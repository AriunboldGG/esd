<?php
/* ================================================================================== */
/*      Slider Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-slider tw-owl-carousel-container'),
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

$owlCarouselClass = '';

wp_enqueue_script('owl-carousel');

if ( ! empty( $atts['layout'] ) && $atts['layout'] === 'with-icon-box' ) {
    $owlCarouselClass = 'tw-with-icon-box';
}

list($output)=lvly_item($atts);
    $output .= '<div class="owl-carousel owl-theme' . $owlCarouselClass . ' ">';
        $output .= wpb_js_remove_wpautop($content);
    $output .= '</div>';
    if ($atts['layout'] === 'with-icon-box'){
        $output .= '<div class="slider-counter"></div>';
    }
$output .= '</div>';
/* ================================================================================== */
echo ($output);