<?php
/**
 * @package   Warp Theme Framework
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

if( !function_exists( 'eclat_is_shop_installed' ) )
{
    /**
     * Detect if there is a shop plugin installed
     *
     * @return bool
     */
    function eclat_is_shop_installed()
    {
        global $woocommerce;
        if( isset( $woocommerce ) || defined( 'JIGOSHOP_VERSION' ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

if( ! function_exists( 'eclat_show_product_category_before_title' ))
{
    /**
     * Add link in the product category before title
     *
     * @return string
     */
    function eclat_show_product_category_before_title()
    {
        global $product;
        $args = array( 'taxonomy' => 'product_cat');
        $terms = wp_get_post_terms($product->id,'product_cat', $args);

        if (count($terms) > 0)
        {
            foreach ($terms as $term)
            {
                $terms_name = $term->name;
                $terms_id = $term->term_id;
                $terms_taxonomy = $term->taxonomy;
                break;
            }

            echo '<div class="tm-product-term-name"><a href="'.get_term_link($terms_id, $terms_taxonomy).'">'.$terms_name.'</a></div>';
        }
    }
}

if( ! function_exists( 'eclat_woo_get_term_parents' ) )
{
    /**
     * Retrieve term parents with separator.
     *
     * @param int $id Term ID.
     * @param string $taxonomy.
     * @param bool $link Optional, default is false. Whether to format with link.
     * @param array $visited Optional. Already linked to terms to prevent duplicates.
     * @return string
     */
    function eclat_woo_get_term_parents( $id, $taxonomy, $link = false, $visited = array() )
    {
        $chain = '';
        $parent = get_term( $id, $taxonomy );
        if ( is_wp_error( $parent ) )
            return $parent;

        $name = $parent->name;

        if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) )
        {
            $visited[] = $parent->parent;
            $chain .= eclat_woo_get_term_parents( $parent->parent, $taxonomy, true, $visited );
        }

        if ( $link )
        {
            $chain .= '<li><a href="' . get_term_link( $parent, $taxonomy ) . '">'.$parent->name.'</a></li>';
        }
        else
        {
            $chain .= '<li class="uk-active"><span>'.$name.'</span></li>';
        }

        return $chain;
    }
}


if ( !function_exists( 'eclat_get_shop_categories' ) )
{
    /**
     * Function for shop-shortcodes
     *
     * @param bool         $show_all
     *
     * @return array
     */
    function eclat_get_shop_categories( $show_all = true ) {
        global $wpdb;

        $terms = $wpdb->get_results( 'SELECT name, slug FROM ' . $wpdb->prefix . 'terms, ' . $wpdb->prefix . 'term_taxonomy WHERE ' . $wpdb->prefix . 'terms.term_id = ' . $wpdb->prefix . 'term_taxonomy.term_id AND taxonomy = "product_cat" ORDER BY name ASC;' );

        $categories = array();
        if ( $show_all )
        {
            $categories[esc_html__( 'All categories', 'eclat' )] = 0;
        }
        if ( $terms )
        {
            foreach ( $terms as $cat )
            {
                $categories[$cat->name] = $cat->slug;
            }
        }
        return $categories;
    }
}

if ( !function_exists( 'eclat_get_product_in_products_slider' ) )
{
    /**
     * Function for shop-shortcodes
     *
     * @param string $product_type
     * @param int $product_limit
     * @param string $orderby
     * @param string $order
     * @param string $template
     *
     * @return mixed String!Array
     */
    function eclat_get_product_in_products_slider( $product_type, $product_limit, $orderby = "rand", $order = "desc", $template = 'product' )
    {
        global $woocommerce_loop;

        $woocommerce_loop['view'] = 'grid';

        $meta_query = WC()->query->get_meta_query();

        $query_args = array(
            'posts_per_page'      => $product_limit,
            'post_status' 	      => 'publish',
            'post_type' 	      => 'product'
        );

        switch( $product_type ) {

            case 'best_selling':
                $query_args['ignore_sticky_posts'] = 1;
                $query_args['meta_key'] = 'total_sales';
                $query_args['orderby'] = 'meta_value_num';
                $query_args['order'] = $order;

                break;

            case 'recent_products':
                $query_args['ignore_sticky_posts'] = 1;
                $query_args['orderby'] = $orderby;
                $query_args['order'] = $order;

                break;

            case 'top_rated':
                $query_args['ignore_sticky_posts'] = 1;
                $query_args['orderby'] = $orderby;
                $query_args['order'] = $order;

                break;

            case 'sale_products':
                $product_ids_on_sale = wc_get_product_ids_on_sale();
                $query_args['no_found_rows'] = 1;
                $query_args['orderby'] = $orderby;
                $query_args['order'] = $order;
                $query_args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );

                break;

            case 'featured_products':
                $meta_query[] = array(
                    'key'   => '_featured',
                    'value' => 'yes'
                );
                $query_args['ignore_sticky_posts'] = 1;
                $query_args['orderby'] = $orderby;
                $query_args['order'] = $order;

                break;

            default: break;
        }

        $query_args['meta_query'] = $meta_query;

        ob_start();

        if($product_type == 'top_rated')
            add_filter( 'posts_clauses', 'eclat_order_by_rating_post_clauses' );

        $products = new WP_Query( $query_args );

        if($product_type == 'top_rated')
            remove_filter( 'posts_clauses', 'eclat_order_by_rating_post_clauses' );

        if ( $products->have_posts() ) : ?>

            <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                <?php wc_get_template_part( 'content', $template ); ?>

            <?php endwhile; ?>

        <?php endif;

        wp_reset_postdata();

        return ob_get_clean();
    }
}

if ( !function_exists( 'eclat_order_by_rating_post_clauses' ) ) {

    /**
     * eclat_order_by_rating_post_clauses function.
     *
     * @param array $args
     * @return array
     */
    function eclat_order_by_rating_post_clauses($args)
    {
        global $wpdb;

        $args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

        $args['join'] .= "
			LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

        $args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

        $args['groupby'] = "$wpdb->posts.ID";

        return $args;
    }
}

if ( !function_exists( 'eclat_get_social_share' ) )
{
    /**
     * Get social share button
     *
     * @param string         $class_name
     * @param array          $social_arr
     *
     * @return mixed String!Array
     */
    function eclat_get_social_share( $class_name = '', $social_arr = array( 'facebook', 'twitter', 'google-plus', 'pinterest-p', 'envelope-o' ), $show_label = false )
    {
        global $post;

        echo '<div id="svg_social" class="socials ' . $class_name . '">';
        echo '<span class="morph-shape" data-morph-active="M251,150c0,93.5-29.203,143-101,143S49,243.5,49,150C49,52.5,78.203,7,150,7S251,51.5,251,150z">
                    <svg width="100%" height="100%" viewBox="0 0 300 300" preserveAspectRatio="none">
                        <path d="M281,150c0,71.797-59.203,131-131,131S19,221.797,19,150S78.203,19,150,19S281,78.203,281,150z"/>
                    </svg>
                </span>';

        echo '<button class="trigger"><span class="tm-icon-share"></span>'.($show_label ? '<span class="title">'.esc_html__( 'Share on', 'eclat' ).'</span>' : '' ).'</button>';
        echo '<ul class="socials_items">';

        foreach ( $social_arr as $i => $social )
        {
            $title      = urlencode( get_the_title() );
            $permalink  = urlencode( get_permalink() );
            $excerpt    = urlencode( get_the_excerpt() );
            $attr       = '';

            switch ($social)
            {
                case 'facebook':
                    $url = apply_filters( 'share_facebook', 'https://www.facebook.com/sharer.php?u=' . $permalink . '&t=' . $title . '' );
                    $attr = " onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"";
                    break;
                case 'twitter':
                    $url = apply_filters( 'share_twitter', 'https://twitter.com/share?url=' . $permalink . '&amp;text=' . $title . '' );
                    $attr = " onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=417,width=600');return false;\"";
                    break;
                case 'google-plus':
                    $url   = apply_filters( 'share_google', 'https://plus.google.com/share?url=' . $permalink . '&amp;title=' . $title . '' );
                    $attr = " onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"";
                    break;
                case 'pinterest-p':
                    $src   = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                    $url   = apply_filters( 'share_pinterest', 'http://pinterest.com/pin/create/button/?url=' . $permalink . '&amp;media=' . $src[0] . '&amp;description=' . $excerpt );
                    $attr = " onclick=\"javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;\"";
                    break;
                case 'envelope-o':
                    $url = apply_filters( 'share_mail', 'mailto:?subject=Have a look at this site&amp;body= ' . $permalink . '&amp;title=' . $title . '' );
                    break;
            }
            ?>
            <li>
                <a href='<?php echo esc_url($url); ?>' class="socials-text <?php echo $social ?>" target="_blank" <?php echo $attr ?>>
                    <span class="uk-icon-<?php echo $social; ?>"></span>
                </a>
            </li>

        <?php
        }
        echo '</ul>';
        echo '</div>';
    }
}

if( ! function_exists( 'eclat_my_account_template' ) )
{
    /**
     * Add custom template form my-account page
     *
     * @param string         $content
     *
     * @return string
     */
    function eclat_my_account_template($content)
    {
        if ( function_exists( 'WC' ) && is_page( get_option( 'woocommerce_myaccount_page_id' ) ) )
        {
            if ( is_user_logged_in() )
            {
                global $wp;

                ob_start();

                ?>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-large-1-4 uk-visible-large"><?php wc_get_template( '/myaccount/my-account-menu.php' ); ?></div>
                        <div class="uk-width-1-1 uk-width-large-3-4 my_account_info">
                            <?php
                            wc_print_notices();

                            if ( isset( $wp->query_vars['view-order'] ) && empty( $wp->query_vars['view-order'] ) ) {
                                wc_get_template( '/myaccount/my-orders.php', array( 'order_count' => -1 ) );
                            }
                            elseif ( isset( $wp->query_vars['view-downloads'] ) ) {
                                wc_get_template( '/myaccount/my-downloads.php' );
                            }
                            elseif ( isset( $wp->query_vars['view-wishlist'] ) ) {
                                echo do_shortcode( '[eclat_wc_wishlist]' );
                            }
                            elseif ( isset( $wp->query_vars['view-compare'] ) ) {
                                echo do_shortcode( '[eclat_wc_compare]' );
                            }
                            else {
                                echo $content;
                            }
                            ?>
                        </div>
                    </div>

                <?php

                $content = ob_get_contents();
                ob_end_clean();
            }
        }

        return $content;
    }
}

if( ! function_exists( 'eclat_get_wishlist_product_id' ) )
{
    /**
     * Get wishlist product id
     *
     * @return array
     */
    function eclat_get_wishlist_product_id()
    {
        $product_id = array();

        if( isset($_COOKIE['wish_list_id']) && $_COOKIE['wish_list_id'] !== "" )
        {
            $product_id = explode(',', $_COOKIE['wish_list_id']);
        }

        return $product_id;
    }
}

if( ! function_exists( 'eclat_get_wishlist_link' ) )
{
    /**
     * Get wishlist page link
     *
     * @return array
     */
    function eclat_get_wishlist_link()
    {
        global $warp;

        if ( is_user_logged_in() )
        {
            $my_account_url = get_permalink( wc_get_page_id( 'myaccount' ) );
            $url = wc_get_endpoint_url('view-wishlist', '', $my_account_url );
        } else {
            $url = get_permalink( $warp['config']->get('woo_product_wishlist_page_id') );
        }

        return $url;
    }
}

if( ! function_exists( 'eclat_get_compare_product_id' ) )
{
    /**
     * Get wishlist product id
     *
     * @return array
     */
    function eclat_get_compare_product_id()
    {
        $product_id = array();

        if( isset($_COOKIE['compare_list_id']) && $_COOKIE['compare_list_id'] !== "" )
        {
            $product_id = explode(',', $_COOKIE['compare_list_id']);
        }

        return $product_id;
    }
}

if( ! function_exists( 'eclat_get_compare_link' ) )
{
    /**
     * Get wishlist page link
     *
     * @return array
     */
    function eclat_get_compare_link()
    {
        global $warp;

        if ( is_user_logged_in() )
        {
            $my_account_url = get_permalink( wc_get_page_id( 'myaccount' ) );
            $url = wc_get_endpoint_url('view-compare', '', $my_account_url );
        } else {
            $url = get_permalink( $warp['config']->get('woo_product_compare_page_id') );
        }

        return $url;
    }
}

if( ! function_exists( 'eclat_ajax_product_remove' ) )
{
    /**
     * Remove product in the cart using ajax
     *
     * @return string
     */
    function eclat_ajax_product_remove()
    {
        // Get mini cart
        ob_start();

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item){
            if($cart_item['product_id'] == $_POST['product_id'] ){
                WC()->cart->remove_cart_item($cart_item_key);
            }
        }

        WC()->cart->calculate_totals();

        WC()->cart->maybe_set_cart_cookies();

        woocommerce_mini_cart();

        $mini_cart = ob_get_clean();

        // Fragments and mini cart are returned
        $data = array(
            'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
                )
            ),
            'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
        );

        wp_send_json( $data );

        die();
    }
}
if( ! function_exists( 'eclat_is_user_logged_in' ) )
{
    /**
     * Is user logged in
     *
     * @return bool
     */

    function eclat_is_user_logged_in()
    {
        $loggedin = false;
        foreach ( (array) $_COOKIE as $cookie => $value ) {
            if ( stristr($cookie, 'wordpress_logged_in_') )
                $loggedin = true;
        }
        return $loggedin;
    }
}

if( ! function_exists( 'eclat_is_quick_view' ) )
{
    /**
     * Is quick view product info
     *
     * @return bool
     */

    function eclat_is_quick_view()
    {
        return ( defined('DOING_AJAX') && DOING_AJAX && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'eclat_load_product_quick_view' ) ? true : false;
    }
}

if( ! function_exists( 'eclat_load_product_quick_view' ) )
{
    /**
     * Load quick view product info
     */

    function eclat_load_product_quick_view()
    {
        if ( ! isset( $_REQUEST['product_id'] ) ) {
            die();
        }

        $product_id = intval( $_REQUEST['product_id'] );

        // set the main wp query for the product
        wp( 'p=' . $product_id . '&post_type=product' );

        // remove parts from single product page
        remove_all_actions( 'woocommerce_after_single_product_summary' );
        remove_all_actions( 'woocommerce_product_thumbnails' );

        // remove woocommerce variation add to cart button
        //remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);

        // display the category name in product list
        add_action( 'woocommerce_single_product_summary', 'eclat_show_product_category_before_title', 1 );

        // add product code after title
        add_action('woocommerce_single_product_summary', 'eclat_show_product_sku_after_title', 6);

        while ( have_posts() ) : the_post(); ?>

            <div class="single-product woocommerce">

                <?php wc_get_template_part( 'content', 'single-product' ); ?>

            </div>

        <?php endwhile;

        die();
    }
}


if( ! function_exists( 'eclat_show_product_sku_after_title' ) )
{
    /**
     * Show product sku after title
     *
     * @return string
     */

    function eclat_show_product_sku_after_title()
    {
        global $post, $product;
        if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

            <span class="sku_wrapper"><?php esc_html_e( 'Product Code:', 'eclat' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'eclat' ); ?></span></span>

        <?php endif;
    }
}

if ( ! function_exists( 'eclat_is_login_page' ) )
{
    /**
     * Check to see if the current page is the login/register page
     * Use this in conjunction with is_admin() to separate the front-end from the back-end of your theme
     *
     * @return bool
     */

    function eclat_is_login_page()
    {
        return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
    }
}

if ( ! function_exists( 'eclat_add_category_fields' ) )
{
    /**
     * Add new fields product category form
     */

    function eclat_add_category_fields()
    {
    ?>
        <div class="form-field">
            <label><?php esc_html_e( 'Image on top of the category page', 'eclat' ); ?></label>
            <div id="product_cat_topimage" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="product_cat_topimage_id" name="product_cat_topimage_id" />
                <button type="button" class="upload_topimage_button button"><?php esc_html_e( 'Upload/Add image', 'eclat' ); ?></button>
                <button type="button" class="remove_topimage_button button"><?php esc_html_e( 'Remove image', 'eclat' ); ?></button>
            </div>
            <script type="text/javascript">

                // Only show the "remove image" button when needed
                if ( ! jQuery( '#product_cat_topimage_id' ).val() ) {
                    jQuery( '.remove_topimage_button' ).hide();
                }

                // Uploading files
                var file_frame_topimage;

                jQuery( document ).on( 'click', '.upload_topimage_button', function( event ) {

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if ( file_frame_topimage ) {
	                    file_frame_topimage.open();
                        return;
                    }

                    // Create the media frame.
	                file_frame_topimage = wp.media.frames.downloadable_file = wp.media({
                        title: '<?php esc_html_e( "Choose an image", "eclat" ); ?>',
                        button: {
                            text: '<?php esc_html_e( "Use image", "eclat" ); ?>'
                        },
                        multiple: false
                    });

                    // When an image is selected, run a callback.
	                file_frame_topimage.on( 'select', function() {
                        var attachment = file_frame_topimage.state().get( 'selection' ).first().toJSON();

                        jQuery( '#product_cat_topimage_id' ).val( attachment.id );
                        jQuery( '#product_cat_topimage' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
                        jQuery( '.remove_topimage_button' ).show();
                    });

                    // Finally, open the modal.
	                file_frame_topimage.open();
                });

                jQuery( document ).on( 'click', '.remove_topimage_button', function() {
                    jQuery( '#product_cat_topimage' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                    jQuery( '#product_cat_topimage_id' ).val( '' );
                    jQuery( '.remove_topimage_button' ).hide();
                    return false;
                });

            </script>
            <div class="clear"></div>
        </div>
        <div class="form-field">
            <label for="topimage_url"><?php esc_html_e( 'Image URL', 'eclat' ); ?></label>
            <input id="topimage_url" type="text" size="40" value="" name="topimage_url">
            <p><?php esc_html_e( 'Insert URL to make the image linked', 'eclat' ); ?></p>
            <div class="clear"></div>
        </div>
    <?php
    }
}

if ( ! function_exists( 'eclat_edit_category_fields' ) )
{
    /**
     * Edit new fields product category form
     *
     * @param object         $term
     */

    function eclat_edit_category_fields( $term )
    {
        $topimage_url = get_woocommerce_term_meta( $term->term_id, 'topimage_url', true );
        $topimage_id = absint( get_woocommerce_term_meta( $term->term_id, 'topimage_id', true ) );

        if ( $topimage_id ) {
            $topimage = wp_get_attachment_thumb_url( $topimage_id );
        } else {
            $topimage = wc_placeholder_img_src();
        }
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label><?php esc_html_e( 'Image on top of the category page', 'eclat' ); ?></label></th>
            <td>
                <div id="product_cat_topimage" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $topimage ); ?>" width="60px" height="60px" /></div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="product_cat_topimage_id" name="product_cat_topimage_id" value="<?php echo $topimage_id; ?>" />
                    <button type="button" class="upload_topimage_button button"><?php esc_html_e( 'Upload/Add image', 'eclat' ); ?></button>
                    <button type="button" class="remove_topimage_button button"><?php esc_html_e( 'Remove image', 'eclat' ); ?></button>
                </div>
                <script type="text/javascript">

                    // Only show the "remove image" button when needed
                    if ( '0' === jQuery( '#product_cat_topimage_id' ).val() ) {
                        jQuery( '.remove_topimage_button' ).hide();
                    }

                    // Uploading files
                    var file_frame_topimage;

                    jQuery( document ).on( 'click', '.upload_topimage_button', function( event ) {

                        event.preventDefault();

                        // If the media frame already exists, reopen it.
                        if ( file_frame_topimage ) {
	                        file_frame_topimage.open();
                            return;
                        }

                        // Create the media frame.
	                    file_frame_topimage = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php esc_html_e( "Choose an image", "eclat" ); ?>',
                            button: {
                                text: '<?php esc_html_e( "Use image", "eclat" ); ?>'
                            },
                            multiple: false
                        });

                        // When an image is selected, run a callback.
	                    file_frame_topimage.on( 'select', function() {
                            var attachment = file_frame_topimage.state().get( 'selection' ).first().toJSON();

                            jQuery( '#product_cat_topimage_id' ).val( attachment.id );
                            jQuery( '#product_cat_topimage' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
                            jQuery( '.remove_topimage_button' ).show();
                        });

                        // Finally, open the modal.
	                    file_frame_topimage.open();
                    });

                    jQuery( document ).on( 'click', '.remove_topimage_button', function() {
                        jQuery( '#product_cat_topimage' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                        jQuery( '#product_cat_topimage_id' ).val( '' );
                        jQuery( '.remove_topimage_button' ).hide();
                        return false;
                    });

                </script>
                <div class="clear"></div>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top"><label><?php esc_html_e( 'Image URL', 'eclat' ); ?></label></th>
            <td>
                <input id="topimage_url" type="text" size="40" value="<?php echo $topimage_url; ?>" name="topimage_url">
                <p class="description"><?php esc_html_e( 'Insert URL to make the image linked', 'eclat' ); ?></p>
            </td>
        </tr>

    <?php
    }
}

if ( ! function_exists( 'eclat_save_category_fields' ) )
{
    /**
     * Save category fields function.
     *
     * @param mixed $term_id Term ID being saved
     */

    function eclat_save_category_fields( $term_id, $tt_id = '', $taxonomy = '' )
    {
        if ( isset( $_POST['product_cat_topimage_id'] ) && 'product_cat' === $taxonomy ) {
            update_woocommerce_term_meta( $term_id, 'topimage_id', absint( $_POST['product_cat_topimage_id'] ) );
        }
        if ( isset( $_POST['topimage_url'] ) && 'product_cat' === $taxonomy ) {
            update_woocommerce_term_meta( $term_id, 'topimage_url', esc_attr( $_POST['topimage_url'] ) );
        }
    }
}

if ( ! function_exists( 'eclat_get_current_post_type' ) )
{
    /**
     * gets the current post type in the WordPress Admin
     */

    function eclat_get_current_post_type() {
        global $post, $typenow, $current_screen;

        //we have a post so we can just get the post type from that
        if ( $post && $post->post_type )
            return $post->post_type;

        //check the global $typenow - set in admin.php
        elseif( $typenow )
            return $typenow;

        //check the global $current_screen object - set in sceen.php
        elseif( $current_screen && $current_screen->post_type )
            return $current_screen->post_type;

        //lastly check the post_type querystring
        elseif( isset( $_REQUEST['post_type'] ) )
            return sanitize_key( $_REQUEST['post_type'] );

        //we do not know the post type!
        return null;
    }
}

if ( ! function_exists( 'eclat_new_product_badge' ) )
{
    /**
     * display the New badge
     */

    function eclat_new_product_badge ()
    {
        global $warp, $product;

        $dateposted			= get_the_time( 'Y-m-d', $product->id );

        $timestampposted 	= strtotime( $dateposted );
        $new_days 			= $warp['config']->get('woo_product_badge_new_days');

        if( (time() - ( 60 * 60 * 24 * $new_days ) ) < $timestampposted )
        {
            echo '<span class="onnew">'.esc_html__( 'New', 'eclat' ).'</span>';
        }
    }
}

/**
 * Create the termmeta table if it doesn't exist
 *
 * @todo should check if the table exists directly rather than relying on an option
 */
function eclat_create_term_meta_table() {

    global $wpdb;

    $table_name = $wpdb->prefix.'termmeta';

    // check if the table already exists
    if ( get_option( 'eclat_created_term_meta_table' ) )
        return false;

    if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE '%s'", $table_name ) ) == $table_name ) {
        update_option('eclat_created_term_meta_table', true);
        return false;
    }

    $wpdb->query( "
		CREATE TABLE `{$wpdb->prefix}termmeta` (
		  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
		  `meta_key` varchar(255) DEFAULT NULL,
		  `meta_value` longtext,
		  PRIMARY KEY (`meta_id`),
		  KEY `term_id` (`term_id`),
		  KEY `meta_key` (`meta_key`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;" );

    update_option( 'eclat_created_term_meta_table', true );
    return true;
}

if ( ! function_exists( 'add_term_meta' ) )
{
    /**
     * Add meta data field to a term.
     *
     * @param int $term_id term_id.
     * @param string $key Metadata name.
     * @param mixed $value Metadata value.
     * @param bool $unique Optional, default is false. Whether the same key should not be added.
     * @return bool False for failure. True for success.
     */

    function add_term_meta($term_id, $meta_key, $meta_value, $unique = false)
    {
        return add_metadata('term', $term_id, $meta_key, $meta_value, $unique);
    }
}

if ( ! function_exists( 'delete_term_meta' ) )
{
    /**
     * Remove metadata matching criteria from a term.
     *
     * You can match based on the key, or key and value. Removing based on key and
     * value, will keep from removing duplicate metadata with the same key. It also
     * allows removing all metadata matching key, if needed.
     *
     * @param int $term_id term_id
     * @param string $meta_key Metadata name.
     * @param mixed $meta_value Optional. Metadata value.
     * @return bool False for failure. True for success.
     */
    function delete_term_meta($term_id, $meta_key, $meta_value = '')
    {
        return delete_metadata('term', $term_id, $meta_key, $meta_value);
    }
}

if ( ! function_exists( 'get_term_meta' ) )
{
    /**
     * Retrieve term meta field for a term.
     *
     * @param int $term_id term_id.
     * @param string $key The meta key to retrieve.
     * @param bool $single Whether to return a single value.
     * @return mixed Will be an array if $single is false. Will be value of meta data field if $single
     * is true.
     */
    function get_term_meta($term_id, $key, $single = false)
    {
        return get_metadata('term', $term_id, $key, $single);
    }
}

if ( ! function_exists( 'update_term_meta' ) )
{
    /**
     * Update term meta field based on term_id.
     *
     * Use the $prev_value parameter to differentiate between meta fields with the
     * same key and term_id.
     *
     * If the meta field for the term does not exist, it will be added.
     *
     * @param int $term_id term ID.
     * @param string $key Metadata key.
     * @param mixed $value Metadata value.
     * @param mixed $prev_value Optional. Previous value to check before removing.
     * @return bool False on failure, true if success.
     */
    function update_term_meta($term_id, $meta_key, $meta_value, $prev_value = '')
    {
        return update_metadata('term', $term_id, $meta_key, $meta_value, $prev_value);
    }
}

if ( ! function_exists( 'get_term_custom' ) )
{
    /**
     * Retrieve term meta fields, based on term_id.
     *
     * The term meta fields are retrieved from the cache, so the function is
     * optimized to be called more than once. It also applies to the functions, that
     * use this function.
     *
     * @param int $term_id term_id
     * @return array
     */
    function get_term_custom($term_id = 0)
    {
        $term_id = (int)$term_id;
        if (!wp_cache_get($term_id, 'term_meta'))
            update_termmeta_cache($term_id);
        return wp_cache_get($term_id, 'term_meta');
    }
}

if ( ! function_exists( 'update_termmeta_cache' ) )
{
    /**
     * Updates metadata cache for list of term_ids.
     *
     * Performs SQL query to retrieve the metadata for the term_ids and updates the
     * metadata cache for the terms. Therefore, the functions which call this
     * function do not need to perform SQL queries on their own.
     *
     * @param array $term_ids List of term_ids.
     * @return bool|array Returns false if there is nothing to update or an array of metadata.
     */
    function update_termmeta_cache($term_ids)
    {
        return update_meta_cache('term', $term_ids);
    }
}

if ( ! function_exists( 'eclat_load_font' ) )
{
    /**
     * insert google font ib head
     */

    function eclat_load_font ()
    {
        global $warp;

        $style = $warp['config']->get('style');

        if (isset($style) && $style == 'default') {
            if ($less_path = $warp['path']->path('less:style.less')) {
                return eclat_scan_font($less_path);
            }
        } else if(isset($style) && $style != 'default'){
            if ($less_path = $warp['path']->path('theme:styles/'.$style.'/style.less')) {
                return eclat_scan_font($less_path);
            }
        }

        return '';
    }
}

if ( ! function_exists( 'eclat_scan_font' ) )
{
    /**
     * scan font name in less file
     *
     * @param string $less_path path.
     * @return string arg google font.
     */

    function eclat_scan_font($less_path)
    {
        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $font_array = array();
        $font_url = '';
        $matches = null;

        $less_file_content = $wp_filesystem->get_contents($less_path);

        preg_match_all('/family=(.*)/', $less_file_content, $matches);

        if($matches && is_array($matches))
        {
            foreach($matches as $matche)
            {
                if(is_array($matche))
                {
                    foreach($matche as $font_name)
                    {
                        if (strpos($font_name, 'family=') !== false)
                            continue;

                        $font_array[] = $font_name;
                    }
                } else
                {
                    $font_name = $matche;

                    if (strpos($font_name, 'family=') !== false)
                        continue;

                    $font_array[] = $font_name;
                }
            }
        }

        if(count($font_array)) {
            $font_url = add_query_arg('family', implode("|", $font_array), "//fonts.googleapis.com/css");
        }

        return $font_url;
    }

}

?>