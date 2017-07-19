<?php

$keys = $contact_form_admin->keys;
$data = $contact_form_admin->data;

	// Set up the navigation
	if (!($navtext = $contact_form_admin->get_val('label'))) $navtext = __('Create new', THEME_NAME);
	$contact_form_admin->navigation_bar(array(__('Contact Field', THEME_NAME) . ': ' . $navtext));

	echo '<p>' . __('Create new fields to add to your contact form.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'contact_fields', 'action_keys' => $keys, 'action' => 'save');
	$contact_form_admin->settings_form_header($form_link);
	
	?>
	<table class="form-table">
	<?php
	
		$comment = __('The name of the field as it will be displayed in the form.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Field title', THEME_NAME) . $required, $contact_form_admin->settings_input('label') . $comment);
		$contact_form_admin->setting_row($row);
	
		$comment = __('This key is used to add the field to contact forms.', THEME_NAME);
		if ($val = $contact_form_admin->get_val('key')) {
			$comment .= ' ' . sprintf( __('For example, you can use %s to include the field in a form.', THEME_NAME), '<code>[contact_form fields="' . $val . '" ]</code>' ); 
		}
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Field key (unique identifier)', THEME_NAME) . $required, $contact_form_admin->settings_input('key') . $comment);
		$contact_form_admin->setting_row($row);

		$comment = __('You can add instructions or information for the user about this field. HTML code is allowed.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Caption', THEME_NAME), $contact_form_admin->settings_textarea('caption') . $comment);
		$contact_form_admin->setting_row($row);
	
		$field_set = array( 
			'text' => 'Text', 
			'textarea' => 'Textarea', 
			'select' => 'Select', 
			'radio' => 'Radio button (set)', 
			'checkbox' => 'Checkbox',
			'hidden' => 'Hidden'
		);
		$field_comments = array(
			'text' => 'A simple one line text input.', 
			'textarea' => 'Plain text box for multiple lines fo text.', 
			'select' => 'A select list (drop down), using the names/values specified in the "Values" field below.', 
			'radio' => 'A radio button set, where the user can select a single option. The list of values is specifed below.', 
			'checkbox' => 'Single checkbox.',
			'hidden' => 'A hidden field not seen by the user. Specify the value in the field below.'
		);
		$comment = '';
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Field type', THEME_NAME) . $comment, $contact_form_admin->settings_radiobuttons('field_type', $field_set, $field_comments));
		$contact_form_admin->setting_row($row);
		
		$comment = __('Set the value of hidden fields here or they will contain no information.<br /><br />If your selected field type requires pre-defined options, such as radio buttons or select boxes, enter the values here as a comma separated list. For example, your values could be entered as <code>Good, Better, Best</code>.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Values (if applicable)', THEME_NAME), $contact_form_admin->settings_input('values') . $comment);
		$contact_form_admin->setting_row($row);

		$comment = __('Require users to enter a value?', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Required', THEME_NAME), $contact_form_admin->settings_bool('required', $keys) . $comment);
		$contact_form_admin->setting_row($row);

		$comment = __('Enter an optional error message for empty fields that are required.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Required error message', THEME_NAME) . $required, $contact_form_admin->settings_input('error_required') . $comment);
		$contact_form_admin->setting_row($row);

		$comment = __('You can optionally specify a minimum number of characters allowed for this field.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Minimum length', THEME_NAME), $contact_form_admin->settings_input('minlength') . $comment);
		$contact_form_admin->setting_row($row);

		$comment = __('You can optionally specify a maximum number of characters allowed for this field.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Maximum length', THEME_NAME), $contact_form_admin->settings_input('maxlength') . $comment);
		$contact_form_admin->setting_row($row);

		$field_set = array( 
			'' => '', 
			'email' => 'Email address', 
			'url' => 'Website address (URL)', 
			'date' => 'Date',
			'digits' => 'Numbers only'
		);
		$comment = __('You can apply validation to some fields to ensure valid entries.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Validation', THEME_NAME) . $comment, $contact_form_admin->settings_select('validation', $field_set));
		$contact_form_admin->setting_row($row);
		
		$comment = __('Enter an optional error message for fields that fail validation.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Validation error message', THEME_NAME) . $required, $contact_form_admin->settings_input('error_validation') . $comment);
		$contact_form_admin->setting_row($row);
		
		$comment = __('Optional. You can specify the width of the field in pixels. Does not apply to some input types.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Input width', THEME_NAME), $contact_form_admin->settings_input('size,width') . $comment);
		$contact_form_admin->setting_row($row);

		$comment = __('Optional. You can specify the height of the field in pixels. Does not apply to some input types.', THEME_NAME);
		$comment = $contact_form_admin->format_comment($comment);
		$row = array(__('Input height', THEME_NAME), $contact_form_admin->settings_input('size,height') . $comment);
		$contact_form_admin->setting_row($row);

	echo '</table>';

	// save button
	$contact_form_admin->settings_save_button(__('Save Field Settings', THEME_NAME), 'button-primary');	

?>