<?php

// [product_categories_grid]
function product_categories_grid_shortcode( $params = array() )
{
    extract( shortcode_atts( array(
        'number'     => null,
        'orderby'    => 'date',
        'order'      => 'desc',
        'hide_empty' => 1,
        'parent'     => '',
        'gutter' => '20'
    ), $params ) );

    if ( isset( $params[ 'ids' ] ) ) {
        $ids = explode( ',', $params[ 'ids' ] );
        $ids = array_map( 'trim', $ids );
    } else {
        $ids = array();
    }

    if( $hide_empty == true || $hide_empty == 1 ) {
        $hide_empty = 1;
    } else {
        $hide_empty = 0;
    }

    $args = array(
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
        'include'    => $ids,
        'pad_counts' => true,
        'child_of'   => $parent
    );

    $product_categories = get_terms( 'product_cat', $args );

    if ( $parent !== "" ) {
        $product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
    }

    if ( $hide_empty ) {
        foreach ( $product_categories as $key => $category ) {
            if ( $category->count == 0 ) {
                unset( $product_categories[ $key ] );
            }
        }
    }

    if ( $number ) {
        $product_categories = array_slice( $product_categories, 0, $number );
    }

    ob_start();

    if ( $product_categories )
    {
        $cat_counter = 0;
        $banner_counter = 0;
        $separate_bannner = array();

        foreach ( $product_categories as $category )
        {
            $cat_counter++;
            $banner_counter++;

            $topimage_id = get_woocommerce_term_meta( $category->term_id, 'topimage_id', true );
            $topimage_url = get_woocommerce_term_meta( $category->term_id, 'topimage_url', true );
            $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
            $image = wp_get_attachment_url( $thumbnail_id );

            if($topimage_id)
            {
                $topimage = wp_get_attachment_url($topimage_id);

                $separate_bannner[] = '<div class="uk-width-1-1">' . ( $topimage_url ? '<a href="'.esc_url($topimage_url).'">' : '' ) . '<img src="' . $topimage . '" alt="" />' . ( $topimage_url ? '</a>' : '' ) . '</div>';
            }

            switch ($cat_counter) {
                case 1:
                    $cat_class = "uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2";
                    break;
                case 6:
                    $cat_class = "uk-width-1-1 uk-width-small-1-1 uk-width-medium-1-2";
                    $cat_counter = 0;
                    break;
                default:
                    $cat_class = "uk-width-1-1 uk-width-small-1-2 uk-width-medium-1-4";
            }
            ?>

            <div class="<?php echo $cat_class; ?>">
                <div class="tm-category-box">
                    <span class="tm-category-item-background" style="background-image:url(<?php echo esc_url($image); ?>)"></span>
                    <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="tm-category-item" >
                        <span class="tm-category-name"><?php echo esc_html($category->name); ?></span>
                    </a>
                </div>
            </div>

        <?php
            if($cat_counter == 0 && count($separate_bannner) && $banner_counter < count($product_categories)){
                $banner_key = rand(0,count($separate_bannner)-1);
                echo $separate_bannner[$banner_key];
                unset($separate_bannner[$banner_key]);
            }
        }
    }

    return '<div class="tm-categories-grid">
        <div class="uk-slidenav-position">
            <div data-uk-grid="{gutter: '.$gutter.'}">' .
                ob_get_clean() .
            '</div>
        </div>
    </div>';
}

add_shortcode("product_categories_grid", "product_categories_grid_shortcode");

