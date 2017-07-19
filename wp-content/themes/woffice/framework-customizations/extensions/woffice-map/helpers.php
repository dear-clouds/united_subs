<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Returns the MAP HTML
 */
function woffice_get_members_map() {
	return fw()->extensions->get( 'woffice-map' )->render( 'view' );
}