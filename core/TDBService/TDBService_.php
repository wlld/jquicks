<?php
class TDBService_ extends TService_{
    const DBERROR = 201;
    const INVALID_LINK_FORMAT = 202;
    const INVALID_LINK_TYPE=203;
    const STRUCFILE_NOT_FOUND = 204;
    const INVALID_LINK_MODE = 205;
    const DB_NOT_FOUND = 206;
    const STRUCFILE_ERROR = 207;
    const RATING_FIELD_EXISTS = 208;
    const FIELD_NOT_EXISTS = 209;
    const TABLE_EXISTS = 210;

    private $_xml;
    private $db;
    public function insertIntoProject($parent, $section, $order, $page, $name = null) {
        if(!$this->project->isComponentExists('TDataBase')) self::error(self::DB_NOT_FOUND);
        parent::insertIntoProject($parent, $section, $order, $page, $name);
        $this->db = $this->project->getByName('TDataBase')->db;
        $this->name = $this->_getName();
        $this->createTables();
    }
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
    protected function _getTables(){
        $xml = $this->_getSelfStructure();
        foreach($xml->table as $tag) $t[]=(string)$tag['name'];
        return $t;
    }
    protected function createTables(){
        $tables = $this->_getDbTables();
        foreach($this->_getTables() as $table){
            $tname = $this->table($table);
            if(!in_array($tname, $tables)) {
                $sql = $this->_getTableCreate($table,$tname);
                if ($this->db->exec($sql)===false) $this->_dbError();
            }
            else  $this->_catchTable($table,$tname);
        }
    }
    protected function table($n){return strtolower($this->name).'_'.$n; }
    protected function _getTableCreate($name,$tname){
        $xml = $this->_getSelfStructure();
        if(!($tables = $xml->xpath("table[@name='$name']"))) self::error(self::TABLEDEF_NOT_FOUND,$name);
        $table = $tables[0];
        $tdef = array();
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
        $sql = 'CREATE TABLE IF NOT EXISTS '.$tname." (\n".join(",\n",$tdef).')';
        $ttype = isset($table['type'])?(string)$table['type']:'MyISAM';
        $sql .= ' ENGINE='.$ttype;
        return $sql;
    } 
    protected function _rename($name) {
        $oldname = strtolower($this->_getName());
        $newname = strtolower($name);
        $this->db = $this->project->getByName('TDataBase')->db;
        $tbls = $this->_getDbTables();
        $tt = array();
        foreach($this->_getTables() as $table){
            $told = $oldname.'_'.$table;
            $tnew = $newname.'_'.$table;
            if(in_array($tnew, $tbls)) self::error(self::TABLE_EXISTS,$tnew);
            $tt[] = $told.' TO '.$tnew;
        }
        if($tt){
            $sql = 'RENAME TABLE '.join(',', $tt);
            if ($this->db->exec($sql)===false) $this->_dbError();
        }
        parent::_rename($name);
    }
    public function setForignKey($model,$field,$service,$parent,$op){
        $this->db = $this->project->getByName('TDataBase')->db;
        $srvname = $this->_getName();
        $ptable = strtolower($service.'_'.$parent);
        $ctable = strtolower($srvname.'_'.$model);
        $keys = $this->_getForignKeys($ctable);
        $n = self::_isKeyExists($field, $keys);
        if($n!==false){ //есть ссылка
            if(self::_isThatLink($keys[$n],$ptable,$op)) return;
            $this->_dropTableKey($ctable,$keys[$n][1]);
        }
        if($op!=='NONE') $this->_addTableKey($ctable,$field,$ptable,$op);
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
    private function _catchTable($table,$db_table_name){
        $cmp = &$this->project->db['components'][$this->id];
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
    public function getRatingType($table,$field,$op){
        if($op==='COUNT') return array('INT UNSIGNED NOT NULL',false);
        $xml = $this->_getSelfStructure();
        $r = $xml->xpath("table[@name='$table']/tfield[@name='$field']");
        if($r){
            $link = (($op==='SUM') || ($field!='idx'))? false:$this->class.'.'.$table;
            return array((string)$r[0]['type'],$link,$this->id);
        } 
        else { // serching for rating fields
            $c = $this->project->db['components'][$this->id];
            if (!isset($c['r'][$table][$field])) self::error(self::FIELD_NOT_EXISTS,$field,$table);
            return $c['r'][$table][$field];
        }
    }
    public function addRatingField($model,$field,$type){
        $c = &$this->project->db['components'][$this->id];
        if(isset($c['r'][$model][$field])) self::error(self::RATING_FIELD_EXISTS,$field,$model);
        $c['r'][$model][$field] = $type;
        $this->db = $this->project->getByName('TDataBase')->db;
        $table = strtolower($c['n'].'_'.$model);
        $dbtables = $this->_getDbTables();
        if(in_array($table, $dbtables)){
            $sql = "ALTER TABLE $table ADD COLUMN `$field` {$type[0]}";
            if($this->db->exec($sql)===false) $this->_dbError();
        }
    }
    public function deleteRatingField($model,$field){
        $c = &$this->project->db['components'][$this->id];
        if(isset($c['r'][$model][$field])){
            unset($c['r'][$model][$field]);
            $this->db = $this->project->getByName('TDataBase')->db;
            $table = strtolower($c['n'].'_'.$model);
            $sql = "ALTER TABLE $table DROP COLUMN `$field`";
            if($this->db->exec($sql)===false) $this->_dbError();
        }
    }
    public function changeRatingField($model,$old_field_name,$new_field_name,$new_type){
        $c = &$this->project->db['components'][$this->id];
        if(!isset($c['r'][$model][$old_field_name])) self::error(self::FIELD_NOT_EXISTS,$old_field_name,$model);
        $this->db = $this->project->getByName('TDataBase')->db;
        $table = strtolower($c['n'].'_'.$model);
        $dbtables = $this->_getDbTables();
        if(in_array($table, $dbtables)){
            $sql = "ALTER TABLE $table CHANGE COLUMN `$old_field_name` `$new_field_name` {$new_type[0]}";
            if($this->db->exec($sql)===false) $this->_dbError();
        }
        $type = $c['r'][$model][$old_field_name];
        unset($c['r'][$model][$old_field_name]);
        $c['r'][$model][$new_field_name]=$type;
    }
    public function updateAllRatings($ptable,$ctable,$lfield,$op,$rfield,$tfield){
        $sql = "UPDATE $ptable AS p SET `$tfield`=(SELECT $op(c.`$rfield`) FROM $ctable AS c WHERE c.`$lfield` = p.idx GROUP BY c.`$lfield`)";
        if($this->db->exec($sql)===false) $this->_dbError();
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
            case self::DB_NOT_FOUND: {$msg = 'You must insert and configure TDataBase component first'; break;}
            case self::STRUCFILE_ERROR: {$msg = 'File service.xml of "'.$args[1].'" has invalid structure.'; break;}
            case self::RATING_FIELD_EXISTS: {$msg = 'Rating field "'.$args[1].'" in "'.$args[2].'" already exists'; break;}
            case self::FIELD_NOT_EXISTS: {$msg = 'Field "'.$args[1].'" does not exist in "'.$args[2].'" model'; break;}
            case self::TABLE_EXISTS: {$msg = 'Table "'.$args[1].'" already exists in the database'; break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
