<?php

/*
Plugin Name: K Elements
Plugin URL: http://seventhqueen.com/
Description: WordPress elements using easy to add shortcodes
Version: 4.0.7
Author: SeventhQueen
Author URI: http://seventhqueen.com/
Domain Path: /languages
Text Domain: k-elements
*/

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Define Constants
//	 02. Load textdomain
//   03. Require Files
//   04. Enqueue Assets
// =============================================================================


// Define Constants
// =============================================================================

if ( ! defined( 'K_ELEM_VERSION' ) ) {
	define( 'K_ELEM_VERSION', '4.0.7' );
}

// Plugin Folder Path
if ( ! defined( 'K_ELEM_PLUGIN_DIR' ) ) {
	define( 'K_ELEM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL
if ( ! defined( 'K_ELEM_PLUGIN_URL' ) ) {
	define( 'K_ELEM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}			

// Plugin Root File
if ( ! defined( 'K_ELEM_PLUGIN_FILE' ) ) {
	define( 'K_ELEM_PLUGIN_FILE', __FILE__ );
}


// Load textdomain
// =============================================================================

add_action( 'plugins_loaded', 'k_elements_load_textdomain' );
function k_elements_load_textdomain() {
	load_plugin_textdomain( 'k-elements', false, dirname(plugin_basename(__FILE__)) . "/languages/" );
}



// Require Files
// =============================================================================

function k_elements_init_helpers() {
	if ( ! class_exists( 'Kleo' ) ) {
		require_once( trailingslashit( K_ELEM_PLUGIN_DIR ) . 'functions/helpers.php' );
	}
}
add_action( 'init', 'k_elements_init_helpers' );


function k_elements_init() {
    require_once( trailingslashit(K_ELEM_PLUGIN_DIR) . 'functions/functions.php' );
    require_once( trailingslashit(K_ELEM_PLUGIN_DIR) . 'admin/tiny_mce.php' );
    require_once( trailingslashit(K_ELEM_PLUGIN_DIR) . 'shortcodes/shortcodes.php' );
}
add_action( 'init', 'k_elements_init', 8 );


if(function_exists('vc_set_as_theme')) {
	require_once( trailingslashit(K_ELEM_PLUGIN_DIR) . 'compat/plugin-js-composer/config.php' );	//compatibility with Visual composer plugin
}



// Enqueue Site Scripts
// =============================================================================

function k_elements_enqueue_site_scripts() {

    // don't load plugin files if using a Kleo theme
    if ( class_exists( 'Kleo' ) ) {
        return;
    }

  if ( ! is_admin() ) {

		/* Footer scripts */
		wp_register_script( 'bootstrap', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/bootstrap.min.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'waypoints', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/waypoints.min.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'caroufredsel', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/carouFredSel/jquery.carouFredSel-6.2.0-packed.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'jquery-mousewheel', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/carouFredSel/helper-plugins/jquery.mousewheel.min.js', array('jquery', 'caroufredsel'),K_ELEM_VERSION, true );
		wp_register_script( 'jquery-touchswipe', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/carouFredSel/helper-plugins/jquery.touchSwipe.min.js', array('jquery', 'caroufredsel'),K_ELEM_VERSION, true );
		wp_register_script( 'isotope', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/jquery.isotope.min.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'kleo-shortcodes', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/shortcodes.min.js', array('jquery'),K_ELEM_VERSION, true );
		wp_register_script( 'particles-js', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/js/plugins/particles.min.js', array('jquery'),K_ELEM_VERSION, true );

		//enqueue them
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('waypoints');
		wp_enqueue_script('caroufredsel');
		wp_enqueue_script('jquery-touchswipe');
		wp_enqueue_script('isotope');
		wp_enqueue_script('kleo-shortcodes');
  }

}

add_action( 'wp_enqueue_scripts', 'k_elements_enqueue_site_scripts' );



// Enqueue Site Styles
// =============================================================================

function k_elements_enqueue_site_styles() {

    // don't load the files if using a Kleo theme
    if ( class_exists('Kleo') ) {
        return;
    }

    if ( ! is_admin() ) {

		// Register the styles
		wp_register_style( 'bootstrap', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/css/bootstrap.min.css', array(), K_ELEM_VERSION, 'all' );  
		wp_register_style( 'kleo-shortcodes', trailingslashit(K_ELEM_PLUGIN_URL) . 'assets/css/shortcodes.min.css', array(), K_ELEM_VERSION, 'all' );

		//enqueue required styles
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'kleo-shortcodes' );   

    }
}

add_action( 'wp_enqueue_scripts', 'k_elements_enqueue_site_styles' );