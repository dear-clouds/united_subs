<?php
/*
 *	Based on the work of Henrik Melin and Kal Ström's "More Fields", "More Types" and "More Taxonomies" plugins.
 *	http://more-plugins.se/
*/

// Reset
if (0) update_option('contact_form_settings', array());

// Settings

$fields = array(
	'var' => array(),
	'array' => array()
);
$default = array(
	'to' => get_option('admin_email'), 
	'subject' => __('Message From Website Contact Form', THEME_NAME),
	'thankyou' => __('Thank you, your message has been sent.', THEME_NAME),
	'button' => __('Send', THEME_NAME),
	'captcha' => 0
);

$settings = array(
	'name' => 'Contact Form', 
	'option_key' => $shortname.'contact_form_settings',
	'fields' => $fields,
	'default' => $default,
	//'parent_menu' => 'settings',
	//'menu_permissions' => 5,
	'file' => __FILE__
);

// Required components
include('object.php');

$contact_form_settings = new contact_form_settings_object($settings);

// Load admin components
if (is_admin()) {	
	include('settings-object.php');
	$contact_form_admin = new contact_form_admin_object($settings);
}

?>
