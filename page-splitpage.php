<?php

/**
 * Template Name: Split Page Template
 *
 * This is the template that displays Split Page JS and it has some additional options.
 *
 * @package ThemeWaves
 */

get_header();
the_post(); 
    $left=$right='';
    $metaboxes = lvly_metas();
    if (isset($metaboxes['split_page_blocks']['left']['block'])&&is_array($metaboxes['split_page_blocks']['left']['block'])&&isset($metaboxes['split_page_blocks']['right']['block'])&&is_array($metaboxes['split_page_blocks']['right']['block'])) {
        foreach($metaboxes['split_page_blocks']['left']['block'] as $i=>$slugL) {
            $slugR=isset($metaboxes['split_page_blocks']['right']['block'][$i])?$metaboxes['split_page_blocks']['right']['block'][$i]:'';
            $contL=$contR='<section class="tw-row uk-section"><h3 class="uk-text-center">'.esc_html__('Block Not Found','lvly').'</h3></section>';
            if ($slugL) {
                $contL = lvly_get_post_content_by_slug($slugL,'lovelyblock');
            }
            if ($slugR) {
                $contR = lvly_get_post_content_by_slug($slugR,'lovelyblock');
            }
            $left  .= '<div class="ms-section">'.$contL.'</div>';
            $right .= '<div class="ms-section">'.$contR.'</div>';
        }
    } ?>
    <div class="ms-left"><?php
        echo ($left); ?>
    </div>
    <div class="ms-right"><?php
        echo ($right); ?>
    </div><?php
get_footer();