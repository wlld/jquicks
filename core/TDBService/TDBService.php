<?php
abstract class TDBService extends TService{
    // Error codes
    const DBERROR = 201;
    const TABLEDEF_NOT_FOUND = 202;
    const UNDEFINED_LINK = 203;
    const BAD_LINK_FORMAT = 204;
    const LINKED_SERVICE_NOT_FOUND = 205;
    
    const SQL_DATE_FORMAT = 'Y-m-d h:i:s';
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
    private static function _castValue(&$val,$key){
        if(isset(self::$_types[$key])) if(self::$_types[$key]===1) $val = (int)$val;
    }
    protected function _castResultTypes(&$rows,$model){
        self::$_types = $this->_getTypeDefinition($model,CHECK_FETCH_FIELDS);
        array_walk_recursive($rows, array(__CLASS__,'_castValue'));
    }
    protected function _exec($sql,$params=array()){
        $cmd = $this->db->prepare($sql);
        if(!$cmd->execute($params)) {
            $code = $cmd->errorCode();
            if($code === '42S02'){ // Tables not exists
                $this->createAllTables();
                if(!$cmd->execute($params)) $this->_dbError($cmd);
            }
            else $this->_dbError($cmd);
        };
        return $cmd;
    }
    public function createTable($name){
        $sql = $this->_getTableCreate($name, $tname, $linked_tables);
        $tables = &$this->dbTables();
        foreach($linked_tables as $link){
            $ptable = strtolower($link[0].'_'.$link[1]);
            if(!in_array($ptable, $tables)){
                $srv = $this->project->getByName($link[0]);
                $srv->createTable($link[1]);
                $tables[] = $ptable;
            }
        }
        if ($this->db->exec($sql)===false) $this->_dbError();
        $tables[] = $tname;
    }
    public function createAllTables(){
        $tables = &$this->dbTables();
        foreach($this->_getTables() as $table){
            if(!in_array($this->table($table), $tables)) $this->createTable($table);
        }
    }
    protected function table($n){return strtolower($this->name).'_'.$n; }
    protected function _getTables(){
        $xmlfile = TComponent::getPalettePath(get_class($this)).'/service.xml';
        $t=array();
        if (!file_exists($xmlfile)| (($this->_xml = simplexml_load_file($xmlfile))===false)) return $t;
        foreach($this->_xml->table as $tag) $t[]=(string)$tag['name'];
        return $t;
    }
    protected function &dbTables(){
        if(!isset(self::$_db_tables)){
            $r = $this->db->query('SHOW TABLES');
            if(!$r) $this->_dbError();
            self::$_db_tables = $r->fetchAll(PDO::FETCH_COLUMN,0);
        }
        return self::$_db_tables;
    }
    protected function _getSelfStructure(){
        if (!isset($this->_xml)){
         $class = get_class($this);   
         $xmlfile = TComponent::getPalettePath($class).'/service.xml';
         if (!file_exists($xmlfile)) self::error(self::STRUCFILE_NOT_FOUND,$class);
         $this->_xml = simplexml_load_file($xmlfile);
         if($this->_xml===false) self::error(self::STRUCFILE_ERROR);
        } 
        return $this->_xml;
    }
    protected function _getTableCreate($name,&$tname, &$linked_tables){
        $xml = $this->_getSelfStructure();
        if(!($tables = $xml->xpath("table[@name='$name']"))) self::error(self::TABLEDEF_NOT_FOUND,$name);
        $table = $tables[0];
        $tdef = $linked_tables = array();
        foreach($table->tfield as $f){
            $fname = (string)$f['name'];
            $def = (string)$f? 'DEFAULT '.(string)$f:'';
            $tdef[] = "`$fname` {$f['type']} $def".(isset($f['auto'])?' AUTO_INCREMENT':'');
        }
        $tdef[] = 'PRIMARY KEY (idx)';
        foreach($table->index as $index) {
            $unique = isset($index['unique'])&&(boolean)$index['unique'];
            $tdef[] = ($unique?'UNIQUE INDEX (':'INDEX (').(string)$index.')';
        }    
        //Добавляем внешние ключи
        if(isset($this->_linksdef[0][$name])){
            foreach($this->_linksdef[0][$name] as $field=>$link){
                if($link[2]==='NONE') continue;
                $ptable = strtolower($link[0].'_'.$link[1]);
                $linked_tables[] = array($link[0],$link[1]);
                $tdef[] = "FOREIGN KEY (`$field`) REFERENCES $ptable(idx) ON DELETE {$link[2]}";
            }
        }
        $tname = $this->table($name);
        $sql = 'CREATE TABLE IF NOT EXISTS '.$tname." (\n".join(",\n",$tdef).')';
        $ttype = isset($table['type'])?(string)$table['type']:'MyISAM';
        $sql .= ' ENGINE='.$ttype;
        return $sql;
    } 
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
                $cmps = $this->project->db['names'];
                if(!isset($cmps[$l[0]])) self::error(self::LINKED_SERVICE_NOT_FOUND,$link);
                $table = strtolower($l[0].'_'.$l[1]); 
                self::$_linked_tables[$l[0]][] = $l[1];
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
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>