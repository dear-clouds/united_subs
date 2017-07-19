<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['name']        = __( 'Woffice FunFacts', 'woffice' );
$manifest['description'] = __( 'Enables the possibility to add a funfacts widget in Woffice. (See documentation for detailed informations).', 'woffice' );
$manifest['version'] = '1.0.0';
$manifest['display'] = true;
$manifest['standalone'] = true;
$manifest['thumbnail'] = fw_get_template_customizations_directory_uri().'/extensions/woffice-funfacts/static/img/thumbnails/funfacts.jpg';
