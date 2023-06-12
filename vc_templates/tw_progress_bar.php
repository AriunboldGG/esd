<?php
/* ================================================================================== */
/*      Progress Bar Shortcode
/* ================================================================================== */
$atts = array_merge(array(
	'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$dark = '';

if ($atts['layout'] == 'style-2') {
	$dark = 'uk-light';
}

list($output,$font_styles)=lvly_item($atts);
	$output .= '<div class="tw-progress '.$atts['layout'].'">';

	$graph_lines = explode( ",", $atts['values'] );
	$max_value = 0.0;
	$graph_lines_data = array();
	foreach ( $graph_lines as $line ) {
		$new_line = array();
		$color_index = 2;
		$data = explode( "|", $line );
		$new_line['value'] = isset( $data[0] ) ? $data[0] : 0;
		$new_line['percentage_value'] = isset( $data[1] ) && preg_match( '/^\d{1,2}\%$/', $data[1] ) ? (float) str_replace( '%', '', $data[1] ) : false;
		if ( $new_line['percentage_value'] != false ) {
			$color_index += 1;
			$new_line['label'] = isset( $data[2] ) ? $data[2] : '';
		} else {
			$new_line['label'] = isset( $data[1] ) ? $data[1] : '';
		}
			
			$new_line['bgcolor'] = $new_line['brcolor'] = $new_line['color'] = '';
			if (( isset( $data[ $color_index ] ) )) {
				$new_line['bgcolor'] = ' style="' . vc_get_css_color( 'background-color', $data[ $color_index ] ) . '"';
				$new_line['brcolor'] = ' style="' . vc_get_css_color( 'border-color', $data[ $color_index ] ) . '"';
				$new_line['color'] = $data[ $color_index ];
			} else if ( !empty($atts['bgcolor'])) {
				$new_line['bgcolor'] = ' style="' . vc_get_css_color( 'background-color', $atts['bgcolor'] ) . '"';
				$new_line['brcolor'] = ' style="' . vc_get_css_color( 'border-color', $atts['bgcolor'] ) . '"';
				$new_line['color'] = $atts['bgcolor'];
			}
			
		if ( $new_line['percentage_value'] === false && $max_value < (float) $new_line['value'] ) {
			$max_value = $new_line['value'];
		}

		$graph_lines_data[] = $new_line;
	}

	foreach ( $graph_lines_data as $line ) {
		$unit = '';

		if (( $atts['units'] != '' )) {
			$unit .= '<span>' . $line['value'] . $atts['units'] . '</span>';
		}
		$output .= '<div class="progress-item '.$dark.'"' . $line['brcolor'] . '>';
		if ($atts['layout'] == 'style-3') {
			$output .= '<div class="uk-float-left">' . $unit .'</div>';
		}
		else{
			$output .= '<h6 style="width: ' .esc_attr( $line['value'] . $atts['units'] . ';' . (empty($font_styles)?'':$font_styles) ).'">' . $line['label'] . $unit .'</h6>';
		}
		if ( $line['percentage_value'] !== false ) {
			$percentage_value = $line['percentage_value'];
		} elseif ( $max_value > 100.00 ) {
			$percentage_value = (float) $line['value'] > 0 && $max_value > 100.00 ? round( (float) $line['value'] / $max_value * 100, 4 ) : 0;
		} else {
			$percentage_value = $line['value'];
		}
		if ($atts['layout'] == 'style-3') {
			$output .= '<div class="tw-progress-container">';
			$output .= '<h6 style="width: ' . esc_attr( $line['value'] . $atts['units'] . ';' . (empty($font_styles)?'':$font_styles)).'">' . $line['label'] .'</h6>';
			$output .= '<progress class="uk-progress" value="' . ( $percentage_value ) . '" max="100"></progress>';
			$output .= '</div>';
		}
		else{
			$output .= '<progress class="uk-progress" value="' . ( $percentage_value ) . '" max="100"></progress>';
		}
		$output .= '</div>';
	}

	$output .= '</div>';
$output .= '</div>';

echo ($output);