<?php
// DEFAULT - Theme Settings Page

$keys = $slideshow_admin->keys;
$importing = (isset($keys[0]) && ($keys[0] == '_plugin_saved')) ? true : false; // are we trying to import saved settings?


echo '<p>' . __('Create and manage your slide shows. Below you can add, edit and delete slide shows from your site. Each slide show can be assigned to a <a href="themes.php?page=layouts">Layout Header</a> as the "Primary Content" or added to any content area using a slide show shortcode.', THEME_NAME) . '</p>';

#-----------------------------------------------------------------
# Lists for each configurable area
#-----------------------------------------------------------------

	// Slideshow list
	//................................................................

	$titles = array(
				__('Slideshow', THEME_NAME), 
				__('Shortcode', THEME_NAME),
				__('Actions', THEME_NAME)
			);

	echo '<br>';
	//$title = __('Slide shows', THEME_NAME);
	//$caption = __('Create and manage your slide shows.', THEME_NAME);
	//echo '<h3>' . $title . '</h3><p>' . $caption . '</p>';
	
	$ancestor_keys = array();
	$slideshow_admin->table_header($titles);
	
	$nbr = 0;
	
	// Look up slide shows
	$slideshows = $slideshow_admin->get_val('slideshows', '_plugin');
	$saved_slideshows = $slideshow_admin->get_val('slideshows', '_plugin_saved');
	if (!empty($slideshows) || !empty($saved_slideshows)) {
		
		// User created slide shows
		if (!empty($slideshows)) {
			foreach ((array) $slideshows as $key => $item) {
				if ($a = $item['ancestor_key']) $ancestor_keys[] = $a;
				$navKeys = '_plugin,slideshows,' . $key;
				$label = stripslashes($item['label']);
				$shortcode = '<span>[slideshow alias="'. $item['key'] .'" ]</span>';
				$edit_link = array('navigation' => 'slideshow', 'action' => 'edit', 'keys' => $navKeys);
				$delete_link = array('action' => 'delete', 'action_keys' => $navKeys, 'class' => 'common-delete');
				$export_link = array('navigation' => 'export', 'keys' => $navKeys);
	
				$warning = '';
				$row = array(	
						$slideshow_admin->settings_link($label, $edit_link) . $warning,
						$shortcode,
						$slideshow_admin->settings_link(__('Edit', THEME_NAME), $edit_link) . ' | ' .
						$slideshow_admin->settings_link(__('Delete', THEME_NAME), $delete_link) //. ' | ' .
					);
				$slideshow_admin->table_row($row, $nbr++);
			}
		} else {
			$row = array(__('No slide shows created.', THEME_NAME), '', '');
			$slideshow_admin->table_row($row, $nbr++);
		}
		
		// Saved slides 
		if (!empty($saved_slideshows)) {
			foreach ($saved_slideshows as $key => $item) {
				$label = $item['label'];
	
				// Is this overwritten?
				$class = (in_array($key, $ancestor_keys)) ? 'disabled' : false;
				if (!$class && $_data['_plugin']['slideshows']) $class = (array_key_exists($key, $_data['_plugin']['slideshows'])) ? 'disabled' : false ;
	
				$label = stripslashes($item['label']);
				$shortcode = '<span>[slideshow alias="'. $item['key'] .'" ]</span>';
				$edit_link = array('navigation' => 'slideshow', 'action' => 'edit', 'keys' => '_plugin_saved,slideshows,'.$key);
				$export_link = array('navigation' => 'export', 'keys' =>  '_plugin_saved,'.$key);

				$row = array(	
						$label,
						$shortcode,
						 $slideshow_admin->settings_link(__('Override', THEME_NAME), $edit_link) . '&nbsp; <span>('.__('from save file', THEME_NAME).')</span>' //. ' | ' .
					);
				if (!$class) { //$row = array($label, '',  __('Overridden above', THEME_NAME));
					// only show saved if not overriden
					$slideshow_admin->table_row($row, $nbr++, 'disabled');
				}
			}
		}
	}
	?>
	</tbody>
		<tfoot>
			<tr>
			<th colspan="<?php echo count($titles); ?>">
			<?php
				$new_key = '_plugin,slideshows,'. $slideshow_admin->add_key;
				$options = array('action' => 'add', 'navigation' => 'slideshow', 'keys' => $new_key, 'class' => 'button');
				echo '<p>' . $slideshow_admin->settings_link('Add new Slide Show', $options) . '</p>';
			?>
			</th>
			</tr>
		</tfoot>
	</table>
	<?php

	
	$options = array('navigation' => 'export', 'keys' => '_plugin,slideshows', 'class' => 'button');
	echo '<br /><div>' . $slideshow_admin->settings_link(__('Export Slide Shows', THEME_NAME), $options) . '</div><br />';

		
	echo '<br>';
	
	echo '<h3 style="margin-bottom:0;">' . __('FAQs', THEME_NAME) . '</h3>';	
	echo '<div class="hr"></div>';	
	
	echo '<h4>' . __('How to override default slide shows', THEME_NAME) . '</h4>';
	echo '<p>' . __('You can edit a default slide show by clicking the "Override" link under the "actions" column. Once the edit screen opens and before making any changes, immediately click "Save" returning you to this page. Now you can re-open the edit screen and make any changes you need.', THEME_NAME) . '</p>';
	echo '<div class="hr"></div>';	
	
	echo '<h4>' . __('Adding slide shows to headers', THEME_NAME) . '</h4>';
	echo '<p>' . __('You can add a slide show to any header by assigning it as "Primary Content" for that header. Headers can be edited from the <a href="themes.php?page=layouts">Layouts</a> area.', THEME_NAME) . '</p>';
	echo '<div class="hr"></div>';	

	echo '<h4>' . __('Adding images', THEME_NAME) . '</h4>';
	echo '<p>' . __('After creating a new slide show, click "Edit" and at the bottom of the edit page you will see the options to create slides. Add your images from an individual slide\'s edit screen.', THEME_NAME) . '</p>';
	echo '<div class="hr"></div>';	
	
	echo '<h4>' . __('Image sizes', THEME_NAME) . '</h4>';
	echo '<p>' . __('The default slide show size is 972 * 325. If the width or height attributes are empty the defaults will be used. You should size your images to a maximum of 972px wide.', THEME_NAME) . '</p>';

?>