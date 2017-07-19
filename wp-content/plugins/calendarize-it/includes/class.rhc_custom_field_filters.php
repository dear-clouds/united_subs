<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class rhc_custom_field_filters {
	function __construct(){
		add_filter('rhc_post_info_value',array(&$this,'handle_custom_field_filter'),10,3);
		
		add_filter('taxonomymeta_shortcode_value', array(&$this,'taxonomymeta_shortcode_value'), 10, 3);
	}
	
	function taxonomymeta_shortcode_value( $value, $term, $field ){
		if( true ){
			if( $field=='website' && ''!=trim($value) ){
				$website = $value;
				$value = false===strpos($website,'://')?'http://'.$website:$website;
			}		
		}
		return $value;
	}
	
	function handle_custom_field_filter($value,$o,$args=array()){
		if($o->type=='taxonomymeta' && $o->taxonomymeta_field=='email'){
			if (preg_match('/^[^\W][a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*\@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*\.[a-zA-Z]{2,4}$/',$value)) { 
				$value = sprintf('<a href="mailto:%s">%s</a>',$value,$value);
			}				
		}
		if($o->type=='taxonomymeta' && $o->taxonomymeta_field=='website'){
			$label = $value;
			$label = str_replace('https://','',$label);
			$label = str_replace('http://','',$label);
			if($label==$value){
				$value = 'http://'.$value;
			}

			$maybe_label = get_term_meta( $args['term']->term_id, 'websitelabel', true);
			if( ''!=$maybe_label ){
				$label = $maybe_label;
			}	
			
			if( isset($args['term']) && property_exists($args['term'],'term_id') ){
				$nofollow = get_term_meta( $args['term']->term_id, 'website_nofollow', true);
			}else{
				$nofollow = '';
			}
			
			$value = sprintf('<a %s href="%s">%s</a>',
				$nofollow,
				htmlspecialchars($value),
				$label
			);		
		}
		if($o->type=='taxonomymeta' && $o->taxonomymeta_field=='gaddress'){
			if(trim($value)=='' && isset($args['term'])){
				$glat = get_term_meta($args['term']->term_id,'glat',true);
				$glon = get_term_meta($args['term']->term_id,'glon',true);		
				if($glat==''||$glon=='')return'';
				$value=$glat.','.$glon;
			}

			$url = "http://maps.google.com/?q=".urlencode($value);
			$value = sprintf('<a href="%s" target="_BLANK">%s</a>',$url,$o->label);			
		}	
		if($o->type=='postmeta' && $o->postmeta=='fc_allday'){
			$value = intval($value) ? __('Yes','rhc') : __('No','rhc') ;
			$value = sprintf('<span class="fc-allday-custom-field">%s</span>',$value);
		}	
		return $value;
	}
}
/*
rhc_post_info_field Object
(
    [id] => 
    [type] => taxonomymeta
    [label] => Email
    [value] => 
    [taxonomy] => 
    [taxonomy_links] => 1
    [postmeta] => 
    [taxonomymeta] => venue
    [taxonomymeta_field] => email
    [render_cb] => 
    [post_ID] => 38
    [date_format] => 
    [column] => 0
    [span] => 12
    [offset] => 0
    [index] => 2
    [frontend] => 1
)
*/
?>