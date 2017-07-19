<?php

// FORCE THE KEYS - THIS IS IMPORTANT FOR SECTIONS WITH OPTIONS ON THE MAIN PAGE
$contact_form_admin->keys = array('_plugin', 'contact_fields');

$keys = $contact_form_admin->keys;


#-----------------------------------------------------------------
# Lists for each configurable area
#-----------------------------------------------------------------

	// contact_fields
	//................................................................

	$titles = array(
		__('Field', THEME_NAME), 
		__('Shortcode key', THEME_NAME), 
		__('Type', THEME_NAME), 
		__('Required', THEME_NAME), 
		__('Actions', THEME_NAME)
	);

	$title = __('Form Fields', THEME_NAME);
	$caption = __('Add and edit the your contact form fields. To create a field, click the "Add new Field" button below.', THEME_NAME);
	echo '<h3>' . $title . '</h3><p>' . $caption . '</p>';
	
	$ancestor_keys = array();
	$contact_form_admin->table_header($titles);
	
	$nbr = 0;

	// Look up contact_fields
	$contact_fields = $contact_form_admin->get_val('contact_fields', '_plugin');
	$saved_contact_fields = $contact_form_admin->get_val('contact_fields', '_plugin_saved');

	if (!empty($contact_fields) || !empty($saved_contact_fields)) {
		
		// User created
		$warning = isset($warning)? $warning : '';
		if (!empty($contact_fields)) {
			$total = count($contact_fields);
			foreach ((array) $contact_fields as $key => $item) {
				if ($a = $item['ancestor_key']) $ancestor_keys[] = $a;
				$aKeys = '_plugin,contact_fields,' . $key;
				$label = stripslashes($item['label']);
				$shortcode = isset($item['alias'])? $item['alias'] : '';

				$edit_link = array('navigation' => 'contact_field', 'action' => 'edit', 'keys' => $aKeys);
				$delete_link = array('action' => 'delete', 'action_keys' => $aKeys, 'class' => 'common-delete');
				$export_link = array('navigation' => 'export', 'keys' => $aKeys);

				$row = array(	
					$contact_form_admin->settings_link($label, $edit_link) . $warning,
					$item['key'],
					ucfirst($item['field_type']),
					($item['required'] == 1) ? 'Yes' : "&nbsp;",
					$contact_form_admin->settings_link(__('Edit', THEME_NAME), $edit_link) . ' | ' .
					$contact_form_admin->settings_link(__('Delete', THEME_NAME), $delete_link) .  ' &nbsp; ' .
					$contact_form_admin->updown_link($nbr, $total, array('keys' => '_plugin,contact_fields', 'action_keys' => '_plugin,contact_fields', 'navigation' => ''))  
				);
				$contact_form_admin->table_row($row, $nbr++);
			}
		} else {
			if ( empty($saved_contact_fields) ) {
				$row = array(__('No fields created.', THEME_NAME), '', '', '', '');
				$contact_form_admin->table_row($row, $nbr++);
			}
		} // END "User created"

		// Saved file 
		if (!empty($saved_contact_fields)) {
			foreach ($saved_contact_fields as $key => $item) {
				$label = $item['label'];
	
				// Is this overwritten?
				$class = (in_array($key, $ancestor_keys)) ? 'disabled' : false;
				if (!$class && isset($_data['_plugin']['contact_fields']) && $_data['_plugin']['contact_fields']) $class = (array_key_exists($key, $_data['_plugin']['contact_fields'])) ? 'disabled' : false ;
	
				$label = stripslashes($item['label']);
				//$shortcode = '<span>[contact_field alias="'. $item['alias'] .'" ]</span>';
				$edit_link = array('navigation' => 'contact_field', 'action' => 'edit', 'keys' => '_plugin_saved,contact_fields,'.$key);
				$row = array(	
					$label,
					$item['key'],
					ucfirst($item['field_type']),
					($item['required'] == 1) ? 'Yes' : "&nbsp;",
					$contact_form_admin->settings_link(__('Override', THEME_NAME), $edit_link) . '&nbsp; <span>('.__('from save file', THEME_NAME).')</span>'
				);

				if (!$class) { 
					// only show saved if not overriden
					$contact_form_admin->table_row($row, $nbr++, 'disabled'); // added disabled class to lower visual priority
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
				$new_key = '_plugin,contact_fields,'. $contact_form_admin->add_key;
				$options = array('action' => 'add', 'navigation' => 'contact_field', 'keys' => $new_key, 'class' => 'button');
				echo '<p>' . $contact_form_admin->settings_link('Add new Field', $options) . '</p>';
			?>
			</th>
			</tr>
		</tfoot>
	</table>
	<?php 
	
	$options = array('navigation' => 'export', 'keys' => '_plugin,contact_fields', 'class' => 'button');
	echo '<br /><div>' . $contact_form_admin->settings_link(__('Export Contact Fields', THEME_NAME), $options) . '</div><br />';
	
	echo '<br /><br />';

?>