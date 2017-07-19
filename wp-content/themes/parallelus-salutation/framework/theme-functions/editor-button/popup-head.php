<?php
// Get wp-load.php path to authenticate user
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../$wp_include";
}

// let's load WordPress
require($wp_include);

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__("You are not allowed to be here", THEME_NAME));
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $themename .' Shortcode'; ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo site_url().'/wp-includes/js/tinymce/tiny_mce_popup.js'; ?>"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url().'/wp-includes/js/tinymce/utils/mctabs.js'; ?>"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url().'/wp-includes/js/tinymce/utils/form_utils.js'; ?>"></script>
	<script language="javascript" type="text/javascript" src="<?php echo site_url().'/wp-content/themes/'. get_template().'/framework/theme-functions/editor-button/jsFunctions.js'; ?>"></script>
	<base target="_self" />
</head>
