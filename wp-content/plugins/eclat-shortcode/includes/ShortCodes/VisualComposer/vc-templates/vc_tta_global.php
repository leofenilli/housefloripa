<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Accordion|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour|WPBakeryShortCode_VC_Tta_Pageable
 */
$el_class = $css = $tab_output = $output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if( $template == "this_theme" )  {

    switch ($this->getShortcode()) {
        case "vc_tta_accordion":
            $content = str_replace("vc_tta_section", "eclat_accordion", $content);

            $this->resetVariables( $atts, $content );

            // It is required to be before tabs-list-top/left/bottom/right for tabs/tours
            $prepareContent = $this->getTemplateVariable('content');

            $output .= '<div class="uk-accordion '.$accordion_style.' '.$nav_style.'" data-uk-accordion="{showfirst: '.$showfirst.', collapse: '.$collapse.', animate: '.$animate.', duration: '.$duration.'}">';
            $output .= $prepareContent;
            $output .= '</div>';

            break;
        case "vc_tta_tabs":
            $content = str_replace("vc_tta_section", "eclat_tab", $content);

            // Extract tab titles
            preg_match_all( '/eclat_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );

            $tab_titles = array();
            if ( isset( $matches[1] ) ) {
                $tab_titles = $matches[1];
            }

            if($title != '') $tab_output .= '<h2 class="uk-tab-title">'.$title.'</h2>';

            if($tab_style == 'uk-tab uk-tab-left' || $tab_style == 'uk-tab uk-tab-right') $tab_output .= '<div class="uk-width-1-1 uk-width-medium-1-'.$width_tabs.'">';

            $tab_output .= '<ul class="'.$tab_style.'" data-uk-switcher="{connect:\'#'.$tabs_id.'\', animation: \''.$animation.'\'}">';
            foreach ( $tab_titles as $tab ) {
                $tab_atts = shortcode_parse_atts( $tab[0] );
                if ( isset( $tab_atts['title'] ) ) {
                    $tab_output .= '<li><a href=""><span>' . $tab_atts['title'] . '</span></a></li>';
                }
            }
            $tab_output .= '</ul>';

            if($tab_style == 'uk-tab uk-tab-left' || $tab_style == 'uk-tab uk-tab-right') $tab_output .= '</div>';

            $this->resetVariables( $atts, $content );

            // It is required to be before tabs-list-top/left/bottom/right for tabs/tours
            $prepareContent = $this->getTemplateVariable('content');

            if($tab_style == 'uk-tab uk-tab-left' || $tab_style == 'uk-tab uk-tab-right') {
                $width_medium = $width_tabs-1;
                $output .= '<div class="uk-width-1-1 uk-width-medium-'.$width_medium.'-'.$width_tabs.'">';
            }

            $output .= "\n\t" . '<ul id="'.$tabs_id.'" class="uk-switcher">';
            $output .= $prepareContent;
            $output .= "\n\t" . '</ul> ';

            if($tab_style == 'uk-tab uk-tab-left' || $tab_style == 'uk-tab uk-tab-right') $output .= '</div>';

            switch ($tab_style) {
                case "uk-tab uk-tab-left":
                    $output = '<div class="uk-grid uk-grid-medium">'.$tab_output.$output.'</div>';
                    break;

                case "uk-tab uk-tab-right":
                    $output = '<div class="uk-grid uk-grid-medium">'.$output.$tab_output.'</div>';
                    break;

                case "uk-tab uk-tab-bottom":
                    $output = $output.$tab_output;
                    break;
                default:
                    $output = $tab_output.$output;
                    break;
            }

            break;
    }

    echo $output;

} else {

    $this->resetVariables( $atts, $content );

    $this->setGlobalTtaInfo();

    $this->enqueueTtaScript();

    // It is required to be before tabs-list-top/left/bottom/right for tabs/tours
    $prepareContent = $this->getTemplateVariable('content');

    $class_to_filter = $this->getTtaGeneralClasses();
    $class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class);
    $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

    $output = '<div ' . $this->getWrapperAttributes() . '>';
    $output .= $this->getTemplateVariable('title');
    $output .= '<div class="' . esc_attr($css_class) . '">';
    $output .= $this->getTemplateVariable('tabs-list-top');
    $output .= $this->getTemplateVariable('tabs-list-left');
    $output .= '<div class="vc_tta-panels-container">';
    $output .= $this->getTemplateVariable('pagination-top');
    $output .= '<div class="vc_tta-panels">';
    $output .= $prepareContent;
    $output .= '</div>';
    $output .= $this->getTemplateVariable('pagination-bottom');
    $output .= '</div>';
    $output .= $this->getTemplateVariable('tabs-list-bottom');
    $output .= $this->getTemplateVariable('tabs-list-right');
    $output .= '</div>';
    $output .= '</div>';

    echo $output;
}