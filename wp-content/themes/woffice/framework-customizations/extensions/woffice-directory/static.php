<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * LOAD THE JAVASCRIPT FOR THE MAP
 */
if ( !is_admin() ) {

	$ext_instance = fw()->extensions->get( 'woffice-directory' );
	
	if(is_page_template("page-templates/page-directory.php") || is_singular("directory") || is_tax( 'directory-category' )) {
		wp_enqueue_script(
			'fw-extension-'. $ext_instance->get_name() .'-google-map',
			'https://maps.googleapis.com/maps/api/js?key=AIzaSyAyXqXI9qYLIWaD9gLErobDccodaCgHiGs',
			true
		);
	}
	
	// LOAD PROJECTS SCRIPTS
	wp_enqueue_script(
		'fw-directory',
		$ext_instance->get_declared_URI( '/static/js/directory.js' ),
		array( 'jquery' ),
		'1.0',
		true
	);
	
}