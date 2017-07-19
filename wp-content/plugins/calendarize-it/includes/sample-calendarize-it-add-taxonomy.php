<?php


 
add_filter('rhc-taxonomies','add_custom_taxonomy_to_event_post_type',10,1);
function add_custom_taxonomy_to_event_post_type($taxonomies){
	$taxonomies['show_type'] = __('Show type','rhc');
	return $taxonomies;
} 
 
add_action('rhcevents_init','add_custom_taxonomy_to_calendarize_it');
function add_custom_taxonomy_to_calendarize_it(){
	$labels = array(
				'name' 				=> _x( 'Show types', 'taxonomy general name' ),
				'singular_name' 	=> _x( 'Show type', 'taxonomy singular name' ),
				'search_items' 		=>  __( 'Search Show types' ),
				'popular_items' 	=> __( 'Popular Show types' ),
				'all_items' 		=> __( 'All show types' ),
				'parent_item' 		=> null,
				'parent_item_colon' => null,
				'edit_item' 		=> __( 'Edit show type' ), 
				'update_item' 		=> __( 'Update show type' ),
				'add_new_item' 		=> __( 'Add show type' ),
				'new_item_name' 	=> __( 'New show type' )
			);
	
	new custom_taxonomy_with_meta(
		'show_type',
		array(RHC_EVENTS),
		array(
	    	'hierarchical' => true,
	    	'labels' => $labels,
	    	'show_ui' => true,
	    	'query_var' => true,
	    	'rewrite' => array( 'slug' => 'show-type' ),
			'capabilities'	=> array(
				'manage_terms'	=> 'calendarize_author',
				'edit_terms'	=> 'calendarize_author',
				'delete_terms'	=> 'calendarize_author',
				'assign_terms'	=> 'calendarize_author'
			)
		),
		array(),
		RHC_PATH
	);
}
?>