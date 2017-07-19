<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class post_meta_boxes {
	var $post_type;
	var $save_fields = array();
	var $capability = 'post';
	var $save_post_done = false;
	function __construct($args=array()){		
		$defaults = array(
			'metabox_meta_fields'			=> 'metabox_meta_fields',
			'post_type'		=> 'post',
			'options'		=> array(),
			'capability'	=> 'post',
			'theme'			=> false,
			'styles'		=> array('post-meta-boxes'),
			'scripts'		=> array(),
			'rangeinput'	=> 'tools-rangeinput',
			'pluginpath'	=> '',
			'colorpicker'	=> 'jquery-colorpicker'/*,
			'rangeinput'	=> false,
			'colorpicker'	=> false*/
			
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//---	
		add_action('admin_head-post.php', array(&$this, 'admin_head') );
		add_action('admin_head-post-new.php', array(&$this, 'admin_head') );
		global $rhc_plugin;
		add_action('save_post', array(&$this,'save_post'), $rhc_plugin->get_save_post_priority(), 2 );	
		add_action('admin_menu', array(&$this, 'post_meta_box') );
		//add_action('dbx_post_sidebar', array(&$this,'dbx_post_sidebar'));
		add_action('edit_form_top', array(&$this,'dbx_post_sidebar'), 10, 1);
	}
	
	function admin_head(){
		global $post;
		if( !is_object($post) || !property_exists($post,'post_type') || $post->post_type!=$this->post_type)
			return;	

		if(count($this->styles)>0){
			foreach($this->styles as $style){
				wp_print_styles($style);
			}
		}			
		if(count($this->scripts)>0){
			foreach($this->scripts as $script){
				wp_print_scripts($script);
			}
		}		
	}
	
	function save_post($post_id, $post){		
		if( @$this->post_type != @$post->post_type ){
			return $post_id;
		}
		
		if ( !wp_verify_nonce( @$_POST[$this->post_type.'-nonce'], $this->post_type.'-nonce' )) {
			return $post_id;
		}
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
		// Check permissions
     
		//add_post_meta
		if ( $this->post_type == $_POST['post_type'] ) {
		  if ( !current_user_can( 'edit_post', $post_id ) ){
		  	return $post_id;
		  }    
		} else {
		    return $post_id;
		}

		if($this->save_post_done){
			return $post_id;
		}
		$this->save_post_done =true;
		//save general settings
		$save_fields = isset($_REQUEST["{$this->metabox_meta_fields}"])?$_REQUEST["{$this->metabox_meta_fields}"]:false;

		if(false===$save_fields){
			return $post_id;
		}
		$save_fields = explode(",",$save_fields);

		if(count($save_fields)>0){
			foreach($save_fields as $field){
				$value = isset($_REQUEST[$field])?$_REQUEST[$field]:'';
				update_post_meta($post_id,$field,$value);
			}
		}
		//This is executed per metabox instance.
		do_action('save_post_post_meta_boxes', $post_id, $post);
		do_action('save_'.$this->post_type.'_post_meta_boxes', $post_id, $post);
	}	
	
	function dbx_post_sidebar( $post ){
		//global $post;
		if($post->post_type==$this->post_type){
			echo sprintf("<input type=\"hidden\" name=\"{$this->metabox_meta_fields}\" value=\"%s\" />",implode(",",$this->save_fields));
			echo sprintf("<input type=\"hidden\" name=\"%s-nonce\" id=\"%s-nonce\" value=\"%s\" />",$this->post_type,$this->post_type,wp_create_nonce( $this->post_type.'-nonce' ));		
		}	
	}
	
	function post_meta_box(){
		if(count($this->options)>0){
			foreach($this->options as $i => $mb){
				$context  = property_exists($mb,'context')?$mb->context:'normal';
				$priority = property_exists($mb,'priority')?$mb->priority:'high';
				add_meta_box( $mb->id, $mb->label,	array( &$this, 'metabox' ), $this->post_type, $context, $priority, array($mb));
			}
		}
	}
	
	function get_meta_key($o){
		return property_exists($o,'meta_key')?$o->meta_key:$o->id;
	}
	
	function metabox($post,$args){
		if(!class_exists('pop_input'))require_once $this->pluginpath.'options-panel/class.pop_input.php';
		$pop_input = new pop_input();	
		
		$save_fields = array();
		$tab = $args['args'][0];	
		foreach($tab->options as $i => $o){
			$defaults = array(
				'default'=>'',
				'default_on_empty'=>true
			);
			foreach($defaults as $property => $default){
				$o->$property = property_exists($o,$property)?$o->$property:$default;
			}
			//--
			$method = "_".$o->type;
			if(!method_exists($pop_input,$method))
				continue;
				
			if(true===@$o->load_option){
				$meta_key = $this->get_meta_key($o);
				$o->value = get_post_meta($post->ID,$meta_key,true);
				$o->value = ''==$o->value && $o->default_on_empty ? $o->default : $o->value;
			}	
			
			echo trim(@$o->description)==''?'':"<div class=\"pt-clear\"></div><div class=\"description\">".@$o->description."</div>";		
			
			$o->post = $post;
			//if($o->type=='callback'){
			if(in_array($o->type,array('callback','div_start','div_end','preview'))){
				echo $pop_input->$method($tab,$i,$o,$save_fields);			
			}else{	
				$class = property_exists($o,'ptclass')?$o->ptclass:'';
				echo sprintf("<div class=\"pt-option pt-option-%s %s\">",$o->type,$class);
				if(in_array($o->type,array('checkbox'))){
					echo sprintf( '<label for="' . $o->id . '" class="selectit">%s %s</label>', $pop_input->$method( $tab, $i, $o , $save_fields ), $o->label );
				}else{
					if(property_exists($o,'label')&&!in_array($o->type,array('label','subtitle','hr','submit','range','textarea'))){
						echo sprintf("<span class=\"pt-label pt-type-%s\">%s</span>",$o->type,$o->label);	
					}
					echo sprintf("%s",$pop_input->$method($tab,$i,$o,$save_fields));						
				}
				//------------
				//echo "<div class=\"pt-clear\"></div>";
				echo "</div>";//close pt-option						
			}				
		}
		$this->save_fields = array_merge($this->save_fields,$save_fields);
	}
}
?>