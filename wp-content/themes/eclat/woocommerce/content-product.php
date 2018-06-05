<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Extra post classes
$classes = array();
$classes[] = "tm-product";
$classes[] = isset($_COOKIE['shop_view_cookie']) ? $_COOKIE['shop_view_cookie'] : 'grid';;

?>
<li <?php post_class( $classes ); ?>>

    <div class="tm-product-spacer">
        <a href="<?php the_permalink(); ?>">

            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action( 'woocommerce_before_shop_loop_item_title' );
            ?>

        </a>
        <?php do_action( 'woocommerce_quick_view_link' ); ?>
        <div class="tm-product-button-line">
            <?php

            /**
             * woocommerce_after_shop_loop_item hook
             *
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action( 'woocommerce_after_shop_loop_item' );

            ?>
        </div>
    </div>

    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    <h3>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>

    <?php
    /**
     * woocommerce_after_shop_loop_item_title hook
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action( 'woocommerce_after_shop_loop_item_title' );
    ?>

    <div class="tm-list-content">
        <p>
            <?php if ( isset($product->post->post_excerpt) && $product->post->post_excerpt ) {
                echo strip_tags(str_replace('</', ' </', $product->post->post_excerpt));
            } ?>
        </p>
        <a class="animate-border" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'eclat' ); ?></a>
    </div>
    <?php do_action( 'woocommerce_product_countdown' ); ?>
</li>
