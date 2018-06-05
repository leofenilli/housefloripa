<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

    <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
        <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-2-6">
            <?php do_action( 'woocommerce_before_cart_totals' ); ?>

            <table cellspacing="0">

                <tr class="cart-subtotal">
                    <th><?php esc_html_e( 'Subtotal', 'eclat' ); ?>:</th>
                    <td><?php wc_cart_totals_subtotal_html(); ?></td>
                </tr>

                <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                    <tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
                        <th><?php wc_cart_totals_coupon_label( $coupon ); ?>:</th>
                        <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                    <tr class="fee">
                        <th><?php echo esc_html( $fee->name ); ?>:</th>
                        <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if ( WC()->cart->tax_display_cart == 'excl' ) : ?>
                    <?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
                        <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                            <tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                                <th><?php echo esc_html( $tax->label ); ?>:</th>
                                <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr class="tax-total">
                            <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?>:</th>
                            <td><?php echo wc_cart_totals_taxes_total_html(); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

                    <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

                    <?php wc_cart_totals_shipping_html(); ?>

                    <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

                <?php elseif ( WC()->cart->needs_shipping() ) : ?>

                    <tr class="shipping">
                        <th><?php esc_html_e( 'Shipping', 'eclat' ); ?>:</th>
                        <td>
                            <p><a href="#" class="shipping-calculator-button"><?php esc_html_e( 'Calculate Shipping', 'eclat' ); ?></a></p>
                        </td>
                    </tr>

                <?php endif; ?>
                <tr class="order-total uk-hidden-large">
                    <th><?php esc_html_e( 'Total', 'eclat' ); ?>:</th>
                    <td><?php wc_cart_totals_order_total_html(); ?></td>
                </tr>

            </table>
        </div>
        <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-4-6">
            <?php if ( WC()->cart->get_cart_tax() ) : ?>
                <p><small><?php

                    $taxable_address = WC()->customer->get_taxable_address();
                    $estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
                        ? sprintf( ' (' . esc_html__( 'estimated for %s', 'eclat' ) . ')', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
                        : '';

                    printf( esc_html__( 'Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'eclat' ), $estimated_text );

                ?></small></p>
            <?php endif; ?>

            <div class="wc-proceed-to-checkout">

                <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

                <span class="order-total uk-visible-large">
                    <span><?php esc_html_e( 'Total', 'eclat' ); ?>:</span>
                    <span><?php wc_cart_totals_order_total_html(); ?></span>
                </span>

                <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

                <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

            </div>

            <?php do_action( 'woocommerce_after_cart_totals' ); ?>
        </div>
    </div>
</div>

<?php if ( is_cart() ) : ?>
    <?php woocommerce_shipping_calculator(); ?>
<?php endif; ?>