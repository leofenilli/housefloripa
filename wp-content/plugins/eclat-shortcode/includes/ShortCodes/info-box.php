<?php

// [info_box]
function info_box_shortcode($params = array(), $content = null)
{
    extract(shortcode_atts(array(
        'title'    => 'Title',
        'link_url' => '',
        'image' => ''
    ), $params));

    $info_box_with_img = $link_markup = '';

    if (is_numeric($image)) {
        $image = wp_get_attachment_url($image);
        $info_box_with_img = ' tm-info-box-with-img';
    }

    if ($content != "") $content_markup = '<p>' . do_shortcode($content) . '</p>';
    if ($link_url != "") $link_markup = ' onclick="location.href=\''.$link_url.'\';"';

    $info_box_markup = '
		<div class="tm-info-box-block uk-clearfix'.$info_box_with_img.'"'.$link_markup.'>
			<div class="tm-info-box-block-img"><img src="'.$image.'" alt="" /></div>
            <div class="tm-info-box-block-content">
                <h3>'.$title.'</h3>
                '.$content_markup.'
            </div>
		</div>';

    return $info_box_markup;
}

add_shortcode('info_box', 'info_box_shortcode');