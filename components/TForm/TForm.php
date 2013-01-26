<?php
class TForm extends TVidget{
    public $updatible = 1;
    protected $client_fields = array('model','view_model','show_loader');
    protected function isClientInstance(){return true;}
}
?>