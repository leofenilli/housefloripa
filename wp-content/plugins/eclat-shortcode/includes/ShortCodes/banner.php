<?php

// [banner]
function banner_shortcode($params = array())
{
	extract(shortcode_atts(array(
		'title'    => 'Title',
        'title_pos'    => 'bottom',
        'title_bg' => '#f0f0f0',
		'link_url' => '',
        'bg_color' => '',
		'bg_image' => '',
		'height'   => '410px',
	), $params));
	
	$banner_with_img = '';
	
	if (is_numeric($bg_image)) {
		$bg_image = wp_get_attachment_url($bg_image);
		$banner_with_img = 'tm-banner-with-img';
	}
	
	$banner_markup = '
		<div class="tm-banner-block '.$banner_with_img.'" onclick="location.href=\''.$link_url.'\';" style="height:'.$height.';" data-uk-scrollspy>
			<div class="tm-banner-block-inner">
				<div class="tm-banner-block-background" style="'.($bg_color ? 'background-color:'.$bg_color.';' : '').' background-image:url('.$bg_image.')"></div>
			
				<div class="tm-banner-block-inside" style="height:'.$height.';">
					<div class="tm-banner-block-content tm-banner-block-title-'.$title_pos.'">
						<div'.($title_bg ? ' style="background-color:'.$title_bg.';"' : '').'><h3>'.$title.'</h3></div>
					</div>
				</div>
			</div>';

    $banner_markup .= '</div>';
	
	return $banner_markup;
}

add_shortcode('banner', 'banner_shortcode');