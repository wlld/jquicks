jq.newClass('CComponentsTree','CVidget',{
/*===Реагирует на события:===
	onbeginbragcomponent - переходит в режим вставки компонента
	onenddragcomponent - определяет место вставки и генерирует событие onaddcomponent
===Генерирует события:===
	onaddcomponent - вставка нового компонента
	onselectcomponent - выбор компонента в дереве
    onchange - при изменениях в составе дерева
*/
    construct:function(){
        jq.CComponentsTree.superclass.constructor.apply(this,arguments);
        this.curent_idx = -1;	//индекс текущего выбранного элемента
        this.curent_name = '';
        this._restore = false;
        this._reload_frame = false;
       	this.cmps = []; 		//Массив компонентов, обслуживаемых деревом
       	this.p_idx = 0;			//Индекс текущего места вставки
       	var this_obj = this;
       	this.onmousemove = function (e){
            e = e || window.event;
            var y = (e.clientY-this_obj.tree.offsetTop)+this_obj.tree.scrollTop;
            var idx = this_obj.findItem.call(this_obj,y);
            if (idx != this_obj.p_idx){
                    this_obj.p_idx = idx;
                    this_obj.hr.style.top = this_obj.cmps[idx].y+"px";
            }
       	};
       	jq.registerEventHandler("CPalettePage","onbegindrag",[this,'_onBeginDrag']);
       	jq.registerEventHandler("CPalettePage","onenddrag",[this,'_onEndDrag']);
        jq.registerEventHandler("CComponentsList","onbegindrag",[this,'_onBeginDrag']);
       	jq.registerEventHandler("CComponentsList","onenddrag",[this,'_onEndDrag']);
        jq.registerEventHandler("CPrpEditor","onchangename",[this,'_changeName']);
        jq.registerEventHandler("CPrpEditor","beforechangesections",[this,'_beforechangesect']);
        jq.registerEventHandler("CHTMLPreview","onchangepage",[this,'_onChangePage']);
        jq.registerEventHandler(this.name+".treemodel","onfetch",[this,'_redraw']);
    },
    onload:function (){
    	jq.CComponentsTree.superclass.onload.call(this);
    	this._parseTree();
        return false;
    },
    _onChangePage:function(e){
        this._reload_frame = false;
        if(e.page != ''){
            this.treemodel.params.page = e.page;
            this.treemodel.fetch();
        }
        else  this.treemodel.clear();
    },
    _beforechangesect:function(){
        this._restore = true;
        this._reload_frame = true;
        this.treemodel.fetch(null,jq.FETCH_IF_UPDATE);
    },
    _onBeginDrag:function (msg){
    	if (msg.sender != this) this.setMode(1);
    },
    _onEndDrag:function (msg){
 	this.setMode(0);
        if (this.active) {
            this.active=false;
    		var m = this.cmps[this.p_idx-1].row;
            var md = this.treemodel;
            var arg = {
                project:md.params.project,
                page:md.params.page,
                parent:m.p,
                section:m.s,
                order:!('o' in m)?0:(m.o+1)
            };
            if(msg.object.tagName == 'IMG') arg.type = msg.object.getAttribute("alt");
            else if (msg.object.tagName == 'P') arg.name = msg.object.innerHTML;
            else return;
            jq.get('TActionServer').registerCommand(this.service,'addComponent',arg,[this,'_onCommandDone']);
            this._reload_frame = true;
            md.fetch(null,jq.FETCH_IF_UPDATE);
            this._restore = true;
            jq.event(this,"onaddcomponent",{section:m.s});
    	}
    },
    select:function (item){
    	if (this.curent_idx >= 0) this.cmps[this.curent_idx].p.className ="";
        item.className ="selected";
       	this.curent_idx = item.value;
        var m = this.cmps[item.value].row;
        this.curent_name = m.n;
       	jq.event(this,"onselectcomponent",{'cmpname':this.curent_name,'cmpid':m.id,'sect':m.s,'group':m.g,'type':m.t});
    },
    _restoreSelection:function(){
        if(this.curent_name){
            for(var i=0,l=this.cmps.length; i<l; i++){
                var m = this.cmps[i];
                if(m.row && m.row.n && (m.row.n == this.curent_name)){
                    m.p.className ="selected";
                    this.curent_idx = i;
                    break;
                }
            }
        }
        this._restore = false;
    },
    findItem:function (y){
    	var m=this.cmps.length-1;
    	for(var i=2; i<m; i++) if (this.cmps[i].y1>y) break;
    	return i
    },
    setMode:function (m){
    	if (m==0) {
    		this.hr.style.display = "none";
    		this.id.onmouseover = null;
    		this.id.onmouseout = null;
    		this.id.onmousemove = null;
    		this.mode = 0;
            this._shield.style.display = 'none';
    	}
    	else if (m==1){
    		this.id.onmouseover = function(){this.cmp.hr.style.display = "block";this.cmp.active=true;};
    		this.id.onmouseout = function(){this.cmp.hr.style.display = "none";this.cmp.active=false;};
    		this.id.onmousemove = this.onmousemove;
    		this.offsetTop = this.id.offsetTop;
    		this.scrollTop = this.id.scrollTop;
    		this.mode = 1;
            this._shield.style.display = 'block';
    	}
    },
    _parseTree:function (){
        this.cmps = [];
    	var i,idx = 0,obj;
    	var pp = this.id.getElementsByTagName('p');
        var mr = this.treemodel.rows[0].tree;
        for(i=0;i<pp.length;i++){
            var p = pp[i];
            var id = p.id;
            if (id){
                var row = parseInt(id.split('.')[1]);
    		    p.value = idx++;
                var py = p.offsetTop, ph = p.offsetHeight;
                obj = {'y' : py, 'y1': py+ph/2, 'p' : p, row:mr[row]};
    		    this.cmps.push(obj);
            }
        }
        py = this.cmps[i-1].y+ph;
        obj = {'y' : py, 'y1': py+ph/2};
        this.cmps.push(obj);
        this.hr = this.id.getElementsByTagName("hr")[0];
        this.tree = document.getElementById('tree');
        this._shield = document.getElementById(this.name+'.shield');
    },
    _changeName:function(msg){
        for(var i = 0,l=this.cmps.length; i<l;i++){
            var mr = this.cmps[i].row;
            if (mr && mr.id && (mr.id == msg.id)){
                this.curent_name = mr.n = msg.name;
                this.cmps[i].p.innerHTML = msg.name;
                return;
            }
        }
    },
    _redraw:function(){
        this.redraw();
        if(this.treemodel.state==jq.STATE_READY){
            this._parseTree();
            if(this._restore) this._restoreSelection();
            else{
                this.curent_name = '';
                this.curent_idx = -1;
                jq.event(this,"onselectcomponent",{'cmpname':'','cmpid':-1});
            }
        }
        if(this._reload_frame)jq.event(this,'onchange')
        else jq.event(this,"onchangepage",{page:this.treemodel.params.page});

    },
    deleteCmp:function(){
        var m = this.cmps[this.curent_idx].row;
        if ((m.i > 1 && m.i < 5) || this.curent_idx == 0) {alert('Can not delete this item.'); return;}
        var md = this.treemodel;
        var arg = {
            project:md.params.project,
            page:md.params.page,
            component:m.id,
            parent:m.p,
            section:m.s,
            order:m.o
        };
        jq.get('TActionServer').registerCommand(this.service,'deleteComponent',arg);//,[this,'_onCommandDone']);
        this._reload_frame = true;
        md.fetch(null,jq.FETCH_IF_UPDATE);
        jq.event(this,"ondeletecomponent",{section:m.s,id:m.id});
    },
    _onCommandDone:function(data){
  //      if(data.status>0) jq.event(this,'onerror',{message:data.errortext})
    }
});