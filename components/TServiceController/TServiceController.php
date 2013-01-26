<?php
class TServiceController extends TService{
/*SRVDEF*/
private static $_definition_struc = array (
  'models' =>array (
    'models' =>array (
      'p' => 'a:2:{s:7:"service";a:2:{i:0;i:3;i:1;b:1;}s:5:"model";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:0:{}',
      'u' => 'a:0:{}',
      'f' => 'a:4:{s:3:"idx";i:3;s:4:"name";i:3;s:4:"desc";i:3;s:6:"delete";i:1;}',
      'owner' => false,
    ),
    'fields' =>array (
      'p' => 'a:3:{s:7:"service";a:2:{i:0;i:3;i:1;b:1;}s:5:"model";a:2:{i:0;i:3;i:1;b:0;}s:4:"link";a:2:{i:0;i:4;i:1;b:0;}}',
      'i' => 'a:0:{}',
      'u' => 'a:0:{}',
      'f' => 'a:9:{s:3:"idx";i:1;s:4:"name";i:3;s:4:"desc";i:3;s:4:"type";i:3;s:5:"fetch";i:1;s:6:"insert";i:1;s:6:"update";i:1;s:5:"model";i:3;s:4:"link";i:5;}',
      'owner' => false,
    ),
    'fetchparams' =>array (
      'p' => 'a:2:{s:7:"service";a:2:{i:0;i:3;i:1;b:1;}s:5:"model";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:0:{}',
      'u' => 'a:0:{}',
      'f' => 'a:7:{s:3:"idx";i:1;s:4:"name";i:3;s:4:"desc";i:3;s:4:"type";i:3;s:8:"required";i:1;s:5:"model";i:3;s:5:"value";i:0;}',
      'owner' => false,
    ),
    'cmdparams' =>array (
      'p' => 'a:2:{s:7:"service";a:2:{i:0;i:3;i:1;b:1;}s:7:"command";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:0:{}',
      'u' => 'a:0:{}',
      'f' => 'a:7:{s:3:"idx";i:1;s:4:"name";i:3;s:4:"desc";i:3;s:8:"required";i:1;s:7:"command";i:3;s:5:"value";i:0;s:6:"pcount";i:1;}',
      'owner' => false,
    ),
    'commands' =>array (
      'p' => 'a:2:{s:7:"service";a:2:{i:0;i:3;i:1;b:1;}s:7:"command";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:0:{}',
      'u' => 'a:0:{}',
      'f' => 'a:3:{s:3:"idx";i:1;s:4:"name";i:3;s:4:"desc";i:3;}',
      'owner' => false,
    ),
  ),
  'commands' =>array (
    'compileServiceXML' => 'a:1:{s:7:"service";a:2:{i:0;i:3;i:1;b:1;}}',
    'testRefIntegrity' => 'a:6:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:8:"cservice";a:2:{i:0;i:3;i:1;b:1;}s:5:"child";a:2:{i:0;i:3;i:1;b:1;}s:6:"lfield";a:2:{i:0;i:3;i:1;b:1;}s:7:"service";a:2:{i:0;i:3;i:1;b:1;}s:6:"parent";a:2:{i:0;i:3;i:1;b:1;}}',
    'makeRefIntegrity' => 'a:7:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:8:"cservice";a:2:{i:0;i:3;i:1;b:1;}s:5:"child";a:2:{i:0;i:3;i:1;b:1;}s:6:"lfield";a:2:{i:0;i:3;i:1;b:1;}s:7:"service";a:2:{i:0;i:3;i:1;b:1;}s:6:"parent";a:2:{i:0;i:3;i:1;b:1;}s:4:"mode";a:2:{i:0;i:3;i:1;b:1;}}',
  ),
  'links' =>array (
  ),
);
protected function &getDefinitionStruc(){return self::$_definition_struc;}
/*SRVDEF*/
    const SERVICE_NOT_EXISTS = 200;
    const PHP_NOT_EXISTS = 201;
    const BAD_PHP_CLASS = 202;
    const INVALID_TYPE_NAME = 203;
    const DB_NOT_FOUND = 204;
    const MODE_NOT_SUPPORT = 205;
    const DBERROR = 206;

    private static $_xml=array();
    private static $db;

    protected static function _getNewName($dbnames){ return __CLASS__; }
    private static function _getStructure($service){
        if(!isset(self::$_xml[$service])){
            $xmlfile = TComponent::getPalettePath($service).'/service.xml';
            if (file_exists($xmlfile)) $xml = simplexml_load_file ($xmlfile);
            else self::error(self::STRUCFILE_NOT_FOUND,$service);
            if($xml===false) self::error(self::STRUCFILE_ERROR, $service);
            self::$_xml[$service] = $xml;
        }
        return self::$_xml[$service];
    }
    protected function _fetch_models_model($args){
        $p = $args['params']; $f = $args['fields'];
        $xml = self::_getStructure($p['service']);
        $rows = array();
        foreach($xml->xpath(isset($p['model'])?"model[@name='{$p['model']}']":'model') as $tag){
            $idx = (string)$tag['name'];
            $row = array('idx'=>$idx);
            if(!$f || in_array('name',$f)) $row['name'] = $row['idx'];
            if(!$f || in_array('desc',$f)) $row['desc'] = isset($tag['desc'])? (string)$tag['desc']:'';
            if(!$f || in_array('delete',$f)) $row['delete'] = isset($tag['delete'])? (integer)$tag['delete']:0;
            if(!$f || in_array('pcount',$f)) $row['pcount'] = count($tag->param);
            $rows[] = $row;
        }
        return array('rows'=>$rows,'count'=>count($rows));
    }
    protected function _fetch_commands_model($args){
        $p = $args['params']; $f = $args['fields'];
        $xml = self::_getStructure($p['service']);
        $rows = array();
        foreach($xml->xpath(isset($p['command'])?"command[@name='{$p['command']}']":'command') as $tag){
            $idx = (string)$tag['name'];
            $row = array('idx'=>$idx);
            if(!$f || in_array('name',$f)) $row['name'] = $row['idx'];
            if(!$f || in_array('desc',$f)) $row['desc'] = isset($tag['desc'])? (string)$tag['desc']:'';
            if(!$f || in_array('pcount',$f)) $row['pcount'] = count($tag->param);
            $rows[] = $row;
        }
        return array('rows'=>$rows,'count'=>count($rows));
    }
    protected function _fetch_fields_model($args){
        $p = $args['params']; $f = $args['fields'];
        $xml = self::_getStructure($p['service']);
        $rows = array();
        $_xpath = isset($p['model'])?"model[@name='{$p['model']}']":"model";
        $link = isset($p['link'])&& $p['link'];
        foreach($xml->xpath($_xpath) as $modeltag){
            $md = (string)$modeltag['name'];
            foreach($modeltag->field as $tag){
                if($link && !isset($tag['link'])) continue;
                $idx = $md.'.'.(string)$tag['name'];
                $row = array('idx'=>$idx);
                if(!$f || in_array('name',$f)) $row['name'] = (string)$tag['name'];
                if(!$f || in_array('desc',$f)) $row['desc'] = isset($tag['desc'])? (string)$tag['desc']:'';
                if(!$f || in_array('type',$f)) $row['type'] = (string)$tag['type'];
                if(!$f || in_array('fetch',$f)) $row['fetch'] = isset($tag['fetch'])? (integer)$tag['fetch']:0;
                if(!$f || in_array('insert',$f)) $row['insert'] = isset($tag['insert'])? (integer)$tag['insert']:0;
                if(!$f || in_array('update',$f)) $row['update'] = isset($tag['update'])? (integer)$tag['update']:0;
                if(!$f || in_array('link',$f)) {
                    $row['link'] = isset($tag['link'])? explode('.',(string)$tag['link']):false;
                }
                if(!$f || in_array('model',$f)) $row['model'] = $md;
                $rows[] = $row;
            }
        }
        return array('rows'=>$rows,'count'=>count($rows));
    }
    protected function _fetch_fetchparams_model($args){
        $p = $args['params']; $f = $args['fields'];
        $xml = self::_getStructure($p['service']);
        $rows = array();
        $_xpath = isset($p['model'])?"model[@name='{$p['model']}']":"model";
        foreach($xml->xpath($_xpath) as $modeltag){
            $md = (string)$modeltag['name'];
            foreach($modeltag->param as $tag){
                $idx = $md.'.'.(string)$tag['name'];
                $row = array('idx'=>$idx);
                if(!$f || in_array('name',$f)) $row['name'] = (string)$tag['name'];
                if(!$f || in_array('desc',$f)) $row['desc'] = isset($tag['desc'])? (string)$tag['desc']:'';
                if(!$f || in_array('type',$f)) $row['type'] = (string)$tag['type'];
                if(!$f || in_array('required',$f)) $row['required'] = isset($tag['required'])? (integer)$tag['required']:0;
                if(!$f || in_array('value',$f)) $row['value'] = (string)$tag;
                if(!$f || in_array('model',$f)) $row['model'] = $md;
                $rows[] = $row;
            }
        }
        return array('rows'=>$rows,'count'=>count($rows));
    }
    protected function _fetch_cmdparams_model($args){
        $p = $args['params']; $f = $args['fields'];
        $xml = self::_getStructure($p['service']);
        $rows = array();
        $_xpath = isset($p['command'])?"command[@name='{$p['command']}']":"command";
        foreach($xml->xpath($_xpath) as $modeltag){
            $md = (string)$modeltag['name'];
            foreach($modeltag->param as $tag){
                $idx = $md.'.'.(string)$tag['name'];
                $row = array('idx'=>$idx);
                if(!$f || in_array('name',$f)) $row['name'] = (string)$tag['name'];
                if(!$f || in_array('desc',$f)) $row['desc'] = isset($tag['desc'])? (string)$tag['desc']:'';
                if(!$f || in_array('type',$f)) $row['type'] = (string)$tag['type'];
                if(!$f || in_array('required',$f)) $row['required'] = isset($tag['required'])? (integer)$tag['required']:0;
                if(!$f || in_array('command',$f)) $row['command'] = $md;
                if(!$f || in_array('value',$f)) $row['value'] = (string)$tag;
                $rows[] = $row;
            }
        }
        return array('rows'=>$rows,'count'=>count($rows));
    }
    private function _getIntegerType($type){
        $type = strtolower($type);
        $itype = array_search($type, array('any','integer','real','char','boolean','object'));
        if($itype===false) self::error(self::INVALID_TYPE_NAME,$type);
        return $itype;
    }
    protected function compileServiceXML($args){
        //грузим файл структуры
        $path = self::getPalettePath($args['service']);
        $phpfile = $path.'/'.$args['service'].'.php';
        if(!file_exists($path.'/service.xml')) self::error(self::STRUCFILE_NOT_FOUND,$args['service']);
        if(!file_exists($phpfile)) self::error(self::PHP_NOT_EXISTS,$phpfile);
        $xml = simplexml_load_file($path.'/service.xml');
        $r = array();
        //компилируем модели
        foreach($xml->model as $model){
            $p = $i = $u = $f = $links = array(); $owner = false;
            $mname = (string)$model['name'];
            foreach($model->field as $field){
                $name = (string)$field['name'];
                if($name==='owner') $owner=true;
                $itype = $this->_getIntegerType((string)$field['type']);
                if(isset($field['insert']) && (integer)$field['insert']) $i[$name] = array($itype,(integer)$field['insert']>1);
                if(isset($field['update']) && (integer)$field['update']) $u[$name] = array($itype,false);
                if(isset($field['fetch']) && (integer)$field['fetch']) $f[$name] = $itype;
                if(isset($field['link'])) $links[$mname][$name] = (string)$field['link'];
            }
            foreach($model->param as $param){
                $name = (string)$param['name'];
                $itype = $this->_getIntegerType((string)$param['type']);
                $p[$name] = array($itype,(integer)$param['required']>0);
            }
            $r[$mname] = array(
                'p'=>serialize($p),
                'i'=>serialize($i),
                'u'=>serialize($u),
                'f'=>serialize($f),
                'owner'=>$owner
            );
        }
        //компилируем команды
        $c = array();
        foreach($xml->command as $cmd){
            $a = array();
            foreach($cmd->param as $param){
                $name = (string)$param['name'];
                $itype = $this->_getIntegerType((string)$param['type']);
                $a[$name] = array($itype,(integer)$param['required']>0);
            }
            $cmdname = (string)$cmd['name'];
            $c[$cmdname] = serialize($a);
        }
        $result = array('models'=>$r,'commands'=>$c,'links'=>$links);
        //читаем серверный клас службы
        $php = file_get_contents($phpfile);
        //ищем и удаляем из класса существующую структуру
        $tag = preg_quote('/*SRV'.'DEF*/','/'); 
        $php =  preg_replace("/$tag.+?$tag\\s*?\\n/s", '', $php);
        //вставляем новую структуру
        $div = 'class\s+'.$args['service'].'\s+extends\s+\w+\s*\{\s*\n';
        $parts = preg_split("/($div)/", $php,-1,PREG_SPLIT_DELIM_CAPTURE);
        if(count($parts)!=3) self::error(self::BAD_PHP_CLASS,$phpfile);
        $struc = var_export($result,true);
        $struc = preg_replace('/=>\\s*\\n\\s*/','=>',$struc);
        $newphp = "{$parts[0]}{$parts[1]}/*SRV"."DEF*/\nprivate static \$_definition_struc = $struc;\n".
        "protected function &getDefinitionStruc(){return self::\$_definition_struc;}\n/*SRV"."DEF*/\n{$parts[2]}";
        file_put_contents($phpfile, $newphp);
    }
    /**
     * Проверка ссылосной целостности таблиц
     * @return array array('unlinked_rows'=><количество несвязанных записей>)
     * @param type $args
     */
    public function testRefIntegrity($args){
        $project = jq::getProject($args['project']);
        if(!$project->isComponentExists($args['service'])) self::error(self::COMPONENT_NOT_FOUND,$args['service']);
        if(!$project->isComponentExists($args['cservice'])) self::error(self::COMPONENT_NOT_FOUND,$args['cservice']);
        if(!$project->isComponentExists('TDataBase')) self::error(self::DB_NOT_FOUND);
        self::$db = $project->getByName('TDataBase')->db;
        $r = self::$db->query('SHOW TABLES');
        if(!$r) self::_dbError();
        $tbls = $r->fetchAll(PDO::FETCH_COLUMN,0);
        $child_table = strtolower($args['cservice'].'_'.$args['child']);
        $parent_table = strtolower($args['service'].'_'.$args['parent']);
        if(!in_array($child_table, $tbls)) return array('unlinked_rows'=>0);
        if(!in_array($parent_table, $tbls)){
             $tocmp = $project->getByName($args['service']);
             $tocmp->createTable($args['parent']);
        }
        $sql = "SELECT count(*) FROM $child_table AS a ".
               "LEFT OUTER JOIN $parent_table AS b ON (a.`{$args['lfield']}`=b.idx) ".
               "WHERE (b.idx is NULL) AND (a.`{$args['lfield']}` is NOT NULL)";
        $r = self::$db->query($sql);
        if(!$r) self::_dbError();
        return array('unlinked_rows'=>$r->fetchColumn());
    }
    public function makeRefIntegrity($args){
        $project = jq::getProject($args['project']);
        if(!$project->isComponentExists('TDataBase')) self::error(self::DB_NOT_FOUND);
        self::$db = $project->getByName('TDataBase')->db;
        $child = strtolower($args['cservice'].'_'.$args['child']);
        $parent = strtolower($args['service'].'_'.$args['parent']);
        $field = $args['lfield'];
        if($args['mode']==='DELETE')
            $sql = "DELETE c FROM `$child` AS c LEFT JOIN `$parent` AS p ON c.`$field` = p.idx  WHERE p.idx IS NULL";
        elseif($args['mode']==='NULL')
            $sql = "UPDATE `$child` AS c LEFT JOIN `$parent` AS p ON c.`$field`=p.idx SET c.`$field`=NULL WHERE p.idx IS NULL";
        else self::error(self::MODE_NOT_SUPPORT,$args['mode']);
        if(self::$db->query($sql)===false) self::_dbError();
    }
    private static function _dbError(){
        $e = self::$db->errorInfo();
        self::error(self::DBERROR,$e[2]);
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::SERVICE_NOT_EXISTS: {$msg = 'Service class "'.$args[1].'" does not exist in components palette.'; break;}
            case self::PHP_NOT_EXISTS: {$msg = 'Class file "'.$args[1].'" does not exist in components palette.'; break;}
            case self::BAD_PHP_CLASS: {$msg = 'Can not find class definition in file "'.$args[1].'"'; break;}
            case self::INVALID_TYPE_NAME: {$msg = 'Invalid type name "'.$args[1].'"' ;break;}
            case self::MODE_NOT_SUPPORT: {$msg = 'Mode "'.$args[1].'" is not supported' ;break;}
            case self::DB_NOT_FOUND: {$msg = 'You must have a TDataBase component to test links'; break;}
            case self::DBERROR: {$msg = 'Database error: '.$args[1] ;break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>
