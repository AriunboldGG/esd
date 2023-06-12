<?php
/* ================================================================================== */
/*      Message Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-message-box'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$bgcolor = '';
if ($atts['type'] == 'uk-notification-message-bgcolor') {
    $bgcolor = ' style="background-color:'.esc_attr($atts['bgcolor']).'"';
}
list($output)=lvly_item($atts);
    $output .= '<div class="uk-notification-message '.esc_attr($atts['type']).'"'.($bgcolor).'>';
        $output .= '<a href="#" class="uk-notification-close" data-uk-close></a>';
        $output .= wpb_js_remove_wpautop($content, true);
    $output .= '</div>';
$output .= '</div>';

echo ($output);