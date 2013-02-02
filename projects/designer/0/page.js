function editPage(row){
  var m = jq.get('pmodel');
  var project = m.params.project; 
  var page = m.rows[row].name;
  var params = m.rows[row].params;
  var url = "/projects/designer/pageeditor.php?edpage="+project+'.'+page;
  if(params != '')  url+='&edparam='+escape(params);
  window.location = url;
}
function deletePage(page){
  if(confirm("Точно удалить?")) jq.get('pmodel').remove(page); 
}
function newPage(){
  var _project = jq.get('pmodel').params.project; 
  var _name = document.getElementById('inp-name').value.trim();
  if(!_name) alert("Необходимо ввести имя новой страницы");
  else if (!(/^[a-zA-Z0-9_]+$/.test(_name))) alert("Недопустимые символы в имене страницы");
  else {
    jq.get('pmodel').insert({name:_name,project:_project});
  }
}

jq.registerEventHandler('pmodel','onfetch',[jq.get('pagelist'),'redraw']);
jq.registerEventHandler('CActionServer','onerror',function(e){
  alert(e.errortext);
});