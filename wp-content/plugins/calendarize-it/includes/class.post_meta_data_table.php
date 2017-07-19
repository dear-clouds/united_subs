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
		$labels = array(
				    'name' 			=> _x( 'Calendar', 'taxonomy general name' ),
				    'singular_name' => _x( 'Calendar', 'taxonomy singular name' ),
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
		    	'rewrite' => array( 'slug' => $rhc_plugin->get_option('rhc-calendar-slug',RHC_CALENDAR) )
			),
			array(),
			RHC_PATH
		);
endif;		
?>