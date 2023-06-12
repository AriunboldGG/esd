<?php
/* ================================================================================== */
/*      Survey Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-heading'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$tag = !empty($atts['heading_tag']) ? ($atts['heading_tag']) : 'h4';
$img=wp_get_attachment_image_src($atts['image'],'gt-iconbox-image');

$img_src=isset($img[0])?$img[0]:'';
$img_width=isset($img[1])?$img[1]:'';
$img_height=isset($img[2])?$img[2]:'';

$image=$attachment_title='';
$atts['element_atts']['class'][] = $atts['title_align'];
$atts['element_atts']['class'][] = $atts['max_width'];

list($output,$font_styles)=lvly_item($atts);
    $output .= '<div class="tw-survey-container">';
        $output .= '<div class="tw-survey-img">';
            if ($img_src)  {
                $attachment_title = ' alt="'. get_the_title($atts['image']).'"';
                $output .= '<img '.$attachment_title.' src="' . esc_url($img_src) . '"  />';
            }
        $output .= "</div>";
        $output .= '<div class="tw-survey-content">';
            $output .= '<div class="tw-survey-title">';
                if (!empty($atts['title'])) {
                    $output .= '<'.esc_attr($tag).(empty($font_styles)?'':(' style="'.esc_attr($font_styles).'"')).' class="heading-title">'.($atts['title']).'</'.esc_attr($tag).'>';
                }
            $output .= "</div>";

            $output .= '<div class="tw-survey-desc">';
                $output .= wpb_js_remove_wpautop($content, true);
            $output .= "</div>";
        $output .= "</div>";
    $output .= "</div>";
$output .= "</div>";
/* ================================================================================== */
echo ($output);