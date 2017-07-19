<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'content'  => array(
		'label' => __( 'Content', 'woffice' ),
		'type'  => 'wp-editor',
		'tinymce' => true,
		'media_buttons' => true,
		'desc'  => __( 'This is the content of the container.', 'woffice' ),
	),
);