<?php

/**
 * Shortcodes that are meant to be used inside a single page (any custom/default post type)
 *
 * @version $Id$
 * @copyright 2003 
 **/

class rhc_single_shortcoes {
	var $in_dbox = false;
	function __construct(){
		foreach(array('venuebox','postinfo','featuredimage','rhc_conditional_content') as $shortcode){
			add_shortcode($shortcode, array(&$this,'handle_conditional'));
		}
		foreach(array('event_detailbox','venue_detailbox','rhc_image') as $shortcode){
			add_shortcode($shortcode, array(&$this,'handle_postinfo_wrappers'));
		}

	}	 
	

	//-- a wrapper for common uses of postinto sc.
	function handle_postinfo_wrappers($atts,$template='',$code=""){
		if( 'event_detailbox' == $code ){
			$atts['meta_key'] = '';
			$atts['meta_value'] = '';
			$atts['default']	= '';
			$atts['se-dbox']	= 'se-dbox';
		}else if( 'venue_detailbox' == $code ){
			$atts['id'] 		= 'venuebox';
			$atts['meta_key'] 	= '';
			$atts['meta_value'] = '';
			$atts['default']	= '';
			$atts['se-dbox']	= 'se-vbox';	
		}else if( 'rhc_image' == $code ){
			//[featuredimage meta_key='enable_featuredimage' meta_value='1' default='1' custom='rhc_top_image']
			$atts['meta_key'] = '';
			$atts['meta_value'] = '';
			$atts['default']	= '';
			$atts['custom'] = empty( $atts['custom'] ) ? 'rhc_top_image' : $atts['custom'] ;
			return $this->handle_conditional( $atts, $template, 'featuredimage' );
		}
	
		return $this->handle_conditional( $atts, $template, 'postinfo' );
	}
	
	function handle_conditional( $atts, $content='', $code="" ){
		extract(shortcode_atts(array(
			'conditional_tag' 	=> 'is_singular',
			'capability'	 			=> '',
			'meta_key'					=> '',
			'meta_value'				=> '',
			'default'					=> '',//value to give meta_value if it is empty.
			'operator'					=> '=',//TODO: allow other operators.
			'filter' 					=> ''//TODO: allow applying a filter to the value
		), $atts));
		
		$atts['meta_value_default'] = $default; //bug fix, boxes dissappearing on ce submitted events.
		
		if( !$this->sc_output_conditions_met ( $atts, $content, $code) ){
			return '';
		}
		
		$method = 'handle_'.$code;	
		if( method_exists( $this, $method ) ){
			return $this->$method( $atts, $content, $code );
		}else{
			return do_shortcode( trim( $content ) );
		}
	}
	
	function sc_output_conditions_met ($atts, $content=null, $code="" ){
		extract(shortcode_atts(array(
			'conditional_tag' 		=> '',
			'capability'	 		=> '',
			'meta_key'				=> '',
			'meta_value'			=> '',
			'meta_value_default'	=> '', //value to give meta_value if it is empty.
			'usermeta_key'			=> '', //a usermeta to test against,
			'usermeta_value'		=> '',
			'usermeta_default'		=> ''
		), $atts));
		
		//---
		if( !empty( $capability ) ){
			if( !current_user_can( $capability ) ){
				return false;
			}
		}	
		
		//---------test wp conditional tags
		if(''!=trim($conditional_tag)){
			$allowed_conditional_tags = apply_filters( 'shortcode_allowed_conditional_tags', array( 
				'is_home',
				'is_front_page',
				'is_singular',
				'is_page',
				'is_single',
				'is_sticky',
				'is_category',
				'is_tax',
				'is_author',
				'is_archive',
				'is_search',
				'is_attachment',
				'is_tag',
				'is_date',
				'is_paged',
				'is_main_query',
				'is_feed',
				'is_trackback',
				'in_the_loop',
				'is_user_logged_in'
				), $code );
			
			$test_tags = explode(',',trim(str_replace(' ','',$conditional_tag)));
			if(is_array($test_tags) && count($test_tags)>0){
				$condition_matched = false;
				foreach($test_tags as $test_method){
					if( in_array($test_method,$allowed_conditional_tags) && $test_method() ){
						$condition_matched = true;
						break;
					}
				}
				if(false===$condition_matched){
					return false;
				}
			}
		}	
		
		//-------- test for post meta_key conditional value 
		if($meta_key!=''){
			global $post; //to be used in a loop where $post is defined.
			$post_ID = property_exists($post,'ID') ? $post->ID : false;

			if(false!==$post_ID){
				$value = get_post_meta($post_ID,$meta_key,true);
				$value = ''==$value?$meta_value_default:$value;		
				//TODO: allow other operators
				if( $value != $meta_value ){
					//condition was not matched.
					return false;
				}
			}		
		}
		//--------
		
		//--------- test for usermeta
		if($usermeta_key!=''){
			if( is_user_logged_in() ){
				global $userdata;
				$value = get_user_meta( $userdata->ID, $usermeta_key, true );
				$value = ''==$value?$usermeta_default:$value;	
				if( $value != $usermeta_value ){
					//condition was not matched.
					return false;
				}				
			}else{
				//user not logged, condition not matched.
				return false;
			}
		}
		//---------
		return true;
	}
		
	function handle_venuebox($atts,$template='',$code=""){
	
		global $rhc_plugin;
		$filename = $rhc_plugin->get_template_path('content-venuebox.php');
		ob_start();
		include $filename;
		$content = ob_get_contents();
		ob_end_clean();
		return do_shortcode($content);
	}
	
	function handle_postinfo($atts,$template='',$code=""){
		return rhc_post_info_shortcode::handle_shortcode($atts,$template,$code);
	}
	
	function handle_featuredimage($atts,$template='',$code=""){
		//originally called featured image, it ended up being a custom featured image.
		extract(shortcode_atts(array(
			'custom' 		=> '',
			'size'			=> '',
			'class'			=> ''
		), $atts));
		
		$class.=' attachment- '.$custom;
		
		$arr = explode(',',$size);
		if(count($arr)==2){
			$size = $arr;
		}
		
		global $post;		
		if(''==$custom){
			if( $thumbnail = get_the_post_thumbnail( $post->ID ) ){
				return $thumbnail;
			}		
		}else{
			$attachment_id = get_post_meta( $post->ID, $custom, true);
			if( intval($attachment_id)>0 && $image=wp_get_attachment_image( $attachment_id, $size, 0, array('class'=>$class) ) ){
				return $image;
			}
		}
		return '';
	}
}
?>