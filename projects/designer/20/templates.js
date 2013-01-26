jq.attachMethod('template','js_editor',function(){
//uses escape
var __r='';
__r+="<div class=\"cmdpanel\"><div onclick=\"jq.get(\'js_editor\').save()\">Сохранить</div></div><div class=\'content\'><textarea spellcheck=\'false\'>";
__r+=jq.ex.escape(this.jsmodel.getField('js'));
__r+="</textarea></div>";
return __r;
});//js_editor.template
jq.attachMethod('template','tpleditor',function(){
//uses escape
var __r='';
if(this.tplmodel.count==1){
__r+="<div class=\"cmdpanel\"><div onclick=\"jq.get(\'tpleditor\').save(this)\">Сохранить</div><div onclick=\"showtree()\">Дерево</div></div><div class=\"content\"><textarea class=\"scrollbox\" spellcheck=\"false\">";
__r+=jq.ex.escape(this.tplmodel.getField('tpl'));
__r+="</textarea></div>";
}
return __r;
});//tpleditor.template
jq.attachMethod('template','prpeditor',function(){
//uses escape,escape,escape
var __r='';
__r+="<div class=\"cmdpanel\"><div onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="save()\" id=";
__r+=this.name;
__r+=".indicator>Сохранить</div></div>";
if(this.prpmodel.count>0){
__r+="<form onsubmit=\"return false;\"><ul class=\"content\"> ";
var lp = {from:this.prpmodel.rows, index:-1};
for(lp.k in lp.from) {
var prp = lp.from[lp.k]; lp.index++;
__r+=" <li>";
__r+=prp['n'];
__r+="<div> ";
if(prp['t']=='boolean'){
__r+=" <input type=\"checkbox\" ";
if(prp['v']>0){
__r+="checked";
}
__r+=" onchange=\"";
__r+="jq.get('"+this.name+"')."
__r+="prpchange(";
__r+=lp['index'];
__r+=",this)\" name=\"";
__r+=prp['n'];
__r+="\"> ";
}else if(prp['t']=='text'||prp['t']=='object'){
__r+=" <div class = \"obj\"> <textarea rows=1 onchange=\"";
__r+="jq.get('"+this.name+"')."
__r+="prpchange(";
__r+=lp['index'];
__r+=",this)\" name=\"";
__r+=prp['n'];
__r+="\">";
__r+=jq.ex.escape(prp['v']);
__r+="</textarea> </div> <div class=\'expand_btn\' onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="showEditor(\'";
__r+=prp['n'];
__r+="\',";
__r+=lp['index'];
__r+=")\"></div> ";
}else if(prp['t']=='list'){
__r+=" <select onchange=\"";
__r+="jq.get('"+this.name+"')."
__r+="prpchange(";
__r+=lp['index'];
__r+=",this)\" name=\"";
__r+=prp['n'];
__r+="\"> ";
var __var0 = {from:prp['o'], index:-1};
for(__var0.k in __var0.from) {
var opt = __var0.from[__var0.k]; __var0.index++;
__r+=" <option ";
if(opt==prp['v']){
__r+="selected";
}
__r+=">";
__r+=opt;
__r+="</option> ";
}
__r+=" </select> ";
}else if(prp['t']=='link'){
__r+=" <div class = \"obj\"> <input type=\"text\" value=\"";
__r+=jq.ex.escape(prp['v']);
__r+="\" onchange=\"";
__r+="jq.get('"+this.name+"')."
__r+="prpchange(";
__r+=lp['index'];
__r+=",this)\" spellcheck=\"false\" disabled name=\"";
__r+=prp['n'];
__r+="\"/> </div> <div class=\'expand_btn\' onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="showEditor(\'";
__r+=prp['n'];
__r+="\',";
__r+=lp['index'];
__r+=")\"></div> ";
}else{
__r+=" <input type=\"text\" value=\"";
__r+=jq.ex.escape(prp['v']);
__r+="\" onchange=\"";
__r+="jq.get('"+this.name+"')."
__r+="prpchange(";
__r+=lp['index'];
__r+=",this)\" spellcheck=\"false\" name=\"";
__r+=prp['n'];
__r+="\"/> ";
}
__r+=" </div></li> ";
}
__r+="</ul></form>";
}
return __r;
});//prpeditor.template
jq.attachMethod('template','pagetree',function(){
var __r='';
__r+="<h3>Дерево компонентов</h3>";
if(this.treemodel.count>0){
__r+="<div class=\"cmdpanel\"> <div onclick=\"jq.get(\'";
__r+=this.name;
__r+="\').deleteCmp()\" class=\"button\">Удалить</div> <div onclick=\"toggleAllCmp()\" class=\"btn_all\">Вставить компонент &gt;&gt;</div></div><div id=\"tree\">";
var tree = {from:this.treemodel.getField('tree'), index:-1};
for(tree.k in tree.from) {
var row = tree.from[tree.k]; tree.index++;
__r+=" ";
if(row['i']==0){
__r+=" <p id=\"";
__r+=this.name;
__r+=".";
__r+=tree['index'];
__r+="\" onclick=\"jq.get(\'pagetree\').select(this)\">";
__r+=row['n'];
__r+="</p> ";
}else if(row['i']==1){
__r+=" <p id=\"";
__r+=this.name;
__r+=".";
__r+=tree['index'];
__r+="\" onclick=\"jq.get(\'pagetree\').select(this)\">";
__r+=row['n'];
__r+="</p> <dl> ";
}else if(row['i']==2){
__r+=" <dt> ";
if(row['s']==-1){
__r+=" <p id=\"";
__r+=this.name;
__r+=".";
__r+=tree['index'];
__r+="\">невизуальные компоненты</p> ";
}else{
__r+=" <p id=\"";
__r+=this.name;
__r+=".";
__r+=tree['index'];
__r+="\">секция ";
__r+=row['s'];
__r+="</p> ";
}
__r+=" <dd> ";
}else if(row['i']==3){
__r+=" </dd> ";
}else if(row['i']==4){
__r+=" </dl> ";
}else if(row['i']==5){
__r+=" <p id=\"";
__r+=this.name;
__r+=".";
__r+=tree['index'];
__r+="\" onclick=\"jq.get(\'pagetree\').select(this)\">";
__r+=row['n'];
__r+="</p> ";
}
}
__r+="<hr></div>";
}
__r+="<div id = \'";
__r+=this.name;
__r+=".shield\' class=\'shield\'></div>";
return __r;
});//pagetree.template


jq.attachMethod('template','csseditor',function(){
//uses escape
var __r='';
if(this.cssmodel.count==1){
__r+="<div class=\"cmdpanel\"><div onclick=\"jq.get(\'csseditor\').save(this)\">Сохранить</div></div><div class=\"content\"><textarea class=\"scrollbox\" spellcheck=\"false\">";
__r+=jq.ex.escape(this.cssmodel.getField('css'));
__r+="</textarea></div>";
}
return __r;
});//csseditor.template


jq.attachMethod('template','php_editor',function(){
//uses escape
var __r='';
__r+="<div class=\"cmdpanel\"> <div onclick=\"jq.get(\'php_editor\').save()\">Сохранить</div></div><div class=\'content\'><textarea spellcheck=\'false\'>";
__r+=jq.ex.escape(this.phpmodel.getField('php'));
__r+="</textarea></div>";
return __r;
});//php_editor.template


jq.attachMethod('template','allcmp',function(){
var __r='';
__r+="<div>Для вставки в проект существующего компонента перетащите его в дерево разработки</div>";
var type='';
var __var0 = {from:this.model.rows, index:-1};
for(__var0.k in __var0.from) {
var row = __var0.from[__var0.k]; __var0.index++;
if(type!=row['type']){
__r+=" <h4>";
__r+=row['type'];
__r+="</h4> ";
var type=row['type'];
}
__r+="<p>";
__r+=row['name'];
__r+="</p>";
}
return __r;
});//allcmp.template


jq.attachMethod('template','linkscheckingdialog',function(){
var __r='';
__r+="<header><button onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="cancel()\">Отмена</button></header><div>";
if(this.state==2){
__r+=" <div class=\"result\"> ";
if(this.result>0){
__r+=" ";
var a=this.result%20;
__r+="В дочерней таблице есть ";
__r+=this.result%20;
__r+=" несвязанн";
__r+=a<1?'ых':a<2?'ая':a<5?'ые':'ых';
__r+=" запис";
__r+=a<1?'ей':a<2?'ь':a<5?'и':'ей';
__r+=". Ситуацию можно исправить одним из нижеуказанных способов ";
}else{
__r+="Таблицы находятся в состоянии ссылочной целостности ";
}
__r+=" </div> ";
if(this.result>0){
__r+=" <form> <div><input type=\"radio\" name=\"mode\" checked>Удалить все несвязанные записи</div> <div><input type=\"radio\" name=\"mode\">Присвоить ссылочному полю несвязанных записей NULL</div> </form> <div class=\"repair\"><button onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="repair()\">Починить</button></div> ";
}
}else{
__r+=" <div id=\"";
__r+=this.name;
__r+="_loader\">";
if(this.state==0){
__r+="Проверяю...";
}else{
__r+="Починяю...";
}
__r+="</div>";
}
__r+="</div>";
return __r;
});//linkscheckingdialog.template


jq.attachMethod('template','linkseditor',function(){
var __r='';
__r+="<div class=\"cmdpanel\"><div onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="add()\">Новая</div><div onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="remove()\">Удалить</div><div onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="edit()\">Редактировать</div><div onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="check()\">Проверка</div></div><div class=\"content\"><table><tr> <td>Потомок</td><td>&nbsp</td><td>Родитель</td></tr>";
var l = {from:this.model.rows, index:-1};
for(l.k in l.from) {
var link = l.from[l.k]; l.index++;
__r+="<tr onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="select(this,";
__r+=l['index'];
__r+=")\"> <td> ";
if(link['type']){
__r+=" <div class=\"typeimg trating\"></div> ";
__r+=link['child'];
__r+=".<wbr>";
__r+=link['lfield'];
__r+="<wbr>(";
__r+=link['rfield'];
__r+=") ";
}else{
__r+=" <div class=\"typeimg\"></div> ";
__r+=link['child'];
__r+=".<wbr>";
__r+=link['lfield'];
__r+=" ";
}
__r+=" </td> <td><div class=\"link_image";
if(link['op']=='SET NULL'){
__r+=" NULL";
}else{
__r+=" ";
__r+=link['op'];
}
__r+="\"></div></td> ";
var brake=link['service_name']=='';
__r+=" <td>";
if(link['service_name']!=''){
__r+=link['service_name'];
__r+=".<wbr>";
__r+=link['parent'];
if(link['type']){
__r+=".<wbr>";
__r+=link['tfield'];
}
}else{
__r+="???";
}
__r+=" </td></tr>";
}
__r+="</table></div>";
return __r;
});//linkseditor.template

//functions//
jq.ex.escape = function(s) {
    if(typeof s === 'number') return s;
    if(typeof s !== 'string') throw new Error('escape()\'s argument is not a string or number');
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/'/g,'&#039;').replace(/"/g,'&quot;');
};
//functions//