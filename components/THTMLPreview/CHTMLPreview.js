jq.newClass('CHTMLPreview','CVidget',{
    construct:function(){
        jq.CHTMLPreview.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler('CPrpEditor','onupdate',[this,'_checkReload']);
        jq.registerEventHandler('CTplEditor','onupdate',[this,'_checkReload']);
        jq.registerEventHandler('CJsEditor','onupdate',[this,'_checkReload']);
        jq.registerEventHandler('CCSSEditor','onupdate',[this,'_checkReload']);
        jq.registerEventHandler('CPalettePage','onbegindrag',[this,'_shieldOn']);
        jq.registerEventHandler('CPalettePage','onenddrag',[this,'_shieldOff']);
        jq.registerEventHandler('CComponentsTree','onchange',[this,'_checkReload']);
        jq.registerEventHandler('CComponentsTree','onselectcomponent',[this,'_onselect']);
        this.curent = '';
        this.project = '';
        this.page = '';
        var _this = this;
        _this.timer = null;
        _this._reload = function(){
            //var frame = _this.id.getElementsByTagName('iframe')[0];
            //frame.src = frame.src;
            _this.window.location.reload(true);
            _this.timer = null;
        };
        _this._onerror = function(msg,file,line){
            jq.event(_this,'onerror',{msg:msg,file:file,line:line});
        };
        _this._onFrameLoad=function() {if(_this.frame) _this._frameLoad();}
    },
    _frameLoad:function(){
        this.frame.contentWindow.onerror = this._onerror;
        var p = /[\\/]projects[\\/](\w+)[\\/](\w+)\.php.*/.exec(this.window.location.pathname);
        if((window.location.hostname == this.window.location.hostname)&& p && (p[1]==this.project)){
            if (p[2]==this.page) jq.event(this,'onrefresh',{});
            else jq.event(this,'onchangepage',{page:(this.page = p[2])});
        }
        else{
            this.page = '';
            jq.event(this,'onchangepage',{page:''});
        }
    },
    onload:function (){
    	jq.CHTMLPreview.superclass.onload.call(this);
        this.frame = this.id.getElementsByTagName('iframe')[0];
        this.window = this.frame.contentWindow;
        var p = /[\\/]projects[\\/](\w+)[\\/](\w+)\.php.*/.exec(this.window.location.pathname);
        if(p){
            this.project = p[1];
            this.page = p[2];
        }
        this.window.onerror = this._onerror;
        if(this.window.jq){
            this.window.jq.registerEventHandler('CActionServer','onerror',[this,'_onAjaxError']);
            this.window.jq.registerEventHandler('CModel','onerror',[this,'_onAjaxError']);
        }
        this.frame.onload = this._onFrameLoad;
    },
    _checkReload:function(){
        if (this.timer === null) this.timer = setTimeout(this._reload,5);
    },
    _shieldOn:function(){
        var shield = document.getElementById(this.name+'.shield');
        shield.style.display = 'block';
    },
    _shieldOff:function(){
        var shield = document.getElementById(this.name+'.shield');
        shield.style.display = 'none';
    },
    _onAjaxError:function(e){
        jq.event(this,'onerror',e);
    },
    _onselect:function(e){
        var c = this.window.document.getElementById(this.curent);
        if(c !== null)  c.style.outline = "";
        if(e.sect>=0){
            this.curent=e.cmpname;
            var cmp = this.window.document.getElementById(this.curent);
            if(cmp) cmp.style.outline = "2px solid yellow";
        }
        else this.curent = '';
    }
});