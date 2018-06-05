<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

global $woocommerce, $wp, $warp;

$my_account_url = get_permalink( wc_get_page_id( 'myaccount' ) );
?>

<ul class="uk-nav uk-border-nav my-account-menu">
    <?php if( $warp['config']->get('woo_product_wishlist_enabled') == '1' ) { ?>
    <li>
        <a href="<?php echo wc_get_endpoint_url('view-wishlist', '', $my_account_url ) ?>" title="<?php esc_html_e( 'My Wishlist', 'eclat' ); ?>" <?php echo isset( $wp->query_vars['view-wishlist'] ) ? ' class="active"' : ''; ?>>
            <?php esc_html_e( 'My Wishlist', 'eclat' ) ?>
        </a>
    </li>
    <?php } ?>
    <?php if( $warp['config']->get('woo_product_compare_enabled') == '1' ) { ?>
        <li>
            <a href="<?php echo wc_get_endpoint_url('view-compare', '', $my_account_url ) ?>" title="<?php esc_html_e( 'My Compare List', 'eclat' ); ?>" <?php echo isset( $wp->query_vars['view-compare'] ) ? ' class="active"' : ''; ?>>
                <?php esc_html_e( 'My Compare List', 'eclat' ) ?>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="<?php echo wc_get_endpoint_url( 'view-order', '', $my_account_url ) ?>" title="<?php esc_html_e( 'My Orders', 'eclat' ); ?>" <?php echo  isset( $wp->query_vars['view-order'] )  ? ' class="active"' : ''; ?>>
            <?php esc_html_e( 'My Orders', 'eclat' ); ?>
        </a>
    </li>
    <li>
        <a href="<?php echo wc_get_endpoint_url('view-downloads', '', $my_account_url ) ?>" title="<?php esc_html_e( 'My Download', 'eclat' ); ?>"<?php echo isset( $wp->query_vars['view-downloads'] ) ? ' class="active"' : ''; ?>>
            <?php esc_html_e( 'My Downloads', 'eclat' ) ?>
        </a>
    </li>
    <li>
        <a href="<?php echo wc_get_endpoint_url('edit-address', '', $my_account_url ) ?>" title="<?php esc_html_e( 'Edit Address', 'eclat' ); ?>"<?php echo isset( $wp->query_vars['edit-address'] ) ? ' class="active"' : ''; ?>>
            <?php esc_html_e( 'Edit Address', 'eclat' ) ?>
        </a>
    </li>
    <li>
        <a href="<?php echo wc_get_endpoint_url('edit-account', '', $my_account_url ) ?>" title="<?php esc_html_e( 'Edit Account', 'eclat' ); ?>"<?php echo isset( $wp->query_vars['edit-account'] ) ? ' class="active"' : ''; ?>>
            <?php esc_html_e( 'Edit Account', 'eclat' ) ?>
        </a>
    </li>
</ul>

