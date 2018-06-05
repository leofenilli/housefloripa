<?php
/**
 * Number of products on shop page
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

global $warp;

if ( is_single() || $warp['config']->get('woo_posts_per_page') == 'default' || ! have_posts() ) return;

$num_prod = ( isset( $_GET['products-per-page'] ) ) ? $_GET['products-per-page'] : $warp['config']->get('woo_posts_per_page');

$num_prod_x1 = $warp['config']->get('woo_posts_per_page');
$num_prod_x2 = $num_prod_x1 + ($num_prod_x1 / 2);
$num_prod_x3 = $num_prod_x1 * 2;
$num_prod_x4 = $num_prod_x1 * 3;

$obj  = get_queried_object();
$link = '';

if ( isset( $obj->term_id ) ) {
    $link = get_term_link( $obj->term_id, $obj->taxonomy );

    if ( is_wp_error( $link ) ) {
        $link = get_term_link( $obj->term_id, $obj->taxonomy );
    }

} else {
    if ( get_option( 'permalink_structure' ) == "" ) {
        $link = get_post_type_archive_link('product');
    } else {
        $link = get_permalink( wc_get_page_id( 'shop' ) );
    }
}

$link = apply_filters( 'eclat_num_products_link', $link );

if( ! empty( $_GET ) ) {
    foreach( $_GET as $key => $value ){
        $link = add_query_arg( $key, $value, $link );
    }
}

?>

<div id="number-of-products">
    <span class="view-title"><?php esc_html_e( 'View style:', 'eclat' ) ?></span>
    <select name="number_products" class="chosen">
        <option<?php if ( $num_prod == $num_prod_x1 ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( 'products-per-page', $num_prod_x1, $link ) ?>"><?php echo $num_prod_x1 ?></option>
        <option<?php if ( $num_prod == $num_prod_x2 ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( 'products-per-page', $num_prod_x2, $link ) ?>"><?php echo $num_prod_x2 ?></option>
        <option<?php if ( $num_prod == $num_prod_x3 ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( 'products-per-page', $num_prod_x3, $link ) ?>"><?php echo $num_prod_x3 ?></option>
        <option<?php if ( $num_prod == $num_prod_x4 ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( 'products-per-page', $num_prod_x4, $link ) ?>"><?php echo $num_prod_x4 ?></option>
        <option<?php if ( $num_prod == 'all' ) echo ' selected="selected"'; ?> value="<?php echo add_query_arg( 'products-per-page', 'all', $link ) ?>"><?php esc_html_e( 'ALL', 'eclat' ) ?></option>
    </select>
</div>
