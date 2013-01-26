<?php
class TLinkSpeedEditor extends TVidget{
    public $updatible = 0;
    protected $client_fields = array('mchild','mlfield','mservice','mparent');
    protected function isClientInstance(){return true;}
}
?>