<?php
/* ================================================================================== */
/*      Map Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-map'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$atts['json']=rawurldecode(lvly_decode(wp_strip_all_tags($atts['json'])));
$google_map_api_key = lvly_get_option( 'google_map_api_key' );
//AIzaSyBZQiiFTOGpm2qHVZmZY1s-aEnmHDhqKgk
wp_enqueue_script('googleapi-map', esc_url( 'https://maps.googleapis.com/maps/api/js' . ( $google_map_api_key ? ( '?key='. $google_map_api_key) : '' ) ), false, false, true);

$atts['element_atts']['data-style'][] = $atts['style_name'];
$atts['element_atts']['data-mouse'][] = $atts['mouse_wheel'];
$atts['element_atts']['data-lat'][] = $atts['lat'];
$atts['element_atts']['data-lng'][] = $atts['lng'];
$atts['element_atts']['data-zoom'][] = $atts['zoom'];
$atts['element_atts']['data-json'][] = $atts['json'];
if ($atts['height']) {$atts['element_atts']['style'][] = 'min-height:'.$atts['height'].'px;';}

list($output)=lvly_item($atts);
    $output .='<div class="map"></div>';
    $output .='<div class="map-markers">';
        $iconDefault = LVLY_DIR."assets/images/map-marker.png";
        $markers = (array) vc_param_group_parse_atts( $atts['markers'] );
        foreach($markers as $marker) {
            $marker = shortcode_atts( array(
                'css' => '',
                'title' => '',
                'lat' => '',
                'lng' => '',
                'icon' => '',
                'icon_width' => '',
                'icon_height' => '',
                'content' => '',
            ),$marker);
            $icon=$marker['icon'];
            if ($icon) {
                $icon=wp_get_attachment_image_src($icon,'full');
                $icon=isset($icon[0])?$icon[0]:$iconDefault;
            }else{
                $icon=$iconDefault;
            }
            $data=' data-title="'.esc_attr($marker['title']).'" data-lat="'.esc_attr($marker['lat']).'" data-lng="'.esc_attr($marker['lng']).'" data-iconsrc="'.esc_url($icon).'" data-iconwidth="'.esc_attr($marker['icon_width']).'" data-iconheight="'.esc_attr($marker['icon_height']).'"';
            $output.= '<div class="map-marker"'.$data.'>';
                if ($marker['title']) {$output .='<h3 class="map-marker-title">'.esc_html($marker['title']).'</h3>';}
                $output .='<div class="marker-content">';
                    $output .= do_shortcode($marker['content']);
                $output .='</div>';
            $output .='</div>';
        }
    $output .='</div>';
    if ($atts['contact']==='true') {
        $output .='<div class="tw-map-contact" style="'.esc_attr('background-color:'.$atts['map_bg_color'].';').'">';
            if ($atts['map_title']  ) {$output.='<h2>'.esc_html($atts['map_title']).'</h2>';}
            if ($atts['map_desc']  ) {$output.='<p>'.esc_html($atts['map_desc']).'</p>';}
            if ($atts['map_contact']) {$output.=do_shortcode('[contact-form-7 id="'.esc_attr($atts['map_contact']).'"]');}
        $output .='</div>';
    }                                           
$output .='</div>';
echo ($output);