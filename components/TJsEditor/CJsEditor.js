jq.newClass('CJsEditor','CVidget',{
    construct:function(){
        jq.CJsEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler(this.name+".jsmodel","onfetch",[this,'redraw']);
        jq.registerEventHandler(this.name+".jsmodel","onupdate",[this,'_onUpdate']);
        jq.registerEventHandler("CHTMLPreview","onchangepage",[this,'_changePage']);
        this._loaded = false;
    },
    show:function(){
        if (this.jsmodel.state == jq.STATE_EMPTY)  this.jsmodel.fetch();
        this.id.style.display = "block";
    },
    onload:function (){
    	jq.CJsEditor.superclass.onload.call(this);
        if(window.ace){
            try{
              this.editor = ace.edit("js_content");
              this.editor.getSession().setMode("ace/mode/javascript");
            } catch(e){};
        }
    },
    save:function(){
        var text = this.editor.getValue();
        this.jsmodel.update({
            js:text
        },[0],true);
    },
    _onUpdate:function(e){jq.event(this,'onupdate',{})},
    _changePage:function(e){
        this.jsmodel.params.page=e.page;
        if((e.page == '')||(this.id.offsetHeight+this.id.offsetHeight ==0)) this.jsmodel.clear();
        else this.jsmodel.fetch();
    },
    redraw:function(){
        this.editor.setValue(this.jsmodel.rows[0].js);
        this.editor.clearSelection();
    }
});