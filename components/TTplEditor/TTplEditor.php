<?php
class TTplEditor extends TVidget{
    protected $client_fields = array('tplmodel','view_model','show_loader');
    public $updatible = 1;
    public $show_loader = true;
    public $display = false;

    protected function isClientInstance(){return true;}
    public function __construct($struc = null) {
        parent::__construct($struc);
        $this->view_model = $this->name.'.tplmodel';
    }
}
?>