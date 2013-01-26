<?php
class TLoginDialog extends TVidget{
    public $display = 1;      //External
    public $updatible = 1;    //External
    protected $client_fields = array('user_id','user_name');
    function __get($name) {
        switch($name){
            case 'user_name':return $this->project->user_name;
            case 'user_id':return $this->project->user_id;
            case 'user_groups':return $this->project->user_groups;
            default:parent::__get($name);
        }    
    }
}
?>