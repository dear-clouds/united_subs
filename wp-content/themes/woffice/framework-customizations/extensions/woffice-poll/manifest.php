<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Woffice Poll', 'woffice' );
$manifest['description'] = __( 'Enables the possibility to add a poll widget in Woffice. (See documentation for detailed informations).', 'woffice' );
$manifest['version'] = '1.0.1';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/woffice-poll/static/img/thumbnails/poll.jpg';
