jq.newClass('CCSSEditor','CVidget',{
    construct:function(){
        jq.CCSSEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler(this.name+".cssmodel","onfetch",[this,'redraw']);
        jq.registerEventHandler(this.name+".cssmodel","onupdate",[this,'_onUpdate']);
        jq.registerEventHandler("CPrpEditor","onchangename",[this.cssmodel,'clear']);
    },
    save:function(){
        var _css = this.id.getElementsByTagName('textarea')[0].value;
        this.cssmodel.update({css:_css});
    },
    show:function(){
        this.id.style.display = "block";
        this.loadData();
    },
    loadData:function(){
        var model = this.cssmodel;
        var id = this.editor.cmpid;
        var page = this.editor.page;
        if((id<0)||((model.state===jq.STATE_READY)&&(id==model.getParam('component')))) return;
        model.fetch({component:id,page:page});
    },
    _onUpdate:function(){ jq.event(this,'onupdate',{}); },
    dropCache:function(id){
        if((this.cssmodel.state===jq.STATE_READY) && (id==this.cssmodel.getParam('component'))) this.cssmodel.clear();
    }
});