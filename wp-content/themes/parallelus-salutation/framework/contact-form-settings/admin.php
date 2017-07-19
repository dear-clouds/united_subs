<?php

global $contact_form_admin, $contact_form_settings;

//  __d($_POST);

//	echo '<pre>Post:';
//	print_r($_POST);
//	echo '</pre>';
//
//	echo '<pre>Keys:';
//	print_r($contact_form_admin->keys);
//	echo '</pre>';	
//

$required = '<em class="required">' . __('Required', THEME_NAME) . '</em>';
$_data = $contact_form_admin->data;


switch ($contact_form_admin->navigation) {
case 'contact_field':

	require_once('admin-fields-options.php');
	break;

default:

	require_once('admin-home.php');

	require_once('admin-fields-home.php');
	
}  

//	echo '<pre>';
//	print_r($contact_form_admin->data);
//	echo '</pre>';
//
//	echo '<pre>';
//	print_r($contact_form_admin->default);
//	echo '</pre>';
?>