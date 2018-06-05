<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

class Warp_Woocommerce_Cart extends WP_Widget
{
    public function Warp_Woocommerce_Cart()
    {
        $widget_ops = array('classname' => 'woocommerce widget_shopping_cart widget', 'description' => esc_html__( 'Display the user Cart in the header of the page.', 'eclat' ));
        parent::__construct(false, esc_html__( 'Eclat - Woocommerce Cart', 'eclat' ), $widget_ops);
    }

    public function widget($args, $instance)
    {
        global $woocommerce, $warp;

        extract( $args );

        $active = (bool) !( empty( $_REQUEST['add-to-cart'] ) || ! is_numeric( $_REQUEST['add-to-cart'] ) );

        if( !eclat_is_shop_installed() ) return;

        echo $before_widget;

        ?>
        <div class="ajax-product-added">
            <span class="tm-icon-check"></span><span><?php esc_html_e( 'Product added', 'eclat' );?></span>
        </div>

	    <?php if( $warp['config']->get('woo_use_as_catalogue') != '1' ) { ?>
        <div class="tm_cart_widget widget_cart">
            <div class="tm_cart_label uk-clearfix <?php echo $active ? ' active' : ''; ?>">
                <a href="<?php echo WC()->cart->get_cart_url(); ?>" class="hover-icon cart_ajax_data">
                    <span class="tm-icon-cart"></span>
                    <span class="uk-hidden-small"><?php esc_html_e( 'Cart', 'eclat' ); ?> </span>
                    <span class="total_products"><strong><?php echo WC()->cart->get_cart_contents_count(); ?></strong></span>
                    <span class="subtotal"><strong><?php echo WC()->cart->get_cart_subtotal(); ?></strong></span>
                </a>
                <span class="tm-icon-arrow-down"></span>
            </div>

            <div class="tm_cart_wrapper<?php echo $active ? ' active' : ''; ?>" style="display:<?php echo $active ? 'block' : 'none'; ?>">
                <div class="widget_shopping_cart_content group">
                    <?php if ( $active ) : ?>
                        <div class="mini-cart-block" style="min-height: 50px">
                            <div class="blockUI blockOverlay" style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; cursor: none; position: absolute; opacity: 1;"></div>
                        </div>
                    <?php else : ?>
                        <div class="mini-cart-block">
                            <p><?php esc_html_e( 'No products in the cart.', 'eclat' ); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
	    <?php } ?>

        <?php if( $warp['config']->get('woo_product_wishlist_enabled') == '1' ) { ?>
        <div class="tm_wishlist_widget widget_whishlist">
            <a href="<?php echo eclat_get_wishlist_link(); ?>" class="hover-icon" data-title="<?php esc_html_e( 'Browse Wishlist', 'eclat' ); ?>">
                <span class="tm-icon-heart"></span>
                <span class="tm-label"><?php esc_html_e( 'Wishlist', 'eclat' ); ?> </span>
                <span><strong id="wish-list-num"><?php echo count(eclat_get_wishlist_product_id()); ?></strong></span>
            </a>
        </div>
        <?php } ?>

        <?php if( $warp['config']->get('woo_product_compare_enabled') == '1' ) { ?>
        <div class="tm_compare_widget widget_compare">
            <a href="<?php echo eclat_get_compare_link(); ?>" class="hover-icon" data-title="<?php esc_html_e( 'Browse Compare', 'eclat' ); ?>">
                <span class="tm-icon-compare"></span>
                <span class="tm-label"><?php esc_html_e( 'Compare', 'eclat' ); ?> </span>
                <span><strong id="compare-num"><?php echo count(eclat_get_compare_product_id()); ?></strong></span>
            </a>
        </div>
        <?php } ?>

        <?php

        echo $after_widget;

    }

    public function form($instance)
    {
        ?><p><?php esc_html_e('Display a dropdown cart for your WooCommerce store.', 'eclat') ?></p><?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance['title'] = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['hide_if_empty'] = empty( $new_instance['hide_if_empty'] ) ? 0 : 1;
        return $instance;
    }
}

register_widget('Warp_Woocommerce_Cart');

