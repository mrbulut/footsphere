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



require_once(ROOT_PATH . '/src/core/res/values/GeneralCons.php');

$string = new GeneralCons("Türkçe");
$de =  $string->getFilesInLangFiles();

foreach ($de as $key => $value)
echo $value;

?>





