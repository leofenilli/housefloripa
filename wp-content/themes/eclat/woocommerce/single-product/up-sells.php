<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $warp;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) {
	return;
}

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

if($warp['config']->get('show_sidebar')) {
    $class = 'uk-grid-width-1-1 uk-grid-width-small-1-2 uk-grid-width-medium-1-3';
} else {
    $class = 'uk-grid-width-1-1 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4';
}

if ( $products->have_posts() ) : ?>

	<div class="upsells_products">

		<h2 class="uk-tab-title"><?php esc_html_e( 'You may also like&hellip;', 'eclat' ) ?></h2>
        <div id="related-products-slider" class="uk-position-relative" data-uk-slider="{infinite: false}">
            <div class="uk-slider-container">
                <ul class="uk-slider uk-grid uk-grid-medium <?php echo $class; ?> product_list_widget">

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>


                </ul>
            </div>
            <a href="" class="uk-slidenav-arrow uk-slidenav-arrow-previous" data-uk-slider-item="previous"></a>
            <a href="" class="uk-slidenav-arrow uk-slidenav-arrow-next" data-uk-slider-item="next"></a>
        </div>
    </div>
<?php endif;

wp_reset_postdata();
