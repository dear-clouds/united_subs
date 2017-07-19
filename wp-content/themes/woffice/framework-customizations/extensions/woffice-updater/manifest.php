<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Woffice Updater', 'woffice' );
$manifest['description'] = __( 'Auto Update your theme with the latest release, just by entering your purchase code.', 'woffice' );
$manifest['version'] = '2.0.0';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/woffice-updater/static/img/thumbnails/updater.jpg';
