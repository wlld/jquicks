<!--pagetree-->
<h3>Дерево компонентов</h3>
{{if this->treemodel->count>0}}
<div class="cmdpanel">
  <div onclick="jq.get('{{this->name}}').deleteCmp()" class="button">Удалить</div>
  <div onclick="toggleAllCmp()" class="btn_all">Вставить компонент &gt;&gt;</div>
</div>
<div id="tree">
{{foreach from=this->treemodel#tree item=row name=tree}}
  {{if $row[i] == 0}}
    <p id="{{this->name}}.{{$tree[index]}}" onclick="jq.get('pagetree').select(this)">{{$row[n]}}</p>
  {{elseif $row[i] == 1}}
    <p id="{{this->name}}.{{$tree[index]}}" onclick="jq.get('pagetree').select(this)">{{$row[n]}}</p>
    <dl>
  {{elseif $row[i] == 2}}
    <dt>
    {{if $row[s] == -1}}
      <p id="{{this->name}}.{{$tree[index]}}">невизуальные компоненты</p>
    {{else}}
      <p id="{{this->name}}.{{$tree[index]}}">секция {{$row[s]}}</p>
    {{/if}}
    <dd>
  {{elseif $row[i] == 3}}
    </dd>
  {{elseif $row[i] == 4}}
    </dl>
  {{elseif $row[i] == 5}}
    <p id="{{this->name}}.{{$tree[index]}}" onclick="jq.get('pagetree').select(this)">{{$row[n]}}</p>
  {{/if}}
{{/foreach}}
<hr>
</div>
{{/if}}
<div id = '{{this->name}}.shield' class='shield'></div>
<!--pagetree-->
<!--prpeditor-->
<div class="cmdpanel">
<div onclick="{{@}}save()" id={{this->name}}.indicator>Сохранить</div>
</div>
{{if this->prpmodel->count>0}}
<form onsubmit="return false;">
<ul class="content">
  {{foreach from=this->prpmodel->rows item=prp name=lp}}
  <li>{{$prp[n]}}<div>
    {{if $prp[t] == 'boolean'}} 
       <input type="checkbox" {{if $prp[v]>0}}checked{{/if}} onchange="{{@}}prpchange({{$lp[index]}},this)" name="{{$prp[n]}}">
    {{elseif ($prp[t] == 'text') || ($prp[t] == 'object')}}
       <div class = "obj">
       <textarea rows=1 onchange="{{@}}prpchange({{$lp[index]}},this)" name="{{$prp[n]}}">{{$prp[v]|escape}}</textarea>
       </div>
       <div class='expand_btn' onclick="{{@}}showEditor('{{$prp[n]}}',{{$lp[index]}})"></div>
    {{elseif $prp[t]=='list'}}
      <select onchange="{{@}}prpchange({{$lp[index]}},this)" name="{{$prp[n]}}">
      {{foreach from=$prp[o] item=opt}} 
         <option {{if $opt==$prp[v]}}selected{{/if}}>{{$opt}}</option>
      {{/foreach}}
      </select>
    {{elseif $prp[t]=='link'}}
       <div class = "obj">
       <input type="text" value="{{$prp[v]|escape}}" onchange="{{@}}prpchange({{$lp[index]}},this)" spellcheck="false" disabled  name="{{$prp[n]}}"/>
       </div>
       <div class='expand_btn' onclick="{{@}}showEditor('{{$prp[n]}}',{{$lp[index]}})"></div>
    {{else}}
       <input type="text" value="{{$prp[v]|escape}}" onchange="{{@}}prpchange({{$lp[index]}},this)" spellcheck="false"  name="{{$prp[n]}}"/>
    {{/if}}
  </div></li>
  {{/foreach}}
</ul>
</form>
{{/if}}
<!--prpeditor-->
<!--tpleditor-->
{{if this->tplmodel->count==1}}
<div class="cmdpanel">
<div onclick="jq.get('tpleditor').save(this)">Сохранить</div>
<div onclick="showtree()">Дерево</div>
</div>
<div class="content">
<textarea class="scrollbox" spellcheck="false">{{this->tplmodel#tpl|escape}}</textarea>
</div>
{{/if}}
<!--tpleditor-->
<!--pageeditor-->
<div id="main">
  <div id={{this->name}}_0 class='section'>
    {{section 0}}
  </div>
  <div id={{this->name}}_1 class='section'>
    {{section 1}}
  </div>
</div>
<div id="shield">
{{section 2}}
</div>
<!--pageeditor-->
<!--js_editor-->
<div class="cmdpanel">
<div onclick="jq.get('js_editor').save()">Сохранить</div>
</div>
<div id="js_content"></div>
<!--js_editor-->
<!--palette_page_1-->
{{foreach from=this->components item=cmp}}
{{assign var=path value=isCoreClass($cmp)?'/core/':'/components/'}}
   <img alt="{{$cmp}}" title="{{$cmp}}" src="{{$path.$cmp}}/icon.png"?>
{{/foreach}}
<!--palette_page_1-->
<!--palette_page_2-->
{{foreach from=this->components item=cmp}}
{{assign var=path value=isCoreClass($cmp)?'/core/':'/components/'}}
   <img alt="{{$cmp}}" title="{{$cmp}}" src="{{$path.$cmp}}/icon.png"?>
{{/foreach}}
<!--palette_page_2-->
<!--palette_page_selector-->
<ul>
{{foreach from=this->pages item=page name=l}}
  <li
     {{if $l[index]==this->active}}class="active"{{/if}}
     onclick="{{@}}select('{{$page}}')">{{$page}}
  </li>
{{/foreach}}
</ul>
<!--palette_page_selector-->
<!--frame-->
<iframe src="{{this->url}}"></iframe>
<div id='{{this->name}}.shield' class='shield'></div>
<!--frame-->
<!--csseditor-->
{{if this->cssmodel->count==1}}
<div class="cmdpanel">
<div onclick="jq.get('csseditor').save(this)">Сохранить</div>
</div>
<div class="content">
<textarea class="scrollbox" spellcheck="false">{{this->cssmodel#css|escape}}</textarea>
</div>
{{/if}}
<!--csseditor-->
<!--component_editor-->
<h3>
<table width="100%">
<tr>
  <td>Имя компонента</td>
  <td width="20px" onclick="resizeeditor()">&gt;&gt;</td>
</tr>
</table>
</h3>
<div id={{this->name}}_0 class='section'>
  {{section 0}}
</div>
<div id={{this->name}}_1 class='section'>
  {{section 1}}
</div>

<!--component_editor-->
<!--page_editor-->
<div id={{this->name}}_0 class='section'>
  {{section 0}}
</div>
<div id={{this->name}}_1 class='section'>
  {{section 1}}
</div>
<!--page_editor-->
<!--html_editor-->
<div id={{this->name}}_1 class='section'>
  {{section 0}}
</div>
<!--html_editor-->
<!--palette-->
<div id={{this->name}}_0 class='section'>
  {{section 0}}
</div>
<div id={{this->name}}_1 class='section'>
  {{section 1}}
</div>
<!--palette-->
<!--php_editor-->
<div class="cmdpanel">
   <div  onclick="jq.get('php_editor').save()">Сохранить</div>
</div>
<div class='content'>
<textarea spellcheck='false'>{{this->phpmodel#php|escape}}</textarea>
</div>
<!--php_editor-->
<!--msglist-->
 
<!--msglist-->
<!--allcmp-->
<div>Для вставки в проект существующего компонента перетащите его в дерево разработки</div>
{{assign var=type value=''}}
{{foreach from=this->model->rows item=row}}
{{if $type != $row[type]}}
  <h4>{{$row[type]}}</h4>
  {{assign var=type value=$row[type]}}
{{/if}}
<p>{{$row[name]}}</p>
{{/foreach}}
<!--allcmp-->
<!--palette_page_3-->
{{foreach from=this->components item=cmp}}
{{assign var=path value=isCoreClass($cmp)?'/core/':'/components/'}}
   <img alt="{{$cmp}}" title="{{$cmp}}" src="{{$path.$cmp}}/icon.png"?>
{{/foreach}}
<!--palette_page_3-->
<!--textspeededitor-->
<header>
<button onclick="{{@}}save()">Ок</button>
<button onclick="{{@}}cancel()">Отмена</button>
</header>
<div>
<textarea wrap="soft"></textarea>
</div>
<!--textspeededitor-->
<!--linkscheckingdialog-->
<header>
<button onclick="{{@}}cancel()">Отмена</button>
</header>
<div>
{{if this->state==2}}
  <div class="result">
    {{if this->result>0}}
    {{assign var=a value=this->result%20}}
В дочерней таблице есть {{this->result%20}} несвязанн{{$a<1?'ых':$a<2?'ая':$a<5?'ые':'ых'}} запис{{$a<1?'ей':$a<2?'ь':$a<5?'и':'ей'}}. Ситуацию можно исправить одним из нижеуказанных способов
    {{else}}
Таблицы находятся в состоянии ссылочной целостности
    {{/if}}
  </div> 
  {{if this->result>0}}
    <form>
    <div><input type="radio" name="mode" checked>Удалить все несвязанные записи</div>
    <div><input type="radio" name="mode">Присвоить ссылочному полю несвязанных записей NULL</div>
    </form>
    <div class="repair"><button onclick="{{@}}repair()">Починить</button></div>
  {{/if}}
{{else}}
  <div id="{{this->name}}_loader">{{if this->state==0}}Проверяю...{{else}}Починяю...{{/if}}</div>
{{/if}}
</div>
<!--linkscheckingdialog-->
<!--prp_css_selector-->
<ul>
{{foreach from=this->pages item=page name=l}}
  <li
     {{if $l[index]==this->active}}class="active"{{/if}}
     onclick="{{@}}select('{{$page}}')">{{$page}}
  </li>
{{/foreach}}
</ul>
<!--prp_css_selector-->
<!--html_js_php_selector-->
<ul>
{{foreach from=this->pages item=page name=l}}
  <li
     {{if $l[index]==this->active}}class="active"{{/if}}
     onclick="{{@}}select('{{$page}}')">{{$page}}
  </li>
{{/foreach}}
</ul>
<!--html_js_php_selector-->
<!--linkseditor-->
<div class="cmdpanel">
<div onclick="{{@}}add()">Новая</div>
<div onclick="{{@}}remove()">Удалить</div>
<div onclick="{{@}}edit()">Редактировать</div>
<div onclick="{{@}}check()">Проверка</div>
</div>
<div class="content">
<table>
<tr>
  <td>Потомок</td><td>&nbsp</td><td>Родитель</td>
</tr>
{{foreach from=this->model->rows item=link name=l}}
<tr onclick="{{@}}select(this,{{$l[index]}})">
  <td>
  {{if $link[type]}}
     <div class="typeimg trating"></div>
     {{$link[child]}}.<wbr>{{$link[lfield]}}<wbr>({{$link[rfield]}})
  {{else}}
     <div class="typeimg"></div>
     {{$link[child]}}.<wbr>{{$link[lfield]}}
  {{/if}}
  </td>
  <td><div class="link_image{{if $link[op]=='SET NULL'}} NULL{{else}} {{$link[op]}}{{/if}}"></div></td>
  {{assign var=brake value = $link[service_name]==''}}
  <td>{{if $link[service_name]!=''}}{{$link[service_name]}}.<wbr>{{$link[parent]}}{{if $link[type]}}.<wbr>{{$link[tfield]}}{{/if}}{{else}}???{{/if}}
  </td>
</tr>
{{/foreach}}
</table>
</div>
<!--linkseditor-->
<!--linkspeededitor-->
<header>
<button onclick="{{@}}save()">Ок</button>
<button onclick="{{@}}cancel()">Отмена</button>
</header>
<form>
<div>
<div class="formfield">Модель:<select name="child" onchange="{{@}}loadModels()"></select></div>
<div class="formfield">Поле:<select name="lfield" onchange="{{@}}onSelectLField()"></select></div>
<div class="link_image NONE"></div>
<div class="formfield">Служба:<select name="service" onchange="{{@}}onSelectService()"></select></div>
<div class="formfield">Модель-родитель:<select name="parent"></select></div>
<div id="{{this->name}}_loader"></div>
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
<!--linkspeededitor-->