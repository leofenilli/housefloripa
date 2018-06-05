<?php

// [eclat_button]
function eclat_button_shortcode($params = array())
{
	extract(shortcode_atts(array(
		"title" => "Text on the button",
		"href" => "",
		"align" => "inline",
		"size" => "",
		"style" => "",
		"shape" => "",
		"icon" => "",
		"scrollspy" => "no",
		"scrollspy_class" => "uk-animation-fade",
		"scrollspy_repeat" => "false",
		"scrollspy_delay" => "300",
		"el_class" => ""
	), $params));

    $href = vc_build_link( $href );
    $a_href = $href['url'];
    $a_title = $href['title'];
    $a_target = $href['target'];

    $button_class = array('uk-button');

    if($style != "")
        $button_class[] = $style;

    if($size != "")
        $button_class[] = $size;

    if($shape != "")
        $button_class[] = $shape;

    if($el_class != "")
        $button_class[] = $el_class;

    if($icon != "")
        $icon = '<span class="'.esc_attr($icon).'"></span>';

    $scrollspy_class = '';

    if($scrollspy == "yes")
        $scrollspy_class = ' data-uk-scrollspy="{cls:\''.$scrollspy_class.'\', repeat: '.$scrollspy_repeat.', delay: '.$scrollspy_delay.'}"';

    ob_start();
    ?>

    <div class="tm-button-container uk-text-<?php echo esc_attr( $align ); ?>"<?php echo $scrollspy_class; ?>>
        <a class="<?php echo implode(' ', $button_class); ?>"
           href="<?php echo esc_attr( $a_href ); ?>"
           title="<?php echo esc_attr( $a_title ); ?>"
           target="<?php echo esc_attr( $a_target ); ?>">
            <?php if($icon != "") echo $icon; ?>
            <?php echo esc_html( $title ); ?>
        </a>
    </div>

    <?php
    $content = ob_get_contents();
    ob_end_clean();

	return $content;
}

add_shortcode("eclat_button", "eclat_button_shortcode");