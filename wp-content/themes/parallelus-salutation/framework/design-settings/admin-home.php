<style type="text/css">
	form textarea.input-textarea { width: 100% !important; height: 200px !important; }
</style>
<?php

$keys = $design_admin->keys;
$data = $design_admin->data;

// Setup defaults from other areas
// ------------------------------------------

// Headers drop down data
$page_headers = $design_admin->get_val('page_headers', '_plugin');
$page_headers_saved = $design_admin->get_val('page_headers', '_plugin_saved');
if (!empty($page_headers_saved)) {
	$page_headers = array_merge((array)$page_headers_saved, (array)$page_headers);
}
// Footers drop down data
$page_footers = $design_admin->get_val('page_footers', '_plugin');
$page_footers_saved = $design_admin->get_val('page_footers', '_plugin_saved');
if (!empty($page_footers_saved)) {
	$page_footers = array_merge((array)$page_footers_saved, (array)$page_footers);
}
// Page layouts drop down data
$page_layouts = $design_admin->get_val('layouts', '_plugin');
$page_layouts_saved = $design_admin->get_val('layouts', '_plugin_saved');
if (!empty($page_layouts_saved)) {
	$page_layouts = array_merge((array)$page_layouts_saved, (array)$page_layouts);
}
// Sidebar drop down data
$sidebar_data = $GLOBALS['sidebar_admin']->load_objects();
$sidebars = array_merge(
	isset($sidebar_data['_plugin_saved']['sidebars'])? (array) $sidebar_data['_plugin_saved']['sidebars'] : array(), 
	isset($sidebar_data['_plugin']['sidebars'])? (array) $sidebar_data['_plugin']['sidebars'] : array()
);

// Prep. each select list
$select_header = array();
foreach ((array) $page_headers as $item) {
	if (!empty($item)) $select_header[$item['key']] = $item['label'];
}
$select_footer = array();
foreach ((array) $page_footers as $item) {
	if (!empty($item)) $select_footer[$item['key']] = $item['label'];
}
$select_layout = array();
foreach ((array) $page_layouts as $item) {
	if (!empty($item)) $select_layout[$item['key']] = $item['label'];
}
$select_sidebar = array();
foreach ((array) $sidebars as $item) {
	if (!empty($item)) $select_sidebar[$item['key']] = $item['label'];
}

	
// DEFAULT DESIGN SETTINGS

	echo '<p>' . __('Configure the default design options.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'design_settings', 'action' => 'save', 'keys' => '_plugins,design_settings', 'action_keys' => '_plugins,design_settings');
	$design_admin->settings_form_header($form_link);
	
	echo '<table class="form-table">';
	
		// Logo
		$comment = __('Enter the full URL to your logo file. For example: ', THEME_NAME) . 
					'<br /><code>'. trailingslashit(get_bloginfo('url')) .'wp-content/uploads/'. date('Y') .'/'. date('m') .'/logo.png</code>';
		$comment = $design_admin->format_comment($comment);
		$row = array(__('Logo', THEME_NAME), $design_admin->settings_input('logo') . $comment);
		$design_admin->setting_row($row);

		$comment = __('The width of the logo file.', THEME_NAME); 
		$comment = $design_admin->format_comment($comment);
		$row = array(__('Logo width', THEME_NAME), $design_admin->settings_input('logo_width') . $comment);
		$design_admin->setting_row($row);

		$comment = __('The height of the logo file.', THEME_NAME); 
		$comment = $design_admin->format_comment($comment);
		$row = array(__('Logo height', THEME_NAME), $design_admin->settings_input('logo_height') . $comment);
		$design_admin->setting_row($row);
		
		// Skin
		$skins = $design_admin->get_skin_css();
		asort($skins);
		$select = $skins;
		$comment = __('Default skin for the theme.', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$row = array(__('Skin', THEME_NAME), $design_admin->settings_select('skin', $select) . $comment );
		$design_admin->setting_row($row);

		// Font
		$select = array(
			'cufon:aller' => 'Aller (cufon)',
			'cufon:blackjack' => 'BlackJack (cufon)',
			'cufon:cabin' => 'Cabin (cufon)',
			'cufon:calluna' => 'Calluna (cufon)',
			'cufon:cantarell' => 'Cantarell (cufon)',
			'cufon:capsuula' => 'Capsuula (cufon)',
			'cufon:chunkfive' => 'ChunkFive (cufon)',
			'cufon:colaborate' => 'Colaborate (cufon)',
			'cufon:daniel' => 'Daniel (cufon)',
			'cufon:droid-sans' => 'Droid Sans (cufon)',
			'cufon:droid-sans-mono' => 'Droid Sans Mono (cufon)',
			'cufon:droid-serif' => 'Droid Serif (cufon)',
			'cufon:fff-tusj' => 'FFF Tusj (cufon)',
			'cufon:journal' => 'Journal (cufon)',
			'cufon:lane' => 'Lane - Narrow (cufon)',
			'cufon:liberation-sans' => 'Liberation Sans (cufon)',
			'cufon:marketing-script' => 'Marketing Script (cufon)',
			'cufon:mentone' => 'Mentone (cufon)',
			'cufon:mido' => 'Mido (cufon)',
			'cufon:museo' => 'Museo (cufon)',
			'cufon:museo-sans' => 'Museo Sans (cufon)',
			'cufon:otari' => 'Otari (cufon)',
			'cufon:opensans' => 'Open Sans (cufon)',
			'cufon:quicksand' => 'Quicksand (cufon)',
			'cufon:sansation' => 'Sansation (cufon)',
			'cufon:santana' => 'Santana (cufon)',
			'cufon:share' => 'Share (cufon)',
			'cufon:titillium-text' => 'Titillium Text (cufon)',
			'cufon:ubuntu-title' => 'Ubuntu-Title (cufon)',
			'cufon:yanone-kaffeesatz' => 'Yanone Kaffeesatz (cufon)',
			
			'standard:Arial|Helvetica|Garuda|sans-serif' => 'Arial',
			'standard:"Arial Black"|Gadget|sans-serif' => 'Arial Black',
			'standard:"Courier New"|Courier|monospace' => 'Courier New',
			'standard:Georgia|"Times New Roman"|Times| serif' => 'Georgia',
			'standard:"Lucida Console"|Monaco|monospace' => 'Lucida Console',
			'standard:"Lucida Sans Unicode"|"Lucida Grande"|sans-serif' => 'Lucida Sans Unicode',
			'standard:"Palatino Linotype"|"Book Antiqua"|Palatino|serif' => 'Palatino Linotype',
			'standard:Tahoma|Geneva|sans-serif' => 'Tahoma',
			'standard:"Times New Roman"|Times|serif' => 'Times New Roman',
			'standard:"Trebuchet MS"|Arial|Helvetica|sans-serif' => 'Trebuchet MS',
			'standard:Verdana|Geneva|sans-serif' => 'Verdana',
			
			'custom:cufon' => 'Custom - Cufon File',
			'custom:standard' => 'Custom - Font'
		);
		$comment = __('Default heading font.', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$comment_custom_cufon = __('Enter the file name for your custom Cufon font.', THEME_NAME) .'<br />'. __('If saved in a different folder include the path to the file. For example: ', THEME_NAME) . 
					'<br /><code>'. trailingslashit(get_bloginfo('template_url')) .'assets/js/my-font.js</code>';
		$comment_custom_cufon = $design_admin->format_comment($comment_custom_cufon);
		$comment_custom_standard =	__('Enter a font name. This should be a standard web-safe font or it may not display for all viewers.', THEME_NAME) .
									'<br /><a href="http://en.wikipedia.org/wiki/Web_typography#Web-safe_fonts" target="_blank">'. 
										__('What is a web-safe font?', THEME_NAME) . 
									'</a>';
		$comment_custom_standard = $design_admin->format_comment($comment_custom_standard);
		$font_setting = $design_admin->get_val('fonts,heading');
		$display_custom_cufon = ($font_setting == 'custom:cufon') ? 'block' : 'none';
		$display_custom_standard = ($font_setting == 'custom:standard') ? 'block' : 'none';
		$custom_field_cufon = '<div id="heading_cufon" style="display: '.$display_custom_cufon.';"><br />'. $design_admin->settings_input('fonts,heading_cufon') . $comment_custom_cufon .'</div>';
		$custom_field_standard = '<div id="heading_standard" style="display: '.$display_custom_standard.';"><br />'. $design_admin->settings_input('fonts,heading_standard') . $comment_custom_standard .'</div>';
		$row = array(__('Heading font', THEME_NAME), $design_admin->settings_select('fonts,heading', $select) . $comment . $custom_field_cufon . $custom_field_standard);
		$design_admin->setting_row($row);

		$select = array(
			'standard:Arial|Helvetica|Garuda|sans-serif' => 'Arial',
			'standard:"Arial Black"|Gadget|sans-serif' => 'Arial Black',
			'standard:"Courier New"|Courier|monospace' => 'Courier New',
			'standard:Georgia|"Times New Roman"|Times| serif' => 'Georgia',
			'standard:"Lucida Console"|Monaco|monospace' => 'Lucida Console',
			'standard:"Lucida Sans Unicode"|"Lucida Grande"|sans-serif' => 'Lucida Sans Unicode',
			'standard:"Palatino Linotype"|"Book Antiqua"|Palatino|serif' => 'Palatino Linotype',
			'standard:Tahoma|Geneva|sans-serif' => 'Tahoma',
			'standard:"Times New Roman"|Times|serif' => 'Times New Roman',
			'standard:"Trebuchet MS"|Arial|Helvetica|sans-serif' => 'Trebuchet MS',
			'standard:Verdana|Geneva|sans-serif' => 'Verdana',
			'custom:standard' => 'Custom'
		);
		$comment = __('Select the default font for the page body.', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$comment_custom =	__('Enter a font name. This should be a standard web-safe font or it may not display for all viewers.', THEME_NAME) .
							'<br /><a href="http://en.wikipedia.org/wiki/Web_typography#Web-safe_fonts" target="_blank">'. 
								__('What is a web-safe font?', THEME_NAME) . 
							'</a>';
		$comment_custom = $design_admin->format_comment($comment_custom);
		$display_custom = ($design_admin->get_val('fonts,body') == 'custom:standard') ? 'block' : 'none';
		$custom_field = '<div id="custom_body_font" style="display: '.$display_custom.';"><br />'. $design_admin->settings_input('fonts,body_custom') . $comment_custom .'</div>';
		$row = array(__('Body font', THEME_NAME), $design_admin->settings_select('fonts,body', $select) . $comment . $custom_field);
		$design_admin->setting_row($row);

	echo '</table>';
	
	echo '<a name="other"></a>';
	echo '<div class="hr"></div> <h3>'. __('Default Sidebar', THEME_NAME) .'</h3>';
	echo '<table class="form-table">';

		$select = $select_sidebar;
		$comment = __('The default sidebar to use when not specified.', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$row = array(__('Sidebar', THEME_NAME), $design_admin->settings_select('sidebar', $select) . $comment);
		$design_admin->setting_row($row);

	echo '</table>';

	echo '<a name="colors"></a>';
	echo '<div class="hr"></div> <h3>'. __('Default Backgrounds', THEME_NAME) .'</h3>';
	echo '<table class="form-table">';


		// Header: default colors
		// --------------------------------
		
		// Background Color
		$comment = __('Optional', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$comment2 = __('Enter the HEX color value for an option background color.', THEME_NAME) . 
					'<br /><a href="http://www.colorpicker.com/" target="_blank">' . __('Where can I get the HEX value for my color?', THEME_NAME) . '</a>';
		$comment2 = $design_admin->format_comment($comment2);
		$row = array(__('Header background color', THEME_NAME) . $comment, "#" . $design_admin->settings_input('header,bg_color') . $comment2);
		$design_admin->setting_row($row);

		// Background Image
		$comment = __('Optional', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$comment2 = __('Enter the full URL of an image to show in your header background.', THEME_NAME);
		$comment2 = $design_admin->format_comment($comment2);

			$field_set_x = array( 
				'0%' => __('Left', THEME_NAME), 
				'50%' => __('Center', THEME_NAME), 
				'100%' => __('Right', THEME_NAME)
			);
			$field_comments_x = array();
			$comment_x = __('', THEME_NAME);
			$comment_x = $design_admin->format_comment($comment_x);
			$row_x = '<div class="optionsColumn">' . __('Horizontal position', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('header,bg_pos_x', $field_set_x, $field_comments_x) . $comment_x . '</div>';
	
			$field_set_y = array( 
				'0%' => __('Top', THEME_NAME), 
				'50%' => __('Middle', THEME_NAME), 
				'100%' => __('Bottom', THEME_NAME)
			);
			$field_comments_y = array();
			$comment_y = __('', THEME_NAME);
			$comment_y = $design_admin->format_comment($comment_y);
			$row_y = '<div class="optionsColumn">' . __('Vertical position', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('header,bg_pos_y', $field_set_y, $field_comments_y) . $comment_y . '</div>';

			$field_set_repeat = array( 
				'no-repeat' => __('No repeat', THEME_NAME), 
				'repeat' => __('Repeat', THEME_NAME),
				'repeat-x' => __('Repeat Horizontal', THEME_NAME), 
				'repeat-y' => __('Repeat Vertical', THEME_NAME)
			);
			$field_comments_repeat = array();
			$comment_repeat = __('', THEME_NAME);
			$comment_repeat = $design_admin->format_comment($comment_repeat);
			$row_repeat = '<div class="optionsColumn">' . __('Background repeat', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('header,bg_repeat', $field_set_repeat, $field_comments_repeat) . $comment_repeat . '</div>';

		$row = array(__('Header background image', THEME_NAME) . $comment, $design_admin->settings_input('header,background') . $comment2 . $row_x . $row_y  . $row_repeat );
		$design_admin->setting_row($row);


		// Footer: default colors
		// --------------------------------
		
		// Background Color
		$comment = __('Optional', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$comment2 = __('Enter the HEX color value for an option background color.', THEME_NAME) . 
					'<br /><a href="http://www.colorpicker.com/" target="_blank">' . __('Where can I get the HEX value for my color?', THEME_NAME) . '</a>';
		$comment2 = $design_admin->format_comment($comment2);
		$row = array(__('Footer background color', THEME_NAME) . $comment, "#" . $design_admin->settings_input('footer,bg_color') . $comment2);
		$design_admin->setting_row($row);

		// Background Image
		$comment = __('Optional', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$comment2 = __('Enter the full URL of an image to show in your footer background.', THEME_NAME);
		$comment2 = $design_admin->format_comment($comment2);

			$field_set_x = array( 
				'0%' => __('Left', THEME_NAME), 
				'50%' => __('Center', THEME_NAME), 
				'100%' => __('Right', THEME_NAME)
			);
			$field_comments_x = array();
			$comment_x = __('', THEME_NAME);
			$comment_x = $design_admin->format_comment($comment_x);
			$row_x = '<div class="optionsColumn">' . __('Horizontal position', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('footer,bg_pos_x', $field_set_x, $field_comments_x) . $comment_x . '</div>';
	
			$field_set_y = array( 
				'0%' => __('Top', THEME_NAME), 
				'50%' => __('Middle', THEME_NAME), 
				'100%' => __('Bottom', THEME_NAME)
			);
			$field_comments_y = array();
			$comment_y = __('', THEME_NAME);
			$comment_y = $design_admin->format_comment($comment_y);
			$row_y = '<div class="optionsColumn">' . __('Vertical position', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('footer,bg_pos_y', $field_set_y, $field_comments_y) . $comment_y . '</div>';

			$field_set_repeat = array( 
				'no-repeat' => __('No repeat', THEME_NAME), 
				'repeat' => __('Repeat', THEME_NAME),
				'repeat-x' => __('Repeat Horizontal', THEME_NAME), 
				'repeat-y' => __('Repeat Vertical', THEME_NAME)
			);
			$field_comments_repeat = array();
			$comment_repeat = __('', THEME_NAME);
			$comment_repeat = $design_admin->format_comment($comment_repeat);
			$row_repeat = '<div class="optionsColumn">' . __('Background repeat', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('footer,bg_repeat', $field_set_repeat, $field_comments_repeat) . $comment_repeat . '</div>';

		$row = array(__('Footer background image', THEME_NAME) . $comment, $design_admin->settings_input('footer,background') . $comment2 . $row_x . $row_y  . $row_repeat );
		$design_admin->setting_row($row);


		// Body: default colors
		// --------------------------------
		
		// Background Color
		$comment = __('Optional', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$comment2 = __('Enter the HEX color value for an option background color.', THEME_NAME) . 
					'<br /><a href="http://www.colorpicker.com/" target="_blank">' . __('Where can I get the HEX value for my color?', THEME_NAME) . '</a>';
		$comment2 = $design_admin->format_comment($comment2);
		$row = array(__('Body background color', THEME_NAME) . $comment, "#" . $design_admin->settings_input('body,bg_color') . $comment2);
		$design_admin->setting_row($row);

		// Background Image
		$comment = __('Optional', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$comment2 = __('Enter the full URL of an image to show in your footer background.', THEME_NAME);
		$comment2 = $design_admin->format_comment($comment2);

			$field_set_x = array( 
				'0%' => __('Left', THEME_NAME), 
				'50%' => __('Center', THEME_NAME), 
				'100%' => __('Right', THEME_NAME)
			);
			$field_comments_x = array();
			$comment_x = __('', THEME_NAME);
			$comment_x = $design_admin->format_comment($comment_x);
			$row_x = '<div class="optionsColumn">' . __('Horizontal position', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('body,bg_pos_x', $field_set_x, $field_comments_x) . $comment_x . '</div>';
	
			$field_set_y = array( 
				'0%' => __('Top', THEME_NAME), 
				'50%' => __('Middle', THEME_NAME), 
				'100%' => __('Bottom', THEME_NAME)
			);
			$field_comments_y = array();
			$comment_y = __('', THEME_NAME);
			$comment_y = $design_admin->format_comment($comment_y);
			$row_y = '<div class="optionsColumn">' . __('Vertical position', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('body,bg_pos_y', $field_set_y, $field_comments_y) . $comment_y . '</div>';

			$field_set_repeat = array( 
				'no-repeat' => __('No repeat', THEME_NAME), 
				'repeat' => __('Repeat', THEME_NAME),
				'repeat-x' => __('Repeat Horizontal', THEME_NAME), 
				'repeat-y' => __('Repeat Vertical', THEME_NAME)
			);
			$field_comments_repeat = array();
			$comment_repeat = __('', THEME_NAME);
			$comment_repeat = $design_admin->format_comment($comment_repeat);
			$row_repeat = '<div class="optionsColumn">' . __('Background repeat', THEME_NAME) . '<br />' . $design_admin->settings_radiobuttons('body,bg_repeat', $field_set_repeat, $field_comments_repeat) . $comment_repeat . '</div>';

		$row = array(__('Body background image', THEME_NAME) . $comment, $design_admin->settings_input('body,background') . $comment2 . $row_x . $row_y  . $row_repeat );
		$design_admin->setting_row($row);

	echo '</table>';
	
	echo '<a name="css"></a>';
	echo '<div class="hr"></div> <h3>'. __('Styles', THEME_NAME) .'</h3>';
	echo '<table class="form-table">';

		$select = $select_sidebar;
		$comment = __('Add custom CSS directly to the <code>&lt;head&gt;</code> section of the site. For example, you could change the color of your links to red by entering: <code>a:link, a:visited { color: #C00; }</code>', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$row = array(__('Custom CSS', THEME_NAME), $design_admin->settings_textarea('css_custom') . $comment);
		$design_admin->setting_row($row);

	echo '</table>';

	echo '<a name="js"></a>';
	echo '<div class="hr"></div> <h3>'. __('Scripts', THEME_NAME) .'</h3>';
	echo '<table class="form-table">';

		$select = $select_sidebar;
		$comment = __('Add custom JavaScript directly to the <code>&lt;head&gt;</code> section of the site. For example, you could add an alert by entering: <code>alert(\'Welcome!\');</code>', THEME_NAME);
		$comment = $design_admin->format_comment($comment);
		$row = array(__('Custom JavaScript', THEME_NAME), $design_admin->settings_textarea('js_custom') . $comment);
		$design_admin->setting_row($row);

	echo '</table>';

	// key for this data type is generated at random when adding new slides.
	echo '<input type="hidden" name="key" value="'. $design_admin->get_val('key') .'" />'; // Normal way causes error --> $design_admin->settings_hidden('index'); 

	// save button
	$design_admin->settings_save_button(__('Save Settings', THEME_NAME), 'button-primary');
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,design_settings', 'class' => 'button');
	echo '<br /><div>' . $design_admin->settings_link(__('Export Design Settings', THEME_NAME), $options) . '</div><br />';
	

	?>
	<br /><br />


	
	<script type="text/javascript">
	
	jQuery(document).ready(function($) {
		
		// show/hide custom skin input
		jQuery("select[name='skin']").change( function() {
			var $custom = jQuery("#custom_skin_input");
			if (jQuery(this).val() == 'custom') {
				$custom.slideDown();
			} else {
				$custom.slideUp();
			}
		});
		
		// show/hide custom heading font
		jQuery("select[name='fonts,heading']").change( function() {
			var $custom_cufon = jQuery("#heading_cufon");
			var $custom_standard = jQuery("#heading_standard");

			if (jQuery(this).val() == 'custom:cufon') {
				$custom_cufon.slideDown();
			} else {
				$custom_cufon.slideUp();
			}

			if (jQuery(this).val() == 'custom:standard') {
				$custom_standard.slideDown();
			} else {
				$custom_standard.slideUp();
			}
		});
		
		// show/hide custom body font
		jQuery("select[name='fonts,body']").change( function() {
			var $custom = jQuery("#custom_body_font");
			if (jQuery(this).val() == 'custom:standard') {
				$custom.slideDown();
			} else {
				$custom.slideUp();
			}
		});


	});
	
	</script> 
