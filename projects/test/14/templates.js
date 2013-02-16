jq.attachMethod('template','vdiscuss',function(){
//uses bbDecode
var __r='';
var l = {from:jq.get('mm').rows, index:-1};
for(l.k in l.from) {
var row = l.from[l.k]; l.index++;
__r+="<article> <header> <span class=\"msg_date\">";
__r+=row['date'];
__r+="</span> ";
__r+=(row['subject.title']==null)?"Без темы":row['subject.title'];
__r+=" <span class=\"msg_owner\">";
__r+=(row['owner.name']==null)?"Unknown user":row['owner.name'];
__r+="</span> parent=";
__r+=row['parent'];
__r+=" </header> <div> <div id=\"";
__r+=this.name;
__r+="_content_";
__r+=l['index'];
__r+="\"> <div class=\"content\">";
__r+=jq.ex.bb.decode(row['text']);
__r+="</div> ";
if(row['own']){
__r+=" <footer> <button onclick=\'my_remove(";
__r+=row['idx'];
__r+=")\'>Удалить</button> <button onclick=\'edit(";
__r+=l['index'];
__r+=")\'>Редактировать</button> </footer> ";
}
__r+=" </div> </div></article>";
}
return __r;
});//vdiscuss.template


jq.attachMethod('template','pager',function(){
var __r='';
if(this.model){
__r+=" ";
var model=jq.get(this.model);
__r+=" ";
if(model.count>0){
__r+=" ";
var limit=model.limit;
__r+=" ";
var pnum=limit>0?Math.ceil(model.count/limit):1;
__r+=" ";
var page=limit>0?Math.ceil((model.first+1)/limit):0;
__r+=" ";
if(pnum>1){
__r+=" <ul> ";
var loop = {start:1, max:pnum+1, step:1};
loop.index = loop.start - loop.step;
while((loop.index += loop.step)<loop.max){
__r+=" <li ";
if(loop['index']==page){
__r+=" class=\'selected\' ";
}else{
__r+="onclick=\"jq.get(\'";
__r+=this.name;
__r+="\').select(";
__r+=loop['index'];
__r+=")\" ";
}
__r+=" >";
__r+=loop['index'];
__r+="</li> ";
}
__r+=" </ul> ";
}
__r+=" ";
}
__r+=" ";
}
return __r;
});//pager.template

//functions//
jq.ex.bb = new function(){
    var tags1='img|url|email';
    var tags2='b|i|u|cite|color';
    var reg1=new RegExp(
        "(?:\\[("+tags1+")\\](.+?)\\[\\/\\1\\])|"+
        "(?:\\[(\\/)?("+tags2+")(?:(?:\\=|\\s)([^\\]]+))?\\])|"+
        "(\\n)","gi"
    );
    var reg2=/\[(\d+?)\]/g;
    this.decode=function(t){
        var n=0, ts=[], ns=[], cs=[], tags=[], r;
        t = t.replace(reg1,function(all,tag1,content,close,tag2,attr,lf){
            if(lf) return '<br>';
            if(tag1) {r=_parseBBTag1(tag1,content); return (r===false)? all:r; }
            tags[n] = [all,close,tag2,attr];
            if(close) {if(ts[0]===tag2) ts.shift(),ns.shift(); else cs.push(n)}
            else ts.unshift(tag2),ns.unshift(n);
            return '['+ n++ +']';
        });
        if(!n) return t;
        var test = ((cs=cs.concat(ns)).length>0);
        if(test) var errors = new RegExp(cs.join('|'));
        t = t.replace(reg2,function(all,n){
            var t=tags[n];
            if(!test||!errors.test(n)){
                var r = _parseBBTag2(t[1],t[2],t[3]);
                return (r===false)? all:r;
            }
            else return t[0];
        });
        return t;
    };
    function _parseBBTag1(tag,content){
        switch(tag){
            case 'img' : return "<img src='"+content+"' alt='"+content+"'>";
            case 'url' : return "<a href='"+content+"'>"+content+"</a>";
            case 'email' : return "<a href='mailto:"+content+"'>"+content+"</a>";
            default: return false;
        }
    }
    function _parseBBTag2(close,tag,attr){
        if(close) return "</"+tag+">";
        else{
            var c=attr? " style='color:"+attr+"'":'';
            return "<"+tag+c+">";
        }
    }
};
//functions//