<?// designer //?>
<?php function pagetree_template($cmp){?>
<h3>Дерево компонентов</h3>
<? if($cmp->treemodel->count>0){?>
<div class="cmdpanel">
  <div onclick="jq.get('<? echo($cmp->name)?>').deleteCmp()" class="button">Удалить</div>
  <div onclick="toggleAllCmp()" class="btn_all">Вставить компонент &gt;&gt;</div>
</div>
<div id="tree">
<? $tree = array('index'=>-1,'from'=>$cmp->treemodel->getField('tree'));
foreach($tree['from'] as $row) {
$tree['index']++;?>
  <? if($cmp->item($row,'i')==0){?>
    <p id="<? echo($cmp->name)?>.<? echo($cmp->item($tree,'index'))?>" onclick="jq.get('pagetree').select(this)"><? echo($cmp->item($row,'n'))?></p>
  <?}elseif($cmp->item($row,'i')==1){?>
    <p id="<? echo($cmp->name)?>.<? echo($cmp->item($tree,'index'))?>" onclick="jq.get('pagetree').select(this)"><? echo($cmp->item($row,'n'))?></p>
    <dl>
  <?}elseif($cmp->item($row,'i')==2){?>
    <dt>
    <? if($cmp->item($row,'s')==-1){?>
      <p id="<? echo($cmp->name)?>.<? echo($cmp->item($tree,'index'))?>">невизуальные компоненты</p>
    <?}else{?>
      <p id="<? echo($cmp->name)?>.<? echo($cmp->item($tree,'index'))?>">секция <? echo($cmp->item($row,'s'))?></p>
    <?}?>
    <dd>
  <?}elseif($cmp->item($row,'i')==3){?>
    </dd>
  <?}elseif($cmp->item($row,'i')==4){?>
    </dl>
  <?}elseif($cmp->item($row,'i')==5){?>
    <p id="<? echo($cmp->name)?>.<? echo($cmp->item($tree,'index'))?>" onclick="jq.get('pagetree').select(this)"><? echo($cmp->item($row,'n'))?></p>
  <?}?>
<?}?>
<hr>
</div>
<?}?>
<div id = '<? echo($cmp->name)?>.shield' class='shield'></div>
<?php }//pagetree_template?>
<?php function prpeditor_template($cmp){?>
<div class="cmdpanel">
<div onclick="jq.get('<?=$cmp->name?>').save()" id=<? echo($cmp->name)?>.indicator>Сохранить</div>
</div>
<? if($cmp->prpmodel->count>0){?>
<form onsubmit="return false;">
<ul class="content">
  <? $lp = array('index'=>-1,'from'=>$cmp->prpmodel->rows);
foreach($lp['from'] as $prp) {
$lp['index']++;?>
  <li><? echo($cmp->item($prp,'n'))?><div>
    <? if($cmp->item($prp,'t')=='boolean'){?> 
       <input type="checkbox" <? if($cmp->item($prp,'v')>0){?>checked<?}?> onchange="jq.get('<?=$cmp->name?>').prpchange(<? echo($cmp->item($lp,'index'))?>,this)" name="<? echo($cmp->item($prp,'n'))?>">
    <?}elseif($cmp->item($prp,'t')=='text'||$cmp->item($prp,'t')=='object'){?>
       <div class = "obj">
       <textarea rows=1 onchange="jq.get('<?=$cmp->name?>').prpchange(<? echo($cmp->item($lp,'index'))?>,this)" name="<? echo($cmp->item($prp,'n'))?>"><? echo(htmlspecialchars($cmp->item($prp,'v'),ENT_QUOTES))?></textarea>
       </div>
       <div class='expand_btn' onclick="jq.get('<?=$cmp->name?>').showEditor('<? echo($cmp->item($prp,'n'))?>',<? echo($cmp->item($lp,'index'))?>)"></div>
    <?}elseif($cmp->item($prp,'t')=='list'){?>
      <select onchange="jq.get('<?=$cmp->name?>').prpchange(<? echo($cmp->item($lp,'index'))?>,this)" name="<? echo($cmp->item($prp,'n'))?>">
      <? $__var0 = array('index'=>-1,'from'=>$cmp->item($prp,'o'));
foreach($__var0['from'] as $opt) {
$__var0['index']++;?> 
         <option <? if($opt==$cmp->item($prp,'v')){?>selected<?}?>><? echo($opt)?></option>
      <?}?>
      </select>
    <?}elseif($cmp->item($prp,'t')=='link'){?>
       <div class = "obj">
       <input type="text" value="<? echo(htmlspecialchars($cmp->item($prp,'v'),ENT_QUOTES))?>" onchange="jq.get('<?=$cmp->name?>').prpchange(<? echo($cmp->item($lp,'index'))?>,this)" spellcheck="false" disabled  name="<? echo($cmp->item($prp,'n'))?>"/>
       </div>
       <div class='expand_btn' onclick="jq.get('<?=$cmp->name?>').showEditor('<? echo($cmp->item($prp,'n'))?>',<? echo($cmp->item($lp,'index'))?>)"></div>
    <?}else{?>
       <input type="text" value="<? echo(htmlspecialchars($cmp->item($prp,'v'),ENT_QUOTES))?>" onchange="jq.get('<?=$cmp->name?>').prpchange(<? echo($cmp->item($lp,'index'))?>,this)" spellcheck="false"  name="<? echo($cmp->item($prp,'n'))?>"/>
    <?}?>
  </div></li>
  <?}?>
</ul>
</form>
<?}?>
<?php }//prpeditor_template?>
<?php function tpleditor_template($cmp){?>
<? if($cmp->tplmodel->count==1){?>
<div class="cmdpanel">
<div onclick="jq.get('tpleditor').save(this)">Сохранить</div>
<div onclick="showtree()">Дерево</div>
</div>
<div class="content">
<textarea class="scrollbox" spellcheck="false"><? echo(htmlspecialchars($cmp->tplmodel->getField('tpl'),ENT_QUOTES))?></textarea>
</div>
<?}?>
<?php }//tpleditor_template?>
<?php function pageeditor_template($cmp){?>
<div id="main">
  <div id=<? echo($cmp->name)?>_0 class='section'>
    <? $cmp->drawSection(0) ?>
  </div>
  <div id=<? echo($cmp->name)?>_1 class='section'>
    <? $cmp->drawSection(1) ?>
  </div>
</div>
<div id="shield">
<? $cmp->drawSection(2) ?>
</div>
<?php }//pageeditor_template?>
<?php function js_editor_template($cmp){?>
<div class="cmdpanel">
<div onclick="jq.get('js_editor').save()">Сохранить</div>
</div>
<div class='content'>
<textarea spellcheck='false'><? echo(htmlspecialchars($cmp->jsmodel->getField('js'),ENT_QUOTES))?></textarea>
</div>
<?php }//js_editor_template?>
<?php function palette_page_1_template($cmp){?>
<? $__var0 = array('index'=>-1,'from'=>$cmp->components);
foreach($__var0['from'] as $cmp) {
$__var0['index']++;?>
<? $path=isCoreClass($cmp)?'/core/':'/components/'; ?>
   <img alt="<? echo($cmp)?>" title="<? echo($cmp)?>" src="<? echo($path.$cmp)?>/icon.png"?>
<?}?>
<?php }//palette_page_1_template?>
<?php function palette_page_2_template($cmp){?>
<? $__var0 = array('index'=>-1,'from'=>$cmp->components);
foreach($__var0['from'] as $cmp) {
$__var0['index']++;?>
<? $path=isCoreClass($cmp)?'/core/':'/components/'; ?>
   <img alt="<? echo($cmp)?>" title="<? echo($cmp)?>" src="<? echo($path.$cmp)?>/icon.png"?>
<?}?>
<?php }//palette_page_2_template?>
<?php function palette_page_selector_template($cmp){?>
<ul>
<? $l = array('index'=>-1,'from'=>$cmp->pages);
foreach($l['from'] as $page) {
$l['index']++;?>
  <li
     <? if($cmp->item($l,'index')==$cmp->active){?>class="active"<?}?>
     onclick="jq.get('<?=$cmp->name?>').select('<? echo($page)?>')"><? echo($page)?>
  </li>
<?}?>
</ul>
<?php }//palette_page_selector_template?>
<?php function frame_template($cmp){?>
<iframe src="<? echo($cmp->url)?>"></iframe>
<div id='<? echo($cmp->name)?>.shield' class='shield'></div>
<?php }//frame_template?>
<?php function csseditor_template($cmp){?>
<? if($cmp->cssmodel->count==1){?>
<div class="cmdpanel">
<div onclick="jq.get('csseditor').save(this)">Сохранить</div>
</div>
<div class="content">
<textarea class="scrollbox" spellcheck="false"><? echo(htmlspecialchars($cmp->cssmodel->getField('css'),ENT_QUOTES))?></textarea>
</div>
<?}?>
<?php }//csseditor_template?>
<?php function component_editor_template($cmp){?>
<h3>
<table width="100%">
<tr>
  <td>Имя компонента</td>
  <td width="20px" onclick="resizeeditor()">&gt;&gt;</td>
</tr>
</table>
</h3>
<div id=<? echo($cmp->name)?>_0 class='section'>
  <? $cmp->drawSection(0) ?>
</div>
<div id=<? echo($cmp->name)?>_1 class='section'>
  <? $cmp->drawSection(1) ?>
</div>

<?php }//component_editor_template?>
<?php function page_editor_template($cmp){?>
<div id=<? echo($cmp->name)?>_0 class='section'>
  <? $cmp->drawSection(0) ?>
</div>
<div id=<? echo($cmp->name)?>_1 class='section'>
  <? $cmp->drawSection(1) ?>
</div>
<?php }//page_editor_template?>
<?php function html_editor_template($cmp){?>
<div id=<? echo($cmp->name)?>_1 class='section'>
  <? $cmp->drawSection(0) ?>
</div>
<?php }//html_editor_template?>
<?php function palette_template($cmp){?>
<div id=<? echo($cmp->name)?>_0 class='section'>
  <? $cmp->drawSection(0) ?>
</div>
<div id=<? echo($cmp->name)?>_1 class='section'>
  <? $cmp->drawSection(1) ?>
</div>
<?php }//palette_template?>
<?php function php_editor_template($cmp){?>
<div class="cmdpanel">
   <div  onclick="jq.get('php_editor').save()">Сохранить</div>
</div>
<div class='content'>
<textarea spellcheck='false'><? echo(htmlspecialchars($cmp->phpmodel->getField('php'),ENT_QUOTES))?></textarea>
</div>
<?php }//php_editor_template?>
<?php function msglist_template($cmp){?>
 
<?php }//msglist_template?>
<?php function allcmp_template($cmp){?>
<div>Для вставки в проект существующего компонента перетащите его в дерево разработки</div>
<? $type=''; ?>
<? $__var0 = array('index'=>-1,'from'=>$cmp->model->rows);
foreach($__var0['from'] as $row) {
$__var0['index']++;?>
<? if($type!=$cmp->item($row,'type')){?>
  <h4><? echo($cmp->item($row,'type'))?></h4>
  <? $type=$cmp->item($row,'type'); ?>
<?}?>
<p><? echo($cmp->item($row,'name'))?></p>
<?}?>
<?php }//allcmp_template?>
<?php function palette_page_3_template($cmp){?>
<? $__var0 = array('index'=>-1,'from'=>$cmp->components);
foreach($__var0['from'] as $cmp) {
$__var0['index']++;?>
<? $path=isCoreClass($cmp)?'/core/':'/components/'; ?>
   <img alt="<? echo($cmp)?>" title="<? echo($cmp)?>" src="<? echo($path.$cmp)?>/icon.png"?>
<?}?>
<?php }//palette_page_3_template?>
<?php function textspeededitor_template($cmp){?>
<header>
<button onclick="jq.get('<?=$cmp->name?>').save()">Ок</button>
<button onclick="jq.get('<?=$cmp->name?>').cancel()">Отмена</button>
</header>
<div>
<textarea wrap="soft"></textarea>
</div>
<?php }//textspeededitor_template?>
<?php function linkscheckingdialog_template($cmp){?>
<header>
<button onclick="jq.get('<?=$cmp->name?>').cancel()">Отмена</button>
</header>
<div>
<? if($cmp->state==2){?>
  <div class="result">
    <? if($cmp->result>0){?>
    <? $a=$cmp->result%20; ?>
В дочерней таблице есть <? echo($cmp->result%20)?> несвязанн<? echo($a<1?'ых':$a<2?'ая':$a<5?'ые':'ых')?> запис<? echo($a<1?'ей':$a<2?'ь':$a<5?'и':'ей')?>. Ситуацию можно исправить одним из нижеуказанных способов
    <?}else{?>
Таблицы находятся в состоянии ссылочной целостности
    <?}?>
  </div> 
  <? if($cmp->result>0){?>
    <form>
    <div><input type="radio" name="mode" checked>Удалить все несвязанные записи</div>
    <div><input type="radio" name="mode">Присвоить ссылочному полю несвязанных записей NULL</div>
    </form>
    <div class="repair"><button onclick="jq.get('<?=$cmp->name?>').repair()">Починить</button></div>
  <?}?>
<?}else{?>
  <div id="<? echo($cmp->name)?>_loader"><? if($cmp->state==0){?>Проверяю...<?}else{?>Починяю...<?}?></div>
<?}?>
</div>
<?php }//linkscheckingdialog_template?>
<?php function prp_css_selector_template($cmp){?>
<ul>
<? $l = array('index'=>-1,'from'=>$cmp->pages);
foreach($l['from'] as $page) {
$l['index']++;?>
  <li
     <? if($cmp->item($l,'index')==$cmp->active){?>class="active"<?}?>
     onclick="jq.get('<?=$cmp->name?>').select('<? echo($page)?>')"><? echo($page)?>
  </li>
<?}?>
</ul>
<?php }//prp_css_selector_template?>
<?php function html_js_php_selector_template($cmp){?>
<ul>
<? $l = array('index'=>-1,'from'=>$cmp->pages);
foreach($l['from'] as $page) {
$l['index']++;?>
  <li
     <? if($cmp->item($l,'index')==$cmp->active){?>class="active"<?}?>
     onclick="jq.get('<?=$cmp->name?>').select('<? echo($page)?>')"><? echo($page)?>
  </li>
<?}?>
</ul>
<?php }//html_js_php_selector_template?>
<?php function linkseditor_template($cmp){?>
<div class="cmdpanel">
<div onclick="jq.get('<?=$cmp->name?>').add()">Новая</div>
<div onclick="jq.get('<?=$cmp->name?>').remove()">Удалить</div>
<div onclick="jq.get('<?=$cmp->name?>').edit()">Редактировать</div>
<div onclick="jq.get('<?=$cmp->name?>').check()">Проверка</div>
</div>
<div class="content">
<table>
<tr>
  <td>Потомок</td><td>&nbsp</td><td>Родитель</td>
</tr>
<? $l = array('index'=>-1,'from'=>$cmp->model->rows);
foreach($l['from'] as $link) {
$l['index']++;?>
<tr onclick="jq.get('<?=$cmp->name?>').select(this,<? echo($cmp->item($l,'index'))?>)">
  <td>
  <? if($cmp->item($link,'type')){?>
     <div class="typeimg trating"></div>
     <? echo($cmp->item($link,'child'))?>.<wbr><? echo($cmp->item($link,'lfield'))?><wbr>(<? echo($cmp->item($link,'rfield'))?>)
  <?}else{?>
     <div class="typeimg"></div>
     <? echo($cmp->item($link,'child'))?>.<wbr><? echo($cmp->item($link,'lfield'))?>
  <?}?>
  </td>
  <td><div class="link_image<? if($cmp->item($link,'op')=='SET NULL'){?> NULL<?}else{?> <? echo($cmp->item($link,'op'))?><?}?>"></div></td>
  <? $brake=$cmp->item($link,'service_name')==''; ?>
  <td><? if($cmp->item($link,'service_name')!=''){?><? echo($cmp->item($link,'service_name'))?>.<wbr><? echo($cmp->item($link,'parent'))?><? if($cmp->item($link,'type')){?>.<wbr><? echo($cmp->item($link,'tfield'))?><?}?><?}else{?>???<?}?>
  </td>
</tr>
<?}?>
</table>
</div>
<?php }//linkseditor_template?>
<?php function linkspeededitor_template($cmp){?>
<header>
<button onclick="jq.get('<?=$cmp->name?>').save()">Ок</button>
<button onclick="jq.get('<?=$cmp->name?>').cancel()">Отмена</button>
</header>
<form>
<div>
<div class="formfield">Модель:<select name="child" onchange="jq.get('<?=$cmp->name?>').loadModels()"></select></div>
<div class="formfield">Поле:<select name="lfield" onchange="jq.get('<?=$cmp->name?>').onSelectLField()"></select></div>
<div class="link_image NONE"></div>
<div class="formfield">Служба:<select name="service" onchange="jq.get('<?=$cmp->name?>').onSelectService()"></select></div>
<div class="formfield">Модель-родитель:<select name="parent"></select></div>
<div id="<? echo($cmp->name)?>_loader"></div>
</div>
<input type="radio" name="type" value="0" onchange="jq.get('<?=$cmp->name?>').setType()" checked/>Ссылка
<input type="radio" name="type" value="1" onchange="jq.get('<?=$cmp->name?>').setType()"/>Рейтинг
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
<?php }//linkspeededitor_template?>
<?php function palette_page_4_template($cmp){?>
<? $__var0 = array('index'=>-1,'from'=>$cmp->components);
foreach($__var0['from'] as $cmp) {
$__var0['index']++;?>
<? $path=isCoreClass($cmp)?'/core/':'/components/'; ?>
   <img alt="<? echo($cmp)?>" title="<? echo($cmp)?>" src="<? echo($path.$cmp)?>/icon.png"?>
<?}?>
<?php }//palette_page_4_template?>