<?php
/* ================================================================================== */
/*      Client Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-clients'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

global $lvly_parentAtts;
$lvly_parentAtts['cnt'] = 0;
$lvly_parentAtts['column'] = $atts['column'];
$lvly_parentAtts['hover'] = $atts['hover'];
$lvly_parentAtts['opacity'] = $atts['opacity'];
list($output)=lvly_item($atts);
    $output .= wpb_js_remove_wpautop($content);
    $output .= '</div>';
$output .= "</div>";
/* ================================================================================== */
echo ($output);
unset($lvly_parentAtts['cnt']);
unset($lvly_parentAtts['column']);
unset($lvly_parentAtts['hover']);
unset($lvly_parentAtts['opacity']);