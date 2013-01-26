<?php
class TForumService extends TDBService{
/*SRVDEF*/
private static $_definition_struc = array (
  'models' =>array (
    'topics' =>array (
      'p' => 'a:1:{s:3:"idx";a:2:{i:0;i:1;i:1;b:0;}}',
      'i' => 'a:3:{s:5:"title";a:2:{i:0;i:3;i:1;b:0;}s:5:"descr";a:2:{i:0;i:3;i:1;b:0;}s:7:"visible";a:2:{i:0;i:1;i:1;b:0;}}',
      'u' => 'a:5:{s:5:"owner";a:2:{i:0;i:1;i:1;b:0;}s:4:"date";a:2:{i:0;i:3;i:1;b:0;}s:5:"title";a:2:{i:0;i:3;i:1;b:0;}s:5:"descr";a:2:{i:0;i:3;i:1;b:0;}s:7:"visible";a:2:{i:0;i:1;i:1;b:0;}}',
      'f' => 'a:6:{s:3:"idx";i:1;s:5:"owner";i:1;s:4:"date";i:3;s:5:"title";i:3;s:5:"descr";i:3;s:7:"visible";i:1;}',
      'owner' => true,
    ),
  ),
  'commands' =>array (
  ),
  'links' =>array (
    'topics' =>array (
      'owner' => 'link_owner',
    ),
  ),
);
protected function &getDefinitionStruc(){return self::$_definition_struc;}
/*SRVDEF*/
    const USER_REQUIRED = 301;

    public function _fetch_topics_model($args){
        $this->_getSQLWhere($args, array('idx'), $where, $params);
        $r = $this->_fetchTableModel($args, 'topics', $where, $params);
        return $r;
    }
    public function _insert_topics_model($args){
        $v = $args['values'];
        $uidx = $this->project->user_id;
        if($uidx == 0) self::error(self::USER_REQUIRED);
        $v['owner'] = $uidx;
        $this->_insertTableModel($v, 'topics');
    }
    public function _remove_topics_model($args){
        $this->_removeTableModel($args['index'], 'topics');
    }
    public function _update_topics_model($args){
        $this->_updateTableModel($args['values'], $args['index'], 'topics');
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::USER_REQUIRED: {$msg = "Authorization required";break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>