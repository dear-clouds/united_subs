<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
function rhc_photolux_theme_meta_fields($arr){
	return array_merge($arr,array(
		"_wp_page_template",
		"slider_value",
		"layout_value",
		"sidebar_value",
		"show_title_value",
		"featured_category_value",
		"featured_post_number_value",
		"post_category_value",
		"order_value",
		"show_filter_value",
		"show_info_value",
		"post_number_value",
		"image_width_value",
		"desaturate_value",
		"show_back_btn_end_value",
		"partial_loading_value",
		"img_num_before_load_value",
		"full_bg_value"		
	));
}
add_filter('rhc_theme_meta_fields','rhc_photolux_theme_meta_fields',10,1);

function photolux_rhc_theme_fix_get_queried_object($hook){
	$hook = 'template_redirect';
	return $hook;
}
add_filter('rhc_theme_fix_get_queried_object', 'photolux_rhc_theme_fix_get_queried_object', 10, 1);
?>