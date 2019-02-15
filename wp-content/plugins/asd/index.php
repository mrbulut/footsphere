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

include_once ROOT_PATH."/src/bussines/concrete/UserManager.php";
$ProductManager = new UserManager();
$User = new User();
$User->setDisplayName("dendeme");
$User->setUserPass("deneme@denemed.com");


 $array =  $ProductManager->updateUser($User,5);



?>





