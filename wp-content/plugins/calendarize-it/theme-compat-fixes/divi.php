<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
function rhc_divi_theme_meta_fields($arr){
	return array_merge($arr,array(
		"_wp_page_template",
		"_et_pb_page_layout"
	));
}
add_filter('rhc_theme_meta_fields','rhc_divi_theme_meta_fields',10,1);

function divi_rhc_theme_fix_get_queried_object($hook){
	$hook = 'template_redirect';
	return $hook;
}
add_filter('rhc_theme_fix_get_queried_object', 'divi_rhc_theme_fix_get_queried_object', 10, 1);
?>