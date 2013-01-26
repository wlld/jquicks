<?
$prj = isset($_GET['project'])? $_GET['project']:'site';
if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/projects/'.$prj)){
  echo("Project '$prj' is not exist."); exit;
}
jq::$project->getByName('pmodel')->params['project'] = $prj;
?>