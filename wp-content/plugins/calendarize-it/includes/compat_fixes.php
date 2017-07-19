<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
global $rhc_plugin;

if(defined('WPSEO_FILE')){
	include RHC_PATH.'plugin-compat-fixes/yoast-seo.php';
}

if( '1' == $rhc_plugin->get_option( 'bug_fix_theme_single_title', '0', true ) ){
	function rhc_bug_fix_theme_single_title( $title, $id=0 ){
		if( is_singular() ){
			global $post,$rhc_plugin;
			if( is_object( $post ) && property_exists( $post, 'post_type') && RHC_EVENTS==$post->post_type){
				$template_id = intval( $rhc_plugin->get_option( 'event_template_page_id', '', true ) );
				if( $template_id && $id==$template_id ){
					return $post->post_title;
				}
			}else if( is_object( $post ) && property_exists( $post, 'post_type') && 'page'==$post->post_type){
				if( false!==$rhc_plugin->template_taxonomy_title ){
					return $rhc_plugin->template_taxonomy_title;
				}
			}
		}
	
		return $title;
	}
	add_filter('the_title', 'rhc_bug_fix_theme_single_title', 10, 2);
}
?>