<?php
/*
Plugin Name: BuddyPress Activity Privacy
Plugin URI: 
Description: Add the ability for members to choose who can read/see his activities and media files.
Version: 1.3.8
Requires at least:  WP 3.4, BuddyPress 1.5
Tested up to: BuddyPress 1.5, 2.2.1
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Meg@Info
Author URI: http://profiles.wordpress.org/megainfo 
Network: true
Text Domain: bp-activity-privacy
Domain Path: /languages
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*************************************************************************************************************
 --- BuddyPress Activity Privacy 1.3.7 ---
 *************************************************************************************************************/

// Define a constant that can be checked to see if the component is installed or not.
define( 'BP_ACTIVITY_PRIVACY_IS_INSTALLED', 1 );

// Define a constant that will hold the current version number of the component
// This can be useful if you need to run update scripts or do compatibility checks in the future
define( 'BP_ACTIVITY_PRIVACY_VERSION', '1.3.8' );

// Define a constant that we can use to construct file paths throughout the component
define( 'BP_ACTIVITY_PRIVACY_PLUGIN_DIR', dirname( __FILE__ ) );
 
//define ( 'BP_ACTIVITY_PRIVACY_DB_VERSION', '1.0' );

define( 'BP_ACTIVITY_PRIVACY_PLUGIN_FILE_LOADER',  __FILE__ );

// Define a constant that we can use as plugin url
define( 'BP_ACTIVITY_PRIVACY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Define a constant that we can use as plugin basename
define( 'BP_ACTIVITY_PRIVACY_PLUGIN_BASENAME',  plugin_basename( __FILE__ ) );

define( 'BP_ACTIVITY_PRIVACY_PLUGIN_DIR_PATH',  plugin_dir_path( __FILE__ ) );

/**
 * textdomain loader.
 *
 * Checks WP_LANG_DIR for the .mo file first, then the plugin's language folder.
 * Allows for a custom language file other than those packaged with the plugin.
 *
 * @uses load_textdomain() Loads a .mo file into WP
 * @uses load_plugin_textdomain() Loads a .mo file into languages folder on plugin
 */ 
function bp_activity_privacy_load_textdomain() {
	$mofile		= sprintf( 'buddypress-activity-privacy-%s.mo', get_locale() );
	
	$mofile_global	= trailingslashit( WP_LANG_DIR ) . $mofile;
	$mofile_local	= BP_ACTIVITY_PRIVACY_PLUGIN_DIR_PATH . 'languages/' . $mofile;

	if ( is_readable( $mofile_global ) ) {
		return load_textdomain( 'bp-activity-privacy', $mofile_global );
	} elseif ( is_readable( $mofile_local ) ){
		//return load_plugin_textdomain( 'bp-activity-privacy', false, $mofile_local );
		return load_textdomain( 'bp-activity-privacy', $mofile_local );
	}
	else
		return false;
}
add_action( 'plugins_loaded', 'bp_activity_privacy_load_textdomain' );

/**
 * Check the config for multisite
 */
function bp_activity_privacy_check_config() {
	global $bp;

	$config = array(
		'blog_status'    => false, 
		'network_active' => false, 
		'network_status' => true 
	);
	if ( get_current_blog_id() == bp_get_root_blog_id() ) {
		$config['blog_status'] = true;
	}
	
	$network_plugins = get_site_option( 'active_sitewide_plugins', array() );

	// No Network plugins
	if ( empty( $network_plugins ) )

	// Looking for BuddyPress and bp-activity plugin
	$check[] = $bp->basename;
	$check[] = BP_ACTIVITY_PRIVACY_PLUGIN_BASENAME;

	// Are they active on the network ?
	$network_active = array_diff( $check, array_keys( $network_plugins ) );
	
	// If result is 1, your plugin is network activated
	// and not BuddyPress or vice & versa. Config is not ok
	if ( count( $network_active ) == 1 )
		$config['network_status'] = false;

	// We need to know if the plugin is network activated to choose the right
	// notice ( admin or network_admin ) to display the warning message.
	$config['network_active'] = isset( $network_plugins[ BP_ACTIVITY_PRIVACY_PLUGIN_BASENAME ] );

	// if BuddyPress config is different than bp-activity plugin
	if ( !$config['blog_status'] || !$config['network_status'] ) {

		$warnings = array();
		if ( !bp_core_do_network_admin() && !$config['blog_status'] ) {
			$warnings[] = __( 'Buddypress Activity Privacy requires to be activated on the blog where BuddyPress is activated.', 'bp-activity-privacy' );
		}

		if ( bp_core_do_network_admin() && !$config['network_status'] ) {
			$warnings[] = __( 'Buddypress Activity Privacy and BuddyPress need to share the same network configuration.', 'bp-activity-privacy' );
		}

		if ( ! empty( $warnings ) ) :
		?>
		<div id="message" class="error">
			<?php foreach ( $warnings as $warning ) : ?>
				<p><?php echo esc_html( $warning ) ; ?></p>
			<?php endforeach ; ?>
		</div>
		<?php
		endif;

		// Display a warning message in network admin or admin
		add_action( $config['network_active'] ? 'network_admin_notices' : 'admin_notices', $warning );
		
		return false;
	} 
	return true;
}


/* Only load the component if BuddyPress is loaded and initialized. */
function bp_activity_privacy_init() {
	// Because our loader file uses BP_Component, it requires BP 1.5 or greater.
	//if ( version_compare( BP_VERSION, '1.3', '>' ) )
	if ( bp_activity_privacy_check_config() )
		require( dirname( __FILE__ ) . '/includes/bp-activity-privacy-loader.php' );
}
add_action( 'bp_include', 'bp_activity_privacy_init' );

/* Put setup procedures to be run when the plugin is activated in the following function */
function bp_activity_privacy_activate() {
	// check if buddypress is active
	if ( ! defined( 'BP_VERSION' ) ) {
		die( _e( 'You cannot enable BuddyPress Activity Privacy because <strong>BuddyPress</strong> is not active. Please install and activate BuddyPress before trying to activate Buddypress Activity Privacy again.' , 'bp-activity-privacy' ) );
	}

	// Add the transient to redirect
	set_transient( '_bp_activity_privacy_activation_redirect', true, 30 );

	do_action( 'bp_activity_privacy_activation' );
}

register_activation_hook( __FILE__, 'bp_activity_privacy_activate' );

/* On deacativation, clean up anything your component has added. */
function bp_activity_privacy_deactivate() {
	/* You might want to delete any options or tables that your component created. */
	do_action( 'bp_activity_privacy_deactivation' );	
}
register_deactivation_hook( __FILE__, 'bp_activity_privacy_deactivate' );