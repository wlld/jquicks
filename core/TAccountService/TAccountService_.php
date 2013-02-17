<?php
class TAccountService_ extends TDBService_{
    protected $singletone = true;
    public function createTable($name,$table){
        parent::createTable($name,$table);
        switch ($name){
            case 'users' :{
                $pass = sha1('admin');
                $date = date(self::SQL_DATE_FORMAT);
                $sql = "INSERT INTO `$table` (login,password,name,regdate,groups,active) VALUES("
                    ."'admin','$pass', 'Administrator', '$date', '1',1"
                .')';
                $this->db->exec($sql);
                break;
            }
            case 'groups' :{
                $sql = "INSERT INTO `$table` (name,descr) VALUES"
                    ."('admins', 'Administrators'),('users', 'Regular users'),('banned', 'Banned users')";
                $this->db->exec($sql);
                break;
            }
        }
    }
    public function applyProperty(&$cmp,$name,$val) {
        if ($name == 'RSA_key_length'){
            $this->project->getByName('TCryptLibrary')->load('RSA.php');
            $rsa = new Crypt_RSA();
            $keys = $rsa->createKey($val);
            $ini ="private=\"{$keys['privatekey']}\"\npublic=\"{$keys['publickey']}\""; 
            $path = $this->project->path.'/'.$this->id;
            if(!file_exists($path)) mkdir($path);
            file_put_contents($path.'/rsakeys.ini', $ini);
         }
         parent::applyProperty($cmp, $name, $val);
    }
}