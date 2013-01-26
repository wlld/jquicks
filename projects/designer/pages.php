<?php
error_reporting (E_ALL);
set_error_handler("error_handler");

require($_SERVER['DOCUMENT_ROOT'].'/core/TComponent/TComponent.php');
require($_SERVER['DOCUMENT_ROOT'].'/core/functions.php');
require($_SERVER['DOCUMENT_ROOT'].'/core/TProject.php');
Jq::construct();
if (file_exists(Jq::$page->path.'/page.php')) require(Jq::$page->path.'/page.php');
Jq::$page->draw();
exit;

class Jq {
    public static $project; //Объект текущего  проекта
    public static $page; //Объект текущей  страницы
    public static $base; //URL текущего проекта

    private static $_projects = array(); //Массив объектов проектов
    public static function construct(){
        $project_name = basename(dirname(__FILE__));
        $page_name = basename(__FILE__,'.php');
        try{
            self::$base = dirname($_SERVER['PHP_SELF']);
            self::$project = self::getProject($project_name);
            if(!isset(self::$project->db['names'][$page_name])) die('Page component "'.$page_name.'" not found');
            $page_id = self::$project->db['names'][$page_name]; 
            self::$page = self::$project->getById($page_id);
            self::$page->load();
            if (file_exists(self::$page->path.'/templates.php')) require(self::$page->path.'/templates.php');
        } catch (Exception $e) {
            echo($e->getMessage());
            exit;
        }
    }
    public static function getProject($name){
        if(!isset(self::$_projects[$name])){
            self::$_projects[$name] = new TProject($name); 
        }
        return self::$_projects[$name];
    }
    public static function get($name){return self::$project->getByName($name);}
}
function error_handler($errno, $errstr, $errfile, $errline ){
    $msg = "$errstr IN $errfile LINE $errline";
    throw new Exception($msg,1);
}
?>
