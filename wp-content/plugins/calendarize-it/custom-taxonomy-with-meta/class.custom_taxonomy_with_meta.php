<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 * Author: Alberto Lau (Righthere.com)
 **/


class custom_taxonomy_with_meta {
	var $taxonomy;
	var $meta = array();
	var $pluginpath = '';
	function __construct ($taxonomy, $object_type, $args = array(), $meta = array(), $pluginpath=''){
		  $this->pluginpath = $pluginpath;
		  $this->taxonomy = $taxonomy;
		  $this->meta = apply_filters("$taxonomy-meta",$meta);
		  $args = apply_filters("rhc_register_taxonomy",$args,$taxonomy,$object_type,$meta,$pluginpath);
		  if( !taxonomy_exists($taxonomy) )  // allow to just bind metafields to registered taxnomy.
		  	register_taxonomy($taxonomy, apply_filters("$taxonomy-object-type",$taxonomy,$object_type),$args);	 

			
		if(is_admin())$this->admin_init();
	}
	
	function admin_init(){
		//head
		add_action('admin_head-edit-tags.php',array(&$this,'head'));
		
		//ADD form
		add_action($this->taxonomy . '_add_form_fields', array(&$this,'new_taxonomy_meta_form'), 10, 1);//do_action($taxonomy . '_add_form_fields', $taxonomy);	
		//ADD save
		add_action("created_".$this->taxonomy,array(&$this,'handle_new_taxonomy_save'),10,2);	
		
		//EDIT form
		add_action($this->taxonomy . '_edit_form_fields', array(&$this,'edit_taxonomy_meta_form'), 10, 2);// do_action($taxonomy . '_edit_form_fields', $tag, $taxonomy);
		//EDIT save
		add_action("edited_{$this->taxonomy}",array(&$this,'handle_new_taxonomy_save'),10,2);//do_action("edited_$taxonomy", $term_id, $tt_id);
		
		//DELETE save (Remove metadata when custom tax is deleted)
		add_action("delete_{$this->taxonomy}",array(&$this,'handle_delete_taxonomy_term'),10,2); //do_action("delete_$taxonomy", $term, $tt_id);
	}
	
	function handle_delete_taxonomy_term($term, $tt_id){
		require_once "taxonomy-metadata.php";
		$meta_to_remove = get_term_meta($term, '');
		if(is_array($meta_to_remove)&&count($meta_to_remove)>0){
			foreach($meta_to_remove as $meta_key => $meta){
				delete_term_meta($term, $meta_key);
			}		
		}
	}
		
	function handle_new_taxonomy_save($term_id, $tt_id){
		require_once "taxonomy-metadata.php";
		$new_meta = isset($_POST["{$this->taxonomy}_meta"])&&is_array($_POST["{$this->taxonomy}_meta"])?$_POST["{$this->taxonomy}_meta"]:false;
		if(false!==$new_meta){
			foreach($new_meta as $meta_key => $meta_value){
				update_term_meta($term_id, $meta_key, $meta_value);
			}
		}
	}
	
	function head(){
		global $tax;
		if(!is_object($tax)||!property_exists($tax,'name')||$tax->name!=$this->taxonomy)return;
		require_once "class.custom_taxonomy_with_meta_head.php";
		new custom_taxonomy_with_meta_head($this->meta);
	}
	
	function new_taxonomy_meta_form($taxonomy){
		require_once "class.custom_taxonomy_with_meta_body.php";
		new custom_taxonomy_with_meta_body($taxonomy,$this->meta,array('pluginpath'=>$this->pluginpath));
	}
	
	function edit_taxonomy_meta_form($tag,$taxonomy){
		require_once "class.custom_taxonomy_with_meta_body.php";
		new custom_taxonomy_with_meta_body(
			$taxonomy,
			$this->meta,
			array(
				'template'				=> '<tr class="form-field {required} {class}"><th scope="row" valign="top">{label}</th><td>{input}<br />{description}</td></tr>',
				'template_checkbox'		=> '<tr class="form-field-chk {required} {class}"><th scope="row" valign="top">&nbsp;</th><td>{input}</td></tr>',
				'description_template'	=> '<span class="description">%s</span>',
				'term_id'				=> property_exists($tag,'term_id')?$tag->term_id:false,
				'subtitle_template'		=> '<tr class="form-field"><th scope="row" valign="top"><h3>%s</h3></th></tr>',
				'pluginpath'			=> $this->pluginpath
			)
		);
	}
}
 
?>