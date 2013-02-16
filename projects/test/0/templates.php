<?php function index_template($cmp){?>
<? $cmp->drawSection(0) ?>
<?php }//index_template?>
<?php function cap_template($cmp){?>
<h1>Главная страница</h1>
<?php }//cap_template?>
<?php function regform_template($cmp){?>
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
<?php }//regform_template?>
<?php function vidget_1_template($cmp){?>
<a onclick='jq.get("regform").show()'>регистрация</a>
<?php }//vidget_1_template?>