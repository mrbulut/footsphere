<?php
function producer_request()
{
 
 require_once(__DIR__ . '/implement/request.php');
 $product =  new request();
 $product->setupPage();
 echo $product->getResultPage();



}

?>
