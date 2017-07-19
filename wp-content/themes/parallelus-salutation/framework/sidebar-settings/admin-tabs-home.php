<?php

// FORCE THE KEYS - THIS IS IMPORTANT FOR SECTIONS WITH OPTIONS ON THE MAIN PAGE
$sidebar_admin->keys = array('_plugin', 'tabs');

$keys = $sidebar_admin->keys;


#-----------------------------------------------------------------
# Lists for each configurable area
#-----------------------------------------------------------------

	// Tabs
	//................................................................

	$titles = array(
				__('Tab', THEME_NAME), 
				'&nbsp;',
				__('Actions', THEME_NAME)
			);

	$title = __('Slide Open Top Tabs', THEME_NAME);
	$caption = __('Each tab created in this section will appear in your "Widgets" menu as a new sidebar.  You can add content to the tab by inserting widgets in the sidebar.', THEME_NAME);
	echo '<h3>' . $title . '</h3><p>' . $caption . '</p>';
	
	$ancestor_keys = array();
	$sidebar_admin->table_header($titles);
	
	$nbr = 0;

	// Look up tabs
	$tabs = $sidebar_admin->get_val('tabs', '_plugin');
	$saved_tabs = $sidebar_admin->get_val('tabs', '_plugin_saved');

	if (!empty($tabs) || !empty($saved_tabs)) {
		
		// User created
		if (!empty($tabs)) {
			$total = count($tabs);
			foreach ((array) $tabs as $key => $item) {
				if ($a = $item['ancestor_key']) $ancestor_keys[] = $a;
				$aKeys = '_plugin,tabs,' . $key;
				$label = stripslashes($item['label']);
				//$shortcode = '<span>[tab alias="'. $item['alias'] .'" ]</span>';

				$edit_link = array('navigation' => 'tab', 'action' => 'edit', 'keys' => $aKeys);
				$delete_link = array('action' => 'delete', 'action_keys' => $aKeys, 'class' => 'common-delete');
				$export_link = array('navigation' => 'export', 'keys' => $aKeys);

				$row = array(	
					$sidebar_admin->settings_link($label, $edit_link) . $warning,
					'&nbsp;',
					$sidebar_admin->settings_link(__('Edit', THEME_NAME), $edit_link) . ' | ' .
					$sidebar_admin->settings_link(__('Delete', THEME_NAME), $delete_link) . 
					$sidebar_admin->updown_link($nbr, $total, array('keys' => '_plugin,tabs', 'action_keys' => '_plugin,tabs', 'navigation' => ''))  // updown_link($nbr, $total, array('keys' => $keys, 'action_keys' => '_plugin,contact_form,contact_fields'))
				);
				$sidebar_admin->table_row($row, $nbr++);
			}
		} else {
			$row = array(__('No tabs created.', THEME_NAME), '', '');
			$sidebar_admin->table_row($row, $nbr++);
		} // END "User created"

		// Saved file 
		if (!empty($saved_tabs)) {
			foreach ($saved_tabs as $key => $item) {
				$label = $item['label'];
	
				// Is this overwritten?
				$class = (in_array($key, $ancestor_keys)) ? 'disabled' : false;
				if (!$class && $_data['_plugin']['tabs']) $class = (array_key_exists($key, $_data['_plugin']['tabs'])) ? 'disabled' : false ;
	
				$label = stripslashes($item['label']);
				//$shortcode = '<span>[tab alias="'. $item['alias'] .'" ]</span>';
				$edit_link = array('navigation' => 'tab', 'action' => 'edit', 'keys' => '_plugin_saved,tabs,'.$key);
				$row = array(	
						$label,
						//$shortcode,
						$sidebar_admin->settings_link(__('Override', THEME_NAME), $edit_link) . '&nbsp; <span>('.__('from save file', THEME_NAME).')</span>'
					);

				if (!$class) { 
					// only show saved if not overriden
					$sidebar_admin->table_row($row, $nbr++, 'disabled'); // added disabled class to lower visual priority
				}
			}
		} // END "Saved"

	} // END (!empty( "user created") || !empty( "saved" ))
	
	?>
	</tbody>
		<tfoot>
			<tr>
			<th colspan="<?php echo count($titles); ?>">
			<?php
				$new_key = '_plugin,tabs,'. $sidebar_admin->add_key;
				$options = array('action' => 'add', 'navigation' => 'tab', 'keys' => $new_key, 'class' => 'button');
				echo '<p>' . $sidebar_admin->settings_link('Add new Tab', $options) . '</p>';
			?>
			</th>
			</tr>
		</tfoot>
	</table>
	<?php 
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,tabs', 'class' => 'button');
	echo '<br /><div>' . $sidebar_admin->settings_link(__('Export Tabs', THEME_NAME), $options) . '</div><br />';
	
	echo '<br /><br />';

?>