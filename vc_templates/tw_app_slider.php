<?php
/* ================================================================================== */
/*      Images Carousel Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-app-slider tw-owl-carousel-container'),
    ),
    'animation_target' => '',//!important empty or (inner selector of .owl-item)
), vc_map_get_attributes($this->getShortcode(),$atts));

wp_enqueue_script('owl-carousel');
list($output)=lvly_item($atts);
    $output .= '<div class="tw-app-slider-container uk-container uk-position-relative">';
        $output .= '<div class="app-mockup-description">';
            $output .= wpb_js_remove_wpautop( $content );
        $output .= '</div>';
        $output .= '<div class="app-mockup">';
            $output .= '<img src="'.esc_url(LVLY_DIR.'assets/images/iphone.png').'" class="attachment-full" alt="'.esc_attr__('iPhone Image','lvly').'">';
        $output .= '</div>';
        $output .= '<div class="tw-app-mockup-carousel">';
            $output .= '<div class="owl-carousel owl-theme tw-nested-bg">';
                if ($atts['images']) {
                    $images = explode(',', $atts['images']);
                    if (count($images)) {
                        foreach ($images as $image) {
                            $img = wp_get_attachment_image_src($image, 'lvly_slider_app');
                            if ($image&&!empty($img[0])) {
                                $desc = get_post_field('post_excerpt', $image);
                                $output .= '<img src="' . esc_url($img[0]) . '"' . ($desc ? ' alt="' . $desc . '"' : '') . ' />';
                            }
                        }
                    }
                }
            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);