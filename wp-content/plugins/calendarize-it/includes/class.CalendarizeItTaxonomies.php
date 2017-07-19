<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class CalendarizeItTaxonomies {
	var $post_type;
	var $capability;
	var $rhc_path;
	var $taxonomy;
	var $slug='';
	var $hierarchical=true;
	var $singular_label;
	var $plural_label;
	var $labels=array();
	function __construct($args=array(),$labels=array()){
		//------------
		//should be instanced from the plugins_loaded hook
		//------------
		$defaults = array(
			'post_type'			=> RHC_EVENTS,
			'capability'		=> 'calendarize_author',
			'rhc_path'			=> RHC_PATH,
			'taxonomy'			=> 'course',
			'slug'				=> '',
			'hierarchical'		=> true,
			'singular_label'	=> __('Course','rhc'),
			'plural_label'		=> __('Courses','rhc')
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
		$default_labels = array(
			'name' 				=> $this->plural_label,
			'singular_name' 	=> $this->singular_label,
			'search_items' 		=> sprintf( __( 'Search %s','rhc' ),$this->plural_label),
			'popular_items' 	=> sprintf(__( 'Popular %s','rhc' ),$this->plural_label),
			'all_items' 		=> sprintf(__( 'All %s','rhc' ),$this->plural_label),
			'parent_item' 		=> null,
			'parent_item_colon' => null,
			'edit_item' 		=> sprintf(__( 'Edit %s','rhc' ),$this->singular_label), 
			'update_item' 		=> sprintf(__( 'Update %s','rhc' ),$this->singular_label),
			'add_new_item' 		=> sprintf(__( 'Add %s','rhc' ),$this->singular_label),
			'new_item_name' 	=> sprintf(__( 'New %s','rhc' ),$this->singular_label)
		);
		foreach($default_labels as $id => $default){
			$this->labels[$id] = isset($labels[$id])?$labels[$id]:$default;
		}		
		//-----------
		add_filter('rhc-taxonomies',array(&$this,'add_custom_taxonomy_to_event_post_type'),10,1);	
		add_action('rhcevents_init',array(&$this,'add_custom_taxonomy_to_calendarize_it'));		
	}
	
	function add_custom_taxonomy_to_event_post_type($taxonomies){
		$taxonomies[$this->taxonomy] = $this->labels['singular_name'];
		return $taxonomies;
	} 
	
	function add_custom_taxonomy_to_calendarize_it(){
		if(!class_exists('custom_taxonomy_with_meta'))return;
		new custom_taxonomy_with_meta(
			$this->taxonomy,
			array($this->post_type),
			array(
		    	'hierarchical' => $this->hierarchical,
		    	'labels' => $this->labels,
		    	'show_ui' => true,
		    	'query_var' => true,
		    	'rewrite' => array( 'slug' => ($this->slug==''?$this->taxonomy:$this->slug) ),
				'capabilities'	=> array(
					'manage_terms'	=> $this->capability,
					'edit_terms'	=> $this->capability,
					'delete_terms'	=> $this->capability,
					'assign_terms'	=> $this->capability
				)
			),
			apply_filters('rhc_'.$this->taxonomy.'_meta',array()),
			$this->rhc_path
		);
	}	
}

?>