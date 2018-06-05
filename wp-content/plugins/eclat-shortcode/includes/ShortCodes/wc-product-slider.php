<?php

// [wc_product_slider]
function wc_product_slider_shortcode( $params = array() )
{
    extract( shortcode_atts( array(
        'title'     => null,
        'number'     => 10,
        'product'    => 'sale_products',
        'slider'     => 'default',
        'grid'       => 'uk-grid uk-grid-medium',
        'row_xlarge_items' => '5',
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

    ob_start();

    switch( $product ) {

        case 'best_selling':
            echo eclat_shortcode_get_product_in_products_slider( 'best_selling', $number, 'rand', 'desc', 'slider-product' );

            break;

        case 'recent_products':
            echo eclat_shortcode_get_product_in_products_slider( 'recent_products', $number, 'date', 'desc', 'slider-product' );

            break;

        case 'top_rated':
            echo eclat_shortcode_get_product_in_products_slider( 'top_rated', $number, 'title', 'desc', 'slider-product' );

            break;

        case 'sale_products':
            echo eclat_shortcode_get_product_in_products_slider( 'sale_products', $number, 'date', 'desc', 'slider-product' );

            break;

        case 'featured_products':
            echo eclat_shortcode_get_product_in_products_slider( 'featured_products', $number, 'date', 'desc', 'slider-product' );

            break;

        default: break;
    }

    if($slider == 'default') {

        $class = 'uk-slideset';

        if ($grid != "no") $class .= ' ' . $grid;

        return '<div class="uk-overflow-hidden tm-slider-block">'.($title ? '<h2>'.$title.'</h2>' : '').'<div class="tm-products-slider" data-uk-slideset="{default: ' . $row_items . ', small: ' . $row_small_items . ', medium: ' . $row_medium_items . ', large: ' . $row_large_items . ', xlarge: ' . $row_xlarge_items . ', animation: \'' . $animation . '\', duration: 200, autoplay: ' . $autoplay . ', pauseOnHover: ' . $pause . ', autoplayInterval: ' . $autoplayinterval . '}">
            <div class="uk-slidenav-position">
                <ul class="' . $class . '">' . ob_get_clean() . '</ul>
                <a class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous" href="#"></a>
                <a class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next" href="#"></a>
            </div>
            <ul class="uk-slideset-nav uk-dotnav uk-flex-center"></ul>
        </div></div>';
    } else {
        $slider_param = 'data-owl-slideset="{default: ' . $row_items . ', small: ' . $row_small_items . ', medium: ' . $row_medium_items . ', large: ' . $row_large_items . ', xlarge: ' . $row_xlarge_items . ', animation: \'' . $animation_owl . '\', autoplay: ' . $autoplay . ', pauseOnHover: ' . $pause . ', autoplayInterval: ' . $autoplayinterval . '}"';

        return '<div class="uk-overflow-hidden tm-slider-block">'.($title ? '<h2>'.$title.'</h2>' : '').'<div class="tm-products-slider">
            <div class="uk-slidenav-position owl-slider-wrap">
                <div class="owl-product-slider" '.$slider_param.'>' . str_replace(array('<li', '</li>'), array('<div', '</div>'), ob_get_clean()) . '</div>
            </div>
        </div></div>';
    }
}

add_shortcode("wc_product_slider", "wc_product_slider_shortcode");

