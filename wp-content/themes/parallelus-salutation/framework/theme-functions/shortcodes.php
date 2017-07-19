<?php
#==================================================================
#
#	Shortcode functions for theme
#
#==================================================================


#-----------------------------------------------------------------
# Default functions
#-----------------------------------------------------------------

// Enable shortdoces in sidebar default Text widget
//...............................................
add_filter('widget_text', 'do_shortcode');



#-----------------------------------------------------------------
# Images
#-----------------------------------------------------------------

// Images with overlay
//...............................................
function theme_styled_image( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'w' => '',			// width
		'h' => '',			// height
		'image' => false,	// image URL or media attachment ID
		'align' => false,	// image alignment
		'alt' => '',		// alt text for image tag
		'caption' => '',
		'link' => '',
		'lightbox' => '',
		'rel' => false		// lightbox related (lets images be linked together)
	), $atts));

	$image = trim($image);

	if ($image) {
		
		// get the image
		$atts['return'] = 'array';
		$imageData = theme_plain_image($atts);
		
		$class = 'styled-image';
		
		// class options for lightbox
		if ($lightbox && strtolower($lightbox) != 'no') { 
			$link_class = 'popup'; 	
			// if no link - open original image and add icon
			if (!$link)	{
				$link =  $image;
			}	
		}
		
		// class options for alignment
		if ($align && $align !== 'center') { $class .= ' align'.$align; }
		
		// rel used for lightbox connecting
		if ($rel) { $rel = 'rel="'.$rel.'"'; }
		
		// image container
		
		$img = $imageData['full_image_tag'];
		
		if ($link) {
			if (wp_get_attachment_url($link)) {
				// the image was provided as a media attachment ID
				$link = wp_get_attachment_url($link);
			}
			$img = '<a href="'. $link .'" class="'. $link_class .'" title="'. $alt .'" '.$rel.'>'. $img .'</a>';
		} // else {
			
		if ($caption) {
			$caption = '<div class="captionText">' . $caption . '</div>';
			$fixed_width = 'style="width: '.$imageData['width'].'px"';
		}
		
		$fixed_width = isset($fixed_width)? $fixed_width : '';
		$img = '<div class="'. $class .'" '. $fixed_width .'>'. $img . $caption .'</div>';	
		//}
		
		// align center
		if ($align == 'center') $img = '<div style="text-align:center;">'. $img .'</div>';
	
		return $img;
		
	}

	return $styledImage;					
}
add_shortcode('styled_image', 'theme_styled_image');


// Resized Image
//...............................................
function theme_plain_image( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'w' => '',			// width
		'h' => '',			// height
		'image' => false,	// image URL or media attachment ID
		'align' => false,	// image alignment
		'alt' => '',	// alt text for image tag
		'resize' => '1',		// resize the image?
		'return' => ''
	), $atts));

	$image = trim($image);
	$class = '';

	if ($image) {
		
		$img = array( 'url' => $image, 'width' => $w, 'height' => $h );
		
		// check resize option
		if ($resize == true || $resize == 'true' || $resize == '1' || $resize == 'Yes' || $resize == 'yes' ) {
			$atts['return'] = 'array'; // to return full image array
			$img = theme_resized_image_path($atts);
		}
		
		// align image class
		if ($align) $class = 'class="align'.$align.'" ';
		
		// final image tag
		$full_img_tag = '<img src="'. $img['url'] .'" width="'. $img['width'] .'" height="'. $img['height'] .'" alt="'. $alt .'" '.$class.'/>';
	
		if ($return == 'array') {
			$img['full_image_tag'] = $full_img_tag;
			return $img;			
		} else {
			return $full_img_tag;
		}
		
	}
	
}
add_shortcode('plain_image', 'theme_plain_image');


// SRC for Resized Image (image in timthumb path)
//...............................................
function theme_resized_image_path( $atts, $content = null ) {
	global $themePath;

	extract(shortcode_atts(array(
		'w' => '0',		// width
		'h' => '0',		// height
		'image' => false,	// image URL or media attachment ID
		'return' => 'url'	// internal, a value of 'array' will return full array with url, width and height
	), $atts));

	$image = trim($image);
	
	if ($image) {
		
		// crop image (default = true)
		$crop = ( strval($w) === '0' || strval($h) === '0' ) ? false : true; // Setting to FALSE is useful when setting one value so other adjusts automatically
		
		// Check for special requests (featured image, etc.)
		if ($image == 'featured') {
			$image = get_post_thumbnail_id();
		}
		
		// get resized image (if given media ID or URL)
		// this will return the resized $thumb or placeholder if enabled and no $thumb
		if (wp_get_attachment_url($image)) {
			// Looks like we were given an ID
			$img = vt_resize( $image, '', $w, $h, $crop );
		} else {
			// Must be an image path
			$img = vt_resize( '', $image, $w, $h, $crop );
		}
		
		// return...
		if ($return == 'array') {
			// Return the entire image array
			return $img;			
		}else {
			// Return the image URL
			return $img['url'];
		}
	}
	
}
add_shortcode('resized_image_path', 'theme_resized_image_path');



#-----------------------------------------------------------------
# Maps
#-----------------------------------------------------------------

// Google Map
//...............................................
function shortcode_google_map( $atts, $content = null ) {
    extract(shortcode_atts(array(
		"width" => '640',
		"height" => '480',
		"src" => ''
    ), $atts));
	
   return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'"></iframe>';
}

// Add shortcode
//...............................................
add_shortcode('google_map', 'shortcode_google_map');



#-----------------------------------------------------------------
# Buttons
#-----------------------------------------------------------------

// Button Function
//...............................................
function theme_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'		=> '',
		'title'		=> false,
		'class'		=> '',
		'id'		=> false,
		'onclick'	=> false,
		'name'		=> false,
		'value'		=> false,
		'type'		=> 'button'
    ), $atts));
	
	// variable setup
	$title = ($title) ? ' title="'.$title .'"' : '';
	$id = ($id) ? ' id="'.$id .'"' : '';
	$name = ($name) ? ' name="'.$name .'"' : '';
	$onclick = ($onclick) ? ' onclick="'.$onclick .'"' : '';
	$value = ($value) ? ' value="'.$value .'"' : '';
	if ($style) $class .= ' '. $style;

	// code
	$button = '<button' .$value. ' '. $name .' ' .$id. ' ' .$onclick. ' ' .$title. ' class="btn ' .trim($class). '" type="'. $type .'" ><span>' .do_shortcode($content). '</span></button>';
    
    return $button;
}

// Add shortcode
//...............................................
add_shortcode('button', 'theme_button');


// Button as Link Function
//...............................................
function theme_button_link( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'		=> '',
        'url'		=> '#',
		'target'	=> '',
		'title'		=> false,
		'class'		=> '',
		'id'		=> false,
		'onclick'	=> false
    ), $atts));
	
	// variable setup
	$title = ($title) ? ' title="'.$title .'"' : '';
	$class = ($class) ? ' '.$class : '';
	$id = ($id) ? ' id="'.$id .'"' : '';
	if ($style) $class .= ' '. $style;
	$onclick = ($onclick) ? ' onclick="'.$onclick .'"' : '';

	// target setup
	if		($target == 'blank' || $target == '_blank' || $target == 'new' )	{ $target = ' target="_blank"'; }
	elseif	($target == 'parent')	{ $target = ' target="_parent"'; }
	elseif	($target == 'self')		{ $target = ' target="_self"'; }
	elseif	($target == 'top')		{ $target = ' target="_top"'; }
	else	{ $target = ''; }

	$button = '<a' .$target. ' ' .$onclick. '  ' .$title. '  ' .$id. ' class="btn' .$class. '" href="' .$url. '"><span>' .do_shortcode($content). '</span></a>';
    
    return $button;
}

// Add shortcode
//...............................................
add_shortcode('button_link', 'theme_button_link');



// Code (internall only)
//...............................................
function shortcode_code( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'class' => '',
    ), $atts));

	return '<pre class="code '.$class.'"><code>'. $content .'</code></pre>';
}
add_shortcode('code', 'shortcode_code');



#-----------------------------------------------------------------
# Icons and Lists
#-----------------------------------------------------------------


// Single Icon
//...............................................
function theme_icon( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'size' => '',			// small, medium, large (16px, 24px, 32px)
		'icon' => '',			// the icon image to use
		'class' => '',			// CSS class to apply to list
		'link' => false,		// if a link is provided
		'title' => false,		// the link title attribute
		'target' => false,		// the link target
		'container' => 'div',	// the container type (span, div, li, etc...)
		'return' => ''			// if you don't want the element, rather the class to be returned
    ), $atts));

	if ($icon) {
	
		$icon = strtolower($icon);
		
		// Icon size
		switch ($size) {
			case 'small':
				$class .= 'icon16';
				break;
			case 'medium':
				$class .= 'icon24';
				break;
			default:
				$class .= 'icon32';
		}
		
		// array of icon classes
		$iconSocial = array('digg', 'googlebuzz', 'delicious', 'twitter', 'dribbble', 'stumbleupon', 'youtube', 'vimeo', 'skype', 'facebook', 'facebooklike', 'ichat', 'myspace', 'dropbox');
		$iconSymbol = array('minus', 'plus', 'close', 'check', 'star', 'unstar', 'folder', 'tag', 'bookmark', 'heart', 'leftarrow', 'rightarrow', 'undo', 'redo');
		$iconFile = array('page', 'acrobat', 'acrobat2', 'word', 'word2', 'zip', 'zip2', 'powerpoint', 'powerpoint2', 'excel', 'excel2', 'document', 'document2');
		$iconMedia = array('map', 'map2', 'marker', 'image', 'images', 'audio', 'play', 'film', 'film2', 'quicktime', 'clapboard', 'microphone', 'search');
		
		// set class for icon image source
		if (in_array($icon, $iconSocial))	$class .= ' iconSocial';
		if (in_array($icon, $iconSymbol))	$class .= ' iconSymbol';
		if (in_array($icon, $iconFile))		$class .= ' iconFile';
		if (in_array($icon, $iconMedia))	$class .= ' iconMedia';
	
		// style
		//if ($style == 'dark')	$class .= ' iconDark';
		
		// icon image
		$class .= ' '. $icon;
		
		// if return is set to class (otherwise continue with image)
		if ($return == 'class') return $class;
		
		// icon
		$image = '<'.$container.' class="'.$class.'"></'.$container.'>';		
		
		// link
		if ($link) {
			
			$link = trim($link);
			
			// set link target
			switch ($target) {
				case 'new':
				case 'blank':
					$target = 'target="_blank"';
					break;
				default:
					$target = 'target="'.$target.'"';
			}
			
			$image = '<a href="'.$link.'" title="'.$title.'" '.$target.' class="tip" >'.$image.'</a>';
		}
		
		return $image;
	
	}
	
}
add_shortcode('icon', 'theme_icon');


// Icon List
//...............................................
function theme_icon_list( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'size' => '',
		'icon' => '',
		'class' => '',
		'link' => false,
		'title' => false,
		'target' => false
    ), $atts));

	$icons = explode(',', $icon);
	$links = explode(',', $link);
	$titles = explode(',', $title);

	// get the icons
	$iconList = array();
	foreach ((array) $icons as $key => $image) :
		$image = trim($image);
		// link
		if (is_array($links)) {
			$url = ($links[$key]) ? $links[$key] : '';
		} else {
			$url = $link;
		}
		// title
		if (is_array($titles)) {
			$alt = ($titles[$key]) ? $titles[$key] : '';
		} else {
			$alt = $title;
		}
		// get single icon
		$iconList[] = theme_icon(array( 'size'=>$size, 'icon'=>$image, 'link'=>$url, 'title'=>$alt, 'target'=>$target));
	endforeach;
	
	// create the list
	$list = '<ul class="horizontalList nav '.$class.'">';
	foreach ((array) $iconList as $image) :
		$list .= '<li>'.$image.'</li>';
	endforeach;
	$list .= '</ul>';

	return $list;
	
}
add_shortcode('icon_list', 'theme_icon_list');


// Unordered Lists
//...............................................
function theme_bullet_list( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'icon' => 'check',
		'indent' => '',
		'class' => '',
    ), $atts));

	// get the image class
	//$iconClass = theme_icon(array( 'size'=>'small', 'icon'=>$icon, 'style'=>$style, 'return'=>'class'));
	$iconImage = theme_icon(array( 'size'=>'small', 'icon'=>$icon));

	if ($indent) $style = ' style="margin-left: '.$indent.';"';
	
	$classAttr = ' class="icon-list '. $class .'"';
	$style = isset($style)? $style : '';
	$content = str_replace('<ul>', '<ul' .$classAttr . $style. '>', do_shortcode($content));
	$content = str_replace('<li>', '<li>'.$iconImage, do_shortcode($content));
	
	return $content;
	
}
add_shortcode('bullet_list', 'theme_bullet_list');


#-----------------------------------------------------------------
# Toggles
#-----------------------------------------------------------------


// Tabs
//...............................................
function theme_tabs( $atts, $content = null ) {
	global $shortcode_tabs;
	/*extract(shortcode_atts(array(
		'style' => ''
    ), $atts));*/

	// get each tab (stored to global $shortcode_tabs)
	do_shortcode($content);

	$tab_items = '';
	$tab_content = '';
	$id = base_convert(microtime(), 10, 36); // a random id generated for each tab group. 
	
	// organize the content and tabs
	if (is_array($shortcode_tabs)) {
		// group each part together
		for ($i = 0; $i < count($shortcode_tabs); $i++) {
			$tab_items .= '<li><a href="#'.$id.'_'.$i.'">'.$shortcode_tabs[$i]['title'].'</a></li>'; 
			$tab_content .= '<div id="'.$id.'_'.$i.'">'.do_shortcode($shortcode_tabs[$i]['content']).'</div>'; 
		}
		// put all the parts together
		$finished_tabs = '<ul class="tabList">'.$tab_items.'</ul>'.$tab_content; 
	}
	$shortcode_tabs = '';
	
	return $finished_tabs;
	
}
add_shortcode('tabs', 'theme_tabs');


// Single Tab
//...............................................
function shortcode_tab( $atts, $content = null ) {
	global $shortcode_tabs;
	extract(shortcode_atts(array(
		'title' => ''
    ), $atts));

	// get tab elements
	$tab_elements['title'] = $title;
	$tab_elements['content'] = do_shortcode($content);
	
	$shortcode_tabs[] = $tab_elements;

	//return $tab_elements;
	
}
add_shortcode('tab', 'shortcode_tab');


// Toggle (show/hide, FAQs)
//...............................................
function theme_toggle( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'start' => 'closed'
    ), $atts));

	$startPos = (strtolower($start) == 'open') ? 'style="display:block;"' : 'style="display:none;"';
	$startIcon = (strtolower($start) == 'open') ? 'minus' : 'plus';

	// make the toggle
	$item = '<div class="toggleItem"><a href="#'.sanitize_title($title).'" class="togTitle"><div class="icon16 iconSymbol '.$startIcon.'"></div>'.$title.'</a><div class="togDesc" '.$startPos.'>'.do_shortcode($content).'</div></div>';
	
	return $item;
	
}
add_shortcode('toggle', 'theme_toggle');


#-----------------------------------------------------------------
# Tables
#-----------------------------------------------------------------


// Pricing table
//...............................................
function theme_pricing_table( $atts, $content = null ) {
	global $shortcode_pricing_table;
	extract(shortcode_atts(array(
		'columns' => '3'
    ), $atts));

	// class for number of selected columns
	switch ($columns) {
		case '2':
			$columnsClass .= 'two-column-table';
			break;
		case '3':
			$columnsClass .= 'three-column-table';
			break;
		case '4':
			$columnsClass .= 'four-column-table';
			break;
		case '5':
			$columnsClass .= 'five-column-table';
			break;
		case '6':
			$columnsClass .= 'six-column-table';
			break;
	}

	// get each column (stored to global $shortcode_tabs)
	do_shortcode($content);

	$columnContent = '';
	
	// create the columns
	if (is_array($shortcode_pricing_table)) {
		// loop through column content
		for ($i = 0; $i < count($shortcode_pricing_table); $i++) {
			$colClass = 'price-column'; $n = $i + 1;
			// column classes
			$colClass .= ( $n % 2 ) ?  '' : ' even-column';
			$colClass .= ( $shortcode_pricing_table[$i]['highlight'] ) ?  ' highlight-column' : '';
			$colClass .= ( $n == count($shortcode_pricing_table) ) ?  ' last-column' : '';
			$colClass .= ( $n == 1 ) ?  ' first-column' : '';
			// column details
			$columnContent .= '<div class="'.$colClass.'">'; 
			$columnContent .= '<h3 class="column-title">'.$shortcode_pricing_table[$i]['title'].'</h3>'; 
			$columnContent .= str_replace(array("\r\n", "\n", "\r"), array("", "", ""), $shortcode_pricing_table[$i]['content']); //str_replace('<p></p>', '', $shortcode_pricing_table[$i]['content']); //$shortcode_pricing_table[$i]['content'];
			$columnContent .= '</div>'; 
		}
		// put all the parts together
		$finished_table = '<div class="price-table '.$columnsClass.'">'.$columnContent.'</div>';
	}
	$shortcode_pricing_table = '';
	
	return $finished_table;
	
}
add_shortcode('pricing_table', 'theme_pricing_table');


// Single Column
//...............................................
function shortcode_pricing_column( $atts, $content = null ) {
	global $shortcode_pricing_table;
	extract(shortcode_atts(array(
		'title' => '',
		'highlight' => 'false'
    ), $atts));

	$highlight = strtolower($highlight);
	
	// get elements
	$column['title'] = $title;
	$column['highlight'] = ( $highlight == 'true' || $highlight == 'yes' || $highlight == '1' ) ? true : false;
	$column['content'] = do_shortcode($content);
	
	$shortcode_pricing_table[] = $column;

	//return $shortcode_pricing_table;
	
}
add_shortcode('pricing_column', 'shortcode_pricing_column');


// Price Info
//...............................................
function shortcode_price_info( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'cost' => ''
    ), $atts));

	$price_info = '<div class="price-info">';
	if ($cost) $price_info .= '<div class="cost">'. $cost .'</div>';
	if ($content) $price_info .= '<div class="details">'. do_shortcode($content) .'</div>';
	$price_info .= '</div>';
	

	return $price_info;
	
}
add_shortcode('price_info', 'shortcode_price_info');



#-----------------------------------------------------------------
# Boxes and containers
#-----------------------------------------------------------------


// Quote
//...............................................

function theme_quote( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'author' => false,
		'image' => false,
		'image_align' => 'left',
		'w' => '0',
		'h' => '0'
    ), $atts));
	
	if ($content) {
		if ($image) {
			$alignClass = ($image_align == 'right') ? ' item-imageRight' : ' item-imageLeft';
			$theImage = '<div class="quoteImage">
							'. theme_plain_image(array('image'=>$image,'w'=>$w,'h'=>$h,'alt'=>$author)) .'
							<div class="quote_arrow"></div>
						</div>';
		}
		
		$theQuote = '<span class="quote_text">'.do_shortcode($content).'</span>';
		$theAuthor = ($author) ?  '<cite class="quote_author">'.$author.'</cite>' : '';
		
		$theContent = '<div class="item-content">'. $theQuote . $theAuthor .'</div>';
	
		return '<div class="messageBox quote'.$alignClass.'">'. $theImage . $theContent .'</div>';
	}
	
}
add_shortcode('quote', 'theme_quote');


// Pull Quote
//...............................................

function theme_pull_quote( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'align' => 'left'
    ), $atts));

	$align = ($align == 'right') ? 'pullRight' : 'pullLeft';

	$content = '<span class="pull-quote '. $align .'">'. do_shortcode($content) .'</span>';
		
   return $content;
}
add_shortcode('pull_quote', 'theme_pull_quote');


// Message boxes
//...............................................

function theme_message_box( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'type' => false,
		'icon' => false,
		'close' => false
    ), $atts));

	$class = 'messageBox';
	
	if ($type == 'inset') {
		$class = 'insetBox'; // overwrite the messageBox class for inset boxes.
	} elseif ($type) {
		$class .= ' '. $type; // add the type class
	}
	if ($icon) $class .= ' icon';

	$box = '<div class="'.$class.'">';
	if ($close) $box .= '<span class="closeBox">'.$close.'</span>';
	$box .= '<span>'.do_shortcode($content).'</span>';
	$box .= '</div>';
		
   return $box;
}
add_shortcode('message_box', 'theme_message_box');


// Text or "Icon" box (with icon)
//...............................................

function theme_text_box( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => false,
		'icon' => false
    ), $atts));

	$class = 'textBox';
	
	if ( isset( $type ) && $type == 'inset') {
		$class = 'insetBox'; // overwrite the messageBox class for inset boxes.
	} elseif ( isset( $type ) ) {
		$class .= ' '. $type; // add the type class
	}
	if ($icon) {
		$class .= ' icon';
		$icon = '<div class="icon48 icon-'. strtolower($icon) .'"></div>';
	}
	if ($title) $title = '<h4 class="textBoxTitle">'.$title.'</h4>';

	$box  = '<div class="'.$class.'">';
		$box .= $icon;
		$box .= '<div class="textContent">';
			$box .= $title;
			$box .= '<span class="theText">'.do_shortcode($content).'</span>';
		$box .= '</div>';
	$box .= '</div>';
		
   return $box;
}
add_shortcode('text_box', 'theme_text_box');



#-----------------------------------------------------------------
# Call to Action
#-----------------------------------------------------------------

// Call to action container
//...............................................
function theme_call_to_action( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'tag_line' => '',
		'button' => '',
		'link' => '#'
    ), $atts));
	
	$cta_header = ( $title || $tag_line || $button ) ? true : false;
	$arrow_class = (isset($arrow) && $arrow) ? 'has-arrow' : '';

	// opening containers
	$call_to_action  = '<div class="call-to-action">';
	//$call_to_action .= '<div class="cta-1-inner"><div class="cta-2-inner"><div class="cta-3-inner"><div class="cta-content">';
	
	// content and options
	if ($cta_header) {
		$call_to_action .= '<div class="cta-header '. $arrow_class  .' clearfix">';
		if ($button) $call_to_action .= '<a href="'.$link.'" class="btn impactBtn"><span>'. $button .'</span></a>';
		if ($title) $call_to_action .= '<h1 class="cta-title">'. $title .'</h1>';
		if ($tag_line) $call_to_action .= '<h2  class="cta-tag-line">'. $tag_line .'</h2>';
		$call_to_action .= '</div>';
	}
	
	// closing containers
	$call_to_action .= '</div>';

	return $call_to_action;
	
}
add_shortcode('call_to_action', 'theme_call_to_action');



#-----------------------------------------------------------------
# Content Dividers
#-----------------------------------------------------------------

function theme_hr( $atts ) {

	// this is stupid, but it's asier to change it to <hr> than all the existing [hr] tags in the content.
	return '<hr>';	
   
   //return '<div class="hr"></div>';
}
add_shortcode('hr', 'theme_hr');


function theme_clear( $atts ) {
   return '<div class="clear"></div>';
}
add_shortcode('clear', 'theme_clear');



#-----------------------------------------------------------------
# Breadcrumbs
#-----------------------------------------------------------------

// Breadcrumbs output
//...............................................
function theme_breadcrumbs( $atts, $content = null ) {

	return show_breadcrumb('<div class="breadcrumbs">','</div>',false,$atts); //$return_content;
	
}
add_shortcode('breadcrumbs', 'theme_breadcrumbs');



#-----------------------------------------------------------------
# Page Title
#-----------------------------------------------------------------

// For inserting in theme headers or other design elements
//...............................................
function theme_page_title( $atts, $content = null ) {
	global $post;

	// $title = esc_attr($post->post_title);

	return $post->post_title;
	
}
add_shortcode('page_title', 'theme_page_title');



#-----------------------------------------------------------------
# Static Content Blocks
#-----------------------------------------------------------------

// For inserting in theme headers or other design elements
//...............................................
function theme_static_content( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'id' => false
    ), $atts));
	
	if ($id) {
		return '<div class="fromShortcode">'. add_page_content(array('name'=>'content-static','value'=>$id)) .'</div>';
	}
}
add_shortcode('static_content', 'theme_static_content');



#-----------------------------------------------------------------
# Sidebar include
#-----------------------------------------------------------------

// Sidebar output
//...............................................
function theme_sidebar( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'alias' => false
    ), $atts));
	
	if ( $alias ) {
		
		// find the sidebar ID by the alias
		$sidebars = get_theme_var('sidebars');
		foreach($sidebars as $key => $value){
			if ($value['alias'] == $alias) {
				$id = $key;
				break;
			}
		}
	
		if (isset($id) && $id) {
			// turn on output buffering to capture output
			ob_start();
			// generate sidebar
			dynamic_sidebar('generated_sidebar-'.$id);
			// get output content
			$content = ob_get_clean();
			// return the content
			return $content;
		}
	}

}
add_shortcode('sidebar', 'theme_sidebar');



#-----------------------------------------------------------------
# Slide show
#-----------------------------------------------------------------

// Slide show output
//...............................................
function theme_slideshow( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'alias' => '',
		'width' => false,
		'height' => false
    ), $atts));
	
	if ($alias) {
		
		// turn on output buffering to capture output
		ob_start();
		// generate sidebar
		display_slideShow($alias, $width, $height);
		// get output content
		$content = ob_get_clean();
		$content = '<div class="styled-slideshow">'. $content .'</div>';
		// return the content
		return $content;
	}
}
add_shortcode('slideshow', 'theme_slideshow');



// Slide element animation
//...............................................

// Left
function shortcode_slideLeft( $atts, $content = null ) {
	$atts['direction'] = 'Left';
	$content = shortcode_slideAnimate( $atts, $content);
	return $content;
}
add_shortcode('slide_left', 'shortcode_slideLeft');
// Right
function shortcode_slideRight( $atts, $content = null ) {
	$atts['direction'] = 'Right';
	$content = shortcode_slideAnimate( $atts, $content);
	return $content;
}
add_shortcode('slide_right', 'shortcode_slideRight');
// Up
function shortcode_slideUp( $atts, $content = null ) {
	$atts['direction'] = 'Up';
	$content = shortcode_slideAnimate( $atts, $content);
	return $content;
}
add_shortcode('slide_up', 'shortcode_slideUp');
// Down
function shortcode_slideDown( $atts, $content = null ) {
	$atts['direction'] = 'Down';
	$content = shortcode_slideAnimate( $atts, $content);
	return $content;
}
add_shortcode('slide_down', 'shortcode_slideDown');


function shortcode_slideAnimate( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'direction' => 'right',
		'easing'    => 'stopFast',
		'speed'     => '1000',
		'delay'     => '0',
		'css'       => false
    ), $atts));
	
	$content = '<div class="slide'. ucfirst($direction) .' slideAnimate" style="'. $css .'" data-output=\'{"easing":"'. $easing .'","speed":"'. $speed .'", "delay":"'. $delay .'"}\'>'. do_shortcode($content) .'</div>';

	// return the content
	return $content;

}
add_shortcode('slide_animate', 'shortcode_slideAnimate');


#-----------------------------------------------------------------
# Portfolio
#-----------------------------------------------------------------

// Portfolio output
//...............................................
function theme_portfolio( $atts, $content = null ) {
	
	return make_theme_portfolio_page($atts); //$return_content;

}
add_shortcode('portfolio', 'theme_portfolio');


#-----------------------------------------------------------------
# Blog output
#-----------------------------------------------------------------

// Blog output
//...............................................
function theme_blog( $atts, $content = null ) {

	return make_theme_blog_page($atts); //$return_content;
	
}
add_shortcode('blog', 'theme_blog');


// Related posts
//...............................................
function shortcode_related_posts( $atts, $content = null ) {

	extract(shortcode_atts(array(
	    'limit' => '5',
	), $atts));

	global $wpdb, $post, $table_prefix;

	if ($post->ID) {
		$retval = '<ul>';
 		// Get tags
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);

		// Do the query
		$q = "SELECT p.*, count(tr.object_id) as count
			FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
 			GROUP BY tr.object_id
			ORDER BY count DESC, p.post_date_gmt DESC
			LIMIT $limit;";

		$related = $wpdb->get_results($q);
 		if ( $related ) {
			foreach($related as $r) {
				$retval .= '<li><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></li>';
			}
		} else {
			$retval .= '
	<li>No related posts found</li>';
		}
		$retval .= '</ul>';
		return $retval;
	}
	return;
	
}
add_shortcode('related_posts', 'shortcode_related_posts');



#-----------------------------------------------------------------
# Members Only
#-----------------------------------------------------------------

// Members content only (hide from public)
//...............................................
function theme_members_only( $atts, $content = null ) {
	
	if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
		return do_shortcode($content);
	
	return '';
	
}
add_shortcode('members_only', 'theme_members_only');


// Public users content only (hide after login)
//...............................................
function theme_public_only( $atts, $content = null ) {
	
	if ( !is_user_logged_in() && !is_null( $content ) && !is_feed() )
		return do_shortcode($content);
	
	return '';
	
}
add_shortcode('public_only', 'theme_public_only');



#-----------------------------------------------------------------
# Contact Form
#-----------------------------------------------------------------

// Contact shortcode function
//...............................................
function theme_contact_form($atts, $content = null) {
	
	// To
	if (isset($atts['to'])) $atts['to'] = trim($atts['to']);

	// Subject
	if (isset($atts['subject'])) $atts['subject'] = trim($atts['subject']);

	// Thank you message
	if (isset($atts['thankyou'])) $atts['thankyou'] = trim($atts['thankyou']);

	// Button text
	if (isset($atts['button'])) $atts['button'] = trim($atts['button']);

	// Captcha
	if (isset($atts['captcha'])) $atts['captcha'] = strtolower(trim($atts['captcha']));

	// return the form
	return make_theme_contact_form($atts); 
}

// Add shortcode
//...............................................
add_shortcode('contact_form','theme_contact_form');  


#-----------------------------------------------------------------
# Page Layout Shortcodes
#-----------------------------------------------------------------

// Content Columns
//...............................................

function theme_one_third( $atts, $content = null ) {
	return '<div class="col-1-3">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_third', 'theme_one_third');


function theme_one_third_last( $atts, $content = null ) {
	return '<div class="col-1-3 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_third_last', 'theme_one_third_last');


function theme_two_third( $atts, $content = null ) {
	return '<div class="col-2-3">'. do_shortcode($content) .'</div>';
}
add_shortcode('two_third', 'theme_two_third');


function theme_two_third_last( $atts, $content = null ) {
	return '<div class="col-2-3 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('two_third_last', 'theme_two_third_last');


function theme_one_half( $atts, $content = null ) {
	return '<div class="col-1-2">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_half', 'theme_one_half');


function theme_one_half_last( $atts, $content = null ) {
	return '<div class="col-1-2 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_half_last', 'theme_one_half_last');


function theme_one_fourth( $atts, $content = null ) {
	return '<div class="col-1-4">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_fourth', 'theme_one_fourth');


function theme_one_fourth_last( $atts, $content = null ) {
	return '<div class="col-1-4 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_fourth_last', 'theme_one_fourth_last');


function theme_three_fourth( $atts, $content = null ) {
	return '<div class="col-3-4">'. do_shortcode($content) .'</div>';
}
add_shortcode('three_fourth', 'theme_three_fourth');


function theme_three_fourth_last( $atts, $content = null ) {
	return '<div class="col-3-4 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('three_fourth_last', 'theme_three_fourth_last');


function theme_one_fifth( $atts, $content = null ) {
	return '<div class="col-1-5">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_fifth', 'theme_one_fifth');


function theme_one_fifth_last( $atts, $content = null ) {
	return '<div class="col-1-5 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('one_fifth_last', 'theme_one_fifth_last');


function theme_two_fifth( $atts, $content = null ) {
	return '<div class="col-2-5">'. do_shortcode($content) .'</div>';
}
add_shortcode('two_fifth', 'theme_two_fifth');


function theme_two_fifth_last( $atts, $content = null ) {
	return '<div class="col-2-5 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('two_fifth_last', 'theme_two_fifth_last');


function theme_three_fifth( $atts, $content = null ) {
	return '<div class="col-3-5">'. do_shortcode($content) .'</div>';
}
add_shortcode('three_fifth', 'theme_three_fifth');


function theme_three_fifth_last( $atts, $content = null ) {
	return '<div class="col-3-5 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('three_fifth_last', 'theme_three_fifth_last');


function theme_four_fifth( $atts, $content = null ) {
	return '<div class="col-4-5">'. do_shortcode($content) .'</div>';
}
add_shortcode('four_fifth', 'theme_four_fifth');


function theme_four_fifth_last( $atts, $content = null ) {
	return '<div class="col-4-5 last">'. do_shortcode($content) .'</div>';
}
add_shortcode('four_fifth_last', 'theme_four_fifth_last');



#-----------------------------------------------------------------
# Miscelanious shortcodes (not included in editor drop down)
#-----------------------------------------------------------------

// Logout URL
//...............................................
function shortcode_logout_link( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'redirect' => ''
    ), $atts));
	
	return wp_logout_url($redirect);
	
}
add_shortcode('logout_link', 'shortcode_logout_link');

// Create Nonce Value
//...............................................
function shortcode_create_nonce( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'action' => -1
    ), $atts));
	
	return wp_create_nonce($action);
	
}
add_shortcode('create_nonce', 'shortcode_create_nonce');

// Logout Nonce
//...............................................
function shortcode_logout_nonce( $atts, $content = null ) {

	$URL = str_replace( '&amp;', '&', wp_logout_url() );
	$URL_Parts = parse_url($URL);
	parse_str($URL_Parts['query'], $vars);

	return $vars['_wpnonce'];
	
}
add_shortcode('logout_nonce', 'shortcode_logout_nonce');

// call_user_func()
//...............................................
function shortcode_fn( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'function' => ''
    ), $atts));
	
	// See if a function exists by this name
	if ( $function && function_exists($function) ) {
		// remove the function from the $atts array
		unset($atts['function']);
		// execute the funtion and pass the parameters
		return call_user_func($function, $atts);
	}
			
	//return get_home_url( $blog_id, $path, $scheme );
	
}
add_shortcode('fn', 'shortcode_fn');


// get_template_part()
//...............................................
function shortcode_template_part( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'slug' => '',
		'name' => ''
    ), $atts));
	
	if ($slug || $name) {
		// turn on output buffering to capture output
		ob_start();
		// generate sidebar
		get_template_part( $slug, $name );
		// get output content
		$content = ob_get_clean();
		// return the content
		return $content;
	}
	
}
add_shortcode('template_part', 'shortcode_template_part');

// Current URI (this helps for the demo skin changer)
//...............................................
function shortcode_url_path( $atts, $content = null ) {
			
	return trailingslashit( parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) );
	
}
add_shortcode('url_path', 'shortcode_url_path');


// BuddyPress Notices - Admin notices displayed site wide (logged in users only)
//...............................................
function shortcode_bp_notices( $atts, $content = null ) {
			
	if (bp_plugin_is_active()) {
		if ( function_exists( 'bp_message_get_notices' ) && is_user_logged_in() ) :
			// turn on output buffering to capture output
			ob_start();
			// output the notice (stupid BP echo's and no option for return)
			bp_message_get_notices(); /* Site wide notices to all users */
			// get output content
			$content = ob_get_clean();
			// return the content
			return '<div class="bp-notices">'. $content .'</div>';
		endif;
	}
	
}
add_shortcode('bp_notices', 'shortcode_bp_notices');



?>