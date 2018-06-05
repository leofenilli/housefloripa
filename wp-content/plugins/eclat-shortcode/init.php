<?php
/*
Plugin Name: Eclat Shortcodes
Plugin URI: http://www.elartica.com/
Description: With the help of this plugin you can add shortcodes
Author: Elartica Team
Author URI: http://www.elartica.com
Text Domain: eclat-shortcodes
Domain Path: /languages/
Version: 1.0.2
*/

define( 'ECLAT_SHORTCODES_VERSION', '1.0.2' );
define( 'ECLAT_SHORTCODES_PLUGIN_PATH', dirname(__FILE__));
define( 'ECLAT_SHORTCODES_PLUGIN_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ));
define( 'ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH', ECLAT_SHORTCODES_PLUGIN_PATH .  '/includes/ShortCodes' );
define( 'ECLAT_SHORTCODES_PLUGIN_WIDGETS_PATH', ECLAT_SHORTCODES_PLUGIN_PATH .  '/includes/Widgets' );

// Loaded this plugin
add_action( 'plugins_loaded', function(){
    load_plugin_textdomain( 'eclat-shortcodes', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );
} );

// load helper function
include_once(ECLAT_SHORTCODES_PLUGIN_PATH.'/includes/functions.php');

// load widgets
include_once(ECLAT_SHORTCODES_PLUGIN_WIDGETS_PATH . '/Last_Tweets.php');

// Start up this post type
add_action( 'init', function()
{


    // load shortcodes
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/google-map.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/icon-box.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/alert-box.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/banner.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/recent-blog-post.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/last-tweets.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/info-box.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/list-styles.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/eclat-button.php');
    include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/team-member.php');

    if (class_exists('WooCommerce'))
    {
        // load shortcodes WooCommerce
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/eclat-wc-wishlist.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/eclat-wc-compare.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-best-selling-products-slider.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-recent-products-slider.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-featured-products-slider.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-sale-products-slider.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-top-rated-products-slider.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-products-slider.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-product-categories-slider.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-product-categories-grid.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/wc-product-slider.php');
    }

    // Visual Composer
    if (class_exists('WPBakeryVisualComposerAbstract'))
    {
        //enable vc on post types
        if(function_exists('vc_set_default_editor_post_types'))
            vc_set_default_editor_post_types( array('page') );

        if(function_exists('vc_set_as_theme'))
            vc_set_as_theme(true);

        vc_disable_frontend();

        // Modify and remove existing shortcodes from VC
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/custom-vc.php');

        // VC Templates
        $vc_templates_dir = ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/vc-templates/';
        vc_set_template_dir($vc_templates_dir);

        // Add new shortcodes to VC
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/eclat-tta.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/google-map.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/icon-box.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/alert-box.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/banner.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/recent-blog-post.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/last-tweets.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/info-box.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/list-styles.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/eclat-button.php');
        include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/team-member.php');

        // Add new Shop shortcodes to VC
        if (class_exists('WooCommerce'))
        {
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-best-selling-products-slider.php');
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-recent-products-slider.php');
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-featured-products-slider.php');
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-sale-products-slider.php');
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-top-rated-products-slider.php');
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-products-slider.php');
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-product-categories-slider.php');
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-product-slider.php');
            include_once(ECLAT_SHORTCODES_PLUGIN_SHORTCODE_PATH . '/VisualComposer/wc-product-categories-grid.php');
        }
    }
} );