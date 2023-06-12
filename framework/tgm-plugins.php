<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package   TGM-Plugin-Activation
 * @version   2.6.1
 * @link      http://tgmpluginactivation.com/
 * @author    Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright Copyright (c) 2011, Thomas Griffin
 * @license   GPL-2.0+
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once LVLY_THEME_PATH . 'framework/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'lvly_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function lvly_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
            array(
                'name' => esc_html__('Redux Framework', 'lvly'),
                'slug' => 'redux-framework',
                'required' => true,
            ),
            array(
                'name' => esc_html__('Lovely Corporate Core', 'lvly'),
                'slug' => 'lvly-core',
                'source' => LVLY_FW_PATH . 'plugins/lvly-core.zip',
                'required' => true,
                'force_deactivation'=> true,
                'version' => '1.0.3',
                'external_url' => '',
            ),
            array(
                'name'          => 'WPBakery Visual Composer', 'lvly',
                'slug'          => 'js_composer',
                'source'            => LVLY_FW_PATH . 'plugins/js_composer.zip',
                'required'          => true,
                'version'           => '5.6',
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'      => '',
            ),
            array(
                'name'          => 'Revolution Slider', 'lvly',
                'slug'          => 'revslider',
                'source'            => LVLY_FW_PATH . 'plugins/revslider.zip',
                'required'          => true,
                'version'           => '5.4.8.1',
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'      => '',
            ),
            array(
                'name'          => 'Envato Market', 'lvly',
                'slug'          => 'envato-market',
                'source'            => LVLY_FW_PATH . 'plugins/envato-market.zip',
                'required'          => true,
                'version'           => '2.0.1',
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'      => '',
            ),
            array(
                'name' => esc_html__('One Click Demo Import', 'lvly'),
                'slug' => 'one-click-demo-import',
                'required' => false,
            ),
            array(
                'name' => esc_html__('TablePress', 'lvly'),
                'slug' => 'tablepress',
                'required' => false,
            ),
            array(
                'name' => esc_html__('Breadcrumb NavXT', 'lvly'),
                'slug' => 'breadcrumb-navxt',
                'required' => false,
            ),
            array(
                'name' => esc_html__('Woocommerce', 'lvly'),
                'slug' => 'woocommerce',
                'required' => false,
            ),
            array(
                'name' => esc_html__('Contact Form 7', 'lvly'),
                'slug' => 'contact-form-7',
                'required' => false,
            ),
        );

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}