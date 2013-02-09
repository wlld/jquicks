<?php
class TAccountService extends TDBService{
/*SRVDEF*/
private static $_definition_struc = array (
  'models' =>array (
    'users' =>array (
      'p' => 'a:1:{s:3:"idx";a:2:{i:0;i:1;i:1;b:0;}}',
      'i' => 'a:7:{s:5:"login";a:2:{i:0;i:3;i:1;b:0;}s:8:"password";a:2:{i:0;i:3;i:1;b:0;}s:4:"name";a:2:{i:0;i:3;i:1;b:0;}s:6:"groups";a:2:{i:0;i:3;i:1;b:0;}s:5:"email";a:2:{i:0;i:3;i:1;b:0;}s:6:"active";a:2:{i:0;i:1;i:1;b:0;}s:7:"pub_key";a:2:{i:0;i:3;i:1;b:0;}}',
      'u' => 'a:8:{s:5:"login";a:2:{i:0;i:3;i:1;b:0;}s:8:"password";a:2:{i:0;i:3;i:1;b:0;}s:4:"name";a:2:{i:0;i:3;i:1;b:0;}s:7:"regdate";a:2:{i:0;i:3;i:1;b:0;}s:6:"groups";a:2:{i:0;i:3;i:1;b:0;}s:5:"email";a:2:{i:0;i:3;i:1;b:0;}s:6:"active";a:2:{i:0;i:1;i:1;b:0;}s:7:"pub_key";a:2:{i:0;i:3;i:1;b:0;}}',
      'f' => 'a:9:{s:3:"idx";i:1;s:5:"login";i:3;s:8:"password";i:3;s:4:"name";i:3;s:7:"regdate";i:3;s:6:"groups";i:3;s:5:"email";i:3;s:6:"active";i:1;s:7:"pub_key";i:3;}',
      'owner' => false,
    ),
    'groups' =>array (
      'p' => 'a:1:{s:3:"idx";a:2:{i:0;i:1;i:1;b:0;}}',
      'i' => 'a:2:{s:4:"name";a:2:{i:0;i:3;i:1;b:0;}s:5:"descr";a:2:{i:0;i:3;i:1;b:0;}}',
      'u' => 'a:2:{s:4:"name";a:2:{i:0;i:3;i:1;b:0;}s:5:"descr";a:2:{i:0;i:3;i:1;b:0;}}',
      'f' => 'a:3:{s:3:"idx";i:1;s:4:"name";i:3;s:5:"descr";i:3;}',
      'owner' => false,
    ),
    'rights' =>array (
      'p' => 'a:4:{s:3:"idx";a:2:{i:0;i:1;i:1;b:0;}s:7:"service";a:2:{i:0;i:1;i:1;b:0;}s:5:"group";a:2:{i:0;i:1;i:1;b:0;}s:5:"model";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:10:{s:7:"service";a:2:{i:0;i:1;i:1;b:1;}s:5:"group";a:2:{i:0;i:1;i:1;b:1;}s:5:"model";a:2:{i:0;i:3;i:1;b:1;}s:11:"fetch-group";a:2:{i:0;i:3;i:1;b:0;}s:11:"fetch-owner";a:2:{i:0;i:3;i:1;b:0;}s:12:"update-group";a:2:{i:0;i:3;i:1;b:0;}s:12:"update-owner";a:2:{i:0;i:3;i:1;b:0;}s:12:"remove-group";a:2:{i:0;i:1;i:1;b:0;}s:12:"remove-owner";a:2:{i:0;i:1;i:1;b:0;}s:12:"insert-group";a:2:{i:0;i:1;i:1;b:0;}}',
      'u' => 'a:7:{s:11:"fetch-group";a:2:{i:0;i:3;i:1;b:0;}s:11:"fetch-owner";a:2:{i:0;i:3;i:1;b:0;}s:12:"update-group";a:2:{i:0;i:3;i:1;b:0;}s:12:"update-owner";a:2:{i:0;i:3;i:1;b:0;}s:12:"remove-group";a:2:{i:0;i:1;i:1;b:0;}s:12:"remove-owner";a:2:{i:0;i:1;i:1;b:0;}s:12:"insert-group";a:2:{i:0;i:1;i:1;b:0;}}',
      'f' => 'a:11:{s:3:"idx";i:1;s:7:"service";i:1;s:5:"group";i:1;s:5:"model";i:3;s:11:"fetch-group";i:3;s:11:"fetch-owner";i:3;s:12:"update-group";i:3;s:12:"update-owner";i:3;s:12:"remove-group";i:1;s:12:"remove-owner";i:1;s:12:"insert-group";i:1;}',
      'owner' => false,
    ),
  ),
  'commands' =>array (
    'authenticatePhase1' => 'a:1:{s:5:"login";a:2:{i:0;i:3;i:1;b:1;}}',
    'getPublicKey' => 'a:0:{}',
    'registration' => 'a:4:{s:5:"login";a:2:{i:0;i:3;i:1;b:1;}s:4:"pass";a:2:{i:0;i:3;i:1;b:1;}s:4:"name";a:2:{i:0;i:3;i:1;b:0;}s:5:"email";a:2:{i:0;i:3;i:1;b:0;}}',
    'authenticationPhase1' => 'a:1:{s:5:"login";a:2:{i:0;i:3;i:1;b:1;}}',
    'authenticationPhase2' => 'a:3:{s:5:"login";a:2:{i:0;i:3;i:1;b:1;}s:4:"pass";a:2:{i:0;i:3;i:1;b:1;}s:2:"rm";a:2:{i:0;i:1;i:1;b:0;}}',
    'logout' => 'a:0:{}',
  ),
  'links' =>array (
  ),
);
protected function &getDefinitionStruc(){return self::$_definition_struc;}
/*SRVDEF*/
    const LOGIN_UNKNOWN = 301;
    const ATTH_PHASE = 302;
    const INVALID_PASSWORD = 303;
    const ACCESS_DENIED = 304;
    const INVALID_PASSWORD_FORMAT = 305;
    const LOGIN_EXISTS = 306;
    const EMAIL_REQUIRED = 307;
    const INVALID_EMAIL_FORMAT = 308;
    const INVALID_LOGIN_FORMAT = 309;
    const DECRYPTION_ERROR = 310;
    
    const pass_regexp = '/^[a-zA-z0-9~!@#$%^&*()_+=[\]{}:?><-]{3,10}$/';
    const email_regexp = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/';
    const login_regexp = '/^[a-zA-z0-9_]{1,20}$/';
    protected $_user_rights = null;
    public $RSA_key_size = 256;
    function cast_value(&$val,$key){
        global $f;
        if(isset($f[$key])) if($f[$key][0]===1) $val = (int)$val;
    }
    protected function _fetch_rights_model($args){
        $p = $args['params'];
        $awhere = $params = array(); $where='';
        if(isset($p['idx']) && ($p['idx']>=0)) {$awhere[]='`idx`=?'; $params[]=$p['idx'];}
        if(isset($p['service'])&&($p['service']>=0)) {$awhere[]='`service`=?'; $params[]=$p['service'];}
        if(isset($p['model']) && $p['model']) {$awhere[]='`model`=?'; $params[]=$p['model'];}
        if(isset($p['group']) && ($p['group']>=0)) {$awhere[]='`group` IN (?)'; $params[]=$p['group'];}
        if ($awhere) $where = 'WHERE ('.join(') AND (', $awhere).')';
        $fields = $this->_getSQLFields($args['fields']);
        $limit = $this->_getSQLLimit($args['first'],$args['limit']);
        $sql = "SELECT $fields FROM {$this->table('rights')} AS t $where $limit";
        $r = $this->_exec($sql,$params);
        $rows = $r->fetchAll(PDO::FETCH_ASSOC);
        $this->_castResultTypes($rows, 'rights');
        return array('rows'=>$rows,'count'=>count($rows));
    }
    public function _insert_rights_model($args){
        $v = $args['values'];
        $tbl = $this->table('rights');
        $ff = array_keys($v);
        $f = '`'.join('`, `',$ff).'`';
        $cmd = "INSERT INTO $tbl ($f) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $this->_exec($cmd,  array_values($v));
    }
    public function _remove_rights_model($args){
        $p = array($args['index']);
        $tbl = $this->table('rights');
        $this->_exec("DELETE FROM $tbl WHERE idx=?", $p);
    }
    public function removeServiceRights($service){
        $this->_exec("DELETE FROM {$this->table('rights')} WHERE service=?", array($service));
    }
    public function _update_rights_model($args){
        $aset = $params = array();  
        foreach($args['values'] as $field=>$val){
            $params[] = $val;
            $aset[] = '`'.$field.'` = ?';
        }
        $params[] = $args['index'];
        $set = join(', ',$aset);
        $sql = "UPDATE {$this->table('rights')} SET $set WHERE idx=?";
        $this->_exec($sql, $params);
    }
    protected function _fetch_users_model($args){
        $p = $args['params'];
        if(isset($p['idx']) && $p['idx']===0){ //current user
            $uid = $this->project->user_id;
            if(!$uid) return array('rows'=>array(),'count'=>0);
            $p['idx'] = $uid;
        }
        $params = array();
        if(isset($p['idx']) && $p['idx']>0){ 
            $where = 'WHERE idx=?'; $params[]=$p['idx'];
        }
        else $where = '';
        $fields = $this->_getSQLFields($args['fields']);
        $limit = $this->_getSQLLimit($args['first'],$args['limit']);
        $sql = "SELECT $fields FROM {$this->table('users')} AS t $where $limit";
        $r = $this->_exec($sql,$params);
        $rows = $r->fetchAll(PDO::FETCH_ASSOC);
        return array('rows'=>$rows,'count'=>count($rows));
    }
    protected function _fetch_groups_model($args){
        $p = $args['params'];
        $params = array();
        if(isset($p['idx'])&&$p['idx']>0){ 
            $where = 'WHERE idx=?'; $params[]=$p['idx'];
        }
        else $where = '';
        $utbl = $this->table('groups');
        $fields = $this->_getSQLFields($args['fields']);
        $limit = $this->_getSQLLimit($args['first'],$args['limit']);
        $sql = "SELECT $fields FROM $utbl AS t $where $limit";
        $r = $this->_exec($sql,$params);
        $rows = $r->fetchAll(PDO::FETCH_ASSOC);
        return array('rows'=>$rows,'count'=>count($rows));
    }
    protected function authenticationPhase1($args){ //command
        $id = substr(uniqid(''),7);
        $table = $this->table('users');
        $sql = "UPDATE $table SET pub_key='$id' WHERE login=?";
        $cmd = $this->_exec($sql,array($args['login']));
        if($cmd->rowCount() === 0) self::error(self::LOGIN_UNKNOWN,$args['login']);
        $r = $this->_getRSAKeys();
        return array('id'=>$id,'key'=>$r['public']);
    }
    protected function authenticationPhase2($args){ //command
        list($pass,$id) = $this->getSHAPassword($args['pass']);
        $rm = isset($args['rm'])?$args['rm']:0;
        $table = $this->table('users');
        $this->db->beginTransaction();
        $sql = "SELECT idx,groups,name,password,pub_key FROM $table WHERE login=? AND active=1 FOR UPDATE";
        $cmd = $this->_exec($sql,array($args['login']));
        if($cmd->rowCount()!==0){
            $row = $cmd->fetch(PDO::FETCH_ASSOC);
            $sql = "UPDATE $table SET pub_key='' WHERE idx=?";
            $this->_exec($sql, array($row['idx']));
        }
        $this->db->commit();
        if($cmd->rowCount()===0) self::error(self::LOGIN_UNKNOWN,$args['login']);
        if(!$row['pub_key'] || $row['pub_key'] != $id) self::error(self::ATTH_PHASE);
        if($row['password']!==$pass) self::error(self::INVALID_PASSWORD);
        $this->startSession($row['idx'], $rm);
        unset($row['password'],$row['pub_key']);
        $this->setUpdateModel('users');
        return $row;
    }
    private function startSession($user_id,$rm=0){
        $sid = md5(uniqid(rand(0,100000)));
        $table = $this->table('sessions');
        $cmd = "INSERT INTO $table (idx,user_idx,ip,uagent,expire,last_active) VALUES ('$sid', :user_idx, :ip, :uagent, :expire, :last_active)";
        $this->_exec($cmd,array(
            ':user_idx'=>$user_id,
            ':ip'=>$_SERVER['REMOTE_ADDR'],
            ':uagent'=>$_SERVER['HTTP_USER_AGENT'],
            ':expire'=>date(self::SQL_DATE_FORMAT,time()+$this->ses_l_time*24*3600),
            ':last_active'=>date(self::SQL_DATE_FORMAT),
        ));
        $expiry = ($rm == 1)? time()+$this->ses_l_time*24*3600:0;
        $cookie_name = 'sid::'.$this->project->name;
        setcookie ($cookie_name, $sid,$expiry,'/');
        $_COOKIE[$cookie_name]=$sid;
    }
    protected function logout(){ //command
        $cookie_name = 'sid::'.$this->project->name;
        if(isset($_COOKIE[$cookie_name])){
            $sid = substr($_COOKIE[$cookie_name],0,32);
            $stbl = $this->table('sessions');
            $this->_exec("DELETE FROM $stbl WHERE idx=?", array($sid));
            setcookie ($cookie_name, '',time()-3600,'/');
            unset($_COOKIE[$cookie_name]);
        }
        return array();
    }
    protected function getPublicKey($args){ // command
        $r = $this->_getRSAKeys();
        return array('key'=>$r['public']);
    }
    protected function registration($args){ // command
        self::checkLogin($args['login']);
        list($pass,$id) = $this->getSHAPassword($args['pass']);
        $name = isset($args['name'])? $args['name']:$args['login'];
        $table = $this->table('users');
        $email = isset($args['email'])? $args['email']:'';
        $date = date(self::SQL_DATE_FORMAT);
        $active = ($this->regmode==='BASIC')?1:0;
        if($this->regmode==='E-MAIL'){
           if(!$email) self::error(self::EMAIL_REQUIRED);
           $key = uniqid('');
        }
        else $key='';
        if($email) self::checkEmail($email);
        $cmd = $this->db->prepare("INSERT INTO $table (login,password,name,email,regdate,active,pub_key) VALUES(?,?,?,?,?,?,?)");
        $r = $cmd->execute(array($args['login'],$pass,$name,$email,$date,$active,$key));
        if(!$r) {
            if($cmd->errorCode()==='23000') self::error(self::LOGIN_EXISTS,$args['login']);
            else $this->_dbError($cmd);
        }
        return;
    }
    private function getSHAPassword($enc_pass){
        TProject::loadLibraryFile('crypt','RSA.php');
        $rsa = new Crypt_RSA();
        $r = $this->_getRSAKeys();
        $p = base64_decode($enc_pass);
        if(!$p) self::error(self::INVALID_PASSWORD_FORMAT);
        try{
            $rsa->loadKey($r['private']);
            $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
            $fpass = $rsa->decrypt($p);
        }
        catch (Exception $e) {self::error(self::DECRYPTION_ERROR);}
        $apass = explode('|',$fpass);
        if(count($apass)!==2) self::error(self::INVALID_PASSWORD_FORMAT);
        $pass = $apass[0];
        self::checkPassword($pass);
        return array(sha1($pass),$apass[1]);
    }
    static function  checkPassword($pass){
        if(!preg_match(self::pass_regexp, $pass)) self::error(self::INVALID_PASSWORD_FORMAT);
    }
    static function checkEmail($email){
        if(!preg_match(self::email_regexp, $email)) self::error(self::INVALID_EMAIL_FORMAT);
    }
    static function checkLogin($login){
        if(!preg_match(self::login_regexp, $login)) self::error(self::INVALID_LOGIN_FORMAT);
    }
    private function _getRSAKeys(){
        if(!file_exists($this->path.'/rsakeys.ini')){
            TProject::loadLibraryFile('crypt','RSA.php');
            $rsa = new Crypt_RSA();
            $keys = $rsa->createKey($this->RSA_key_size);
            $ini ="private=\"{$keys['privatekey']}\"\npublic=\"{$keys['publickey']}\""; 
            if(!file_exists($this->path)) mkdir($this->path);
            file_put_contents($this->path.'/rsakeys.ini', $ini);
            return array('private'=>$keys['privatekey'],'public'=>$keys['publickey']);
        }
        else return parse_ini_file($this->path.'/rsakeys.ini');
    }
    public function getUserInfo(){
        $cookie_name = 'sid::'.$this->project->name;
        if(!isset($_COOKIE[$cookie_name])) return array(0,'','0');
        $sid = substr($_COOKIE[$cookie_name],0,32);
        $stbl = $this->table('sessions');
        $utbl = $this->table('users');
        $sql = "SELECT u.idx,u.name,u.groups,s.ip,s.uagent,UNIX_TIMESTAMP(s.expire) AS expire
            FROM $stbl AS s, $utbl AS u WHERE s.idx=? AND s.user_idx=u.idx";
        $cmd = $this->_exec($sql,array($sid));
        if($cmd->rowCount()===0) array(0,'','0');
        $row = $cmd->fetch();
        if(($this->check_ip && ($row['ip']!==$_SERVER['REMOTE_ADDR']))||
        ($row['uagent']!==$_SERVER['HTTP_USER_AGENT'])||($row['expire']<time())){
            $this->logout();
            return array(0,'','0');
        }
        if(rand(0,10000)<2) $this->_exec("DELETE FROM {$this->table('sessions')} WHERE expire<=now()?");
        unset($row['ip'],$row['uagent'],$row['expire']);
        return array_values($row);
    }
    public function testCoreRights($service,$model,$command=null,$arg=null,$isOwnerFunc=null){
        switch($this->security){
            case 'on': {
                if($command) return $this->_testModelCommand($service,$model,$command,$arg,$isOwnerFunc);
                else return $this->_testServiceCommand($service,$model);
            }
            case 'training':{
                if($command)  return $this->_trainingModelCommand($service,$model,$command,$arg,$isOwnerFunc);
                else return $this->_trainingServiceCommand($service,$model);
            }
        }
        return false;
    }
    private function _testServiceCommand($service,$command){
        if($service==$this->id && in_array($command, array('authenticatePhase1','authenticatePhase2','logout'))) return false;
        $rights = $this->_getUserRights($service,$command);
        if($rights===false) return false;
        if($rights['insert-group']==0) self::error(self::ACCESS_DENIED,'service',$command);
        return true;
    }
    private function _trainingServiceCommand($service,$command){
        if($service==$this->id && in_array($command, array('authenticatePhase1','authenticatePhase2','logout'))) return false;
        if(($g = $this->_getGroup()) === false) return false;
        $this->db->beginTransaction();
        $this-> _saveInsertRights($g,$command,$service);
        $this->db->commit();
        return false;
    }
    private function _testModelCommand($service,$model,$command,$arg=null,$isOwnerFunc=null){
        $rights = $this->_getUserRights($service,$model);
        if($rights===false) return false;
        switch ($command){
            case 'fetch':{
                $allowed = array_filter(explode(',',$rights['fetch-group']));
                if(array_diff($arg['fields'], $allowed)) self::error(self::ACCESS_DENIED,$model,'fetch');
                return true;
            }
            case 'insert':{
                if($rights['insert-group']==0) self::error(self::ACCESS_DENIED,$model,'insert');
                return true;
            }    
            case 'update': {
                $fields = array_keys($arg['values']);
                $allowed = array_filter(explode(',',$rights['update-group']));
                if(array_diff($fields, $allowed)) self::error(self::ACCESS_DENIED,$model,'update');
                $owners = array_filter(explode(',',$rights['update-owner']));
                if(!$owners || !array_intersect($fields, $owners)) return true;
                if($isOwnerFunc[0]->$isOwnerFunc[1]($arg['index'])) return true;
                self::error(self::ACCESS_DENIED,$model,'update');
            }
            case 'remove': {
                if($rights['remove-group']==0) self::error(self::ACCESS_DENIED,$model,'remove');
                if(($rights['remove-owner']==0)||$isOwnerFunc[0]->$isOwnerFunc[1]($arg['index'])) return true;
                self::error(self::ACCESS_DENIED,$model,'remove');
            }
        }
    }
    private function _trainingModelCommand($service,$model,$command,$arg=null,$isOwnerFunc=null){
            if(($g = $this->_getGroup()) === false) return true;
            $trights = $this->table('rights');
            $this->db->beginTransaction();
            switch ($command){
                case 'fetch':{
                    $sql = "SELECT `idx`,`fetch-group` FROM $trights WHERE `group`=? AND `model`=? AND `service`=? FOR UPDATE";
                    $r = $this->_exec($sql, array($g,$model,$service));
                    if($rrow = $r->fetch()){
                        //Корректируем существующие права
                        $old_f = array_filter(explode(',',$rrow['fetch-group']));
                        $new_f = array_diff($arg['fields'],$old_f);
                        if($new_f){
                            //Есть новые поля. Дописываем их в таблицу прав
                            $sql = "UPDATE $trights SET `fetch-group`=? WHERE idx=?";
                            $this->_exec($sql, array(join(',',array_merge($old_f,$new_f)),$rrow['idx']));
                        }
                    }
                    else{
                        //Нет строки. Добавляем её
                        $sql = "INSERT INTO $trights (`group`, `model`, `service`, `fetch-group`) VALUES (?,?,?,?)";
                        $this->_exec($sql, array($g,$model,$service,join(',',$arg['fields'])));
                    }
                    break;
                }
                case 'insert':{
                    $this-> _saveInsertRights($g,$model,$service);
                    break;
                }    
                case 'update': {
                    $sql = "SELECT `idx`,`update-group`,`update-owner` FROM $trights WHERE `group`=? AND `model`=? AND `service`=? FOR UPDATE";
                    $r = $this->_exec($sql, array($g,$model,$service));
                    $own  = $isOwnerFunc[0]->$isOwnerFunc[1]($arg['index'],true);
                    $fields = array_keys($arg['values']);
                    if($rrow = $r->fetch()){
                        //Корректируем существующие права
                        $old_group = array_filter(explode(',',$rrow['update-group']));
                        $old_owner = array_filter(explode(',',$rrow['update-owner']));
                        $new_f = array_diff($fields,$old_group);
                        $new_group = array_merge($old_group,$new_f);
                        $new_owner = $own? array_merge($old_owner,$new_f):array_diff($old_owner,$fields);
                        if(($old_group!=$new_group)||($old_owner!=$new_owner)){
                            //Есть новые поля. Дописываем их в таблицу прав
                            $sql = "UPDATE $trights SET `update-group`=?,`update-owner`=? WHERE idx=?";
                            $this->_exec($sql, array(join(',',$new_group),join(',',$new_owner),$rrow['idx']));
                        }
                    }
                    else{
                        //Нет строки. Добавляем её
                        $group = join(',',$fields);
                        $owner = $own? $group:'';
                        $sql = "INSERT INTO $trights (`group`, `model`, `service`, `update-group`, `update-owner`) VALUES (?,?,?,?,?)";
                        $this->_exec($sql, array($g,$model,$service,$group,$owner));
                    }
                    break;
                }
                case 'remove': {
                    $sql = "SELECT `idx`,`remove-group`,`remove-owner` FROM $trights WHERE `group`=? AND `model`=? AND `service`=? FOR UPDATE";
                    $r = $this->_exec($sql, array($g,$model,$service));
                    $own  = $isOwnerFunc[0]->$isOwnerFunc[1]($arg['index'],true)? 1:0;
                    if($rrow = $r->fetch()){
                        if($rrow['remove-group'] && $own) break;
                        if(($rrow['remove-group']==0) || ($rrow['remove-owner']!=$own)) {
                            $sql = "UPDATE $trights SET `remove-group`=1,`remove-owner`=? WHERE idx=?";
                            $this->_exec($sql, array($own,$rrow['idx']));
                        }
                    }
                    else{
                        $sql = "INSERT INTO $trights (`group`, `model`, `service`, `remove-group`, `remove-owner`) VALUES (?,?,?,1,?)";
                        $this->_exec($sql, array($g,$model,$service,$own));
                    }
                }
            }
            $this->db->commit();
            return false;
    }
    private function _saveInsertRights($g,$model,$service){
        $trights = $this->table('rights');
        $sql = "SELECT `idx`,`insert-group` FROM $trights WHERE `group`=? AND `model`=? AND `service`=? FOR UPDATE";
        $r = $this->_exec($sql, array($g,$model,$service));
        if($rrow = $r->fetch()){
            if(!$rrow['insert-group']){
                $sql = "UPDATE $trights SET `insert-group`=1 WHERE idx=?";
                $this->_exec($sql, array($rrow['idx']));
            }
        }
        else{
            $sql = "INSERT INTO $trights (`group`, `model`, `service`, `insert-group`) VALUES (?,?,?,1)";
            $this->_exec($sql, array($g,$model,$service));
        }
    }
    private function _getGroup(){
        $ga = explode(',',$this->project->user_groups);
        if(in_array(1, $ga)) return false;
        if (count($ga)>1) $ga = array_diff($ga,array(1)); 
        if (count($ga)>1) return false;
        return $ga[0];
    }
    protected function _getUserRights($service,$model){
        if($this->_user_rights === null){
            $groups = $this->project->user_groups;
            $ga = explode(',',$groups);
            if(in_array(1, $ga)) return $this->_user_rights = false;
            $params = array('group'=>$groups, 'model'=>$model, 'service'=>$service, 'idx'=>-1); 
            $this->args = array('params'=>$params,'fields'=>array(),'limit'=>0,'first'=>0,'count'=>0); 
            $r = $this->_fetch_rights_model($this->args);
            $rows = $r['rows'];
            $this->_user_rights = isset($rows[0])?$rows[0]:array(
                'fetch-group'=>'',
                'fetch-owner'=>'',
                'update-group'=>'',
                'update-owner'=>'',
                'remove-group'=>0,
                'remove-owner'=>0,
                'insert-group'=>0
            );
            if(count($rows)>1){
                for($i=1; $i<count($rows); $i++){
                    $rr = $rows[$i];
                    self::_concat($this->_user_rights['fetch-group'],$rr['fetch-group']);
                    self::_concat($this->_user_rights['fetch-owner'],$rr['fetch-owner']);
                    self::_concat($this->_user_rights['update-group'],$rr['update-group']);
                    self::_concat($this->_user_rights['update-owner'],$rr['update-owner']);
                    $this->_user_rights['remove-group'] += $rr['remove-group'];
                    $this->_user_rights['remove-owner'] += $rr['remove-owner'];
                    $this->_user_rights['insert-group'] += $rr['insert-group'];
                }
            }
        }
        return $this->_user_rights;
    }
    static private function _concat(&$str1,$str2){
        if (!$str2) return;
        $str1 = ($str1)? $str1.','.$str2:$str2;
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::LOGIN_UNKNOWN: {$msg = "User with login '$args[1]' not found";break;}
            case self::ATTH_PHASE: {$msg = "Authentication phase 1 must be passed before";break;}
            case self::INVALID_PASSWORD: {$msg = "Invalid password";break;}
            case self::ACCESS_DENIED: {$msg = 'Access denied to "'.$args[2].'" command of "'.$args[1].'"'; break;}
            case self::LOGIN_EXISTS: {$msg = 'Login "'.$args[1].'" already exists'; break;}
            case self::EMAIL_REQUIRED: {$msg = 'Email required for "E-MAIL" registration mode'; break;}
            case self::INVALID_PASSWORD_FORMAT: {$msg = 'Invalid password format. Password must match next regilar expression: '.self::pass_regexp; break;}
            case self::INVALID_EMAIL_FORMAT: {$msg = 'Invalid e-mail format. E-mail must match next regilar expression: '.self::email_regexp; break;}
            case self::INVALID_LOGIN_FORMAT: {$msg = 'Invalid login format. Login must match next regilar expression: '.self::login_regexp; break;}
            case self::DECRYPTION_ERROR: {$msg = 'Decryption error'; break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>
