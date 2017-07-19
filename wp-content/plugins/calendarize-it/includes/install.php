<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
function handle_rhc_install(){
	//----for taxonomy metadata support
	global $wpdb;
	$charset_collate = '';  
	if ( ! empty($wpdb->charset) )$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	if ( ! empty($wpdb->collate) )$charset_collate .= " COLLATE $wpdb->collate";
	$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}taxonomymeta'");
	if (!count($tables))
	 $wpdb->query("CREATE TABLE {$wpdb->prefix}taxonomymeta (
	   meta_id bigint(20) unsigned NOT NULL auto_increment,
	   taxonomy_id bigint(20) unsigned NOT NULL default '0',
	   meta_key varchar(255) default NULL,
	   meta_value longtext,
	   PRIMARY KEY  (meta_id),
	   KEY taxonomy_id (taxonomy_id),
	   KEY meta_key (meta_key)
	 ) $charset_collate;");
	 
	 $tables = $wpdb->get_results("show tables like '{$wpdb->prefix}rhc_cache'");
	if (!count($tables))
	 $wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}rhc_cache` (
  `request_md5` char(32) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(50) DEFAULT NULL,
  `response` longtext NOT NULL,
  PRIMARY KEY (`request_md5`,`user_id`)
) $charset_collate;");
	 	 
	
	 $tables = $wpdb->get_results("show tables like '{$wpdb->prefix}rhc_events'");
	if (!count($tables))
	 $wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}rhc_events` (
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `allday` tinyint(4) NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_start`,`post_id`),
  KEY `event_end` (`event_end`,`post_id`),
  KEY `event_start` (`event_start`,`event_end`)
) $charset_collate;");
		 
  	 
	 //---- Capabilities for the rhcvents custom post type
	$WP_Roles = new WP_Roles();	
	foreach(array(
		'calendarize_author',
		'edit_'.RHC_CAPABILITY_TYPE,
		'read_'.RHC_CAPABILITY_TYPE,
		'delete_'.RHC_CAPABILITY_TYPE,
		'delete_'.RHC_CAPABILITY_TYPE.'s',
		'edit_'.RHC_CAPABILITY_TYPE.'s',
		'edit_others_'.RHC_CAPABILITY_TYPE.'s',
		'edit_published_'.RHC_CAPABILITY_TYPE.'s',
		'delete_published_'.RHC_CAPABILITY_TYPE.'s',
		'delete_private_'.RHC_CAPABILITY_TYPE.'s',
		'delete_others_'.RHC_CAPABILITY_TYPE.'s',
		'publish_'.RHC_CAPABILITY_TYPE.'s',
		'read_private_'.RHC_CAPABILITY_TYPE.'s',
		
		'manage_'.RHC_VENUE,
		'manage_'.RHC_CALENDAR,
		'manage_'.RHC_ORGANIZER,
		
		'rhc_options',
		'rhc_license'
		) as $cap){
		$WP_Roles->add_cap( RHC_ADMIN_ROLE, $cap );
	}	
	//----
	global $rhc_plugin;
	include RHC_PATH.'includes/bundle_default_custom_fields.php';
	if(isset($postinfo_boxes)){
		//--save:
		$options = get_option($rhc_plugin->options_varname);
		$options = is_array($options)?$options:array();
		if( !isset($options['postinfo_boxes']) ){
			$options['postinfo_boxes']=$postinfo_boxes;
			update_option($rhc_plugin->options_varname,$options);
		}
		//--
	}		
	add_option('rhc_options_redirect', true);
	add_option('rhc_setup', true); 
	$rhc_plugin->update_option('data-last-modified', gmdate("D, d M Y H:i:s") . " GMT" );
}


function handle_rhc_uninstall(){
	$WP_Roles = new WP_Roles();
	foreach(array(
		'calendarize_author',
		'edit_'.RHC_CAPABILITY_TYPE,
		'read_'.RHC_CAPABILITY_TYPE,
		'delete_'.RHC_CAPABILITY_TYPE,
		'delete_'.RHC_CAPABILITY_TYPE.'s',
		'edit_'.RHC_CAPABILITY_TYPE.'s',
		'edit_others_'.RHC_CAPABILITY_TYPE.'s',
		'edit_published_'.RHC_CAPABILITY_TYPE.'s',
		'delete_published_'.RHC_CAPABILITY_TYPE.'s',
		'delete_private_'.RHC_CAPABILITY_TYPE.'s',
		'delete_others_'.RHC_CAPABILITY_TYPE.'s',		
		'publish_'.RHC_CAPABILITY_TYPE.'s',
		'read_private_'.RHC_CAPABILITY_TYPE.'s',
		
		'manage_'.RHC_VENUE,
		'manage_'.RHC_CALENDAR,
		'manage_'.RHC_ORGANIZER
		) as $cap){
		$WP_Roles->remove_cap( RHC_ADMIN_ROLE, $cap );
	}
	//-----
	delete_site_transient('update_plugins');
	delete_option( 'rhc_dismiss_help_notice' );
	
	$filename = get_home_path() . '.htaccess';
	if(file_exists($filename)){
		insert_with_markers( $filename, 'RHC', array());
	}	
}

?>