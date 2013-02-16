<!--topics-->
{{section 0}}
<!--topics-->
<!--vtopics-->
{{if mtopics->count>0}}
<table>
<tr>
  <td>Тема</td>
  <td class='msgcount'>Сообщений</dt>
  <td class='lastmsg'>Последнее сообщение</dt>
  <td class='actions'>Действия</td>
</tr>
{{foreach from=mtopics->rows item=row}}
<tr>
  <td><a href="discuss.php?topic={{$row[idx]}}">{{$row[title]}}</a></td>
  <td>{{$row[msgcount]}}</dt>
  <td>{{$row['lastmsg.owner.name']}}<br>{{$row['lastmsg.date']}}</dt>
  <td><div onclick="jq.get('mtopics').remove({{$row[idx]}})">удалить</div></td>
</tr>
{{/foreach}}
</table>
{{else}}
Нет тем
{{/if}}
<!--vtopics-->
<!--frm_new_topic-->
<header>Создать новую тему</header>
<form onsubmit="return false;">
<input class="input" type="text" name="title">
<input type="button" onclick="{{@}}submit()" value="Ok"/>
</form>
<!--frm_new_topic-->
<!--logindialog_1-->
{{if this->user_id > 0}}
<span>{{this->user_name}}</span>
<button onclick="{{@}}logout()">Выйти</button>
{{else}}
<form onsubmit="{{@}}login(); return false;">
  <input name='login' type='text' value='' placeholder="Логин"/>
  <input name='pass' type='password' value='' placeholder="Пароль"/>
  <input name='rm' type='checkbox' checked style="display:none"/>
  <button>Войти</button>
</form>
{{/if}}
<!--logindialog_1-->
<!--vidget_2-->
<a onclick="jq.get('frm_registration').show()">регистрация</a>
<!--vidget_2-->
<!--frm_registration-->
<div>
  <header>
  <span>Регистрация</span>
  <button onclick="{{@}}cancel()">Закрыть</button>
  </header>
{{if this->state==0}}
  <form onsubmit="return false;">
  <div><input type="text" name="login"  maxlength=10>Логин</div>
  <div><input type="password" name="password" maxlength=10>Пароль</div>
  <div><input type="password" name="password2" maxlength=10>Введите в это поле пароль ещё раз</div>
  <div><input type="text" name="email"  maxlength=50>Адрес электронной почты</div>
  <center>
  <input type="button" onclick="{{@}}send()" value="Зарегистрироваться" class="big_button"/>
  </center>
  </form>
{{elseif this->state==1}}
  <div class="loader centered">Пожалуйста, подождите...</div>
{{else}}
  <div class="centered"><h1>Поздравляем!</h1> <p>Ваша учётная запись успешно создана.</p></div>
{{/if}}
</div>
<!--frm_registration-->