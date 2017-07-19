<?php
/*
	===============================================================================

	Copyright 2012  Richard Ashby  (email : wordpress@mediacreek.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/


/**
 A shortcode that outputs a link which will delete the cookie used to track
 whether or not a vistor has dismissed the header message (i.e. so it doesn't
 keep on showing on all pages)

 Usage:	[delete_cookies]
		[delete_cookies linktext="delete cookies"]
 
 N.B. This shortcut does not block cookies, or delete any other cookies!
*/
function cookielawinfo_delete_cookies_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'text' => 'Delete Cookies'
	), $atts ) );
	return "<a href='' id='cookielawinfo-cookie-delete'>{$text}</a>";
}


/**
 A nice shortcode to output a table of cookies you have saved, output in ascending
 alphabetical order. If there are no cookie records found a single empty row is shown.
 You can customise the 'not shown' message (see commented code below)

 N.B. This only shows the information you entered on the "cookie" admin page, it
 does not necessarily mean you comply with the cookie law. It is up to you, or
 the website owner, to make sure you have conducted an appropriate cookie audit
 and are informing website visitors of the actual cookies that are being stored.

 Usage:					[cookie_audit]
						[cookie_audit style="winter"]
						[cookie_audit not_shown_message="No records found"]
						[cookie_audit style="winter" not_shown_message="Not found"]

 Styles included:		simple, classic, modern, rounded, elegant, winter.
						Default style applied: classic.

 Additional styles:		You can customise the CSS by editing the CSS file itself,
 						included with plugin.
*/
function cookielawinfo_table_shortcode( $atts ) {
	
	/** RICHARDASHBY EDIT: only add CSS if table is being used */
	wp_enqueue_style( 'cookielawinfo-table-style' );
	/** END EDIT */
	
	extract( shortcode_atts( array(
		'style' => 'classic',
		'not_shown_message' => ''
	), $atts ) );
	
	global $post;
	
	$args = array(
		'post_type' => 'cookielawinfo',
		/** 28/05/2013: Changing from 10 to 50 to allow longer tables of cookie data */
		'posts_per_page' => 50,
		'order' => 'ASC',
		'orderby' => 'title'
	);
	$cookies = new WP_Query( $args );
	
	$ret = '<table class="cookielawinfo-' . $style . '"><thead><tr>';
	$ret .= '<th class="cookielawinfo-column-1">Cookie</th>';
	$ret .= '<th class="cookielawinfo-column-2">Type</th>';
	$ret .= '<th class="cookielawinfo-column-3">Duration</th>';
	$ret .= '<th class="cookielawinfo-column-4">Description</th></tr>';
	$ret .= '</thead><tbody>';
	
	if ( !$cookies->have_posts() ) {
		$ret .= '<tr class="cookielawinfo-row"><td colspan="2" class="cookielawinfo-column-empty">' . $not_shown_message . '</td></tr>';
	}
	
	while ( $cookies->have_posts() ) : $cookies->the_post();
		// Get custom fields:
		$custom = get_post_custom( $post->ID );
		$cookie_type = ( isset ( $custom["_cli_cookie_type"][0] ) ) ? $custom["_cli_cookie_type"][0] : '';
		$cookie_duration = ( isset ( $custom["_cli_cookie_duration"][0] ) ) ? $custom["_cli_cookie_duration"][0] : '';
		// Output HTML:
		$ret .= '<tr class="cookielawinfo-row"><td class="cookielawinfo-column-1">' . get_the_title() . '</td>';
		$ret .= '<td class="cookielawinfo-column-2">' . $cookie_type .'</td>';
		$ret .= '<td class="cookielawinfo-column-3">' . $cookie_duration .'</td>';
		$ret .= '<td class="cookielawinfo-column-4">' . get_the_content() .'</td>';
		$ret .= '</tr>';
	endwhile;
	$ret .= '</tbody></table>';
	return $ret;
}


/** Returns HTML for a standard (green, medium sized) 'Accept' button */
function cookielawinfo_shortcode_accept_button( $atts ) {
	extract( shortcode_atts( array(
		'colour' => 'green'
	), $atts ) );

	// Fixing button translate text bug
	// 18/05/2015 by RA
	$defaults = array(
		'button_1_text' => 'Accept'
	);
	$settings = wp_parse_args( cookielawinfo_get_admin_settings(), $defaults );

	return '<a href="#" id="cookie_action_close_header" class="medium cli-plugin-button ' . $colour . '">' . stripslashes( $settings['button_1_text'] ) . '</a>';
}


/** Returns HTML for a generic button */
function cookielawinfo_shortcode_more_link( $atts ) {
	return cookielawinfo_shortcode_button_DRY_code( 'button_2' );
}


/** Returns HTML for a generic button */
function cookielawinfo_shortcode_main_button( $atts ) {
	$defaults = array(
		'button_1_text' => 'Accept',
		'button_1_url' => '#',
		'button_1_action' => '#cookie_action_close_header',
		
		'button_1_link_colour' => '#fff',
		'button_1_new_win' => false,
		'button_1_as_button' => true,
		'button_1_button_colour' => '0f0',
		'button_1_button_size' => 'medium'
	);
	$settings = wp_parse_args( cookielawinfo_get_admin_settings(), $defaults );
	
	$class = '';
	if ( $settings['button_1_as_button'] ) {
		$class .= ' class="' . $settings['button_1_button_size'] . ' cli-plugin-button cli-plugin-main-button"';
	}
	else {
		$class .= ' class="cli-plugin-main-button" ' ;
	}
	
	// If is action not URL then don't use URL!
	$url = ( $settings['button_1_action'] == "CONSTANT_OPEN_URL" ) ? $settings['button_1_url'] : "#";
	
	$link_tag = '<a href="' . $url . '" id="' . cookielawinfo_remove_hash ( $settings['button_1_action'] ) . '" ';
	$link_tag .= ( $settings['button_1_new_win'] ) ? 'target="_blank" ' : '' ;
	$link_tag .= $class . ' >' . stripslashes( $settings['button_1_text'] ) . '</a>';
	
	return $link_tag;
}


/** Returns HTML for a generic button */
function cookielawinfo_shortcode_button_DRY_code( $name ) {
	$arr = cookielawinfo_get_admin_settings();
	$settings = array();
	$class_name = '';
	
	if ( $name == "button_1" ) {
		$settings = array(
			'button_x_text' => stripslashes( $arr['button_1_text'] ),
			'button_x_url' => $arr['button_1_url'],
			'button_x_action' => $arr['button_1_action'],
			
			'button_x_link_colour' => $arr['button_1_link_colour'],
			'button_x_new_win' => $arr['button_1_new_win'],
			'button_x_as_button' => $arr['button_1_as_button'],
			'button_x_button_colour' => $arr['button_1_button_colour'],
			'button_x_button_size' => $arr['button_1_button_size']
		);
		$class_name = 'cli-plugin-main-button';
	}
	elseif ( $name == "button_2" ) {
		$settings = array(
			'button_x_text' => stripslashes( $arr['button_2_text'] ),
			'button_x_url' => $arr['button_2_url'],
			'button_x_action' => $arr['button_2_action'],
			
			'button_x_link_colour' => $arr['button_2_link_colour'],
			'button_x_new_win' => $arr['button_2_new_win'],
			'button_x_as_button' => $arr['button_2_as_button'],
			'button_x_button_colour' => $arr['button_2_button_colour'],
			'button_x_button_size' => $arr['button_2_button_size']
		);
		$class_name = 'cli-plugin-main-link';
	}
	
	$class = '';
	if ( $settings['button_x_as_button'] ) {
		$class .= ' class="' . $settings['button_x_button_size'] . ' cli-plugin-button ' . $class_name . '"';
	}
	else {
		$class .= ' class="' . $class_name . '" ' ;
	}
	
	// If is action not URL then don't use URL!
	$url = ( $settings['button_x_action'] == "CONSTANT_OPEN_URL" ) ? $settings['button_x_url'] : "#";
	
	$link_tag = '<a href="' . $url . '" id="' . cookielawinfo_remove_hash ( $settings['button_x_action'] ) . '" ';
	$link_tag .= ( $settings['button_x_new_win'] ) ? 'target="_blank" ' : '' ;
	$link_tag .= $class . ' >' . $settings['button_x_text'] . '</a>';
	
	return $link_tag;
}


?>
