<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Woffice_Maintenance extends FW_Extension {

	/**
	 * @internal
	 */
	public function _init() {
	
		add_action('fw_extensions_after_activation', array($this, 'woffice_maintenance_create_page'));
		add_action('fw_extensions_before_deactivation', array($this, 'woffice_maintenance_delete_page'));
		
	}
	
	/**
	 * We create the Maintenance page on the extension activation 
	 */ 
	public function woffice_maintenance_create_page($extensions) {
		
		/* ONLY IF IT's the Maintenance extension */
		if (!isset($extensions['woffice-maintenance'])) {
	        return;
	    }
		
		/* We check if the page already exist and if not then we create it */
		global $wpdb;
		$table_name = $wpdb->prefix . 'posts';
		$check_page = $wpdb->get_row("SELECT post_name FROM ".$table_name." WHERE post_name = 'maintenance'", 'ARRAY_A');
		if(empty($check_page)) {
		    $prop_page = array(
				'ID' 			=> '',
				'post_title'    => 'Maintenance',
				'post_content'  => 'No need for content, all is in the Extension settings, the title does not matter too.', 
				'post_excerpt'  => '',
				'post_name' => 'maintenance',
				'post_type' 	=> 'page',
				'post_status'   => 'publish',
				'post_author'   => 1
			);
			wp_insert_post($prop_page);
		}
		
	}	 
	
	/**
	 * We delete the page if the extension is not activated
	 */	
	public function woffice_maintenance_delete_page($extensions) {
	
	    /* ONLY IF IT's the Maintenance extension */
		if (!isset($extensions['woffice-maintenance'])) {
	        return;
	    }
	    
		/* We find the maintenance page ID */
		$page = get_page_by_title( 'Maintenance' );
		$ID_page = $page->ID;
		/* We delete it */
		if (!empty($ID_page)) {
			wp_delete_post($ID_page); 
		}
		
	}
	
	
	
		
}

