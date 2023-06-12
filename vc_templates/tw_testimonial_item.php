<?php
/* ================================================================================== */
/*      Testimonial Item Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);
$output='';
global $lvly_parentAtts;
$link = vc_build_link( $atts['link'] );

if ($lvly_parentAtts['layout'] == 'simple') {
    $output .= '<div class="testimonial-item uk-grid-medium uk-child-width-expand uk-flex-middle" data-uk-grid>';
        $lrg_img=wp_get_attachment_image_src($atts['img'], 'thumbnail');
        if (!empty($lrg_img[0])) {
            $output .= '<div class="uk-width-auto">';
                $output .= '<div class="testimonial-author">';
                    $output .= '<img alt="' . esc_attr($atts['title']) . '" src="' . esc_url($lrg_img[0]) . '" class="uk-border-circle" />';
                $output .= '</div>';
            $output .= '</div>';
        }        

        $output .= '<div>';
            $output .= '<div class="testimonial-content">';
                if (!empty($atts['title'])) {
                    $output .= '<h3 class="testimonial-title">'.esc_html($atts['title']).'</h3>';
                }
                $output .= '<p>' . wp_strip_all_tags($content) . '</p>';
                $output .= '<div class="testimonial-author">';
                    $output .= '<span>';
                        if (!empty($link['url'])) {
                            $output .= '<a href="'.esc_url($link['url']).'"'.(empty($link['title'])?'':(' title="'.esc_attr($link['title']).'"')).'>';
                        }
                        if (!empty($atts['name'])) {
                            $output .= '<span class="author-name">' . esc_attr($atts['name']) . '</span>';
                        }
                        if (!empty($atts['position'])) {
                            $output .= ' / ';
                            $output .= esc_attr($atts['position']);
                        }
                        if (!empty($link['url'])) {
                            $output .= '</a>';
                        }
                    $output .= '</span>';
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';
        
    $output .= '</div>';
    
} else {
    $thumb = '';
    $thumbSize = 'thumbnail';
    $thumbClass = 'uk-border-circle';
    
    
    if ($lvly_parentAtts['layout'] == 'carousel3') {
        $thumbSize = 'full';
        $thumbClass = '';
        $output .= '<div class="carousel-item">';
            $output .= '<section class="uk-section uk-padding-remove">';
                $output .= '<div class="uk-container">';
                    $output .= '<div class="uk-child-width-expand" data-uk-grid>';
                        $output .= '<div class="uk-first-column">';
                            $output .= '<div class="tw-carousel-testimonial uk-section-large">';
    }
                                $lrg_img=wp_get_attachment_image_src($atts['img'], $thumbSize);
                                if (!empty($lrg_img[0])) {
                                    $thumb = '<img alt="' . esc_attr($atts['title']) . '" src="' . esc_url($lrg_img[0]) . '" class="'.esc_attr($thumbClass).'" />';
                                }
                                $output .= '<div class="testimonial-item">';
                                    if ($lvly_parentAtts['layout'] == 'carousel' && $thumb) {
                                        $output .= '<div class="testimonial-avatar">'.($thumb).'</div>';
                                    }
                                    if (!empty($atts['title'])) {
                                        $output .= '<h3 class="testimonial-title">'.esc_html($atts['title']).'</h3>';
                                    }
                                    $output .= '<div class="testimonial-content">';
                                        $output .= '<p>' . wp_strip_all_tags($content) . '</p>';
                                    $output .= '</div>';
                                    $output .= '<div class="testimonial-author">';
                                        if ($lvly_parentAtts['layout'] == 'carousel2') {
                                            $output .= $thumb;
                                        }
                                        $output .= '<span>';
                                            if (!empty($link['url'])) {
                                                $output .= '<a href="'.esc_url($link['url']).'"'.(empty($link['title'])?'':(' title="'.esc_attr($link['title']).'"')).'>';
                                            }
                                                if (!empty($atts['name'])) {
                                                    $output .= '<span class="author-name">' . esc_attr($atts['name']) . '</span>';
                                                }
                                            if (!empty($atts['position'])) {
                                                $output .= ' / ';
                                                $output .= esc_attr($atts['position']);
                                            }
                                            if (!empty($link['url'])) {
                                                $output .= '</a>';
                                            }
                                        $output .= '</span>';
                                    $output .= '</div>';
                                $output .= '</div>';
    if ($lvly_parentAtts['layout'] == 'carousel3') {
                            $output .= '</div>';
                        $output .= '</div>';
                        if ($thumb) {
                            $output .= '<div class="uk-width-auto uk-visible@m testimonial-image">'.($thumb).'</div>';
                        }
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</section>';
        $output .= '</div>';
    }
}    

/* ================================================================================== */
echo ($output);