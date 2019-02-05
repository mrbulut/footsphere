<?php


function producer_order() {

    require_once(__DIR__ . '/implement/order.php');
    $product =  new order();
    $product->setupPage();
    echo $product->getResultPage();

}
?>



