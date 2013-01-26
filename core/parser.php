<?php
define('LT_END',0);
define('LT_STRING',1);
define('LT_PARAM_FUNC',2);
define('LT_UNPARAM_FUNC',3);
define('LT_NAME',4);
define('LT_OPERATOR',5);
define('LT_CHARACTER',6);
define('LT_EVENT',7);
define('LT_NUMBER',8);

define('PT_EXPRESSION',1);
define('PT_NAME',2);
define('PT_NONE',3);

class TTemplateParser {
    const BLOCK_NAME_EXPECTED = 1000;
    const EXPECTED = 1001;
    const UNEXPECTED = 1002;
    const TPLEND_UNEXPECTED = 1003;
    const PARAMETER_NAME_EXPECTED = 1004;
    const PARAMETER_UNSUPPORT = 1005;
    const PARAMETER_VALUE = 1006;
    const MODIFIER_NAME_EXPECTED = 1007;
    const VARIABLE_NAME = 1008;
    const SYNTAX = 1009;
    const OPERAND_EXPECTED = 1010;

    private $lexems = array(); //Массив лексем разбираемого шаблона
    private $lexem=''; //Текущая лексема
    private $lexem_type; //Тип текущей лексемы
    private $lexem_idx; //Индекс текущей лексемы в массиве лексем
    private $lexem_offset; //Позиция текущей лексемы в шаблоне. Выводится в сообщениях об ошибке
    private $tpl; //Текущий компилируемый шаблон
    private $tpl_line; //Номер строки, на которой находится текущий шаблон
    private $tpl_col; //Номер позиции текущего шаблона в строке
    static $PRIORITIES = array(
        '&&'=>10, '||'=>10, 'or'=>10, 'and'=>10,
        '=='=>20, '!='=>20,
        '>='=>30, '<='=>30, '<'=>30, '>'=>30,
        '+'=>40, '-'=>40, '.'=>40,
        '/'=>50, '*'=>50, '%'=>50,
        '?'=>60,
        '!'=>70,
        '['=>80, '->'=>80, '#'=>80, '^'=>80
    );
    static $TPL_PARAM_FUNCS = array(
        'foreach'=>array('from'=>PT_EXPRESSION, 'item'=>PT_NAME, 'key'=>PT_NAME, 'name'=>PT_NAME),
        'for'=>array('start'=>PT_EXPRESSION,'max'=>PT_EXPRESSION,'step'=>PT_EXPRESSION,'name'=>PT_NAME),
        'assign'=>array('var'=>PT_NAME, 'value'=>PT_EXPRESSION)
    );
    static $TPL_PARAMLESS_FUNCS = array(
        'if'=>PT_EXPRESSION,
        'elseif'=>PT_EXPRESSION,
        'else'=>PT_NONE,
        'section'=>PT_EXPRESSION,
        'objects'=>PT_NONE,
    );
    static $TPL_BLOCK_FUNCS = array('if','foreach','for');
    protected function fetchLinesPos(&$tpl){
        preg_match_all('/\\n/',$tpl,$m,PREG_OFFSET_CAPTURE);
        $lines=array(1);
        foreach($m[0] as $lf){ $lines[] = $lf[1];}
        $this->lines = $lines;
    }
    protected function getLineAndCol($pos){
        $k = 1; while($k<count($this->lines) && $pos>$this->lines[$k]) $k++;
        $this->tpl_line = $k; $this->tpl_col = $pos-$this->lines[$k-1];
    }
    public function getCFGTree($tpl){
        $this->fetchLinesPos($tpl);
        $parts = preg_split('/\\{\\{(.+?)\\}\\}/',$tpl,-1,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_OFFSET_CAPTURE);
        $count = count($parts);
        $tree = array();
        for($i=1;$i<$count;$i=$i+2){
            $this->getLineAndCol($parts[$i][1]);
            $tree[] = $this->parseTemplate(trim($parts[$i][0]));
        }
        $html = '';
        foreach ($tree as $tpl) {$html .= $tpl->toHTML();}
        return $html;
    }
    public function compile($tpl){
        $this->fetchLinesPos($tpl);
        $parts = preg_split('/\\{\\{(.+?)\\}\\}/',$tpl,-1,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_OFFSET_CAPTURE);
        $count = count($parts);
        for($i=0,$s='',$c="var __r='';\n";$i<$count;$i++){
            if ($i % 2) {
                $this->getLineAndCol($parts[$i][1]);
                $el = $this->parseTemplate(trim($parts[$i][0]));
                $r = $el->compile();
                $s .= $r[0];
                $c .= $r[1]."\n";
            }
            else{
                $s .= $parts[$i][0];
                $str = addslashes(str_replace("\n",'',$parts[$i][0]));
                $str = preg_replace("/[ \n\t\r]+/",' ',$str);
                if ($parts[$i][0] && $str) $c .= '__r+="'.$str."\";\n";
            }
        }
        $c .= 'return __r;';
        $cuses = join(',',TFunction::$cient_uses);
        $suses = join(',',TFunction::$srv_uses);
        if ($cuses)  $c = "//uses $cuses\n".$c;
        if ($suses)  $s = "<?//uses $cuses ?>\n".$s;
        return array($s,$c);
    }

    private function parseTemplate($tpl){
        $this->lexem_idx = -1;
        $this->tpl = $tpl;
        $paramfuncs = join('|',array_keys(TTemplateParser::$TPL_PARAM_FUNCS));
        $unparamfuncs = join('|',array_keys(TTemplateParser::$TPL_PARAMLESS_FUNCS));
        preg_match_all('/\s*(?: #Пропустить все начальные пробельные символы для всех альтернатив
           (?:^('.$paramfuncs.'))| # 1-функции шаблона с именоваными параметрами
           (?:^('.$unparamfuncs.'))| # 2-функции шаблона с безымянным параметром
           ((?:"(?:[^"\\\\]|\\\\.)*")|(?:\'(?:[^\'\\\\]|\\\\.)*\'))| #3- строки
           (\\d+(?:\\.\\d+)*)| #4 - числа
           (->|==|>=|<=|!=|&&|\\|\\||or|and|[<>[.?+\\-*\\/!#^%])| # 5 - операторы
           ([_a-zA-Z]+[_a-zA-Z0-9]*)| # 6-имена
           (^\\@$)| # 7-события
           (\\S) # 8-Любой другой символ, не удовлетворяющий ни одной из предыдущих альтернатив
        )/Sxi',$tpl,$this->lexems,PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
        $this->getNextLexem();
        switch ($this->lexem_type) {
            case LT_PARAM_FUNC: {$root = $this->parseTemplateParamFuncs(); break;}
            case LT_UNPARAM_FUNC: {$root = $this->parseTemplateUnparamFuncs(); break;}
            case LT_NUMBER:
            case LT_STRING: {$root = $this->parseTemplateExpression(); break;}
            case LT_OPERATOR: {
                switch ($this->lexem){
                    case '/': return $this->parseTemplateBlockEnd();
                    case '-': return $this->parseTemplateExpression();
                    default: $this->syntaxErrorUnexpected();
                }
            }
            case LT_NAME: {$root = $this->parseTemplateExpression(); break;}
            case LT_EVENT: {$root = $this->parseTemplateEvent(); break;}
            case LT_CHARACTER: {
                if ($this->lexem=='$' || $this->lexem=='(') $root = $this->parseTemplateExpression();
                else $this->syntaxErrorUnexpected();
                break;
            }
            default:$this->syntaxErrorUnexpected();
        }
        return $root;
    }
    private function parseTemplateEvent(){
        return new TEvent($this->tpl_line,$this->tpl_col);
    }
    private function parseTemplateBlockEnd(){
        $this->getNextLexem();
        if($this->lexem_type != LT_NAME)  $this->_throwError(self::BLOCK_NAME_EXPECTED);
        $func = $this->lexem;
        if(!in_array($func,TTemplateParser::$TPL_BLOCK_FUNCS)) {
            $bf = '"'.join('","',TTemplateParser::$TPL_BLOCK_FUNCS).'"';
            $this->_throwError(self::EXPECTED,$bf);
        }
        $this->getNextLexem();
        if($this->lexem_type != LT_END) $this->syntaxErrorUnexpected();
        return  new TTemplateBlockEnd($func,$this->tpl_line,$this->tpl_col);
    }
    private function getNextLexem(){
        if ($this->lexem_idx<count($this->lexems)-1){
            $el = $this->lexems[++$this->lexem_idx];
            if($el[1][1] >= 0){
                $this->lexem=$el[1][0];
                $this->lexem_offset=$el[1][1];
                $this->lexem_type=LT_PARAM_FUNC;
            }
            elseif($el[2][1] >= 0){
                $this->lexem=$el[2][0];
                $this->lexem_offset=$el[2][1];
                $this->lexem_type=LT_UNPARAM_FUNC;
            }
            elseif($el[3][1]>=0){
                $this->lexem=$el[3][0];
                $this->lexem_offset=$el[3][1];
                $this->lexem_type=LT_STRING;
            }
            elseif($el[4][1]>=0){
                $this->lexem=$el[4][0];
                $this->lexem_offset=$el[4][1];
                $this->lexem_type=LT_NUMBER;
            }
            elseif($el[5][1]>=0){
                $this->lexem=$el[5][0];
                $this->lexem_offset=$el[5][1];
                $this->lexem_type=LT_OPERATOR;
            }
            elseif($el[6][1]>=0){
                $this->lexem=$el[6][0];
                $this->lexem_offset=$el[6][1];
                $this->lexem_type=LT_NAME;
            }
            elseif($el[7][1]>=0){
                $this->lexem=$el[7][0];
                $this->lexem_offset=$el[7][1];
                $this->lexem_type=LT_EVENT;
            }
            else{
                $this->lexem=$el[8][0];
                $this->lexem_offset=$el[7][1];
                $this->lexem_type=LT_CHARACTER;
            }
        }else{
            $this->lexem='';
            $this->lexem_offset=strlen($this->tpl);
            $this->lexem_type=LT_END;
        }
    }
    private function parseTemplateParamFuncs(){
        $func = $this->lexem;
        $this->getNextLexem();
        $params = array();
        $fdef = &TTemplateParser::$TPL_PARAM_FUNCS[$func];
        while ($this->lexem_type != LT_END){
            if ($this->lexem_type != LT_NAME) $this->_throwError(self::PARAMETER_NAME_EXPECTED);
            $key = $this->lexem;
            if (!isset($fdef[$key])) $this->_throwError(self::PARAMETER_UNSUPPORT,$key);
            $this->getNextLexem();
            if ($this->lexem != '=') $this->_throwError(self::EXPECTED,'=');
            $this->getNextLexem();
            switch ($fdef[$key]){
                case PT_EXPRESSION: {$params[$key] = $this->parseExpression(); break;}
                case PT_NAME: {
                    if($this->lexem_type != LT_NAME) $this->_throwError(self::PARAMETER_VALUE,$key);
                    $params[$key] = $this->lexem;
                    $this->getNextLexem(); break;
                }
            }
        }
        return new TTemplateFunction($func,$params,$this->tpl_line,$this->tpl_col);
    }
    private function parseTemplateUnparamFuncs(){
        $func = $this->lexem;
        $this->getNextLexem();
        $param = null;
        if($this->lexem_type != LT_END) {
            switch (TTemplateParser::$TPL_PARAMLESS_FUNCS[$func]){
                case PT_EXPRESSION: {$param = $this->parseExpression(); break;}
                case PT_NAME: {$param = $this->lexem; $this->getNextLexem(); break;}
                case PT_NONE: $this->syntaxErrorUnexpected();
            }
            if($this->lexem_type != LT_END) $this->syntaxErrorUnexpected();
        }
        return new TTemplateFunction($func,array($param),$this->tpl_line,$this->tpl_col);
    }
    private function parseTemplateExpression(){
        $expr = $this->ParseExpression();
        while ($this->lexem=='|') {
            $this->getNextLexem();
            if($this->lexem_type != LT_NAME) $this->_throwError(self::MODIFIER_NAME_EXPECTED);
            $modname = $this->lexem;
            $this->getNextLexem();
            $params = array();
            while ($this->lexem==':'){
                $this->getNextLexem();
                $params[] = $this->parseExpression();
            }
            array_unshift($params,$expr);
            $expr = new TFunction($modname,$this->lexem_offset,$params);
        }
        if ($this->lexem_type != LT_END) $this->syntaxErrorUnexpected();
        return new TTemplateExpression($expr,$this->tpl_line,$this->tpl_col);
    }
    private function parseFirst(){
        switch ($this->lexem_type){
            case LT_NUMBER:
            case LT_STRING: return $this->parseConstant();
            case LT_NAME: return $this->parseName();
            case LT_OPERATOR: {
                switch($this->lexem){
                    case '!': return $this->parseOperathor(0,null);
                    case '-': {
                        $this->getNextLexem();
                        if($this->lexem_type != LT_NUMBER) $this->syntaxErrorUnexpected();
                        $this->lexem = '-'.$this->lexem;
                        return $this->parseConstant();
                    }
                }
            }
            case LT_CHARACTER:{
                switch($this->lexem){
                    case '$': return $this->parseVariable();
                    case '(': return $this->parseParenExpr();
                }
            }
            default: $this->syntaxErrorUnexpected();
        }
    }
    private function parseVariable(){
        $this->getNextLexem();
        if($this->lexem_type != LT_NAME) $this->_throwError(self::VARIABLE_NAME);
        $var = $this->lexem;
        $this->getNextLexem();
        return new TVariable($var,$this->lexem_offset,null);
    }
    private function parseExpression(){
        $lopr = $this->parseFirst();
        return $this->parseOperathor(0,$lopr);
    }
    private function parseOperathor($prioriti,$lopr){
        while(1){
            if($this->lexem_type != LT_OPERATOR) return $lopr;
            $binop = $this->lexem;
            $lexpr1 = TTemplateParser::$PRIORITIES[$binop];
            if ($lexpr1<$prioriti) return $lopr;
            $this->getNextLexem();
            if($binop == '->' and $this->lexem=='(') $this->syntaxErrorUnexpected();
            if($binop == '['){
                $ropr = $this->parseExpression();
                if($this->lexem !=']') $this->_throwError(self::EXPECTED,']');
                $this->getNextLexem();
            }
            elseif($binop == '?'){
                $yes = $this->parseExpression();
                if($this->lexem !=':') $this->_throwError(self::EXPECTED,':');
                $this->getNextLexem();
                $no = $this->parseExpression();
                $ropr = new TAltervatives(':',$this->lexem_offset,array($yes,$no));
            }
            elseif($binop == '^'){
                $ropr = null;
            }
            else $ropr = $this->parseFirst();
            if($this->lexem_type == LT_OPERATOR and $lexpr1<(TTemplateParser::$PRIORITIES[$this->lexem]) ){
                $ropr = $this->parseOperathor($lexpr1+1,$ropr);
            }
            if (!$lopr && $ropr)  $lopr = new TLeftUnaryOperator($binop,$this->lexem_offset,array($ropr));
            elseif($lopr && $ropr) $lopr = new TBinOperator($binop,$lexpr1,$this->lexem_offset,array($lopr,$ropr));
            elseif($lopr && !$ropr) $lopr = new TRightUnaryOperator($binop,$this->lexem_offset,array($lopr));
            else $this->_throwError(self::OPERAND_EXPECTED);
        }
    }
    private function parseConstant(){
        $r = new TConstant($this->lexem,$this->lexem_offset,null);
        $this->getNextLexem();
        return $r;
    }
    private function parseParenExpr(){
        $this->getNextLexem();
        $r = $this->parseExpression();
        if ($this->lexem != ')') $this->_throwError(self::EXPECTED,')');
        $this->getNextLexem();
        switch ($this->lexem_type){
            case LT_END: return $r;
            case LT_OPERATOR: if (!in_array($this->lexem,array('->','[','#')) ) return $r;
            default: $this->syntaxErrorUnexpected();
        }
        return $r;
    }
    private function parseName(){
        $name = $this->lexem;
        $this->getNextLexem();
        if($this->lexem == '('){ //Функция
            $this->getNextLexem();
            $args = array();
            if ($this->lexem != ')'){
                while(1){
                    $args[] = $this->parseExpression();
                    if($this->lexem == ')') break;
                    if($this->lexem != ',') $this->_throwError(self::EXPECTED,',');
                    $this->getNextLexem();
                }
            }
            $this->getNextLexem();
            return new TFunction($name,$this->lexem_offset,$args);
        }
        else{
            return new TName($name,$this->lexem_offset,null);
        }
    }

    private function syntaxErrorUnexpected(){
        if($this->lexem_type == LT_END) $this->_throwError(self::TPLEND_UNEXPECTED);
        else $this->_throwError(self::UNEXPECTED,$this->lexem);
    }
    protected function _throwError(){
        $a = func_get_args();
        $code = $a[0];
        $l = $this->tpl_line;
        $c = $this->tpl_col+$this->lexem_offset;
        switch ($code){
            case self::BLOCK_NAME_EXPECTED: {$msg = "Block name expected at line:$l col:$c"; break;}
            case self::EXPECTED: {$msg = "'$a[1]' expected at line:$l col:$c" ;break;}
            case self::UNEXPECTED: {$msg = "Unexpected lexem '$a[1]' at line:$l col:$c";break;}
            case self::TPLEND_UNEXPECTED: {$msg = "Unexpected end of template at line:$l col:$c" ;break;}
            case self::PARAMETER_NAME_EXPECTED: {$msg = "Parameter name expected at line:$l col:$c" ;break;}
            case self::PARAMETER_UNSUPPORT: {$msg = "Paramemet '$a[1]' unsupport at line:$l col:$c";break;}
            case self::PARAMETER_VALUE: {$msg = "Invalid parameter '$a[1]' value at line:$l col:$c"; break;}
            case self::MODIFIER_NAME_EXPECTED: {$msg = "Modifier name expected at line:$l col:$c" ;break;}
            case self::VARIABLE_NAME: {$msg = "Variable name expected at line:$l col:$c";break;}
            case self::SYNTAX: {$msg = "Syntax error at line:$l col:$c" ;break;}
            case self::OPERAND_EXPECTED: {$msg = "Operand expected at line:$l col:$c" ;break;}
            default: $msg = 'Unknown error';
        }
        throw new Exception($msg,$code);
    }
}
?>