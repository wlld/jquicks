jq.newClass('CDDSource','CVidget',{
    construct:function(){
        jq.CDDSource.superclass.constructor.apply(this,arguments);
        var this_obj = this;
       	this.is_drag = false;
       	this.onmousemove = function(e){
       		e = e || window.event;
       		if (!this_obj._clone) this_obj.dragStart.call(this_obj,e);
       		else {
                this_obj._cs.left = e.clientX+7+'px';
                this_obj._cs.top = e.clientY+9+'px';
            }
       	};
       	this.onmouseup = function(){
       		this_obj.dragStop.call(this_obj);
       	}
    },
    onload:function (){
    	jq.CDDSource.superclass.onload.call(this);
        this.init();
    },
    init:function (){
    	var items = this.id.getElementsByTagName(this.tag);
    	var l = items.length;
    	for (var i = 0; i<l; i++) {items[i].onmousedown = this.onmousedown; items[i].cmp = this}
    },
    onmousedown:function(e){
    	var cmp = this.cmp;
    	cmp.drag_object = this;
    	document.onmousemove = cmp.onmousemove;
    	document.onmouseup = cmp.onmouseup;
    	document.ondragstart = function() { return false };
        document.body.onselectstart = function() { return false };
        return false;
    },
    dragStart:function(e){
    	this._clone = this.drag_object.cloneNode(true);
        this._cs = this._clone.style;
        var cs = this._clone.style;
    	cs.position = "absolute";
    	cs.left = e.clientX+7+'px';
    	cs.top = e.clientY+9+'px';
        cs.zIndex = 20;
    	this.drag_component_type = "";
    	document.body.appendChild(this._clone);
    	jq.event(this,"onbegindrag",{type:this.curent});
    },
    dragStop:function(){
    	document.onmousemove = null;
    	document.onmouseup = null;
    	document.ondragstart = null;
        document.body.onselectstart = null;
    	if (this._clone) {
    		document.body.removeChild(this._clone);
            this._cs = null;
    		this._clone = null;
    		jq.event(this,"onenddrag",{object:this.drag_object});
    	}
        this.drag_object = null;
    }
});