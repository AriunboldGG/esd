<?php
/* ================================================================================== */
/*      Client Item Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

global $lvly_parentAtts;
$link = vc_build_link( $atts['link'] );
$output = '';
$lvly_parentAtts['cnt']++;

$clmn= intval(str_replace('col', '', $lvly_parentAtts['column']));

if ($lvly_parentAtts['cnt']%$clmn===1) {
    if ($lvly_parentAtts['cnt']>1) {
        $output .= '</div><hr class="uk-margin-remove" />';
    }
    $colClss='';
    switch ($lvly_parentAtts['column']) {
        case 'col2':
            $colClss .= 'uk-child-width-1-1 uk-child-width-1-2@s';
        break;
        case 'col3':
            $colClss .= 'uk-child-width-1-1 uk-child-width-1-3@m';
        break;
        case 'col4':
            $colClss .= 'uk-child-width-1-1@xs uk-child-width-1-2@s uk-child-width-1-4@m';
        break;
        case 'col5':
            $colClss .= 'uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m';
        break;
        case 'col6':
            $colClss .= 'uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-6@m';
        break;
    }
    $output .= "<div class='".esc_attr($colClss)." uk-flex-middle' data-uk-grid>";
}


    $output .= '<div>';
        $output .= '<div class="client-item uk-padding-small'.esc_attr($lvly_parentAtts['hover']).'">';
            $tag = 'div';
            $href = '';
            if (!empty($link['url'])) {
                $tag = 'a';
                $href = ' href="'.esc_url($link['url']).'"';
            }
            $output .= '<'.($tag . $href).(empty($atts['title'])?'':(' title="'.esc_attr($atts['title']).'" data-uk-tooltip')).'>';
                $lrg_img=wp_get_attachment_image_src($atts['img'], 'full');
                if (!empty($lrg_img[0])) {
                    $output .= '<img alt="' . esc_attr($atts['title']) . '" src="' . esc_url($lrg_img[0]) . '" '.(!empty($lvly_parentAtts['opacity']) ? (' style="opacity: '.$lvly_parentAtts['opacity'].'"') : '').' />';
                    if (!empty($lvly_parentAtts['hover'])) {
                        $output .= '<img alt="' . esc_attr($atts['title']) . '" src="' . esc_url($lrg_img[0]) . '" />';
                    }
                } else {
                    $output .= '<h1>'.$atts['title'].'</h1>';
                }
            $output .= '</'.$tag.'>';
        $output .= '</div>';
    $output .= '</div>';
/* ================================================================================== */
echo ($output);