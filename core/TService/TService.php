<?php
define('CHECK_FETCH_PARAMS',0);
define('CHECK_UPDATE_FIELDS',1);
define('CHECK_INSERT_FIELDS',2);
define('CHECK_FETCH_FIELDS',3);
define('CHECK_CMD_PARAMS',4);

abstract class TService extends TComponent implements ICommandServer{
    abstract protected function &getDefinitionStruc();

    const ARGUMENT_REQUIRED = 101;
    const UNKNOWN_MODEL = 102;
    const METHOD_UNSUPPORT = 103;
    const UNDEFINED_COMMAND = 104;
    const STRUCFILE_NOT_FOUND = 105;
    const STRUCFILE_ERROR = 106;
    const UNDEFINED_VALUES = 111;
    
    protected $_updated_models = array();
	
    public function testServiceRights(){return true;}
    protected function _getTypeDefinition($model,$check){
        $struc = &$this->getDefinitionStruc();
        if($check===CHECK_CMD_PARAMS)
            {if(!isset($struc['commands'][$model])) self::error (self::UNDEFINED_COMMAND,$model);}
        else {
            {if(!isset($struc['models'][$model])) self::error (self::UNKNOWN_MODEL,$model);}
        }
        switch($check){
            case CHECK_FETCH_PARAMS:{$t=&$struc['models'][$model]['p']; break;}
            case CHECK_UPDATE_FIELDS:{$t=&$struc['models'][$model]['u']; break;}
            case CHECK_INSERT_FIELDS:{$t=&$struc['models'][$model]['i']; break;}
            case CHECK_FETCH_FIELDS:{$t=&$struc['models'][$model]['f']; break;}
            case CHECK_CMD_PARAMS:{$t=&$struc['commands'][$model]; break;}
        }
        if(is_string($t)) $t = unserialize($t);
        return $t;
    }
    public function checkTypes($model,&$val,$check){
        $types = self::_getTypeDefinition($model,$check);
        $diff = array_diff_key($val, $types);
        if($diff) self::error(self::UNDEFINED_VALUES,join(',', array_keys($diff)),$model);
        foreach($types as $name=>$def){
            if(isset($val[$name])){
                switch($def[0]){
                    case 1: {$val[$name] = (integer)$val[$name]; break;}
                    case 2: {$val[$name] = (real)$val[$name]; break;}
                    case 4: {$val[$name] = (boolean)$val[$name]; break;}
                    case 3:
                    case 5:{ $val[$name] = (string)$val[$name]; break;}
                }
            }
            else if($def[1]) self::error(self::ARGUMENT_REQUIRED,$name,$model); 
        }
    }
    public function run($cmd,$args){
        $this->checkTypes($cmd,$args,CHECK_CMD_PARAMS);
        if($this->project->isComponentExists('TAccountService')){
            $acs = $this->project->getByName('TAccountService'); 
            $acs->testCoreRights($this->id,$cmd);
        }
        return $this->$cmd($args);
    }
    public function isModelUpdated($model){
        return in_array($model,$this->_updated_models);
    }
    public function isOwnedModel($model){
        $struc = $this->getDefinitionStruc();
        return $struc['models'][$model]['owner'];
    }
    public function queryModel($model,$cmd,$arg){
        $func = '_'.$cmd.'_'.$model.'_model';
        if(!method_exists($this,$func)&&!method_exists($this,'__call')) self::error(self::METHOD_UNSUPPORT,$cmd,$model);
        $r =  $this->$func($arg);
        if ($cmd!=='fetch') $this->_updated_models[] = $model;
        return $r;
    }
    protected function setUpdateModel($model){
        $this->_updated_models[] = $model;
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::ARGUMENT_REQUIRED: {$msg = 'Argument "'.$args[1].'" required for "'.$args[2].'" model/command' ;break;}
            case self::UNKNOWN_MODEL: {$msg = 'Unknown model: "'.$args[1].'"' ;break;}
            case self::METHOD_UNSUPPORT: {$msg = $args[1].' is not supported for "'.$args[2].'" model' ;break;}
            case self::UNDEFINED_COMMAND: {$msg = 'Undefined service command: "'.$args[1].'"' ;break;}
            case self::STRUCFILE_NOT_FOUND: {$msg = 'File service.xml not found for "'.$args[1].'"'; break;}
            case self::STRUCFILE_ERROR: {$msg = 'File service.xml of "'.$args[1].'" has invalid structure.'; break;}
            case self::UNDEFINED_VALUES:{$msg = 'Values for "'.$args[1].'" not allowed in '.$args[2]; break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>