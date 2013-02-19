<?php
class TPage extends TContainer {
    public $client_classes = null;
    public $title = '';    //External
    public $keywords = '';    //External
    public $description = '';    //External
    public $P3P = '';  //External
    private $_comps;
    private $_classes = array();
    private $_loaded = array();

    public function __construct($project,$struc=null){
        parent::__construct($project,$struc);
        if ($struc) $this->_comps = $struc['u'];
    }
    protected function isClientInstance(){return false;}
    public function load(){
        $this->_loadComponent($this->id);
        asort($this->_classes);
    }
    private function _loadComponent($id){
        $c = $this->project->getById($id);
        $content = $c->getUsedComponents();
        for($i=0,$l=count($content);$i<$l;$i++){$this->_loadComponent($content[$i]);}
        if($c->isClientInstance()) $this->_registerClass(get_class($c));
        return $c;
    }
    private function _registerClass($class){
       if ($class==='TComponent'){
           if(!isset($this->_classes[$class])) $this->_classes[$class]=0;
       }
       else{
           $parent = get_parent_class($class);
           if (!$parent) throw new Exception('Invalid parent class for class '.$class,1);
           $this->_registerClass($parent);
           if(!isset($this->_classes[$class])) $this->_classes[$class]=$this->_classes[$parent]+1;
       }
    }
    private function _drawComponents(){
        $def = '';
        foreach($this->project->getAllComponents() as $cmp) {
            if(!$cmp->isEmbedded()){
                $r = $cmp->getDefinition(0);
                if ($r) $def .= $r.";\n";
            }
        }
        if ($def) echo "\n\n".'<script type="text/javascript">'."\n".$def.'</script>'."\n";
    }
    protected function getUsedComponents(){
        $r = parent::getUsedComponents();
        return array_merge($r,$this->_comps);
    }
    private function _noCacheLink($file){
       $path = jq::$base.'/'.$this->id.'/'.$file;
        $mt = filemtime($_SERVER['DOCUMENT_ROOT'].$path);
        return $path.'?'.$mt;
    }
    private function _drawHeader(){
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',"\n";
        echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">',"\n";
        echo '<head>',"\n";
        echo '  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />',"\n";
        if ($this->keywords) echo '  <meta name="keywords" content="',htmlspecialchars($this->keywords,ENT_QUOTES,'UTF-8'),'">',"\n";
        if ($this->description) echo '  <meta name="description" content="',htmlspecialchars($this->description,ENT_QUOTES,'UTF-8'),'">',"\n";
        echo '  <link rel="stylesheet" href="',$this->_noCacheLink('page.css'),'" type="text/css" />',"\n";
//        echo '  <script type="text/javascript" src="',$this->_noCacheLink('classes.js'),'"></script>',"\n";
        $this->_drawClientClasses();
        echo '  <title>',$this->title,'</title>',"\n";
        $this->project->event('ondrawheader');
        echo "</head>\n<body id='$this->name'>\n";
    }
    private function _drawClientClasses(){
        echo '  <script type="text/javascript" src="/core/classes.js"></script>',"\n";
        foreach($this->_classes as $class=>$p){
            if(in_array($class,array('TComponent','TVidget','TModel','TActionServer'))) continue;
            $path = TComponent::isCoreClass($class)? '/core/':'/components/';
            $fname = 'C'.substr($class,1).'.js';
            echo '  <script type="text/javascript" src="'.$path.$class.'/'.$fname.'"></script>',"\n";
        }
    }
    private function _drawFooter(){
        $this->_drawComponents();
        if(file_exists($this->path.'/templates.js'))
            echo "\n",'<script type="text/javascript" src="',$this->_noCacheLink('templates.js'),'"></script>',"\n";
        if(file_exists($this->path.'/page.js'))
            echo '<script type="text/javascript" src="',$this->_noCacheLink('page.js'),'"></script>',"\n";
        echo "<body>\n<html>";
    }
    public function drawLibrary($url){
        if(in_array($url, $this->_loaded)) return;
        $ext = substr(strrchr($url, '.'), 1);
        if($ext=='js') echo('  <script type="text/javascript" src="'.$url.'"></script>'."\n");
        elseif($ext=='css') echo('  <link rel="stylesheet" href="'.$url.'" type="text/css" />');
        $this->_loaded[] = $url;
    }
    public function draw(){
        header('Content-Type: text/html; charset=utf-8');
        header('Cache-control: no-store');
        if ($this->P3P) header('P3P: CP="'.$this->P3P.'"');
        ob_start();
        $this->_drawHeader();
        $this->_drawTemplate();
        $this->_drawFooter();
        ob_end_flush();
    }
}
?>