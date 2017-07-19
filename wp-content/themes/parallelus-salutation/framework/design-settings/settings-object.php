<?php

class design_admin_object extends framework_admin_object_ambassador_1 {

	// Add hooks & crooks
	function add_actions() {
		
		//include JS for drag and drop layout manager (cutsom jquery UI)
		add_action('admin_print_scripts-' . $this->parent_menu . '_page_' . $this->slug, array(&$this, 'load_admin_js'));
		
	}

	function after_settings_init() {
		/* nothing */
  	}

	function validate_sumbission() {
		
		$index = 'design_setting';
		$navigation = $index . 's';
		
		// Save settings - setup
		if ($this->navigation == $navigation) {
			// check for post back "submit" action
			if (!$_POST) return false;
			// Set the index
			$_POST['index'] = $index; //'design_setting';
		}

		// Check for data, if none load the defaults (only necessary for admin home screen)
		$verifyData = $this->get_val($index, '_plugin'); // has the page been saved before, ever?
		if (empty($verifyData) && $this->action != 'save') { 
			// no data saved and we're not saving now so... load default data
			$this->action = 'add';
			$this->keys = array('_plugin', $this->add_key);
		} else {
			// otherwise, set the key to the default (for admin home)
			$this->keys = array('_plugin', $index);
		}

		// If all is OK
		return true;
		
	}
	
	function load_objects() {
		global $design_settings;		
		$this->data = $design_settings->load_objects();
		return $this->data;
	}

	function load_admin_js() {
		/* nothing */
	} 

}
?>