<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 21.02.2019
 * Time: 16:44
 */
if (count($route) == 1 && $route[0] == '') {
    $route[0] = 'home';
    $route[1] = 'index';
}

if (!isset($route[1])) {
    $route[1] = 'index';
}


