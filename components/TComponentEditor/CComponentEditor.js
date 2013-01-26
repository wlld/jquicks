jq.newClass('CComponentEditor','CContainer',{
    construct:function(){
        jq.CComponentEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler("CComponentsTree","onselectcomponent",[this,'select']);
        jq.registerEventHandler('CComponentsTree',"ondeletecomponent",[this,'_dropCache']);
        jq.registerEventHandler("CHTMLPreview","onchangepage",[this,'changePage']);
        this.editors = [];
        this.cmpid = -1;
    },
    onload:function (){
        var esect,psect,divs,i,l,div,n,cmp;
    	jq.CComponentEditor.superclass.onload.call(this);
        esect = document.getElementById(this.name+'_0');
        psect = document.getElementById(this.name+'_1');
        divs = psect.childNodes;
        for(i=0,l=divs.length; i<l; i++){
            div = divs[i];
            if(div.tagName=='DIV') this.pager = jq.get(div.id);
        }
        divs = esect.childNodes;
        for(i=0,l=divs.length; i<l; i++){
            div = divs[i];
            if(div.tagName=='DIV') {
                n = div.id;
                cmp = jq.get(n);
                this.editors.push({
                    name:n,
                    cmp:cmp,
                    groups:this.groups[n]?this.groups[n]:'',
                    active:false
                });
                cmp.editor = this;
            }
        }
        this.pager.value = 'prpeditor';
        return false;
    },
    isVisible:function(name) {return this.editors[name].cmp.id.offsetHeight != 0},
    select:function(e){
        var i,l,ed,a;
        this.cmpid = e.cmpid;
        this.cmpname = e.cmpname;
        this.type = e.type;
        var v= this.pager.value;
        var s = false;
        for(i=0,l=this.editors.length; i<l; i++){
            ed = this.editors[i];
            a = (ed.groups.indexOf(e.group)>=0)&&(this.cmpid>=0);
            if(ed.active != a){
                ed.active = a;
                this.pager.setActive(ed.name,a);
            }
            if(a && (v==ed.name)) {this.pager.select(ed.name); s = true} 
        }
        if((this.cmpid>=0)&&!s) this.pager.select('prpeditor');
    },
    changePage:function(e){
        if(e.page){
            if(this.id.offsetHeight == 0) this.id.style.display = 'block';
            this.page = e.page; 
        }
        else if(this.id.offsetHeight != 0) this.id.style.display = 'none';
    },    
    _dropCache:function(e){
        for(var i=0,l=this.editors.length; i<l; i++){
            var ed = this.editors[i].cmp;
            if(typeof ed.dropCache === 'function') ed.dropCache(e.id);
        }    
    }
});