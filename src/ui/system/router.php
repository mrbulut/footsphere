<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 11:26
 */

$url = $_SERVER['REQUEST_URI'];
$url = explode("wp-admin", $url);
if ($url[1]) {


    $url = $url[1];
    $url = explode("&", $url);
    $url = $url[1];



    if (!$url) {
        $url = "Dashboard";
    }

    echo "Url . " . $url."<br>";
    echo "Value . " . $url."<br>";

    $controller = ROOT_PATH . "/src/ui/app/controllers/" . $url . "Controller.php";
    $header = ROOT_PATH . "/src/ui/app/header.php";
    $footer = ROOT_PATH . "/src/ui/app/footer.php";

    if (file_exists($controller)) {
        require $header;
        require $controller;
        require $footer;
    } else
        echo "404";
}



