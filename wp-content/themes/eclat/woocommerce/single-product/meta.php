<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $warp;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product-button-block">

    <?php if( $warp['config']->get('woo_product_wishlist_enabled') == '1' ) {
        $wishlist_class = '';

        if( in_array($product->id, eclat_get_wishlist_product_id()) ) {
            $wishlist_text = apply_filters( 'wish_list_view_text', esc_html__( 'Browse Wishlist', 'eclat' ) );
            $wishlist_href = eclat_get_wishlist_link();
            $wishlist_class = ' added';
        } else {
            $wishlist_text = apply_filters( 'wish_list_view_text', esc_html__( 'Add to Wishlist', 'eclat' ) );
            $wishlist_class = ' add_wish_list';
            $wishlist_href = '#';
        }
        ?>
        <div class="uk-margin-bottom">
            <a class="hover-icon two<?php echo $wishlist_class; ?>" title="<?php echo $wishlist_text; ?>" href="<?php echo $wishlist_href; ?>" data-product_id="<?php echo $product->id; ?>">
                <span class="tm-icon-heart"></span>
                <span class="title"><?php echo $wishlist_text; ?></span>
            </a>
        </div>
    <?php } ?>

    <?php if( $warp['config']->get('woo_product_compare_enabled') == '1' ) {
        $compare_class = '';

        if( in_array($product->id, eclat_get_compare_product_id()) ) {
            $compare_text = apply_filters( 'compare_view_text', esc_html__( 'Browse Compare', 'eclat' ) );
            $compare_href = eclat_get_compare_link();
            $compare_class = ' added';
        } else {
            $compare_text = apply_filters( 'compare_view_text', esc_html__( 'Add to Compare', 'eclat' ) );
            $compare_class = ' add_compare';
            $compare_href = '#';
        }
        ?>
        <div class="uk-margin-bottom">
            <a class="hover-icon one<?php echo $compare_class; ?>" title="<?php echo $compare_text; ?>" href="<?php echo $compare_href; ?>" data-product_id="<?php echo $product->id; ?>">
                <span class="tm-icon-compare"></span>
                <span class="title"><?php echo $compare_text; ?></span>
            </a>
        </div>
    <?php } ?>

</div>

<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php //echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'eclat' ) . ' ', '.</span>' ); ?>

	<?php //echo $product->get_tags( '', '<div class="uk-article-tag"><span class="tm-icon-tag"></span>' . _n( 'Tag:', 'Tags:', $tag_count, 'eclat' ) . ' ', '</div>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>

<?php
if(!eclat_is_quick_view()) {
    eclat_get_social_share('tm-svg-socials', array('envelope-o', 'pinterest-p', 'google-plus', 'twitter', 'facebook'), true);
}
?>
