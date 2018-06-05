<?php

// [list_styles]
function list_styles_shortcode($params = array(), $content = '') {
	extract(shortcode_atts(array(
		"type" => 'bulleted',
		"style" => 'uk-circle-list',
		"style_num" => 'uk-round-list',
	), $params));

    if($type == 'bulleted') {
        $content = str_replace(array('<ul>', '<p>', '</p>'), array('<ul class="uk-list-styles ' . $style . '">', '', ''), $content);
    } else {
        $content = str_replace(array('<ul>', '</ul>', '<p>', '</p>'), array('<ol class="uk-list-styles ' . $style_num . '">', '</ol>', '', ''), $content);
    }

	return $content;
}

add_shortcode("list_styles", "list_styles_shortcode");