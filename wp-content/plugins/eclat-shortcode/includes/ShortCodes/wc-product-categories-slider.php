<?php

// [product_categories_slider]
function product_categories_slider_shortcode( $params = array() )
{
    extract( shortcode_atts( array(
        'number'     => null,
        'orderby'    => 'date',
        'order'      => 'desc',
        'hide_empty' => 1,
        'parent'     => '',
        'slider'     => 'default',
        'grid'       => 'uk-grid uk-grid-medium',
        'row_large_items' => '4',
        'row_medium_items' => '3',
        'row_small_items' => '2',
        'row_items'  => '1',
        'animation'  => 'scale',
        'animation_owl' => 'fade',
        'autoplay'   => 'false',
        'pause'      => 'true',
        'autoplayinterval' => '7000'
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
        foreach ( $product_categories as $category )
        {
            $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
            $image = wp_get_attachment_url( $thumbnail_id );
            ?>

            <?php if($slider == 'default') { ?><li><?php } ?>
                <div class="tm-category-box">
                    <span class="tm-category-item-background" style="background-image:url(<?php echo esc_url($image); ?>)"></span>
                    <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="tm-category-item" >
                        <span class="tm-category-name"><?php echo esc_html($category->name); ?></span>
                    </a>
                </div>
            <?php if($slider == 'default') { ?></li><?php } ?>

        <?php
        }
    }

    if($slider == 'default') {

        $class = 'uk-slideset';

        if ($grid != "no") $class .= ' ' . $grid;

        return '<div class="tm-categories-slider" data-uk-slideset="{default: ' . $row_items . ', small: ' . $row_small_items . ', medium: ' . $row_medium_items . ', large: ' . $row_large_items . ', animation: \'' . $animation . '\', duration: 200, autoplay: ' . $autoplay . ', pauseOnHover: ' . $pause . ', autoplayInterval: ' . $autoplayinterval . '}">
            <div class="uk-slidenav-position">
                <ul class="' . $class . '">' . ob_get_clean() . '</ul>
            </div>
            <ul class="uk-slideset-nav uk-dotnav uk-flex-center"></ul>
        </div>';
    } else {
        $slider_param = 'data-owl-slideset="{default: ' . $row_items . ', small: ' . $row_small_items . ', medium: ' . $row_medium_items . ', large: ' . $row_large_items . ', animation: \'' . $animation_owl . '\', autoplay: ' . $autoplay . ', pauseOnHover: ' . $pause . ', autoplayInterval: ' . $autoplayinterval . '}"';

        return '<div class="tm-categories-slider">
            <div class="uk-slidenav-position owl-slider-wrap">
                <div class="owl-product-categories-slider" '.$slider_param.'>' . ob_get_clean() . '</div>
            </div>
        </div>';
    }
}

add_shortcode("product_categories_slider", "product_categories_slider_shortcode");

