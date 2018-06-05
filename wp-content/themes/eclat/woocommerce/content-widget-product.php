<?php global $product; ?>
<li class="tm-product product">
    <div class="tm-product-spacer">
        <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>">

            <?php
            /**
             * woocommerce_before_shop_loop_item_title hook
             *
             * @hooked woocommerce_show_product_loop_new_flash - 1
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action( 'woocommerce_before_shop_loop_item_title' );
            ?>

        </a>
        <?php do_action( 'woocommerce_quick_view_link' ); ?>
        <div class="tm-product-button-line">
        <?php

        /**
         * woocommerce_after_shop_loop_item hook
         *
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action( 'woocommerce_after_shop_loop_item' );

        ?>
        </div>
    </div>

    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    <h3>
        <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>"><?php the_title(); ?></a>
    </h3>

    <?php
    /**
     * woocommerce_after_shop_loop_item_title hook
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action( 'woocommerce_after_shop_loop_item_title' );
    ?>
</li>