<?php
/* ================================================================================== */
/*      Post Slider Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'element_atts' =>array(
        'class' => array('tw-element tw-slider uk-light'),
    ),
    'animation_target' => '.post-item',
), vc_map_get_attributes($this->getShortcode(),$atts));

$query = array(
    'post_type' => 'post',
    'posts_per_page' => $atts['count'],
);
$atts['cats']=trim(trim($atts['cats']),',');
$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'category',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}

$atts['element_atts']['class'][] = 'tw-slider-postcount-'.$atts['count']; 
list($output)=lvly_item($atts);
    $lvly_query = new WP_Query( $query );
    if ($lvly_query->have_posts()) {
        global $post;
        $slider_data = $atts['auto_play'] == 'yes' ? (' data-autoplay="true"') : '';
        $max_width = $content_align = $content_class = '';
        $max_width = ' style="max-width: '.esc_attr($atts['max_width']).'"';
        if ($atts['content_align'] == 'centered') {
            $content_align = 'uk-flex-center uk-text-center';
        }
        elseif ($atts['content_align'] == 'right-normal') {
            $content_class = 'uk-margin-auto-left';
        }
        elseif ($atts['content_align'] == 'left-align') {
            $content_align = 'uk-flex-left uk-margin-medium-left';
        }
        elseif ($atts['content_align'] == 'right-align') {
            $content_align = 'uk-flex-right uk-margin-medium-right';
        }
        $output .= '<div class="tw-lovely-slider" style="height:'.esc_attr($atts['height']).';"'.($slider_data).'>';
            $active = true;
            while($lvly_query->have_posts()) { $lvly_query->the_post();    
                $thumb = '';
                if (has_post_thumbnail($post->ID)) {
                    $img = lvly_image('full', true);
                    if (!empty($img['url'])) {
                        $thumb = '<div class="slider-bg" style="background-image: url('.esc_url($img['url']).');"></div>';
                    }
                }
                $output .= '<div class="post-item'.($active ? ' active' : '').'">';
                    $output .= $thumb;
                    $output .= '<div class="post-content">';
                        $output .= '<div class="uk-container uk-flex uk-flex-middle '.esc_attr($content_align).' uk-light">';
                            $output .= '<div class="entry-content uk-clearfix '.esc_attr($content_class).'" '.$max_width.'>';
                                $output .= '<h2 class="post-title"><a href="'.esc_url(get_permalink()).'" title="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</a></h2>';
                                if (!empty($atts['more_text'])) {
                                    $output .= '<a class="uk-button uk-button-default uk-button-small uk-button-radius light-hover tw-hover" href="'.esc_url(get_permalink()).'"><span class="tw-hover-inner"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></span></a>';
                                }
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
                $active = false;
            }
        $output .= "</div>";
        wp_reset_postdata();
    }

$output .= "</div>";
/* ================================================================================== */
echo ($output);