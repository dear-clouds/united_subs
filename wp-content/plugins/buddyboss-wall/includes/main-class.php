<?php
/**
 * @package WordPress
 * @subpackage BuddyBoss Wall
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BuddyBoss_Wall_Plugin' ) ):
/**
 *
 * BuddyBoss Wall Main Plugin Controller
 * *************************************
 *
 *
 */
class BuddyBoss_Wall_Plugin
{
	/* Includes
	 * ===================================================================
	 */

	/**
	 * Most BuddyPress plugin have the includes in the function
	 * method that loads them, we like to keep them up here for easier
	 * access.
	 * @var array
	 */
	private $bp_includes = array(
		'wall-class',
		'wall-functions',
		'wall-template',
		'wall-compat',
		'wall-hooks',
		'wall-filters',
        'wall-privacy',

	);

	private $main_includes = array(
		'class-buddyboss-wall-like-notification',
		'wall-bp-notifications'
	);

	/**
	 * Admin includes
	 * @var array
	 */
	private $admin_includes = array(
		'admin'
	);

	/* Plugin Options
	 * ===================================================================
	 */

	/**
	 * Default options for the plugin, the strings are
	 * run through localization functions during instantiation,
	 * and after the user saves options the first time they
	 * are loaded from the DB.
	 *
	 * @var array
	 */
	private $default_options = array(
		'enabled'               => true,

		'notices_legacy'        => true,

		'UPDATE_MENUS'		    => true,
		'PERSONAL_TAB_NAME'		=> 'Wall',
		'FEED_TAB_NAME'		    => 'News Feed',
		'FAV_TAB_NAME'			=> 'My Likes',
		'MENU_NAME'				=> 'Wall',
		'INJECT_MARKUP'         => true,
		'ADD_TPL_HOOKS'         => true,
		'LOAD_CSS'              => true,
		'LOAD_TOOLTIPS'         => true,
		'USE_WP_CACHE'          => true,
        
        'enabled-wall-privacy'  => true,
        'enabled_link_preview'  => true,
	);

	/**
	 * This options array is setup during class instantiation, holds
	 * default and saved options for the plugin.
	 *
	 * @var array
	 */
	public $options        = array();
	
	/**
	 * Whether the plugin is activated network wide.
	 * 
	 * @var boolean 
	 */
	public $network_activated = false;

	/**
	 * Is BuddyPress installed and activated?
	 * @var boolean
	 */
	public $bp_enabled     = false;

	/* Version
	 * ===================================================================
	 */

	/**
	 * Plugin codebase version
	 * @var string
	 */
	public $version        = '0.0.0';

	/**
	 * Plugin database version
	 * @var string
	 */
	public $db_version     = '0.0.0';

	/* Paths
	 * ===================================================================
	 */
	public $file           = '';
	public $basename       = '';
	public $plugin_dir     = '';
	public $plugin_url     = '';
	// public $includes_dir        = '';
	// public $includes_url        = '';
	public $lang_dir       = '';
	public $assets_dir     = '';
	public $assets_url     = '';

	/* Component State
	 * ===================================================================
	 */
	public $current_type   = '';
	public $current_item   = '';
	public $current_action = '';
	public $is_single_item = false;

	/* Magic
	 * ===================================================================
	 */

	/**
	 * BuddyBoss Wall uses many variables, most of which can be filtered to
	 * customize the way that it works. To prevent unauthorized access,
	 * these variables are stored in a private array that is magically
	 * updated using PHP 5.2+ methods. This is to prevent third party
	 * plugins from tampering with essential information indirectly, which
	 * would cause issues later.
	 *
	 * @see BuddyBoss_Wall_Plugin::setup_globals()
	 * @var array
	 */
	private $data;

	/* Singleton
	 * ===================================================================
	 */

	/**
	 * Main BuddyBoss Wall Instance.
	 *
	 * BuddyBoss Wall is great
	 * Please load it only one time
	 * For this, we thank you
	 *
	 * Insures that only one instance of BuddyBoss Wall exists in memory at any
	 * one time. Also prevents needing to define globals all over the place.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @static object $instance
	 * @uses BuddyBoss_Wall_Plugin::setup_globals() Setup the globals needed.
	 * @uses BuddyBoss_Wall_Plugin::setup_actions() Setup the hooks and actions.
	 * @uses BuddyBoss_Wall_Plugin::setup_textdomain() Setup the plugin's language file.
	 * @see buddyboss_wall()
	 *
	 * @return BuddyBoss Wall The one true BuddyBoss.
	 */
	public static function instance()
	{
		// Store the instance locally to avoid private static replication
		static $instance = null;

		//Check the buddypress activity component is active
		$active_component = get_option('bp-active-components');

		if ( ! isset ( $active_component['activity'] ) ) {

			$instance = new BuddyBoss_Wall_Plugin();
			add_action( 'admin_notices', array( $instance, 'show_notices' ) );

			return $instance;
		}

		// Only run these methods if they haven't been run previously
		if ( null === $instance ) {
			$instance = new BuddyBoss_Wall_Plugin();
			$instance->setup_globals();
			$instance->setup_actions();
			$instance->setup_textdomain();
			$instance->do_includes( $instance->main_includes );
		}

		// Always return the instance
		return $instance;
	}

	/* Magic Methods
	 * ===================================================================
	 */

	/**
	 * A dummy constructor to prevent BuddyBoss Wall from being loaded more than once.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 * @see BuddyBoss_Wall_Plugin::instance()
	 * @see buddypress()
	 */
	private function __construct() { /* nothing here */ }

	/**
	 * A dummy magic method to prevent BuddyBoss Wall from being cloned.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function __clone() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'buddyboss-wall' ), '1.7' ); }

	/**
	 * A dummy magic method to prevent BuddyBoss Wall from being unserialized.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function __wakeup() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'buddyboss-wall' ), '1.7' ); }

	/**
	 * Magic method for checking the existence of a certain custom field.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function __isset( $key ) { return isset( $this->data[$key] ); }

	/**
	 * Magic method for getting BuddyBoss Wall varibles.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function __get( $key ) { return isset( $this->data[$key] ) ? $this->data[$key] : null; }

	/**
	 * Magic method for setting BuddyBoss Wall varibles.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function __set( $key, $value ) { $this->data[$key] = $value; }

	/**
	 * Magic method for unsetting BuddyBoss Wall variables.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function __unset( $key ) { if ( isset( $this->data[$key] ) ) unset( $this->data[$key] ); }

	/**
	 * Magic method to prevent notices and errors from invalid method calls.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 */
	public function __call( $name = '', $args = array() ) { unset( $name, $args ); return null; }

	/* Plugin Specific, Setup Globals, Actions, Includes
	 * ===================================================================
	 */

	/**
	 * Setup BuddyBoss Wall plugin global variables.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 * @access private
	 *
	 * @uses plugin_dir_path() To generate BuddyBoss Wall plugin path.
	 * @uses plugin_dir_url() To generate BuddyBoss Wall plugin url.
	 * @uses apply_filters() Calls various filters.
	 */
	private function setup_globals( $args = array() )
	{
		$this->network_activated = $this->is_network_activated();
		
		global $buddyboss_wall;
		
		$saved_options = $this->network_activated ?  get_site_option( 'buddyboss_wall_plugin_options' ) : get_option( 'buddyboss_wall_plugin_options' );
		$saved_options = maybe_unserialize( $saved_options );

		$this->options = wp_parse_args( $saved_options, $this->default_options );

		// Normalize legacy uppercase keys
		foreach( $this->options as $key => $option )
		{
			// Delete old entry
			unset( $this->options[$key] );

			// Override w/ lowercase key
			$this->options[ strtolower( $key) ] = $option;
		}

		/** Versions **************************************************/

		$this->version    = BUDDYBOSS_WALL_PLUGIN_VERSION;
		$this->db_version = BUDDYBOSS_WALL_PLUGIN_DB_VERSION;

		/** Paths ******************************************************/

		// BuddyBoss Wall root directory
		$this->file           = BUDDYBOSS_WALL_PLUGIN_FILE;
		$this->basename       = plugin_basename( $this->file );
		$this->plugin_dir     = BUDDYBOSS_WALL_PLUGIN_DIR;
		$this->plugin_url     = BUDDYBOSS_WALL_PLUGIN_URL;

		// Languages
		$this->lang_dir      = dirname( $this->basename ) . '/languages/';

		// Includes
		$this->includes_dir   = $this->plugin_dir . 'includes';
		$this->includes_url   = $this->plugin_url . 'includes';

		// Templates
		$this->templates_dir = $this->plugin_dir . 'templates';
		$this->templates_url = $this->plugin_url . 'templates';

		// Assets
		$this->assets_dir     = $this->plugin_dir . 'assets';
		$this->assets_url     = $this->plugin_url . 'assets';
	}

	/**
	 * Check if the plugin is activated network wide(in multisite)
	 * 
	 * @since 1.1.0
	 * @access private
	 * 
	 * @return boolean
	 */
   private function is_network_activated(){
	   $network_activated = false;
	   if ( is_multisite() ) {
		   if ( ! function_exists( 'is_plugin_active_for_network' ) )
			   require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		   if( is_plugin_active_for_network( basename( constant( 'BUDDYBOSS_WALL_PLUGIN_DIR' ) ).'/buddyboss-wall.php' ) ){
			   $network_activated = true;
		   }
	   }
	   return $network_activated;
   }
	
	/**
	 * Setup BuddyBoss Wall main actions
	 *
	 * @since  BuddyBoss Wall 1.0
	 */
	private function setup_actions()
	{
        // Admin
        add_action( 'init', array( $this, 'setup_admin_settings' ) );

		if ( ! $this->is_enabled() )
			return;

		// Hook into BuddyPress init
		add_action( 'bp_init', array( $this, 'bp_loaded' ),4 );
			
	}

    public function setup_admin_settings(){
        if ( ( is_admin() || is_network_admin() ) && current_user_can( 'manage_options' ) )
        {
            $this->load_admin();
        }
    }

	/**
	 * Load plugin text domain
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses sprintf() Format .mo file
	 * @uses get_locale() Get language
	 * @uses file_exists() Check for language file(filename)
	 * @uses load_textdomain() Load language file
	 */
	public function setup_textdomain()
	{
		$domain = 'buddyboss-wall';
		$locale = apply_filters('plugin_locale', get_locale(), $domain);

		//first try to load from wp-content/languages/plugins/ directory
		load_textdomain($domain, WP_LANG_DIR.'/plugins/'.$domain.'-'.$locale.'.mo');
		
		//if not found, then load from buddboss-wall/languages/ directory
		load_plugin_textdomain( 'buddyboss-wall', false, $this->lang_dir );
	}

	/**
	 * We require BuddyPress to run the main components, so we attach
	 * to the 'bp_loaded' action which BuddyPress calls after it's started
	 * up. This ensures any BuddyPress related code is only loaded
	 * when BuddyPress is active.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 * @access public
	 *
	 * @return void
	 */
	public function bp_loaded()
	{
		global $bp;

		$this->bp_enabled = true;

		$this->check_legacy();

		// Detect legacy wall versions
		if ( $this->is_legacy )
		{
			// Show notice if user hasn't disabled it
			if ( $this->option( 'notices_legacy' ) !== false )
			{
				add_action( 'admin_notices', array( $this, 'legacy_admin_notice' ) );
			}

			// Bail when legacy
			return;
		}

		$this->load_main();
		
		//Image size for url preview
		add_image_size( 'bbwall-url-preview-thumb', 200, 100, true );
	}

	/* Load
	 * ===================================================================
	 */

	/**
	 * Include required admin files.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 * @access private
	 *
	 * @uses $this->do_includes() Loads array of files in the include folder
	 */
	public function load_admin()
	{
		$this->do_includes( $this->admin_includes );

		$this->admin = BuddyBoss_Wall_Admin::instance();
	}

	/**
	 * Include required files.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 * @access private
	 *
	 * @uses BuddyBoss_Wall_Plugin::do_includes() Loads array of files in the include folder
	 */
	private function load_main()
	{
		$this->do_includes( $this->bp_includes );

		$this->component = new BuddyBoss_Wall_BP_Component();
		//Override activity component notification callback
		//buddypress()->activity->notification_callback = 'buddyboss_wall_notification_callback';
	}

	/* Activate/Deactivation/Uninstall callbacks
	 * ===================================================================
	 */

	/**
	 * Fires when plugin is activated
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses current_user_can() Checks for user permissions
	 * @uses check_admin_referer() Verifies session
	 */
	public function activate()
	{
    if ( ! current_user_can( 'activate_plugins' ) )
    {
    	return;
    }

    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';

    check_admin_referer( "activate-plugin_{$plugin}" );
  }

	/**
	 * Fires when plugin is de-activated
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses current_user_can() Checks for user permissions
	 * @uses check_admin_referer() Verifies session
	 */
	public function deactivate()
	{
    if ( ! current_user_can( 'activate_plugins' ) )
    {
    	return;
    }

		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';

		check_admin_referer( "deactivate-plugin_{$plugin}" );
	}

	/**
	 * Fires when plugin is uninstalled
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses current_user_can() Checks for user permissions
	 * @uses check_admin_referer() Verifies session
	 */
	public function uninstall()
	{
    if ( ! current_user_can( 'activate_plugins' ) )
    {
    	return;
    }

    check_admin_referer( 'bulk-plugins' );

    // Important: Check if the file is the one
    // that was registered during the uninstall hook.
    if ( $this->file != WP_UNINSTALL_PLUGIN )
    {
    	return;
    }
	}

	/* Utility functions
	 * ===================================================================
	 */

	/**
	 * Include required array of files in the includes directory
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses require_once() Loads include file
	 */
	public function do_includes( $includes = array() )
	{
		foreach( (array)$includes as $include )
		{
			require_once( $this->includes_dir . '/' . $include . '.php' );
		}
	}

	/**
	 * Check if the plugin is active and enabled in the plugin's admin options.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses BuddyBoss_Media_Plugin::option() Get plugin option
	 *
	 * @return boolean True when the plugin is active
	 */
	public function is_enabled()
	{
		$is_enabled = $this->option( 'enabled' ) === true || $this->option( 'enabled' ) === 'on';

		return $is_enabled;
	}

    /**
     * Check if wall privacy is active and enabled in the plugin's admin options.
     *
     * @since BuddyBoss Wall (1.0.0)
     *
     * @uses BuddyBoss_Media_Plugin::option() Get plugin option
     *
     * @return boolean True when the plugin is active
     */
    public function is_wall_privacy_enabled()
    {
        $is_wall_privacy_enabled = $this->option( 'enabled-wall-privacy' ) === true || $this->option( 'enabled-wall-privacy' ) === 'on';

        return $is_wall_privacy_enabled;
    }

	/**
	 * Convenience function to access plugin options, returns false by default
	 *
	 * @since  BuddyBoss Wall (1.0.0)
	 *
	 * @param  string $key Option key

	 * @uses apply_filters() Filters option values with 'buddyboss_wall_option' &
	 *                       'buddyboss_wall_option_{$option_name}'
	 * @uses sprintf() Sanitizes option specific filter
	 *
	 * @return mixed Option value (false if none/default)
	 *
	 */
	public function option( $key )
	{
		$key    = strtolower( $key );
		$option = isset( $this->options[$key] )
		        ? $this->options[$key]
		        : null;

		// Apply filters on options as they're called for maximum
		// flexibility. Options are are also run through a filter on
		// class instatiation/load.
		// ------------------------

		// This filter is run for every option
		$option = apply_filters( 'buddyboss_wall_option', $option );

		// Option specific filter name is converted to lowercase
		$filter_name = sprintf( 'buddyboss_wall_option_%s', strtolower( $key  ) );
		$option = apply_filters( $filter_name,  $option );

		return $option;
	}

	/**
	 * Check for older versions of BuddyBoss theme where the Wall and Photos
	 * plugin were packaged in the theme.
	 *
	 * @since BuddyBoss Wall (1.0.0)
	 *
	 * @uses apply_filters() Filters $legacy boolean with 'buddyboss_pics_is_legacy'
	 *
	 * @return boolean True when a "packaged" legacy version of the wall/media
	 *                 plugin exists
	 */
	public function check_legacy()
	{
		$is_legacy = false;

		if ( is_admin() && isset( $_GET['disable_wall_legacy_notice'] ) )
		{
			$this->options['notices_legacy'] = false;
			update_option( 'buddyboss_wall_plugin_options', $this->options );
		}

		if ( file_exists( get_template_directory() . '/buddyboss-inc/buddyboss-pics/buddyboss-pics-loader.php' ) )
		{
			$is_legacy = true;
		}
		else if ( file_exists( get_stylesheet_directory() . '/buddyboss-inc/buddyboss-pics/buddyboss-pics-loader.php' ) )
		{
			$is_legacy = true;
		}

		$is_legacy = $this->is_legacy = apply_filters( 'buddyboss_media_is_legacy', $is_legacy );

		return (bool)$is_legacy;
	}

	/**
	 * Legacy admin notice
	 *
	 * @return [type] [description]
	 */
	public function legacy_admin_notice()
	{
    ?>
    <div class="updated">
	    <p><?php _e( 'To use the <strong>BuddyBoss Wall</strong> plugin, please manually update your BuddyBoss theme to version 4.0 or above first. <a href="https://www.buddyboss.com/upgrading-to-buddyboss-4-0/">Read how &rarr;</a>', 'buddyboss-wall' ); ?></p>
	    <p class="submit"><a href="<?php echo esc_url(add_query_arg('disable_wall_legacy_notice', 'true', admin_url('options-general.php?page=buddyboss-wall/includes/admin.php') )); ?>" class="button-primary"><?php _e( 'Disable Notice', 'buddyboss-wall' ); ?></a></p>
    </div>
    <?php
	}

	/**
	 * Show relevant notices
	 *
	 * @since 2.3
	 */
	public function show_notices() {

			echo '<div class="error">';
			echo '<p>' . sprintf( __( 'Hey! BuddyBoss Wall requires activity component to be enabled. Please enable it in your <a href="%s">BuddyPress Settings</a>.', 'buddyboss-wall' ), admin_url( 'admin.php?page=bp-components' ) ) . '</p>';
			echo '</div>';
	}

	}
// End class BuddyBoss_Wall_Plugin

endif;

?>