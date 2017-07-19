<style type="text/css">
	form textarea.input-textarea { width: 100% !important; height: 200px !important; }
</style>
<?php

$keys = $layout_admin->keys;
$data = $layout_admin->data;

// Setup defaults from other areas
//--------------------------------------------------------------

// Slide show drop down data
$slideshow_data = $GLOBALS['slideshow_admin']->load_objects();
$slideshows = array_merge(
	(array) $slideshow_data['_plugin_saved']['slideshows'], 
	(array) $slideshow_data['_plugin']['slideshows']
);

// Rev Slider drop down data
if ( class_exists( 'RevSlider' ) ) {
	$revslider = new RevSlider();
	$arrsliders = $revslider->getArrSliders();
}
// Sidebar drop down data
$sidebar_data = $GLOBALS['sidebar_admin']->load_objects();
$sidebars = array_merge(
	isset($sidebar_data['_plugin_saved']['sidebars'])? (array) $sidebar_data['_plugin_saved']['sidebars'] : array(), 
	isset($sidebar_data['_plugin']['sidebars'])? (array) $sidebar_data['_plugin']['sidebars'] : array()
);

// Drop down options
//--------------------------------------------------------------

// Primary content: slide show and static blocks drop down
$select_header_content = array('' => ' ');
if (!empty($slideshows)) {
	foreach ($slideshows as $ss) {
		if (!empty($ss)) $select_header_content['ss,'.$ss['key']] = __('Slide Show: ', THEME_NAME).$ss['label'];
	}
}

// Rev SLider list
if ( isset($arrsliders) && !empty($arrsliders) ) {
	$select_header_content['-'] = '---'; 
	foreach ($arrsliders as $slider) {
		$key = $slider->getAlias();
		$label = $slider->getTitle();
		if (!empty($slider)) $select_header_content['rs,'.$key] = __('Slider Revolution: ', THEME_NAME).$label;
	}
}

$content_blocks = $layout_admin->get_posts(false, true, 'static_block', 'post_name');
if (!empty($content_blocks)) {
	$select_header_content['--'] = '---'; // blank divider between Slide Show and blocks
	foreach ($content_blocks as $key => $value) {
		$select_header_content['static,'.$key] = __('Static Block: ', THEME_NAME). $value;
	}
}

// Sidebar drop down
$select_sidebar = array('' => 'None');
if (!empty($sidebars)) {
	foreach ($sidebars as $item) {
		if (!empty($item)) $select_sidebar[$item['key']] = $item['label'];
	}
}

// PAGE HEADER SETUP
//if ( $layout_admin->navigation == 'page_header') :

	// Set up the navigation
	if (!($navtext = $layout_admin->get_val('label'))) $navtext = __('Create new', THEME_NAME);
	$layout_admin->navigation_bar(array(__('Page header', THEME_NAME) . ': ' . $navtext));

	echo '<p>' . __('Create a new page header.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'page_headers', 'action_keys' => $keys, 'action' => 'save');
	$layout_admin->settings_form_header($form_link);
	
	?>
	<table class="form-table">
	<?php
	
		$comment = __('For reference only.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Title', THEME_NAME) . $required, $layout_admin->settings_input('label') . $comment);
		$layout_admin->setting_row($row);

		$comment = __('Optional. Override your default logo for this header. Enter full image URL.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Alternate logo', THEME_NAME), $layout_admin->settings_input('logo') . $comment);
		$layout_admin->setting_row($row);

		$select = $select_sidebar;
		$comment = __('Select a sidebar to populate the area above the page top and below the logo and menu.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Top banner', THEME_NAME), $layout_admin->settings_select('top_sidebar', $select) . $comment);
		$layout_admin->setting_row($row);

		$headerContent = $select_header_content;
		$comment = __('The header area can display slide shows, static content or nothing. Select the source for this header. ', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('<strong>Primary content</strong>', THEME_NAME), $layout_admin->settings_select('content', $headerContent));
		$layout_admin->setting_row($row,'highlight');

		$field_set = array( 
			'show' => __('Show borders', THEME_NAME), 
			'hide' => __('Hide borders', THEME_NAME)
		);
		$field_comments = array();
		$comment = __('Show the borders of the top container.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Top container', THEME_NAME) . $comment, $layout_admin->settings_radiobuttons('top_container', $field_set, $field_comments));
		$layout_admin->setting_row($row);

		// Background Color
		$comment = __('Optional', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$comment2 = __('Enter the HEX color value for an option background color.', THEME_NAME) . 
					'<br /><a href="http://www.colorpicker.com/" target="_blank">' . __('Where can I get the HEX value for my color?', THEME_NAME) . '</a>';
		$comment2 = $layout_admin->format_comment($comment2);
		$row = array(__('Background color', THEME_NAME) . $comment, "#" . $layout_admin->settings_input('bg_color') . $comment2);
		$layout_admin->setting_row($row);

		// Background glow
		$field_set = array( 
			'show' => __('Show glow effect', THEME_NAME), 
			'hide' => __('Hide glow effect', THEME_NAME)
		);
		$field_comments = array();
		$comment = __('Show glow effect in header background.', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$row = array(__('Background glow', THEME_NAME) . $comment, $layout_admin->settings_radiobuttons('bg_glow', $field_set, $field_comments));
		$layout_admin->setting_row($row);

		// Background Image
		$comment = __('Optional', THEME_NAME);
		$comment = $layout_admin->format_comment($comment);
		$comment2 = __('Enter the full URL of an image to show in your header background.', THEME_NAME);
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
	$layout_admin->settings_save_button(__('Save Header', THEME_NAME), 'button-primary');	

	?>
	<br /><br />
	
<?php
//else:	// There is no else for this yet...

	// nothing here.

//endif;
?>