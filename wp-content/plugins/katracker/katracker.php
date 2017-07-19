<?php
/**
 * Plugin Name: KaTracker
 * Plugin URI: kateam.org/tracker
 * Description: The only full and all powerful, complete bittorrent tracker integration for wordpress.
 * Author: nicoco
 * Version: 1.0.9
 * Author URI: kateam.org
 * License: GPL2
 * Text Domain: katracker
 * Domain Path: /languages/
 */

// Include dependencies ////////////////////////////////////////////////////////////////////////////

// Helper Functions and Constatns
require_once plugin_dir_path( __FILE__ ) . 'functions.php';
require_once plugin_dir_path( __FILE__ ) . 'constants.php';

// Setup Activation Hooks //////////////////////////////////////////////////////////////////////////
register_activation_hook( __FILE__, function () {
	wp_schedule_event( time(), 'hourly', 'katracker_clean_idle' );

	// Only run on first activation
	if ( !get_katracker_option( 'init' ) ) {
		katracker_db_init();
		katracker_settings_init();
		katracker_install_torrents_meta();
	}
} );

register_deactivation_hook( __FILE__, function () {
	wp_clear_scheduled_hook('katracker_clean_idle');
} );


// Sets the cleaner action for the tracker
add_action( 'katracker_clean_idle', function () {
	// include wordpress database
	global $wpdb;
	$wpdb->query(
		// delete peers that have been idle too long
		"DELETE FROM `" . KATRACKER_DB_PREFIX . "peers` WHERE updated < " .
		// idle length is announce interval x 2
		( time() - ( get_katracker_option( 'announce-interval' ) * 60 * 2 ) )
	);
} );

// Setup Tracker File Loading //////////////////////////////////////////////////////////////////////
add_action( 'plugins_loaded', function () {
	if ( get_katracker_option( 'active' ) && $katracker_slug = get_katracker_option( 'slug' ) ){
		$current = array();
		if ( get_option( 'permalink_structure' ) ) {
			$current['url'] = explode( '/', preg_replace( '/\/{0,}$/', '', strtok( $_SERVER['REQUEST_URI'], '?' ) ) );
			$current['page'] = preg_replace( array( '/\.php.*/', '/\?.*\=.*/' ),
			                   array( '', '' ),
			                   end( $current['url'] ) );
			$current['pagename'] = get_katracker_option( 'subdomain' ) ?
			                       explode( '.', $_SERVER['HTTP_HOST'] )[0] :
			                       prev( $current['url'] );
		} else {
			$current['page']     = isset( $_GET['page'] )     ? sanitize_text_field( $_GET['page'] )     : false;
			$current['pagename'] = isset( $_GET['pagename'] ) ? sanitize_text_field( $_GET['pagename'] ) : false;
		}
		if ( $current['pagename'] == $katracker_slug ) {
			if ( $current['page'] ) {
				foreach ( glob( plugin_dir_path( __FILE__ ) . 'tracker/tracker-*.php' ) as $tracker_page ) {
					if ( $current['page'] == preg_replace( array( '/^tracker-/', '/\.php/' ),
					                                       array( '', '' ) ,
					                                       basename( $tracker_page ) ) ) {
						require_once $tracker_page;
						break;
					}
				}
			}
			add_action( 'parse_request', function ( $query ) {
				unset( $query->query_vars );
				$query->query_vars['pagename'] = get_katracker_option( 'slug' );
				return $query;
			} );
		}
	}
	unset( $current, $katracker_slug );

	katracker_load_text_domain();

	// Check if there is a tracker page, and set it's link according to the main tracker link
	add_filter( 'page_link', function ( $link, $id ) {
		return ( get_post( $id )->post_name == get_katracker_option( 'slug' ) ) ? KATRACKER_URL : $link;
	}, 10, 2 );

// Include Wordpress related UI and framework //////////////////////////////////////////////////////

	// Torrent file related actions
	require_once plugin_dir_path( __FILE__ ) . 'torrent/torrent-init.php';
	require_once plugin_dir_path( __FILE__ ) . 'torrent/torrent-category.php';

	// Admin UI
	if ( is_admin() ) {
		require_once plugin_dir_path( __FILE__ ) . 'admin/admin-page.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/media-list.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/media-button.php';
		require_once plugin_dir_path( __FILE__ ) . 'torrent/torrent-media.php';
		
		// Add settings link to the plugin description
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), function( $links ) {
			$links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=katracker') ) .'">' . __( 'Settings' ) . '</a>';
			return $links;
		} );
	}

	// Shortcode and Widgets
	require_once plugin_dir_path( __FILE__ ) . 'widget/widget.php';
	require_once plugin_dir_path( __FILE__ ) . 'shortcode/shortcode.php';
} );

?>
