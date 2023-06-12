<?php 
/**
 * The template for Single Portfolio
 *
 * This is the template that displays All Portfolio Single.
 *
 * @package ThemeWaves
 */

get_header();
the_post();
lvly_seen_add();

$metaboxes = lvly_metas();
$metaboxes['video_min_height']=640;
$metaboxes['video_modal']=true;
$metaboxes['single_layout'] = empty( $metaboxes['single_layout'] ) ? '' : $metaboxes['single_layout'];
lvly_set_atts($metaboxes);

/**
 * Portfolio Single Content is located below path.
 */

get_template_part( 'template/portfolio/content', $metaboxes['single_layout']);

get_footer();