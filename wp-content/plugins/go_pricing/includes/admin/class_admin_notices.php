<?php
/**
 * Admin notices class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


// Class
class GW_GoPricing_AdminNotices {

	protected static $instance = null;
	protected $globals;
		
	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected static $plugin_path;


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

		// Admin notices action
		add_action( 'admin_notices', array( $this, 'print_admin_notices' ) );
	
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
	 * Print admin notices
	 *
	 * @return void
	 */		  
		 
	public static function print_admin_notices() {
		
		$notices = $new_notices = get_option( self::$plugin_prefix . '_notices' ); 
		if ( $notices === false ) return;
		
		foreach ( $notices as $notice_key => $notice ) {

			// Set message class
			$class = 'updated';
			
			if ( !empty( $notice['type'] ) ) {
				
				switch( $notice['type'] ) {
				
					case 'error' : 
						$class = 'error';
						break;

					case 'success' : 
						$class = 'updated';
						break;

					case 'info' : 
						$class = 'info';
						break;					

				}
				
			}
			
			// Show message
			if ( !empty( $notice['message'] ) ) {
				$content = '';
				foreach ( (array)$notice['message'] as $msg ) {
					$content .= '<p><strong>' . $msg . '</strong></p>';
				}
				include( self::$plugin_path . 'includes/admin/views/view_message.php' );
				
			}
			
			unset( $new_notices[$notice_key] );
			
		}
		
		if ( $new_notices != $notices ) update_option( self::$plugin_prefix . '_notices', $new_notices ); 
		
	}	


	/**
	 * Show admin notices
	 *
	 * @return void
	 */		  
		 
	public static function show() {

		self::print_admin_notices();
		
	}


	/**
	 * Add admin notice
	 *
	 * @return void
	 */		  
		

	public static function add( $id = '', $type = 'success', $message = '', $override = true ) {
		
		if ( empty( $message ) ) return;
				
		$notices = $new_notices = get_option( self::$plugin_prefix . '_notices' );
		
		if ( !empty( $new_notices[$id] ) && (bool)$override === false ) {
			$old_message = $new_notices[$id]['message'];
			$new_notices[$id]['message'] = array_merge( (array)$old_message, (array)$message );
		} else {			
			$new_notices[$id] = array (
				'type' => $type, 
				'message' => array( $message )
			);
		}
		
		if ( $new_notices != $notices ) update_option( self::$plugin_prefix . '_notices', $new_notices ); 		
		
	}
	
	/**
	 * Get admin notice
	 *
	 * @return array
	 */		  
		

	public static function get( $id = '', $type = 'error' ) {
		
		if ( empty( $id ) ) return false;
		return get_option( self::$plugin_prefix . '_notices' ); 		
		
	}	
	
}

?>