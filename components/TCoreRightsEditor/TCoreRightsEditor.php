<?php
class TCoreRightsEditor extends TVidget{
    const SERVICE_NOT_FOUND = 200;
    
    public $display = 1;      //External
    public $updatible = 1;    //External
    public $service = '';    //External
    public $filters = array('model'=>'','group'=>'','fetch-group'=>'','fetch-owner'=>'','update-group'=>'','update-owner'=>'','remove-group'=>'','remove-owner'=>'','insert-group'=>'');
    protected $client_fields = array('mmodels','mfields','mgroups','mrights');
    protected function isClientInstance(){return true;}

    public function setService($name){
        $names = $this->project->db['names'];
        if(!isset($names[$name])) self::error(self::SERVICE_NOT_FOUND,$name); 
        $id = $names[$name];
        $class = $this->project->db['components'][$id]['c'];
        $this->mfields->params['service']= $class;
        $this->mmodels->params['service']= $class;
        $this->mrights->params['service']= (integer)$id;
        $this->service = $name;
    }
    /*
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
     * 
     */      
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::SERVICE_NOT_FOUND: {$msg = "Service '$args[1]' does not exist.";break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>