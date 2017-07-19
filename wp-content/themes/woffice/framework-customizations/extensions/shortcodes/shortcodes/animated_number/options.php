<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'number'  => array(
	    'type'  => 'text',
	    'value' => '100',
	    'label' => __('The animated number', 'woffice'),
	    'desc'  => __('Only number please or it will not work.', 'woffice'),
	),
	'title'  => array(
	    'type'  => 'text',
	    'value' => 'Title',
	    'label' => __('Title under', 'woffice')
	)
);