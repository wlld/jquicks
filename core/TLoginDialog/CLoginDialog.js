jq.newClass('CLoginDialog','CVidget',{
    construct:function(){
        jq.CLoginDialog.superclass.constructor.apply(this,arguments);
//        jq.registerEventHandler(this.name+".model","onfetch",[this,'_onFetchModel']);
        jq.registerEventHandler(this.name,"onerror",[this,'_onError']);
    },
    login:function(){
        var form = this.id.getElementsByTagName('form')[0];  
        this._login = form.login.value;
        this._pass = form.pass.value;
        this._rm = (form.rm && form.rm.checked)?1:0;
        if(!this._login){alert('Введите логин!'); return;}
        if(!this._pass){alert('Введите пароль!'); return;}
        var arg = {login:this._login};
        jq.get('TActionServer').registerCommand('TAccountService','authenticationPhase1',arg,[this,'_onAtthPhase1']);
    },
    logout:function(){
        jq.get('TActionServer').registerCommand('TAccountService','logout',{},[this,'_onLogOut']);
    },
    _onLogOut:function(e){
        if(e.status==0) {
            this.user_id=0;
            this.user_name='';
            this.redraw();
            jq.event(this,'onlogin',{});
        }
        else jq.event(this,'onerror',e);
    },
    _onAtthPhase1:function(e){
      if(e.status>0) jq.event(this,'onerror',e);
      else {
         var key = RSA.getPublicKey(e.key);
         var arg = {
            login:this._login,  
            pass:RSA.encrypt(this._pass+'|'+e.id, key),
            rm:this._rm  
         };
         jq.get('TActionServer').registerCommand('TAccountService','authenticationPhase2',arg,[this,'_onAtthPhase2']);
      }
    },
    _onAtthPhase2:function(e){
      if(e.status>0) jq.event(this,'onerror',e);
      else{
          this.user_id = e.idx;
          this.user_name = e.name;
          this.redraw();
         jq.event(this,'onlogin',{});
      } 
    },
    _onError:function(e){alert(e.errortext);}
});