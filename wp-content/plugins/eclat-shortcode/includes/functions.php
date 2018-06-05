<?php
/**
 * @package   Eclat Shortcodes
 * @author    Elartica Team http://www.elartica.com
 * @copyright Copyright (C) Elartica Team
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

if( ! function_exists( 'eclat_shortcode_get_tweets_posts' ) )
{
    /**
     * Get last tweets posts
     *
     * @param string         $oauth_access_token
     * @param string         $oauth_access_token_secret
     * @param string         $consumer_key
     * @param string         $consumer_secret
     * @param int            $limit
     *
     * @return Array
     */
    function eclat_shortcode_get_tweets_posts( $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret, $limit)
    {
        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $oauth = array( 'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time(),
            'count' => $limit,
            'oauth_version' => '1.0');

        $base_info = eclat_shortcode_buildBaseString($url, 'GET', $oauth);
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $header = array(eclat_shortcode_buildAuthorizationHeader($oauth), 'Expect:');

        $oauth['User-Agent'] = $_SERVER['HTTP_USER_AGENT'];

        $options = array( CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url . '?count='.$limit,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false);

        $feed = curl_init();

        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);

        /*if( !class_exists( 'WP_Http_Curl' ) ) {
            include_once( ABSPATH . WPINC. '/class-wp-http-curl.php' );
        }
        $wp_http_curl = new WP_Http_Curl;
        $args = array ('headers' => $oauth);

        $json = $wp_http_curl->request( $url . '?count='.$limit , $args );*/

        return json_decode($json);
    }

    function eclat_shortcode_buildBaseString($baseURI, $method, $params)
    {
        $r = array();
        ksort($params);
        foreach($params as $key=>$value){
            $r[] = "$key=" . rawurlencode($value);
        }

        return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    function eclat_shortcode_buildAuthorizationHeader($oauth)
    {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach($oauth as $key=>$value) {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        $r .= implode(', ', $values);
        return $r;
    }
}

if( ! function_exists( 'eclat_shortcode_get_time_ago' ) )
{
    /**
     * Get time
     *
     * @param bool         $date
     *
     * @return string
     */
    function eclat_shortcode_get_time_ago($date = false)
    {
        // Array of time period chunks
        $chunks = array(
            array( 60 * 60 * 24 * 365 , esc_html__( 'year', 'eclat-shortcodes' ), esc_html__( 'years', 'eclat-shortcodes' ) ),
            array( 60 * 60 * 24 * 30 , esc_html__( 'month', 'eclat-shortcodes' ), esc_html__( 'months', 'eclat-shortcodes' ) ),
            array( 60 * 60 * 24 * 7, esc_html__( 'week', 'eclat-shortcodes' ), esc_html__( 'weeks', 'eclat-shortcodes' ) ),
            array( 60 * 60 * 24 , esc_html__( 'day', 'eclat-shortcodes' ), esc_html__( 'days', 'eclat-shortcodes' ) ),
            array( 60 * 60 , esc_html__( 'hour', 'eclat-shortcodes' ), esc_html__( 'hours', 'eclat-shortcodes' ) ),
            array( 60 , esc_html__( 'minute', 'eclat-shortcodes' ), esc_html__( 'minutes', 'eclat-shortcodes' ) ),
            array( 1, esc_html__( 'second', 'eclat-shortcodes' ), esc_html__( 'seconds', 'eclat-shortcodes' ) )
        );

        if ( !is_numeric( $date ) ) {
            $time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
            $date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
            $date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
        }

        $current_time = current_time( 'mysql', $gmt = 0 );
        $newer_date = strtotime( $current_time );

        // Difference in seconds
        $since = $newer_date - $date;

        // Something went wrong with date calculation and we ended up with a negative date.
        if ( 0 > $since )
            return esc_html__( 'sometime', 'eclat-shortcodes' );

        //Step one: the first chunk
        for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];

            // Finding the biggest chunk (if the chunk fits, break)
            if ( ( $count = floor($since / $seconds) ) != 0 )
                break;
        }

        // Set output var
        $output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];


        if ( !(int)trim($output) ){
            $output = '0 ' . esc_html__( 'seconds', 'eclat-shortcodes' );
        }

        $output .= esc_html__(' ago', 'eclat-shortcodes');

        return $output;
    }
}

if ( !function_exists( 'eclat_shortcode_get_product_in_products_slider' ) )
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
    function eclat_shortcode_get_product_in_products_slider( $product_type, $product_limit, $orderby = "rand", $order = "desc", $template = 'product' )
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

if ( !function_exists( 'eclat_shortcode_get_products_slider' ) ) {
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
    function eclat_shortcode_get_products_slider($categories = '', $serie_type = '', $product_limit = 12, $orderby = "rand", $order = "desc", $template = 'product')
    {
        global $woocommerce_loop;

        $woocommerce_loop['view'] = 'grid';

        $meta_query = WC()->query->get_meta_query();

        $query_args = array(
            'posts_per_page' => $product_limit,
            'post_status' => 'publish',
            'post_type' => 'product'
        );

        $query_args['ignore_sticky_posts'] = 1;
        $query_args['orderby'] = $orderby;
        $query_args['order'] = $order;

        $query_args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => array($serie_type),
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => array($categories),
            ),
        );


        $query_args['meta_query'] = $meta_query;

        ob_start();

        $products = new WP_Query($query_args);


        if ( $products->have_posts() ) {

            while ($products->have_posts()) {
                $products->the_post();

                wc_get_template_part('content', $template);

            }

        }

        wp_reset_postdata();

        return ob_get_clean();
    }

}

function eclat_get_types($id = 0)
{
    $args = array(
        'order'      => 'asc',
        'hide_empty' => true,
        'slug'       => array('quadrado', 'retangular')
    );

    $categories = get_terms( 'product_cat', $args );
    $cats = array('Escolha' => '');

    if( $categories ) {
        foreach ($categories as $category ) {
            if( $category->slug == 'retangular' || $category->slug == 'quadrado')
                $cats[$category->name] = $category->slug;
        }
    }
    return $cats;
}

function eclat_get_categories()
{
    $args = array(
        'order'      => 'asc',
        'hide_empty' => true
    );

    $categories = get_terms( 'product_cat', $args );
    $cats = array('Escolha' => '');
    if( $categories ) {
        foreach ($categories as $category ) {
            if( $category->slug != 'retangular' && $category->slug != 'quadrado')
                $cats[$category->name] = $category->term_id;
        }
    }

    return $cats;
}