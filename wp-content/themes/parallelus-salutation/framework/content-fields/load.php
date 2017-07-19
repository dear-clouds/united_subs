<?php

#
#	FIX FOR 5 IMAGES IN MEDIA LIBRARY ON POSTS (lightbox) APPLIED TO "rewrite-object.php" ON LINE 16:
#
#	 COMMENTED OUT:
#
#		 Add_filter('posts_join', array(&$this, 'query_join'));
#
#
#	THIS MAY DISABLE SOME FUNCTIONALITY FOR MEDIA BASED FIELDS. IF UNSURE, ENABLE FILTER AND TEST AGAIN.
#




/*
Plugin Name: More Fields
Version: 2.0.5.2
Author URI: http://more-plugins.se/
Plugin URI: http://more-plugins.se/plugins/more-fields/
Description:  Add more input boxes to use on the write/edit page.
Author: Henrik Melin, Kal Ström
License: GPL2

	USAGE:

	See http://more-plugins.se/plugins/more-fields/

	Copyright (C) 2010  Henrik Melin, Kal Ström
	
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
    
*/
// Reset More Fields
if (0) update_option('content_fields', array());

// Plugin settings
$settings = array(
	'name' => 'Content Fields', 
	'option_key' => $shortname.'content_fields',
	'fields' => array(),
	'default' => array(),
	'file' => __FILE__,
);

// Always on components
include('object.php');
include('field-types.php');
include('rewrite-object.php');
include('theme-functions.php');

$content_fields = new content_fields_object($settings);

// Load admin components
if (is_admin()) {	
	include('settings-object.php');
	$content_fields_settings = new content_fields_admin($settings);
}


?>
