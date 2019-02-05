<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="section_offset">

	<div class="woocommerce-form-coupon-toggle">
		<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'shopme' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' ); ?>
	</div>

	<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display: none; ">

		<div class="theme_box">

			<p class="form_caption"><?php esc_html_e('Enter your coupon code if you have one.', 'shopme') ?></p>

			<ul>
				<li class="row">
					<div class="col-xs-12">
						<p class="form-row form-row-first">
							<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_html_e( 'Coupon code', 'shopme' ); ?>" id="coupon_code" value="" />
						</p>
					</div>
				</li>
			</ul>

		</div><!--/ .theme_box-->

		<footer class="bottom_box">
			<button type="submit" class="button button_grey middle_btn" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'shopme' ); ?>"><?php esc_html_e( 'Apply Coupon', 'shopme' ); ?></button>
		</footer><!--/ .bottom_box-->

	</form>

</div><!--/ .section_offset-->

