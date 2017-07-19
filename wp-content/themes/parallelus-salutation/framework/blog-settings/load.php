<?php
/*
 *	Based on the work of Henrik Melin and Kal Ström's "More Fields", "More Types" and "More Taxonomies" plugins.
 *	http://more-plugins.se/
*/

// Reset
if (0) update_option('blog_settings', array());

// Settings
$fields = array(
		'var' => array(
			'show_post_date', 
			'show_author_name',
			'show_author_avatar',
			'show_comments_link',
			'show_categories',
			'show_tags',
			'blog_show_image',
			'post_show_image', 
			'post_image_width', 
			'post_image_height', 
			'use_post_excerpt', 
			'excerpt_length',
			'read_more_text',
		),
		'array' => array( )
);
$default = array(
		'show_post_date' => 1, 
		'show_author_name' => 1,
		'show_author_avatar' => 1,
		'show_comments_link' => 1, 
		'show_categories' => 1, 
		'show_tags' => 0, 
		'blog_show_image' => 1,
		'post_show_image' => 0,
		'post_image_width' => 687, 
		'post_image_height' => '',
		'use_post_excerpt' => 1,
		'excerpt_length' => 50, 
		'read_more_text' => __('Read more...', THEME_NAME)
);

$settings = array(
	'name' => 'Blog Settings', 
	'option_key' => $shortname.'blog_settings',
	'fields' => $fields,
	'default' => $default,
	//'parent_menu' => 'settings',
	//'menu_permissions' => 5,
	'file' => __FILE__
);

// Required components
include('object.php');

$blog_settings = new blog_settings_object($settings);

// Load admin components
if (is_admin()) {	
	include('settings-object.php');
	$blog_admin = new blog_admin_object($settings);
}

?>
