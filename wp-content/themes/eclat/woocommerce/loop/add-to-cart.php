<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $warp;

$link = array(
	'url'      => '',
	'label'    => '',
	'class'    => '',
	'icon'    => '',
	'quantity' => 1
);
?>

<div class="uk-flex uk-flex-middle uk-flex-space-between">

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
        <a class="hover-icon one<?php echo $compare_class; ?>" title="<?php echo $compare_text; ?>" href="<?php echo $compare_href; ?>" data-product_id="<?php echo $product->id; ?>" data-uk-tooltip="{animation:'true'}">
            <span class="tm-icon-compare"></span>
        </a>
        <span class="tm-cart-sep"></span>
    <?php } ?>

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
        <a class="hover-icon two<?php echo $wishlist_class; ?>" title="<?php echo $wishlist_text; ?>" href="<?php echo $wishlist_href; ?>" data-product_id="<?php echo $product->id; ?>" data-uk-tooltip="{animation:'true'}">
            <span class="tm-icon-heart"></span>
        </a>
        <span class="tm-cart-sep"></span>
    <?php } ?>

	<?php if( $warp['config']->get('woo_use_as_catalogue') == '1' )
	{
		$link['url']   = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
		$link['label'] = apply_filters( 'external_add_to_cart_text', esc_html__( 'Read More', 'eclat' ) );
		$link['icon'] = apply_filters( 'external_add_to_cart_icon', 'tm-icon-read-more' );

		echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="hover-icon three %s product_type_%s"><span class="%s uk-margin-small-right"></span><span>%s</span></a>',
				esc_url( $link['url'] ),
				esc_attr( $product->id ),
				esc_attr( $product->get_sku() ),
				esc_attr( $link['quantity'] ),
				esc_attr( $link['class'] ),
				esc_attr( $product->product_type ),
				esc_attr( $link['icon'] ),
				esc_html( $link['label'] ) ),
			$product,
			$link
		);
	} else { ?>
	    <?php if ( !$product->is_in_stock() ) { ?>
	        <a href="<?php echo apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ); ?>" class="hover-icon three out-of-stock">
	            <span class="tm-icon-empty-cart uk-margin-small-right"></span>
	            <span><?php echo apply_filters( 'out_of_stock_add_to_cart_text', esc_html__( 'Out Of Stock', 'eclat' ) ); ?></span>
	        </a>
	    <?php } else {
	        $handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );

	        switch ( $handler ) {
	            case "variable" :
	                $link['url']   = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
	                $link['label'] = apply_filters( 'variable_add_to_cart_text', esc_html__( 'Set options', 'eclat' ) );
	                $link['icon'] = apply_filters( 'variable_add_to_cart_icon', 'tm-icon-select-cart-option' );
	                break;
	            case "grouped" :
	                $link['url']   = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
	                $link['label'] = apply_filters( 'grouped_add_to_cart_text', esc_html__( 'View options', 'eclat' ) );
	                $link['icon'] = apply_filters( 'grouped_add_to_cart_icon', 'tm-icon-select-cart-option' );
	                break;
	            case "external" :
	                $link['url']   = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
	                $link['label'] = apply_filters( 'external_add_to_cart_text', esc_html__( 'Read More', 'eclat' ) );
	                $link['icon'] = apply_filters( 'external_add_to_cart_icon', 'tm-icon-read-more' );
	                break;
	            default :
	                if ( $product->is_purchasable() ) {
	                    $link['url']      = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
	                    $link['label']    = apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'eclat' ) );
	                    $link['class']    = apply_filters( 'add_to_cart_class', 'add_to_cart_button ajax_add_to_cart' );
	                    $link['icon']    = apply_filters( 'add_to_cart_icon', 'tm-icon-cart' );
	                    $link['quantity'] = apply_filters( 'add_to_cart_quantity', ( isset( $quantity ) ? $quantity : 1 ) );
	                }
	                else {
	                    $link['url']   = apply_filters( 'not_purchasable_url', get_permalink( $product->id ) );
	                    $link['label'] = apply_filters( 'not_purchasable_text', esc_html__( 'Read More', 'eclat' ) );
	                    $link['icon'] = apply_filters( 'not_purchasable_icon', 'tm-icon-read-more' );
	                }
	                break;
	        }

	        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="hover-icon three %s product_type_%s"><span class="%s uk-margin-small-right"></span><span>%s</span></a>',
	                esc_url( $link['url'] ),
	                esc_attr( $product->id ),
	                esc_attr( $product->get_sku() ),
	                esc_attr( $link['quantity'] ),
	                esc_attr( $link['class'] ),
	                esc_attr( $product->product_type ),
	                esc_attr( $link['icon'] ),
	                esc_html( $link['label'] ) ),
	            $product,
	            $link
	        );
	    } ?>
	<?php } ?>
</div>

