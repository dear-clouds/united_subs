<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

function rhc_handle_delete_events_cache(){
	global $rhc_plugin,$wpdb;		
	if('1'!=$rhc_plugin->get_option('disable_rhc_cache','',true)){
		//clear cache.
		$sql = "TRUNCATE `{$wpdb->prefix}rhc_cache`";
		if($wpdb->query($sql)){
		
		}else{
			$sql = "DELETE FROM `{$wpdb->prefix}rhc_cache` WHERE (1)";
			if($wpdb->query($sql)){
		
			}
		}
		//--clear files
		if('1'==$rhc_plugin->get_option('file_cache','',true)  ){
			$cache_path = $rhc_plugin->calendar_ajax->get_cache_path();
			$path = $cache_path.'*';						
			$arr = glob( $path );			
			if( is_array($arr) && count($arr)>0){
				foreach($arr as $file){
					if(is_dir($file)){
						$sub_path = $file.'/*';
						@array_map('unlink', glob( $sub_path ));	
					}else{
						unlink($file);
					}
				}
			}	
		}
	}
	$last_modified = gmdate("D, d M Y H:i:s") . " GMT";
	$rhc_plugin->update_option('data-last-modified', $last_modified );
	$rhc_plugin->update_option('data-last-modified-md5', md5($last_modified) );
}
?>