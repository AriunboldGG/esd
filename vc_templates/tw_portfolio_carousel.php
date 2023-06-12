<?php
/* ================================================================================== */
/*      Portfolio Carousel Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-portfolio tw-owl-carousel-container'),
    ),
    'animation_target' => '.portfolio-item',//!important empty or (inner selector of .owl-item)
), vc_map_get_attributes($this->getShortcode(),$atts));

wp_enqueue_script('owl-carousel');

$atts['layout']='carousel';
$atts['items'] = intval( $atts['items'] );
$atts['img_size'] = empty( $atts['disable_crop'] ) ? ( 'lvly_grid_col' . ( $atts['items'] > 4 ? 4 : $atts['items'] ) ) : 'full';
$query = array(
    'post_type' => 'portfolio',
    'posts_per_page' => $atts['count'],
);
$atts['cats']=trim(trim($atts['cats']),',');
$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'portfolio_cat',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}
list($output)=lvly_item($atts);
    $lvly_query = new WP_Query( $query );
    if ($lvly_query->have_posts()) {
        global $post;
        $output .= '<div class="owl-carousel owl-theme">';
            lvly_set_atts($atts);
            ob_start();
                while($lvly_query->have_posts()) { $lvly_query->the_post();
                    get_template_part( 'template/loop/port', $atts['content_type']);
                }
            $output .= ob_get_clean();
        $output .= "</div>";
        wp_reset_postdata();
    }
$output .= "</div>";
/* ================================================================================== */
echo ($output);