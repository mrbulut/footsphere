<?php
function products()
{
   require_once ABSPATH . "wp-content/plugins/footsphere/views/menu/producerspage/implement/products.php";
   //require_once(__DIR__ . '/implement/products.php');
   $product =  new productpage(true);
   $product->setupPage();
   echo $product->getResultPage();
}

?>
