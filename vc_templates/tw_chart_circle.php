<?php
/* ================================================================================== */
/*      Circle Chart Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-chart-circle uk-text-center'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

wp_enqueue_script('easy-pie-chart', LVLY_DIR . '/assets/js/jquery.easypiechart.min.js', false, false, true);
$atts['google_fonts_field'] = $this->getParamData( 'google_fonts' );

list($output,$font_styles)=lvly_item($atts);
    $data = $icon = '';
    $icon=lvly_icon($atts);
    $cStyle = $atts['pie_icon_color'] ? ('color:' . esc_attr($atts['pie_icon_color']) . ';') : '';
    $data .= ' data-percent="' . esc_attr($atts['pie_percent']) . '"';
    $data .= ' data-width="'.esc_attr($atts['pie_track_width']).'"';
    $data .= ' data-size="120"';
    $data .= ' data-track-color="' . esc_attr($atts['pie_track_color']) . '"';
    $data .= ' data-color="' . esc_attr($atts['pie_bar_color']) . '"';

    $output .='<div class="tw-chart"'.$data.'>';
        if (!empty($icon)) {
            $output .='<span class="chart-icon" style="' . esc_attr($cStyle) . '">';
                $output .= lvly_icon($atts);
            $output .='</span>';
        }else {
            $output .='<span style="' . esc_attr($cStyle) . '">';
                $output .=$atts['pie_percent'].'%';
            $output .='</span>';
        }
    $output .='</div>';
    $output .='<h6 class="title"'.(empty($font_styles)?'':(' style="'.esc_attr($font_styles).'"')).'>';
        $output .=$atts['pie_title'];
    $output .='</h6>';

$output .='</div>';
/* ================================================================================== */
echo ($output);