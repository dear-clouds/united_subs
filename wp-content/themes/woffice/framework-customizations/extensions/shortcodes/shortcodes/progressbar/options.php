<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
    'progress'  => array(
	    'type'  => 'slider',
	    'value' => 50,
	    'properties' => array(
	        'min' => 0,
	        'max' => 100,
	        'sep' => 1,
	    ),
	    'label' => __('Progress', 'woffice'),
	),
    'icon'  => array(
		'label' => __( 'Icon', 'woffice' ),
		'desc'    => __( 'Choose an icon that will be on the progress bar at the beginning.', 'woffice' ),
		'type'  => 'icon',
		'value' => 'fa clock-o'
	)
);