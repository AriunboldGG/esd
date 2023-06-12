<?php 
/**
 * The template for Single
 *
 * This is the template that displays all Post Singles.
 *
 * @package ThemeWaves
 */

get_header();
the_post();
lvly_seen_add();

$format = get_post_format() == "" ? "standard" : get_post_format();

$metaboxes = lvly_metas();

$media_layout = !empty($metaboxes['single_media']) ? $metaboxes['single_media'] : lvly_get_option('single_media', 'small');
$single_layout = !empty($metaboxes['single_layout']) ? $metaboxes['single_layout'] : lvly_get_option('single_layout');
?>
<section class="uk-section uk-section-blog">
    <div class="uk-container">
        <?php 
            if ($media_layout == 'large') {
                echo '<div class="single-media-large">';
                    lvly_single_title();
                    $atts['img_size'] = 'full';
                    echo lvly_entry_media($format, $atts);
                echo '</div>';
            }
        ?>
        <div class="<?php echo esc_attr($single_layout); ?>" data-uk-grid>
            <div class="content-area uk-width-expand">
                <article <?php post_class('single'); ?>>
                    <div class="entry-post">
                        <?php 
                            if ($media_layout == 'small') {
                                lvly_single_title();
                                $atts['img_size'] = 'lvly_thumb';
                                echo lvly_entry_media($format, $atts);
                            } elseif ($media_layout == 'none') {
                                lvly_single_title();
                            }
                        ?>
                        <div class="entry-content uk-clearfix">
                        <?php
                            the_content();
                        ?>
                        </div><?php 
                            wp_link_pages();
                            if (lvly_get_option('single_tags')) {
                                echo get_the_tag_list(('<div class="entry-tags tw-meta"><h5>'.esc_html__('Tags', 'lvly').':</h5>'), '', '</div>');
                            }
                            if (lvly_get_option('single_share')) {
                                do_action( 'waves_entry_share' );
                            } ?>
                    </div>
                </article><?php
                if (lvly_get_option('single_pagination')) {
                    $prev = get_adjacent_post(false,'',true) ;
                    $next = get_adjacent_post(false,'',false) ; ?>
                    <div class="nextprev-postlink-container">
                        <div class="nextprev-postlink uk-flex">
                            <?php if ( isset($prev->ID) ):
                                $pid = $prev->ID; 
                                $img = wp_get_attachment_image_src( get_post_thumbnail_id($pid), 'thumbnail' );
                                if ($img['0']) {
                                    $thumb = '<div class="post-thumb"><div style="background-image: url('.esc_url($img['0']).')"></div></div>';
                                }else{
                                    $pformat = get_post_format( $pid ) == "" ? "standard" : get_post_format( $pid );
                                    $thumb = '<div class="post-thumb format-icon '.esc_attr($pformat).'"></div>';
                                } ?>
                                <div class="prev-post-link">
                                    <a href="<?php echo esc_url(get_permalink( $pid )); ?>" title="<?php echo get_the_title( $pid );?>"><?php echo ($thumb .'<div class="post-title">'.get_the_title( $pid ).'</div><span class="tw-meta">'.esc_html__('Previous Post', 'lvly').'</span>'); ?><i class="ion-ios-arrow-left"></i></a>
                                </div>
                            <?php endif;
                            if ( isset($next->ID) ):
                                $pid = $next->ID; 
                                $img = wp_get_attachment_image_src( get_post_thumbnail_id($pid), 'thumbnail' );
                                if ($img['0']) {
                                    $thumb = '<div class="post-thumb"><div style="background-image: url('.esc_url($img['0']).')"></div></div>';
                                }else{
                                    $pformat = get_post_format( $pid ) == "" ? "standard" : get_post_format( $pid );
                                    $thumb = '<div class="post-thumb format-icon '.esc_attr($pformat).'"></div>';
                                }?>
                                <div class="next-post-link">
                                    <a href="<?php echo esc_url(get_permalink( $pid )); ?>"><?php echo ($thumb .'<div class="post-title">'.get_the_title( $pid ).'</div><span class="tw-meta">'.esc_html__('Next Post', 'lvly').'</span>'); ?><i class="ion-ios-arrow-right"></i></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php }
                if (lvly_get_option('single_author')) {
                    lvly_author();
                }
                comments_template('', true); ?>
            </div>
            <?php 
                if ($single_layout != 'fullwidth-content' && $single_layout != 'narrow-content') {
                    get_sidebar();
                }
            ?>
        </div>
    </div>
</section>
<?php get_footer();