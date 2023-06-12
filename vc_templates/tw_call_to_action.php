<?php
/* ================================================================================== */
/*      Call To Action Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-call-action'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));
$atts['google_fonts_field'] = $this->getParamData( 'google_fonts' );
list($output,$font_styles)=lvly_item($atts);
    $output .= '<div class="call-content">';
    $output .= '<h3'.(empty($font_styles)?'':(' style="'.esc_attr($font_styles).'"')).'>'.$atts['callout_title'].'</h3>';
    $output .= !empty($atts['callout_desc']) ? ('<p>'.esc_html($atts['callout_desc']).'</p>') : '';
    $output .= '</div>';
    $output .= '<div class="call-btn">'.wpb_js_remove_wpautop($content).'</div>';

$output .= '</div>';

echo ($output);