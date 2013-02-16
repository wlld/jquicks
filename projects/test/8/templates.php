<?php function topics_template($cmp){?>
<? $cmp->drawSection(0) ?>
<?php }//topics_template?>
<?php function vtopics_template($cmp){?>
<? if(jq::get('mtopics')->count>0){?>
<table>
<tr>
  <td>Тема</td>
  <td class='msgcount'>Сообщений</dt>
  <td class='lastmsg'>Последнее сообщение</dt>
  <td class='actions'>Действия</td>
</tr>
<? $__var0 = array('index'=>-1,'from'=>jq::get('mtopics')->rows);
foreach($__var0['from'] as $row) {
$__var0['index']++;?>
<tr>
  <td><a href="discuss.php?topic=<? echo($cmp->item($row,'idx'))?>"><? echo($cmp->item($row,'title'))?></a></td>
  <td><? echo($cmp->item($row,'msgcount'))?></dt>
  <td><? echo($cmp->item($row,'lastmsg.owner.name'))?><br><? echo($cmp->item($row,'lastmsg.date'))?></dt>
  <td><div onclick="jq.get('mtopics').remove(<? echo($cmp->item($row,'idx'))?>)">удалить</div></td>
</tr>
<?}?>
</table>
<?}else{?>
Нет тем
<?}?>
<?php }//vtopics_template?>
<?php function frm_new_topic_template($cmp){?>
<header>Создать новую тему</header>
<form onsubmit="return false;">
<input class="input" type="text" name="title">
<input type="button" onclick="jq.get('<?=$cmp->name?>').submit()" value="Ok"/>
</form>
<?php }//frm_new_topic_template?>
<?php function logindialog_1_template($cmp){?>
<? if($cmp->user_id>0){?>
<span><? echo($cmp->user_name)?></span>
<button onclick="jq.get('<?=$cmp->name?>').logout()">Выйти</button>
<?}else{?>
<form onsubmit="jq.get('<?=$cmp->name?>').login(); return false;">
  <input name='login' type='text' value='' placeholder="Логин"/>
  <input name='pass' type='password' value='' placeholder="Пароль"/>
  <input name='rm' type='checkbox' checked style="display:none"/>
  <button>Войти</button>
</form>
<?}?>
<?php }//logindialog_1_template?>
<?php function vidget_2_template($cmp){?>
<a onclick="jq.get('frm_registration').show()">регистрация</a>
<?php }//vidget_2_template?>
<?php function frm_registration_template($cmp){?>
<div>
  <header>
  <span>Регистрация</span>
  <button onclick="jq.get('<?=$cmp->name?>').cancel()">Закрыть</button>
  </header>
<? if($cmp->state==0){?>
  <form onsubmit="return false;">
  <div><input type="text" name="login"  maxlength=10>Логин</div>
  <div><input type="password" name="password" maxlength=10>Пароль</div>
  <div><input type="password" name="password2" maxlength=10>Введите в это поле пароль ещё раз</div>
  <div><input type="text" name="email"  maxlength=50>Адрес электронной почты</div>
  <center>
  <input type="button" onclick="jq.get('<?=$cmp->name?>').send()" value="Зарегистрироваться" class="big_button"/>
  </center>
  </form>
<?}elseif($cmp->state==1){?>
  <div class="loader centered">Пожалуйста, подождите...</div>
<?}else{?>
  <div class="centered"><h1>Поздравляем!</h1> <p>Ваша учётная запись успешно создана.</p></div>
<?}?>
</div>
<?php }//frm_registration_template?>