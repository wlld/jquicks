jq.attachMethod('template','vtopics',function(){
var __r='';
if(jq.get('mtopics').count>0){
__r+="<table><tr> <td>Тема</td> <td class=\'msgcount\'>Сообщений</dt> <td class=\'lastmsg\'>Последнее сообщение</dt> <td class=\'actions\'>Действия</td></tr>";
var __var0 = {from:jq.get('mtopics').rows, index:-1};
for(__var0.k in __var0.from) {
var row = __var0.from[__var0.k]; __var0.index++;
__r+="<tr> <td><a href=\"discuss.php?topic=";
__r+=row['idx'];
__r+="\">";
__r+=row['title'];
__r+="</a></td> <td>";
__r+=row['msgcount'];
__r+="</dt> <td>";
__r+=row['lastmsg.owner.name'];
__r+="<br>";
__r+=row['lastmsg.date'];
__r+="</dt> <td><div onclick=\"jq.get(\'mtopics\').remove(";
__r+=row['idx'];
__r+=")\">удалить</div></td></tr>";
}
__r+="</table>";
}else{
__r+="Нет тем";
}
return __r;
});//vtopics.template
jq.attachMethod('template','logindialog_1',function(){
var __r='';
if(this.user_id>0){
__r+="<span>";
__r+=this.user_name;
__r+="</span><button onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="logout()\">Выйти</button>";
}else{
__r+="<form onsubmit=\"";
__r+="jq.get('"+this.name+"')."
__r+="login(); return false;\"> <input name=\'login\' type=\'text\' value=\'\' placeholder=\"Логин\"/> <input name=\'pass\' type=\'password\' value=\'\' placeholder=\"Пароль\"/> <input name=\'rm\' type=\'checkbox\' checked style=\"display:none\"/> <button>Войти</button></form>";
}
return __r;
});//logindialog_1.template
jq.attachMethod('template','frm_registration',function(){
var __r='';
__r+="<div> <header> <span>Регистрация</span> <button onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="cancel()\">Закрыть</button> </header> ";
if(this.state==0){
__r+=" <form onsubmit=\"return false;\"> <div><input type=\"text\" name=\"login\" maxlength=10>Логин</div> <div><input type=\"password\" name=\"password\" maxlength=10>Пароль</div> <div><input type=\"password\" name=\"password2\" maxlength=10>Введите в это поле пароль ещё раз</div> <div><input type=\"text\" name=\"email\" maxlength=50>Адрес электронной почты</div> <center> <input type=\"button\" onclick=\"";
__r+="jq.get('"+this.name+"')."
__r+="send()\" value=\"Зарегистрироваться\" class=\"big_button\"/> </center> </form> ";
}else if(this.state==1){
__r+=" <div class=\"loader centered\">Пожалуйста, подождите...</div> ";
}else{
__r+=" <div class=\"centered\"><h1>Поздравляем!</h1> <p>Ваша учётная запись успешно создана.</p></div> ";
}
__r+=" </div>";
return __r;
});//frm_registration.template