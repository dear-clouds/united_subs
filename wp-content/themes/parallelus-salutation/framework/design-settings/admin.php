<?php

global $design_admin, $design_settings;

//  __d($_POST);

//	echo '<pre>Post:';
//	print_r($_POST);
//	echo '</pre>';
//
//	echo '<pre>Keys:';
//	print_r($design_admin->keys);
//	echo '</pre>';	


$required = '<em class="required">' . __('Required', THEME_NAME) . '</em>';
$_data = $design_admin->data;



switch ($design_admin->navigation) {

	default:
	
		require_once('admin-home.php');
	
}  

//	echo '<pre>';
//	print_r($design_admin->data);
//	echo '</pre>';
//
//	echo '<pre>';
//	print_r($design_admin->default);
//	echo '</pre>';
?>