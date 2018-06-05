<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $warp;

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php eclat_is_quick_view() ? post_class('product') : post_class(); ?>>
    <div class="uk-grid">
        <div class="uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-2-5 uk-width-xlarge-1-2 uk-position-relative">
            <?php
            /**
             * woocommerce_before_single_product_summary hook
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action( 'woocommerce_before_single_product_summary' );
            ?>
        </div>
        <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-3-5 uk-width-xlarge-1-2">

            <?php if($warp['widgets']->count('product-sidebar') && !eclat_is_quick_view()) { ?>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-width-small-2-3 uk-width-medium-1-1 uk-width-large-2-3">
                        <?php } ?>
                        <div class="summary entry-summary">
                            <?php
                            /**
                             * woocommerce_single_product_summary hook
                             *
                             * @hooked woocommerce_template_single_title - 5
                             * @hooked woocommerce_template_single_rating - 10
                             * @hooked woocommerce_template_single_price - 10
                             * @hooked woocommerce_template_single_excerpt - 20
                             * @hooked woocommerce_template_single_add_to_cart - 30
                             * @hooked woocommerce_template_single_meta - 40
                             * @hooked woocommerce_template_single_sharing - 50
                             */
                            do_action( 'woocommerce_single_product_summary' );
                            ?>

                        </div><!-- .summary -->
                        <?php if($warp['widgets']->count('product-sidebar') && !eclat_is_quick_view()) { ?>
                    </div>
                    <div class="uk-width-1-1 uk-width-small-1-3 uk-hidden-medium uk-width-large-1-3">
                        <div class="tm-product-sidebar"><?php echo $warp['widgets']->render('product-sidebar'); ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
