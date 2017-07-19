<?php
/*
 *	Based on the work of Henrik Melin and Kal Ström's "More Fields", "More Types" and "More Taxonomies" plugins.
 *	http://more-plugins.se/
*/

// Reset
if (0) update_option('sidebar_settings', array());

// Settings
$fields = array(
		'var' => array(),
		'array' => array()
);
$default = array();

$settings = array(
	'name' => 'Sidebars &amp; Top Tabs', 
	'option_key' => $shortname.'sidebar_settings',
	'fields' => $fields,
	'default' => $default,
	'parent_menu' => 'appearance',
	//'menu_permissions' => 5,
	'file' => __FILE__
);

// Required components
include('object.php');

$sidebar_settings = new sidebar_settings_object($settings);

// Load admin components
if (is_admin()) {	
	include('settings-object.php');
	$sidebar_admin = new sidebar_admin_object($settings);
}

?>
