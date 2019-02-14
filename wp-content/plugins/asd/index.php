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

include_once ROOT_PATH."/src/bussines/concrete/CustomerManager.php";
$ProductManager = new CustomerManager();
$Product = new Customer();
$Product->setUserId(3);
echo $ProductManager->getProducts();



?>





