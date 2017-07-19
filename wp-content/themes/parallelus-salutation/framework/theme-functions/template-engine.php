<?php

#-----------------------------------------------------------------
# Hijack WP 'template_include' to include theme template files 
#-----------------------------------------------------------------

// Default WP templates using 'template_include' filter
//................................................................
if ( ! function_exists( 'template_context' ) ) :
	function template_context($template) {
		global $context, $target_wp_template_file, $theme_design_loaded;

		// set this global variable for cases where we might need it, like helping with old versions, etc.
		$target_wp_template_file = $template;

		// Get the $context by stripping the file name from $template path (old method)
			// $context = basename($template, ".php");
			
		// Set $context by WP conditional tags
		if     ( is_404() 				)	: $context = 'error';
		elseif ( is_search()			)	: $context = 'search';
		elseif ( is_tax()				)	: $context = 'taxonomy';
		elseif ( is_front_page()		)	: $context = 'home';
		elseif ( is_home()				)	: $context = 'home';
		elseif ( is_attachment()		)	: $context = 'attachment';
		elseif ( is_single()			)	: $context = 'post';
		elseif ( is_page()				)	: $context = 'page';
		elseif ( is_category()			)	: $context = 'category';
		elseif ( is_tag()				)	: $context = 'tag';
		elseif ( is_author()			)	: $context = 'author';
		elseif ( is_date()				)	: $context = 'date';
		elseif ( is_archive()			)	: $context = 'blog';
		elseif ( is_comments_popup()	)	: $context = 'comments';
		elseif ( is_paged()				)	: $context = 'paged';
		else :
			// Something nice to add here might be a feature that makes association 
			// between template files and a custom $context. A user could assign
			// these associations from the WP admin options? Just a thought.
		
			// Set the default
			$context = 'default';
		endif;

		// Apply filters: 'template_context'
		//................................................................

		// Give plugins and theme functions a chance to modify the $context
		$context = apply_filters( 'template_context', $context, $template );	

		// Sometimes this function is called more than once (usually by a plugin) and we don't want to load the design twice.
		// On the second and all calls after the first we use the "bypass" context to return $template directly for loading. 
		if ($theme_design_loaded) {
			$context = 'bypass';
		}

		// Call the "create_page_layout()" function to load the relevant template files
		//................................................................

			/**
			*	After calling the function, the flow goes something like this:
			*	
			*	1. create_theme_layout($context, $template) -> 		
			*	2. Load design file "design.php" -> (done by create_theme_layout function)
			*	3. Look up the layout for this specific context/page ->
			*	4. Include all the necessary pieces of the layout assigned to this page (sidebars, columns, etc) ->
			*	5. Include the $template if the layout specifies a "Default Content" area.
			*/

		// Last chance to edit the values of $template and $context
		$template = apply_filters( 'theme_template_file', $template );
		$context = apply_filters( 'theme_template_context', $context );

		// echo "Template: <strong>$template</strong>, Context: <strong>$context</strong><br><br>";

		switch ($context) {

			// Allow default WP functionality in these cases
			case "bypass":			// Special context for skipping theme layout
			case "":				// Empty or false
				return $template;
				break;
			// Apply the theme layout function
			default:
				if (function_exists( 'create_theme_layout' )) {
					create_theme_layout($context, $template );
					return false;
				} else {
					return $template;
				}
		}
	}

	// Apply filters
	if (!is_admin()) {
		// adding the !is_admin() prevents triggering on AJAX requests
		add_filter( 'template_include', 'template_context', 9999 );	// we want this to run after everything else that filters template_include()
	}
endif;

if ( ! function_exists( 'rtmedia_main_template_include' ) ) :
	function rtmedia_main_template_include($template, $new_rt_template) {
		if( bp_is_member() ) {
			bp_template_context( get_template_directory().'/members/single/rtmedia/main.php');
		}
		if( bp_is_group() ) {
			bp_template_context( get_template_directory().'/groups/single/rtmedia/main.php');
		}			
	}
endif;

if ( ! function_exists( 'bp_action_settings' ) ) :
	function bp_action_settings() {
		if( bp_is_user_settings_profile() ) {
			bp_template_context(get_template_directory().'/members/single/settings/profile.php');
		}
		if (!is_admin()) {
			add_filter('rtmedia_main_template_include', 'rtmedia_main_template_include', 20, 2);
		}	

	}
	if (!is_admin()) {
		add_action( 'bp_actions', 'bp_action_settings' );
	}	
endif;

// Default BuddyPress templates using 'template_redirect' filter
//................................................................

/*
	BuddyPress is it's own animal and uses the "template_redirect" 
	for getting the template files to load. Because of this, we
	manage it independent of all other "template_include" filters 
	and overrides. 
*/

if ( ! function_exists( 'bp_template_context' ) ) :
	function bp_template_context($template) {
		global $context, $target_wp_template_file, $theme_design_loaded;

		// set this global variable for cases where we might need it, like helping with old versions, etc.
		$target_wp_template_file = $template;

		// Possible BP paths, used to set the $context variable
		//................................................................

		$pathNormalized = str_replace( array('/','\\'), '|', $template);	// replacing "/" and "\" with "|" to prevent OS path conflicts
		$bpTemplatePaths = array(
			// Activity (bp-activity)
				'activity|index.php' 							=> 'bp-activity',
			// Blogs (bp-blogs)
				'blogs|index.php' 								=> 'bp-blogs',
				'blogs|create.php' 								=> 'bp-blogs',
			// Forums (bp-forums)
				'forums|index.php' 								=> 'bp-forums',
			// Groups (bp-groups)
				'groups|index.php' 								=> 'bp-groups',
				'groups|create.php' 							=> 'bp-groups',					// bp-groups-create
				'groups|single|home.php' 						=> 'bp-groups-single',
				'groups|single|plugins.php' 					=> 'bp-groups-single-plugins',
				'groups|single|rtmedia|main.php' 				=> 'bp-groups-single-plugins',
			// Members (bp-members)
				'members|index.php' 							=> 'bp-members',
				'members|single|activity|permalink.php' 		=> 'bp-members',				// bp-members-single-activity
				'members|single|home.php' 						=> 'bp-members-single',
				'members|single|settings|general.php' 			=> 'bp-members-single',			// bp-members-single-settings-general
				'members|single|settings|delete-account.php'	=> 'bp-members-single',			// bp-members-single-settings-delete-account
				'members|single|settings|notifications.php' 	=> 'bp-members-single',			// bp-members-single-settings-notifications
				'members|single|plugins.php' 					=> 'bp-members-single-plugins',
				'members|single|rtmedia|main.php' 				=> 'bp-members-single-plugins',
			// Registration (bp-registration)
				'registration|activate.php' 					=> 'bp-registration',			// bp-registration-activate
				'registration|register.php' 					=> 'bp-registration'			// bp-registration
		);

		// Set $context by BuddyPress conditional tags
		//................................................................

		// Set the default
		$context = 'bp';

		// Test the template paths to find the $context
		foreach ( $bpTemplatePaths as $BpPath => $ContextValue ) {
			if ( strripos( $pathNormalized, $BpPath ) !== false ) {
				$context = $ContextValue;
			}
		}

		// Sometimes this function is called more than once (usually by a plugin) and we don't want to load the design twice.
		// On the second and all calls after the first we use the "bypass" context to return $template directly for loading. 
		if ($theme_design_loaded) {
			$context = 'bypass';
		}

		// Apply filters: 'template_context'
		//................................................................

		// Give plugins and theme functions a chance to modify the $context
		$template = apply_filters( 'theme_template_file', $template );
		$context = apply_filters( 'theme_template_context', $context );
		// $context = apply_filters( 'bp_template_context', $context, $template );	

		// Call the "create_theme_layout()" function to load the relevant template files
		//................................................................

		switch ($context) {

			// Allow default WP functionality in these cases
			case "bypass":			// Special context for skipping theme layout
			case "":				// Empty or false
				return $template;
				break;
			// Apply the theme layout function
			default:
				if (function_exists( 'create_theme_layout' )) {
					create_theme_layout($context, $template);
				}				
				return FRAMEWORK_DIR .'theme-functions/blank.php';	// This returns an empty PHP file to prevent errors.
		}
	}

	// Apply filters
	if (!is_admin()) {
		// adding the !is_admin() prevents triggering on AJAX requests
		add_filter( 'bp_load_template', 'bp_template_context', 9999 ); // we want this to run after everything else that filters bp_load_template()
	}
endif;






#-----------------------------------------------------------------
# Register and apply functions for $context by template file
#-----------------------------------------------------------------

// Register Templates for Context Assignment
//................................................................

	/**
	*
	*	@param string $name - A name associated with this template. May be used in admin as a label for layout selection.
	*	@param string $context - The context to be assigned when this template is called
	*	@param string or array $file_or_function - A single template file, array of template files or function to be called
	*	@param int $priority - The priority to execute this item
	*	@param string $return_val - When a function is used for $file_or_function, this specifies if the return value is the 'context' or 'bool' (true/false) to use the supplied context when registered
	*	@return bool - Will return false if any errors or required variables are not supplied
	*
	*	Example usage: 
	*	
	*		$news_template = locate_template('category-news.php'); // provides full path to files in theme folder
	*		register_context( 'News Category', 'news_category', $news_template);
	*
	*
	*/
if ( ! function_exists( 'register_context' ) ) :
	function register_context( $name, $context = 'post', $file_or_function, $priority = 10, $return_val = 'context' ) {
		global $register_context, $master_context_list;

		$auto_CPT = false;

		if (is_callable($file_or_function) && !is_array($file_or_function)) {
			// We have a function to use.
			$function = $file_or_function;
			$file = '';

			// Check if this is an auto-generated CPT (these many not do anything and we need to say that in the admin)
			if ($function == 'verify_post_type_context') {
				$auto_CPT = true;
			}
		} else {
			// It's not a function, so we probably have a template file (or array) specified
			 $file = $file_or_function;
		}

		if ($file || $function) {

			if (!$name) $name = $context;

			$register_context[$priority][$name] = array( 
				'file' => $file,
				'function' => $function,
				'context' => $context,
				'return' => $return_val
			);

			if ($auto_CPT) {
				// These are generated automatically by the theme and may not actually have a public facing page so we manage them seperate.
				$master_context_list['auto'][$context] = $name;
			} else {	
				// add context to the list (for admin purposes)
				$master_context_list['manual'][$context] = $name;
			}


			// success
			return true;

		} else {

			// failure
			return false;
		}

	}
endif;



// Apply Template Context Registrations
//................................................................

	/**
	*
	*	When a $context is registered using the "register_context()" function it stores the data to the global $register_context 
	*	variable. When the function "template_context()" determines which context to use from the defaults, it needs to also check 
	*	against the list of registered contexts. These can include auto-registered custom post types, custom user registered and 
	*	some other custom registrations included by the theme. After the default $context values are checked, we apply a filter to 
	*	the "template_context()" function to run "apply_registered_context()" which tests for a registered context/template and 
	*	updates the $context values of the "template_context()" function before executing the design files. 
	*
	*	@param string $context - The context.
	*	@param string $template - The template file 
	*
	*/

if ( ! function_exists( 'apply_registered_context' ) ) :
	// This applies the registerd $context when loading the public layouts
	function apply_registered_context($context, $template) {
		global $register_context;

			
		if (is_array($register_context)) {
			foreach($register_context as $priority => $item) {
				foreach($item as $name => $values) {

					$_file = $values['file'];			// This could be a single file or an array of files (should be full path)
					$_function = $values['function'];	// A function to test against instead of a specific template file
					$_context = $values['context'];		// The context to assign
					$_return = $values['return'];		// Type of return value for a function call, can be 'context' or 'bool'

					if (is_callable($_function)) {
						if ($_return == 'context') {
							// the function returns the context
							$context = call_user_func($_function, $context, $template, $values);
						} else {
							if (call_user_func($_function, $context, $template)) {
								// the function returns true/false and we set the context based on the registration
								$context = $_context;
							}
						}
					} elseif ( is_array($_file) ) {
						foreach($_file as $_template) {
							if ($template == $_template){
								$context = $_context;
								break;
							}
						}
					} else {
						if ($_file == $template) {
							$context = $_context;
						}
					}
				}

			}
		}

		// Give plugins and theme users a chance to override the values
		$context =  apply_filters( 'apply_registered_context', $context, $template );

		return $context;

	}

	// Apply filters
	add_filter( 'template_context', 'apply_registered_context', 10, 2 );

endif;



// Auto-register all custom post types
// -----------------------------------------------------------------

/**
*
*	Finds and registers any public custom post types that are not WP defaults or "_builtin" 
*
*/

// Register custom post types ($context)
//................................................................

// This looks up the custom post type objects and calls the "register_context()" function. It verifies the CPT with a function
// instead of specifying a template file.

if ( ! function_exists( 'auto_register_custom_post_type_context' ) ) :
	function auto_register_custom_post_type_context() {
		//global $post, $wp_query;
		$args = array(
		  'public'   => true,
		  '_builtin' => false
		); 
		$output = 'objects'; // names or objects, 'names' is the default
		$operator = 'and'; // 'and' or 'or'
		$post_types = get_post_types($args,$output,$operator); 
		
		foreach ($post_types  as $post_type ) {
			register_context( $post_type->labels->name, $post_type->name, 'verify_post_type_context');
		}
	}
	
	// Apply filters
	add_action( 'init', 'auto_register_custom_post_type_context' );
endif;

// Applies context when detecting a custom post types
//................................................................

// This function is called by the "register_context()" function (instead of a template file) to verify if the currently loaded 
// page is one that meets the requirements of a registered context (CPT). It tests the current page to see if the "$post_type->name"
// value matches a registered $context and if so, returns the $context value. 

if ( ! function_exists( 'verify_post_type_context' ) ) :
	function verify_post_type_context($context, $template, $values) {
		global $post;

		// If current post type ($post_type->name) matches a registered $context, return the $context value
		if ( $values['context'] == get_post_type($post) ) {
			$context = $values['context'];
		}

		return $context;
	}
endif;


// Register the bbPress $context
//................................................................

// This calls a function to test if a page is produced by the bbPress plugin

if ( ! function_exists( 'bbp_template_context' ) ) :
	function bbp_template_context($template) {

		if ( function_exists('is_bbpress') ) {
			register_context( 'bbPress', 'bbpress', 'bbpress_context', 10);
		}

		return $template; // pass the template back or the bbPress plugin will fail to load

	}

	// Could be attached to 'template_include' or anything before it. Doing it this way ensures bbPress is installed and loaded.
	add_filter( 'bbp_template_include', 'bbp_template_context' );	
endif;

// This tests the internal plugin function "is_bbpress()" to see if it is producing the current page

if ( ! function_exists( 'bbpress_context' ) ) :
	function bbpress_context($context, $template, $values) {
		global $post;

		if ( is_bbpress() ) {

			// This is a bbPress page so update the $context
			$context = 'bbpress';

			// Check against some specific bbPress page types also for more granular layout control
			if (get_post_type($post) == 'topic') {
				$context = 'bbp_topic';
			} /* elseif (get_post_type($post) == 'reply') {
				// $context = 'bbp_reply';
			}*/

		}
		return $context;
	}
endif;



#-----------------------------------------------------------------
# WPMU Plugin Helpers
#-----------------------------------------------------------------

// Directory Plugin
//................................................................

// This plugin auto registers a custom post type. This auto-registers the 'directory_listing' $context. The function below will make sure this context is also
// applied to all of the other pages of the plugin, not just the main 'Listings' page. Individual areas can override the layout in the WP admin 'Pages' area.
if ( ! function_exists( 'directory_plugin_template_context' ) ) :
	function directory_plugin_template_context($context) {
		global $wp_query, $directory_core;

		if ( is_object($directory_core) ) {
			// These are all the conditions for testing Directory pages
			if  ( 
					is_dr_page('archive') ||
					( $wp_query->is_single &&  'directory_listing' == $wp_query->query_vars['post_type'] ) ||
					is_page($directory_core->directory_page_id) ||
					is_page($directory_core->my_listings_page_id) ||
					( is_page($directory_core->add_listing_page_id) || is_page($directory_core->edit_listing_page_id) ) ||
					is_page($directory_core->signin_page_id) ||
					is_page($directory_core->signup_page_id) ||
					$directory_core->is_directory_page
				) 
			{
				// Apply the directory context
				$context = 'directory_listing';
			}
		}

		// The Directory plugin either isn't installed or active.
		return $context;
	}
	
	// Attach the filter
	add_filter( 'template_context', 'directory_plugin_template_context' );	
endif;

?>