<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Include static files: javascript and css
 */
if ( is_admin() ) {
	return;
}
/**
 * Enqueue scripts and styles for the front end.
 */
		/*---------------------------------------------------------
		** 
		** COMMENTS SCRIPTS FROM WP
		**
		----------------------------------------------------------*/
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		/*---------------------------------------------------------
		** 
		** CSS FILES NEEDED FOR WOFFICE
		**
		----------------------------------------------------------*/
		wp_enqueue_style( 'theme-fonts', woffice_fonts_url(), array(), null );
		// Font Awesome stylesheet
		wp_enqueue_style(
			'font-awesome',
			get_template_directory_uri() . '/css/font-awesome.min.css',
			array(),
			'1.0'
		);
		// Bootstrap stylesheet
		wp_enqueue_style(
			'bootstrap',
			get_template_directory_uri() . '/css/bootstrap.min.css',
			array(),
			'1.0'
		);
		// Animations stylesheet
		wp_enqueue_style(
			'animations',
			get_template_directory_uri() . '/css/animations.min.css',
			array(),
			'1.0'
		);
		// Buddypress stylesheet
		/*wp_enqueue_style(
			'buddypress',
			get_template_directory_uri() . '/css/buddypress.css',
			array(),
			'1.0'
		);*/
		// CSS from plugins stylesheet
		wp_enqueue_style(
			'plugins',
			get_template_directory_uri() . '/css/plugins.css',
			array(),
			'1.0'
		);
		// Load our main stylesheet.
		wp_enqueue_style(
			'woffice-theme-style',
			get_stylesheet_uri(),
			'1.0'
		);
		// Responsive stylesheet
		wp_enqueue_style(
			'responsive',
			get_template_directory_uri() . '/css/responsive.css',
			array(),
			'1.0'
		);
		/*---------------------------------------------------------
		** 
		** JS FILES NEEDED FOR WOFFICE
		**
		----------------------------------------------------------*/
		// LOAD JS PLUGINS FOR THE THEME
		wp_enqueue_script(
			'fw-theme-plugins',
			get_template_directory_uri() . '/js/plugins.js',
			array( 'jquery' ),
			'1.0',
			true
		);
		//NAVIGATION FIXED
		$header_fixed = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('header_fixed') : '';
		if( $header_fixed == "yep" ) :
			wp_enqueue_script(
				'fw-fixed-navigation',
				get_template_directory_uri() . '/js/fixed-nav.js',
				array( 'jquery' ),
				'1.0',
				true
			);
		endif;
		// LOAD JS FUNCTIONS FOR THE THEME
		wp_enqueue_script(
			'fw-theme-script',
			get_template_directory_uri() . '/js/scripts.js',
			array( 'jquery' ),
			'1.0',
			true
		);
