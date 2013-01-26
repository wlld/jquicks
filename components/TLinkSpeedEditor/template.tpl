<header>
<button onclick="{{@}}cancel()">Отмена</button>
<button onclick="{{@}}checkLinks()">Проверить ссылочную целостность</button>
<button onclick="{{@}}save()">Ок</button>
</header>
<form>
<div>
<div class="formfield">Модель:<select name="child" onchange="{{@}}loadModels()"></select></div>
<div class="formfield">Поле:<select name="lfield" onchange="{{@}}loadModels()"></select></div>
<div class="link_image NONE"></div>
<div class="formfield">Служба:<select name="services" onchange="{{@}}loadModels()"></select></div>
<div class="formfield">Модель-родитель:<select name="models"></select></div>
</div>
<input type="radio" name="type" value="0" onchange="{{@}}setType()" checked/>Ссылка
<input type="radio" name="type" value="1" onchange="{{@}}setType()"/>Рейтинг
<fieldset>
 <legend>Действие при удалении родительской записи</legend>
 <div><input type="radio" name="ondelete" value="RESTRICT"/>Не удалять, если есть потомки</div>
 <div><input type="radio" name="ondelete" value="CASCADE"/>Удалить всех потомков</div>
 <div><input type="radio" name="ondelete" value="SET NULL"/>Присвоить ссылкам потомков null</div>
 <div><input type="radio" name="ondelete" value="NONE"/>Не контролировать потомков(нарушить целостность)</div>
</fieldset>
<fieldset>
 <legend>Рейтинг</legend>
 <div class="formfield">Операция:<select name="op">
  <option>SUM</option>
  <option>MIN</option>
  <option>MAX</option>
  <option>COUNT</option>
 </select></div>
 <div class="formfield">Поле:<select name="rfield"></select></div>
 <div class="formfield">Результат:<input name="tfield" type="text"/></div>
</fieldset>
</form>