<style type="text/css">
	form textarea.input-textarea { width: 100% !important; height: 250px !important; }
</style>
<?php


$keys = $layout_admin->keys;
$data = $layout_admin->data;

// Static content drop down (static blocks)
$content_blocks = $layout_admin->get_posts(' ', true, 'static_block', 'post_name');


// PAGE FOOTER SETUP
//if ( $layout_admin->navigation == 'page_footer') :

	// Set up the navigation
	if (!($navtext = $layout_admin->get_val('label'))) $navtext = __('Create new', THEME_NAME);
	$layout_admin->navigation_bar(array(__('Page footer', THEME_NAME) . ': ' . $navtext));

	echo '<p>' . __('Create a new page footer.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'page_footers', 'action_keys' => $keys, 'action' => 'save');
	$layout_admin->settings_form_header($form_link);
	
	?>
	<table class="form-table">
	<?php
	
		// Title/Name
		$comment = __('This name is for reference only.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Title', THEME_NAME) . $required, $layout_admin->settings_input('label') . $comment);
		$layout_admin->setting_row($row);

		// Content source
		$select = $content_blocks;
		$comment = __('Select a static block as the content source for this footer.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('<strong>Primary content</strong>', THEME_NAME), $layout_admin->settings_select('content', $select) . $comment);
		$layout_admin->setting_row($row,'highlight');

		// Background Color
		$comment = __('Optional', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$comment2 = __('Enter the HEX color value for an option background color.', THEME_NAME) . 
					'<br /><a href="http://www.colorpicker.com/" target="_blank">' . __('Where can I get the HEX value for my color?', THEME_NAME) . '</a>';
		$comment2 = $layout_admin->format_comment($comment2);
		$row = array(__('Background color', THEME_NAME) . $comment, "#" . $layout_admin->settings_input('bg_color') . $comment2);
		$layout_admin->setting_row($row);

		// Background Image
		$comment = __('Optional', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$comment2 = __('Enter the full URL of an image to show in your footer background.', THEME_NAME);
		$comment2 = $layout_admin->format_comment($comment2);

			$field_set_x = array( 
				'' => __('Default (Design Settings)', THEME_NAME), 
				'0%' => __('Left', THEME_NAME), 
				'50%' => __('Center', THEME_NAME), 
				'100%' => __('Right', THEME_NAME)
			);
			$field_comments_x = array();
			$comment_x = __('', THEME_NAME);
			$comment_x = $layout_admin->format_comment($comment_x);
			$row_x = '<div class="optionsColumn">' . __('Horizontal position', THEME_NAME) . '<br />' . $layout_admin->settings_radiobuttons('bg_pos_x', $field_set_x, $field_comments_x) . $comment_x . '</div>';
	
			$field_set_y = array( 
				'' => __('Default (Design Settings)', THEME_NAME), 
				'0%' => __('Top', THEME_NAME), 
				'50%' => __('Middle', THEME_NAME), 
				'100%' => __('Bottom', THEME_NAME)
			);
			$field_comments_y = array();
			$comment_y = __('', THEME_NAME);
			$comment_y = $layout_admin->format_comment($comment_y);
			$row_y = '<div class="optionsColumn">' . __('Vertical position', THEME_NAME) . '<br />' . $layout_admin->settings_radiobuttons('bg_pos_y', $field_set_y, $field_comments_y) . $comment_y . '</div>';

			$field_set_repeat = array( 
				'' => __('Default (Design Settings)', THEME_NAME), 
				'no-repeat' => __('No repeat', THEME_NAME), 
				'repeat' => __('Repeat', THEME_NAME),
				'repeat-x' => __('Repeat Horizontal', THEME_NAME), 
				'repeat-y' => __('Repeat Vertical', THEME_NAME)
			);
			$field_comments_repeat = array();
			$comment_repeat = __('', THEME_NAME);
			$comment_repeat = $layout_admin->format_comment($comment_repeat);
			$row_repeat = '<div class="optionsColumn">' . __('Background repeat', THEME_NAME) . '<br />' . $layout_admin->settings_radiobuttons('bg_repeat', $field_set_repeat, $field_comments_repeat) . $comment_repeat . '</div>';

		$row = array(__('Background image', THEME_NAME) . $comment, $layout_admin->settings_input('background') . $comment2 . $row_x . $row_y  . $row_repeat );
		$layout_admin->setting_row($row);

	echo '</table>';

	// key for this data type is generated at random when adding new slides.
	echo '<input type="hidden" name="key" value="'. $layout_admin->get_val('key') .'" />'; // Normal way causes error --> $layout_admin->settings_hidden('index'); 

	// save button
	$layout_admin->settings_save_button(__('Save Footer', THEME_NAME), 'button-primary');	

//else:	// There is no else for this yet...

	// nothing here.
	
//endif;

?>