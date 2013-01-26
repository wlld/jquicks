<?php
class TDBService_ extends TService_{
    const DBERROR = 201;
    const INVALID_LINK_FORMAT = 202;
    const INVALID_LINK_TYPE=203;
    const STRUCFILE_NOT_FOUND = 204;
    const INVALID_LINK_MODE = 205;
    const DB_NOT_FOUND = 206;
    const STRUCFILE_ERROR = 207;
    
    private $_xml;
    private $db;
    
    protected function _getSelfStructure(){
        if (!$this->_xml){
         $xmlfile = TComponent::getPalettePath($this->class).'/service.xml';
         if (!file_exists($xmlfile)) self::error(self::STRUCFILE_NOT_FOUND,$this->class);
         $this->_xml = simplexml_load_file($xmlfile);
         if($this->_xml===false) self::error(self::STRUCFILE_ERROR);
        } 
        return $this->_xml;
    }
    protected function _getDbTables(){
        $r = $this->db->query('SHOW TABLES');
        if(!$r) $this->_dbError();
        return $r->fetchAll(PDO::FETCH_COLUMN,0);
    }
    protected function _rename($name) {
        $oldname = strtolower($this->_getName());
        $newname = strtolower($name);
        if($this->project->isComponentExists('TDataBase')){
            $this->db = $this->project->getByName('TDataBase')->db;
            $r = $this->db->query('SHOW TABLES');
            if(!$r) $this->_dbError();
            $tbls = $r->fetchAll(PDO::FETCH_COLUMN,0);
            $tt = array();
            foreach($this->_getTables() as $table){
                $told = $oldname.'_'.$table;
                $tnew = $newname.'_'.$table;
                if(in_array($tnew, $tbls)){
                    $cmp = &$this->project->db['components'][$this->id];
                    $this->_catchTable($table,$tnew,$cmp);
                    continue;
                } 
                if(in_array($told, $tbls)) $tt[] = $told.' TO '.$tnew;
            }
            if($tt){
                $sql = 'RENAME TABLE '.join(',', $tt);
                if ($this->db->exec($sql)===false) $this->_dbError();
            }
        }
        parent::_rename($name);
    }
    public function setForignKeys($model,$field,$service,$parent,$op){
        if(!$this->project->isComponentExists('TDataBase')) return;
        $this->db = $this->project->getByName('TDataBase')->db;
        $tables = $this->_getDbTables();
        $srvname = $this->_getName();
        $ptable = strtolower($service.'_'.$parent);
        $ctable = strtolower($srvname.'_'.$model);
        if(!in_array($ctable, $tables)) return;
        $keys = $this->_getForignKeys($ctable);
        $n = self::_isKeyExists($field, $keys);
        if($n!==false){ //есть ссылка
            if(self::_isThatLink($keys[$n],$ptable,$op)) return;
            $this->_dropTableKey($ctable,$keys[$n][1]);
        }
        if($op!=='NONE'){
            if(!in_array($ptable, $tables)){
                $pcmp = $this->project->getByName($service);
                $pcmp->createTable($parent);
            }
            $this->_addTableKey($ctable,$field,$ptable,$op);
        }
    }
    private static function _isKeyExists($field,$keys){
        if (!$keys) return false;
        for($i=0;$i<count($keys);$i++) if ($keys[$i][2]===$field) return $i;
        return false;
    }
    private static function _isThatLink($key,$table,$mode){
        if($key[3]!=$table) return false; 
        if(isset($key[4])) return $key[4] === $mode; 
        else return $mode==='RESTRICT'; 
    }
    private function _dropTableKey($table,$fid){
        $sql = "ALTER TABLE $table DROP FOREIGN KEY $fid";
        if($this->db->exec($sql)===false) $this->_dbError();
    }
    private function _addTableKey($table,$field,$to_table,$mode){
        $sql = "ALTER TABLE $table ADD CONSTRAINT FOREIGN KEY ($field) REFERENCES $to_table(idx) ON DELETE $mode";
        if($this->db->exec($sql)===false) $this->_dbError();
    }
    private function _catchTable($table,$db_table_name,$cmp){
        $this->_restoreForignKeys($table,$db_table_name,$cmp);
    }
    private function _restoreForignKeys($table,$db_table_name,$cmp){
        $links = isset($cmp['links'][0][$table])? $cmp['links'][0][$table]:array();
        //Проверяем существующие ключи
        $e_links = $this->_getForignKeys($db_table_name);
        $c = $this->project->db['components'];
        foreach($e_links as $link){
            if(!isset($links[$link[2]])) $this->_dropTableKey($db_table_name,$link[1]);
            else{
                //Проверяем, совпадают ли параметры существующего ключа с заданными в ссылке
                $l = $links[$link[2]];
                if(!isset($c[$l[0]])) {$this->_dropTableKey($db_table_name,$link[1]); continue;}
                $ptable = strtolower($c[$l[0]]['n'].'_'.$l[2]);
                if(self::_isThatLink($link,$ptable,$l[3])) {
                    unset($links[$link[2]]);
                    continue;
                }
                else $this->_dropTableKey($db_table_name,$link[1]);
            }
        }    
        //Создаём недостающие ссылки
        foreach($links as $field=>$l){
            if(isset($c[$l[0]])){
                $ptable = strtolower($c[$l[0]]['n'].'_'.$l[2]);
                $this->_addTableKey($db_table_name,$field,$ptable,$l[3]);
            }
        }
    }
    /**
     * Возвращает перечень существующих внешних ключей в формате:
     * array(*array(<key_definition>,<constraint_name>,<field_name>,<linked_table>[,<CASCADE|SET NULL>]))
     * @param type $table
     * @return array массив ключей
     */
    private function _getForignKeys($table){
        $r = $this->db->query("SHOW CREATE TABLE $table");
        $struc = $r->fetchAll(PDO::FETCH_COLUMN,1);
        $m = array();
        $r = preg_match_all('/CONSTRAINT\s+`?(\w+)`?\s+FOREIGN\s+KEY\s*\(\s*`?(\w+)`?\s*\)?\s*'.
                            'REFERENCES\s+`?(\w+)`?\s*\(\s*`?idx`?\s*\)\s*'.
                            '(?:ON\s+DELETE\s+(\w+))?/', $struc[0],$m,PREG_SET_ORDER);
        return $m;
    }
    protected function _getTables(){
        $xmlfile = TComponent::getPalettePath($this->class).'/service.xml';
        $t=array();
        if (!file_exists($xmlfile)||(($xml = simplexml_load_file($xmlfile))===false)) return $t;
        foreach($xml->table as $tag) $t[]=(string)$tag['name'];
        return $t;
    }
    protected  function _dbError(){
        $e = $this->db->errorInfo();
        self::error(self::DBERROR,$e[2]);
    }
    protected  static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::DBERROR: {$msg = 'Database error: '.$args[1] ;break;}
            case self::INVALID_LINK_FORMAT:{$msg = 'Invalid format of link property value "'.$args[1].'"'; break;}
            case self::INVALID_LINK_TYPE: {$msg = 'Invalid type definition of link "'.$args[1] ;break;}
            case self::STRUCFILE_NOT_FOUND: {$msg = 'File service.xml in "'.$args[1].'"does not exist or it have bad xml format'; break;}
            case self::INVALID_LINK_MODE: {$msg = 'Invalid link mode: "'.$args[1].'"'; break;}
            case self::DB_NOT_FOUND: {$msg = 'You must have a TDataBase component to edit links'; break;}
            case self::STRUCFILE_ERROR: {$msg = 'File service.xml of "'.$args[1].'" has invalid structure.'; break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
