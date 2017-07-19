<?php
/**
 * Front core class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class
class GW_GoPricing_Front {	

	protected static $instance = null;
	protected $globals;

	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected $plugin_file;
	protected $plugin_base;
	protected $plugin_dir;
	protected $plugin_path;
	protected $plugin_url;


	/**
	 * Initialize the class
	 *
	 * @return void
	 */		  
	 
	public function __construct() {
		
		$this->globals = GW_GoPricing::instance();
		self::$plugin_version = $this->globals['plugin_version'];
		self::$db_version = $this->globals['db_version'];		
		self::$plugin_prefix = $this->globals['plugin_prefix'];
		self::$plugin_slug = $this->globals['plugin_slug'];
		$this->plugin_url = $this->globals['plugin_url'];
		$this->plugin_path = $this->globals['plugin_path'];

		// Enqueue frontend styles
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
		
		// Enqueue frontend scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_public_scripts' ) );
		
		// Live preview
		add_action( 'init', array( $this, 'live_preview_safe' ) );
		
	}


	/**
	 * Return an instance of this class
	 *
	 * @return object
	 */
	 
	public static function instance() {
		
		if ( self::$instance == null ) self::$instance = new self;
		return self::$instance;
		
	}
	
	
	/**
	 * Enqueue public styles
	 *
	 * @return void
	 */
	 
	 
	public function enqueue_public_styles() {
		
		$general_settings = get_option( self::$plugin_prefix . '_table_settings' );			
				
		if ( !empty( $general_settings['plugin-pages'] ) && !isset( $_GET['go_pricing_preview_id'] ) ) {
			$pages =  trim( preg_replace( '/([^0-9][^,]{0})+/', ',', $general_settings['plugin-pages'] ), ',' );
			$pages = explode( ',', $pages );
			global $post;
			if ( !empty( $post ) && !in_array( $post->ID, $pages ) ) return;
		}		
		
		wp_enqueue_style( self::$plugin_slug . '-styles', $this->plugin_url . 'assets/css/go_pricing_styles.css', false, self::$plugin_version );	
		if ( !empty( $general_settings['custom-css'] ) ) wp_add_inline_style( self::$plugin_slug . '-styles', $general_settings['custom-css'] );
		
	}
	
	
	/**
	 * Register public scripts
	 *
	 * @return void
	 */	
	
	public function register_public_scripts() {
		
		$general_settings = get_option( self::$plugin_prefix . '_table_settings' );			
				
		if ( !empty( $general_settings['plugin-pages'] ) && !isset( $_GET['go_pricing_preview_id'] ) ) {
			$pages =  trim( preg_replace( '/([^0-9][^,]{0})+/', ',', $general_settings['plugin-pages'] ), ',' );
			$pages = explode( ',', $pages );
			global $post;
			if ( !empty( $post ) && !in_array( $post->ID, $pages ) ) return;

		}
		
		$in_footer = empty( $general_settings['js-in-header'] );

		wp_register_script( 'gw-tweenmax', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.11.2/TweenMax.min.js', array(), self::$plugin_version, false );
		wp_enqueue_script( 'gw-tweenmax' );
				
		wp_register_script( self::$plugin_slug . '-scripts', $this->plugin_url . 'assets/js/go_pricing_scripts.js', array( 'jquery' ), self::$plugin_version, $in_footer );
		wp_enqueue_script( self::$plugin_slug . '-scripts' );
				
		wp_register_script( self::$plugin_slug . '-map', 'http://maps.google.com/maps/api/js?sensor=false', array(), self::$plugin_version, false );
		wp_register_script( self::$plugin_slug . '-gomap', $this->plugin_url . 'assets/lib/js/jquery.gomap-1.3.2.min.js', array( 'jquery', self::$plugin_slug . '-map' ), self::$plugin_version, false );
		
		global $wp_version;
		if ( version_compare( $wp_version, 3.6, '<' ) ) wp_register_script( self::$plugin_slug . '-mediaelementjs', $this->plugin_url . 'assets/plugins/js/mediaelementjs/mediaelement-and-player.min.js', array( 'jquery' ), self::$plugin_version, $in_footer );

	}
	
	
	/**
	 * Safe mode for live preview
	 *
	 * @return void
	 */
	 
	public function live_preview_safe() {
		
		if ( !isset( $_GET['go_pricing_preview_id'] ) ) return;	
		$general_settings = get_option( self::$plugin_prefix . '_table_settings' );
		if ( !isset( $general_settings['safe-preview'] ) ) return;		
		
		$_GET['id'] = $_GET['go_pricing_preview_id'] ;
		include_once ( $this->plugin_path . 'includes/preview.php' );
		exit;
		
	}	

}

 

?>