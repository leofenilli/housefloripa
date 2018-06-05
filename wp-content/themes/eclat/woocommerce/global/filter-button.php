<?php
/**
 * Shop filter buttom
 */

if ( is_single() || ! have_posts() ) return;

global $warp;

?>
<?php if( $warp['widgets']->count('offcanvas-filter') ) { ?>
<div id="filter-button"<?php echo $warp['config']->get('show_sidebar') ? ' class="uk-hidden-large"' : ''; ?>>
    <a href="#offcanvas-filter" class="hover-icon" data-uk-offcanvas>
        <span class="tm-icon-config"></span>
        <span><?php esc_html_e( 'Filter', 'eclat' )?></span>
    </a>
</div>
<?php } ?>