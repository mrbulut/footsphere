<?php

$currentPath = __DIR__.'/';
$woocommerceDir = $currentPath.'woocommerce/';
$ecommerceDir = $currentPath.'ecommerce/';
$envatoDir = $currentPath.'envato/';

if (!class_exists('WooCommerceCacheHelper')) {
    require_once $woocommerceDir.'WooCommerceCacheHelper.php';
}

if (!class_exists('FestiObject')) {
    require_once $currentPath.'FestiObject.php';
}

if (!class_exists('FestiPlugin')) {
    require_once $currentPath.'FestiPlugin.php';
}

if (!class_exists("DataAccessObject")) {
    require_once $currentPath.'database/DataAccessObject.php';
}

if (!class_exists('WooCommerceProductValuesObject')) {
    require_once $woocommerceDir.'WooCommerceProductValuesObject.php';
}

if (!class_exists("WordpressFacade")) {
    require_once $currentPath.'wordpress/WordpressFacade.php';
}

if (!class_exists('EcommerceFactory')) {
    require_once $ecommerceDir.'EcommerceFactory.php';
}

if (!interface_exists('IEcommerceFacade')) {
    require_once $ecommerceDir.'IEcommerceFacade.php';
}

if (!class_exists('EcommerceFacade')) {
    require_once $ecommerceDir.'EcommerceFacade.php';
}

if (!class_exists('UnsupportableFacadeMethod')) {
    require_once $currentPath.'exceptions/UnsupportableFacadeMethod.php';
}
if (!class_exists('FacadeException')) {
    require_once $currentPath.'exceptions/FacadeException.php';
}

if (!class_exists("WooCommerceFacade")) {
    require_once  $woocommerceDir.'WooCommerceFacade.php';
}

if (!class_exists('EnvatoUtil')) {
    require_once $envatoDir.'EnvatoUtil.php';
}

if (!interface_exists('IConnectionUrlFacade')) {
    require_once $envatoDir.'IConnectionUrlFacade.php';
}

if (!class_exists('AbstractConnectionUrl')) {
    require_once $envatoDir.'AbstractConnectionUrl.php';
}

if (!class_exists('ConnectionUrlFacade')) {
    require_once $envatoDir.'ConnectionUrlFacade.php';
}

if (!class_exists('EnvatoApiServerNotFound')) {
    require_once $currentPath.'exceptions/envato/EnvatoApiServerNotFound.php';
}

if (!class_exists('EnvatoApiServerNotFound')) {
    require_once $currentPath.'exceptions/envato/EnvatoException.php';
}

if (!class_exists('ConnectionLibraryNotFound')) {
    require_once $currentPath.'exceptions/envato/ConnectionLibraryNotFound.php';
}
