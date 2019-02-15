<?php

/**
Plugin Name: DENEMEPLGUSİB
Plugin URI: techsy.worksd
Description: XSXSs
Author: ^'+!'¡2£#>233
Version: 11.0
Author URI: ---
License: MIT
 **/
//SETUP MUST //
define('ABSPATH',dirname(__FILE__)."/../../../");

define('ROOT_PATH',__DIR__);

include_once ROOT_PATH."/src/bussines/concrete/ProductManager.php";
$ProductManager = new ProductManager();



  $array =  $ProductManager->getAllListForTheUser(3);

foreach ($array[0] as $key => $value)
 echo $key.$value;
?>





