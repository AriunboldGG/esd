<?php
/* ================================================================================== */
/*      Social Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-socials'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$atts['element_atts']['class'][] = $atts['layout'];
$atts['element_atts']['class'][] = $atts['hover'];
$atts['element_atts']['class'][] = $atts['color'];
if ($atts['color'] == 'social-trans') {
    $atts['color'] = 'uk-icon-button fab ';
}

list($output)=lvly_item($atts);
    $social_links=explode(",", $atts['socials']);
        foreach($social_links as $social_link) {
            if (!empty($social_link)) {
                $socl = lvly_social_icon(esc_url($social_link));
                $output .= '<a title="'.esc_attr($socl['name']).'" href="'.esc_url($social_link).'" class="'.esc_attr($socl['name'].' '.$atts['size']).'"><i class="'.esc_attr($atts['color'] .' '. $socl['class']).'"></i>';
                $output.='</a>';
                
            }
        }
$output .= '</div>';
echo ($output);