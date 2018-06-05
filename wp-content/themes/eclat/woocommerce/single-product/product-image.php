<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

$attachment_count = 0;
?>
<div class="images">
    <div class="tm-main-images-slider main-images">
        <div class="uk-slidenav-position">
            <div class="uk-slider-container">
                <?php
                    if ( has_post_thumbnail() ) {

                        $image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
                        $image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
                        $image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
                        $image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                            'title'	=> $image_title,
                            'alt'	=> $image_title
                            ) );

                        $attachment_ids = $product->get_gallery_attachment_ids();
                        $attachment_count = count( $attachment_ids );

                        if ( $attachment_count > 0 ) {
                            $gallery = "{group:'product-gallery'}";
                        } else {
                            $gallery = '';
                        }

                        echo '<div>'.apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom-product-image" data-o_href="%s" title="%s" data-uk-lightbox="' . $gallery . '">%s</a>', $image_link, $image_link, $image_caption, $image ), $post->ID ).'<span class="tm-icon-zoom"></span></div>';

                        foreach ( $attachment_ids as $attachment_id ) {

                            $image_link = wp_get_attachment_url( $attachment_id );

                            if ( ! $image_link )
                                continue;

                            $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
                            $image_title = esc_attr( get_the_title( $attachment_id ) );

                            echo '<div>'.apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-additional-image zoom-product-image" title="%s" data-uk-lightbox="' . $gallery . '">%s</a>', $image_link, '', $image ), $post->ID ).'<span class="tm-icon-zoom"></span></div>';
                        }

                    } else {

                        echo '<div>'.apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'eclat' ) ), $post->ID ).'</div>';

                    }
                ?>
            </div>
        </div>
    </div>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
