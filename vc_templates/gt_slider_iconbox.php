<?php
/* ================================================================================== */
/*      Client Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element gt-slider-iconbox'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$style = $atts['style'];
$colmn = '';

if($style == 'style1') {
    $colmn = 'uk-child-width-1-3@m';
    
}else {
    $colmn = 'uk-child-width-1-2@m';
}

global $lvly_parentAtts;
$lvly_parentAtts['cnt'] = 0;
list($output)=lvly_item($atts);
    $output .= '<div class="'.$style.'">';
        if($style == 'style2') {
            $output .= '<div class="gt-slider-iconbox-line"></div>';
        }
        $output .=   '<div class="uk-child-width-1-1 '.$colmn.'" data-uk-grid>';
            $output .= wpb_js_remove_wpautop($content);
        $output .= '</div>';
    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);
unset($lvly_parentAtts['cnt']);