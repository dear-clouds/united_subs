<?php
/*
Plugin Name: Cookie Law Info
Plugin URI: http://wordpress.org/extend/plugins/cookie-law-info/description/
Description: A simple way of 'implied consent' to show your website complies with the EU Cookie Law, which came into force on 26 May 2012.
Author: Richard Ashby
Author URI: http://cookielawinfo.com/
Version: 1.5.3
License: GPL2
*/

/*	
	Copyright 2012  Richard Ashby  (email : wordpress@mediacreek.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



// Failsafe setting (will catch any missed debug function calls), switch off ("false") in live:
define ( 'CLI_PLUGIN_DEVELOPMENT_MODE', false );

define ( 'CLI_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define ( 'CLI_PLUGIN_URL', plugins_url() . '/cookie-law-info/');
define ( 'CLI_DB_KEY_PREFIX', 'CookieLawInfo-' );
define ( 'CLI_LATEST_VERSION_NUMBER', '0.9' );
define ( 'CLI_SETTINGS_FIELD', CLI_DB_KEY_PREFIX . CLI_LATEST_VERSION_NUMBER );
define ( 'CLI_MIGRATED_VERSION', CLI_DB_KEY_PREFIX . 'MigratedVersion' );

// Previous version settings (depreciated from 0.9 onwards):
define ( 'CLI_ADMIN_OPTIONS_NAME', 'CookieLawInfo-0.8.3' );


require_once CLI_PLUGIN_PATH . 'php/functions.php';
require_once CLI_PLUGIN_PATH . 'admin/cli-admin.php';
require_once CLI_PLUGIN_PATH . 'admin/cli-admin-page.php';
require_once CLI_PLUGIN_PATH . 'php/shortcodes.php';
require_once CLI_PLUGIN_PATH . 'php/custom-post-types.php';


// General, including script handling and uninstall:
register_activation_hook( __FILE__, 'cookielawinfo_activate' );	
add_action( 'admin_menu', 'cookielawinfo_register_custom_menu_page' );
add_action( 'wp_enqueue_scripts', 'cookielawinfo_enqueue_frontend_scripts' );
add_action( 'wp_footer', 'cookielawinfo_inject_cli_script' );

// Shortcodes:
add_shortcode( 'delete_cookies', 'cookielawinfo_delete_cookies_shortcode' );	// a shortcode [delete_cookies (text="Delete Cookies")]
add_shortcode( 'cookie_audit', 'cookielawinfo_table_shortcode' );				// a shortcode [cookie_audit style="winter"]
add_shortcode( 'cookie_accept', 'cookielawinfo_shortcode_accept_button' );		// a shortcode [cookie_accept (colour="red")]
add_shortcode( 'cookie_link', 'cookielawinfo_shortcode_more_link' );			// a shortcode [cookie_link]
add_shortcode( 'cookie_button', 'cookielawinfo_shortcode_main_button' );		// a shortcode [cookie_button]

// Dashboard styles:
add_action( 'admin_enqueue_scripts', 'cookielawinfo_custom_dashboard_styles' );
add_action( 'admin_enqueue_scripts', 'cookielawinfo_enqueue_color_picker' );
function cookielawinfo_enqueue_color_picker( $hook ) {
    if ( 'cookielawinfo_page_cookie-law-info' != $hook )
        return;
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'cookielawinfo_admin_page_script', plugins_url('admin/cli-admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}


// Cookie Audit custom post type functions:
add_action( 'admin_init', 'cookielawinfo_custom_posts_admin_init' );
add_action( 'init', 'cookielawinfo_register_custom_post_type' );
add_action( 'save_post', 'cookielawinfo_save_custom_metaboxes' );
add_filter( 'manage_edit-cookielawinfo_columns', 'cookielawinfo_edit_columns' );
add_action( 'manage_posts_custom_column',  'cookielawinfo_custom_columns' );


// Add plugin settings link:
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'cookielawinfo_plugin_action_links' );
function cookielawinfo_plugin_action_links( $links ) {
   $links[] = '<a href="'. get_admin_url(null, 'edit.php?post_type=cookielawinfo&page=cookie-law-info') .'">Settings</a>';
   $links[] = '<a href="http://cookielawinfo.com/cookie-law-info-2-0/" target="_blank">Beta 2.0</a>';
   return $links;
}


/** Register the uninstall function */
function cookielawinfo_activate() {
	register_uninstall_hook( __FILE__, 'cookielawinfo_uninstall_plugin' );
}


/** Uninstalls the plugin (removes settings and custom meta) */
function cookielawinfo_uninstall_plugin() {
	// Bye bye settings:
	delete_option( CLI_ADMIN_OPTIONS_NAME );
	delete_option( CLI_MIGRATED_VERSION );
	delete_option( CLI_SETTINGS_FIELD );
	
	// Bye bye custom meta:
	global $post;
	$args = array('post_type' => 'cookielawinfo');
	$cookies = new WP_Query( $args );
	
	if ( !$cookies->have_posts() ) {
		return;
	}
	
	while ( $cookies->have_posts() ) : $cookies->the_post();
		// Get custom fields:
		$custom = get_post_custom( $post->ID );
		// Look for old values. If they exist, move them to new values then delete old values:
		if ( isset ( $custom["cookie_type"][0] ) ) {
			delete_post_meta( $post->ID, "cookie_type", $custom["cookie_type"][0] );
		}
		if ( isset ( $custom["cookie_duration"][0] ) ) {
			delete_post_meta( $post->ID, "cookie_duration", $custom["cookie_duration"][0] );
		}
		if ( isset ( $custom["_cli_cookie_type"][0] ) ) {
			delete_post_meta( $post->ID, "_cli_cookie_type", $custom["_cli_cookie_type"][0] );
		}
		if ( isset ( $custom["_cli_cookie_duration"][0] ) ) {
			delete_post_meta( $post->ID, "_cli_cookie_duration", $custom["_cli_cookie_duration"][0] );
		}
	endwhile;
}


?>