<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! WC()->cart->coupons_enabled() ) {
	return;
}

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'eclat' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'eclat' ) . '</a>' );
wc_print_notice( $info_message, 'notice' );
?>

<form class="checkout_coupon" method="post" style="display:none">

    <div class="uk-grid uk-margin-large-bottom" data-uk-grid-margin>
        <div class="uk-width-1-2 uk-width-medium-2-3 uk-width-large-1-2">
            <div class="form-group">
                <input type="text" name="coupon_code" class="input-text form-control" id="coupon_code" value="" />
                <label for="coupon_code"><?php esc_html_e( 'Coupon code', 'eclat' ); ?></label>
            </div>
        </div>

        <div class="uk-width-1-2 uk-width-medium-1-3 uk-width-large-1-2">
            <input type="submit" class="button" name="apply_coupon" value="<?php esc_html_e( 'Apply Coupon', 'eclat' ); ?>" />
        </div>
    </div>
</form>
