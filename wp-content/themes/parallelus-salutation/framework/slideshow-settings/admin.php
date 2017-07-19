<?php

global $slideshow_admin, $slideshow_settings;

//  __d($_POST);

	//echo '<pre>Post:';
	//print_r($_POST);
	//echo '</pre>';

	//echo '<pre>Keys:';
	//print_r($slideshow_admin->keys);
	//echo '</pre>';	


$required = '<em class="required">' . __('Required', THEME_NAME) . '</em>';
$_data = $slideshow_admin->data;


switch ($slideshow_admin->navigation) {
case 'slideshow':
case 'slide':

	require_once('admin-settings.php');
	break;

default:

	require_once('admin-home.php');
	
}  

//	echo '<pre>';
//	print_r($slideshow_admin->data);
//	echo '</pre>';
//
//	echo '<pre>';
//	print_r($slideshow_admin->default);
//	echo '</pre>';
?>