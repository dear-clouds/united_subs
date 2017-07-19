<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Woffice Members Map', 'woffice' );
$manifest['description'] = __( 'Enables the possibility to add a map of Buddypress members in Woffice. (See documentation for detailed informations).', 'woffice' );
$manifest['version'] = '2.0.0';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/woffice-map/static/img/thumbnails/map.jpg';
