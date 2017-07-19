<?php

global $sidebar_admin, $sidebar_settings;

//  __d($_POST);

//	echo '<pre>Post:';
//	print_r($_POST);
//	echo '</pre>';
//
//	echo '<pre>Keys:';
//	print_r($sidebar_admin->keys);
//	echo '</pre>';	


$required = '<em class="required">' . __('Required', THEME_NAME) . '</em>';
$_data = $sidebar_admin->data;


switch ($sidebar_admin->navigation) {
case 'sidebar':

	require_once('admin-options.php');
	break;

case 'tab':

	require_once('admin-tabs-options.php');
	break;

default:

	require_once('admin-home.php');

	require_once('admin-tabs-home.php');
	
}  

//	echo '<pre>';
//	print_r($sidebar_admin->data);
//	echo '</pre>';
//
//	echo '<pre>';
//	print_r($sidebar_admin->default);
//	echo '</pre>';
?>