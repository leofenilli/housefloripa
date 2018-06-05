<?php
/**
 * Shipping Calculator
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() ) {
	return;
}

?>

<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

	<section class="shipping-calculator-form" style="display:none;">

        <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) && apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) :
                $width_large = "1-5";
            elseif( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) || apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) :
                $width_large = "1-4";
            else :
                $width_large = "1-3";
        endif; ?>

        <div class="uk-grid uk-grid-medium">
            <div class="uk-width-1-1 uk-width-large-<?php echo $width_large; ?>">
                <div class="form-row form-row-wide" id="calc_shipping_country_field">
                    <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state chosen" rel="calc_shipping_state">
                        <option value=""><?php esc_html_e( 'Select a country&hellip;', 'eclat' ); ?></option>
                        <?php
                        foreach( WC()->countries->get_shipping_countries() as $key => $value )
                            echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
                        ?>
                    </select>
                </div>
            </div>
            <div class="uk-width-1-1 uk-width-large-<?php echo $width_large; ?>">
                <div class="form-row form-row-wide" id="calc_shipping_state_field">
                    <?php
                    $current_cc = WC()->customer->get_shipping_country();
                    $current_r  = WC()->customer->get_shipping_state();
                    $states     = WC()->countries->get_states( $current_cc );

                    // Hidden Input
                    if ( is_array( $states ) && empty( $states ) ) {

                        ?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_html_e( 'State / county', 'eclat' ); ?>" /><?php

                        // Dropdown Input
                    } elseif ( is_array( $states ) ) {

                        ?><span>
                        <select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_html_e( 'State / county', 'eclat' ); ?>">
                            <option value=""><?php esc_html_e( 'Select a state&hellip;', 'eclat' ); ?></option>
                            <?php
                            foreach ( $states as $ckey => $cvalue )
                                echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . $cvalue .'</option>';
                            ?>
                        </select>
                        </span><?php

                        // Standard Input
                    } else {

                        ?><input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_html_e( 'State / county', 'eclat' ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php

                    }
                    ?>
                </div>
            </div>
            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>
            <div class="uk-width-1-1 uk-width-large-<?php echo $width_large; ?>">
                <div class="form-row form-row-wide" id="calc_shipping_city_field">
                    <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_html_e( 'City', 'eclat' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
                </div>
            </div>
            <?php endif; ?>

            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>
            <div class="uk-width-1-1 uk-width-large-<?php echo $width_large; ?>">
                <div class="form-row form-row-wide" id="calc_shipping_postcode_field">
                    <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_html_e( 'Postcode / Zip', 'eclat' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
                </div>
            </div>
            <?php endif; ?>

            <div class="uk-width-1-1 uk-width-large-<?php echo $width_large; ?> uk-text-center">
                <div class="form-row form-row-wide">
                    <button type="submit" name="calc_shipping" value="1" class="button"><?php esc_html_e( 'Update Totals', 'eclat' ); ?></button>
                </div>
            </div>
        </div>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	</section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
