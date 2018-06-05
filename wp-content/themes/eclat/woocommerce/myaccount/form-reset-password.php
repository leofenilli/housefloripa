<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices(); ?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password">

	<p><?php echo apply_filters( 'woocommerce_reset_password_message', __( 'Enter a new password below.', 'eclat') ); ?></p>

	<div class="uk-grid uk-grid-medium">
		<div class="uk-width-medium-1-2 uk-margin-bottom">
			<div class="form-group">
				<input type="password" class="input-text form-control" name="password_1" id="password_1" />
				<label for="password_1"><?php esc_html_e( 'New password', 'eclat' ); ?> <em class="required">*</em></label>
			</div>
		</div>
		<div class="uk-width-medium-1-2 uk-margin-bottom">
			<div class="form-group">
				<input type="password" class="input-text form-control" name="password_2" id="password_2" />
				<label for="password_2"><?php esc_html_e( 'Re-enter new password', 'eclat' ); ?> <em class="required">*</em></label>
			</div>
		</div>
	</div>

	<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
	<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

	<div class="clear"></div>

	<?php do_action( 'woocommerce_resetpassword_form' ); ?>

	<p class="woocommerce-FormRow form-row">
		<input type="hidden" name="wc_reset_password" value="true" />
		<input type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Save', 'eclat' ); ?>" />
	</p>

	<?php wp_nonce_field( 'reset_password' ); ?>

</form>
