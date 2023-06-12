<?php
/* ================================================================================== */
/*      FancyBox Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-fancybox'),
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

$link = vc_build_link( $atts['link'] );
$min_height = $layout_size = $hover_color = '';

$layout_size .= $atts['size'];


if ($atts['min_height']){
    $min_height = 'style="min-height: '.$atts['min_height'] .'px;"';
}
if (!empty($atts['color'])) {
    $hover_color = ' data-background-color="'.$atts['color'] .'"';
}


list($output,$font_styles)=lvly_item($atts);
$tag = 'div';
$href = '';
    if (!empty($link['url'])) {
        $tag = 'a';
        $href = ' href="'.esc_url($link['url']).'"';
    }
    $output .= '<'.($tag . $href).(empty($atts['title'])?'':(' title="'.esc_attr($atts['title']).'"')).' class="tw-box uk-text-center'.$layout_size.'" '.$hover_color.$min_height.'>'; 
        $output .= lvly_icon($atts,true);
        $output .= '<h4'.(empty($font_styles)?'':(' style="'.esc_attr($font_styles).'"')).'>'.$atts['title'].'</h4>';
        $output .= do_shortcode(wpb_js_remove_wpautop($content, true));
    $output .= '</'.$tag.'>';
$output .= "</div>";
/* ================================================================================== */
echo ($output);