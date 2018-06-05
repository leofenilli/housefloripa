<?php

// [icon_box]
function icon_box_shortcode($params = array(), $content = null)
{
	extract(shortcode_atts(array(
		'eclat_icon' => '',
		'icon_position' => 'top',
		'icon_style' => 'normal',
		'icon_color' => '#333',
		'icon_bg_color' => '',
		'title' => '',
		'separator' => 'without_separator',
		'link_name' => '',
		'link_url' => '',
        'el_class' => ''
	), $params));
	
	/*if (is_numeric($icon)) {
		$icon = wp_get_attachment_url($icon);
	}*/

	$title_markup = "";
	$content_markup = "";
	$button_markup = "";
	
	if ($title != "") $title_markup = '<h3 class="icon_box_title">' . $title . '</h3>';
	if ($content != "") $content_markup = '<div class="icon_box_content"><p>' . do_shortcode($content) . '</p></div>';
	if ($link_name != "") $button_markup = '<a class="animate-border" href="' . $link_url . '">' . $link_name . '</a>';
	
	$icon_box_markup = '		
		<div class="tm_icon_box icon_position_'.$icon_position.' icon_style_'.$icon_style.' '.$separator.' '.$el_class.' uk-clearfix">
			<div class="icon_wrapper"'.($icon_bg_color && $icon_style == 'bg_color' ? ' style="background-color:'.$icon_bg_color.';"' : '').'>
				<span class="'.$eclat_icon.'" style="color:'.$icon_color.'"></span>
			</div>'
			.$title_markup
			.$content_markup
			.$button_markup.
		'</div>
	';
	return $icon_box_markup;
}

add_shortcode('icon_box', 'icon_box_shortcode');