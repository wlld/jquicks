<?php
class TModelPageControl extends TVidget{
    public $updatible = 1;
    public $model = ''; //External
    protected $client_fields = array('model');
    protected function isClientInstance(){return true;}
}
?>