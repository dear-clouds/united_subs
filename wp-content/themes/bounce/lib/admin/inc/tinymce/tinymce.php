<?php

class add_gp_button {
	
	var $pluginname = 'gp_shortcode';
	var $path = '';
	var $internalVersion = 100;
	
	function add_gp_button()  {
		
		// Set path to editor_plugin.js
		$this->path = get_template_directory_uri() . '/lib/admin/inc/tinymce/';	
		
		// Modify the version when tinyMCE plugins are changed.
		add_filter('tiny_mce_version', array (&$this, 'gp_change_tinymce_version'));

		// init process for button control
		add_action('init', array (&$this, 'addbuttons'));
	}
	
	function addbuttons() {
		global $page_handle;
	
		// Don't bother doing this stuff if the current user lacks permissions
		if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) 
			return;
		
		// Add only in Rich Editor mode
		if(get_user_option('rich_editing') == 'true') {		 
			$svr_uri = $_SERVER['REQUEST_URI'];
			if(strstr($svr_uri, 'post.php') OR strstr($svr_uri, 'post-new.php') OR strstr($svr_uri, 'page.php') OR strstr($svr_uri, 'page-new.php') OR strstr($svr_uri, $page_handle)) {
				add_filter('mce_external_plugins', array(&$this, 'gp_add_tinymce_plugin'), 5);
				add_filter('mce_buttons', array(&$this, 'gp_register_button'), 5);
			}
		}
	}
	
	function gp_register_button($buttons) {
		array_push($buttons, 'separator', $this->pluginname);
		return $buttons;
	}
	
	function gp_add_tinymce_plugin($plugin_array) {		
		$plugin_array[$this->pluginname] =  $this->path . 'editor_plugin.js';		
		return $plugin_array;
	}
	
	function gp_change_tinymce_version($version) {
		$version = $version + $this->internalVersion;
		return $version;
	}
	
}

$tinymce_button = new add_gp_button();

?>