<?php
class TContainer_ extends TVidget_{
    const INVALID_PRP_VALUE = 200;

    protected function insertIntoDB($embedded=false,$name=null){
        $id = parent::insertIntoDB($embedded, $name);
        $cmp = &$this->project->db['components'][$id];
        $cmp['s'] = array_fill(0,$cmp['p']['sections'][1],array());
        return $id;
    }
    public function applyProperty(&$cmp,$name,$val) {
        if ($name == 'sections'){
             $sections = $cmp['p']['sections'][1];
             if($val<=0) self::error(self::INVALID_PRP_VALUE,$val,$name);
             $s = &$cmp['s'];
             if($val<$sections){
                 $c = array();
                 for($i = $val,$l=count($s);$i<$l;$i++){
                     $c = array_merge($c,$s[$i]);
                 }
                 $s[$val-1] = array_merge($s[$val-1],$c);
                 array_splice($s,$val);
             }
             elseif($val>$sections){
                 $s = array_merge($s,array_fill(0,$val-$sections,array()));
             }
             else exit;
         }
         parent::applyProperty($cmp, $name, $val);
    }
    public function removeFromProject($parent,$section,$order,$page){
        $components = $this->project->db['components'];
        foreach($components[$this->id]['s'] as $sect=>$sect_content){
            $this->_deleteSection($sect,$sect_content,$page); 
        }
        parent::removeFromProject($parent,$section,$order,$page);
    }
    protected function _deleteSection($sect,$sect_content,$page) {
        foreach($sect_content as $ord=>$id){
            $designer = TComponent_::getDesigner($id, $this->project);
            $designer->removeFromProject($this->id,$sect,$ord,$page);
        }
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::INVALID_PRP_VALUE: {$msg = "Invalid value '$args[1]'' for property '$args[2]'"; break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>
