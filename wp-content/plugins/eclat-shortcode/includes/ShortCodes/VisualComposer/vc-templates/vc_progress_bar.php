<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $values
 * @var $units
 * @var $bgcolor
 * @var $custombgcolor
 * @var $customtxtcolor
 * @var $options
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Progress_Bar
 */
$title = $values = $units = $bgcolor = $css = $custombgcolor = $customtxtcolor = $options = $el_class = $output = '';

$class_arr = array("uk-progress");

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$atts = $this->convertAttributesToNewProgressBar( $atts );

extract( $atts );

$el_class = $this->getExtraClass( $el_class );

if ( 'custom' === $bgcolor && '' !== $custombgcolor ) {
	$custombgcolor = ' style="' . vc_get_css_color( 'background-color', $custombgcolor ) . '"';
	if ( '' !== $customtxtcolor ) {
		$customtxtcolor = ' style="' . vc_get_css_color( 'color', $customtxtcolor ) . '"';
	}
} else {
	$custombgcolor = '';
	$customtxtcolor = '';
    $class_arr[] = esc_attr( $bgcolor );
}

if( $size != "" ) $class_arr[] = esc_attr( $size );
if( $striped != "" ) $class_arr[] = esc_attr( $striped );

$output = '<div class="tm-progress-bar' . esc_attr( $el_class ) . '">';

$values = (array) vc_param_group_parse_atts( $values );
$max_value = 0.0;
$graph_lines_data = array();
foreach ( $values as $data ) {
	$new_line = $data;
	$new_line['value'] = isset( $data['value'] ) ? $data['value'] : 0;
	$new_line['label'] = isset( $data['label'] ) ? $data['label'] : '';
	$new_line['bgcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $custombgcolor;
	$new_line['txtcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $customtxtcolor;
	if ( isset( $data['customcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
		$new_line['bgcolor'] = ' style="background-color: ' . esc_attr( $data['customcolor'] ) . ';"';
	}
	if ( isset( $data['customtxtcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
		$new_line['txtcolor'] = ' style="color: ' . esc_attr( $data['customtxtcolor'] ) . ';"';
	}

	if ( $max_value < (float) $new_line['value'] ) {
		$max_value = $new_line['value'];
	}
	$graph_lines_data[] = $new_line;
}

foreach ( $graph_lines_data as $line ) {
	$unit = ( '' !== $units ) ? ' <span class="uk-progress-units">' . $line['value'] . $units . '</span>' : '';

    if ( $max_value > 100.00 ) {
        $percentage_value = (float) $line['value'] > 0 && $max_value > 100.00 ? round( (float) $line['value'] / $max_value * 100, 4 ) : 0;
    } else {
        $percentage_value = $line['value'];
    }

    if( $size != "" ) {
        $output .= '<div class="uk-progress-block">'.$line['label'].' '.$unit.'</div>';
    }

    $output .= '<div class="'.implode(' ', $class_arr).'">';
    if( $size == "" ) {
        $output .= '<div data-uk-scrollspy data-uk-tooltip title="'.$line['label'].'" class="uk-progress-bar" data-percentage-value="' . esc_attr( $percentage_value ) . '" data-value="' . esc_attr( $line['value'] ) . '"' . ( ( isset( $line['bgcolor'] ) && $line['bgcolor'] != '' ) ? $line['bgcolor'] : '' ) . ( ( isset( $line['txtcolor'] ) && $line['txtcolor'] != '' ) ? $line['txtcolor'] : '' ) . '>'.$unit.'</div>';
    } else {
        $output .= '<div data-uk-scrollspy class="uk-progress-bar" data-percentage-value="' . esc_attr( $percentage_value ) . '" data-value="' . esc_attr( $line['value'] ) . '"' . ( ( isset( $line['bgcolor'] ) && $line['bgcolor'] != '' ) ? $line['bgcolor'] : '' ) . ( ( isset( $line['txtcolor'] ) && $line['txtcolor'] != '' ) ? $line['txtcolor'] : '' ) . '></div>';
    }
    $output .= '</div>';
}

$output .= '</div>';

echo $output;
