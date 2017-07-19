<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhc_archive_layout_settings {
	function __construct($plugin_id='rhc'){
		//$this->id = $plugin_id.'-log';
		$this->id = $plugin_id;
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);
	}
	function options($t){
		$i = count($t);
		//-------------------------		
		$i = count($t);
		$t[$i]->id 			= 'rhc-archive-layout'; 
		$t[$i]->label 		= __('Archive/Blog layout settings','rhc');
		$t[$i]->right_label	= __('Modify the layout of events in the archive','rhc');
		$t[$i]->page_title	= __('Archive/Blog layout settings','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'use_archive_content_filter',
				'label'		=> __('Use built-in archive content filter','wlb'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'description'=>  sprintf(__('Choose %s if you would prefer the theme to render the content of events in an archive.','wlb'),__('No','wlb')),
				'el_properties'	=> array(),
				'hidegroup'	=> '#archive_group',
				'save_option'=>true,
				'load_option'=>true
				),			
			(object)array(
				'type'=>'clear'
			),	
			(object)array(
				'id'	=> 'archive_group',
				'type'=>'div_start'
			),	
			(object)array(
				'id'			=> 'rhc-archive-layout',
				'type' 			=> 'textarea',
				'label'			=> __('Archive content template','rhc'),
				'el_properties' => array('rows'=>'15','cols'=>'50'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array('type'	=> 'div_end')
		);
	
		//-------------------------		
				
		return $t;
	}
}
?>