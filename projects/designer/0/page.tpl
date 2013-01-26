<!--pages-->
<div>
  <div><a href="/projects/designer/changelog.php">Jquicks v1.0a3</a></div>
  <div>{{section 0}}</div>
</div>
<!--pages-->
<!--pagelist-->
<ul>
{{foreach from=pmodel->rows item=row name=lp}}
 <li>{{$row[name]}}
    <div class="button edit_button" onclick="editPage('{{$lp[index]}}')"></div>
    {{if $row[name]!='index'}}
    <div class="button delete_button" onclick="deletePage('{{$row[idx]}}')"></div>
    {{/if}}
    {{if 0}}<div class="button compile_button"></div>{{/if}}
 </li>
{{/foreach}}
</ul>
<!--pagelist-->
<!--pagetree-->
{{this->name}}
<!--pagetree-->
<!--newpage-->
<input id="inp-name" type="text" value="" placeholder="имя новой страницы">
<div class="button" onclick="newPage()"></div>
<!--newpage-->
<!--prgname-->
<h1>{{pmodel->params[project]}}</h1>
<!--prgname-->