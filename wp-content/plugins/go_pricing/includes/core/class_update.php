<?php
/**
 * Plugin update class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class
class GW_GoPricing_Update {

	protected static $instance = null;
	protected $globals;
		
	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected static $plugin_path;
	
	protected $plugin_file;
	protected $plugin_base;	
	
	protected $api_url = 'http://granthweb.com/api';	


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
		self::$plugin_path = $this->globals['plugin_path'];
		
		$this->plugin_file = $this->globals['plugin_file'];
		$this->plugin_base = $this->globals['plugin_base'];		

		add_action( 'init', array( $this, 'update_filters' ) );
	
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
	 * Update fileters
	 *
	 * @return void
	 */	


	public function update_filters() {
		
		// Check for update
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ) );

		// Show plugin information
		add_filter( 'plugins_api', array( $this, 'update_info' ), 10, 3 );
		
	}
		
	
	/**
	 * Check for plugin updates
	 *
	 * @return array
	 */		  
		 
	public function check_update( $transient ) {
		
		global $wp_version;
		global $go_pricing;
		
		$api_products['go_pricing'] = array(
			'id' => 'go_pricing',
			'slug' => 'gw-' . self::$plugin_slug,
			'base' => $this->plugin_base,
			'version' => self::$plugin_version,
		);
		
		$apicall = new GW_GoPricing_Api( array( 'product' => 'go_pricing', 'type' => 'info' ) );
		$api_data = $apicall->get_data();
		
		if ( !empty( $go_pricing['addons'] ) && !empty( $api_data['addons'] ) ) {
			
			foreach( $go_pricing['addons'] as $id => $addon ) {
				
				if ( empty( $addon['id'] ) || empty( $addon['name'] ) || empty( $addon['slug'] ) || empty( $addon['base'] ) || empty( $addon['version'] ) ) continue;
				
				if ( !empty( $api_data['addons'] ) && !empty( $api_data['addons'][$id] ) ) $api_products[$id] = $addon;
				
			}
			
		}
		
		if ( !empty( $api_data['addons'] ) ) unset( $api_data['addons'] ) ;
		
		$api_products['go_pricing']['api_data'] = $api_data;
		
		if ( !empty( $go_pricing['addons'] ) ) $api_products = array_merge( $api_products, $go_pricing['addons'] );
		
		foreach( $api_products as $api_product ) {
			
			if ( empty( $api_product['api_data'] ) || empty( $api_product['api_data']['version'] ) ) continue;
			
			$update_data = get_option( self::$plugin_prefix . '_update_data', array() );
				
			// For backward compatibility
			$update_data = (array)$update_data;
				
			$update_data[$api_product['slug']] = $api_product;
				
			update_option( self::$plugin_prefix . '_update_data', $update_data );
							
			if ( version_compare( $api_product['version'], $api_product['api_data']['version'], '<' ) ) {
	
				$obj = new stdClass();
				$obj->slug = $api_product['slug'];
				$obj->plugin = $api_product['base'];
				$obj->new_version = $api_product['api_data']['version'];
				$obj->package = '';		
				$obj->upgrade_notice = '';
				$transient->response[$api_product['base']] = $obj;
	
			}			
		
		}
		
		return $transient;		

	}
	
	
	/**
	 * Show update details
	 *
	 * @return array | bool
	 */		
	
	public function update_info( $false, $action, $args ) {
		
		$update_data = get_option( self::$plugin_prefix . '_update_data', array() );
		
		if ( empty( $args->slug ) || empty( $update_data[$args->slug] ) || empty( $update_data[$args->slug]['api_data'] ) || empty( $update_data[$args->slug]['id'] ) ) return false;
	
		$plugin_data = $update_data[$args->slug]['api_data'];
				
		$change_log = '';
		
		$apicall = new GW_GoPricing_Api( array( 'product' => $update_data[$args->slug]['id'], 'type' => 'log' ) );
		$api_data = $apicall->get_data();		
				
		if ( !empty( $api_data ) ) {
			
			foreach( $api_data as $version => $info ) {
				
				$change_log .= sprintf( '<h4>%s</h4>', $version );
				$more_info = !empty( $info['details'] ) ? sprintf( ' - <a href="%1$s" target="_blank">%2$s</a>', $info['details'], __( 'More info', 'go_pricing_textdomain' ) ) : ''; 
				$change_log .= '<em>' . sprintf( '%1$s - %2$s', __( 'Release Date', 'go_pricing_textdomain' ), date_i18n( get_option( 'date_format' ), strtotime( $info['date'] ) ) ) . $more_info . '</em>';
				$change_log .= !empty( $info['description'] ) ? sprintf( '<p>%s</p>', $info['description'] ) : ''; 
				$change_log .= $info['log'];
				
			}
			
		}
			
		$obj = new stdClass();
		$obj->slug = $args->slug;  
		$obj->name = $plugin_data['name']; /* ? */
		$obj->plugin_name = $args->slug;
		$obj->version = $plugin_data['version'];			
		$obj->requires = $plugin_data['wp_min'];  
		$obj->tested = $plugin_data['wp_max'];  
		$obj->last_updated = $plugin_data['date'];  
		$obj->sections = array(  
			'description' => !empty( $plugin_data['description'] ) ? wpautop( $plugin_data['description'] ) : '',
			'changelog' => $change_log 
		);
		$obj->author = '<a href="http://granthweb.com" target="_blank">Granth</a>';
		$obj->homepage = $plugin_data['url'];

		return $obj;
		
	}

}

?>