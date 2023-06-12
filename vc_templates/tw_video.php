<?php
/* ================================================================================== */
/*      Video Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-video'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$atts['element_atts']['data-video-target'][] = '.tw-video-container';
$img=wp_get_attachment_image_src($atts['thumb'],'full');
$img=isset($img[0])?$img[0]:'';
$content='<div class="tw-video-frame" data-video-embed="' . esc_attr( rawurlencode($content) ) . '"></div>';
$vidContent='';
if ($atts['modal']==='true') {
    $atts['element_atts']['class'][] = 'with-modal';
    $vidContent .= '<div class="uk-modal-dialog uk-modal-dialog uk-width-auto uk-margin-auto-vertical">';
        $vidContent .= '<button class="uk-modal-close" type="button" data-uk-close></button>';
        $vidContent .= ($content);
    $vidContent .= '</div>';
}else{
    $vidContent .= ($content);
}

$atts['element_atts']['style'][] = 'min-height:'.esc_attr($atts['min_height']).'px;';
if ($img) {
    $atts['element_atts']['class'][] = 'uk-background-cover';
    $atts['element_atts']['style'][] = 'background-image: url('.esc_url($img).');';
}
$styleBtn=$styleBtnBA=$styleIcon='';
if ($atts['play_btn_color_bg']) {
    $styleBtn  =' style="background-color:'.esc_attr($atts['play_btn_color_bg']).';"';
    $styleBtnBA=' style="border-color:'.esc_attr($atts['play_btn_color_bg']).';"';
}
if ($atts['play_btn_color']) {
    $styleIcon =' style="color:'.esc_attr($atts['play_btn_color']).';"';
}


list($output)=lvly_item($atts);
    $output .= '<div class="tw-thumbnail">';
        $output .= '<button type="button" class="tw-video-icon"'.($styleBtn).'><span class="before"'.($styleBtnBA).'></span><i class="ion-play"'.($styleIcon).'></i><span class="after"'.($styleBtnBA).'></span></button>';
    $output .= '</div>';
    $output .= '<div class="tw-video-container tw-invis">';
        $output .= ($vidContent);
    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);