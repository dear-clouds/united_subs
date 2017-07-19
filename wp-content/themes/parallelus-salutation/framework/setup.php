<?php

#-----------------------------------------------------------------
# Load framework components
#-----------------------------------------------------------------

include_once('core/common-object.php');


#-----------------------------------------------------------------
# Initialize the admin components
#-----------------------------------------------------------------

// Load admin components
if (is_admin()) {
	include_once('core/admin-object.php');
}


#-----------------------------------------------------------------
# Load options and functions
#-----------------------------------------------------------------

// Include framework features
include_once("utilities/plugin-installer/load.php");
include_once("theme-settings/load.php");
include_once("blog-settings/load.php");
include_once("contact-form-settings/load.php");
include_once("design-settings/load.php");
include_once("layout-settings/load.php");
include_once("sidebar-settings/load.php");
include_once("slideshow-settings/load.php");
include_once("content-fields/load.php");

// WordPress filters and actions
include_once("theme-functions/filters-and-actions.php");


#-----------------------------------------------------------------
# Other utilities
#-----------------------------------------------------------------

if (!is_admin()) {
	include_once('utilities/media-functions.php');
	include_once('utilities/pagination.php');
	include_once('utilities/breadcrumbs.php');
	include_once('utilities/email-functions.php');
	include_once("theme-functions/layout-and-design.php");
}

// Template Engine
include_once("theme-functions/template-engine.php");

// Sidebars
include_once('utilities/sidebar-generator.php');

// Post types
include_once('utilities/post-type-static-block.php');

// Shortcodes
include_once('theme-functions/shortcodes.php');
if (is_admin()) {
	// Include Editor Button
	include_once('theme-functions/editor-button/load-buttons.php');
}

// BuddyPress related functions
if (bp_plugin_is_active()) {
	// Include BP functions
	include_once('theme-functions/buddypress.php');
}

// bbPress (site wide) related functions
if (bbPress_plugin_is_active()) {
	// Include BP functions
	include_once('theme-functions/bbpress.php');
}

// Import Data - Check the DB for theme data, if empty import
include_once('data/import.php');


?>