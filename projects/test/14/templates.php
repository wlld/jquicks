<?php function discuss_template($cmp){?>
<? $cmp->drawSection(0) ?>
<?php }//discuss_template?>
<?php function vdiscuss_template($cmp){?>
<? $l = array('index'=>-1,'from'=>jq::get('mm')->rows);
foreach($l['from'] as $row) {
$l['index']++;?>
<article>
  <header>
    <span class="msg_date"><? echo($cmp->item($row,'date'))?></span>
    <? echo(is_null($cmp->item($row,'subject.title'))?"Без темы":$cmp->item($row,'subject.title'))?> 
    <span class="msg_owner"><? echo(is_null($cmp->item($row,'owner.name'))?"Unknown user":$cmp->item($row,'owner.name'))?></span>
    parent=<? echo($cmp->item($row,'parent'))?>
  </header>
  <div>
  <div id="<? echo($cmp->name)?>_content_<? echo($cmp->item($l,'index'))?>">
     <div class="content"><? echo(bbDecode($cmp->item($row,'text')))?></div>
     <? if($cmp->item($row,'own')){?>
     <footer>
       <button onclick='my_remove(<? echo($cmp->item($row,'idx'))?>)'>Удалить</button>
       <button onclick='edit(<? echo($cmp->item($l,'index'))?>)'>Редактировать</button>
     </footer>
     <?}?>
  </div>
  </div>
</article>
<?}?>
<?php }//vdiscuss_template?>
<?php function pager_template($cmp){?>
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
<?php }//pager_template?>
<?php function newmsg_template($cmp){?>
<form onsubmit="return false;">
<header>Новая запись</header>
<textarea name="text"></textarea>
<input type="button" onclick="jq.get('<?=$cmp->name?>').submit()" value="Ok"/>
<? if(array_key_exists('subject',jq::get('mm')->params)){?>
<input type="hidden" name='subject' value="<? echo($cmp->item(jq::get('mm')->params,'subject'))?>"/>
<?}?>
</form>

<?php }//newmsg_template?>
<?php function editor_template($cmp){?>
<form onsubmit="return false;">
<textarea name="text"></textarea>
<input name="parent" type='text' />
<footer>
  <button onclick="jq.get('<?=$cmp->name?>').submit()">Ok</button>
  <button onclick="cancel()">Отмена</button>
</footer>
</form>
<?php }//editor_template?>