<?php
/* ================================================================================== */
/*      Image Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-gallery'),
    ),
    'animation_target' => '> .gallery-item',
), vc_map_get_attributes($this->getShortcode(),$atts));

$conClass='uk-child-width-1-1@xxs';
$justMargs=false;
if ($atts['layout']==='justified') {
    wp_enqueue_style ('justifiedGallery');
    wp_enqueue_script('jquery-justifiedGallery');
    switch($atts['gutter']) {
        case 'uk-grid-collapse':
            $justMargs=0;
        break;
        case 'uk-grid-large':
            $justMargs=70;
        break;
        case 'uk-grid-medium':
            $justMargs=30;
        break;
        case 'uk-grid-small':
            $justMargs=15;
        break;
        case 'uk-grid-xsmall':
            $justMargs=10;
        break;
        default:
            $justMargs=40;
    }
    $conClass .=' tw-justified-gallery';
    $atts['element_atts']['class'][] = 'tw-justified-gallery-container';
    $atts['element_atts']['data-item-selector'][] = '.tw-justified-gallery>*';
    $atts['element_atts']['data-margins'][] = $justMargs;
    $atts['element_atts']['data-row-height'][] = $atts['row_height'];
    $atts['element_atts']['data-row-height-max'][] = $atts['row_height_max']?'true':'false';
    $atts['lightbox']='true';
}elseif ($atts['layout']==='masonry') {
    wp_enqueue_script( 'isotope' );
    $conClass .=' isotope-container';
    $atts['element_atts']['class'][] = 'tw-isotope-container';
    $atts['element_atts']['data-item-selector'][] = '.gallery-item';
    $conClass .=' '.$atts['gutter'];
    switch($atts['column']) {
        case 'col4':
            $conClass .=' uk-child-width-1-2@xs uk-child-width-1-3@s uk-child-width-1-4@m';
        break;
        case 'col3':
            $conClass .=' uk-child-width-1-2@xs uk-child-width-1-3@s';
        break;
        case 'col2':
            $conClass .=' uk-child-width-1-2@xs uk-child-width-1-2@s';
        break;
        default:
            $conClass .=' uk-child-width-1-1';
    }
}

$output = '';
if ($atts['filter']) {
    $atts['element_atts']['class'][] = 'tw-filter-container';
    $atts['element_atts']['data-filter'][] = $atts['filter'];
    $outputFilter = '<ul class="tw-filter-list uk-list">';
        $outputFilter .= '<li><span data-filter="*">'.lvly_get_option('gallery-show', esc_html__( 'Show All', 'lvly')).'</span></li>';
        $filters = get_terms('attachment_cat');
        foreach ($filters as $category) {
            $outputFilter .= '<li class="hidden"><span data-filter=".category-' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</span></li>';
        }
    $outputFilter .= '</ul>';


    $filterClass='uk-text-center';
    if ($atts['filter_title']) {
        $filterClass='uk-text-right filter-with-title';
        $output .= '<div class="uk-container">';
            $output .= '<div class="uk-grid uk-margin-large-bottom uk-margin-large-top uk-child-width-expand@m" data-uk-grid>';
                $output .= '<div class="uk-width-auto@m">';
                    $output .= '<div class="uk-text-left uk-visible@m">';
                        $output .= '<h2 class="uk-text-uppercase uk-margin-remove-bottom">'.esc_html($atts['filter_title']).'</h2>';
                    $output .= '</div>';
                    $output .= '<div class="uk-text-right uk-hidden@m">';
                        $output .= '<h2 class="uk-text-uppercase uk-margin-remove-bottom">'.esc_html($atts['filter_title']).'</h2>';
                    $output .= '</div>';
                $output .= '</div>';
    }
                $output .= '<div class="tw-filter-list-outer uk-text-uppercase '.esc_attr($filterClass).'"'.($atts['filter_title']?' data-abs="background:#fff;height:137px;"':'').'>';
                    $output .= ($outputFilter);
                $output .= '</div>';
    if ($atts['filter_title']) {
            $output .= '</div>';
        $output .= '</div>';
    }
}
$output .= '<div class="'.esc_attr($conClass).'"'.($atts['layout']==='masonry'?' data-uk-grid':'').' data-uk-lightbox="toggle: .tw-image-hover;">';
    if (!empty($atts['images'])) {
        $images = explode(',', $atts['images']);
        foreach($images as $image) {
            if ($image && $img=wp_get_attachment_image_src($image, 'full')) {
                $description = $caption = '';
                $desc = get_post_field('post_excerpt', $image);
                if ($desc) {
                    $description = ' alt="' . esc_attr($desc) . '"';
                    $caption = ' data-caption="' . esc_attr($desc) . '"';
                }
                $itemClass='';
                $cats = wp_get_post_terms($image, 'attachment_cat');
                foreach ($cats as $catalog) {
                    $itemClass .= " category-" . $catalog->slug;
                }
                if ($atts['layout']==='masonry') {
                    $output .= '<div class="gallery-item '.esc_attr($itemClass).'"><div class="gallery-image">';
                }
                    if ($atts['lightbox']) {
                        $output .= '<a href="' . esc_url($img[0]) . '" class="tw-image-hover '.($atts['layout']==='justified'?esc_attr($itemClass):'').'"'.($caption).'>';
                            $output .= '<img src="' . esc_url($img[0]) . '"' . ($description) . ' />';
                        $output .= '</a>';
                    } else {
                        $output .= '<img src="' . esc_url($img[0]) . '"' . ($description) . ($atts['layout']==='justified'?(' class="'.esc_attr($itemClass).'"'):'').' />';
                    }
                if ($atts['layout']==='masonry') {
                    $output .= '</div></div>';
                }
            }
        }
    }
$output .= '</div>';
$output = lvly_item($atts)[0].$output ."</div>";
/* ================================================================================== */
echo ($output);