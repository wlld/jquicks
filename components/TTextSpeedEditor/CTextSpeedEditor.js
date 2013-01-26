jq.newClass('CTextSpeedEditor','CVidget',{
    construct:function(){
        jq.CTextSpeedEditor.superclass.constructor.apply(this,arguments);
        jq.registerEventHandler("CPrpEditor","onedittextproperty",[this,'_showEditor']);
        jq.registerEventHandler("CPrpEditor","oneditobjectproperty",[this,'_showEditor']);
    },
    cancel:function(){
        this.id.style.display = 'none';
        document.getElementById('shield').className = '';
    },
    save:function(){
        var ta = this.id.getElementsByTagName('textarea')[0];
        this.control.value = ta.value;
        this.control.onchange();
        this.id.style.display = 'none';
        document.getElementById('shield').className = '';
    },
    _showEditor:function(e){
        document.getElementById('shield').className = 'active_shield';
        this.id.style.display = 'block';
        var ta = this.id.getElementsByTagName('textarea')[0];
        ta.value = e.control.value;
        ta.focus();
        this.control = e.control;
    }
});