

<?php
ob_start();

/**
Plugin Name: DENEMEPLGUSİB
Plugin URI: techsy.worksd
Description: XSXSs
Author: ^'+!'¡2£#>233
Version: 11.0
Author URI: ---
License: MIT
 **/
define('ABSPATH',__DIR__);
define('ROOT_PATH',__DIR__);
define('WORD_PATH',dirname(__FILE__)."/../../../");

// AAM Üyelik sistemi aktifleştiriliyor.
include ROOT_PATH.'/src/core/lib/advanced-access-manager/aam.php';
// Short code yükleniyor
include ROOT_PATH.'/src/ui/app/views/shortcodes/init.php';

// Menuler oluşturuluyor.
add_action('admin_menu', 'fs_modifymenu');

function fs_modifymenu()
{
    add_menu_page(
        "Footsphere", //page title
        "Footsphere", //menu title
        'edit_posts', //capabilities
        'footsphere',//menu slug
        'my_custom_menu_page' //function
    //icon
    );
}

function my_custom_menu_page(){
    include ROOT_PATH . '/src/autoloader.php';
}




?>




