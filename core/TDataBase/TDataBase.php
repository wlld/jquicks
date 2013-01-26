<?php
class TDataBase extends TComponent{
    const CONNECTION_ERROR = 201;

    public $database;     //External
    public $user;       //External
    public $password;   //External
    public $persistent=1;   //External
    
    function __get($name){
        if ($name==='db'){
            $this->db = $this->connect();
            return $this->db;
        } else return parent::__get ($name);
    }
    private function connect(){
        $host = '127.0.0.1';
        $dbname = $this->project->getProjectVar('database');// database;
        $user = $this->project->getProjectVar('dbusername');//$this->user;
        $password = $this->project->getProjectVar('dbpassword');//$this->password;
        try{
            $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password,array(PDO::ATTR_PERSISTENT=>(boolean)$this->persistent));
        }
        catch (PDOException $e) {self::error(self::CONNECTION_ERROR,$e->getMessage());}
        if ($db) $db->exec('SET NAMES UTF8');
        else self::error(self::CONNECTION_ERROR,'');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        return $db;
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::CONNECTION_ERROR: {$msg = 'Error while connecting to database: '.$args[1] ;break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>
