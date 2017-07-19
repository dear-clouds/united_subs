<?php

/*
Plugin Name: BadgeOS BuddyPress Notifier
Plugin URI: http://wordpress.org/
Description: Sends on-site notifications to BuddyPress when a BadgeOS achievement is achieved
Version: 1.0
Requires at least: 3.4.2
Tested up to: 3.9.1
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Rikkouri
Author URI: http://wordpress.org/
*/

// Where am I?
$plugin_dir = ! empty( $network_plugin ) ? $network_plugin : $plugin;

// Set symlink friendly dir constant
define( 'BP_BADGE_NOTIFIER_PLUGIN_DIR', dirname( $plugin_dir ) );

/**
 * Initiates this plugin by setting up the buddypress notifier component.
 * @return void
 */
function bp_badge_notifier_init() {
	if( version_compare( BP_VERSION, '1.3', '>' ) ) {
		// Buddypress component that handles the notifications
		require_once( dirname( __FILE__ ) . '/includes/notifier.php' );
		BP_Badge_Notifier::__setup();
	}
}

// Setup component with bp_setup_components action
add_action( 'bp_setup_components', 'bp_badge_notifier_init' );

/**
 * Adds forum notifier component to the active components list.
 * This is a must do if we want the notifications to work.
 * @param array $components alread activated components
 * @return array
 */
function bp_badge_notifier_add_active_component( $components ) {
	return array_merge( $components, array( 'badge_notifier' => true ) );
}

// Setup active components with bp_active_components filter
add_filter( 'bp_active_components', 'bp_badge_notifier_add_active_component' );
