<?php
/**
 * Shop list or grid
*/

if ( is_single() || ! have_posts() ) return;

global $woocommerce_loop;

if ( !( isset( $woocommerce_loop['view'] ) && ! empty( $woocommerce_loop['view'] ) ) )
    $woocommerce_loop['view'] = isset($_COOKIE['shop_view_cookie']) ? $_COOKIE['shop_view_cookie'] : 'grid';

?>
<div id="list-or-grid">
    <a class="grid-view<?php if ( $woocommerce_loop['view'] == 'grid' ) echo ' active'; ?>" href="<?php echo add_query_arg( 'view', 'grid' ) ?>" title="<?php esc_html_e( 'Switch to grid view', 'eclat' ) ?>">
        <span class="uk-icon-th"></span>
    </a>
    <a class="list-view<?php if ( $woocommerce_loop['view'] == 'list' ) echo ' active'; ?>" href="<?php echo add_query_arg( 'view', 'list' ) ?>" title="<?php esc_html_e( 'Switch to list view', 'eclat' ) ?>">
        <span class="uk-icon-list"></span>
    </a>
</div>