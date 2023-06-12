<?php

/**
 * Template Name: One Page Template
 *
 * This is the template that displays One Page Layout and it has some additional options.
 *
 * @package ThemeWaves
 */
get_header();
the_post();
the_content();
wp_link_pages();
get_footer();