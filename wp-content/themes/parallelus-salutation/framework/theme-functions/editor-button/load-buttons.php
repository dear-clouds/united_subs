<?php
class add_theme_button {
	
	var $pluginname = 'theme_shortcode';
	var $path = '';
	var $internalVersion = 100;
	
	// Add triggers into WordPress 
	function add_theme_button()  {
		
		// Set path to editor_plugin.js
		$this->path = FRAMEWORK_URL . 'theme-functions/editor-button/';	
		
		// Modify the version when tinyMCE plugins are changed.
		add_filter('tiny_mce_version', array (&$this, 'change_tinymce_version') );

		// init process for button control
		add_action('init', array (&$this, 'addbuttons') );
	}
	
	// Add button for current page/post
	function addbuttons() {
		global $page_handle;
	
		// Check user permissions
		if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) 
			return;
		
		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
		 
			$svr_uri = $_SERVER['REQUEST_URI'];
			if ( strpos(strtolower($svr_uri), 'post.php', 0 ) || strpos(strtolower($svr_uri), 'post-new.php', 0 ) || strpos(strtolower($svr_uri), 'page.php', 0 ) || strpos(strtolower($svr_uri), 'page-new.php', 0 ) || strpos(strtolower($svr_uri), $page_handle, 0 ) ) {
				add_filter("mce_external_plugins", array (&$this, 'add_tinymce_plugin' ), 5);
				add_filter('mce_buttons', array (&$this, 'register_button' ), 5);
				add_filter('mce_external_languages', array (&$this, 'add_tinymce_langs_path'));
			}
		}
	}
	
	// Register button
	function register_button($buttons) {
		array_push($buttons, 'separator', $this->pluginname );
		return $buttons;
	}
	
	// Add plugin to tinymce 
	function add_tinymce_plugin($plugin_array) {
		global $page_handle;
		$svr_uri = $_SERVER['REQUEST_URI'];
		
		if(isset($_GET['post_type'])) {
			$post_type_get = $_GET['post_type'];
		}
		$post_id = $_GET['post'];
		$post = get_post($post_id);
		$post_type = $post->post_type;
		
		//if($post_type == 'page' || $post_type_get == 'page' || strstr($svr_uri, $page_handle) ){
			$plugin_array[$this->pluginname] =  $this->path . 'editor_plugin_page.js';
		//}
		
		//if($post_type == 'post'){
		//	$plugin_array[$this->pluginname] =  $this->path . 'editor_plugin_post.js';
		//}
		
		return $plugin_array;
	}
	
	// Load the tinymce language file	
	function add_tinymce_langs_path($plugin_array) {
		$plugin_array[$this->pluginname] =  $this->path . 'langs.php';
		return $plugin_array;
	}
	
	// Update tinymce version
	function change_tinymce_version($version) {
			$version = $version + $this->internalVersion;
		return $version;
	}
	
}

$tinymce_button = new add_theme_button();

?>