<?php

session_start();

$url = $_GET['_url'];
$route = explode('/', $url);
$viewPath = null;


include 'config/routes.php';
include 'core/router.php';
include 'middleware.php';


if(isset($myRoutes[$url])) {
    $route = $myRoutes[$url];
    $viewPath = isset($myRoutes[$url][2]) ? $myRoutes[$url][2] : null;
}

new MiddleWare();


include 'core/view.php';

