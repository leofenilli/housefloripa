<?php
/** @var $this WPBakeryShortCode_VC_Tab */
$output = $title = $tab_id = '';
extract( shortcode_atts( $this->predefined_atts, $atts ) );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'uk-clearfix', $this->settings['base'], $atts );
$output .= "\n\t\t\t" . '<li '.$atts['slider'].' class="' . $css_class . '" data-title="'.$atts['title_block'].'">';
$output .= ( $content == '' || $content == ' ' ) ? esc_html__( "Empty tab. Edit page to add content here.", "js_composer" ) : "\n\t\t\t\t" . wpb_js_remove_wpautop( $content );
$output .= "\n\t\t\t" . '</li> ' . $this->endBlockComment( '.wpb_tab' );

echo $output;