<?php

#-----------------------------------------------------------------
# Theme Variables
#-----------------------------------------------------------------

// Retrieve theme data from the database to store in an array
//................................................................


if ( ! function_exists( '_theme_data_lookup' ) ) :

	function _theme_data_lookup() {
		global $theme_settings, $blog_settings, $contact_form_settings, $design_settings, $layout_settings, $slideshow_settings, $sidebar_settings, $theme_data_array;

		// Get settings values (saved and DB)
		$theme_data = $theme_settings->get_objects(array('_plugin_saved', '_plugin'));
		
		// Get blog settings (saved and DB)
		$blog_data = $blog_settings->get_objects(array('_plugin_saved', '_plugin'));
		$theme_data['blog'] = $blog_data['blog_setting'];
		
		// Get contact form (saved and DB)
		$contact_saved_data = $contact_form_settings->get_objects(array('_plugin_saved'));
		$contact_db_data = $contact_form_settings->get_objects(array('_plugin'));
		$theme_data['contact_form'] = array_merge(isset($contact_saved_data['contact_form'])? (array)$contact_saved_data['contact_form'] : array(), isset($contact_db_data['contact_form'])? (array)$contact_db_data['contact_form'] : array());
		$theme_data['contact_form']['contact_fields'] = array_merge(isset($contact_saved_data['contact_fields'])? (array)$contact_saved_data['contact_fields'] : array(), isset($contact_db_data['contact_fields'])? (array)$contact_db_data['contact_fields'] : array());

		// Get design values (saved and DB)
		$design_saved_data = $design_settings->get_objects(array('_plugin_saved'));
		$design_db_data = $design_settings->get_objects(array('_plugin'));
		$design_data['design_setting'] = array_merge(isset($design_saved_data['design_setting'])? (array)$design_saved_data['design_setting'] : array(), isset($design_db_data['design_setting'])? (array)$design_db_data['design_setting'] : array());

		// Get slide shows (saved and DB)
		$slideshow_saved_data = $slideshow_settings->get_objects(array('_plugin_saved'));
		$slideshow_db_data = $slideshow_settings->get_objects(array('_plugin'));
		$design_data['slideshows'] = array_merge((array)$slideshow_saved_data['slideshows'], (array)$slideshow_db_data['slideshows']);

		// Get sidebars (saved and DB)
		$sidebar_saved_data = $sidebar_settings->get_objects(array('_plugin_saved'));
		$sidebar_db_data = $sidebar_settings->get_objects(array('_plugin'));
		$design_data['sidebars'] = array_merge(isset($sidebar_saved_data['sidebars'])? (array)$sidebar_saved_data['sidebars'] : array(), isset($sidebar_db_data['sidebars'])? (array)$sidebar_db_data['sidebars'] : array());
		// Get tab sidebars (saved and DB)
		$design_data['sidebar-tabs'] = array_merge(isset($sidebar_saved_data['tabs'])? (array)$sidebar_saved_data['tabs'] : array(), isset($sidebar_db_data['tabs'])? (array)$sidebar_db_data['tabs'] : array());

		/*
			Layout options have several sections, each must be merged individually
			
			Note: using the array casting below may cause some empty values if nothing exists in the item being cast. This shouldn't be
			and issue here since blanks will be ignored. This would only matter if we were populating a field for the admin as it would
			leave an empty option in the field.
		*/
		
		// Get layout settings (saved and DB)
		$layout_saved_data = $layout_settings->get_objects(array('_plugin_saved'));
		$layout_db_data = $layout_settings->get_objects(array('_plugin'));
		$design_data['page_headers'] = array_merge(isset($layout_saved_data['page_headers'])? (array)$layout_saved_data['page_headers'] : array(), isset($layout_db_data['page_headers'])? (array)$layout_db_data['page_headers'] : array());
		$design_data['page_footers'] = array_merge(isset($layout_saved_data['page_footers'])? (array)$layout_saved_data['page_footers'] : array(), isset($layout_db_data['page_footers'])? (array)$layout_db_data['page_footers'] : array());
		$design_data['layouts'] = array_merge(isset($layout_saved_data['layouts'])? (array)$layout_saved_data['layouts'] : array(), isset($layout_db_data['layouts'])? (array)$layout_db_data['layouts'] : array());
		$design_data['design_setting']['layout'] = array_merge(isset($layout_saved_data['layout_settings']['layout'])? (array)$layout_saved_data['layout_settings']['layout'] : array(), isset($layout_db_data['layout_settings']['layout'])? (array)$layout_db_data['layout_settings']['layout'] : array());
		
		//$design_data['top_graphics'] = array_merge((array)$design_saved_data['top_graphics'], (array)$design_db_data['top_graphics']);

		// combine all option to single array
		$data = array_merge($theme_data, $design_data);
		
		//return $data;
		$theme_data_array = $data;
	}

endif;

// add data lookup to WP init function
add_action('init', '_theme_data_lookup');


// Get theme variables, default action is echo 
//................................................................

//	$option = the option name in the database (can be comma separated array path)
// 	$echo = print the return value (true, false). Default: true
// 	$default = value returned is no value exists in database
if ( ! function_exists( 'theme_var' ) ) :

	function theme_var($option, $act = 'echo', $default = '') {
		global $theme_data_array;
		
		// get the theme data
		$data = $theme_data_array;
			
		// deal with comma separated requests			
		if (strpos($option, ',')) {
			$c = explode(',', str_replace(' ', '', $option));
			foreach($c as $d) $s[] = $d;
		} else {
			$s[] = $option;
		}
		
		// Iterate through the data
		$subdata = $data;
		foreach ($s as $key) {
			$subdata = isset($subdata[$key])? $subdata[$key] : '';
		}
		if (!is_array($subdata)) $subdata = stripslashes($subdata);

		// return or echo
		switch ($act){
			case "return":
				return $subdata;
				break;
			default:
				echo $subdata;
				break;
		}
	}
	
endif;


// Shortcut for options without echo 
//................................................................

if ( ! function_exists( 'get_theme_var' ) ) :

	function get_theme_var($option, $default = '') {
		return theme_var($option, 'return', $default);
	}
	
endif;


#-----------------------------------------------------------------
# Excerpt Functions
#-----------------------------------------------------------------

// Replace "[...]" in excerpt with "..."
//................................................................
function new_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'new_excerpt_more');


// Modify the WordPress excerpt length
//................................................................
//
// We set this pretty high because our "customExcerpt" function 
// uses the WordPress excerpt content as it's source of text
// because it's already stripped of HTML, images and such. 
//
//................................................................
function new_excerpt_length($length) {
	return 250;
}
add_filter('excerpt_length', 'new_excerpt_length');


// Custom Length Excerpts
//................................................................
// 
// Usage:
// echo customExcerpt(get_the_content(), 30);
// echo customExcerpt(get_the_content(), 50);
// echo customExcerpt($your_content, 30);
//
//................................................................
function customExcerpt($excerpt = '', $excerpt_length = 50, $tags = '', $trailing = '...') {
	global $post;
	
	if (has_excerpt()) {
		// see if there is a user created excerpt, if so we use that without any trimming
		return  get_the_excerpt();
	} else {
		// otherwise make a custom excerpt
		$string_check = explode(' ', $excerpt);
		if (count($string_check, COUNT_RECURSIVE) > $excerpt_length) {
			$excerpt = strip_shortcodes( $excerpt );
			$new_excerpt_words = explode(' ', $excerpt, $excerpt_length+1); 
			array_pop($new_excerpt_words);
			$excerpt_text = implode(' ', $new_excerpt_words); 
			$temp_content = strip_tags($excerpt_text, $tags);
			$short_content = preg_replace('`\[[^\]]*\]`','',$temp_content);
			$short_content .= $trailing;
			
			return $short_content;
		} else {
			// no trimming needed, excerpt is too short.
			return $excerpt;
		}
	}
} 


#-----------------------------------------------------------------
# Content Functions
#-----------------------------------------------------------------

// Prepare content for output
//................................................................
if ( ! function_exists( 'prep_content' ) ) :
	
	function prep_content($content, $allowHTML = 1, $allowShortcodes = 0) {
		
		if ($allowHTML) $content = html_entity_decode($content, ENT_QUOTES);
		if ($allowShortcodes) $content = do_shortcode($content);
		
		return $content;
	}

endif;



#-----------------------------------------------------------------
# Menus
#-----------------------------------------------------------------

// Default theme menus
if ( ! function_exists( 'register_theme_menus' ) ) :
	
	function register_theme_menus() {
		global $themeMenus;
		if ( function_exists( 'register_nav_menus' ) ) {	// feature detect instead of version checking
			register_nav_menus( $themeMenus );
		}
	}
	add_action( 'init', 'register_theme_menus' );

endif;

// Menu fallback function. Displays message for menus not set under "Menu > Theme Locations"
if ( ! function_exists( 'no_menu_set' ) ) :

	function no_menu_set($info) {
		global $themeMenus, $theHeader;
		// Display error message if menu location isn't set
		printf(
			'<small style="line-height:2.7;background:#D00;color:#fff;padding:2px 5px;">'. __('Set %s in "Appearance > Menus > Manage Locations"', THEME_NAME) .'</small>', 
			'<strong style="text-decoration:underline;">'.$themeMenus[$info['theme_location']].'</strong>'
		);
	}

endif;



#-----------------------------------------------------------------
# Stylesheet queue
#-----------------------------------------------------------------

/*	Adds the ability to queue style sheets similar to the method
*	used by WordPress. Makes it easier to include CSS files 
*	organized together and load them as needed as opposed to 
*	"wp_enqueue_style" which mixes with all plugins.
*/

// Add CSS files to queue
//................................................................

if ( ! function_exists( 'theme_register_css' ) ) :
function theme_register_css( $handle, $src, $priority = 10, $id = false, $class = false ) {

	global $enqueue_theme_css;
	// add new file to CSS queue
	$enqueue_theme_css[$handle] = array( 'src' => $src, 'priority' => $priority, 'id' => $id, 'class' => $class);

}
endif;

// Print CSS files
if ( ! function_exists( 'print_theme_style_sheets' ) ) :
	function print_theme_style_sheets() {
		global $enqueue_theme_css, $skinCssPosition;
		
		$skin = (!$skinCssPosition) ? 'last' : $skinCssPosition; // skin CSS file added: 'first', 'last' or 'none' to exclude based on global variable
		
		$styleSheet = $enqueue_theme_css;
		$cssFiles = array(); // new array to move values to before sorting
	
		// add skin CSS file (set to add before other CSS files)
		if ($skin == 'first') {
			theme_skin();
		}
	
		// put all the items in the new array with ID based on priority
		if (is_array($styleSheet) && count($styleSheet) > 0) {
			$n = 0;
			foreach ((array) $styleSheet as $handle => $css) {
				$id = (isset($id) && $id) ? ' id="'.$css['id'].'"' : '';
				$class = (isset($class) && $class) ? ' class="'.$css['class'].'"' : '';
				$cssFiles[$css['priority'].'.'.$n] = '<link rel="stylesheet" type="text/css" href="'. $css['src'] .'"'. $id . $class .' />';
				$n++;
			}
			ksort($cssFiles); // sort the items for priority
			
			// print each CSS file
			foreach ($cssFiles as $style_sheet) {
				echo $style_sheet ."\n";
			}
		}

		// add skin CSS file last (default)
		if ($skin == 'last') {
			theme_skin();
		}
	}
	
	// Add print function to hook 
	add_action('wp_head','print_theme_style_sheets', 1);
endif;


#-----------------------------------------------------------------
# Miscelanious
#-----------------------------------------------------------------

// Append to <title> the value set by the user
//................................................................
if ( ! function_exists( 'theme_append_to_title' ) ) :
	
	function theme_append_to_title($title, $sep = '&raquo;', $seplocation = 'right') {
		
		if ( is_front_page() ) {
			$html_title = get_bloginfo('name') .' &#8211; '. get_bloginfo('description');
		} else {

			if ( get_theme_var('options,append_to_title') ) {
				
				$html_title = get_theme_var('options,append_to_title'); 
				
				if ($title) {
					$html_title = $title .' &#8211; '.  $html_title;
				}
			} else {
				$html_title = $title;
			}

		}

		return $html_title;
	}

	add_filter( 'wp_title', 'theme_append_to_title', 10, 3 );

endif;


// Test for a script already enqueue 
//................................................................
if ( ! function_exists( 'is_enqueued_script' ) ) :
	
	function is_enqueued_script( $script ) {
		return isset( $GLOBALS['wp_scripts']->registered[ $script ] );
	}
	
endif;



// Add gravatars to WP admin options 
//................................................................
if ( ! function_exists( 'theme_gravatar' ) ) :
	
	function theme_gravatar( $avatar_defaults ) {
		
		$themeAvatar_1 = THEME_URL . 'assets/images/icons/avatar-1.png';
		$avatar_defaults[$themeAvatar_1] = 'Theme Avatar 1';
		$themeAvatar_2 = THEME_URL . 'assets/images/icons/avatar-2.png';
		$avatar_defaults[$themeAvatar_2] = 'Theme Avatar 2';
		$themeAvatar_3 = THEME_URL . 'assets/images/icons/avatar-3.png';
		$avatar_defaults[$themeAvatar_3] = 'Theme Avatar 3';
		return $avatar_defaults;
		
	}
	
	add_filter( 'avatar_defaults', 'theme_gravatar' );
	
endif;


// Simple string encode/decode functions
//................................................................

$strEncOffset = 14; // set to a unique number for offset

if ( ! function_exists( 'strEnc' ) ) :
	function strEnc($s) {
		global $strEncOffset;
		
		for( $i = 0; $i < strlen($s); $i++ )
			$r[] = ord($s[$i]) + $strEncOffset;
		return implode('.', $r);
	}
endif;

if ( ! function_exists( 'strDec' ) ) :
	function strDec($s) {
		global $strEncOffset;
		
		$s = explode(".", $s);
		for( $i = 0; $i < count($s); $i++ )
			$s[$i] = chr($s[$i] - $strEncOffset);
		return implode('', $s);
	}
endif;



// WordPress Auto Paragraphs (wpautop)
//................................................................

if ( ! function_exists( 'wpautop_control_filter' ) ) :
	function wpautop_control_filter($content) {
		global $post, $tempPost;
		
		// check the temporary $post reassignment for context specific $post data
		$the_post = ( isset($tempPost) ) ? $tempPost : $post;  
		
		// Get wpautop setting
		$remove_filter = wpautop_filter($the_post->ID);
		
		// turn on/off
		if ( $remove_filter ) {
		  remove_filter('the_content', 'wpautop');
		  remove_filter('the_excerpt', 'wpautop');
		}
		
		return $content;
	}
	
	add_filter('the_content', 'wpautop_control_filter', 9);
endif;
		  
if ( ! function_exists( 'wpautop_filter' ) ) :
	function wpautop_filter($id = '') {
		global $post, $tempPost;
		
		// Get the page/post meta setting
		$post_wpautop_value = strtolower(get_meta('wpautop', $id)); //get_post_meta($post->ID, 'wpautop', true);
		
		// Global default setting
		$default_wpautop_value = get_theme_var('options,wpautop',1); //intval( get_option('wpautop_on_by_default', '1') );
		
		$remove_filter = false; // to match the WP default
		
		// check if set at page level
		if ( in_array($post_wpautop_value, array('true', 'on', 'yes')) ) {
			$remove_filter = false;
		} elseif ( in_array($post_wpautop_value, array('false', 'off', 'no')) ) {
			$remove_filter = true;
		} else {
			// page/post level setting not found, use global setting
			$remove_filter = ! $default_wpautop_value;
		}
		
		return $remove_filter;
	}
endif;


// Exclude posts and pages from search
//................................................................
if (!is_admin()) {
	
	// filter search results
	if ( ! function_exists( 'filter_search_exclude' ) ) :
		function filter_search_exclude($where = '') {
			global $wpdb;
			
			// Meta values to look up
			$meta_key = 'search-exclude';
			$meta_value = '1';
			
			// Query DB for meta setting 'search-exclude = "Yes"'
			$search_exclude_ids = $wpdb->get_col($wpdb->prepare("
			SELECT      post_id
			FROM        $wpdb->postmeta
			WHERE       meta_key = %s
			AND			meta_value = %s
			ORDER BY    post_id ASC",
					 $meta_key,$meta_value)); 
						
			if ( is_search() && $search_exclude_ids) {
				
				$exclude = $search_exclude_ids;
	
				for($x=0; $x < count($exclude); $x++){
				  $where .= " AND ID != ".$exclude[$x];
				}
			}
			return $where;
		}
		add_filter('posts_where', 'filter_search_exclude');
	endif;

}


// Filter WP navigation menus by class name as function
// Run shortcodes for menu titles and URLs for special features
//................................................................
if ( ! function_exists( 'filter_nav_menu_items' ) ) :
	
	// Filter mneus by specific class names used to call a function as the test for include/exclude
	function filter_nav_menu_items($sorted_menu_items, $args){

		foreach ($sorted_menu_items as $nav_item) {	

			// Shortcodes in titles and URLs
			//................................................................
			
				// Shortcodes to item titles
				$nav_item->title = do_shortcode($nav_item->title);
	
				// Shortcodes to URLs
				if (strpos($nav_item->url,"((") && strpos($nav_item->url,"))")) {
					// Change any "((" to "[" and "))" to "]" - WP menus don't allow [ or ] in URL
					$URL = str_replace('((', '[', str_replace('))', ']', $nav_item->url));
					$nav_item->url = do_shortcode($URL);					
				}
			

			// Filter items by class name (to call function)
			//................................................................

			// Check for classes that trigger functions
			for ($i=0; $i<count($nav_item->classes); $i++) {
	
				$item = 'include';
				
				$class = $nav_item->classes[$i];
				
				// Test the class for being conditional, returns true (include) or false (exclude)
				if ( !conditional_return($class) ) {
						$item = 'exclude';
						break; // go to the next class for this item :)
				}

			}
			
			// add the item to the correct list (keep it or exclude it)
			if ($item == 'exclude') {
				$excluded_items[]=$nav_item; 
			} else {
				$included_items[]=$nav_item;
			}

		}
		
		return $included_items;
	
	}
	
	add_filter( 'wp_nav_menu_objects', 'filter_nav_menu_items', 10, 3);

endif;


// Test string for conditional function, return results of condition
//....................................................................
if ( ! function_exists( 'conditional_return' ) ) :
	function conditional_return($string) {

		// Users can spefy to test for a false value such as "if (!is_home())" with a "-" before the class name.
		if (substr($string, 0, 1) == '-') {
			$conditon =  false;
			$string = substr($string, 1, strlen($string)); // get rid of that "-" at the start for the function test.
		} else {
			$conditon =  true;
		}
		
		// All special classes should start with "function-"
		if (substr($string, 0, 9) == 'function-') {
			
			// get rid of the prefix "function-" at the start of the class
			$string = substr($string, 9, strlen($string)); 

			// change "is-home" into "is_home" (WP menus won't allow "_" in class names
			$string = str_replace('-', '_', $string);
			
			// See if a function exists by this name
			if ( function_exists($string) ) {
				if ( call_user_func($string) != $conditon ) {
					return false;
				}
			}
									
		}

		return true;
	}
endif;



// Get a page/post ID from the slug
//....................................................................
if ( ! function_exists( 'get_ID_by_slug' ) ) :
	function get_ID_by_slug($page_slug, $post_type = 'page') {
		$page = get_page_by_path($page_slug,OBJECT,$post_type);
		if ($page) {
			return $page->ID;
		} else {
			return null;
		}
	}
endif;



// Check if BuddyPress is active 
//................................................................

if ( ! function_exists( 'bp_plugin_is_active' ) ) :
	function bp_plugin_is_active() {
		//check if the function "bp_include" exists (this is a shortcut to checking if BP is loaded)
		return ( function_exists( 'bp_include' ) ) ? true : false;
	}
endif;

// Check if bbPress is active (site wide, not BP groups version)
//................................................................

if ( ! function_exists( 'bbPress_plugin_is_active' ) ) :
	function bbPress_plugin_is_active() {
		//check if the calss "bbPress" exists (this is a shortcut to checking if bbPress is loaded)
		return ( class_exists('bbPress') ) ? true : false;
	}
endif;


// Remove filters from 'the_content' based on post type
//................................................................

if ( ! function_exists( 'the_content_filter' ) ) :

	function the_content_filter($content) {
		global $post, $tempPost, $wp_filter, $save_wp_filter;
		
		// check the temporary $post reassignment for context specific $post data
		$the_post = ( isset($tempPost) ) ? $tempPost : $post;

		if(isset($save_wp_filter)) {
			$wp_filter['the_content'] = $save_wp_filter;
		} else {
			$save_wp_filter = $wp_filter['the_content'];
		}

		// active filters
		$the_content_filters = $wp_filter['the_content'];
		
		// get block options
		$disable = unserialize(get_theme_var('options,disable_wp_content'));

	  	if(isset($disable[$the_post->post_type])) {
			$disable = $disable[$the_post->post_type];

			if(count($disable)) {
				foreach($disable as $filter) {
					// check filter type (function or object)
					if(preg_match("/->/", $filter)) {
						// get class to block then generate current block id
						// and unset filter from apply list
						$filter = explode("->", $filter);
						$class = $filter[0];
						$method = $filter[1];
						foreach($the_content_filters as $level => $_filters) {
							foreach($_filters as $_filter_name => $_filter) {
								if(is_object($_filter['function'][0])) {
									if($class == get_class($_filter['function'][0]) && $method == $_filter['function'][1]) {
										$object_filter = _wp_filter_build_unique_id('', array(&$_filter["function"][0], $method), 10);
										foreach($wp_filter['the_content'] as $key => $val) {
											unset($wp_filter['the_content'][$key][$object_filter]);
										}
									}
								}
							}
						}
					}
					else {
						// unset function filter
						remove_filter('the_content', $filter);
					}
				}
			}
			
		}

	  	return $content;
	}

	// apply filter blocker with
	add_filter( 'the_content', 'the_content_filter', 1 );

endif;


// Save a database reference of all public content filters
//................................................................

if ( ! function_exists( 'save_public_content_filter' ) ) :

	function save_public_content_filter() {
		global $wp_filter;

		if ( !is_admin() ) {
			update_option( 'public_content_filters', $wp_filter['the_content'] );
		}

	}

	// Without this we may miss a public filter in the admin, 
	// since many use conditions like "if (!is_admin())"
	add_action('init', 'save_public_content_filter');

endif;


// WP 3.4+ home page bug. Fixes paging problems on custom queries. 
//................................................................
//
// The bug is caused by WP reading settings, 'Blog pages show at 
// most' being set to '10' by default. Setting to any number 
// lower than the custom query 'post_per_page' value fixes the
// issue so we force it to '1' on the home page.
//
//................................................................

function homepage_query_paging_bug( $query ) {
	if (!is_admin() && $query->is_main_query() && is_home()){
		$query->set('posts_per_page', 1);
	}
}
add_action( 'pre_get_posts', 'homepage_query_paging_bug' );
?>