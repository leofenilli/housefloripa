<?php

// [eclat_wc_compare]
function eclat_wc_compare_shortcode($params = array())
{
    extract(shortcode_atts(array(), $params));

    $compare_items = eclat_get_compare_product_id();

    ob_start();

    if( count( $compare_items ) > 0 )
    {
        $parameter_arr = array();

        foreach( $compare_items as $key => $item )
        {
            global $product;
            if( function_exists( 'wc_get_product' ) )
            {
                $product = wc_get_product( $item );
            }
            else
            {
                $product = get_product( $item );
            }

	        if( $product !== false && $product->exists() )
	        {
	            if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
	                $parameter_arr[] = esc_html__( 'Product SKU', 'eclat-shortcodes' );
	            }

	            $parameter_arr[] = esc_html__( 'Stock status', 'eclat-shortcodes' );

	            $attributes = $product->get_attributes();

	            if( $product !== false && $product->exists() )
	            {
	                if ( $product->enable_dimensions_display() )
	                {
	                    if ( $product->has_weight() )
	                    {
	                        $parameter_arr[] = esc_html__( 'Weight', 'eclat-shortcodes' );
	                    }
	                    if ( $product->has_dimensions() )
	                    {
	                        $parameter_arr[] = esc_html__( 'Dimensions', 'eclat-shortcodes' );
	                    }
	                }
	                foreach ( $attributes as $attribute )
	                {
	                    if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) )
	                    {
	                        continue;
	                    }

	                    $parameter_arr[] = wc_attribute_label( $attribute['name'] );
	                }
	            }
	        } else {
		        unset( $compare_items[$key] );
	        }
        }

        $parameter_arr = array_unique($parameter_arr);

	    if( count( $parameter_arr ) > 0 )
	    {
	        ?>
	        <div class="tm-compare-container woocommerce">
	            <div class="uk-grid uk-grid-collapse">
	                <div class="tm-compare-props uk-width-1-2 uk-width-medium-1-3<?php echo is_user_logged_in() ? '' : ' uk-width-large-1-4' ;?>">
	                    <div class="top-container">
	                        <a class="remove_all_compare" href="#"><span class="tm-icon-cancel"></span><span><?php esc_html_e( 'Delete all', 'eclat-shortcodes' ) ?></span></a>
	                    </div>
	                    <div class="props">
	                        <?php
	                        $data_id = 1;
	                        foreach($parameter_arr as $parameter) { ?>
	                            <div class="prop-one" data-id="<?php echo esc_attr( $data_id ); ?>"><div class="prop-wrap"><?php echo esc_html( $parameter ); ?></div></div>
	                            <?php
	                            $data_id++;
	                        } ?>
	                    </div>
	                </div>
	                <div class="tm-compare-elements uk-width-1-2 uk-width-medium-2-3<?php echo is_user_logged_in() ? '' : ' uk-width-large-3-4' ;?> sm-compare">
	                    <div id="carousel-compare" class="tm-elements-wrap">
	                        <?php foreach( $compare_items as $item ) {
	                            global $product;
	                            if( function_exists( 'wc_get_product' ) ) {
	                                $product = wc_get_product( $item );
	                            } else {
	                                $product = get_product( $item );
	                            }

	                            if( $product !== false && $product->exists() ) {
	                                $availability = $product->get_availability();
	                                $stock_status = $availability['class'];
	                                ?>
	                                <div class="tm-compare-element">
	                                    <div class="top-container">
	                                        <ul>
	                                            <li class="tm-product product">

	                                                <div class="tm-product-spacer">
	                                                    <?php
	                                                    $thumbnail = apply_filters( 'eclat_wc_wishlist_item_thumbnail', get_the_post_thumbnail( $product->id, 'shop_catalog' ));
	                                                    if ( ! $product->is_visible() ) { ?>

	                                                        <?php
	                                                            echo $thumbnail;
	                                                            do_action( 'eclat_before_compare_item_title' );
	                                                        ?>

	                                                    <?php } else { ?>

	                                                        <a href="<?php echo $product->get_permalink( $product ); ?>">
	                                                            <?php
	                                                                echo $thumbnail;
	                                                                do_action( 'eclat_before_compare_item_title' );
	                                                            ?>
	                                                        </a>

	                                                    <?php } ?>

	                                                    <?php do_action( 'woocommerce_quick_view_link' ); ?>

	                                                    <div class="tm-product-button-line">
	                                                        <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	                                                    </div>

	                                                    <?php echo apply_filters( 'eclat_wc_compare_item_remove_link', sprintf( '<a href="%s" class="remove compare-product-remove" data-product_id="%s" title="%s" data-uk-tooltip><span class="tm-icon-cancel"></span></a>', '#', $product->id, esc_html__( 'Remove this item', 'eclat-shortcodes' ) )); ?>

	                                                </div>

	                                                <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	                                                <h3>
	                                                    <?php
	                                                    if ( ! $product->is_visible() )
	                                                        echo apply_filters( 'eclat_wc_compare_item_name', $product->get_title() );
	                                                    else
	                                                        echo apply_filters( 'eclat_wc_comparet_item_name', sprintf( '<a href="%s">%s </a>', $product->get_permalink( $product ), $product->get_title() ) );
	                                                    ?>
	                                                </h3>

	                                                <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

	                                            </li>
	                                        </ul>
	                                        <?php
	                                        $product_param = array();

	                                        if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) )
	                                        {
	                                            $product_param[esc_html__('Product SKU', 'eclat-shortcodes')] = ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'eclat-shortcodes' );
	                                        }

	                                        if( $stock_status == 'out-of-stock' )
	                                        {
	                                            $product_param[esc_html__( 'Stock status', 'eclat-shortcodes' )] = '<span class="uk-icon-remove"></span>' . esc_html__( 'Out of Stock', 'eclat-shortcodes' );
	                                        }
	                                        else
	                                        {
	                                            $product_param[esc_html__( 'Stock status', 'eclat-shortcodes' )] = '<span class="uk-icon-check"></span>' . esc_html__( 'In Stock', 'eclat-shortcodes' );
	                                        }

	                                        $attributes = $product->get_attributes();
	                                        if ( $product->enable_dimensions_display() )
	                                        {
	                                            if ( $product->has_weight() )
	                                            {
	                                                $product_param[esc_html__( 'Weight', 'eclat-shortcodes' )] = $product->get_weight() . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) );
	                                            }

	                                            if ( $product->has_dimensions() )
	                                            {
	                                                $product_param[esc_html__( 'Dimensions', 'eclat-shortcodes' )] = $product->get_dimensions();
	                                            }
	                                        }

	                                        foreach ( $attributes as $attribute ) {
	                                            if ( (empty( $attribute['is_visible'] ) && empty( $attribute['is_variation'] ) ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) )
	                                            {
	                                                continue;
	                                            }
	                                            if ( $attribute['is_taxonomy'] )
	                                            {
	                                                $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
	                                                $product_param[wc_attribute_label( $attribute['name'] )] = apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
	                                            }
	                                            else
	                                            {
	                                                $values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
	                                                $product_param[wc_attribute_label( $attribute['name'] )] = apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
	                                            }
	                                        } ?>
	                                    </div>
	                                    <div class="props">
	                                        <?php
	                                        $data_id = 1;
	                                        foreach($parameter_arr as $param)
	                                        {
	                                            if(isset($product_param[$param])) { ?>
	                                                <div class="prop-one" data-id="<?php echo esc_attr( $data_id ) ?>"><div class="prop-wrap"><?php echo $product_param[$param] ?></div></div>
	                                            <?php } else { ?>
	                                                <div class="prop-one" data-id="<?php echo esc_attr( $data_id ) ?>"><div class="prop-wrap"><span class="no"> - </span></div></div>
	                                            <?php } ?>
	                                            <?php
	                                            $data_id++;
	                                        }
	                                        ?>

	                                    </div>
	                                </div>
	                            <?php
	                            }
	                        } ?>
	                    </div>
	                </div>
	            </div>
	        </div>
	    <?php } ?>
        <div<?php echo (count( $compare_items ) > 0 ? ' style="display: none"' : ''); ?> class="uk-alert uk-alert-inline uk-margin-remove" data-uk-alert>
            <a class="uk-alert-close uk-close" href=""></a>
            <h3><?php esc_html_e( 'Information', 'eclat-shortcodes' ) ?></h3>
            <p><?php esc_html_e( 'No products were added to the compare', 'eclat-shortcodes' ) ?></p>
        </div>
    <?php
	    $time = time() + ( 365*24*60*60 );
        setcookie( 'compare_list_id', implode( ',', $compare_items ), $time, '/' );
    } else { ?>
        <div class="uk-alert uk-alert-inline uk-margin-remove" data-uk-alert>
            <a class="uk-alert-close uk-close" href=""></a>
            <h3><?php esc_html_e( 'Information', 'eclat-shortcodes' ) ?></h3>
            <p><?php esc_html_e( 'No products were added to the compare', 'eclat-shortcodes' ) ?></p>
        </div>
    <?php } ?>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('eclat_wc_compare', 'eclat_wc_compare_shortcode');