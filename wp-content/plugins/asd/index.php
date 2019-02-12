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
define('ROOT_PATH',__DIR__);
require_once(ROOT_PATH . '/src/core/lib/ExchangeRateConverter.php');
$ex = new ExchangeRateConverter(); // defined roles and caps

echo "deneme. " .realpath(dirname(__FILE__));

//SETUP



/*
$rates = new ExchangeRateConverter(120); // 10 minutes cache
echo "ddddddddd.".$rates->convert('TRY','USD',25);
*/
?>





