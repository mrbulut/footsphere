<?php

class config {
  // Config::getConfig('mysql/host') şeklinde kullanılıyor.
  function getConfig($yol = null){
  if($yol!=null){
    $config = $GLOBALS['config'];
    $yol = explode("/",$yol) ;
    foreach ($yol as $bit) {
      if (isset($config[$bit])){
        $config = $config[$bit];
      }
    }
    return $config;
  }
  require false;
}

}

class df{

}


 ?>
