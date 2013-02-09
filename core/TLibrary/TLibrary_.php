<?php
class TLibrary_ extends TComponent_{
    const LIB_NOT_EXISTS = 1;

    public function applyProperty(&$cmp,$name,$val) {
        if ($name == 'library'){
            $libpath = TProject::getLibraryPath($val);
            if(!file_exists($_SERVER['DOCUMENT_ROOT'].$libpath)) self::error(self::LIB_NOT_EXISTS,$val);
         }
         parent::applyProperty($cmp, $name, $val);
    }
    protected static function _getErrorMsg($args){
        $code = $args[0];
        switch ($code){
            case self::LIB_NOT_EXISTS: {$msg = 'Library "'.$args[1].'" does not exist' ;break;}
            default: $msg = parent::_getErrorMsg($args);
        }
        return $msg;
    }
}