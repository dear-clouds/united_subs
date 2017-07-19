<?php
/**
 * Admin page abtract class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class
abstract class GW_GoPricing_AdminPage {

	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected $plugin_file;
	protected $plugin_base;
	protected $plugin_dir;
	protected $plugin_path;
	protected $plugin_url;
	protected $globals;

	protected $is_ajax;
	protected $screen;
	protected $nonce;
	protected $referrer;
	protected $action;
	protected $action_type;
	
	protected $title;
	protected $content;
	protected $message;
	protected $response;
	protected $wrapper_class;
	protected $settings;
	

	/**
	 * Initialize the class
	 *
	 * @return object
	 */		  
	
	public function __construct( $ajax_action_callback = null ) {
		
		$this->globals = GW_GoPricing::instance();
		self::$plugin_version = $this->globals['plugin_version'];
		self::$db_version = $this->globals['db_version'];		
		self::$plugin_prefix = $this->globals['plugin_prefix'];
		self::$plugin_slug = $this->globals['plugin_slug'];
		$this->plugin_file = $this->globals['plugin_file'];		
		$this->plugin_base = $this->globals['plugin_base'];
		$this->plugin_dir = $this->globals['plugin_dir'];
		$this->plugin_path = $this->globals['plugin_path'];
		$this->plugin_url =	$this->globals['plugin_url'];

		$this->screen = get_current_screen();
		$this->action = !empty( $_POST['_action'] ) ? $_POST['_action'] : '';
		$this->action_type = !empty( $_POST['_action_type'] ) ? $_POST['_action_type'] : '';
		$this->referrer = !empty( $_POST['_wp_http_referer'] ) ? esc_url( $_POST['_wp_http_referer'] ) : '';
		$this->is_ajax = isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' && !empty( $_POST['action'] ) ? true : false;

		// Register ajax actions
		if ( !empty( $ajax_action_callback ) ) $this->register_ajax_actions( $ajax_action_callback );
		
		// Fire action
		$this->action();	

	}	
	
	/**
	 * Register ajax actions
	 *
	 * @return void
	 */			
	
	abstract public function register_ajax_actions( $ajax_action_callback );
	
	
	/**
	 * Action 
	 *
	 * @return object
	 */			
	
	abstract public function action();
	
	
	/**
	 * Get view
	 *
	 * @return object
	 */
	 	
	abstract public function view( $view = '' );
		

	/**
	 * Create nonce
	 *
	 * @return void
	 */

	public function create_nonce( $action = 'action' ) {
		
		$this->nonce = $this->plugin_base .'-'. $action;

	}

	
	/**
	 * Save temporary postdata
	 *
	 * @return void
	 */	
	
	public function set_temp_postdata( $data ) {
		
		set_transient( 
			sha1( self::$plugin_prefix . '_tmp'  ), 
			array( 
				'token' => sha1( self::$plugin_prefix . ( !empty( $data ) && is_array( $data ) ? base64_encode( serialize( $data ) ) : $data ) ),
				'data' => $data
			),
			10
		);

	}
	
	
	/**
	 * Read temporary postdata
	 *
	 * @return void
	 */		
	
	public function get_temp_postdata() {
		
		$tmp_postdata = get_transient( sha1( self::$plugin_prefix . '_tmp'  ), false );
		if ( $tmp_postdata === false ) return;
		if ( empty( $tmp_postdata['token'] ) || empty( $tmp_postdata['data'] ) || sha1( self::$plugin_prefix . ( !empty( $tmp_postdata['data'] ) && is_array( $tmp_postdata['data'] ) ? base64_encode( serialize( $tmp_postdata['data'] ) ) : $tmp_postdata['data'] ) ) != $tmp_postdata['token'] ) return false;

		return $tmp_postdata['data'];

	}
	
	
	/**
	 * Delete temporary postdata
	 *
	 * @return void
	 */		
	
	public function delete_temp_postdata() {

		delete_transient( sha1( self::$plugin_prefix . '_tmp'  ) );
		
	}			


	/**
	 * Set view title
	 *
	 * @return void
	 */
	 
	public function title( $title = '' ) {
		
		$this->title = $title;

	}	


	/**
	 * Set view content
	 *
	 * @return void
	 */
	 
	public function content( $content = '', $type = 'page' ) {
		
		$this->content = $content;
		
		switch( $type ) {
			
			case 'page' :
				$this->response = 'page';
				break;
		
			case 'message' : 
				$this->response = 'message';
				break;
		
			case 'raw' :
				$this->response = 'raw';
				break;			
				
			default : 
				$this->response = null;
				break;
			
		}
		
	}
	
	
	/**
	 * Render view
	 *
	 * @return string
	 */
	 	
	public function render() {
		
		if ( $this->response == 'page' ) {
			return $this->render_page();
		} else if ( $this->response == 'message' ) {
			return $this->render_message();
		} else if ( $this->response == 'raw' ) {
			return $this->render_raw();
		} else {
			return;
		}
		
	}


	/**
	 * Render page view
	 *
	 * @return string
	 */
	
	public function render_page() {

		$content = $this->content;
		$title = $this->title;
		$wrapper_class = $this->wrapper_class;
		$settings = $this->settings;

		include_once( 'views/view_page.php' );
		$content = ob_get_clean();
		return $content;
		
	}


	/**
	 * Render message view
	 *
	 * @return string
	 */

	public function render_message() {
		
		return '<div class="updated">' . $this->content . '</div>';

	}

	
	/**
	 * Render raw view
	 *
	 * @return string
	 */
	 	
	public function render_raw() {
		
		return $this->content;
		
	}	

	
}

?>