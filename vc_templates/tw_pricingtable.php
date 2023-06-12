<?php
/* ================================================================================== */
/*      Pricing Table Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-pricing-table uk-card uk-box-shadow-small uk-box-shadow-hover-medium'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

global $waves_parentAtts;

if ($atts['button_hover'] == 'normal') {
    $content_align = 'uk-flex-center uk-text-center';
}
elseif ($atts['button_hover'] == 'dark-hover') {
    $content_align = 'dark-hover';
}
elseif ($atts['button_hover'] == 'right-align') {
    $content_align = 'uk-flex-right uk-margin-medium-right';
}

list($output)=lvly_item($atts);
        $output .= '<div class="uk-card-body">';
            $output .= '<h3 class="pricing-title">' . $atts['price'] . (!empty($atts['symbol']) ? ('<span>'.$atts['symbol'].'</span>') : '') . '</h3>';
            $output .= '<span class="tw-meta">' . $atts['title'] . '</span>';
        $output .= '</div>';
        $output .= '<div class="uk-card-body">';
            $output .= wpb_js_remove_wpautop($content, true);
            $link = vc_build_link( $atts['link'] );
            if (!empty($link['url']) && !empty($link['title'])) {
                $output .= '<a href="' . esc_url($link['url']) . '" class="uk-button uk-button-default uk-button-small uk-button-radius tw-hover '.$atts['button_hover'].'">';
                $output .= '<span class="tw-hover-inner"><span>'.$link['title'].'</span><i class="ion-ios-arrow-thin-right"></i></span>';
                $output .= '</a>';
            }
        $output .= '</div>';
$output .= '</div>';
echo ($output);