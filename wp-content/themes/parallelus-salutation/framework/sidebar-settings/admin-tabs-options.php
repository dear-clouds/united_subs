<?php

$keys = $sidebar_admin->keys;
$data = $sidebar_admin->data;

	
// TAB SETUP
//if ( $sidebar_admin->navigation == 'tab') :

	// Set up the navigation
	if (!($navtext = $sidebar_admin->get_val('label'))) $navtext = __('Create new', THEME_NAME);
	$sidebar_admin->navigation_bar(array(__('Tab', THEME_NAME) . ': ' . $navtext));

	echo '<p>' . __('Create a new tab.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'tabs', 'action_keys' => $keys, 'action' => 'save');
	$sidebar_admin->settings_form_header($form_link);
	
	?>
	<table class="form-table">
	<?php
	
		// Title
		$comment = __('This name is for reference only.', THEME_NAME);
		$comment = $sidebar_admin->format_comment($comment);
		$row = array(__('Title', THEME_NAME) . $required, $sidebar_admin->settings_input('label') . $comment);
		$sidebar_admin->setting_row($row);

		// Background Color
		$comment = __('Optional', THEME_NAME);
		$comment = $sidebar_admin->format_comment($comment);
		$comment2 = __('Enter the HEX color value for an option background color.', THEME_NAME) . 
					'<br /><a href="http://www.colorpicker.com/" target="_blank">' . __('Where can I get the HEX value for my color?', THEME_NAME) . '</a>';
		$comment2 = $sidebar_admin->format_comment($comment2);
		$row = array(__('Tab background color', THEME_NAME) . $comment, "#" . $sidebar_admin->settings_input('bg_color') . $comment2);
		$sidebar_admin->setting_row($row);

		// Class
		$comment = __('Optional', THEME_NAME);
		$comment = $sidebar_admin->format_comment($comment);
		$comment2 =	__('Add an optional CSS class. This can be used for applying special styles.', THEME_NAME);
		$comment2 = $sidebar_admin->format_comment($comment2);
		$row = array(__('CSS Classes', THEME_NAME) . $comment, $sidebar_admin->settings_input('class') . $comment);
		$sidebar_admin->setting_row($row);

		// Conditionals
		$comment =	__('Conditional functions to optionally show/hide tabs.', THEME_NAME) . 
					'<br><br>' . __('You can specify a tab should only show for logged in users by inserting <code>function-is-user-logged-in</code>. Many of the WordPress conditional functions can be used by prefixing the text "function-" before the function name or "-function-" to test for the NOT condition. A list of these functions and be found on the codex site:  ', THEME_NAME) .
					'<a href="http://codex.wordpress.org/Conditional_Tags" target="_blank">' . __('WP Conditional Tags', THEME_NAME) . '</a>' .
					'<br><br>' . __('Examples of conditional functions:  ', THEME_NAME) .
					'<br><br><ul>' . 
					'<li><code>function-is-home</code> or <code>function-is-front-page</code> - '. __('Only show a link on the home page', THEME_NAME) .'</li>' .
					'<li><code>-function-is-home</code> - '. __('Show everywhere <u>except</u> the home page', THEME_NAME) .'</li>' .
					'<li><code>function-is-category</code> - '. __('Only show a link on category pages', THEME_NAME) .'</li>' .
					'<li><code>function-is-singluar</code> - '. __('Only show a link on posts', THEME_NAME) .'</li>' .
					'<li><code>function-is-sticky</code> - '. __('Only show a link on sticky posts', THEME_NAME) .'</li>' .
					'<li><code>function-is-page</code> - '. __('Only show a link on pages', THEME_NAME) .'</li>' .
					'<li><code>function-is-search</code> - '. __('Only show on search results', THEME_NAME) .'</li>' .
					'</ul>' .
					'<br>' . __('You can hide a tab completely (turn it off) with the condition <code>-function-is-blog-installed</code>', THEME_NAME);
		$comment = $sidebar_admin->format_comment($comment);
		$row = array(__('Conditions', THEME_NAME), $sidebar_admin->settings_input('conditions') . $comment);
		$sidebar_admin->setting_row($row);

	echo '</table>';

	// alias for this item is generated from key.
	echo '<input type="hidden" name="alias" value="'. $sidebar_admin->get_val('alias') .'" />'; // Normal way causes error --> $sidebar_admin->settings_hidden('index'); 
	// key for this data type is generated at random when created.
	echo '<input type="hidden" name="key" value="'. $sidebar_admin->get_val('key') .'" />'; // Normal way causes error --> $sidebar_admin->settings_hidden('index'); 

	// save button
	$sidebar_admin->settings_save_button(__('Save Tab', THEME_NAME), 'button-primary');	


//else:	// There is no else for this yet...

	// nothing here.

//endif;

?>