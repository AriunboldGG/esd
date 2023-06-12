<?php $atts = lvly_get_atts(); 
$media = '';
$classContent = 'uk-width-1-1';
$classMedia = 'uk-width-2-3@m uk-width-1-1';
if (!empty($atts['media']) && $atts['media'] != 'none') {
    $media = call_user_func('lvly_portfolio_'.$atts['media'], $atts);
} elseif (empty($atts['media'])) {
    $media = lvly_image('full');
} ?>
<section class="uk-section uk-section-normal uk-padding-remove-bottom">
    <div class="uk-container">
        <div class="uk-grid-medium" data-uk-grid><?php 
            if ( $media ) {
                $classContent .= ' uk-width-1-3@m';
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
                }
                echo '<div class="' . esc_attr( $classMedia ) . '">' . ( $media ) . '</div>';
            }
            echo '<div class="' . esc_attr( $classContent ) . '">';
                echo '<div class="portfolio-single-title">';
                    echo '<h1 class="portfolio-title">'.get_the_title().'</h1>';
                    if ( ! empty( $atts['sub_title'] ) ) {
                        echo '<div class="portfolio-cats tw-meta">' . esc_attr( $atts['sub_title'] ) . '</div>';
                    }
                echo '</div>';
                echo '<div class="portfolio-single-content">';
                    the_content();
                    wp_link_pages();
                echo '</div>';
                echo '<ul class="portfolio-single-meta">';
                    if (lvly_get_option('portfolio_date')) {
                        echo lvly_portfolio_date();
                    }
                    if (lvly_get_option('portfolio_client')) {
                        echo lvly_portfolio_client($atts);
                    }
                    if (lvly_get_option('portfolio_cats')) {
                        echo lvly_portfolio_cats($post);
                    }
                    if (lvly_get_option('portfolio_share')) {
                        echo lvly_portfolio_share();
                    }
                echo '</ul>';
                echo lvly_portfolio_morebtn($atts);
            echo '</div>';
            ?>
        </div>        
    </div>
</section>

<?php 
if ( lvly_get_option( 'portfolio_pagination' ) ) {
    echo lvly_portfolio_nextprev( $atts );
}