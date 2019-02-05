<?php
function producer()
{
  require_once(__DIR__ . '/implement/producer.php');
  $product =  new producerpage();
  $product->setupPage();
  echo $product->getResultPage();
}

?>
