<?php
/**
 * @package   Eclat
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$theme_config = array();

// check compatibility
if (version_compare(PHP_VERSION, '5.3', '>=')) {

    // bootstrap warp
    $theme_config = require(get_template_directory().'/warp.php');
}

add_action( 'after_setup_theme', function() use ($theme_config)
{
    // set theme support
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'widgetkit' );
    add_theme_support( 'term-meta' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    if(isset($theme_config['config']) && $theme_config['config']->get('show_sidebar')) {
        add_theme_support( 'content-width', 880 );
    } else {
        add_theme_support( 'content-width', 1180 );
    }
    add_theme_support( 'post-formats', array('image', 'gallery', 'video', 'quote') );

    // set translations
    load_theme_textdomain('eclat',  get_template_directory() . '/languages');

    // post thumbnails for posts and pages
    $image_sizes = array(
        'blog_small'                            => array( 468, 468, true ),
        'blog_big'                              => array( 880, 534, true ),
        'testimonial_thumb'                     => array( 200, 200, true ),
        'team_thumb'                            => array( 468, 518, true ),
        'portfolio_big'                         => array( 1180, 758 ),
        'portfolio_small'                       => array( 590, 543, true ),
        'portfolio_thumb'                       => array( 506, 534, true )
    );

    $image_sizes = apply_filters( 'eclat_add_image_size', $image_sizes );

    foreach ( $image_sizes as $id_size => $size ) {
        add_image_size( $id_size, $size[0], $size[1], isset( $size[2] ) ? $size[2] : false );
    }
});

if(isset($theme_config['config']) && $theme_config['config']->get('show_sidebar')) {
    $content_width = 880;
} else {
    $content_width = 1180;
}

// setup the termmeta table
add_action( 'init', function()
{
    global $wpdb;
    if ( ! current_theme_supports( 'term-meta' ) )
        return false;

    eclat_create_term_meta_table();

    $wpdb->tables[] = 'termmeta';
    $wpdb->termmeta = $wpdb->prefix . 'termmeta';
});

// replace avatar class
add_filter('get_avatar', function($avatar)
{
    if(strpos($avatar, 'Avatar')!==false) {
        $avatar = str_replace('class=\'avatar', 'class=\'uk-comment-avatar', $avatar);
    }

    return $avatar;
});

// set custom title-renderer
add_filter('wp_title', function( $title, $sep )
{
    if ( is_feed() ) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo( 'name', 'display' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }

    return $title;
}, 10, 2);

// disable responsive images
if ( isset($theme_config['config']) && $theme_config['config']->get('srcset_image') == '1' ) {
    add_filter('max_srcset_image_width', create_function('', 'return 1;'));
}

// change the placeholder image
add_filter('wsl_render_auth_widget_alter_widget_css', function($widget_css){
    $widget_css = "";
    return $widget_css;
});

// Remove product in the cart using ajax
add_action( 'wp_ajax_product_remove', 'eclat_ajax_product_remove' );
add_action( 'wp_ajax_nopriv_product_remove', 'eclat_ajax_product_remove' );

// load product info
add_action( 'wp_ajax_eclat_load_product_quick_view', 'eclat_load_product_quick_view' );
add_action( 'wp_ajax_nopriv_eclat_load_product_quick_view', 'eclat_load_product_quick_view' );

// Add new fields product category form
add_action( 'product_cat_add_form_fields', 'eclat_add_category_fields', 15 );
add_action( 'product_cat_edit_form_fields', 'eclat_edit_category_fields', 15 );
add_action( 'created_term', 'eclat_save_category_fields', 15, 3 );
add_action( 'edit_term', 'eclat_save_category_fields', 15, 3 );

// woocommerce
if (class_exists('WooCommerce'))
{
    // ajax update cart info
    add_filter( 'add_to_cart_fragments', function($fragments){
        $fragments['.tm_cart_widget .tm_cart_label .cart_ajax_data .total_products'] = '<span class="total_products"><strong>' . WC()->cart->get_cart_contents_count() . '</strong></span>';
        $fragments['.tm_cart_widget .tm_cart_label .cart_ajax_data .subtotal'] = '<span class="subtotal"><strong>' . WC()->cart->get_cart_subtotal() . '</strong></span>';
        return $fragments;
    });

    // change the placeholder image
    add_filter('woocommerce_placeholder_img_src', function($src){
        $src = get_stylesheet_directory_uri().'/images/placeholder.jpg';
        return $src;
    });

    // products loop
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

    /*add_action( 'woocommerce_before_shop_loop', function()
    {
        get_template_part( 'woocommerce/global/filter-button' );
    }, 10);*/

//    add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 20 );
//    add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 30 );

    /* add_action( 'woocommerce_before_shop_loop', function()
     {
         get_template_part( 'woocommerce/global/list-or-grid' );
         get_template_part( 'woocommerce/global/number-of-products' );
     }, 40);*/

    // replace woocommerce default PayPal icon
    add_filter( 'woocommerce_paypal_icon', function()
    {
        return get_stylesheet_directory_uri().'/images/paypal_ico.png';
    });

    // shop image hover effect
    add_action('woocommerce_before_shop_loop_item_title', function()
    {
        global $product;

        $attachment_ids = $product->get_gallery_attachment_ids();

        if ( count( $attachment_ids ) > 0 ) {
            echo wp_get_attachment_image( $attachment_ids[0], 'shop_catalog', false, array('class' => 'shop-image-hover-effect'));
        }

    }, 10);

    // add product code after title
    add_action('woocommerce_single_product_summary', 'eclat_show_product_sku_after_title', 6);

    // change count related products
    add_filter( 'woocommerce_output_related_products_args', function( $args )
    {
        $args['posts_per_page'] = 10;
        $args['columns'] = 1;

        return $args;
    });

    // remove tab heading
    add_filter( 'woocommerce_product_description_heading', function()
    {
        return false;
    });
    add_filter( 'woocommerce_product_additional_information_heading', function()
    {
        return false;
    });

    // change reviews tab title
    add_filter( 'woocommerce_product_reviews_tab_title', function($title = '')
    {
        return str_replace(array('(', ')'), array('<span>(', ')</span>'), $title);
    });

    // change rating html
    add_filter( 'woocommerce_product_get_rating_html', function( $rating_html )
    {
        return str_replace('class="star-rating"', 'class="star-rating" data-uk-tooltip="{animation:true}"', $rating_html);
    });

    add_filter( 'woocommerce_enqueue_styles', function($enqueue_styles)
    {
        unset( $enqueue_styles['woocommerce-general'] );
        return $enqueue_styles;
    });

    //disable signup password strength checker
    if ( isset($theme_config['config']) && $theme_config['config']->get('woo_password_strength_enabled') == '1') {
        add_action('wp_print_scripts', function ()
        {
            if (wp_script_is('wc-password-strength-meter', 'enqueued')) {
                wp_dequeue_script('wc-password-strength-meter');
            }
        }, 100);

        add_filter( 'woocommerce_min_password_strength', function()
        {
            return 1;
        });
    }

    // add quick view add to cart variation
    if ( isset($theme_config['config']) && $theme_config['config']->get('woo_product_quick_view_enabled') == '1')
    {
        add_action( 'wp_head', function()
        {
            if(!is_product())
            {
                //wp_deregister_script('wc-add-to-cart-variation');
                //wp_dequeue_script('wc-add-to-cart-variation');
                wp_register_script( 'wc-add-to-cart-variation', plugins_url( 'woocommerce/assets/js/frontend/add-to-cart-variation.min.js' ), array( 'jquery', 'wp-util'), false, true );
                wp_enqueue_script('wc-add-to-cart-variation');
            }
            else if(is_product())
            {
                global $product;
                if( !$product->is_type( 'variable' ) ){
                    //wp_deregister_script('wc-add-to-cart-variation');
                    //wp_dequeue_script('wc-add-to-cart-variation');
                    wp_register_script( 'wc-add-to-cart-variation', plugins_url( 'woocommerce/assets/js/frontend/add-to-cart-variation.min.js' ), array( 'jquery', 'wp-util'), false, true );
                    wp_enqueue_script('wc-add-to-cart-variation');
                }
            }
        });

        add_action( 'wp_footer', function()
        {
            ?>
            <div id="product-quick-view" class="uk-modal">
                <div class="uk-modal-dialog uk-modal-dialog-large">
                    <a class="uk-modal-close uk-close"></a>
                    <div id="product-quick-view-content"></div>
                </div>
            </div>
            <?php
        });
    }

    // loop
    if ( file_exists( get_template_directory() . '/woocommerce/myaccount/my-account.php' ) && function_exists( 'WC' ) )
    {
        add_filter('warp_content_loop', 'eclat_my_account_template');
        add_filter('woocommerce_get_endpoint_url', function($url){
            return str_replace(array("/view-downloads/", "/view-wishlist/", "/view-compare/"), array("/?view-downloads", "/?view-wishlist", "/?view-compare"), $url);
        });
    }

    add_action( 'after_setup_theme', function()
    {
        if ( function_exists( 'WC' ) ) {
            WC()->query->query_vars['view-downloads'] = 'view-downloads';
            WC()->query->query_vars['view-wishlist'] = 'view-wishlist';
            WC()->query->query_vars['view-compare'] = 'view-compare';
        }
    });

    // remove woocommerce breadcrumb
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

    // hide woocommerce title
    add_filter('woocommerce_show_page_title', function()
    {
        return false;
    });

    // add image on top of the category page
    add_action('woocommerce_archive_description', function()
    {
        if ( is_tax( array( 'product_cat' ) ) )
        {
            global $wp_query;

            $cat = $wp_query->get_queried_object();

            $topimage_id = get_woocommerce_term_meta( $cat->term_id, 'topimage_id', true );
            $topimage_url = get_woocommerce_term_meta( $cat->term_id, 'topimage_url', true );

            if($topimage_id)
            {
                $image = wp_get_attachment_url($topimage_id);

                echo '<div class="woocommerce-top-image">' . ( $topimage_url ? '<a href="'.esc_url($topimage_url).'">' : '' ) . '<img src="' . $image . '" alt="" />' . ( $topimage_url ? '</a>' : '' ) . '</div>';
            }
        }
    }, 1);

    // number of products per page
    if (isset($theme_config['config']) && $theme_config['config']->get('woo_posts_per_page') !== 'default')
    {
        add_filter( 'loop_shop_per_page', function() use ($theme_config)
        {
            $num_prod = ( isset( $_GET['products-per-page'] ) ) ? (int) $_GET['products-per-page'] : $theme_config['config']->get('woo_posts_per_page');

            if ( $num_prod == 'all' )
            {
                $num_prod = wp_count_posts( 'product' )->publish;
            }

            return $num_prod;
        }, 20 );
    }
    // display the New badge
    if(isset($theme_config['config']) && $theme_config['config']->get('woo_product_badge_enabled_new') && $theme_config['config']->get('woo_product_badge_new_days') > 0)
    {
        add_action('woocommerce_before_shop_loop_item_title', 'eclat_new_product_badge', 1);
        add_action('woocommerce_before_single_product_summary', 'eclat_new_product_badge', 1);
        add_action('eclat_before_compare_item_title', 'eclat_new_product_badge', 1);
        add_action('eclat_before_compare_item_title', function()
        {
            get_template_part( 'woocommerce/loop/sale-flash' );
        }, 2);
    }

    // display quick view button
    if(isset($theme_config['config']) && $theme_config['config']->get('woo_product_quick_view_enabled') == '1')
    {
        add_action('woocommerce_quick_view_link', function()
        {
            global $product;

            $text = apply_filters( 'quick_view_text', esc_html__( 'Quick View', 'eclat' ) );
            echo '<a href="#" title="'.$text.'" class="tm-quick-view-button hover-icon" data-product_id="'. $product->id . '" data-uk-tooltip="{animation:\'true\'}"><span class="tm-icon-quick-view"></span><span>'.$text.'</span></a>';

        }, 3);
    }

    // display sale product countdown
    if(isset($theme_config['config']) && $theme_config['config']->get('woo_product_countdown_enabled') == '1')
    {
        add_action('woocommerce_product_countdown', function()
        {
            global $product;

            $date_from = get_post_meta( $product->id, '_sale_price_dates_from', true );
            $date_to   = get_post_meta( $product->id, '_sale_price_dates_to', true );

            if( $date_from < time() && $date_to > time() ) {
                echo '<div class="sale-product-countdown"><h3>'.esc_html__( 'This limited offers ends in:', 'eclat' ).'</h3><div data-date_to="'.date("Y/m/d", $date_to).'"></div></div>';
            }

        }, 4);

        add_action('woocommerce_single_product_summary', function()
        {
            global $product;

            $date_from = get_post_meta( $product->id, '_sale_price_dates_from', true );
            $date_to   = get_post_meta( $product->id, '_sale_price_dates_to', true );

            if( $date_from < time() && $date_to > time() ) {
                echo '<div class="single-product-countdown"><h3>'.esc_html__( 'This limited offers ends in:', 'eclat' ).'</h3><div data-date_to="'.date("Y/m/d", $date_to).'"></div></div>';
            }

        }, 11);
    }

    // display the category name in product list
    if(isset($theme_config['config']) && $theme_config['config']->get('woo_category_name_list_enabled')) {
        add_action( 'woocommerce_before_shop_loop_item', 'eclat_show_product_category_before_title' );
        add_action( 'woocommerce_single_product_summary', 'eclat_show_product_category_before_title', 1 );
    }

    // use the WooCommerce as catalogue
    if ( isset($theme_config['config']) && $theme_config['config']->get('woo_use_as_catalogue') == '1' )
    {
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    }

    // You may be interested in cart
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
    add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 30 );
    add_filter( 'woocommerce_cross_sells_total', function($posts_per_page) use ($theme_config) {
        if($theme_config['config']->get('show_sidebar')){
            $posts_per_page = 3;
        } else {
            $posts_per_page = 4;
        }
        return $posts_per_page;
    });

    // Remove prices
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 15 );
}

if(!is_admin()){
    // check and load google map script
    add_action( 'wp_enqueue_scripts', function() use ($theme_config)
    {
        global $post;

        if ( is_singular() ) wp_enqueue_script( "comment-reply" );

        if( isset($post->post_content) && has_shortcode( $post->post_content, 'google_map') )
        {
            wp_enqueue_script('eclat-google-maps', 'https://maps.googleapis.com/maps/api/js?sensor=false', array(), '1.0', FALSE);
        }

        wp_enqueue_script('jquery-cookie', get_template_directory_uri().'/js/jquery.cookie.js', array( 'jquery' ), '1.4.1', FALSE);
        wp_enqueue_script('jquery-zoom', get_template_directory_uri().'/js/zoom.js', array( 'jquery' ), '1.4.1', FALSE);
        wp_enqueue_style( 'eclat-fonts', eclat_load_font(), array(), '1.0.0' );

        // get styles and scripts
        $theme_config['asset']->addFile('css', 'css:theme.css');
        $theme_config['asset']->addFile('css', 'css:custom.css');

        if ($theme_config['config']->get('page_loader', true) && (is_home() || is_front_page()))
        {
            $theme_config['asset']->addFile('js', 'js:modernizr.custom.js');
            $theme_config['asset']->addFile('js', 'js:page-loader.js');
        }

        $theme_config['asset']->addFile('js', 'js:uikit.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/autocomplete.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/accordion.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/grid.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/lightbox.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/slideshow.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/slideset.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/slider.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/sticky.js');
        $theme_config['asset']->addFile('js', 'warp:vendor/uikit/js/components/tooltip.js');
        $theme_config['asset']->addFile('js', 'js:jquery.chosen.min.js');
        $theme_config['asset']->addFile('js', 'js:jquery.hoverIntent.js');
        $theme_config['asset']->addFile('js', 'js:jquery.mousewheel.min.js');
        $theme_config['asset']->addFile('js', 'js:jquery.countdown.min.js');
        $theme_config['asset']->addFile('js', 'js:owl.carousel.min.js');
        $theme_config['asset']->addFile('js', 'js:snap.svg-min.js');

        if (class_exists('WooCommerce'))
        {
            $theme_config['asset']->addFile('js', 'js:woocommerce.js');
        }

        $theme_config['asset']->addFile('js', 'js:theme.js');

        $styles  = $theme_config['asset']->get('css');
        $scripts = $theme_config['asset']->get('js');

        // load woocommerce style overrides
        if ( class_exists('WooCommerce') && $file = $theme_config['path']->url('css:woocommerce.css')) {
            $styles->prepend($theme_config['asset']->createFile($file));
        }

        // customizer mode
        if ($theme_config['config']['customizer']) {
            foreach ($theme_config['config']['less']['files'] as $file => $less) {
                foreach ($styles as $style) {
                    if ($url = $style->getUrl() and substr($url, -strlen($file)) == $file) {
                        $style['data-file'] = $file;
                        break;
                    }
                }
            }
        }
        // compress styles and scripts
        else if ($compression = $theme_config['config']['compression'] or $theme_config['config']['direction'] == 'rtl') {

            $options = array();
            $filters = array('CssImportResolver', 'CssRewriteUrl');

            // set filter
            if ($theme_config['config']['direction'] == 'rtl') {
                $filters[] = 'CssRtl';
            }

            if ($compression >= 2 && ($theme_config['useragent']->browser() != 'msie' || version_compare($theme_config['useragent']->version(), '8.0', '>='))) {
                $filters[] = 'CssImageBase64';
            }

            if ($styles) {
                // cache styles and check for remote styles
                $styles = array($theme_config['asset']->cache('theme.css', $styles, array_merge($filters, array('CssCompressor')), $options));
                foreach ($styles[0] as $style) {
                    if ($style->getType() == 'File' && !$style->getPath()) {
                        $styles[] = $style;
                    }
                }
            }

            if ($scripts) {
                // cache scripts and check for remote scripts
                $scripts = array($theme_config['asset']->cache('theme.js', $scripts, array('JsCompressor'), $options));
                foreach ($scripts[0] as $script) {
                    if ($script->getType() == 'File' && !$script->getPath()) {
                        $scripts[] = $script;
                    }
                }
            }

        }

        // add styles
        if ($styles)
        {
            $eclat_inline_style = '';

            foreach ($styles as $style)
            {
                if ($url = $style->getUrl())
                {
                    $style_file_path = explode('/'.get_template(), $url);
                    $style_file_path = array_pop($style_file_path);
                    $style_file_name = explode('/', $style_file_path);
                    $style_file_name = array_pop($style_file_name);
                    $style_file_name = 'eclat-' . str_replace(".css", "", $style_file_name);

                    if (strpos($style_file_name, 'theme') !== false){
                        $style_file_name = 'eclat-theme';
                    }

                    wp_enqueue_style($style_file_name, get_stylesheet_directory_uri().$style_file_path, array(), false );
                }
                else
                {
                    $eclat_inline_style .= $style->getContent();
                }
            }

            if($eclat_inline_style)
                wp_add_inline_style( 'eclat-inline-style', $eclat_inline_style );

        }

        // add scripts
        if ($scripts) {
            foreach ($scripts as $script) {
                if ($url = $script->getUrl()) {
                    $script_file_path = explode(get_template(), $url);
                    $script_file_path = array_pop($script_file_path);
                    $script_file_name = explode('/', $script_file_path);
                    $script_file_name = array_pop($script_file_name);
                    $script_file_name = str_replace(".js", "", $script_file_name);

                    if (strpos($script_file_name, 'theme') !== false){
                        $script_file_name = 'eclat-theme';
                    }

                    if(in_array($script_file_name, array('woocommerce', 'login', 'settings')) || strpos($script_file_path, 'uikit') !== false) {
                        $script_file_name = 'eclat-' . $script_file_name;
                    }

                    wp_enqueue_script(str_replace(".", "-", $script_file_name), get_stylesheet_directory_uri().$script_file_path, array( 'jquery' ), '', true);
                }
            }
        }

    });

    // customizer mode
    add_filter( 'style_loader_tag', function($tag) use ($theme_config)
    {
        $styles  = $theme_config['asset']->get('css');

        if ($theme_config['config']['customizer']) {
            foreach ($theme_config['config']['less']['files'] as $file => $less) {
                foreach ($styles as $style) {
                    if ($url = $style->getUrl() and substr($url, -strlen($file)) == $file) {
                        if(substr_count($tag, $url)) {
                            $tag = str_replace(' href=', 'data-file="'.$file.'" href=', $tag);
                        }
                        break;
                    }
                }
            }
        }
        return $tag;
    });
}

