<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="theme_box">

	<form class="woocommerce-EditAccountForm edit-account col-2" action="" method="post">

		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

		<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
			<label for="account_first_name"><?php _e( 'First name', 'shopme' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-last">
			<label for="account_last_name"><?php _e( 'Last name', 'shopme' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
		</p>
		<div class="clear"></div>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
		</p>
		<div class="clear"></div>

		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<label for="account_email"><?php _e( 'Email address', 'shopme' ); ?> <span class="required">*</span></label>
			<input type="email" class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
		</p>

		<fieldset>
			<legend><?php _e( 'Password Change', 'shopme' ); ?></legend>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="password_current"><?php _e( 'Current Password (leave blank to leave unchanged)', 'shopme' ); ?></label>
				<input type="password" class="input-text" name="password_current" id="password_current" />
			</p>
			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="password_1"><?php _e( 'New Password (leave blank to leave unchanged)', 'shopme' ); ?></label>
				<input type="password" class="input-text" name="password_1" id="password_1" />
			</p>
			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="password_2"><?php _e( 'Confirm New Password', 'shopme' ); ?></label>
				<input type="password" class="input-text" name="password_2" id="password_2" />
			</p>
		</fieldset>
		<div class="clear"></div>

		<?php do_action( 'woocommerce_edit_account_form' ); ?>

		<p>
			<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
			<button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
			<input type="hidden" name="action" value="save_account_details" />
		</p>

		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

	</form>

	<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

</div>