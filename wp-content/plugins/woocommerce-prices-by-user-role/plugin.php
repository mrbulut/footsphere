<?php
// @codingStandardsIgnoreStart
/**
 * Plugin Name: WooCommerce Prices By User Role
 * Plugin URI: https://festi.team/plugins/woocommerce-prices-by-user-role/
 * Description:  With this plugin  for WooCommerce  Products can be offered different prices for each customer group. Also you can do only product catalog without prices and show custom notification instead price.
 * Version: 4.0.2
 * Author: Festi-Team
 * Author URI: https://festi.team/
 * Copyright 2014  Festi-Team  https://festi.team/
 */
// @codingStandardsIgnoreEnd

try {
    $festiPriceByRolePath = dirname(__FILE__);
    $festiPriceByRoleCommonPath = dirname(__FILE__).'/common';
    $festiPriceByRoleFestiPath = dirname(__FILE__).'/common/festi';
    
    require_once $festiPriceByRolePath.'/config.php';
    
    if (!class_exists('WooUserRolePricesUtils')) {
        $path = '/WooUserRolePricesUtils.php';
        require_once $festiPriceByRolePath.$path;
    }
    
    WooUserRolePricesUtils::doCheckPhpVersion(
        PRICE_BY_ROLE_MIN_PHP_VERSION
    );
    
    require_once $festiPriceByRoleFestiPath.'/autoload.php';
    
    if (!class_exists('WordpressDispatchFacade')) {
        require_once $festiPriceByRoleCommonPath.'/WordpressDispatchFacade.php';
    }
    
    if (!class_exists('UserRolePriceFacade')) {
        $path = '/facade/UserRolePriceFacade.php';
        require_once $festiPriceByRoleCommonPath.$path;
    }
    
    if (!class_exists('WpmlCompatibleFestiPlugin')) {
        $path = '/wpml/WpmlCompatibleFestiPlugin.php';
        require_once $festiPriceByRoleCommonPath.$path;
    }
    
    if (!class_exists('FestiWpmlManager')) {
        require_once $festiPriceByRoleCommonPath.'/wpml/FestiWpmlManager.php';
    }
    
    if (!class_exists('StringManagerWooUserRolePrices')) {
        require_once $festiPriceByRolePath.
            '/StringManagerWooUserRolePrices.php';
    }
    
    if (!class_exists('WooUserRolePricesFestiPlugin')) {
        require_once $festiPriceByRolePath.'/WooUserRolePricesFestiPlugin.php';
    }
    
    require_once $festiPriceByRolePath.'/functions.php';
    require_once $festiPriceByRoleCommonPath.'/WooUserRolePricesApiFacade.php';
    
    $className = 'wooUserRolePricesFestiPlugin';
    $GLOBALS[$className] = new WooUserRolePricesFestiPlugin(__FILE__);
} catch (Exception $e) {
     WooUserRolePricesUtils::displayPluginError($e->getMessage());
}
