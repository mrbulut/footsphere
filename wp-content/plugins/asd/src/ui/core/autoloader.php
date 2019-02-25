<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 21.02.2019
 * Time: 16:35
 */
session_start();

$url = $_GET['_url'];
echo $url;
$route = explode('/', $url);
$viewPath = null;


include ROOT_PATH.'/src/ui/config/routes.php';
include ROOT_PATH.'/src/ui/core/router.php';
include ROOT_PATH.'/src/ui/middleware.php';


if(isset($myRoutes[$url])) {
    $route = $myRoutes[$url];
    $viewPath = isset($myRoutes[$url][2]) ? $myRoutes[$url][2] : null;
}

new MiddleWare();

function autoloadHelper($className)
{
    if (substr($className, -10) == 'Controller' && file_exists(ROOT_PATH.'/src/ui/controllers/' . $className . '.php')) {
        include(ROOT_PATH.'/src/ui/controllers/' . $className . '.php');
    }

    if (substr($className, -5) == 'Model' && file_exists(ROOT_PATH.'/src/ui/models/' . $className . '.php')) {
        include(ROOT_PATH.'/src/ui/models/' . $className . '.php');
    }

    if (file_exists(ROOT_PATH.'/src/ui/core/' . $className . '.core.php')) {
        include ROOT_PATH.'/src/ui/core/' . $className . '.core.php';
    }
}

spl_autoload_register('autoloadHelper');



$myClass = $route[0] . 'Controller';

if ($myClass) {
    $myClass = new $myClass();
    $myMethod = $route[1];

    if (method_exists($myClass, $myMethod)) {
        $myClass->$myMethod();
    }
}

include ROOT_PATH.'/src/ui/core/view.php';