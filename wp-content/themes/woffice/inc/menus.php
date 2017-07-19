<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Register menus
 */

// This theme uses wp_nav_menu() in two locations.
register_nav_menus( array(
	'primary'   => __( '[Woffice] main menu in the header.', 'woffice' ),
    'woffice_user'      => __( '[Woffice] Dropdown user menu', 'woffice' ),
));

$private = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('private') : ''; 
if ($private != "nope") {
	register_nav_menus( array(
		'public'   => __( '[Woffice] Menu for non-logged users.', 'woffice' ),
	));
} 
else {
	unregister_nav_menu( 'public' );
}
	