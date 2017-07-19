<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'type' => array(
	    'type'  => 'select',
	    'label' => __('Type of Trello element', 'woffice'),
	    'desc'  => __('You need to have installed before the Plugin WP Trello.', 'woffice'),
	    'choices' => array(
	    	'organizations' => 'Organizations',
	    	'boards' => 'Boards',
	    	'lists' => 'Lists',
	    	'cards' => 'Cards',
	    	'card' => 'Card',
	    ),
	),
	'trello_id' => array(
	    'type'  => 'text',
	    'label' => __('ID', 'woffice'),
	    'desc'  => __('The ID of the element, you can find it in the URL or in Settings -> WP TRELLO -> API Helper', 'woffice'),
	),
	'link'    => array(
		'label' => __( 'Link ?', 'woffice' ),
		'type'         => 'switch',
		'right-choice' => array(
			'value' => 'yes',
			'label' => __( 'Yep', 'woffice' )
		),
		'left-choice'  => array(
			'value' => 'no',
			'label' => __( 'Nope', 'woffice' )
		),
		'value'        => 'nope',
		'desc' => __('Display as a link to Trello.','woffice'),
	)
);