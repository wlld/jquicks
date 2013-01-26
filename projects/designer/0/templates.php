<?php function index_template($cmp){?>
<div>
  <div><a href="/projects/designer/changelog.php">Jquicks v1.0a3</a></div>
  <div><? $cmp->drawSection(0) ?></div>
</div>
<?php }//index_template?>
<?php function pagelist_template($cmp){?>
<ul>
<? $lp = array('index'=>-1,'from'=>jq::get('pmodel')->rows);
foreach($lp['from'] as $row) {
$lp['index']++;?>
 <li><? echo($cmp->item($row,'name'))?>
    <div class="button edit_button" onclick="editPage('<? echo($cmp->item($lp,'index'))?>')"></div>
    <? if($cmp->item($row,'name')!='index'){?>
    <div class="button delete_button" onclick="deletePage('<? echo($cmp->item($row,'idx'))?>')"></div>
    <?}?>
    <? if(0){?><div class="button compile_button"></div><?}?>
 </li>
<?}?>
</ul>
<?php }//pagelist_template?>
<?php function pagetree_template($cmp){?>
<? echo($cmp->name)?>
<?php }//pagetree_template?>
<?php function newpage_template($cmp){?>
<input id="inp-name" type="text" value="" placeholder="имя новой страницы">
<div class="button" onclick="newPage()"></div>
<?php }//newpage_template?>
<?php function prgname_template($cmp){?>
<h1><? echo($cmp->item(jq::get('pmodel')->params,'project'))?></h1>
<?php }//prgname_template?>