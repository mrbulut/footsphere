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

include_once ROOT_PATH."/src/bussines/concrete/ProducerManager.php";
$MessageManager = new ProducerManager(8);
$Producer = new Producer();
$Producer->setOfferLimit(5);
echo "dsds".$MessageManager->removeProducer(9);
//echo "dsds".$MessageManager->getProducerProducts();

//echo "burda..." .$CustomerManager->getMessagesList($messageWhere)['Message'];


//SETUP



/*
$rates = new ExchangeRateConverter(120); // 10 minutes cache
echo "ddddddddd.".$rates->convert('TRY','USD',25);
*/
?>





