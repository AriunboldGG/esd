<?php
/* ================================================================================== */
/*      Team Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-team'),
    ),
    'animation_target' => '> tw-team',
), vc_map_get_attributes($this->getShortcode(),$atts));

$atts['element_atts']['class'][] = $atts['layout'];

$social = $hover = $attachment_title = $linkimg = '';
$linkimg = wp_get_attachment_image_src($atts['image'], 'full');
$attachment_title = get_the_title($atts['image']);

$social_links = explode(",",$atts['socials']);
    foreach($social_links as $social_link) {
        $social .= lvly_social_link($social_link);
    }

$hover = ' tw-image-hover';

if ($atts['layout'] == 'style-2') {
    $hover = '';
}
    
list($output)=lvly_item($atts);
    if ($atts['layout'] == 'style-1' || $atts['layout'] == 'style-2') {
        if (!empty($atts['link'])) {
            $output .= '<div class="team-media">';
        }
        else{
            $output .= '<div class="team-media" data-uk-lightbox="animation: fade;toggle:.tw-image-hover">';
        }
            if (!empty($atts['link'])) {
                $output .= '<a href="'.$atts['link'].'" class="'.$hover.'">';
                    $output .= '<img src="' . esc_url($linkimg[0]) . '" alt="'.esc_attr($attachment_title).'" />';
                $output .= '</a>';
            }
            else{
                $output .= '<a href="' . esc_url($linkimg[0]) . '" class="'.$hover.'" data-caption="'.esc_attr($atts['name']).'">';
                    $output .= '<img src="' . esc_url($linkimg[0]) . '" alt="'.esc_attr($attachment_title).'" />';
                $output .= '</a>';
            }
            if ($atts['layout'] == 'style-2') {
                $output .= '<div class="team-content uk-light">';
                    $output .= '<div class="uk-text-center">';
                        $output .= '<span class="tw-meta"><span>'.esc_attr($atts['position']).'</span></span>';
                        $output .= '<h4><span>'.esc_attr($atts['name']).'</span></h4>';
                    $output .= '</div>';
                $output .= '</div>';
            }
        $output .= '</div>';
        $output .= '<div class="team-content uk-text-center '.esc_attr($atts['layout']).'">';
            $output .= '<span class="tw-meta">'.esc_attr($atts['position']).'</span>';
            $output .= '<h4>'.esc_attr($atts['name']).'</h4>';
            $output .= '<div class="tw-socials social-hover-color">';
                $output .= $social;
            $output .= '</div>';
        $output .= '</div>';
    } else {
        $output .= '<div class="team-media'.$hover.'">';
            $output .= '<img src="' . esc_url($linkimg[0]) . '" alt="'.esc_attr($attachment_title).'" />';
            $output .= '<div class="team-content '.esc_attr($atts['layout']).' uk-light">';
                $output .= '<div class="uk-text-center">';
                    $output .= '<span class="tw-meta"><span>'.esc_attr($atts['position']).'</span></span>';
                    if (!empty($atts['link'])) {
                        $output .= '<h4><a href="'.$atts['link'].'">';
                            $output .= '<span>'.esc_attr($atts['name']).'</span>';
                        $output .= '</a></h4>';
                    } else {
                        $output .= '<h4><span>'.esc_attr($atts['name']).'</span></h4>';
                    }
                    $output .= '<div class="tw-socials social-hover-light">';
                        $output .= $social;
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';
    }
$output .= "</div>";

/* ================================================================================== */
echo ($output);