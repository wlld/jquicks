<?php
class TLibrary extends TComponent{
    public $autoload = '';
    public function __construct($project,$struc = null) {
        parent::__construct($project,$struc);
        if($this->autoload)  $project->registerEventHandler('ondrawheader',$this,'drawHeader');
    }
    public function drawHeader(){
        $files = explode(',',$this->autoload);
        $class = get_class($this);
        $path = (self::isCoreClass($class)? '/core/':'/components/').$class.'/client/';
        foreach($files as $file){
            $ext = substr(strrchr($file, '.'), 1);
            if($ext=='js') echo('  <script type="text/javascript" src="'.$path.$file.'"></script>'."\n");
            elseif($ext=='css') echo('  <link rel="stylesheet" href="'.$path.$file.'" type="text/css" />');
        }
    }   
    public function load($file){
        $path = TComponent::getPalettePath(get_class($this));
        require_once "$path/server/$file";
    }
    protected function isClientInstance(){return false;}
}
