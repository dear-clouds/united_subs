<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */
 
/* Roles array ready for options */
global $wp_roles;
$tt_roles = array();
foreach ($wp_roles->roles as $key=>$value){
$tt_roles[$key] = $value['name']; }
$tt_roles_tmp = array('nope' => __("Everyone","woffice")) + $tt_roles;
/* End */

$options = array(
	'page-box' => array(
		'title'   => __( 'Wiki settings ', 'woffice' ),
		'type'    => 'box',
		'options' => array(
			'exclude_roles' => array(
			    'type'  => 'select-multiple',
			    'label' => __('Exclude Roles', 'woffice'),
				'help'  => __('Help tip : Hold Ctrl to select multiple roles.', 'woffice'),
			    'desc'  => __('The excluded roles will not be able to see that wiki article, they will receive an error message instead. ', 'woffice'),
			    'choices' => $tt_roles_tmp
			),
			'everyone_edit'    => array(
				'label'       => __( 'Everyone can edit ?', 'woffice' ),
				'desc'       => __( 'If it is not checked only the admin and the post author will be able to edit (from the frontend).', 'woffice' ),
				'type'        => 'checkbox',
				'value' => false
			),
            'featured_wiki'    => array(
                'label'       => __( 'This is a featured wiki', 'woffice' ),
                'desc'       => __( 'This will display a star before the wiki name, in the listing.', 'woffice' ),
                'type'        => 'checkbox',
                'value' => false
            ),
		)
	),
);
