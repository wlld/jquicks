<?
$service = isset($_GET['service'])? $_GET['service']:'TPageEditService';
jq::get('mmodels')->params["service"] = $service;
jq::get('mfields')->params["service"] = $service;
jq::get('mfetchp')->params["service"] = $service;
jq::get('mcmdp')->params["service"] = $service;
jq::get('mcmd')->params["service"] = $service;
?>