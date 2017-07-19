<?php

class theme_settings_admin extends framework_admin_object_ambassador_1 {

	// Add hooks & crooks
	function add_actions() {
		// empty
	}

	function after_settings_init() {
		// empty
  	}
		
	function validate_sumbission() {

		// Display instructions for saving import data
		if (isset($this->keys[0]) && ($this->keys[0] == '_plugin_saved')) {
			$this->message = __('Review the saved data and click "Import" or "Save" when done.', THEME_NAME);
		}
		
		// Contact Fields
		if ($this->navigation == 'contact_field') {
			if ($this->action == 'add') {
				$this->default = array('field_type' => 'text', 'required' => 0, 'validation' => '');
			}

		}
		if (isset($this->action_keys[2]) && ($this->action_keys[2] == 'contact_fields')) {

			if ($this->action == 'save') {
				if (!$_POST) return false;
				$this->fields = array(
					'var' => array('label', 'key', 'caption', 'field_type', 'values', 'required', 'error_required', 'minlength', 'maxlength', 'validation', 'error_validation'),
					'array' => array(
						'size' => array('width', 'height')
					),
				);
				// Save all level 2 data in 'contact_fields'.
				if (!esc_attr($_POST['label'])) {
					$this->set_navigation('contact_field');
					return $this->error(__('You must enter a field name.', THEME_NAME)); 
				}
				if (!($name = esc_attr($_POST['key']))) {
					$this->set_navigation('contact_field');
					return $this->error(__('You must specify a unique key.', THEME_NAME)); 
				}
				$name = sanitize_title($name);
				$_POST['key'] = $name; // replace value with sanitized version
				$_POST['index'] = $name;
			}
			
		}
			
		// Must force some values when default page has options. This is becuase there are no query string vars to pull from.
		if ( $this->navigation == 'options' || !$this->navigation ) {
			
			if (isset($this->keys[0]) && ($this->keys[0] == '_plugin_saved')) {
				// importing data... do not override keys
			} else {
				$verifyData = $this->get_val('options', '_plugin'); // has the page been saved before, ever?
				if (empty($verifyData) && $this->action != 'save') { 
					$this->action = 'add';
					$this->keys = array('_plugin', $this->add_key);
				} else {
					$this->keys = array('_plugin', 'options');
				}
			}

			$this->action_keys[2] = isset($this->action_keys[2])? $this->action_keys[2] : '';
			if ($this->action == 'save' && $this->action_keys[2] != 'contact_fields') {

				// If a saved data file was just imported... Set the import_key to match the saved version_key
				if ($_POST['originating_keys'] == "_plugin_saved,options") {
					$_POST['import_key'] = $this->get_val('version_key', $_POST['originating_keys']);
				}
				
				// Set array index name
				$_POST['index'] = 'options';

			} else {
				/* nothing */
			}
		}
			
		// If all is OK
		return true;
		
	}
	
	function load_objects() {
		global $theme_settings;		
		$this->data = $theme_settings->load_objects();
		return $this->data;
	}

}
?>