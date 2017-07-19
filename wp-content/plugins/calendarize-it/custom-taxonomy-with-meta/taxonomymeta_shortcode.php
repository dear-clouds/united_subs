<?php


add_shortcode('taxonomymeta', 'shortcode_taxonomymeta');

function shortcode_taxonomymeta($atts,$content=null,$code=""){
	extract(shortcode_atts(array(
		'taxonomy' 	=> 'category',
		'multiple'	=> 1,
		'term'		=> ''
	), $atts));
	
	$output = '';
	$terms = array();
	if(''==$term){
		$postid = get_the_ID();
		if($postid>0){
			$terms = wp_get_post_terms( $postid, $taxonomy ) ;	
		}	
	}else{
		$t = get_term_by( 'slug', $term, $taxonomy );
		if(false!==$t){
			$terms[]=$t;
		}
	}

	if(is_array($terms)&&count($terms)>0){
		if(!function_exists('get_term_meta'))require_once 'taxonomy-metadata.php';
		foreach($terms as $i => $term){
			$template = $content;
			//--replace standard taxonomy fields:
			foreach(array('term_id','name','slug','term_group','term_taxonomy_id','taxonomy','description','parent','count') as $field){
				if(!property_exists($term,$field))continue;
				$template = str_replace( sprintf('{%s}',$field) ,$term->$field,$template);
				//---
				$value = ''==trim($term->$field)?'1':'0'; 
				$template = str_replace( sprintf('empty-%s',$field) , $value, $template);
			}
			
			$link = get_term_link($term);
			$link = is_wp_error($link) ? '#' : $link ;
			$template = str_replace( '{link}' , $link, $template);
			
			if(0<preg_match_all('/{([^}]+)}/i',$content,$matches)){
				foreach($matches[0] as $j => $replace){		
					$field = '';
					$arr_field = explode( ',', $matches[1][$j] );	
					$all_empty = true;
					if( is_array($arr_field) && count($arr_field)> 0 ){
						foreach( $arr_field as $field ){
							$value = apply_filters('taxonomymeta_shortcode_value', get_term_meta($term->term_id,$field,true), $term, $field );
							if( ''!=trim($value) ){								
								$all_empty = false;
								$template = str_replace($replace,$value,$template);
							}
						}
					}
					if( $all_empty ){
						$empty_replace = 'empty-'.$field;
						$value = ''==trim($value)?'1':'0'; 
						$template = str_replace($empty_replace,$value,$template);		
					}
					//----
					$field=$matches[1][$j];		
					$value = apply_filters('taxonomymeta_shortcode_value', get_term_meta($term->term_id,$field,true), $term, $field );
					$template = str_replace($replace,$value,$template);
					//-- intended for adding a class when value is empty
					$replace = str_replace('{','empty-',$replace);
					$replace = str_replace('}','',$replace);
					$value = ''==trim($value)?'1':'0'; 
					$template = str_replace($replace,$value,$template);
					
				}
			}
			$output.=$template;
			if($multiple==0)break;			
		}
	}
	
	return do_shortcode($output);	
	//-- the_content is creating an infinite loop, do_shorcode is now the only was to process the nested shortcodes.
	/*
	global $rhc_plugin;
	if( '1'==$rhc_plugin->get_option('bug_unwanted_venuebox','',true) ){
		return do_shortcode($output);
	}
	return apply_filters('the_content',$output);
	*/
}
?>