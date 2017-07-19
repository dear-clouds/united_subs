<?php
/*
 *	Based on the work of Henrik Melin and Kal Ström's "More Fields", "More Types" and "More Taxonomies" plugins.
 *	http://more-plugins.se/
*/

// Reset
if (0) update_option('design_settings', array());

// Settings
$fields = array(
	'var' => array('label', 'logo', 'logo_width', 'logo_height', 'skin', 'skin_custom', 'sidebar', 'css_custom', 'js_custom'),
	'array' => array(
		'fonts' => array('heading', 'heading_cufon', 'heading_standard', 'body', 'body_custom'),
		'header' => array('bg_color', 'background', 'bg_pos_x', 'bg_pos_y', 'bg_repeat'),
		'footer' => array('bg_color', 'background', 'bg_pos_x', 'bg_pos_y', 'bg_repeat'),
		'body' => array('bg_color', 'background', 'bg_pos_x', 'bg_pos_y', 'bg_repeat')
	)
);
$default = array(
	'skin' => 'style-skin-1.css',
	'fonts' => array(
		'heading' => 'cufon:opensans', 
		'body' => 'standard:Arial|Helvetica|Garuda|sans-serif'
	),
	'sidebar' => '30fs6yk453s',
	'header' => array(
		'bg_pos_x' => '0', 
		'bg_pos_y' => '0', 
		'bg_repeat' => 'no-repeat'
	),
	'footer' => array(
		'bg_pos_x' => '0', 
		'bg_pos_y' => '0', 
		'bg_repeat' => 'no-repeat'
	),
	'body' => array(
		'bg_pos_x' => '0', 
		'bg_pos_y' => '0', 
		'bg_repeat' => 'no-repeat'
	)
);
 
$settings = array(
	'name' => 'Design Settings', 
	'option_key' => $shortname.'design_settings',
	'fields' => $fields,
	'default' => $default,
	'parent_menu' => 'appearance',
	//'menu_permissions' => 5,
	'file' => __FILE__
);

// Required components
include('object.php');

$design_settings = new design_settings_object($settings);

// Load admin components
if (is_admin()) {	
	include('settings-object.php');
	$design_admin = new design_admin_object($settings);
}

?>
