<?php
/* ================================================================================== */
/*      Images Carousel Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-images-carousel tw-owl-carousel-container'),
    ),
    'animation_target' => '',//!important empty or (inner selector of .owl-item)
), vc_map_get_attributes($this->getShortcode(),$atts));

wp_enqueue_script('owl-carousel');


list($output)=lvly_item($atts);
    $output .= '<div class="owl-carousel owl-theme">';
        if ($atts['images']) {
            $images = explode(',', $atts['images']);
            if (count($images)) {
                foreach ($images as $image) {
                    $img = wp_get_attachment_image_src($image, 'full');
                    $attachment_title = ' alt="'. get_the_title($image).'"';
                    if ($image&&!empty($img[0])) {
                        $desc = get_post_field('post_excerpt', $image);
                        $output .= '<img '.$attachment_title.' src="' . esc_url($img[0]) . '" width="'.esc_attr($img[1]).'" height="'.esc_attr($img[2]).'"/>';
                    }
                }
            }
        }
    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);