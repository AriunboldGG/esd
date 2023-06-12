<?php
/* ================================================================================== */
/*      Process Item Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

global $lvly_parentAtts;
$output = '<div class="tw-process-block uk-padding-large">';
    if ($lvly_parentAtts['layout'] == 'style-2') {
        $output .= '<div class="tw-process-circle">';
            $output .= '<h3 class="uk-text-uppercase"'.(empty($lvly_parentAtts['font_styles'])?'':(' style="'.esc_attr($lvly_parentAtts['font_styles']).'"')).'>'.$atts['title'].'</h3>';
            $output .= '<span class="tw-small-circle uk-border-circle"></span>';
            $output .= '<span class="tw-process-number">'.$atts['no'].'</span>';
        $output .= '</div>';
    } else {
        $output .= '<div class="tw-process-circle uk-border-circle">';
            $output .= '<span class="tw-process-number">'.$atts['no'].'</span>';
            $output .= '<h3 class="uk-text-uppercase"'.(empty($lvly_parentAtts['font_styles'])?'':(' style="'.esc_attr($lvly_parentAtts['font_styles']).'"')).'>'.$atts['title'].'</h3>';
        $output .= '</div>';
    }
    if (!empty($content)) {
        $output .= '<p>'.$content.'</p>';
    }

$output .= '</div>';

/* ================================================================================== */
echo ($output);