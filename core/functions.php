<?php
//===============================================================================================
class bbClass {
    private static $n;
    private static $tags,$tstack,$nstack,$cstack,$test;
    const tags1 = 'img|url|email|br';
    const tags2 = 'b|i|u|cite|color';
    public function decode($text) {
        self::$n = 0;
        self::$tags = self::$tstack = self::$nstack = self::$cstack = array();
        $text = preg_replace_callback('/
           (?: \[('.self::tags1.')\](.+?)\[\/\1\]  )| #теги, не допускающие вложенность
           (?: \[ (\/)?('.self::tags2.')(?: (?:=|\s)([^\]]+) )? \] )| #теги, допускающие рекурсивную вложенность
           (\n)  #перевод строки
        /xius',array($this,'_parseCallback1'),$text);
        if(!self::$n) return $text;
        self::$test = (boolean)(self::$cstack += self::$nstack);
        $text = preg_replace_callback('/\[(\d+)\]/',array($this,'_parseCallback2'),$text);
        return $text;
    }
    private function _parseCallback1($m){ //$m => [0=>all,1=>tag1,2=>content,3=>close,4=>tag2,5=>attr,6=>lf]
        if(isset($m[6])&&$m[6]==="\n") return '<br>';
        if(isset($m[1]) && $m[1]) {$r = $this->_parseBBTag1($m[1],$m[2]); return ($r===false)? $m[0]:$r;}
        $tag2 = isset($m[4])? $m[4]:null;
        $attr = isset($m[5])? $m[5]:null;
        $close = isset($m[3])&&$m[3];
        self::$tags[self::$n]=array($m[0], $close, $tag2, $attr);
        if($close) {
            if(isset(self::$tstack[0])&&self::$tstack[0]===$tag2){
                array_shift(self::$tstack);
                array_shift(self::$nstack);
            }
            else self::$cstack[] = self::$n;
        }
        else{
            array_unshift(self::$tstack,$tag2);
            array_unshift(self::$nstack,self::$n);
        }
        return '['.self::$n++.']';
    }
    private function _parseCallback2($m){
        $t = self::$tags[$m[1]];
        if(!self::$test || !in_array($m[1],self::$cstack)){
            $r = $this->_parseBBTag2($t[1],$t[2],$t[3]);
            return ($r===false)? $m[0]:$r;
        }
    }
    private function _parseBBTag1($tag,$content){
        switch(strtolower($tag)){
            case 'img':return "<img src='$content' alt='$content'>";
            case 'url':return "<a href='$content'>$content</a>";
            case 'email':return "<a href='mailto:$content'>$content</a>";
        }
    }
    private function _parseBBTag2($close,$tag,$attr){
        if($close) return "</$tag>";
        else{
            $c = $attr? " style='color:$attr'":'';
            return '<'.$tag.$c.'>';
        }
    }
}
function bbDecode($str){
    static $bb;
    if(!$bb) $bb=new bbClass;
    return $bb->decode($str);
}
function isCoreClass($class){
    return TComponent::isCoreClass($class);
}
?>