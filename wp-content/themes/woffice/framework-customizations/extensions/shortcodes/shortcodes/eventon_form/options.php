<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'eventon_title'  => array(
		'label' => __( 'Form Header Text', 'woffice' ),
		'type'  => 'text',
	),
	'eventon_subtitle'  => array(
		'label' => __( 'Form Subheader Text', 'woffice' ),
		'type'  => 'text',
	),
    'eventon_msub' => array(
        'type'  => 'checkbox',
		'label'   => __( 'Allow multiple submissions w/o page refresh', 'woffice' ),
	    'value' => 'false'
    ),
);