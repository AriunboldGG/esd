<?php
/* ================================================================================== */
/*      IconBox Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-box'),
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

switch($atts['layout']) {
    case 'top_center':
        $atts['element_atts']['class'][]='uk-text-center';
    break;
    case 'top_right':
        $atts['element_atts']['class'][]='uk-text-right';
    break;
    case 'left':
        $atts['element_atts']['class'][]='layout-2';
    break;
    case 'right':
        $atts['element_atts']['class'][]='layout-2 right';
    break;
    case 'small_layout':
        $atts['element_atts']['class'][]='layout-3 uk-text-center';
    break;
}
$atts['element_atts']['class'][] = $atts['size'];
list($output,$font_styles)=lvly_item($atts);
        $output .= lvly_icon($atts,true);
        $output .= '<h4'.(empty($font_styles)?'':(' style="'.esc_attr($font_styles).'"')).'>'.$atts['title'].'</h4>';
        $output .= do_shortcode(wpb_js_remove_wpautop($content, true));

$output .= "</div>";
/* ================================================================================== */
echo ($output);