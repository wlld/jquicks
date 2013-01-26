jq.newClass('CLinkSpeedEditor','CVidget',{
    construct:function(){
        jq.CLinkSpeedEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler(this.name+".mservice","onfetch",[this,'_onLoadServices']);
        jq.registerEventHandler(this.name+".mchild","onfetch",[this,'_onLoadChilds']);
        jq.registerEventHandler(this.name+".mlfield","onfetch",[this,'_onLoadLFields']);
        jq.registerEventHandler(this.name+".mparent","onfetch",[this,'_onLoadParent']);
        this.comp_class = ''; //Имя класса текущего компонента
        this.comp_id = -1; //Идентификатор текущего компонента
        this.child = ''; //Имя дочерней модели
        this.lfield = ''; //Имя ссылочного поля
        this.rfield = '';
        this.service = -1; //Идентификатор родительского сервиса
        this.parent = ''; //Имя родительской модели
        this.page = ''; //Имя страницы
        this.link = null;
    },
    onload:function(){
    	jq.CLinkSpeedEditor.superclass.onload.call(this);
        this.form = this.id.getElementsByTagName('FORM')[0];
        var fs = this.form.getElementsByTagName('FIELDSET');
        this.link_fieldset = fs[0];
        this.rtng_fieldset = fs[1];
        this.setType();
        this.loader = document.getElementById(this.name+'_loader');
    },    
    setType:function(){
        if(this.form.type[0].checked) {
            this.link_fieldset.style.display = 'block';
            this.rtng_fieldset.style.display = 'none';
        }
        else{
            this.link_fieldset.style.display = 'none';
            this.rtng_fieldset.style.display = 'block';
        }
    },
    save:function(){
       var radios,i,l,e;
       var f = this.form;
       //TODO: Add values checking
       e = {
           type:f.type[1].checked?1:0,	
           child:f.child.value,	
           service:f.service.value,	
           parent:f.parent.value,	
           lfield:f.lfield.value	
       };
       if(e.type){
           e.op = f.op.value;
           e.rfield = f.rfield.value;
           e.tfield = f.tfield.value;
       }
       else{
            radios = this.form.ondelete;
            for(i=0,l=radios.length;i<l;i++) if(radios[i].checked){e.op=radios[i].value;break;}
            e.rfield = e.tfield = '';
       }
       if(this.link) {
           for(var p in e) if (e.hasOwnProperty(p)) {
               if(e[p]==this.link[p]) delete e[p];
           }
           if (Object.keys(e).length>0) jq.event(this,'oneditrow',e);
       }
       else {
           e.component = this.comp_id;	
           jq.event(this,'onaddrow',e);
       }
       this.id.style.display = 'none';
       document.getElementById('shield').className = '';
    },
    cancel:function(){
        this.id.style.display = 'none';
        document.getElementById('shield').className = '';
    },
    show:function(e){
        var i,l;
        document.getElementById('shield').className = 'active_shield';
        this.id.style.display = 'block';
        this.comp_class = e.comp_class;
        this.comp_id = e.comp_id;
        this.page = e.page;
        var f = this.form;
        var radios = this.form.ondelete;
        if(e.link){
            var link = this.link = e.link;
            f.child.value = this.child = link.child;
            f.lfield.value = this.lfield = link.lfield;
            f.service.value = this.service = link.service;
            f.parent.value = this.parent = link.parent;
            this.rfield = link.rfield;
            if(link.type){
                f.type[0].checked = false;
                f.type[1].checked = true;
                f.op.value = link.op;
                f.tfield.value = link.tfield; 
            }
            else{
                f.type[0].checked = true;
                f.type[1].checked = false;
                for(i=0,l=radios.length;i<l;i++) radios[i].checked = (radios[i].value==link.op);
            } 
            f.type[0].disabled = f.type[1].disabled = true;
        }
        else{
            this.link = null;
            f.child.value = this.child = '';
            f.lfield.value = this.lfield = '';
            f.service.value = this.service = -1;
            f.parent.value = this.parent = '';
            f.op.value = '';
            for(i=0,l=radios.length;i<l;i++) radios[i].checked = (i==3);
            f.type[0].disabled = f.type[1].disabled = false;
        }
        this.setType();
        this._disableFields();
        this.mchild.fetch({service:e.comp_class});
    },
    _disableFields:function(){
        this.loader.style.display = 'inline-block';
        var f = this.form;
        f.child.disabled = true;
        f.lfield.disabled = true;
        f.service.disabled = true;
        f.parent.disabled = true;
    },
    _enableFields:function(lvl){
        var f = this.form;
        switch(lvl){
            case 0: f.parent.disabled = f.parent.options.length<=1;
            case 1: f.service.disabled = f.service.options.length<=1;
            case 2: if (!this.link ) f.lfield.disabled = f.lfield.options.length<=1;
            case 3: if (!this.link ) f.child.disabled = f.child.options.length<=1;
        }
        this.loader.style.display = 'none';
    },
//=============================================================    
    _onLoadChilds:function(){
        var rows = this.mchild.rows,def,l;
        l = rows.length;
        if (l==0) {this._enableFields(4); return;}
        def = (l==1)? (this.child=rows[0].name):this.child;
        this._setSelectsList('child',rows,def);
        if(def) this._fetchLField();
        else this._enableFields(3);
    },
    _onLoadLFields:function(){
        var rows = this.mlfield.rows,def,l,i;
        l = rows.length;
        if (l==0) {this._enableFields(3); return;}
        this.links = [];
        for(i=0;i<l;i++) if(rows[i].link) this.links.push(rows[i]);
        l = this.links.length;
        def = (l==1)? (this.lfield=this.links[0].name):this.lfield;
        this._setSelectsList('lfield',this.links,def);
        this._setSelectsList('rfield',rows,this.rfield);
        this.form.rfield.disabled = false;
        if(def) this._fetchService();
        else this._enableFields(2);
    },
    _onLoadServices:function(e){
        var rows = this.mservice.rows,l,def;
        l = rows.length;
        if (l==0) {this._enableFields(2); return;};
        def = (l==1)? (this.service=rows[0].id):this.service;
        this._setSelectsList('service',rows,def,true);
        if(def) this._fetchParent();
        else this._enableFields(1);
    },
    _onLoadParent:function(e){
        var rows = this.mparent.rows,l,def;
        l = rows.length;
        if (l==0) {this._enableFields(1); return;}
        def = (l==1)? (this.parent=rows[0].name):this.parent;
        this._setSelectsList('parent',rows,def);
        this._enableFields(0);
    },
//=============================================================    
    _fetchLField:function(){
        var v = this.form.child.value;
        if(!v) return;
        this._disableFields();
        this.form.rfield.disabled = true;
        this.mlfield.fetch({service:this.comp_class,model:v});
    },
    _fetchService:function(){
        var n = this.form.lfield.selectedIndex;
        if(n<0) return;
        var link = this.links[n].link;
        var srv_class = link[0]? link[0]:'TDBService';
        this.parent_restrict = link[1];
        this._disableFields();
        this.mservice.fetch({page:this.page,type:srv_class});
    },
    _fetchParent:function(){
        if(this.parent_restrict){
            this._setSelectsList('parent',[{name:this.parent_restrict}],this.parent_restrict);
            this._enableFields(0);
            return;
        }
        else{
            var n = this.form.service.selectedIndex;
            if(n<0) return;
            var type = this.mservice.rows[n].type;
            this._disableFields();
            this.mparent.fetch({service:type});
        }
    },
//=============================================================        
    onSelectChild:function(){
       this.form.lfield.value = this.lfield='';
       this.form.service.value = this.service='';
       this.form.parent.value = this.parent='';
       this._fetchLField();
    },
    onSelectLField:function(){
       this.form.service.value = this.service='';
       this.form.parent.value = this.parent='';
       this._fetchService();
    },
    onSelectService:function(){
       this.parent='';
       this._fetchParent();
    },
//=============================================================        
    _setSelectsList:function(name,rows,def,id){
        var opt = "", ctrl = this.form[name];
        for(var i=0,l=rows.length;i<l;i++){
            var val = id? rows[i].id:rows[i].name;
            opt+= '<option value="'+val+'">'+rows[i].name+'</option>';
        }
        ctrl.innerHTML = opt;
        ctrl.value = def;
    },
    checkLinks:function(){
        var form = this.id.getElementsByTagName('form')[0];
        var arg = {
            to_service: form.services.value,
            to_model: form.models.value,
            project: this.smodel.params.project,
            property: this.prp_name,
            service: this.cmp_id
        }
        jq.get('TActionServer').registerCommand('TServiceController','testRefIntegrity',arg,[this,'_onCheckLinks']);
    },
    _onCheckLinks:function(data){
      if (data.status==0) jq.event(this,'onlinksdataload',{project:this.smodel.params.project, tables:data.tables});  
      else jq.event(this,'onerror',data.errortext);  
    }
});