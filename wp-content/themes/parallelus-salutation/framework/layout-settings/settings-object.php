<?php

class layout_admin_object extends framework_admin_object_ambassador_1 {

	// Add hooks & crooks
	function add_actions() {
		
		//include JS for drag and drop layout manager (cutsom jquery UI)
		add_action('admin_print_scripts-' . $this->parent_menu . '_page_' . $this->slug, array(&$this, 'load_admin_js'));
		
	}

	function after_settings_init() {
		/* nothing */
  	}

	function validate_sumbission() {

		// Design defaults
		if ($this->navigation == 'layout_settings') {
			if (!$_POST) return false;

			// Default, this is so we don't duplicate
			$default_context_list = array(
				'header',
				'footer',
				'default',
				'home',
				'page',
				'post',
				'category',
				'author',
				'tag',
				'date',
				'blog',
				'search',
				'error',
				'bp',
				'bp-activity',
				'bp-blogs',
				'bp-forums',
				'bp-groups',
				'bp-groups-single',
				'bp-groups-single-plugins',
				'bp-members',
				'bp-members-single',
				'bp-members-single-plugins',
				'bbpress',
				'bbp_topic',
				'bbp_reply' );

			// The list we get from the saved global array
			$custom_context_list = $GLOBALS['master_context_list'];

			// Combine the 'manual' and 'auto' generate lists (manual added by user, auto from WP Custom Post Type object)
			
			$custom_context_list = array_merge( (array)$custom_context_list['manual'], (array)$custom_context_list['auto'] );

			if (is_array($custom_context_list)) {
				foreach ($custom_context_list as $context => $name) {
					// Skip anything that might be a duplicate of a default
					if (!in_array($context, $default_context_list)) {
						$custom_context[] = $context;
					}
				}
			}
			$fields_layout_array = array_merge( (array)$default_context_list, (array)$custom_context );

			// Assign the values to the DB array
			$this->fields = array(
				'var' => array(),
				'array' => array(
					'layout' => $fields_layout_array
				)
			);

			// Set the index
			$_POST['index'] = 'layout_settings';
		}


		// Layouts
		if ($this->navigation == 'layouts') {
			if (!$_POST) return false;
			$this->fields = array(
				'var' => array('label', 'key', 'header', 'footer', 'skin'),
				'array' => array('layout_fields')
			);
			// Save data in 'design => layouts' (set by keys)
			if (!esc_attr($_POST['label'])) {
				$this->set_navigation('layout');
				return $this->error(__('You must enter a template name.', THEME_NAME)); 
			}
			if (!($name = esc_attr($_POST['key']))) {
				$this->set_navigation('layout');
				return $this->error(__('You must specify a unique key.', THEME_NAME)); 
			}
			
			// manage the funky JS array saved in the hidden field
			parse_str($_POST['layout_fields'], $layout_fields);
			$_POST['layout_fields'] = $layout_fields;
			
			$name = sanitize_title($name);
			$_POST['key'] = $name; // replace value with sanitized version
			$_POST['index'] = $name;
		}
		
		// Page Headers - add/edit
		if ($this->navigation == 'page_header' && $this->action == 'add') {

			// Default field values for a new slide
			$this->default = array('top_container' => 'show', 'bg_glow' => 'show', 'bg_pos_x' => '0', 'bg_pos_y' => '0', 'bg_repeat' => '');
	
		}
		// Page Headers - save
		if ($this->navigation == 'page_headers') {
			if (!$_POST) return false;
			$this->fields = array(
				'var' => array('key', 'label', 'logo', 'top_sidebar', 'content', 'top_container', 'bg_color', 'bg_glow', 'background', 'bg_pos_x', 'bg_pos_y', 'bg_repeat'),
				'array' => array()
			);
			// Save data - validate
			if (!esc_attr($_POST['label'])) {
				$this->set_navigation('page_header');
				return $this->error(__('You must enter a title.', THEME_NAME)); 
			}
									
			// no keys or indexes for slides. Auto-generate and stored in hidden fields.
			// Unique keys are important, otherwise a reference to this item could fail if the title is used as the key and it gets changed. 
			if (!$_POST['key']) { 
				$_POST['key'] = base_convert(microtime(), 10, 36);
			}
			$_POST['index'] = $_POST['key'];
		}
		
		
		// Page Footers - add/edit
		if ($this->navigation == 'page_footer' && $this->action == 'add') {

			// Default field values for a new slide
			$this->default = array('bg_pos_x' => '0', 'bg_pos_y' => '0', 'bg_repeat' => '');
	
		}
		// Page Footers - save
		if ($this->navigation == 'page_footers') {
			if (!$_POST) return false;
			$this->fields = array(
				'var' => array('key', 'label', 'content', 'bg_color', 'background', 'bg_pos_x', 'bg_pos_y', 'bg_repeat'),
				'array' => array()
			);
			// Save data - validate
			if (!esc_attr($_POST['label'])) {
				$this->set_navigation('page_footer');
				return $this->error(__('You must enter a title.', THEME_NAME)); 
			}
									
			// no keys or indexes for slides. Auto-generate and stored in hidden fields.
			// Unique keys are important, otherwise a reference to this item could fail if the title is used as the key and it gets changed. 
			if (!$_POST['key']) { 
				$_POST['key'] = base_convert(microtime(), 10, 36);
			}
			$_POST['index'] = $_POST['key'];
		}

		// If all is OK
		return true;
		
	}
	
	function load_objects() {
		global $layout_settings;		
		$this->data = $layout_settings->load_objects();
		return $this->data;
	}

	function load_admin_js() {

		// JS for drag and drop layout manager
		//$js = FRAMEWORK_URL . 'js/';
		// wp_deregister_script( 'jquery-ui' );
        //wp_register_script( 'jquery-ui', $js.'jquery-ui-1.8.24.custom.min.js', array('jquery'), '1.8.24', true);
        wp_enqueue_script( 'jquery-ui' );
        wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		
	} 

}
?>