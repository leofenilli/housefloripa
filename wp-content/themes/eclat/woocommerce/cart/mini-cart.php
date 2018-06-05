<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
    <div class="mini-cart-block">
        <table class="cart-list <?php echo $args['list_class']; ?>" cellspacing="0">
            <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                        $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                        $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                        $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                        ?>
                        <tr>
                            <?php if ( ! $_product->is_visible() ) : ?>
                                <td><?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?></td>
                                <td class="product-name">
                                    <?php echo $product_name; ?>
                                    <?php echo WC()->cart->get_item_data( $cart_item ); ?>
                                </td>
                            <?php else : ?>
                                <td>
                                    <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                        <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                                    </a>
                                </td>
                                <td class="product-name">
                                    <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                        <?php echo $product_name; ?>
                                    </a>
                                    <?php echo WC()->cart->get_item_data( $cart_item ); ?>
                                </td>
                            <?php endif; ?>
                            <td class="quantity-block">
                                <span class="quantity-text">x<?php echo $cart_item['quantity']; ?></span>
                                <?php echo $product_price; ?>
                            </td>
                            <td>
                                <?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove ajax-product-remove" data-product_id="%s" title="%s" data-uk-tooltip><span class="tm-icon-cancel"></span></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), $product_id,  esc_html__( 'Remove this item', 'eclat' ) ), $cart_item_key ); ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>
        </table>
    </div>
<?php else : ?>
    <div class="mini-cart-block">
        <p><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>
    </div>
<?php endif; ?>

<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
    <p class="total"><strong><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

    <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

    <p class="buttons">
        <a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button wc-forward"><?php esc_html_e( 'View Cart', 'woocommerce' ); ?></a>
        <a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button alt checkout wc-forward"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
    </p>
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
