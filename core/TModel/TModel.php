<?php
class TModel extends TComponent implements ICommandServer{
    const NOT_MODIFIED = 100;
    const SERVICE_NOT_FOUND = 102;
    const FIELD_NOT_EXISTS = 103;
    const METHOD_UNSUPPORT = 104;
    const ARGUMENT_REQUIRED = 105;
    const PARAMETER_REQUIRED = 107;
    const FIELD_REQUIRED = 109;
    const FIELD_NOT_UPDATIBLE = 110;
    // Fetch mode constants
    const FETCH_NORMAL = 0;
    const FETCH_IF_UPDATED = 1;

    public $curent = 0;
    public $service;    //External
    public $model;      //External
    public $params = array(); //External
    public $fields = array(); //External
    public $first = 0; //External
    public $limit = 0; //External
    public $import = 'none';
    public $calcfields = '';

    private static $_ccf = null;
    private static $_cfields = null;
    private static $_ex_fields = null;
    private $_owned_model = null;

    protected $client_fields = array('first','limit','params');
    function __get($prpname){
        switch ($prpname) {
            case 'rows':{
                $r = $this->_fetchData();
                $this->rows = $r['rows'];
                $this->count = $r['count'];
                return $this->rows;
            }
            case 'count':{
                $r = $this->_fetchData();
                $this->rows = $r['rows'];
                $this->count = $r['count'];
                return $this->count;
            }
            case 'srv':{
                $this->srv=$this->project->getByName($this->service);
                if (!is_subclass_of($this->srv,'TService')) self::error(self::SERVICE_NOT_FOUND,$this->service);
                return $this->srv;
            }
            default: self::error(self::UNKNOWN_PROPERTY,$prpname);
        }
    }
    private static function _registerCField($m){
        self::$_cfields[] = $m[1];
        return '$row[\''.$m[1].'\']';
    }
    private function _fetchData($arg = null) {
       if ($this->service) {
            if($arg===null) $arg = array('params'=>$this->params,'first'=>$this->first,'limit'=>$this->limit,'fields'=>$this->fields);
            $this->srv->checkTypes($this->model,$arg['params'],CHECK_FETCH_PARAMS);
            if($this->calcfields){
                self::$_cfields = array();
                self::$_ccf = preg_replace_callback('/#(\w+)/', array(__CLASS__,'_registerCField'), $this->calcfields);
                if(self::$_cfields) self::$_ex_fields = array_diff(array_unique(self::$_cfields), $arg['fields']);
                if(self::$_ex_fields) $arg['fields'] = array_merge ($arg['fields'],self::$_ex_fields);
            }
            else self::$_ccf = false;
            $r =  $this->srv->queryModel($this->model,'fetch',$arg);
            if ($r['rows'] && self::$_ccf)  $this->addCalculatedFields($r['rows']);
            return $r;
        }
        else return array('rows'=>array(),'count'=>0);
    }
    private static function addCalculatedFields(&$rows){
        if(preg_match_all('/^\s*(\w+)\s*=\s*(.+)\s*$/m',self::$_ccf,$m,PREG_SET_ORDER)>0){
            $exprs = array();
            if($remove_ex = (boolean)self::$_ex_fields) $ex = array_flip(self::$_ex_fields);
            foreach($m as $f) $exprs[$f[1]] = 'return '.$f[2].';';
            foreach($rows as &$row){
                foreach($exprs as $field=>$expr){
                    $row[$field] = eval($expr);
                }
                if($remove_ex) $row = array_diff_key($row, $ex); 
            }
        }
    }
    protected function isClientInstance(){return $this->import!=='none';}
    protected function _getPrpDefinition($lvl){
        try{
            $r = parent::_getPrpDefinition($lvl);
            if($this->import === 'data'){
                $r.= ",\n".str_repeat('    ',$lvl)."    rows:".self::jsonEncode($this->rows);
                $r.= ",\n".str_repeat('    ',$lvl)."    count:".$this->count;
            }
        }
        catch(Exception $e){return "/*ERROR: ".$e->getMessage().'*/';}
        return $r;
    }
    /**
     * Обработка команд, получаемых от клиента
     * @param string $cmd Имя комадны ('fetch', 'insert', 'update' или  'remove'). 
     * @param array $arg Ассоциативный массив аргументов
     * @return array Содержание зависит от команды
     */
    public function run($cmd,$arg){
        switch($cmd){
            case 'fetch': {
                if(isset($arg['mode']) && ($arg['mode']===self::FETCH_IF_UPDATED) && !$this->srv->isModelUpdated($this->model)) self::error(self::NOT_MODIFIED);
                $arg['fields'] = $this->fields;
        //        $this->srv->checkTypes($this->model,$arg['params'],CHECK_FETCH_PARAMS);
                $this->_testRights($cmd, $arg);
                return $this->_fetchData($arg);
            }
            case 'insert': {
                if(!isset($arg['values'])) self::error(self::ARGUMENT_REQUIRED,'values');
                $this->srv->checkTypes($this->model,$arg['values'],CHECK_INSERT_FIELDS);
                $this->_testRights($cmd, $arg);
                $this->srv->queryModel($this->model,$cmd,$arg);
                return array();
            }
            case 'update': {
                try{
                    if (!isset($arg['index'])) self::error(self::ARGUMENT_REQUIRED,'index');
                    if (!isset($arg['values'])) self::error(self::ARGUMENT_REQUIRED,'values');
                    if (!isset($arg['id'])) self::error(self::ARGUMENT_REQUIRED,'id');
                    $this->srv->checkTypes($this->model,$arg['values'],CHECK_UPDATE_FIELDS);
                    $this->_testRights($cmd,$arg,array($this,'isOwnersRecord'));
                    $this->srv->queryModel($this->model,$cmd,$arg);
                }
                catch(Exception $e){
                    return array('status'=>$e->getCode(), 'errortext'=>$e->getMessage(),'id'=>$arg['id']);
                }
                return array('id'=>$arg['id']);
            }
            case 'remove': {
                if (!isset($arg['index'])) self::error(self::ARGUMENT_REQUIRED,'index');
                $this->_testRights($cmd,$arg,array($this,'isOwnersRecord'));
                $this->srv->queryModel($this->model,$cmd,$arg);
                return array();
            }
            default: self::error(self::METHOD_UNSUPPORT,$this->model,$cmd);
        }
    }
    private function _testRights($cmd,$arg,$isOwnerFunc=null){
        if($this->project->isComponentExists('TAccountService')){
            $acs = $this->project->getByName('TAccountService'); 
            $r = $acs->testCoreRights($this->srv->id,$this->model,$cmd,$arg,$isOwnerFunc);
            if($r) $this->srv->testServiceRights();
        }
    }
    /*
    private function _testFetchParams(&$p){
        $needs = $this->srv->getFetchParams(get_class($this->srv),array('required','value','type','name'), $this->model);
        $a = array();
        foreach ($needs as $need){
           $name = $need['name'];
           if($need['required']){
               if(!isset($p[$name])) self::error(self::PARAMETER_REQUIRED,$this->model,$name);
               $a[$name] = $p[$name];
           }
           else $a[$name] = isset($p[$name])? $p[$name]:$need['value'];
           TService::checkType($need['type'],$name,$a[$name]);
        }
        $p = $a;
    }
    private function _testInsertValues(&$v){
        $needs = $this->srv->getFields(get_class($this->srv),array('insert','value','type','name'), $this->model,2);
        $a = array();
        foreach ($needs as $need){
            $name = $need['name'];
            if($need['insert']>1){
                 if(!isset($v[$name])) self::error(self::FIELD_REQUIRED,$this->model,$name);
                 $a[$name] = $v[$name];
            }
            else $a[$name] = isset($v[$name])? $v[$name]:$need['value'];
            TService::checkType($need['type'],$name,$a[$name]);
        }
        $v = $a;
    }
    private function _testUpdateFields($v) {
        $needs = $this->srv->getFields(get_class($this->srv),array('type'), $this->model,3);
        foreach ($v as $name=>&$value){
            $idx = $this->model.'.'.$name;
            if(!isset($needs[$idx])) self::error(self::FIELD_NOT_UPDATIBLE,$name,$this->model);
            TService::checkType($needs[$idx]['type'],$name,$value);
        }
    }
     * 
     */
    public function isOwnersRecord($idx,$check_owned_model=false){
        if($check_owned_model){
            if($this->_owned_model === null) $this->_owned_model = $this->srv->isOwnedModel($this->model);
            if(!$this->_owned_model) return false;
        }
        $arg = array('params'=>array('idx'=>$idx),'first'=>0,'limit'=>0,'fields'=>array('owner'));
        $user = $this->project->user_id;
        $r = $this->srv->queryModel($this->model,'fetch',$arg);
        return isset($r['rows'][0]) && ($r['rows'][0]['owner'] == $user);
    }
    /**
     * Возвращает значение заданного поля текущей записи модели. Используется шаблонами компонентов.
     * @param string $name Имя поля
     * @return mixed Значение поля
     */
    public function getField($name) {
        $rows = $this->rows;
        if (!isset($rows[$this->curent][$name])) self::error(self::FIELD_NOT_EXISTS,$name,$this->name);
        return $rows[$this->curent][$name];
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::SERVICE_NOT_FOUND: {$msg = 'Service component not found: '.$args[1]; break;}
            case self::FIELD_NOT_EXISTS: {$msg = 'Field "'.$args[1].'" is not exists in model "'.$args[2].'"'; break;}
            case self::METHOD_UNSUPPORT: {$msg = $args[2].'is not supported for "'.$args[1].'" model' ;break;}
            case self::ARGUMENT_REQUIRED: {$msg = 'Argument "'.$args[1].'" required' ;break;}
            case self::PARAMETER_REQUIRED: {$msg = 'Parameter "'.$args[2].'" required for model "'.$args[1].'" fetching' ;break;}
            case self::FIELD_REQUIRED: {$msg = 'Field "'.$args[2].'" required to insert data in model "'.$args[1].'"' ;break;}
            case self::FIELD_NOT_UPDATIBLE: {$msg = 'Field "'.$args[1].'" of model "'.$args[2].'" is not updatible' ;break;}
            case self::NOT_MODIFIED: {$msg = 'Not modified' ;break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>
