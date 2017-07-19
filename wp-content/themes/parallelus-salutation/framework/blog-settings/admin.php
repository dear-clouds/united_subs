<?php

global $blog_admin, $blog_settings;

//  __d($_POST);

//	echo '<pre>Post:';
//	print_r($_POST);
//	echo '</pre>';
//
//	echo '<pre>Keys:';
//	print_r($blog_admin->keys);
//	echo '</pre>';	


$required = '<em class="required">' . __('Required', THEME_NAME) . '</em>';
$_data = $blog_admin->data;



switch ($blog_admin->navigation) {

	default:
	
		require_once('admin-home.php');
	
}  

//	echo '<pre>';
//	print_r($blog_admin->data);
//	echo '</pre>';
//
//	echo '<pre>';
//	print_r($blog_admin->default);
//	echo '</pre>';
?>