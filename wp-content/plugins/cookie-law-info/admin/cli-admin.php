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
 Returns default settings
 If you override the settings here, be ultra careful to use escape characters!
 */
function cookielawinfo_get_default_settings() {
	$settings_v0_9 = array(
		'animate_speed_hide' 			=> '500',
		'animate_speed_show' 			=> '500',
		'background' 					=> '#fff',
		'background_url' 				=> '',
		'border' 						=> '#444',
		'border_on'						=> true,
		'button_1_text'					=> 'Accept',
		'button_1_url' 					=> '#',
		'button_1_action' 				=> '#cookie_action_close_header',
		'button_1_link_colour' 			=> '#fff',
		'button_1_new_win' 				=> false,
		'button_1_as_button' 			=> true,
		'button_1_button_colour' 		=> '#000',
		'button_1_button_size' 			=> 'medium',
		'button_2_text' 				=> 'Read More',
		'button_2_url' 					=> get_site_url(),
		'button_2_action' 				=> 'CONSTANT_OPEN_URL',
		'button_2_link_colour' 			=> '#444',
		'button_2_new_win' 				=> true,
		'button_2_as_button'			=> false,
		'button_2_button_colour' 		=> '#333',
		'button_2_button_size' 			=> 'medium',
		'font_family' 					=> 'inherit', // Pick the family, not the easy name (see helper function below)
		'header_fix'                    => false,
		'is_on' 						=> true,
		'notify_animate_hide'			=> true,
		'notify_animate_show'			=> false,
		'notify_div_id' 				=> '#cookie-law-info-bar',
		'notify_position_horizontal'	=> 'right',	// left | right
		'notify_position_vertical'		=> 'bottom', // 'top' = header | 'bottom' = footer
		'notify_message'				=> addslashes ( 'This website uses cookies to improve your experience. We\'ll assume you\'re ok with this, but you can opt-out if you wish.[cookie_button] [cookie_link]' ),
		'scroll_close'                  => false,
		'scroll_close_reload'           => false,
		'showagain_background' 			=> '#fff',
		'showagain_border' 				=> '#000',
		'showagain_text'	 			=> addslashes ( 'Privacy & Cookies Policy' ),
		'showagain_div_id' 				=> '#cookie-law-info-again',
		'showagain_tab' 				=> true,
		'showagain_x_position' 			=> '100px',
		'text' 							=> '#000',
		'use_colour_picker'				=> true,
		'show_once_yn'					=> false,	// this is a new feature so default = switched off
		'show_once'						=> '10000'	// 8 seconds
	);
	return $settings_v0_9;
}


/**
 Delete the values in all fields
 WARNING - this has a predictable result i.e. will delete saved settings! Once deleted,
 the get_admin_options() function will not find saved settings so will return default values
 */
function cookielawinfo_delete_settings() {
	if ( defined ( 'CLI_ADMIN_OPTIONS_NAME' ) ) {
		delete_option( CLI_ADMIN_OPTIONS_NAME );
	}
	if ( defined ( 'CLI_SETTINGS_FIELD' ) ) {
		delete_option( CLI_SETTINGS_FIELD );
	}
}


/**
 Retrieves admin setting: use colour picker in admin panel?
 Default is true
 Useful if issues with WP Theme and need to disable
*/
function cookielawinfo_colourpicker_enabled() {
	$settings = cookielawinfo_get_admin_settings();
	return $settings['use_colour_picker'];
}



/** Retrieves (and sanitises) settings */
function cookielawinfo_get_admin_settings() {
	$settings = cookielawinfo_get_default_settings();
	$stored_options = get_option( CLI_SETTINGS_FIELD );
	if ( !empty( $stored_options ) ) {
		foreach ( $stored_options as $key => $option ) {
			$settings[$key] = cookielawinfo_sanitise( $key, $option );
		}
	}
	update_option( CLI_SETTINGS_FIELD, $settings );
	return $settings;
}


/** Updates latest version number of plugin */
function cookielawinfo_update_to_latest_version_number() {
	update_option( CLI_MIGRATED_VERSION, CLI_LATEST_VERSION_NUMBER );
}


/** Returns true if user is on latest version of plugin */
function cookielawinfo_has_migrated() {
	// Test for previous version. If doesn't exist then safe to say are fresh install:
	$old_settings = get_option( CLI_ADMIN_OPTIONS_NAME );
	if ( empty( $old_settings ) ) {
		return true;
	}
	// Test for latest version number
	$version = get_option( CLI_MIGRATED_VERSION );
	if ( empty ( $version ) ) {
		// No version stored; not yet migrated:
		return false;
	}
	if ( $version == CLI_LATEST_VERSION_NUMBER ) {
		// Are on latest version
		return true;
	}
	echo 'VERSION: ' . $version . '<br /> V2: ' . CLI_LATEST_VERSION_NUMBER;
	// If you got this far then you're on an inbetween version
	return false;
}

function cookielawinfo_copy_old_settings_to_new() {
	$new_settings = cookielawinfo_get_admin_settings();
	$old_settings = get_option( CLI_ADMIN_OPTIONS_NAME );
	
	if ( empty( $old_settings ) ) {
		// Something went wrong:
		return false;
	}
	else {
		// Copy over settings:
		$new_settings['background'] 			= $old_settings['colour_bg'];
		$new_settings['border'] 				= $old_settings['colour_border'];
		$new_settings['button_1_action']		= 'CONSTANT_OPEN_URL';
		$new_settings['button_1_text'] 			= $old_settings['link_text'];
		$new_settings['button_1_url'] 			= $old_settings['link_url'];
		$new_settings['button_1_link_colour'] 	= $old_settings['colour_link'];
		$new_settings['button_1_new_win'] 		= $old_settings['link_opens_new_window'];
		$new_settings['button_1_as_button']		= $old_settings['show_as_button'];
		$new_settings['button_1_button_colour']	= $old_settings['colour_button_bg'];
		$new_settings['notify_message'] 		= $old_settings['message_text'];
		$new_settings['text'] 					= $old_settings['colour_text'];
		
		// Save new values:
		update_option( CLI_SETTINGS_FIELD, $new_settings );
	}
	return true;
}

/** Migrates settings from version 0.8.3 to version 0.9 */
function cookielawinfo_migrate_to_new_version() {
	
	if ( cookielawinfo_has_migrated() ) {
		return false;
	}
	
	if ( !cookielawinfo_copy_old_settings_to_new() ) {
		return false;
	}
	
	// Register that have completed:
	cookielawinfo_update_to_latest_version_number();
	return true;
}


/**
 Returns list of HTML tags allowed in HTML fields for use in declaration of wp_kset field validation.
 
 Deliberately allows class and ID declarations to assist with custom CSS styling.
 To customise further, see the excellent article at: http://ottopress.com/2010/wp-quickie-kses/
 */
function cookielawinfo_allowed_html() {
	$allowed_html = array(
		// Allowed:		<a href="" id="" class="" title="" target="">...</a>
		// Not allowed:	<a href="javascript(...);">...</a>
		'a' => array(
			'href' => array(),
			'id' => array(),
			'class' => array(),
			'title' => array(),
			'target' => array(),
			'rel' => array()
		),
		'b' => array(),
		'br' => array(
			'id' => array(),
			'class' => array()
		),
		'div' => array(
			'id' => array(),
			'class' => array()
		),
		'em' => array (
			'id' => array(),
			'class' => array()
		),
		'i' => array(),
		'img' => array(
			'src' => array(),
			'id' => array(),
			'class' => array(),
			'alt' => array()
		),
		'p' => array (
			'id' => array(),
			'class' => array()
		),
		'span' => array(
			'id' => array(),
			'class' => array()
		),
		'strong' => array(
			'id' => array(),
			'class' => array()
		),
	);
	return $allowed_html;
}


/**
 Returns list of allowed protocols, for use in declaration of wp_kset field validation.
 N.B. JavaScript is specifically disallowed for security reasons.
 Don't even trust your own database, as you don't know if another plugin has written to your settings.
 */
function cookielawinfo_allowed_protocols() {
	// Additional options: 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'
	return array ('http', 'https');
}


/**
 Returns sanitised content based on field-specific rules defined here
 Used for both read AND write operations
 */
function cookielawinfo_sanitise($key, $value) {
	$ret = null;
	
	switch ($key) {
		// Convert all boolean values from text to bool:
		case 'is_on':
		case 'border_on':
		case 'notify_animate_show':
		case 'notify_animate_hide':
		case 'showagain_tab':
		case 'use_colour_picker':
		case 'button_1_new_win':
		case 'button_1_as_button':
		case 'button_2_new_win':
		case 'button_2_as_button':
		case 'scroll_close':
		case 'scroll_close_reload':
		case 'show_once_yn':
		case 'header_fix':
			if ( $value == 'true' || $value === true ) {
				$ret = true;
			}
			elseif ( $value == 'false' || $value === false ) {
				$ret = false;
			}
			else {
				// Unexpected value returned from radio button, go fix the HTML.
				// Failover = assign null.
				$ret = 'fffffff';
			}
			break;
		// Any hex colour e.g. '#f00', '#FE01ab' '#ff0000' but not 'f00' or 'ff0000':
		case 'background':
		case 'text':
		case 'border':
		case 'showagain_background':
		case 'showagain_border':
		case 'button_1_link_colour':
		case 'button_1_button_colour':
		case 'button_2_link_colour':
		case 'button_2_button_colour':
			if ( preg_match( '/^#[a-f0-9]{6}|#[a-f0-9]{3}$/i', $value ) ) {
				// Was: '/^#([0-9a-fA-F]{1,2}){3}$/i' which allowed e.g. '#00dd' (error)
				$ret =  $value;
			}
			else {
				// Failover = assign '#000' (black)
				$ret =  '#000';
			}
			break;
		// Allow some HTML, but no JavaScript. Note that deliberately NOT stripping out line breaks here, that's done when sending JavaScript parameter elsewhere:
		case 'notify_message':
			$ret = wp_kses( $value, cookielawinfo_allowed_html(), cookielawinfo_allowed_protocols() );
			break;
		// URLs only:
		case 'button_1_url':
		case 'button_2_url':
			$ret = esc_url( $value );
			break;
		// Basic sanitisation for all the rest:
		default:
			$ret = sanitize_text_field( $value );
			break;
	}
	return $ret;
}


/**
 Registers menu options
 Hooked into admin_menu
 */
function cookielawinfo_register_custom_menu_page() {
	add_submenu_page(
		'edit.php?post_type=cookielawinfo',
		'Cookie Law Settings',
		'Cookie Law Settings',
		'manage_options',
		'cookie-law-info',
		'cookielawinfo_print_admin_page'
	);
}


/**
 Registers dashboard scripts and styles used for Cookie Law Info plugin settings panel
 Important: these scripts only load on the plugin settings page (avoids conflicts)
 Hooked into admin_enqueue_script
 */
function cookielawinfo_custom_dashboard_styles( $hook ) {
	if ( 'cookielawinfo_page_cookie-law-info' != $hook )
        return;
    
	wp_register_style( 'cookielawinfo-admin-style', plugins_url('/cookie-law-info/css/cli-admin-style.css') );
    wp_enqueue_style( 'cookielawinfo-admin-style' );
}


/**
 Adds custom script to cookielawinfo admin panel to run the colour pickers
 Important: these scripts only load on the plugin settings page (avoids conflicts)
 Hooked into admin_footer
 */
function cookielawinfo_custom_dashboard_styles_my_colours() {
	$screen = get_current_screen();
	if ( $screen->post_type != 'cookielawinfo' ) {
		return;
	}
}


/**
 Returns list of available jQuery actions
 Used by buttons/links in header
 */
function cookielawinfo_get_js_actions() {
	$js_actions = array(
		'Close Header' => '#cookie_action_close_header',
		'Open URL' => 'CONSTANT_OPEN_URL'	// Don't change this value, is used by jQuery
	);
	return $js_actions;
}


/**
 Function returns list of supported fonts
 Used when printing admin form (for combo box)
 */
function cookielawinfo_get_fonts() {
	$fonts = Array(
		'Default theme font'	=> 'inherit',
		'Sans Serif' 			=> 'Helvetica, Arial, sans-serif',
		'Serif' 				=> 'Georgia, Times New Roman, Times, serif',
		'Arial'					=> 'Arial, Helvetica, sans-serif',
		'Arial Black' 			=> 'Arial Black,Gadget,sans-serif',
		'Georgia' 				=> 'Georgia, serif',
		'Helvetica' 			=> 'Helvetica, sans-serif',
		'Lucida' 				=> 'Lucida Sans Unicode, Lucida Grande, sans-serif',
		'Tahoma' 				=> 'Tahoma, Geneva, sans-serif',
		'Times New Roman' 		=> 'Times New Roman, Times, serif',
		'Trebuchet' 			=> 'Trebuchet MS, sans-serif',
		'Verdana' 				=> 'Verdana, Geneva'
	);
	return $fonts;
}


/**
 Returns button sizes (dependent upon CSS implemented - careful if editing)
 Used when printing admin form (for combo boxes)
 */
function cookielawinfo_get_button_sizes() {
	$sizes = Array(
		'Extra Large'	=> 'super',
		'Large'			=> 'large',
		'Medium'		=> 'medium',
		'Small'			=> 'small'
	);
	return $sizes;
}


/**
 Prints a combobox based on options and selected=match value
 
 Parameters:
 	$options = array of options (suggest using helper functions)
 	$selected = which of those options should be selected (allows just one; is case sensitive)
 
 Outputs (based on array ( $key => $value ):
 	<option value=$value>$key</option>
 	<option value=$value selected="selected">$key</option>
 */
function cookielawinfo_print_combobox_options( $options, $selected ) {
	foreach ( $options as $key => $value ) {
		echo '<option value="' . $value . '"';
		if ( $value == $selected ) {
			echo ' selected="selected"';
		}
		echo '>' . $key . '</option>';
	}
}


?>