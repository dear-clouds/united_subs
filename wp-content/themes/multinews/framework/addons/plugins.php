<?php
//require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'mom_theme_register_required_plugins' );
function mom_theme_register_required_plugins() {
$logos = MOM_ADDON_URI . '/assets/images/';
	$plugins = array(


		// This is an example of how to include a plugin from the WordPress Plugin Repository

		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'required' 	=> false,
			'logo'				=> 'http://ps.w.org/contact-form-7/assets/icon-256x256.png',
			'author'			=> 'Takayuki Miyoshi',
			'desc'				=> 'Just another contact form plugin. Simple but flexible.',
			'type'				=> 'plugin',
		),		

		array(
			'name' 		=> 'mobble',
			'slug' 		=> 'mobble',
			'required' 	=> false,
			'logo'				=> 'http://ps.w.org/mobble/assets/icon-256x256.png',
			'author'			=> 'Scott Evans',
			'desc'				=> 'Helper plugin that provides conditional functions for detecting a variety of mobile devices & tablets.',
			'type'				=> 'plugin',
		),		

		array(
			'name'     				=> 'GeoDirectory - Multinews Theme Compatibility',
			'slug'     				=> 'geodirectory-multinews', 
			'source'   				=> get_template_directory() . '/framework/plugins/geodirectory-multinews.zip',
			'required' 				=> false, 
			'version' 				=> '1.0.0', 
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false,
			'external_url' 			=> '', 
			'logo'				=> 'http://ps.w.org/geodirectory/assets/icon-256x256.jpg',
			'author'			=> 'wpbakery',
			'desc'				=> 'Make theme compatible with Geodirectory plugin',
			'type'				=> 'addon',
		),

		array(
			'name'     				=> 'Visual Composer',
			'slug'     				=> 'js_composer', 
			'source'   				=> get_template_directory() . '/framework/plugins/js_composer.zip',
			'required' 				=> true, 
			'version' 				=> '4.10', 
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false,
			'external_url' 			=> '', 
			'logo'				=> $logos.'vc.png',
			'author'			=> 'wpbakery',
			'desc'				=> 'Visual Composer for WordPress is drag and drop frontend and backend page builder plugin that will save your time',
			'type'				=> 'addon',
		),
		array(
			'name'     				=> ' Slider Revolution',
			'slug'     				=> 'revslider', 
			'source'   				=> get_template_directory() . '/framework/plugins/revslider.zip',
			'required' 				=> false, 
			'version' 				=> '5.1.6', 
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false,
			'external_url' 			=> '', 
			'logo'				=> $logos.'rev-slider.png',
			'author'			=> 'themepunch',
			'desc'				=> 'Slider Revolution is an all-purpose slide displaying solution that allows for showing almost any kind of content',
			'type'				=> 'addon',
		),

		array(
			'name'     				=> 'Layer Slider',
			'slug'     				=> 'LayerSlider', 
			'source'   				=> get_template_directory() . '/framework/plugins/layersliderwp.zip',
			'required' 				=> false, 
			'version' 				=> '5.6.2', 
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false,
			'external_url' 			=> '', 
			'logo'				=> $logos . 'layer-slider.png',
			'author'			=> 'kreatura',
			'desc'				=> 'a premium multi-purpose slider for creating image galleries, content sliders, and mind-blowing slideshows',
			'type'				=> 'addon',
		),
	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'theme';

	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following addons needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following addons need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                'update_link'                    => _n_noop( 'Begin updating addon', 'Begin updating addons', 'tgmpa' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}