<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class post_type_calendar {
	function __construct($post_type='rhcevents',$args=array()){
		$defaults = array(
			'page_title'			=> __('Calendar','pop'),
			'menu_text'				=> __('Calendar','pop'),
			'capability'			=> sprintf("calendarize_%s",$post_type),
			'menu_id'				=> sprintf("calendarize_%s",$post_type),
			'option_menu_parent'	=> sprintf('edit.php?post_type=%s',$post_type),
			'menu_priority'			=> 1
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//----	
		add_action('admin_menu',array(&$this,'admin_menu'),$this->menu_priority);
	}
	
	function admin_menu(){	
		$page_id = add_submenu_page( $this->option_menu_parent,$this->page_title ,$this->menu_text,$this->capability,$this->menu_id,array(&$this,'body'));
		add_action( 'admin_head-'. $page_id, array(&$this,'head') );
	}
	
	function head(){
	
	}
	
	function body(){
		echo sprintf('<div id="calendarize" class="calendarize"></div>');
	}
}
?>