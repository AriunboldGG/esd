<?php
/* ================================================================================== */
/*      Blog Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-blog'),
    ),
    'animation_target' => 'article.post',
), vc_map_get_attributes($this->getShortcode(),$atts));

$layout   = $conClass = '';
$sidebar  = $atts['sidebar'];
if ( $atts['layout'] == 'minimal' ) {
    /* Minimal Layout */
    $sidebar = '';
    $layout = $atts['layout'];
    $atts['element_atts']['class'][] = 'minimal-blog';
} elseif ( $atts['layout'] ) {
    /* Grid Layouts */
    $atts['element_atts']['data-uk-grid'][] = '';
    $atts['element_atts']['class'][]        =  $atts['gutter'];
    $atts['element_atts']['class'][]        = 'grid-blog';
    $atts['element_atts']['class'][]        = 'uk-child-width-1-1@xxs uk-child-width-1-1@xs uk-child-width-1-2@s';
    
    if ( $atts['column'] == 'col3' ) {
        $atts['element_atts']['class'][] = 'uk-child-width-1-3@m';
    }elseif ( $atts['column'] == 'col4' ) {
        $atts['element_atts']['class'][] = 'uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l';
    }
    if ( $atts['content_type'] == 'inside' ) {
        $layout = 'inside';
    } else {
        $layout = 'under';
    }    
    if ( in_array( $atts['layout'], array( 'metro', 'masonry' ) ) ) {
        wp_enqueue_script( 'isotope' );
        if ( $atts['layout'] == 'metro' ) {
            $layout = 'inside';
            $atts['inside'] = $atts['metro_layout'];
        } else {
            $atts['img_size'] = empty( $atts['disable_crop'] )  ? ( 'lvly_masonry_' . $atts['column'] ) : 'full';
        }
        $atts['element_atts']['class'][] = 'isotope-container';
        $conClass .= ' tw-isotope-container';
    } else {
        $atts['img_size'] = empty( $atts['disable_crop'] ) ? ( 'lvly_grid_'.$atts['column'] ) : 'full';
    }
}else{
    /* Simple Layout */
    $atts['img_size'] = empty($atts['disable_crop'])?'lvly_thumb':'full';
}

$query = array(
    'post_type' => 'post',
    'posts_per_page' => $atts['posts_per_page'],
);

/* Pagination Fix - NOT Overriding WordPress globals */
if ($atts['pagination']) {
    global $paged, $page;
    if (is_front_page() && $page) {
        $paged = $page;
    }
    $query['paged'] = $paged;
    if ($atts['pagination']==='infinite') {
        $conClass .= ' tw-infinite-container';
    }
}
$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'category',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}

echo '<div data-uk-grid>';
    echo '<div class="content-area uk-width-expand@m' . esc_attr( $conClass ) . '"' . ( $conClass ? ( ' data-item-selector="article.post"' . ( $atts['layout'] == 'metro' ? ( 'data-layout="metro" data-metro-height="' . esc_attr( $atts['metro_height'] ) . '"' ) : '' ) ) : '' ) . '>'; /* data-item-selector - use with tw-isotope-container or tw-infinite-container*/
        $lvly_query = new WP_Query( $query );
        if ( $lvly_query->have_posts() ) {
            echo lvly_item($atts)[0];
                lvly_set_atts( $atts );
                $meta_layout = '';
                while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                    if ( ! empty( $atts['layout'] ) && $atts['layout'] != 'minimal' ) {
                        $excerpt_count = $atts['excerpt_count'];
                        $inside = $atts['inside'];
                        $under = $atts['under'];
                        $post_layout = $layout;
                        if ( $atts['layout'] != 'metro' ) {
                            $meta_layout = lvly_meta( 'blog_layout' );
                            switch ( $meta_layout ) {
                                case 'inside':
                                    $post_layout = 'inside';
                                    $atts['inside'] = '';
                                    $atts['excerpt_count'] = 0;
                                    break;
                                case 'under':
                                    $post_layout = 'under';
                                    $atts['under'] = 'date';
                                    $atts['excerpt_count'] = 0;
                                    break;
                                case 'under-content':
                                    $post_layout = 'under';
                                    $atts['under'] = 'btn';
                                    break;
                            }
                        }
                        lvly_set_atts( $atts );
                        get_template_part( 'template/loop/post', $post_layout );
                        /* custom layouts need to restore default atts */
                        if ( $meta_layout ) {
                            $atts['excerpt_count'] = $excerpt_count;
                            $atts['inside'] = $inside;
                            $atts['under'] = $under;
                        }
                    } else {
                        get_template_part( 'template/loop/post', $layout );
                    }
                }
            echo '</div>';
            if ($atts['pagination']) {
                $atts['query']=$lvly_query;
                lvly_pagination($atts);
            }
            wp_reset_postdata();
        }
    echo '</div>';
    if ($sidebar) {
        $class = '';
        if (lvly_get_option('sidebar_affix')) {
            $class = ' sticky-sidebar'; 
            wp_enqueue_script('ResizeSensor');
            wp_enqueue_script('theia-sticky-sidebar');
        }
        echo '<div class="sidebar-area'.esc_attr($class).'">';
            echo '<div class="sidebar-inner">';
                if ( is_active_sidebar( $sidebar )  ) {
                    dynamic_sidebar($sidebar);
                } 
            echo '</div>';
        echo '</div>';
    }
echo '</div>';