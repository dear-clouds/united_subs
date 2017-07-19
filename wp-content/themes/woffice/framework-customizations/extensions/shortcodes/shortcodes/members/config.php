<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => __( 'Members', 'woffice' ),
	'description' => __( 'Display avatars of the members with link to their profiles.', 'woffice' ),
	'tab'         => __( 'Content Elements', 'woffice' ),
	'icon' 		  => 'fa fa-users',
);