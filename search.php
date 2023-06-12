<?php

/**
 * The template for Search Result
 *
 * This is the template that displays Your Searched query Result.
 *
 * @package ThemeWaves
 */

get_header();
    lvly_set_options(array(
        'pagination'    => '',
        'img_size'      => 'lvly_thumb',
        'excerpt_count' => 200,
        'footer_layout' => '',
    ));
    $atts = array(
        'img_size'      => 'lvly_thumb',
        'more_text'     => lvly_get_option( 'more_text', esc_html__( 'Read more', 'lvly' ) ),
        'excerpt_count' => lvly_get_option( 'blog_excerpt' ),
        'pagination'    => lvly_get_option( 'blog_pagination', 'normal' ),
        'sidebar'       => lvly_get_option( 'blog_sidebar', 'right-sidebar' ),
    );
    $blog_layout = ( ! empty( $atts['sidebar'] ) && $atts['sidebar'] != 'none' ) ? $atts['sidebar'] : '';
    lvly_set_atts( $atts );
    echo '<section class="uk-section uk-section-blog">';
        echo '<div class="uk-container">';
            echo '<div class="' . esc_attr( $blog_layout ) . '" data-uk-grid>';
                echo '<div class="content-area uk-clearfix uk-width-expand@m">';
                if ( have_posts() ) {
                    echo '<div class="tw-blog">';
                        while ( have_posts() ) { the_post();
                            get_template_part( 'template/loop/post' );
                        }
                    echo '</div>';
                    if ( $atts['pagination'] ) {
                        lvly_pagination( $atts );
                    }
                } else { ?>
                    <h3 class="uk-margin-bottom"><?php esc_html_e("Sorry, Your search has no Results.", 'lvly'); ?></h3>
                    <div class="uk-margin-bottom">
                        <?php get_search_form(); ?>
                    </div>
                    <p><?php esc_html_e("For best search results, mind the following suggestions:", 'lvly');?></p>
                    <ul>
                        <li><?php esc_html_e("Always double check your spelling.", 'lvly');?></li>
                        <li><?php esc_html_e("Try similar keywords, for example: tablet instead of laptop.", 'lvly');?></li>
                        <li><?php esc_html_e("Try using one keyword more than many.", 'lvly');?></li>
                    </ul><?php
                }
                echo '</div>';
                if ( $blog_layout ) {
                    get_sidebar();
                }
            echo '</div>';
        echo '</div>';
    echo '</section>';
get_footer();