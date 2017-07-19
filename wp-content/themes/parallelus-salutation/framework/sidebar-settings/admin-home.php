<?php
$keys = $sidebar_admin->keys;
?>

<p>Add sidebars and tabs.</p>

<?php
#-----------------------------------------------------------------
# Lists for each configurable area
#-----------------------------------------------------------------
	
	// Sidebars
	//................................................................

	$titles = array(
				__('Sidebar', THEME_NAME), 
				__('Shortcode', THEME_NAME),
				__('Actions', THEME_NAME)
			);

	$title = __('Sidebars', THEME_NAME);
	$caption = __('Create sidebars which you can include in layouts, insert with shortcodes and add widgets to from the "Widgets" page.', THEME_NAME);
	echo '<h3>' . $title . '</h3><p>' . $caption . '</p>';
	
	$ancestor_keys = array();
	$sidebar_admin->table_header($titles);
	
	$nbr = 0;

	// Look up sidebars
	$sidebars = $sidebar_admin->get_val('sidebars', '_plugin');
	$saved_sidebars = $sidebar_admin->get_val('sidebars', '_plugin_saved');

	if (!empty($sidebars) || !empty($saved_sidebars)) {
		
		// User created
		if (!empty($sidebars)) {
			$total = count($sidebars);
			foreach ((array) $sidebars as $key => $item) {
				if ($a = $item['ancestor_key']) $ancestor_keys[] = $a;
				$aKeys = '_plugin,sidebars,' . $key;
				$label = stripslashes($item['label']);
				$shortcode = '<span>[sidebar alias="'. $item['alias'] .'" ]</span>';

				$edit_link = array('navigation' => 'sidebar', 'action' => 'edit', 'keys' => $aKeys);
				$delete_link = array('action' => 'delete', 'action_keys' => $aKeys, 'class' => 'common-delete');
				$export_link = array('navigation' => 'export', 'keys' => $aKeys);

				$warning = '';
				$row = array(	
					$sidebar_admin->settings_link($label, $edit_link) . $warning,
					$shortcode,
					$sidebar_admin->settings_link(__('Edit', THEME_NAME), $edit_link) . ' | ' .
					$sidebar_admin->settings_link(__('Delete', THEME_NAME), $delete_link) . 
					$sidebar_admin->updown_link($nbr, $total, array('keys' => '_plugin,sidebars', 'action_keys' => '_plugin,sidebars', 'navigation' => '' ))
				);
				$sidebar_admin->table_row($row, $nbr++);
			}
		} else {
			$row = array(__('No sidebars created.', THEME_NAME), '', '');
			$sidebar_admin->table_row($row, $nbr++);
		} // END "User created"
		
		// Saved file 
		if (!empty($saved_sidebars)) {
			foreach ($saved_sidebars as $key => $item) {
				$label = $item['label'];
	
				// Is this overwritten?
				$class = (in_array($key, $ancestor_keys)) ? 'disabled' : false;
				if (!$class && $_data['_plugin']['sidebars']) $class = (array_key_exists($key, $_data['_plugin']['sidebars'])) ? 'disabled' : false ;
	
				$label = stripslashes($item['label']);
				$shortcode = '<span>[sidebar alias="'. $item['alias'] .'" ]</span>';
				$edit_link = array('navigation' => 'sidebar', 'action' => 'edit', 'keys' => '_plugin_saved,sidebars,'.$key);
				$row = array(	
						$label,
						$shortcode,
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
				$new_key = '_plugin,sidebars,'. $sidebar_admin->add_key;
				$options = array('action' => 'add', 'navigation' => 'sidebar', 'keys' => $new_key, 'class' => 'button');
				echo '<p>' . $sidebar_admin->settings_link('Add new Sidebar', $options) . '</p>';
			?>
			</th>
			</tr>
		</tfoot>
	</table>
	<?php 
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,sidebars', 'class' => 'button');
	echo '<br /><div>' . $sidebar_admin->settings_link(__('Export Sidebars', THEME_NAME), $options) . '</div><br />';
	

?>