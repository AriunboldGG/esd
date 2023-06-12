<?php
/* ================================================================================== */
/*      Milestones Item Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

global $waves_parentAtts;
$vcFE=isset($_GET['vc_editable']);

$class = $data = $layout = $milebg = '';
$waves_parentAtts['animation_delay'] = intval($waves_parentAtts['animation_delay']) + 300;
$animData=waves_anim($waves_parentAtts);
if (!empty($animData)&&!$vcFE) {$class.=' tw-animate-gen';$data.=$animData.' style="opacity:0;"';wp_enqueue_style('waves-animate', WAVES_THEME_DIR . '/assets/css/animate.css');}

if (!empty($atts['mile_bgcolor'])) {
    $milebg= ' style="background: '.$atts['mile_bgcolor'].';border-color: '.$atts['mile_bgcolor'].';"';
}
$output = '<div class="'.$waves_parentAtts['column'].$class.'"'.$data.'>';
    $icon = waves_icon($atts,true);
    $output .= '<div class="tw-milestones-box clearfix tw-animate">';
        if ($icon) {
            $output .= $icon;
            $layout = ' with-icon';
        }            
        $output .= '<div class="tw-milestones-content'.$layout.'"'.$milebg.'>';
            $output .= '<div class="tw-milestones-count clearfix">';
                foreach(str_split($atts['count']) as $count) {
                    $output .= '<div class="tw-milestones-show'.(is_numeric($count)?(($vcFE?'':' not-animated').' number'):(' symbol'.($count===' '?' empty':''))).'" data-count="'.esc_attr($count).'">';
                        $output .= is_numeric($count)?($vcFE?$count:'0'):($count===' '?'_':$count);
                    $output .= '</div>';
                }
            $output .= '</div>';
            $output .= '<div class="milestones-title">' . esc_html($atts['mile_title']) . '</div>';
        $output .= '</div>';
    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);