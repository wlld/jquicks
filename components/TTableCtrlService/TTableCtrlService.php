<?php
class TTableCtrlService extends TService{
    const UNKNOWN_DATABASE = 200;
    const DBERROR = 202;

    private $db = null;

    protected function _getDatabase(){
        if(!isset(jq::$cmp[$this->database])||get_class(jq::$cmp[$this->database])!=='TDataBase')
            self::error(self::UNKNOWN_DATABASE);
        $this->db = jq::$cmp[$this->database]->db;
    }
    function __call($name,$args){
        if (!preg_match('/^_(fetch|update)_([a-zA-Z0-9_]+)_model$/',$name,$m))
            self::error(self::UNDEFINED_METHOD,$name);
        $this->_args = $args[0];
        $this->_args['model'] = $m[2];
        return $this->$m[1]();
    }
    protected function fetch(){
        $this->_getDatabase();
        $params = &$this->_args['params'];
        $this->_checkValues($params,array(
            'idx:integer'=>-1
        ),self::PARAMETER_REQUIRED,self::INVALID_PARAMETER_TYPE);
        $sth = null;
        $fields = $this->_args['fields'];
        if (!$fields) $f = '*';
        else {
            $fields[] = 'idx';
            $f = join(',',array_unique($fields));
        }
        $sql = ' FROM '.$this->_args['model'];
        if (($idx = $this->_args['params']['idx'])>=0) $sql .= ' WHERE idx='.(int)$idx;
        $limit = ($l = $this->_args['limit'])?(' LIMIT '.$this->_args['first'].','.$l):'';
        $sth = $this->db->query('SELECT '.$f.$sql.$limit);
        if (!$sth) {$e = $this->db->errorInfo(); self::error(self::DBERROR,$e[2]); };
        $model = array();
        $model['rows'] = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sth = $this->db->query('SELECT count(*)'.$sql);
        if (!$sth) {$e = $this->db->errorInfo(); self::error(self::DBERROR,$e[2]); };
        $model['count'] = (integer)$sth->fetchColumn();
        return $model;
    }
    protected function update (){
        $this->_getDatabase();
        $val = $this->_args['values'];
        $pairs = array();
        foreach($val as $field=>$value) {$pairs[]=$field.'='.$this->quote_smart($value);}
        $sql = 'UPDATE '.$this->_args['model'].' SET '.join(', ',$pairs).' WHERE idx='.$this->_args['index'];
        $r = $this->db->exec($sql);
        if ($r === false) {$e = $this->db->errorInfo(); self::error(self::DBERROR,$e[2]); };
    }
    protected function quote_smart($value){
        if (get_magic_quotes_gpc()) $value = stripslashes($value);
        return is_string($value)? "'".addslashes($value)."'":$value;
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::UNKNOWN_DATABASE: {$msg = 'Database component required';break;}
            case self::DBERROR: {$msg = 'Database error: '.$args[1] ;break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>
