<?php

$keys = $sidebar_admin->keys;
$data = $sidebar_admin->data;
	
// SIDEBAR SETUP
//if ( $sidebar_admin->navigation == 'sidebar') :

	// Set up the navigation
	if (!($navtext = $sidebar_admin->get_val('label'))) $navtext = __('Create new', THEME_NAME);
	$sidebar_admin->navigation_bar(array(__('Sidebar', THEME_NAME) . ': ' . $navtext));

	echo '<p>' . __('Create a new sidebar.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'sidebars', 'action_keys' => $keys, 'action' => 'save');
	$sidebar_admin->settings_form_header($form_link);
	
	?>
	<table class="form-table">
	<?php
	
		$comment = __('This name is for reference only.', THEME_NAME);
		$comment = $sidebar_admin->format_comment($comment);
		$row = array(__('Title', THEME_NAME) . $required, $sidebar_admin->settings_input('label') . $comment);
		$sidebar_admin->setting_row($row);

		$comment = __('This ID can be used to include the widget area with a shortcode.', THEME_NAME);
		if ($val = $sidebar_admin->get_val('alias')) {
			$comment .= ' ' . sprintf ( '<br />' . __('For example, you can use %s to include the sidebar into a content area.', THEME_NAME), '<code>[sidebar alias="' . $val . '"]</code>' ); 
		}
		$comment = $sidebar_admin->format_comment($comment);
		$row = array(__('Alias', THEME_NAME) . $required, $sidebar_admin->settings_input('alias') . $comment);
		$sidebar_admin->setting_row($row);

	echo '</table>';

	// key for this data type is generated at random when created.
	echo '<input type="hidden" name="key" value="'. $sidebar_admin->get_val('key') .'" />'; // Normal way causes error --> $sidebar_admin->settings_hidden('index'); 

	// save button
	$sidebar_admin->settings_save_button(__('Save Sidebar', THEME_NAME), 'button-primary');	

//else:	// There is no else for this yet...

	// nothing here.
	
//endif;

?>