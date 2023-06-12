<?php

/**
 * Template Name: Magazine Page Template
 *
 * This is the template that displays Magazine Layout and it has some additional options.
 *
 * @package ThemeWaves
 */

get_header();
the_post();
the_content();
wp_link_pages();
get_footer();