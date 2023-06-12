<?php
/* ================================================================================== */
/*      Counter Up Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-counterup uk-text-center'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));
$atts['element_atts']['class'][] = $atts['counter_style'];
$atts['element_atts']['data-slctr'][] = 'h1';
$atts['element_atts']['data-txt'][] = $atts['counter_data_title'];
$atts['element_atts']['data-sep'][] = ',';
$atts['element_atts']['data-dur'][] = '1000';
list($output)=lvly_item($atts);
    $icon=lvly_icon($atts,true);
    if (!empty($icon)) {
        $output .= '<div class="icon-container">'.$icon.'</div>';
    }
    $output .= '<div class="tw-counterup-content">';
        $output .= '<h1>'.esc_html($atts['counter_number']).'</h1>';
        $output .= '<span class="counter-meta">'.esc_html($atts['counter_title']).'</span>';
    $output .= '</div>';
$output .= '</div>';

echo ($output);