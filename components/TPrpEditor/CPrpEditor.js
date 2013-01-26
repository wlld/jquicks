jq.newClass('CPrpEditor','CVidget',{
    construct:function(){
        jq.CPrpEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler("CComponentsTree","onaddcomponent",[this,'loadData']);
        jq.registerEventHandler(this.name+".prpmodel","onupdate",[this,'_onUpdate']);
        jq.registerEventHandler(this.name+".prpmodel","onfetch",[this,'redraw']);
        this.cval = [];
        this.editor = null;
        this.editor_prp = '';
    },
    loadData:function(){
        var model = this.prpmodel;
        var id = this.editor.cmpid;
        var page = this.editor.page;
        if((id<0)||((model.state===jq.STATE_READY)&&(id==model.getParam('component')))) return;
        model.fetch({component:id,page:page});
    },
    show:function(){
        this.id.style.display = "block";
        this.loadData();
    },
    prpchange:function(row,obj){
        var v;
        if (obj.tagName=='INPUT'){
            if (obj.type=='checkbox') v=obj.checked? 1:0;
            else v=obj.value;
        } else v = obj.value;
        //var type = this.prpmodel.rows[row]['t'];
        //TODO: Добавить проверку типов данных
        this.cval[row] = {val:v,obj:obj};
        obj.className = 'changed';
    },
    save:function(){
        var i,l,v = this.cval;
        for (i=0,l=v.length;i<l; i++) {
            if (v[i]) {
                var row = this.prpmodel.rows[i];
                if(row.n=='name') this.old_name = row.v;
                this.prpmodel.update({v:v[i].val}, i);
                if(row.n == 'sections')   jq.event(this,'beforechangesections');
            }
        }
    },
    _onUpdate:function(msg){
        var v = this.cval;
        v[msg.row].obj.className = '';
        v[msg.row] = null;
        var rows = this.prpmodel.rows;
        var m = rows[msg.row];
        if (m.n == 'name') {
            jq.event(this,'onchangename',{id:this.editor.cmpid,name:m.v});
            for(var i=0,l=rows.length;i<l;i++) if(rows[i]['t']=='link'){
                var link = rows[i]['v'].split('.');
                if(link[0]==this.old_name) {
                    var nl = m.v+'.'+link[1];
                    var form = this.id.getElementsByTagName('form')[0];
                    form[rows[i].n].value = nl;
                    rows[i]['v'] = nl;
                }
            }
        }
        jq.event(this,'onupdate',{});
    },
    showEditor:function(prp,n){
        var form = this.id.getElementsByTagName('form')[0];
        this.editor_prp = form[prp];
        this.editor_row = n;
        var type = this.prpmodel.rows[n]['t'];
        var e = {control:form[prp],row:this.prpmodel.rows[n],component:this.cmpid};
        if (type=='object') jq.event(this,'oneditobjectproperty',e);
        else if (type=='text') jq.event(this,'onedittextproperty',e);
        else throw new Error('There is no editor for "'+type+'" type/');
    },
    hideEditor:function(){
        var ta = document.getElementById(this.name+'-textarea');
        this.editor.style.display='none';
        if(this.editor_prp.value != ta.value){
            this.editor_prp.value = ta.value;
            this.prpchange(this.editor_row,this.editor_prp);
        }
    },
   dropCache:function(id){
        if((this.prpmodel.state===jq.STATE_READY) && (id==this.prpmodel.getParam('component'))) this.prpmodel.clear();
    }
});
