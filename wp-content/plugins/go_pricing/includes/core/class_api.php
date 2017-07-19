<?php
/**
 * Class for connecting to plugin API
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class
class GW_GoPricing_Api {

	protected $globals;
		
	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected static $plugin_path;
	
	protected $plugin_file;
	protected $plugin_base;
	
	protected $url = 'http://granthweb.com/api';
	protected $args_headers = array();
	protected $args_body = array();
	protected $use_cache = true;
	protected $cache_hash = null;
	protected $response = null;


	/**
	 * Initialize the class
	 *
	 * @return void
	 */	
	
	public function __construct( $body, $header = array(), $use_cache = true ) {
		
		$this->globals = GW_GoPricing::instance();
		self::$plugin_version = $this->globals['plugin_version'];
		self::$db_version = $this->globals['db_version'];		
		self::$plugin_prefix = $this->globals['plugin_prefix'];
		self::$plugin_slug = $this->globals['plugin_slug'];
		self::$plugin_path = $this->globals['plugin_path'];	
		
		$this->plugin_file = $this->globals['plugin_file'];
		$this->plugin_base = $this->globals['plugin_base'];		
		
		if ( !empty( $header ) ) $this->args_headers = $header;
		if ( !empty( $body ) ) $this->args_body = $body;
		if ( $use_cache === false ) $this->use_cache = false;
		
		$this->connect( $this->args_body, $this->args_headers, $this->use_cache );
		
	}

	
	/**
	 * Connet to API and get data
	 *
	 * @return array | bool
	 */	
	
	public function connect() {
		
		global $wp_version;
		
		$args = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'user-agent'  => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ),
			'headers' => $this->args_headers,
			'body' => $this->args_body
		);
			
		$this->cache_hash = md5( serialize( $args ) );

		//$this->clear_cache();

		if ( $this->use_cache === true ) { 
			$response = get_transient( self::$plugin_prefix . '_'.  $this->cache_hash );
		} else {
			$this->clear_cache();		
		}
		
		if ( $this->use_cache === false || empty( $response ) ) {
			
			$response = wp_remote_post( 
				$this->url, 
				$args
			);

		}
		
		if ( is_wp_error( $response ) || empty( $response['body'] ) || !isset( $response['response']['code'] ) || $response['response']['code'] != '200' || !isset( $response['headers']['content-type'] ) || $response['headers']['content-type'] != 'application/json' ) return false;

		set_transient( self::$plugin_prefix . '_'.  $this->cache_hash, $response, 60 * 60 * 6 ); /* 6hrs */

		return $this->response = $response;

	}
	
	
	/**
	 * Return API result
	 *
	 * @return array | bool
	 */
	 	
	
	public function get_response() {	
	
		return $this->response;
		
	}
	

	/**
	 * Get API data
	 *
	 * @return array | bool
	 */
	 	
	
	public function get_data( $json = false ) {	
	
		if ( empty( $this->response ) || empty( $this->response['body'] ) ) return false;
	
		$data = json_decode( $this->response['body'], true );

		if ( empty( $data['data'] ) ) return false;

		return $data['data'];
		
	}	
	
	
	/**
	 * Clear API chache
	 *
	 * @return void
	 */	
	
	public function clear_cache() {	
	
		delete_transient( self::$plugin_prefix . '_'.  $this->cache_hash );
		
	}
	

}

?>