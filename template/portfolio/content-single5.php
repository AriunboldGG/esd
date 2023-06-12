<?php $atts = lvly_get_atts(); 
$media = '';

$classContent           = 'uk-padding-large uk-padding-remove-horizontal uk-width-1-1';
$classContentSub        = 'uk-width-1-1';
$classContentContainer  = 'uk-container';
$classMedia             = 'uk-width-1-1 uk-width-1-2@m';

$paddingMedia = ' uk-padding-large uk-padding-remove-horizontal tw-padding-20-left';
if ( ! empty( $atts['media'] ) && $atts['media'] != 'none' ) {
    $media = call_user_func( 'lvly_portfolio_' . $atts['media'], $atts );
} elseif ( empty( $atts['media'] ) ) {
    $media = lvly_image( 'full' );
} 
if ( $media ) {
    $classContent           .= ' uk-width-1-2@m';
    $classContentSub        .= ' uk-width-2-3@m';
    $classContentContainer  .= ' tw-container-half uk-padding-remove uk-align-right';
}
$classMedia .= $paddingMedia;

if ( ! empty( $atts['custom_class_media'] ) ) {
    $classMedia         = $atts['custom_class_media'];
}
if ( ! empty( $atts['custom_class_content'] ) ) {
    $classContent       = $atts['custom_class_content'];
}
if ( ! empty( $atts['custom_class_content_sub'] ) ) {
    $classContentSub    = $atts['custom_class_content_sub'];
}
if ( ! empty( $atts['sticky_sidebar'] ) ) {
    $classMedia         .= ' sticky-sidebar';
    $classContent       .= ' sticky-sidebar';
    wp_enqueue_script( 'ResizeSensor' );
    wp_enqueue_script( 'theia-sticky-sidebar' );
} ?>
<section class="uk-section uk-padding-remove uk-position-relative"><?php
    if( ! $media ){ ?>
        <div class="uk-container"><?php
    } ?>
        <div<?php if ( ! $media ) { echo ( ' class="uk-grid-collapse"' ); } ?> data-uk-grid>
            <div class="<?php echo esc_attr( $classContent ); ?>">
                <div class="<?php echo esc_attr( $classContentContainer ); ?>">
                    <div data-uk-grid>
                        <div class="<?php echo esc_attr( $classContentSub ); ?>">
                            <div class="portfolio-single-title"><?php 
                                echo '<h1 class="portfolio-title">'.get_the_title().'</h1>';
                                if (!empty($atts['sub_title'])) {
                                    echo '<div class="portfolio-cats tw-meta">'.esc_attr($atts['sub_title']).'</div>';
                                } ?>
                            </div>
                            <div class="portfolio-single-content"><?php
                                the_content();
                                wp_link_pages(); ?>
                            </div>
                            <ul class="portfolio-single-meta"><?php
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
                                } ?>
                            </ul>
                            <?php echo lvly_portfolio_morebtn($atts); ?>
                        </div>
                    </div>
                </div>
            </div><?php 
            if ( $media ) {
                echo '<div class="' . esc_attr( $classMedia ) . '">';
                    echo ( $media );
                echo '</div>';
            } ?>
        </div><?php
    if( ! $media ) { ?>
        </div><?php
    } ?>
</section><?php 
if ( ! empty( $atts['extra_content'] ) ) {
    echo lvly_get_post_content_by_slug( $atts['extra_content'], 'lovelyblock' );
}

echo lvly_portfolio_nextprev( $atts );