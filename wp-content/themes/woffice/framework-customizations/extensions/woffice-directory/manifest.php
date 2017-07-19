<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Woffice Directory', 'woffice' );
$manifest['description'] = __( 'Enables the possibility to add a complete directory page to your site for Jobs, Partners...', 'woffice' );
$manifest['version'] = '1.5.0';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/woffice-directory/static/img/thumbnails/directory.jpg';
