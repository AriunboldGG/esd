<?php
/* ================================================================================== */
/*      Timeline Item Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

global $lvly_parentAtts;
$output ='<div class="tw-timeline-block">';
    if ($lvly_parentAtts['layout']==='style-2') {
        $output .= '<div class="tw-timeline-info">';
            if ($atts['sub_title']) {$output .= '<h5 class="letter-spacing">'.esc_attr($atts['sub_title']).'</h5>';}
            if ($atts['meta']     ) {$output .= '<p class="tw-meta">'.esc_attr($atts['meta']).'</p>';}
        $output .= '</div>';
    }
    $output .= '<div class="tw-timeline-circle"></div>';
    $output .= '<div class="tw-timeline-content">';
        $output .= '<h3 class="uk-text-uppercase"'.(empty($lvly_parentAtts['font_styles'])?'':(' style="'.esc_attr($lvly_parentAtts['font_styles']).'"')).'>'.esc_attr($atts['title']).'</h3>';
        $output .= '<p class="description">' . strip_tags($content) . '</p>';
    $output .='</div>';
$output .='</div>';

/* ================================================================================== */
echo ($output);