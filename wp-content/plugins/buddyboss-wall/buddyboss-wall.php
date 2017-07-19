<?php
/**
 * Plugin Name: BuddyBoss Wall
 * Plugin URI:  http://buddyboss.com/product/buddyboss-wall/
 * Description: Turns your BuddyPress activity stream into a super interactive "Wall".
 * Author:      BuddyBoss
 * Author URI:  http://buddyboss.com
 * Version:     1.3.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * ========================================================================
 * CONSTANTS
 * ========================================================================
 */

// Codebase version
if ( ! defined( 'BUDDYBOSS_WALL_PLUGIN_VERSION' ) ) {
  define( 'BUDDYBOSS_WALL_PLUGIN_VERSION', '1.3.1' );
}

// Database version
if ( ! defined( 'BUDDYBOSS_WALL_PLUGIN_DB_VERSION' ) ) {
  define( 'BUDDYBOSS_WALL_PLUGIN_DB_VERSION', 1 );
}

// Directory
if ( ! defined( 'BUDDYBOSS_WALL_PLUGIN_DIR' ) ) {
  define( 'BUDDYBOSS_WALL_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Url
if ( ! defined( 'BUDDYBOSS_WALL_PLUGIN_URL' ) ) {
  $plugin_url = plugin_dir_url( __FILE__ );

  // If we're using https, update the protocol. Workaround for WP13941, WP15928, WP19037.
  if ( is_ssl() )
    $plugin_url = str_replace( 'http://', 'https://', $plugin_url );

  define( 'BUDDYBOSS_WALL_PLUGIN_URL', $plugin_url );
}

// File
if ( ! defined( 'BUDDYBOSS_WALL_PLUGIN_FILE' ) ) {
  define( 'BUDDYBOSS_WALL_PLUGIN_FILE', __FILE__ );
}

/**
 * ========================================================================
 * MAIN FUNCTIONS
 * ========================================================================
 */

/**
 * Main
 *
 * @return void
 */
function buddyboss_wall_init()
{
  global $buddyboss_wall;

  if ( ! function_exists('bp_is_active' ) ) {
    add_action('admin_notices','bb_wall_admin_notice');
    return;
  }


  $main_include  = BUDDYBOSS_WALL_PLUGIN_DIR  . 'includes/main-class.php';

  try
  {
    if ( file_exists( $main_include ) )
    {
      require( $main_include );
    }
    else {
      $msg = sprintf( __( "Couldn't load main class at:<br/>%s", 'buddyboss-wall' ), $main_include );
      throw new Exception( $msg, 404 );
    }
  }
  catch( Exception $e )
  {
    $msg = sprintf( __( "<h1>Fatal error:</h1><hr/><pre>%s</pre>", 'buddyboss-wall' ), $e->getMessage() );
    echo $msg;
  }

  $buddyboss_wall = BuddyBoss_Wall_Plugin::instance();
}
add_action( 'plugins_loaded', 'buddyboss_wall_init' );

/**
 * Show admin notice when BuddyPress is not active
 */
function bb_wall_admin_notice() { ?>
  <div class='error'><p>
      <?php _e( 'BuddyBoss Wall needs BuddyPress activated!', 'buddyboss-wall' ); ?>
    </p></div>;
  <?php
}

/**
 * Widgets include
 */
$widgets_include = BUDDYBOSS_WALL_PLUGIN_DIR . 'includes/widgets.php';
if ( file_exists( $widgets_include ) ) {
	require( $widgets_include );

	add_action( 'widgets_init', create_function( '', 'return register_widget("BuddyBoss_Most_Liked_Activity_Widget");' ) );
}

/**
 * Must be called after hook 'plugins_loaded'
 * @return BuddyBoss Wall Plugin main controller object
 */
function buddyboss_wall()
{
  global $buddyboss_wall;

  return $buddyboss_wall;
}

/**
 * Register BuddyBoss Menu Page
 */
if ( !function_exists( 'register_buddyboss_menu_page' ) ) {

	function register_buddyboss_menu_page() {
		// Set position with odd number to avoid confict with other plugin/theme.
		add_menu_page( 'BuddyBoss', 'BuddyBoss', 'manage_options', 'buddyboss-settings', '', BUDDYBOSS_WALL_PLUGIN_URL . 'assets/images/logo.svg', 64.99 );

		// To remove empty parent menu item.
		add_submenu_page( 'buddyboss-settings', 'BuddyBoss', 'BuddyBoss', 'manage_options', 'buddyboss-settings' );
		remove_submenu_page( 'buddyboss-settings', 'buddyboss-settings' );
	}

	add_action( 'admin_menu', 'register_buddyboss_menu_page' );
}

/**
 * Allow automatic updates via the WordPress dashboard
 */
require_once('includes/buddyboss-plugin-updater.php');
new buddyboss_updater_plugin( 'http://update.buddyboss.com/plugin', plugin_basename(__FILE__), 37);
