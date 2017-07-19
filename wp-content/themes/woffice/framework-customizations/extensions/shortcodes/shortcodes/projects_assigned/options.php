<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
global $wp_roles;
$tt_users = array();
foreach (get_users(array('fields' => array( 'id', 'user_login', 'display_name' ))) as $key=>$value){
	$tt_users[$value->id] = $value->user_login; }
$tt_users_tmp = array('current' => __("Current User","woffice")) + $tt_users;

$options = array(
	'user'  => array(
	    'type'  => 'select',
	    'value' => 'current',
	    'label' => __('Select member', 'woffice'),
	    'choices' => $tt_users_tmp,
	),
);