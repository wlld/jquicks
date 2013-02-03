<?php
define('FETCH', 0); 
define('INSERT', 1); 
define('UPDATE', 2); 
define('REMOVE', 3); 
abstract class TDBService extends TService{
    // Error codes
    const DBERROR = 201;
    const TABLEDEF_NOT_FOUND = 202;
    const UNDEFINED_LINK = 203;
    const BAD_LINK_FORMAT = 204;
    const LINKED_SERVICE_NOT_FOUND = 205;
    const LINK_FIELD_NOT_SET = 206;
    
    const SQL_DATE_FORMAT = 'Y-m-d h:i:s';
    static $cmd_array = array('fetch','insert','update','remove');
    static $expressions = array(
        INSERT=>array(
            'MIN'=>'`%1$s`=IF(`%1$s`<%2$s,`%1$s`,%2$s)',
            'MAX'=>'`%1$s`=IF(`%1$s`>%2$s,`%1$s`,%2$s)',
            'SUM'=>'`%1$s`=`%1$s`+%2$s',
        ),
        REMOVE=>array(
            'MIN'=>'`%1$s`=IF(`%1$s`<%2$s,`%1$s`,(SELECT MIN(t.`%3$s`) FROM %4$s AS t WHERE t.`%5$s`=%6$s GROUP BY t.`%5$s`))',//tfield,rval,rfield,ctable,lfield,lval
            'MAX'=>'`%1$s`=IF(`%1$s`>%2$s,`%1$s`,(SELECT MAX(t.`%3$s`) FROM %4$s AS t WHERE t.`%5$s`=%6$s GROUP BY t.`%5$s`))',
            'SUM'=>'`%1$s`=`%1$s`-%2$s',
            'COUNT'=>'`%1$s`=`%1$s`-1',
        ),
        UPDATE=>array(
            'MIN'=>'`%1$s`=(SELECT MIN(t.`%3$s`) FROM %4$s AS t WHERE t.`%5$s`=p.idx GROUP BY t.`%5$s`)',//tfield,rval,rfield,ctable,lfield,lval
            'MAX'=>'`%1$s`=(SELECT MAX(t.`%3$s`) FROM %4$s AS t WHERE t.`%5$s`=p.idx GROUP BY t.`%5$s`)',
            'SUM'=>'`%1$s`=(SELECT SUM(t.`%3$s`) FROM %4$s AS t WHERE t.`%5$s`=p.idx GROUP BY t.`%5$s`)',
        )
    );
    private static $_types;
    private static $_links;
    private static $_db_tables;
    static protected $_linked_tables; //Список присоединённых таблиц для текущей операции SELECT
    private $_linksdef; 

    public function __construct($struc=null){
        parent::__construct($struc);
        if($struc) $this->_linksdef = isset($struc['links'])?$struc['links']:array(array(),array());
    }
    function __get($name) {
        if($name==='db'){
            $c = $this->project->getByName('TDataBase');
            $this->db = $c->db;
            return $this->db;
        }
        else return parent::__get($name);
    }
    public function queryModel($model,$cmd,$arg){
        $icmd = array_search($cmd, self::$cmd_array); 
        if($icmd==FETCH || !isset($this->_linksdef[1][$model])) return parent::queryModel($model, $cmd, $arg);
        $this->db->beginTransaction(); 
        try{
            if($icmd==REMOVE) $child_row = array('idx'=>$arg['index']);
            else{
                $result = parent::queryModel($model, $cmd, $arg);
                $child_row = $arg['values'];
                if($icmd==UPDATE) $child_row['idx'] = $arg['index'];
            }
            $ctable = strtolower($this->name.'_'.$model);
            $rsql='';
            foreach($this->_linksdef[1][$model] as $r){
                list($service,$type,$parent,$op,$lfield,$rfield,$tfield) = $r;
                if(($icmd==REMOVE)||($icmd==UPDATE)){
                    if($icmd==REMOVE){
                        $sql="SELECT `$lfield`,`$rfield` FROM $ctable WHERE idx={$child_row['idx']}";
                    }
                    else{
                        if(!isset($child_row[$rfield]) || $op=='COUNT') continue;
                        $sql="SELECT `$lfield` FROM $ctable WHERE idx={$child_row['idx']}";
                    }
                    if(($r=$this->db->query($sql))===false) $this->_dbError();
                    $child_row += $r->fetch(PDO::FETCH_ASSOC);
                }
                $expr = $this->_getRatingExpression($icmd,$op,$lfield,$rfield,$tfield,$child_row,$ctable);
                $parent_name = $this->project->getNameById($service);
                $ptable = strtolower($parent_name.'_'.$parent);
                $rsql .= "UPDATE $ptable AS p SET $expr WHERE idx={$child_row[$lfield]};\n";
            }
            if($icmd==REMOVE) $result = parent::queryModel($model, $cmd, $arg);
            if($rsql) if ($this->db->exec($rsql)===false) $this->_dbError();
            $this->db->commit();
            return $result;
        }
        catch(Exception $e){
            $this->db->rollBack();
            unset($this->_updated_models[$model]);
            throw $e;
        }
    }
    private function _getRatingExpression($icmd,$op,$lfield,$rfield,$tfield,&$child_row,$ctable){
        if($icmd==INSERT){
            if($op==='COUNT') return "`$tfield`=`$tfield`+1";
            else{
                if(!isset($child_row[$rfield])){
                    $idx = $this->db->lastInsertId();
                    if($rfield!='idx'){
                        $sql="SELECT `$rfield` FROM $ctable WHERE idx=$idx";
                        if(($r=$this->db->query($sql))===false) $this->_dbError();
                        $child_row += $r->fetch(PDO::FETCH_ASSOC);
                    }
                    $child_row['idx'] = $idx;
                }
                return sprintf(self::$expressions[$icmd][$op],$tfield,$child_row[$rfield]);
            }
        }
        elseif($icmd==REMOVE){
            return sprintf(self::$expressions[$icmd][$op],
                $tfield,$child_row[$rfield],$rfield,$ctable,$lfield,$child_row[$lfield]
            );
        }
        else{//UPDATE
            return sprintf(self::$expressions[$icmd][$op],$tfield,'',$rfield,$ctable,$lfield);
        }
    }
    private static function _castValue(&$val,$key){
        if(isset(self::$_types[$key])) if(self::$_types[$key]===1) $val = (int)$val;
    }
    protected function _castResultTypes(&$rows,$model){
        self::$_types = $this->_getTypeDefinition($model,CHECK_FETCH_FIELDS);
        array_walk_recursive($rows, array(__CLASS__,'_castValue'));
    }
    protected function _exec($sql,$params=array()){
        if($params){
            $cmd = $this->db->prepare($sql);
            if(!$cmd->execute($params)) $this->_dbError($cmd);
        }
        else{
            $cmd = $this->db->query($sql);
            if(!$cmd) $this->_dbError($cmd);
        }
        return $cmd;
    }
    protected function table($n){return strtolower($this->name).'_'.$n; }
    protected function _fetchTableModel($args,$model,$awhere=array(),$params=array()){
        self::$_linked_tables = array();
        $fields = $this->_getSQLFields($args['fields']);
        $limit = $this->_getSQLLimit($args['first'],$args['limit']);
        $tbl = $this->table($model);
        $where = $awhere?  'WHERE ('.join(') AND (', $awhere).')':'';
        $links = $this->_getSQLLinks($model);
        $cmd = $this->_exec("SELECT SQL_CALC_FOUND_ROWS $fields FROM $tbl AS t $links $where $limit",$params);
        $crows = $this->_exec('SELECT FOUND_ROWS()');
        $count = $crows->fetchColumn();
        $rows = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return array('rows'=>$rows, 'count'=>$count);
    }
    protected function _insertTableModel($values,$model){
        $tbl = $this->table($model);
        if($values){
            $fnames = array_keys($values);
            $fparams = array_values($values);
        } else {$fnames = $fparams = array();}
        $f = '`'.join('`, `',$fnames).'`';
        $val = rtrim(str_repeat('?,', count($fparams)),',');
        $cmd = "INSERT INTO $tbl ($f) VALUES ($val)";
        $this->_exec($cmd,$fparams);
    }
    protected function _removeTableModel($idx,$model){
        $tbl = $this->table($model);
        $this->_exec("DELETE FROM $tbl WHERE idx=?", array($idx));
    }
    protected function _updateTableModel($values,$idx,$model){
        $aset = $params = array();  
        foreach($values as $field=>$val){
            $params[] = $val;
            $aset[] = '`'.$field.'` = ?';
        }
        $params[] = $idx;
        $set = join(', ',$aset);
        $sql = "UPDATE {$this->table($model)} SET $set WHERE idx=?";
        $this->_exec($sql, $params);
    }
    protected function _getSQLWhere($args,$fields,&$where,&$params){
        $where = $params = array();
        $p = $args['params'];
        if($p) foreach($fields as $f) if(isset($p[$f])) {$where[] = "$f = :$f"; $params[$f]=$p[$f];};
    }
    protected function _getSQLFields($fields){
        self::$_links = array();
        if (!$fields) return 't.*';
        if(!in_array('idx',$fields)) $fields[] = 'idx';
        foreach($fields as &$f){
            $a = explode('.',$f);
            if(count($a)==2){
                self::$_links[] = $a[0];
                $f = $a[0].'.`'.$a[1].'` AS `'.$f.'`';
            }
            else $f = 't.`'.$f.'`';
        }
        self:$_links = array_unique(self::$_links);
        return join(', ',$fields);
    }
    protected function _getSQLLinks($model){
        $r = '';
        if(self::$_links){
            foreach(self::$_links as $link){
                if(!isset($this->_linksdef[0][$model][$link])) self::error(self::UNDEFINED_LINK,$link);
                $l = $this->_linksdef[0][$model][$link];
                $cmps = $this->project->db['components'];
                if(!isset($cmps[$l[0]])) self::error(self::LINKED_SERVICE_NOT_FOUND,$link);
                $sname = $cmps[$l[0]]['n'];
                $table = strtolower($sname.'_'.$l[2]); 
                self::$_linked_tables[$sname][] = $l[2];
                $r .= " LEFT JOIN $table AS $link ON `$link`=$link.idx";
            }
        }
        return $r;
    }
    protected function _getSQLLimit($first,$limit){
       return $limit?(' LIMIT '.$first.','.$limit):'';
    }
    protected function _dbError($cmd=null){
        $e = $cmd? $cmd->errorInfo():$this->db->errorInfo();
        self::error(self::DBERROR,$e[2]);
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::DBERROR: {$msg = 'Database error: '.$args[1] ;break;}
            case self::TABLEDEF_NOT_FOUND: {$msg = 'Create definition for table "'.$args[1].'" not found in service.xml' ;break;}
            case self::UNDEFINED_LINK: {$msg = 'Link "'.$args[1].'" is not defined' ;break;}
            case self::BAD_LINK_FORMAT: {$msg = 'Link "'.$args[1].'" has bad format' ;break;}
            case self::LINKED_SERVICE_NOT_FOUND: {$msg = 'Linked service not found for link "'.$args[1].'"' ;break;}
            case self::LINK_FIELD_NOT_SET: {$msg = 'Can not set rating becase childs link field "'.$args[1].'" has no value' ;break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>