<?php

// [recent_products_slider]
function recent_products_slider_shortcode($params = array())
{
    extract(shortcode_atts(array(
        'items' => '10',
        'orderby' => 'date',
        'order' => 'desc',
        'grid' => 'uk-grid uk-grid-medium',
        'row_large_items' => '4',
        'row_medium_items' => '3',
        'row_small_items' => '2',
        'row_items' => '1'
    ), $params));

    $class = 'uk-slider';

    if($grid != "no") $class .= ' '.$grid;

    $markup = '<div class="uk-position-relative" data-uk-slider>
            <div class="uk-slider-container woocommerce">
                <ul class="' . $class . ' uk-grid-width-1-' . $row_items . ' uk-grid-width-small-1-' . $row_small_items . ' uk-grid-width-medium-1-' . $row_medium_items . ' uk-grid-width-large-1-' . $row_large_items . ' product_list_widget">
                    '. eclat_shortcode_get_product_in_products_slider( 'recent_products', $items, $orderby, $order ).'
                </ul>
            </div>
            <a href="" class="uk-slidenav-arrow uk-slidenav-arrow-previous" data-uk-slider-item="previous"></a>
            <a href="" class="uk-slidenav-arrow uk-slidenav-arrow-next" data-uk-slider-item="next"></a>
        </div>';

    return $markup;
}

add_shortcode('recent_products_slider', 'recent_products_slider_shortcode');