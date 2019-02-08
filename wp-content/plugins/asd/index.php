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



require_once(ROOT_PATH . '/src/core/lib/ExchangeRateConverter.php');


$rates = new ExchangeRateConverter(120); // 10 minutes cache
echo "ddddddddd.".$rates->convert('TRY','USD',25);

?>





