<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
function moose_rhc_bug_fix_theme_single_title( $title, $id=0 ){
	global $rhc_plugin;
	if( $id > 0 ){
		if( $id==$rhc_plugin->get_option('venue_template_page_id','',true) ){
			remove_filter('the_title', 'rhc_bug_fix_theme_single_title', 10);			
			return $rhc_plugin->template_taxonomy_title;
		}else if( $id==$rhc_plugin->get_option('taxonomy_template_page_id','',true) ){
			remove_filter('the_title', 'rhc_bug_fix_theme_single_title', 10);
			return $rhc_plugin->template_taxonomy_title;
		}else if( $id==$rhc_plugin->get_option('organizer_template_page_id','',true) ){
			remove_filter('the_title', 'rhc_bug_fix_theme_single_title', 10);
			return $rhc_plugin->template_taxonomy_title;
		}
	}

	return $title;
}
add_filter('the_title', 'moose_rhc_bug_fix_theme_single_title', 9, 2);
	 
function rhc_moose_single_top_image_in_title( $null, $object_id, $meta_key, $single  ){
	if( 'eltd_title-image' == $meta_key ){	
		$post_type = get_post_type( $object_id );

		if( is_singular() ){
			global $post,$rhc_plugin;
			if( is_object( $post ) && property_exists( $post, 'post_type') && RHC_EVENTS==$post->post_type){
				$template_id = intval( $rhc_plugin->get_option( 'event_template_page_id', '', true ) );
				if( $template_id && $object_id==$template_id ){
					$attachment_id = get_post_meta( $post->ID, 'rhc_top_image', true );
					if( $attachment_id > 0 ){
						$url = wp_get_attachment_url( $attachment_id );
						if( !empty( $url ) ){
							return $url;
						}
					}
				}
			}
		}
	}
	return $null;
}
add_filter( 'get_post_metadata', 'rhc_moose_single_top_image_in_title', 10, 4 );

if( '0' == $this->get_option( 'bug_fix_theme_single_title', '0', true )  ){
	$this->update_option( 'bug_fix_theme_single_title', '1' );
}


?>