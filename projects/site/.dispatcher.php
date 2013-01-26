<?php
error_reporting (E_ALL);
set_error_handler("error_handler");
require($_SERVER['DOCUMENT_ROOT'].'/core/TComponent/TComponent.php');
require($_SERVER['DOCUMENT_ROOT'].'/core/TService/TService.php');
require($_SERVER['DOCUMENT_ROOT'].'/core/TProject.php');

Jq::construct();
Jq::processQueue();
exit;

class Jq {
    public static $project; //Объект текущего  проекта
    public static $page=null; //Объект текущей  страницы
    public static $base; //URL текущего проекта
    private static $_projects = array(); //Массив объектов проектов

    private static $queue;
    private static $answer = array();
    public static function construct(){
        $project_name = basename(dirname(__FILE__));
        try{
            self::$base = dirname($_SERVER['PHP_SELF']);
            self::$project = self::getProject($project_name);
            self::$queue = json_decode(get_magic_quotes_gpc()? stripslashes($_POST['queue']):$_POST['queue'],true);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            for($i=0,$l=count(self::$queue);$i<$l;$i++) self::$answer[]=array('status'=>$e->getCode(), 'errortext'=>$msg);
            self::sendAnswer();
        }
    }
    private static function sendAnswer(){
        header('Content-Type: text/html; charset=utf-8');
        echo TComponent::jsonEncode(self::$answer);
    }
    public static function getProject($name){
        if(!isset(self::$_projects[$name])){
            self::$_projects[$name] = new TProject($name); 
        }
        return self::$_projects[$name];
    }
    public static function get($name){return self::$project->getByName($name);}

    public static function processQueue(){
        foreach(self::$queue as $command){
            try{
                if (!isset($command['service'])) throw new Exception('Service undefined.');
                if (!isset($command['method'])) throw new Exception('Method undefined.');
                if (!isset($command['args'])) throw new Exception('Method arguments undefined.');
                $c = self::get($command['service']);
                if(!$c instanceof ICommandServer) throw new Exception($c->name.' can not execute commands.');
                $result = $c->run($command['method'],$command['args']);
                $result['status'] = 0;
                self::$answer[] = $result;
            }
            catch(Exception $e) {self::$answer[] = array('status'=>$e->getCode(), 'errortext'=>$e->getMessage());}
        }
        self::sendAnswer();
    }
}

function error_handler($errno, $errstr, $errfile, $errline ){
    $msg = "$errstr IN $errfile LINE $errline";
    throw new Exception($msg,1);
}
?>