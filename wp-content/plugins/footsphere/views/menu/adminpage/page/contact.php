<?php


function contact()
{

 // require_once(__DIR__ . '/implement/products.php');
 
 require_once(__DIR__ . '/implement/contact.php');
   $product =  new messagelistpage(true);
   $product->setupPage();
   echo $product->getResultPage();
 

}


?>