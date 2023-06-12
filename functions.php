<?php
class Lvly_ThemeWaves{
    var $theme_name;
    public function __construct() {
        $this->init_theme();
        $this->constants();
        $this->requires();
    }
    public function init_theme() {
        if (is_child_theme()) {
            $temp_obj = wp_get_theme();
            $theme_obj = wp_get_theme($temp_obj->get('Template'));
        } else {
            $theme_obj = wp_get_theme();
        }
        $this->theme_name = $theme_obj->get('Name');

        add_action('after_setup_theme',  array($this, 'setup_theme'));
        add_action('wp_enqueue_scripts', array($this, 'scripts'), 20);
        add_action('admin_print_scripts', array($this, 'admin_scripts'));
        add_action('admin_print_styles',  array($this, 'admin_styles'));
        add_action('wp_enqueue_scripts', array($this, 'typekit_scripts'), 151);
        add_action('admin_print_scripts', array($this, 'typekit_scripts'));
        add_action('widgets_init', array($this, 'widgets_init'));
        add_filter('widget_title', array($this, 'widget_title' )); //Uses the built in filter function.  The title of the widget is passed to the function.
        add_filter('body_class', array($this,'body_class'));
        add_filter('get_search_form', array($this,'searchform'));
        /* WordPress Edit Gallery */
        add_filter('use_default_gallery_style', '__return_false');
        add_filter('wp_get_attachment_link', array($this,'pretty_photo'), 10, 5);
    }
    public function constants() {
        define( 'LVLY_THEMENAME', str_replace(' ', '-', strtolower( $this->theme_name ) ) );
        define( 'LVLY_META', 'themewaves_' . strtolower( LVLY_THEMENAME ) . '_options' );
        define( 'LVLY_THEME_PATH', trailingslashit( get_template_directory() ) );
        define( 'LVLY_DIR', trailingslashit( get_template_directory_uri() ) );
        define( 'LVLY_FW_PATH',LVLY_THEME_PATH . 'framework/' );
        define( 'LVLY_FW_DIR', LVLY_DIR . 'framework/' );
        define( 'LVLY_OPTIONS_NAME', 'lvly_redux' );
        define( 'LVLY_OPTIONS_PATH', LVLY_FW_PATH . 'options/' );
        define( 'LVLY_STYLESHEET_PATH', trailingslashit( get_stylesheet_directory() ) );
        define( 'LVLY_STYLESHEET_DIR', trailingslashit( get_stylesheet_directory_uri() ) );
    }
    public function requires() {
        require_once (LVLY_FW_PATH . "theme_functions.php");
        require_once (LVLY_FW_PATH . "tgm-plugins.php");
        require_once (LVLY_FW_PATH . "custom_menu.php");
        require_once (LVLY_FW_PATH . "options/options.php");
        require_once (LVLY_THEME_PATH . "woocommerce/tw_woocommerce.php");
        require_once (LVLY_FW_PATH . "theme_css.php");
    }
    public function setup_theme() {
        add_editor_style();
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'quote', 'status', 'link' ) );
        add_theme_support( 'title-tag' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'woocommerce' );

        /* Setting Theme Language - textdomain */
        load_theme_textdomain( 'lvly', LVLY_THEME_PATH . 'languages/' );

        register_nav_menus( array( 'main'   => esc_html__( 'Main Menu', 'lvly' ) ) );
        register_nav_menus( array( 'mobile' => esc_html__( 'Mobile Menu', 'lvly' ) ) );


        add_image_size('gt-iconbox-image', 416, 312, true);

        $image_sizes = lvly_get_att( 'CONST_image_sizes' );
        if ( ! empty( $image_sizes ) && is_array( $image_sizes ) ) {
            foreach ( $image_sizes as $image_size ) {
                if ( isset( $image_size['id'] ) && isset( $image_size['default'] ) && isset( $image_size['default']['width'] ) && isset( $image_size['default']['height'] ) ) {
                    $dem = lvly_get_option( $image_size['id'], array( 'width' => $image_size['default']['width'], 'height' => $image_size['default']['height'] ) );
                    add_image_size( $image_size['id'], ( empty( $dem['width'] ) ? 0 : $dem['width'] ), ( empty( $dem['height'] ) ? 0 : $dem['height'] ), true );
                    if ( strpos( $image_size['id'], 'grid' ) !== false ) {
                        /* Masonry */
                        $image_size_masonry = str_replace( 'grid', 'masonry', $image_size['id'] );
                        add_image_size( $image_size_masonry, ( empty( $dem['width'] ) ? 0 : $dem['width'] ) );

                        /* Metro */
                        $image_size_metro = str_replace( 'grid', 'metro', $image_size['id'] );
                        add_image_size( $image_size_metro .'_small',        ( empty( $dem['width'] ) ? 0 : $dem['width'] ),     ( empty( $dem['width'] ) ? 0 : $dem['width'] ),   true );
                        add_image_size( $image_size_metro .'_vertical',     ( empty( $dem['width'] ) ? 0 : $dem['width'] ),     ( empty( $dem['width'] ) ? 0 : intval( $dem['width'] )*2 ), true );
                        add_image_size( $image_size_metro .'_horizontal',   ( empty( $dem['width'] ) ? 0 : intval($dem['width'])*2 ),   ( empty( $dem['width'] ) ? 0 : $dem['width'] ),   true );
                        add_image_size( $image_size_metro .'_large',        ( empty( $dem['width'] ) ? 0 : intval($dem['width'])*2 ),   ( empty( $dem['width'] ) ? 0 : intval($dem['width'])*2 ), true );
                    }
                }
            }
        }
    }
    public function block_styles() {
        $output = $headerStyle = $footerStyle = $topStyle ='';
        $lvly_get_options = lvly_get_options();
        // Single
        if ( is_singular() || is_404() ) {
            $lvly_metas = lvly_metas();
            $contentSingleID = get_the_ID();

            // 404
            if ( is_404() ) {
                if ( ! empty( $lvly_get_options['page_404'] ) ) {
                    $lvly_metas = lvly_get_att( 'page_404_metas' );
                    $contentSingleID = lvly_get_ID_by_slug( $lvly_get_options['page_404'], 'page' );
                    $block_css = get_post_meta( $contentSingleID, '_wpb_shortcodes_custom_css', true );
                    if ( ! empty( $block_css ) ) {
                        $output .= strip_tags( $block_css );
                    }
                }
            }
            
            // Single - Top Bar
            if (!empty($lvly_metas['top_bar_content'])) {
                $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_metas['top_bar_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
                if ( !empty($block_css) ) {
                    $topStyle .= strip_tags( $block_css );
                }
            }
            // Single - Header
            if (!empty($lvly_metas['heading_content'])) {
                $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_metas['heading_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
                if ( ! empty( $block_css ) ) {
                    $headerStyle .= strip_tags( $block_css );
                }
            }
            // Single - Footer
            if (!empty($lvly_metas['footer_content'])) {
                $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_metas['footer_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
                if ( ! empty( $block_css ) ) {
                    $footerStyle .= strip_tags( $block_css );
                }
            }
            // Single - Footer 2
            if (!empty($lvly_metas['footer_content2'])) {
                $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_metas['footer_content2'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
                if ( ! empty( $block_css ) ) {
                    $footerStyle .= strip_tags( $block_css );
                }
            }


            // Single - Content
            $contentSingle = get_post_field( 'post_content', $contentSingleID );
            $regex = '/\[tw_block(.*?)\](.*?)/';
            $regex_attr = '/(.*?)=\"(.*?)\"/';
            preg_match_all($regex, $contentSingle, $matches, PREG_SET_ORDER);
            if (count($matches)) {
                $inside_column = false;
                foreach ($matches as $value) {
                    if (isset($value[1])) {
                        preg_match_all($regex_attr, trim($value[1]), $matches_attr, PREG_SET_ORDER);
                        foreach ($matches_attr as $value_attr) {
                            if (trim($value_attr[1]) === 'slug' && !empty($value_attr[2])) {
                                $block_css = get_post_meta( lvly_get_ID_by_slug($value_attr[2],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
                                if ( ! empty( $block_css ) ) {
                                        $output .= strip_tags( $block_css );
                                }
                                continue;
                            }
                        }
                    }
                }
            }
            
            if (is_page_template( 'page-splitpage.php' )) {
                $metaboxes = lvly_metas();
                if (isset($metaboxes['split_page_blocks']['left']['block'])&&is_array($metaboxes['split_page_blocks']['left']['block'])&&isset($metaboxes['split_page_blocks']['right']['block'])&&is_array($metaboxes['split_page_blocks']['right']['block'])) {
                    foreach($metaboxes['split_page_blocks']['left']['block'] as $i=>$slugL) {
                        $slugR=isset($metaboxes['split_page_blocks']['right']['block'][$i])?$metaboxes['split_page_blocks']['right']['block'][$i]:'';
                        if ($slugL) {
                            $idL=lvly_get_ID_by_slug($slugL,'lovelyblock');
                            if ($idL) {
                                $block_css = get_post_meta( $idL, '_wpb_shortcodes_custom_css', true );
                                if ( ! empty( $block_css ) ) {
                                    $output .= strip_tags( $block_css );
                                }
                            }
                        }
                        if ($slugR) {
                            $idR=lvly_get_ID_by_slug($slugR,'lovelyblock');
                            if ($idR) {
                                $block_css = get_post_meta( $idR, '_wpb_shortcodes_custom_css', true );
                                if ( ! empty( $block_css ) ) {
                                    $output .= strip_tags( $block_css );
                                }
                            }
                        }
                    }
                }
            } elseif (is_page_template( 'page-fullpage.php' )) {
                $metaboxes = lvly_metas();
                if (isset($metaboxes['full_page_blocks']['section']['block'])&&is_array($metaboxes['full_page_blocks']['section']['block'])) {
                    foreach($metaboxes['full_page_blocks']['section']['block'] as $i=>$slug) {
                        if ($slug) {
                            $id=lvly_get_ID_by_slug($slug,'lovelyblock');
                            if ($id) {
                                $block_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
                                if ( ! empty( $block_css ) ) {
                                    $output .= strip_tags( $block_css );
                                }
                            }
                        }
                    }
                }

                // Fullpage - Footer
                if ( ! empty( $lvly_metas['full_page_footer_content'] ) ) {
                    $block_css = get_post_meta( lvly_get_ID_by_slug( $lvly_metas['full_page_footer_content'], 'lovelyblock' ), '_wpb_shortcodes_custom_css', true );
                    if ( ! empty( $block_css ) ) {
                        $output .= strip_tags( $block_css );
                    }
                }
            }
        }
        
        // Heading
        if (!$headerStyle) {
            if (is_page()) {
                $heading_content = $lvly_get_options['page_heading_content'];
            }elseif (is_singular('post')) {
                $heading_content = $lvly_get_options['single_heading_content'];
            }
            if (!empty($heading_content)) {
                $block_css = get_post_meta( lvly_get_ID_by_slug($heading_content,'lovelyblock'), '_wpb_shortcodes_custom_css', true );
                if ( !empty( $block_css ) ) {
                    $headerStyle .= strip_tags( $block_css );
                }
            }
        }
        // Footer
        if (!$footerStyle&&!empty($lvly_get_options['footer_content'])) {
            $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_get_options['footer_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
            if ( ! empty( $block_css ) ) {
                $footerStyle .= strip_tags( $block_css );
            }
        }
        if (!$footerStyle&&!empty($lvly_get_options['footer_content2'])) {
            $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_get_options['footer_content2'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
            if ( ! empty( $block_css ) ) {
                $footerStyle .= strip_tags( $block_css );
            }
        }
        // Merge
        $output .= $topStyle.$headerStyle.$footerStyle;
        return $output;
    }
    public function scripts() {
        wp_localize_script( 'jquery', 'lvly_script_data', array(
            'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' ))
        ));
        wp_enqueue_style('uikit', LVLY_DIR . 'assets/css/uikit.min.css');
        wp_register_style('justifiedGallery', LVLY_DIR . 'assets/css/justifiedGallery.min.css');
        wp_enqueue_style('ionicons', LVLY_DIR . 'assets/css/ionicons.min.css');
        wp_enqueue_style('simple-line-icons', LVLY_DIR . 'assets/css/simple-line-icons.css');
        wp_enqueue_style('font-awesome', LVLY_DIR . 'assets/css/font-awesome.css');
        if (is_page_template( 'page-fullpage.php' )) {
            wp_enqueue_style('lvly-animations', LVLY_DIR . 'assets/css/animations.css');
            wp_enqueue_style('jquery-fullpage', LVLY_DIR . 'assets/css/jquery.fullpage.css');
        }
        if (is_page_template( 'page-splitpage.php' )) {
            wp_enqueue_style('jquery-multiscroll', LVLY_DIR . 'assets/css/jquery.multiscroll.min.css');
        }
        if (lvly_woocommerce()) {
           wp_enqueue_style('lvly-tw-woocommerce', LVLY_DIR . 'woocommerce/assets/tw-woocommerce.css');
           wp_enqueue_script('lvly-tw-woocommerce',LVLY_DIR . 'woocommerce/assets/tw-woocommerce.js', array('jquery'), false, true);
        }
        wp_enqueue_style('owl-carousel', LVLY_DIR . 'assets/css/owl.carousel.min.css');
        wp_enqueue_style('lvly-style', LVLY_STYLESHEET_DIR . 'style.css');
        wp_add_inline_style('lvly-style', lvly_get_option_styles());
        wp_enqueue_style('lvly-responsive', LVLY_DIR . 'assets/css/responsive.css');
        wp_add_inline_style('lvly-responsive', $this->block_styles());

        if (is_single() && comments_open()) {
            wp_enqueue_script('comment-reply');
        }
        wp_enqueue_script('uikit', LVLY_DIR . 'assets/js/uikit.min.js', array('jquery'), false, true);
        if (is_page_template( 'page-fullpage.php' )) {
            wp_enqueue_script('jquery-fullpage', LVLY_DIR . 'assets/js/jquery.fullpage.js', array('jquery'), false, true);
        }
        if (is_page_template( 'page-splitpage.php' )) {
            wp_enqueue_script('jquery-easings', LVLY_DIR . 'assets/js/jquery.easings.min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery-multiscroll', LVLY_DIR . 'assets/js/jquery.multiscroll.min.js', array('jquery'), false, true);
        }
        wp_register_script('jquery-justifiedGallery',LVLY_DIR . 'assets/js/jquery.justifiedGallery.min.js');
        wp_register_script('ResizeSensor',LVLY_DIR . 'assets/js/ResizeSensor.min.js');
        wp_register_script('theia-sticky-sidebar',LVLY_DIR . 'assets/js/theia-sticky-sidebar.min.js');
        wp_register_script('owl-carousel',LVLY_DIR . 'assets/js/owl.carousel.min.js');
        wp_register_script('codrops-tiltfx',LVLY_DIR . 'assets/js/codrops-tiltfx.js');

        wp_register_script( 'isotope', LVLY_DIR . 'assets/js/isotope.pkgd.min.js' );
        wp_enqueue_script( 'lvly-theme', LVLY_DIR . 'assets/js/theme.js' );
    }
    public function admin_scripts() {
        global $post,$pagenow;
        if (current_user_can('edit_posts') && ($pagenow == 'post-new.php' || $pagenow == 'post.php')&&isset($post)) {
            wp_localize_script( 'jquery', 'lvly_script_data', array(
                'home_uri' => esc_url(home_url('/')),
                'post_id' => esc_attr($post->ID),
                'nonce' => esc_attr(wp_create_nonce( 'themewaves-ajax' )),
                'label_create' => esc_html__("Create Featured Gallery", 'lvly'),
                'label_edit' => esc_html__("Edit Featured Gallery", 'lvly'),
                'label_save' => esc_html__("Save Featured Gallery", 'lvly'),
                'label_saving' => esc_html__("Saving...", 'lvly')
            ));
            wp_enqueue_script('lvly-colorpicker',  LVLY_FW_DIR.'assets/js/colorpicker.js');
            wp_enqueue_script('lvly-metabox',  LVLY_FW_DIR.'assets/js/metabox.js');
        }
    }
    function admin_styles() {
        wp_enqueue_style('lvly-metabox',LVLY_FW_DIR . 'assets/css/metabox.css');
    }
    function typekit_scripts() {
        global $pagenow;

        $kit_enqueue = false;
        $kit_id = lvly_get_option( 'typekit_kit_ID' );
    
        if ( $kit_id ) {
            if ( ! is_admin() ) {
                $typography_fields = lvly_get_att( 'typography_fields' );
                $kit_fonts_list  = get_option( 'lvly_custom_fonts', array() );
                if ( is_array( $kit_fonts_list ) ) {
                    $kit_fonts_list_first  = reset( $kit_fonts_list );
                    $kit_fonts_families  = array_keys( $kit_fonts_list_first );
                    foreach ( $typography_fields as $typography_field ) {
                        if ( ! empty( $typography_field['font-family'] ) && in_array( $typography_field['font-family'] , $kit_fonts_families ) ) {
                            $kit_enqueue = true;
                            break;
                        }
                    }
                }
            } elseif ( $pagenow == 'admin.php' ) {
                $kit_enqueue = true;
            }
        }
        if ( $kit_enqueue ) {
            wp_enqueue_script( 'typekit', 'https://use.typekit.com/' . trim( $kit_id ) . '.js' );
            wp_add_inline_script( 'typekit', 'try{Typekit.load();}catch(e){}' );
        }
    }
    public function widgets_init() {
        register_sidebar(array(
            'name' => esc_html__('Default sidebar', 'lvly'),
            'id' => 'default-sidebar',
            'before_widget' => '<div class="widget-item"><aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside></div>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));

        /* footer sidebar */
        $grid  = lvly_get_option('footer_layout', '3-3-3-3');
        if (!empty($grid) && $grid != 'block') {
            $i = 1;
            foreach (explode('-', $grid) as $g) {
                register_sidebar(array(
                    'name' => esc_html__('Footer sidebar', 'lvly')." $i",
                    'id' => "lvly-footer-sidebar-$i",
                    'description' => esc_html__('The footer sidebar widget area', 'lvly'),
                    'before_widget' => '<aside class="widget %2$s" id="%1$s">',
                    'after_widget' => '</aside>',
                    'before_title' => '<h3 class="widget-title">',
                    'after_title' => '</h3>',
                ));
                $i++;
            }
        }
    }
    public function widget_title($html_widget_title) {

	$html_widget_title_tagopen = '['; //Our HTML opening tag replacement
	$html_widget_title_tagclose = ']'; //Our HTML closing tag replacement

	$html_widget_title = str_replace($html_widget_title_tagopen, '<', $html_widget_title);
	$html_widget_title = str_replace($html_widget_title_tagclose, '>', $html_widget_title);

        $html_widget_title = str_replace(array('&quot;','&#8220;','&#8221;'), '"', $html_widget_title );

	return $html_widget_title;
    }
    public function body_class($classes) {
        $classes[] = 'loading';
        return $classes;
    }
    public function searchform() {
        $form = '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '" >
        <div class="input">
        <input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_attr__('Keyword ...', 'lvly') . '" />
            <button type="submit" class="button-search"><i class="simple-icon-magnifier"></i></button>
        </div>
        </form>';
        return $form;
    }
    public function pretty_photo($content, $id, $size, $permalink) {
        if (!$permalink)
            $content = preg_replace("/<a/", "<a rel=\"prettyPhoto[gallery]\"", $content, 1);
        $content = preg_replace("/<\/a/", "<span class=\"image-overlay\"></span></a", $content, 1);
        return $content;
    }
}
$lvly_ThemeWaves = new Lvly_ThemeWaves();

if (!isset($content_width)) {
   $content_width = 1170;
}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'lvly_vcSetAsTheme' );
function lvly_vcSetAsTheme() {
    vc_set_as_theme();
}

/* One Click Dummy for PT One Click Plugin */
function lvly_import_files() {
    return array(
        array(
            'import_file_name'           => esc_html__( 'Main Demo', 'lvly' ),
            'import_file_url'            => LVLY_DIR . 'dummy-data/dummy-data.xml',
            'import_widget_file_url'     => LVLY_DIR . 'dummy-data/widgets.json',
            'import_notice'              => esc_html__( 'Please check the Recommended PHP settings on our Documentation and apply your server.', 'lvly' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'lvly_import_files' );

function lvly_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'main' );
    $mobile = get_term_by( 'name', 'Mobile Menu', 'mobile' );

    set_theme_mod( 'nav_menu_locations', array(
            'main' => $main_menu->term_id,
            'mobile' => $mobile->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'lvly_after_import_setup' );