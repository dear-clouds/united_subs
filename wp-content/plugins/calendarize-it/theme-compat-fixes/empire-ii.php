<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class rhc_theme_fixes {
	function __construct(){
		add_action('wp_footer', array(&$this,'wp_footer'), 10);
	}
	
	function wp_footer(){
		global $rhc_plugin; 
		include $rhc_plugin->get_template_path('calendar_item_tooltip.php');	
		wp_print_scripts('rhc_gmap3');	
?>
<script>jQuery(document).on('page_is_open',function(e){init_rhc();});</script>
<?php	
	}
}

new rhc_theme_fixes();
?>