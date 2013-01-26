<!--servicehelp-->
{{section 0}}
<!--servicehelp-->
<!--title-->
<h1>{{mmodels->params[service]}}</h1>
<!--title-->
<!--briefmodels-->
<h2>Поддерживаемые модели</h2>
<ul>
{{foreach from=mmodels->rows item=row}}
<li><a href="#model.{{$row[name]}}">{{$row[name]}}</a> - {{$row[desc]}}</li>
{{/foreach}}
</ul>
<!--briefmodels-->
<!--briefcommands-->
<h2>Поддерживаемые команды</h2>
<ul>
{{foreach from=mcmd->rows item=row}}
<li><a href="#cmd.{{$row[name]}}">{{$row[name]}}</a> - {{$row[desc]}}</li>
{{/foreach}}
</ul>
<!--briefcommands-->
<!--fullmodels-->
<h2>Описание моделей</h2>
{{foreach from=mmodels->rows item=model}}
<a name="model.{{$model[name]}}"></a>
<h3>{{$model[name]}}</h3>
<p>{{$model[desc]}}. Модель{{$model[delete]?"":" не"}} поддерживает удаление записей</p>
<h4>Описание полей</h4>
<table border=1>
<tr>
  <td>Имя поля</td>
  <td>Тип</td>
  <td>fetch</td>
  <td>insert</td>
  <td>update</td>
  <td>Описание</td>
</tr>
{{foreach from=mfields->rows item=row}}
 {{if $row[model]==$model[name]}}
  <tr>
    <td>{{$row[name]}}</td>
    <td>{{$row[type]}}</td>
    <td>{{$row[fetch]}}</td>
    <td>{{$row[insert]}}</td>
    <td>{{$row[update]}}</td>
    <td>{{$row[desc]}}</td>
  </tr>
 {{/if}}
{{/foreach}}
</table>
<h4>Описание параметров команды fetch</h4>
<table border=1>
<tr>
  <td>Имя параметра</td>
  <td>Тип</td>
  <td>Обязательный параметр</td>
  <td>Описание</td>
</tr>
{{foreach from=mfetchp->rows item=row}}
  {{if $row[model]==$model[name]}}
  <tr>
    <td>{{$row[name]}}</td>
    <td>{{$row[type]}}</td>
    <td>{{$row[required]?"Да":"Нет"}}</td>
    <td>{{$row[desc]}}</td>
  </tr>
  {{/if}}
{{/foreach}}
</table>
{{/foreach}}
<!--fullmodels-->
<!--fullcommands-->
<h2>Описание команд</h2>
{{foreach from=mcmd->rows item=cmd}}
<a name="cmd.{{$cmd[name]}}"></a>
<h3>{{$cmd[name]}}</h3>
<p>{{$cmd[desc]}}</p>
{{if $cmd[pcount]>0}}
<h4>Параметры:</h4>
<table border=1>
<tr>
  <td>Имя параметра</td>
  <td>Тип</td>
  <td>Обязательный параметр</td>
  <td>Значение по умолчанию</td>
  <td>Описание</td>
</tr>
{{foreach from=mcmdp->rows item=row}}
  {{if $row[command]==$cmd[name]}}
  <tr>
    <td>{{$row[name]}}</td>
    <td>{{$row[type]}}</td>
    <td>{{$row[required]?"Да":"Нет"}}</td>
    <td>{{$row[value]}}</td>
    <td>{{$row[desc]}}</td>
  </tr>
  {{/if}}
{{/foreach}}
</table>
{{else}}
Команда не имеет параметров
{{/if}}
{{/foreach}}
<!--fullcommands-->