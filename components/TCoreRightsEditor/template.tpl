{{assign var=ms value=this->mrights}}
{{if $ms->count>0}}
<table border=1 cellpadding=0 cellspacing=0>
<tr id='{{this->name}}_filter' onkeydown="if(event.keyCode==13) jq.get('{{this->name}}').filter()">
  <td>&nbsp;</td>
  <td><input type="text" field="model" value="{{this->filters['model']}}"></td>
  <td><input type="text" field="group" value="{{this->filters['group']}}"></td>
  <td><input type="text" field="fetch-group" value="{{this->filters['fetch-group']}}"></td>
  <td><input type="text" field="fetch-owner" value="{{this->filters['fetch-owner']}}"></td>
  <td><input type="text" field="update-group" value="{{this->filters['update-group']}}"></td>
  <td><input type="text" field="update-owner" value="{{this->filters['update-owner']}}"></td>
  <td><input type="text" field="remove-group" value="{{this->filters['remove-group']}}"></td>
  <td><input type="text" field="remove-owner" value="{{this->filters['remove-owner']}}"></td>
  <td><input type="text" field="insert-group" value="{{this->filters['insert-group']}}"></td>
  <td>&nbsp;</td>
</tr>
<tr class='head'>
  <td>&nbsp;</td>
  <td>model</td>
  <td>group</td>
  <td>fetch-group</td>
  <td>fetch-owner</td>
  <td>update-group</td>
  <td>update-owner</td>
  <td>remove-group</td>
  <td>remove-owner</td>
  <td>insert-group</td>
  <td>&nbsp;</td>
</tr>
{{foreach from=$ms->rows item=row name=loop}}
{{if $row[filter]==0}}
<tr>
  <td><img src="data/image/delete.png" onclick="jq.get('{{this->name}}').remove({{$loop[index]}})"></td>
  <td>{{$row[model]}}</td>
  <td>{{$row[group]}}</td>
  <td>{{$row["fetch-group"]}}</td>
  <td>{{$row["fetch-owner"]}}</td>
  <td>{{$row["update-group"]}}</td>
  <td>{{$row["update-owner"]}}</td>
  <td>{{$row["remove-group"]}}</td>
  <td>{{$row["remove-owner"]}}</td>
  <td>{{$row["insert-group"]}}</td>
  <td><img src="data/image/modify.png" onclick="jq.get('{{this->name}}').show_editor('{{$loop[index]}}')"></td>
</tr>
{{/if}}
{{/foreach}}
</table>
{{else}}
  Модель rights не содержит строк
{{/if}}

<div id="{{this->name}}_bg"></div>
<div id="{{this->name}}_editor">
<header>
  <button class="cancel" onclick="jq.get('{{this->name}}').hide_editor()">Отмена</button>
  <button class="ok" onclick="jq.get('{{this->name}}').save()">Ок</button>
  <span>Текст заголовка</span>
</header>
<ul>
<li>model<div class="control"><select onchange="jq.get('{{this->name}}').changeModel(this.value)">
{{foreach from=this->mmodels->rows item=model}}
  <option>{{$model[name]}}</option>
{{/foreach}}
</select></div>
</li>
<li>group<div class="control"><select>
  <option value=0>0-guests</option>
  {{foreach from=this->mgroups->rows item=group}}
    <option value={{$group[idx]}}>{{$group[idx].'-'.$group[name]}}</option>
  {{/foreach}}
</select></div></li>
<li>fetch-group<div class="control"><input type="text" onfocus="jq.get('{{this->name}}').drawFields(this,'fetch')"></div></li>
<li>fetch-owner<div class="control"><input type="text" onfocus="jq.get('{{this->name}}').drawFields(this,'fetch')"></div></li>
<li>update-group<div class="control"><input type="text" onfocus="jq.get('{{this->name}}').drawFields(this,'update')"></div></li>
<li>update-owner<div class="control"><input type="text" onfocus="jq.get('{{this->name}}').drawFields(this,'update')"></div></li>
<li>remove-group<div class="control"><input type="checkbox"></div></li>
<li>remove-owner<div class="control"><input type="checkbox"></div></li>
<li>insert-group<div class="control"><input type="checkbox"></div></li>
</ul>
<div id="{{this->name}}_fields"></div>
</div>