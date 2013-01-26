<?
class ETreeError extends Exception{
    const OPERAND_TYPE = 1100;
    const EXPRESSIOIN_EXPECTED = 1101;
    const PARAMETER_REQUIRED = 1102;
    const BLOCK_END = 1103;
    const UNKNOWN_FUNCTION = 1104;
    const INVALID_PARAMEMET_TYPE = 1105;
    const UNKNOWN_OPERATHOR = 1106;
    public function ETreeError(){
        $a = func_get_args();
        $code = $a[0];
        switch ($code){
           case self::OPERAND_TYPE: {$msg = "Invalid operand type for '$a[1]' at line:$a[2], offset:$a[3]"; break;}
           case self::EXPRESSIOIN_EXPECTED: {$msg = "Valid expression expected at line:$a[1], offset:$a[2]" ;break;}
           case self::PARAMETER_REQUIRED: {$msg = "Parameter '$a[1]' required at line:$a[1], offset:$a[2]" ;break;}
           case self::BLOCK_END: {$msg = "\{\{/$a[1]\}\} without \{\{$a[1]\}\} at line:$a[1], offset:$a[2]" ;break;}
           case self::UNKNOWN_FUNCTION: {$msg = "Unknown function '$a[1]'" ;break;}
           case self::INVALID_PARAMEMET_TYPE: {$msg = "Invalid parameter type" ;break;}
           case self::UNKNOWN_OPERATHOR: {$msg = "Unknown operathor at line:$a[1], offset:$a[2]" ;break;}
           default: $msg = 'Unknown error';
        }
        parent::__construct($msg,$code);
    }
};
abstract class TCFGTreeItem {
    public $item;
    protected $_children;
    protected $_pos;
    public abstract function getCompiledExpression();
    public function __construct($_item,$pos,$_children){
        $this->item = $_item;
        $this->_children = $_children;
        $this->_pos = $pos;
    }
    public function toHTML(){
        $html = '<p>'.get_class($this).'('.$this->item.')'.'</p>';
        if($this->_children){
            $html .= '<div>';
            foreach ($this->_children as $mod ) if($mod) /** @noinspection PhpUndefinedMethodInspection */
                $html .= $mod->toHTML();
            $html.= '</div>';
        }
        return $html;
    }
    protected function errorInvalidItem(){
        $l = TTemplate::$curent_line;
        $c = TTemplate::$curent_col+$this->_pos;
        throw new ETreeError(ETreeError::OPERAND_TYPE,$this->item,$l,$c);
    }
}
// TName - имя компонента или свойства компонента
// item - Имя
class TName extends TCFGTreeItem{
    public function getCompiledExpression(){
        $l = TTemplate::$curent_line;
        $c = TTemplate::$curent_col+$this->_pos;
        throw new ETreeError(ETreeError::EXPRESSIOIN_EXPECTED,$l,$c);
    }
}
class TConstant extends TExpressionItem{
    public function getCompiledExpression(){return array($this->item, $this->item);}
}
class TBinOperator extends TExpressionItem{
    public $priority = 0;
    public function __construct($_item,$_prior,$_pos,$_children){
        parent::__construct($_item,$_pos,$_children);
        $this->priority = $_prior;
    }
    public function getCompiledExpression(){
        $op = $this->item;
        switch($op){
            case '->': return $this->compileProperty();
            case '#': return $this->compileModelField();
            case '[': return $this->compileArrayElement();
            case '?': return $this->compileTernary();
            case 'or': $this->item = '||';
            case 'and': $this->item = '&&';
            default: return $this->compileCommonOperathor();
        }
    }
    private function compileTernary(){
        $lclass = get_class($this->_children[0]);
        if(!is_subclass_of($lclass,'TExpressionItem')) $this->$this->errorInvalidItem();
        $rclass = get_class($this->_children[1]);
        if(!$lclass==='TAlternatives') $this->$this->errorInvalidItem();
        $r = $this->_children[0]->getCompiledExpression();
        $a = $this->_children[1]->getCompiledExpression();
        return array($r[0].'?'.$a[0],$r[1].'?'.$a[1]);
    }
    private function compileArrayElement(){
        $lclass = get_class($this->_children[0]);
        if ($lclass == 'TFunction' || $lclass == 'TVariable' ||
        ($lclass == 'TBinOperator' && ($this->_children[0]->priority >= $this->priority))){
            $lop =  $this->_children[0]->getCompiledExpression();
           }
        else  $this->errorInvalidItem();
        if (get_class($this->_children[1])=='TName'){
            $i = '\''.$this->_children[1]->item.'\'';
            $rop = array($i,$i);
        } else  $rop = $this->getOperand($this->_children[1],false);
        return array('$cmp->item('.$lop[0].','.$rop[0].')',$lop[1].'['.$rop[1].']');
    }
    private function compileCommonOperathor(){
        $lop = $this->getOperand($this->_children[0]);
        $rop = $this->getOperand($this->_children[1]);
        $sop = $cop = $this->item;
        if ($cop == '.') $cop = '+';
        return array($lop[0].$sop.$rop[0],$lop[1].$cop.$rop[1]);
    }
    private function compileComponent(){
        $lclass = get_class($this->_children[0]);
        if ($lclass == 'TName'){
            $comp = $this->_children[0]->item;
            if($comp == 'this') return array('$cmp','this');
            else return array('jq::get(\''.$comp.'\')','jq.get(\''.$comp.'\')');
        }
        elseif ($lclass == 'TFunction' || $lclass == 'TVariable' || $lclass == 'TRightUnaryOperator' ||
        ($lclass == 'TBinOperator' && ($this->_children[0]->priority >= $this->priority))){
            return $this->_children[0]->getCompiledExpression();
        }
        else $this->errorInvalidItem();
    }
    private function compileProperty(){
        $c = $this->compileComponent();
        $rclass = get_class($this->_children[1]);
        if($rclass == 'TName'){
            $p = $this->_children[1]->item;
            return array($c[0].'->'.$p,$c[1].'.'.$p);
        }
        elseif($rclass == 'TFunction'){
            $p = $this->_children[1]->getCompiledExpression();
            return array($c[0].'->'.$p[0],$c[1].'.'.$p[1]);
        }
        elseif($rclass == 'TVariable'){
            $var = $this->_children[1]->item;
            return array($c[0].'->$'.$var, $c[1].'['.$var.']');
        }
        else $this->errorInvalidItem();
    }
    private function compileModelField(){
        $c = $this->compileComponent();
        $rclass = get_class($this->_children[1]);
        if($rclass == 'TName'){
            $f = $this->_children[1]->item;
            return array($c[0].'->getField(\''.$f.'\')',$c[1].'.getField(\''.$f.'\')');
        }
        elseif($rclass == 'TVariable' || $rclass == 'TFunction'){
            $f = $this->_children[1]->getCompiledExpression();
            return array($c[0].'->getField('.$f[0].')',$c[1].'.getField('.$f[1].')');
        }
        else  $this->errorInvalidItem();
    }
    private function getOperand(TCFGTreeItem $child,$paren=true){
        $cclass = get_class($child);
        if (!is_subclass_of($cclass,'TExpressionItem')) $this->errorInvalidItem();
        $expr = $child->getCompiledExpression();
        if ($paren && $cclass=='TBinOperator' && $this->priority > $child->priority)
            return array('('.$expr[0].')','('.$expr[1].')');
            else return $expr;
    }
}
class TLeftUnaryOperator extends TExpressionItem{
    public function getCompiledExpression(){throw new Exception(get_class($this).' is under construction',1);}
}
class TRightUnaryOperator extends TExpressionItem{
    public function getCompiledExpression(){
        if ($this->item==='^'){
            $lclass = get_class($this->_children[0]);
            if ($lclass == 'TName'){
                $comp = $this->_children[0]->item;
                if($comp == 'this') return array('$cmp','this');
                else return array('jq::get(\''.$comp.'\')','jq.get(\''.$comp.'\')');
            }
            elseif ($lclass == 'TFunction' || $lclass == 'TVariable'||($lclass == 'TBinOperator')){
                $r = $this->_children[0]->getCompiledExpression();
                return array('jq::get('.$r[0].')','jq.get('.$r[1].')');
            }
            else $this->errorInvalidItem();
        }
        else {
            $l = TTemplate::$curent_line;
            $c = TTemplate::$curent_col+$this->_pos;
            new ETreeError(ETreeError::UNKNOWN_OPERATHOR,$l,$c);
        }
    }
}
// TFunction - вызов функции или метода компонента
// item - Имя функции или метода
// children[0..n] - ссылки на аргументы
class TFunction extends TExpressionItem{
    static $cient_uses = array();
    static $srv_uses = array();
    public function __construct($_item,$pos,$_children){
        parent::__construct($_item,$pos,$_children);
    }
    public function getCompiledExpression(){
        $sarg = $carg = array();
        foreach($this->_children as $arg) {
            $r = $arg->getCompiledExpression();
            $sarg[] = $r[0]; $carg[] = $r[1];
        }
        $s = $this->_getServerExpression($sarg);
        $c = $this->_getClientExpression($carg);
        return array ($s,$c);
    }
    private function _getServerExpression($args){
        switch($this->item){
            case 'escape':return 'htmlspecialchars('.$args[0].',ENT_QUOTES)';
            case 'inArray':return 'in_array('.join(',',$args).')';
            case 'ceil':return 'ceil('.$args[0].')';
            case 'bbDecode':return 'bbDecode('.$args[0].')';
            case 'isCoreClass':return 'isCoreClass('.$args[0].')';
            case 'count':return 'count('.$args[0].')';
            case 'ifNull':return 'is_null('.$args[0].')?'.$args[1].':'.$args[0];
            case 'isKeyExists':return 'array_key_exists('.$args[1].','.$args[0].')';
            default:throw new ETreeError(ETreeError::UNKNOWN_FUNCTION,$this->item);
        }
    }
    private function _getClientExpression($args){
        switch($this->item){
            case 'escape':{$this->_register(); return 'jq.ex.escape('.$args[0].')';}
            case 'inArray':{$this->_register(); return 'jq.ex.inArray('.join(',',$args).')';}
            case 'ceil':return 'Math.ceil('.$args[0].')';
            case 'bbDecode':{$this->_register(); return 'jq.ex.bb.decode('.$args[0].')';}
            case 'isCoreClass':{$this->_register(); return 'jq.ex.isCoreClass('.$args[0].')';}
            case 'count': return $args[0].'.length';
            case 'ifNull': return '('.$args[0].'==null)?'.$args[1].':'.$args[0];
            case 'isKeyExists': return '('.$args[0].'['.$args[1].']!=undefined)';
            default:throw new ETreeError(ETreeError::UNKNOWN_FUNCTION,$this->item);
        }
    }
    private function _register($client=true){
        if($client) TFunction::$cient_uses[] = $this->item;
        else TFunction::$cient_uses[] = $this->item;
    }
}
class TAltervatives extends TCFGTreeItem{
    public function getCompiledExpression(){
        $lclass = get_class($this->_children[0]);
        if(!is_subclass_of($lclass,'TExpressionItem')) $this->$this->errorInvalidItem();
        $rclass = get_class($this->_children[1]);
        if(!is_subclass_of($lclass,'TExpressionItem')) $this->$this->errorInvalidItem();
        $r1 = $this->_children[0]->getCompiledExpression();
        $r2 = $this->_children[1]->getCompiledExpression();
        return array($r1[0].':'.$r2[0],$r1[1].':'.$r2[1]);
    }
}
class TObject extends TCFGTreeItem{
    public function getCompiledExpression(){throw new Exception(get_class($this).' is under construction',1);}
}
class TVariable extends TExpressionItem{
    public function getCompiledExpression(){return array('$'.$this->item,$this->item); }
}


abstract class TExpressionItem extends TCFGTreeItem {}
abstract class TTemplate{
    static $avn = 0; // Номер последней автоматической переменной. Им всем даются имена вида __var2
    static $blocks = array(); //стек активных блоков
    static $curent_line;
    static $curent_col;
    protected $line;
    protected $col;
    abstract function getCompiledExpression();
    protected  function getAutoVar(){return '__var'.TTemplate::$avn++;}
    public function compile(){
        TTemplate::$curent_line = $this->line;
        TTemplate::$curent_col = $this->col;
        return $this->getCompiledExpression();
    }
}
class TEvent extends TTemplate{
    public function __construct($l,$c){
        $this->line = $l;
        $this->col = $c;
    }
    public function getCompiledExpression(){
        $cexp = '__r+="jq.get(\'"+this.name+"\')."';
        $sexp = 'jq.get(\'<?=$cmp->name?>\').';
        return array($sexp, $cexp);
    }
}
class TTemplateExpression extends TTemplate {
    private $expression;
    public function getCompiledExpression(){
        $cclass = get_class($this->expression);
        if (!is_subclass_of($cclass,'TExpressionItem')) {
            $l = TTemplate::$curent_line;
            $c = TTemplate::$curent_col;
            throw new ETreeError(ETreeError::EXPRESSIOIN_EXPECTED,$l,$c);
        }
        $expr = $this->expression->getCompiledExpression();
        return(array('<? echo('.$expr[0].')?>', '__r+='.$expr[1].';'));
    }
    public function __construct($_exp,$l,$c){
        $this->expression = $_exp;
        $this->line = $l;
        $this->col = $c;
    }
    public function toHTML(){
        $html = '<p>'.get_class($this).'</p><div><p>Expression</p>';
        if($this->expression){
            $html .= '<div>'.$this->expression->toHTML().'</div>';
        }
        $html.= '</div>';
        return $html;
    }
}
class TTemplateFunction extends TTemplate {
    private $name;
    private $parameters = null;

    public function __construct($_name,$_params,$l,$c){
        $this->name = $_name;
        $this->parameters = $_params;
        $this->line = $l;
        $this->col = $c;
    }
    public function getCompiledExpression(){
        switch ($this->name){
            case 'foreach': return $this->compileForeach();
            case 'for': return $this->compileFor();
            case 'assign': return $this->compileAssign();
            case 'if': return $this->compileIfStatment();
            case 'elseif': return $this->compileElseifStatment();
            case 'else': return array('<?}else{?>','}else{');
            case 'section': return $this->compileSectionStatment();
            case 'objects': return array('<? $cmp->drawComponents() ?>','');
        }
        throw new ETreeError(ETreeError::UNKNOWN_FUNCTION,$this->name,1);
    }
    private function compileIfStatment(){
        $cond = $this->parameters[0]->getCompiledExpression();
        TTemplate::$blocks['if'][]=1;
        return array("<? if($cond[0]){?>","if($cond[1]){");
    }
    private function compileAssign(){
        $p = &$this->parameters;
        if(!isset($p['var'])) $this->errorRequiredParam('var');
        if(!isset($p['value'])) $this->errorRequiredParam('value');
        $r = $p['value']->getCompiledExpression();
        return array("<? \${$p['var']}=$r[0]; ?>","var {$p['var']}=$r[1];");
    }
    private function compileSectionStatment(){
        $cond = $this->parameters[0]->getCompiledExpression();
        return array("<? \$cmp->drawSection($cond[0]) ?>","\$this.drawSection($cond[1]);");
    }
    private function compileElseifStatment(){
        $cond = $this->parameters[0]->getCompiledExpression();
        return array("<?}elseif($cond[0]){?>","}else if($cond[1]){");
    }
    private function compileForeach(){
        $p = &$this->parameters;
        if(!isset($p['from'])) $this->errorRequiredParam('from');
        if(!isset($p['item'])) $this->errorRequiredParam('item');
        if(!isset($p['name'])) $p['name'] = $this->getAutoVar();
        TTemplate::$blocks['foreach'][]=$p['name'];
        if (isset($p['key'])) {
             $skey ='$'.$p['key'].'=>';
             $ckey =$p['key'];
             $ckey1 = 'var '.$ckey;
        }
        else {
             $skey ='';
             $ckey = $ckey1 = $p['name'].'.k';
        }
        $r = $p['from']->getCompiledExpression();
        $s= "<? \${$p['name']} = array('index'=>-1,'from'=>{$r[0]});\n".
        "foreach(\${$p['name']}['from'] as $skey\${$p['item']}) {\n".
        "\${$p['name']}['index']++;?>";
        $c ="var {$p['name']} = {from:$r[1], index:-1};\n".
        "for($ckey1 in {$p['name']}.from) {\n".
        "var {$p['item']} = {$p['name']}.from[$ckey]; {$p['name']}.index++;";
        return array($s,$c);
    }
    private function compileFor(){
        $p = &$this->parameters;
        $start = isset($p['start'])? $p['start']->getCompiledExpression(): array(0,0);
        $step = isset($p['step'])? $p['step']->getCompiledExpression(): array(1,1);
        if(!isset($p['max'])) $this->errorRequiredParam('max');
        $max = $p['max']->getCompiledExpression();
        if(!isset($p['name'])) $p['name'] = $this->getAutoVar();
        TTemplate::$blocks['for'][]=$p['name'];

        $s= "<? \${$p['name']} = array('start'=>{$start[0]},'max'=>{$max[0]},'step'=>{$step[0]});\n".
        "\${$p['name']}['index'] = \${$p['name']}['start']-\${$p['name']}['step'];\n".
        "while((\${$p['name']}['index']+=\${$p['name']}['step'])<\${$p['name']}['max']){?>";
        $c ="var {$p['name']} = {start:$start[1], max:$max[1], step:$step[1]};\n".
        "{$p['name']}.index = {$p['name']}.start - {$p['name']}.step;\n".
        "while(({$p['name']}.index += {$p['name']}.step)<{$p['name']}.max){";
        return array($s,$c);
    }
    public function toHTML(){
        $html = '<p>'.get_class($this).'('.$this->name.')</p>';
        if($this->parameters){
            $html.= '<div><p>Parameters</p><div>';
            foreach ($this->parameters as $key=>$param ){
                if(is_object($param)) $html .= $key.'='.$param->toHTML();
                elseif(is_string($param)) $html .= '<p>'.$key.'='.$param.'</p>';
                elseif(is_null($param)) $html .= '<p>Nothing</p>';
                else throw new ETreeError(ETreeError::INVALID_PARAMEMET_TYPE);
            }
            $html.= '</div></div>';
        }
        return $html;
    }
    protected function errorRequiredParam($name){
        $l = TTemplate::$curent_line;
        $c = TTemplate::$curent_col;
        throw new ETreeError(ETreeError::PARAMETER_REQUIRED,$name,$l,$c);
    }
}
class TTemplateBlockEnd extends TTemplate {
    private $name;
    public function __construct($_name,$l,$c){
        $this->name = $_name;
        $this->line = $l;
        $this->col = $c;
    }
    public function getCompiledExpression(){
        if (!isset(TTemplate::$blocks[$this->name]) || !TTemplate::$blocks[$this->name]){
            $l = TTemplate::$curent_line;
            $c = TTemplate::$curent_col;
            throw new ETreeError(ETreeError::BLOCK_END,$this->name,$l,$c);
        }
        array_pop(TTemplate::$blocks[$this->name]);
        return array('<?}?>','}');
    }
    public function toHTML(){
        $html = '<p>'.get_class($this).'('.$this->name.')</p>';
        return $html;
    }
}
?>