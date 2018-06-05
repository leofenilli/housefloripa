<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * Override this template by copying it to yourtheme/woocommerce/loop/no-products-found.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="uk-alert uk-alert-inline uk-alert-small">
    <a class="uk-alert-close uk-close" href=""></a>
    <h3><?php esc_html_e('Information for you', 'eclat'); ?></h3>
    <p><?php esc_html_e( 'No products were found matching your selection.', 'eclat' ); ?></p>
</div>
