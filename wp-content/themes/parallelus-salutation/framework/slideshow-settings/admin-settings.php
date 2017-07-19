<style type="text/css">
	form textarea.input-textarea { width: 100% !important; height: 200px !important; }
</style>
<?php


$keys = $slideshow_admin->keys;
$data = $slideshow_admin->data;

	
// SLIDE SHOW SETUP
if ( $slideshow_admin->navigation == 'slideshow') :

	// Set up the navigation
	if (!($navtext = $slideshow_admin->get_val('label'))) $navtext = __('Create new', THEME_NAME);
	$slideshow_admin->navigation_bar(array(__('Slide show', THEME_NAME) . ': ' . $navtext));

	echo '<p>' . __('Create a new slide show.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'slideshows', 'action_keys' => $keys, 'action' => 'save');
	$slideshow_admin->settings_form_header($form_link);
	
	?>
	<table class="form-table">
	<?php
	
		$comment = __('This name is for reference only.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Title of slide show', THEME_NAME) . $required, $slideshow_admin->settings_input('label') . $comment);
		$slideshow_admin->setting_row($row);

		$comment = __('This ID can be used to add the slide show with a shortcode.', THEME_NAME);
		if ($val = $slideshow_admin->get_val('key')) {
			$comment .= ' ' . sprintf ( '<br />' . __('For example, you can use %s to include the slide show into a page.', THEME_NAME), '<code>[slideshow alias="' . $val . '"]</code>' ); 
		}
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('ID (unique identifier)', THEME_NAME) . $required, $slideshow_admin->settings_input('key') . $comment);
		$slideshow_admin->setting_row($row);

		$comment = __('Optional', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$comment2 = __('Leave this field blank to use the default value.', THEME_NAME);
		$comment2 = $slideshow_admin->format_comment($comment2);
		$row = array(__('Width', THEME_NAME) . $comment, $slideshow_admin->settings_input('width') . $comment2);
		$slideshow_admin->setting_row($row);

		$comment = __('Optional', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$comment2 = __('Leave this field blank to use the default value.', THEME_NAME);
		$comment2 = $slideshow_admin->format_comment($comment2);
		$row = array(__('Height', THEME_NAME) . $comment, $slideshow_admin->settings_input('height') . $comment2);
		$slideshow_admin->setting_row($row);

		$comment = __('The number of seconds between slides.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Timing', THEME_NAME), $slideshow_admin->settings_input('timing') . $comment);
		$slideshow_admin->setting_row($row);

		$transitions = array( 
			'fade' => 'fade',
			'scrollHorz' => 'scrollHorz',
			'scrollVert' => 'scrollVert',
			'shuffle' => 'shuffle',
			'blindY' => 'blindY',
			'blindZ' => 'blindZ',
			'cover' => 'cover',
			'curtainX' => 'curtainX',
			'curtainY' => 'curtainY',
			'fadeZoom' => 'fadeZoom',
			'growX' => 'growX',
			'growY' => 'growY',
			'scrollUp' => 'scrollUp',
			'scrollDown' => 'scrollDown',
			'scrollLeft' => 'scrollLeft',
			'scrollRight' => 'scrollRight',
			'slideX' => 'slideX',
			'slideY' => 'slideY',
			'toss' => 'toss',
			'turnUp' => 'turnUp',
			'turnDown' => 'turnDown',
			'turnLeft' => 'turnLeft',
			'turnRight' => 'turnRight',
			'uncover' => 'uncover',
			'wipe' => 'wipe',
			'zoom' => 'zoom',
			'none' => 'none'
		);
		$comment = __('Default transition used for slides. Can be set individually for each slide if desired.', THEME_NAME);
		$comment = '<em>' . $comment . '</em>';
		$row = array(__('Transition', THEME_NAME), $slideshow_admin->settings_select('transition', $transitions) . $comment);
		$slideshow_admin->setting_row($row);

		$comment = __('Optional. Speed of the transition effect in milliseconds. For example, enter 2000 for 2 seconds.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Transition speed', THEME_NAME), $slideshow_admin->settings_input('speed') . $comment);
		$slideshow_admin->setting_row($row);

		$comment = __('Only applies to 1 column slide shows. ', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Pause on hover', THEME_NAME), $slideshow_admin->settings_bool('pause_on_hover', $keys) . $comment);
		$slideshow_admin->setting_row($row);
		
		$field_set = array( 
			'1' => '1 (default)', 
			'2' => '2', 
			'3' => '3', 
			'4' => '4', 
			'5' => '5',
			'6' => '6'
		);
		$field_comments = array();
		$comment = __('The slide show supports multiple columns of images allowing you to select a different series of images for each column.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Columns', THEME_NAME) . $comment, $slideshow_admin->settings_radiobuttons('columns', $field_set, $field_comments));
		$slideshow_admin->setting_row($row);

	echo '</table>';
	echo $slideshow_admin->settings_hidden('slides_1');
	echo $slideshow_admin->settings_hidden('slides_2');
	echo $slideshow_admin->settings_hidden('slides_3');
	echo $slideshow_admin->settings_hidden('slides_4');
	echo $slideshow_admin->settings_hidden('slides_5');
	echo $slideshow_admin->settings_hidden('slides_6');
	
	if ($slideshow_admin->action != 'add') {

		// Slides
		//................................................................
	
		$titles = array(
					__('Slide', THEME_NAME), 
					__('Media', THEME_NAME),
					__('Transition', THEME_NAME),
					__('Actions', THEME_NAME)
				);

		$title = __('Slides', THEME_NAME);
		$caption = __('The slides for this slide show.', THEME_NAME);
		echo '<h3>' . $title . '</h3><p>' . $caption . '</p>';
		
		$ancestor_keys = array();
		$defaultTrans = 'Default (' . $slideshow_admin->get_val('transition') . ')';
		
		// Look up slides for each column
		$columns = $slideshow_admin->get_val('columns');
		for ($i=1; $i <= $columns; $i++) {
			
			// print the slides in this column
			echo '<h4>Column '. $i .'</h4>';
			$slideshow_admin->table_header($titles);
			
			$col = 'slides_'. $i;
			$nbr = 0;
			$slides = $slideshow_admin->get_val($col);
			if (!empty($slides)) {
				$slide_count = 1;
				$warning = isset($warning)? $warning : '';
				foreach ((array) $slides as $key => $item) {
					$fieldKeys = $keys[0] .','. $keys[1] .','. $keys[2] .','. $col;
					$akeys = $fieldKeys .','. $key;
					$label = 'Slide ' . $slide_count;
					// $media
					if ($item['format'] == 'image' || $item['format'] == 'background-image' || $item['format'] == 'framed-image') {
						$media = '<img src="'. $item['media'] .'" width="200" height="60" />';
					} elseif ($item['format'] == 'video' || $item['format'] == 'framed-video') {
						$media = __('Video', THEME_NAME);
					} else {
						$media = __('Other', THEME_NAME);
					}
					$transition = (!$item['transition']) ? $defaultTrans : stripslashes($item['transition']);
					$edit_link = array('navigation' => 'slide', 'action' => 'edit', 'keys' => $akeys);
					$delete_link = array('navigation' => 'slideshow', 'action' => 'delete', 'action_keys' => $akeys, 'keys' => $keys, 'class' => 'more-common-delete');
		
					$row = array(	
							$slideshow_admin->settings_link($label, $edit_link) . $warning,
							$slideshow_admin->settings_link($media, $edit_link),
							$transition,
							$slideshow_admin->settings_link(__('Edit', THEME_NAME), $edit_link) . ' | ' .
							$slideshow_admin->settings_link(__('Delete', THEME_NAME), $delete_link) .
							$slideshow_admin->updown_link($nbr, count($slides), array('keys' => $keys, 'action_keys' => $fieldKeys ))
						);
					$slideshow_admin->table_row($row, $nbr++);
					$slide_count++;
				}
			} else {
				$row = array(__('No slides added.', THEME_NAME), '', '', '');
				$slideshow_admin->table_row($row, $nbr++);
			}

			?>
			</tbody>
				<tfoot>
					<tr>
					<th colspan="<?php echo count($titles); ?>">
					<?php
						$new_key = $keys[0] . ',' . $keys[1] . ',' . $keys[2] . ','. $col .','. $slideshow_admin->add_key;
						$options = array('action' => 'add', 'navigation' => 'slide', 'keys' => $new_key, 'class' => 'button');
						echo '<p>' . $slideshow_admin->settings_link('Add new Slide', $options) . '</p>';
					?>
					</th>
					</tr>
				</tfoot>
			</table>
			<?php
			
		} // end loop for each column

	} else {
	
		echo '<p>';
		_e('After saving these settings you can edit the slide show to add slides.', THEME_NAME);
		echo '</p>';
	}

	echo '<br />';

	// save button
	$slideshow_admin->settings_save_button(__('Save Slide Show', THEME_NAME), 'button-primary');	
	
	echo '<br /><br />';

else:	// ADDING (or editing) A SINGLE SLIDE



	// Set up the navigation
	$navtext = __('Edit slide', THEME_NAME);
	if ($slideshow_admin->action !== 'edit') $navtext = __('Create new slide', THEME_NAME);

	$parentSS = $slideshow_admin->get_val('label', array($keys[0], $keys[1], $keys[2]));
	$navurl = $slideshow_admin->settings_link($parentSS, array('keys' => $keys[0].','.$keys[1].','.$keys[2], 'navigation' => 'slideshow'));
	$slideshow_admin->navigation_bar(array($navurl, $navtext));

	
	echo '<p>' . __('Add a new slide.', THEME_NAME) . '</p>';

	$form_link = array('navigation' => 'slideshow', 'action_keys' => $keys, 'action' => 'save', 'keys' => array($keys[0], $keys[1], $keys[2]) );
	$slideshow_admin->settings_form_header($form_link);
	
	?>
	<table class="form-table">
	<?php
	
		$comment = __('The full path to an image or video. Leave empty to custom define slide layout in content area.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Media', THEME_NAME), $slideshow_admin->settings_input('media') . $comment);
		$slideshow_admin->setting_row($row);

		$comment = __('Optional. Make the slide link to a page, post or other website.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Link URL', THEME_NAME), $slideshow_admin->settings_input('link') . $comment);
		$slideshow_admin->setting_row($row);

		$comment = __('Open the link in a new window.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Open in new window', THEME_NAME), $slideshow_admin->settings_bool('target_blank', $keys) . $comment);
		$slideshow_admin->setting_row($row);

		$field_set = array( 
			'image' => 'Image only', 
			'video' => 'Video only', 
			'content' => 'Content only (custom)', 
			'background-image' => 'Content with background image', 
			'framed-image' => 'Content with framed image', 
			'framed-video' => 'Content with framed video'
		);
		$field_comments = array(
			'image' => 'Use the image entered in the "Media" field above as the only content for this slide.', 
			'video' => 'Display the video entered in the "Media" field above as the only content for this slide.', 
			'content' => 'Custom define the layout and content of your slide using the content area below.', 
			'background-image' => 'Use the image from the  "Media" field as a background for the content entered in the content area below.', 
			'framed-image' => 'Show a framed image (media field) to the left or right of my content.', 
			'framed-video' => 'Show a framed video (media field) to the left or right of my content.'
		);
		$comment = '<br />'. __('Define the layout to use for displaying your slide.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Slide format', THEME_NAME) . $required . $comment, $slideshow_admin->settings_radiobuttons('format', $field_set, $field_comments));
		$slideshow_admin->setting_row($row);

		$field_set = array( 
			'left' => 'Left', 
			'right' => 'Right'
		);
		$field_comments = array( );
		$comment = __('Only applies to slides using the framed media format.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Media position', THEME_NAME) . $comment, $slideshow_admin->settings_radiobuttons('position', $field_set, $field_comments));
		$slideshow_admin->setting_row($row);

		$transitions = array( 
			'' => '',
			'fade' => 'fade',
			'scrollHorz' => 'scrollHorz',
			'scrollVert' => 'scrollVert',
			'shuffle' => 'shuffle',
			'blindY' => 'blindY',
			'blindZ' => 'blindZ',
			'cover' => 'cover',
			'curtainX' => 'curtainX',
			'curtainY' => 'curtainY',
			'fadeZoom' => 'fadeZoom',
			'growX' => 'growX',
			'growY' => 'growY',
			'scrollUp' => 'scrollUp',
			'scrollDown' => 'scrollDown',
			'scrollLeft' => 'scrollLeft',
			'scrollRight' => 'scrollRight',
			'slideX' => 'slideX',
			'slideY' => 'slideY',
			'toss' => 'toss',
			'turnUp' => 'turnUp',
			'turnDown' => 'turnDown',
			'turnLeft' => 'turnLeft',
			'turnRight' => 'turnRight',
			'uncover' => 'uncover',
			'wipe' => 'wipe',
			'zoom' => 'zoom',
			'none' => 'none'
		);
		$comment = __('Optional. Custom transition for this slide.', THEME_NAME);
		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Transition', THEME_NAME), $slideshow_admin->settings_select('transition', $transitions) . $comment);
		$slideshow_admin->setting_row($row);

		$comment  = __('Add your own content to the slide. This may include any text or images you choose. HTML and shortcodes are allowed.', THEME_NAME);
		$comment .= '<div class="hr"></div><br>'. __('Create animated slide "layers" with the following shortcodes:', THEME_NAME);
		$comment .= '<br><ul>';
		$comment .= '<li><code>'. __('[slide_right]&lt;img src="layer-1.jpg"&gt;[/slide_right]', THEME_NAME) . '</code></li>';
		$comment .= '<li><code>'. __('[slide_left]&lt;img src="layer-1.jpg"&gt;[/slide_left]', THEME_NAME) . '</code></li>';
		$comment .= '<li><code>'. __('[slide_up]&lt;img src="layer-1.jpg"&gt;[/slide_up]', THEME_NAME) . '</code></li>';
		$comment .= '<li><code>'. __('[slide_down]&lt;img src="layer-1.jpg"&gt;[/slide_down]', THEME_NAME) . '</code></li>';
		$comment .= '</ul>';
		$comment .= '<br>'. __('Slide animation shortcode parameters:', THEME_NAME);
		$comment .= '<br><ul>';
		$comment .= '<li><strong>'. __('easing', THEME_NAME) . '</strong> - '. __('Values: stopSlow, stopMedium, stopFast, stopElastic, stopBack, stopBounce', THEME_NAME) . '</li>';
		$comment .= '<li><strong>'. __('speed', THEME_NAME) . '</strong> - '. __('Time of transition from start to end in milliseconds, e.g. 1000 = 1 second', THEME_NAME) . '</li>';
		$comment .= '<li><strong>'. __('delay', THEME_NAME) . '</strong> - '. __('Delay showing element in milliseconds. e.g. 1000 = 1 second', THEME_NAME) . '</li>';
		$comment .= '<li><strong>'. __('css', THEME_NAME) . '</strong> - '. __('Any valid css styles to add. E.g. css="color: #F00;" ', THEME_NAME) . '</li>';
		$comment .= '</ul>';
		$comment .= '<div class="hr"></div><strong>'. __('NOTE: Be sure to set the "Slide format" in the options above to "Content with background" or another option that includes the content box when using animations.', THEME_NAME) .'</strong>';

		$comment = $slideshow_admin->format_comment($comment);
		$row = array(__('Slide content', THEME_NAME), $slideshow_admin->settings_textarea('content', $keys) . $comment);
		$slideshow_admin->setting_row($row);


	echo '</table>';

	// key for this data type is generated at random when adding new slides.
	echo '<input type="hidden" name="key" value="'. $slideshow_admin->get_val('key') .'" />'; // Normal way causes error --> $slideshow_admin->settings_hidden('index'); 

	// save button
	$slideshow_admin->settings_save_button(__('Save Slide', THEME_NAME), 'button-primary');	
	
	echo '<br /><br />';
	
endif;
?>