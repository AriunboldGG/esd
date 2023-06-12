<?php
/* ================================================================================== */
/*      Portfolio Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-portfolio'),
        'data-item-selector'=>array('.portfolio-item'),
    ),
    'animation_target' => '.portfolio-item',
), vc_map_get_attributes($this->getShortcode(),$atts));


if ($atts['pagination']==='infinite') {
    $atts['element_atts']['class'][]='tw-infinite-container';
}

      
if ($atts['filter_style'] == 'filter-modern') {
    $atts['element_atts']['class'][] = $atts['filter_style'];  
}

$columnClass = 'uk-child-width-1-2@s uk-child-width-1-3@m';
switch ($atts['column']) {
    case 'col4':
        $columnClass = 'uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l';
        break;
    case 'col2':
        $columnClass = 'uk-child-width-1-2@s uk-child-width-1-2@m';
        break;
}
$layout=in_array($atts['layout'], array('masonry', 'grid'))?$atts['content_type']:$atts['layout'];
switch($atts['layout']) {
    case'masonry':
        $atts['img_size'] = empty($atts['disable_crop'])?'lvly_masonry_'.$atts['column']:'full';
        $atts['element_atts']['data-layout'][]=$atts['layout'];
    break;
    case'metro':
        $atts['element_atts']['data-layout'][]=$atts['layout'];
        $layout='inside';
        $atts['hover'] = $atts['hover_metro'];
    break;
    case'grid':
        $atts['img_size'] = empty($atts['disable_crop'])?'lvly_grid_'.$atts['column']:'full';
        $atts['element_atts']['data-layout'][]=$atts['layout'];
    break;
    case'promo':
        $atts['img_size'] = empty($atts['disable_crop'])?'lvly_port_promo':'full';
    break;
    default:
        $atts['img_size'] = 'full';
}

$query = array(
    'post_type' => 'portfolio',
    'posts_per_page' => $atts['count'],
);

/* Pagination Fix - NOT Overriding WordPress globals */
if ($atts['pagination']) {
    global $paged, $page;
    if (is_front_page() && $page) {
        $paged = $page;
    }
    $query['paged'] = $paged;
}
if (!empty($atts['not_in'])) {
    $query['post__not_in'] = array($atts['not_in']);
}
$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'portfolio_cat',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}

$lvly_query = new WP_Query( $query );

$output = '';
if ( $lvly_query->have_posts() ) {
    if ( in_array( $atts['layout'], array( 'parallax', 'promo' ) ) ) {
        $atts['cntr']=0;
        $atts['element_atts']['class'][]=$atts['layout'];
        if ($atts['layout']==='parallax') {
            $atts['element_atts']['class'][]='uk-light';
        }
        ob_start();
            while($lvly_query->have_posts()) { $lvly_query->the_post();
                lvly_set_atts($atts); /* important in while for $atts['cntr'] */
                get_template_part( 'template/loop/port', $layout);
                $atts['cntr']++;
            }
        $output .= ob_get_clean();
    } else {
        wp_enqueue_script( 'isotope' );
        $contClass = $columnClass . ' ' . $atts['gutter'];

        $atts['element_atts']['class'][]='tw-isotope-container';
        if ($atts['filter']) {
            $atts['element_atts']['class'][] = 'tw-filter-container';
            $atts['element_atts']['data-filter'][] = $atts['filter'];
            $outputFilter = '<ul class="tw-filter-list uk-list">';
                $outputFilter .= '<li><span data-filter="*">'.lvly_get_option('portfolio-show', esc_html__( 'Show All', 'lvly')).'</span></li>';
                if ($cats) {
                    $filters = $cats;
                } else {
                    $filters = get_terms('portfolio_cat');
                }
                foreach ($filters as $category) {
                    if ($cats) {
                        $category = get_term_by('slug', $category, 'portfolio_cat');
                    }
                    $outputFilter .= '<li class="hidden"><span data-filter=".category-' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</span></li>';
                }
            $outputFilter .= '</ul>';


            $filterClass='uk-text-center';
            $filterTextClass= '';
            if ($atts['filter_style'] == 'filter-right') {
                if (!empty($atts['filter_title'])){
                    $filterTextClass= ' uk-light';
                }
                $filterClass='uk-text-right filter-with-title';
                $output .= '<div class="uk-container">';
                    $output .= '<div class="uk-grid '.esc_attr($filterTextClass).' uk-margin-large-bottom uk-margin-large-top uk-child-width-expand@m" data-uk-grid>';
                        $output .= '<div class="uk-width-auto@m">';
                            $output .= '<div class="uk-text-left uk-visible@m">';
                                $output .= '<h3 class="uk-text-uppercase uk-margin-remove-bottom">'.esc_html($atts['filter_title']).'</h3>';
                            $output .= '</div>';
                            $output .= '<div class="uk-text-right uk-hidden@m">';
                                $output .= '<h3 class="uk-text-uppercase uk-margin-remove-bottom">'.esc_html($atts['filter_title']).'</h4>';
                            $output .= '</div>';
                        $output .= '</div>';
            }
                        $output .= '<div class="tw-filter-list-outer uk-text-uppercase '.esc_attr($filterClass).'"'.($atts['filter_title']?' data-abs="background:#151515;height:240px;"':'').'>';
                            $output .= ($outputFilter);
                        $output .= '</div>';
            if ($atts['filter_style'] == 'filter-right') {
                    $output .= '</div>';
                $output .= '</div>';
            }
        }
        $contClass.=' isotope-container';

        if ($atts['filter_style'] == 'filter-modern') {
            $output .= '<div class="isotope-wrapper">';
        }
        $output .= '<div class="'.esc_attr($contClass).'" data-uk-grid>';
            lvly_set_atts($atts);
            ob_start();
                while($lvly_query->have_posts()) { $lvly_query->the_post();
                    get_template_part( 'template/loop/port', $layout);
                }
            $output .= ob_get_clean();
        $output .= '</div>';

        if ($atts['filter_style'] == 'filter-modern') {
            $output .= '</div>';
        }
    }
    if ($atts['pagination']) {
        $atts['query']=$lvly_query;
        $output .= lvly_pagination($atts,true);
    }
    wp_reset_postdata();
}
$output = lvly_item($atts)[0].$output ."</div>";
/* ================================================================================== */
echo ($output);