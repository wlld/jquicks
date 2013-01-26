<?php
class TLinksCheckingDialog extends TVidget{
    public $updatible = 1;
    public $display = 0;
    protected $client_fields = array();
    public $data=array();
    public $ready=false;
    protected function isClientInstance(){return true;}
}