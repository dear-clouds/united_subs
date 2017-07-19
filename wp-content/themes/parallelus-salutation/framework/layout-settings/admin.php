<?php

global $layout_admin, $layout_settings;

//  __d($_POST);

//	echo '<pre>Post:';
//	print_r($_POST);
//	echo '</pre>';
//
//	echo '<pre>Keys:';
//	print_r($layout_admin->keys);
//	echo '</pre>';	


$required = '<em class="required">' . __('Required', THEME_NAME) . '</em>';
$_data = $layout_admin->data;



switch ($layout_admin->navigation) {
case 'page_header':

	require_once('admin-options-header.php');
	break;

case 'page_footer':

	require_once('admin-options-footer.php');
	break;

case 'layout':

	require_once('admin-options-layout.php');
	break;

default:

	require_once('admin-home.php');
	
	require_once('admin-options-defaults.php');
	
}  

//	echo '<pre>';
//	print_r($layout_admin->data);
//	echo '</pre>';
//
//	echo '<pre>';
//	print_r($layout_admin->default);
//	echo '</pre>';
?>