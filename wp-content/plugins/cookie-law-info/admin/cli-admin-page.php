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


/** Displays admin page within WP dashboard */
function cookielawinfo_print_admin_page() {
	
	// Lock out non-admins:
	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficient permission to perform this operation' );
	}
	
	// Get options:
	$the_options = cookielawinfo_get_admin_settings();
	
	// Check if form has been set:
	if ( isset( $_POST['update_admin_settings_form'] ) ) {
		// Check nonce:
		check_admin_referer( 'cookielawinfo-update-' . CLI_SETTINGS_FIELD );
		foreach ( $the_options as $key => $value ) {
			if (isset($_POST[$key . '_field'])) {
				// Store sanitised values only:
				$the_options[$key] = cookielawinfo_sanitise($key, $_POST[$key . '_field']);
			}
		}
		update_option(CLI_SETTINGS_FIELD, $the_options);
		echo '<div class="updated"><p><strong>Settings Updated.</strong></p></div>';
	}
	else if ( isset ( $_POST['delete_all_settings'] ) ) {
		// Check nonce:
		check_admin_referer( 'cookielawinfo-update-' . CLI_SETTINGS_FIELD );
		cookielawinfo_delete_settings();
		$the_options = cookielawinfo_get_admin_settings();
	}
	else if ( isset ( $_POST['revert_to_previous_settings'] ) ) {
		if ( !cookielawinfo_copy_old_settings_to_new() ) {
			echo '<h3>ERROR MIGRATING SETTINGS (ERROR: 2)</h3>';
		}
		$the_options = cookielawinfo_get_admin_settings();
	}
	
	// Print form here:
	
	
	echo '<div class="wrap">';
	
	?>
		<h2>Cookie Law Settings</h2>
	
	
	<?php
	
	// Migration controller:
	if ( isset ( $_POST['cli-migration-button'] ) ) {
		if ( isset( $_POST['cli-migration_field'] ) ) {
			switch ( $_POST['cli-migration_field'] ) {
				case '2':
					// Migrate but keep
					if ( !cookielawinfo_migrate_to_new_version() ) {
						echo '<h3>ERROR MIGRATING SETTINGS (ERROR: 2)</h3>';
					}
					break;
				case '3':
					// Just use this version
					cookielawinfo_update_to_latest_version_number();
					break;
				default:
					// Form error, ignore
					echo '<h3>Error processing migration request (ERROR: 4)</h3>';
					break;
			}
		}
		$the_options = cookielawinfo_get_admin_settings();
	}
	
	
	echo '<form method="post" action="' . esc_url ( $_SERVER["REQUEST_URI"] ) . '">';
	
	// Set nonce:
	if ( function_exists('wp_nonce_field') ) 
		wp_nonce_field('cookielawinfo-update-' . CLI_SETTINGS_FIELD);
		
	?>
	
	<div class="cli-plugin-container">
		<div class="cli-plugin-left-col width-62">
			<div class="pad-10">
				
				<!-- Toolbar -->
				<div class="cli-plugin-toolbar top">
					<div class="left">
					
						<?php
							// Outputs the "cookie bar is on/off" message in the header
							$img_tag = '<img id="cli-plugin-status-icon" src="' . CLI_PLUGIN_URL . 'images/';
							$span_tag = '<span id="header_on_off_alert">';
							if ( $the_options['is_on'] == true ) {
								$img_tag .= 'tick.png" alt="tick icon" />';
								$span_tag .= 'Your Cookie Law Info bar is switched on</span>';
							}
							else {
								$img_tag .= 'cross.png" alt="cross icon" />';
								$span_tag .= 'Your Cookie Law Info bar is switched off</span>';
							}
							echo $img_tag . $span_tag;
						?>
						
					</div>
					<div class="right">
						<input type="submit" name="update_admin_settings_form" value="Update Settings" class="button-primary" />
					</div>
				</div>
				
				<style>
					/* http://css-tricks.com/snippets/jquery/simple-jquery-accordion/  ...with custom CSS */
					dl.accordion dt {
						background: #fff;
						border: 1px #ccc solid;
						color: #333;
						font-size: 12px;
						margin-bottom: 10px;
						padding: 8px;
						-moz-border-radius: 5px;
						-webkit-border-radius: 5px;
						border-radius: 5px;
						-khtml-border-radius: 5px;
					}
				</style>
				
				<!-- Accordion -->
				<dl class="accordion">
				
				
				<dt class="ui-icon ui-icon-triangle-1-s"><a href="#">Settings</a></dt>
				<dd id="accordion_default">
					<h4>The Cookie Bar</h4>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="is_on_field">Cookie Bar is currently:</label></th>
							<td>
								<input type="radio" id="is_on_field_yes" name="is_on_field" class="styled" value="true" <?php echo ( $the_options['is_on'] == true ) ? ' checked="checked" />' : ' />'; ?> On
								<input type="radio" id="is_on_field_no" name="is_on_field" class="styled" value="false" <?php echo ( $the_options['is_on'] == false ) ? ' checked="checked" />' : ' />'; ?> Off
								<span id="header_on_off_field_warning"></span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="notify_position_vertical_field">Cookie Bar will be show in:</label></th>
							<td>
								<select name="notify_position_vertical_field" class="vvv_combobox">
									<?php
										if ( $the_options['notify_position_vertical'] == "top" ) {
											echo '<option value="top" selected="selected">Header</option>';
											echo '<option value="bottom">Footer</option>';
										}
										else {
											echo '<option value="top">Header</option>';
											echo '<option value="bottom" selected="selected">Footer</option>';
										}
									?>
								</select>
							</td>
						</tr>

						<!-- header_fix code here -->
						<tr valign="top">
							<th scope="row"><label for="header_fix_field">Fix Cookie Bar to Header?</label></th>
							<td>
								<input type="radio" id="header_fix_field_yes" name="header_fix_field" class="styled" value="true" <?php echo ( $the_options['header_fix'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="iheader_fix_field_no" name="header_fix_field" class="styled" value="false" <?php echo ( $the_options['header_fix'] == false ) ? ' checked="checked" />' : ' />'; ?> No
								<span class="cli-plugin-example">If you select "Header" then you can optionally stick the cookie bar to the header. Will not have any effect if you select "Footer".</span>
							</td>
						</tr>
						<!-- /header_fix -->

						<tr valign="top">
							<th scope="row"><label for="notify_animate_show_field">On load</label></th>
							<td>
								<select name="notify_animate_show_field" class="vvv_combobox">
									<?php
										if ( $the_options['notify_animate_show'] == true ) {
											echo '<option value="true" selected="selected">Animate</option>';
											echo '<option value="false">Sticky</option>';
										}
										else {
											echo '<option value="true">Animate</option>';
											echo '<option value="false" selected="selected">Sticky</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="notify_animate_hide_field">On hide</label></th>
							<td>
								<select name="notify_animate_hide_field" class="vvv_combobox">
									<?php
										if ( $the_options['notify_animate_hide'] == true ) {
											echo '<option value="true" selected="selected">Animate</option>';
											echo '<option value="false">Disappear</option>';
										}
										else {
											echo '<option value="true">Animate</option>';
											echo '<option value="false" selected="selected">Disappear</option>';
										}
									?>
								</select>
							</td>
						</tr>
						
						<!-- SHOW ONCE / TIMER -->
						<tr valign="top" class="hr-top">
							<th scope="row"><label for="show_once_yn_field">Auto-hide cookie bar after delay?</label></th>
							<td>
								<input type="radio" id="show_once_yn_yes" name="show_once_yn_field" class="styled" value="true" <?php echo ( $the_options['show_once_yn'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="show_once_yn_no" name="show_once_yn_field" class="styled" value="false" <?php echo ( $the_options['show_once_yn'] == false ) ? ' checked="checked" />' : ' />'; ?> No
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="show_once_field">Milliseconds until hidden</label></th>
							<td>
								<input type="text" name="show_once_field" value="<?php echo $the_options['show_once'] ?>" />
								<span class="cli-plugin-example">Specify milliseconds (not seconds) e.g. <em>8000 = 8 seconds</em></span>
							</td>
						</tr>

						<!-- NEW: CLOSE ON SCROLL -->
						<tr valign="top" class="hr-top">
							<th scope="row"><label for="scroll_close_field">Auto-hide cookie bar if the user scrolls?</label></th>
							<td>
								<input type="radio" id="scroll_close_yes" name="scroll_close_field" class="styled" value="true" <?php echo ( $the_options['scroll_close'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="scroll_close_no" name="scroll_close_field" class="styled" value="false" <?php echo ( $the_options['scroll_close'] == false ) ? ' checked="checked" />' : ' />'; ?> No
							</td>
						</tr>
						<tr valign="top" class="hr-bottom">
							<th scope="row"><label for="scroll_close_reload_field">Reload after "scroll accept" event?</label></th>
							<td>
								<!-- <input type="text" name="scroll_close_reload_field" value="<?php echo $the_options['scroll_close_reload'] ?>" />
								<span class="cli-plugin-example">If the user accepts, do you want to reload the page? This feature is mostly for Italian users who have to deal with a very specific interpretation of the cookie law.</span>
									-->


								<input type="radio" id="scroll_close_reload_yes" name="scroll_close_reload_field" class="styled" value="true" <?php echo ( $the_options['scroll_close_reload'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="scroll_close_reload_no" name="scroll_close_reload_field" class="styled" value="false" <?php echo ( $the_options['scroll_close_reload'] == false ) ? ' checked="checked" />' : ' />'; ?> No


							</td>
						</tr>
						
					</table>
					
					<h4>The Show Again Tab</h4>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="showagain_tab_field">Use Show Again Tab?</label></th>
							<td>
								<input type="radio" id="showagain_tab_field_yes" name="showagain_tab_field" class="styled" value="true" <?php echo ( $the_options['showagain_tab'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="showagain_tab_field_no" name="showagain_tab_field" class="styled" value="false" <?php echo ( $the_options['showagain_tab'] == false ) ? ' checked="checked" />' : ' />'; ?> No
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="notify_position_horizontal_field">Tab Position</label></th>
							<td>
								<select name="notify_position_horizontal_field" class="vvv_combobox">
									<?php
										if ( $the_options['notify_position_horizontal'] == "right" ) {
											echo '<option value="right" selected="selected">Right</option>';
											echo '<option value="left">Left</option>';
										}
										else {
											echo '<option value="right">Right</option>';
											echo '<option value="left" selected="selected">Left</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="showagain_x_position_field">From Left Margin</label></th>
							<td>
								<input type="text" name="showagain_x_position_field" value="<?php echo $the_options['showagain_x_position'] ?>" />
								<span class="cli-plugin-example">Specify px&nbsp;or&nbsp;&#37;, e.g. <em>"100px" or "30%"</em></span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="showagain_text">Show More Text</label></th>
							<td>
								<input type="text" name="showagain_text_field" value="<?php echo $the_options['showagain_text'] ?>" />
								
							</td>
						</tr>
					</table>
					
				</dd>
				
				
				<dt><a href="#">Cookie Law Message Bar</a></dt>
				<dd>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="notify_message_field">Message</label></th>
							<td>
								<?php
								echo '<textarea name="notify_message_field" class="vvv_textbox">';
								echo apply_filters('format_to_edit', stripslashes($the_options['notify_message'])) . '</textarea>';
								?>
								<span class="cli-plugin-example">Shortcodes allowed: see settngs section "Using the Shortcodes". <br /><em>Examples: "We use cookies on this website [cookie_accept] to find out how to delete cookies [cookie_link]."</em></span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="background_field">Cookie Bar Colour</label></th>
							<td>
								<?php
								
								/** RICHARDASHBY EDIT */
								//echo '<input type="text" name="background_field" id="cli-colour-background" value="' .$the_options['background']. '" />';
								echo '<input type="text" name="background_field" id="cli-colour-background" value="' .$the_options['background']. '" class="my-color-field" data-default-color="#fff" />';
								
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="text_field">Text Colour</label></th>
							<td>
								<?php
								/** RICHARDASHBY EDIT */
								echo '<input type="text" name="text_field" id="cli-colour-text" value="' .$the_options['text']. '" class="my-color-field" data-default-color="#000" />';
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="border_on_field">Show Border?</label></th>
							<td>
								<!-- Border on/off -->
								<input type="radio" id="border_on_field_yes" name="border_on_field" class="styled" value="true" <?php echo ( $the_options['border_on'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="border_on_field_no" name="border_on_field" class="styled" value="false" <?php echo ( $the_options['border_on'] == false ) ? ' checked="checked" />' : ' />'; ?> No
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="border_field">Border Colour</label></th>
							<td>
								<?php
								echo '<input type="text" name="border_field" id="cli-colour-border" value="' .$the_options['border']. '" class="my-color-field" />';
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="font_family_field">Font</label></th>
							<td>
								<select name="font_family_field" class="vvv_combobox">
								<?php cookielawinfo_print_combobox_options( cookielawinfo_get_fonts(), $the_options['font_family'] ) ?>
								</select>
							</td>
						</tr>
					</table>
				</dd>
				
				
				<dt><a href="#">Customise Buttons</a></dt>
				<dd>
					
					<h4>Main Button <code>[cookie_button]</code></h4>
					<p>This button/link can be customised to either simply close the cookie bar, or follow a link. You can also customise the colours and styles, and show it as a link or a button.</p>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="button_1_text_field">Link Text</label></th>
							<td>
								<input type="text" name="button_1_text_field" value="<?php echo stripslashes( $the_options['button_1_text'] ) ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_1_action_field">Action</label></th>
							<td>
								<select name="button_1_action_field" id="cli-plugin-button-1-action" class="vvv_combobox">
								<?php cookielawinfo_print_combobox_options( cookielawinfo_get_js_actions(), $the_options['button_1_action'] ) ?>
								</select>
							</td>
						</tr>
						<tr valign="top" class="cli-plugin-row">
							<th scope="row"><label for="button_1_url_field">Link URL</label></th>
							<td>
								<input type="text" name="button_1_url_field" id="button_1_url_field" value="<?php echo $the_options['button_1_url'] ?>" />
								<span class="cli-plugin-example"><em>Button will only link to URL if Action = Show URL</em></span>
							</td>
						</tr>
						
						<tr valign="top" class="cli-plugin-row">
							<th scope="row"><label for="button_1_new_win_field">Open link in new window?</label></th>
							<td>
								<input type="radio" id="button_1_new_win_field_yes" name="button_1_new_win_field" class="styled" value="true" <?php echo ( $the_options['button_1_new_win'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="button_1_new_win_field_no" name="button_1_new_win_field" class="styled" value="false" <?php echo ( $the_options['button_1_new_win'] == false ) ? ' checked="checked" />' : ' />'; ?> No
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_1_link_colour_field">Link colour</label></th>
							<td>
								<?php
								echo '<input type="text" name="button_1_link_colour_field" id="cli-colour-link-button-1" value="' .$the_options['button_1_link_colour']. '" class="my-color-field" />';
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_1_as_button_field">Show as button?</label></th>
							<td>
								<input type="radio" id="button_1_as_button_field_yes" name="button_1_as_button_field" class="styled" value="true" <?php echo ( $the_options['button_1_as_button'] == true ) ? ' checked="checked" />' : ' />'; ?> Button
								<input type="radio" id="button_1_as_button_field_no" name="button_1_as_button_field" class="styled" value="false" <?php echo ( $the_options['button_1_as_button'] == false ) ? ' checked="checked" />' : ' />'; ?> Link
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_1_button_colour_field">Button colour</label></th>
							<td>
								<?php
								echo '<input type="text" name="button_1_button_colour_field" id="cli-colour-btn-button-1" value="' .$the_options['button_1_button_colour']. '" class="my-color-field" />';
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_1_button_size_field">Button Size</label></th>
							<td>
								<select name="button_1_button_size_field" class="vvv_combobox">
								<?php cookielawinfo_print_combobox_options( cookielawinfo_get_button_sizes(), $the_options['button_1_button_size'] ); ?>
								</select>
							</td>
						</tr>
					</table><!-- end custom button -->
					
					
					<h4>Read More Link <code>[cookie_link]</code></h4>
					<p>This button/link can be used to provide a link out to your Privacy & Cookie Policy. You can customise it any way you like.</p>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><label for="button_2_text_field">Link Text</label></th>
							<td>
								<input type="text" name="button_2_text_field" value="<?php echo stripslashes( $the_options['button_2_text'] ) ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_2_url_field">Link URL</label></th>
							<td>
								<input type="text" name="button_2_url_field" id="button_2_url_field" value="<?php echo $the_options['button_2_url'] ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_2_link_colour_field">Link colour</label></th>
							<td>
								<?php
								echo '<input type="text" name="button_2_link_colour_field" id="cli-colour-link-button-1" value="' .$the_options['button_2_link_colour']. '" class="my-color-field" />';
								?>
							</td>
						</tr>
						
						
						<tr valign="top">
							<th scope="row"><label for="button_2_new_win_field">Open link in new window?</label></th>
							<td>
								<input type="radio" id="button_2_new_win_field_yes" name="button_2_new_win_field" class="styled" value="true" <?php echo ( $the_options['button_2_new_win'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="button_2_new_win_field_no" name="button_2_new_win_field" class="styled" value="false" <?php echo ( $the_options['button_2_new_win'] == false ) ? ' checked="checked" />' : ' />'; ?> No
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_2_as_button_field">Show as button?</label></th>
							<td>
								<input type="radio" id="button_2_as_button_field_yes" name="button_2_as_button_field" class="styled" value="true" <?php echo ( $the_options['button_2_as_button'] == true ) ? ' checked="checked" />' : ' />'; ?> Button
								<input type="radio" id="button_2_as_button_field_no" name="button_2_as_button_field" class="styled" value="false" <?php echo ( $the_options['button_2_as_button'] == false ) ? ' checked="checked" />' : ' />'; ?> Link
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_2_button_colour_field">Button colour</label></th>
							<td>
								<?php
								echo '<input type="text" name="button_2_button_colour_field" id="cli-colour-btn-button-1" value="' .$the_options['button_2_button_colour']. '" class="my-color-field" />';
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="button_2_button_size_field">Button Size</label></th>
							<td>
								<select name="button_2_button_size_field" class="vvv_combobox">
								<?php cookielawinfo_print_combobox_options( cookielawinfo_get_button_sizes(), $the_options['button_2_button_size'] ); ?>
								</select>
							</td>
						</tr>
					</table><!-- end custom button -->
					
				</dd>
				
				<dt><a href="#">Using the Shortcodes</a></dt>
				<dd class="cli-help">
					<h4>Cookie bar shortcodes</h4>
					<p>You can enter the shortcodes in the "message" field of the Cookie Law Info bar. They add nicely formatted buttons and/or links into the cookie bar, without you having to add any HTML.</p>
					<p>The shortcodes are:</p>
					
					<pre>[cookie_accept]</pre><span>If you just want a standard green "Accept" button that closes the header and nothing more, use this shortcode. It is already styled, you don't need to customise it.</span>
					
					<pre>[cookie_accept colour="red"]</pre><span>Alternatively you can add a colour value. Choose from: red, blue, orange, yellow, green or pink.<br /><em>Careful to use the British spelling of "colour" for the attribute.</em></span>
					
					<pre>[cookie_button]</pre><span>This is the "main button" you customise above.</span>
					
					<pre>[cookie_link]</pre><span>This is the "read more" link you customise above.</span>
					
					<h4>Other shortcodes</h4>
					<p>These shortcodes can be used in pages and posts on your website. It is not recommended to use these inside the cookie bar itself.</p>
					
					<pre>[cookie_audit]</pre><span>This prints out a nice table of cookies, in line with the guidance given by the ICO. <em>You need to enter the cookies your website uses via the Cookie Law Info menu in your WordPress dashboard.</em></span>
					
					<pre>[delete_cookies]</pre><span>This shortcode will display a normal HTML link which when clicked, will delete the cookie set by Cookie Law Info (this cookie is used to remember that the cookie bar is closed).</span>
					<pre>[delete_cookies text="Click here to delete"]</pre><span>Add any text you like- useful if you want e.g. another language to English.</span>
					
					
				</dd>
				
				
				<dt><a href="#">Advanced</a></dt>
				<dd>
					<p>Sometimes themes apply settings that clash with plugins. If that happens, try adjusting these settings.</p>
					
					<table class="form-table">
						<!--
						<tr valign="top">
							<th scope="row"><label for="use_colour_picker_field">Use colour picker on this page?</label></th>
							<td>
								<input type="radio" id="use_colour_picker_field_yes" name="use_colour_picker_field" class="styled" value="true" <?php echo ( $the_options['use_colour_picker'] == true ) ? ' checked="checked" />' : ' />'; ?> Yes
								<input type="radio" id="use_colour_picker_field_no" name="use_colour_picker_field" class="styled" value="false" <?php echo ( $the_options['use_colour_picker'] == false ) ? ' checked="checked" />' : ' />'; ?> No
								<span class="cli-plugin-example"><em>You will need to refresh your browser once the page re-loads in order to show the colour pickers.</em></span>
							</td>
						</tr>
						-->
						<tr valign="top">
							<th scope="row">Reset all values</th>
							<td>
								<input type="submit" name="delete_all_settings" value="Delete settings and reset" class="button-secondary" onclick="return confirm('Are you sure you want to delete all your settings?');" />
								<span class="cli-plugin-example"><em>Warning: this will actually delete your current settings.</em></span>
							</td>
						</tr>
						<!--
						<tr valign="top">
							<th scope="row">Revert to previous version's settings</th>
							<td>
								<input type="submit" name="revert_to_previous_settings" value="Revert to old settings" class="button-secondary" onclick="return confirm('You will lose your current settings. Are you sure?');" />
								<span class="cli-plugin-example"><em>Warning: this will actually delete your current settings.</em></span>
							</td>
						</tr>
						-->
					</table>
					
				</dd>
				
			</dl><!-- end of cookielawinfo-accordion -->
			
			
			<!-- Second save button -->
			<div class="cli-plugin-toolbar bottom">
				<div class="left">
					
				</div>
				<div class="right">
					<input type="submit" name="update_admin_settings_form" value="Update Settings" class="button-primary" />
				</div>
			</div>
			
			
			</form><!-- end of main settings form -->
			
			
			</div><!-- end of pad-5 -->
		</div><!-- end of cli-plugin-left-col (62%) -->
		
		<!-- Dashboard Sidebar -->
		<div class="cli-plugin-right-col width-38">
			<div class="pad-10">
				
				
				<div id="cli-plugin-migrate">
					<h3>Where did my settings go?</h3>
					<p>Cookie Law Info version 0.9 has been updated and has new settings. <strong>Your previous settings are safe.</strong></p>
					<p>You can either copy over your old settings to this version, or use the new default values. </p>
					<form method="post" action="<?php esc_url ( $_SERVER["REQUEST_URI"] ) ?>">
						<p><label for="cli-migration">Would you like to:</label></p>
						<ul>
							<li><input type="radio" id="cli-migration_field_yes" name="cli-migration_field" class="styled" value="2" /> Use previous settings</li>
							<li><input type="radio" id="cli-migration_field_yes" name="cli-migration_field" class="styled" value="3" checked="checked" /> Start afresh with the new version</li>
						</ul>
						<input type="submit" name="cli-migration-button" value="Update" class="button-secondary" onclick="return confirm('Are you sure you want to migrate settings?');" />
					</form>
					<p>If you want to go back to the previous version you can always download it again from <a href="http://www.cookielawinfo.com">CookieLawInfo.com.</a></p>
				</div>
				
				<h3>Coming Soon: Cookie Law Info 2.0</h3>
				<p>It's time for a completely new version! Cookie Law Info will always be free but there will also be a PRO version for those who want a bit more. You can <a href="http://cookielawinfo.com/cookie-law-info-2-0/">read about it here</a>. For both versions, you can sign up to the BETA version and be the first to try it out. It's completely free of charge and you could even win a free PRO version!</p>
				<br />

				<h3>Like this plugin?</h3>
				<p>If you find this plugin useful please show your support and rate it <a href="http://wordpress.org/support/view/plugin-reviews/cookie-law-info?filter=5" target="_blank">★★★★★</a> on <a href="http://wordpress.org/support/view/plugin-reviews/cookie-law-info?filter=5" target="_blank">WordPress.org</a> - much appreciated! :)</p>
				<br />

				<h3>Help</h3>
				<ul>
					<li><a href="http://cookielawinfo.com/support/">Help and Support</a></li>
					<li><a href="http://wordpress.org/support/plugin/cookie-law-info/">Report a Bug</a></li>
					<li><a href="http://cookielawinfo.com/contact/">Suggest a Feature</a></li>
					<li><a href="http://cookielawinfo.com">About the law</a></li>
				</ul>
				<br />
				
				<div>
					<form action="http://cookielawinfo.us5.list-manage.com/subscribe/post?u=b32779d828ef2e37e68e1580d&amp;id=71af66b86e" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
						<h3><label for="mce-EMAIL">Subscribe to our mailing list</label></h3>
						<p>Occasional updates on plugin updates, compliance requirements, who's doing what and industry best practice.</p>
						<input type="email" value="" name="EMAIL" class="vvv_textfield" id="mce-EMAIL" placeholder="email address" required>
						<div class="">
							<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button-secondary">
						</div>
						<p>We will not send you spam or pass your details to 3rd Parties.</p>
					</form>
				</div><!--End mc_embed_signup-->
				
			</div>
		</div><!-- end of cli-plugin-right-col (38%) -->
	
	</div><!-- end of cli-plugin-container -->
	
	
	<script type="text/javascript">
		(function($) {
	
		  var allPanels = $('.accordion > dd').hide();
		  $('#accordion_default').show();
	
		  $('.accordion > dt > a').click(function() {
			allPanels.slideUp();
			$(this).parent().next().slideDown();
			return false;
		  });

		})(jQuery);
	</script>
	
	
	<?php
		if ( !cookielawinfo_has_migrated() ) {
			?>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#cli-plugin-migrate').slideDown();
				});
			</script>
			<?php
		}
		
		//DEBUG:
		echo cookielawinfo_debug_admin_settings( true );
		echo cookielawinfo_debug_echo (cookielawinfo_get_json_settings() );
		
		echo '</div><!-- end wrap -->';

}

?>