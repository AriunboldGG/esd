<?php
/* ================================================================================== */
/*      Coming Soon Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-coming-soon uk-text-center'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));
$atts['element_atts']['data-uk-countdown'][] = $atts['date'];
list($output)=lvly_item($atts);
    if (!empty($atts['days_text'])) {
        $output .= '<div class="counter-item days">';
            $output .= '<div class="counter"><span class="uk-countdown-days"></span></div>';
            $output .= '<div class="tw-meta">'.$atts['days_text'].'</div>';
        $output .= '</div>';
    }
    if (!empty($atts['hours_text'])) {
        $output .= '<div class="counter-item hours">';
            $output .= '<div class="counter"><span class="uk-countdown-hours"></span></div>';
            $output .= '<div class="tw-meta">'.$atts['hours_text'].'</div>';
        $output .= '</div>';
    }
    if (!empty($atts['minutes_text'])) {
        $output .= '<div class="counter-item minutes">';
            $output .= '<div class="counter"><span class="uk-countdown-minutes"></span></div>';
            $output .= '<div class="tw-meta">'.$atts['minutes_text'].'</div>';
        $output .= '</div>';
    }
    if (!empty($atts['seconds_text'])) {
        $output .= '<div class="counter-item seconds">';
            $output .= '<div class="counter"><span class="uk-countdown-seconds"></span></div>';
            $output .= '<div class="tw-meta">'.$atts['seconds_text'].'</div>';
        $output .= '</div>';
    }
$output .= '</div>';
echo ($output);