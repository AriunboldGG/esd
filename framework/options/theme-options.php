<?php
$options_image_size=lvly_get_att('CONST_image_sizes');
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux' ) ) {return;}

// This is your option name where all the Redux data is stored.
$opt_name = LVLY_OPTIONS_NAME;

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get( 'Name' ),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get( 'Version' ),
    // Version that appears at the top of your panel
    'menu_type'            => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => false,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__( 'Theme Options', 'lvly'),
    'page_title'           => esc_html__( 'Theme Options', 'lvly'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => false,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => '',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);
Redux::setArgs( $opt_name, $args );

$headings = array(
    'none' => 'Disable',
    'title' => 'Only Title',
    'block' => 'Content Block',
);
$footers = array('' => 'Disable',
    '12'      => '1 Column (12)',
    '6-6'     => '2 Columns (6-6)',
    '4-4-4'   => '3 Columns (4-4-4)',
    '3-3-3-3' => '4 Columns (3-3-3-3)',
    'block' => 'Content Block',
);
$content_block = array('' => 'Select Block');
$posts_array = get_posts( array('post_type' => 'lovelyblock', 'posts_per_page' => '-1','orderby'=> 'title', 'order' => 'ASC') );
foreach($posts_array as $post_array) {
    $content_block[$post_array->post_name] = $post_array->post_title;
}


$pages = $pagesDefaultTemplate = array(
    '' => 'Disable (Default)',
);
$pages_array = get_posts( array( 'post_type' => 'page', 'posts_per_page' => '-1', 'orderby'=> 'title', 'order' => 'ASC') );
foreach($pages_array as $page_array) {
    $pages[ $page_array->post_name ] = $page_array->post_title;
}
$pages_array = get_posts( array( 'post_type' => 'page', 'posts_per_page' => '-1', 'orderby'=> 'title', 'order' => 'ASC', 'meta_key'  =>'_wp_page_template', 'meta_value' => 'default') );
foreach($pages_array as $page_array) {
    $pagesDefaultTemplate[ $page_array->post_name ] = $page_array->post_title;
}

/*
 * ---> END ARGUMENTS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

/*

    As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


 */

// -> START Basic Fields
$options_general=array(
    array(
        'id'       => 'favicon',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Upload Your Favicon', 'lvly'),
        'subtitle' => esc_html__( 'Default Fav icon is located in our lvly/assets/img/favicon.png', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => LVLY_DIR . 'assets/img/favicon.png',
    ),
    array(
        'id'       => 'logo',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Upload Logo', 'lvly'),
        'subtitle' => esc_html__( 'Recommended Size: 230x80', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => '',
    ),
    array(
        'id'       => 'logo_light',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Upload Light Logo', 'lvly'),
        'subtitle' => esc_html__( 'Recommended Size: 230x80. It will be displayed when you have set Header-color: Dark or Transparent', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => '',
    ),
    array(
        'id'       => 'scroll_menu',
        'type'     => 'select',
        'title'    => esc_html__( 'Header Scroll Up Style', 'lvly'),
        'subtitle' => esc_html__( 'Please choose the Scroll Up for following functions.', 'lvly'),
        'default'  => 'none',
        'options'  => array(
            'none' => 'Disable',
            'scroll-up' => 'Scroll Up',
            'fixed' => 'Fixed to Top',
        ),
    ),
    array(
        'id'       => 'page_404',
        'type'     => 'select',
        'title'    => esc_html__( 'Set 404 Error Page', 'lvly'),
        'subtitle' => esc_html__( 'Before you Choosing it you need to Create it on Pages. This option will give your Customize the 404 Page for yourself!', 'lvly'),
        'options'  => $pagesDefaultTemplate,
    ),
    array(
        'id'       => 'fullmenu_social',
        'type'     => 'multi_text',
        'title'    => esc_html__('Full Menu - Social Icons', 'lvly'),
        'subtitle' => esc_html__('Following Format is available. Example: #icon_class|#link', 'lvly'),
        'default'  => array( 'ion-social-facebook|facebook.com', 'ion-social-twitter|twitter.com', 'ion-social-youtube|youtube.com'),
    ),
);
$options_topbar=array(
    array(
        'id'       => 'top_bar',
        'type'     => 'select',
        'title'    => esc_html__( 'Top bar?', 'lvly' ),
        'subtitle' => esc_html__('You can change the TopBar Content with Content Block or Edit the Default sections.', 'lvly'),
        'options'  => array(
            'true' => 'Show',
            '' => 'Disable',
            'block' => 'Content Block',
        ),
        'default'  => ''
    ),
    array(
        'id'       => 'top_text',
        'type'     => 'multi_text',
        'title'    => esc_html__('Top Left Text', 'lvly'),
        'subtitle' => esc_html__('Following Format will display your content. Please check carefully and insert Icon Class from FontAwesome or Ion Icons .Example: #yourcontent|#icon_class|#link', 'lvly'),
        'default'  => array( '(001) 8686 234 432|ion-iphone', 'support@themewaves.com|ion-ios-email-outline', '88, Orchard St, New York|ion-ios-location-outline'),
        'required' => array(
            array('top_bar','!=','block'),
        ),
    ),
    array(
        'id'       => 'top_text2',
        'type'     => 'multi_text',
        'title'    => esc_html__('Top Right Text', 'lvly'),
        'subtitle' => esc_html__('Following Format will display your content. Please check carefully and insert Icon Class from FontAwesome or Ion Icons .Example: #yourcontent|#icon_class|#link', 'lvly'),
        'default'  => array( 'facebook|ion-social-facebook|facebook.com', 'twitter|ion-social-twitter|twitter.com', 'youtube|ion-social-youtube|youtube.com'),
        'required' => array(
            array('top_bar','!=','block'),
        )
    ),
    array(
        'id'       => 'top_bar_content',
        'type'     => 'select',
        'title'    => esc_html__( 'Choose from Content Block CPT.', 'lvly'),
        'subtitle' => esc_html__( 'First you need to create the Content Block and Assign it here. It will displayed on Globally.', 'lvly'),
        'options'  => $content_block,
        'default'  => '',
        'required' => array(
            array('top_bar','=','block'),
        ),
    ),
);

$options_header=array(
    array(
        'id'       => 'header_layout',
        'type'     => 'image_select',
        'title'    => esc_html__( 'Header Layout', 'lvly' ),
        'options'  => array(
                'classic' => array(
                    'alt' => esc_html__('Classic', 'lvly'),
                    'title' => esc_html__('Classic', 'lvly'),
                    'img' => LVLY_DIR . 'framework/assets/img/classic.jpg'
                ),
                'opacity' => array(
                    'alt' => esc_html__('Opacity Menu', 'lvly'),
                    'title' => esc_html__('Opacity Menu', 'lvly'),
                    'img' => LVLY_DIR . 'framework/assets/img/opacity.jpg'
                ),
                'full' => array(
                    'alt' => esc_html__('Full Menu', 'lvly'),
                    'title' => esc_html__('Full Menu', 'lvly'),
                    'img' => LVLY_DIR . 'framework/assets/img/full.jpg'
                ),
                'sidebar' => array(
                    'alt' => esc_html__('Left Sidebar', 'lvly'),
                    'title' => esc_html__('Left Sidebar', 'lvly'),
                    'img' => LVLY_DIR . 'framework/assets/img/sidemenu.jpg'
                ),
            ),
        'default'  => 'classic',
    ),
    array(
        'id'       => 'header_container',
        'type'     => 'select',
        'title'    => esc_html__( 'Header Container Type', 'lvly' ),
        'subtitle' => esc_html__( 'Please choose the Heading Container', 'lvly'),
        'options'  => array(
            'uk-container uk-container-small' => '900px Container',
            'uk-container' => '1170px Container',
            'uk-container uk-container-large' => '1600px Container',
            'uk-container uk-container-expand' => '100% Fullwidth Container',
        ),
        'default'  => 'uk-container'
    ),
    array(
        'id'       => 'header_color',
        'type'     => 'select',
        'title'    => esc_html__( 'Header Color Type', 'lvly' ),
        'subtitle' => esc_html__( 'Please choose the Heading Color Scheme', 'lvly'),
        'options'  => array(
            'tw-header-light' => 'Light',
            'tw-header-dark uk-light' => 'Dark',
            'tw-header-transparent uk-light' => 'Transparent',
        ),
        'default'  => 'tw-header-light'
    ),
    array(
        'id'       => 'header_height',
        'title'    => esc_html__( 'Set Header Height', 'lvly'),
        'type'      => 'slider',
        "default"   => 70,
        "min"       => 40,
        "step"      => 10,
        "max"       => 300,
        'display_value' => 'text'
    ),
    array(
        'id'       => 'header_search',
        'type'     => 'switch',
        'title'    => esc_html__( 'Enable Search on Header?', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'header_cart',
        'type'     => 'switch',
        'title'    => esc_html__( 'Enable Cart Widget on Header?', 'lvly'),
        'subtitle' => esc_html__( 'Woocommerce required', 'lvly'),
        'default'  => 0,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
);

$options_blog=array(
    array(
        'id'       => 'blog_sidebar',
        'type'     => 'select',
        'title'    => esc_html__( 'Blog sidebar', 'lvly' ),
        'subtitle' => esc_html__( 'Those option will control only the Default blog. If you want to override it then Use Pagebuilder Blog Element with Visual Composer.', 'lvly' ),
        'options'  => array(
            'none' => 'Disable',
            'left-sidebar' => 'Left Sidebar',
            'right-sidebar' => 'Right Sidebar',
        ),
        'default'  => 'right-sidebar'
    ),
    array(
        'id'       => 'blog_excerpt',
        'type'     => 'text',
        'title'    => esc_html__( 'Blog excerpt?', 'lvly' ),
        'subtitle' => esc_html__( 'Excerpt word count. You can set it on Blog Single area.', 'lvly' ),
        'default'  => '20'
    ),
    array(
        'id'       => 'blog_pagination',
        'type'     => 'select',
        'title'    => esc_html__( 'Blog Pagination', 'lvly' ),
        'subtitle' => esc_html__( 'Choose the blog Pagination style', 'lvly' ),
        'options'  => array(
            'default' => 'Default',
            'simple' => 'Simple',
            'infinite' => 'Infinite',
            '' => 'Disable',
        ),
        'default'  => 'default'
    ),
    array(
        'id'=>'blog-single-start',
        'type' => 'section',
        'title' => esc_html__('Blog Single Options', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
        ),
    array(
        'id'       => 'single_layout',
        'type'     => 'image_select',
        'title'    => esc_html__( 'Set Blog Single Layout', 'lvly'),
        'options'  => array(
                'right-sidebar' => array(
                    'alt' => esc_html__('Right Sidebar', 'lvly'),
                    'title' => esc_html__('Right Sidebar', 'lvly'),
                    'img' => LVLY_DIR . 'framework/assets/img/single-1.jpg'
                ),
                'left-sidebar' => array(
                    'alt' => esc_html__('Left Sidebar', 'lvly'),
                    'title' => esc_html__('Left Sidebar', 'lvly'),
                    'img' => LVLY_DIR . 'framework/assets/img/single-2.jpg'
                ),
                'narrow-content' => array(
                    'alt' => esc_html__('Narrow Content', 'lvly'),
                    'title' => esc_html__('Narrow Content', 'lvly'),
                    'img' => LVLY_DIR . 'framework/assets/img/single-3.jpg'
                ),
                'fullwidth-content' => array(
                    'alt' => esc_html__('Fullwidth Content', 'lvly'),
                    'title' => esc_html__('Fullwidth Content', 'lvly'),
                    'img' => LVLY_DIR . 'framework/assets/img/single-4.jpg'
                ),
            ),
        'default'  => 'right-sidebar',
    ),
    array(
        'id'       => 'single_media',
        'type'     => 'select',
        'title'    => esc_html__( 'Display Featured Media?', 'lvly' ),
        'options'  => array(
            'small' => 'Small',
            'large' => 'Large',
            'none' => 'Disable',
        ),
        'default'  => 'small'
    ),
    array(
        'id'       => 'sidebar_affix',
        'type'     => 'switch',
        'title'    => esc_html__( 'Enable Sidebar Affix?', 'lvly'),
        'subtitle' => esc_html__( 'If you set this on Sidebar areas will be affixed.', 'lvly'),
        'default'  => 0,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'single_share',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Post share on Single?', 'lvly'),
        'subtitle'     => esc_html__( 'Social shares visible or not on Single Post area', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'single_pagination',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Next, Prev on Single?', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'single_cats',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Categories on Single?', 'lvly'),
        'subtitle'     => esc_html__( 'Post categories', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'single_meta',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Meta on Single?', 'lvly'),
        'subtitle'     => esc_html__( 'Post date and author', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'single_tags',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Tags on Single?', 'lvly'),
        'subtitle'     => esc_html__( 'Tag on Single', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'single_author',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display author on Single?', 'lvly'),
        'subtitle'     => esc_html__( 'Author box on Bottom of the Single Content.', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'=>'blog-single-end',
        'type' => 'section',
        'indent' => false // Indent all options below until the next 'section' option is set.
    ),
);
$options_page=array(
    array(
        'id'    => 'other_shortcode',
        'type'  => 'info',
        'style' => 'warning',
        'title' => '%post_title% => "Post title", %category% => "Category title", %taxonomy% => "Taxonomy name", %post_type% => "Post type", %search% => "Search query", %author% => "Author name", %archive% => "Archive date time"',
        'icon'  => '',
        'desc'  => esc_html__( 'Use this Shortcodes on any Element or Any Content Block etc.', 'lvly')
    ),
    array(
        'id'=>'page-heading-start',
        'type' => 'section',
        'title' => esc_html__('Page Title options', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
    ),
    array(
        'id'       => 'page_heading',
        'type'     => 'select',
        'title'    => esc_html__( 'Page Title Type', 'lvly'),
        'options'  => $headings,
        'default'  => 'title',
    ),
    array(
        'id'       => 'page_heading_content',
        'type'     => 'select',
        'title'    => esc_html__( 'Choose from Content Block CPT.', 'lvly'),
        'subtitle' => esc_html__( 'First you need to create the Content Block and Assign it here. It will displayed on Globally.', 'lvly'),
        'options'  => $content_block,
        'default'  => '',
        'required' => array(
            array('page_heading','=','block'),
        )
    ),
    array(
        'id'       => 'page_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Page Title Text', 'lvly'),
        'subtitle' => esc_html__('"%post_title%" Will display the Current Page Name. It will displayed on Globally.', 'lvly'),
        'default'  => esc_html__('%post_title%', 'lvly'),
        'required' => array(
            array('page_heading','=','title'),
        )
    ),
    array(
        'id'=>'single-heading-start',
        'type' => 'section',
        'title' => esc_html__('Single Title options', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
    ),
    array(
        'id'       => 'single_heading',
        'type'     => 'select',
        'title'    => esc_html__( 'Single Heading Type', 'lvly'),
        'options'  => $headings,
        'default'  => 'none',
    ),
    array(
        'id'       => 'single_heading_content',
        'type'     => 'select',
        'title'    => esc_html__( 'Choose from Content Block CPT.', 'lvly'),
        'subtitle' => esc_html__( 'First you need to create the Content Block and Assign it here. It will displayed on Globally.', 'lvly'),
        'options'  => $content_block,
        'default'  => '',
        'required' => array(
            array('single_heading','=','block'),
        )
    ),
    array(
        'id'       => 'single_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Single Post Title Text', 'lvly'),
        'default'  => esc_html__('Blog Post', 'lvly'),
        'required' => array(
            array('single_heading','=',array('title')),
        )
    ),
    array(
        'id'=>'blog-heading-start',
        'type' => 'section',
        'title' => esc_html__('Blog Title options', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
    ),
    array(
        'id'       => 'blog_heading',
        'type'     => 'select',
        'title'    => esc_html__( 'Blog Title Type', 'lvly'),
        'options'  => $headings,
        'default'  => 'title',
    ),
    array(
        'id'       => 'blog_heading_content',
        'type'     => 'select',
        'title'    => esc_html__( 'Choose from Content Block CPT.', 'lvly'),
        'subtitle' => esc_html__( 'First you need to create the Content Block and Assign it here. It will displayed on Globally.', 'lvly'),
        'options'  => $content_block,
        'default'  => '',
        'required' => array(
            array('blog_heading','=','block'),
        )
    ),
    array(
        'id'       => 'blog_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Single Post Title Text', 'lvly'),
        'default'  => esc_html__('Blog Post', 'lvly'),
        'required' => array(
            array('blog_heading','=',array('title')),
        )
    ),
    array(
        'id'=>'heading-title-start',
        'type' => 'section',
        'title' => esc_html__('Other Archive Pages - Title Customize', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
    ),
    array(
        'id'       => 'cat_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Category Title Text', 'lvly'),
        'default'  => esc_html__('Category: %category%', 'lvly'),
    ),
    array(
        'id'       => 'tag_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Tag Title Text', 'lvly'),
        'default'  => esc_html__('Tag: %category%', 'lvly'),
    ),
    array(
        'id'       => 'archive_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Archive Title Text', 'lvly'),
        'default'  => esc_html__('Archive: %archive%', 'lvly'),
    ),
    array(
        'id'       => 'author_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Author Title Text', 'lvly'),
        'default'  => esc_html__('Author: %author%', 'lvly'),
    ),
    array(
        'id'       => 'search_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Search Title Text', 'lvly'),
        'default'  => esc_html__('Search: %search%', 'lvly'),
    ),
    array(
        'id'       => 'tax_heading_title',
        'type'     => 'text',
        'title'    => esc_html__( 'Insert the Taxonomy Title Text', 'lvly'),
        'default'  => esc_html__('%post_type%: %category%', 'lvly'),
    ),
);
$options_portfolio=array(
    array(
        'id'       => 'portfolio_sidebar_affix',
        'type'     => 'switch',
        'title'    => esc_html__( 'Enable Sidebar Affix?', 'lvly'),
        'subtitle' => esc_html__( 'If you set this on Sidebar areas will be affixed.', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'portfolio_date',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Dates on Single?', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'portfolio_client',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Clients on Single?', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'portfolio_cats',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Categories on Single?', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'portfolio_share',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Share on Single?', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
    array(
        'id'       => 'portfolio_pagination',
        'type'     => 'switch',
        'title'    => esc_html__( 'Display Next, Prev on Single?', 'lvly'),
        'default'  => 1,
        'on'       => esc_html__( 'Yes', 'lvly'),
        'off'      => esc_html__( 'No', 'lvly'),
    ),
);
$options_color=array(
    array(
        'id'=>'body-section-start',
        'type' => 'section',
        'title' => esc_html__('General Color', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
        ),
    array(
        'id'       => 'body_color',
        'type'     => 'color',
        'title'    => esc_html__( 'Body Color?', 'lvly'),
        'default'  => '#666666',
    ),
    array(
        'id'       => 'body_bg',
        'type'     => 'background',
        'title'    => esc_html__('Body Background', 'lvly'),
        'subtitle' => esc_html__('This will works whole background area. If you chosen the Boxed Layout then it will work outside of Container area. It will not work if you have chosen Full Layout', 'lvly'),
        'default'  => array(
            'background-color' => '#fff',
        )
    ),
    array(
        'id'       => 'heading_color',
        'type'     => 'color',
        'title'    => esc_html__( 'Heading Title Color (H1-H6)?', 'lvly'),
        'default'  => '#151515',
    ),
    array(
        'id'       => 'link_color',
        'type'     => 'link_color',
        'title'    => esc_html__( 'Link Color?', 'lvly'),
        
        'default'  => array(
            'regular' => '#808080',
            'hover'   => '#999',
            'active'  => false,
        )
    ),
    array(
        'id'       => 'border_color',
        'type'     => 'color',
        'title'    => esc_html__( 'Border Color?', 'lvly'),
        'subtitle' => 'table, image description, post comment, widget, footer etc... ',
        'default'  => '#e6e6e6',
    ),
    array(
        'id'       => 'input_bg',
        'type'     => 'color',
        'title'    => esc_html__( 'Input Background Color?', 'lvly'),
        'subtitle' => 'and tags, author box, next prev posts, comment form etc... ',
        'default'  => '#f0f0f0',
    ),
    array(
        'id'       => 'input_color',
        'type'     => 'color',
        'title'    => esc_html__( 'Input Text Color?', 'lvly'),
        'subtitle' => 'and tags, author box, next prev posts, comment form etc... ',
        'default'  => '#999',
    ),


    array(
        'id'=>'body-section-end',
        'type' => 'section',
        'indent' => false // Indent all options below until the next 'section' option is set.
    ),

    array(
        'id'=>'post-section-start',
        'type' => 'section',
        'title' => esc_html__('Post Area Colors', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
    ),
    array(
        'id'       => 'post_link',
        'type'     => 'link_color',
        'title'    => esc_html__( 'Post Link Color?', 'lvly'),
        'default'  => array(
            'regular' => '#151515',
            'hover'   => '#999',
            'active'  => false,
        )
    ),
    array(
        'id'=>'post-section-end',
        'type' => 'section',
        'indent' => false // Indent all options below until the next 'section' option is set.
    ),

    array(
        'id'=>'header-section-start',
        'type' => 'section',
        'title' => esc_html__('Header Area Colors', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
        ),
    array(
        'id'       => 'header_bg',
        'type'     => 'color',
        'title'    => esc_html__('Header Background', 'lvly'),
        'default'  => '#fff',
    ),
    array(
        'id'       => 'menu_color',
        'type'     => 'color',
        'title'    => esc_html__('Menu text color?', 'lvly'),
        'subtitle' => esc_html__('Note: menu and search icon?', 'lvly'),
        'default'  => '#151515',
    ),
    array(
        'id'       => 'menu_hover',
        'type'     => 'color',
        'title'    => esc_html__('Menu hover color?', 'lvly'),
        'subtitle' => esc_html__('If you want to disable it then set the same color for Header area text color.', 'lvly'),
        'default'  => '#151515',
    ),
    array(
        'id'       => 'submenu_bg',
        'type'     => 'color',
        'title'    => esc_html__('SubMenu BG color?', 'lvly'),
        'default'  => '#151515',
    ),
    array(
        'id'       => 'submenu_hover_bg',
        'type'     => 'color',
        'title'    => esc_html__('SubMenu Hover BG color?', 'lvly'),
        'default'  => 'transparent',
    ),
    array(
        'id'       => 'submenu_color',
        'type'     => 'color',
        'title'    => esc_html__('SubMenu Text color?', 'lvly'),
        
        'default'  => '#999',
    ),
    array(
        'id'       => 'submenu_hover_color',
        'type'     => 'color',
        'title'    => esc_html__('SubMenu Hover Text color?', 'lvly'),
        'default'  => '#fff',
    ),

    array(
        'id'=>'header-section-end',
        'type' => 'section',
        'indent' => false // Indent all options below until the next 'section' option is set.
    ),

    array(
        'id'=>'footer-section-start',
        'type' => 'section',
        'title' => esc_html__('Footer Area Colors', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
    ),
    array(
        'id'       => 'footer_text_color',
        'type'     => 'color',
        'title'    => esc_html__( 'Footer Text Color?', 'lvly'),
        
        'default'  => '#999',
    ),
    array(
        'id'       => 'footer_link_color',
        'type'     => 'link_color',
        'title'    => esc_html__( 'Link Color?', 'lvly'),
        
        'default'  => array(
            'regular' => '#999',
            'hover'   => '#fff',
            'active'  => false,
        )
    ),
    array(
        'id'=>'footer-section-end',
        'type' => 'section',
        'indent' => false // Indent all options below until the next 'section' option is set.
    ),
);

$options_typography=array(
    array(
        'id'       => 'body_font',
        'type'     => 'typography',
        'title'    => esc_html__( 'General Body Font', 'lvly'),
        'subtitle' => esc_html__( 'Site whole Text on Body area.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'color'  => false,
        'all_styles'  => false,
        'font-backup'  => true,
        'line-height'  => true,
        'letter-spacing'  => true,
        'default'  => array(
            'font-size'   => '14px',
            'font-family' => 'Roboto',
            'font-weight' => '400',
            'line-height' => '1.72',
            'letter-spacing' => '0',
            'font-backup'  => 'Arial, Helvetica, sans-serif',
        ),
    ),
    array(
        'id'       => 'blog_single_font',
        'type'     => 'typography',
        'title'    => esc_html__( 'Blog Single Body Font', 'lvly'),
        'subtitle' => esc_html__( 'Only works on Blog Single Content', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'color'  => false,
        'all_styles'  => false,
        'font-backup'  => true,
        'line-height'  => true,
        'letter-spacing'  => true,
        'default'  => array(
            'font-size'   => '15px',
            'font-family' => 'Roboto',
            'font-weight' => '400',
            'line-height' => '1.82',
            'letter-spacing' => '0',
            'font-backup'  => 'Arial, Helvetica, sans-serif',
        ),
    ),
    array(
        'id'          => 'menu_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'Main Menu Font', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => true,
        'line-height'  => false,
        'letter-spacing' => true,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => 'Yantramanav',
            'font-size'   => '11px',
            'letter-spacing'   => '0.2',
            'font-style'  => '',
            'text-transform'  => 'uppercase',
            'font-weight' => '400',
            'font-backup'  => 'Arial, Helvetica, sans-serif',
        ),
    ),
    array(
        'id'          => 'submenu_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'SubMenu font size', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-transform'  => true,
        'text-align'  => false,
        'color'  => false,
        'font-size'  => true,
        'line-height'  => false,
        'letter-spacing' => true,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => 'Yantramanav',
            'font-style'  => '',
            'font-size'  => '11px',
            'font-weight'  => '400',
            'letter-spacing'   => '0.2',
            'text-transform'  => 'uppercase',
        ),
    ),
    array(
        'id'          => 'meta_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'Post Meta Font', 'lvly'),
        'subtitle'    => esc_html__( 'Date time, comment count and share count.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'color'  => false,
        'text-transform'  => true,
        'font-size'  => true,
        'line-height'  => false,
        'letter-spacing' => true,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => 'Yantramanav',
            'font-weight' => '400',
            'font-size'  => '10px',
            'letter-spacing' => '0.2',
            'text-transform'  => 'uppercase',
        ),
    ),
    array(
        'id'          => 'heading_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'Heading Title Font', 'lvly'),
        'subtitle'    => esc_html__( 'H1-H6 and any Post Titles.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => false,
        'line-height'  => false,
        'letter-spacing' => true,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => 'Yantramanav',
            'font-style'  => '',
            'text-transform'  => 'uppercase',
            'font-weight' => '400',
            'letter-spacing' => '0.2',
        ),
    ),
    array(
        'title' => esc_html__('Heading Title Tags Size', 'lvly'),
        'id' => 'tab_typography_sub_tag_start',
        'type' => 'section',
        'indent' => true,
    ),

    array(
        'id'          => 'h1_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'H1', 'lvly'),
        'google'   => false,
        'font-family'  => false,
        'font-style'  => false,
        'font-weight'  => false,
        'text-align'  => false,
        'color'  => false,
        'font-size'  => true,
        'line-height'  => true,
        'all_styles'  => false,
        'default'  => array(
            'font-size'  => '36px',
            'line-height'  => '1.2',
        ),
    ),
    array(
        'id'          => 'h2_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'H2', 'lvly'),
        'google'   => false,
        'font-family'  => false,
        'font-style'  => false,
        'font-weight'  => false,
        'text-align'  => false,
        'color'  => false,
        'font-size'  => true,
        'line-height'  => true,
        'all_styles'  => false,
        'default'  => array(
            'font-size'  => '30px',
            'line-height'  => '1.2',
        ),
    ),
    array(
        'id'          => 'h3_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'H3', 'lvly'),
        'google'   => false,
        'font-family'  => false,
        'font-style'  => false,
        'font-weight'  => false,
        'text-align'  => false,
        'color'  => false,
        'font-size'  => true,
        'line-height'  => true,
        'all_styles'  => false,
        'default'  => array(
            'font-size'  => '24px',
            'line-height'  => '1.3',
        ),
    ),
    array(
        'id'          => 'h4_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'H4', 'lvly'),
        'google'   => false,
        'font-family'  => false,
        'font-style'  => false,
        'font-weight'  => false,
        'text-align'  => false,
        'color'  => false,
        'font-size'  => true,
        'line-height'  => true,
        'all_styles'  => false,
        'default'  => array(
            'font-size'  => '20px',
            'line-height'  => '1.3',
        ),
    ),
    array(
        'id'          => 'h5_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'H5', 'lvly'),
        'google'   => false,
        'font-family'  => false,
        'font-style'  => false,
        'font-weight'  => false,
        'text-align'  => false,
        'color'  => false,
        'font-size'  => true,
        'line-height'  => true,
        'all_styles'  => false,
        'default'  => array(
            'font-size'  => '16px',
            'line-height'  => '1.4',
        ),
    ),
    array(
        'id'          => 'h6_font',
        'type'        => 'typography',
        'title'       => esc_html__( 'H6', 'lvly'),
        'google'   => false,
        'font-family'  => false,
        'font-style'  => false,
        'font-weight'  => false,
        'text-align'  => false,
        'color'  => false,
        'font-size'  => true,
        'line-height'  => true,
        'all_styles'  => false,
        'default'  => array(
            'font-size'  => '14px',
            'line-height'  => '1.4',
        ),
    ),
    array(
        'id'          => 'extra_font_1',
        'type'        => 'typography',
        'title'       => esc_html__( 'Extra Font 1', 'lvly'),
        'subtitle'    => esc_html__( 'use any Elements.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => false,
        'line-height'  => false,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => 'Lora',
            'font-style'  => '400,italic',
            'text-transform'  => 'none',
            'font-weight' => '400',
        ),
    ),
    array(
        'id'          => 'extra_font_2',
        'type'        => 'typography',
        'title'       => esc_html__( 'Extra Font 2', 'lvly'),
        'subtitle'    => esc_html__( 'use any Elements.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => false,
        'line-height'  => false,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => 'Shadows Into Light',
            'font-style'  => '400',
            'text-transform'  => 'none',
            'font-weight' => '400'
        ),
    ),
    array(
        'id'          => 'extra_font_3',
        'type'        => 'typography',
        'title'       => esc_html__( 'Extra Font 3', 'lvly'),
        'subtitle'    => esc_html__( 'use any Elements.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => false,
        'line-height'  => false,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => '',
            'font-style'  => '',
            'text-transform'  => '',
            'font-weight' => ''
        ),
    ),
    array(
        'id'          => 'extra_font_4',
        'type'        => 'typography',
        'title'       => esc_html__( 'Extra Font 4', 'lvly'),
        'subtitle'    => esc_html__( 'use any Elements.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => false,
        'line-height'  => false,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => '',
            'font-style'  => '',
            'text-transform'  => '',
            'font-weight' => ''
        ),
    ),
    array(
        'id'          => 'extra_font_5',
        'type'        => 'typography',
        'title'       => esc_html__( 'Extra Font 5', 'lvly'),
        'subtitle'    => esc_html__( 'use any Elements.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => false,
        'line-height'  => false,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => '',
            'font-style'  => '',
            'text-transform'  => '',
            'font-weight' => ''
        ),
    ),
    array(
        'id'          => 'extra_font_6',
        'type'        => 'typography',
        'title'       => esc_html__( 'Extra Font 6', 'lvly'),
        'subtitle'    => esc_html__( 'use any Elements.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => false,
        'line-height'  => false,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => '',
            'font-style'  => '',
            'text-transform'  => '',
            'font-weight' => ''
        ),
    ),
    array(
        'id'          => 'extra_font_7',
        'type'        => 'typography',
        'title'       => esc_html__( 'Extra Font 7', 'lvly'),
        'subtitle'    => esc_html__( 'use any Elements.', 'lvly'),
        'google'   => true,
        'font-style'  => true,
        'font-weight'  => true,
        'text-align'  => false,
        'text-transform'  => true,
        'color'  => false,
        'font-size'  => false,
        'line-height'  => false,
        'all_styles'  => false,
        'default'  => array(
            'font-family' => '',
            'font-style'  => '',
            'text-transform'  => '',
            'font-weight' => ''
        ),
    ),
    array(
        'id' => 'tab_typography_sub_tag_end',
        'type' => 'section',
        'indent' => false,
    ),
);

$options_footer=array(
    array(
        'id'       => 'footer_layout',
        'type'     => 'select',
        'title'    => esc_html__( 'Footer Widget Layout', 'lvly'),
        'subtitle'    => esc_html__( 'Total Grid Column is 12 and back numbers are defined the Column Grid', 'lvly'),
        'desc'    => esc_html__( '(6-3-3) => (col-md-6, col-md-3, col-md-3)', 'lvly'),
        'options'   => $footers,
        'default'  => '',
    ),
    array(
        'id'       => 'footer_content',
        'type'     => 'select',
        'title'    => esc_html__( 'Footer Content Bloc Content', 'lvly'),
        'options'  => $content_block,
        'default'  => '',
        'required' => array(
            array('footer_layout','=','block'),
        )
    ),
    array(
        'id'       => 'footer_content2',
        'type'     => 'select',
        'title'    => esc_html__( 'Footer Content Bloc Content 2', 'lvly'),
        'options'  => $content_block,
        'default'  => '',
        'required' => array(
            array('footer_layout','=','block'),
        )
    ),
    array(
        'id'       => 'footer_width',
        'type'     => 'select',
        'title'    => esc_html__( 'Footer Width', 'lvly'),
        'options'   => array('' => '1170px', 'fullwidth' => 'Fullwidth'),
        'default'  => '',
        'required' => array(
            array( 'footer_layout', '!=', '' ),
            array( 'footer_layout', '!=','block' ),
        ),
    ),
    array(
        'id'       => 'footer_text',
        'type'     => 'textarea',
        'title'    => esc_html__('Footer Left Text', 'lvly'),
        'subtitle' => esc_html__('You can use HTML tags on this area', 'lvly'),
        'default'  => wp_kses_post(sprintf(__( '&copy; 2018 - All rights reserved Developed by <a href="%s">Themewaves.com</a>', 'lvly'), 'https://themeforest.net/user/themewaves')),
        'required' => array(
            array( 'footer_layout', '!=', '' ),
            array( 'footer_layout', '!=','block' ),
        )
    ),
    array(
        'id'       => 'footer_text2',
        'type'     => 'textarea',
        'title'    => esc_html__( 'Footer Right Text', 'lvly' ),
        'subtitle' => esc_html__( 'You can use HTML tags on this area', 'lvly' ),
        'default'  => esc_html__( 'Back to Top', 'lvly'),
        'required' => array(
            array( 'footer_layout', '!=', '' ),
            array( 'footer_layout', '!=','block' ),
        )
    ),
    array(
        'id'       => 'footer_custom_class',
        'type'     => 'multi_text',
        'title'    => esc_html__( 'Footer Area - Custom Class', 'lvly' ),
        'subtitle' => esc_html__( 'You can add custom Classes on Footer area 1-4. Just add the Classes and Add ', 'lvly' ),
        'default'  => array( '' ),
        'add_text'    => esc_html__( 'Add Class', 'lvly' ),
        'required' => array(
            array( 'footer_layout', '!=', '' ),
            array( 'footer_layout', '!=','block' ),
        ),
    ),
);

$options_api=array(
    array(
        'id'       => 'google_map_api_key',
        'type'     => 'text',
        'title'    => esc_html__( 'Google Map API Key', 'lvly'),
        'default'  => '',
        'subtitle' => wp_kses_post(sprintf(__( 'You need a <a href="%s">Google Map API Key</a> .', 'lvly'), 'https://developers.google.com/maps/documentation/javascript/get-api-key')),
    ),
    array(
        'id'       => 'typekit_api_token',
        'type'     => 'text',
        'title'    => esc_html__( 'Typekit API Token', 'lvly'),
        'default'  => '',
        'subtitle' => wp_kses_post(sprintf(__( 'You need a <a href="%s">Typekit API Token</a> to access your Typekit fonts.', 'lvly'), 'https://typekit.com/account/tokens')),
    ),
    array(
        'id'       => 'typekit_kit_ID',
        'type'     => 'text',
        'title'    => esc_html__( 'Kit ID', 'lvly'),
        'default'  => '',
    ),
    array(
        'id'       => 'typekit_kit_cache_time',
        'type'     => 'text',
        'title'    => esc_html__( 'Typekit Cache Time', 'lvly'),
        'subtitle' => esc_html__( 'by hours on admin', 'lvly'),
        'default'  => '1',
    ),
);
$options_translation=array(
    array(
        'id'       => 'more_text',
        'type'     => 'text',
        'title'    => esc_html__( 'Read more text', 'lvly'),
        'default'  => esc_html__( 'Read more', 'lvly'),
    ),
    array(
        'id'       => 'text_older',
        'type'     => 'text',
        'title'    => esc_html__( 'Older posts text on Pagination', 'lvly'),
        'default'  => esc_html__( 'Older Posts', 'lvly'),
    ),
    array(
        'id'       => 'text_newer',
        'type'     => 'text',
        'title'    => esc_html__( 'Newer posts text on Pagination', 'lvly'),
        'default'  => esc_html__( 'Newer Posts', 'lvly'),
    ),
    array(
        'id'       => 'text_loadmore',
        'type'     => 'text',
        'title'    => esc_html__( 'Load More on Infinite Pagination', 'lvly'),
        'default'  => esc_html__( 'Load More', 'lvly'),
    ),
    array(
        'id'       => 'text_search',
        'type'     => 'text',
        'title'    => esc_html__( 'Search placeholder', 'lvly'),
        'default'  => esc_html__( 'Start typing...', 'lvly'),
    ),
    array(
        'id'       => 'launch_project',
        'type'     => 'text',
        'title'    => esc_html__( 'Portfolio Single Launch Project', 'lvly'),
        'default'  => esc_html__( 'Launch Project', 'lvly'),
    ),
    array(
        'id'       => 'text_writer',
        'type'     => 'text',
        'title'    => esc_html__( 'Blog Single - Author Writer', 'lvly'),
        'default'  => esc_html__( 'Writer', 'lvly'),
    ),
    array(
        'id'       => 'portfolio-show',
        'type'     => 'text',
        'title'    => esc_html__( 'Portfolio Element Filter Text', 'lvly'),
        'default'  => esc_html__( 'Show All', 'lvly'),
    ),
    array(
        'id'       => 'gallery-show',
        'type'     => 'text',
        'title'    => esc_html__( 'Gallery Element Filter Text', 'lvly'),
        'default'  => esc_html__( 'Show All', 'lvly'),
    ),
);

Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'General', 'lvly'),
    'id'               => 'general',
    'customizer_width' => '400px',
    'icon'             => 'el el-home',
    'fields'           => $options_general
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Top Bar', 'lvly'),
    'id'         => 'top_bar',
    'icon'       => 'el el-photo el-flip-vertical',
    'fields'     => $options_topbar
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Header', 'lvly'),
    'id'         => 'header',
    'icon'       => 'el el-lines',
    'fields'     => $options_header
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Blog', 'lvly'),
    'id'         => 'blog',
    'icon'       => 'el el-pencil',
    'fields'     => $options_blog
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Page Title', 'lvly'),
    'id'         => 'page',
    'icon'       => 'el el-edit',
    'fields'     => $options_page
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Portfolio', 'lvly'),
    'id'         => 'portfolio',
    'icon'       => 'el el-qrcode',
    'fields'     => $options_portfolio
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Footer', 'lvly'),
    'id'         => 'footer',
    'icon'       => 'el el-photo',
    'fields'     => $options_footer
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Color', 'lvly'),
    'id'         => 'color',
    'icon'       => 'el el-magic',
    'fields'     => $options_color
) );

Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Typography', 'lvly'),
    'id'     => 'typography',
    'icon'   => 'el el-fontsize',
    'fields' => $options_typography
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Image Sizes', 'lvly'),
    'id'         => 'image_size',
    'icon'       => 'el el-picture',
    'fields'     => $options_image_size
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'API Keys', 'lvly'),
    'id'         => 'api',
    'icon'       => 'el el-key',
    'fields'     => $options_api
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Translation', 'lvly'),
    'id'         => 'translation',
    'icon'       => 'el el-globe',
    'fields'     => $options_translation
) );