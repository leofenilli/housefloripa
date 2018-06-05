<?php
/**
 * Show messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! $messages ){
	return;
}

$count_messages = 0;
?>

<?php foreach ( $messages as $message ) : ?>
    <div class="uk-alert uk-alert-inline uk-alert-small<?php $count_messages == 0 ? " uk-margin-top-remove" : ""?>" data-uk-alert>
        <a href="" class="uk-alert-close uk-close"></a>
        <h3><?php esc_html_e('Information for you', 'eclat')?></h3>
        <p><?php echo wp_kses_post( $message ); ?></p>
    </div>
    <?php
    $count_messages++;
endforeach; ?>
