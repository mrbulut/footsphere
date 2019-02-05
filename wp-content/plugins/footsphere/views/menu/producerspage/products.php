<?php
function producer_products()
{
  require_once(__DIR__ . '/implement/products.php');
  $product =  new productpage();
  $product->setupPage();
  echo $product->getResultPage();
  

}

?>
