<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'build' => array(
		'type'    => 'tab',
		'title'   => __( 'Cover Options', 'woffice' ),
		'options' => array(
			'funfacts-box' => array(
				'title'   => __( 'Default Cover Options', 'woffice' ),
				'type'    => 'box',
				'options' => array(
					'cover_default' => array(
					    'type'  => 'upload',
					    'label' => __('Default Cover', 'woffice'),
					    'desc' => __('It is an optional option, it\'s not required', 'woffice'),
					    'images_only' => true,
					)
				)
			)
		)
	),
);