<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
global $wp_roles;
$tt_roles = array();
foreach ($wp_roles->roles as $key=>$value){
$tt_roles[$key] = $value['name']; }
$tt_roles_tmp = array('all' => __("All Users","woffice")) + $tt_roles;

$options = array(
	'role'  => array(
	    'type'  => 'select',
	    'value' => 'all',
	    'label' => __('Select members type', 'woffice'),
	    'choices' => $tt_roles_tmp,
	),
);