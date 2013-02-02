jq.newClass('CLinksEditor','CVidget',{
    construct:function(){
        jq.CLinksEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler(this.speededitor,"onaddrow",[this,'_new']);
        jq.registerEventHandler(this.speededitor,"oneditrow",[this,'_update']);
        this.curent_tr = null;
        this.curent_index = -1;
    },
    loadData:function(){
        var model = this.model;
        var id = this.editor.cmpid;
        if((id<0)||((model.state===jq.STATE_READY)&&(id==model.getParam('component')))) return;
        model.fetch({component:id});
    },
    show:function(){
        this.id.style.display = "block";
        this.loadData();
    },
    edit:function(){
        if(this.curent_index>=0){
            var e = {
                link:this.model.rows[this.curent_index],
                comp_id:this.editor.cmpid,
                comp_class:this.editor.type,
                page:this.editor.page
            };
            jq.get(this.speededitor).show(e);
        }
    },
    check:function(){
        if(this.curent_index<0) return;
        if (this.model.rows[this.curent_index].type) {
            alert('Rating chacking is under construction');
            return;
        }
        var e = {
            link:this.model.rows[this.curent_index],
            project:this.model.getParam('project'),
            cservice:this.editor.cmpname
        };
        jq.get(this.checker).check(e);
    },
    add:function(){
        var e = {
            comp_id:this.editor.cmpid,
            comp_class:this.editor.type,
            page:this.editor.page
        };
        jq.get(this.speededitor).show(e);
    },
    dropCache:function(id){
        if((this.model.state===jq.STATE_READY) && (id==this.model.getParam('component'))) this.model.clear();
    },
    _new:function(r){
        r.project = this.model.getParam('project');
        this.model.insert(r);
    },
    _update:function(r){
        this.model.update(r,this.curent_index);
        if(r.service) this.model.fetch(null,jq.FETCH_IF_UPDATE);
    },
    redraw:function(){
        jq.CLinksEditor.superclass.redraw.call(this);
        this.curent_tr = null;
        this.curent_index = -1;
    },
    remove:function(){
        if(!confirm('Правда удалить???')) return;
        if(this.curent_index>=0){
            this.model.remove(this.model.rows[this.curent_index].idx);
        }
    },
    select:function(tr,index){
        if(this.curent_tr) this.curent_tr.className = '';
        tr.className = 'selected';
        this.curent_tr = tr;
        this.curent_index = index;
    }
//    _onUpdate:function(e){ jq.event(this,'onupdate',{}); }
});