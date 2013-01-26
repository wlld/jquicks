jq.newClass('CPHPEditor','CVidget',{
    construct:function(){
        jq.CPHPEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler(this.name+".phpmodel","onfetch",[this,'redraw']);
        jq.registerEventHandler("CHTMLPreview","onchangepage",[this,'_changePage']);
        this._loaded = false;
    },
    show:function(){
        if (this.phpmodel.state == jq.STATE_EMPTY)  this.phpmodel.fetch();
        this.id.style.display = "block";
    },
    save:function(){
        var text = this.id.getElementsByTagName('textarea')[0].value;
        this.phpmodel.update({php:text},[0],true);
    },
    _changePage:function(e){
        this.phpmodel.params.page=e.page;
        if((e.page == '')||(this.id.offsetHeight+this.id.offsetHeight ==0)) this.phpmodel.clear();
        else this.phpmodel.fetch();
    }
});