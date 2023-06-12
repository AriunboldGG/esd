<?php $atts = lvly_get_atts(); 
$media = '';
if (!empty($atts['media']) && $atts['media'] != 'none') {
    $media = call_user_func('lvly_portfolio_'.$atts['media'], $atts);
} elseif (empty($atts['media'])) {
    $media = lvly_image('full');
} ?>

<section class="uk-section uk-section-normal">
    <div class="uk-container">
        <div class="uk-grid-medium" data-uk-grid>
            <div class="uk-width-1-4@l">
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
            <div class="uk-width-1-3@m">
                <ul class="portfolio-single-meta">
                    <?php
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
                    ?>
                </ul>
                <?php echo lvly_portfolio_morebtn($atts); ?>
            </div>
        </div>
    </div>
</section>

<?php
if ($media) { 
    echo '<section class="uk-section uk-section-normal uk-padding-remove-top">';
    echo '<section class="uk-section uk-section-normal uk-padding-remove-top">';
        echo '<div class="uk-container">';
            echo ($media);
        echo '</div>';
    echo '</section>';
}

if (!empty($atts['extra_content'])) {
    echo lvly_get_post_content_by_slug($atts['extra_content'],'lovelyblock');
} ?>
<div class="uk-container"><hr /></div>

<?php 
if (lvly_get_option('portfolio_pagination')) {
    echo lvly_portfolio_nextprev($atts);
}