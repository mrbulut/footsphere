<?php
function producer_profil()
{
   require_once(__DIR__ . '/implement/profil.php');
   $product =  new profilpage();
   $product->setupPage();
   echo $product->getResult();


   

   

}

?>
