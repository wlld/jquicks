jq.newClass('CModelPageControl','CVidget',{
    construct:function(){
        jq.CModelPageControl.superclass.constructor.apply(this,arguments);
        if (this.model) jq.registerEventHandler(this.model,'onfetch',[this,'redraw'])
    },
    select:function(n){
        var m =jq.get(this.model);
        if ((m.state == jq.STATE_READY) || (m.state == jq.STATE_EMPTY)){
            m.first = (n-1)*m.limit;
            m.fetch();
        }
    }
});