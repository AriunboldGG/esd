<?php
/* ================================================================================== */
/*      Testimonial Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element'),
    ),
    'animation_target' => '.testimonial-item',
), vc_map_get_attributes($this->getShortcode(),$atts));

global $lvly_parentAtts;
$atts['items']=intval($atts['items']);
$lvly_parentAtts['layout'] = $atts['layout'];

if ($atts['layout']==='simple') {
    $atts['element_atts']['class'][] = 'tw-testimonial';
}else{
    $atts['element_atts']['class'][] = 'tw-owl-carousel-container';
    if ($atts['layout']==='carousel') {
        $atts['element_atts']['class'][] = 'tw-carousel-testimonial uk-text-center';
    }elseif ($atts['layout']==='carousel2') {
        $atts['element_atts']['class'][] = 'tw-carousel-testimonials carousel-2';
    }elseif ($atts['layout']==='carousel3') {
        $atts['element_atts']['class'][] = 'tw-carousel-testimonial carousel-3';
    }
}

list($output)=lvly_item($atts);
    if ($atts['layout'] == 'simple') {
        $output .= wpb_js_remove_wpautop($content);
    } else {
        wp_enqueue_script('owl-carousel');
        
        $output .= '<div class="owl-carousel owl-theme">';
            $output .= wpb_js_remove_wpautop($content);
        $output .= "</div>";
    }
$output .= "</div>";
/* ================================================================================== */
echo ($output);

unset($lvly_parentAtts['layout']);