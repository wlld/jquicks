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