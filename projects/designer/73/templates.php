<?php function index_template($cmp){?>
<div id="ilogo"><? $cmp->drawSection(0) ?></div>
<div id="imenu"><? $cmp->drawSection(1) ?></div>
<div id="icontent">
  <div id="ileftpanel"><? $cmp->drawSection(2) ?></div>
  <div id="irightpanel"><? $cmp->drawSection(3) ?></div>
</div>
<?php }//index_template?>
<?php function logo_template($cmp){?>
JQuicks 1.0.0a4
<?php }//logo_template?>
<?php function menu_template($cmp){?>
<a href="https://github.com/wlld/jquicks" class="medit">Git</a>
<a href="https://github.com/wlld/jquicks/issues" class="medit">Bug tracker</a>
<a href="/projects/designer/srvcompiler.php" class="mtools">Компилятор служб</a>
<a href="/rename_tables.php">Переименовать таблицы</a>
<?php }//menu_template?>
<?php function shelp_template($cmp){?>
<h1>Справка по службам</h1>
<ul>
  <li><a href="/projects/designer/servicehelp.php?service=TServiceController">TServiceController</a></li>
  <li><a href="/projects/designer/servicehelp.php?service=TPageEditService">TPageEditService</a></li>
  <li><a href="/projects/designer/servicehelp.php?service=TAccountService">TAccountService</a></li>
  <li><a href="/projects/designer/servicehelp.php?service=TDiscussService">TDiscussService</a></li>
  <li><a href="/projects/designer/servicehelp.php?service=TForumService">TForumService</a></li>
</ul>
<?php }//shelp_template?>
<?php function concept_template($cmp){?>
<h1>Концепции</h1>
        <ul>
            <li><a href="https://docs.google.com/document/d/16RjxIefl-SgLvSoBYybUtZ4qOaKeO03DQ1dzVE3bCfI/edit">База данных проекта</a></li>
            <li><a href="https://docs.google.com/document/d/1xS1MDxjRak3oJ93ZrFxLMc6TbT-30qfV4UmAJKr8dCA/edit">Встроенные компоненты</a></li>
            <li><a href="https://docs.google.com/document/d/18lM5JmHITv3BB3vtNeetE40OO0_Feb1TFjcxtPGAmiA/edit">Дизайнер-классы</a></li>
            <li><a href="https://docs.google.com/document/d/1G8Dt0oeGXOu8HugVUfl3iXpT-QT9DYcnAKJnkDfAkF4/edit">Компиляция файла описания службы</a></li>
            <li><a href="https://docs.google.com/document/d/1zTGoDnrL1CCSiWTjvxfc33_9j72OC2HOugsB2HvRIvk/edit">Модульная структура</a></li>
            <li><a href="https://docs.google.com/document/d/1Lez7yoO52RNcO7bY3OOFv0uumsvs21Zhx5uUZfGz0R4/edit">Агрегация служб</a></li>
            <li><a href="https://docs.google.com/document/d/1a1pWlQb9nO26LcDhj_aFwx4LEzRtsh8j1GQXoW3Zq-M/edit">Шаблоны компонентов</a></li>
        </ul>
<?php }//concept_template?>
<?php function news_template($cmp){?>
<h1>Новости</h1>
<? $__var0 = array('index'=>-1,'from'=>jq::get('m_news')->rows);
foreach($__var0['from'] as $row) {
$__var0['index']++;?>
<div class="newsblock">
  <div class="newsdate"><? echo($cmp->item($row,'date'))?></div>
  <div class="newtext"><? echo(bbDecode($cmp->item($row,'text')))?></div>
  <div class="delbtn" onclick="delete_news(<? echo($cmp->item($row,'idx'))?>)"></div>
</div>
<?}?>
<?php }//news_template?>
<?php function modelpagecontrol_1_template($cmp){?>
<? if($cmp->model){?>
<? $model=jq::get($cmp->model); ?>
<? if($model->count>0){?>
<? $limit=$model->limit; ?>
<? $pnum=$limit>0?ceil($model->count/$limit):1; ?>
<? $page=$limit>0?ceil(($model->first+1)/$limit):0; ?>
<? if($pnum>1){?>
<ul>
<? $loop = array('start'=>1,'max'=>$pnum+1,'step'=>1);
$loop['index'] = $loop['start']-$loop['step'];
while(($loop['index']+=$loop['step'])<$loop['max']){?>
  <li
   <? if($cmp->item($loop,'index')==$page){?> class='selected'
   <?}else{?>onclick="jq.get('<? echo($cmp->name)?>').select(<? echo($cmp->item($loop,'index'))?>)"
   <?}?>
  ><? echo($cmp->item($loop,'index'))?></li>
<?}?>
</ul>
<?}?>
<?}?>
<?}?>
<?php }//modelpagecontrol_1_template?>
<?php function frm_new_news_template($cmp){?>
<form onsubmit="return false;">
<textarea name="text"></textarea>
<input type="button" onclick="jq.get('<?=$cmp->name?>').submit()" value="Ok"/>
</form>

<?php }//frm_new_news_template?>
<?php function projects_template($cmp){?>
<h1>Проекты</h1>
<ul>
  <li><a href="/projects/designer/pages.php?project=designer">Дизайнер</a></li>
  <li><a href="/projects/designer/pages.php?project=waterline">Ватерлиния</a></li>
  <li><a href="/projects/designer/pages.php?project=test">Тест</a></li>
</ul>
<?php }//projects_template?>