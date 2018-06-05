<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
    ?>
	<div class="thumbnails">
        <div class="uk-slidenav-position">
            <div class="uk-slider-container">
                <?php

                if ( has_post_thumbnail() ) {

                    $image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
                    $image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
                    $image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
                    $image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
                        'title'	=> $image_title,
                        'alt'	=> $image_title
                    ) );

                    echo '<div>'.apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="uk-active" title="%s">%s</a>', $image_link, $image_caption, $image ), get_post_thumbnail_id(), $post->ID ).'</div>';

                }

                foreach ( $attachment_ids as $attachment_id ) {

                    $image_link = wp_get_attachment_url( $attachment_id );

                    if ( ! $image_link )
                        continue;

                    $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
                    $image_title = esc_attr( get_the_title( $attachment_id ) );

                    echo '<div>'.apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" title="%s">%s</a>', $image_link, $image_title, $image ), $attachment_id, $post->ID ).'</div>';

                }

                ?>
            </div>
        </div>
    </div>
	<?php
}
