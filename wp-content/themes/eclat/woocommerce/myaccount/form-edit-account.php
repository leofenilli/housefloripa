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
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

    <div class="uk-grid">
        <div class="uk-width-medium-1-2">
            <p class="form-row form-row-wide">
                <label for="account_first_name"><?php esc_html_e( 'First name', 'eclat' ); ?> <span class="required">*</span></label>
                <input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
            </p>
        </div>
        <div class="uk-width-medium-1-2">
            <p class="form-row form-row-wide">
                <label for="account_last_name"><?php esc_html_e( 'Last name', 'eclat' ); ?> <span class="required">*</span></label>
                <input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
            </p>
        </div>
    </div>
    <div class="uk-clearfix">
        <p class="form-row form-row-wide">
            <label for="account_email"><?php esc_html_e( 'Email address', 'eclat' ); ?> <span class="required">*</span></label>
            <input type="email" class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
        </p>

        <p class="form-row form-row-wide">
            <label for="password_current"><?php esc_html_e( 'Current Password (leave blank to leave unchanged)', 'eclat' ); ?></label>
            <input type="password" class="input-text" name="password_current" id="password_current" />
        </p>
        <p class="form-row form-row-wide">
            <label for="password_1"><?php esc_html_e( 'New Password (leave blank to leave unchanged)', 'eclat' ); ?></label>
            <input type="password" class="input-text" name="password_1" id="password_1" />
        </p>
        <p class="form-row form-row-wide">
            <label for="password_2"><?php esc_html_e( 'Confirm New Password', 'eclat' ); ?></label>
            <input type="password" class="input-text" name="password_2" id="password_2" />
        </p>

        <?php do_action( 'woocommerce_edit_account_form' ); ?>
    </div>

    <p>
        <?php wp_nonce_field( 'save_account_details' ); ?>
        <input type="submit" class="button" name="save_account_details" value="<?php esc_html_e( 'Save changes', 'eclat' ); ?>" />
        <input type="hidden" name="action" value="save_account_details" />
    </p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
