<?php

/**
 * Template Name: FullScreen Page Template
 *
 * This is the template that displays FullScreen JS and it has some additional options.
 *
 * @package ThemeWaves
 */

get_header();
the_post();
    $sections='';
    $metaboxes = lvly_metas();
    if (isset($metaboxes['full_page_blocks']['section']['block'])&&is_array($metaboxes['full_page_blocks']['section']['block'])) {
        foreach($metaboxes['full_page_blocks']['section']['block'] as $i=>$slug) {
            if ($slug) {
                $sections .= lvly_get_post_content_by_slug($slug,'lovelyblock');
            }
        }
    }
    echo ($sections);
get_footer();