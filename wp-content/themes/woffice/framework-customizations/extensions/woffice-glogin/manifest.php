<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Woffice Social Login', 'woffice' );
$manifest['description'] = __( 'Enables the possibility to login with your Google & Facebook Account. (See documentation for detailed informations).', 'woffice' );
$manifest['version'] = '1.0.0';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/woffice-glogin/static/img/thumbnails/glogin.jpg';
