<?php

/**
Plugin Name: Calendarize it! for WordPress
Plugin URI: http://plugins.righthere.com/calendarize-it/
Description: Calendarize it! for WordPress is a powerful calendar and event plugin (Now with support for Visual Composer)
Version: 4.1.3.69163
Author: Alberto Lau (RightHere LLC)
Author URI: http://plugins.righthere.com
 **/
 
define('RHC_VERSION','4.1.3'); 
define('RHC_PATH', plugin_dir_path(__FILE__) ); 
define("RHC_URL", plugin_dir_url(__FILE__) ); 
define("RHC_SLUG", plugin_basename( __FILE__ ) );
define("RHC_ADMIN_ROLE", 'administrator');

//this can only be modified when installing for the first time,//created taxonomies will be lost if changed later.
define("RHC_CALENDAR",	'calendar');
define("RHC_VENUE",		'venue');
define("RHC_ORGANIZER",	'organizer');
define("RHC_VISUAL_CALENDAR", 'calendar');
//custom post type, this afects slugs
define("RHC_EVENTS", 'events');
define("RHC_CAPABILITY_TYPE", 'event');

define('RHC_DEFAULT_DATE_FORMAT','D. F j, g:ia');

define('RHC_DISPLAY','rhcdisplay');

define('SHORTCODE_CALENDARIZE','calendarize');
define('SHORTCODE_CALENDARIZEIT','calendarizeit');

define('RHC_LANGUAGES', dirname( plugin_basename( __FILE__ ) ).'/languages/');//load_plugin_textdomain('rhc', null, dirname( plugin_basename( __FILE__ ) ).'/languages' );

if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

if(!function_exists('property_exists')):
function property_exists($o,$p){
	return is_object($o) && 'NULL'!==gettype($o->$p);
}
endif;

if(!class_exists('plugin_righthere_calendar')){
	require_once RHC_PATH.'includes/class.plugin_righthere_calendar.php';
}

$settings = array(
	'options_capability'	=> 'rhc_options',
	'license_capability'	=> 'rhc_license'
);
//$settings['debug_menu']=true;//provides a debug menu with debugging information
$settings['debugging_js_css']=false;//loads non minified css
//$settings['post_info_shortcode']='rhc_post_info';//change the post_info shortcode.

global $rhc_plugin; 
$rhc_plugin = new plugin_righthere_calendar($settings);

if( ( isset($_REQUEST['rhc_action']) || isset($_REQUEST['rhc_json_feed']) || isset($_REQUEST['meetup_json_feed']) || isset($_REQUEST['gcal_feed']) || isset($_REQUEST['fb_json_feed']) ) 
	&& '1'==$rhc_plugin->get_option('ajax_catch_warnings','',true)){
	ob_start();
}

//-------------------------------------------------------- 
if( !defined('SHORTINIT') || true!==SHORTINIT ){
	register_activation_hook(__FILE__,'rhc_install');
	function rhc_install() {
		include RHC_PATH.'includes/install.php';
		if(function_exists('handle_rhc_install'))handle_rhc_install();	
	}
	//---
	register_deactivation_hook( __FILE__, 'rhc_uninstall' );
	function rhc_uninstall(){
		include RHC_PATH.'includes/install.php';
		if(function_exists('handle_rhc_uninstall'))handle_rhc_uninstall();
	}
}
//-------------------------------------------------------- 
?>