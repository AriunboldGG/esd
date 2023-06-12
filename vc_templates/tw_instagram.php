<?php
/* ================================================================================== */
/*      Instagram Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-instagram null-instagram-feed'),
    ),
    'animation_target' => '',
    //------------
    'layout'=>'carousel'
), vc_map_get_attributes($this->getShortcode(),$atts));

list($output)=lvly_item($atts);
    ob_start();
        $foo_insta = new waves_instagram_widget();
        $foo_insta->widget(array(), $atts);
    $output .= ob_get_clean();
$output .= '</div>';
/* ================================================================================== */
echo ($output);
