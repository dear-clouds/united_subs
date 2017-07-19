<?php
// FORCE THE KEYS - THIS IS IMPORTANT FOR SECTIONS WITH OPTIONS ON THE MAIN PAGE
$savedData = $contact_form_admin->get_val('contact_form', '_plugin');
if ( !empty($savedData) ) {
	$contact_form_admin->keys = array('_plugin', 'contact_form');
} else {
	echo '<div class="error fade"><p><strong>'. __('Please save the form settings below before you continue.', THEME_NAME) .'</strong></p></div>';
}

$keys = $contact_form_admin->keys;
$data = $contact_form_admin->data;

	$form_link = array('navigation' => 'contact_form_settings', 'action' => 'save', 'keys' => '_plugins,contact_form', 'action_keys' => '_plugins,contact_form');
	$contact_form_admin->settings_form_header($form_link);
	//$contact_form_admin->settings_form_header(array('action' => 'save', 'keys' => '_plugins,options', 'action_keys' => '_plugins,options'));
	
	?>

	<a name="options_contact"></a>
	<h3><?php _e('Contact Form', THEME_NAME); ?></h3>
	<p><?php _e('Display your form with the <code>[contact_form]</code> shortcode. You can customize each instance with unique values for <code>to</code>, <code>subject</code> and <code>thankyou</code> in the form. Empty fields use the default settings established in the fileds below.' ,THEME_NAME); ?></p>
	<!--<div class="meta-box-sortables metabox-holder">
		<div class="postbox">
			<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle"><span><?php _e('Options', THEME_NAME); ?></span></h3>
			<div class="inside" style="display: none;">-->
				<table class="form-table">
				<?php
					$comment = __('The default address to deliver messages sent from contact forms. For example: ', THEME_NAME) . '<code>' . get_option('admin_email') . '</code>';
					$comment = $contact_form_admin->format_comment($comment);
					$row = array(__('Email To', THEME_NAME), $contact_form_admin->settings_input('to', $keys) . $comment);
					$contact_form_admin->setting_row($row);
			
					$comment = __('Enter the default email subject for contact form messages.', THEME_NAME);
					$comment = $contact_form_admin->format_comment($comment);
					$row = array(__('Subject', THEME_NAME), $contact_form_admin->settings_input('subject', $keys) . $comment);
					$contact_form_admin->setting_row($row);
					
					$comment = __('The "thank you" message visitors will see after sending. HTML is allowed.', THEME_NAME);
					$comment = $contact_form_admin->format_comment($comment);
					$row = array(__('Thank You Message', THEME_NAME), $contact_form_admin->settings_textarea('thankyou', $keys) . $comment);
					$contact_form_admin->setting_row($row);
					
					$comment = __('The text to appear on the send button. Default: "Send"', THEME_NAME);
					$comment = $contact_form_admin->format_comment($comment);
					$row = array(__('Button text', THEME_NAME), $contact_form_admin->settings_input('button', $keys) . $comment);
					$contact_form_admin->setting_row($row);
			
					$comment = __('Require CAPTCHA image verification?', THEME_NAME);
					$comment = $contact_form_admin->format_comment($comment);
					$sample = '<p><img src="'. FRAMEWORK_URL .'/utilities/captcha/captcha.php?_'. base_convert(mt_rand(0x1679616, 0x39AA3FF), 10, 36) .'" id="captcha" /></p>' . __('Sample image. <a href="#" onclick="document.getElementById(\'captcha\').src=\''. FRAMEWORK_URL .'/utilities/captcha/captcha.php?_\'+Math.random(); return false;" id="refreshCaptcha">Refresh?</a>', THEME_NAME);
					$row = array(__('Use CAPTCHA', THEME_NAME), $contact_form_admin->settings_bool('captcha', $keys) . $comment . $sample);
					$contact_form_admin->setting_row($row);
			
					// Look up user created fields
					$fields = $contact_form_admin->get_val('contact_fields', '_plugin');
					$fields_saved = $contact_form_admin->get_val('contact_fields', '_plugin_saved');
					// Combine fields from DB and Saved file
					$fields = array_merge((array)$fields_saved, (array)$fields);

					//$fields = $contact_form_admin->get_val('contact_fields', $keys);
				
					// Create sample shortcodes
					$code  = 	'<p><code>[contact_form]</code></p>';
					$code .=	'<p><code>[contact_form '.
								'to="'. str_replace('"', '\"', $contact_form_admin->get_val('to', $keys)) . '" ' .
								'subject="'. str_replace('"', '\"', $contact_form_admin->get_val('subject', $keys)) . '" ' .
								'thankyou="'. str_replace('"', '\"', $contact_form_admin->get_val('thankyou', $keys)) . '" ' .
								'button="'. str_replace('"', '\"', $contact_form_admin->get_val('button', $keys)) . '" ';
								// check for captcha
								$hasCaptcha = $contact_form_admin->get_val('captcha', $keys);
								if ($hasCaptcha) {
									$code .= 'captcha="yes" ';
								}
					$code .=	']</code></p>';
								
					// If we have user created fields...
					if (!empty($fields)) {
						// Print another shortcode sample with ALL custom fields
						$field_keys = array();
						foreach((array) $fields as $key => $item) {
							if (!$key) continue;
							array_push($field_keys, $item['key']);
						}
						// Add another shortcode
						$code .=	'<p><code>[contact_form fields="'. implode(",", $field_keys) . '"]</code></p>';
					}
					$comment = __('Above are examples of how you can add the shortcode to your content. ', THEME_NAME);
					$comment = $contact_form_admin->format_comment($comment);
					$row = array(__('Shortcodes', THEME_NAME), $code . $comment);
					$contact_form_admin->setting_row($row);
				?>
				</table>
			<!--</div>
		</div>
	</div>-->

		
	<?php

	// key for this data type is generated at random when adding new slides.
	echo '<input type="hidden" name="key" value="'. $contact_form_admin->get_val('key') .'" />'; // Normal way causes error --> $contact_form_admin->settings_hidden('index'); 

	// save button
	$contact_form_admin->settings_save_button(__('Save Settings', THEME_NAME), 'button-primary');
	
	?>
	
	<br />
		
	<div class="hr"></div>
