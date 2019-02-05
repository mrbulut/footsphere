<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
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
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="tabs-holder">

	<ul class="tabs-nav">

		<li class="active"><a href="#"><?php esc_html_e('Login', 'shopme') ?></a></li>

		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
			<li><a href="#"><?php esc_html_e('Register', 'shopme') ?></a></li>
		<?php endif; ?>

	</ul><!--/ .tabs-nav-->

	<div class="tabs-container">

		<div class="tab-content">

			<div class="col-2">

				<form method="post" class="login">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
						<label for="username"><?php esc_html_e( 'Username or email address', 'shopme' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
					</p>
					<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
						<label for="password"><?php esc_html_e( 'Password', 'shopme' ); ?> <span class="required">*</span></label>
						<input class="input-text" type="password" name="password" id="password" />
						<span class="lost_password">
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'shopme' ); ?></a>
						</span>
					</p>

					<div class="clear"></div>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<p class="form-row">
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" />
						<label for="rememberme" class="inline"><?php esc_html_e( 'Remember me', 'shopme' ); ?></label>
					</p>

					<p class="form-row">
						<input type="submit" class="button button_blue middle_btn" name="login" value="<?php esc_html_e( 'Login', 'shopme' ); ?>" />
					</p>

					<?php if (defined('OA_SOCIAL_LOGIN_PLUGIN_URL')):
						$settings = get_option('oa_social_login_settings');
						$settings = $settings['providers'];
					?>

						<?php if (!empty($settings)): ?>

							<div class="streamlined">
								<h4 class="streamlined_title"><?php esc_html_e('OR Log In With', 'shopme'); ?></h4>
								<?php do_action( 'woocommerce_login_form_end' ); ?>
							</div>

						<?php else: ?>

							<?php do_action( 'woocommerce_login_form_end' ); ?>

						<?php endif; ?>

					<?php else: ?>

						<?php do_action( 'woocommerce_login_form_end' ); ?>

					<?php endif; ?>

				</form>

			</div><!--/ .col-2-->

		</div><!--/ .tab-content-->

		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

			<div class="tab-content">

				<div class="col-2" id="customer_login">

					<form method="post" class="register">

						<?php do_action( 'woocommerce_register_form_start' ); ?>

						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

							<p class="form-row form-row-wide">
								<label for="reg_username"><?php esc_html_e( 'Username', 'shopme' ); ?> <span class="required">*</span></label>
								<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
							</p>

						<?php endif; ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
							<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</p>

						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
							</p>

						<?php endif; ?>

						<?php do_action( 'woocommerce_register_form' ); ?>

						<p class="form-row">
							<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
							<input type="submit" class="button button_blue middle_btn" name="register" value="<?php esc_html_e( 'Register', 'shopme' ); ?>" />
						</p>

						<?php do_action( 'woocommerce_register_form_end' ); ?>

					</form>

				</div><!--/ .col-2-->

			</div><!--/ .tab-content-->

		<?php endif; ?>

	</div><!--/ .tabs-container-->

</div><!--/ .tabs-holder-->

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

