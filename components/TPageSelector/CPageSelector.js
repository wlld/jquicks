jq.newClass('CPageSelector','CVidget',{
    construct:function(){
        this.value = '';
        this.items = {};
        jq.CPageSelector.superclass.constructor.apply(this,arguments);
    },    
    select:function(name){
    	var page;
        for(var p in this.items) if(this.items.hasOwnProperty(p)) this.items[p].className = "";
        this.items[name].className ="active";
    	this.value = name;
    	for(i = 0;i<this.pages.length; i++){
            var n = this.pages[i];
            try{ page = jq.get(n);}
            catch(e) {page = null;}
            if (n==this.value) {
                if(page && typeof page.show=='function') page.show();
                else document.getElementById(this.pages[i]).style.display = "block";
            }
            else  document.getElementById(this.pages[i]).style.display = "none";
    	}
        jq.event(this,"onpageselect",{item:this.pages[this.value]});
    },
    onload:function (){
    	jq.CPageSelector.superclass.onload.call(this);
    	var lis = this.id.getElementsByTagName('li');
    	for (var i = 0; i<lis.length; i++){
            var n = this.pages[i];
            this.items[n] = lis[i];
            if(!this.visibility[i]) lis[i].style.display = 'none';
        } 
        return false;
    },
    setActive:function(name,a){
       this.items[name].style.display = a?'':'none';
       if(name==this.value && !a) {
           document.getElementById(name).style.display = "none";
       }
    }
});