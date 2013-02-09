<?php
class TVidget_ extends TComponent_ {
    const MULTIPLE_TEMPLATES = 101;
    const FUNCTION_NOT_DEFINED = 102;
    const SECTION_NOT_EXISTS = 103;
    const CONTAINER_NOT_FOUND = 104;
    const CSS_SECTIONS = 105;

    protected $name;
    function __construct($project,$class,$id=null){
        parent::__construct($project,$class,$id);
        if(!is_null($id)) $this->name = $this->_getName();
    }
    private static function _cssDiv($n){return '/*'.$n.'*/';}
    private static function _tplDiv($n){return '<!--'.$n.'-->';}
    private static function _lSrvTplDiv($n){return '<?php function '.$n.'_template($cmp){?>';}
    private static function _rSrvTplDiv($n){return '<?php }//'.$n.'_template?>';}
    private static function _lClientTplDiv($n){return "jq.attachMethod('template','".$n."',function(){";}
    private static function _rClientTplDiv($n){return '});//'.$n.'.template';}
    public function setTemplate($new, $path){
        if(!$new) return;
        $tpl_file = $path.'/page.tpl';
        $stpl_file = $path.'/templates.php';
        $ctpl_file = $path.'/templates.js';
        require_once($_SERVER['DOCUMENT_ROOT'].'/core/treeclasses.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/core/parser.php');
        $parser = new TTemplateParser();
        $ctemplate = $parser->compile($new);
        // Обновляем серверный компилированный шаблон
        $name = $this->name;
        $stpl = $this->_update_page_file(self::_lSrvTplDiv($name),self::_rSrvTplDiv($name),$ctemplate[0],$stpl_file);
        // Обновляем файл шаблона
        $div = self::_tplDiv($name);
        $ttpl = $this->_update_page_file($div,$div,$new,$tpl_file);
        // Обновляем клиентский компилированный шаблон
        if($this->_isUpdatible()){
            $ctpl = $this->_update_page_file(self::_lClientTplDiv($name),self::_rClientTplDiv($name),$ctemplate[1],$ctpl_file);
            $ctpl = $this->_linkClientUses($ctpl);
            file_put_contents($ctpl_file,$ctpl);
        }
        // Записываем файлы
        file_put_contents($stpl_file,$stpl);
        file_put_contents($tpl_file,$ttpl);
    }
    private function _isUpdatible(){
        $prp = $this->project->db['components'][$this->id]['p'];
        if (isset($prp['updatible'])) return $prp['updatible'][1];
        $cmp = new $this->class($this->project);
        return $cmp->updatible;
    }
    protected function _rename($name){
        $oldname = $this->name;
        parent::_rename($name);
        $c = &$this->project->db['components'][$this->id];
        foreach($c['l'] as $page=>$count){
            $dir = $this->project->path.'/'.$page;
            $this->_renameTemplates($oldname,$name,$dir);
            $this->_renameStyles($oldname,$name,$dir);
        }
        $this->name = $name;
    }            
    protected function applyProperty(&$cmp,$name,$val){
        if($name === 'updatible'){
            foreach($cmp['l'] as $page=>$count){
                $dir = $this->project->path.'/'.$page;
                if ($val) $this->_setClientTemplate($dir);
                else $this->_delClientTemplate($dir);
            }
        }
        parent::applyProperty($cmp, $name, $val);
    }
    public function deleteFromContainer($parent,$section,$order){
        $components = &$this->project->db['components'];
        if (!isset($components[$parent])) self::error(self::CONTAINER_NOT_FOUND,$parent);
        if (!isset($components[$parent]['s'][$section])) self::error(self::SECTION_NOT_EXISTS,$section);
        $s = &$components[$parent]['s'][$section];
        unset($s[$order]);
        $s = array_values($s);
    }
    public function removeFromProject($parent,$section,$order,$page){
        $cmp = $this->project->db['components'][$this->id];
        if($cmp['l'][$page]<=1){
            $path = $this->project->path.'/'.$page;
            $this->_delTemplates($path);
            $this->_delStyles($path);
        }
        parent::removeFromProject($parent,$section,$order,$page);
    }
    public function insertIntoProject($parent,$section,$order,$page,$name=null){
        if(!$this->id) {
            $this->id = $this->insertIntoDB(false,$name);
            $this->name = $this->_getName();
        }   
        //1. Вставить в контейнер
        $components = &$this->project->db['components'];
        if($parent>=0){
            if(!isset($components[$parent])) self::error(self::CONTAINER_NOT_FOUND,$parent);
            $cnt = &$components[$parent];
            if(!isset($cnt['s'][$section])) self::error(self::SECTION_NOT_EXISTS,$section,$cnt['n']);
            $cs = &$cnt['s'][$section];
            $cs = array_merge(array_slice($cs,0,$order),array($this->id),array_slice($cs,$order));
        }
        $links = &$components[$this->id]['l'];
        $dir = $this->project->path.'/'.$page;
        if(!$links){
            //2. Вставить шаблон
            $tpl = $this->_getVidgetsResource('template.tpl');
            if ($tpl) $this->setTemplate($tpl,$dir);
            //3. Вставить стили
            $css = $this->_getVidgetsResource('styles.css');
            if($css){
                $css = preg_replace('/((?:^\\s*)|(?:,\\s*))#name/m','\\1#'.$this->name,$css);
                $this->setStyles($css,$dir);
            }
            $links = array($page=>1);
        }
        else{
            if(!isset($links[$page])){
                $prevdir = $this->project->path.'/'.key($links);
                $file = file_get_contents($prevdir.'/page.css');
                $divider = preg_quote('/*'.$this->name.'*/','/');
                $css = preg_match("/$divider(.*)$divider/s",$file,$m)? trim($m[1]):'';
                if($css) $this->setStyles($css,$dir);
                $file = file_get_contents($prevdir.'/page.tpl');
                $divider = preg_quote('<!--'.$this->name.'-->','/');
                $tpl = preg_match("/$divider(.*)$divider/s",$file,$m)? trim($m[1]):'';
                if ($tpl) $this->setTemplate($tpl,$dir);
                $links[$page] = 1;
            }
            else $links[$page]++;
        }
    }
    public function setStyles($css,$path){
        $css_file = $path.'/page.css';
        $div = self::_cssDiv($this->name);
        $pagecss = $this->_update_page_file($div,$div,$css,$css_file);
        file_put_contents($css_file,$pagecss);
    }
    public function _renameStyles($oldname,$newname,$path){
        $css_file = $path.'/page.css';
        if(file_exists($css_file)){
            $css = file_get_contents($css_file);
            $div = self::_cssDiv($oldname);
            $cdiv = preg_quote($div,'/');
            $parts = preg_split("/$cdiv/s",$css);
            if(count($parts) == 1) return;
            if(count($parts)!=3) self::error(self::CSS_SECTIONS,$oldname);
            $parts[1] = preg_replace('/((?:^\\s*)|(?:,\\s*))#'.$oldname.'/m','\\1#'.$newname,$parts[1]);
            $css = join(self::_cssDiv($newname),$parts);
            file_put_contents($css_file,$css);
        }
    }
    private function _delTemplates($path){
        $this->_delClientTemplate($path);
        $file = $path.'/page.tpl';
        $div = self::_tplDiv($this->name);
        $this->_delete_page_file($div,$div,$file);
        $file = $path.'/templates.php';
        $this->_delete_page_file(self::_lSrvTplDiv($this->name),self::_rSrvTplDiv($this->name),$file);
    }
    private function _delStyles($path){
        $file = $path.'/page.css';
        $div = self::_cssDiv($this->name);
        $this->_delete_page_file($div,$div,$file);
    }
    private function _delClientTemplate($path){
        $ctpl_file = $path.'/templates.js';
        if (file_exists($ctpl_file)){
            $cldiv = preg_quote(self::_lClientTplDiv($this->name),'/');
            $crdiv = preg_quote(self::_rClientTplDiv($this->name),'/');
            $tpl = file_get_contents($ctpl_file);
            $tpl = preg_replace("/\\s*$cldiv.*?$crdiv\\s*/s","\n",$tpl);
            $tpl = $this->_linkClientUses($tpl);
            file_put_contents($ctpl_file,trim($tpl));
        }
    }
    private function _setClientTemplate($path){
        $root = $_SERVER['DOCUMENT_ROOT'];
        $tpl_file = $path.'/page.tpl';
        $ctpl_file = $path.'/templates.js';
        $tpl = file_get_contents($tpl_file);
        $div = preg_quote(self::_tplDiv($this->name),'/');
        preg_match("/$div(.*?)$div/s",$tpl,$m);

        require_once($root.'/core/treeclasses.php');
        require_once($root.'/core/parser.php');
        $parser = new TTemplateParser();
        $ctemplate = $parser->compile($m[1]);
        $ctpl = $this->_update_page_file(self::_lClientTplDiv($this->name),self::_rClientTplDiv($this->name),$ctemplate[1],$ctpl_file);
        $ctpl = $this->_linkClientUses($ctpl);
        file_put_contents($ctpl_file,$ctpl);
    }
    private function _update_page_file($ldiv,$rdiv,$tpl,$file){
        $cldiv = preg_quote($ldiv,'/');
        $crdiv = preg_quote($rdiv,'/');
        $tpl = $ldiv."\n".$tpl."\n".$rdiv;
        if (file_exists($file)){
            $stpl = file_get_contents($file);
            $parts = preg_split("/$cldiv.*?$crdiv/s",$stpl);
            if(count($parts)==1) $stpl = rtrim($parts[0])."\n".$tpl;
            elseif((count($parts)==2)) $stpl = $parts[0].$tpl.$parts[1];
            else self::error(self::MULTIPLE_TEMPLATES,$file);
            return $stpl;
        }
        else{
            return $tpl;
        }
    }
    private function _delete_page_file($ldiv,$rdiv,$file){
        $cldiv = preg_quote($ldiv,'/');
        $crdiv = preg_quote($rdiv,'/');
        if (file_exists($file)){
            $stpl = file_get_contents($file);
            $stpl = preg_replace("/\\s*$cldiv.*?$crdiv\\s*/s","\n",$stpl);
            file_put_contents($file,trim($stpl));
        }
    }
    private function _linkClientUses($txt){
        $txt = preg_replace('/\\/\\/functions\\/\\/.*\\/\\/functions\\/\\//s','',$txt);
        if(preg_match_all('/\\/\\/uses (.*)$/m',$txt,$mm,PREG_SET_ORDER)){
            $uses = array();
            foreach($mm as $m){$uses = array_merge($uses,explode(',',trim($m[1])));}
            $uses = array_unique($uses);
            if ($uses){
                $func_file = $_SERVER['DOCUMENT_ROOT'].'/core/functions.js';
                $func = file_get_contents($func_file);
                $inc = '';
                foreach($uses as $use){
                    $rr = "/\\/\\/$use\\/\\/(.*)\\/\\/$use\\/\\//s";
                    if(!preg_match($rr,$func,$m)) self::error(self::FUNCTION_NOT_DEFINED,$use);
                    $inc .= $m[1];
                }
                $txt = rtrim($txt)."\n\n".'//functions//'."\n".trim($inc)."\n".'//functions//';
            }
        }
        return $txt;
    }
    protected function _renameTemplates($old,$new,$path){
        $tpl_file = $path.'/page.tpl';
        $stpl_file = $path.'/templates.php';
        $ctpl_file = $path.'/templates.js';
        // Обновляем метки в файле шаблона
        $from = '/'.preg_quote($this->_tplDiv($old),'/').'/';
        $to = self::_tplDiv($new);
        $txt = file_get_contents($tpl_file);
        $txt = preg_replace($from,$to,$txt,-1,$c);
        if ($c==0) return; //если шаблона нет в файле, то больше ничего не делаем
        file_put_contents($tpl_file,$txt);
        // Обновляем имя функции серверного шаблона
        $from = '/'.preg_quote($old.'_template','/').'/';
        $to = $new.'_template';
        $txt = file_get_contents($stpl_file);
        $txt = preg_replace($from,$to,$txt,-1,$c);
        if ($c) file_put_contents($stpl_file,$txt);
        // Обновляем имя функции клиентского шаблона
        if(file_exists($ctpl_file)){
            $from = $to = array();
            $from[0] = '/'.preg_quote(self::_lClientTplDiv($old),'/').'/';
            $from[1] = '/'.preg_quote(self::_rClientTplDiv($old),'/').'/';
            $to[0] = self::_lClientTplDiv($new);
            $to[1] = self::_rClientTplDiv($new);
            $txt = file_get_contents($ctpl_file);
            $txt = preg_replace($from,$to,$txt,-1,$c);
            if ($c) file_put_contents($ctpl_file,$txt);
        }
    }
    protected function _getVidgetsResource($file){
        $type = $this->class;
        while (1){
            $cmpfile = TComponent::getPalettePath($type).'/'.$file;
            if (file_exists($cmpfile)) return file_get_contents($cmpfile);
            if($type == 'TVidget') return "";
            $type = get_parent_class($type);
        }
        return '';
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::SECTION_NOT_EXISTS: {$msg = 'Section '.$args[1].' is not exist in component '.$args[2] ;break;}
            case self::CONTAINER_NOT_FOUND: {$msg = 'Container '.$args[1].' not found' ;break;}
            case self::CSS_SECTIONS: {$msg = 'Invalid count of CSS dividers of component '.$args[1] ;break;}
            case self::MULTIPLE_TEMPLATES: {$msg = 'More than one template found in file: '.$args[1] ;break;}
            case self::FUNCTION_NOT_DEFINED: {$msg = 'Client function "'.$args[1].'" is not exist' ;break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }

}
?>
