<?php
class TPage_ extends TContainer_{
    const CREATE_DIRECTORY = 300;
    const RENAME_PAGE_FILE = 301;
    const CREATE_PAGE_FILE = 302;

    protected function insertIntoDB($embedded = false, $name = null) {
        $id = parent::insertIntoDB($embedded, $name);
        $cmp = &$this->project->db['components'][$id];
        $cmp['u'] = array();
        return $id;
    }
    public function insertIntoProject($parent,$section,$order,$page,$name=null){
        if(!$this->id) $this->id = $this->insertIntoDB(false,$name);
        $this->name = $this->_getName();
        $path = $this->project->path.'/'.$this->id;
        if(file_exists($path)) foreach(glob($path."/*") as $obj) unlink($obj);
        else if(!mkdir($path)) self::error(self::CREATE_DIRECTORY,$path);
        parent::insertIntoProject($parent,$section,$order,$this->id,$name);
        $scr_page_file = $_SERVER['DOCUMENT_ROOT'].'/core/index.ph_';
        $page_file = $this->project->path.'/'.$name.'.php';
        if(!copy($scr_page_file,$page_file)) self::error(self::CREATE_PAGE_FILE,$page_file);
    }
    public function deleteFromContainer($parent,$section,$order){}
    public function removeFromProject($parent,$section,$order,$page){
        $components = &$this->project->db['components'];
        $this->_deleteSection(-1,$components[$this->id]['u'],$page); 
        $path = $this->project->path.'/'.$this->id;
        parent::removeFromProject($parent,$section,$order,$page);
        if(file_exists($path)){
            foreach(glob($path."/*") as $obj) unlink($obj);
            rmdir($path);
        }
        $index = $this->project->path.'/'.$this->name.'.php';
        if(file_exists($index)) unlink($index);
    }
    public function _rename($name) {
        $oldname = $this->name;
        parent::_rename($name);
        $path = $this->project->path;
        if(!rename($path.'/'.$oldname.'.php',$path.'/'.$name.'.php')) self::error(self::RENAME_PAGE_FILE,$oldname);
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::CREATE_DIRECTORY: {$msg = 'Can not create directory: '.$args[1]; break;}
            case self::RENAME_PAGE_FILE: {$msg = 'Can not rename page file: '.$args[1].'.php'; break;}
            case self::CREATE_PAGE_FILE: {$msg = 'Can not create page file: '.$args[1]; break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}
?>