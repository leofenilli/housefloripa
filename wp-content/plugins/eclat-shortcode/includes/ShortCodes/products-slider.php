<?php

// [products_slider]

function products_slider_shortcode($params = array())
{
    extract(shortcode_atts(array(
        'best_selling_products' => '',
        'best_selling_products_title' => '',
        'best_selling_products_items' => '10',
        'recent_products' => '',
        'recent_products_title' => '',
        'recent_products_items' => '10',
        'recent_products_orderby' => 'date',
        'recent_products_order' => 'desc',
        'top_rated_products' => '',
        'top_rated_products_title' => '',
        'top_rated_products_items' => '10',
        'top_rated_products_orderby' => 'title',
        'top_rated_products_order' => 'desc',
        'sale_products' => '',
        'sale_products_title' => '',
        'sale_products_items' => '10',
        'sale_products_orderby' => 'title',
        'sale_products_order' => 'desc',
        'featured_products' => '',
        'featured_products_title' => '',
        'featured_products_items' => '10',
        'featured_products_orderby' => 'date',
        'featured_products_order' => 'desc'
    ), $params));

    ?>
    <div class="uk-grid">
        <div class="woocommerce uk-width-medium-1-1">
            <ul data-uk-switcher="{connect:'#products_slider', animation: 'scale'}">
                <?php if($best_selling_products == "yes") : ?>
                <li><a href=""><?php echo esc_html($best_selling_products_title) ?></a></li>
                <?php endif; ?>
                <?php if($recent_products == "yes") : ?>
                <li><a href=""><?php echo esc_html($recent_products_title) ?></a></li>
                <?php endif; ?>
                <?php if($top_rated_products == "yes") : ?>
                <li><a href=""><?php echo esc_html($top_rated_products_title) ?></a></li>
                <?php endif; ?>
                <?php if($sale_products == "yes") : ?>
                <li><a href=""><?php echo esc_html($sale_products_title) ?></a></li>
                <?php endif; ?>
                <?php if($featured_products == "yes") : ?>
                <li><a href=""><?php echo esc_html($featured_products_title) ?></a></li>
                <?php endif; ?>
            </ul>

            <ul id="products_slider" class="uk-switcher">
            <?php if($best_selling_products == "yes") : ?>
                <li data-uk-slider>
                    <div class="uk-slider-container">
                        <?php echo eclat_shortcode_get_product_in_products_slider( 'best_selling', $best_selling_products_items ); ?>
                    </div>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                </li>
            <?php endif; ?>
            <?php if($recent_products == "yes") : ?>
                <li data-uk-slider>
                    <div class="uk-slider-container">
                        <?php echo eclat_shortcode_get_product_in_products_slider( 'recent_products', $recent_products_items, $recent_products_orderby, $recent_products_order ); ?>
                    </div>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                </li>
            <?php endif; ?>
            <?php if($top_rated_products == "yes") : ?>
                <li data-uk-slider>
                    <div class="uk-slider-container">
                        <?php echo eclat_shortcode_get_product_in_products_slider( 'top_rated', $top_rated_products_items, $top_rated_products_orderby, $top_rated_products_order ); ?>
                    </div>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                </li>
            <?php endif; ?>
            <?php if($sale_products == "yes") : ?>
                <li data-uk-slider>
                    <div class="uk-slider-container">
                        <?php echo eclat_shortcode_get_product_in_products_slider( 'sale_products', $sale_products_items, $sale_products_orderby, $sale_products_order ); ?>
                    </div>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                </li>
            <?php endif; ?>
            <?php if($featured_products == "yes") : ?>
                <li data-uk-slider>
                    <div class="uk-slider-container">
                        <?php echo eclat_shortcode_get_product_in_products_slider( 'featured_products', $featured_products_items, $featured_products_orderby, $featured_products_order ); ?>
                    </div>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </div>
<?php }

add_shortcode('products_slider', 'products_slider_shortcode');