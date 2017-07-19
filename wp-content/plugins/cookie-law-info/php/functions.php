<?php
/*
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
 Returns JSON object containing the settings for the main script
 REFACTOR / DEBUG: may need to use addslashes( ... ) else breaks JSON
 */
function cookielawinfo_get_json_settings() {
	$settings = cookielawinfo_get_admin_settings();
	
	// DEBUG hex:
	// preg_match('/^#[a-f0-9]{6}|#[a-f0-9]{3}$/i', $hex)
	// DEBUG json_encode - issues across different versions of PHP!
	// $str = json_encode( $slim_settings, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
	
	// Slim down JSON objects to the bare bones:
	$slim_settings = array(
		'animate_speed_hide'			=> $settings['animate_speed_hide'],
		'animate_speed_show'			=> $settings['animate_speed_show'],
		'background'					=> $settings['background'],
		'border'						=> $settings['border'],
		'border_on'						=> $settings['border_on'],
		'button_1_button_colour'		=> $settings['button_1_button_colour'],
		'button_1_button_hover'			=> (cookielawinfo_su_hex_shift( $settings['button_1_button_colour'], 'down', 20 )),
		'button_1_link_colour'			=> $settings['button_1_link_colour'],
		'button_1_as_button'			=> $settings['button_1_as_button'],
		'button_2_button_colour'		=> $settings['button_2_button_colour'],
		'button_2_button_hover'			=> (cookielawinfo_su_hex_shift( $settings['button_2_button_colour'], 'down', 20 )),
		'button_2_link_colour'			=> $settings['button_2_link_colour'],
		'button_2_as_button'			=> $settings['button_2_as_button'],
		'font_family'					=> $settings['font_family'],
		'header_fix'                    => $settings['header_fix'],
		'notify_animate_hide'			=> $settings['notify_animate_hide'],
		'notify_animate_show'			=> $settings['notify_animate_show'],
		'notify_div_id'					=> $settings['notify_div_id'],
		'notify_position_horizontal'	=> $settings['notify_position_horizontal'],
		'notify_position_vertical'		=> $settings['notify_position_vertical'],
		'scroll_close'                  => $settings['scroll_close'],
		'scroll_close_reload'           => $settings['scroll_close_reload'],
		'showagain_tab'					=> $settings['showagain_tab'],
		'showagain_background'			=> $settings['showagain_background'],
		'showagain_border'				=> $settings['showagain_border'],
		'showagain_div_id'				=> $settings['showagain_div_id'],
		'showagain_x_position'			=> $settings['showagain_x_position'],
		'text'							=> $settings['text'],
		'show_once_yn'					=> $settings['show_once_yn'],
		'show_once'						=> $settings['show_once']
	);
	$str = json_encode( $slim_settings );
	/*
	DEBUG: 
	if ( $str == null | $str == '') {
		$str = 'error: json is empty';
	}
	*/
	return $str;
}


/**
 Outputs the cookie control script in the footer
 N.B. This script MUST be output in the footer.
 
 This function should be attached to the wp_footer action hook.
*/
function cookielawinfo_inject_cli_script() {
	$the_options = cookielawinfo_get_admin_settings();
		
	if ( $the_options['is_on'] == true ) {

		// Output the HTML in the footer:
		$str = do_shortcode( stripslashes ( $the_options['notify_message'] ) );
		$notify_html = '<div id="' . cookielawinfo_remove_hash( $the_options["notify_div_id"] ) . '"><span>' . $str . '</span></div>';
		
		if ( $the_options['showagain_tab'] === true ) {
			$notify_html .= '<div id="' . cookielawinfo_remove_hash( $the_options["showagain_div_id"] ) . '"><span id="cookie_hdr_showagain">' . $the_options["showagain_text"] . '</span></div>';
		}

		echo $notify_html;

		// Now output the JavaScript:
		
		?>
		
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function() {
				cli_show_cookiebar({
					settings: '<?php echo cookielawinfo_get_json_settings(); ?>'
				});
			});
			//]]>
		</script>
		
		<?php
	}
}


/**
 Outputs frontend scripts in the header.
 N.B. These scripts MUST be output in the header.
 
 This function should be attached to the wp_enqueue_script action hook, not wp_head!
 Else gets output in footer (incorrect).
*/
function cookielawinfo_enqueue_frontend_scripts() {
	$the_options = cookielawinfo_get_admin_settings();
	if ( $the_options['is_on'] == true ) {

		/**
		 * Force reload
		 */
		$version = '1.5.3';
		
		wp_register_style( 'cookielawinfo-style', CLI_PLUGIN_URL . 'css/cli-style.css', null, $version );
		wp_enqueue_style( 'cookielawinfo-style' );
		
		wp_enqueue_script( 'cookie-law-info-script', CLI_PLUGIN_URL . 'js/cookielawinfo.js', array( 'jquery' ), $version );
	}
	wp_register_style( 'cookielawinfo-table-style', CLI_PLUGIN_URL . 'css/cli-tables.css', null, $version );
}


/**
 * Color shift a hex value by a specific percentage factor
 * By http://www.phpkode.com/source/s/shortcodes-ultimate/shortcodes-ultimate/lib/color.php
 * Adapted by Richard Ashby; amended error handling to use failovers not messages, so app continues
 *
 * @param string $supplied_hex Any valid hex value. Short forms e.g. #333 accepted.
 * @param string $shift_method How to shift the value e.g( +,up,lighter,>)
 * @param integer $percentage Percentage in range of [0-100] to shift provided hex value by
 * @return string shifted hex value
 * @version 1.0 2008-03-28
 */
function cookielawinfo_su_hex_shift( $supplied_hex, $shift_method, $percentage = 50 ) {
	$shifted_hex_value = null;
	$valid_shift_option = FALSE;
	$current_set = 1;
	$RGB_values = array( );
	$valid_shift_up_args = array( 'up', '+', 'lighter', '>' );
	$valid_shift_down_args = array( 'down', '-', 'darker', '<' );
	$shift_method = strtolower( trim( $shift_method ) );

	// Check Factor
	if ( !is_numeric( $percentage ) || ($percentage = ( int ) $percentage) < 0 || $percentage > 100 ) {
		//trigger_error( "Invalid factor", E_USER_ERROR );
		return $supplied_hex;
	}

	// Check shift method
	foreach ( array( $valid_shift_down_args, $valid_shift_up_args ) as $options ) {
		foreach ( $options as $method ) {
			if ( $method == $shift_method ) {
				$valid_shift_option = !$valid_shift_option;
				$shift_method = ( $current_set === 1 ) ? '+' : '-';
				break 2;
			}
		}
		++$current_set;
	}

	if ( !$valid_shift_option ) {
		//trigger_error( "Invalid shift method", E_USER_ERROR );
		return $supplied_hex;
	}

	// Check Hex string
	switch ( strlen( $supplied_hex = ( str_replace( '#', '', trim( $supplied_hex ) ) ) ) ) {
		case 3:
			if ( preg_match( '/^([0-9a-f])([0-9a-f])([0-9a-f])/i', $supplied_hex ) ) {
				$supplied_hex = preg_replace( '/^([0-9a-f])([0-9a-f])([0-9a-f])/i', '\\1\\1\\2\\2\\3\\3', $supplied_hex );
			} else {
				//trigger_error( "Invalid hex color value", E_USER_ERROR );
				return $supplied_hex;
			}
			break;
		case 6:
			if ( !preg_match( '/^[0-9a-f]{2}[0-9a-f]{2}[0-9a-f]{2}$/i', $supplied_hex ) ) {
				//trigger_error( "Invalid hex color value", E_USER_ERROR );
				return $supplied_hex;
			}
			break;
		default:
			//trigger_error( "Invalid hex color length", E_USER_ERROR );
			return $supplied_hex;
	}

	// Start shifting
	$RGB_values['R'] = hexdec( $supplied_hex{0} . $supplied_hex{1} );
	$RGB_values['G'] = hexdec( $supplied_hex{2} . $supplied_hex{3} );
	$RGB_values['B'] = hexdec( $supplied_hex{4} . $supplied_hex{5} );

	foreach ( $RGB_values as $c => $v ) {
		switch ( $shift_method ) {
			case '-':
				$amount = round( ((255 - $v) / 100) * $percentage ) + $v;
				break;
			case '+':
				$amount = $v - round( ($v / 100) * $percentage );
				break;
			default:
				// trigger_error( "Oops. Unexpected shift method", E_USER_ERROR );
				return $supplied_hex;
		}

		$shifted_hex_value .= $current_value = (
			strlen( $decimal_to_hex = dechex( $amount ) ) < 2
			) ? '0' . $decimal_to_hex : $decimal_to_hex;
	}

	return '#' . $shifted_hex_value;
}


/** Removes leading # characters from a string */
function cookielawinfo_remove_hash( $str ) {
	if ( $str{0} == "#" ) {
		$str = substr( $str, 1, strlen($str) );
	}
	else {
		return $str;
	}
	return cookielawinfo_remove_hash( $str );
}


/**
 Explodes hex colour from 3 to 6 characters.
 If string is not 3 chars on input, will return original string
 */
function cookielawinfo_make_hex_colour_6_chars( $hex ) {
	$str = cookielawinfo_remove_hash( $hex );
	if ( strlen( $str ) == 3 ) {
		$hex = '#' . $str[0] . $str[0] . $str[1] . $str[1] . $str[2] . $str[2];
	}
	return $hex;
}


/** Debug assistance: JS alertbox for any passed value of $gubbins */
function cookielawinfo_debug_alertbox( $gubbins ) {
	if ( ! CLI_PLUGIN_DEVELOPMENT_MODE )
		return;
	echo '<script type="text/javascript"> alert("' . $gubbins .'")</script>';
}


/** Echoes out a debug string of your choice (but only if in development mode) */
function cookielawinfo_debug_echo( $gubbins ) {
	if ( ! CLI_PLUGIN_DEVELOPMENT_MODE )
		return;
	echo '<br />START OF DEBUG STRING>>>' . $gubbins . '<<< END OF DEBUG STRING<br />';
}


/** Debug: output saved settings to footer of admin panel */
function cookielawinfo_debug_admin_settings( $break ) {
	if ( ! CLI_PLUGIN_DEVELOPMENT_MODE )
		return;
	$settings = cookielawinfo_get_admin_settings();
	$ret = '<p>Settings: ';
	foreach ( $settings as $key => $option ) {
		$ret .= $key . ' = ' . $option . '; ';
		if ( $break )
			$ret .= '<br />';
	}
	$ret .= '</p>';
	return $ret;
}

?>
