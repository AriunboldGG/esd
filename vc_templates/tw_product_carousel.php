<?php
/* ================================================================================== */
/*      Post Carousel Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element woocommerce tw-product-carousel tw-owl-carousel-container'),
    ),
    'animation_target' => '.product',//!important empty or (inner selector of .owl-item)
), vc_map_get_attributes($this->getShortcode(),$atts));

wp_enqueue_script('owl-carousel');

$query = array(
    'post_type' => 'product',
    'posts_per_page' => $atts['count'],
);
$atts['cats']=trim(trim($atts['cats']),',');
$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'product_cat',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}
list($output)=lvly_item($atts);
    $lvly_query = new WP_Query( $query );
    if ( $lvly_query->have_posts() ) {
        global $post;
        $output .= '<div class="owl-carousel owl-theme">';
            while( $lvly_query->have_posts() ) { $lvly_query->the_post();
                ob_start(); ?>
                    <div <?php post_class(); ?>>
                        <div class="shop-image-container tw-onhover visible"><?php
                            do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
                            <div class="uk-position-bottom"><?php
                                do_action( 'woocommerce_after_shop_loop_item' ); ?>
                            </div>
                        </div><?php
                            do_action( 'woocommerce_before_shop_loop_item' );
                            do_action( 'woocommerce_shop_loop_item_title' );
                            do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
                    </div><?php
                $output .= ob_get_clean();
            }
        $output .= "</div>";
        wp_reset_postdata();
    }

$output .= "</div>";
/* ================================================================================== */
echo ($output);