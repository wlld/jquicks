<?
if(!isset($_GET['edpage'])) $_GET['edpage'] = "site.index";
$p = explode('.',$_GET['edpage']);
if(count($p) !== 2){
    echo "Invalid format of parameter edpage. 'project.page' required.";
    exit;
}
list($prg,$page) = $p;
try{
    $edproj = jq::getProject($prg);
    if(!isset($edproj->db['names'][$page])) throw new Exception('Page with name "'.$page.'" is not exist.');
    $page_id = $edproj->db['names'][$page];
}catch(Exception $e){
    echo $e->getMessage(); exit;
}
jq::get('pagetree')->treemodel->params["project"] = $prg;
jq::get('pagetree')->treemodel->params["page"] = $page;
jq::get('tpleditor')->tplmodel->params["project"] = $prg;
jq::get('tpleditor')->tplmodel->params["page"] = $page;
jq::get('js_editor')->jsmodel->params["project"] = $prg;
jq::get('js_editor')->jsmodel->params["page"] = $page;
jq::get('prpeditor')->prpmodel->params["project"] = $prg;
jq::get('prpeditor')->prpmodel->params["page"] = $page;
jq::get('csseditor')->cssmodel->params["project"] = $prg;
jq::get('csseditor')->cssmodel->params["page"] = $page;
jq::get('php_editor')->phpmodel->params["project"] = $prg;
jq::get('php_editor')->phpmodel->params["page"] = $page;
jq::get('allcmp')->model->params["project"] = $prg;
jq::get('allcmp')->model->params["page"] = $page;
jq::get('linkspeededitor')->mservice->params["project"] = $prg;
//jq::get('linkspeededitor')->mparent->params["project"] = $prg;
jq::get('component_editor')->page = $page;
jq::get('linkseditor')->model->params["project"] = $prg;

$edparam = isset($_GET['edparam'])? $_GET['edparam']:'';
jq::get('frame')->url = "/projects/$prg/$page.php?$edparam";
?>