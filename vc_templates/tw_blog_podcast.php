<?php
/* ================================================================================== */
/*      Blog-Home-GolomtIPO Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-blog-podcast'),
    ),
    'animation_target' => 'article.post',
), vc_map_get_attributes($this->getShortcode(),$atts));




$column =  $atts['column'] ;

$colmn  = '';

if( $column == 'column' ) {
    $colmn = 'uk-child-width-1-1 uk-child-width-1-1@m ';
    
}elseif( $column == 'column2' ) {
    $colmn = 'uk-child-width-1-1 uk-child-width-1-2@m ';
}

$query = array(
    'post_type' => 'post',
    'post_format' => 'post-format-audio',
    'posts_per_page' => $atts['posts_per_page'],
);

/* Pagination Fix - NOT Overriding WordPress globals */
if ($atts['pagination']) {
    global $paged, $page;
    if (is_front_page() && $page) {
        $paged = $page;
    }
    $query['paged'] = $paged;
    if ($atts['pagination'] === 'infinite') {
        $conClass .= ' tw-infinite-container';
    }
}

$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'category',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}

$link = vc_build_link( $atts['link'] );

$output ='';
$lvly_query = new WP_Query($query);



if ($lvly_query->have_posts()) {
    $output .= lvly_item($atts)[0];
    echo $output;
        if($link['url']) {
            echo '<div class="tw-blog-podcast-link">';
                echo '<a href="' . $link['url'] . '">' . $link['title'] . '
                    <span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M17.9199 6.62C17.8185 6.37565 17.6243 6.18147 17.3799 6.08C17.2597 6.02876 17.1306 6.00158 16.9999 6H6.99994C6.73472 6 6.48037 6.10536 6.29283 6.29289C6.1053 6.48043 5.99994 6.73478 5.99994 7C5.99994 7.26522 6.1053 7.51957 6.29283 7.70711C6.48037 7.89464 6.73472 8 6.99994 8H14.5899L6.28994 16.29C6.19621 16.383 6.12182 16.4936 6.07105 16.6154C6.02028 16.7373 5.99414 16.868 5.99414 17C5.99414 17.132 6.02028 17.2627 6.07105 17.3846C6.12182 17.5064 6.19621 17.617 6.28994 17.71C6.3829 17.8037 6.4935 17.8781 6.61536 17.9289C6.73722 17.9797 6.86793 18.0058 6.99994 18.0058C7.13195 18.0058 7.26266 17.9797 7.38452 17.9289C7.50638 17.8781 7.61698 17.8037 7.70994 17.71L15.9999 9.41V17C15.9999 17.2652 16.1053 17.5196 16.2928 17.7071C16.4804 17.8946 16.7347 18 16.9999 18C17.2652 18 17.5195 17.8946 17.707 17.7071C17.8946 17.5196 17.9999 17.2652 17.9999 17V7C17.9984 6.86932 17.9712 6.74022 17.9199 6.62Z" fill="#3A96EC"/> </svg>
                    </span>';
                echo '</a>';
            echo '</div>';
        }
       
        echo '<div class="' . $colmn . $column . '" data-uk-grid>';
            while ($lvly_query->have_posts()) { 
                $lvly_query->the_post();
                $excerptTitle = wp_trim_words(get_the_title(), 12, '...');
                echo '<div>';
                    echo '<article class="tw-blog-podcast-art" id="post-' . get_the_ID() . '"class="' . esc_attr( implode( ' ', get_post_class() ) ) . '">';
                        echo '<div>';
                            $meta = lvly_metas_format();   
                            $embed = $meta['audio_embed'];
                            $embedWP = apply_filters("the_content", wp_specialchars_decode($embed));
                            echo $embedWP;
                            // $timeAgo = human_time_diff_mon( get_the_time('U'), current_time('timestamp') );
                            // echo '<span class="date">' . esc_attr($timeAgo) . '</span>';
                        echo '</div>';
                        echo '<h5 class="tw-blog-podcast-title">' . esc_attr($excerptTitle) . '</h5>';
                    echo '</article>';
                echo '</div>';
            }
        echo '</div>';
        if ($atts['pagination']) {
            $atts['query'] = $lvly_query;
            lvly_pagination($atts);
        }
    echo '</div>'; 
}

