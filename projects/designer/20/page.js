function resizeeditor(){
	// Изменение размера редактора компонента
    var section = document.getElementById('component_editor_0');
    var editor = document.getElementById('component_editor');
    var style = section.style;
    var td = editor.getElementsByTagName('h3')[0].getElementsByTagName('td')[1];
    if (style.width!='800px') {
        style.width='800px';
        td.innerHTML='<<';
    }
    else {
        style.width='270px';
        td.innerHTML='>>';
    }
}
function showtree(){
    var _tpl = jq.get('tpleditor').id.getElementsByTagName('textarea')[0].value;
    jq.get('server').registerCommand('page_edit_service','getCFGTree',{tpl:_tpl},onGetTree);
}
function onGetTree (msg){
    var tw = window.open('','','width=700,height=800,toolbar=0').document;
    var style = 'div{padding-left: 20px; border-left: #555 1px solid; margin:0;} p{margin:0;}';
    tw.body.innerHTML = '<style>'+style+'</style>'+msg.tree;
}
function toggleAllCmp(){
    var all = jq.get('allcmp');
    if(all.id.offsetHeight !=0) all.hide();
    else all.show();
}
jq.registerEventHandler('CActionServer','onerror',function(e){
  var msg = document.getElementById('msglist');
  msg.innerHTML += '<p class="ajaxerror">HTTP:'+e.errortext.replace(/\<.+?\>/g,'')+'</p>';
})
jq.registerEventHandler('frame','onerror',function(e){
  var msg = document.getElementById('msglist');
  if(e.errortext)
  msg.innerHTML += '<p class="ajaxerror">HTTP:'+e.errortext.replace(/\<.+?\>/g,'')+'</p>';
  else if(e.msg)
  msg.innerHTML += '<p class="jserror">HTTP:'+e.msg.replace(/\<.+?\>/g,'')+'</p>';
  else msg.innerHTML += '<p class="jserror">Unknown error</p>'; 
})
jq.registerEventHandler('frame','onrefresh',function(){
  var msg = document.getElementById('msglist');
  msg.innerHTML = '';
})

