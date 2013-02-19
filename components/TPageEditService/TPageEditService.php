<?php
class TPageEditService extends TService{
/*SRVDEF*/
private static $_definition_struc = array (
  'models' =>array (
    'page' =>array (
      'p' => 'a:2:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:4:"page";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:3:{s:4:"name";a:2:{i:0;i:3;i:1;b:1;}s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:6:"params";a:2:{i:0;i:3;i:1;b:0;}}',
      'u' => 'a:3:{s:2:"js";a:2:{i:0;i:3;i:1;b:0;}s:3:"php";a:2:{i:0;i:3;i:1;b:0;}s:6:"params";a:2:{i:0;i:3;i:1;b:0;}}',
      'f' => 'a:6:{s:3:"idx";i:1;s:2:"js";i:3;s:3:"php";i:3;s:4:"tree";i:3;s:4:"name";i:3;s:6:"params";i:3;}',
      'owner' => false,
    ),
    'component' =>array (
      'p' => 'a:7:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:4:"page";a:2:{i:0;i:3;i:1;b:1;}s:4:"type";a:2:{i:0;i:3;i:1;b:0;}s:9:"component";a:2:{i:0;i:1;i:1;b:0;}s:7:"exclude";a:2:{i:0;i:3;i:1;b:0;}s:3:"set";a:2:{i:0;i:3;i:1;b:0;}s:5:"order";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:0:{}',
      'u' => 'a:2:{s:3:"css";a:2:{i:0;i:3;i:1;b:0;}s:3:"tpl";a:2:{i:0;i:3;i:1;b:0;}}',
      'f' => 'a:6:{s:3:"idx";i:1;s:3:"css";i:3;s:3:"tpl";i:3;s:4:"name";i:3;s:4:"type";i:3;s:5:"group";i:1;}',
      'owner' => false,
    ),
    'properties' =>array (
      'p' => 'a:3:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:4:"page";a:2:{i:0;i:3;i:1;b:1;}s:9:"component";a:2:{i:0;i:1;i:1;b:1;}}',
      'i' => 'a:0:{}',
      'u' => 'a:2:{s:1:"v";a:2:{i:0;i:0;i:1;b:0;}s:4:"mode";a:2:{i:0;i:1;i:1;b:0;}}',
      'f' => 'a:6:{s:3:"idx";i:3;s:1:"n";i:3;s:1:"t";i:3;s:1:"o";i:3;s:1:"v";i:0;s:1:"d";i:3;}',
      'owner' => false,
    ),
    'files' =>array (
      'p' => 'a:2:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:9:"component";a:2:{i:0;i:3;i:1;b:0;}}',
      'i' => 'a:4:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:9:"component";a:2:{i:0;i:3;i:1;b:1;}s:8:"filename";a:2:{i:0;i:3;i:1;b:1;}s:4:"data";a:2:{i:0;i:3;i:1;b:1;}}',
      'u' => 'a:0:{}',
      'f' => 'a:3:{s:3:"idx";i:3;s:8:"filename";i:3;s:8:"filesize";i:3;}',
      'owner' => false,
    ),
    'links' =>array (
      'p' => 'a:3:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:9:"component";a:2:{i:0;i:1;i:1;b:1;}s:4:"type";a:2:{i:0;i:1;i:1;b:0;}}',
      'i' => 'a:10:{s:4:"type";a:2:{i:0;i:1;i:1;b:1;}s:5:"child";a:2:{i:0;i:3;i:1;b:1;}s:7:"service";a:2:{i:0;i:3;i:1;b:1;}s:6:"parent";a:2:{i:0;i:3;i:1;b:1;}s:2:"op";a:2:{i:0;i:3;i:1;b:1;}s:6:"lfield";a:2:{i:0;i:3;i:1;b:1;}s:6:"rfield";a:2:{i:0;i:3;i:1;b:1;}s:6:"tfield";a:2:{i:0;i:3;i:1;b:1;}s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:9:"component";a:2:{i:0;i:1;i:1;b:1;}}',
      'u' => 'a:5:{s:7:"service";a:2:{i:0;i:3;i:1;b:0;}s:6:"parent";a:2:{i:0;i:3;i:1;b:0;}s:2:"op";a:2:{i:0;i:3;i:1;b:0;}s:6:"rfield";a:2:{i:0;i:3;i:1;b:0;}s:6:"tfield";a:2:{i:0;i:3;i:1;b:0;}}',
      'f' => 'a:10:{s:3:"idx";i:3;s:4:"type";i:1;s:5:"child";i:3;s:7:"service";i:3;s:12:"service_name";i:3;s:6:"parent";i:3;s:2:"op";i:3;s:6:"lfield";i:3;s:6:"rfield";i:3;s:6:"tfield";i:3;}',
      'owner' => false,
    ),
  ),
  'commands' =>array (
    'getCFGTree' => 'a:1:{s:3:"tpl";a:2:{i:0;i:3;i:1;b:1;}}',
    'addComponent' => 'a:7:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:4:"page";a:2:{i:0;i:3;i:1;b:1;}s:6:"parent";a:2:{i:0;i:1;i:1;b:1;}s:7:"section";a:2:{i:0;i:1;i:1;b:1;}s:5:"order";a:2:{i:0;i:1;i:1;b:1;}s:4:"type";a:2:{i:0;i:3;i:1;b:0;}s:4:"name";a:2:{i:0;i:3;i:1;b:0;}}',
    'deleteComponent' => 'a:6:{s:7:"project";a:2:{i:0;i:3;i:1;b:1;}s:4:"page";a:2:{i:0;i:3;i:1;b:1;}s:6:"parent";a:2:{i:0;i:1;i:1;b:1;}s:7:"section";a:2:{i:0;i:1;i:1;b:1;}s:5:"order";a:2:{i:0;i:1;i:1;b:1;}s:9:"component";a:2:{i:0;i:1;i:1;b:1;}}',
  ),
  'links' =>array (
  ),
);
protected function &getDefinitionStruc(){return self::$_definition_struc;}
/*SRVDEF*/
    const PROPERTY_DEF = 200;
    const PROPERTY_TYPE = 201;
    const FILE_NOT_EXISTS = 202;
    const INDEX_FORMAT = 203;
    const INVALID_CMP_INDEX = 204;
    const INDEX_NOT_EXIST = 205;
    const STRUCTURE_FILE_FORMAT = 206;
    const DIFFERENT_PAGES = 207;
    const NO_SECTION_PRP = 208;
    const UNKNOWN_ORDER = 210;
    const COMPONENT_EXISTS = 211;
    const BAD_MDEF = 212;
    const UNKNOWN_MODEL_PRP = 213;
    const BAD_MODEL_PRP_LINK = 214;
    const SERVER_CLASS_NOT_EXISTS = 215;
    const NOT_A_COMPONENT = 216;
    const PAGE_NOT_FOUND = 217;
    const LINK_EXISTS = 218;
    const RATING_EXISTS = 219;

    const DEFAULT_DIR_MODE = 0777; //rvk
    const DEFAULT_FILE_MODE = 0644; //rvk

    private $_dbnames = null;
    private $_dbcomponents = null;
    private $_dbclasses = null;
    private $_ed_project = null;

    public function _fetch_page_model($args){
        $params = &$args['params'];
        $fields = $args['fields'];
        $this->_loadEditingProject($params['project']);
        if(isset($params['page'])){
            $row = $this->_fetchOnePage($params['project'],$params['page'],$fields);
            $rows=array($row);
        }
        else {
            $rows = array();
            foreach($this->_dbcomponents as $id=>$cmp){
                if($cmp['c']==='TPage') $rows[] = $this->_fetchOnePage($params['project'],$id,$fields);
            }
        }
        return array('rows'=>$rows,'count'=>count($rows));
    }
    public function _fetch_component_model($args){
        $params = &$args['params'];
        $this->_loadEditingProject($p = $params['project']);
        $rows = array();
        if(isset($params['component'])) $rows[]=$this->_fetchComponent($c=$params['component'],$this->_dbcomponents[$c],$params['project'],$params['page'],$args['fields']);
        else{
            $exclude = isset($params['exclude'])? explode(',',$params['exclude']):false;
            $type = isset($params['type'])? explode(',',$params['type']):false;
            if(isset($params['order'])&&$params['order']==='SMART'){
                array_push($args['fields'],'type','group','name');
            }
            foreach($this->_dbcomponents as $c =>$cmp){
                if($cmp['l']==false) continue;
                if($exclude && ($this->_instanceOf($cmp['c'],$exclude)!==false)) continue;
                if($type && ($this->_instanceOf($cmp['c'],$type)===false)) continue;
                $accept = true;
                if(isset($params['set'])){
                   switch($params['set']){
                       case 'NOT_IN_PAGE': $accept = !isset($cmp['l'][$params['page']]);
                   }
                }
                if ($accept) $rows[] = $this->_fetchComponent($c,$cmp,$params['project'],$params['page'],$args['fields']);
            }    
            if(isset($params['order'])){
                switch ($params['order']){
                    case 'SMART': {usort($rows,array($this,'_sort_SMART'));break;}
                    default: self::error(self::UNKNOWN_ORDER,$params['order']);
                }
            }
        }
        return array('rows'=>$rows,'count'=>count($rows));
    }
    public function _fetch_properties_model($args){
        $params = &$args['params'];
        $id = $params['component'];
        $idx = $params['project'].'.'.$id;
        $this->_loadEditingProject($params['project']);
        if (!isset($this->_dbcomponents[$id])) self::error(self::INDEX_NOT_EXIST,$id);
        $component = $this->_dbcomponents[$id];
        $rows = array();
        $rows[] = array('idx'=>$idx.'.name','n'=>'name', 't'=>'string', 'v'=>$component['n'], 'd'=>'');
        foreach ($component['p'] as $prpname=>$prp){
            $m = preg_split("/[[(]/",$prp[0]);
            if (!$m) self::error(self::PROPERTY_DEF,$prpname);
            $prptype = $m[0];
            $value = $prp[1];
            $opt = array();
            switch($prptype){
                case 'list':{
                    if(!isset($m[1])) self::error(self::PROPERTY_DEF,$prpname);
                    $opt = json_decode('['.$m[1],true);
                    break;
                }
                case 'component':{
                    $type = rtrim($m[1],')');
                    $opt = array('');
                    if(!isset($this->_dbnames[$params['page']])) self::error(self::PAGE_NOT_FOUND,$page);
                    $page = $this->_dbnames[$params['page']]; 
                    foreach($this->_dbcomponents as $cmp){
                        if (($cmp['c']===$type||in_array($type,$this->_dbclasses[$cmp['c']]))&&
                            isset($cmp['l'][$page])
                        ) $opt[]=$cmp['n'];
                    }
                    $prptype = 'list';
                    if ($opt && !in_array($value,$opt)) $opt[] = $value;
                    break;
                }
                case 'link': {
                    $opt = explode('.',rtrim($m[1],')'));
                    if(count($opt) != 2) self::error(self::PROPERTY_DEF,$prpname);
                    $value = $value? join('.',$value):'..';
                    break;
                }
                case 'object': {$value = self::jsonEncode($value); break;}
                case 'integer':
                case 'float':
                case 'string':
                case 'text':
                case 'boolean':break;
                default: self::error(self::PROPERTY_TYPE,$prpname);
            }
            $descr = ''; //TODO: вывести описание свойств
            $rows[] = array('idx'=>$idx.'.'.$prpname,'n'=>$prpname, 't'=>$prptype, 'o'=>$opt, 'v'=>$value, 'd'=>$descr);
        }
        return array('rows'=>$rows,'count'=>count($rows));
    }
    public function _update_page_model($args){
        $idx = explode('.',$args['index']);
        if (count($idx)!=2) self::error(self::INDEX_FORMAT,$args['index']);
        $val = $args['values'];
        if(isset($val['js'])) $this->_update_jscript($idx[0],$idx[1],$val['js']);
        if(isset($val['php'])) $this->_update_php($idx[0],$idx[1],$val['php']);
    }
    public function _update_component_model($args){
        $idx = explode('.',$args['index']);
        if (count($idx)!=2)  self::error(self::INDEX_FORMAT,$args['index']);
        $val = $args['values'];
        $this->_loadEditingProject($idx[0]);
        $id = (integer)$idx[1];
        $designer = TComponent_::getDesigner($id, $this->_ed_project);
        $links = $this->_dbcomponents[$id]['l'];
        foreach($links as $page=>$count){
            $path = $this->_ed_project->path.'/'.$page;
            if(isset($val['css'])) $designer->setStyles($val['css'],$path);
            if(isset($val['tpl'])) $designer->setTemplate($val['tpl'],$path);
        }
    }
    public function _update_properties_model($args){
        $val = $args['values'];
        $idx = explode('.',$args['index']);
        if(count($idx) != 3) self::error(self::INDEX_FORMAT,$idx);
        $this->_loadEditingProject($idx[0]);
        $id = (integer)$idx[1];
        $designer = TComponent_::getDesigner($id, $this->_ed_project);//new
        if(isset($val['mode'])) $designer->setProperty($idx[2],$val['v'],$val['mode']);
        else $designer->setProperty($idx[2],$val['v']);
        if(($idx[2]==='sections')&&($this->_is_a($id, 'TComponent'))) $this->_updated_models[] = 'page';
    }
    public function _insert_page_model($args){
        $val = $args['values'];
        $this->_loadEditingProject($val['project']);
        $designer = TComponent_::getDesigner('TPage', $this->_ed_project);//new
        $designer->insertIntoProject(-1,0,0,0,$val['name']);
        $this->_ed_project->changed = true;
    }
    public function _remove_page_model($args){
        $p = explode('.',$args['index']);
        if(count($p) !== 2) self::error(self::INDEX_FORMAT,$args['index']);
        list($project,$page) = $p;
        $page = (integer)$page;
        $this->_loadEditingProject($project);
        $designer = TComponent_::getDesigner($page, $this->_ed_project);//new
        $designer->removeFromProject(-1,0,0,$page); //new
        $this->_ed_project->changed = true;
    }

    private function _fetchOnePage($project,$page,$fields){
        if(is_string($page)){
            if(!isset($this->_dbnames[$page])) self::error(self::PAGE_NOT_FOUND,$page);
            $page = $this->_dbnames[$page]; 
        }
        $row = array('idx' => $project.'.'.$page);
        if (in_array('js',$fields)){
            $js_file = $_SERVER['DOCUMENT_ROOT'].'/projects/'.$project.'/'.$page.'/page.js';
            $js = file_exists($js_file)? file_get_contents($js_file):'';
            $row['js'] = $js;
        }
        if (in_array('php',$fields)){
            $php_file = $_SERVER['DOCUMENT_ROOT'].'/projects/'.$project.'/'.$page.'/page.php';
            $php = file_exists($php_file)? file_get_contents($php_file):'';
            $row['php'] = $php;
        }
        if (in_array('tree',$fields)){
            $row['tree'] = $this->_fetchTree($project,$page);
        }
        if (in_array('name',$fields)){
            $row['name'] = $this->_dbcomponents[$page]['n'];
        }
        if (in_array('params',$fields)){
            $p = $this->_dbcomponents[$page];
            $row['params'] = isset($p['g'])? $p['g']:'';
        }
        return $row;
    }
    private function _fetchTree($project,$page){
        $this->_loadEditingProject($project);
        $tree = $this->_parseVidget($page);
        return $tree;
    }
    // ======================================== row format =============================================
    // i - item(0-vidget; 1-container; 2,7,8,9-section begin; 3-section end; 4-container end; 5-component)
    // n - name : string
    // s - section : integer
    // p - parent: string
    // t - type: string
    // Section types: 2-container vidget; 7-components; 8-service; 9-politics
    //====================================================================================================
    private function _parseVidget($id,$parent=0,$sect=0,$ord=0) {
        $tree = array();
        if(!isset($this->_dbcomponents[$id])) self::error(self::INVALID_CMP_INDEX,$id);
        $comp = $this->_dbcomponents[$id];
        if(isset($comp['s'])){
            $tree[]=array('i'=>1,'n'=>$comp['n'],'id'=>$id,'t'=>$comp['c'],'g'=>$this->_getComponentGroup($comp['c']), 's'=>$sect,'p'=>$parent,'o'=>$ord);
            foreach ($comp['s'] as $ns=>$section){
                $tree[]=array('i'=>2,'s'=>$ns,'p'=>$id);
                $n = 0;
                foreach ($section as $cmp) {
                    $r = $this->_parseVidget($cmp,$id,$ns,$n++);
                    $tree = array_merge($tree,$r);
                }
                $tree[]=array('i'=>3);
            }
            if(isset($comp['u'])){
                $tree[]=array('i'=>2,'s'=>-1,'p'=>$id);
                $n = 0;
                foreach ($comp['u'] as $cmp) {
                    $r = $this->_parseVidget($cmp,$id,-1,$n++);
                    $tree = array_merge($tree,$r);
                }
                $tree[]=array('i'=>3);
            }
            $tree[]=array('i'=>4);
        }
        else{
            $tree[]=array('i'=>0,'n'=>$comp['n'],'g'=>$this->_getComponentGroup($comp['c']),'id'=>$id,'t'=>$comp['c'],'p'=>$parent,'s'=>$sect,'o'=>$ord);
        }
        return $tree;
    }
/* SMART sort order. Rows must content fields 'type','is_vidget','name'
1 - TVidgets children -> TComponents children
2 - by class name
3 - by component name
 */
    private function _sort_SMART($a,$b){
        if(($r = $b['group']-$a['group']) !== 0) return $r;
        if(($r = strcmp($a['type'],$b['type'])) !== 0 ) return $r;
        return strcmp($a['name'],$b['name']);
    }
    private function _fetchComponent($id,$cmp,$project,$page,$fields){
        if(!isset($this->_dbnames[$page])) self::error(self::PAGE_NOT_FOUND,$page);
        $page = $this->_dbnames[$page]; 
        $row = array('idx' => $project.'.'.$id);
        if (in_array('css',$fields)){
            $css_file = $_SERVER['DOCUMENT_ROOT'].'/projects/'.$project.'/'.$page.'/page.css';
            if(file_exists($css_file)){
                $css = file_get_contents($css_file);
                if (!isset($this->_dbcomponents[$id])) self::error(self::INDEX_NOT_EXIST,$id);
                $divider = preg_quote('/*'.$cmp['n'].'*/','/');
                $row['css'] = preg_match("/$divider(.*)$divider/s",$css,$m)? trim($m[1]):'';
            }
            else $row['css'] = '';
        }
        if (in_array('tpl',$fields)){
            $tpl_file = $_SERVER['DOCUMENT_ROOT'].'/projects/'.$project.'/'.$page.'/page.tpl';
            if(file_exists($tpl_file)){
                $tpl = file_get_contents($tpl_file);
                if (!isset($this->_dbcomponents[$id])) self::error(self::INDEX_NOT_EXIST,$id);
                $divider = preg_quote('<!--'.$cmp['n'].'-->','/');
                $row['tpl'] = preg_match("/$divider(.*)$divider/s",$tpl,$m)? trim($m[1]):'';
            }
            else $row['tpl'] = '';
        }
        if (in_array('name',$fields))$row['name'] = $cmp['n'];
        if (in_array('id',$fields))$row['id'] = $id;
        if (in_array('type',$fields))$row['type'] = $cmp['c'];
        if (in_array('group',$fields))$row['group'] = $this->_getComponentGroup($cmp['c']);
        return $row;
    }
    private function _getComponentGroup($class){
        if(($n=$this->_instanceOf($class,array('TVidget','TDBService')))===false) return 0;
        else return $n+1;
    } 
    private function _update_jscript($project,$page,$val){
        $js_file = $_SERVER['DOCUMENT_ROOT'].'/projects/'.$project.'/'.$page.'/page.js';
        file_put_contents ($js_file, $val);
    }
    private function _update_php($project,$page,$val){
        $php_file = $_SERVER['DOCUMENT_ROOT'].'/projects/'.$project.'/'.$page.'/page.php';
        file_put_contents ($php_file, $val);
    }
    private function _loadEditingProject($proj){
        if ($this->_ed_project !== null) return;
        $this->_ed_project = jq::getProject($proj);
        $this->_dbnames = &$this->_ed_project->db['names'];
        $this->_dbcomponents = &$this->_ed_project->db['components'];
        $this->_dbclasses = &$this->_ed_project->db['classes'];
    }
    protected function getCFGTree($args){
        $path = $_SERVER['DOCUMENT_ROOT'].'/core/';
        require_once($path.'parser.php');
        require_once($path.'treeclasses.php');
        $parser = new TTemplateParser();
        $result['tree'] = $parser->getCFGTree(trim($args['tpl']));
        return  $result;
    }
    protected function addComponent($arg){
        $this->_loadEditingProject($arg['project']);
        if(isset($arg['type'])){
            $type = $arg['type'];
            $designer = TComponent_::getDesigner($type, $this->_ed_project);//new
        }
        elseif(isset($arg['name'])){
            $id = $this->_dbnames[$arg['name']];
            $designer = TComponent_::getDesigner($id, $this->_ed_project);//new
        }
        else self::error(self::PARAMETER_REQUIRED,'type or name');
        if(!isset($this->_dbnames[$arg['page']])) self::error(self::PAGE_NOT_FOUND,$arg['page']);
        $page = $this->_dbnames[$arg['page']]; 
        $designer->insertIntoProject($arg['parent'],$arg['section'],$arg['order'],$page); //new
        $this->_ed_project->changed = true;
        $this->_updated_models[]='page';
    }
    protected function deleteComponent($args){
        $this->_loadEditingProject($args['project']);
        $idx = $args['component'];
        $designer = TComponent_::getDesigner($idx, $this->_ed_project); //new
        if(!isset($this->_dbnames[$args['page']])) self::error(self::PAGE_NOT_FOUND,$args['page']);
        $page = $this->_dbnames[$args['page']]; 
        $designer->removeFromProject($args['parent'],$args['section'],$args['order'],$page);//new
        $this->_ed_project->changed = true;
        $this->_updated_models[]='page';
    }
    private function _instanceOf($class,$classes){
        $dbc = $this->_dbclasses;
        for($i=0,$l=count($classes);$i<$l;$i++){
            $c = $classes[$i];
            if (($c===$class)||in_array($c,$dbc[$class])) return $i;
        }
        return false;
    }
    private function _is_a($id,$parent){
        if ($parent === 'TComponent') return true;
        $class = $this->_dbcomponents[$id]['c'];
        if ($class===$parent) return true;
        return in_array($parent, $this->_dbclasses[$class]);
    }
 /*RVK*/
    protected function _fetch_files_model($args){  //rvk
        $params = $args['params'];
        $id = $params['component'];
        $proj = $params['project'];            
        $dir = $this->_path2Data($args);        
        if (!is_dir($dir['datadirpath'])) mkdir($dir['datadirpath'], self::DEFAULT_DIR_MODE);
        if (!is_dir($dir['datacomponentdirpath'])) mkdir($dir['datacomponentdirpath'], self::DEFAULT_DIR_MODE);
        if (!is_dir($dir['datacomponentdirpath'].'/thumbs')) mkdir($dir['datacomponentdirpath'].'/thumbs', self::DEFAULT_DIR_MODE);
        
        $rows[] = array('idx'=>$proj.'.'.$id.'.','filename'=>'.',);
        $f = scandir($dir['datacomponentdirpath']);
        $list = array();
        foreach ($f as $file){
            $fileonserver = $dir['datacomponentdirpath'].'/'.$file;
            if (!is_dir($fileonserver)){
                $ctime = filectime($fileonserver) . ',' . $fileonserver;
                $list[$ctime]['filename'] = $file;
                $list[$ctime]['filesize'] = filesize($fileonserver);
               }
            }
        krsort($list);
        foreach ($list as $r) {
            $rows[] = array('idx'=>$proj.'.'.$id.'.'.$r['filename'],'filename'=>$r['filename'],
            'filesize'=>$r['filesize']);            
        }
        return array('rows'=>$rows, 'count'=>count($rows));
    }
    protected function _insert_files_model($args){  //rvk
        $dir = $this->_path2Data($args);
        //print_r($_FILES);
        $fp = fopen($dir['datacomponentdirpath'].'/'.$dir['file'], 'w');
        stream_filter_append($fp, 'convert.base64-decode');
        fwrite($fp, substr($dir['data'], strpos($dir['data'],'base64,')+7));
        fclose($fp);
        
        $newname = $dir['datacomponentdirpath'].'/'.$dir['file'];
        $file_size = getimagesize($newname); 
        //1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP
        //if (!$file_size OR !in_array(strtolower($file_ext), array('jpg','jpeg','gif','png','bmp')) OR !in_array($file_size[2], array(1, 2, 3))) return NPG_SetMessage(22);
        $newname_thumb =  $dir['datacomponentdirpath'].'/thumbs/thumb_'.$dir['file'].'.png';
        if ($file_size){
        list($width, $height, $type, $attr) = $file_size;
                //Creating a thumb
                $width_t = $height_t = 32; //$CONFIG['thumbs_size'];
                $ratio = $width/$height;
                if ($width_t/$height_t > $ratio) $width_t = $height_t*$ratio;
                    else $height_t = $width_t/$ratio;
                // Resample
                // Определяем исходный формат по MIME-информации и выбираем соответствующую imagecreatefrom-функцию.
                $format=strtolower(substr($file_size['mime'], strpos($file_size['mime'], '/')+1));
                $icfunc="imagecreatefrom".$format;  
                if(function_exists($icfunc)){
                    
                $image_p = imagecreatetruecolor($width_t, $height_t);
                imagesavealpha($image_p,true); 
                imagefill($image_p,0,0,IMG_COLOR_TRANSPARENT); 
                $image = $icfunc($newname);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_t, $height_t, $width, $height);
                // Output
                imagepng($image_p, $newname_thumb);
                }
        }
        else{
            $fp = fopen($newname_thumb, 'w');
            stream_filter_append($fp, 'convert.base64-decode');
            fwrite($fp, "iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QAAAAAAAD5Q7t/AAAACXBIWXMAAABIAAAASABGyWs+AAAACXZwQWcAAAAgAAAAIACH+pydAAACYklEQVRYw8WXy27TQBSG/3ES0jhOhQhRUlDVqgjKRZWrOrxG3jSbSFnwDE1rsQ4IVpASECwiciGdn0U8lWN57BkH1CNZk7no5Mz/nTljC5K4TysnBwaDwX+LqNfridwAooX/7E+llCCJ4XBopgAArFYrCCFAEkJsgo63aWMAQHLrkVLeBaAzJ22QJK6urzeOIgfKSfJ3vFXBOY5z16pHZ2VdAOe+v1Hj6j3GB6eFEZwd1jPny7qJ2WwGz/PgVgReP9nTSq/DoTYipdwaM0Ywn88RecyUXodDmUJhrUCr1QJJ/F5JjL8sCiM4P963R0ASl6MR3na7qFUEXh1UjaTPwmGFAACCINDKWxSHlQIqCed/iPFktROCLCW0ObBYLuF5HmoVgdN2xVp6E/m1CEjicbO5kTAm7S44rBW4HI3QDQLM18D427owAv+oYR8ASQQXFyAJtww8b5WMsj1tTZ4C2lMwnU43UqZImnU60lBlBaFVoOa6AIDFGvjwXRZGcHZYtw8AAOquC5LYKxHPmiJX+qwr2hoBSYRhiMhTrvSmOKwQ+L4PklisgY8/lAP7t7U3T2uZ81oEk5sbdNptVEvEySMlhnnxUf28JNSegv1GQ1tMsopPFhYrBG6UhMtbgU8/1c7ijsxwqJvUGkEYhvB9H9UScfxQGhegNByFkzDqpDpRfJP95HieaRX4Opmg025jKR18/pWWKmY4XnYeFFPA8zwAwPLFCY6cW63EeW3hQuTVoxIak9TmPtjpLqjXt9/lkzs2rQEmlhpAv99/R1LEP810lpxPW+84DqSUqTKI+/48/wtO199dDQWIoQAAACV0RVh0Y3JlYXRlLWRhdGUAMjAwOS0xMS0yOFQxNzoxODoyOC0wNzowMDGRsiwAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTAtMDItMjJUMTI6NTg6MDYtMDc6MDDq3LqPAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDEwLTAxLTExVDA4OjQ3OjUwLTA3OjAw/mBTrwAAADV0RVh0TGljZW5zZQBodHRwOi8vY3JlYXRpdmVjb21tb25zLm9yZy9saWNlbnNlcy9MR1BMLzIuMS87wbQYAAAAJXRFWHRtb2RpZnktZGF0ZQAyMDA5LTExLTI4VDEzOjU1OjUwLTA3OjAw0pQRwgAAABZ0RVh0U291cmNlAENyeXN0YWwgUHJvamVjdOvj5IsAAAAndEVYdFNvdXJjZV9VUkwAaHR0cDovL2V2ZXJhbGRvLmNvbS9jcnlzdGFsL6WRk1sAAAAASUVORK5CYII=");
            fclose($fp);
        }
        //SK: Переменная $filesize не инициализирована
        return array('file' => $dir['file'], 'filesize'=>$filesize);
    }    
    protected function _remove_files_model($args){ //rvk
        $dir = $this->_path2Data($args);
        unlink($dir['datacomponentdirpath'].'/'.$dir['file']);
        unlink($dir['datacomponentdirpath'].'/thumbs/thumb_'.$dir['file'].'.png');
        return array ('id'=>$dir['file']);        
    }    
    private function _path2Data($args){  //rvk
        $data = '';
        $file = '';
        if (isset($args['index'])){        
            $p = explode('.',$args['index'],3);
            if(count($p) !== 3) self::_error(self::INDEX_FORMAT,$args['index']);
            list($proj,$id,$file) = $p;
        }
        elseif (isset($args['params'])) {
            $val = $args['params']; 
            $proj = $val['project'];
            $id = $val['component'];            
        } else {
            //print_r($args);
            $val = $args['values'];    
            $proj = $val['project'];
            $id = $val['component'];
            $file = $val['filename'];
            $data = $val['data'];
        }
        $path = $_SERVER['DOCUMENT_ROOT'].'/.projects/'.$proj.'/data';
        $componentdir = $path.'/'.$id;
        return array('datadirpath'=>$path, 'datacomponentdirpath'=>$componentdir, 'file'=>$file,
        'data'=>$data);
    }    
/*RVK*/  
    public function _fetch_links_model($args){
        $p = $args['params'];
        $this->_loadEditingProject($p['project']);
        $cmp = $this->_dbcomponents[$p['component']];
        $rows = array(); $fields = $args['fields'];
        $all = !(boolean)$fields;
        if(isset($cmp['links']) && $cmp['links']){
           if(!isset($p['type']) || ($p['type']==0)){
               foreach($cmp['links'][0] as $child=>$fk)
                   foreach($fk as $lfield=>$val){
                      $row = array('idx'=>"{$p['project']}.{$p['component']}.0.$child.$lfield");
                      $breaked = !isset($this->_dbcomponents[$val[0]]) ||
                                 $this->_dbcomponents[$val[0]]['c'] != $val[1];
                      if($all || in_array('type',$fields)) $row['type'] = 0;
                      if($all || in_array('child',$fields)) $row['child'] = $child;
                      if($all || in_array('service',$fields)) $row['service'] = $breaked? -1:$val[0];
                      if($all || in_array('service_name',$fields)) $row['service_name'] = $breaked? '':$this->_dbcomponents[$val[0]]['n'];
                      if($all || in_array('parent',$fields)) $row['parent'] = $breaked? '':$val[2];
                      if($all || in_array('op',$fields)) $row['op'] = $val[3];
                      if($all || in_array('lfield',$fields)) $row['lfield'] = $lfield;
                      if($all || in_array('rfield',$fields)) $row['rfield'] = '';
                      if($all || in_array('tfield',$fields)) $row['tfield'] = '';
                      $rows[] = $row;    
                   }
           } 
           if(!isset($p['type']) || ($p['type']==1)){
               foreach($cmp['links'][1] as $child=>$rtng)
                   foreach($rtng as $id=>$val){
                      $row = array('idx'=>"{$p['project']}.{$p['component']}.1.$child.$id");
                      $breaked = !isset($this->_dbcomponents[$val[0]]) ||
                                 $this->_dbcomponents[$val[0]]['c'] != $val[1];
                      if($all || in_array('type',$fields)) $row['type'] = 1;
                      if($all || in_array('child',$fields)) $row['child'] = $child;
                      if($all || in_array('service',$fields)) $row['service'] = $val[0];
                      if($all || in_array('service_name',$fields)) $row['service_name'] = $breaked? '':$this->_dbcomponents[$val[0]]['n'];
                      if($all || in_array('parent',$fields)) $row['parent'] = $breaked? '':$val[2];
                      if($all || in_array('op',$fields)) $row['op'] = $val[3];
                      if($all || in_array('lfield',$fields)) $row['lfield'] = $val[4];
                      if($all || in_array('rfield',$fields)) $row['rfield'] = $val[5];
                      if($all || in_array('tfield',$fields)) $row['tfield'] = $val[6];
                      $rows[] = $row;    
                   }
           } 
        }
        return array('rows'=>$rows, 'count'=>count($rows));
    } 
    public function _remove_links_model($args){
        $idx = explode('.',$args['index']);
        if(count($idx) !== 5) self::error(self::INDEX_FORMAT,$args['index']);
        $this->_loadEditingProject($idx[0]);
        if(!isset($this->_dbcomponents[$idx[1]])) self::error(self::INDEX_NOT_EXIST,$idx[1]);
        $cmp = &$this->_dbcomponents[$idx[1]];
        if(isset($cmp['links'][$idx[2]][$idx[3]][$idx[4]])){ 
            $link = $cmp['links'][$idx[2]][$idx[3]][$idx[4]];
            if(!$idx[2]){
                $designer = TComponent_::getDesigner((integer)$idx[1], $this->_ed_project);
                $designer->setForignKey($idx[3],$idx[4],$link[0],$link[1],'NONE');
            }    
            else{
                $parent_designer = TComponent_::getDesigner((integer)$link[0], $this->_ed_project);
                $parent_designer->deleteRatingField($link[2],$link[6]);
            }
            unset($cmp['links'][$idx[2]][$idx[3]][$idx[4]]);
            $this->_ed_project->changed = true;
        }    
    }
    public function _insert_links_model($args){
        $v=$args['values'];
        $this->_loadEditingProject($v['project']);
        if(!isset($this->_dbcomponents[$v['component']])) self::error(self::INDEX_NOT_EXIST,$v['component']);
        $cmp = &$this->_dbcomponents[$v['component']];
        if(!isset($cmp['links'])) $cmp['links'] = array(0=>array(),1=>array());
        $links = &$cmp['links'];
        if(!isset($this->_dbcomponents[$v['service']])) self::error(self::INDEX_NOT_EXIST,$v['service']);
        $type = $this->_dbcomponents[$v['service']]['c'];
        $l = array($v['service'],$type,$v['parent'],$v['op']);//0 1 2 3
        if($v['type']){ //rating
            array_push($l, $v['lfield'],$v['rfield'],$v['tfield']); // 4 5 6
            foreach($links[1] as $child=>$def){
                foreach($def as $ll)
                    if(($child==$v['child'])&&($ll[0]==$l[0])&&($ll[2]==$l[2])&&($ll[3]==$l[3])&&($ll[4]==$l[4])&&($ll[5]==$l[5]))
                        self::error(self::RATING_EXISTS,"{$l[3]}({$l[5]})",$l[0].'.'.$l[2]);
            }
            $links[1][$v['child']][] = $l;
            $childs_designer = TComponent_::getDesigner((integer)$v['component'], $this->_ed_project);
            $r_type = $childs_designer->getRatingType($v['child'],$l[5],$l[3]);
            $parent_designer = TComponent_::getDesigner((integer)$l[0], $this->_ed_project);
            $parent_designer->addRatingField($l[2],$l[6],$r_type);
            $ptable = self::getTableName($this->_ed_project->getNameById((integer)$l[0]),$l[2]);
            $ctable = self::getTableName($cmp['n'],$v['child']);
            $parent_designer->updateAllRatings($ptable,$ctable,$l[4],$l[3],$l[5],$l[6]);
        }
        else{ //link
            if(isset($links[0][$v['child']][$v['lfield']])) self::error(self::LINK_EXISTS,$v['child'].'.'.$v['lfield']);
            $links[0][$v['child']][$v['lfield']] = $l;
            $designer = TComponent_::getDesigner((integer)$v['component'], $this->_ed_project);
            $sname = $this->_dbcomponents[$l[0]]['n'];
            $designer->setForignKey($v['child'],$v['lfield'],$sname,$l[2],$l[3]);
        }
        $this->_ed_project->changed = true;
    }
    public function _update_links_model($args){
        $idx = explode('.',$args['index']);
        if(count($idx) !== 5) self::error(self::INDEX_FORMAT,$args['index']);
        $this->_loadEditingProject($idx[0]);
        if(!isset($this->_dbcomponents[$idx[1]])) self::error(self::INDEX_NOT_EXIST,$idx[1]);
        $cmp = &$this->_dbcomponents[$idx[1]];
        if(!isset($cmp['links'][$idx[2]][$idx[3]][$idx[4]])) return;
        $link = &$cmp['links'][$idx[2]][$idx[3]][$idx[4]];
        $old_link = $link;
        $v = $args['values'];
        if(isset($v['service'])) {
            if(!isset($this->_dbcomponents[$v['service']])) self::error(self::INDEX_NOT_EXIST,$v['service']);
            $link[0] = $v['service'];
            $link[1] = $this->_dbcomponents[$v['service']]['c'];
        }    
        if(isset($v['parent'])) $link[2] = $v['parent'];
        if(isset($v['op'])) $link[3] = $v['op'];
        if($idx[2]){//rating
            if(isset($v['rfield'])) $link[5] = $v['rfield'];
            if(isset($v['tfield'])) $link[6] = $v['tfield'];
            $childs_designer = TComponent_::getDesigner((integer)$idx[1], $this->_ed_project);
            $r_type = $childs_designer->getRatingType($idx[3],$link[5],$link[3]);
            if(isset($v['service'])||isset($v['parent'])){
                $old_parent_designer = TComponent_::getDesigner((integer)$old_link[0], $this->_ed_project);
                $new_parent_designer = TComponent_::getDesigner((integer)$link[0], $this->_ed_project);
                $old_parent_designer->deleteRatingField($old_link[2],$old_link[6]);
                $new_parent_designer->addRatingField($link[2],$link[6],$r_type);
            }
            else{
                $parent_designer = TComponent_::getDesigner((integer)$link[0], $this->_ed_project);
                $parent_designer->changeRatingField($link[2],$old_link[6],$link[6],$r_type);
                if(isset($v['op'])||isset($v['rfield'])){
                    $ptable = self::getTableName($this->_ed_project->getNameById((integer)$link[0]),$link[2]);
                    $ctable = self::getTableName($cmp['n'],$idx[3]);
                    $parent_designer->updateAllRatings($ptable,$ctable,$link[4],$link[3],$link[5],$link[6]);
                }
            }
        }
        else{//link
            if(!isset($this->_dbcomponents[$link[0]])) self::error(self::INDEX_NOT_EXIST,$link[0]);
            $sname = $this->_dbcomponents[$link[0]]['n'];
            $designer = TComponent_::getDesigner((integer)$idx[1], $this->_ed_project);
            $designer->setForignKey($idx[3],$idx[4],$sname,$link[2],$link[3]);
        }
        $this->_ed_project->changed = true;
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::PROPERTY_DEF: {$msg = 'Invalid property type definition of "'.$args[1] ;break;}
            case self::PROPERTY_TYPE: {$msg = 'Unknown type of property: '.$args[1] ;break;}
            case self::FILE_NOT_EXISTS: {$msg = 'File not exists: '.$args[1] ;break;}
            case self::INDEX_FORMAT: {$msg = 'Invalid index format: '.$args[1] ;break;}
            case self::INDEX_NOT_EXIST: {$msg = 'Component with index "'.$args[1].'" is not exist' ;break;}
            case self::INVALID_CMP_INDEX: {$msg = 'Invalid component index: "'.$args[1].'"'; break;}
            case self::STRUCTURE_FILE_FORMAT: {$msg = 'Invalid page structure format'; break;}
            case self::DIFFERENT_PAGES: {$msg = 'Not allowed to modify different pages in one queie'; break;}
            case self::NO_SECTION_PRP: {$msg = 'Error in project database. Container "'.$args[1].'" has no section property'; break;}
            case self::UNKNOWN_ORDER: {$msg = 'Unsupported order type: "'.$args[1].'"'; break;}
            case self::COMPONENT_EXISTS: {$msg = 'Component with this name already exists in this page'; break;}
            case self::BAD_MDEF: {$msg = 'Bad TModel\'s cmpdef.xml file format'; break;}
            case self::UNKNOWN_MODEL_PRP: {$msg = 'Unknown models property "'.$args[1].'" in cmpdef.xml file'; break;}
            case self::BAD_MODEL_PRP_LINK: {$msg = 'Bad model property link "'.$args[1].'"'; break;}
            case self::SERVER_CLASS_NOT_EXISTS: {$msg = 'Server class '.$args[1].' does not exist'; break;}
            case self::NOT_A_COMPONENT: {$msg = 'Class "'.$args[1].'" is not derived from TComponent'; break;}
            case self::PAGE_NOT_FOUND: {$msg = 'Page with name "'.$args[1].'" not found'; break;}
            case self::LINK_EXISTS: {$msg = 'Link with "'.$args[1].'" already exists'; break;}
            case self::RATING_EXISTS: {$msg = 'Rating "'.$args[1].'" in "'.$args[2].'" already exists'; break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }

};
?>