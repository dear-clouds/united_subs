<?php
#-----------------------------------------------------------------
# Page Layouts
#-----------------------------------------------------------------

// Get layout information and assemble page
//................................................................

if ( ! function_exists( 'create_theme_layout' ) ) :

	// base function for creating layout
	function create_theme_layout($source = 'default', $template = false, $layout_key = false) {
		global $post, $cssPath, $jsPath, $context, $layouts, $theLayout, $theHeader, $theFooter, $theme_data_array, $theme_design_loaded;

		$theme_design_loaded = true; // marks this function has been called already

		// For backwards compatibility before v2, check for existing template file using old format and update the variables
		//................................................................
		if ($old_template = page_layout_v1_compatibility($source, $template, $layout_key)) {
			$source = $old_template[0];
			$template = $old_template[1];
			$layout_key = $old_template[2];
		}

		// Begin getting together the default data
		//................................................................

		$context = $source;

		// Retrieve the layout information for this page.
		$layouts = get_theme_var('layouts');
		
		if (!is_array($layouts)) { 
			_theme_data_lookup();						// 1. Make sure the data loaded
			$layouts = get_theme_var('layouts');		// 2. Try setting the layouts variable again
			if (!is_array($layouts)) { $layouts = 0 ; }	// 3. Ok, we tried, there are no layouts.
		}
		// Check for a the set layout
		if (!is_array($layouts) || count($layouts) <= 0 ) {
			echo '<p>'. __('No layouts defined for this theme. Please go to "Appearance &gt; Layouts" and ensure you have page layouts created and default layouts assigned for each post type at the bottom of the page.', THEME_NAME) .'</p>'; // should be returned using 404 page template...
		} else {

			// get the layout array to use

			$layout_id = $layout_key; // default = false;
			$the_context = $context;
			
			// Check for special cases where the context is overriden for the layout
			if ($context == 'page' && is_front_page()) {
				// this happens when "Front page displays > A static page" is selected and the home page is loaded.
				// we're not setting the variable "$context"  because that would cause a global change. we only want the layout altered.
				$layout_id = false;
				$the_context = 'home';
			}elseif ($context == 'home' && is_home() && get_option('show_on_front') == 'page') {
				// The user has specified a "blog page" under Reading settings, "Front page displays > A static page > Posts page"
				// We need to force the layout to the default "blog" or it will try and use the home page layout.
				$layout_id = false;
				$the_context = 'blog';
			}

			// Get the layout array for this page 
			$theLayout = get_theme_layout($layout_id, $the_context); // get_theme_layout();
			$theLayout['template'] = $template;  // set the template file (source file of "Default Content" areas)

			// header settings
			$theHeader = get_header_layout();	// returns header options for current layout/page
			if(empty($theHeader['bg_repeat'])) {
				$defaultHeader = get_theme_var('design_setting,header');				
				$theHeader['bg_repeat'] = $defaultHeader['bg_repeat'];
			}

			// logo image
			if ($theHeader['logo']) {
				$theLayout['logo'] = array( 'img' => $theHeader['logo'], 'w' => $theHeader['logo_width'], 'h' => $theHeader['logo_height'] );
			} else {
				$theLayout['logo'] = array( 'img' => get_theme_var('design_setting,logo'), 'w' => get_theme_var('design_setting,logo_width'), 'h' => get_theme_var('design_setting,logo_height') );
			}

			// Body fonts
			if (get_theme_var('design_setting,fonts,body') == 'custom:standard') {
				$theLayout['body_font'] = prep_content(get_theme_var('design_setting,fonts,body_custom'));
			} else {
				$theLayout['body_font'] = prep_content(str_replace(array('standard:','|'), array('',', '), get_theme_var('design_setting,fonts,body')));
			}
			// Heading fonts
			$headingFont = get_theme_var('design_setting,fonts,heading');
			$fontType = substr($headingFont, 0, strpos($headingFont, ':'));
			if ($headingFont == 'custom:standard') {
				// custom standard font
				$theLayout['heading_font']['standard'] = prep_content(get_theme_var('design_setting,fonts,heading_standard'));
			} elseif ($headingFont == 'custom:cufon') {
				// custom cufon font
				$cufonFont = prep_content(get_theme_var('design_setting,fonts,heading_cufon'));
				if (strpos($cufonFont, '/')) {
					// seems we have a path to a cufon file
					$theLayout['heading_font']['cufon'] = $cufonFont;
				} else {
					// just a file name, add the path to our other cufon files
					$theLayout['heading_font']['cufon'] = $jsPath . 'fonts/'. $cufonFont;
				}
			} else {
				// Pre-set font selected
				if ($fontType == 'standard') $theLayout['heading_font']['standard'] = prep_content(str_replace(array('standard:','|'), array('',', '), $headingFont));
				if ($fontType == 'cufon') {
					$cufonFont = substr($headingFont, strpos($headingFont, ':')+1);
					$theLayout['heading_font']['cufon'] = $jsPath . 'fonts/cufon.'. $cufonFont .'.js';
				}
			}
			
			// Blog defaults
			$theLayout['blog']['post_date'] = get_theme_var('blog,show_post_date');
			$theLayout['blog']['author_name'] = get_theme_var('blog,show_author_name');
			$theLayout['blog']['author_avatar'] = get_theme_var('blog,show_author_avatar');
			$theLayout['blog']['comments_link'] = get_theme_var('blog,show_comments_link');
			$theLayout['blog']['category_list'] = get_theme_var('blog,show_categories');
			$theLayout['blog']['tag_list'] = get_theme_var('blog,show_tags');
			$theLayout['blog']['image']['width'] = (int)get_theme_var('blog,post_image_width', 153); // image width
			$theLayout['blog']['image']['height'] = (int)get_theme_var('blog,post_image_height', 153); // image height
			$theLayout['blog']['use_excerpt'] = get_theme_var('blog,use_post_excerpt');
			$theLayout['blog']['excerpt_length'] = (int)get_theme_var('blog,excerpt_length', 50); // length of excerpt
			$theLayout['blog']['read_more'] = get_theme_var('blog,read_more_text'); // optional "Read more..." link
			$theLayout['blog']['blog_featured_images'] = (get_theme_var('blog,blog_show_image')) ? 1 : 0;
			$theLayout['blog']['post_featured_images'] = (get_theme_var('blog,post_show_image')) ? 1 : 0;
			$theLayout['blog']['paging'] = true; // just a default for shortcode purposes

			// footer settings
			$theFooter = get_footer_layout();	// returns footer options for current layout/page
			if(empty($theFooter['bg_repeat'])) {
				$defaultFooter = get_theme_var('design_setting,footer');
				$theFooter['bg_repeat'] = $defaultFooter['bg_repeat'];
			}
			$theFooter['top'] =  isset($theFooter['content_top'])? prep_content($theFooter['content_top'], 1, 1) : ''; // ($content, $allowHTML, $allowShortcodes)
			$theFooter['bottom'] = isset($theFooter['content_bottom'])? prep_content($theFooter['content_bottom'], 1, 1) : '';

			
			
			// GENERATE THEME OUTPUT

			// Include master design file.
			//................................................................
			// This contains the main structure or outline of the design. 
			// Supports context specific design files "design-home.php", if it doesn't exist the template falls back to "design.php" (default)
			//
			// 2012-09-27 - Updated to use "locate_template" instead of "get_template_part" for the 'require once'. This prevents the design template from being loaded multiple times.
			//................................................................

			$designTemplate = array(
				'design-'.$the_context.'.php', // for a custom design template "design-{$context}.php"
				'design.php' );
			locate_template( $designTemplate, true, true); // Updated to use "locate_templage" so the 'require once' option can be used. This prevents the design template from being loaded multiple times

		}
	
	}
endif;

	// Manages old template files before v2 updated Template Engine
	//................................................................

	if ( ! function_exists( 'create_page_layout' ) ) :

		// base function for creating layout
		function create_page_layout($source = 'post', $layout_key = false) {
			global $target_wp_template_file, $theme_design_loaded;

			if (!$theme_design_loaded) {
				create_theme_layout($source, 'template-' . $source, $layout_key);
			}
		}

	endif;

	// Tests for backwards compatibility before v2 updated Template Engine
	//................................................................
	
	if ( ! function_exists( 'page_layout_v1_compatibility' ) ) :

		// Updates the  function for creating layout
		function page_layout_v1_compatibility($source = 'post', $template = false, $layout_key = false) {
			
			// Check the file that would be loaded by default for the old function "create_page_layout()" and get the parameters.

			$values = array();
			if ( isset($template_array) && ($file = locate_template($template_array,false,false) ) ) {
				$template_file = implode( '', file( $file )); 
				$layoutParams = '';

				// Get the params from the old function
				if ( preg_match( '/create_page_layout\((.*)\)/mi', $template_file, $layoutParams ) ) {
					$templateParts = explode(',', str_replace( array("'", '"'," "), '', $layoutParams[1]));
				}

				// Update the variables to work from the old data
				$values = false;
				if ( !empty($templateParts) ) {
					$values[] = $templateParts[0]; // $source
					$values[] = _old_theme_content_by_context($source); // $template 
					$values[] = $templateParts[1]; // $layout_key
				}
			}

			return $values;
		}

	endif;


// Generate layout content containers
//................................................................
if ( ! function_exists( 'generate_content_layout' ) ) :

	function generate_content_layout($layout, $source = false) {
		global $context;
		
		// we could have a request with the context specified
		if ($source) $context = $source;
		// make sure we never have an empty context value
		if (!$context) $context = 'default';

		// one last check to make sure we have data for this layout
		if (!is_array($layout['layout_fields'])) {
			if ($layout['label']) {
				echo '<p>'. __('The selected layout contains no information. Please check your settings for the following layout: ', THEME_NAME) . $layout['label'] .'</p>';
			} else {
				echo '<p>'. __('The selected layout contains no information. Please check your design settings and ensure all layouts have containers and content blocks assigned.', THEME_NAME) .'</p>';
			}
			return false;
		} else {
			// no problems so far, start creating the layout containers
			$fields = $layout['layout_fields'];
			
			// loop through the containers
			$f = 1;
			foreach ((array) $fields as $container) {
				echo '<div id="'. $layout['key'] .'_c'. $f .'" class="clearfix">' . PHP_EOL; // with line break
				// loop through the columns in each container
				$c = 1;
				foreach ((array) $container as $column) {
					// set container class
					$columnClass = $column['class'].' clearfix';
					if (count($container) >1 && count($container) == $c) $columnClass .= ' last';
					// set container ID
					$columnID = $layout['key'] .'_c'. $f .'_'. $column['class'] .'_'. $c;
					// print container
					echo '	<div id="'. $columnID .'" class="'. $columnClass .'">';
					// loop through content items in each column
					$i = 0;
					if(isset($column['items'])) {
						foreach ((array) $column['items'] as $items) {
							// print each item
							echo '<div class="i'. $i .' ugc">';
							// each item can have multiple content blocks
							for($n = 0; $n < count($items); ++$n) {
								echo add_page_content($items[$n], $context);
							}
							echo '</div>';

							$i++;
						}
					}
					echo '</div> <!-- END id='. $columnID .' class='. $column['class'] .' -->' . PHP_EOL;
					$c++;
				}
				echo '</div> <!-- END id='. $layout['key'] .'_container_'. $f .' -->' . PHP_EOL . PHP_EOL;
				$f++;
			}
		
			return true;
			
		}

	}
	
endif;



// Add content to layout containers
//................................................................
if ( ! function_exists( 'add_page_content' ) ) :

	function add_page_content($content, $source = false) {
		global $context, $designBypassContent;
		
		// we could have a request with the context specified
		if ($source) $context = $source;
		// make sure we never have an empty context value
		if (!$context) $context = 'default';
		
		// check to make sure we have data for this set
		if (!is_array($content)) {
			return '<!-- '. __('No content selected. ', THEME_NAME)  .' -->';
		} else {

			// no problems so far, start outputting the content

			switch ($content['name']) {
				case "sidebar":
					if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('generated_sidebar-'.$content['value'])) : endif;
					break;
				case "content-static":
					$id = $content['value'];
					$id = (!is_numeric($id)) ? get_ID_by_slug($id, 'static_block') : $id;
					return theme_get_page($id);
					break;
				case "content-default":
					if ($designBypassContent) {
						// When a plugin tries to load content outside the design making direct calls to "get_header()" and "get_footer()"
						return $designBypassContent;
					} else {
						// the normal operation (what we want to happen)
						return theme_content_by_context();
					}
					break;
				case "divider":
					return '<hr />';
					break;
				default:
					// if no other option fits...
					return 'Unknown. Name: '. $content['name'] .', Value: '. $content['value'];
			}
		}
	}
	
endif;


// Insert static content from specified page
//................................................................
if ( ! function_exists( 'theme_get_page' ) ) :

	function theme_get_page($id, $title = false) {
		global $post, $tempPost;

		if (!$id) return false;

		// Get the page contenet
		$page_data = get_page( $id );
		$content = is_object($page_data)? $page_data->post_content : ''; // get the content

		// Apply filters
		if (get_meta('content_filters',$id) == 'All Content Filters') {
			// This option applies all content filters, including those added by plugins. It still makes use of the filters in Theme Settings
			$tempPost = $page_data;	// Used as global variable in 'the_content' filters
			$content = apply_filters('the_content', $content); // run remaining Wordpress filters such as paragraph tags.		
			unset($GLOBALS['tempPost']);
		} else {
			// Only apply default WP filters. This is the safe way to go so we don't risk any plugin injection/overrides of 'the_content'
			$content = wptexturize($content);
			$content = convert_smilies($content);
			$content = convert_chars($content);
			if (!wpautop_filter($id)) {
				$content = wpautop($content); // Add paragraph tags.
			}
			$content = shortcode_unautop($content);
			$content = prepend_attachment($content);
			$content = do_shortcode($content);
		}

		// Get title, add to output<br />
		if ($title) $content =  '<h3 class="content_static pageTitle">'. $page_data->post_title .'</h3>' . $content; 
		
		// Apply function specific
		$content = apply_filters('theme_get_page', $content, $id);
				
		return  $content;
	}
endif;

	// Filter 'theme_get_page' based on content type
	//................................................................
	add_filter( 'theme_get_page', 'content_type_specific', 10, 2 );
	
	if ( ! function_exists( 'content_type_specific' ) ) :
	
		function content_type_specific($content, $id) {

			if (!$id) 
				return $content;
			
			// Switch based on content type
			switch ( get_post_type($id) ) {
				
				// Static blocks
				case "static_block":
					
					// Check the "code" input area
					$code = get_meta('code',$id);
					if ($code) {
						// append code to end of content
						$content .= '<div class="staticBlockCode">'. prep_content($code, 0, 1) .'</div>';
					}
					
					// Get background elements
					$background = (get_meta('bg_color',$id)) ? '#' . str_replace('#','',get_meta('bg_color',$id)) : 'transparent';	// bg color
					$bg_image = (get_meta('bg_image',$id)) ? get_meta('bg_image',$id) : '';	// bg image
					
					// if image, get positioning
					if ($bg_image) {
						$background .= ' url(\''. $bg_image .'\')';
						switch (get_meta('bg_repeat',$id)) {
							case 'Repeat':
								$background .= ' repeat';
								break;
							case 'Repeat Horizontal':
								$background .= ' repeat-x';
								break;
							case 'Repeat Vertical':
								$background .= ' repeat-y';
								break;
							default:
								$background .= ' no-repeat';
						}
						$background .= ' '. strtolower(get_meta('bg_pos_x',$id)) .' '. strtolower(get_meta('bg_pos_y',$id));
					}
					
					// full style tag
					$background = 'style="background: '. $background .';"';
					
					// return the content with container
					return '<div class="staticBlockWrapper ugc" '.$background.'><div class="staticContent scid-'.$id.'">' . $content . '<div class="clear"></div></div></div>';
					
					break;
				
				// Other types... Add wrapper with content type as class name
				default:
					
					return '<div class="'. get_post_type($id) .' ugc">' . $content . '</div>';
				
			}
			
		}
	endif;

#-----------------------------------------------------------------
# Content templates based on context
#-----------------------------------------------------------------

// Get the template file for the page context
//................................................................
if ( ! function_exists( 'theme_content_by_context' ) ) :

	function theme_content_by_context($source = false) {
		global $context, $theLayout;
		
		// If we already have the content template, found with template_context()
		//................................................................
		if ( $theLayout['template'] && file_exists($theLayout['template']) ) {
			include( $theLayout['template'] ); 
			return;
		}

		// Incase there isn't a template file set already...
		//................................................................

		// we could have a request with the context specified
		if ($source) $context = $source;
		// make sure we never have an empty context value
		if (!$context) $context = 'default';
		
		// Set default locations to look for template file
		$template_names = array();
		$template_names[] = THEME_TEMPLATES.$context.'.php';
		$template_names[] = $context.'.php';
		$template_names[] = THEME_TEMPLATES.'blog.php';
		$template_names[] = 'blog.php';
		$template_names[] = 'index.php';
		
		// Apply filters
		$template_names = apply_filters( 'theme_content_by_context', $template_names, $context );
		
		// Load template file
		locate_template( $template_names, true, false );

	}


	// The old function, kept for backwards compatibility.
	// -----------------------------------------------------------------
	// When we detect that a file is being called witht he old  "create_page_layout()" function this will be used to load the correct template file.

	function _old_theme_content_by_context($source = false) {
		global $post, $context;
		
		// we could have a request with the context specified
		if ($source) $context = $source;
		// make sure we never have an empty context value
		if (!$context) $context = 'post';
		
		switch ($context) {
			case "home":
			case "search":
			case "category":
			case "author":
			case "tag":
			case "date":
			case "blog":
				$template_order = array(
					'template-'.$context.'.php', 
					'template-blog.php',
					'template.php'
				);
				// locate_template( $template_order, true, false ); // array: template cascade, include (if exists), require once
				return locate_template( $template_order, false, false );
				break;
			default:
				// if no other option fits...
				// get_template_part( 'template', $context ); // (has buil-in fallback to "template.php" if "template-< $context >.php" does not exist.
				$template_order = array(
					'template-'.$context.'.php', 
					'template.php'
				);
				return locate_template( $template_order, false, false );

		} // END switch ($context)

	}
endif;



#-----------------------------------------------------------------
# Layout, Header and Footer array queries
#-----------------------------------------------------------------

// Retun the layout settings array for current page
//................................................................

if ( ! function_exists( 'get_theme_layout' ) ) :

	function get_theme_layout($id = false, $source = false) {
		global $post, $context;

		// we could have a request with the context specified
		$the_context = ($source) ? $source : $context;
		
		// make sure we never have an empty context value
		if (!$the_context) $the_context = 'default';

		if (!$id) {
			
			// first, check for a user specified layout for this post/page
			// can't be used on the home page and other specific contexts because layout settings for first post will override
			$meta_layout_exclude = array( 'home', 'search', 'category', 'author', 'tag', 'date' );
			if ( !in_array($context, $meta_layout_exclude) ) {
				$id = get_meta('layout');
				$layout = get_theme_var('layouts,'.$id);
				// check if we have an array...
				if ( is_array($layout) ) return $layout;
			}
			
			// next, try using the context specific default (page, post, blog, home, etc.)
			$id = get_theme_var('design_setting,layout,'.$the_context);
			$layout = get_theme_var('layouts,'.$id);
			// check if we have an array...
			if ( is_array($layout) ) return $layout;
			
			// we checked the actual context, now we should test for fallbacks. only a few contexts have fallback values.
			// blog layout fallbacks
			$fallbacks = array('category', 'author', 'tag', 'date');
			if (in_array($the_context, $fallbacks)) {
				// Get the fallback layout
				$id = get_theme_var('design_setting,layout,blog');
				$layout = get_theme_var('layouts,'.$id);
				if ( is_array($layout) ) return $layout;
			}
			// BuddyPress fallbacks
			$fallbacks = array('bp-activity', 'bp-blogs', 'bp-forums', 'bp-groups', 'bp-groups-single', 'bp-members', 'bp-members-single', 'bp-members-single-plugins', 'bp-members-single-settings-general');
			if (in_array($the_context, $fallbacks)) {
				// Get the fallback layout
				$id = get_theme_var('design_setting,layout,bp');
				$layout = get_theme_var('layouts,'.$id);
				if ( is_array($layout) ) return $layout;
			}

			// next, use a default layout based on post type
			switch (get_post_type()) {
				case "page":
				case "post":
					$contentType = get_post_type();
					break;
				default:
					// if no other option fits...
					$contentType = 'default';
			}
			// other cases for $contentType
			if (is_home() || is_front_page()) $contentType = 'home';
			// now look up the default for this post/content type
			$id = get_theme_var('design_setting,layout,'.$contentType);
			$layout = get_theme_var('layouts,'.$id);
			// check if we have an array...
			if ( is_array($layout) ) return $layout;

			// last resort, get to the main default layout
			$id = get_theme_var('design_setting,layout,default');
			$layout = get_theme_var('layouts,'.$id);
			// check if we have an array...
			if ( is_array($layout) ) return $layout;

			// We found nothing configured so return the first layout in the database
			// This should never happen so we're grasping at straws.
			$layout = get_theme_var('layouts');
			if ( is_array($layout) && count($layout) > 0 ) {
				return $layout[0];  // send the first one found
			} else {
				return __('Error: No layouts found. Please make sure you have layouts in the design settings and assigned defaults for each content type.', THEME_NAME);
			}
			
		} else {
			
			// get the layout based on provided id
			// this means a specific header was requested.
			$layout = get_theme_var('layouts,'.$id);
			// check if we have an array...
			if ( is_array($layout) ) return $layout;
			
			// otherwise...
			return __('Error: Layout not found.', THEME_NAME);
			
		}
				
		return true;

	}

endif;


// Retun the header settings array for current page
//................................................................

if ( ! function_exists( 'get_header_layout' ) ) :

	function get_header_layout($id = false) {
		global $post, $context, $theLayout;

		if (!$id) {
			
			// first check for a user specified header for this post/page
			// can't be used on the home page because layout settings for first post will override
			if ($context != 'home' && $context != 'search') {
				$id = get_meta('layout_header');
				$header = get_theme_var('page_headers,'.$id);
				// check if we have an array...
				if ( is_array($header) ) return $header;
			}
			
			// next test the current layout for the header setting
			$id = $theLayout['header'];
			$header = get_theme_var('page_headers,'.$id);
			// check if we have an array...
			if ( is_array($header) ) return $header;

			// last we go to the default header setting
			$id = get_theme_var('design_setting,layout,header');
			$header = get_theme_var('page_headers,'.$id);
			// check if we have an array...
			if ( is_array($header) ) return $header;

			// We found nothing configured so return the first header in the database
			// This should never happen. 
			$header = get_theme_var('page_headers');
			if ( is_array($header) && count($header) > 0 ) {
				return $header[0];  // send the first one found
			} else {
				return __('Error: No headers found.', THEME_NAME);
			}
			
		} else {
			
			// get the header based on provided id
			// this means a specific header was requested.
			$header = get_theme_var('page_headers,'.$id);
			// check if we have an array...
			if ( is_array($header) ) return $header;
			
			// otherwise...
			return __('Error: Header not found.', THEME_NAME);
			
		}
				
		return true;
	}

endif;


// Retun the footer settings array for current page
//................................................................

if ( ! function_exists( 'get_footer_layout' ) ) :

	function get_footer_layout($id = false) {
		global $post, $context, $theLayout;
		
		if (!$id) {
			
			// first check for a user specified footer for this post/page
			// can't be used on the home page because layout settings for first post will override
			if ($context != 'home' && $context != 'search') {
				$id = get_meta('layout_footer');
				$footer = get_theme_var('page_footers,'.$id);
				// check if we have an array...
				if ( is_array($footer) ) return $footer;
			}
			
			// next test the current layout for the footer setting
			$id = $theLayout['footer'];
			$footer = get_theme_var('page_footers,'.$id);
			// check if we have an array...
			if ( is_array($footer) ) return $footer;

			// last we go to the default footer setting
			$id = get_theme_var('design_setting,layout,footer');
			$footer = get_theme_var('page_footers,'.$id);
			// check if we have an array...
			if ( is_array($footer) ) return $footer;

			// We found nothing configured so return the first footer in the database
			// This should never happen. 
			$footer = get_theme_var('page_footers');
			if ( is_array($footer) && count($footer) > 0 ) {
				return $footer[0];  // send the first one found
			} else {
				return __('Error: No footers found.', THEME_NAME);
			}
			
		} else {
			
			// get the footer based on provided id
			// this means a specific footer was requested.
			$footer = get_theme_var('page_footers,'.$id);
			// check if we have an array...
			if ( is_array($footer) ) return $footer;
			
			// otherwise...
			return __('Error: Footer not found.', THEME_NAME);
			
		}
				
		return true;
	}

endif;



#-----------------------------------------------------------------
# Header content (top graphics or slide show)
#-----------------------------------------------------------------

// Generate the slide show or top graphic (a.k.a. header graphic)
//................................................................

if ( ! function_exists( 'show_header_content' ) ) :

	function show_header_content($id) {
		global $post;
		
		// first check for if a user specified header content was set for this post/page
		if ( isset( $custom ) ) {
			 if ($custom == 'none') return false;	// no header content
			 $id = $custom; // set the id to the custom selection
		}
		
		if (!$id) {
			
			// that's not good, we need an id to use
			
		} else {
			
			$content = explode(",", $id);
			
			switch ($content[0]) {
				case 'ss':
					// slide show 
					display_slideShow($content[1]);
					break;
				case 'rs':
					// Rev slider slideshow
					if ( function_exists( 'putRevSlider' ) ) {
						putRevSlider($content[1]);
					}					
					break;
				case 'static':
					// static content 
					$id = $content[1];
					$id = (!is_numeric($id)) ? get_ID_by_slug($id, 'static_block') : $id;
					echo theme_get_page($id);
					//display_headerGraphic($content[1]);
					break;
				default:
					// this shouldn't happen.
			}
			
		}
				
		return true;
	}

endif;



#-----------------------------------------------------------------
# Slide show
#-----------------------------------------------------------------

// Generate the slide show
//................................................................

if ( ! function_exists( 'display_slideShow' ) ) :

	function display_slideShow($id, $width = false, $height = false) {
		global $themeScripts, $jsPath, $SS_IDs, $load_slide_show_scripts;
		
		$SS_IDs = ($SS_IDs) ? $SS_IDs + 1 : 1; // global ID used to increment each slide show index (prevents duplicate IDs)
		
		// Tells the  the contact form scripts to load in the footer
		$load_slide_show_scripts = true;
		
		// get the selected slide show
		$ss = get_theme_var('slideshows,'.$id);
		
		if ( is_array($ss) ) {
			// ok we have a slide show, look up the columns and such
			
			
			$cols = $ss['columns'];		// number of image columns
			$fx = $ss['transition'];	// default transition
			$speed = ($ss['speed']) ? $ss['speed'] : '1000';		// speed of transition
			$pauseOnHover = ($ss['pause_on_hover'] == true) ? '1' : '0'; // pause when mouse over
			$default_width = '972';		// default width
			$default_height = '325';	// default height
			
			// If width/height is specified, for example by a shortcode we use it, or default to slide show setting. 
			$w = ($width) ? $width : $ss['width'];
			$h = ($height) ? $height : $ss['height'];
			
			// Double check size setting. Slide show width/height can be left blank so we use default.  
			if (!$w) $w = $default_width;
			if (!$h) $h = $default_height;

			$total_width = $w;
			
			if ($cols > 1) {
				// get width for multiple image columns
				$w = floor($total_width/$cols);
			}
			
			$scripts = array();
			
			echo '	<section class="slideShow" style="height: '.$h.'px;">';
			for ($n = 1; $n <= $cols; $n++) {
				
				// variables
				$ssID = 'SS-'.$SS_IDs.'-'.$n;
				$slide_fx = array();
				
				// multi-column stuff
				if ($cols > 1) {
					// columns get special class
					$class = 'class="ss-column"';
					// last column width, add remainder
					if ($n == $cols) {
						$w +=  fmod($total_width,$cols);
					}
				}
				
				// get the slides
				$slides = $ss['slides_'.$n];
				if ( is_array($slides) ) {
					$class = ( isset( $class ) ) ? $class : '';
					// create the container
					echo '<div id="'. $ssID .'" '.$class.'>';
					// print each slide
					foreach ($slides as $slide) {
						echo '<div style="width: '.$w.'px; height: '.$h.'px; overflow: hidden;">';
							display_slide($slide, $w, $h);
						echo '</div>';
						$slide_fx[] = ($slide['transition']) ? $slide['transition'] : $fx; // if this slide has a custom transition, else use default.
					}
					// close the container
					echo '</div> <!-- END "'. $ssID .'" -->';
					
					// add variables to the JavaScript array
					$fx_string = implode(",", $slide_fx);
					$scripts[$ssID] = array(
						'fx' => $fx_string, 
						'timing' => $ss['timing'] . '000',
						'speed' => $speed,
						'pause' => $pauseOnHover
					);

				} else {
					_e('No slides.', THEME_NAME);
				}

			}
			echo '	</section> <!-- END id="SlideShow" -->';
			echo '<div id="'. $ssID .'_nav" class="slideShowPager"></div>';
			
			// add the JS for the slide show to initialize
			echo '<script type="text/javascript"> jQuery(document).ready(function($) { ';
				$jsID = str_replace ('-','_',$id);
				
				// multiple slide shows so we do a few things differeng. 
				foreach ($scripts as $key => $value) {
					
					$slideTimeout = $value['timing'];
					
					// multi-column specific items
					if (count($scripts) > 1) {
						$slideTimeout = '0';			// 1) Stopped at load.
						$timing =  $value['timing'];	// 2) Timing and "next" transition triggered by interval function
					}
					
					// create slide show (or column) JavaScript
					echo '$("#'. $key .'").cycle({ before: beforeSlide, after: afterSlide, fx:"'. $value['fx'] .'",timeout:'. $slideTimeout .',speed:'. $value['speed'] .',pause:'. $value['pause'] .',randomizeEffects:0, pager:"#'. $key .'_nav"});';

				}
				
				// create a JS function to access slide show. if multiple columns this function will trigger "next slide" to prevent sync issues.
				echo 'SS_'.$jsID .' = $("#'. implode(',#',array_keys($scripts)) .'");';
				
				// advance multi-column slides using "setInteral"
				if (count($scripts) > 1) {
					echo 'setInterval("SS_'.$jsID.'.cycle(\'next\');", '. $timing .');';
				}
					
			echo '}); </script>';
		}

	}

endif;


// Get a single slide
//................................................................

if ( ! function_exists( 'display_slide' ) ) :

	function display_slide($slide, $w, $h) {
		
		// output the content based on the format selected
		switch ($slide['format']) {
			case 'image':
				if ($slide['link']) {
					$target = ($slide['target_blank']) ? 'target="_blank"' : '';
					$before = '<a href="'. $slide['link'] .'" '. $target .'>';
					$after = '</a>';
				}
				$before = ( isset( $before ) ) ? $before : '';
				$after = ( isset( $after ) ) ? $after : '';
				echo '<div class="slide imageSlide">' . $before .'<img src="'. $slide['media'] .'" />'. $after . '</div>';  // nesting image inside DIV to help with PNG transparency issues in IE
				//echo $before .'<img src="'. $slide['media'] .'" width="'. $w .'" height="'. $h .'" />'. $after;
				break;
			case 'video':
			
				$video = video_info($slide['media']);
				
				// valid YouTube or Vimeo 
				if ($video) {
					
					switch ($video['video_type']) {
						case 'youtube':
							$url = 'http://www.youtube.com/v/'. $video['video_id'];
							$embedMethod = 'youtube-iframe';
							break;
						case 'vimeo':						
							$url = 'http://player.vimeo.com/video/'. $video['video_id'];
							$embedMethod = 'vimeo-iframe';
							break;
						default:
							// nothing here yet.
					}

					echo '<div class="slide videoSlide">';
					embed_video($url, $w, $h, '', $embedMethod);
					echo '</div>';
						
				
				} else {
					_e('Please enter a valid Youtube or Vimeo Url', THEME_NAME);
				}
				
				break;
			case 'content':
				$before = '<div class="slide contentSlide" style="width: '. $w .'px; height: '. $h .'px;"><div class="inner ugc">';
				$after = '</div></div>';
				echo $before . prep_content($slide['content'], 1, 1) . $after;
				break;
			case 'background-image':
				if ($slide['media']) {
					$bg = 'transparent url('. $slide['media'] .') no-repeat 50% 50%';
					$before = '<div class="slide contentSlide" style="background: '. $bg .'; width: '. $w .'px; height: '. $h .'px;"><div class="inner ugc">';
					$after = '</div></div>';
				}
				echo $before . prep_content($slide['content'], 1, 1) . $after;
				break;
			case 'framed-image':
				$before = '<div style="width: '. $w .'px; height: '. $h .'px;" class="framedMedia">';
				$after = '</div>';
				// setup image
				if ($slide['media']) {
					$img = '<img src="'. $slide['media'] .'" />';
					if ($slide['link']) {
						$target = ($slide['target_blank']) ? 'target="_blank"' : '';
						$img = '<a href="'. $slide['link'] .'" '. $target .'>'. $img .'</a>';
					}
					$img = '<div class="slide framedImage">'. $img .'</div>';
				}
				// setup content
				$content = prep_content($slide['content'], 1, 1);
				$content = '<div class="framedContent ugc">'. $content .'</div>';
				// position image (left/right)
				$output = $img . $content;	// default - image left
				if ($slide['position'] == 'right') $output = $content . $img;
				// output slide
				echo $before . $output . $after;
				break;
			case 'framed-video':
				$before = '<div style="width: '. $w .'px; height: '. $h .'px;" class="slide framedMedia">';
				$after = '</div>';
				// setup image
				if ($slide['media']) {

					$video = video_info($slide['media']);
					
					// valid YouTube or Vimeo 
					if ($video) {

						switch ($video['video_type']) {
							case 'youtube':
								$url = 'http://www.youtube.com/v/'. $video['video_id'];
								$embedMethod = 'youtube-iframe';
								break;
							case 'vimeo':						
								$url = 'http://player.vimeo.com/video/'. $video['video_id'];
								$embedMethod = 'vimeo-iframe';
								break;
							default:
								// nothing here yet.
						}
					
					} else {
						_e('Please enter a valid Youtube or Vimeo Url', THEME_NAME);
					}

				}
				// setup content
				$content = prep_content($slide['content'], 1, 1);
				$content = '<div class="framedContent ugc">'. $content .'</div>';

				// output slide
				echo $before;
	
						if ($slide['position'] == 'right') echo $content;
				
						echo '<div class="framedVideo">';
						embed_video($url, '612', '374', '', $embedMethod);
						echo '</div>';

						if ($slide['position'] !== 'right') echo $content;

				echo $after;
				break;
		}
	}

endif;


#-----------------------------------------------------------------
# Portfoliio page
#-----------------------------------------------------------------

// Get the data and template for a portfolio page
//................................................................
if ( ! function_exists( 'make_theme_portfolio_page' ) ) :
	
	function make_theme_portfolio_page($settings = false) {
		global $portfolio_query, $shortcode_values, $paged;
		
		$shortcode_values = $settings;
		$portfolio = array();
		
		if ($settings && is_array($settings)) {

			$portfolio = $settings;
			
			// Unique ID. Used to identify multiple portfolios on one page.
			$id = base_convert(microtime(), 10, 36); // a random id generated for each form. 
			$shortcode_values['id'] = $id;

			// set some defaults in the shortcode values
			//................................................................

			// columns
			if (!$shortcode_values['columns']) {
				$shortcode_values['columns'] = 3; // default
			}
			
			// paging
			if (!$portfolio['paging']) {
				$shortcode_values['paging'] = true; // default is to use paging
			} else {
				$sc_val = strtolower(trim($portfolio['paging']));
				if ($sc_val == 'no' || $sc_val == 'n' || $sc_val == '0' || $sc_val == 'false' || $sc_val == 'hide' || $sc_val == 'off' ) {
					$shortcode_values['paging'] = false;
				}
			}
			
			// posts per page
			if (!$portfolio['posts_per_page']) {
				$portfolio['posts_per_page'] = floor((int) $shortcode_values['columns'] * 2);
			}
			

			// check a few query values that need preperation
			//................................................................

			// the categories to include (converted to array)
			if (isset($portfolio['category']) && $portfolio['category']) {
				$cats = explode(',', $settings['category']);
				foreach ((array) $cats as $cat) :
					$portfolio['category__in'][] = trim($cat);
				endforeach;
				unset($portfolio['category']); // not a query variable so we remove it
			}
			
			// the post/page ID's to include (converted to array)
			if (isset($portfolio['page_id']) && $portfolio['page_id']) {
				$page_id = explode(',', $settings['page_id']);
				foreach ((array) $page_id as $id) :
					$portfolio['post__in'][] = trim($id);
				endforeach;
				unset($portfolio['page_id']); // not a query variable so we remove it
			}

			// set orderby to "menu_order" for pages, if not specified by user (otherwise it will use the published date)
			if (isset($portfolio['post_type']) && ($portfolio['post_type'] == 'page') && !isset($portfolio['orderby']) ) {
				$portfolio['orderby'] = 'menu_order';
				if (!isset($portfolio['order'])) $portfolio['order'] = 'ASC';
			}
			
			// not a query variables so we remove them
			unset($portfolio['columns']);
			unset($portfolio['excerpt']);
			unset($portfolio['excerpt_length']);
			unset($portfolio['title']);
			unset($portfolio['link']);
			unset($portfolio['image_ratio']);
			unset($portfolio['content_width']);
			unset($portfolio['paging']);

			
			
			// for pagination to work...
			if ($shortcode_values['paging']) {
				// if turned off we don't want this variable set or it will be populated by other shortcodes
				$portfolio['paged'] = $paged;
			}
			
			// create query the portfolio (pass it to $wp_query)
			$portfolio_query = new WP_Query( $portfolio );
	
			// turn on output buffering to capture script output
			ob_start(); 
			get_template_part( 'template', 'portfolio' );
			
			// get the content that has been output
			$content = ob_get_clean();
			wp_reset_query();
			
			// return the content
			return $content;
		}
		
	}

endif;


#-----------------------------------------------------------------
# Blog page
#-----------------------------------------------------------------

// Get the data and template for a blog page (shortcode based)
//................................................................
if ( ! function_exists( 'make_theme_blog_page' ) ) :
	
	function make_theme_blog_page($settings = false) {
		global $wp_query, $blog_query, $shortcode_values, $theLayout, $paged;
				
		$shortcode_values = $settings;
		$blog = array();
		
		if ($settings && is_array($settings)) {

			$blog = $settings;
			
			
			// check a few query values that need preperation
			//................................................................

			// the categories to include (converted to array)
			if ($blog['category']) {
				$cats = explode(',', $settings['category']);
				foreach ((array) $cats as $cat) :
					$blog['category__in'][] = trim($cat);
				endforeach;
				unset($blog['category']); // not a query variable so we remove it
			}

			// the post/page ID's to include (converted to array)
			if (isset($blog['page_id']) && $blog['page_id']) {
				$page_id = explode(',', $settings['page_id']);
				foreach ((array) $page_id as $id) :
					$blog['post__in'][] = trim($id);
				endforeach;
				unset($blog['page_id']); // not a query variable so we remove it
			}
			
			// set orderby to "menu_order" for pages, if not specified by user (otherwise it will use the published date)
			if (isset($blog['post_type']) && ($blog['post_type'] == 'page') && !$blog['orderby'] ) {
				$blog['orderby'] = 'menu_order';
				if (!$blog['order']) $blog['order'] = 'ASC';
			}
			
			// set $shortcode_values where not specified with blog defaults 
			//................................................................
			$shortcode_values['image']['width'] = $theLayout['blog']['image']['width'];
			$shortcode_values['image']['height'] = $theLayout['blog']['image']['height'];
			$shortcode_values['excerpt_length'] = $theLayout['blog']['excerpt_length'];
			$shortcode_values['read_more'] = $theLayout['blog']['read_more'];
			
			
			// Overwrite defaults where shortcode specifies value. Some naming varies in shortcode attribute to 
			// be easier for end users to understand)
			//....................................................................................................

			if ( isset($blog['image_width']) ) $shortcode_values['image']['width'] = (int)$blog['image_width'];
			if ( isset($blog['image_height']) ) $shortcode_values['image']['height'] = (int)$blog['image_height'];
			if ($blog['excerpt_length']) $shortcode_values['excerpt_length'] = (int)$blog['excerpt_length'];
			if (isset($blog['read_more']) && $blog['read_more']) $shortcode_values['read_more'] = $blog['read_more'];
		
			// A loop created to handle all booleans entered with human "true" or "false" (yes or no)
			// 
			// 	Values of $booleans array: 
			// 		key = shortcode variable name , 
			// 		value = array( database variable name [, true value (optional) ] [, false value (optional)] )
			
			$booleans = array( 
				'show_date' => array( 'name' => 'post_date' ),
				'author_link' => array( 'name' => 'author_name' ),
				'author_avatar' => array( 'name' => 'author_avatar' ),
				'comments_link' => array( 'name' => 'comments_link' ),
				'show_category_list' => array( 'name' => 'category_list' ),
				'show_tag_list' => array( 'name' => 'tag_list' ),
				'post_content' => array( 'name' => 'use_excerpt', 'true' => 'excerpt', 'false' => 'full' ),
				'images' => array( 'name' => 'blog_featured_images' ),
				'paging' => array( 'name' => 'paging' )
			);
			foreach ((array) $booleans as $shortcode_name => $db_name ) :

				// the values from shortcode and database
				$sc_val = isset($blog[$shortcode_name])? strtolower(trim($blog[$shortcode_name])) : 0;
				$db_val = $theLayout['blog'][$db_name['name']]; // the master array to get database defaults
				
				// if a shortcode value was set for this option
				if ($sc_val) {
					
					// test if it meets a TRUE or FALSE condition
					if (isset($db_name['true']) && $db_name['true']) {
						// a custom 'TRUE' value is provided
						if ( $sc_val == $db_name['true'] ) $db_val = true;
					} else {
						// cover the human variations of "yes" that might be used
						if ( $sc_val == 'yes' || $sc_val == 'y' || $sc_val == '1' || $sc_val == 'true' || $sc_val == 'show' || $sc_val == 'on' ) $db_val = true;
					}
					// see if a custom 'true' value is provided
					if (isset($db_name['false']) && $db_name['false']) {
						// a custom 'FALSE' value is provided
						if ( $sc_val == $db_name['false'] ) $db_val = false;
					} else {
						// cover the human variations of "no" that might be used
					if ( $sc_val == 'no' || $sc_val == 'n' || $sc_val == '0' || $sc_val == 'false' || $sc_val == 'hide' || $sc_val == 'off' ) $db_val = false;
					}
					
				}
				
				// set the final value 
				// if no conditions were met for a shortcode value the database default is used
				$shortcode_values[$db_name['name']] = $db_val;
			
			endforeach;
			
			
			// shortcode only values
			//................................................................

			// not a query variables so we remove them
			unset($blog['show_date']);
			unset($blog['author_link']);
			unset($blog['author_avatar']);
			unset($blog['comments_link']);
			unset($blog['post_content']); // options: excerpt, full
			unset($blog['excerpt_length']);
			unset($blog['read_more']);
			unset($blog['images']);
			unset($blog['image_width']);
			unset($blog['image_height']);
			unset($blog['paging']);
			
			// for pagination to work...
			if ($shortcode_values['paging']) {
				// if turned off we don't want this variable set or it will be populated by other shortcodes
				$blog['paged'] = $paged;
			}
			
			// create query the portfolio (pass it to $wp_query)
			$blog_query = new WP_Query( $blog );

			// turn on output buffering to capture script output
			ob_start();
			get_template_part( 'template', 'blog' );
			
			// get the content that has been output
			$content = ob_get_clean();
			wp_reset_query();
			
			// destroy variables after use to avoid intermixing when not wanted
			unset($GLOBALS['blog_query']);
			unset($GLOBALS['shortcode_values']);
			
			// return the content
			return $content;
		}
		
	}

endif;



#-----------------------------------------------------------------
# Contact Form
#-----------------------------------------------------------------

// Required JS files for contact forms
//................................................................

// Create contact form
//................................................................
if ( ! function_exists( 'make_theme_contact_form' ) ) :
	
	function make_theme_contact_form($form = false) {
		global $themeScripts, $jsPath, $themePath, $load_contact_form_scripts;
				
		// Tells the  the contact form scripts to be loaded in the footer
		$load_contact_form_scripts = true;
		
		// Unique ID. Enables multiple forms on a single page.
		$id = base_convert(microtime(), 10, 36); // a random id generated for each form. 
		
		// get the main data from the database
		$contact_form_data = get_theme_var('contact_form');
		$contact_fields_data = $contact_form_data['contact_fields'];
		
		if ( count($contact_fields_data) <= 0 ) {
			return '<p><code>'. __('No form fields created. Go to: "Settings > Contact Form"', THEME_NAME) .'</code></p>';
		}
		
		// set all variables based on defaults
		$send_to = isset($contact_form_data['to'])? $contact_form_data['to'] : '';
		$subject = isset($contact_form_data['subject'])? $contact_form_data['subject'] : '';
		$thankyou_message = isset($contact_form_data['thankyou'])? $contact_form_data['thankyou'] : '';
		$button = isset($contact_form_data['button'])? $contact_form_data['button'] : '';
		$use_captcha = isset($contact_form_data['captcha'])? $contact_form_data['captcha'] : '';
		$fields = $contact_fields_data;
		$error_messages = array();
		$hidden_to = '';
		$hidden_subject = '';
		$theFields = '';
		
		if ($form && is_array($form)) {
			// the form data array was provided, override defaults as provided
			if (isset($form['to']) && $form['to']) $send_to = $form['to'];
			if (isset($form['subject']) && $form['subject']) $subject = $form['subject'];
			if (isset($form['thankyou']) && $form['thankyou']) $thankyou_message = $form['thankyou'];
			if (isset($form['button']) && $form['button']) $button = $form['button'];
			if (isset($form['captcha']) && $form['captcha']) {
				$use_captcha = ($form['captcha'] == 'yes') ? 1 : 0;
			}
			if ($form['fields']) {
				$items = explode(',', $form['fields']);
				// get each field name included and recreate the $fileds array with the data
				$new_fields = array();
				foreach ((array) $items as $item) :
					$item = sanitize_title($item);
					if (is_array($contact_fields_data[$item])) {
						$new_fields[$item] = $contact_fields_data[$item];
					}
				endforeach;
				if (!empty($new_fields)) $fields = $new_fields;
			}
		}
		
		// Special Fields
		// The "to" and "subject" fields may need to be included as hidden fields if their values were
		// specified in the shortcode and differ from the database defaults.
		if (isset($contact_form_data['to']) && ($send_to != $contact_form_data['to'])) {
			$hidden_to = '<input type="hidden" name="_R" value="'. strEnc($send_to) .'" />';
		}
		if (isset($contact_form_data['subject']) && ($subject != $contact_form_data['subject'])) {
			$hidden_subject = '<input type="hidden" name="_S" value="'. strEnc($subject) .'" />';
		}
		
		
		// Image verification
		if ($use_captcha) {
			
			//session_start(); // part of including CAPTCHA
			if (!isset($_SESSION)) session_start(); // if captcha
			
			// add captcha to the fields array
			$fields['form_captcha'] = array(
				'field_type' => 'captcha', 
				'key' => 'captcha', 
				'required' => true, 
				'error_required' => __('You must enter the verification code', THEME_NAME),
				'minlength' => 4,
				'maxlength' => '',
				'size' => array('width' => 150, 'height' => '')
			);
		}


		// get all the inputs and fields
		foreach ((array) $fields as $field) {
			
			$field_class = 'formField';
			$field_style = '';
			$labelClass = "formTitle";
			$field_id = $field['key'].'_'.$id;
			$field_min = ($field['minlength']) ? 'minlength="'.$field['minlength'].'"' : '';
			$field_max = ($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : '';
			$values = explode(',', $field['values']);
			
			// text input class
			$field_class .= ($field['field_type'] == 'text' || $field['field_type'] == 'textarea') ? ' textInput' : '';
			
			// overlabel class
			if ($field['field_type'] == 'text' || $field['field_type'] == 'textarea' || $field['field_type'] == 'captcha') {
				$labelClass .= " overlabel";
			}
			
			// required field
			if ($field['required']) {
				// add required class
				$field_class .= ' required';
				// error message
				if ($field['error_required']) {
					// add custom "required" error message
					$error_messages[$field['key']]['required'] = $field['error_required'];
				}
			}
			// validated field
			if ($field['validation']) {
				// make sure field type can have validation
				if ($field['field_type'] == 'text' || $field['field_type'] == 'textarea') {
					// add validation class
					$field_class .= ' '.$field['validation'];
					// error message
					if ($field['error_validation']) {
						// add custom "required" error message
						$error_messages[$field['key']][$field['validation']] = $field['error_validation'];
					}
				}
			}

			// width/height setting
			if ($field['size']['width']) {
				// add width
				$field_style .= ' width: '. (int)$field['size']['width'] .'px;';
			}
			if ($field['size']['height']) {
				// add height
				$field_style .= ' height: '. (int)$field['size']['height'] .'px;';
			}
			$field_style = 'style="'. trim($field_style) .'"';
			
			if ($field['field_type'] !== 'hidden') {
				// opening container element (not needed for hidden fields)
				$theFields .= '<div class="fieldContainer field_type_'.$field['field_type'].'">';
			}

			// the default label
			$defaultLabel = '<label for="'.$field_id.'" class="'.$labelClass.'">'.$field['label'].'</label>';
			// the default caption
			$defaultCaption = '<div class="formCaption">'.prep_content($field['caption'], 1, 0).'</div>';

			switch ($field['field_type']) {
				case 'hidden':
					$theFields .= '<input type="hidden" id="'.$field_id.'" name="'.$field['key'].'" value="'. $field['values'] .'" />';
					break;
				case 'text':
					$theFields .= $defaultLabel;
					$theFields .= '<input type="text" id="'.$field_id.'" name="'.$field['key'].'" class="'. trim($field_class) .'" '.$field_style.' '.$field_min.' '.$field_max.' />';
					$theFields .= $defaultCaption;
					break;
				case 'textarea':
					$theFields .= $defaultLabel;
					$theFields .= '<textarea id="'.$field_id.'" name="'.$field['key'].'" class="'. trim($field_class) .'" '.$field_style.' '.$field_min.' '.$field_max.'></textarea>';
					$theFields .= $defaultCaption;
					break;
				case 'select':
					$options = '<option value=""></option>'; // blank first option
					foreach ((array) $values as $value) :
						$options .= '<option value="'.sanitize_title($value).'">'.trim($value).'</option>';
					endforeach;
					$theFields .= $defaultLabel;
					$theFields .= '<select id="'.$field_id.'" name="'.$field['key'].'" class="'. trim($field_class) .' selectInput" '.$field_style.'>';
					$theFields .= $options;
					$theFields .= '</select>';
					$theFields .= $defaultCaption;
					break;
				case 'radio':
					$theFields .= '<label for="'.$field_id.'" class="'.$labelClass.' radioSetTitle">'.$field['label'].'</label>';
					$n = 1;
					foreach ((array) $values as $value) :
						$theFields .= '<label for="'.$field_id.'_'.$n.'" class="radioLabel">';
						$theFields .= '<input type="'.$field['field_type'].'" id="'.$field_id.'_'.$n.'" name="'.$field['key'].'" class="'. trim($field_class) .' radioInput" value="'.sanitize_title($value).'" />';
						$theFields .= '<span>'.trim($value).'</span></label>';
						$n++;
					endforeach;
					$theFields .= $defaultCaption;
					break;
				case 'checkbox':
					$theFields .= '<label for="'.$field_id.'" class="checkboxLabel">';
					$theFields .= '<input type="'.$field['field_type'].'" id="'.$field_id.'" name="'.$field['key'].'" class="'. trim($field_class) .' checkboxInput" />';
					$theFields .= '<span>'.$field['label'].'</span></label>';
					$theFields .= $defaultCaption;
					break;
				case 'captcha':
					$theFields .= '<img src="'. FRAMEWORK_URL .'utilities/captcha/captcha.php?_'. base_convert(mt_rand(0x1679616, 0x39AA3FF), 10, 36) .'" id="image_'.$field_id.'" />' . 
								  '<br />';
								  
					$theFields .= '<div>';
					$theFields .= '<label for="'.$field_id.'" class="'.$labelClass.' captchaLabel">'.__('Image Verification', THEME_NAME).'</label>';
					$theFields .= '<input type="text" id="'.$field_id.'" name="'.$field['key'].'" class="required textInput" '.$field_style.' '.$field_min.' '.$field_max.' />';
					$theFields .= '<div class="formCaption">'.
								  '<a href="#" onclick="document.getElementById(\'image_'.$field_id.'\').src=\''. FRAMEWORK_URL .'/utilities/captcha/captcha.php?_\'+Math.random(); return false;" id="refresh_img_'.$field_id.'">'.
								  __('Refresh image?', THEME_NAME) .
								  '</a></div>';
					$theFields .= '</div>';
					break;
			}


			if ($field['field_type'] !== 'hidden') {
				// closing container element (not needed for hidden fields)
				$theFields .= '</div>';
			}
		}
		
		// Create the output and return
		//................................................................
		$content = '';

		// this code initializes the JS validation for the form
		$content .= '
		<script type="text/javascript">
			jQuery(document).ready(function($) { 
				$("#form_'.$id.'").validate({ 
					submitHandler: function(form) {
						ajaxContact(form);	// form is valid, submit it
						return false;
					},
					errorElement: "em",
					errorPlacement: function(error, element) {
						error.appendTo( element.closest("div") );
					},
					highlight: function(element, errorClass, validClass) {
						$(element).addClass(errorClass).removeClass(validClass);
						$(element).closest(".fieldContainer").addClass(errorClass);
					},
					unhighlight: function(element, errorClass, validClass) {
						$(element).removeClass(errorClass).addClass(validClass);
						$(element).closest(".fieldContainer").removeClass(errorClass);
					},
					messages: {';
					$msg_cnt = 1;
					$msg_total = count($error_messages);
					foreach ($error_messages as $field => $error) :
						$content .= '"' . $field .'" : {';
						$err_cnt = 1;
						$err_total = count($error);
						foreach ($error as $type => $message) :
							$output = $type .': "'. $message .'"';
							$content .= ($err_cnt == $err_total) ? $output : $output.',';
							$err_cnt++;
						endforeach;
						$content .= ($msg_cnt == $msg_total) ? '}' : '},';
						$msg_cnt++;
					endforeach;
		$content .= '}
				});
			});
		</script>';
		
		// Start of form
		$content .= '
		<div class="contactFormWrapper contactShortcode" style="position:relative;">
			<div class="formMessages-top" style="position:absolute;">
				<div class="formSuccess" style="display:none;">'.prep_content($thankyou_message, 1, 0).'</div>
			</div>
			<form class="cmxform publicContactForm" id="form_'.$id.'" method="post" action="">
				<fieldset><legend>'.__('Contact Form', THEME_NAME).'</legend>';
			
		// Form fields
		$content .= $theFields;
			
		// End of from
		$content .= '
					<div class="contactFormBottom">
						<button type="submit" class="btn formSubmit"><span>'.$button.'</span></button>
						<span class="sending invisible"><img src="'.$themePath.'assets/images/ajax-loader.gif" width="24" height="24" alt="Loading..." class="sendingImg" /></span>
						'. $hidden_to . $hidden_subject .'
						<input class="" type="hidden" name="mail_action" value="send" />
					</div>
				</fieldset>
			</form>
			<div class="formMessages-bottom">
				<div class="formError" style="display:none;"></div>
			</div>
		</div>';
		
		return $content;
		
		}

endif;



#-----------------------------------------------------------------
# Design elements
#-----------------------------------------------------------------

// Get the logo
//................................................................

/*
	Returns the theme's logo. Optional parameters can be set to 
	specify the URL of the link, if an image tag is returned and
	if a link tag is returned.
*/

if ( ! function_exists( 'theme_logo' ) ) :
	
	function theme_logo( $link = '', $default = array() ) {
				
		echo get_theme_logo( $link, $default );
	}
	
endif;

if ( ! function_exists( 'get_theme_logo' ) ) :
	
	function get_theme_logo( $link = '', $default = array() ) {
		
		// The link URL
		$link = ($link) ? $link : get_home_url();
		
		// The logo image
		$image = get_theme_logo_image(true, $default);
		
		// The full logo (link + image)
		$logo = '<a href="'. $link .'" >'. $image .'</a>';
		
		return $logo;
	}
	
endif;

if ( ! function_exists( 'get_theme_logo_image' ) ) :
	
	function get_theme_logo_image( $HTML = true, $default = array() ) {
		global $theLayout;
		
		if ($theLayout['logo']['img'] || !empty($default)) {
			
			// Theme options specified image
			if ($theLayout['logo']['img']) {
				$src = $theLayout['logo']['img'];
				$w = ($theLayout['logo']['w']) ? 'width="'.$theLayout['logo']['w'].'"'	: '';
				$h = ($theLayout['logo']['h']) ? 'height="'.$theLayout['logo']['h'].'"'	: '';
				$class = ($theLayout['logo']['class']) ? 'class="'.$theLayout['logo']['class'].'"'	: '';
			// Default logo (from array)
			} else {
				$src = $default['image'];
				$w = ($default['width'])	? 'width="'.$default['width'].'"'	: '';
				$h = ($default['height'])	? 'height="'.$default['height'].'"'	: '';
				$class = ($default['class']) ? 'class="'.$default['class'].'"'	: '';
			}
				
			$image = ($HTML) ? '<img src="'. $src .'" alt="'. get_bloginfo('name') .'" '. $class .'  '. $w .'  '. $h .' />' : $src;
		}
		
		return $image;
	}
	
endif;



#-----------------------------------------------------------------
# Stylesheet related features
#-----------------------------------------------------------------

// Find the skin file setting
//................................................................

if ( ! function_exists( 'get_theme_skin' ) ) :
	
	function get_theme_skin($file = false) {
		global $post, $context, $theLayout;
		
		if (!$file) {
			
			// first check for a skin setting at the page/post level 
			// except on home page because it causes problems (PHP versions < 5.3)
			if ($context != 'home' && $context != 'search') {
				$file = get_meta('skin');
				if ( $file && $file != '- Select -' ) return $file;
			}
			
			// next test the layout for a skin setting
			$file = $theLayout['skin'];
			if ( $file ) return $file;

			// last, the design default skin setting
			$file = get_theme_var('design_setting,skin');
			if ( $file ) return $file;

			// We found nothing configured so return skin 1
			return 'style-skin-1.css';
			
		} else {
			
			// get the skin based on provided filename
			return $file;
			
		}
	}
	
endif;


// Output the CSS link for the skin file
//................................................................
if ( ! function_exists( 'theme_skin' ) ) :
	
	function theme_skin($file = false) {
		
		if (!$file) $file = get_theme_skin();
		echo '<link rel="stylesheet" type="text/css" href="'. trailingslashit(get_bloginfo('stylesheet_directory')) . $file .'" id="SkinCSS" />' . "\n";
	}
	
endif;


// Add specific CSS class to body tag by filter
//................................................................
if ( ! function_exists( 'theme_body_class' ) ) :
	
	function theme_body_class($classes) {
		global $theLayout, $theHeader, $theFooter;
		
		// add classes to body tag based on theme settings
		
		// fade in content (set's a special "invisible" class)
		switch (get_theme_var('options,fade_in_content')) {
			case 'all':
				$classes[] = 'invisibleAll';
				break;
			case 'content':
				$classes[] = 'invisibleMiddle';			
				break;
		}

		// header content
		if (!$theHeader['content']) {
			$classes[] = 'noHeaderContent';
		}
		
		// theme skin
		if (get_theme_skin()) {
			$classes[] = str_replace('.css', '', get_theme_skin());
		}
		
		// return the $classes array
		return $classes;
	}

	add_filter('body_class','theme_body_class');
	
endif;


?>
