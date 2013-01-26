jq.newClass('CTplEditor','CVidget',{
    construct:function(){
        jq.CTplEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler(this.name+".tplmodel","onfetch",[this,'redraw']);
        jq.registerEventHandler(this.name+".tplmodel","onupdate",[this,'_onUpdate']);
    },
    save:function(){
        var _tpl = this.id.getElementsByTagName('textarea')[0].value;
        this.tplmodel.update({tpl:_tpl});
    },
    loadData:function(){
        var model = this.tplmodel;
        var id = this.editor.cmpid;
        var page = this.editor.page;
        if((id<0)||((model.state===jq.STATE_READY)&&(id==model.getParam('component')))) return;
        model.fetch({component:id,page:page});
    },
    show:function(){
        this.id.style.display = "block";
        this.loadData();
    },
    _onUpdate:function(){
        jq.event(this,'onupdate',{});
    },
    dropCache:function(id){
        if((this.tplmodel.state===jq.STATE_READY) && (id==this.tplmodel.getParam('component'))) this.tplmodel.clear();
    }
});