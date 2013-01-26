jq.newClass('CLinksCheckingDialog','CVidget',{
    construct:function(){
        jq.CLinksCheckingDialog.superclass.constructor.apply(this,arguments);
        this.link = null;
        this.state=0; //0-проверка 1-исправление 2-готово
        this.result=0;
    },
    cancel:function(){
        document.getElementById('shield').className = '';
        this.id.style.display = 'none';
    },
    check:function(e){
        document.getElementById('shield').className = 'active_shield';
        this.state=0;
        this.redraw();
        this.id.style.display = 'block';
        var args = {
            project:e.project,
            cservice:e.cservice,
            child:e.link.child,
            lfield:e.link.lfield, 
            service:e.link.service_name,
            parent:e.link.parent 
        }
        this.link = args;
        jq.get('TActionServer').registerCommand('TServiceController','testRefIntegrity',args,[this,'_testComplete']);
    },    
    _testComplete:function(e){
        this.state=2;
        if(e.status==0) this.result = e.unlinked_rows;
        this.redraw();  
    },
    repair:function(){
        var mode = this.id.getElementsByTagName('FORM')[0].mode[0].checked?'DELETE':'NULL';
        this.link.mode = mode;
        this.state=1;
        this.redraw();  
        jq.get('TActionServer').registerCommand('TServiceController','makeRefIntegrity',this.link,[this,'_repairComplete']);
    },
    _repairComplete:function(e){
        this.state=2;
        if(e.status==0) this.result = 0;
        this.redraw();  
    }
});