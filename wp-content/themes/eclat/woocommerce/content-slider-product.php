<?php global $product; ?>
<li class="tm-product-slider">
    <div class="tm-product-slider-spacer">
        <div class="tm-product-slider-inner">
            <?php
                woocommerce_template_loop_product_thumbnail();
                woocommerce_template_loop_price();
            ?>
            <div class="uk-vertical-align">
                <div class="uk-vertical-align-middle">
                    <div>
                        <p><?php the_title(); ?></p>
                        <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>"><?php esc_html_e( "Shop now", "eclat" ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>