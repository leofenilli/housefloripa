<?php $search_text = get_search_query() ? get_search_query() : esc_attr_x( 'Search Products&hellip;', 'placeholder', 'eclat' ); ?>
<form method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
    <div class="search">
        <div class="uk-container uk-container-center uk-padding-remove">
        <button type="submit"><span class="tm-icon-search"></span></button>
        <input type="text" class="search-field uk-width-1-1" value="<?php echo $search_text?>" name="s"
               <?php if(!get_search_query()) { ?>
               onblur="if(this.value=='') this.value='<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'eclat' ); ?>';" onfocus="if(this.value=='<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'eclat' ); ?>') this.value='';"
               <?php } ?>
            />
        </div>
    </div>
    <a id="show_search_form" href="#"><span class="tm-icon-search"></span></a>
	<input type="hidden" name="post_type" value="product" />
</form>
