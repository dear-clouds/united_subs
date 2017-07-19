<?php

/**
 * Register BuddyBoss Menu Page
 */
if ( !function_exists( 'register_buddyboss_menu_page' ) ) {

	function register_buddyboss_menu_page() {
		// Set position with odd number to avoid confict with other plugin/theme.
		add_menu_page( 'BuddyBoss', 'BuddyBoss', 'manage_options', 'buddyboss-settings', '', get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/logo.svg', 64.99 );
		// To remove empty parent menu item.
		add_submenu_page( 'buddyboss-settings', 'BuddyBoss', 'BuddyBoss', 'manage_options', 'buddyboss-settings' );
		remove_submenu_page( 'buddyboss-settings', 'buddyboss-settings' );
	}

	add_action( 'admin_menu', 'register_buddyboss_menu_page' );
}

/**
 * Load extensions - MUST be loaded before your options are set
 */
if ( file_exists( dirname( __FILE__ ) . '/boss-extensions/extensions-init.php' ) ) {
	require_once( dirname( __FILE__ ) . '/boss-extensions/extensions-init.php' );
}

/**
 * Load redux
 */
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/admin/ReduxCore/framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/admin/ReduxCore/framework.php' );
}

/**
 * Load the theme/plugin options
 */
if ( !function_exists( 'load_boss_theme_options' ) ) {

	function load_boss_theme_options() {
		if ( file_exists( dirname( __FILE__ ) . '/options-init.php' ) ) {
			require_once( dirname( __FILE__ ) . '/options-init.php' );
		}
		if ( file_exists( dirname( __FILE__ ) . '/plugin-support.php' ) ) {
			require_once( dirname( __FILE__ ) . '/plugin-support.php' );
		}
		if ( file_exists( dirname( __FILE__ ) . '/help-support.php' ) ) {
			require_once( dirname( __FILE__ ) . '/help-support.php' );
		}
	}

	// This is used to show xProfile fields in option settings.
	if ( function_exists( 'bp_is_active' ) ) {
		add_action( 'bp_init', 'load_boss_theme_options' );
	} else {
		load_boss_theme_options();
	}
}

/**
 * Remove redux menu under the tools
 */
if ( !function_exists( 'boss_remove_redux_menu' ) ) {

	function boss_remove_redux_menu() {
		remove_submenu_page( 'tools.php', 'redux-about' );
	}

	add_action( 'admin_menu', 'boss_remove_redux_menu', 12 );
}

/**
 * Remove redux demo links
 */
if ( !function_exists( 'boss_remove_DemoModeLink' ) ) {

	function boss_remove_DemoModeLink() {
		// Be sure to rename this function to something more unique
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks' ), null, 2 );
		}

		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
		}
	}

	add_action( 'init', 'boss_remove_DemoModeLink' );
}

/**
 * Remove redux dashboard widget
 */
if ( !function_exists( 'boss_remove_dashboard_widget' ) ) {

	function boss_remove_dashboard_widget() {
		remove_meta_box( 'redux_dashboard_widget', 'dashboard', 'side' );
	}

	// Hook into the 'wp_dashboard_setup' action to register our function
	add_action( 'wp_dashboard_setup', 'boss_remove_dashboard_widget', 999 );
}

/**
 * Custom panel styles
 */
if ( !function_exists( 'boss_custom_panel_styles_scripts' ) ) {

	function boss_custom_panel_styles_scripts() {

		$buddyboss_redux_js_vars = array(
			'color_scheme' => boss_get_option( 'boss_scheme_select' ),
			'boss_header' => boss_get_option( 'boss_header' )
		);

		/**
		 * Assign the Boss version to a var
		 */
		$theme 		    = wp_get_theme( 'boss' );
		$boss_version   = $theme['Version'];

		wp_register_style( 'redux-custom-panel', get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/css/redux-custom-panel.css', array( 'redux-admin-css' ), $boss_version, 'all' );
		wp_enqueue_style( 'redux-custom-panel' );

		wp_register_script( 'redux-custom-script', get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/js/boss-custom-admin.js', array(), $boss_version );
		wp_enqueue_script( 'redux-custom-script' );

		$buddyboss_redux_js_vars = apply_filters( 'buddyboss_redux_js_vars', $buddyboss_redux_js_vars );
		wp_localize_script( 'redux-custom-script', 'BuddyBossReduxOptions', $buddyboss_redux_js_vars );
	}

	// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
	add_action( 'redux/page/boss_options/enqueue', 'boss_custom_panel_styles_scripts' );
}

/**
 * Hide Redux Notifications and Ads
 */
if ( !function_exists( 'boss_remove_redux_ads' ) ) {

	function boss_remove_redux_ads() {
		echo '<style type="text/css">
		   #wpbody-content .redux-messageredux-notice,
			#redux-header .rAds,
			#boss_options-boss_favicon,
			#boss_options-admin_custom_colors {
				display: none !important;
				opacity: 0;
				visibility: hidden;
			}
		 </style>';
	}

	add_action( 'admin_head', 'boss_remove_redux_ads' );
}

/**
 * Import social learner color scheme in new format.
 * @since 2.0.0
 */
if ( function_exists( 'boss_edu_add_color_scheme' ) ) { //ensures that social-learner is active 
    add_filter( 'buddyboss_customizer_themes_preset', 'maybe_restructure_boss_edu_add_color_scheme', 9 );
    function maybe_restructure_boss_edu_add_color_scheme( $theme_presets ){
        //get social learner version
        $social_learner = wp_get_theme();//should load current active child theme ( social learner )
        if( $social_learner->get( 'Version' ) >= '1.0.3' ){
            //social learner version 1.0.3 onwards has the new format already, so no changes here
            return $theme_presets;
        } else { 
            //need to import into new format
            //1. remove the orginal function
            remove_filter( 'buddyboss_customizer_themes_preset', 'boss_edu_add_color_scheme' );

            //2. get ouptput of original function
            $social_learner_presets = boss_edu_add_color_scheme( array() );

            //3. restructure that output and add it to theme_presets
            if ( !empty( $social_learner_presets ) && is_array( $social_learner_presets ) ) {
                foreach( $social_learner_presets as $social_learner_preset ){
                    $theme_presets['education'] = array();
                    $theme_presets['education']['alt'] = isset( $social_learner_preset['name'] ) ? $social_learner_preset['name'] : '';
                    $theme_presets['education']['img'] = get_template_directory_uri() . '/buddyboss-inc/buddyboss-framework/assets/images/presets/social_learner.png';
                    $theme_presets['education']['presets'] = isset( $social_learner_preset['rules'] ) ? $social_learner_preset['rules'] : array();
                }
            }

            return $theme_presets;
        }
    }
}

/**
 * Ensures that social-learner is active
 */
if ( function_exists( 'boss_edu_remove_redux_field' ) ) {

	/**
	 * Remove header redux option
	 * @param $sections
	 * @return mixed
	 */
	function boss_edu_remove_header_redux_field( $sections ) {
		unset( $sections[ 1 ]);
		return $sections;
	}

	// In this example OPT_NAME is the returned opt_name.
	add_filter( "redux/options/boss_options/sections", 'boss_edu_remove_header_redux_field' );

	/**
	 * Set header style to 1
	 */
	function boss_edu_set_default_header() {
		global $reduxConfig;

		if( '2' == boss_get_option( 'boss_header' ) ) {
			$reduxConfig->ReduxFramework->set(  'boss_header', '1' );
		}
	}

	add_action( 'init', 'boss_edu_set_default_header' );
}