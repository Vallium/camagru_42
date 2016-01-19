<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'on');

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
define('DS', DIRECTORY_SEPARATOR);

require('core/Controller.php');
require('core/Model.php');

//function __autoload($class)
//{
//    $path = ROOT.DS.str_replace('\\', DS, $class).'.php';
//    if (file_exists($path))
//        require $path;
//}

$url = explode('/', $_GET['url']);

$controller = !empty($url[0]) ? ucfirst($url[0]).'Controller' : 'HomeController';
$method = isset($url[1]) ? $url[1] : 'index';


unset($url[0]);
unset($url[1]);

require('controllers'.DS.$controller.'.php');
$controller = '\controller\\'.$controller;
$controller = new $controller();

if (method_exists($controller, $method))
{
    $controller->$method();
//    call_user_func_array(array($controller, $method), $url);
}
else
    echo 'erreur 404';