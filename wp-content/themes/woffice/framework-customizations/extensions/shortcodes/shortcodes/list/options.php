<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'style'  => array(
	    'type'  => 'select',
	    'value' => 'list-check',
	    'label' => __('List style', 'woffice'),
	    'desc'  => __('This is the icon at the beginning.', 'woffice'),
	    'choices' => array(
	        'list-check' => 'Check',
	        'list-circle' => 'Circle',
	        'list-square' => 'Square',
	        'list-star' => 'Star',
	    ),
	),
	'content' => array(
	    'type'  => 'addable-option',
	    'value' => array('Item 1', 'Item 2', 'Item 3'),
	    'label' => __('List Items', 'woffice'),
	    'option' => array( 'type' => 'text' ),
	)
);