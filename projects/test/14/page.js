var curent,editor;
function edit(n){
  var content,container,ta;
  if(curent) curent.style.display='block';
  content = document.getElementById('vdiscuss_content_'+n);
  h = content.getElementsByTagName('div')[0].offsetHeight;
  if(!editor) editor = jq.get('editor');
  editor.init(n);
  container = content.parentNode;
  content.style.display='none';
  container.appendChild(editor.id);
  editor.id.style.display='block';
  ta = editor.id.getElementsByTagName('textarea')[0];
  ta.style.height=h+'px';
  ta.focus();
  curent = content;
}

function cancel(){
  if(curent) curent.style.display='block';
  editor.id.style.display='none';
  curent = null;
}
function my_remove(n){
  jq.get('mm').remove(n,true);
}