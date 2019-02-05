<?php

/**
  Plugin Name: Footsphere
  Plugin URI: techy.works
  Description: XSXS
  Author: ^'+!'¡£#>23
  Version: 1.0
  Author URI: ---
  License: MIT
 **/

defined('ABSPATH') or die('You can\t access this file!');


// Menüler ekleniyor.

require_once __DIR__ . "/init.php";
require_once __DIR__ . "/views/menu/menu.php";
require_once __DIR__ . "/classes/element.php";


// üyelik sistemi ekleniyor.
require_once __DIR__ . "/includes/advanced-access-manager/aam.php";

// yetkisi olmayan biri klasör oluşturmaya çalışırsa bu hatayı vericek.
defined('ABSPATH') or die('You can\t access this file!');
// yetkisi olmayan biri fonksiyon çağırmaya kalkarsa bu hatayı vericek.
if (!function_exists('add_action')) {
  echo 'You can\t access this file';
  exit;
}


/*
    require_once ('database/bespokeDB.php');
    $olustur = new bespokeDB();
    echo "ikiyuzfeatures . ".$olustur->setAll(array(7,"3","3","3","3"));

    $ids = $db->insertMulti('wp_bespoke', $data, $keys);




    


*/
?>






