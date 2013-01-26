<?php
class TComponentsTree extends TVidget{
    protected $client_fields = array('service','treemodel');
    public $updatible = 1; //External
    protected function isClientInstance(){return true;}
}
?>