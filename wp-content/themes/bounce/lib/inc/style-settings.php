<?php global $gp_settings;

// Convert hex codes to rgb

function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);	
	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		$rgb = array($r, $g, $b);
		return implode(",", $rgb);
	} elseif(strlen($hex) > 3) {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
		$rgb = array($r, $g, $b);
		return implode(",", $rgb);
	} else {}
}


// CSS3 Pie

echo '
<!--[if lte IE 9]>
<style>

.skin-darkblue #header-outer {-pie-background: url('.get_template_directory_uri().'/lib/images/header-bg-darkblue.png) right top no-repeat, linear-gradient(#2d353a, #000);}

.skin-darkblue #top-content.top-content-stripes {-pie-background: url('.get_template_directory_uri().'/lib/images/top-content-bg.png) right bottom no-repeat, linear-gradient(#364046, #15191b);}

.skin-darkgrey #header-outer {-pie-background: url('.get_template_directory_uri().'/lib/images/header-bg-darkgrey.png) right top no-repeat, linear-gradient(#333, #000);}

.skin-darkgrey #top-content.top-content-stripes {-pie-background: url('.get_template_directory_uri().'/lib/images/top-content-bg.png) right bottom no-repeat, linear-gradient(#3e3e3e, #181818);}

.skin-maroon #header-outer {-pie-background: url('.get_template_directory_uri().'/lib/images/header-bg-maroon.png) right top no-repeat, linear-gradient(#3A2C2E, #000);}
.skin-maroon #top-content.top-content-stripes {-pie-background: url('.get_template_directory_uri().'/lib/images/top-content-bg.png) right bottom no-repeat, linear-gradient(#453537, #1A1415);}

.skin-orange #header-outer {-pie-background: url('.get_template_directory_uri().'/lib/images/header-bg-darkgrey.png) right top no-repeat, linear-gradient(#333, #000);}
.skin-orange #top-content.top-content-stripes {-pie-background: url('.get_template_directory_uri().'/lib/images/top-content-bg.png) right bottom no-repeat, linear-gradient(#E66D1A, #B85614);}

.skin-purple #header-outer {-pie-background: url('.get_template_directory_uri().'/lib/images/header-bg-purple.png) right top no-repeat, linear-gradient(#2C2E3A, #000);}
.skin-purple #top-content.top-content-stripes {-pie-background: url('.get_template_directory_uri().'/lib/images/top-content-bg.png) right bottom no-repeat, linear-gradient(#353745, #14151A);}

.skin-teal #header-outer {-pie-background: url('.get_template_directory_uri().'/lib/images/header-bg-teal.png) right top no-repeat, linear-gradient(#60807B, #405451);}
.skin-teal #top-content.top-content-stripes {-pie-background: url('.get_template_directory_uri().'/lib/images/top-content-bg.png) right bottom no-repeat, linear-gradient(#6A8A87, #495F5B);}
								
#header-outer, #nav, #top-content, #top-content.top-content-stripe, #top-content #searchform, .author-info, .sc-price-box, .widget_nav_menu a:hover, .widget_nav_menu .current-menu-item > a, .wp-pagenavi span, .wp-pagenavi.cat-navi a, .wp-pagenavi.comment-navi a, .wp-pagenavi.post-navi a span, .gallery img, .frame #content-wrapper, .post-thumbnail, .sc-button, .sc-button:hover, .separate > div, .sc-image.image-border, .dropcap2, .dropcap3, .dropcap4, .dropcap5, .notify, .comment-avatar img, .post-author, #bp-links a, .avatar, .bp-wrapper .button, .button.submit, .bp-wrapper .generic-button a, .bp-wrapper ul.button-nav li a, .bp-wrapper .item-list .activity-meta a, .bp-wrapper .item-list .acomment-options a, .bp-wrapper .activity-meta a:hover span, .widget .item-options a, .widget .item-options a.selected, .widget .swa-wrap ul#activity-filter-links a, .widget .swa-activity-list li.mini div.swa-activity-meta a, .widget .swa-activity-list div.swa-activity-meta a.acomment-reply, .widget .swa-activity-list div.swa-activity-meta a, .widget .swa-activity-list div.acomment-options a, .activity-list div.activity-meta a, .activity-list div.acomment-options a
{
behavior: url("'.get_template_directory_uri().'/lib/scripts/pie/PIE.php");
}
</style>
<![endif]-->';


echo '<style>';
	
// Primary

if(get_option($dirname.'_primary_text_color') OR get_option($dirname.'_primary_font') OR get_option($dirname.'_primary_size')) {
	echo 'body, input, textarea, select, .bp-wrapper div.activity-comments form .ac-textarea, .bp-wrapper #whats-new-textarea, .widget div.swa-activity-comments form .ac-textarea, .widget #swa-whats-new-textarea {
	color: '.get_option($dirname.'_primary_text_color').';	
	font-family: "'.get_option($dirname.'_primary_font').'";
	font-size: '.get_option($dirname.'_primary_size').'px;
	}';
}
	
if(get_option($dirname.'_primary_link_color')) {
	echo 'a, .bp-active.bp-wrapper div.item-list-tabs ul li.selected a, .bp-active.bp-wrapper div.item-list-tabs ul li.current a {color: '.get_option($dirname.'_primary_link_color').';}';
}

if(get_option($dirname.'_primary_link_hover_color')) {
	echo 'a:hover, .bp-active.bp-wrapper div.item-list-tabs ul li a:hover {color: '.get_option($dirname.'_primary_link_hover_color').';}';
}

if(get_option($dirname.'_primary_bg_color')) {
	echo '.frame #content-wrapper {background-color: '.get_option($dirname.'_primary_bg_color').';}';
}	
		
if(get_option($dirname.'_primary_border_color')) {
	echo 'input, textarea, select, .post-meta, .sc-divider, .frame .sc-divider, .author-info, .separate > div, .joint > div, .widget, .frame .widget, .bp-wrapper div.item-list-tabs ul li, .bp-wrapper div.item-list-tabs, .frame.bp-wrapper div.item-list-tabs, .bp-wrapper div.activity-comments form .ac-textarea, .bp-wrapper #whats-new-textarea, .widget div.swa-activity-comments form .ac-textarea, .widget #swa-whats-new-textarea {border-color:'.get_option($dirname.'_primary_border_color').';}';
}	


// Secondary
		
if(get_option($dirname.'_secondary_text_color')) {
	echo '#content .post-meta {color: '.get_option($dirname.'_secondary_text_color').';}';
}	

if(get_option($dirname.'_secondary_link_color')) {
	echo '#content .post-meta a {color: '.get_option($dirname.'_secondary_link_color').';}';
}

if(get_option($dirname.'_secondary_link_hover_color')) {
	echo '#content .post-meta a:hover {color: '.get_option($dirname.'_secondary_link_hover_color').';}';
}
			
if(get_option($dirname.'_secondary_bg_color')) {		
	echo 'input, textarea, select, .ui-tabs .ui-tabs-nav li.ui-tabs-active, .sc-tab-panel, .post-thumbnail, .avatar, .bp-wrapper div.activity-comments form .ac-textarea, .bp-wrapper #whats-new-textarea, .widget div.swa-activity-comments form .ac-textarea, .widget #swa-whats-new-textarea {background-color: '.get_option($dirname.'_secondary_bg_color').' !important;}';
}

		
// Background Gradients

if(get_option($dirname.'_bg_image') OR get_option($dirname.'_top_bg_gradient_color') OR get_option($dirname.'_bottom_bg_gradient_color')) {

	if(get_option($dirname.'_top_bg_gradient_color') == "") { $top_bg_gradient_color = "#000000"; } else { $top_bg_gradient_color = get_option($dirname.'_top_bg_gradient_color'); }
	if(get_option($dirname.'_bottom_bg_gradient_color') == "") { $bottom_bg_gradient_color = "#000000"; } else { $bottom_bg_gradient_color = get_option($dirname.'_bottom_bg_gradient_color'); }

	echo '.'.$gp_settings['skin'].' #header-outer {
		background-color: '.$top_bg_gradient_color.';
		background-image: url('.get_option($dirname.'_bg_image').'), -moz-linear-gradient('.$top_bg_gradient_color.', '.$bottom_bg_gradient_color.');
		background-image: url('.get_option($dirname.'_bg_image').'), -webkit-gradient(linear, 0% 0%, 0% 100%, from('.$top_bg_gradient_color.'), to('.$bottom_bg_gradient_color.'));
		background-image: url('.get_option($dirname.'_bg_image').'), -webkit-linear-gradient('.$top_bg_gradient_color.', '.$bottom_bg_gradient_color.');
		background-image: url('.get_option($dirname.'_bg_image').'), -o-linear-gradient('.$top_bg_gradient_color.', '.$bottom_bg_gradient_color.');
		background-image: url('.get_option($dirname.'_bg_image').'), -ms-linear-gradient('.$top_bg_gradient_color.', '.$bottom_bg_gradient_color.');
		-pie-background: url('.get_option($dirname.'_bg_image').') right top no-repeat, linear-gradient('.$top_bg_gradient_color.', '.$bottom_bg_gradient_color.');		
	}';
}	


// Elements Gradient Background Colors

if(get_option($dirname.'_elements_text_color')) {
	echo '#top-content, .post-meta, #top-content h1, #top-content h2, #top-content h3, #top-content h4, #top-content h5, #top-content h6, #breadcrumbs, .author-info, .sc-price-box, .sc-pricing-table thead th {color: '.get_option($dirname.'_elements_text_color').';}';
}

if(get_option($dirname.'_elements_link_color')) {
	echo '#top-content a, #breadcrumbs a, input[type="button"], input[type="submit"], input[type="reset"], .widget_nav_menu a:hover, .widget_nav_menu .current-menu-item > a, .wp-pagenavi span, .wp-pagenavi.cat-navi a, .wp-pagenavi.comment-navi a, .wp-pagenavi.post-navi a span, .caption, #bp-links a {color: '.get_option($dirname.'_elements_link_color').';}';
}

if(get_option($dirname.'_elements_link_hover_color')) {
	echo '#top-content a:hover, #breadcrumbs a:hover, input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover, .wp-pagenavi.cat-navi a:hover, .wp-pagenavi.comment-navi a:hover, .wp-pagenavi.post-navi a:hover span {color: '.get_option($dirname.'_elements_link_hover_color').';}';
}
		
if(get_option($dirname.'_elements_top_gradient_color') OR get_option($dirname.'_elements_bottom_gradient_color')) {	
	echo 'input[type="button"], input[type="submit"], input[type="reset"], .'.$gp_settings['skin'].' #top-content, .'.$gp_settings['skin'].' #top-content.top-content-stripes, .author-info, .sc-price-box, .sc-pricing-table thead th, .widget_nav_menu a:hover, .widget_nav_menu .current-menu-item > a, .wp-pagenavi span, .wp-pagenavi.cat-navi a, .wp-pagenavi.comment-navi a, .wp-pagenavi.post-navi a span, .caption, #bp-links {
		background-color: '.get_option($dirname.'_elements_top_gradient_color').' !important;
		background-image: -moz-linear-gradient('.get_option($dirname.'_elements_top_gradient_color').', '.get_option($dirname.'_elements_bottom_gradient_color').');
		background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from('.get_option($dirname.'_elements_top_gradient_color').'), to('.get_option($dirname.'_elements_bottom_gradient_color').'));
		background-image: -webkit-linear-gradient('.get_option($dirname.'_elements_top_gradient_color').', '.get_option($dirname.'_elements_bottom_gradient_color').');
		background-image: -o-linear-gradient('.get_option($dirname.'_elements_top_gradient_color').', '.get_option($dirname.'_elements_bottom_gradient_color').');
		background-image: -ms-linear-gradient('.get_option($dirname.'_elements_top_gradient_color').', '.get_option($dirname.'_elements_bottom_gradient_color').');
		-pie-background: linear-gradient('.get_option($dirname.'_elements_top_gradient_color').', '.get_option($dirname.'_elements_bottom_gradient_color').');
	}';
	echo '#top-content #searchform {background: rgb(0,0,0); background: rgba(0,0,0,0.3); -pie-background: none;}';
}

if(get_option($dirname.'_elements_top_gradient_hover_color') OR get_option($dirname.'_elements_bottom_gradient_hover_color')) {	
	echo 'input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover, .wp-pagenavi.cat-navi a:hover, .wp-pagenavi.comment-navi a:hover, .wp-pagenavi.post-navi a:hover span {
		background-color: '.get_option($dirname.'_elements_top_gradient_hover_color').';
		background-image: -moz-linear-gradient('.get_option($dirname.'_elements_top_gradient_hover_color').', '.get_option($dirname.'_elements_bottom_gradient_hover_color').');
		background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from('.get_option($dirname.'_elements_top_gradient_hover_color').'), to('.get_option($dirname.'_elements_top_gradient_hover_color').'));
		background-image: -webkit-linear-gradient('.get_option($dirname.'_elements_top_gradient_hover_color').', '.get_option($dirname.'_elements_bottom_gradient_hover_color').');
		background-image: -o-linear-gradient('.get_option($dirname.'_elements_top_gradient_hover_color').', '.get_option($dirname.'_elements_bottom_gradient_hover_color').');
		background-image: -ms-linear-gradient('.get_option($dirname.'_elements_top_gradient_hover_color').', '.get_option($dirname.'_elements_bottom_gradient_hover_color').');
		-pie-background: linear-gradient('.get_option($dirname.'_elements_top_gradient_hover_color').', '.get_option($dirname.'_elements_bottom_gradient_hover_color').');
	}';
}

if(get_option($dirname.'_elements_border_color')) {
	echo 'input[type="button"], input[type="submit"], input[type="reset"], #top-content, .author-info, .sc-price-box, .sc-pricing-table thead th, .widget_nav_menu a:hover, .widget_nav_menu .current-menu-item > a, .wp-pagenavi span, .wp-pagenavi.cat-navi a, .wp-pagenavi.comment-navi a, .wp-pagenavi.post-navi a span, #top-content #searchform {border-color:'.get_option($dirname.'_elements_border_color').';}';
}	


// Navigation Menu Gradient Background Colors

if(get_option($dirname.'_nav_top_gradient_color') OR get_option($dirname.'_nav_bottom_gradient_color')) {	
	echo '#nav {
		background-color: '.get_option($dirname.'_nav_top_gradient_color').';
		background-image: -moz-linear-gradient('.get_option($dirname.'_nav_top_gradient_color').', '.get_option($dirname.'_nav_bottom_gradient_color').');
		background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from('.get_option($dirname.'_nav_top_gradient_color').'), to('.get_option($dirname.'_nav_bottom_gradient_color').'));
		background-image: -webkit-linear-gradient('.get_option($dirname.'_nav_top_gradient_color').', '.get_option($dirname.'_nav_bottom_gradient_color').');
		background-image: -o-linear-gradient('.get_option($dirname.'_nav_top_gradient_color').', '.get_option($dirname.'_nav_bottom_gradient_color').');
		background-image: -ms-linear-gradient('.get_option($dirname.'_nav_top_gradient_color').', '.get_option($dirname.'_nav_bottom_gradient_color').');
		-pie-background: linear-gradient('.get_option($dirname.'_nav_top_gradient_color').', '.get_option($dirname.'_nav_bottom_gradient_color').');
	}';
}

if(get_option($dirname.'_nav_dropdown_bg_color')) {
	echo '#nav .sub-menu {background-color: '.get_option($dirname.'_nav_dropdown_bg_color').';}';
}	
		
if(get_option($dirname.'_nav_dropdown_border_color')) {
	echo '#nav .sub-menu, #nav .sub-menu a {border-color:'.get_option($dirname.'_nav_dropdown_border_color').';}';
}	

if(get_option($dirname.'_nav_link_color')) {
	echo '#nav li > a, #nav .sub-menu a {color: '.get_option($dirname.'_nav_link_color').';}';
}

if(get_option($dirname.'_nav_link_hover_color')) {
	echo '#nav .sub-menu a:hover {color: '.get_option($dirname.'_nav_link_hover_color').';}';
}
	
	
// Headings

if(get_option($dirname.'_heading_text_color') OR get_option($dirname.'_heading_font')) {
	echo 'h1, h2, h3, h4, h5, h6, .widget .widgettitle {color: '.get_option($dirname.'_heading_text_color').'; font-family: "'.get_option($dirname.'_heading_font').'";}';
}	

if(get_option($dirname.'_heading1_size')) {
	echo 'h1 {font-size: '.get_option($dirname.'_heading1_size').'px;}';
}	

if(get_option($dirname.'_heading2_size')) {
	echo 'h2 {font-size: '.get_option($dirname.'_heading2_size').'px;}';
}
	
if(get_option($dirname.'_heading3_size')) {
	echo 'h3 {font-size: '.get_option($dirname.'_heading3_size').'px;}';
}
	
if(get_option($dirname.'_heading_link_color')) {				
	echo 'h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .post-text h2 a {color: '.get_option($dirname.'_heading_link_color').';}';
}

if(get_option($dirname.'_heading_link_hover_color')) {
	echo 'h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .post-text h2 a:hover {color: '.get_option($dirname.'_heading_link_hover_color').';}';
}	

echo '</style>';

?>