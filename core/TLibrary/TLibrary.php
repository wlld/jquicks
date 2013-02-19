<?php
class TLibrary extends TComponent{
    public $autoload = '';
    public function __construct($project,$struc = null) {
        parent::__construct($project,$struc);
        if($this->autoload)  $project->registerEventHandler('ondrawheader',$this,'drawHeader');
    }
    public function drawHeader(){
        $files = explode(',',$this->autoload);
        $path = $this->project->getLibraryPath($this->library).'/client/';
        foreach($files as $file){
            jq::$page->drawLibrary($path.$file);
        }
    }   
    protected function isClientInstance(){return false;}
}
