<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * LOAD THE JAVASCRIPT FOR THE WIKI
 */
if ( !is_admin() ) {

	$ext_instance = fw()->extensions->get( 'woffice-wiki' );

	// LOAD PROJECTS SCRIPTS
	wp_enqueue_script(
		'fw-projects',
		$ext_instance->get_declared_URI( '/static/js/wiki.js' ),
		array( 'jquery' ),
		'1.0',
		true
	);
	
}