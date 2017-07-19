<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'title'  => array(
		'label' => __( 'Title', 'woffice' ),
		'desc'  => __( 'This is the title of the box.', 'woffice' ),
		'type'  => 'text',
	),
	'content'  => array(
		'label' => __( 'Content', 'woffice' ),
		'type'  => 'wp-editor',
		'tinymce' => false,
		'media_buttons' => false,
		'desc'  => __( 'This is the content of the box.', 'woffice' ),
	),
	'icon'                      => array(
		'label' => __( 'Icon', 'woffice' ),
		'type'  => 'icon',
		'desc'  => __( 'The icon will be displayed in the background with a small opacity', 'woffice' ),
		'value' => 'fa fa-group',
	),
	'color'        => array(
		'label' => __( 'Background color', 'woffice' ),
		'type'  => 'color-picker',
		'desc'  => __( 'The background of the box, remember that the white color should come out.', 'woffice' ),
		'value' => '#d05c3d'
	),
);