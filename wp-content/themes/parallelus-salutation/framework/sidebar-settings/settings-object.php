<?php

class sidebar_admin_object extends framework_admin_object_ambassador_1 {

	// Add hooks & crooks
	function add_actions() {
		
		//include JS (from "load_admin_js" function at end of page)
		add_action('admin_print_scripts-' . $this->parent_menu . '_page_' . $this->slug, array(&$this, 'load_admin_js'));
		
	}

	function after_settings_init() {
		/* nothing */
  	}

	function validate_sumbission() {

		// Sidebars
		if ($this->navigation == 'sidebars') {
			if (!$_POST) return false;
			$this->fields = array(
				'var' => array('label', 'alias', 'key'),
				'array' => array()
			);
			// Validate fields
			if (!esc_attr($_POST['label'])) {
				$this->set_navigation('sidebar');
				return $this->error(__('You must enter a title.', THEME_NAME)); 
			}
			if (!esc_attr($_POST['alias'])) {
				$_POST['alias'] = $_POST['label'];
			}
									
			// No keys or indexes for this type. Auto-generate and stored in hidden fields.
			// Unique keys are important, otherwise a reference to this item could fail if the title is used as the key and it gets changed. 
			if (!$_POST['key']) { 
				$_POST['key'] = base_convert(microtime(), 10, 36);
			}
			$_POST['alias'] = sanitize_title($_POST['alias']);
			$_POST['index'] = $_POST['key'];

		}

		// Tabs
		if ($this->navigation == 'tabs') {
			if (!$_POST) return false;
			$this->fields = array(
				'var' => array('label', 'class', 'conditions', 'bg_color', 'alias', 'key'),
				'array' => array()
			);
			// Validate fields
			if (!esc_attr($_POST['label'])) {
				$this->set_navigation('tab');
				return $this->error(__('You must enter a title.', THEME_NAME)); 
			}
			if (!esc_attr($_POST['alias'])) {
				$_POST['alias'] = $_POST['label'];
			}
									
			// No keys or indexes for this type. Auto-generate and stored in hidden fields.
			// Unique keys are important, otherwise a reference to this item could fail if the title is used as the key and it gets changed. 
			if (!$_POST['key']) { 
				$_POST['key'] = base_convert(microtime(), 10, 36);
				$_POST['alias'] = $_POST['key'];  // sidebars need the alias field
			}
			//$_POST['alias'] = sanitize_title($_POST['alias']);
			$_POST['index'] = $_POST['key'];

		}

		// If all is OK
		return true;
		
	}
	
	function load_objects() {
		global $sidebar_settings;		
		$this->data = $sidebar_settings->load_objects();
		return $this->data;
	}

	function load_admin_js() {
		/* none */		
	} 

}
?>