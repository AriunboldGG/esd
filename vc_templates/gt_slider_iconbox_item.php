<?php
/* ================================================================================== */
/*      Client Item Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

global $lvly_parentAtts;
$output = '';
$lvly_parentAtts['cnt']++;

$img=wp_get_attachment_image_src($atts['image'],'gt-iconbox-image');

$img_src=isset($img[0])?$img[0]:'';

$image=$attachment_title='';

$output .= '<div class="tw-iconbox-container">';
    $output .= '<div class="tw-iconbox-container-inner">';

        $output .= '<div class="tw-iconbox-content-media">';
            if ($img_src)  {
                $attachment_title = ' alt="'. get_the_title($atts['image']).'"';
                $output .= '<img '.$attachment_title.' src="' . esc_url($img_src) . '"  />';
            }
        $output .= '</div>';

        $output .= '<div class="tw-iconbox-content">';
            $output .= '<h4 class="tw-iconbox-title">'.$atts['title'].'</h4>';
            $output .= do_shortcode(wpb_js_remove_wpautop($content, true));
        $output .= '</div>';

    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);