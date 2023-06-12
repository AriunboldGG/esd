<?php
/* ================================================================================== */
/*      Post Carousel Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-post-carousel tw-owl-carousel-container tw-course'),
    ),
    'animation_target' => '.post-item',//!important empty or (inner selector of .owl-item)
), vc_map_get_attributes($this->getShortcode(),$atts));

wp_enqueue_script('owl-carousel');

$query = array(
    'post_type' => 'lp_course',
    'posts_per_page' => $atts['count'],
);
$atts['cats']=trim(trim($atts['cats']),',');
$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'course_category',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}
if ($atts['background']) {
    $atts['element_atts']['class'][] = $atts['background']; 
}
list($output)=lvly_item($atts);
    $lvly_query = new WP_Query( $query );
    if ($lvly_query->have_posts()) {
        global $post;
        $output .= '<div class="owl-carousel owl-theme">';
            while($lvly_query->have_posts()) { $lvly_query->the_post();
                $cntnt='';
                if ($atts['layout']==='style-2') {
                    ob_start();
                        lvly_blogcontent($atts);
                    $cntnt .= '<p>'.strip_tags(ob_get_clean()).'</p>';
                    if (!empty($atts['excerpt_count']) && !empty($atts['more_text'])) {
                        $cntnt .= '<p class="more-link"><a class="uk-button uk-button-default uk-button-small uk-button-radius tw-hover" href="'.esc_url(get_permalink()).'"><span class="tw-hover-inner"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></span></a></p>';
                    }
                }            
                $thumb = '';
                if (has_post_thumbnail($post->ID)&&$atts['show_image']) {
                    $thumb = '<div class="entry-media">';
                        $thumb .= '<a href="'.esc_url(get_permalink()).'" class="tw-image-hover" title="' . esc_attr(get_the_title()) . '">';
                            $thumb .= lvly_image('lvly_grid_col'.$atts['items']);
                        $thumb .= '</a>';
                    $thumb .= '</div>';
                }
                $output .= '<div class="post-item">';
                    $output .= $thumb;
                    $output .= '<div class="post-content">';
                        $output .= '<div class="tw-meta">'.esc_html__('By ', 'lvly').' '.get_the_author_posts_link().'</div>';
                        $output .= '<h3 class="post-title"><a href="'.esc_url(get_permalink()).'" title="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</a></h3>';
                        $output .= '<div class="tw-meta">';
                            $output .= '<span class="max-students"><i class="fa fa-user"></i>' . get_post_meta($post->ID, '_lp_max_students', true) . '</span>';
                            if (comments_open()) {
                                $output .= '<span class="course-comments"><i class="fa fa-comment"></i>' . get_comments_number() . '</span>';
                            }
                            if (function_exists('LP')) {
                                $course = LP()->global['course'];
                                if ( $price = $course->get_price_html() ) {
                                    $output .= '<span class="course-price">';
                                    $origin_price = $course->get_origin_price_html();
                                    if ( $course->get_sale_price() !== ''/* $price != $origin_price */ ) {
                                        $output .= '<span class="course-origin-price">' . $origin_price . '</span>';
                                    }
                                    $output .= '<span class="sale-price">' . $price . '</span></span>';
                                }
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                    
                    
                $output .= '</div>';
            }
        $output .= "</div>";
        wp_reset_postdata();
    }

$output .= "</div>";
/* ================================================================================== */
echo ($output);