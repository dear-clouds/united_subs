<?php

if(is_admin() && isset($_GET['activated']) && $pagenow == "themes.php") {

	global $dirname;

	if(get_option($dirname.'_theme_auto_install') !== '1') {


		/////////////////////////////////////// Delete Default Content ///////////////////////////////////////	


		// Default Posts
		$post = get_page_by_path('hello-world', OBJECT, 'post');
		if($post) { wp_delete_post($post->ID,true); }

		// Default Pages		
		$post = get_page_by_path('sample-page', OBJECT, 'page');
		if($post) { wp_delete_post($post->ID,true); }
		
				
		/////////////////////////////////////// Create Attachments ///////////////////////////////////////	


		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require(ABSPATH . 'wp-admin/includes/image.php');		
		
		$filename1 = get_template_directory_uri().'/lib/images/placeholder1.png';
		$description1 = 'Image Description 1';
		media_sideload_image($filename1, 0, $description1);
		$last_attachment1 = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
		$attachment_id1 = $last_attachment1['ID'];
		
		$filename2 = get_template_directory_uri().'/lib/images/placeholder2.png';
		$description2 = 'Image Description 2';
		media_sideload_image($filename2, 0, $description2);
		$last_attachment2 = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 2", ARRAY_A);
		$attachment_id2 = $last_attachment2['ID'];
		
		
		/////////////////////////////////////// Create Pages ///////////////////////////////////////	

		
		/*************************************** Homepage ***************************************/	
		
		if(function_exists('bp_is_active') && file_exists(ghostpool_bp.'functions-buddypress.php')) { 
				
			$new_page_title = 'Homepage';
			$new_page_content =			
'[logged_out]

[one type="joint" padding="40" background="#fcfcfc"]

[twothirds]
[text color="#000" line_height="28" size="28" other="font-weight: bold"]Join everybody else at Bounce[/text]
[text color="#000" line_height="22" margins="10,0,0,0"]Assertively leverage existing superior processes with resource maximizing schemas. Interactively expedite team driven human capital via user-centric portals. Authoritatively embrace team driven architectures through interdependent metrics.[/text]
[/twothirds]

[onethird_last text_align="text-center" padding="20,0,0,0"]
[button link="#" size="large" color="darkblue"]Create An Account &rarr;[/button]
[text margins="5,0,0,0" size="11" color="#999"]Or login to your account.[/text]
[/onethird_last]

[/one]

[/logged_out]

[onefourth type="joint" padding="40,20,40,40"][sidebar name="BuddyPress 4"][/onefourth]

[threefourths_last type="joint" padding="40"]

[two][sidebar name="BuddyPress 5"][/two]

[two_last][sidebar name="BuddyPress 6"][/two_last]

[/threefourths_last]

[one padding="40,40,20,40" text_align="text-center"]<img src="'.wp_get_attachment_url($attachment_id1).'" width="874" height="40" alt="" />[/one]';
			$page_check = get_page_by_title($new_page_title);
			$new_page = array(
				'post_type' => 'page',
				'post_title' => $new_page_title,
				'post_content' => $new_page_content,
				'post_status' => 'publish',
				'post_author' => 1,
				'comment_status' => 'closed'
			);
			if(!isset($page_check->ID)){
				$new_page_id = wp_insert_post($new_page);
				update_option('page_on_front', $new_page_id);
				update_option('show_on_front', 'page');
				update_post_meta($new_page_id, 'ghostpool_layout', 'fullwidth');
				update_post_meta($new_page_id, 'ghostpool_padding', 'Disable');
				update_post_meta($new_page_id, 'ghostpool_title', 'Hide');
				update_post_meta($new_page_id, 'ghostpool_breadcrumbs', 'Hide');
				update_post_meta($new_page_id, 'ghostpool_search', 'Hide');	
				update_post_meta($new_page_id, 'ghostpool_top_content', '[text width="100%" text_align="text-center" color="#fff" size="48" line_height="48" font="Lato, sans-serif"]Join our community today.[/text]
[text width="100%" text_align="text-center" size="12" other="font-weight: bold;" margins="10,0,0,0"]Seamlessly network world-class functionalities with stand-alone customer service. Competently whiteboard enterprise-wide interfaces.[/text]

[one text_align="text-center" name="button-divider" padding="20,0"][button link="#" color="yellow" size="large"]Sign Up Here[/button][/one]

[two][sidebar name="BuddyPress 1"][/two]

[two_last]

<div class="left" style="width: 48%; margin-right: 4%;">[sidebar name="BuddyPress 2"]</div>

<div class="right" style="width: 48%;">[sidebar name="BuddyPress 3"]</div>

[/two_last]');
			}		
		
		} else {
		
			$new_page_title = 'Homepage';
			$new_page_content = 
'[three type="joint" text_align="text-center" padding="0" height="300"]
[text size="16" margins="20,0,10,0" width="80%" other="font-weight: bold"]Powerful Shortcodes[/text]
[text width="80%" size="12" color="#666"]Bounce comes with over 25 powerful shortcodes that all you to create amazing content in minutes.[/text]
[image url="'.wp_get_attachment_url($attachment_id1).'" width="360" height="200" bottom="0"]
[/three]

[three_middle type="joint" text_align="text-center" padding="0" height="300"]
[text size="16" margins="20,0,10,0" width="80%" other="font-weight: bold"]Fully Responsive[/text]
[text width="80%" size="12" color="#666"]Bounce is a fully responsive theme so it will fit to your screen width and comes with custom tablet and mobile displays.[/text]
[image url="'.wp_get_attachment_url($attachment_id2).'" width="360" height="200" bottom="0"]
[/three_middle]

[three_last type="joint" text_align="text-center" padding="0" height="300"]
[text size="16" margins="20,0,10,0" width="80%" other="font-weight: bold"]7 Skins Variation[/text]
[text width="80%" size="12" color="#666"]Bounce comes with 7 beautiful skin variations which can be applied to the whole site or individual pages.[/text]
[image url="'.wp_get_attachment_url($attachment_id1).'" width="360" height="200" bottom="0"]
[/three_last]

[one type="joint" padding="0" margins="0"]

[twothirds margins="0"]
[text name="Bob Smith" company="AwesomeCo" margins="10%,0%,0%,10%" width="90%" size="25" line_height="45" font="Raleway, sans-serif"]Objectively reinvent user friendly collaboration and idea-sharing through end-to-end materials.[/text]
[/twothirds]

[onethird_last margins="0"]
[image url="'.wp_get_attachment_url($attachment_id1).'" width="228" height="289" margins="5%,0,0,0" align="aligncenter"]
[/onethird_last]

[/one]

[one type="joint" padding="40"]

[onethird]
<h4>Why Buy This Theme?</h4>
[list type="large-tick"]
[li]Powerful shortcodes[/li]
[li]7 skin variations[/li]
[li]Fully responsive[/li]
[li]Excellent video support[/li]
[li]Create unique layouts in minutes[/li]
[li]Pricing tables and boxes[/li]
[li]JW player commercial license[/li]
[li]Full localisation (translation ready)[/li]
[li]Full theme PSDs included[/li]
[/list]
[/onethird]

[twothirds_last]
<h4>From The Blog</h4>
[clear][posts per_page="2" image_wrap="true" image_width="130" image_height="130" excerpt_length="200" meta_cats="false" meta_tags="false"]
[/twothirds_last]

[/one]

[one padding="40,40,20,40" text_align="text-center"]<img src="'.wp_get_attachment_url($attachment_id1).'" width="874" height="40" alt="" />[/one]';
			$page_check = get_page_by_title($new_page_title);
			$new_page = array(
				'post_type' => 'page',
				'post_title' => $new_page_title,
				'post_content' => $new_page_content,
				'post_status' => 'publish',
				'post_author' => 1,
				'comment_status' => 'closed'
			);
			if(!isset($page_check->ID)){
				$new_page_id = wp_insert_post($new_page);
				update_option('page_on_front', $new_page_id);
				update_option('show_on_front', 'page');
				update_post_meta($new_page_id, 'ghostpool_layout', 'fullwidth');
				update_post_meta($new_page_id, 'ghostpool_padding', 'Disable');
				update_post_meta($new_page_id, 'ghostpool_title', 'Hide');
				update_post_meta($new_page_id, 'ghostpool_breadcrumbs', 'Hide');
				update_post_meta($new_page_id, 'ghostpool_search', 'Hide');	
				update_post_meta($new_page_id, 'ghostpool_top_content', '				
[two]

[text line_height="35" font="Lato, sans-serif" text_align="text-center" size="30" margins="0,0,10" color="#fff"]Bounce is a powerful, professional and fully responsive WordPress theme.[/text]

[text line_height="23" text_align="text-center" margins="0,0,15"]Bounce comes crammed with over 25 powerful shortcodes, 7 beautiful skin variations, the ability to create unique page layouts in minutes, it\'s fully responsive and comes with excellent video support for flash, HTML5, YouTube and Vimeo files.[/text]

[one text_align="text-center" name="button-divider"][button link="#" color="yellow" size="large"]Sign Up Here[/button][/one]

[small_clear]

[text size="12" margins="15,0,0,0" color="#fff" other="font-weight: bold;"]Comes with a commercial JW player license worth $80[/text]
[text size="12"]Bounce comes with a free commercial license for the JW player which plays YouTube, FLV, MP4, M4V, MP3 and HTML5 videos for iOS devices (also comes with Vimeo support). The player is fully integrated into the slider, lightbox and video shortcode to insert you videos anywhere on the site.[/text]

[/two]

[two_last]

[slider width="432" height="250" align="alignright"]

[text name="Joe Blogs" company="Google" line_height="21" size="12" text_align="text-right" margins="20,0,0" other="font-weight: bold"]"Monotonectally evisculate multidisciplinary e-business vis-a-vis user-centric methodologies. Quickly aggregate team building process improvements through professional relationships.[/text]

[/two_last]');
			}

		}
				

		/*************************************** Blog Page ***************************************/	
		
		$new_page_title = 'Blog';
		$new_page_content = '[posts]';
		$page_check = get_page_by_title($new_page_title);
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
		}
		
					
		/*************************************** Contact Page ***************************************/	
		
		$new_page_title = 'Contact';
		$new_page_content = '[contact email="youraddress@email.com"]';
		$page_check = get_page_by_title($new_page_title);
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, 'ghostpool_sidebar', 'gp-contact-page');
		}


		/////////////////////////////////////// Create Posts ///////////////////////////////////////	


		/*************************************** Post 1 ***************************************/	
				
		$new_page_title = 'Post 1';
		$new_page_content = 'Compellingly drive goal-oriented initiatives without high-payoff internal or "organic" sources. Objectively provide access to cooperative human capital after highly efficient value. Credibly administrate multimedia based applications with cooperative niche markets. Seamlessly evolve focused models for state of the art quality vectors. Assertively harness long-term high-impact catalysts for change with.';
		$page_check = get_page_by_title($new_page_title, '', 'post');
		$new_page = array(
			'post_type' => 'post',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'open'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, 'ghostpool_link_type', 'Page');
			set_post_thumbnail($new_page_id, $attachment_id1);
		}
		
		
		/*************************************** Post 2 ***************************************/	
				
		$new_page_title = 'Post 2';
		$new_page_content = 'Proactively foster superior growth strategies and adaptive users. Conveniently deploy timely strategic theme areas vis-a-vis B2B scenarios. Progressively cultivate viral partnerships after state of the art e-commerce. Proactively synergize sticky best practices without ethical e-tailers. Quickly visualize customized data and synergistic infrastructures.';
		$page_check = get_page_by_title($new_page_title, '', 'post');
		$new_page = array(
			'post_type' => 'post',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'open'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, 'ghostpool_link_type', 'Page');
			set_post_thumbnail($new_page_id, $attachment_id2);
		}			
				
				
		/////////////////////////////////////// Create Slides ///////////////////////////////////////	
		

		/*************************************** Slide 1 ***************************************/	
				
		$new_page_title = 'Image Slide';
		$new_page_content = 'Proactively develop competitive strategic theme areas before inexpensive best practices. Proactively conceptualize viral.';
		$page_check = get_page_by_title($new_page_title, '', 'slide');
		$new_page = array(
			'post_type' => 'slide',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, 'ghostpool_slide_url', '#');
			set_post_thumbnail($new_page_id, $attachment_id1);
		}
		
		
		/*************************************** Slide 2 ***************************************/	
				
		$new_page_title = 'Video Slide';
		$new_page_content = '';
		$page_check = get_page_by_title($new_page_title, '', 'slide');
		$new_page = array(
			'post_type' => 'slide',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, 'ghostpool_slide_video', 'http://vimeo.com/36006533');
			update_post_meta($new_page_id, 'ghostpool_slide_title', true);
			update_post_meta($new_page_id, 'ghostpool_slide_text', true);
			set_post_thumbnail($new_page_id, $attachment_id2);
		}

		
		/////////////////////////////////////// Create Navigation ///////////////////////////////////////	


		/*************************************** Header Nav ***************************************/	
		
		$menu_name = 'Header';
		$menu_location = 'header-nav';
		$menu_exists = wp_get_nav_menu_object($menu_name);			
		if(!$menu_exists) {
			$menu_id = wp_create_nav_menu($menu_name);
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' => 'Home',
				'menu-item-classes' => 'home',
				'menu-item-url' => home_url('/'), 
				'menu-item-status' => 'publish')
			);		
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' => 'Blog',
				'menu-item-object' => 'page',
				'menu-item-object-id' => get_page_by_path('blog')->ID,
				'menu-item-description' => 'An example of a blog page.',
				'menu-item-type' => 'post_type',
				'menu-item-status' => 'publish')
			);									
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' => 'Contact',
				'menu-item-object' => 'page',
				'menu-item-object-id' => get_page_by_path('contact')->ID,
				'menu-item-type' => 'post_type',
				'menu-item-status' => 'publish')
			);
			if(!has_nav_menu($menu_location)) {
				$locations = get_theme_mod('nav_menu_locations');
				$locations[$menu_location] = $menu_id;
				set_theme_mod('nav_menu_locations', $locations);
			}
		}     
			
	}
	
	update_option($dirname.'_theme_auto_install', '1');

}	

?>