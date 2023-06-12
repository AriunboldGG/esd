<?php
if (!function_exists('lvly_get_option')) {
    function lvly_get_option($index, $default = false) {
        global $lvly_redux;
        if ( isset( $lvly_redux[ $index ]) ) {
            return $lvly_redux[$index];
        } else {
            return $default;
        }
    }
}
if (!function_exists('lvly_get_options')) {
    function lvly_get_options() {
        global $lvly_redux;
        return $lvly_redux;
    }
}
if (!function_exists('lvly_set_options')) {
    function lvly_set_options($new_atts) {
        global $lvly_redux;
        if (empty($lvly_redux)||!is_array($lvly_redux)) {$lvly_redux=array();}
        $lvly_redux = array_merge($lvly_redux, $new_atts);
    }
}
if (!function_exists('lvly_get_atts')) {
    function lvly_get_atts() {
        global $lvly_atts;
        return $lvly_atts;
    }
}
if (!function_exists('lvly_get_att')) {
    function lvly_get_att($slug) {
        global $lvly_atts;
        return isset($lvly_atts[$slug])?$lvly_atts[$slug]:NULL;
    }
}
if (!function_exists('lvly_set_atts')) {
    function lvly_set_atts($new_atts) {
        global $lvly_atts;
        if (empty($lvly_atts)||!is_array($lvly_atts)) {$lvly_atts=array();}
        $lvly_atts = array_merge($lvly_atts, $new_atts);
    }
}
if (!function_exists('lvly_set_att')) {
    function lvly_set_att($new_att_slug,$new_att_value) {
        global $lvly_atts;
        $lvly_atts[$new_att_slug] = $new_att_value;
    }
}
if (!function_exists('lvly_favicon')) {
    function lvly_favicon() {
        if (!function_exists('has_site_icon')||!has_site_icon()) {

        /* Our Favicon will Work If Site Icon has no value - We are not overriding the Core */

            $favicon = lvly_get_option('favicon');
            if (!empty($favicon['url'])) {
                echo '<link rel="shortcut icon" href="' . esc_url($favicon['url']).'"/>';
            }else{
                echo '<link rel="shortcut icon" href="' . esc_url(LVLY_DIR . 'assets/images/favicon.png') . '"/>';
            }
        }
    }
}

/* Page, Post custom metaboxes */
if ( ! function_exists( 'lvly_metas' ) ) {
    function lvly_metas($pid=false) {
        global $post;
        $metas = array();
        if ( $pid === false && $post ) {
            $pid = $post->ID;
        }
        if ( $pid ) {
            $metas = get_post_meta( $pid, LVLY_META, true );
            if ( ! is_array( $metas ) ) {
                $metas = array();
            }
        }
        return $metas;
    }
}
if ( ! function_exists( 'lvly_meta' ) ) {
    function lvly_meta( $name, $pid=false, $def='' ) {
        $metas = lvly_metas( $pid );
        if ( isset( $metas[ $name ] ) ) {
            return $metas[ $name ];
        }
        return $def;
    }
}
if ( ! function_exists( 'lvly_metas_format' ) ) {
    function lvly_metas_format($pid=false) {
        if (!($metas = lvly_metas($pid))) {
            $metas = array();
        }
        return array_merge(array(
            'gallery_image_ids'=>'',
            'video_embed'=>'',
            'audio_mp3'=>'',
            'audio_embed'=>'',
        ),$metas);
    }
}
if (!function_exists('lvly_update_metas')) {
    function lvly_update_metas($metas,$pid=false) {
        global $post;
        if ($pid===false&&$post) {$pid=$post->ID;}
        if ($pid) {
            return update_post_meta($pid,LVLY_META,$metas);
        }
        return false;
    }
}
if (!function_exists('lvly_update_meta')) {
    function lvly_update_meta($name,$value,$pid=false) {
        global $post;
        if ($pid===false&&$post) {$pid=$post->ID;}
        if ($pid) {
            $metas=lvly_metas($pid);
            $metas[$name]=$value;
            return lvly_update_metas($metas,$pid);
        }
        return false;
    }
}

/* Menu */
if (!function_exists('lvly_social_link')) {
    function lvly_social_link($link) {
        if (!empty($link)) {
            $social = lvly_social_icon(esc_url($link));
            return '<a title="'.esc_attr($social['name']).'" href="'.esc_url($link).'" class="'.esc_attr($social['name']).'"><i class="'.esc_attr($social['class']).'"></i></a>';
        }
    }
}
if (!function_exists('lvly_social_icon')) {
    function lvly_social_icon($url) {
        if (strpos($url,'twitter.com')) {$social['name']='twitter';$social['class']='fa fa-twitter';return $social;}
        if (strpos($url,'linkedin.com')) {$social['name']='linkedin';$social['class']='fa fa-linkedin';return $social;}
        if (strpos($url,'facebook.com')) {$social['name']='facebook';$social['class']='fa fa-facebook';return $social;}
        if (strpos($url,'delicious.com')) {$social['name']='delicious';$social['class']='fa fa-delicious';return $social;}
        if (strpos($url,'codepen.io')) {$social['name']='codepen';$social['class']='fa fa-codepen';return $social;}
        if (strpos($url,'github.com')) {$social['name']='github';$social['class']='fa fa-github';return $social;}
        if (strpos($url,'wordpress.org')||strpos($url,'wordpress.com')) {$social['name']='wordpress';$social['class']='fa fa-wordpress';return $social;}
        if (strpos($url,'youtube.com')) {$social['name']='youtube';$social['class']='fa fa-youtube';return $social;}
        if (strpos($url,'behance.net')) {$social['name']='behance';$social['class']='fa fa-behance';return $social;}
        if (strpos($url,'pinterest.com')) {$social['name']='pinterest';$social['class']='fa fa-pinterest';return $social;}
        if (strpos($url,'foursquare.com')) {$social['name']='foursquare';$social['class']='fa fa-foursquare';return $social;}
        if (strpos($url,'soundcloud.com')) {$social['name']='soundcloud';$social['class']='fa fa-soundcloud';return $social;}
        if (strpos($url,'dribbble.com')) {$social['name']='dribbble';$social['class']='fa fa-dribbble';return $social;}
        if (strpos($url,'instagram.com')) {$social['name']='instagram';$social['class']='fa fa-instagram';return $social;}
        if (strpos($url,'plus.google')) {$social['name']='google';$social['class']='fa fa-google-plus';return $social;}
        if (strpos($url,'reddit.com')) {$social['name']='reddit';$social['class']='fa fa-reddit';return $social;}
        if (strpos($url,'vimeo.com')) {$social['name']='vimeo';$social['class']='fa fa-vimeo';return $social;}
        if (strpos($url,'twitch.tv')) {$social['name']='twitch';$social['class']='fa fa-twitch';return $social;}
        if (strpos($url,'tumblr.com')) {$social['name']='tumblr';$social['class']='fa fa-tumblr';return $social;}
        if (strpos($url,'trello.com')) {$social['name']='trello';$social['class']='fa fa-trello';return $social;}
        if (strpos($url,'spotify.com')) {$social['name']='spotify';$social['class']='fa fa-spotify';return $social;}
        if (strpos($url,'rss')) {$social['name']='feed';$social['class']='fa fa-rss';return $social;}

        $social['name']='custom';$social['class']='fa fa-link';
        $social['name']='tel';$social['class']='fa fa-phone';
        return $social;
    }
}

/* Menu */
if (!function_exists('lvly_menu')) {
    function lvly_menu() {
        $menu_args = array(
            'walker' => new Lvly_Menu(),
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'tw-main-menu uk-visible@m',
            'fallback_cb' => 'lvly_nomenu',
            'theme_location' => 'main'
        );
        if ($nav_menu = lvly_meta('page_menu')) {
            $menu_args['menu'] = $nav_menu;
        }
        wp_nav_menu($menu_args);
    }
}
if (!function_exists('lvly_nomenu')) {
    function lvly_nomenu() {
        echo "<ul class='tw-main-menu tw-list-pages uk-visible@m'>";
        wp_list_pages(array('title_li' => ''));
        echo "</ul>";
    }
}
/* Mobile Menu */
if (!function_exists('lvly_mobilemenu_convert')) {
    function lvly_mobilemenu_convert($output) {
        return str_replace(array(' %uk-nav%"',' menu-item-has-children '), array('" data-uk-nav',' uk-parent '),$output);
    }
}
if (!function_exists('lvly_mobilemenu')) {
    function lvly_mobilemenu() {            
        $menu_args = array(
            'walker' => new Lvly_Menu_Mobile(),
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'uk-nav-default uk-nav-parent-icon %uk-nav%',
            'fallback_cb' => 'lvly_mobilemenu_main',
            'theme_location' => 'mobile'
        );
        if ($nav_menu = lvly_meta('page_menu')) {
            $menu_args['menu'] = $nav_menu;
        }
        ob_start();
        wp_nav_menu($menu_args);
        echo lvly_mobilemenu_convert(ob_get_clean());
    }
}
if (!function_exists('lvly_mobilemenu_main')) {
    function lvly_mobilemenu_main() {
        $menu_args = array(
            'walker' => new Lvly_Menu_Mobile(),
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'uk-nav-default uk-nav-parent-icon %uk-nav%',
            'fallback_cb' => 'lvly_nomobilemenu',
            'theme_location' => 'main'
        );
        if ($nav_menu = lvly_meta('page_menu')) {
            $menu_args['menu'] = $nav_menu;
        }
        ob_start();
        wp_nav_menu($menu_args);
        echo lvly_mobilemenu_convert(ob_get_clean());
    }
}
if (!function_exists('lvly_nomobilemenu')) {
    function lvly_nomobilemenu() {
        echo '<ul class="uk-nav-default uk-nav-parent-icon tw-mobile-list-pages" data-uk-nav>';
            wp_list_pages(array('title_li' => ''));
        echo '</ul>';
    }
}

/* Sidebar Menu */
if (!function_exists('lvly_sidemenu_convert')) {
    function lvly_sidemenu_convert($output) {
        return str_replace(array('uk-navbar-dropdown','uk-navbar-dropdown-grid','data-uk-drop="'), array('sub-menu uk-animation-fade','','data-disable-uk-drop="'),$output);
    }
}
if (!function_exists('lvly_sidemenu')) {
    function lvly_sidemenu() {
        ob_start();
            lvly_menu();
        echo lvly_sidemenu_convert(ob_get_clean());
    }
}

/* Blog */
if (!function_exists('lvly_author')) {
    function lvly_author() {
        $description = get_the_author_meta('description');
        if ( $description ) { ?>
            <div class="tw-author">
                <div class="author-box"><?php
                    $tw_author_email = get_the_author_meta('email');
                    echo get_avatar($tw_author_email, $size = '120'); ?>
                    <h3><?php
                        if ( is_author() ) {
                            the_author();
                        } else {
                            the_author_posts_link();
                        } ?>
                    </h3><?php
                    echo '<span class="tw-meta">'.lvly_get_option('text_writer', esc_html__('writer', 'lvly')) .'</span>';
                    echo '<p>';
                        echo esc_html( $description );
                    echo '</p>';
                    $socials = get_the_author_meta('user_social');
                    if (!empty($socials)) {
                        echo '<div class="tw-socials tw-social-light with-hover">';
                        $social_links=explode("\n",$socials);
                        foreach($social_links as $social_link) {
                            $icon = lvly_social_icon(esc_url($social_link));
                            echo '<a href="'.esc_url($social_link).'"><i class="'.esc_attr($icon['class']).'"></i></a>';
                        }
                        echo '</div>';
                    } ?>
                </div>
            </div><?php
        }
    }
}
if (!function_exists('lvly_comment_count')) {
    function lvly_comment_count() {
        if (comments_open()) {
            $comment_count = get_comments_number('0', '1', '%');
            $comment_trans = $comment_count . ' <span class="comment-label">' . esc_html__('comments', 'lvly').'</span>';
            if ($comment_count == 0) {
                $comment_trans = '<span class="comment-label">'.esc_html__('no comment', 'lvly').'</span>';
            } elseif ($comment_count == 1) {
                $comment_trans = '1 <span class="comment-label">'. esc_html__('comment', 'lvly').'</span>';
            }
            return '<a class="comment-count" href="' . esc_url(get_comments_link()) . '"><i class="ion-chatbubbles"></i><span>' . ($comment_trans) . '</span></a>';
        } else {
            $comment_trans = esc_html__('disabled', 'lvly');
            return '<a class="comment-count" href="' . esc_url(get_comments_link()) . '"><i class="ion-chatbubbles"></i><span>' . ($comment_trans) . '</span></a>';
        }
    }
}
/* Share */
if (!function_exists('lvly_share_count')) {
    function lvly_share_count($social='',$pid=false) {
        $count = 0;
        if ($social) {$count = lvly_meta('share_count_' . $social, $pid);}
        return intval($count);
    }
}
add_action( 'wp_ajax_lvly_share_ajax', 'lvly_share_ajax' );
add_action( 'wp_ajax_nopriv_lvly_share_ajax', 'lvly_share_ajax' );

function lvly_share_ajax() {
    if (isset($_REQUEST['social_pid']) && isset($_REQUEST['social_name'])) {
        lvly_update_meta('share_count_' . sanitize_text_field(wp_unslash($_REQUEST['social_name'])),lvly_share_count(sanitize_text_field(wp_unslash($_REQUEST['social_name'],$_REQUEST['social_pid']))) + 1,sanitize_text_field(wp_unslash($_REQUEST['social_pid'])));
    }
    wp_die();
}
if (!function_exists('lvly_image')) {
    function lvly_image($size = 'full', $returnURL = false) {
        global $post;
        $attachment = get_post(get_post_thumbnail_id($post->ID));
        if (!empty($attachment)) {
            if ($returnURL) {
                $img = array(
                    'url' =>'',
                    'alt' =>'',
                    'width' =>'',
                    'height' =>'',
                );
                $lrg_img = wp_get_attachment_image_src($attachment->ID, $size);
                if ( $lrg_img && is_array($lrg_img) ) {
                    $url = $lrg_img[0];
                    $width = $lrg_img[1];
                    $height = $lrg_img[2];
                    $alt0 = lvly_meta('_wp_attachment_image_alt',$attachment->ID);
                    $alt = empty($alt0)?$attachment->post_title:$alt0;
                    $img['url'] = $url;
                    $img['alt'] = $alt;
                    $img['width'] = $width;
                    $img['height'] = $height;
                }
                return $img;
            } else {
                return get_the_post_thumbnail($post->ID,$size);
            }
        }
    }
}

if (!function_exists('lvly_single_title')) {
    function lvly_single_title() {
        echo '<div class="single-title-container">';
            if (lvly_get_option('single_cats')) {
                echo '<div class="entry-cats tw-meta">'.get_the_category_list(', ').'</div>';
            }
            echo '<h2 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h2>';
            if (lvly_get_option('single_meta')) {
                echo '<div class="entry-date tw-meta">';
                    echo '<span>'.esc_attr(get_the_time(get_option('date_format'))).'</span>&nbsp;&nbsp;/&nbsp;&nbsp;';  
                    echo '<span class="entry-author">'.esc_html_e('By ', 'lvly').' ';
                        the_author_posts_link();
                    echo '</span>';
                echo '</div>';
            }
        echo '</div>';
    }
}

if (!function_exists('lvly_cats')) {
    function lvly_cats($sep = ', ') {
        $cats = '';
        foreach((get_the_category()) as $category) {
            $options = get_option("taxonomy_".$category->cat_ID);
            if (!isset($options['featured']) || !$options['featured']) {
                $cats .= '<div class="cat-item"><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( esc_attr__( 'View all posts in %s', 'lvly' ), $category->name ) . '" ' . '>'  . $category->name.'</a><span>'.$sep.'</span></div>';
            }
        }
        if (!$cats && is_search()) {
            $cats = '<div class="cat-item"><a href="' . get_permalink() . '">' . esc_html__('Page', 'lvly') . '</a></div>';
        }
        return $cats;
    }
}

if (!function_exists('lvly_blogcontent')) {
    function lvly_blogcontent($atts) {
        global $more,$post;
        $more = 0;
        if ( ! empty( $atts['excerpt_count'] ) ) {
            /* $atts['excerpt_count']!==0 */
            $atts['excerpt_count'] = intval( $atts['excerpt_count'] );
            if (has_excerpt()) {
                the_excerpt();
            } elseif ( $atts['excerpt_count'] > 0 ) {
                $more = 1;
                $str = wp_strip_all_tags( do_shortcode( get_the_content() ) );
                echo '<p>' . lvly_excerpt( $str, $atts['excerpt_count'] ) . '</p>';
            } else {
                the_content( isset( $atts['more_text'] ) ? $atts['more_text'] : '' );
            }
            
        }
    }
}

if (!function_exists('lvly_excerpt')) {
    function lvly_excerpt($str, $length) {
        $str = explode(" ", strip_tags($str));
        return implode(" ", array_slice($str, 0, $length));
    }
}

if (!function_exists('lvly_read_more_link')) {
    add_filter('the_content_more_link', 'lvly_read_more_link', 10, 2);
    function lvly_read_more_link($output, $read_more_text) {
        $output = '<p class="more-link"><a class="uk-button uk-button-default uk-button-small uk-button-radius tw-hover" href="'.esc_url(get_permalink()).'"><span class="tw-hover-inner"><span>'.($read_more_text).'</span><i class="ion-ios-arrow-thin-right"></i></span></a></p>';
        return $output;
    }
}

if (!function_exists('lvly_seen_add')) {
    function lvly_seen_add() {
        $seen = lvly_meta('post_seen');
        $seen = intval($seen)+1;
        lvly_update_meta('post_seen',$seen);
    }
}
if (!function_exists('lvly_standard_media')) {
    function lvly_standard_media($post, $atts) {
        $output = '';
        if (has_post_thumbnail($post->ID)) {
            $output .= '<div class="tw-thumbnail">';
                if (is_single($post)) {
                    $img = lvly_image('full', true);
                    $output .= lvly_image($atts['img_size']);
                    $output .= '<div class="image-overlay"><a href="' . esc_url($img['url']) . '" title="' . esc_attr(get_the_title()) . '"></a></div>';
                } else {
                    $output .= '<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" class="tw-image-hover">'.lvly_image($atts['img_size']).'</a>';
                }
            $output .= '</div>';
        }
        return $output;
    }
}
if ( ! function_exists( 'lvly_entry_media' ) ) {
    function lvly_entry_media( $format, $atts, $force = false ) {
        global $post;
        $output = $data = $class = '';
        if ( ! is_single() && has_post_thumbnail( $post->ID ) && ! $force ) {
            $output .= lvly_standard_media( $post, $atts );
        } else {
            $meta = lvly_metas_format();
            switch ( $format ) {
                case 'gallery':
                    $images = explode(',', $meta['gallery_image_ids']);
                    if ($images) {
                        wp_enqueue_script('owl-carousel');
                        $output .= '<div class="tw-element tw-owl-carousel-container uk-light" data-dots="inside" data-nav="true">';
                            $output .= '<div class="owl-carousel onhover owl-theme" data-uk-scrollspy="target: .shop-item; cls:uk-animation-slide-bottom-medium; delay: 300;">';
                                foreach ($images as $image) {
                                    $img = wp_get_attachment_image_src($image, $atts['img_size']);
                                    if ($image&&$img) {
                                        $desc = get_post_field('post_excerpt', $image);
                                        $output .= '<div class="gallery-item"><div class="shop-content"><img src="' . esc_url($img[0]) . '"' . ($desc ? ' alt="' . $desc . '"' : '') . ' /></div></div>';
                                    }
                                }
                            $output .= '</div>';
                        $output .= '</div>';
                    }
                    break;

                case 'video':
                    $embedWP='';
                    $embed = $meta['video_embed'];
                    if (wp_oembed_get($embed)) {
                        $embedWP .= wp_oembed_get($embed);
                    } elseif (!empty($embed)) {
                        $embedWP .= apply_filters("the_content", wp_specialchars_decode($embed));
                    }
                    if ($embedWP) {
                        $class .=' tw-video uk-background-cover';
                        $data .= ' data-video-target=".tw-video-container" style="min-height:'.intval(empty($meta['video_min_height'])?'450':$meta['video_min_height']).'px; background-image: url('.esc_url(lvly_image($atts['img_size'],true)['url']).');"';
                        $output .= '<div class="tw-thumbnail"><button type="button" class="tw-video-icon"><span class="before"></span><i class="ion-play"></i><span class="after"></span></button></div><div class="tw-video-container tw-invis"><div class="tw-video-frame" data-video-embed="'.esc_attr($embedWP).'"></div></div>';
                    }
                    break;

                case 'audio':

                    $mp3   = $meta['audio_mp3'];
                    $embed = $meta['audio_embed'];
                    if ($mp3) {
                        $output .= apply_filters("the_content", '[audio src="' . esc_url($mp3) . '"]');
                    } elseif (wp_oembed_get($embed)) {
                        $output .= wp_oembed_get($embed);
                    } elseif (!empty($embed)) {
                        $output .= apply_filters("the_content", wp_specialchars_decode($embed));
                    }
                    break;
                
                case 'quote':
                    if (!empty($meta['quote_text'])) {
                        $author = $bgimage = '';
                        if (!empty($meta['quote_bgimage'])) {
                            $bgimage = '<div class="testimonial-bgimage" style="background-image:url('.esc_url($meta['quote_bgimage']).')"></div>';
                        }
                        if (!empty($meta['quote_author'])) {
                            $author = '<div class="testimonial-author">'.esc_attr($meta['quote_author']).'</div>';
                        }
                        $output .= '<div class="testimonial">';
                            $output .= '<div class="testimonial-content">'.($bgimage).'<p>'.esc_html($meta['quote_text']).'</p>'.($author). ( empty( $atts['inside'] ) ? ( '<div class="tw-meta tw-datetime"><a href="' . esc_url( get_permalink() ) . '">' . esc_attr( get_the_time( get_option( 'date_format' ) ) ) . '</a></div>' ) : '' ) .'</div>';
                        $output .= '</div>';
                    }
                    break;
                    
                case 'status':
                    if ( ! empty ( $meta['status_url'] ) ) {
                        $status = apply_filters( "the_content", str_replace( '&quot;', '', $meta['status_url'] ) );
                        if ( strpos( $status, 'class="twitter-tweet"' ) === false ) { // important use === false. Do not remove === false.
                            $output .= $status;
                        } else {
                            libxml_use_internal_errors( true );
                            $dom = new DomDocument();
                            $dom->loadHTML( $status );
                            $xpath = new DOMXPath( $dom );
                            libxml_clear_errors();
                            $nodes = $xpath->query( '//blockquote' );
                            $twt = $nodes->item( 0 );
                            $tweetDateLink      = $xpath->query( '(//a)[last()]', $twt )->item( 0 );
                            $tweetDateLinkURL   = $tweetDateLink->getAttribute( 'href' );
                            $tweetDateLinkTime  = strtotime( $tweetDateLink->nodeValue );
                            $tweetUserName = explode( '/', str_replace( array( 'http://twitter.com/', 'https://twitter.com/', '//twitter.com/', 'twitter.com/' ), '', $tweetDateLinkURL ) )[0];
                            $newHTML_Last  = '<p class="tweet-user"><a href="' . esc_url( 'https://twitter.com/' . $tweetUserName ) . '">@' . esc_attr( $tweetUserName ) . '</a></p>';
                            $newHTML_Last .= '<span class="tweet-posted tw-meta"><a href="' . esc_url( $tweetDateLinkURL ) . '">' . human_time_diff( $tweetDateLinkTime ) . esc_html__( ' ago', 'lvly' ) . '</a></span>';
                            $tweetDateLinkParent = $tweetDateLink->parentNode;
                            if ( $tweetDateLinkParent->tagName != 'blockquote' ) {
                                $tweetDateLinkParent->parentNode->removeChild( $tweetDateLinkParent );
                            }
                            $twtChilds  = $twt->childNodes;
                            $output .= '<blockquote class="blockquote-tweet">';
                                $output .= '<i class="icon-twitter fa fa-twitter"></i>';
                                foreach ( $twtChilds as $twtChild ) { 
                                    $output .= $twtChild->ownerDocument->saveHTML( $twtChild );
                                }
                                $output .= $newHTML_Last;
                            $output .= '</blockquote>';
                        }
                    }
                    break;
                    
                case 'link':
                if (!empty($meta['link_url'])) {
                    $author = $bgimage = '';
                    if (!empty($meta['link_bgimage'])) {
                        $bgimage = '<div class="testimonial-bgimage" style="background-image:url('.esc_url($meta['link_bgimage']).')"></div>';
                    }
                    $output .= '<div class="testimonial">';
                        $output .= '<div class="testimonial-content">'.($bgimage).'<a href="'.esc_url($meta['link_url']).'">'.get_the_title().'</a></div>';
                    $output .= '</div>';
                }
                break;
            }
            /* Standard OR Other Formats are Emtpy */
            if (empty($output)) {
                $output .= lvly_standard_media($post, $atts);
            }
        }
        /* if OUTPUT is not empty then add outer (IMPORTANT: Don't merge two IF checks.) */
        if ($output) {$output= '<div class="entry-media uk-responsive-width'.$class.'"'.($data).'>'.$output.'</div>';}
        return $output;
    }
}
if ( ! function_exists( 'lvly_portfolio_gallery_slider' ) ) {
    function lvly_portfolio_gallery_slider( $atts ) {
        $output = '';
        $class = 'tw-gallery-carousel';

        if ( ! empty( $atts['gallery_light'] ) ) {
            $class .= ' uk-light';
        }

        if ( ! empty( $atts['gallery'] ) ) {
            wp_enqueue_script( 'owl-carousel' );
            $images = explode( ',', $atts['gallery'] );
            $output .= '<div class="' . esc_attr( $class ) . '" data-nav="' . esc_attr( empty( $atts['gallery_nav'] ) ? 'false' : 'true' ) . '" data-dots="' . esc_attr( empty( $atts['gallery_dots'] ) ? 'false' : $atts['gallery_dots'] ) . '" data-center="' . esc_attr( empty( $atts['gallery_center'] ) ? '' : 'true' ) . '">';
                $output .= '<div class="owl-carousel owl-theme">';
                    foreach( $images as $image ) {
                        if ( $image && $img = wp_get_attachment_image_src( $image, 'full' ) ) {
                            $desc = get_post_field( 'post_excerpt', $image );
                            $output .= '<div class="carousel-item">';
                                $output .= '<img src="' . esc_url( $img[0] ) . '"' . ( $desc ? ' alt="' . esc_attr( $desc ) . '"' : '' ) . ' />';
                            $output .= '</div>';
                        }
                    }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_gallery_1')) {
    function lvly_portfolio_gallery_1($atts) {
        $output = '';
        if (!empty($atts['gallery'])) {
            wp_enqueue_script( 'isotope' );
            $images = explode(',', $atts['gallery']);
            $output .= '<div class="tw-element tw-gallery tw-isotope-container" data-isotope-item=".gallery-item">';
                $output .= '<div class="isotope-container uk-grid-xsmall uk-child-width-1-1" data-uk-grid>';
                
                foreach($images as $image) {
                    if ($image && $img=wp_get_attachment_image_src($image, 'full')) {
                        $description = '';
                        $desc = get_post_field('post_excerpt', $image);
                        if ($desc) {
                            $description = ' alt="' . esc_attr($desc) . '"';
                        }
                        $output .= '<div class="gallery-item"><div class="gallery-image">';
                                $output .= '<img src="' . esc_url($img[0]) . '"' . ($description) . ' />';
                        $output .= '</div></div>';
                    }
                }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_gallery_2')) {
    function lvly_portfolio_gallery_2($atts) {
        $output = '';
        if (!empty($atts['gallery'])) {
            wp_enqueue_script( 'isotope' );
            $images = explode(',', $atts['gallery']);
            $output .= '<div class="tw-element tw-gallery tw-isotope-container" data-isotope-item=".gallery-item">';
                $output .= '<div class="isotope-container uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s" data-uk-grid data-uk-lightbox="toggle: .tw-image-hover;">';
                
                foreach($images as $image) {
                    if ($image && $img=wp_get_attachment_image_src($image, 'full')) {
                        $description = $caption = '';
                        $desc = get_post_field('post_excerpt', $image);
                        if ($desc) {
                            $description = ' alt="' . esc_attr($desc) . '"';
                            $caption = ' data-caption="' . esc_attr($desc) . '"';
                        }
                        $output .= '<div class="gallery-item"><div class="gallery-image">';
                            $output .= '<a href="'.esc_url($img[0]).'" class="tw-image-hover"'. ($caption) .'>';
                                $output .= '<img src="' . esc_url($img[0]) . '"' . ($description) . ' />';
                            $output .= '</a>';
                        $output .= '</div></div>';
                    }
                }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_gallery_3')) {
    function lvly_portfolio_gallery_3($atts) {
        $output = '';
        if (!empty($atts['gallery'])) {
            wp_enqueue_script( 'isotope' );
            $images = explode(',', $atts['gallery']);
            $output .= '<div class="tw-element tw-gallery tw-isotope-container" data-isotope-item=".gallery-item">';
                $output .= '<div class="isotope-container uk-grid-medium uk-child-width-1-1@xxs uk-child-width-1-2@xs uk-child-width-1-2@s uk-child-width-1-3@m" data-uk-grid data-uk-lightbox="toggle: .tw-image-hover;">';
                
                foreach($images as $image) {
                    if ($image && $img=wp_get_attachment_image_src($image, 'full')) {
                        $description = $caption = '';
                        $desc = get_post_field('post_excerpt', $image);
                        if ($desc) {
                            $description = ' alt="' . esc_attr($desc) . '"';
                            $caption = ' data-caption="' . esc_attr($desc) . '"';
                        }
                        $output .= '<div class="gallery-item"><div class="gallery-image">';
                            $output .= '<a href="'.esc_url($img[0]).'" class="tw-image-hover"'. ($caption) .'>';
                                $output .= '<img src="' . esc_url($img[0]) . '"' . ($description) . ' />';
                            $output .= '</a>';
                        $output .= '</div></div>';
                    }
                }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_video')) {
    function lvly_portfolio_video($atts) {
        $output = '';
        if (!empty($atts['video_embed'])) {
            if (wp_oembed_get($atts['video_embed'])) {
                $embed = wp_oembed_get($atts['video_embed']);
            } else {
                $embed = apply_filters("the_content", wp_specialchars_decode($atts['video_embed']));
            }
            $image = lvly_image('full', true);
            if (empty($image['url'])) {
                $output .= ($embed);
            } else {
                $output= '<div class="entry-media uk-responsive-width tw-video uk-background-cover" data-video-target=".tw-video-container" style="background-image: url(' . esc_url( $image['url'] ) . ');"><div class="tw-thumbnail"><button type="button" class="tw-video-icon"><span class="before"></span><i class="ion-play"></i><span class="after"></span></button></div><div class="tw-video-container tw-invis"><div class="tw-video-frame" data-video-embed="' . esc_attr( $embed ) . '"></div></div></div>';
            }
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_date')) {
    function lvly_portfolio_date() {
        $output = '';
        $output .= '<li>';
            $output .= '<h3 class="portfolio-subtitle">'.esc_html__('Date', 'lvly').'</h3>';
            $output .= '<div class="portfolio-meta">'.esc_html(get_the_time(get_option('date_format'))).'</div>';
        $output .= '</li>';
        return $output;
    }
}
if (!function_exists('lvly_portfolio_cats')) {
    function lvly_portfolio_cats($post) {
        $output = '';
        $cats = get_the_term_list( $post->ID, 'portfolio_cat', '', ', ', '' );
        if ($cats) {
            $output .= '<li>';
                $output .= '<h3 class="portfolio-subtitle">'.esc_html__('Categories', 'lvly').'</h3>';
                $output .= '<div class="portfolio-meta">'.($cats).'</div>';
            $output .= '</li>';
        } 
        return $output;
    }
}
if (!function_exists('lvly_portfolio_client')) {
    function lvly_portfolio_client($atts) {
        $output = '';
        if (!empty($atts['client_name'])) {
            if (!empty($atts['client_link'])) {
                $atts['client_name'] = '<a href="'.esc_url($atts['client_link']).'">'.esc_html($atts['client_name']).'</a>';
            }
            $output .= '<li>';
                $output .= '<h3 class="portfolio-subtitle">'.esc_html__('Client', 'lvly').'</h3>';
                $output .= '<div class="portfolio-meta">'.($atts['client_name']).'</div>';
            $output .= '</li>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_share')) {
    function lvly_portfolio_share() {
        ob_start();
            do_action( 'waves_entry_share', 'layout-2' );
        return ob_get_clean();
    }
}
if (!function_exists('lvly_portfolio_morebtn')) {
    function lvly_portfolio_morebtn($atts) {
        $output = '';
        if (!empty($atts['more_link'])) {
            $output .= '<a href="'.esc_url($atts['more_link']).'" class="uk-button uk-button-radius uk-button-default portfolio-btn tw-hover"><span class="tw-hover-inner"><span>'.lvly_get_option('launch_project', esc_html__( 'Launch Project', 'lvly')).'</span><i class="ion-ios-arrow-thin-right"></i></span></a>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_nextprev')) {
    function lvly_portfolio_nextprev($atts) {
        $output = '';
        
        $prev_text = '<i class="ion-ios-arrow-left"></i><span>'.esc_html__('Prev', 'lvly').'</span>';
        $next_text = '<span>'.esc_html__('Next', 'lvly').'</span><i class="ion-ios-arrow-right"></i>';
        ob_start();
        previous_post_link('%link', $prev_text);
        $prev = ob_get_clean();
        ob_start();
        next_post_link('%link', $next_text);
        $next = ob_get_clean();
        $ppage = lvly_get_option('portfolio_page');
        $link = $ppage ? get_permalink($ppage) : home_url('/');
        
        if (isset($atts['full_navigation'])) {
            $output .= '<section class="uk-section uk-section-small uk-padding-large">';
                $output .= '<div class="uk-padding uk-padding-remove-vertical">';
        } else {
            $output .= '<section class="uk-section uk-section-small">';
                $output .= '<div class="uk-container">';
        }
                $output .= '<div class="tw-portfolio-nav uk-flex uk-flex-between uk-flex-middle">';
                    $output .= '<div class="nav-prev tw-meta">';
                        $output .= $prev ? $prev : ('<div>'.$prev_text.'</div>');
                    $output .= '</div>';
                    $output .= '<div class="nav-link">';
                        $output .= '<a href="'.esc_url($link).'">';
                            $output .= '<i class="ion-grid"></i>';
                        $output .= '</a>';
                    $output .= '</div>';
                    $output .= '<div class="nav-next tw-meta">';
                        $output .= $next ? $next : ('<div>'.$next_text.'</div>');
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</section>';
        return $output;
    }
}
if (!function_exists('lvly_comment')) {
    function lvly_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
		// Display trackbacks differently than normal comments.
        ?>
        <div class="post pingback" id="comment-<?php comment_ID(); ?>">
		    <?php esc_html_e( 'Pingback:', 'lvly' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'lvly' ), '<span class="edit-link">', '</span>' ); ?>
        <?php
            break;
            default :
            // Proceed with normal comments.
            global $post;
        ?>
        <div <?php comment_class();?> id="comment-<?php comment_ID(); ?>">
            <div class="comment-author">
                <?php echo get_avatar($comment, $size = '65'); ?>
            </div>
            <div class="comment-text">
                <h3 class="author"><?php echo get_comment_author_link(); ?></h3>
                <span class="tw-meta"><?php echo get_comment_date('F j, Y'); ?></span>
                <h6 class="reply"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></h6>
                <?php comment_text() ?>
            </div>
            <?php
		break;
	    endswitch; // end comment_type check
    }
}
if (!function_exists('lvly_comment_form')) {
    function lvly_comment_form($fields) {
        global $id, $post_id;
        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields = array(
            'author' => '<p class="comment-form-author">' .
            '<input id="author" name="author" placeholder="' . esc_attr__('Name *', 'lvly') . '" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'email' => '<p class="comment-form-email">' .
            '<input id="email" name="email" placeholder="' . esc_attr__('Email *', 'lvly') . '" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'url' => '<p class="comment-form-url">' .
            '<input id="url" name="url" placeholder="' . esc_attr__('Website', 'lvly') . '" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" />' . '</p><div class="clearfix"></div>',
        );
        return $fields;
    }
    add_filter('comment_form_default_fields', 'lvly_comment_form');
}

/* Modal Search */
if (!function_exists('lvly_modal_search')) {
    function lvly_modal_search($header_search = false) {
        if ($header_search) {
            $offset="";
            if ( is_admin_bar_showing() ) {
                $offset = 'style="top: 32px;"';
            }
            else{
                $offset = 'style="top: 0;"';
            }
            $output = '<div id="search-modal" class="uk-modal-full uk-modal" data-uk-modal>';
                $output .= '<div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" data-uk-height-viewport>';
                    $output .= '<button class="uk-modal-close-full" type="button" data-uk-close '.$offset.'></button>';
                    $output .= '<form class="uk-search uk-search-large" action="' . esc_url(home_url('/')) . '">';
                        $output .= '<span class="input--hoshi">';
                            $output .= '<input class="uk-search-input input__field--hoshi" autofocus type="search" name="s" placeholder="' . lvly_get_option('text_search', esc_attr__('Start typing...', 'lvly')) . '"  value="' . get_search_query() . '">';
                            $output .= '<label class="input__label--hoshi"></label>';
                            $output .= '<button type="submit" class="button-search"><i class="simple-icon-magnifier"></i></button>';
                        $output .= '</span>';
                    $output .= '</form>';
                $output .= '</div>';
            $output .= '</div>';

            echo ($output);
        }
    }
}

/* Sidebar Search */
if (!function_exists('lvly_sidebar_search')) {
    function lvly_sidebar_search($header_search = false) {
        if ($header_search) {

            $output = '<div class="search-form">';
                $output .= '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '">';
                    $output .= '<div class="input uk-position-relative">';
                        $output .= '<input type="text" value="" name="s" placeholder="' . esc_attr__('Search...', 'lvly') . '">';
                        $output .= '<a class="uk-form-icon uk-form-icon-flip"><i class="ion-search tw-search-icon"></i></a>';
                    $output .= '</div>';
                $output .= '</form>';
            $output .= '</div>';

            echo ($output);
        }
    }
}
if (!function_exists('lvly_modal_cart')) {
    function lvly_modal_cart($drop=array()) {
        $drop = shortcode_atts( array(
            'mode' => 'click',
            'boundary' => '! .uk-navbar-container',
            'pos' => 'bottom-right',
            'offset' => '0',
            'animation' => 'uk-animation-slide-bottom-small',
            'duration' => '300',
        ),$drop);
        $dropAtt='';
        foreach($drop as $k=>$v) {
            $dropAtt.=$k.':'.$v.'; ';
        }
        $output = '<a class="cart-btn uk-navbar-toggle" href="#"><i class="simple-icon-bag"><span class="hidden">0</span></i></a>';
        $output .= '<div class="cart-btn-widget uk-light" data-uk-drop="'.esc_attr($dropAtt).'">';
            ob_start();
                woocommerce_mini_cart(array());
            $output .= ob_get_clean();
        $output .= '</div>';
        echo ($output);
    }
}
if (!function_exists('lvly_modal_mobile_menu')) {
    function lvly_modal_mobile_menu() { ?>
        <div id="mobile-menu-modal" class="uk-modal-full" data-uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-full" type="button" data-uk-close></button>
                <div class="uk-light uk-height-viewport tw-mobile-modal uk-flex uk-flex-middle uk-flex-center" data-uk-scrollspy="target:>ul>li,>div>a; cls:uk-animation-slide-bottom-medium; delay: 150;">
                    <?php lvly_mobilemenu(); ?>
                    <?php lvly_fullmenu_social(); ?>
                </div>
            </div>
        </div><?php
    }
}
/* Logo */
if (!function_exists('lvly_logo')) {
    function lvly_logo($color = 'tw-header-light') {
        $before = $after = '';
        if (is_page_template('page-splitpage.php')||is_page_template('page-magazinepage.php')) {
            $logo=lvly_get_option('logo');
            $logoLight=lvly_get_option('logo_light');
        }else{
            $logo = $color == 'tw-header-light' ? lvly_get_option('logo') : lvly_get_option('logo_light');
        }
        if (empty($logo['url'])) {
            $before='<h3 class="site-name">';
            $after='</h3>';
        }
        $output = '<div class="tw-logo">';
            $output .= $before;
                $output .= '<a href="' . esc_url(home_url('/')) . '">';
                    if (!empty($logo['url'])) {
                        $output .= '<img class="logo-img" src="' . esc_url($logo['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                        if (!empty($logoLight['url'])) {
                            $output .= '<img class="logo-img logo-light" src="' . esc_url($logoLight['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                        }
                    }else{
                        $output .= get_bloginfo('name');
                    }
                $output .= '</a>';
            $output .= $after;
        $output .= '</div>';
        echo ($output);
    }
}
if (!function_exists('lvly_top_bar')) {
    function lvly_top_bar( $container = false ) {
        $topbar = lvly_get_option( 'top_bar' );
        if ( is_page() && is_page_template( array( 'page-onepage.php', 'default' ) ) ) {
            $ptopbar = lvly_meta( 'top_bar_content' );
            if (! empty( $ptopbar ) ) {
                $topbar = $ptopbar;
            }
        }
        $output = '';
        if ($topbar == 'true') {
            $output .= '<section class="uk-section tw-topbar uk-light uk-section-secondary uk-padding-remove-vertical">';
                if ($container) {
                    $output .= '<div class="uk-container">';
                }
                    $output .= '<div class="uk-child-width-1-1 uk-child-width-1-2@m" data-uk-grid>';
                        $output .= '<div>';
                        $toptext1 = lvly_get_option('top_text');
                        if ($toptext1) {
                            $output .= '<div class="tw-topbar-left uk-grid-medium uk-child-width-auto" data-uk-grid>';
                                foreach($toptext1 as $text) {
                                    $a_end = '';
                                    if ($text) {
                                        $pieces = explode("|", $text);
                                        $output .= '<div><div class="tw-element tw-box layout-4">';
                                            if (!empty($pieces[2])) {
                                                $output .= '<a href="'.esc_url($pieces[2]).'">';
                                                $a_end = '</a>';
                                            }
                                            if (!empty($pieces[1])) {
                                                $output .= '<i class="'.esc_attr($pieces[1]).'"></i>';
                                            }
                                            if (!empty($pieces[0])) {
                                                $output .= '<p class="description">'.esc_html($pieces[0]).'</p>';
                                            }                                            
                                        $output .= $a_end.'</div></div>';
                                    }
                                }
                            $output .= '</div>';
                        }
                        $output .= '</div><div>';
                        $toptext2 = lvly_get_option('top_text2');
                        if ($toptext2) {
                            $output .= '<div class="tw-topbar-right uk-flex-right uk-grid-medium uk-child-width-auto" data-uk-grid>';
                                foreach($toptext2 as $text) {
                                    $a_end = '';
                                    if ($text) {
                                        $pieces = explode("|", $text);
                                        $output .= '<div><div class="tw-element tw-box layout-4">';
                                            if (!empty($pieces[2])) {
                                                $output .= '<a href="'.esc_url($pieces[2]).'">';
                                                $a_end .= '</a>';
                                            }
                                            if (!empty($pieces[1])) {
                                                $output .= '<i class="'.esc_attr($pieces[1]).'"></i>';
                                            }
                                            if (!empty($pieces[0])) {
                                                $output .= '<p class="description">'.esc_html($pieces[0]).'</p>';
                                            }                                            
                                        $output .= $a_end.'</div></div>';
                                    }
                                }
                            $output .= '</div>';
                        }
                        $output .= '</div>';
                    $output .= '</div>';
                if ($container) {
                    $output .= '</div>';
                }
            $output .= '</section>';
        } elseif ($topbar == 'block') {
            $top_content = lvly_get_option('top_bar_content');
        } elseif (!empty($topbar) && $topbar != 'false') {
            $top_content = $topbar;
        }
        if (!empty($top_content)) {
            $output .= lvly_get_post_content_by_slug($top_content,'lovelyblock');
        }
        return $output;
    }
}

if (!function_exists('lvly_fullmenu_social')) {
    function lvly_fullmenu_social() {
        $output = '';
        $fullmenu_social = lvly_get_option('fullmenu_social');
            if ($fullmenu_social) {
                $output .= '<div class="tw-socials social-minimal">';
                    foreach($fullmenu_social as $text) {
                        $a_end = '';
                        if ($text) {
                            $pieces = explode("|", $text);
                                if (!empty($pieces[1])) {
                                    $output .= '<a href="'.esc_url($pieces[1]).'">';
                                    $a_end .= '</a>';
                                }
                                if (!empty($pieces[0])) {
                                    $output .= '<i class="'.esc_attr($pieces[0]).'"></i>';
                                }
                            $output .= $a_end;
                        }
                    }
                $output .= '</div>';
            }
        return $output;
    }
}
/* Template */
if (!function_exists('lvly_template_header')) {
    function lvly_template_header() {
        $header = lvly_get_option('header_layout', 'classic');
        $color = lvly_get_option('header_color', 'tw-header-light');
        $scroll_menu = lvly_get_option('scroll_menu', 'hide');
        $header_container = lvly_get_option('header_container', 'uk-container');
        $magazine = false;
        if ( is_page() ) {
            if ( is_page_template('page-magazinepage.php') ) {
                $magazine = true;
                $pheader = 'magazine';
            } elseif ( is_page_template( 'page-splitpage.php' ) ) {
                $pheader = 'splitpage';
                $pcolor = 'tw-header-transparent uk-light';
            } elseif ( is_page_template( 'page-fullpage.php' ) ) {
                $pscroll_menu=lvly_meta('fullpage_scroll_menu');
                $pheader = 'fullpage';
                $pcolor = 'tw-header-transparent uk-light';
                
            }else {
                $pheader = lvly_meta('header_layout');
                $pcolor = lvly_meta('header_color');
                $pscroll_menu = lvly_meta('scroll_menu');
                $pheader_container = lvly_meta('header_container');
            }
        } elseif( is_404() ) {
            $page_404_metas = lvly_get_att( 'page_404_metas' );
            if ( isset( $page_404_metas['header_layout'] ) ) {
                $pheader = $page_404_metas['header_layout'];
            }
            if ( isset( $page_404_metas['header_color'] ) ) {
                $pcolor = $page_404_metas['header_color'];
            }
            if ( isset( $page_404_metas['scroll_menu'] ) ) {
                $pscroll_menu = $page_404_metas['scroll_menu'];
            }
            if ( isset( $page_404_metas['header_container'] ) ) {
                $pheader_container = $page_404_metas['header_container'];
            }
        }

        if ( ! empty( $pheader ) ) {
            $header = $pheader;
        }
        if ( ! empty( $pcolor ) ) {
            $color = $pcolor;
        }
        if ( ! empty( $pscroll_menu ) ) {
            $scroll_menu = $pscroll_menu;
        }
        if ( ! empty( $pheader_container ) ) {
            $header_container = $pheader_container;
        }


        lvly_set_atts(array(
            'header_color'      => $color,
            'header_container'  => $header_container,
            'scroll_menu'       => $scroll_menu
        ));
        get_template_part( 'template/header/header', $header );
        /* Magazine */
        if ( $magazine ) { ?>
            <div class="tw-magazine-title"><?php
                lvly_template_feature( true ); ?>
            </div><?php
        } 
    }
}
if (!function_exists('lvly_template_feature')) {
    function lvly_template_feature($do=false) {
        if ( $do || ! is_page_template( array( 'page-magazinepage.php', 'page-splitpage.php', 'page-fullpage.php' ) ) ) {
            $meta_block = '';
            $heading_type = lvly_get_option( 'blog_heading', 'none' );
            $heading_block = lvly_get_option('blog_heading_content');
            if (is_page()) {
                $title = str_replace('%post_title%', get_the_title(), lvly_get_option('page_heading_title', get_the_title()));
                $heading_type = lvly_get_option( 'page_heading', 'none' );
                $heading_block = lvly_get_option('page_heading_content');
                $meta_block = is_page_template( 'page-magazinepage.php' ) ? lvly_meta('magazine_content') : lvly_meta('heading_content');
            } elseif (is_singular('post')) {
                $title = str_replace('%post_title%', get_the_title(), lvly_get_option('single_heading_title', esc_html__('Blog', 'lvly')));
                $heading_type = lvly_get_option( 'single_heading', 'none' );
                $heading_block = lvly_get_option('single_heading_content');
                $meta_block = lvly_meta('heading_content');
            } elseif (is_category()) {
                $title = str_replace("%category%", single_cat_title("", false), lvly_get_option('cat_heading_title'));
            } elseif (is_tag()) {
                $title = str_replace("%category%", single_tag_title("", false), lvly_get_option('tag_heading_title'));
            } elseif (is_tax()) {
                $query = get_queried_object();
                if (!empty($query->taxonomy)) {
                    global $post;
                    $tax = get_taxonomy($query->taxonomy);
                    if (isset($tax->singular_label) && isset($post->post_type)) {
                        $code = array('%post_type%', '%category%', '%taxonomy%');
                        $text = array($post->post_type, single_term_title("", false), $tax->singular_label);
                        $title = str_replace($code, $text, lvly_get_option('tax_heading_title'));
                    }
                }
            } elseif (is_search()) {
                $title = str_replace("%search%", get_search_query(), lvly_get_option('search_heading_title'));
            } elseif (is_archive()) {
                if (is_day()) {
                    $title = str_replace("%archive%", get_the_date(), lvly_get_option('archive_heading_title'));
                } elseif (is_month()) {
                    $title = str_replace("%archive%", get_the_date("F Y"), lvly_get_option('archive_heading_title'));
                } elseif (is_year()) {
                    $title = str_replace("%archive%", get_the_date("Y"), lvly_get_option('archive_heading_title'));
                } elseif (is_author()) {
                    global $author;
                    $userdata = get_userdata($author);
                    $title = str_replace("%author%", $userdata->display_name, lvly_get_option('author_heading_title'));
                }
            }
            if ($meta_block == 'none') {
                $heading_type = 'none';
            }elseif ($meta_block) {
                $heading_type = 'block';
                $heading_block = $meta_block;
            }
            if ($heading_type == 'title' && !empty($title)) {
                lvly_set_atts(array('post_title'=>$title));
                get_template_part( 'template/title/title', 'blogs' );
            } elseif ($heading_type == 'block' && !in_array($heading_block, array('','none'))) {
                echo lvly_get_post_content_by_slug($heading_block,'lovelyblock');
            } elseif ( ! is_page() && ! is_404() && lvly_get_att( 'header_color' ) == 'tw-header-transparent uk-light' ) {
                get_template_part( 'template/title/title', 'none' );
            }
        }
    }
}

if ( ! function_exists( 'lvly_template_footer' ) ) {
    function lvly_template_footer() {
        if ( ! is_page() || ! is_page_template( array( 'page-splitpage.php', 'page-magazinepage.php' ) ) ) {
            $footer_layout         = lvly_get_option( 'footer_layout', '4-4-4-4' );
            $footer_content        = lvly_get_option( 'footer_content' );
            $footer_content2       = lvly_get_option( 'footer_content2' );

            $pfooter = lvly_meta( ( is_page_template( 'page-fullpage.php' ) ? 'full_page_':'' ) . 'footer_content'.'footer_content2' );
            if ( is_404() ) {
                $page_404_metas = lvly_get_att( 'page_404_metas' );
                if ( isset( $page_404_metas['footer_content'] ) ) {
                    $pfooter = $page_404_metas['footer_content'];
                }
            }
            if ( $pfooter == 'none' ) {
                $footer_layout = '';
            } elseif ( $pfooter ) {
                $footer_layout = 'block';
                $footer_content = $pfooter;
            }

            if ( $footer_layout ) { ?>
                <footer class="uk-section uk-padding-remove-vertical"><?php
                    if ( $footer_layout == 'block' ) {
                        echo lvly_get_post_content_by_slug( $footer_content, 'lovelyblock' );
                    } else {
                        lvly_set_atts( array( 'footer_layout' => $footer_layout ) );
                        get_template_part( 'template/footer/footer', 'classic' );
                    } ?>
                </footer><?php
            }
        }
    }
}
if ( ! function_exists( 'lvly_template_blog' ) ) {
    function lvly_template_blog() {
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
                    echo '<div class="content-area uk-width-expand@m">';
                    if ( have_posts() ) {
                        echo '<div class="tw-blog">';
                            while ( have_posts() ) { the_post();
                                get_template_part( 'template/loop/post' );
                            }
                        echo '</div>';
                        if ( $atts['pagination'] ) {
                            lvly_pagination( $atts );
                        }
                    }
                    echo '</div>';
                    if ( $blog_layout ) {
                        get_sidebar();
                    }
                echo '</div>';
            echo '</div>';
        echo '</section>';
    }
}
/* Pagination */
if ( ! function_exists( 'lvly_pagination' ) ) {
    function lvly_pagination( $atts = array( 'pagination' => 'default' ), $return = false ) {
        global $wp_query;
        $lvly_query = isset( $atts['query'] ) ? $atts['query'] : $wp_query;
        $pages = intval( $lvly_query->max_num_pages );
        $paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : ( get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1);
        if ( empty( $pages ) ) {
            $pages = 1;
        }
        $output='';
        if ( isset( $atts['pagination'] ) && $pages>1 ) {
            switch ( $atts['pagination'] ) {
                case 'infinite':
                    $output .= '<div class="tw-pagination tw-infinite-scroll uk-text-center' . ( $atts['infinite_auto'] ? ' infinite-auto' : '' ) . '" data-has-next="' . ( $paged >= $pages ? 'false' : 'true' ) . '"' . ( $atts['infinite_auto'] ? ( ' data-infinite-auto-offset="' . intval( $atts['infinite_auto_offset'] ) . '"' ) : '' ) . '>';
                        $output .= '<a href="#" class="ldr uk-button uk-button-default uk-button-small uk-button-radius uk-button-silver tw-hover">' . esc_html__( 'Loading ...', 'lvly' ) . '</a>';
                        $output .= '<a href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '" class="next uk-button uk-button-default uk-button-small uk-button-radius uk-button-silver tw-hover">';
                            $output .= '<span class="tw-hover-inner">';
                                $output .= '<span>' . ( empty( $atts['infinite_text'] ) ? lvly_get_option( 'text_loadmore', esc_html__( 'Load More', 'lvly' ) ) : esc_html( $atts['infinite_text'] ) ) . '</span>';
                                $output .= '<i class="ion-ios-arrow-thin-right"></i>'; 
                            $output .= '</span>';
                        $output .= '</a>';
                    $output .= '</div>';
                break;
                case 'default':
                    $big = 9999; // need an unlikely integer
                    $output.= "<div class='tw-pagination'>";
                        $output.= paginate_links(
                            array(
                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'end_size' => 3,
                                'mid_size' => 6,
                                'format' => '?paged=%#%',
                                'current' => max( 1, $paged ),
                                'total' => $pages,
                                'type' => 'list',
                                'prev_text' => '<',
                                'next_text' => '>',
                            )
                        );
                    $output.= "</div>";
                break;
                case 'minimal':
                    $next = get_next_posts_link( '<span class="tw-hover-inner"><span>' . lvly_get_option( 'text_older', esc_html__( 'Older Posts', 'lvly' ) ) . '</span><i class="ion-ios-arrow-thin-right"></i></span>', $pages );
                    $prev = get_previous_posts_link( '<span class="tw-hover-inner"><span>' . lvly_get_option( 'text_newer', esc_html__( 'Newer Posts', 'lvly' ) ) . '</span><i class="ion-ios-arrow-thin-left"></i></span>', $pages );
                    if ( $next || $prev ) {
                        $output .= '<div class="tw-pagination pagination-border">';
                            if ( $next ) {
                                $output .= '<div class="older">' . str_replace( '<a', '<a class="uk-button uk-button-default uk-button-small uk-button-radius uk-button-silver tw-hover"', $next ) . '</div>';
                            }
                            if ( $prev ) {
                                $output .= '<div class="newer">' . str_replace( '<a', '<a class="uk-button uk-button-default uk-button-small uk-button-radius uk-button-silver tw-hover"', $prev ) . '</div>';
                            }
                        $output .= '</div>';
                    }
                break;
            }
        }
        if ( $return ) {
            return $output;
        } else {
            echo ( $output );
        }
    }
}
/* Waves Code */
if (!function_exists('lvly_encode')) {
    function lvly_encode($value) {
        $func = 'base64' . '_encode';
        return $func($value);
    }
}
if (!function_exists('lvly_decode')) {
    function lvly_decode($value) {
        $func = 'base64' . '_decode';
        return $func($value);
    }
}

/* Waves HTML Data */
if (!function_exists('lvly_html_data')) {
    function lvly_html_data($dAr) {
        $data='';
        if (!empty($dAr)&&is_array($dAr)) {
            foreach($dAr as $key=>$val) {
                $data.=' '.esc_attr($key).'="'.esc_attr(implode(' ', $val)).'"';
            }
        }
        return $data;
    }
}

/* Waves Anim */
if (!function_exists('lvly_anim')) {
    function lvly_anim($atts) {
        $data='';
        if (isset($atts['animation_customize'])&&$atts['animation_customize']==='true') {
            $data.=$atts['animation_custom'];
        }else{
            if (isset($atts['animation'])&&$atts['animation']!=='none') {
                /* Visual Composer Animate CSS enqueue */
                wp_enqueue_style( 'animate-css' );
                $data.='target:'.htmlspecialchars($atts['animation_target']).'; cls:'.$atts['animation'].'; delay:'.(empty($atts['animation_delay'])?'0':str_replace(' ','',$atts['animation_delay']));
                if (!empty($atts['animation_repeat'])&&$atts['animation_repeat']==='true') {
                    $data.='; repeat:true';
                }
            }
        }
        if ($data) {
            $data=' data-uk-scrollspy="'.esc_attr(str_replace('cls:','cls:animated ',$data)).'"';
        }
        return $data;
    }
}
/* Waves Item */
if (!function_exists('lvly_item')) {
    function lvly_item($atts) {
        $tag='div';
        $data=$video='';
        /* Carousel */
        foreach(array('dots','dots-each','nav','loop','autoplay','autoplay-hover-pause','autoplay-timeout','auto-width','items','center','margin','auto-height-lowest') as $val) {
            if ( isset( $atts[ $val ] ) ) {
                $atts['element_atts']['data-'.$val][]=$atts[$val];
            }
        }
        /* Elem */
        if (!empty($atts['uk_light'])&&$atts['uk_light']==='true') {$atts['element_atts']['class'][]= 'uk-light';}
        if (!empty($atts['large_screens'])&&$atts['large_screens']==='true') {$atts['element_atts']['class'][]= 'tw-hidden-large';}
        if (!empty($atts['desktop'])&&$atts['desktop']==='true') {$atts['element_atts']['class'][]= 'tw-hidden-desktop';}
        if (!empty($atts['tablet'])&&$atts['tablet']==='true') {$atts['element_atts']['class'][]= 'tw-hidden-tablet';}
        if (!empty($atts['mobile'])&&$atts['mobile']==='true') {$atts['element_atts']['class'][]= 'tw-hidden-mobile';}
        if (!empty($atts['custom_class'])) {$atts['element_atts']['class'][] = $atts['custom_class'];}
        if (!empty($atts['base'])&&!empty($atts['css'])) {
            $atts['element_atts']['class'][] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $atts['css'], $atts );
        }
        if (!empty($atts['custom_id'])) {$atts['element_atts']['id'][] = $atts['custom_id'];}
        if (!empty($atts['parallax'])) {$atts['element_atts']['data-uk-parallax'][] = $atts['parallax'];}
        if (!empty($atts['overlay'])) {$atts['element_atts']['data-overlay'][] = $atts['overlay'];}
        if (!empty($atts['tw_dimension_type'])) {
            $atts['element_atts']['data-tw-dimension-type'][]= $atts['tw_dimension_type'];
            if ($atts['tw_dimension_type']==='custom-min-height'&&!empty($atts['tw_dimension_height'])) {
                $atts['element_atts']['data-tw-dimension-height'][]= $atts['tw_dimension_height'];
                $atts['element_atts']['style'][]= 'min-height:'.$atts['tw_dimension_height'].'px;';
            }
        }
        /* Background Video */
        if (!empty($atts['bg_video'])) {
            $atts['element_atts']['class'][]= 'data-uk-cover-container';
            $video .= '<div class="tw-background-video" data-uk-cover data-video-embed="'.esc_attr(apply_filters("the_content", rawurldecode(lvly_decode($atts['bg_video'])))).'"></div>';
        }
        /* Font Style */
        $font_styles = '';
        if ( !empty( $atts['custom_font']) && 'yes'== $atts['custom_font']) {
            $atts['element_atts']['class'][] = 'tw-heading-custom-font';
            $google_fonts_obj = new Vc_Google_Fonts();

            $google_fonts_field_settings = isset( $atts['google_fonts_field']['settings'], $atts['google_fonts_field']['settings']['fields'] ) ? $atts['google_fonts_field']['settings']['fields'] : array();
            
            $google_fonts_data = strlen( $atts['google_fonts'] ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings, $atts['google_fonts'] ) : '';
            if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
                $google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
                $font_styles .= 'font-family:' . $google_fonts_family[0].';';
                $google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
                $font_styles .= 'font-weight:' . $google_fonts_styles[1].';';
                $font_styles .= 'font-style:' . $google_fonts_styles[2].';';

                $subsets = '';
                $google_fonts_subsets = get_option( 'wpb_js_google_fonts_subsets' );
                if ( is_array( $google_fonts_subsets ) && ! empty( $google_fonts_subsets ) ) {
                        $subsets = '&subset=' . implode( ',', $google_fonts_subsets );
                }
                wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
            }
            if (!empty($atts['font_size'])) {
                $font_styles .= 'font-size:'.esc_attr($atts['font_size']).'px;';
            }
            if (isset($atts['letter_spacing'])) {
                $font_styles .= 'letter-spacing:'.($atts['letter_spacing'] / 1000).'em;';
            }
            if (!empty($atts['text_transform'])) {
                $font_styles .= 'text-transform:'.esc_attr($atts['text_transform']).';';
            }
            if (!empty($atts['margin'])) {
                $font_styles .= 'margin:'.esc_attr($atts['margin']).';';
            }
        }
        /* ---------------- */
        if (!empty($atts['tag'])) {$tag=$atts['tag'];}
        
        /* anim */
        $data.=lvly_anim($atts);
        if (isset($atts['element_atts'])) {
            $data.= lvly_html_data($atts['element_atts']);
        }

        $output = '<'.esc_attr($tag).' '.$data.'>'.$video;
        return array($output,$font_styles);
    }
}
if (!function_exists('lvly_get_image_by_id')) {
    function lvly_get_image_by_id($id,$url=false,$size='full') {
        $lrg_img=wp_get_attachment_image_src($id,$size);
        $output='';
        $attachment_title='';
        $attachment_title = get_the_title($id);
        if (isset($lrg_img[0])) {
            if ($url) {
                $output.=$lrg_img[0];
            }else{
                $output .= '<img alt="'.esc_attr($attachment_title).'" src="'.esc_url($lrg_img[0]).'" />';
            }
        }
        return $output;
    }
}
if (!function_exists('lvly_icon')) {
    function lvly_icon($atts,$styled=false) {
        $output='';
        if (is_array($atts)&&!empty($atts['icon'])&&!empty($atts[$atts['icon']])&&$atts['icon']!=='none') {
            vc_icon_element_fonts_enqueue($atts['icon']);
            $style = '';
            $class = $atts[$atts['icon']];
            if ($atts['icon']==='fi_image') {
                $output.= lvly_get_image_by_id($class);
            }elseif ($atts['icon']==='fi_text') {
                $output.= $atts[$atts['icon']];
            }else{
                if ($styled) {
                    if (!empty($atts['fi_color'])) {
                        $style .='color:'.esc_attr($atts['fi_color']).';';
                    }
                    if (!empty($atts['fi_bgcolor'])) {
                        $style .='background-color:'.esc_attr($atts['fi_bgcolor']).';';
                    }
                    if (!empty($atts['fi_brcolor'])) {
                        $style .='border-color:'.esc_attr($atts['fi_brcolor']).';';
                    }
                }
                $output .= '<i class="fi '.esc_attr($class.($style?' uk-border-circle layout-2':'')).'" style="'.esc_attr($style).'"></i>';
            }

        }
        return $output;
    }
}
if ( ! function_exists( 'lvly_font_family' ) ) {
    function lvly_font_family( $font_family ) {
        return '"' . str_replace( array( '"', "'", ',' ), array( '', '', '","' ), $font_family ) . '"';
    }
}
if (!function_exists('lvly_main_data')) {
    function lvly_main_data($data=array()) {
        $data['class'][]= 'main-container';
        if (is_page_template( 'page-splitpage.php' )) {
            $data['class'][]= 'tw-splitpage';
        }
        if (is_page_template( 'page-fullpage.php' )) {
            $metaboxes = lvly_metas();
            $full_page_anim = isset($metaboxes['full_page_anim'])?$metaboxes['full_page_anim']:'';
            $data['data-speed'][]= '1000';
            switch ($full_page_anim) {
                case 'rotate_room':
                    $data['data-down-in'][]= 'pt-page-rotateRoomTopIn';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateRoomTopOut pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateRoomBottomIn';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateRoomBottomOut pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_room_carousel':
                    $data['data-down-in'][]= 'pt-page-rotateRoomTopIn';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateCarouselTopOut pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateCarouselBottomIn';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateCarouselBottomOut pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_cube':
                    $data['data-down-in'][]= 'pt-page-rotateCubeTopIn';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateCubeTopOut pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateCubeBottomIn';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateCubeBottomOut pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_side':
                    $data['data-down-in'][]= 'pt-page-moveFromBottom pt-page-ontop';
                    $data['data-down-in-delay'][]= '200';
                    $data['data-down-out'][]= 'pt-page-rotateBottomSideFirst';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromTop pt-page-ontop';
                    $data['data-up-in-delay'][]= '200';
                    $data['data-up-out'][]= 'pt-page-rotateTopSideFirst';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_fall':
                    $data['data-down-in'][]= 'pt-page-scaleUp';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateFall pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-scaleUp';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateFall pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_newspaper':
                    $data['data-down-in'][]= 'pt-page-rotateInNewspaper';
                    $data['data-down-in-delay'][]= '500';
                    $data['data-down-out'][]= 'pt-page-rotateOutNewspaper';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateInNewspaper';
                    $data['data-up-in-delay'][]= '500';
                    $data['data-up-out'][]= 'pt-page-rotateOutNewspaper';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_fush_move':
                    $data['data-down-in'][]= 'pt-page-moveFromTop';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotatePushBottom';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottom';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotatePushTop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_fush_pull':
                    $data['data-down-in'][]= 'pt-page-rotatePullTop';
                    $data['data-down-in-delay'][]= '180';
                    $data['data-down-out'][]= 'pt-page-rotatePushBottom';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotatePullBottom';
                    $data['data-up-in-delay'][]= '180';
                    $data['data-up-out'][]= 'pt-page-rotatePushTop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_fold':
                    $data['data-down-in'][]= 'pt-page-moveFromTopFade';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateFoldBottom';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottomFade';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateFoldTop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_unfold':
                    $data['data-down-in'][]= 'pt-page-rotateUnfoldBottom';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToTopFade';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateUnfoldTop';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToBottomFade';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_slide':
                    $data['data-down-in'][]= 'pt-page-rotateSlideIn';
                    $data['data-down-in-delay'][]= '200';
                    $data['data-down-out'][]= 'pt-page-rotateSlideOut';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateSlideIn';
                    $data['data-up-in-delay'][]= '200';
                    $data['data-up-out'][]= 'pt-page-rotateSlideOut';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_slides':
                    $data['data-down-in'][]= 'pt-page-rotateSidesIn';
                    $data['data-down-in-delay'][]= '200';
                    $data['data-down-out'][]= 'pt-page-rotateSlidesOut';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateSlidesIn';
                    $data['data-up-in-delay'][]= '200';
                    $data['data-up-out'][]= 'pt-page-rotateSlidesOut';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move':
                    $data['data-down-in'][]= 'pt-page-moveFromBottom';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToTop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromTop';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToBottom';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move_fade':
                    $data['data-down-in'][]= 'pt-page-moveFromBottom pt-page-ontop';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-fade';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromTop pt-page-ontop';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-fade';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move_fade_2':
                    $data['data-down-in'][]= 'pt-page-moveFromTopFade';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToBottomFade';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottomFade';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToTopFade';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move_easing':
                    $data['data-down-in'][]= 'pt-page-moveFromTop';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToBottomEasing pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottom';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToTopEasing pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move_scale':
                    $data['data-down-in'][]= 'pt-page-moveFromTop pt-page-ontop';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-scaleDown';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottom pt-page-ontop';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-scaleDown';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'scale':
                    $data['data-down-in'][]= 'pt-page-scaleUp';
                    $data['data-down-in-delay'][]= '300';
                    $data['data-down-out'][]= 'pt-page-scaleDownUp';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-scaleUpDown';
                    $data['data-up-in-delay'][]= '300';
                    $data['data-up-out'][]= 'pt-page-scaleDown';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'scale_move':
                    $data['data-down-in'][]= 'pt-page-scaleUp';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToBottom pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-scaleUp';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToTop pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'scale_center':
                    $data['data-down-in'][]= 'pt-page-scaleUpCenter';
                    $data['data-down-in-delay'][]= '300';
                    $data['data-down-out'][]= 'pt-page-scaleDownCenter';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-scaleUpCenter';
                    $data['data-up-in-delay'][]= '300';
                    $data['data-up-out'][]= 'pt-page-scaleDownCenter';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'flip':
                    $data['data-down-in'][]= 'pt-page-flipInTop';
                    $data['data-down-in-delay'][]= '500';
                    $data['data-down-out'][]= 'pt-page-flipOutBottom';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-flipInBottom';
                    $data['data-up-in-delay'][]= '500';
                    $data['data-up-out'][]= 'pt-page-flipOutTop';
                    $data['data-up-out-delay'][]= '0';
                break;
            }
        }
        echo lvly_html_data($data);
    }
}

if (!function_exists('lvly_get_post_content_by_slug')) {
    function lvly_get_post_content_by_slug($slug,$postType='post') {
        $output='';
        $pposts = get_posts( array('name' => $slug,'post_type' => $postType, 'posts_per_page' => 1) );
        if ( !empty($pposts[0]) && !empty($pposts[0]->post_content)) {
            $output = apply_filters('the_content', $pposts[0]->post_content);
        }
        return $output;
    }
}
if (!function_exists('lvly_get_ID_by_slug')) {
    function lvly_get_ID_by_slug($slug,$postType='post') {
        $id='';
        if ($slug) {
            $my_posts = get_posts( array('name' => $slug,'post_type' => $postType, 'posts_per_page' => 1) );
            if ( !empty($my_posts[0]) && !empty($my_posts[0]->ID)) {
                $id=$my_posts[0]->ID;
            }
        }
        return $id;
    }
}

/* quotes fix for some googlefont */
if ( ! function_exists( 'lvly_the_content_filter' ) ) {
    function lvly_the_content_filter( $content ) {
        if ( is_single() || is_page() ){
            $content = html_entity_decode($content, ENT_QUOTES, "UTF-8");
        }
        return $content;
    }
    add_filter( 'the_content', 'lvly_the_content_filter', 20 );
}

if ( ! function_exists( 'lvly_the_title_filter' ) ) {
    function lvly_the_title_filter( $content ) {
        $content = html_entity_decode($content, ENT_QUOTES, "UTF-8");
        return $content;
    }
    add_filter( 'the_title', 'lvly_the_title_filter', 20 );
}