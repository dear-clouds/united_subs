<?php

/**
 * Not used anymore, will be removed. 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class load_event_template {
	function __construct(){
		add_action('wp_head',array(&$this,'wp_head'));
	}
	function wp_head(){
		global $rhc_plugin; 
		$value = $rhc_plugin->get_option('rhc-list-layout');
		
		if(''==trim($value)){
			ob_start();	
			include $rhc_plugin->get_template_path('event_list_content.php');		
			$value = ob_get_contents();
			ob_end_clean();
		}
?>
<script type="text/javascript">
var rhc_event_tpl = <?php echo json_encode($value)?>;
</script>
<?php		
	}

}
?>