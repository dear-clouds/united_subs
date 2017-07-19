<?php
/*
 *	Based on the work of Henrik Melin and Kal Ström's "More Fields", "More Types" and "More Taxonomies" plugins.
 *	http://more-plugins.se/
*/

// Reset
if (0) update_option('slideshow_settings', array());

// Settings
$fields = array(
		'var' => array(),
		'array' => array()
);
$default = array();

$settings = array(
	'name' => 'Slide Shows', 
	'option_key' => $shortname.'slideshow_settings',
	'fields' => $fields,
	'default' => $default,
	'parent_menu' => 'appearance',
	//'menu_permissions' => 5,
	'file' => __FILE__
);

// Required components
include('object.php');

$slideshow_settings = new slideshow_settings_object($settings);

// Load admin components
if (is_admin()) {	
	include('settings-object.php');
	$slideshow_admin = new slideshow_admin_object($settings);
}

?>
