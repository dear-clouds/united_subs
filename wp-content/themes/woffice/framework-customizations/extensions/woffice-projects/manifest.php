<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Woffice Projects', 'woffice' );
$manifest['description'] = __( 'Enables the possibility to add a project management to your site.', 'woffice' );
$manifest['version'] = '2.0.0';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/woffice-projects/static/img/thumbnails/projects.jpg';
