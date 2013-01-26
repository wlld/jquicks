<?php
class TDiscussService extends TDBService{
/*SRVDEF*/
private static $_definition_struc = array (
  'models' =>array (
    'messages' =>array (
      'p' => 'a:4:{s:3:"idx";a:2:{i:0;i:1;i:1;b:0;}s:7:"subject";a:2:{i:0;i:1;i:1;b:0;}s:7:"filters";a:2:{i:0;i:3;i:1;b:0;}s:5:"order";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:5:{s:7:"subject";a:2:{i:0;i:1;i:1;b:0;}s:5:"title";a:2:{i:0;i:3;i:1;b:0;}s:4:"text";a:2:{i:0;i:3;i:1;b:0;}s:6:"parent";a:2:{i:0;i:1;i:1;b:0;}s:7:"visible";a:2:{i:0;i:1;i:1;b:0;}}',
      'u' => 'a:8:{s:7:"subject";a:2:{i:0;i:1;i:1;b:0;}s:5:"owner";a:2:{i:0;i:1;i:1;b:0;}s:4:"date";a:2:{i:0;i:3;i:1;b:0;}s:5:"title";a:2:{i:0;i:3;i:1;b:0;}s:4:"text";a:2:{i:0;i:3;i:1;b:0;}s:6:"parent";a:2:{i:0;i:1;i:1;b:0;}s:7:"visible";a:2:{i:0;i:1;i:1;b:0;}s:2:"ip";a:2:{i:0;i:3;i:1;b:0;}}',
      'f' => 'a:9:{s:3:"idx";i:1;s:7:"subject";i:1;s:5:"owner";i:1;s:4:"date";i:3;s:5:"title";i:3;s:4:"text";i:3;s:6:"parent";i:1;s:7:"visible";i:1;s:2:"ip";i:3;}',
      'owner' => true,
    ),
  ),
  'commands' =>array (
  ),
  'links' =>array (
    'messages' =>array (
      'subject' => 'link_subject',
      'owner' => 'link_owner',
    ),
  ),
);
protected function &getDefinitionStruc(){return self::$_definition_struc;}
/*SRVDEF*/
    const ACCOUNT_SRV_REQUIRED = 300;
    const USER_REQUIRED = 301;
    const SQL_DATE_FORMAT = 'Y-m-d h:i:s';

    public $auth_required = false; //Внешнее свойство. Принимать сообщения только от авторизованных пользователей
    public function _fetch_messages_model($args){
        $this->_getSQLWhere($args, array('idx','subject'), $where, $params);
        $r = $this->_fetchTableModel($args, 'messages', $where, $params);
        return $r;
    }
    public function _insert_messages_model($args){
        $v = $args['values'];
        $uidx = $this->project->user_id;
        if(($uidx == 0) && $this->auth_required) self::error(self::USER_REQUIRED);
        $v['owner'] = $uidx;
        $v['date'] = date(self::SQL_DATE_FORMAT,time());
        $v['ip'] =$_SERVER['REMOTE_ADDR'];
        $this->_insertTableModel($v, 'messages');
    }
    public function _remove_messages_model($args){
        $this->_removeTableModel($args['index'], 'messages');
    }
    public function _update_messages_model($args){
        $this->_updateTableModel($args['values'], $args['index'], 'messages');
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::DBERROR: {$msg = 'Database error: '.$args[1] ;break;}
            case self::ACCOUNT_SRV_REQUIRED: {$msg = 'Account service must be defined';break;}
            case self::USER_REQUIRED: {$msg = "Authorization required";break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>