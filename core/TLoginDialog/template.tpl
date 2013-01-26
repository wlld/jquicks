{{if this->user_id > 0}}
<span>{{this->user_name}}</span>
<button onclick="{{@}}logout()">Выйти</button>
{{else}}
<form onsubmit="{{@}}login(); return false;">
  <input name='login' type='text' value='' placeholder="Логин"/>
  <input name='pass' type='password' value='' placeholder="Пароль"/>
  <button>Войти</button>
  <input name='rm' type='checkbox' checked />Запомнить
</form>
{{/if}}