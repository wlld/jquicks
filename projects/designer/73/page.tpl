<!--index-->
<div id="ilogo">{{section 0}}</div>
<div id="imenu">{{section 1}}</div>
<div id="icontent">
  <div id="ileftpanel">{{section 2}}</div>
  <div id="irightpanel">{{section 3}}</div>
</div>
<!--index-->
<!--logo-->
JQuicks 1.0.0a4
<!--logo-->
<!--menu-->
<a href="https://github.com/wlld/jquicks" class="medit">Git</a>
<a href="https://github.com/wlld/jquicks/issues" class="medit">Bug tracker</a>
<a href="/projects/designer/srvcompiler.php" class="mtools">Компилятор служб</a>
<!--menu-->
<!--shelp-->
<h1>Справка по службам</h1>
<ul>
  <li><a href="/projects/designer/servicehelp.php?service=TServiceController">TServiceController</a></li>
  <li><a href="/projects/designer/servicehelp.php?service=TPageEditService">TPageEditService</a></li>
  <li><a href="/projects/designer/servicehelp.php?service=TAccountService">TAccountService</a></li>
  <li><a href="/projects/designer/servicehelp.php?service=TDiscussService">TDiscussService</a></li>
  <li><a href="/projects/designer/servicehelp.php?service=TForumService">TForumService</a></li>
</ul>
<!--shelp-->
<!--concept-->
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
<!--concept-->
<!--news-->
<h1>Новости</h1>
{{foreach from=m_news->rows item=row}}
<div class="newsblock">
  <div class="newsdate">{{$row[date]}}</div>
  <div class="newtext">{{$row[text]|bbDecode}}</div>
  <div class="delbtn" onclick="delete_news({{$row[idx]}})"></div>
</div>
{{/foreach}}
<!--news-->
<!--modelpagecontrol_1-->
{{if this->model}}
{{assign var=model value=this->model^}}
{{if $model->count>0}}
{{assign var=limit value=$model->limit}}
{{assign var=pnum value=($limit>0)?ceil($model->count/$limit):1}}
{{assign var=page value=($limit>0)?ceil(($model->first+1)/$limit):0}}
{{if $pnum>1}}
<ul>
{{for start=1 max=$pnum+1 name=loop}}
  <li
   {{if $loop[index]==$page}} class='selected'
   {{else}}onclick="jq.get('{{this->name}}').select({{$loop[index]}})"
   {{/if}}
  >{{$loop[index]}}</li>
{{/for}}
</ul>
{{/if}}
{{/if}}
{{/if}}
<!--modelpagecontrol_1-->
<!--frm_new_news-->
<form onsubmit="return false;">
<textarea name="text"></textarea>
<input type="button" onclick="{{@}}submit()" value="Ok"/>
</form>

<!--frm_new_news-->
<!--projects-->
<h1>Проекты</h1>
<ul>
  <li><a href="/projects/designer/pages.php?project=designer">Дизайнер</a></li>
  <li><a href="/projects/designer/pages.php?project=waterline">Ватерлиния</a></li>
  <li><a href="/projects/designer/pages.php?project=test">Тест</a></li>
</ul>
<!--projects-->