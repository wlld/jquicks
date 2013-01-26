jq.newClass('CComponentsList','CDDSource',{
    construct:function(){
        jq.CComponentsList.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler(this.name+".model","onfetch",[this,'_redraw']);
        jq.registerEventHandler("CComponentsTree","onchange",[this,'_onChangeTree']);
        jq.registerEventHandler("CHTMLPreview","onchangepage",[this,'_changePage']);
    },
    dragStop:function(){
        jq.CComponentsList.superclass.dragStop.call(this);
        this.hide();
    },
    show:function(){
        if(this.model.state === jq.STATE_EMPTY) this.model.fetch();
        this.id.style.display = 'block';
    },
    hide:function(){
        this.id.style.display = 'none';
    },
    _redraw:function(){
      this.redraw();
      this.init();
    },
    _onChangeTree:function(){
        this.model.clear();
        this.hide();
    },
    _changePage:function(e){
        this.model.params.page = e.page;
        this.model.clear();
    }
});