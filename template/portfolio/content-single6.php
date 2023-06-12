<?php $atts = lvly_get_atts(); 
$media = '';

$classContent = 'uk-width-1-1';
$classMedia   = 'uk-width-expand';

if ( ! empty( $atts['media'] ) && $atts['media'] != 'none' ) {
    $media = call_user_func( 'lvly_portfolio_' .$atts['media'], $atts );
} elseif ( empty( $atts['media'] ) ) {
    $media = lvly_image('full');
} 
if ( $media ) {
    $classContent = 'portfolio-single6-content';
}

if ( ! empty( $atts['custom_class_media'] ) ) {
    $classMedia = $atts['custom_class_media'];
}
if ( ! empty( $atts['custom_class_content'] ) ) {
    $classContent = $atts['custom_class_content'];
}
if ( ! empty( $atts['sticky_sidebar'] ) ) {
    $classContent .= ' sticky-sidebar';
    $classMedia .= ' sticky-sidebar';
    wp_enqueue_script( 'ResizeSensor' );
    wp_enqueue_script( 'theia-sticky-sidebar' );
} ?>
<section class="uk-section uk-section-small uk-padding-large uk-padding-remove-bottom">
    <div class="uk-padding uk-padding-remove-bottom">
        <div class="uk-grid-large" data-uk-grid>
            <div class="<?php echo esc_attr( $classContent );?>">
                <div class="portfolio-single-title"><?php
                    echo '<h1 class="portfolio-title">' . get_the_title() . '</h1>';
                    if ( ! empty( $atts['sub_title'] ) ) {
                        echo '<div class="portfolio-cats tw-meta">' . esc_attr( $atts['sub_title'] ) . '</div>';
                    } ?>
                </div>
                <div class="portfolio-single-content"><?php
                    the_content();
                    wp_link_pages(); ?>
                </div>
                <ul class="portfolio-single-meta"><?php
                    if ( lvly_get_option( 'portfolio_date' ) ) {
                        echo lvly_portfolio_date();
                    }
                    if ( lvly_get_option( 'portfolio_client' ) ) {
                        echo lvly_portfolio_client( $atts );
                    }
                    if ( lvly_get_option( 'portfolio_cats' ) ) {
                        echo lvly_portfolio_cats( $post );
                    }
                    if ( lvly_get_option( 'portfolio_share' ) ) {
                        echo lvly_portfolio_share();
                    } ?>
                </ul>
                <?php echo lvly_portfolio_morebtn( $atts ); ?>
            </div><?php
            if ( $media ) {
                echo '<div class="' . esc_attr( $classMedia ) . '">' . ( $media ) . '</div>';
            } ?>
        </div>
    </div>
</section><?php 
if ( ! empty( $atts['extra_content'] ) ) {
    echo lvly_get_post_content_by_slug( $atts['extra_content'], 'lovelyblock' );
}
$atts['full_navigation'] = true;
if (lvly_get_option('portfolio_pagination')) {
    echo lvly_portfolio_nextprev($atts);
}