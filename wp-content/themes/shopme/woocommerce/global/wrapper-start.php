<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

	global $woocommerce_loop, $shopme_config;

	$wrapper_classes = array();

	$woocommerce_columns = $shopme_config['shop_overview_column_count'];
	$overview_column_count = shopme_get_meta_value('overview_column_count');

	if (!empty($overview_column_count) ) { $woocommerce_columns = $overview_column_count; }

	$product_view = shopme_custom_get_option('shop-view');
	if (empty($product_view)) { $product_view = 'type_1'; }

	$shop_view = shopme_get_meta_value('shop_view');
	if ( empty($shop_view) ) { $shop_view = shopme_custom_get_option('type-view'); }
	$wrapper_classes[] = $shop_view;

	if ( !shopme_is_product() ) {
		if (!empty( $woocommerce_columns ) ) { $wrapper_classes[] = 'shop-columns-' . $woocommerce_columns; }
		if (!empty( $product_view ) ) 		 { $wrapper_classes[] = $product_view; }
	}

	$show_sku = absint(shopme_custom_get_option('shop_show_sku'));

	if ( $show_sku ) {
		$wrapper_classes[] = 'visible-get-sku';
	}

	if ( shopme_is_product() ) {
		$wrapper_classes = array();
	}

?>

<div class="products-container clearfix <?php echo implode( ' ', $wrapper_classes ) ?>">