<?php
/*
* Shortcode generator
*/

class KElementsTiny {

	function __construct()
	{
		add_action('admin_init', array(&$this, 'init'));
	}
	
	/**
	 * Registers TinyMCE rich editor button
	 *
	 * @return	void
	 */
	function init()
	{
		
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}
		
		/**
	 * Enqueue Scripts and Styles
	 */
		
		$wp_version = floatval(get_bloginfo('version'));
		
		$shortcodes = array();	
		$shortcodes = apply_filters('kleo_tinymce_shortcodes',$shortcodes);
			
		$localize = array(
				'plugin_folder' => K_ELEM_PLUGIN_URL.'/admin',
				'shortcodes' => $shortcodes
		);

		if ( $wp_version >= "3.6" ) {
			wp_localize_script( 'jquery-core', 'KleoShortcodes', $localize );
		}
		else
		{
			wp_localize_script( 'jquery', 'KleoShortcodes', $localize );
		}
		
	}
    
	// --------------------------------------------------------------------------
	

	
	
	/**
	 * Define TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array )
	{
		$plugin_array['kleoShortcodes'] = K_ELEM_PLUGIN_URL . '/admin/tinymce/plugin.js';
		return $plugin_array;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons )
	{
		array_push( $buttons, 'kleo_button' );
		return $buttons;
	}
    
}
$k_elements_tiny = new KElementsTiny();

?>
