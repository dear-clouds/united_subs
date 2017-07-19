<?php require(gp_inc . 'options.php'); global $gp_settings;


// iOS Conditionals

$gp_settings['iphone'] = (stripos($_SERVER['HTTP_USER_AGENT'],"iPhone") !== false);
$gp_settings['ipad'] = (stripos($_SERVER['HTTP_USER_AGENT'],"iPad") !== false);


// Preload Effect

if($theme_preload == "0") {
	$gp_settings['preload'] = "preload";
} else {
	$gp_settings['preload'] = "";
}


// Skins

if(isset($_GET['skin']) && $_GET['skin'] != "default") {
	$gp_settings['skin'] = "skin-".$_GET['skin'];
} elseif(isset($_COOKIE['SkinCookie']) && $_COOKIE['SkinCookie'] != "default") {
	$gp_settings['skin'] = "skin-".$_COOKIE['SkinCookie']; 
} elseif(get_post_meta($post->ID, 'ghostpool_skin', true) && get_post_meta($post->ID, 'ghostpool_skin', true) != "Default") {
	$gp_settings['skin'] = "skin-".get_post_meta($post->ID, 'ghostpool_skin', true);
} else {
	$gp_settings['skin'] = "skin-".$theme_skin;
}


//////////////////////////////////////// BuddyPress ////////////////////////////////////////

	
if(function_exists('bp_is_active') && !bp_is_blog_page()) {

	// Sidebar
	if(get_post_meta($post->ID, 'ghostpool_sidebar', true) && get_post_meta($post->ID, 'ghostpool_sidebar', true) != 'Default') {
		$gp_settings['sidebar'] = get_post_meta($post->ID, 'ghostpool_sidebar', true);
	} else {
		$gp_settings['sidebar'] = $theme_bp_sidebar;
	}
		
	// Layout
	if(get_post_meta($post->ID, 'ghostpool_layout', true) && get_post_meta($post->ID, 'ghostpool_layout', true) != "Default") {
		$gp_settings['layout'] = get_post_meta($post->ID, 'ghostpool_layout', true);
	} else {
		$gp_settings['layout'] = $theme_bp_layout;
	}
	
	// Frame
	if(get_post_meta($post->ID, 'ghostpool_frame', true) && get_post_meta($post->ID, 'ghostpool_frame', true) != "Default") {
		$gp_settings['frame'] = get_post_meta($post->ID, 'ghostpool_frame', true);
	} else {
		$gp_settings['frame'] = $theme_bp_frame;
	}
	
	// Padding
	if(get_post_meta($post->ID, 'ghostpool_padding', true) && get_post_meta($post->ID, 'ghostpool_padding', true) != "Default") {
		$gp_settings['padding'] = get_post_meta($post->ID, 'ghostpool_padding', true);
	} else {
		$gp_settings['padding'] = $theme_bp_padding;
	}

	// Top Content Panel
	if(get_post_meta($post->ID, 'ghostpool_top_content_panel', true) && get_post_meta($post->ID, 'ghostpool_top_content_panel', true) != "Default") {
		$gp_settings['top_content_panel'] = get_post_meta($post->ID, 'ghostpool_top_content_panel', true);
	} else {
		$gp_settings['top_content_panel'] = $theme_bp_top_content_panel;
	} 

	// Title
	if(get_post_meta($post->ID, 'ghostpool_title', true) && get_post_meta($post->ID, 'ghostpool_title', true) != "Default") {
		$gp_settings['title'] = get_post_meta($post->ID, 'ghostpool_title', true);
	} else {
		$gp_settings['title'] = $theme_bp_title;
	} 	
 
	// Breadcrumbs
	if(get_post_meta($post->ID, 'ghostpool_breadcrumbs', true) && get_post_meta($post->ID, 'ghostpool_breadcrumbs', true) != "Default") {
		$gp_settings['breadcrumbs'] = get_post_meta($post->ID, 'ghostpool_breadcrumbs', true);
	} else {
		$gp_settings['breadcrumbs'] = $theme_bp_breadcrumbs;
	}
	
	// Search Bar
	if(get_post_meta($post->ID, 'ghostpool_search', true) && get_post_meta($post->ID, 'ghostpool_search', true) != "Default") {
		$gp_settings['search'] = get_post_meta($post->ID, 'ghostpool_search', true);
	} else {
		$gp_settings['search'] = $theme_bp_search;
	} 


/////////////////////////////////////// bbPress ///////////////////////////////////////


} elseif(function_exists('is_bbpress') && is_bbpress()) {

	$gp_settings['sidebar'] = $theme_bp_sidebar;
	$gp_settings['layout'] = $theme_bp_layout;
	$gp_settings['frame'] = $theme_bp_frame;
	$gp_settings['padding'] = $theme_bp_padding;
	$gp_settings['top_content_panel'] = $theme_bp_top_content_panel;
	$gp_settings['title'] = $theme_bp_title;
	$gp_settings['breadcrumbs'] = $theme_bp_breadcrumbs;
	$gp_settings['search'] = $theme_bp_search;
	

//////////////////////////////////////// Categories, Archives etc. ////////////////////////////////////////


} elseif(((is_home() OR is_archive() OR is_search()) && !function_exists('is_woocommerce')) OR ((is_home() OR is_archive() OR is_search()) && function_exists('is_woocommerce') && !is_shop())) {

	$gp_settings['thumbnail_width'] = $theme_cat_thumbnail_width;
	$gp_settings['thumbnail_height'] = $theme_cat_thumbnail_height;
	$gp_settings['image_wrap'] = $theme_cat_image_wrap;
	$gp_settings['hard_crop'] = $theme_cat_hard_crop;
	if ( $gp_settings['hard_crop'] == 'Enable' ) { $gp_settings['hard_crop'] = true; } else { $gp_settings['hard_crop'] = false; }	
	$gp_settings['sidebar'] = $theme_cat_sidebar;
	$gp_settings['layout'] = $theme_cat_layout;
	$gp_settings['frame'] = $theme_cat_frame;
	$gp_settings['padding'] = $theme_cat_padding;
	$gp_settings['top_content_panel'] = $theme_cat_top_content_panel;	
	$gp_settings['title'] = $theme_cat_title;		
	$gp_settings['breadcrumbs'] = $theme_cat_breadcrumbs;
	$gp_settings['search'] = $theme_cat_search;	
	$gp_settings['content_display'] = $theme_cat_content_display;
	$gp_settings['excerpt_length'] = $theme_cat_excerpt_length;
	$gp_settings['read_more'] = $theme_cat_read_more;
	$gp_settings['meta_date'] = $theme_cat_date;
	$gp_settings['meta_author'] = $theme_cat_author;
	$gp_settings['meta_cats'] = $theme_cat_cats;
	$gp_settings['meta_tags'] = $theme_cat_tags;
	$gp_settings['meta_comments'] = $theme_cat_comments;
	
						
//////////////////////////////////////// Posts ////////////////////////////////////////


} elseif(is_singular('post')) {

	// Show Image
	if(get_post_meta($post->ID, 'ghostpool_show_image', true) && get_post_meta($post->ID, 'ghostpool_show_image', true) != "Default") {
		$gp_settings['show_image'] = get_post_meta($post->ID, 'ghostpool_show_image', true);
	} else {
		$gp_settings['show_image'] = $theme_show_post_image;
	}
	
	// Image Dimensions
	if(get_post_meta($post->ID, 'ghostpool_image_width', true) && get_post_meta($post->ID, 'ghostpool_image_width', true) != "") {
		$gp_settings['image_width'] = get_post_meta($post->ID, 'ghostpool_image_width', true);
	} else {
		$gp_settings['image_width'] = $theme_post_image_width;
	}
	if(get_post_meta($post->ID, 'ghostpool_image_height', true) != "") {
		$gp_settings['image_height'] = get_post_meta($post->ID, 'ghostpool_image_height', true);
	} else {
		$gp_settings['image_height'] = $theme_post_image_height;
	}
	
	// Image Wrap
	if(get_post_meta($post->ID, 'ghostpool_image_wrap', true) && get_post_meta($post->ID, 'ghostpool_image_wrap', true) != "Default") {
		$gp_settings['image_wrap'] = get_post_meta($post->ID, 'ghostpool_image_wrap', true);
	} else {
		$gp_settings['image_wrap'] = $theme_post_image_wrap;
	}

	// Hard Crop
	if(get_post_meta($post->ID, 'ghostpool_hard_crop', true) && get_post_meta($post->ID, 'ghostpool_hard_crop', true) != "Default") {
		$gp_settings['hard_crop'] = get_post_meta($post->ID, 'ghostpool_hard_crop', true);
	} else {
		$gp_settings['hard_crop'] = $theme_post_hard_crop;
	}
	if ( $gp_settings['hard_crop'] == 'Enable' ) { $gp_settings['hard_crop'] = true; } else { $gp_settings['hard_crop'] = false; }	
	
	// Sidebar
	if(get_post_meta($post->ID, 'ghostpool_sidebar', true) && get_post_meta($post->ID, 'ghostpool_sidebar', true) != 'Default') {
		$gp_settings['sidebar'] = get_post_meta($post->ID, 'ghostpool_sidebar', true);
	} else {
		$gp_settings['sidebar'] = $theme_post_sidebar;
	}
		
			
	// Layout
	if(is_attachment()) {
		$gp_settings['layout'] = "fullwidth";
	} else {
		if(get_post_meta($post->ID, 'ghostpool_layout', true) && get_post_meta($post->ID, 'ghostpool_layout', true) != "Default") {
			$gp_settings['layout'] = get_post_meta($post->ID, 'ghostpool_layout', true);
		} else {
			$gp_settings['layout'] = $theme_post_layout;
		}
	}

	// Frame
	if(get_post_meta($post->ID, 'ghostpool_frame', true) && get_post_meta($post->ID, 'ghostpool_frame', true) != "Default") {
		$gp_settings['frame'] = get_post_meta($post->ID, 'ghostpool_frame', true);
	} else {
		$gp_settings['frame'] = $theme_post_frame;
	}
	
	// Padding
	if(get_post_meta($post->ID, 'ghostpool_padding', true) && get_post_meta($post->ID, 'ghostpool_padding', true) != "Default") {
		$gp_settings['padding'] = get_post_meta($post->ID, 'ghostpool_padding', true);
	} else {
		$gp_settings['padding'] = $theme_post_padding;
	}

	// Top Content Panel
	if(get_post_meta($post->ID, 'ghostpool_top_content_panel', true) && get_post_meta($post->ID, 'ghostpool_top_content_panel', true) != "Default") {
		$gp_settings['top_content_panel'] = get_post_meta($post->ID, 'ghostpool_top_content_panel', true);
	} else {
		$gp_settings['top_content_panel'] = $theme_post_top_content_panel;
	} 

	// Title
	if(get_post_meta($post->ID, 'ghostpool_title', true) && get_post_meta($post->ID, 'ghostpool_title', true) != "Default") {
		$gp_settings['title'] = get_post_meta($post->ID, 'ghostpool_title', true);
	} else {
		$gp_settings['title'] = $theme_post_title;
	} 	
 
	// Breadcrumbs
	if(get_post_meta($post->ID, 'ghostpool_breadcrumbs', true) && get_post_meta($post->ID, 'ghostpool_breadcrumbs', true) != "Default") {
		$gp_settings['breadcrumbs'] = get_post_meta($post->ID, 'ghostpool_breadcrumbs', true);
	} else {
		$gp_settings['breadcrumbs'] = $theme_post_breadcrumbs;
	}
	
	// Search Bar
	if(get_post_meta($post->ID, 'ghostpool_search', true) && get_post_meta($post->ID, 'ghostpool_search', true) != "Default") {
		$gp_settings['search'] = get_post_meta($post->ID, 'ghostpool_search', true);
	} else {
		$gp_settings['search'] = $theme_post_search;
	} 

	// Post Meta						
	$gp_settings['meta_date'] = $theme_post_date;
	$gp_settings['meta_author'] = $theme_post_author;
	$gp_settings['meta_cats'] = $theme_post_cats;
	$gp_settings['meta_tags'] = $theme_post_tags;
	$gp_settings['meta_comments'] = $theme_post_comments;
	
	// Author Info Panel
	$gp_settings['author_info'] = $theme_post_author_info;
						
	// Related Items
	$gp_settings['related_items'] = $theme_post_related_items;					


//////////////////////////////////////// Pages, Attachments, 404 etc. ////////////////////////////////////////


} else {

	if(function_exists('is_woocommerce') && is_shop()) {
		$post_id = get_option('woocommerce_shop_page_id'); 
	} else {
		$post_id = get_the_ID(); 
	}
	
	// Show Image
	if(get_post_meta($post_id, 'ghostpool_show_image', true) && get_post_meta($post_id, 'ghostpool_show_image', true) != "Default") {
		$gp_settings['show_image'] = get_post_meta($post_id, 'ghostpool_show_image', true);
	} else {
		$gp_settings['show_image'] = $theme_show_page_image;
	}
	
	// Image Dimensions
	if(get_post_meta($post_id, 'ghostpool_image_width', true) && get_post_meta($post_id, 'ghostpool_image_width', true) != "") {
		$gp_settings['image_width'] = get_post_meta($post_id, 'ghostpool_image_width', true);
	} else {
		$gp_settings['image_width'] = $theme_page_image_width;
	}
	if(get_post_meta($post_id, 'ghostpool_image_height', true) != "") {
		$gp_settings['image_height'] = get_post_meta($post_id, 'ghostpool_image_height', true);
	} else {
		$gp_settings['image_height'] = $theme_page_image_height;
	}
	
	// Image Wrap
	if(get_post_meta($post_id, 'ghostpool_image_wrap', true) && get_post_meta($post_id, 'ghostpool_image_wrap', true) != "Default") {
		$gp_settings['image_wrap'] = get_post_meta($post_id, 'ghostpool_image_wrap', true);
	} else {
		$gp_settings['image_wrap'] = $theme_page_image_wrap;
	}

	// Hard Crop
	if(get_post_meta($post_id, 'ghostpool_hard_crop', true) && get_post_meta($post_id, 'ghostpool_hard_crop', true) != "Default") {
		$gp_settings['hard_crop'] = get_post_meta($post_id, 'ghostpool_hard_crop', true);
	} else {
		$gp_settings['hard_crop'] = $theme_page_hard_crop;
	}
	if ( $gp_settings['hard_crop'] == 'Enable' ) { $gp_settings['hard_crop'] = true; } else { $gp_settings['hard_crop'] = false; }	
	
	// Sidebar
	if(get_post_meta($post_id, 'ghostpool_sidebar', true) && get_post_meta($post_id, 'ghostpool_sidebar', true) != 'Default') {
		$gp_settings['sidebar'] = get_post_meta($post_id, 'ghostpool_sidebar', true);
	} else {
		$gp_settings['sidebar'] = $theme_page_sidebar;
	}
			
	// Layout
	if(get_post_meta($post_id, 'ghostpool_layout', true) && get_post_meta($post_id, 'ghostpool_layout', true) != "Default") {
		$gp_settings['layout'] = get_post_meta($post_id, 'ghostpool_layout', true);
	} else {
		$gp_settings['layout'] = $theme_page_layout;
	}
	
	// Frame
	if(get_post_meta($post_id, 'ghostpool_frame', true) && get_post_meta($post_id, 'ghostpool_frame', true) != "Default") {
		$gp_settings['frame'] = get_post_meta($post_id, 'ghostpool_frame', true);
	} else {
		$gp_settings['frame'] = $theme_page_frame;
	}
	
	// Padding
	if(get_post_meta($post_id, 'ghostpool_padding', true) && get_post_meta($post_id, 'ghostpool_padding', true) != "Default") {
		$gp_settings['padding'] = get_post_meta($post_id, 'ghostpool_padding', true);
	} else {
		$gp_settings['padding'] = $theme_page_padding;
	}

	// Top Content Panel
	if(get_post_meta($post_id, 'ghostpool_top_content_panel', true) && get_post_meta($post_id, 'ghostpool_top_content_panel', true) != "Default") {
		$gp_settings['top_content_panel'] = get_post_meta($post_id, 'ghostpool_top_content_panel', true);
	} else {
		$gp_settings['top_content_panel'] = $theme_page_top_content_panel;
	} 

	// Title
	if(get_post_meta($post_id, 'ghostpool_title', true) && get_post_meta($post_id, 'ghostpool_title', true) != "Default") {
		$gp_settings['title'] = get_post_meta($post_id, 'ghostpool_title', true);
	} else {
		$gp_settings['title'] = $theme_page_title;
	} 	
 
	// Breadcrumbs
	if(get_post_meta($post_id, 'ghostpool_breadcrumbs', true) && get_post_meta($post_id, 'ghostpool_breadcrumbs', true) != "Default") {
		$gp_settings['breadcrumbs'] = get_post_meta($post_id, 'ghostpool_breadcrumbs', true);
	} else {
		$gp_settings['breadcrumbs'] = $theme_page_breadcrumbs;
	}
	
	// Search Bar
	if(get_post_meta($post_id, 'ghostpool_search', true) && get_post_meta($post_id, 'ghostpool_search', true) != "Default") {
		$gp_settings['search'] = get_post_meta($post_id, 'ghostpool_search', true);
	} else {
		$gp_settings['search'] = $theme_page_search;
	} 
	
	// Post Meta						
	$gp_settings['meta_date'] = $theme_page_date;
	$gp_settings['meta_author'] = $theme_page_author;
	$gp_settings['meta_cats'] = "1";
	$gp_settings['meta_tags'] = "1";
	$gp_settings['meta_comments'] = $theme_page_comments;
	
	// Author Info Panel
	$gp_settings['author_info'] = $theme_page_author_info;
						
}

?>