jq.newClass('CCoreRightsEditor','CVidget',{
    construct:function(){
        jq.CCoreRightsEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler(this.name+'.mrights','onfetch',[this,'redraw']);
        jq.registerEventHandler(this.name+'.mrights','onupdate',[this,'redraw']);
        this.filters = {'model':'','group':'','fetch-group':'','fetch-owner':'','update-group':'','update-owner':'','remove-group':'','remove-owner':'','insert-group':''};
    },
/*    load:function(n){
        this.curent = n;
        var model = 'ms_'+n;
        if(!this[model]) throw new Error(this.name+'::load(): Service with index '+n+'does not exist');
        this.mmodels.fetch({service:this.srv[n].c});
        this.mfields.fetch({service:this.srv[n].c});
        this.filters = {'model':'','group':'','fetch-group':'','fetch-owner':'','update-group':'','update-owner':'','remove-group':'','remove-owner':'','insert-group':''};
        this[model].fetch();
    },
*/
/*    add:function(){
        var model = 'ms_'+this.curent;
        this._show_editor();
    },
*/    
    remove:function(row){
        var m = this.mrights;
        var r = m.rows[row];
        if(confirm('Точно удалить строку для model="'+r.model+'", group='+r.group+'?')) m.remove(r.idx);
    },
    save:function (){
        var values = this.getValues();
        if(this.edit_idx<0) {
            values.service = this.mrights.params.service;
            this.mrights.insert(values)
        }
        else {
            var uf = {}, u=false, row = this.mrights.rows[this.edit_idx];
            for (var name in values) if(values.hasOwnProperty(name)) {
                if(row[name]!=values[name]) {uf[name] = values[name]; u=true};
            } 
            if(u) this.mrights.update(uf,this.edit_idx);
        }
        this.hide_editor();
    },
    getValues:function(){
        var e = document.getElementById(this.name+'_editor');
        var s = e.getElementsByTagName('select'); 
        var i = e.getElementsByTagName('input'); 
        var r = {
            'model':s[0].value,
            'group':s[1].value,
            'fetch-group':i[0].value,
            'fetch-owner':i[1].value,
            'update-group':i[2].value,
            'update-owner':i[3].value,
            'remove-group':(i[4].checked)?1:0,
            'remove-owner':(i[5].checked)?1:0,
            'insert-group':(i[6].checked)?1:0
        } 
        return r;
    },
    filter:function(){
        var f,i,l,is = document.getElementById(this.name+'_filter').getElementsByTagName('input');
        for(i=0,l=is.length; i<l; i++) this.filters[is[i].getAttribute('field')] = is[i].value.replace(/^\s+|\s+$/g, '');
        var rows = this.mrights.rows;
        for(i=0,l=rows.length; i<l; i++){
          var row = rows[i];
          f = ((this.filters['model']!='') && (row['model'].indexOf(this.filters['model'])<0))||
              ((this.filters['group']!='') && (row['group']!=this.filters['group']))||
              ((this.filters['fetch-group']!='') && (row['fetch-group'].indexOf(this.filters['fetch-group'])<0))||
              ((this.filters['fetch-owner']!='') && (row['fetch-owner'].indexOf(this.filters['fetch-owner'])<0))||
              ((this.filters['update-group']!='') && (row['update-group'].indexOf(this.filters['update-group'])<0))||
              ((this.filters['update-owner']!='') && (row['update-owner'].indexOf(this.filters['update-owner'])<0))||
              ((this.filters['remove-group']!='') && (row['remove-group']!=this.filters['remove-group']))||
              ((this.filters['remove-owner']!='') && (row['remove-owner']!=this.filters['remove-owner']))||
              ((this.filters['insert-group']!='') && (row['insert-group']!=this.filters['insert-group']));
          row.filter = f;
        }
        this.redraw();
    },
    show_editor:function(idx){
        var bg = document.getElementById(this.name+'_bg');
        bg.style.display = 'block';
        var e = document.getElementById(this.name+'_editor');
        var h = e.getElementsByTagName('header')[0];
        var span = h.getElementsByTagName('span')[0];
        var s = e.getElementsByTagName('select'); 
        var i = e.getElementsByTagName('input'); 
        if(typeof idx == 'undefined'){
            span.innerHTML = 'Новая запись';
            s[0].disabled = false;
            s[1].disabled = false;
            s[0].selectedIndex = 0;
            s[1].selectedIndex = 0;
            i[0].value ='';
            i[1].value = '';
            i[2].value = '';
            i[3].value = '';
            i[4].checked = 0;
            i[5].checked =0;
            i[6].checked = 0;
            this.edit_idx = -1;
        }
        else{
            span.innerHTML = 'Редактирование строки';
            var row = this.mrights.rows[idx];
            s[0].value = row.model;
            s[1].value = row.group;
            s[0].disabled = true;
            s[1].disabled = true;
            i[0].value = row['fetch-group'];
            i[1].value = row['fetch-owner'];
            i[2].value = row['update-group'];
            i[3].value = row['update-owner'];
            i[4].checked = row['remove-group'];
            i[5].checked = row['remove-owner'];
            i[6].checked = row['insert-group'];
            this.edit_idx = idx;
        }
        this.active_model = s[0].value;
        e.style.display = "block";
        document.getElementById(this.name+'_fields').innerHTML = '';
    },
    changeModel:function (m){
        this.active_model = m;
        document.getElementById(this.name+'_fields').innerHTML = '';
    },
    drawFields:function(field,mode){
        this.active_field = field;
        var mf = this.mfields.rows;
        if(typeof(mf)==undefined) return;
        var t = '';
        for(var i=0,l=mf.length; i<l; i++){
            var f = mf[i];
            if((f.model==this.active_model)&&(f[mode]==1)) t += '<tr><td><a onclick="jq.get(\''+this.name+'\').addField(this.innerHTML)">'+f.name+'</a></td><td>'+f.desc+'</td></tr>'
        }
        if(t!=="")  t='<table>'+t+'</table>';
        document.getElementById(this.name+'_fields').innerHTML = t;
    },
    addField:function(text){
        this.active_field.value += (this.active_field.value=='')? text:','+text; 
        this.active_field.focus();
        return true;
    },
    hide_editor:function(){
        var bg = document.getElementById(this.name+'_bg');
        bg.style.display = 'none';
        var eid = this.name+'_editor';
        var e = document.getElementById(eid);
        e.style.display = "none";
    }
});