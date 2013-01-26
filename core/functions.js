//escape//
jq.ex.escape = function(s) {
    if(typeof s === 'number') return s;
    if(typeof s !== 'string') throw new Error('escape()\'s argument is not a string or number');
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/'/g,'&#039;').replace(/"/g,'&quot;');
};
//escape//
//inArray//
jq.ex.inArray = function(s,a) {
    for(var i in a) if(s == a[i]) return true;
    return false;
};
//inArray//
//isCoreClass//
jq.ex.isCoreClass = function(c) {
    return /TComponent|TVidget|TModel|TActionServer|TContainer|TPage|TService|TDBService|TDataBase|TAccountService|TLoginDialog/.test(c);
};
//isCoreClass//
//bbDecode//
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
//bbDecode//