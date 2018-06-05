<?php

// [eclat_wc_wishlist]
function eclat_wc_wishlist_shortcode($params = array())
{
    extract(shortcode_atts(array(), $params));

    $wishlist_items = eclat_get_wishlist_product_id();

    ob_start();
    ?>
    <?php if( count( $wishlist_items ) > 0 ) { ?>
    <div class="woocommerce">
        <table class="wishlist-table" cellspacing="0">
            <thead>
                <tr>
                    <th class="product-remove"></th>
                    <th class="product-thumbnail"><?php esc_html_e( 'Photo', 'eclat-shortcodes' ); ?></th>
                    <th class="product-name"><?php esc_html_e( 'Product', 'eclat-shortcodes' ); ?></th>
                    <th class="product-price"><?php esc_html_e( 'Price', 'eclat-shortcodes' ); ?></th>
                    <th class="product-status"><?php esc_html_e( 'Stock status', 'eclat-shortcodes' ); ?></th>
                    <th class="product-action"></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach( $wishlist_items as $key => $item ) {
                global $product;
                if( function_exists( 'wc_get_product' ) ) {
                    $product = wc_get_product( $item );
                }
                else{
                    $product = get_product( $item );
                }

                if( $product !== false && $product->exists() ) {
                    $availability = $product->get_availability();
                    $stock_status = $availability['class'];
                    ?>
                    <tr class="cart_item">
                        <td class="product-remove">
                            <?php
                            echo apply_filters( 'eclat_wc_wishlist_item_remove_link', sprintf( '<a href="%s" class="remove wishlist-product-remove" data-product_id="%s" title="%s" data-uk-tooltip><span class="tm-icon-cancel"></span></a>', '#', $product->id, esc_html__( 'Remove this item', 'eclat-shortcodes' ) ));
                            ?>
                        </td>
                        <td class="product-thumbnail">
                            <?php
                            $thumbnail = apply_filters( 'eclat_wc_wishlist_item_thumbnail', $product->get_image());

                            if ( ! $product->is_visible() )
                                echo $thumbnail;
                            else
                                printf( '<a href="%s">%s</a>', $product->get_permalink( $product ), $thumbnail );
                            ?>
                        </td>
                        <td class="product-name">
                            <?php
                            if ( ! $product->is_visible() )
                                echo apply_filters( 'eclat_wc_wishlist_item_name', $product->get_title() ) . '&nbsp;';
                            else
                                echo apply_filters( 'eclat_wc_wishlist_item_name', sprintf( '<a href="%s">%s </a>', $product->get_permalink( $product ), $product->get_title() ) );

                            // Backorder notification
                            if ( $product->backorders_require_notification() && $product->is_on_backorder( 1 ) )
                                echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'eclat-shortcodes' ) . '</p>';
                            ?>
                        </td>

                        <td class="product-price">
                            <?php
                            if( is_a( $product, 'WC_Product_Bundle' ) ){
                                if( $product->min_price != $product->max_price ){
                                    echo sprintf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
                                }
                                else{
                                    echo wc_price( $product->min_price );
                                }
                            }
                            elseif( $product->price != '0' ) {
                                echo $product->get_price_html();
                            }
                            else {
                                echo apply_filters( 'eclat_wc_wishlist_free_text', esc_html__( 'Free!', 'eclat-shortcodes' ) );
                            }
                            ?>
                        </td>

                        <td class="product-stock-status">
                            <?php
                            if( $stock_status == 'out-of-stock' ) {
                                echo '<span class="uk-icon-remove"></span>' . esc_html__( 'Out of Stock', 'eclat-shortcodes' );
                            } else {
                                echo '<span class="uk-icon-check"></span>' . esc_html__( 'In Stock', 'eclat-shortcodes' );
                            }
                            ?>
                        </td>

                        <td class="product-add-to-cart">

                            <!-- Add to cart button -->
                            <?php if( isset( $stock_status ) && $stock_status != 'out-of-stock' ): ?>
                                <?php
                                if( function_exists( 'wc_get_template' ) ) {
                                    wc_get_template( 'loop/add-to-cart.php' );
                                }
                                else{
                                    woocommerce_get_template( 'loop/add-to-cart.php' );
                                }
                                ?>
                            <?php endif ?>
                        </td>
                    </tr>

                <?php
                } else {
	                unset( $wishlist_items[$key] );
                }
            } ?>
            </tbody>
        </table>
        <div<?php echo ( count( $wishlist_items ) > 0 ? ' style="display: none"' : ''); ?> class="uk-alert uk-alert-inline uk-margin-remove" data-uk-alert>
            <a class="uk-alert-close uk-close" href=""></a>
            <h3><?php esc_html_e( 'Information', 'eclat-shortcodes' ) ?></h3>
            <p><?php esc_html_e( 'No products were added to the wishlist', 'eclat-shortcodes' ) ?></p>
        </div>
    </div>
    <?php
		$time = time() + ( 365*24*60*60 );
		setcookie( 'wish_list_id', implode( ',', $wishlist_items ), $time, '/' );
	} else { ?>
    <div class="uk-alert uk-alert-inline uk-margin-remove" data-uk-alert>
        <a class="uk-alert-close uk-close" href=""></a>
        <h3><?php esc_html_e( 'Information', 'eclat-shortcodes' ) ?></h3>
        <p><?php esc_html_e( 'No products were added to the wishlist', 'eclat-shortcodes' ) ?></p>
    </div>
    <?php } ?>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('eclat_wc_wishlist', 'eclat_wc_wishlist_shortcode');