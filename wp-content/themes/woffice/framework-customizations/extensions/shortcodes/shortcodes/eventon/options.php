<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'eventon_type' => array(
		'type'  => 'select',
	    'label' => __('Type', 'woffice'),
	    'choices' => array(
	        'calendar' => __('Main Calendar', 'woffice'),
	        'event' => __('Single Event', 'woffice'),
	    ),
	    'value' => 'calendar'
	),
	'eventon_id' => array(
	    'type'  => 'text',
	    'label' => __('Unique ID :', 'woffice'),
	    'desc'  => __('An unique ID for the Main calendar OR an event ID to display it', 'woffice'),
	),
	'eventon_open' => array(
	    'type'  => 'switch',
	    'label' => __('Auto Open event(s)', 'woffice'),
	    'right-choice' => array(
			'value' => 'yep',
			'label' => __( 'Yep', 'woffice' )
		),
		'left-choice'  => array(
			'value' => 'nope',
			'label' => __( 'Nope', 'woffice' )
		),
		'value'        => 'nope',
	),
	'eventon_excerpt' => array(
	    'type'  => 'switch',
	    'label' => __('See event excerpt', 'woffice'),
	    'right-choice' => array(
			'value' => 'yep',
			'label' => __( 'Yep', 'woffice' )
		),
		'left-choice'  => array(
			'value' => 'nope',
			'label' => __( 'Nope', 'woffice' )
		),
		'value'        => 'nope',
	)
	
);