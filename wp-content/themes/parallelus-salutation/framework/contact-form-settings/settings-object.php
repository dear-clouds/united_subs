<?php

class contact_form_admin_object extends framework_admin_object_ambassador_1 {

	// Add hooks & crooks
	function add_actions() {
		
		//include JS for drag and drop layout manager (cutsom jquery UI)
		add_action('admin_print_scripts-' . $this->parent_menu . '_page_' . $this->slug, array(&$this, 'load_admin_js'));
		
	}

	function after_settings_init() {
		/* nothing */
  	}

	function validate_sumbission() {
		
		// Make sure the default data is saved first!!!
		$verifyData = $this->get_val('contact_form', '_plugin'); // has the page been saved before, ever?
		if (empty($verifyData) && $this->navigation == '') { 
			
			// no data saved and we're not saving now so... load default data
			$this->action = 'add';
			$this->keys = array('_plugin', $this->add_key);

		} else {
			

			// OK, the defaults are saved. We can now do other things.

			// Contact Fields - New (defaults)
			if ($this->navigation == 'contact_field' && $this->action == 'add') {
				$this->default = array('field_type' => 'text', 'required' => 0, 'validation' => '');
			}
			
			// Contact Fields - Save
			if ($this->navigation == 'contact_fields') {
				if (!$_POST) return false;
				$this->fields = array(
					'var' => array('label', 'key', 'caption', 'field_type', 'values', 'required', 'error_required', 'minlength', 'maxlength', 'validation', 'error_validation'),
					'array' => array(
						'size' => array('width', 'height')
					)
				);
				// Validate fields
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
	
	
			// Default options - Save
			if ($this->navigation == 'contact_form_settings') {
				if (!$_POST) return false;
				$this->fields = array(
					'var' => array(	'to', 'subject', 'thankyou', 'button', 'captcha'),
					'array' => array()
				);
				if (!esc_attr($_POST['to'])) {
						$this->set_navigation('contact_form');
						return $this->error(__('You must enter an email address.', THEME_NAME)); 
					}
				
				// Set the index
				$_POST['index'] = 'contact_form';
				
			}
		}

		// If all is OK
		return true;
		
	}
	
	function load_objects() {
		global $contact_form_settings;		
		$this->data = $contact_form_settings->load_objects();
		return $this->data;
	}

	function load_admin_js() {
		/* nothing */
	} 

}
?>