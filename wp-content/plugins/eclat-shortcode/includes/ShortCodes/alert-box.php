<?php

// [alert_box]
function alert_box_shortcode($params = array())
{
    extract(shortcode_atts(array(
        'type'              => '',
        'style'             => '',
        'inline'            => '',
        'close'             => 'yes',
        'title'             => '',
        'text'              => '',
        'scrollspy'         => 'no',
        'scrollspy_class'   => '',
        'scrollspy_repeat'  => 'false',
        'scrollspy_delay'   => '300'
    ), $params));

    $class = $title_markup = $text_markup = $close_markup = $scrollspy_html = "";

    if ($type != "") $class .= $type;
    if ($style != "") $class .= ' ' . $style;
    if ($inline != "") $class .= ' ' . $inline;
    if ($close == "yes") $close_markup .= '<a href="" class="uk-alert-close uk-close"></a>';
    if ($title != "") $title_markup = '<h3>' . $title . '</h3>';
    if ($text != "") $text_markup = '<p>' . do_shortcode($text) . '</p>';

    if($scrollspy == "yes" && $scrollspy_class != ''){
        $scrollspy_html = ' data-uk-scrollspy="{cls:\'' . $scrollspy_class . '\', repeat: ' . $scrollspy_repeat . ', delay:' . $scrollspy_delay . '}"';
    }

    $alert_box_markup = '
		<div class="uk-alert '.$class.'" data-uk-alert'.$scrollspy_html.'>'
            .$close_markup
            .$title_markup
            .$text_markup.
        '</div>
    ';
    return $alert_box_markup;
}

add_shortcode('alert_box', 'alert_box_shortcode');