<?php
interface ICommandServer {
   public function run($cmd,$args);
}
abstract class TComponent {
    const COMPONENT_NOT_FOUND = 1;
    const UNKNOWN_PROPERTY = 2;

    public $name;
    public $id;
    protected $project;
    protected $client_fields = array();
    private $_embedded = false;
    private $_dbmnt = array();

    public function __construct($project,$struc=null){
        $this->project = $project;
        if($struc){
            $this->name = $struc['n'];
            $this->_embedded = $struc['l']===false;
            if(isset($struc['m'])) $this->_dbmnt = $struc['m'];
            foreach ($struc['p'] as $name=>$def) $this->$name = $def[1];
        }
    }
    public function __get($name){
        if(!isset($this->_dbmnt[$name])) self::error (self::UNKNOWN_PROPERTY,$name);
        $this->$name = $this->project->getById($this->_dbmnt[$name]);
        return $this->$name;
    } 
    public function isEmbedded(){return $this->_embedded;}
    protected function getUsedComponents(){
        return array_values($this->_dbmnt);
    }
    public static function loadFromDB($project,$id){
        if(!isset($project->db['components'][$id])) self::error(self::COMPONENT_NOT_FOUND,$id);
        $struc = $project->db['components'][$id];
        $class = $struc['c'];
        $c = new $class($project,$struc);
        $c->id = $id;
        $c->path = $project->path.'/'.$id;
        return $c;
    }
    public static function jsonEncode($str){
        if (defined('JSON_UNESCAPED_UNICODE')) return json_encode($str,JSON_UNESCAPED_UNICODE);
        return json_encode($str);
    }
/*DEPLOY_TIME*/
    protected function isClientInstance(){return false;}
    protected function getDefinition($lvl){
        if (!$this->isClientInstance()) return '';
        $cclass = 'C'.substr(get_class($this),1);
        $r = "jq.create('{$this->name}','$cclass',{";
        $r .=$this->_getPrpDefinition($lvl);
        $r .= "\n".str_repeat('    ',$lvl).'}'.(($lvl>0)? ',true':'').')';
        return $r;
    }
    protected function getClientProperties(){return $this->client_fields;}
    protected function _getPrpDefinition($lvl){
        try{
            $r = ''; $i=0;
            $defs = $this->getClientProperties();
            if ($defs){
                foreach($defs as $prp){
                    if ($i++) $r .= ',';
                    $prpval = $this->$prp;
                    if(is_object($prpval)){
                        if(!method_exists($prpval,'getDefinition')) throw new Exception("$prp of {$this->name} is not a TComponent");
                        $def = $prpval->getDefinition($lvl+1);
                        if ($def) $r .= "\n    $prp:$def";
                    }
                    else $r.= "\n".str_repeat('    ',$lvl)."    $prp:".self::jsonEncode($prpval);
                }
            }
        }
        catch (Exception $e) {$r = '/*'.$e->getMessage().'*/';}
        return $r;
        
    }
    public static function error(){
        $msg = static::_getErrorMsg(func_get_args());
        $code = func_get_arg(0);
        throw new Exception($msg,$code);
    }
/*DEPLOY_TIME*/
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::COMPONENT_NOT_FOUND: {$msg = 'Component "'.$args[1].'"not found in project database'; break;}
            case self::UNKNOWN_PROPERTY:{$msg = 'Undefined property: '.$args[1]; break;}
            default: $msg = 'Unknown error';
        }
        return $msg;
    }
    public static function getPalettePath($class){
        $class = rtrim($class,'_');
        return $_SERVER['DOCUMENT_ROOT'].(self::isCoreClass($class)? '/core/':'/components/').$class;
    }
    public static function isCoreClass($class){
        return in_array($class,array('TComponent','TVidget','TModel','TCacheModel','TActionServer','TContainer','TPage',
        'TService','TDBService','TDataBase','TAccountService','TLoginDialog','TLibrary','TCryptLibrary'));
    }
}