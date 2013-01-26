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
    'authenticatePhase2' => 'a:3:{s:5:"login";a:2:{i:0;i:3;i:1;b:1;}s:4:"pass";a:2:{i:0;i:3;i:1;b:1;}s:2:"rm";a:2:{i:0;i:1;i:1;b:0;}}',
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
    
    protected $_user_rights = null;
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
    protected function authenticatePhase2($args){
        $table = $this->table('users');
        $sql = "SELECT idx,groups,name,password,pub_key FROM $table WHERE login=? AND active=1";
        $cmd = $this->_exec($sql,array($args['login']));
        if($cmd->rowCount()===0) self::error(self::LOGIN_UNKNOWN,$args['login']);
        $row = $cmd->fetch(PDO::FETCH_ASSOC);
        if(!$row['pub_key']) self::error(self::ATTH_PHASE);
        $db_pass = md5($row['password'].$row['pub_key']);
        if($db_pass !== $args['pass']) self::error(self::INVALID_PASSWORD);
        // Session initialization
        $sid = md5(uniqid(rand(0,100000)));
        $table = $this->table('sessions');
        $cmd = "INSERT INTO $table (idx,user_idx,ip,uagent,expire,last_active)
          VALUES ('$sid', :user_idx, :ip, :uagent, :expire, :last_active)";
        $this->_exec($cmd,array(
            ':user_idx'=>$row['idx'],
            ':ip'=>$_SERVER['REMOTE_ADDR'],
            ':uagent'=>$_SERVER['HTTP_USER_AGENT'],
            ':expire'=>date(self::SQL_DATE_FORMAT,time()+$this->ses_l_time*24*3600),
            ':last_active'=>date(self::SQL_DATE_FORMAT),
        ));
        $this->setCookies($sid,$args['rm']);
        unset($row['password'],$row['pub_key']);
        $this->setUpdateModel('users');
        return $row;
    }
    protected function logout(){
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
    protected function authenticatePhase1($args){
        $id = uniqid('');
        $table = $this->table('users');
        $sql = "UPDATE $table SET pub_key='$id' WHERE login=?";
        $cmd = $this->_exec($sql,array($args['login']));
        if($cmd->rowCount() === 0) self::error(self::LOGIN_UNKNOWN,$args['login']);
        return array('pub_key'=>$id);
    }
    private function setCookies($sid,$rm){
        $expiry = ($rm == 1)? time()+$this->ses_l_time*24*3600:0;
        $cookie_name = 'sid::'.$this->project->name;
        setcookie ($cookie_name, $sid,$expiry,'/');
        $_COOKIE[$cookie_name]=$sid;
    }
    public function createTable($name){
        parent::createTable($name);
        $table = $this->table($name);
        switch ($name){
            case 'users' :{
                $pass = md5('admin');
                $date = date(self::SQL_DATE_FORMAT);
                $sql = "INSERT INTO $table (login,password,name,regdate,groups,active) VALUES("
                    ."'admin','$pass', 'Administrator', '$date', '1',1"
                .')';
                $this->db->exec($sql);
                break;
            }
            case 'groups' :{
                $sql = "INSERT INTO $table (name,descr) VALUES"
                    ."('admins', 'Administrators'),('users', 'Regular users'),('banned', 'Banned users')";
                $this->db->exec($sql);
                break;
            }
        }
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
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>
