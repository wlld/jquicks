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