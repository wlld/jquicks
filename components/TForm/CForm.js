jq.newClass('CForm','CVidget',{
    construct:function(){
        jq.CForm.superclass.constructor.apply(this,arguments);
        if(this.model){
            jq.registerEventHandler(this.name,'onsubmit',[this,'_send']);
            jq.registerEventHandler(this.model,'onerror',[this,'_error']);
        }
        this.row = -1;
        this.values = {};
    },
    submit:function(){
        var f,i,l,el,n,val;
        f = this.id.getElementsByTagName('FORM')[0];
        var rows = jq.get(this.model).rows;
        for(i=0,l=f.elements.length; i<l;i++ ){
            el = f.elements[i];
            if ((n = el.name)=='') continue;
            if((el.tagName=='SELECT') || (el.tagName=='TEXTAREA')) val = el.value;
            else if (el.tagName=='INPUT')
            switch (el.type){
                case 'radio':{if(!el.checked) continue;}
                case 'file':
                case 'hidden':
                case 'password':
                case 'text':{val = el.value; break;}
                case 'checkbox':{val = el.checked?1:0; break;}
            }
            if((this.row <0)||((rows[this.row][n])!=val)) this.values[n]=val;
        }
        jq.event(this,'onsubmit',{form:this});
        return false;
    },
    _send:function(){
       if(!this.model) return; 
       if(this.row>=0)jq.get(this.model).update(this.values,this.row) 
       else jq.get(this.model).insert(this.values);
    },
    _error:function(e){ alert(e.message); return true;},
    init:function(nrow){
        var f,i,l,el,n;
        f = this.id.getElementsByTagName('FORM')[0];
        var row = jq.get(this.model).rows[nrow];
        for(i=0,l=f.elements.length; i<l;i++ ){
            el = f.elements[i];
            if (((n = el.name)=='') || (typeof row[n]==='undefined')) continue;
            if((el.tagName=='SELECT') || (el.tagName=='TEXTAREA')) el.value = row[n];
            else if (el.tagName=='INPUT')
            switch (el.type){
                case 'radio':{el.checked = (row[n]==el.value); continue;}
                case 'file':
                case 'hidden':
                case 'password':
                case 'text':{el.value = row[n]; break;}
                case 'checkbox':{el.checked = row[n]>0; break;}
            }
        }
        this.row = nrow;
        return false;
    }
});
