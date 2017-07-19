<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class debug_calendarize {
	function __construct($menu_parent_id,$capability='administrator'){
		$this->option_menu_parent = $menu_parent_id;
		$this->capability = $capability;
		add_action('admin_menu',array(&$this,'admin_menu'));
	}
	
	function admin_menu(){
		$page_id = add_submenu_page( $this->option_menu_parent, __('Debug','rhc') ,__('Debug','rhc'),$this->capability,'rhc-debug',array(&$this,'body'));
		add_action( 'admin_head-'. $page_id, array(&$this,'head') );	
	}
	
	function head(){
	
	}
	
	function body(){
		include "debug.php";
	}
}
 

?>