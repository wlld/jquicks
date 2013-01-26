jq.attachMethod('template','pagelist',function(){
var __r='';
__r+="<ul>";
var lp = {from:jq.get('pmodel').rows, index:-1};
for(lp.k in lp.from) {
var row = lp.from[lp.k]; lp.index++;
__r+=" <li>";
__r+=row['name'];
__r+=" <div class=\"button edit_button\" onclick=\"editPage(\'";
__r+=lp['index'];
__r+="\')\"></div> ";
if(row['name']!='index'){
__r+=" <div class=\"button delete_button\" onclick=\"deletePage(\'";
__r+=row['idx'];
__r+="\')\"></div> ";
}
__r+=" ";
if(0){
__r+="<div class=\"button compile_button\"></div>";
}
__r+=" </li>";
}
__r+="</ul>";
return __r;
});//pagelist.template