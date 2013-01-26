<?php function servicehelp_template($cmp){?>
<? $cmp->drawSection(0) ?>
<?php }//servicehelp_template?>
<?php function title_template($cmp){?>
<h1><? echo($cmp->item(jq::get('mmodels')->params,'service'))?></h1>
<?php }//title_template?>
<?php function briefmodels_template($cmp){?>
<h2>Поддерживаемые модели</h2>
<ul>
<? $__var0 = array('index'=>-1,'from'=>jq::get('mmodels')->rows);
foreach($__var0['from'] as $row) {
$__var0['index']++;?>
<li><a href="#model.<? echo($cmp->item($row,'name'))?>"><? echo($cmp->item($row,'name'))?></a> - <? echo($cmp->item($row,'desc'))?></li>
<?}?>
</ul>
<?php }//briefmodels_template?>
<?php function briefcommands_template($cmp){?>
<h2>Поддерживаемые команды</h2>
<ul>
<? $__var0 = array('index'=>-1,'from'=>jq::get('mcmd')->rows);
foreach($__var0['from'] as $row) {
$__var0['index']++;?>
<li><a href="#cmd.<? echo($cmp->item($row,'name'))?>"><? echo($cmp->item($row,'name'))?></a> - <? echo($cmp->item($row,'desc'))?></li>
<?}?>
</ul>
<?php }//briefcommands_template?>
<?php function fullmodels_template($cmp){?>
<h2>Описание моделей</h2>
<? $__var0 = array('index'=>-1,'from'=>jq::get('mmodels')->rows);
foreach($__var0['from'] as $model) {
$__var0['index']++;?>
<a name="model.<? echo($cmp->item($model,'name'))?>"></a>
<h3><? echo($cmp->item($model,'name'))?></h3>
<p><? echo($cmp->item($model,'desc'))?>. Модель<? echo($cmp->item($model,'delete')?"":" не")?> поддерживает удаление записей</p>
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
<? $__var1 = array('index'=>-1,'from'=>jq::get('mfields')->rows);
foreach($__var1['from'] as $row) {
$__var1['index']++;?>
 <? if($cmp->item($row,'model')==$cmp->item($model,'name')){?>
  <tr>
    <td><? echo($cmp->item($row,'name'))?></td>
    <td><? echo($cmp->item($row,'type'))?></td>
    <td><? echo($cmp->item($row,'fetch'))?></td>
    <td><? echo($cmp->item($row,'insert'))?></td>
    <td><? echo($cmp->item($row,'update'))?></td>
    <td><? echo($cmp->item($row,'desc'))?></td>
  </tr>
 <?}?>
<?}?>
</table>
<h4>Описание параметров команды fetch</h4>
<table border=1>
<tr>
  <td>Имя параметра</td>
  <td>Тип</td>
  <td>Обязательный параметр</td>
  <td>Описание</td>
</tr>
<? $__var2 = array('index'=>-1,'from'=>jq::get('mfetchp')->rows);
foreach($__var2['from'] as $row) {
$__var2['index']++;?>
  <? if($cmp->item($row,'model')==$cmp->item($model,'name')){?>
  <tr>
    <td><? echo($cmp->item($row,'name'))?></td>
    <td><? echo($cmp->item($row,'type'))?></td>
    <td><? echo($cmp->item($row,'required')?"Да":"Нет")?></td>
    <td><? echo($cmp->item($row,'desc'))?></td>
  </tr>
  <?}?>
<?}?>
</table>
<?}?>
<?php }//fullmodels_template?>
<?php function fullcommands_template($cmp){?>
<h2>Описание команд</h2>
<? $__var0 = array('index'=>-1,'from'=>jq::get('mcmd')->rows);
foreach($__var0['from'] as $cmd) {
$__var0['index']++;?>
<a name="cmd.<? echo($cmp->item($cmd,'name'))?>"></a>
<h3><? echo($cmp->item($cmd,'name'))?></h3>
<p><? echo($cmp->item($cmd,'desc'))?></p>
<? if($cmp->item($cmd,'pcount')>0){?>
<h4>Параметры:</h4>
<table border=1>
<tr>
  <td>Имя параметра</td>
  <td>Тип</td>
  <td>Обязательный параметр</td>
  <td>Значение по умолчанию</td>
  <td>Описание</td>
</tr>
<? $__var1 = array('index'=>-1,'from'=>jq::get('mcmdp')->rows);
foreach($__var1['from'] as $row) {
$__var1['index']++;?>
  <? if($cmp->item($row,'command')==$cmp->item($cmd,'name')){?>
  <tr>
    <td><? echo($cmp->item($row,'name'))?></td>
    <td><? echo($cmp->item($row,'type'))?></td>
    <td><? echo($cmp->item($row,'required')?"Да":"Нет")?></td>
    <td><? echo($cmp->item($row,'value'))?></td>
    <td><? echo($cmp->item($row,'desc'))?></td>
  </tr>
  <?}?>
<?}?>
</table>
<?}else{?>
Команда не имеет параметров
<?}?>
<?}?>
<?php }//fullcommands_template?>