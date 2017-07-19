<?php
/**
 * Core class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;

// Class
class GW_GoPricing {
	
	protected static $instance = null;
	protected $globals;
	
	protected static $plugin_version = '3.3.1';
	protected static $db_version = '2.0.0';
	protected static $plugin_prefix = 'go_pricing';
	protected static $plugin_slug = 'go-pricing';
	protected $plugin_file;
	protected $plugin_base;
	protected $plugin_dir;
	protected $plugin_path;
	protected $plugin_url;
	
	
	/**
	 * Constructor of the class
	 *
	 * @return void
	 */		  
	 
	public function __construct() {
					
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
				
		// Register globals
		add_action( 'init',  array( $this, 'register_globals' ) );	
		
		// Trigger plugin init
		add_action( 'init',  array( $this, 'plugin_init' ) );		
		
	}

	
	/**
	 * Return an instance of this class
	 *
	 * @return array
	 */
	 
	 public static function instance( $plugin_file = __FILE__ ) {
		
		static $globals;
		
		if ( self::$instance == null ) {
			self::$instance = new self;
			$globals = self::$instance->set_globals( $plugin_file );
			self::$instance->load_includes();

		}

		return $globals;
		
	}	
	
	 
	/**
	 * Fired when the plugin is activated 
	 *
	 * @return void
	 */			 
	 
	public static function activate( $network_wide ) {
	
	}
	

	/**
	 * Fired when the plugin is deactivated 
	 *
	 * @return void
	 */		 
	 
	public static function deactivate() {

	}	


	/**
	 * Fired when the plugin is uninstalled
	 *
	 * @return void
	 */			 
	 
	public static function uninstall( $network_wide ) {

		// Delete db data & cookies
		delete_option( self::$plugin_prefix . '_general_settings' );
		delete_option( self::$plugin_prefix . '_version' );
		delete_option( self::$plugin_prefix . '_notices' );
		
		if ( isset( $_COOKIE['go_pricing'] ) ) unset( $_COOKIE['go_pricing'] );

	}


	/**
	 * Set global variables
	 *
	 * @return array
	 */			 
	 
	public function set_globals( $plugin_file ) {
		
		$this->plugin_file = $plugin_file;
		$this->plugin_base = plugin_basename( $this->plugin_file );
		$this->plugin_dir = dirname( plugin_basename( $this->plugin_file ) );
		$this->plugin_path = plugin_dir_path( $this->plugin_file );
		$this->plugin_url =	plugin_dir_url( $this->plugin_file );

		$globals = array (
			'plugin_version' => self::$plugin_version,
			'db_version' => self::$db_version,
			'plugin_prefix' => self::$plugin_prefix,
			'plugin_slug' => self::$plugin_slug,
			'plugin_file' => $this->plugin_file,
			'plugin_base' => $this->plugin_base,
			'plugin_dir' => $this->plugin_dir,
			'plugin_path' => $this->plugin_path,
			'plugin_url' => $this->plugin_url,
		);
		
		$this->globals = $globals;
		return $globals;
	
	}
	 
	
	/**
	 * Load required includes
	 *
	 * @return void
	 */		
	
	public function load_includes() {
		
		// Include & init admin classes
		if ( is_admin() ) {
			
			// Include & init admin main class
			include_once ( $this->plugin_path . 'includes/admin/class_admin.php' );
			GW_GoPricing_Admin::instance( $this->globals );
			
		}

		// Include & init data class
		include_once ( $this->plugin_path . 'includes/core/class_data.php' );
		GW_GoPricing_Data::instance();
		
		// Include helper class
		include_once ( $this->plugin_path . 'includes/core/class_helper.php' );	
		
		// Include api class
		include_once ( $this->plugin_path . 'includes/core/class_api.php' );
		
		// Include plugin addons class
		include_once ( $this->plugin_path . 'includes/core/class_addons.php' );		

		// Include custom plugin upgrader class
		include_once ( $this->plugin_path . 'includes/core/class_plugin_upgrader.php' );
		
		// Include custom plugin installer skin class
		include_once ( $this->plugin_path . 'includes/core/class_plugin_installer_skin.php' );		

		// Include & init plugin update
		include_once ( $this->plugin_path . 'includes/core/class_update.php' );
		GW_GoPricing_Update::instance();
		
		// Include & init shortcodes class
		include_once ( $this->plugin_path . 'includes/front/class_front.php' );
		GW_GoPricing_Front::instance();	
		
		// Include & init shortcodes class
		include_once ( $this->plugin_path . 'includes/shortcodes/class_shortcodes.php' );
		GW_GoPricing_Shortcodes::instance( $this->globals );		

	}

	 
	/**
	 * Load the plugin text domain for translation
	 *
	 * @return void
	 */			 
	 
	public function load_plugin_textdomain() {

		load_plugin_textdomain( 'go_pricing_textdomain', FALSE, $this->plugin_dir . '/lang/' );
	
	}				
	
	
	/**
	 * Register plugin globals
	 *
	 * @return void
	 */			 
	 
	public function register_globals() {

		global $go_pricing;
		
		include_once( $this->plugin_path . 'includes/globals/currency.php' );
		include_once( $this->plugin_path . 'includes/globals/fonts.php' );
		include_once( $this->plugin_path . 'includes/globals/styles.php' );
		include_once( $this->plugin_path . 'includes/globals/clean_style.php' );		
		include_once( $this->plugin_path . 'includes/globals/shadows.php' );
		include_once( $this->plugin_path . 'includes/globals/signs.php' );
		include_once( $this->plugin_path . 'includes/globals/animation.php' );
	
	}
	
	
	/**
	 * Plugin init action
	 *
	 * @return void
	 */			 
	 	
	
	public function plugin_init() {
		
		do_action( 'go_pricing_init' );	
	
	}	
		
}

