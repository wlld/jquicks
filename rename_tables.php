<?php
error_reporting (E_ALL);
require($_SERVER['DOCUMENT_ROOT'].'/core/TComponent/TComponent.php');
require($_SERVER['DOCUMENT_ROOT'].'/core/TProject.php');
$projects = glob($_SERVER['DOCUMENT_ROOT'].'/projects/*',GLOB_ONLYDIR);
foreach($projects as $project){
    $project = new TProject(basename($project)); 
    if(!$project->isComponentExists('TDataBase')) continue;
    $db = $project->getByName('TDataBase')->db;
    $dbtables = getDbTables();
    $tt = array(); $n=0;
    foreach($project->db['components'] as $id => $cmp){
        if(isDBService($cmp['c'])){
            $designer = TComponent_::getDesigner($id, $project);
            $tables = $designer->_getTables();
            foreach($tables as $table){
                $old_name = strtolower($cmp['n'].'_'.$table);
                $new_name = strtolower($cmp['n'].'@'.$table);
                if(in_array($old_name, $dbtables)) $tt[] = "`$old_name` TO `$new_name`";
            }
        }
    }
    if($tt){
        $sql = 'RENAME TABLE '.join(',', $tt);
        if ($db->exec($sql)===false) die($db->errorInfo());
        $n+=count($tt);
    }
}
header('Content-Type: text/html; charset=utf-8');
die("Готово. $n таблиц переименовано.");
function isDBService($class){
global $project;   
   if ($class === 'TDBService') return true;
   return in_array('TDBService', $project->db['classes'][$class]);
}
function getDbTables(){
global $db;    
   $r = $db->query('SHOW TABLES');
   if(!$r) die($db->errorInfo());
   return $r->fetchAll(PDO::FETCH_COLUMN,0);
}
class jq {
    static $page = '';
}
?>
