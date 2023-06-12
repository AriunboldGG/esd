<?php $atts = lvly_get_atts(); 
$media = '';
$media_padding = 'uk-padding-remove-bottom';
if (!empty($atts['media']) && $atts['media'] != 'none') {
    $media = call_user_func('lvly_portfolio_'.$atts['media'], $atts);
    if ($atts['media'] == 'gallery_slider') {
        $media_padding = 'uk-padding-remove';
    } elseif ($media) {
        $media = '<div class="uk-container">'.($media).'</div>';
    }
} elseif (empty($atts['media'])) {
    $media = lvly_image('full');
    $media_padding = 'uk-padding-remove';
}

if ($media) {
    echo '<section class="uk-section '.esc_attr($media_padding).'">';
            echo ($media);
    echo '</section>';
} ?>
<section class="uk-section uk-section-normal">
    <div class="uk-container">
        <div class="uk-grid-medium" data-uk-grid>
            <div class="uk-width-1-4@m">
                <div class="portfolio-single-title">
                    <?php 
                    echo '<h1 class="portfolio-title">'.get_the_title().'</h1>';
                    if (!empty($atts['sub_title'])) {
                        echo '<div class="portfolio-cats tw-meta">'.esc_attr($atts['sub_title']).'</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="uk-width-expand">
                <div class="portfolio-single-content">
                    <h3 class="portfolio-subtitle"><?php esc_html_e('Description', 'lvly');?></h3><?php
                    the_content();
                    wp_link_pages(); ?>
                </div>
            </div>
        </div>
        <hr class="uk-margin-large" />
        <div class="portfolio-single-meta uk-child-width-1-2@s uk-child-width-expand@m uk-grid-medium" data-uk-grid>
            <?php 
            if (lvly_get_option('portfolio_date')) {
                $date = lvly_portfolio_date();
                if ($date) {
                    echo '<div>'.($date).'</div>';
                }
            }
            if (lvly_get_option('portfolio_client')) {
                $client = lvly_portfolio_client($atts);
                if ($client) {
                    echo '<div>'.($client).'</div>';
                }
            }
            if (lvly_get_option('portfolio_cats')) {
                $cats = lvly_portfolio_cats($post);
                if ($cats) {
                    echo '<div>'.($cats).'</div>';
                }
            }
            if (lvly_get_option('portfolio_share')) {
                $share = lvly_portfolio_share();
                if ($share) {
                    echo '<div>'.($share).'</div>';
                }
            }
            ?>
        </div>
    </div>
</section>


<?php

if (!empty($atts['extra_content'])) {
    echo lvly_get_post_content_by_slug($atts['extra_content'],'lovelyblock');
}

$btn = lvly_portfolio_morebtn($atts);
if ($btn) {
    echo '<section class="uk-section uk-section-normal uk-padding-remove-top">';
        echo '<div class="uk-container uk-text-center">'.($btn).'</div>';
    echo '</section>';
} ?>

<div class="uk-container"><hr /></div>

<?php
if (lvly_get_option('portfolio_pagination')) {
    echo lvly_portfolio_nextprev($atts);
}