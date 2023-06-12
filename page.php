<?php

/**
 * The template for Page
 *
 * This is the template that displays all Pages.
 *
 * @package ThemeWaves
 */

get_header();
the_post();

/* Checking Visual Composer Enabled */
$post = get_post();
if ( $post && preg_match( '/vc_row/', $post->post_content ) ) {
    the_content();
}
/* Default Page content goes here */
else {
    ?>
    <section class="uk-section uk-section-normal">
        <div class="uk-container">
            <div class="page-content uk-clearfix"><?php
                the_content(); ?>
            </div>
            <?php wp_link_pages(); ?>
        <?php comments_template('', true); ?>
        </div>
    </section>
    <?php
}
get_footer();