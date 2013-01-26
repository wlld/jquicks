jq.newClass('CCacheModel','CModel',{
    construct:function CModel(){
        jq.CCacheModel.superclass.constructor.apply(this,arguments);
        this.cache_store={};
        this.cache_key=null;
        var _this = this;
        this._onTick=function() {_this._onFetch(_this.cache_store[_this.cache_key]);}
    },
    dropCache:function(clear){
        this.cache_store={};
        if(clear) this.clear();
    },
    _toString:function(obj){
        if(obj){
            if (typeof obj == 'object'){
                var s='';
                for(var p in obj) if (obj.hasOwnProperty(p)) s+=p.toString()+this._toString(obj[p]);
                return s;
            } else return obj.toString();
        } else return '';
    },
    _queryData:function(mode){
        var ckey = this._toString(this.params)+this.first+this.limit;
        if(this.cache_store[ckey]) {
            this.cache_key=ckey;
            setTimeout(this._onTick,1);
        }
        else jq.CCacheModel.superclass._queryData.call(this,mode);
    },
    _onFetch:function(data){
        if(this.cache_key){
            this.cache_key = null;
        }
        else{
            if(data.status == 0){
                var ckey = this._toString(this.params)+this.first+this.limit;
                this.cache_store[ckey] = data;
            }
        }
       jq.CCacheModel.superclass._onFetch.call(this,data);
    }
});