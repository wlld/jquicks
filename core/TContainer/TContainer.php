<?php
class TContainer extends TVidget {
    private $_content;
    public $sections = 1;
    public function drawSection($n){
        if(!isset($this->_content[$n])) echo 'Section ',$n,' is not exist';
        else {
            if ($this->_content[$n])
                foreach ($this->_content[$n] as $id){
                    $c = $this->project->getById($id);
                    $c->draw();
                }
                else echo 'section ',$n;
        }
    }
    public function __construct($struc=null){
        parent::__construct($struc);
        if($struc) $this->_content = $struc['s'];
    }
    protected function getUsedComponents(){
        $r = parent::getUsedComponents();
        for($i=0,$l=count($this->_content);$i<$l;$i++) $r = array_merge($r,$this->_content[$i]);
        return $r;
    }
}
?>