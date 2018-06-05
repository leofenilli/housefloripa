<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

        <div class="uk-alert uk-alert-inline uk-alert-small uk-alert-danger uk-margin-top-remove" data-uk-alert>
            <h3><?php esc_html_e('Oh no!', 'eclat')?></h3>
            <p><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'eclat' ); ?></p>
        </div>

		<p><?php
			if ( is_user_logged_in() )
                esc_html_e( 'Please attempt your purchase again or go to your account page.', 'eclat' );
			else
                esc_html_e( 'Please attempt your purchase again.', 'eclat' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'eclat' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My Account', 'eclat' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

        <div class="uk-alert uk-alert-inline uk-alert-small uk-alert-success uk-margin-top-remove" data-uk-alert>
            <h3><?php esc_html_e('Well done!', 'eclat')?></h3>
            <p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'eclat' ), $order ); ?></p>
        </div>

		<ul class="order_details">
			<li class="order">
				<?php esc_html_e( 'Order Number:', 'eclat' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php esc_html_e( 'Date:', 'eclat' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php esc_html_e( 'Total:', 'eclat' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php esc_html_e( 'Payment Method:', 'eclat' ); ?>
				<strong><?php echo $order->payment_method_title; ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

    <div class="uk-alert uk-alert-inline uk-alert-small uk-alert-success uk-margin-top-remove" data-uk-alert>
        <h3><?php esc_html_e('Well done!', 'eclat')?></h3>
        <p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'eclat' ), null ); ?></p>
    </div>

<?php endif; ?>
