<?php
/* ================================================================================== */
/*      Timeline Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-timeline-container'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

global $lvly_parentAtts;
$lvly_parentAtts['layout']=$atts['layout'];
switch($atts['layout']) {
    case 'center':
        $atts['element_atts']['class'][] = 'normal';
    break;
    case 'right':
        $atts['element_atts']['class'][] = 'right';
    break;
    case 'style-2':
        $atts['element_atts']['class'][] = 'style-2';
    break;
}
$atts['google_fonts_field'] = $this->getParamData( 'google_fonts' );
list($output,$lvly_parentAtts['font_styles'])=lvly_item($atts);
    $output .= wpb_js_remove_wpautop($content);
$output .= "</div>";
/* ================================================================================== */
echo ($output);
unset($lvly_parentAtts['layout']);
unset($lvly_parentAtts['font_styles']);