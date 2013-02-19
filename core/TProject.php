<?php
class TProject{
    const ID_NOT_FOUND = 10;
    const INVALID_CMP_NAME = 11;
    const CMP_NOT_EXISTS = 12;
    const AS_NOT_FOUND = 13;
    const PROJECT_VAR_NOT_FOUND = 14;
    
    public $db;
    public $name;
    public $changed = false;
    public $path;
    private $_vars;
    private $_file;
    private $_comp_id = array(); //Ассоциативный массив компонентв с ключами-id
    private $_comp_name = array(); //Ассоциативный массив компонентв с ключами-name
    private $_events = array(); //Обработчики событий {event:[[object,method]]}
    
    function __construct($project){
        $this->path = $_SERVER['DOCUMENT_ROOT'].'/projects/'.$project;
        $file = $this->path.'/projectdb.php';
        $this->name = $project;
        $this->_file = $file;
        if (file_exists($file)){
            $this->_loadFromPHP($file);
        }
        else $this->db = array('components'=>array(),'names'=>array(),'classes'=>array());
    }
    function __get($name) {
        switch ($name){
            case 'user_name': $this->_readUserData(); return $this->user_name; 
            case 'user_id':$this->_readUserData(); return $this->user_id;
            case 'user_groups':$this->_readUserData(); return $this->user_groups;
        };
    }
    private function _readUserData(){
        if(!$this->isComponentExists('TAccountService')) self::_error(self::AS_NOT_FOUND); 
        $as = $this->getByName('TAccountService');
        $r = $as->getUserInfo();
        list($this->user_id,$this->user_name,$this->user_groups) = $as->getUserInfo();
    }
    function __destruct(){
        if ($this->changed) $this->_saveAsPHP();
    }
    private function _loadFromPHP($file){
        $str = file_get_contents($file);
        $str = substr($str,2,strlen($str)-4);
        $evalstr = '$this->db = '.trim($str).';';
        eval($evalstr);
    }
    private function _saveAsPHP(){
        $str = var_export($this->db,true);
        $str = preg_replace('/=>\\s*\\n\\s*/','=>',$str);
        $str = "<?\n".$str."\n?>";
        file_put_contents($this->_file,$str);
    }
    public function getById($id){
        if (isset($this->_comp_id[$id])) return $this->_comp_id[$id];
        $c = TComponent::loadFromDB($this,$id);
        $this->_comp_name[$c->name] = &$c;
        $this->_comp_id[$id] = &$c;
        return $c;
    }
    public function getByName($name){
        if(!isset($this->_comp_name[$name])){
            if(jq::$page) self::_error(self::CMP_NOT_EXISTS,$name);
            if(!isset($this->db['names'][$name])) self::_error(self::INVALID_CMP_NAME,$name);
            $id = (integer)$this->db['names'][$name];
            $c = TComponent::loadFromDB($this,$id);
            $this->_comp_name[$name] = &$c;
            $this->_comp_id[$id] = &$c;
        }
        return $this->_comp_name[$name];
    }
    public function getNameById($id){
        if(!isset($this->db['components'][$id])) self::_error(self::ID_NOT_FOUND,$id);
        return $this->db['components'][$id]['n'];
    }
    public function &getAllComponents(){return $this->_comp_id;}
    public function isComponentExists($cmp){
       if (is_string($cmp)) return isset($this->db['names'][$cmp]);
       elseif(is_integer($cmp)) return isset($this->db['components'][$cmp]);
       else return false;
    }
    public function getProjectVar($name){
       if(!isset($this->_vars)){
           $varfile = $this->path.'/project.ini';
           if(!file_exists($varfile)) $this->_vars = false;
           else $this->_vars = parse_ini_file ($varfile);
       }
       if(!$this->_vars || !isset($this->_vars[$name])) self::_error(self::PROJECT_VAR_NOT_FOUND,$name,$this->name);
       return $this->_vars[$name];
    }
    private static function _error(){
        $a = func_get_args();
        $code = $a[0];
        switch ($code){
            case self::ID_NOT_FOUND: {$msg = "Component with id '$a[1]' does not exist"; break;}
            case self::INVALID_CMP_NAME: {$msg = "Invalid component name: $a[1]"; break;}
            case self::CMP_NOT_EXISTS: {$msg = "Component '$a[1]' is not exists in the page."; break;}
            case self::AS_NOT_FOUND:{$msg = 'You must have a TAccountService component in your project to menage users data'; break;}
            case self::PROJECT_VAR_NOT_FOUND:{$msg = 'You must define variable "'.$a[1].'" in project.ini for "'.$a[2].'" project'; break;}
            default: $msg = 'Unknown error';
        }
        throw new Exception($msg,$code);
    }
    public function registerEventHandler($event,$object,$method){
        $this->_events[$event][] = array($object,$method);
    }
    public function event($event,$args=null){
        if(isset($this->_events[$event]))
            foreach($this->_events[$event] as $h){
                call_user_func($h,$args);
            }
    }
    public static function getLibraryPath($lib){
       return (in_array($lib,array('crypt'))? '/core/lib/':'/lib/').$lib;
    }
    public static function loadLibraryFile($lib,$file){
        $path = self::getLibraryPath($lib);
        require_once "{$_SERVER['DOCUMENT_ROOT']}$path/server/$file";
    }
}
function __autoload($class) {
    $path = TComponent::getPalettePath($class);
    require ($path.'/'.$class.'.php');
}
function isOwner($id) {return $id === jq::$project->user_id;}
function isAdmin() {
    static $_is_admin;
    if($_is_admin!==null) return $_is_admin;
    $ug = explode(',',jq::$project->user_groups);
    return $_is_admin = in_array(1,$ug);
}
function isMemberOf($g) {
    static $_is_member_of;
    if($_is_member_of!==null) return $_is_member_of;
    $ug = explode(',',jq::$project->user_groups);
    return $_is_member_of = (boolean)array_intersect($g,$ug);
}