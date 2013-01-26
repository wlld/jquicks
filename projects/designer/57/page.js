function compile(a){
  var cls = a.innerText;
  jq.get('TActionServer').registerCommand('TServiceController','compileServiceXML',{service:cls},function(e){
     if(e.status>0) alert(e.errortext);
     else alert('Ok');
  }); 
}