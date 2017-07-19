<?php
/*
Plugin Name: BuddyPress Group TinyChat
Plugin URI: http://wordpress.org/extend/plugins/bp-group-tinychat/
Description: This plugins create a tiny chatroom for your group members. Check out our Pro-version.
Version: 1.4
Requires at least: WordPress 3.1.0, BuddyPress 1.2.8
Tested up to: WordPress 3.9.1, BuddyPress 2.0
License: AGPL
Author: Van dat
Author URI: http://wp-plugins.seedceo.com
*/

/* Only load the component if BuddyPress is loaded and initialized. */
function bp_group_tinychat_init() {
	require( dirname( __FILE__ ) . '/includes/bp-group-tinychat-core.php' );
}
add_action( 'bp_init', 'bp_group_tinychat_init' );

// create the tables
function bp_group_tinychat_activate() {
	global $wpdb;

	if ( !empty($wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

	$sql[] = "CREATE TABLE {$wpdb->base_prefix}bp_group_tinychat (
		  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  		group_id bigint(20) NOT NULL,
		  		user_id bigint(20) NOT NULL,
		  		message_content text
		 	   ) {$charset_collate};";

	$sql[] = "CREATE TABLE {$wpdb->base_prefix}bp_group_tinychat_online (
		  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  		group_id bigint(20) NOT NULL,
		  		user_id bigint(20) NOT NULL,
		  		timestamp int(11) NOT NULL
		 	   ) {$charset_collate};";

	require_once( ABSPATH . 'wp-admin/upgrade-functions.php' );

	dbDelta($sql);

	update_site_option( 'bp-group-tinychat-db-version', BP_GROUP_tinychat_DB_VERSION );
}
register_activation_hook( __FILE__, 'bp_group_tinychat_activate' );

?>