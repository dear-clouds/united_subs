<?php

// Accordions
require_once(gp_admin . 'shortcodes/accordions.php');

// Activity
require_once(gp_admin . 'shortcodes/activity-stream.php');

// Author Info
require_once(gp_admin . 'shortcodes/author-info.php');

// Blockquotes
require_once(gp_admin . 'shortcodes/blockquotes.php');

// Buttons
require_once(gp_admin . 'shortcodes/buttons.php');

// Columns
require_once(gp_admin . 'shortcodes/columns.php');

// Contact Form
require_once(gp_admin . 'shortcodes/contact-form.php');

// Dividers
require_once(gp_admin . 'shortcodes/dividers.php');

// Dropcaps
require_once(gp_admin . 'shortcodes/dropcaps.php');

// Images
require_once(gp_admin . 'shortcodes/images.php');

// Lists
require_once(gp_admin . 'shortcodes/lists.php');

// Logged In
require_once(gp_admin . 'shortcodes/logged-in.php');

// Logged Out
require_once(gp_admin . 'shortcodes/logged-out.php');

// Login Form
require_once(gp_admin . 'shortcodes/login-form.php');

// Notifications
require_once(gp_admin . 'shortcodes/notifications.php');

// Posts
require_once(gp_admin . 'shortcodes/posts.php');

// Price Boxes
require_once(gp_admin . 'shortcodes/price-boxes.php');

// Pricing Table
require_once(gp_admin . 'shortcodes/pricing-table.php');

// Register Form
require_once(gp_admin . 'shortcodes/register-form.php');

// Related Posts
require_once(gp_admin . 'shortcodes/related-posts.php');

// Sidebars
require_once(gp_admin . 'shortcodes/sidebars.php');

// Slider
require_once(gp_admin . 'shortcodes/slider.php');

// Tabs
require_once(gp_admin . 'shortcodes/tabs.php');

// Text Boxes
require_once(gp_admin . 'shortcodes/text-boxes.php');

// Toggle Boxes
require_once(gp_admin . 'shortcodes/toggle-boxes.php');

// Videos
if(get_option($dirname.'_old_video_shortcode') == "0") {
	require_once(gp_admin . 'shortcodes/videos.php');
}

?>