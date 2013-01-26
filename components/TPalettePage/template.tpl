{{foreach from=this->components item=cmp}}
{{assign var=path value=isCoreClass($cmp)?'/core/':'/components/'}}
   <img alt="{{$cmp}}" title="{{$cmp}}" src="{{$path.$cmp}}/icon.png"?>
{{/foreach}}