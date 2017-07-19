<?php // Themes Options Menu

$shortname = "theme";
$page_handle = $shortname . '-options';
$options = array (

array(	"name" => __('General Settings', 'gp_lang'),
      	"type" => "title"),

		array(	"type" => "open",
      	"id" => $shortname."_general_settings"),

		array(
		"name" => __('General Settings', 'gp_lang'),
		"type" => "header",
      	"id" => $dirname."_general_header",
      	"desc" => __('This section controls the general settings for the theme.', 'gp_lang')
      	),

  		array("type" => "divider"),
  		
 		array(  
		"name" => __('Theme Skin', 'gp_lang'),
        "desc" => __('Choose the theme skin (can be overridden on individual posts/pages).', 'gp_lang'),
        "id" => $shortname."_skin",
        "std" => "darkblue",
		"options" => array('darkblue' => __('Dark Blue', 'gp_lang'), 'darkgrey' => __('Dark Grey', 'gp_lang'), 'maroon' => __('Maroon', 'gp_lang'), 'teal' => __('Teal', 'gp_lang'), 'brown' => __('Brown', 'gp_lang'), 'purple' => __('Purple', 'gp_lang'), 'orange' => __('Orange', 'gp_lang')),
        "type" => "select"),
        
        array(
		"name" => __('Custom Stylesheet', 'gp_lang'),
		"desc" => __('Enter the relative URL to your custom stylesheet e.g. <code>lib/css/custom-style.css</code> (can be overridden on individual posts/pages).', 'gp_lang'),
        "id" => $shortname."_custom_stylesheet",
        "std" => "",
        "type" => "text"),
        
		array("type" => "divider"), 
		
		array(
		"name" => __('Custom Logo Image', 'gp_lang'),
        "desc" => __('Upload your own logo.', 'gp_lang'),
        "id" => $shortname."_logo",
        "std" => "",
        "type" => "upload"),

		array(
		"name" => __('Logo Width', 'gp_lang'),
        "desc" => __('Enter the logo width (set to half the original logo width for retina displays).', 'gp_lang'),
        "id" => $dirname."_logo_width",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"),

		array(
		"name" => __('Logo Height', 'gp_lang'),
        "desc" => __('Enter the logo height (set to half the original logo height for retina displays).', 'gp_lang'),
        "id" => $dirname."_logo_height",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"),
			
		array(
		"name" => __('Logo Top Margin', 'gp_lang'),
        "desc" => __('Enter the top margin of your logo.', 'gp_lang'),
        "id" => $shortname."_logo_top",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"),

		array(
		"name" => __('Logo Left Margin', 'gp_lang'),
        "desc" => __('Enter the left margin of your logo.', 'gp_lang'),
        "id" => $shortname."_logo_left",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"),
		
		array(
		"name" => __('Logo Bottom Margin', 'gp_lang'),
        "desc" => __('Enter the bottom margin of your logo.', 'gp_lang'),
        "id" => $shortname."_logo_bottom",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"),
		
		array("type" => "divider"),
		
		array(
		"name" => __('Contact Info', 'gp_lang'),
        "desc" => __('Enter your contact info to display at the top of the page.', 'gp_lang'),
        "id" => $shortname."_contact_info",
        "std" => "",
        "type" => "textarea"),

		array("type" => "divider"),  

		array(  
		"name" => __('Responsive', 'gp_lang'),
        "desc" => __('Choose whether the theme responds to the width of the browser window.', 'gp_lang'),
        "id" => $dirname."_responsive",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),

		array("type" => "divider"),
		   				
		array(  
		"name" => __('Retina Images', 'gp_lang'),
        "desc" => __('Choose whether to crop images at double the size on retina displays (newer iPhones/iPads, Macbook Pro etc.).', 'gp_lang'),
        "id" => $dirname."_retina",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
                		
		array("type" => "divider"),
				
		array(  
		"name" => __('RSS Feed Button', 'gp_lang'),
        "desc" => __('Display the RSS feed button with the default RSS feed or enter a custom feed below.', 'gp_lang'),
        "id" => $shortname."_rss_button",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
		array(
		"name" => __('RSS URL', 'gp_lang'),
        "id" => $shortname."_rss",
        "std" => "",
        "type" => "text"),
        
        array(
		"name" => __('Twitter URL', 'gp_lang'),
        "id" => $shortname."_twitter",
        "std" => "",
        "type" => "text"),
        
        array(
		"name" => __('Facebook URL', 'gp_lang'),
        "id" => $shortname."_facebook",
        "std" => "",
        "type" => "text"),
        
        array(
		"name" => __('Dribbble URL', 'gp_lang'),
        "id" => $shortname."_dribbble",
        "std" => "",
        "type" => "text"),    
        
        array(
		"name" => __('Digg URL', 'gp_lang'),
        "id" => $shortname."_digg",
        "std" => "",
        "type" => "text"),    

        array(
		"name" => __('Delicious URL', 'gp_lang'),
        "id" => $shortname."_delicious",
        "std" => "",
        "type" => "text"),

        array(
		"name" => __('YouTube URL', 'gp_lang'),
        "id" => $shortname."_youtube",
        "std" => "",
        "type" => "text"),

        array(
		"name" => __('Vimeo URL', 'gp_lang'),
        "id" => $shortname."_vimeo",
        "std" => "",
        "type" => "text"),
        
        array(
		"name" => __('Google+ URL', 'gp_lang'),
        "id" => $shortname."_googleplus",
        "std" => "",
        "type" => "text"),
        
        array(
		"name" => __('LinkedIn URL', 'gp_lang'),
        "id" => $shortname."_linkedin",
        "std" => "",
        "type" => "text"),

        array(
		"name" => __('MySpace URL', 'gp_lang'),
        "id" => $shortname."_myspace",
        "std" => "",
        "type" => "text"),
                
        array(
		"name" => __('Flickr URL', 'gp_lang'),
        "id" => $shortname."_flickr",
        "std" => "",
        "type" => "text"),
        
 		array(
		"name" => __('Additional Social Icons', 'gp_lang'),
        "desc" => __('Add additional social icons by entering the link and image HTML code e.g. <code>&lt;a href=&quot;http://social-link.com&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;'.get_template_directory_uri().'/images/socialicon.png&quot; alt=&quot;&quot; /&gt;&lt;/a&gt;</code>', 'gp_lang'),
        "id" => $shortname."_additional_social_icons",
        "std" => "",
        "type" => "textarea"),
        
		array("type" => "divider"),
		
		array(
		"name" => __('Footer Content', 'gp_lang'),
        "desc" => __('Enter the content you want to display in your footer (e.g. copyright text).', 'gp_lang'),
        "id" => $shortname."_footer_content",
        "std" => "",
        "type" => "textarea"),

		array("type" => "divider"), 
		
		array(
		"name" => __('Scripts', 'gp_lang'),
        "desc" => __('Enter any scripts that need to be embedded into your theme (e.g. Google Analytics)', 'gp_lang'),
        "id" => $shortname."_scripts",
        "std" => "",
        "type" => "textarea"),
        
		array("type" => "divider"),

		array(  
		"name" => __('JW Player For YouTube Videos', 'gp_lang'),
        "desc" => __('Use the JW Player for YouTube vidoes (not recommended!).', 'gp_lang'),
        "id" => $dirname."_jwplayer",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
		
		array(  
		"name" => __('Old Video Shortcode', 'gp_lang'),
        "desc" => __('WordPress now has it\'s own native [video] shortcode. Choose this option to use the old video shortcode instead.', 'gp_lang'),
        "id" => $dirname."_old_video_shortcode",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
                        
		array("type" => "divider"),
		
	 	array(
		"name" => __('Preload Effect', 'gp_lang'),
        "desc" => __('Choose whether to use the preload effect on content in category, archive, tag pages etc (this can be specified individually from shortcodes using <code>preload="true"</code>).', 'gp_lang'),
        "id" => $shortname."_preload",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
		array("type" => "close"),	

array(	"name" => __('Category Settings', 'gp_lang'),
		"type" => "title"),

		array(	"type" => "open",
      	"id" => $shortname."_category_settings"),

		array(
		"name" => __('Category Settings', 'gp_lang'),
		"type" => "header",
      	"id" => $dirname."_cat_header",
      	"desc" => __('This section controls the global settings for all category, archive, tag and search result pages.', 'gp_lang')
      	),
 
  		array("type" => "divider"),
  		
        array(
		"name" => __('Thumbnail Width', 'gp_lang'),
        "desc" => __('The width to crop the thumbnail to (can be overridden on individual posts, set to 0 to have a proportionate width).', 'gp_lang'),
        "id" => $shortname."_cat_thumbnail_width",
        "std" => "560",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 

  		array(
		"name" => __('Thumbnail Height', 'gp_lang'),
        "desc" => __('The height to crop the thumbnail to (can be overridden on individual posts, set to 0 to have a proportionate height).', 'gp_lang'),
        "id" => $shortname."_cat_thumbnail_height",
        "std" => "250",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 

		array(
		"name" => __('Image Wrap', 'gp_lang'),
        "desc" => __('Choose whether the page content wraps around the featured image.', 'gp_lang'),
        "id" => $shortname."_cat_image_wrap",
        "std" => "Enable",
		"options" => array('Enable' => __('Enable', 'gp_lang'), 'Disable' => __('Disable', 'gp_lang')),
        "type" => "select"),

		array(
		"name" => __('Hard Crop', 'gp_lang'),
        "desc" => __('Choose whether the image is hard cropped.', 'gp_lang'),
        "id" => $shortname."_cat_hard_crop",
        "std" => "Enable",
		"options" => array('Enable' => __('Enable', 'gp_lang'), 'Disable' => __('Disable', 'gp_lang')),
        "type" => "select"),
                
  		array("type" => "divider"),

 		array( 
		"name" => __('Sidebar', 'gp_lang'),
        "desc" => __('Choose which sidebar area to display.', 'gp_lang'),
        "id" => $shortname."_cat_sidebar",
        "std" => "default",
        "type" => "select_sidebar"),
        
  		array("type" => "divider"),
          		
		array( 
		"name" => __('Layout', 'gp_lang'),
        "desc" => __('Choose the page layout.', 'gp_lang'),
        "id" => $shortname."_cat_layout",
        "std" => "sb-right",
		"options" => array('sb-left' => __('Sidebar Left', 'gp_lang'), 'sb-right' => __('Sidebar Right', 'gp_lang'), 'fullwidth' => __('Fullwidth', 'gp_lang')),
        "type" => "select"),

        array("type" => "divider"), 
        		
 		array(  
		"name" => __('Frame', 'gp_lang'),
        "desc" => __('Choose whether to display a frame.', 'gp_lang'),
        "id" => $shortname."_cat_frame",
        "std" => "frame",
		"options" => array('frame' => __('Enable', 'gp_lang'), 'no-frame' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
        array("type" => "divider"), 
        		
 		array(  
		"name" => __('Padding', 'gp_lang'),
        "desc" => __('Choose whether to display padding around the page.', 'gp_lang'),
        "id" => $shortname."_cat_padding",
        "std" => "padding",
		"options" => array('padding' => __('Enable', 'gp_lang'), 'no-padding' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
        array("type" => "divider"), 
        
		array(
		"name" => __('Top Content Panel', 'gp_lang'),
        "desc" => __('Choose whether to display the top content panel.', 'gp_lang'),
        "id" => $shortname."_cat_top_content_panel",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
  		array(
		"name" => __('Title', 'gp_lang'),
        "desc" => __('Choose whether to display the page title.', 'gp_lang'),
        "id" => $shortname."_cat_title",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
 		array(
		"name" => __('Breadcrumbs', 'gp_lang'),
        "desc" => __('Choose whether to display breadcrumbs.', 'gp_lang'),
        "id" => $shortname."_cat_breadcrumbs",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
 		array(
		"name" => __('Search Bar', 'gp_lang'),
        "desc" => __('Choose whether to display the search bar.', 'gp_lang'),
        "id" => $shortname."_cat_search",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

  		array("type" => "divider"),
  		
		array(
		"name" => __('Content Display', 'gp_lang'),
        "desc" => __('Choose whether to display the full post content or an excerpt.', 'gp_lang'),
        "id" => $shortname."_cat_content_display",
        "std" => "0",
		"options" => array(__('Excerpt', 'gp_lang'), __('Full Content', 'gp_lang')),
        "type" => "radio"),
        
		array("type" => "divider"),
		
        array(
		"name" => __('Excerpt Length', 'gp_lang'),
        "desc" => __('The number of characters in excerpts.', 'gp_lang'),
        "id" => $shortname."_cat_excerpt_length",
        "std" => "400",
        "type" => "text",
		"size" => "small"),
 
  		array("type" => "divider"),
		
		array(  
		"name" => __('Read More Link', 'gp_lang'),
        "desc" => __('Choose whether to display the read more links.', 'gp_lang'),
        "id" => $shortname."_cat_read_more",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
 
  		array("type" => "divider"),
  		
		array(  
		"name" => __('Post Date', 'gp_lang'),
        "desc" => __('Choose whether to display the post date.', 'gp_lang'),
        "id" => $shortname."_cat_date",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),

		array(  
		"name" => __('Post Author', 'gp_lang'),
        "desc" => __('Choose whether to display the post author.', 'gp_lang'),
        "id" => $shortname."_cat_author",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),

		array(  
		"name" => __('Post Categories', 'gp_lang'),
        "desc" => __('Choose whether to display the post categories.', 'gp_lang'),
        "id" => $shortname."_cat_cats",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
		array(  
		"name" => __('Post Comments', 'gp_lang'),
        "desc" => __('Choose whether to display the post comments.', 'gp_lang'),
        "id" => $shortname."_cat_comments",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
 
		array(  
		"name" => __('Post Tags', 'gp_lang'),
        "desc" => __('Choose whether to display the post tags.', 'gp_lang'),
        "id" => $shortname."_cat_tags",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
                       
		array("type" => "close"),
		
array(	"name" => __('Post Settings', 'gp_lang'),
		"type" => "title"),

		array(	"type" => "open",
      	"id" => $shortname."_post_settings"),

		array(
		"name" => __('Post Settings', 'gp_lang'),
		"type" => "header",
      	"id" => $dirname."_ost_header",
      	"desc" => __('This section controls the global settings for all posts, but most settings can be overridden on individual posts.', 'gp_lang')
      	),

  		array("type" => "divider"),
  		        
		array(  
		"name" => __('Featured Image', 'gp_lang'),
        "desc" => __('Choose whether to display the featured image (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_show_post_image",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),
        
        array(
		"name" => __('Image Width', 'gp_lang'),
        "desc" => __('The width to crop the image to (can be overridden on individual posts, set to 0 to have a proportionate width).', 'gp_lang'),
        "id" => $shortname."_post_image_width",
        "std" => "560",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 

  		array(
		"name" => __('Image Height', 'gp_lang'),
        "desc" => __('The height to crop the image to (can be overridden on individual posts, set to 0 to have a proportionate height).', 'gp_lang'),
        "id" => $shortname."_post_image_height",
        "std" => "250",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 
		
		array(
		"name" => __('Image Wrap', 'gp_lang'),
        "desc" => __('Choose whether the page content wraps around the featured image (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_post_image_wrap",
        "std" => "Enable",
		"options" => array('Enable' => __('Enable', 'gp_lang'), 'Disable' => __('Disable', 'gp_lang')),
        "type" => "select"),

		array(
		"name" => __('Hard Crop', 'gp_lang'),
        "desc" => __('Choose whether the image is hard cropped.', 'gp_lang'),
        "id" => $shortname."_post_hard_crop",
        "std" => "Enable",
		"options" => array('Enable' => __('Enable', 'gp_lang'), 'Disable' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
  		array("type" => "divider"),

 		array( 
		"name" => __('Sidebar', 'gp_lang'),
        "desc" => __('Choose which sidebar area to display.', 'gp_lang'),
        "id" => $shortname."_post_sidebar",
        "std" => "default",
        "type" => "select_sidebar"),
                
  		array("type" => "divider"),
      
		array( 
		"name" => __('Layout', 'gp_lang'),
        "desc" => __('Choose the page layout (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_post_layout",
        "std" => "sb-right",
		"options" => array('sb-left' => __('Sidebar Left', 'gp_lang'), 'sb-right' => __('Sidebar Right', 'gp_lang'), 'fullwidth' => __('Fullwidth', 'gp_lang')),
        "type" => "select"),

        array("type" => "divider"), 
        		
 		array(  
		"name" => __('Frame', 'gp_lang'),
        "desc" => __('Choose whether to display a frame (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_post_frame",
        "std" => "frame",
		"options" => array('frame' => __('Enable', 'gp_lang'), 'no-frame' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
 		array("type" => "divider"),

 		array(  
		"name" => __('Padding', 'gp_lang'),
        "desc" => __('Choose whether to display padding around the page (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_post_padding",
        "std" => "padding",
		"options" => array('padding' => __('Enable', 'gp_lang'), 'no-padding' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
        array("type" => "divider"), 
        
		array(
		"name" => __('Top Content Panel', 'gp_lang'),
        "desc" => __('Choose whether to display the top content panel (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_post_top_content_panel",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
  		array(
		"name" => __('Title', 'gp_lang'),
        "desc" => __('Choose whether to display the page title (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_post_title",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
 		array(
		"name" => __('Breadcrumbs', 'gp_lang'),
        "desc" => __('Choose whether to display breadcrumbs (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_post_breadcrumbs",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
 		array(
		"name" => __('Search Bar', 'gp_lang'),
        "desc" => __('Choose whether to display the search bar (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_post_search",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

 		array("type" => "divider"),

		array(  
		"name" => __('Post Author', 'gp_lang'),
        "desc" => __('Choose whether to display the post author.', 'gp_lang'),
        "id" => $shortname."_post_author",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
	
		array(  
		"name" => __('Post Date', 'gp_lang'),
        "desc" => __('Choose whether to display the post date.', 'gp_lang'),
        "id" => $shortname."_post_date",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
		array(  
		"name" => __('Post Categories', 'gp_lang'),
        "desc" => __('Choose whether to display the post categories.', 'gp_lang'),
        "id" => $shortname."_post_cats",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
		array(  
		"name" => __('Post Comment Number', 'gp_lang'),
        "desc" => __('Choose whether to display the number of post comments.', 'gp_lang'),
        "id" => $shortname."_post_comments",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
 
 		array(  
		"name" => __('Post Tags', 'gp_lang'),
        "desc" => __('Choose whether to display the post tags.', 'gp_lang'),
        "id" => $shortname."_post_tags",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
  		array("type" => "divider"),
  		
         array(
		"name" => __('Author Info Panel', 'gp_lang'),
        "desc" => __('Choose whether to display the author info panel (can also be inserted in individual posts using the <code>[author]</code> shortcode).', 'gp_lang'),
        "id" => $shortname."_post_author_info",
       "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
  		array("type" => "divider"),
		
		array( 
		"name" => __('Related Items', 'gp_lang'),
        "desc" => __('Choose whether to display a related items section (can also be inserted in individual posts using the <code>[related_posts]</code> shortcode).', 'gp_lang'), 
        "id" => $shortname."_post_related_items",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),

        array(
		"name" => __('Image Width', 'gp_lang'),
        "desc" => __('The width to crop the image to (set to 0 to have a proportionate width).', 'gp_lang'),
        "id" => $shortname."_post_related_image_width",
        "std" => "175",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 

  		array(
		"name" => __('Image Height', 'gp_lang'),
        "desc" => __('The height to crop the image to (set to 0 to have a proportionate height).', 'gp_lang'),
        "id" => $shortname."_post_related_image_height",
        "std" => "155",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 
         
		array("type" => "close"),

array(	"name" => __('Page Settings', 'gp_lang'),
		"type" => "title"),

		array(	"type" => "open",
      	"id" => $shortname."_page_settings"),

		array(
		"name" => __('Page Settings', 'gp_lang'),
		"type" => "header",
      	"id" => $dirname."_page_header",
      	"desc" => __('This section controls the global settings for all pages, but most settings can be overridden on individual pages.', 'gp_lang')
      	),

  		array("type" => "divider"),
  		   		
		array(  
		"name" => __('Featured Image', 'gp_lang'),
        "desc" => __('Choose whether to display the featured image (can be overridden on individual posts).', 'gp_lang'),
        "id" => $shortname."_show_page_image",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),
        
        array(
		"name" => __('Image Width', 'gp_lang'),
        "desc" => __('The width to crop the image to (can be overridden on individual pages, set to 0 to have a proportionate width).', 'gp_lang'),
        "id" => $shortname."_page_image_width",
        "std" => "560",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 

  		array(
		"name" => __('Image Height', 'gp_lang'),
        "desc" => __('The height to crop the image to (can be overridden on individual pages, set to 0 to have a proportionate height).', 'gp_lang'),
        "id" => $shortname."_page_image_height",
        "std" => "250",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 
		
		array(
		"name" => __('Image Wrap', 'gp_lang'),
        "desc" => __('Choose whether the page content wraps around the featured image (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_page_image_wrap",
        "std" => "Enable",
		"options" => array('Enable' => __('Enable', 'gp_lang'), 'Disable' => __('Disable', 'gp_lang')),
        "type" => "select"),

		array(
		"name" => __('Hard Crop', 'gp_lang'),
        "desc" => __('Choose whether the image is hard cropped.', 'gp_lang'),
        "id" => $shortname."_page_hard_crop",
        "std" => "Enable",
		"options" => array('Enable' => __('Enable', 'gp_lang'), 'Disable' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
  		array("type" => "divider"),

 		array( 
		"name" => __('Sidebar', 'gp_lang'),
        "desc" => __('Choose which sidebar area to display.', 'gp_lang'),
        "id" => $shortname."_page_sidebar",
        "std" => "default",
        "type" => "select_sidebar"),
                
   		array("type" => "divider"),
   		
		array( 
		"name" => __('Layout', 'gp_lang'),
        "desc" => __('Choose the page layout (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_page_layout",
        "std" => "sb-right",
		"options" => array('sb-left' => __('Sidebar Left', 'gp_lang'), 'sb-right' => __('Sidebar Right', 'gp_lang'), 'fullwidth' => __('Fullwidth', 'gp_lang')),
        "type" => "select"),

        array("type" => "divider"), 
        		
 		array(  
		"name" => __('Frame', 'gp_lang'),
        "desc" => __('Choose whether to display a frame (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_page_frame",
        "std" => "frame",
		"options" => array('frame' => __('Enable', 'gp_lang'), 'no-frame' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
   		array("type" => "divider"),
   		
 		array(  
		"name" => __('Padding', 'gp_lang'),
        "desc" => __('Choose whether to display padding around the page (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_page_padding",
        "std" => "padding",
		"options" => array('padding' => __('Enable', 'gp_lang'), 'no-padding' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
        array("type" => "divider"), 
        
 		array(
		"name" => __('Top Content Panel', 'gp_lang'),
        "desc" => __('Choose whether to display the top content panel (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_page_top_content_panel",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
  		array(
		"name" => __('Title', 'gp_lang'),
        "desc" => __('Choose whether to display the page title (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_page_title",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
 		array(
		"name" => __('Breadcrumbs', 'gp_lang'),
        "desc" => __('Choose whether to display breadcrumbs (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_page_breadcrumbs",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
 		array(
		"name" => __('Search Bar', 'gp_lang'),
        "desc" => __('Choose whether to display the search bar (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_page_search",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),

		array(  
		"name" => __('Page Author', 'gp_lang'),
        "desc" => __('Choose whether to display the page author.', 'gp_lang'),
        "id" => $shortname."_page_author",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
   		
		array(  
		"name" => __('Page Date', 'gp_lang'),
        "desc" => __('Choose whether to display the page date.', 'gp_lang'),
        "id" => $shortname."_page_date",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
		array(  
		"name" => __('Page Comment Number', 'gp_lang'),
        "desc" => __('Choose whether to display the number of page comments.', 'gp_lang'),
        "id" => $shortname."_page_comments",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),

   		array("type" => "divider"),
   		
		array(  
		"name" => __('Author Info Panel', 'gp_lang'),
        "desc" => __('Choose whether to display an author info panel.', 'gp_lang'),
        "id" => $shortname."_page_author_info",
        "std" => "1",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),
        
		array("type" => "close"),

array(	"name" => __('BuddyPress Settings', 'gp_lang'),
		"type" => "title"),

		array(	"type" => "open",
      	"id" => $shortname."_bp_settings"),

		array(
		"name" => __('BuddyPress Settings', 'gp_lang'),
		"type" => "header",
      	"id" => $dirname."_bp_header",
      	"desc" => __('This section controls the BuddyPress pages created by the plugin.', 'gp_lang')
      	),

  		array("type" => "divider"),
  		   		
		array(  
		"name" => __('Login/Register Links', 'gp_lang'),
        "desc" => __('Choose whether to display the login and register links in the header.', 'gp_lang'),
        "id" => $shortname."_bp_links",
        "std" => "0",
		"options" => array(__('Enable', 'gp_lang'), __('Disable', 'gp_lang')),
        "type" => "radio"),

		array(
		"name" => __('Login URL', 'gp_lang'),
        "desc" => __('Enter the URL you have assigned the Login page template to.', 'gp_lang'),
        "id" => $shortname."_login_url",
        "std" => "",
        "type" => "text"),

  		array("type" => "divider"),

 		array( 
		"name" => __('Sidebar', 'gp_lang'),
        "desc" => __('Choose which sidebar area to display.', 'gp_lang'),
        "id" => $shortname."_bp_sidebar",
        "std" => "default",
        "type" => "select_sidebar"),
        
   		array("type" => "divider"),
   		
		array( 
		"name" => __('Layout', 'gp_lang'),
        "desc" => __('Choose the page layout (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_bp_layout",
        "std" => "fullwidth",
		"options" => array('sb-left' => __('Sidebar Left', 'gp_lang'), 'sb-right' => __('Sidebar Right', 'gp_lang'), 'fullwidth' => __('Fullwidth', 'gp_lang')),
        "type" => "select"),

        array("type" => "divider"), 
        		
 		array(  
		"name" => __('Frame', 'gp_lang'),
        "desc" => __('Choose whether to display a frame (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_bp_frame",
        "std" => "frame",
		"options" => array('frame' => __('Enable', 'gp_lang'), 'no-frame' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
   		array("type" => "divider"),
   		
 		array(  
		"name" => __('Padding', 'gp_lang'),
        "desc" => __('Choose whether to display padding around the page (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_bp_padding",
        "std" => "padding",
		"options" => array('padding' => __('Enable', 'gp_lang'), 'no-padding' => __('Disable', 'gp_lang')),
        "type" => "select"),
        
        array("type" => "divider"), 
        
 		array(
		"name" => __('Top Content Panel', 'gp_lang'),
        "desc" => __('Choose whether to display the top content panel (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_bp_top_content_panel",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
  		array(
		"name" => __('Title', 'gp_lang'),
        "desc" => __('Choose whether to display the page title (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_bp_title",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
 		array(
		"name" => __('Breadcrumbs', 'gp_lang'),
        "desc" => __('Choose whether to display breadcrumbs (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_bp_breadcrumbs",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),

   		array("type" => "divider"),
   		
 		array(
		"name" => __('Search Bar', 'gp_lang'),
        "desc" => __('Choose whether to display the search bar (can be overridden on individual pages).', 'gp_lang'),
        "id" => $shortname."_bp_search",
        "std" => "Show",
		"options" => array('Show' => __('Show', 'gp_lang'), 'Hide' => __('Hide', 'gp_lang')),
        "type" => "select"),
   				
		array("type" => "close"),	


array(	"name" => __('Style Settings', 'gp_lang'),
		"type" => "title"),

		array(	"type" => "open",
      	"id" => $dirname."_style_settings"),
	
		array(
		"name" => __('Style Settings', 'gp_lang'),
		"type" => "header",
      	"id" => $dirname."_style_header",
      	"desc" => __('This section provides you with some basic settings to change the look of the theme. If you want to customize the design of the theme further you can add your own CSS styling in "CSS Settings" tab.', 'gp_lang')
      	),
  		
  		array("type" => "divider"),
  			
 		array(
		"name" => __('Primary Font', 'gp_lang'),
        "desc" => __('Enter the name of the font you want to use for the body text (e.g. Times New Roman, Arial, Oswald). To use <a href="http://www.google.com/webfonts" target="_blank">Google Web Fonts</a> get the "Standard" code provided by Google and add this to "Scripts" box in the "General Settings" tab.', 'gp_lang'),        
        "id" => $dirname."_primary_font",
        "std" => "",
        "type" => "text"), 

 		array(
		"name" => __('Primary Text Size', 'gp_lang'),
        "desc" => __('The text size used for the body text.', 'gp_lang'),
        "id" => $dirname."_primary_size",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"), 
				   		
 		array(
		"name" => __('Primary Text Color', 'gp_lang'),
        "desc" => __('The text color used for the body text.', 'gp_lang'),
        "id" => $dirname."_primary_text_color",
        "std" => "",
        "type" => "colorpicker"),
   		         
 		array(
		"name" => __('Primary Link Color', 'gp_lang'),
        "desc" => __('The link color used for the body text.', 'gp_lang'),
        "id" => $dirname."_primary_link_color",
        "std" => "",
        "type" => "colorpicker"), 

 		array(
		"name" => __('Primary Link Hover Color', 'gp_lang'),
        "desc" => __('The link hover color used for the body text.', 'gp_lang'),
        "id" => $dirname."_primary_link_hover_color",
        "std" => "",
        "type" => "colorpicker"), 
   		  
		array(
		"name" => __('Primary Background Color', 'gp_lang'),
        "desc" => __('The background color used for the main content and sidebar.', 'gp_lang'),
        "id" => $dirname."_primary_bg_color",
        "std" => "",
        "type" => "colorpicker"), 
		        		        
		array(
		"name" => __('Primary Border Color', 'gp_lang'),
        "desc" => __('The border color used for post meta, dividers etc.', 'gp_lang'),
        "id" => $dirname."_primary_border_color",
        "std" => "",
        "type" => "colorpicker"), 

  		array("type" => "divider"), 
				   		
 		array(
		"name" => __('Secondary Text Color', 'gp_lang'),
        "desc" => __('The text color used in post meta text.', 'gp_lang'),
        "id" => $dirname."_secondary_text_color",
        "std" => "",
        "type" => "colorpicker"),
   		         
 		array(
		"name" => __('Secondary Link Color', 'gp_lang'),
        "desc" => __('The link color used in post meta text.', 'gp_lang'),
        "id" => $dirname."_secondary_link_color",
        "std" => "",
        "type" => "colorpicker"), 

 		array(
		"name" => __('Secondary Link Hover Color', 'gp_lang'),
        "desc" => __('The link hover color used in post meta text.', 'gp_lang'),
        "id" => $dirname."_secondary_link_hover_color",
        "std" => "",
        "type" => "colorpicker"), 
   		  
 		array(
		"name" => __('Secondary Background Color', 'gp_lang'),
        "desc" => __('The background color used for input boxes, tabs etc.', 'gp_lang'),
        "id" => $dirname."_secondary_bg_color",
        "std" => "",
        "type" => "colorpicker"),

  		array("type" => "divider"),
  		  		
		array(
		"name" => __('Background Top Gradient Color', 'gp_lang'),
        "desc" => __('The top gradient color used for the background at the top of the page.', 'gp_lang'),
        "id" => $dirname."_top_bg_gradient_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Background Bottom Gradient Color', 'gp_lang'),
        "desc" => __('The bottom gradient color used for the background at the top of the page.', 'gp_lang'),
        "id" => $dirname."_bottom_bg_gradient_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Background Image', 'gp_lang'),
        "desc" => __('The background image used at the top of the page.', 'gp_lang'),
        "id" => $dirname."_bg_image",
        "std" => "",
        "type" => "upload"),
        
  		array("type" => "divider"),

		array(
		"name" => __('Elements Text Color', 'gp_lang'),
        "desc" => __('The text color used for the page elements e.g. top content panel, buttons etc.', 'gp_lang'),
        "id" => $dirname."_elements_text_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Elements Link Color', 'gp_lang'),
        "desc" => __('The link color used for the page elements e.g. top content panel, buttons etc.', 'gp_lang'),
        "id" => $dirname."_elements_link_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Elements Link Hover Color', 'gp_lang'),
        "desc" => __('The link hover color used for the page elements e.g. top content panel, buttons etc.', 'gp_lang'),
        "id" => $dirname."_elements_link_hover_color",
        "std" => "",
        "type" => "colorpicker"), 
                        
		array(
		"name" => __('Elements Top Gradient Color', 'gp_lang'),
        "desc" => __('The top gradient color used for the page elements e.g. top content panel, buttons etc.', 'gp_lang'),
        "id" => $dirname."_elements_top_gradient_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Elements Bottom Gradient Color', 'gp_lang'),
        "desc" => __('The bottom gradient color used for the page elements e.g. top content panel, buttons etc.', 'gp_lang'),
        "id" => $dirname."_elements_bottom_gradient_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Elements Top Gradient Hover Color', 'gp_lang'),
        "desc" => __('The top gradient hover color used for the page elements e.g. top content panel, buttons etc.', 'gp_lang'),
        "id" => $dirname."_elements_top_gradient_hover_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Elements Bottom Gradient Hover Color', 'gp_lang'),
        "desc" => __('The bottom gradient hover color used for the page elements e.g. top content panel, buttons etc.', 'gp_lang'),
        "id" => $dirname."_elements_bottom_gradient_hover_color",
        "std" => "",
        "type" => "colorpicker"), 
        
		array(
		"name" => __('Elements Border Color', 'gp_lang'),
        "desc" => __('The border color used for the page elements e.g. top content panel, buttons etc.', 'gp_lang'),
        "id" => $dirname."_elements_border_color",
        "std" => "",
        "type" => "colorpicker"), 
        
  		array("type" => "divider"),

		array(
		"name" => __('Navigation Top Gradient Color', 'gp_lang'),
        "desc" => __('The top navigation color used for the navigation menu.', 'gp_lang'),
        "id" => $dirname."_nav_top_gradient_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Navigation Bottom Gradient Color', 'gp_lang'),
        "desc" => __('The bottom navigation color used for the navigation menu.', 'gp_lang'),
        "id" => $dirname."_nav_bottom_gradient_color",
        "std" => "",
        "type" => "colorpicker"), 

 		array(
		"name" => __('Navigation Link Color', 'gp_lang'),
        "desc" => __('The link color used in navigation text.', 'gp_lang'),
        "id" => $dirname."_nav_link_color",
        "std" => "",
        "type" => "colorpicker"), 
 
  		array(
		"name" => __('Navigation Link Hover Color', 'gp_lang'),
        "desc" => __('The link hover color used in navigation text.', 'gp_lang'),
        "id" => $dirname."_nav_link_hover_color",
        "std" => "",
        "type" => "colorpicker"), 

		array(
		"name" => __('Navigation Dropdown Background Color', 'gp_lang'),
        "desc" => __('The background color used for the navigation dropdown menus.', 'gp_lang'),
        "id" => $dirname."_nav_dropdown_bg_color",
        "std" => "",
        "type" => "colorpicker"), 
 
 		array(
		"name" => __('Navigation Dropdown Border Color', 'gp_lang'),
        "desc" => __('The border color used for the navigation dropdown menus.', 'gp_lang'),
        "id" => $dirname."_nav_dropdown_border_color",
        "std" => "",
        "type" => "colorpicker"), 
                              
  		array("type" => "divider"),
 
  		array(
		"name" => __('Heading Font', 'gp_lang'),
        "desc" => __('Enter the name of the font you want to use for the headings (e.g. Times New Roman, Arial, Oswald). To use <a href="http://www.google.com/webfonts" target="_blank">Google Web Fonts</a> get the "Standard" code provided by Google and add this to "Scripts" box in the "General Settings" tab.', 'gp_lang'),
        "id" => $dirname."_heading_font",
        "std" => "",
        "type" => "text"), 

 		array(
		"name" => __('Heading 1 Text Size', 'gp_lang'),
        "desc" => __('The text size used in &lt;h1&gt; headings.', 'gp_lang'),
        "id" => $dirname."_heading1_size",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"),

 		array(
		"name" => __('Heading 2 Text Size', 'gp_lang'),
        "desc" => __('The text size used in &lt;h2&gt; headings.', 'gp_lang'),
        "id" => $dirname."_heading2_size",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"),
		
 		array(
		"name" => __('Heading 3 Text Size', 'gp_lang'),
        "desc" => __('The text size used in &lt;h3&gt; headings.', 'gp_lang'),
        "id" => $dirname."_heading3_size",
        "std" => "",
        "type" => "text",
		"size" => "small",
		"details" => "px"),
						           		
 		array(
		"name" => __('Heading Text Color', 'gp_lang'),
        "desc" => __('The text colour used in headings.', 'gp_lang'),
        "id" => $dirname."_heading_text_color",
        "std" => "",
        "type" => "colorpicker"), 

 		array(
		"name" => __('Heading Link Color', 'gp_lang'),
        "desc" => __('The link colour used in headings.', 'gp_lang'),
        "id" => $dirname."_heading_link_color",
        "std" => "",
        "type" => "colorpicker"), 
        
 		array(
		"name" => __('Heading Link Hover Color', 'gp_lang'),
        "desc" => __('The link hover colour used in headings.', 'gp_lang'),
        "id" => $dirname."_heading_link_hover_color",
        "std" => "",
        "type" => "colorpicker"),
   		 		  		  		                		
		array("type" => "close"),
				              			
array(	"name" => __('CSS Settings', 'gp_lang'),
		"type" => "title"),

		array(	"type" => "open",
      	"id" => $shortname."_css_settings"),

		array(
		"name" => __('CSS Settings', 'gp_lang'),
		"type" => "header",
      	"id" => $dirname."_css_header",
      	"desc" => __('You can add your own CSS below to style the theme. This CSS will not be lost if you update the theme. For more information on how to find the names of the elements you want to style click', 'gp_lang').' <a href="http://ghostpool.com/help/'.$dirname.'/help.html#customizing-design" target="_blank">'.__('here', 'gp_lang').'</a>.'
      	),

  		array("type" => "divider"),
  				
		array(
		"name" => __('Custom CSS', 'gp_lang'),
        "id" => $shortname."_custom_css",
        "std" => "",
        "type" => "textarea",
        "size" => "large"),

		array("type" => "close"),
	
);

function gp_add_admin(){

    global $themename, $dirname, $shortname, $options;
			
    if(isset($_GET['page']) && $_GET['page'] == basename(__FILE__)){

        if (isset($_REQUEST['action']) && 'save' == $_REQUEST['action']){

                foreach ($options as $value){
                    update_option($value['id'], $_REQUEST[ $value['id'] ]); }

                foreach ($options as $value){
                    if(isset($_REQUEST[ $value['id'] ])){ update_option($value['id'], $_REQUEST[ $value['id'] ] ); } else { delete_option($value['id']); } }

                header("Location: themes.php?page=theme-options.php&saved=true");
                die;

        } else if(isset($_REQUEST['action']) && 'reset' == $_REQUEST['action']){

            foreach ($options as $value){
                delete_option($value['id']);
            }
            
            update_option($dirname.'_theme_setup_status', '0');

            header("Location: themes.php?page=theme-options.php&reset=true");
            die;

        }

		else if(isset($_REQUEST['action']) && 'export' == $_REQUEST['action'])export_settings();
		else if(isset($_REQUEST['action']) && 'import' == $_REQUEST['action'])import_settings();

    }

    add_theme_page(__('Theme Options', 'gp_lang'), __('Theme Options', 'gp_lang'), 'manage_options', basename(__FILE__), 'gp_admin');

}

function gp_admin(){

    global $themename, $dirname, $shortname, $options;

    if (isset($_REQUEST['saved']) && $_REQUEST['saved'])echo '<div id="message" class="updated"><p><strong>'.__('Options Saved', 'gp_lang').'</strong></p></div>';
    if (isset($_REQUEST['reset']) && $_REQUEST['reset'])echo '<div id="message" class="updated"><p><strong>'.__('Options Reset', 'gp_lang').'</strong></p></div>';

?>

<!--Begin Theme Wrapper-->
<div id="gp-theme-options" class="wrap">
	
	<?php screen_icon('options-general'); ?>
	<h2><?php _e('Theme Options', 'gp_lang'); ?></h2>
	
	<p><h3><a href="http://ghostpool.com/help/<?php echo $dirname; ?>/help.html" target="_blank"><?php _e('Help File', 'gp_lang'); ?></a> | <a href="http://ghostpool.com/help/<?php echo $dirname; ?>/changelog.html" target="_blank"><?php _e('Changelog', 'gp_lang'); ?></a> | <a href="http://ghostpool.ticksy.com" target="_blank"><?php _e('Support', 'gp_lang'); ?></a> | <a href="http://www.ourwebmedia.com/ghostpool.php?aff=002" target="_blank"><?php _e('Premium Services', 'gp_lang'); ?></a></h3></p>
	
	<div id="import_export" class="hide-if-js">
	
		<h3><?php _e('Import Theme Options', 'gp_lang'); ?></h3>
		<div class="option-desc"><?php _e('If you have a back up of your theme options you can import them below.', 'gp_lang'); ?></div>
		
		<form method="post" enctype="multipart/form-data">
			<p class="submit"><input type="file" name="file" id="file" />
			<input type="submit" name="import" class="button" value="<?php _e('Upload', 'gp_lang'); ?>" /></p>
			<input type="hidden" name="action" value="import" />
		</form>

		<div class="divider"></div>
		
		<h3><?php _e('Export Theme Options', 'gp_lang'); ?></h3>
		<div class="option-desc"><?php _e('If you want to create a back up of all your theme options click the Export button below (will only back up your theme options and not your post/page/images data).', 'gp_lang'); ?></div>
		
		<form method="post">
			<p class="submit"><input name="export" type="submit" class="button" value="<?php _e('Export Theme Settings', 'gp_lang'); ?>" /></p>
			<input type="hidden" name="action" value="export" />
		</form>	
	
	</div>

	
	<form method="post">
		
		<div class="submit">	
		
			<a href="#TB_inline?height=300&amp;width=500&amp;inlineId=import_export" onclick="return false;" class="thickbox"><input type="button" class="button" value="<?php _e('Import/Export Theme Options' ,'gp_lang'); ?>"></a>
		
			<input name="save" type="submit" class="button-primary right" value="<?php _e('Save Changes', 'gp_lang'); ?>" />
			<input type="hidden" name="action" value="save" />
			
		</div>
		
		<div id="panels">


<?php foreach ($options as $value){
switch($value['type']){
case "open":
?>

<?php break;
case "title":
?>

<div class="panel" id="<?php echo $value['name']; ?>">


<?php break;
case "header":
?>

	<div class="option option-header">
		<?php if($value['name']) { ?><h2><?php echo $value['name']; ?></h2><?php } ?>
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>
	
	
<?php break;
case "close":
?>

</div>
<!--End Panel-->


<?php break;
case "divider":
?>

<div class="divider"></div>


<?php break;
case "clear":
?>

<div class="clear"></div>


<?php break;
case 'text':
?>
	
	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option"<?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?><?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?>>
		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if(get_option($value['id'])!= "") { echo get_option($value['id']); } else { echo $value['std']; } ?>" size="<?php if(isset( $value['size'] ) && $value['size'] == "small") { ?>3<?php } else { ?>40<?php } ?>" /><?php if(isset($value['details'])) { ?> <span><?php echo $value['details']; ?></span>&nbsp;<?php } ?>
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>


<?php break;
case 'upload':
?>

	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option uploader"<?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?>>
		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" size="40" class="upload" value="<?php echo get_option($value['id']); ?>" />
		<input type="button" id="<?php echo $value['id']; ?>_button" class="upload-image-button button" value="<?php _e('Upload', 'gp_lang'); ?>" />
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>
	

<?php
break;

case 'textarea':
?>

	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option"<?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?>>
		<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="70" rows="<?php if(isset( $value['size'] ) && $value['size'] == "large") { ?>50<?php } else { ?>10<?php } ?>"><?php if(get_option($value['id'])!= ""){ echo stripslashes(get_option($value['id'])); } else { echo $value['std']; } ?></textarea>
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>


<?php
break;
case 'select':
?>
	
	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option"<?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?>>
		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
			<?php foreach ($value['options'] as $key=>$option){ ?>
					<?php if(get_option($value['id']) != "") { ?>
						<option value="<?php echo $key; ?>" <?php if(get_option($value['id']) == $key){ echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>" <?php if($value['std'] == $key) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
					<?php } ?>
			<?php } ?>
		</select>
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>


<?php
break;
case 'select_taxonomy':
?>
		
	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option"<?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?>>
		<?php $terms = get_terms($value['cats'], 'hide_empty=0'); ?>
		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><option value=''><?php _e('None', 'gp_lang'); ?></option><?php foreach ($terms as $term): ?><option value="<?php echo $term->slug; ?>" <?php if(get_option($value['id'])==  $term->slug){ echo ' selected="selected"'; } ?>><?php echo $term->name; ?></option><?php endforeach; ?></select>
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>	


<?php
break;
case 'select_sidebar':
global $post, $wp_registered_sidebars;
?>
		
	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option"<?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?>>
		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
		<?php $sidebars = $wp_registered_sidebars; 
		if(is_array($sidebars) && !empty($sidebars)) { 
			foreach($sidebars as $sidebar) { 
				if(get_option($value['id']) != "") { ?>
					<option value="<?php echo $sidebar['id']; ?>"<?php if(get_option($value['id']) == $sidebar['id']) { echo ' selected="selected"'; } ?>><?php echo $sidebar['name']; ?></option>
				<?php } else { ?>				
					<option value="<?php echo $sidebar['id']; ?>"<?php if($value['std'] == $sidebar['id']) { echo ' selected="selected"'; } ?>><?php echo $sidebar['name']; ?></option>				
		<?php }}} ?>	
		</select>
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>


<?php
break;
case "checkbox":
?>
   
   
   	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option<?php if($value['extras'] == "multi"){ ?> multi-checkbox<?php } ?>">
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?><input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>


<?php        
break;
case "radio":
?>

	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option"<?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?>>
		<?php foreach ($value['options'] as $key=>$option){
		$radio_setting = get_option($value['id']);
		if($radio_setting != ''){
			if ($key == get_option($value['id'])){
				$checked = "checked=\"checked\"";
				} else {
					$checked = "";
				}
		}else{
			if($key == $value['std']){
				$checked = "checked=\"checked\"";
			}else{
				$checked = "";
			}
		}?>
			<div class="radio-buttons">
				<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'] . $key; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><label for="<?php echo $value['id'] . $key; ?>"><?php echo $option; ?></label>
			</div>	
		<?php } ?>
		<div class="clear"></div>
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>


<?php        
break;
case "colorpicker":
?>

	<?php if($value['name']) { ?><h3><?php echo $value['name']; ?></h3><?php } ?>
	<div class="option"<?php if(isset($value['style'])) { ?> style="<?php echo $value['style']; ?>"<?php } ?>>
		<script type="text/javascript">
			jQuery(document).ready(function($){  
			<?php global $wp_version; if(version_compare($wp_version, '3.5', '>=')) { ?>
				$("#<?php echo $value['id']; ?>").wpColorPicker();
			<?php } else { ?>
				$("#<?php echo $value['id']; ?>_picker").farbtastic('#<?php echo $name; ?>');	
			<?php } ?>
			});
		</script>
		<input type="text" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php if(get_option($value['id'])!= "") { echo get_option($value['id']); } else { echo $value['std']; } ?>" />
		<div id="<?php echo $value['id']; ?>_picker"></div>
		<?php if(isset($value['desc'])) { ?><div class="option-desc"><?php echo $value['desc']; ?></div><?php } ?>
	</div>


<?php        
break;
}}
?>

	</div>
	
	<div class="submit">

			<input name="save" type="submit" class="button-primary right" value="<?php _e('Save Changes', 'gp_lang'); ?>" />
			<input type="hidden" name="action" value="save" />

		</form>
	
		<form method="post" onSubmit="if(confirm('<?php _e('Are you sure you want to reset all the theme options&#63;', 'gp_lang'); ?>')) return true; else return false;">	
			<input name="reset" type="submit" class="button right" style="margin-right: 10px;" value="<?php _e('Reset', 'gp_lang'); ?>" />
			<input type="hidden" name="action" value="reset" />			
		</form>
		
		<div class="clear"></div>
	
	</div>

</div>
<!--End Theme Wrapper-->


<?php } 

if(is_admin() && $pagenow == "themes.php") {
	function gp_admin_scripts() {
		wp_enqueue_style('thickbox');
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('admin', get_template_directory_uri().'/lib/admin/css/admin.css');	
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('thickbox');
		wp_enqueue_media();
		wp_enqueue_script('tabs', get_template_directory_uri().'/lib/admin/scripts/jquery.tabs.js', array('jquery'));
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script('uploader', get_template_directory_uri().'/lib/admin/scripts/uploader.js');
	}
	add_action('admin_print_scripts', 'gp_admin_scripts');				
}

add_action('admin_menu', 'gp_add_admin'); 


// Export Theme Options
function export_settings(){
	global $options;
	header("Cache-Control: public, must-revalidate");
	header("Pragma: hack");
	header("Content-Type: text/plain");
	header('Content-Disposition: attachment; filename="theme-options-'.date("dMy").'.dat"');
	foreach ($options as $value)$theme_settings[$value['id']] = get_option($value['id']);	
	echo serialize($theme_settings);
}

// Import Theme Options
function import_settings(){
	global $options;
	if ($_FILES["file"]["error"] > 0){
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
	} else {
		$rawdata = file_get_contents($_FILES["file"]["tmp_name"]);		
		$theme_settings = unserialize($rawdata);		
		foreach ($options as $value){
			if ($theme_settings[$value['id']]){
				update_option($value['id'], $theme_settings[$value['id']]);
				$$value['id'] = $theme_settings[$value['id']];
			} else {
				if ($value['type'] == 'checkbox_multiple')$$value['id'] = array();
				else $$value['id'] = $value['std'];
			}
		}
		
	}
	if (in_array('cacheStyles', get_option('theme_misc')))cache_settings();
	wp_redirect($_SERVER['PHP_SELF'].'?page=theme-options.php');
}

// Help Tab
if(is_admin() && $pagenow == "themes.php") {
	function theme_help_tab() {
		global $dirname;
		$screen = get_current_screen();
		$screen->add_help_tab(array( 
			'id' => 'help', 'title' => 'Help', 'content' => '<p><a href="http://ghostpool.com/help/'.$dirname.'/help.html" target="_blank">'.__('Help File', 'gp_lang').'</a></p><p><a href="http://ghostpool.com/help/'.$dirname.'/changelog.html" target="_blank">'.__('Changelog', 'gp_lang').'</a></p><p><a href="http://ghostpool.ticksy.com" target="_blank">'.__('Support', 'gp_lang').'</a></p><p><a href="http://www.ourwebmedia.com/ghostpool.php?aff=002" target="_blank">'.__('Premium Services', 'gp_lang').'</a></p>'
		));	
	}
	add_action('admin_head', 'theme_help_tab');
}


/*************************** Save Default Theme Options ***************************/

add_action('after_setup_theme', 'the_theme_setup');
function the_theme_setup() {

	// Check if user is updating from earlier version of theme
	if(!get_option('theme_skin') && !get_option('theme_rss_button')) {
	
		global $dirname;
	
		if(get_option($dirname.'_theme_setup_status') !== '1') {
		
			$core_settings = array(
			
				/* General Settings */
				'theme_skin' => 'darkblue',
				'theme_contact_info' => 'Call us on: (000) 529-4327',
				$dirname.'_responsive' => '0',
				$dirname.'_retina' => '0',
				'theme_rss_button' => '0',				
				$dirname.'_jwplayer' => '1',			
				$dirname.'_old_video_shortcode' => '1',	
				'theme_preload' => '1',
			
				/* Category Settings */
				'theme_cat_thumbnail_width' => '560',
				'theme_cat_thumbnail_height' => '250',
				'theme_cat_image_wrap' => 'Disable',
				'theme_cat_hard_crop' => 'Enable',
				'theme_cat_sidebar' => 'default',
				'theme_cat_layout' => 'sb-right',
				'theme_cat_frame' => 'frame',
				'theme_cat_padding' => 'padding',
				'theme_cat_top_content_panel' => 'Show',
				'theme_cat_title' => 'Show',
				'theme_cat_breadcrumbs' => 'Show',
				'theme_cat_search' => 'Show',			
				'theme_cat_content_display' => '0',
				'theme_cat_excerpt_length' => '400',
				'theme_cat_read_more' => '0',
				'theme_cat_date' => '0',
				'theme_cat_author' => '0',
				'theme_cat_cats' => '0',
				'theme_cat_comments' => '0',
				'theme_cat_tags' => '1',	
	
				/* Post Settings */
				'theme_post_image' => 'Show',
				'theme_post_image_width' => '560',
				'theme_post_image_height' => '250',
				'theme_post_image_wrap' => 'Disable',
				'theme_post_hard_crop' => 'Enable',
				'theme_post_sidebar' => 'default',
				'theme_post_layout' => 'sb-right',
				'theme_post_frame' => 'frame',
				'theme_post_padding' => 'padding',
				'theme_post_top_content_panel' => 'Show',			
				'theme_post_title' => 'Show',
				'theme_post_breadcrumbs' => 'Show',
				'theme_post_search' => 'Show',
				'theme_post_date' => '0',
				'theme_post_author' => '0',
				'theme_post_cats' => '0',
				'theme_post_comments' => '0',
				'theme_post_tags' => '1',	
				'theme_post_author_info' => '0',	
				'theme_post_related_items' => '0',	
				'theme_post_related_image_width' => '175',	
				'theme_post_related_image_height' => '155',			
				
				/* Page Settings */
				'theme_page_image' => 'Show',
				'theme_page_image_width' => '560',
				'theme_page_image_height' => '250',
				'theme_page_image_wrap' => 'Disable',
				'theme_page_hard_crop' => 'Enable',
				'theme_page_sidebar' => 'default',
				'theme_page_layout' => 'sb-right',
				'theme_page_frame' => 'frame',
				'theme_page_padding' => 'padding',
				'theme_page_top_content_panel' => 'Show',			
				'theme_page_title' => 'Show',
				'theme_page_breadcrumbs' => 'Show',
				'theme_page_search' => 'Show',
				'theme_page_date' => '1',
				'theme_page_author' => '1',
				'theme_page_comments' => '1',	
				'theme_page_author_info' => '1',	
				
				/* BuddyPress Settings */
				'theme_bp_links' => '0',
				'theme_login_url' => home_url().'/login-page-example',
				'theme_bp_sidebar' => 'default',
				'theme_bp_layout' => 'fullwidth',
				'theme_bp_frame' => 'frame',			
				'theme_bp_padding' => 'padding',
				'theme_bp_top_content_panel' => 'Show',			
				'theme_bp_title' => 'Show',
				'theme_bp_breadcrumbs' => 'Show',
				'theme_bp_search' => 'Show',		
																	
			);
			foreach ($core_settings as $k => $v) {
				update_option($k, $v);
			}
	
			update_option($dirname.'_theme_setup_status', '1');

		}

	}

}

?>