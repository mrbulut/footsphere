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

include_once ROOT_PATH."/src/bussines/concrete/MessageManager.php";
$CustomerManager = new MessageManager(1);
$message = new message();
$message->setUserId(1);$message->setMessage("MESAJJJJ");
$messageWhere =new message();
$messageWhere->setId(2);
echo "burda..." .$CustomerManager->getMessagesList($messageWhere)['Message'];


//SETUP



/*
$rates = new ExchangeRateConverter(120); // 10 minutes cache
echo "ddddddddd.".$rates->convert('TRY','USD',25);
*/
?>





