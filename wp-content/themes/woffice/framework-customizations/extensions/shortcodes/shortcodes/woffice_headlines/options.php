<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'title'    => array(
		'type'  => 'text',
		'label' => __( 'Title', 'woffice' ),
		'desc'  => __( 'Write the heading title content.', 'woffice' ),
	),
	'heading' => array(
		'type'    => 'select',
		'label'   => __('Heading Size', 'woffice'),
		'choices' => array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		)
	)
);
