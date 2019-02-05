<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

?>
<li>

	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

	<a class="product_thumb" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo wp_kses_post( $product->get_image(array(85, 85)) ); ?>
	</a>
	<div class="wrapper">
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_title() ?>
		</a>
		<div class="clearfix product_info">
			<?php echo wp_kses_post( $product->get_price_html() ); ?>
			<?php if ( ! empty( $show_rating ) ) : ?>
				<?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) ); ?>
			<?php endif; ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>

	<div class="clear"></div>
</li>