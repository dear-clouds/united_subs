<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
function rhc_enfold_theme_meta_fields($arr){
	return array_merge($arr,array(
		'above-sidebar',
		'below-sidebar',
		'content-with-sidebar',
		'footer',
		'header_title_bar',
		'header_transparency',
		'layout',
		'post-option',
		'sidebar'
	));
}
add_filter('rhc_theme_meta_fields','rhc_enfold_theme_meta_fields',10,1)

?>