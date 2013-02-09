<?php
class TRegistrationForm extends TForm{
    public $state=0;
    protected function isClientInstance(){return true;}
    public function __construct($project,$struc = null) {
        parent::__construct($project,$struc);
        $project->registerEventHandler('ondrawheader',$this,'drawHeader');
    }
    public function drawHeader(){
        $path = $this->project->getLibraryPath('crypt').'/client/';
        jq::$page->drawLibrary($path.'rsa.js');
    }   
}
?>