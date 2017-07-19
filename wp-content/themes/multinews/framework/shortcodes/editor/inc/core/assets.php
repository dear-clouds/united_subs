<?php

/**
 * Class for managing plugin assets
 */
class mom_su_Assets {

	/**
	 * Set of queried assets
	 *
	 * @var array
	 */
	static $assets = array( 'css' => array(), 'js' => array() );

	/**
	 * Constructor
	 */
	function __construct() {
		// Register
		add_action( 'wp_head',                     array( __CLASS__, 'register' ) );
		add_action( 'admin_head',                  array( __CLASS__, 'register' ) );
		add_action( 'mom_su/generator/preview/before', array( __CLASS__, 'register' ) );
		add_action( 'mom_su/examples/preview/before',  array( __CLASS__, 'register' ) );
		// Enqueue
		add_action( 'wp_footer',                   array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_footer',                array( __CLASS__, 'enqueue' ) );
		// Print
		add_action( 'mom_su/generator/preview/after',  array( __CLASS__, 'prnt' ) );
		add_action( 'mom_su/examples/preview/after',   array( __CLASS__, 'prnt' ) );
		// Custom CSS
		add_action( 'wp_footer',                   array( __CLASS__, 'custom_css' ), 99 );
		add_action( 'mom_su/generator/preview/after',  array( __CLASS__, 'custom_css' ), 99 );
		add_action( 'mom_su/examples/preview/after',   array( __CLASS__, 'custom_css' ), 99 );
		// Custom TinyMCE CSS and JS
		// add_filter( 'mce_css',                     array( __CLASS__, 'mce_css' ) );
		// add_filter( 'mce_external_plugins',        array( __CLASS__, 'mce_js' ) );
	}

	/**
	 * Register assets
	 */
	public static function register() {
		// Chart.js
		wp_register_script( 'chartjs', MOM_URI . '/framework/shortcodes/editor/assets/js/chart.js', false, '0.2', true );
		// SimpleSlider
		wp_register_script( 'simpleslider', MOM_URI . '/framework/shortcodes/editor/assets/js/simpleslider.js', array( 'jquery' ), '1.0.0', true );
		wp_register_style( 'simpleslider', MOM_URI . '/framework/shortcodes/editor/assets/css/simpleslider.css', false, '1.0.0', 'all' );
		// Owl Carousel
		wp_register_script( 'owl-carousel', MOM_URI . '/framework/shortcodes/editor/assets/js/owl-carousel.js', array( 'jquery' ), '1.3.2', true );
		wp_register_style( 'owl-carousel', MOM_URI . '/framework/shortcodes/editor/assets/css/owl-carousel.css', false, '1.3.2', 'all' );
		wp_register_style( 'owl-carousel-transitions', MOM_URI . '/framework/shortcodes/editor/assets/css/owl-carousel-transitions.css', false, '1.3.2', 'all' );
		// Font Awesome
		wp_register_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', false, '4.2.0', 'all' );
		// Animate.css
		wp_register_style( 'animate', MOM_URI . '/framework/shortcodes/editor/assets/css/animate.css', false, '3.1.1', 'all' );
		// InView
		wp_register_script( 'inview', MOM_URI . '/framework/shortcodes/editor/assets/js/inview.js', array( 'jquery' ), '2.1.1', true );
		// qTip
		wp_register_style( 'qtip', MOM_URI . '/framework/shortcodes/editor/assets/css/qtip.css', false, '2.1.1', 'all' );
		wp_register_script( 'qtip', MOM_URI . '/framework/shortcodes/editor/assets/js/qtip.js', array( 'jquery' ), '2.1.1', true );
		// jsRender
		wp_register_script( 'jsrender', MOM_URI . '/framework/shortcodes/editor/assets/js/jsrender.js', array( 'jquery' ), '1.0.0-beta', true );
		// Magnific Popup
		wp_register_style( 'magnific-popup', MOM_URI . '/framework/shortcodes/editor/assets/css/magnific-popup.css', false, '0.9.9', 'all' );
		wp_register_script( 'magnific-popup', MOM_URI . '/framework/shortcodes/editor/assets/js/magnific-popup.js', array( 'jquery' ), '0.9.9', true );
		wp_localize_script( 'magnific-popup', 'mom_su_magnific_popup', array(
				'close'   => __( 'Close (Esc)', 'theme' ),
				'loading' => __( 'Loading...', 'theme' ),
				'prev'    => __( 'Previous (Left arrow key)', 'theme' ),
				'next'    => __( 'Next (Right arrow key)', 'theme' ),
				'counter' => sprintf( __( '%s of %s', 'theme' ), '%curr%', '%total%' ),
				'error'   => sprintf( __( 'Failed to load this link. %sOpen link%s.', 'theme' ), '<a href="%url%" target="_blank"><u>', '</u></a>' )
			) );
		// Ace
		wp_register_script( 'ace', MOM_URI . '/framework/shortcodes/editor/assets/js/ace/ace.js', false, '1.1.3', true );
		// Swiper
		wp_register_script( 'swiper', MOM_URI . '/framework/shortcodes/editor/assets/js/swiper.js', array( 'jquery' ), '2.6.1', true );
		// jPlayer
		wp_register_script( 'jplayer', MOM_URI . '/framework/shortcodes/editor/assets/js/jplayer.js', array( 'jquery' ), '2.4.0', true );
		// Options page
		wp_register_style( 'mom-su-options-page', MOM_URI . '/framework/shortcodes/editor/assets/css/options-page.css', false, mom_su_PLUGIN_VERSION, 'all' );
		wp_register_script( 'mom-su-options-page', MOM_URI . '/framework/shortcodes/editor/assets/js/options-page.js', array( 'magnific-popup', 'jquery-ui-sortable', 'ace', 'jsrender' ), mom_su_PLUGIN_VERSION, true );
		wp_localize_script( 'mom-su-options-page', 'mom_su_options_page', array(
				'upload_title'  => __( 'Choose files', 'theme' ),
				'upload_insert' => __( 'Add selected files', 'theme' ),
				'not_clickable' => __( 'This button is not clickable', 'theme' )
			) );
		// Cheatsheet
		wp_register_style( 'mom-su-cheatsheet', MOM_URI . '/framework/shortcodes/editor/assets/css/cheatsheet.css', false, mom_su_PLUGIN_VERSION, 'all' );
		// Generator
		wp_register_style( 'mom-su-generator', MOM_URI . '/framework/shortcodes/editor/assets/css/generator.css', array( 'farbtastic', 'magnific-popup' ), mom_su_PLUGIN_VERSION, 'all' );
		wp_register_script( 'mom-su-generator', MOM_URI . '/framework/shortcodes/editor/assets/js/generator.js', array( 'farbtastic', 'magnific-popup', 'qtip' ), mom_su_PLUGIN_VERSION, true );
		wp_localize_script( 'mom-su-generator', 'mom_su_generator', array(
				'upload_title'         => __( 'Choose file', 'theme' ),
				'upload_insert'        => __( 'Insert', 'theme' ),
				'isp_media_title'      => __( 'Select images', 'theme' ),
				'isp_media_insert'     => __( 'Add selected images', 'theme' ),
				'presets_prompt_msg'   => __( 'Please enter a name for new preset', 'theme' ),
				'presets_prompt_value' => __( 'New preset', 'theme' ),
				'last_used'            => __( 'Last used settings', 'theme' )
			) );
		// Shortcodes stylesheets
		wp_register_style( 'mom-su-content-shortcodes', self::skin_url( 'content-shortcodes.css' ), false, mom_su_PLUGIN_VERSION, 'all' );
		wp_register_style( 'mom-su-box-shortcodes', self::skin_url( 'box-shortcodes.css' ), false, mom_su_PLUGIN_VERSION, 'all' );
		wp_register_style( 'mom-su-media-shortcodes', self::skin_url( 'media-shortcodes.css' ), false, mom_su_PLUGIN_VERSION, 'all' );
		wp_register_style( 'mom-su-other-shortcodes', self::skin_url( 'other-shortcodes.css' ), false, mom_su_PLUGIN_VERSION, 'all' );
		wp_register_style( 'mom-su-galleries-shortcodes', self::skin_url( 'galleries-shortcodes.css' ), false, mom_su_PLUGIN_VERSION, 'all' );
		wp_register_style( 'mom-su-players-shortcodes', self::skin_url( 'players-shortcodes.css' ), false, mom_su_PLUGIN_VERSION, 'all' );
		// Shortcodes scripts
		wp_register_script( 'mom-su-galleries-shortcodes', MOM_URI . '/framework/shortcodes/editor/assets/js/galleries-shortcodes.js', array( 'jquery', 'swiper' ), mom_su_PLUGIN_VERSION, true );
		wp_register_script( 'mom-su-players-shortcodes', MOM_URI . '/framework/shortcodes/editor/assets/js/players-shortcodes.js', array( 'jquery', 'jplayer' ), mom_su_PLUGIN_VERSION, true );
		wp_register_script( 'mom-su-other-shortcodes', MOM_URI . '/framework/shortcodes/editor/assets/js/other-shortcodes.js', array( 'jquery' ), mom_su_PLUGIN_VERSION, true );
		wp_localize_script( 'mom-su-other-shortcodes', 'mom_su_other_shortcodes', array( 'no_preview' => __( 'This shortcode doesn\'t work in live preview. Please insert it into editor and preview on the site.', 'theme' ) ) );
		// Hook to deregister assets or add custom
		do_action( 'mom_su/assets/register' );
	}

	/**
	 * Enqueue assets
	 */
	public static function enqueue() {
		// Get assets query and plugin object
		$assets = self::assets();
		// Enqueue stylesheets
		foreach ( $assets['css'] as $style ) wp_enqueue_style( $style );
		// Enqueue scripts
		foreach ( $assets['js'] as $script ) wp_enqueue_script( $script );
		// Hook to dequeue assets or add custom
		do_action( 'mom_su/assets/enqueue', $assets );
	}

	/**
	 * Print assets without enqueuing
	 */
	public static function prnt() {
		// Prepare assets set
		$assets = self::assets();
		// Enqueue stylesheets
		wp_print_styles( $assets['css'] );
		// Enqueue scripts
		wp_print_scripts( $assets['js'] );
		// Hook
		do_action( 'mom_su/assets/print', $assets );
	}

	/**
	 * Print custom CSS
	 */
	public static function custom_css() {
		// Get custom CSS and apply filters to it
		$custom_css = apply_filters( 'mom_su/assets/custom_css', str_replace( '&#039;', '\'', html_entity_decode( (string) get_option( 'mom_su_option_custom-css' ) ) ) );
		// Print CSS if exists
		if ( $custom_css ) echo "\n\n<!-- Shortcodes Ultimate custom CSS - begin -->\n<style type='text/css'>\n" . stripslashes( str_replace( array( '%theme_url%', '%home_url%', '%plugin_url%' ), array( trailingslashit( get_stylesheet_directory_uri() ), trailingslashit( get_option( 'home' ) ), trailingslashit( MOM_URI . '' ) ), $custom_css ) ) . "\n</style>\n<!-- Shortcodes Ultimate custom CSS - end -->\n\n";
	}

	/**
	 * Styles for visualised shortcodes
	 */
	public static function mce_css( $mce_css ) {
		if ( ! empty( $mce_css ) ) $mce_css .= ',';
		$mce_css .= MOM_URI . '/framework/shortcodes/editor/assets/css/tinymce.css';
		return $mce_css;
	}

	/**
	 * TinyMCE plugin for visualised shortcodes
	 */
	public static function mce_js( $plugins ) {
		$plugins['shortcodesultimate'] = MOM_URI . '/framework/shortcodes/editor/assets/js/tinymce.js';
		return $plugins;
	}

	/**
	 * Add asset to the query
	 */
	public static function add( $type, $handle ) {
		// Array with handles
		if ( is_array( $handle ) ) { foreach ( $handle as $h ) self::$assets[$type][$h] = $h; }
		// Single handle
		else self::$assets[$type][$handle] = $handle;
	}
	/**
	 * Get queried assets
	 */
	public static function assets() {
		// Get assets query
		$assets = self::$assets;
		// Apply filters to assets set
		$assets['css'] = array_unique( ( array ) apply_filters( 'mom_su/assets/css', ( array ) array_unique( $assets['css'] ) ) );
		$assets['js'] = array_unique( ( array ) apply_filters( 'mom_su/assets/js', ( array ) array_unique( $assets['js'] ) ) );
		// Return set
		return $assets;
	}

	/**
	 * Helper to get full URL of a skin file
	 */
	public static function skin_url( $file = '' ) {
		$shult = mom_shortcodes_ultimate();
		$skin = get_option( 'mom_su_option_skin' );
		$uploads = wp_upload_dir(); $uploads = $uploads['baseurl'];
		// Prepare url to skin directory
		$url = ( !$skin || $skin === 'default' ) ? MOM_URI . '/framework/shortcodes/editor/assets/css/' : $uploads . '/mom-shortcodes-ultimate-skins/' . $skin;
		return trailingslashit( apply_filters( 'mom_su/assets/skin', $url ) ) . $file;
	}
}

new mom_su_Assets;

/**
 * Helper function to add asset to the query
 *
 * @param string  $type   Asset type (css|js)
 * @param mixed   $handle Asset handle or array with handles
 */
function mom_su_query_asset( $type, $handle ) {
	mom_su_Assets::add( $type, $handle );
}

/**
 * Helper function to get current skin url
 *
 * @param string  $file Asset file name. Example value: box-shortcodes.css
 */
function mom_su_skin_url( $file ) {
	return mom_su_Assets::skin_url( $file );
}
