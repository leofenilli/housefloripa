<?php

// [eclat_accordion]
function eclat_accordion_shortcode($params = array(), $content = null)
{
    extract(shortcode_atts(array(
        'title'    => 'Title'
    ), $params));

    ob_start();
    ?>

    <h3 class="uk-accordion-title"><?php echo esc_html( $title ); ?></h3>
    <div class="uk-accordion-content">
        <?php echo ( $content == '' || $content == ' ' ) ? esc_html__( "Edit page to add content here.", "eclat-shortcodes" ) : wpb_js_remove_wpautop( $content ); ?>
    </div>

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('eclat_accordion', 'eclat_accordion_shortcode');

// [eclat_tab]
function eclat_tab_shortcode($params = array(), $content = null)
{
    extract(shortcode_atts(array(
        'title'       => 'Title',
        'slider'      => '',
        'title_block' => '',
        'el_class'    => ''
    ), $params));

    ob_start();
    ?>

    <li<?php echo $el_class ? ' class="'.esc_attr( $el_class ).'"' : ''; ?><?php echo $title_block ? ' data-title="'.esc_html( $title_block ).'"' : ''; ?><?php echo $slider ? ' '.esc_html( $slider ) : ''; ?>>
        <?php echo ( $content == '' || $content == ' ' ) ? esc_html__( "Edit page to add content here.", "eclat-shortcodes" ) : wpb_js_remove_wpautop( $content ); ?>
    </li>

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('eclat_tab', 'eclat_tab_shortcode');