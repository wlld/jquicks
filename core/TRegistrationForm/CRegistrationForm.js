jq.newClass('CRegistrationForm','CVidget',{
    construct:function(){
       jq.CRegistrationForm.superclass.constructor.apply(this,arguments);
       this.state = 0;
    },
    cancel:function(){
       this.id.style.display='none';  
    },
    show:function(){
       this.login = this.pass = this.email = '';
       if (this.state != 0 || !this.id.getElementsByTagName('FORM')[0]){
           this.state=0;
           this.redraw();
       }
       this.id.style.display='block';  
    },
    redraw:function(){
        jq.CRegistrationForm.superclass.redraw.apply(this,arguments);  
        if(this.state==0){
            var form = this.id.getElementsByTagName('FORM')[0];
            if(this.login) form.login.value = this.login;
            if(this.pass) form.password.value = this.pass;
            if(this.email) form.email.value = this.email;
        }
    },
    send:function(){
        var form = this.id.getElementsByTagName('FORM')[0];
        this.login = form.login.value;
        this.pass = form.password.value;
        this.email = form.email.value;
        if(!this.login) {alert('Введите логин'); return;}
        if(!this.pass) {alert('Введите пароль');return}
        if(!this.email) {alert('Введите email'); return;}
        if(!this.isValidPassword(this.pass)) {
            alert("Пароль может состоять только из следующих символов:\na-zA-z0-9~!@#$%^&*()_+=[]{}:?><-\nи должен содержвать не менее 3 и не более 10 символов.");
            return;
        }
        if(!this.isValidLogin(this.login)) {
            alert("Логин может состоять только из следующих символов:\na-zA-z0-9_\nи должен содержвать не более 20 символов.");
            return;
        }
        if(!this.isValidEmail(this.email)) {
            alert("Не верный адрес электронной почты");
            return;
        }
        if(this.pass != form.password2.value) {alert('Пароли не совпадают');return;}
        jq.get('TActionServer').registerCommand('TAccountService','getPublicKey',{},[this,'_onPhase1']);
        this.state=1;
        this.redraw();
    },
    isValidPassword:function(pass){
        return /^[a-zA-z0-9~!@#$%^&*()_+=[\]{}:?><-]{3,10}$/.test(pass);
    },
    isValidLogin:function(l){
        return /^[a-zA-z0-9_]{1,20}$/.test(l);
    },
    isValidEmail:function(l){
        return /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/.test(l);
    },
    _onPhase1:function(e){
        if(e.status==0){
            var key = RSA.getPublicKey(e.key);
            var args = {
               login:this.login,  
               pass:RSA.encrypt(this.pass+'|', key),
               email:this.email  
            };
            jq.get('TActionServer').registerCommand('TAccountService','registration',args,[this,'_onPhase2']);
        }    
        else {
            this.state=0;
            this.redraw();
            alert(e.errortext);
        }
    },
    _onPhase2:function(e){
        if(e.status==0){
            this.state=2;
            this.redraw();
        }
        else {
            this.state=0;
            this.redraw();
            alert(e.errortext);
        }
    }
});
