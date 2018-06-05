<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
	'numberposts' => $order_count,
	'meta_key'    => '_customer_user',
	'meta_value'  => get_current_user_id(),
	'post_type'   => wc_get_order_types( 'view-orders' ),
	'post_status' => array_keys( wc_get_order_statuses() )
) ) );

if ( $customer_orders ) { ?>

	<h2><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', esc_html__( 'Recent Orders', 'eclat' ) ); ?></h2>

	<table class="shop_table shop_table_responsive my_account_orders">

		<thead>
			<tr>
				<th class="order-number"><span class="nobr"><?php esc_html_e( 'Order', 'eclat' ); ?></span></th>
				<th class="order-date"><span class="nobr"><?php esc_html_e( 'Date', 'eclat' ); ?></span></th>
				<th class="order-status"><span class="nobr"><?php esc_html_e( 'Ship to', 'eclat' ); ?></span></th>
				<th class="order-total"><span class="nobr"><?php esc_html_e( 'Total', 'eclat' ); ?></span></th>
				<th class="order-total"><span class="nobr"><?php esc_html_e( 'Items QTY', 'eclat' ); ?></span></th>
                <th class="order-status"><span class="nobr"><?php esc_html_e( 'Status', 'eclat' ); ?></span></th>
				<th class="order-actions">&nbsp;</th>
			</tr>
		</thead>

		<tbody><?php
			foreach ( $customer_orders as $customer_order ) {
				$order = wc_get_order( $customer_order );
				$order->populate( $customer_order );
				$item_count = $order->get_item_count();

                $status_icon = array(
                    'pending' => 'uk-icon-external-link-square',
                    'processing' => 'uk-icon-spinner',
                    'on-hold' => 'uk-icon-history',
                    'completed' => 'uk-icon-check',
                    'cancelled' => 'uk-icon-remove',
                    'refunded' => 'uk-icon-reply',
                    'failed' => 'uk-icon-exclamation-circle'
                );

				?><tr class="order">
					<td class="order-number" data-title="<?php esc_html_e( 'Order Number', 'eclat' ); ?>">
						<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
							#<?php echo $order->get_order_number(); ?>
						</a>
					</td>
					<td class="order-date" data-title="<?php esc_html_e( 'Date', 'eclat' ); ?>">
						<time datetime="<?php echo date( 'Y-m-d', strtotime( $order->order_date ) ); ?>" title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></time>
					</td>
					<td class="order-status" data-title="<?php esc_html_e( 'Status', 'eclat' ); ?>" style="white-space:nowrap;">
						<?php echo $order->billing_first_name." ".$order->billing_last_name; ?>
					</td>
					<td class="order-total" data-title="<?php esc_html_e( 'Total', 'eclat' ); ?>">
						<?php echo $order->get_formatted_order_total(); ?>
					</td>
                    <td class="order-total" data-title="<?php esc_html_e( 'Total', 'eclat' ); ?>">
                        <?php echo $item_count; ?>
                    </td>
                    <td class="order-status" data-title="<?php esc_html_e( 'Status', 'eclat' ); ?>" style="white-space:nowrap;">
                        <?php echo '<span class="' . $status_icon[$order->get_status()] . '"></span>' . wc_get_order_status_name( $order->get_status() ); ?>
                    </td>
					<td class="order-actions">
						<?php
							$actions = array();

							if ( in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_payment', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['pay'] = array(
									'url'  => $order->get_checkout_payment_url(),
									'name' => esc_html__( 'Pay', 'eclat' )
								);
							}

							if ( in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['cancel'] = array(
									'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
									'name' => esc_html__( 'Cancel', 'eclat' )
								);
							}

							$actions['view'] = array(
								'url'  => $order->get_view_order_url(),
								'name' => esc_html__( 'View', 'eclat' )
							);

							$actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order );

							if ( $actions ) {
								foreach ( $actions as $key => $action ) {
									echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
								}
							}
						?>
					</td>
				</tr><?php
			}
		?></tbody>

	</table>
<?php } else { ?>
    <p><?php esc_html_e( 'There are no orders yet.', 'eclat' ); ?></p>
<?php } ?>
