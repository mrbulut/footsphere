<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 21.02.2019
 * Time: 16:42
 */

$viewPath = ($viewPath == null) ? implode('/', $route) : $viewPath;
if (!file_exists(__DIR__.'/../views/' . $viewPath . '.php')) {
    $viewPath = '404';
}

include __DIR__.'/../views/default_master.php';