<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
if(defined('RHC_PATH')):
		//-- included by class.righthere_calendar.php
		//-- Calendar
		
		$fields = apply_filters('rhc_calendar_meta',array());
		
		$labels = array(
				    'name' 			=> __( 'Calendars', 'rhc' ),
				    'singular_name' => __( 'Calendar', 'rhc' ),
				    'search_items' 	=>  __( 'Search Calendar','rhc' ),
				    'popular_items' => __( 'Popular Calendar','rhc' ),
				    'all_items' => __( 'All calendars', 'rhc' ),
				    'parent_item' => null,
				    'parent_item_colon' => null,
				    'edit_item' => __( 'Edit calendar','rhc' ), 
				    'update_item' => __( 'Update calendar','rhc' ),
				    'add_new_item' => __( 'Add calendar','rhc' ),
				    'new_item_name' => __( 'New calendar','rhc' ),
				  );
		global $rhc_plugin;		  
		new custom_taxonomy_with_meta(
			RHC_CALENDAR,
			array(RHC_EVENTS),
			array(
		    	'hierarchical' => true,
		    	'labels' => $labels,
		    	'show_ui' => true,
		    	'query_var' => true,
		    	'rewrite' => array( 'slug' => $rhc_plugin->get_option('rhc-calendar-slug', RHC_CALENDAR, true) ),
				'capabilities'	=> array(
					'manage_terms'	=> 'manage_'.RHC_CALENDAR,
					'edit_terms'	=> 'manage_'.RHC_CALENDAR,
					'delete_terms'	=> 'manage_'.RHC_CALENDAR,
					'assign_terms'	=> 'manage_'.RHC_CALENDAR
				)
			),
			$fields,
			RHC_PATH
		);
endif;		
?>