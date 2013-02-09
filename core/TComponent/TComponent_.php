<?php
class TComponent_ {
    protected $singletone = false;
    
    const CMPDEF_NOT_FOUND = 10;
    const BAD_CMPDEF = 11;
    const NAME_EXIST = 12;
    const PAGE_NOT_FOUND = 13;
    const RENAME_SINGLE = 14;
    const EX_PROPERTY_NOT_FOUND = 15;
    const EX_PROPERTY_INVALID_JSON = 16;
    const UNKNOWN_PROPERTY = 17;
    const UNKNOWN_PROPERTY_TYPE = 19;
    const CLASS_NOT_EXISTS = 20;
    protected $id = null; // Экземпляр объекта, если редактируем существующий объект
    protected $class; //Класс объекта, с которым имеем дело
    protected $project; //Класс объекта, с которым имеем дело
    /**
     * Создаёт экземпляр класса дизайнера для нового или существующего в проекте компонента
     * @param integer|string $item id компонента - для существующего, имя класса - для нового
     * @param type $project - объект проекта
     */
    public function __construct($project,$class,$id=null) {
        $this->class = $class;
        $this->project = $project;
        if(!is_null($id)) $this->id = $id;
    }
    public function __get($name) {
        if(!isset($this->project->db['components'][$this->id]['m'])) self::error(self::UNKNOWN_PROPERTY,$name);
        $embed = $this->project->db['components'][$this->id]['m'];
        if(!isset($embed[$name])) self::error(self::UNKNOWN_PROPERTY,$name);
        $mid = $embed[$name];
        $this->$name = TComponent_::getDesigner($mid, $this->project);
        return $this->$name;
    }
    public static function getDesigner($item,$project){
        $class = is_integer($item)? $project->db['components'][$item]['c']:$item;
        $true_class = $class;
        $designer_class = $class.'_';
        if(!class_exists($designer_class,false)){
            $path = TComponent::getPalettePath($class);
            while(!file_exists($path.'/'.$designer_class.'.php')){
                $p_class = get_parent_class($class);
                if(!$p_class) self::error(self::CLASS_NOT_EXISTS,$class);
                else $class=$p_class;
                $path = TComponent::getPalettePath($class);
                $designer_class = $class.'_';
            };
        }
        return new $designer_class($project,$true_class,is_integer($item)?$item:null);
    }
    protected function _getName(){
        return $this->project->db['components'][$this->id]['n'];
    }
    protected function _getNewName(){
        if($this->singletone) return $this->class;
        $name = strtolower(substr($this->class,1)).'_';
        $i=1;
        foreach($this->project->db['names'] as $cmpname=>$id){
            if (strpos($cmpname,$name)===0){
                $ii = (int)substr($cmpname,strlen($name));
                if($ii>=$i) $i = $ii+1;
            }
        }
        return $name.$i;
    }
    protected function _compilePropertyValue($val,$type){
        list($t) = preg_split("/[[(]/",$type);
        switch($t){
            case 'object': {
                $val1 = json_decode($val,true);
                if($val1===null) self::error(self::EX_PROPERTY_INVALID_JSON,$val);
                return $val1;
            }
            case 'boolean':
            case 'integer': return (int)$val;
            case 'float': return floatval($val);
            case 'component': 
            case 'list': 
            case 'text': 
            case 'string': return $val;
            default: self::error(self::UNKNOWN_PROPERTY_TYPE,$type);
        }
    }
    protected function insertIntoDB($embedded=false,$name=null){
        $cmpdef_file = TComponent::getPalettePath($this->class).'/cmpdef.xml';
        if(!file_exists($cmpdef_file)) self::error(self::CMPDEF_NOT_FOUND,$this->class);
        $prpdef = array();
        if(!($cmpdef = simplexml_load_file($cmpdef_file))) self::error(self::BAD_CMPDEF);
        foreach($cmpdef->prp as $prp){
            $t = (string)$prp['type'];
            $v = $this->_compilePropertyValue((string)$prp,$t);
            $prpdef[(string)$prp['name']] = array($t,$v);
        }
        if($name===null) $name = $this->_getNewName();
        $db = &$this->project->db;
        if(isset($db['names'][$name])) self::error(self::NAME_EXIST,$name);
        $cmp = array('c'=>$this->class,'n'=>$name,'l'=>$embedded?false:array(),'p'=>$prpdef);
        $m = array();
        $components = &$db['components'];
        if(isset($cmpdef->embed)){
            foreach($cmpdef->embed as $embed){
                $mname = (string)$embed['name'];
                $mtype = (string)$embed['type'];
                $designer = TComponent_::getDesigner($mtype, $this->project);
                $mid = $designer->insertIntoDB(true,$name.'.'.$mname);
                $mprp = &$components[$mid]['p'];
                foreach($embed->prpval as $mval){
                    $mprpname = (string)$mval['name'];
                    $mprptype = $mprp[$mprpname][0];
                    $v = $designer->_compilePropertyValue((string)$mval,$mprptype);
                    $mprp[$mprpname][1] = $v;
                }
                $m[$mname] = $mid;
            }
        }
        if($m) $cmp['m'] = $m;
        //Вставить компонент в файл структуры
        $components[] = $cmp;
        end($components);
        $id = key($components);
        $db['names'][$name]=$id;
        if(!isset($db['classes'][$this->class])){
            $parents = array(); $p = $this->class;
            while ((($p = get_parent_class($p)) !== 'TComponent')) $parents[] = $p;
            $db['classes'][$this->class] = $parents;
        }
        return $id;
    }
    private function deleteFromDB($id){
        $db = &$this->project->db;
        $cmp = &$db['components'][$id];
        if(isset($cmp['m'])){
            foreach($cmp['m'] as $mcmp) $this->deleteFromDB($mcmp);
        }
        $name = $cmp['n'];
        $class = $cmp['c'];
        unset($db['components'][$id]);
        unset($db['names'][$name]);
        foreach($db['components'] as $i=>$c) if($c['c']===$class) return;
        unset($db['classes'][$class]);
    }

    protected function _rename($name){
        if($this->singletone) self::error(self::RENAME_SINGLE);
        $db = $this->project->db;
        $c = &$db['components'][$this->id];
        if(isset($db['names'][$name])) self::error(self::NAME_EXIST,$name);
        unset($db['names'][$c['n']]);
        $db['names'][$name] = $this->id;
        $c['n'] = $name;
        if(isset($c['m'])){
            foreach($c['m'] as $pname=>$mid){
                $mname = $name.'.'.$pname;
                $n = &$db['components'][$mid]['n'];
                unset($db['names'][$n]);
                $db['names'][$mname] = $mid;
                $n = $mname;
            }
        }
        $this->project->changed = true;
    }
    public function setProperty($prp,$val){
        if($prp==='name') $this->_rename($val);
        else{
            $c = &$this->project->db['components'][$this->id];
            if (!isset($c['p'][$prp])) self::error(self::EX_PROPERTY_NOT_FOUND,$prp,$this->name);
            $val = $this->_compilePropertyValue($val, $c['p'][$prp][0]);
            $this->applyProperty($c,$prp,$val);
        }
    }
    protected function applyProperty(&$cmp,$name,$val){
        $cmp['p'][$name][1] = $val;
        $this->project->changed = true;
    }
    protected function deleteFromContainer($parent,$section,$order){
        $components = &$this->project->db['components'];
        if (!isset($components[$parent]['u'])) self::error(self::PAGE_NOT_FOUND,$parent);
        $s = &$components[$parent]['u'];
        unset($s[$order]);
        $s = array_values($s);
    }
    public function removeFromProject($parent,$section,$order,$page){
        $this->deleteFromContainer($parent,$section,$order);
        $components = &$this->project->db['components'];
        $links = &$components[$this->id]['l'];
        if (isset($links[$page])) {if(--$links[$page] <= 0) unset($links[$page]);}
        $free = true;
        foreach($links as $link=>$count) if (isset($components[$link])) {$free=false; break;}
        if ($free) $this->deleteFromDB($this->id);
    }
    public function insertIntoProject($parent,$section,$order,$page,$name=null){
        if(!$this->id) $this->id = $this->insertIntoDB(false,$name);
        $components = &$this->project->db['components'];
        if(!isset($components[$parent]['u'])) self::error(self::PAGE_NOT_FOUND,$parent);
        $cs = &$components[$parent]['u'];
        $cs = array_merge(array_slice($cs,0,$order),array($this->id),array_slice($cs,$order));
        $links = &$components[$this->id]['l'];
        if (isset($links[$page] )) $links[$page]++;
        else $links[$page] = 1;
    }
    protected static function error(){
        $msg = static::_getErrorMsg(func_get_args());
        $code = func_get_arg(0);
        throw new Exception($msg,$code);
    }

    protected static function  _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::EX_PROPERTY_NOT_FOUND: {$msg = 'Property "'.$args[1].'"is not exist in component '.$args[2]; break;}
            case self::PAGE_NOT_FOUND: {$msg = 'Valid page component "'.$args[1].'"not found'.$args[2]; break;}
            case self::EX_PROPERTY_INVALID_JSON: {$msg = 'Invalid json data format: '.$args[1]; break;}
            case self::NAME_EXIST: {$msg = 'Component with name "'.$args[1].'" already exist in this project'; break;}
            case self::RENAME_SINGLE:{$msg = 'Can not rename singletone'; break;}
            case self::BAD_CMPDEF: {$msg = 'Bad cmpdef.xml file format'; break;}
            case self::CMPDEF_NOT_FOUND: {$msg = 'File cmpdef.xml not exists in '.$args[1]; break;}
            case self::UNKNOWN_PROPERTY:{$msg = 'Undefined property: '.$args[1]; break;}
            case self::UNKNOWN_PROPERTY_TYPE:{$msg = 'Unknown property type "'.$args[1].'"'; break;}
            case self::CLASS_NOT_EXISTS:{$msg = 'Server class "'.$args[1].'" not found'; break;}
            default: $msg = 'Unknown error';
        }
        return $msg;
    }
}
?>
