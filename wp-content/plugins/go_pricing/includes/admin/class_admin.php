<?php
/**
 * Admin core class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


// Class
class GW_GoPricing_Admin {	

	protected static $instance = null;
	protected static $screen_hooks = null;
	protected static $ajax_actions;

	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected $plugin_file;
	protected $plugin_base;
	protected $plugin_dir;
	protected $plugin_path;
	protected $plugin_url;
	protected $admin_path;
	protected $admin_url;
	protected $includes_path;
	protected $includes_url;
	protected $views_path;
	protected $globals;


	/**
	 * Initialize the class
	 *
	 * @return object
	 */		  
	
	public function __construct( $globals ) {
		
		self::$plugin_version = $globals['plugin_version'];
		self::$db_version = $globals['db_version'];		
		self::$plugin_prefix = $globals['plugin_prefix'];
		self::$plugin_slug = $globals['plugin_slug'];
		$this->plugin_file = $globals['plugin_file'];		
		$this->plugin_base = $globals['plugin_base'];
		$this->plugin_dir = $globals['plugin_dir'];
		$this->plugin_path = $globals['plugin_path'];
		$this->plugin_url =	$globals['plugin_url'];
		$this->globals = $globals;

		add_action( 'init', array( $this, 'check_db_version' ) );
		
		add_action( 'init', array( $this, 'check_plugin_version' ) );

		// Start output buffering
		add_action( 'admin_init', array( $this, 'start_ob' ) );	
		
		// Delete temporary files
		add_action( 'admin_init', array( $this, 'delete_temporary_uploads' ) );		

		// Enqueue admin styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		
		// Enqueue admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		
		// Localization
		add_action( 'admin_enqueue_scripts', array( $this, 'localization' ) );		
					
		// Register menu pages
		add_action( 'admin_menu', array( $this, 'register_menu_pages' ) );	
		
		// Handle ajax actions
		add_action( 'wp_ajax_go_pricing_ajax_action', array( __CLASS__, 'ajax_action_router' ) );
		add_action( 'wp_ajax_nopriv_go_pricing_ajax_action', array( __CLASS__, 'nopriv_ajax_request' ) );		
		
		// Clip ad
		add_action( 'go_pricing_init', array( $this, 'clip_ad' ), 9999 );
		
	}


	/**
	 * Clip ad actions
	 *
	 * @return void
	 */

	public function clip_ad() {
	
		if ( class_exists( 'GW_GoPricing_Clip' ) ) return;	
		add_action( 'go_pricing_editor_popup_content_before_html', array( $this, 'editor_popup_clipboard_html' ) );
		add_action( 'go_pricing_colum_editor_content_before_html', array( $this, 'clipboard_html' ) );
		add_action( 'go_pricing_colum_editor_nav_html', array( $this, 'clipboard_nav_html' ) );
						
	}


	/**
	 * HTML content of popup clipboard
	 *
	 * @return void
	 */

	public function editor_popup_clipboard_html( $data ) {
		
		ob_start();
		?>
		<div class="gwa-clipboard-wrap-preview"<?php echo isset( $data['_action_type'] ) ? sprintf( ' data-clip-id="%s"', esc_attr( $data['_action_type'] ) ) : ''; ?>>
			<div class="gwa-clipboard-preview">
				<div class="gwa-clipboard-message-prev"><p><strong>Easier and faster work? Of course!</strong><br>By using ‘Clip – Add-on for Go Pricing’ you can copy this popup content within a table or between tables.</p><a href="http://codecanyon.net/item/clip-addon-for-go-pricing/13216605?ref=Granth" target="_blank" title="<?php esc_attr_e( 'Buy Now', 'go_pricing_clip_textdomain' ); ?>" class="gwa-btn-style2"><?php _e( 'Buy Now', 'go_pricing_clip_textdomain'); ?></a></div>
				<div class="gwa-clip-assets-nav-preview"><a href="#" class="gwa-asset-icon-clipboard-preview" data-action="clipboard-prev" title="<?php esc_attr_e( 'Open / Close Clipboard', 'go_pricing_clip_textdomain' ); ?>"><span></span></a></div>
				<a href="#" title="<?php esc_attr_e( 'Close', 'go_pricing_clip_textdomain' ); ?>" class="gwa-clipboard-close"></a>
			</div>
		</div>
		<?php
		echo ob_get_clean();
		
	}
	
	
	/**
	 * HTML content of popup clipboard
	 *
	 * @return void
	 */

	public function clipboard_html( $data ) {
		
		ob_start();
		?>
		<div class="gwa-clipboard-wrap-preview">
			<div class="gwa-clipboard-preview">
                <div class="gwa-clipboard-message-prev"><p><strong>Easier and faster work? Of course!</strong><br>By using ‘Clip – Add-on for Go Pricing’ you can copy columns within a table or between tables.</p><a href="http://codecanyon.net/item/clip-addon-for-go-pricing/13216605?ref=Granth" target="_blank" title="<?php esc_attr_e( 'Buy Now', 'go_pricing_clip_textdomain' ); ?>" class="gwa-btn-style2"><?php _e( 'Buy Now', 'go_pricing_clip_textdomain'); ?></a></div>
			</div>
		</div>
		<?php
		echo ob_get_clean();
		
	}	
	
	
	/**
	 * HTML content of clipboard icon in column editor header
	 *
	 * @return void
	 */
	 	
	public function clipboard_nav_html( $data ) {
		
		ob_start();
		?>
		<a href="#" data-action="clipboard-prev" title="<?php _e( 'Open / Close Clipboard', 'go_pricing_clip_textdomain' ); ?>" class="gwa-abox-header-nav-clip-preview"><?php _e( 'Clip', 'go_pricing_clip_textdomain' ); ?></a>
		<?php
		echo ob_get_clean();
		
	}


	/**
	 * Check plugin version
	 *
	 * @return void
	 */	 	

	public function check_plugin_version() {
		
		$user_id = get_current_user_id();
		if ( !isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ) $_COOKIE['go_pricing']['settings']['help'][$user_id] = 1;		

		$version_info = get_option( self::$plugin_prefix . '_version' );
		
		if ( empty( $version_info['plugin'] ) || ( !empty( $version_info['plugin'] ) && version_compare( $version_info['plugin'], self::$plugin_version, '<' ) ) ) {
		
			$this->register_defaults();
			$version_info['plugin'] = self::$plugin_version;
			update_option( self::$plugin_prefix . '_version', $version_info );
					
		}
				
	}
	
	
	/**
	 * Register default values
	 *
	 * @return void
	 */		
	
	public function register_defaults() {
		
		$general_settings = get_option( self::$plugin_prefix . '_table_settings' );
		
		// General Settings 
		if ( empty( $general_settings['admin'] ) ) {
			$general_settings['admin'] = array(
				'ajax' => 1,
				'capability' => 'manage_options'
			);
		}
		
		// Currency
		if ( empty( $general_settings['currency'] ) ) {
			$general_settings['currency'][0] = array(
				'currency' => 'USD',
				'position' => 'left',
				'thousand-sep' => ',',
				'decimal-sep' => '.',
				'decimal-no' => 2
			);
		}
				
		update_option( self::$plugin_prefix . '_table_settings', $general_settings );

	}

	public function check_db_version() {

		$old_db_tables = get_option( self::$plugin_prefix . '_tables' );
		$version_info = get_option( self::$plugin_prefix . '_version' );

		if ( ( empty( $version_info['db'] ) || ( !empty( $version_info['db'] ) && version_compare( $version_info['db'], self::$db_version, "<" ) ) ) && !empty( $old_db_tables ) ) {
			add_action( 'go_pricing_menu_pages', array($this, 'register_db_update_page' ));
			add_filter( 'go_pricing_page_router_callback', array( $this, 'force_db_update_page' ) );
		}
				
	}
	
	public function register_db_update_page() {

		// Get general settings
		$general_settings = get_option( self::$plugin_prefix . '_table_settings' );
		
		// DB updater page
		self::add_submenu_page(
			__( 'Database Update', 'go_pricing_textdomain' ),
			__( 'Database Update', 'go_pricing_textdomain' ),
			isset( $general_settings['capability'] ) ? $general_settings['capability'] : 'manage_options', 
			self::$plugin_slug . '-db-update',
			array( $this, 'db_updater_page' ),
			false
		);
	
	}	

	public function force_db_update_page( $callback ) {
		
		return array( $this, 'db_updater_page' );
	
	}	

	
	/**
	 * Return an instance of this class
	 *
	 * @return object | bool
	 */
	 
	public static function instance( $globals = null ) {
		
		if ( empty( $globals ) && self::$instance == null ) return false;
		
		if ( self::$instance == null ) {
			self::$instance = new self ( $globals );
			self::$instance->load_includes();
		}
		
		return self::$instance;
		
	}
	
	
	/**
	 * Load admin includes
	 *
	 * @return void
	 */	

	public function load_includes() {
		
		// Include & init admin notice class
		include_once ( $this->plugin_path . 'includes/admin/class_admin_notices.php');
		GW_GoPricing_AdminNotices::instance();
		
		// Include admin page classes
		include_once ( $this->plugin_path . 'includes/admin/class_admin_page.php');
		include_once ( $this->plugin_path . 'includes/admin/class_admin_page_main.php');
		include_once ( $this->plugin_path . 'includes/admin/class_admin_page_general_settings.php');
		include_once ( $this->plugin_path . 'includes/admin/class_admin_page_impex.php');
		include_once ( $this->plugin_path . 'includes/admin/class_admin_page_db_update.php');
		include_once ( $this->plugin_path . 'includes/admin/class_admin_page_update.php');		
		
		// Include VC extend class
		include_once ( $this->plugin_path . 'includes/vendors/vc/class_vc_extend.php');
		GW_GoPricing_VCExtend::instance();

	}	
	

	/**
	 * Start output buffering 
	 *
	 * @return void
	 */	

	public function start_ob() {
		
		ob_start();	
	}
	

	/**
	 * Delete uploaded files
	 *
	 * @return void
	 */	

	public function delete_temporary_uploads() {
		
		$uploads = get_option( self::$plugin_prefix . '_uploads', array() );
		
		if ( get_transient( self::$plugin_prefix . '_uploads' ) !== false ) return;

		$new_uploads = array();
		
		foreach ( $uploads as $upload_key => $upload ) {
			
			if ( empty( $upload['expiration'] ) || empty( $upload['file'] ) ) continue;
						
			$expiration = strtotime( $upload['expiration'] );
			$now = strtotime( date( 'Y-m-d H:i:s' ) );
			
			if ($expiration - $now > 0 && file_exists( $upload['file'] ) ) {
				$new_uploads[] = $upload;
			} else {
				unlink( $upload['file'] );
			}
				
		}
		
		if ( $uploads != $new_uploads ) update_option( self::$plugin_prefix . '_uploads', $new_uploads );
		set_transient( self::$plugin_prefix . '_uploads', 'uploads', 5 * 60 );
		
	}	
	
		
	/**
	 * Enqueue admin styles
	 *
	 * @return void
	 */

	public function enqueue_admin_styles() {
		
		// Plugin screens filter
		self::$screen_hooks = apply_filters( 'go_pricing_add_screen', self::$screen_hooks );
		
		if ( empty( self::$screen_hooks ) ) return;
		
		$screen = get_current_screen();
		
		if ( array_key_exists( $screen->id, self::$screen_hooks ) ) {
			
			wp_enqueue_style( self::$plugin_slug . '-admin-styles', $this->plugin_url . 'assets/admin/css/go_pricing_admin_styles.css', array(), self::$plugin_version );
			wp_enqueue_style( self::$plugin_slug . '-font-awesome', $this->plugin_url . 'assets/lib/font_awesome/css/font-awesome.min.css', array(), self::$plugin_version );
			wp_enqueue_style( self::$plugin_slug . '-spectrum', $this->plugin_url . 'assets/lib/spectrum/spectrum.css', array(), self::$plugin_version );
			wp_enqueue_style( self::$plugin_slug . '-codemirror', $this->plugin_url . 'assets/lib/codemirror/codemirror.css', array(), self::$plugin_version );			
				
		}

	}


	/**
	 * Enqueue admin scripts
	 *
	 * @return void
	 */

	public function enqueue_admin_scripts() {
		
		if ( empty( self::$screen_hooks ) ) return;
		
		global $wp_version;
		
		$screen = get_current_screen();

		if ( array_key_exists( $screen->id, self::$screen_hooks ) ) {
					
			if ( version_compare( $wp_version, 3.5, ">=" ) ) wp_enqueue_media();

			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( self::$plugin_slug . '-spectrum', $this->plugin_url . 'assets/lib/spectrum/spectrum.js', 'jquery', self::$plugin_version );
			wp_enqueue_script( self::$plugin_slug . '-codemirror', $this->plugin_url . 'assets/lib/codemirror/codemirror_custom.js', 'jquery', self::$plugin_version );			
			wp_enqueue_script( self::$plugin_slug . '-admin-scripts', $this->plugin_url . 'assets/admin/js/go_pricing_admin_scripts.js', 'jquery', self::$plugin_version );			
				
		}
			
	}
	
	
	/**
	 * Set translatable content
	 *
	 * @return void
	 */

	public function localization() {
		
		$translate = array(
			'ajax_error' => __( 'PHP Error in AJAX Response!', 'go_pricing_textdomain' ),
			'upload_size' => __( 'File size exceeds the maximum upload size!', 'go_pricing_textdomain' ),
			'upload_size_null' => __( 'File is emtpy!', 'go_pricing_textdomain' ),			
			'upload_ext' => __( 'Invalid file type', 'go_pricing_textdomain' ),			
			'warning_maxcol' => __( 'You have reached the maximum number of columns!', 'go_pricing_textdomain' ),
			'warning_invalid_imge' => __( 'Invalid image!', 'go_pricing_textdomain' )
		);					
		
		wp_localize_script( self::$plugin_slug . '-admin-scripts', 'GoPricingL10n', $translate );	
		
	}
	

	/**
	 * Register menu pages
	 *
	 * @return void
	 */
	 
	public function register_menu_pages() {
		
		$general_settings = get_option( self::$plugin_prefix . '_table_settings' );
		
		// Main menu page
		$screen_id = add_menu_page( 
			'Go Pricing',
			'Go Pricing', 
			isset( $general_settings['capability'] ) ? $general_settings['capability'] : 'manage_options', 
			self::$plugin_slug, 
			array( __CLASS__, 'admin_page_router' ),
			$this->plugin_url . 'assets/admin/images/go_logo_nav.png',
			90.1298
		);
		
		self::$screen_hooks[$screen_id] = array( __CLASS__, 'main_page' );
		
		// General Settings page
		self::add_submenu_page(
			__( 'General Settings', 'go_pricing_textdomain' ),
			__( 'General Settings', 'go_pricing_textdomain' ),
			isset( $general_settings['capability'] ) ? $general_settings['capability'] : 'manage_options', 
			self::$plugin_slug . '-settings',
			array( $this, 'settings_page' )
		);

		// Import & Export page
		self::add_submenu_page(
			__( 'Import & Export', 'go_pricing_textdomain' ),
			__( 'Import & Export', 'go_pricing_textdomain' ),
			isset( $general_settings['capability'] ) ? $general_settings['capability'] : 'manage_options', 
			self::$plugin_slug . '-import-export',
			array( $this, 'impex_page' )
		);
		
		if ( !is_multisite() || ( is_multisite() && get_current_blog_id() == 1 ) ) {
		
			$capability = is_multisite() ? 'manage_network' : ( isset( $general_settings['capability'] ) ? $general_settings['capability'] : 'manage_options' );
		
			// Plugin Update page
			self::add_submenu_page(
				__( 'Update', 'go_pricing_textdomain' ),
				__( 'Update', 'go_pricing_textdomain' ),
				$capability, 
				self::$plugin_slug . '-update',
				array( $this, 'plugin_updater_page' )
			);	
	
		}
		
		// Admin menu page action
		do_action( 'go_pricing_menu_pages' );	
		
	}
	
	
	/**
	 * Main page
	 *
	 * @return void
	 */
	 
	public static function main_page() {
	
		$page = new GW_GoPricing_AdminPage_Main( __METHOD__ );
		$page->title( 'Go Pricing' );
		echo $page->render();
		
	}
	
	
	/**
	 * General Settings page
	 *
	 * @return void
	 */
	 
	public static function settings_page() {

		$page = new GW_GoPricing_AdminPage_GeneralSettings( __METHOD__ );
		$page->title( sprintf( 'Go Pricing - %s',  __( 'General Settings', 'go_pricing_textdomain' ) ) );
		echo $page->render();
		
	}	
	
	
	/**
	 * Import & Export page
	 *
	 * @return void
	 */
	 
	public static function impex_page() {
		
		$page = new GW_GoPricing_AdminPage_Impex( __METHOD__ );
		$page->title( sprintf( 'Go Pricing - %s',  __( 'Import & Export', 'go_pricing_textdomain' ) ) );
		echo $page->render();	
		
	}
	
	/**
	 * Database updater page
	 *
	 * @return void
	 */
	 
	public static function db_updater_page() {
		
		$page = new GW_GoPricing_AdminPage_DbUpdate( __METHOD__ );
		$page->title( sprintf( 'Go Pricing - %s',  __( 'Database Update', 'go_pricing_textdomain' ) ) );
		echo $page->render();
		
	}
	
	
	/**
	 * Plugin updater page
	 *
	 * @return void
	 */
	 
	public static function plugin_updater_page() {
		
		$page = new GW_GoPricing_AdminPage_Update( __METHOD__ );
		$page->title( sprintf( 'Go Pricing - %s',  __( 'Update', 'go_pricing_textdomain' ) ) );
		echo $page->render();
		
	}	
	
	
	/**
	 * Add submenu page
	 *
	 * @return void
	 */
	 
	public static function add_submenu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $parent_slug = true ) {
		
		if ( $parent_slug === true ) $parent_slug = self::$plugin_slug;

		$screen_id = add_submenu_page(
			$parent_slug,			
			$page_title . ' | Go Pricing',
			$menu_title,
			$capability, 
			$menu_slug,
			array( __CLASS__, 'admin_page_router' )
		);
		
		return array( $screen_id => self::$screen_hooks[$screen_id] = $function );
		
	}
	
	
	/**
	 * Remove submenu page
	 *
	 * @return void
	 */
	 
	public static function remove_submenu_page( $menu_slug, $parent_slug = true ) {
		
		if ( $parent_slug === true ) $parent_slug = self::$plugin_slug;

		$result = remove_submenu_page( $parent_slug, $menu_slug );
		
		if ( !empty( $result ) && isset( self::$screen_hooks[self::$plugin_slug . '_page_' . $menu_slug] ) ) 
			unset( self::$screen_hooks[self::$plugin_slug . '_page_' . $menu_slug] );
		
	}
	

	/**
	 * Admin page router
	 *
	 * @return void
	 */
	 
	public static function admin_page_router() {

		$screen = get_current_screen();		
		
		if ( !empty( $screen->id ) && !empty( self::$screen_hooks[$screen->id] ) ) {

			$screen_filter = self::$screen_hooks[$screen->id];
			
			// Filter for a certain page
			$page_callback = apply_filters( "{$screen->id}_callback", $screen_filter );

			// Global filter
			$page_callback = apply_filters( 'go_pricing_page_router_callback', $page_callback );
			
			if ( !empty( $page_callback ) ) call_user_func( $page_callback, $screen->id );			
			
		}
		
	}


	/**
	 * Register ajax action
	 *
	 * @return void
	 */

	public static function register_ajax_action( $action, $action_callback ) {
		
		if ( empty( $action ) || empty( $action_callback ) ) return;
		
		$actions = $new_actions = get_option( self::$plugin_prefix . '_ajax_actions' );
		$new_actions['data'][$action] = $action_callback;
		
		if ( $actions['data'] != $new_actions['data'] ) {
		
			update_option( 
				self::$plugin_prefix . '_ajax_actions', 
				array(
					'token' => sha1( @serialize( $new_actions['data'] ) ),
					'data' => $new_actions['data']
				)
			);
		}
				
	}
	
	
	/**
	 * Ajax action router (handle callbacks)
	 *
	 * @return void
	 */	
	
	public static function ajax_action_router() {		
	
		if ( empty( $_POST['action'] ) || empty( $_POST['_action'] ) ) {
		
			GW_GoPricing_AdminNotices::add( 'ajax', 'error', __( 'No AJAX action has been found!', 'go_pricing_textdomain' ) );
			GW_GoPricing_AdminNotices::show();
			exit;
			
		}

		$actions = get_option( self::$plugin_prefix . '_ajax_actions' );
		
		if ( empty( $actions['data'] ) || empty( $actions['token'] ) || sha1( @serialize( $actions['data'] ) ) != $actions['token'] ) {

			GW_GoPricing_AdminNotices::add( 'ajax', 'error', __( 'Invalid AJAX callback has been detected! Please, refresh the page!', 'go_pricing_textdomain' ) );
			GW_GoPricing_AdminNotices::show();
			exit;
			
		}
				
		if ( !empty( $actions['data'][$_POST['_action']] ) ) {

			call_user_func( $actions['data'][$_POST['_action']] );
				
		} else {
			
			GW_GoPricing_AdminNotices::add( 'ajax', 'error', __( 'No AJAX callback has been registered for this action! Please, refresh the page!', 'go_pricing_textdomain' ) );
			GW_GoPricing_AdminNotices::show();
			exit;			
			
		}
		
		exit;

	}	
		

	/**
	 * Handle unauthorized ajax requrest
	 *
	 * @return void
	 */

	public static function nopriv_ajax_request() {

		die;

	}	

}

?>