<?php
// DEFAULT - Theme Settings Page

	$keys = $layout_admin->keys;
	$importing = (isset($keys[0]) && ($keys[0] == '_plugin_saved')) ? true : false; // are we trying to import saved settings?


	echo '<p>' . __('Creat unique page headers and footers then assign them to layouts. Configure the columns and content sources of each layout with drag-and-drop controls.' ,THEME_NAME) . '</p>';


#-----------------------------------------------------------------
# Lists for each configurable area
#-----------------------------------------------------------------


	
	// Page Headers
	//................................................................

	$titles = array(
				__('Header', THEME_NAME), 
				'&nbsp;',
				__('Actions', THEME_NAME)
			);

	$title = __('Headers', THEME_NAME);
	$caption = __('Select the elements to use in your header including slide shows, top graphics, menus, top content area and showcase content. The headers created here are available to add to any page layout.', THEME_NAME);
	echo '<h3>' . $title . '</h3><p>' . $caption . '</p>';
	
	$ancestor_keys = array();
	$layout_admin->table_header($titles);
	
	$nbr = 0;
	
	// Look up page headers
	$page_headers = $layout_admin->get_val('page_headers', '_plugin');
	$saved_page_headers = $layout_admin->get_val('page_headers', '_plugin_saved');

	if (!empty($page_headers) || !empty($saved_page_headers)) {
	
		// User created
		if (!empty($page_headers)) {

			foreach ((array) $page_headers as $key => $item) {
				if ($a = $item['ancestor_key']) $ancestor_keys[] = $a;
				$aKeys = '_plugin,page_headers,' . $key;
				$label = stripslashes($item['label']);

				$edit_link = array('navigation' => 'page_header', 'action' => 'edit', 'keys' => $aKeys);
				$delete_link = array('action' => 'delete', 'action_keys' => $aKeys, 'class' => 'common-delete');
				$export_link = array('navigation' => 'export', 'keys' => $aKeys);

				$warning = '';
				$row = array(	
					$layout_admin->settings_link($label, $edit_link) . $warning,
					'&nbsp;',
					$layout_admin->settings_link(__('Edit', THEME_NAME), $edit_link) . ' | ' .
					$layout_admin->settings_link(__('Delete', THEME_NAME), $delete_link)
				);
				$layout_admin->table_row($row, $nbr++);
			}
		} else {
			$row = array(__('No page headers created.', THEME_NAME), '', '');
			$layout_admin->table_row($row, $nbr++);
		} // END "User created"
		
		// Saved file 
		if (!empty($saved_page_headers)) {
			foreach ($saved_page_headers as $key => $item) {
				$label = $item['label'];
	
				// Is this overwritten?
				$class = (in_array($key, $ancestor_keys)) ? 'disabled' : false;
				if (!$class && $_data['_plugin']['page_headers']) $class = (array_key_exists($key, $_data['_plugin']['page_headers'])) ? 'disabled' : false ;
	
				$label = stripslashes($item['label']);
				$edit_link = array('navigation' => 'page_header', 'action' => 'edit', 'keys' => '_plugin_saved,page_headers,'.$key);

				$row = array(	
						$label,
						'&nbsp;',
						$layout_admin->settings_link(__('Override', THEME_NAME), $edit_link) . '&nbsp; <span>('.__('from save file', THEME_NAME).')</span>'
					);

				if (!$class) { 
					// only show saved if not overriden
					$layout_admin->table_row($row, $nbr++, 'disabled'); // added disabled class to lower visual priority
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
				$new_key = '_plugin,page_headers,'. $layout_admin->add_key;
				$options = array('action' => 'add', 'navigation' => 'page_header', 'keys' => $new_key, 'class' => 'button');
				echo '<p>' . $layout_admin->settings_link('Add new Header', $options) . '</p>';
			?>
			</th>
			</tr>
		</tfoot>
	</table>
	<?php 
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,page_headers', 'class' => 'button');
	echo '<br /><div>' . $layout_admin->settings_link(__('Export Page Headers', THEME_NAME), $options) . '</div><br />';
	

	?>
	<a name="page_footers"></a>
	<?php
	
	// Page Footers
	//................................................................

	$titles = array(
				__('Footer', THEME_NAME), 
				'&nbsp;',
				__('Actions', THEME_NAME)
			);

	$title = __('Footers', THEME_NAME);
	$caption = __('Configure the options for the content and layout of page footers. The footers created here are available to add to page layouts.', THEME_NAME);
	echo '<h3>' . $title . '</h3><p>' . $caption . '</p>';
	
	$ancestor_keys = array();
	$layout_admin->table_header($titles);
	
	$nbr = 0;
	
	// Look up page footers
	$page_footers = $layout_admin->get_val('page_footers', '_plugin');
	$saved_page_footers = $layout_admin->get_val('page_footers', '_plugin_saved');

	if (!empty($page_footers) || !empty($saved_page_footers)) {
	
		// User created
		if (!empty($page_footers)) {

			foreach ((array) $page_footers as $key => $item) {
				if ($a = $item['ancestor_key']) $ancestor_keys[] = $a;
				$aKeys = '_plugin,page_footers,' . $key;
				$label = stripslashes($item['label']);

				$edit_link = array('navigation' => 'page_footer', 'action' => 'edit', 'keys' => $aKeys);
				$delete_link = array('action' => 'delete', 'action_keys' => $aKeys, 'class' => 'common-delete');
				$export_link = array('navigation' => 'export', 'keys' => $aKeys);
			
				$row = array(	
					$layout_admin->settings_link($label, $edit_link) . $warning,
					'&nbsp;',
					$layout_admin->settings_link(__('Edit', THEME_NAME), $edit_link) . ' | ' .
					$layout_admin->settings_link(__('Delete', THEME_NAME), $delete_link)
				);
				$layout_admin->table_row($row, $nbr++);
			}
		} else {
			$row = array(__('No page footers created.', THEME_NAME), '', '');
			$layout_admin->table_row($row, $nbr++);
		} // END "User created"
		
		// Saved file 
		if (!empty($saved_page_footers)) {
			foreach ($saved_page_footers as $key => $item) {
				$label = $item['label'];
	
				// Is this overwritten?
				$class = (in_array($key, $ancestor_keys)) ? 'disabled' : false;
				if (!$class && $_data['_plugin']['page_footers']) $class = (array_key_exists($key, $_data['_plugin']['page_footers'])) ? 'disabled' : false ;
	
				$label = stripslashes($item['label']);
				$edit_link = array('navigation' => 'page_footer', 'action' => 'edit', 'keys' => '_plugin_saved,page_footers,'.$key);
				
				$row = array(	
						$label,
						'&nbsp;',
						$layout_admin->settings_link(__('Override', THEME_NAME), $edit_link) . '&nbsp; <span>('.__('from save file', THEME_NAME).')</span>'
					);

				if (!$class) { 
					// only show saved if not overriden
					$layout_admin->table_row($row, $nbr++, 'disabled'); // added disabled class to lower visual priority
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
				$new_key = '_plugin,page_footers,'. $layout_admin->add_key;
				$options = array('action' => 'add', 'navigation' => 'page_footer', 'keys' => $new_key, 'class' => 'button');
				echo '<p>' . $layout_admin->settings_link('Add new Footer', $options) . '</p>';
			?>
			</th>
			</tr>
		</tfoot>
	</table>
	<?php 
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,page_footers', 'class' => 'button');
	echo '<br /><div>' . $layout_admin->settings_link(__('Export Page Footers', THEME_NAME), $options) . '</div><br />';


	?>
	<a name="page_layouts"></a>
	<?php
	
	// Layouts list
	//................................................................

	$titles = array(
				__('Template', THEME_NAME), 
				'&nbsp;',
				__('Actions', THEME_NAME)
			);

	$title = __('Layouts', THEME_NAME);
	$caption = __('Create and manage the templates available for your content.', THEME_NAME);
	echo '<h3>' . $title . '</h3><p>' . $caption . '</p>';
	
	$ancestor_keys = array();
	$layout_admin->table_header($titles);
	
	$nbr = 0;

	// Look up layouts
	$layouts = $layout_admin->get_val('layouts', '_plugin');
	$saved_layouts = $layout_admin->get_val('layouts', '_plugin_saved');

	if (!empty($layouts) || !empty($saved_layouts)) {
	
		// User created
		if (!empty($layouts)) {

			foreach ((array) $layouts as $key => $item) {
				if ($a = $item['ancestor_key']) $ancestor_keys[] = $a;
				$aKeys = '_plugin,layouts,' . $key;
				$label = stripslashes($item['label']);

				$edit_link = array('navigation' => 'layout', 'action' => 'edit', 'keys' => $aKeys);
				$delete_link = array('action' => 'delete', 'action_keys' => $aKeys, 'class' => 'common-delete');
				$export_link = array('navigation' => 'export', 'keys' => $aKeys);
			
				$row = array(	
					$layout_admin->settings_link($label, $edit_link) . $warning,
					'&nbsp;',
					$layout_admin->settings_link(__('Edit', THEME_NAME), $edit_link) . ' | ' .
					$layout_admin->settings_link(__('Delete', THEME_NAME), $delete_link)
				);
				$layout_admin->table_row($row, $nbr++);
			}
		} else {
			$row = array(__('No layouts created.', THEME_NAME), '', '');
			$layout_admin->table_row($row, $nbr++);
		} // END "User created"
		
		// Saved file 
		if (!empty($saved_layouts)) {
			foreach ($saved_layouts as $key => $item) {
				$label = $item['label'];
	
				// Is this overwritten?
				$class = (in_array($key, $ancestor_keys)) ? 'disabled' : false;
				if (!$class && $_data['_plugin']['layouts']) $class = (array_key_exists($key, $_data['_plugin']['layouts'])) ? 'disabled' : false ;
	
				$label = stripslashes($item['label']);
				$edit_link = array('navigation' => 'layout', 'action' => 'edit', 'keys' => '_plugin_saved,layouts,'.$key);

				$row = array(	
						$label,
						'&nbsp;',
						$layout_admin->settings_link(__('Override', THEME_NAME), $edit_link) . '&nbsp; <span>('.__('from save file', THEME_NAME).')</span>'
					);

				if (!$class) { 
					// only show saved if not overriden
					$layout_admin->table_row($row, $nbr++, 'disabled'); // added disabled class to lower visual priority
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
				$new_key = '_plugin,layouts,'. $layout_admin->add_key;
				$options = array('action' => 'add', 'navigation' => 'layout', 'keys' => $new_key, 'class' => 'button');
				echo '<p>' . $layout_admin->settings_link('Add new Layout', $options) . '</p>';
			?>
			</th>
			</tr>
		</tfoot>
	</table>
	<?php 
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,layouts', 'class' => 'button');
	echo '<br /><div>' . $layout_admin->settings_link(__('Export Layouts', THEME_NAME), $options) . '</div><br />';


	echo '<br /><br />';
		

?>