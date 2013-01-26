<?php
class TCoreRightsEditor_ extends TVidget_{
    const SERVICE_NOT_FOUND = 200;
    
    public function setProperty($prp,$val){
        parent::setProperty($prp,$val);
        if ($prp === 'service') {
            if(!$this->project->isComponentExists($val)) self::error(self::SERVICE_NOT_FOUND,$val); 
            $db = $this->project->db;
            $id = $db['names'][$val];
            $class = $db['components'][$id]['c'];
            $this->mrights->setProperty('params',"{\"service\":$id}");
            $this->mmodels->setProperty('params',"{\"service\":\"$class\"}");
            $this->mfields->setProperty('params',"{\"service\":\"$class\"}");
        }
    } 
    protected static function  _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::SERVICE_NOT_FOUND: {$msg = "Service '$args[1]' does not exist.";break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}

?>
