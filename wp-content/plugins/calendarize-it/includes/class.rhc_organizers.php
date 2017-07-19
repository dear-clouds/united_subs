<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
 
 
if(defined('RHC_PATH')):

function organizer_html_description_input($tab,$i,$o,$r){
	ob_start();
	wp_editor($r->get_value($tab,$i,$o),$r->get_id($tab,$i,$o),array(
		'textarea_name' => $r->get_name($tab,$i,$o)
	));
	
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
} 
		//-- Organizers --------------------------------------
		//-- included by class.righthere_calendar.php
		require 'organizer_meta_fields.php';  	    
		$fields = apply_filters('rhc_organizer_meta',$fields);
		$labels = array(
					'name' 				=> __( 'Organizers', 'rhc' ),
					'singular_name' 	=> __( 'Organizer', 'rhc' ),
					'search_items' 		=> __( 'Search Organizer' , 'rhc'),
					'popular_items' 	=> __( 'Popular Organizers' , 'rhc'),
					'all_items' 		=> __( 'All organizers' , 'rhc'),
					'parent_item' 		=> null,
					'parent_item_colon' => null,
					'edit_item' 		=> __( 'Edit Organizer' , 'rhc' ), 
					'update_item' 		=> __( 'Update Organizer' , 'rhc' ),
					'add_new_item' 		=> __( 'Add Organizer' , 'rhc' ),
					'new_item_name' 	=> __( 'New Organizer' , 'rhc' )
				);
		global $rhc_plugin;
		new custom_taxonomy_with_meta(
			RHC_ORGANIZER,
			array(RHC_EVENTS),
			array(
		    	'hierarchical' => true,
		    	'labels' => $labels,
		    	'show_ui' => true,
		    	'query_var' => true,
		    	'rewrite' => array( 'slug' => $rhc_plugin->get_option('rhc-organizers-slug',RHC_ORGANIZER,true) ),
				'capabilities'	=> array(
					'manage_terms'	=> 'manage_'.RHC_ORGANIZER,
					'edit_terms'	=> 'manage_'.RHC_ORGANIZER,
					'delete_terms'	=> 'manage_'.RHC_ORGANIZER,
					'assign_terms'	=> 'manage_'.RHC_ORGANIZER
				)
			),
			$fields, //defined at organizer_meta_fields.php
			RHC_PATH
		);		
endif;		

// add tax meta fields to post info metabox
function filter_organizer_taxonomy_meta_field($meta_fields){
	$meta_fields = is_array($meta_fields)?$meta_fields:array();	
	require 'organizer_meta_fields.php'; 
	return array_merge($meta_fields,$fields);
}
add_filter( RHC_ORGANIZER.'_taxonomy_meta_fields','filter_organizer_taxonomy_meta_field',10,1);
?>