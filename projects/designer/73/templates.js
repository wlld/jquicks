jq.attachMethod('template','modelpagecontrol_1',function(){
var __r='';
if(this.model){
var model=jq.get(this.model);
if(model.count>0){
var limit=model.limit;
var pnum=limit>0?Math.ceil(model.count/limit):1;
var page=limit>0?Math.ceil((model.first+1)/limit):0;
if(pnum>1){
__r+="<ul>";
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
__r+="</li>";
}
__r+="</ul>";
}
}
}
return __r;
});//modelpagecontrol_1.template
jq.attachMethod('template','news',function(){
//uses bbDecode
var __r='';
__r+="<h1>Новости</h1>";
var __var0 = {from:jq.get('m_news').rows, index:-1};
for(__var0.k in __var0.from) {
var row = __var0.from[__var0.k]; __var0.index++;
__r+="<div class=\"newsblock\"> <div class=\"newsdate\">";
__r+=row['date'];
__r+="</div> <div class=\"newtext\">";
__r+=jq.ex.bb.decode(row['text']);
__r+="</div> <div class=\"delbtn\" onclick=\"delete_news(";
__r+=row['idx'];
__r+=")\"></div></div>";
}
return __r;
});//news.template

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