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

define('ROOT_PATH',__DIR__);

require_once ROOT_PATH.'/src/data/concrete/CustomerDal.php';

$eklencekObject = new Customer();
$eklencekObject->setAge("1");
$database = new CustomerDal();
$database->settingQuery($eklencekObject);
$database->deleteToObject();
//new User*Dal();


?>





