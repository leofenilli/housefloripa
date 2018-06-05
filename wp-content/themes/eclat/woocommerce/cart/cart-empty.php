<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>
<div class="uk-text-center">
    <div class="cart-empty-icon"><span class="tm-icon-empty-cart"></span></div>

    <p class="cart-empty">
        <?php esc_html_e( 'Your cart is currently empty.', 'eclat' ) ?>
    </p>

    <?php do_action( 'woocommerce_cart_is_empty' ); ?>

    <div class="return-to-shop">
        <a class="button alt wc-backward" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ); ?>">
            <?php esc_html_e( 'Return To Shop', 'eclat' ) ?>
            <span class="tm-icon-back"></span>
        </a>
    </div>
</div>
