<?php

class slideshow_admin_object extends framework_admin_object_ambassador_1 {

	// Add hooks & crooks
	function add_actions() {
		
		//include JS (from "load_admin_js" function at end of page)
		add_action('admin_print_scripts-' . $this->parent_menu . '_page_' . $this->slug, array(&$this, 'load_admin_js'));
		
	}

	function after_settings_init() {
		/* nothing */
  	}

	function validate_sumbission() {

		
		// Slideshows
		if ($this->navigation == 'slideshows') {
			if (!$_POST) return false;
			$this->fields = array(
				'var' => array('label', 'key', 'width', 'height', 'timing', 'transition', 'speed', 'pause_on_hover', 'columns'),
				'array' => array('slides_1', 'slides_2', 'slides_3', 'slides_4')
			);
			// Save data in 'design => layouts' (set by keys)
			if (!esc_attr($_POST['label'])) {
				$this->set_navigation('slideshow');
				return $this->error(__('You must enter a name.', THEME_NAME)); 
			}
			if (!($id = esc_attr($_POST['key']))) {
				// No key/ID specified so we'll create it from the title. Could get messy if generated ID exists, it will overwrite existing slide show. 
				// You can uncomment section below to return to the page and force the user to add an ID manually.
				$id = sanitize_title($_POST['label']); 
				
				// Error: No ID specified, return to the page and give error
				//$this->set_navigation('slideshow');
				//return $this->error(__('You must specify a unique key.', THEME_NAME)); 
			}
						
			$id = sanitize_title($id);
			$_POST['key'] = $id; // replace value with sanitized version
			$_POST['index'] = $id;
		}
		
		// Add/Edit Slide
		if ($this->navigation == 'slide' && $this->action == 'add') {

			// Default field values for a new slide
			$this->default = array('target_blank' => '0', 'format' => 'image', 'position' => 'left', 'transition' => '');
	
		}
		
		if ($this->navigation == 'slideshow') {
			
			// This case means we're adding a new slideshow
			if ($this->action == 'add') {
				
				// Set default field values
				$this->default = array('timing' => '6', 'transition' => 'fade', 'pause_on_hover' => '0', 'columns' => '1');
				
		
			// The alternative (else) is that we're saving a slide for the current slide show.	
			} else {
				
				// we want to ignore the test for !$_POST if we are moving a slide position (or it will fail)
				if ($this->action != 'move' && $this->action != 'delete') {
					
					// Check if we have a postback event, if so we are doing a save/add
					if (!$_POST) return false;

					$this->fields = array(
						'var' => array('key', 'media', 'link', 'target_blank', 'format', 'position', 'transition', 'content'),
						'array' => array()
					);

					// no keys or indexes for slides. Auto-generate and stored in hidden fields.
					if (!$_POST['key']) { 
						$_POST['key'] = base_convert(microtime(), 10, 36);
					}
					$_POST['index'] = $_POST['key'];
					
				}
			}
		}


		// If all is OK
		return true;
		
	}
	
	function load_objects() {
		global $slideshow_settings;		
		$this->data = $slideshow_settings->load_objects();
		return $this->data;
	}

	function load_admin_js() {
		/* none */
	} 

}
?>