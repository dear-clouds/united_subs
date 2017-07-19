<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'number'  => array(
	    'type'  => 'select',
	    'value' => 5,
	    'label' => __('Number of posts', 'woffice'),
	    'choices' => array(1,2,3,4,5,6,7,8,9,10,20),
	),
	'excerpt'  => array(
		'type'  => 'checkbox',
		'value' => true,
		'label' => __('Show posts excerpt', 'woffice'),
	),
);