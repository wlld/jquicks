<?php
class TLinksEditor extends TVidget{
    protected $client_fields = array('model','view_model','show_loader','speededitor','checker');
    public $updatible = 1;
    public $show_loader = true;
    public $display = false;

    protected function isClientInstance(){return true;}
    public function __construct($project,$struc = null) {
        parent::__construct($project,$struc);
        $this->view_model = $this->name.'.model';
    }
}
?>