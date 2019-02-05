<?php


function request_adminpage()
{


    require_once(__DIR__ . '/implement/request.php');
    $product = new adminrequest();
    $product->setupPage();
    echo $product->getResultPage();



}
?>