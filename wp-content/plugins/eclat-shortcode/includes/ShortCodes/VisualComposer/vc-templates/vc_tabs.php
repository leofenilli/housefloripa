<?php
$output = $el_class = '';
extract( shortcode_atts( array(
    'title' => '',
    'tabs_id' => '',
    'animation' => 'scale',
	'el_class' => ''
), $atts ) );

$el_class = $this->getExtraClass( $el_class );

$element = 'uk-switcher';
if ( 'vc_tour' == $this->shortcode ) {
	$element = 'wpb_tour';
}

// Extract tab titles
preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
/**
 * vc_tabs
 *
 */
if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $el_class ), $this->settings['base'], $atts );

if($title != '') $output .= "\n\t" . '<h2 class="uk-tab-title">'.$title.'</h2>';

$output .= "\n\t" . '<ul class="'.$css_class.'" data-uk-switcher="{connect:\'#'.$tabs_id.'\', animation: \''.$animation.'\'}">';
foreach ( $tab_titles as $tab ) {
	$tab_atts = shortcode_parse_atts( $tab[0] );
	if ( isset( $tab_atts['title'] ) ) {
        $output .= "\n\t\t" . '<li><a href="">' . $tab_atts['title'] . '</a></li>';
	}
}
$output .= "\n\t" . '</ul>' . "\n";

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, trim( $element ), $this->settings['base'], $atts );

$output .= "\n\t" . '<ul id="'.$tabs_id.'" class="' . $css_class . '">';
$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
$output .= "\n\t" . '</ul> ' . $this->endBlockComment( $element );

echo $output;