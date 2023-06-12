<?php
/* ================================================================================== */
/*      Process Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-process uk-text-center'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

global $lvly_parentAtts;
$lvly_parentAtts['layout'] = $atts['layout'];

$atts['element_atts']['class'][] = $atts['layout'];

list($output,$lvly_parentAtts['font_styles'])=lvly_item($atts);
    $output .= "<div class='".esc_attr($atts['column'])." uk-flex-middle' data-uk-grid>";
            $output .= wpb_js_remove_wpautop($content);
    $output .= "</div>";
$output .= "</div>";
/* ================================================================================== */
echo ($output);
unset($lvly_parentAtts['layout']);
unset($lvly_parentAtts['font_styles']);