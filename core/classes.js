var jq = new function(){
    var _c = {}; //components list
    var _events = {}; //events list
    this.ex = {}; //extern functions
    window.onload = function(){ jq.event('window','onload',{})};

    this.CComponent = function (params){
        for (var p in params) if(params.hasOwnProperty(p)) this[p] = params[p];
    };

    this.event = function(obj,event,e){
        var h,ev,r;
        if (ev = _events[event]){
            if (typeof obj === 'string') h=ev[obj];
            else if (typeof obj === 'object'){
                h = ev[obj.name];
                if(ev[obj.constructor.cname]){
                    if (h) h = h.concat(ev[obj.constructor.cname])
                    else h = ev[obj.constructor.cname];
                }
            } 
            else return;
            if (h) for(var i = h.length-1; i>=0; i--) {
                if(typeof h[i]==='function') r = h[i](e);
                else if (typeof h[i] === 'object') r = h[i][0][h[i][1]](e);
                if (r) return true;
            }
        }
        return false;
    };
    this.registerEventHandler = function(cname,event,handler){
        if(!_events[event]) _events[event] = {};
        if(!_events[event][cname]) _events[event][cname] = [];
        _events[event][cname].push(handler);
    };
    this.newClass = function(newclass,parent,mtds){
        if(typeof this[parent] !== 'function') throw new Error(parent+' is not exists');
        var constr = mtds.construct;
        mtds.construct = null;
        var F = function(){};
        F.prototype = this[parent].prototype;
        constr.prototype = new F();
        constr.prototype.constructor = constr;
        constr.superclass = this[parent].prototype;
        constr.cname = newclass;
        for(var mtd in mtds) if(mtds.hasOwnProperty(mtd)) constr.prototype[mtd] = mtds[mtd];
        this[newclass] = constr;
    };
    this.create = function(n,cls,params,embed){
        if(typeof this[cls] !== 'function') throw new Error(cls+' is not exists');
        params.name = n;
        var cmp = new this[cls](params);
        if (!embed) _c[n] = cmp;
        else return cmp;
    };
    this.get = function(n){
        if(!_c[n]) throw new Error('Component "'+n+'" does not exist');
        return _c[n]
    };
    this.attachMethod = function(name,target,mtd){
        if(typeof this[target]==='function') this[target].prototype[name] = mtd;
        else if(typeof _c[target]==='object') _c[target][name] = mtd;
        else throw new Error(target+' not exists');
    }
};
/*--CLASS--*/
jq.newClass('CVidget','CComponent',{
    construct:function CVidget(){
       this.view_model = '';
       this.show_loader = 0; 
       jq.CVidget.superclass.constructor.apply(this,arguments);
       jq.registerEventHandler("window","onload",[this,'onload']);
       if(this.view_model != ''){
           jq.registerEventHandler(this.view_model,"onfetch",[this,'redraw']);
           jq.registerEventHandler(this.view_model,"onupdate",[this,'redraw']);
           if (this.show_loader>0) jq.registerEventHandler(this.view_model,"onstatechanged",[this,'switchLoader']);
       } 
    },
    onload:function(){
       this.id = document.getElementById(this.name);
       this.id.cmp = this;
    },
    redraw:function(){
       if (this.template) {
           try{ this.id.innerHTML = this.template(); }
           catch(e){
               this.id.innerHTML = 'Templete drawing error: '+e.message;
           }
       }
    },
    switchLoader:function(e){
        if(e.newstate===jq.STATE_CHANGED){
            if(typeof this.loader !== 'object'){
                this.loader = document.createElement('DIV');
                this.loader.className = 'ajax_loader'; 
            }
            this.loader.style.display = 'block';
            this.id.appendChild(this.loader);
            if(this.id.style.position !== 'absolute') this.id.style.position = 'relative';
        }
        else{
            this.loader.style.display = 'none';
        }
    }
});
/*--CLASS--*/
jq.newClass('CModel','CComponent',{
    construct:function CModel(){
        jq.CModel.superclass.constructor.apply(this,arguments);
        this.curent = 0;
        if (!this.params||(this.params.length == 0)) this.params = {};
        if(this.rows) this.state = jq.STATE_READY;
        else this.state = jq.STATE_EMPTY;
        this.queie = [];
    },
    getField:function(name){
        if (this.state != jq.STATE_READY) this._stateError();
        return this.rows[this.curent][name];
    },
    getParam:function(name){
        return this.params[name];
    },
    clear:function(){
        this.state = jq.STATE_EMPTY;
        this.rows = [];
        this.count = 0;
        jq.event(this,'onfetch');
    },
    fetch:function(params,mode){
        if (this.state == jq.STATE_CHANGED) this._stateError();
        if (params) for(var p in params) if (params.hasOwnProperty(p)) this.params[p] = params[p];
        this._setState(jq.STATE_CHANGED);
        this._queryData(mode);
    },
    _queryData:function(mode){
        var args = {
            params:this.params||[],
            first:this.first||0,
            limit:this.limit||0
        };
        if (mode!==null) args.mode = mode;
        jq.get('TActionServer').registerCommand(this.name,'fetch',args,[this,'_onFetch']);
    },
    update:function(_values,_row){
        if (this.state != jq.STATE_READY) this._stateError();
        if (!_row) _row = this.curent;
        var id = this._pushCommand({values:_values,row:_row});
        var args = {
            values:_values,
            index:this.rows[_row].idx,
            id:id
        };
        jq.get('TActionServer').registerCommand(this.name,'update',args,[this,'_onUpdate']);
    },
    insert:function(_values,_fetch){
        if (this.state == jq.STATE_CHANGED) this._stateError();
        var args = {
            values:_values
        };
        jq.get('TActionServer').registerCommand(this.name,'insert',args,[this,'_onInsert']);
        if((typeof _fetch==='undefined') || _fetch) this.fetch({},jq.FETCH_IF_UPDATE);
    },
    remove:function(_idx,_fetch){
        var args = {
            index:_idx
        };
        jq.get('TActionServer').registerCommand(this.name,'remove',args,[this,'_onRemove']);
        if((typeof _fetch==='undefined') || _fetch) this.fetch({},jq.FETCH_IF_UPDATE);
    },
    _onFetch:function(data){
        if(data.status == 0){
            this.rows = data.rows;
            this.count = data.count;
            if(this.cache){
                var ckey = this.params.toString()+this.limit+this.first;
                this.cache_store[ckey] = data; 
            }
            this._setState(jq.STATE_READY);
            jq.event(this,'onfetch');
        }
        else if(data.status == jq.NOT_MODIFIED){
            this._setState(jq.STATE_READY);
            return true;
        }
        else  this._setState(jq.STATE_ERROR);
    },
    _onUpdate:function(data) {
        var c;
        if(data.id !== undefined){
            c = this.queie[data.id];
            c.status = data.status;
        } else c = data;
        if(data.status == 0){
            for(var f in c.values) if(c.values.hasOwnProperty(f)) this.rows[c.row][f] = c.values[f];
            this.queie[data.id] = null;
        }
        return jq.event(this,'onupdate',c);
    },
    _onInsert:function(data) {
        if(data.status === 0) jq.event(this,'oninsert');
    },
    _onRemove:function(data) {
        if(data.status === 0) jq.event(this,'onremove');
    },
    _pushCommand:function(obj){
        for(var i=0,l=this.queie.length;i<l;i++) if(!this.queie[i]) break;
        this.queie[i] = obj;
        return i;
    },
    _setState:function(s){
        var old = this.state;
        this.state = s;
        jq.event(this,'onstatechanged',{oldstate:old,newstate:s});
    },
    _stateError:function(){
        var stext = 'UNKNOWN';
        if (this.state == jq.STATE_READY) stext = 'STATE_READY';
        else if (this.state == jq.STATE_CHANGED) stext = 'STATE_CHANGED';
        else if (this.state == jq.STATE_EMPTY) stext = 'STATE_EMPTY';
        else if (this.state == jq.STATE_ERROR) stext = 'STATE_ERROR';
        throw new Error('Model "'+this.name+'" is in '+stext+' state.');
    }
});
jq.STATE_READY=0;
jq.STATE_CHANGED=1;
jq.STATE_EMPTY = 2;
jq.STATE_ERROR = 3;
jq.FETCH_IF_UPDATE = 1;
jq.NOT_MODIFIED = 100;
/*--CLASS--*/
jq.newClass('CActionServer','CComponent',{
    construct:function CActionServer(){
        jq.CVidget.superclass.constructor.apply(this,arguments);
        this._xhr = this._getXmlHttp();   // XMLHttpRequest
        this._sendcb = [];     // функции обратного вызова отосланных команд
        this._commands = [];   // коллекция неотосланных команд
        this._callbacks = [];  // коллекция функций обратного вызова, соответствующих элементам _commands[]
        this._timeout = null;
        var this_obj = this;
        this._xhrCallback = function(){if (this_obj._xhr.readyState == 4) this_obj._processAnswer();};
        this._sendQueued = function(){ this_obj._timeout = null; this_obj._sendRequest(); };
    },
    registerCommand:function(_service,_method,_args,_callback){
        if(!this._xhr) return;
        this._commands.push({service:_service, method:_method, args:_args});
        this._callbacks.push(_callback);
        if (!this._timeout) this._timeout = setTimeout(this._sendQueued,1);
    },
    _sendRequest:function(){
        if (!this._timeout && this.busy) {this._timeout = setTimeout(this._sendQueued,100); return;}
        this.busy = true;
        if(this._commands.length==0) return;
        this._sendcb = this._callbacks;
        this._callbacks = [];
        var params = "&queue="+encodeURIComponent(JSON.stringify(this._commands));
        this._commands = [];
        var xhr = this._xhr;
        var url = window.location.pathname.replace(/[^\/]*$/, '.dispatcher.php');
        xhr.open('POST',url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = this._xhrCallback;
        xhr.send(params);
    },
    _processAnswer:function(){
        var answer, i, cb = this._sendcb, ok, r, func;
        if(this._xhr.status==200){
            try{
                answer = eval('('+this._xhr.responseText+')');
                ok = true;
            } catch (e) {ok = false;}
        }
        for (i=0;i<cb.length;i++){
            var e = ok?answer[i]:{status:1,errortext:this._xhr.responseText};
            func = cb[i];
            if ((typeof func === 'object') && (func)) r = func[0][func[1]](e);
            else if ((typeof func === 'function' )) r = func(e);
            else r = false;
            if(!r &&(e.status>0)) jq.event(this,'onerror',e);
        }
        this.busy = false;
    },
    _getXmlHttp:function(){
        var xmlhttp;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (E) {
                xmlhttp = false;
            }
        }
        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        if (!xmlhttp) return;
        return xmlhttp;
    }
});
var JSON;
if (!JSON) JSON = {};
(function (){
function f(n) {
   return n < 10 ? '0' + n : n;
}
if (typeof Date.prototype.toJSON !== 'function') {
    Date.prototype.toJSON = function (key) {
        return isFinite(this.valueOf()) ?
            this.getUTCFullYear()     + '-' +
            f(this.getUTCMonth() + 1) + '-' +
            f(this.getUTCDate())      + 'T' +
            f(this.getUTCHours())     + ':' +
            f(this.getUTCMinutes())   + ':' +
            f(this.getUTCSeconds())   + 'Z' : null;
        };

     String.prototype.toJSON  =
     Number.prototype.toJSON  =
     Boolean.prototype.toJSON = function (key) { return this.valueOf();};
}
var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
escapable = /[\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
gap='',
indent='',
meta = {    // table of character substitutions
    '\b': '\\b',
    '\t': '\\t',
    '\n': '\\n',
    '\f': '\\f',
    '\r': '\\r',
    '"' : '\\"',
    '\\': '\\\\'
},
rep;
function quote(string) {
    escapable.lastIndex = 0;
    return escapable.test(string) ? '"' + string.replace(escapable, function (a) {
        var c = meta[a];
        return typeof c === 'string' ? c :
            '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
    }) + '"' : '"' + string + '"';
}
//noinspection FunctionWithInconsistentReturnsJS
function str(key, holder) {
var i,          // The loop counter.
    k,          // The member key.
    v,          // The member value.
    length,
    mind = gap,
    partial,
    value = holder[key];

    if (value && typeof value === 'object' &&  typeof value.toJSON === 'function') {
        value = value.toJSON(key);
    }
    switch (typeof value) {
        case 'string':
            return quote(value);
        case 'number':
            return isFinite(value) ? String(value) : 'null';
        case 'boolean':
        case 'null':
            return String(value);
        case 'object':
            if (!value) {
                return 'null';
            }
            gap += indent;
            partial = [];
            if (Object.prototype.toString.apply(value) === '[object Array]') {
                length = value.length;
                for (i = 0; i < length; i += 1) {
                    partial[i] = str(i, value) || 'null';
                }
                v = partial.length === 0 ? '[]' : gap ?
                    '[\n' + gap + partial.join(',\n' + gap) + '\n' + mind + ']' :
                    '[' + partial.join(',') + ']';
                gap = mind;
                return v;
            }

            for (k in value) {
                if (Object.prototype.hasOwnProperty.call(value, k)) {
                    v = str(k, value);
                    if (v) {
                        partial.push(quote(k) + (gap ? ': ' : ':') + v);
                    }
                }
            }
            v = partial.length === 0 ? '{}' : gap ?
                '{\n' + gap + partial.join(',\n' + gap) + '\n' + mind + '}' :
                '{' + partial.join(',') + '}';
            gap = mind;
            return v;
        }
    }
if (typeof JSON.stringify !== 'function') {
    JSON.stringify = function (value) {return str('', {'': value})}
}
}());