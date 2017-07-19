<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class rhc_event_template_metabox {
 	var $uid=0;
	var $post_type;
	var $debug=false;
	function __construct($post_type='rhcevents',$debug=false){
		$this->debug = $debug;
		if(!class_exists('post_meta_boxes'))
			require_once('class.post_meta_boxes.php');		
		$this->post_type = $post_type;
		$this->metabox_meta_fields = array("_wp_page_template");
		$this->post_meta_boxes = new post_meta_boxes(array(
			'post_type'=>$post_type,
			'options'=>$this->metaboxes(),
			'styles'=>array(),
			'scripts'=>array(),
			'metabox_meta_fields' =>  'event_meta_fields',
			'pluginpath'=>RHC_PATH
		));
		$this->post_meta_boxes->save_fields = $this->metabox_meta_fields;	
	}	
	function metaboxes($t=array()){
		$i = count($t);
		//------------------------------
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-page-template'; 
		$t[$i]->label 		= __('Template','rhc');
		$t[$i]->right_label	= __('Template','rhc');
		$t[$i]->page_title	= __('Template','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->context		= 'side';
		$t[$i]->options = array(
			(object)array(
				'id'=>'_wp_page_template',
				'type'=>'callback',
				'callback'=> array(&$this,'body')
			),
			(object)array(
				'type'=>'clear'
			)
		);
		//------------------------------
		return $t;
	}		
	function body(){
		global $post;
		if ( 0 != count( get_page_templates() ) ) {
		//$template = !empty($post->page_template) ? $post->page_template : false;
		$template = get_post_meta($post->ID,'_wp_page_template',true);
		$template = ''==trim($template)?false:$template;
		?>
<p><strong><?php _e('Template','rhc') ?></strong></p>
<label class="screen-reader-text" for="page_template"><?php _e('Page Template','rhc') ?></label><select name="_wp_page_template" id="_wp_page_template">
<option value='default'><?php _e('Default Template','rhc'); ?></option>
<?php page_template_dropdown($template); ?>
</select>
<?php
		}
	}
}

?>