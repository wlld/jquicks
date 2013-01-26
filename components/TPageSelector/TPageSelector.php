<?php
class TPageSelector extends TVidget{
    public  $pages;
    public  $active=0;
    protected $client_fields = array('pages','changable','visibility','active');
    protected function isClientInstance(){return true;}
}
?>