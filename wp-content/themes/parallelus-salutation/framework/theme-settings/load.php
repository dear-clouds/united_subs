<?php

// Reset
if (0) update_option('theme_settings', array());

// Settings
$fields = array(
		'var' => array(
			'fade_in_content',
			'tool_tips',
            'disable_wp_content',
			//'advanced_ie_styles',
			'favorites_icon',
			'apple_touch_icon',
			'append_to_title',
			'placeholder_images',
			'custom_placeholder',
			'404_page',
			'google_analytics',
			'wpautop',
			'access_theme_settings',
			'access_theme_design',
			'developer_custom_fields',
			'developer_custom_content_types',
			'developer_custom_taxonomies',
			'developer_custom_fields_access',
			'developer_custom_content_types_access',
			'developer_custom_taxonomies_access',
			'branding_admin_logo',
			'branding_admin_header_logo',
			'branding_admin_help_tab_title',
			'branding_admin_help_tab_content',
			'branding_admin_custom_right_column_title',
			'branding_admin_custom_right_column',
			'branding_admin_right_column_theme_settings',
			'branding_admin_right_column_design_settings'
		),
		'array' => array( )
);
$default = array(
		'fade_in_content' => 'all',
		'tool_tips' => 'class',
		//'advanced_ie_styles' =>1,
		'favorites_icon' => 'http://para.llel.us/favicon.ico',
		'apple_touch_icon' => 'http://para.llel.us/apple-itouch-icon.png',
		'placeholder_images' => 1,
		'404_page' => '1708',
		'wpautop' => 1,
		'developer_custom_fields' => 0,
		'developer_custom_content_types' => 0,
		'developer_custom_taxonomies' => 0,
		'developer_custom_fields_access' => 'administrator',
		'developer_custom_content_types_access' => 'administrator',
		'developer_custom_taxonomies_access' => 'administrator',
		//'access_theme_settings' => 'administrator',
		'access_theme_design' => 'administrator',
		'branding_admin_right_column_theme_settings' => 1,
		'branding_admin_right_column_design_settings' => 1
);

$settings = array(
	'name' => 'Theme Settings', 
	'option_key' => $shortname.'theme_settings',
	'fields' => $fields,
	'default' => $default,
	//'parent_menu' => 'settings',
	//'menu_permissions' => 5,
	'file' => __FILE__
);

// Required components
include('object.php');

$theme_settings = new theme_settings_object($settings);

// Load admin components
if (is_admin()) {	
	include('settings-object.php');
	$theme_settings_settings = new theme_settings_admin($settings);
}

?>
