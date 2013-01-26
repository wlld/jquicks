<?php

class TComponentEditor extends TContainer{
    public $page='';
    protected function isClientInstance(){return true;}
    protected $client_fields = array('groups','page');
}
?>