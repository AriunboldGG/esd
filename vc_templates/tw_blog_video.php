<?php
/* ================================================================================== */
/*      Blog-Home-VIDEO-ESD Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-blog-video'),
    ),
    'animation_target' => 'article.post',
), vc_map_get_attributes($this->getShortcode(),$atts));

$atts['element_atts']['data-video-target'][] = '.tw-video-container';
$sticky = get_option( 'sticky_posts' );

$link = vc_build_link( $atts['link'] );

$query = array(
    'post_type' => 'post',
    'showposts'     => -1,
    'post__not_in' => $sticky
);

$query_sticky = array(
    'posts_per_page' => -1,
    'post__in'  => $sticky
);

$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query_sticky['tax_query'] = $query['tax_query'] = Array(Array(
            'taxonomy' => 'category',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}

echo lvly_item($atts)[0];

    if($link['url']) {
        echo '<div class="tw-home-blog-link">';
            echo '<a href="' . $link['url'] . '">' . $link['title'] . '
                <span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M17.9199 6.62C17.8185 6.37565 17.6243 6.18147 17.3799 6.08C17.2597 6.02876 17.1306 6.00158 16.9999 6H6.99994C6.73472 6 6.48037 6.10536 6.29283 6.29289C6.1053 6.48043 5.99994 6.73478 5.99994 7C5.99994 7.26522 6.1053 7.51957 6.29283 7.70711C6.48037 7.89464 6.73472 8 6.99994 8H14.5899L6.28994 16.29C6.19621 16.383 6.12182 16.4936 6.07105 16.6154C6.02028 16.7373 5.99414 16.868 5.99414 17C5.99414 17.132 6.02028 17.2627 6.07105 17.3846C6.12182 17.5064 6.19621 17.617 6.28994 17.71C6.3829 17.8037 6.4935 17.8781 6.61536 17.9289C6.73722 17.9797 6.86793 18.0058 6.99994 18.0058C7.13195 18.0058 7.26266 17.9797 7.38452 17.9289C7.50638 17.8781 7.61698 17.8037 7.70994 17.71L15.9999 9.41V17C15.9999 17.2652 16.1053 17.5196 16.2928 17.7071C16.4804 17.8946 16.7347 18 16.9999 18C17.2652 18 17.5195 17.8946 17.707 17.7071C17.8946 17.5196 17.9999 17.2652 17.9999 17V7C17.9984 6.86932 17.9712 6.74022 17.9199 6.62Z" fill="#3A96EC"/> </svg>
                </span>';
            echo '</a>';
        echo '</div>';
    }

    echo '<div class="it-video-player uk-margin-medium-bottom">';
        $outputHead = $outputBody = $meta_layout = '';

        // sticky posts
      
        $lvly_query = new WP_Query( $query_sticky );
        if ( $lvly_query->have_posts() ) {
            if ( $sticky ) {
            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                $outputHead .= '<div class="title-icon">';
                    $outputHead .= '<div class="uk-grid-small uk-flex-middle" data-uk-grid>';
                        $outputHead .= '<div class="uk-width-1-1 uk-width-5-12@s">';
                            $outputHead .= '<div class="entry-post">';
                                $outputHead .= '<div class="entry-thubnail">';
                                    $outputHead .= lvly_image('home-video-blog-other');
                                
                                $outputHead .= '</div>';
                                $outputHead .= '<div class="uk-position-center">';
                                    $outputHead .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 22.75H9C3.57 22.75 1.25 20.43 1.25 15V9C1.25 3.57 3.57 1.25 9 1.25H15C20.43 1.25 22.75 3.57 22.75 9V15C22.75 20.43 20.43 22.75 15 22.75ZM9 2.75C4.39 2.75 2.75 4.39 2.75 9V15C2.75 19.61 4.39 21.25 9 21.25H15C19.61 21.25 21.25 19.61 21.25 15V9C21.25 4.39 19.61 2.75 15 2.75H9Z" fill="white"/>
                                    <path d="M10.7598 16.3683C10.3398 16.3683 9.94984 16.2683 9.59984 16.0683C8.79984 15.6083 8.33984 14.6683 8.33984 13.4783V10.5183C8.33984 9.33834 8.79984 8.38834 9.59984 7.92834C10.3998 7.46834 11.4398 7.53834 12.4698 8.13834L15.0398 9.61834C16.0598 10.2083 16.6498 11.0783 16.6498 11.9983C16.6498 12.9183 16.0598 13.7883 15.0398 14.3783L12.4698 15.8583C11.8898 16.1983 11.2998 16.3683 10.7598 16.3683ZM10.7698 9.12834C10.6098 9.12834 10.4698 9.15834 10.3598 9.22834C10.0398 9.41834 9.84984 9.88834 9.84984 10.5183V13.4783C9.84984 14.1083 10.0298 14.5783 10.3598 14.7683C10.6798 14.9583 11.1798 14.8783 11.7298 14.5583L14.2998 13.0783C14.8498 12.7583 15.1598 12.3683 15.1598 11.9983C15.1598 11.6283 14.8498 11.2283 14.2998 10.9183L11.7298 9.43834C11.3698 9.22834 11.0398 9.12834 10.7698 9.12834Z" fill="white"/>
                                    </svg>';
                                $outputHead .= '</div>';
                            $outputHead .= '</div>';
                        $outputHead .= '</div>';

                        $outputHead .= '<div class="uk-width-1-1 uk-width-7-12@s tw-video-right">';
                                $outputHead .= '<div class="entry-content">';
                                    // $timeAgo = human_time_diff_mon( get_the_time('U'), current_time('timestamp') );
                                    // $outputHead .= '<span class="date">' . esc_attr($timeAgo) . '</span>';
                                    $outputHead .= '<h2 class="entry-title"><a href="' . get_permalink() . '">' . htmlspecialchars_decode  ( get_the_title() ) . '</a></h2>';
                                $outputHead .= '</div>';
                        $outputHead .= '</div>';
                    $outputHead .= '</div>';
                $outputHead .= '</div>';

                $outputBody .= '<div class="tw-home-blog-left-container">';
                    $outputBody .= lvly_entry_media( 'video', array( 'img_size' => 'home-video-blog-first' ), false );
                
                $outputBody .= '</div>';
            }}
            wp_reset_postdata();
        }

        // posts
        
        $lvly_query = new WP_Query( $query );
        if ( $lvly_query->have_posts() ) {
            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                $outputHead .= '<div class="title-icon">';

                    $outputHead .= '<div class="uk-grid-small uk-flex-middle" data-uk-grid>';

                        $outputHead .= '<div class="uk-width-1-1 uk-width-12-12@s">';
                            $outputHead .= '<div class="entry-post">';
                                $outputHead .= '<div class="entry-thubnail">';
                                    $outputHead .= lvly_image('home-video-blog-other');
                                   
                                $outputHead .= '</div>';
                                $outputHead .= '<div class="uk-position-center">';
                                    $outputHead .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 22.75H9C3.57 22.75 1.25 20.43 1.25 15V9C1.25 3.57 3.57 1.25 9 1.25H15C20.43 1.25 22.75 3.57 22.75 9V15C22.75 20.43 20.43 22.75 15 22.75ZM9 2.75C4.39 2.75 2.75 4.39 2.75 9V15C2.75 19.61 4.39 21.25 9 21.25H15C19.61 21.25 21.25 19.61 21.25 15V9C21.25 4.39 19.61 2.75 15 2.75H9Z" fill="white"/>
                                    <path d="M10.7598 16.3683C10.3398 16.3683 9.94984 16.2683 9.59984 16.0683C8.79984 15.6083 8.33984 14.6683 8.33984 13.4783V10.5183C8.33984 9.33834 8.79984 8.38834 9.59984 7.92834C10.3998 7.46834 11.4398 7.53834 12.4698 8.13834L15.0398 9.61834C16.0598 10.2083 16.6498 11.0783 16.6498 11.9983C16.6498 12.9183 16.0598 13.7883 15.0398 14.3783L12.4698 15.8583C11.8898 16.1983 11.2998 16.3683 10.7598 16.3683ZM10.7698 9.12834C10.6098 9.12834 10.4698 9.15834 10.3598 9.22834C10.0398 9.41834 9.84984 9.88834 9.84984 10.5183V13.4783C9.84984 14.1083 10.0298 14.5783 10.3598 14.7683C10.6798 14.9583 11.1798 14.8783 11.7298 14.5583L14.2998 13.0783C14.8498 12.7583 15.1598 12.3683 15.1598 11.9983C15.1598 11.6283 14.8498 11.2283 14.2998 10.9183L11.7298 9.43834C11.3698 9.22834 11.0398 9.12834 10.7698 9.12834Z" fill="white"/>
                                    </svg>';
                                $outputHead .= '</div>';
                            $outputHead .= '</div>';
                        $outputHead .= '</div>';

                        $outputHead .= '<div class="uk-width-1-1 uk-width-7-12@s">';
                                $outputHead .= '<div class="entry-content">';
                                    // $timeAgo = human_time_diff_mon( get_the_time('U'), current_time('timestamp') );
                                    // $outputHead .= '<span class="date">' . esc_attr($timeAgo) . '</span>';
                                    $outputHead .= '<h2 class="entry-title"><a href="' . get_permalink() . '">' . htmlspecialchars_decode  ( get_the_title() ) . '</a></h2>';
                                $outputHead .= '</div>';
                        $outputHead .= '</div>';

                    $outputHead .= '</div>';

                $outputHead .= '</div>';

                $outputBody .= '<div class="tw-home-blog-left-container">';
                    $outputBody .= lvly_entry_media( 'video', array( 'img_size' => 'home-video-blog-first' ), false );
                   
                $outputBody .= '</div>';

            }
            wp_reset_postdata();
            
           
        }

        if ( $outputBody && $outputHead ) { 
            echo '<div data-uk-grid>';
                echo '<div class="uk-width-1-1 uk-width-12-12@m">';
                    echo '<div class="it-video-player-body">' . $outputBody . '</div>';
                echo '</div>';
                // echo '<div class="uk-width-1-1 uk-width-5-12@m">';
                //     echo '<div class="it-video-player-head">' . $outputHead . '</div>';
                // echo '</div>';
            echo '</div>';
        }
    echo '</div>';
echo '</div>';