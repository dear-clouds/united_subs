<?php

// Uninstall Triggers and Actions //////////////////////////////////////////////////////////////////

// Helper Functions and Constatns
require_once plugin_dir_path( __FILE__ ) . 'functions.php';
require_once plugin_dir_path( __FILE__ ) . 'constants.php';

// If uninstall is called from WordPress, performe full uninstall.
if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) katracker_uninstall( 'full' );

?>
