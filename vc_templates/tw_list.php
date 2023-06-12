<?php
/* ================================================================================== */
/*      List Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-list'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

vc_icon_element_fonts_enqueue($atts['icon']);
if ($atts['icon']==='fi_image') {
    $lrg_img=wp_get_attachment_image_src($atts['fi_image'], 'full');
    $iconimg= isset($lrg_img[0])?'<img src="' . esc_url($lrg_img[0]) . '" />':'';
}
list($output)=lvly_item($atts);

$list_style = $icon_color = '';
if (!empty($atts['list_style'])) {
    $list_style .= ' '.$atts['list_style'];
}
    $output .= '<ul class="uk-list'.$list_style.'">';
            $items = explode( ",", $atts['items'] );
            if (isset($iconimg)) {
                foreach($items as $item) {
                    $output .='<li>'.$iconimg.$item.'</li>';
                }
            } else {
                foreach($items as $item) {
                    $icon_here = '';
                    $data = explode( "|", $item );
                    if (!empty($data[1])) {
                        $icon_color = ' style="color:'.($data[1]).';"';
                    }elseif (!empty($atts['color'])) {
                        $icon_color = ' style="color:'.($atts['color']).';"';
                    }
                    if (!empty($data[2])) {
                        $icon_here = '<i class="fi '.$data[2].'"'.$icon_color.'></i>';
                    }elseif (isset($atts[$atts['icon']])) {
                        $icon_here = '<i class="fi '.$atts[$atts['icon']].'"'.$icon_color.'></i>';
                    }
                    $output .='<li>'.$icon_here.$data[0].'</li>';
                }
            }
    $output .= '</ul>';
$output .= '</div>';
echo ($output);