<?php
class TVidget extends TComponent{
    const KEY_NOT_EXISTS = 100;

    public $display = 1;      //External
    public $updatible = 0;    //External
    public $view_model = '';  //External
    public $show_loader = 0;  //External
    protected $client_fields = array('view_model','show_loader');
    
    protected function isClientInstance(){return $this->updatible;}
    protected function draw(){
        echo('<div id="'.$this->name.'" class="'.get_class($this).'">');
        $this->_drawTemplate();
        echo('</div>');
    }
    protected function _drawTemplate(){
        try{
            ob_start();
            $tmplate = $this->name.'_template';
            if ($this->display && function_exists($tmplate)) $tmplate($this);// call_user_func($tmplate,$this);
            ob_end_flush();
        }
        catch (Exception $e){ob_end_clean(); echo htmlspecialchars($e->getMessage(),ENT_QUOTES);}
    }
    public function item($array,$key) {
        if (!array_key_exists($key,$array)) return null;
        return $array[$key];
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::KEY_NOT_EXISTS: {$msg = 'Undefined key: '.$args[1]; break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>