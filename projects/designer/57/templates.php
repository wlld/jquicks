<?php function srvcompiler_template($cmp){?>
<h1>Компилятор файлов описаний служб</h1>
<? $cmp->drawSection(0) ?>
<?php }//srvcompiler_template?>
<?php function vidget_1_template($cmp){?>
<ul>
<li><a onclick="compile(this)">TAccountService</a></li>
<li><a onclick="compile(this)">TServiceController</a></li>
<li><a onclick="compile(this)">TDiscussService</a></li>
<li><a onclick="compile(this)">TPageEditService</a></li>
<li><a onclick="compile(this)">TForumService</a></li>
</ul>
<?php }//vidget_1_template?>