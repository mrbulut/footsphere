<?php
/**
Plugin Name: FootsphereSS
Plugin URI: techy.workss
Description: XSXS
Author: ^'+!'¡£#>23
Version: 1.0
Author URI: ---
License: MIT
 **/

defined('ABSPATH') or die('You can\t access this file!');
if (!function_exists('add_action')) {
    echo 'You can\t access this file';
    exit;
}

define('ROOT_PATH', __DIR__);
include_once  __DIR__.'/src/data/concrete/UserDal.php';
include_once  __DIR__.'/src/entities/concrete/UserConcrete.php';
include_once ROOT_PATH."/src/entities/abstract/Container.php";
$database =Container::getInstance(UserDal::class);
$m = new User();


//$database = new CustomerDal();
//$mesaj = new Customer();




























/// TEŞEKKÜR YAZISINI KALDIRIYOR
function custom_admin_footer() {
    echo '';
}
add_filter('admin_footer_text', 'custom_admin_footer');
/// TEŞEKKÜR YAZISINI KALDIRIYOR