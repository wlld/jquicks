<!--discuss-->
{{section 0}}
<!--discuss-->
<!--vdiscuss-->
{{foreach from=mm->rows item=row name=l}}
<article>
  <header>
    <span class="msg_date">{{$row[date]}}</span>
    {{$row['subject.title']|ifNull:"Без темы"}} 
    <span class="msg_owner">{{$row['owner.name']|ifNull:"Unknown user"}}</span>
    parent={{$row[parent]}}
  </header>
  <div>
  <div id="{{this->name}}_content_{{$l[index]}}">
     <div class="content">{{$row[text]|bbDecode}}</div>
     {{if $row[own]}}
     <footer>
       <button onclick='my_remove({{$row[idx]}})'>Удалить</button>
       <button onclick='edit({{$l[index]}})'>Редактировать</button>
     </footer>
     {{/if}}
  </div>
  </div>
</article>
{{/foreach}}
<!--vdiscuss-->
<!--pager-->
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
<!--pager-->
<!--newmsg-->
<form onsubmit="return false;">
<header>Новая запись</header>
<textarea name="text"></textarea>
<input type="button" onclick="{{@}}submit()" value="Ok"/>
{{if isKeyExists(mm->params,'subject')}}
<input type="hidden" name='subject' value="{{mm->params[subject]}}"/>
{{/if}}
</form>

<!--newmsg-->
<!--editor-->
<form onsubmit="return false;">
<textarea name="text"></textarea>
<input name="parent" type='text' />
<footer>
  <button onclick="{{@}}submit()">Ok</button>
  <button onclick="cancel()">Отмена</button>
</footer>
</form>
<!--editor-->