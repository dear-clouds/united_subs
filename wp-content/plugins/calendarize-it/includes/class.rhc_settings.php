<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhc_settings {
	var $added_rules;
	function __construct($plugin_id='rhc'){
		//$this->id = $plugin_id.'-log';
		$this->id = $plugin_id;
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);			
		add_action('pop_handle_save',array(&$this,'pop_handle_save'),50,1);
		add_action('pop_body_'.$this->id,array(&$this,'flush_rewrite_rules'));
				
		add_action('init',array(&$this,'admin_init'));
		
	}
	
	function admin_init(){
		$this->add_rhc_rules(false);
		//observe that this isnt flushing rules. just adding them to wp_rewrite in case some 
		//other plugins flushes them, and calendarize are not included.
	}
	
	function add_rhc_rules($flush_rules=true){
		global $wp_rewrite,$rhc_plugin;
		//Todo: change to rewrite endpoints when they work with archives.
		//-----
		$visual_calendar_slug = $rhc_plugin->get_option('rhc-visualcalendar-slug',RHC_VISUAL_CALENDAR, true);
		//-----
		$forced_rewrite_rule = $rhc_plugin->get_option('forced_rewrite_rules', '0', true);
		$forced_rewrite_rule = $forced_rewrite_rule=='1'?true:false;
		// note: why forced? some plugins seem to be removing cal permalinks.
		
		$post_types=array();
		$rhc_rules = array();
		foreach(get_post_types(array(/*'public'=> true,'_builtin' => false*/),'objects','and') as $post_type => $pt){
			if(in_array($post_type,array('revision','nav_menu_item')))continue;
			$post_types[$post_type]=$pt;
		} 
		//-----
		if( '1'==$rhc_plugin->get_option('enable_post_type_endpoint','1',true) ){
			$calendarize_post_types = array(
				'rhc-events-slug' => RHC_EVENTS
			);
			foreach($calendarize_post_types as $slug => $post_type){
				$regex = sprintf('(%s)/(%s)/?$',$rhc_plugin->get_option($slug,$post_type,true),$visual_calendar_slug);
				$redirect = sprintf('index.php?post_type=%s&%s=$matches[2]',$post_type,RHC_DISPLAY);
				if($forced_rewrite_rule){
					$rhc_rules[$regex]=$redirect;
				}else{
					add_rewrite_rule($regex, $redirect	, 'top');
				}
			}		
		}
		//----
		if( '1'==$rhc_plugin->get_option('enable_static_list_endpoint','1',true) ){
			$upcoming = $rhc_plugin->get_option('enable_static_list_upcoming_slug','rhc-upcoming-events',true);
			$past = $rhc_plugin->get_option('enable_static_list_past_slug','rhc-past-events',true);
			add_rewrite_endpoint( $upcoming, EP_ALL );
			add_rewrite_endpoint( $past, EP_ALL );
		}
		
		$event_archive_slug = $rhc_plugin->get_option('rhc-events-archive-slug','',true);
		if( !empty($event_archive_slug) ){
			$regex = sprintf('(%s)/?$',$event_archive_slug);
			$redirect = sprintf('index.php?post_type=%s',$post_type);
			add_rewrite_rule($regex, $redirect	, 'top');
		}
		
		if( $forced_rewrite_rule && !empty($rhc_rules) ){		
			$wp_rewrite->extra_rules_top = array_merge( $rhc_rules, $wp_rewrite->extra_rules_top );
		}
		
		if($flush_rules){	
			flush_rewrite_rules(false);		
		}
	}
	
	function flush_rewrite_rules(){
		if( get_option('rhc_flush_rewrite_rules',false) ){
			delete_option('rhc_flush_rewrite_rules');
			$this->add_rhc_rules();
		}
	}
	
	function pop_handle_save($pop){
		global $rhc_plugin;
		if($rhc_plugin->options_varname!=$pop->options_varname)return;
		update_option('rhc_flush_rewrite_rules',true);
		
		if(isset($_POST['btn_clear_event_color'])){
			if(current_user_can($rhc_plugin->options_capability)){
				global $wpdb;
				$sql ="DELETE FROM `{$wpdb->postmeta}` WHERE meta_key IN ('fc_color','fc_text_color');";
				$wpdb->query($sql);
			}
		}		

		if(isset($_POST['btn_wp41_empty_posts_bug'])){
			if(current_user_can($rhc_plugin->options_capability)){
				global $wpdb;
				$sql = sprintf("UPDATE `{$wpdb->posts}` SET `post_content`='&nbsp;' WHERE TRIM(post_title)='' AND TRIM(post_content)='' AND TRIM(post_excerpt)='' AND post_type='%s';",
					RHC_EVENTS
				);
				$wpdb->query($sql);
			}
		}	
		
		if(isset($_POST['btn_wp44_empty_taxonomy_metadata'])){
			if(current_user_can($rhc_plugin->options_capability)){
				update_option( 'RHC_VERSION', 0, true );				
			}
		}
		
		add_action('admin_init',array(&$this,'save_file_cache'));//so that insert with markers is defined.
		
		if(isset($_POST['rhc_cache_clear'])){
			if(!function_exists('rhc_handle_delete_events_cache')){
				require_once RHC_PATH.'includes/function.rhc_handle_delete_events_cache.php';
			}
			rhc_handle_delete_events_cache();
			//Note: currently only saving options clears cache. but that may change. keep this just in case.
		}
	}
	
	function options($t){
		$i = count($t);
		//-- Permalink settings -----------------------		
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-permalinks'; 
		$t[$i]->label 		= __('Permalink settings','rhc');
		$t[$i]->right_label	= __('Modify permalinks','rhc');
		$t[$i]->page_title	= __('Permalink settings','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'			=> 'rhc-events-slug',
				'type' 			=> 'text',
				'label'			=> __('Events post type slug','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'rhc-calendar-slug',
				'type' 			=> 'text',
				'label'			=> __('Calendar category slug','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'rhc-venues-slug',
				'type' 			=> 'text',
				'label'			=> __('Venues slug','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'rhc-organizers-slug',
				'type' 			=> 'text',
				'label'			=> __('Organizers slug','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'			=> 'rhc-visualcalendar-slug',
				'type' 			=> 'text',
				'default'		=> RHC_VISUAL_CALENDAR,
				'label'			=> __('Visual calendar slug','rhc'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'forced_rewrite_rules',
				'label'		=> __('Forced rewrite rules','rhc'),
				'type'		=> 'yesno',
				'description'=> __('Choose yes if permalinks are not working.  It will attempt an alternative method of adding rewrite rules.','rhc'),
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'enable_post_type_endpoint',
				'label'		=> __('Enable calendar end point','rhc'),
				'description'=> sprintf('<p>%s</p><p>%s</p>',
					__('If permalinks are active, choose yes to be able to append /calendar/ to the url to load a calendar for that particular post type, example yourdomain.com/events/calendar/ will display the calendar without the need to setup the shortcode on a page.','rhc'),
					__('If you have a page with permalink /events/calendar/ you may need to disable this, as it takes precedence over the page permlink.','rhc')
				),
				'type'		=> 'yesno',
				'default'	=> '1',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			)								
		);
		
		$t[$i]->options[]=(object)array(
				'type'=>'subtitle',
				'label'=> __('Events archive permalink'),
				'description'=> __('Events archive is listed in the order of publishing, not event date.  Also recurring instances do not show.  Its for sites that what to display events as rendered by the theme.','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'rhc-events-archive-slug',
				'type' 			=> 'text',
				'default'		=> '',
				'label'			=> __('Events archive slug','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);	
		//--Custom Post Types -----------------------		
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-custom-types'; 
		$t[$i]->label 		= __('Custom Post Types','rhc');
		$t[$i]->right_label	= __('Enable calendar metabox for other post types.','rhc');
		$t[$i]->page_title	= __('Custom Post Types','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array();

		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Calendarize metabox','rhc')
			);		
		//--------------
		$post_types=array();
		foreach(get_post_types(array(/*'public'=> true,'_builtin' => false*/),'objects','and') as $post_type => $pt){
			if(in_array($post_type,array(RHC_EVENTS, 'revision','nav_menu_item')))continue;
			$post_types[$post_type]=$pt;
		} 
		//--------------		
		if(count($post_types)==0){
			$t[$i]->options[]=(object)array(
				'id'=>'no_ctypes',
				'type'=>'description',
				'label'=>__("There are no additional Post Types to enable.",'rhc')
			);
		}else{
			$j=0;
			foreach($post_types as $post_type => $pt){
				$tmp=(object)array(
					'id'	=> 'post_types_'.$post_type,
					'name'	=> 'post_types[]',
					'type'	=> 'checkbox',
					'option_value'=>$post_type,
					'label'	=> (@$pt->labels->name?$pt->labels->name:$post_type),
					'el_properties' => array(),
					'save_option'=>true,
					'load_option'=>true
				);
				if($j==0){
					$tmp->description = __("Calendarizer metabox can be enabled for other post types.  Check the post types, where you want the calendar metabox to be displayed.",'rhc');
					$tmp->description_rowspan = count($post_types);
				}
				$t[$i]->options[]=$tmp;
				$j++;
			}
		}

		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);	
		
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Events & Venue Detail box','rhc')
			);
			
		if(count($post_types)==0){
			$t[$i]->options[]=(object)array(
				'type'=>'description',
				'label'=>__("There are no additional Post Types to enable.",'rhc')
			);
		}else{
			$j=0;
			foreach($post_types as $post_type => $pt){
				$tmp=(object)array(
					'id'	=> 'dbox_post_types_'.$post_type,
					'name'	=> 'dbox_post_types[]',
					'type'	=> 'checkbox',
					'option_value'=>$post_type,
					'label'	=> (@$pt->labels->name?$pt->labels->name:$post_type),
					'el_properties' => array(),
					'save_option'=>true,
					'load_option'=>true
				);
				if($j==0){
					$tmp->description = sprintf('<p>%s</p><p>%s</p>',
						__('Check post types for wich you want to enable the detail box metabox.','rhc'),
						__('You will need to manually add the [rhc_post_info] shortcode.','rhc')
					);
					$tmp->description_rowspan = count($post_types);
				}				
				$t[$i]->options[]=$tmp;
				$j++;
			}
		}	
					
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);	

		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Calendarize It! images','rhc')
			);

		if(count($post_types)==0){
			$t[$i]->options[]=(object)array(
				'type'=>'description',
				'label'=>__("There are no additional Post Types to enable.",'rhc')
			);
		}else{
			$j=0;
			foreach($post_types as $post_type => $pt){
				$tmp=(object)array(
					'id'	=> 'img_post_types_'.$post_type,
					'name'	=> 'img_post_types[]',
					'type'	=> 'checkbox',
					'option_value'=>$post_type,
					'label'	=> (@$pt->labels->name?$pt->labels->name:$post_type),
					'el_properties' => array(),
					'save_option'=>true,
					'load_option'=>true
				);
				if($j==0){
					$tmp->description = sprintf('<p>%s</p><p>%s</p><p>%s</p><p>%s</p>',
						__('Check post types for wich you want to enable the Calendarize It! image metaboxes.','rhc'),
						__('You will need to manually add the shortcode.','rhc'),
						__('Top image shortcode','rhc'),
						"[featuredimage meta_key='enable_featuredimage' meta_value='1' default='1' custom='rhc_top_image']"
					);
					$tmp->description_rowspan = count($post_types);
				}				
				$t[$i]->options[]=$tmp;
				$j++;
			}
		}	

		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);	
			
		$t[$i]->options[]=(object)array(
				'type'			=> 'subtitle',
				'label'			=> __('Automatic Calendar content','rhc'),
				'description'	=> __('Use this option to automatically add Calendarize It! single page elements, you can still control display with the Layout options in the post edit screen.',"rhc")
			);	

		//--custom content templates
		global $rhc_plugin;
		$enabled_post_types = $rhc_plugin->get_option('dbox_post_types',array());
		$enabled_post_types = is_array($enabled_post_types)?$enabled_post_types:array();
		$enabled_post_types = apply_filters('rhc_dbox_metabox_post_types',$enabled_post_types);	
		$enabled_post_types_keys = array(RHC_EVENTS);
		foreach( $enabled_post_types as $p ){
			$enabled_post_types_keys[] = $p;
		}
		
		$post_types[ RHC_EVENTS ] = get_post_type_object( RHC_EVENTS );
		foreach($post_types as $post_type => $pt){
			if( !in_array( $post_type,  $enabled_post_types_keys ) ) continue;
			$t[$i]->options[] = (object)array(
				'id'			=> 'enable_cctpl_' . $post_type,
				'type'			=> 'onoff',
				'default'		=> ( $post_type == RHC_EVENTS ? '1' : '0' ),
				'label'			=> sprintf(  __('%s( %s )','rhc'),
					(@$pt->labels->name?$pt->labels->name:$post_type),
					$post_type
				),
				'hidegroup'	=> '#cctpl_' .$post_type,
				'save_option'	=> true,
				'load_option'	=> true
			);
			
			$t[$i]->options[] = (object)array('type'	=> 'clear');
			
			$t[$i]->options[] = (object)array(
				'id'	=> 'cctpl_' .$post_type,
				'type'=>'div_start'
			);
			
			$t[$i]->options[] = (object)array(
					'id'			=> 'cctpl_'.$post_type,
					'type' 			=> 'textarea',
					'label'			=> sprintf( __('Custom template ( %s )','rhc'), $post_type),
					'default'		=> esc_attr("[rhc_event_microdata][featuredimage meta_key='enable_featuredimage' meta_value='1' default='1' custom='rhc_top_image'][CONTENT][postinfo meta_key='enable_postinfo' meta_value='1' default='1' class='se-dbox'][postinfo meta_key='enable_venuebox' meta_value='1' default='1' id='venuebox' class='se-vbox']"),
					'el_properties' => array('rows'=>'15','cols'=>'50'),
					'save_option'=>true,
					'load_option'=>true
				);
			
			$t[$i]->options[]=(object)array('type'	=> 'div_end');
			
			$t[$i]->options[] = (object)array('type'	=> 'clear');

		}
		//custom_content_single_event	
//		$t[$i]->options[]=;
		
		
			
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);	
			
		$t[$i]->options[]=(object)array(
				'type'=>'subtitle',
				'label'=>__('Other integration settings','rhc')
			);				
			
		$t[$i]->options[]=(object)array(
				'id'		=> 'show_all_post_types',
				'label'		=> __('Show all post types in calendar','rhc'),
				'description'=> __('By default the calendarizeit shortcode only displays one custom post type (events by default), and you need to set the post_type value to show a diferent post type.  Choose yes if you want to display all enabled post types by default.','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
					
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);
		//--Advanced settings-----------------------		
/*
		$i = count($t);
		$t[$i]->id 			= 'advanced'; 
		$t[$i]->label 		= __('Advanced Settings','rhc');
		$t[$i]->right_label	= __('Advanced Settings','rhc');
		$t[$i]->page_title	= __('Advanced Settings','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'	=> 'todo',
				'type'	=> 'label',
				'label'	=> __('TODO','rhc'),
				'save_option'=>false,
				'load_option'=>false
			),	
			(object)array(
				'type'=>'clear'
			)	,
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary',
				'save_option'=>false,
				'load_option'=>false
			)	
		);		
*/
		//--Custom Post Types -----------------------		
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-cache'; 
		$t[$i]->label 		= __('Events cache','rhc');
		$t[$i]->right_label	= __('Enable and configure event ajax caching.','rhc');
		$t[$i]->page_title	= __('Events cache','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
				(object)array(
					'type'		=> 'callback',
					'callback'	=> array(&$this,'cb_rhc_cache')
				),
				(object)array(
					'id'		=> 'disable_rhc_cache',
					'label'		=> __('Disable events cache','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Event cache is active by default, choose yes to turn off the server side events cache.','rhc')
					),
					'default'	=> '',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),
			
				(object)array(
					'id'			=> 'rhc_cache_minutes',
					'type' 			=> 'text',
					'label'			=> __('Expiration minutes','rhc'),
					'description'	=> __('By default set to 10080 (1 week).  Represents how long to wait before a cached event query is expired.','rhc'),
					//'el_properties' => array('class'=>'widefat'),
					'save_option'=>true,
					'load_option'=>true
				),
				
				(object)array(
					'id'		=> 'external_sources_cache',
					'label'		=> __('External sources cache','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Enable cache for external sources','rhc')
					),
					'default'	=> '1',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),					
				
				(object)array(
					'id'			=> 'rhc_external_cache_minutes',
					'type' 			=> 'text',
					'label'			=> __('External Sources Expiration minutes','rhc'),
					'description'	=> __('By default set to 120 (2 hours).  If set too hight, it will take a while do detect new events.','rhc'),
					//'el_properties' => array('class'=>'widefat'),
					'save_option'=>true,
					'load_option'=>true
				),		
						
				(object)array(
					'id'		=> 'rhc_cache_by_user',
					'label'		=> __('Cache by user','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Turned off by default.  Choose yes if you have plugins or addons that may modify the content of events based on what user is logged in.  This increases the size of the cache, so only choose yes if needed.','rhc')
					),
					'default'	=> '',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),
				
				(object)array(
					'id'		=> 'file_cache',
					'label'		=> __('File cache (Experimental)','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p><pre>%s</pre>',
						__('Local events will be saved to files.  Turning this option on will attempt to write to htaccess.  Only available with apache mod rewrite.','rhc'),
						$this->get_htaccess(true)
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),				

				(object)array(
					'id'		=> 'rhc_cache_clear',
					'label'		=> __('Clear Cache','rhc'),
					'type'		=> 'callback',
					'description' => __('Click to clear calendar ajax cache.','rhc'),
					'callback'	=> array(&$this,'render_rhc_cache_clear'),
					'el_properties'	=> array(),
					'save_option'=>false,
					'load_option'=>false
				),	
				
				(object)array(
					'type'=>'clear'
				),
				(object)array(
					'type'	=> 'submit',
					'label'	=> __('Save','rhc'),
					'class' => 'button-primary',
					'save_option'=>false,
					'load_option'=>false
				)									
		);
		
		//-------------------------		
		if(current_user_can('manage_options')){
			$i = count($t);
			$t[$i]=(object)array();
			$t[$i]->id 			= 'troubleshooting'; 
			$t[$i]->label 		= __('Troubleshooting','rhc');
			$t[$i]->right_label	= __('Troubleshooting','rhc');
			$t[$i]->page_title	= __('Troubleshooting','rhc');
			$t[$i]->theme_option = true;
			$t[$i]->plugin_option = true;
			$t[$i]->options = array(
				(object)array(
					'id'		=> 'ignore_wordpress_standard',
					'label'		=> __('Ignore WordPress Standard','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p><p>%s</p>',
						__('Choose yes only if you are getting a 404 page when trying to get an event page.','rhc'),
						__('If you choose yes and the event starts showing, it means that the theme or a plugin is not following a standard in regards to register_post_type and flush_rewrite_rules.  Under certain circumstances it could also affecting website performance.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'id'		=> 'enable_theme_thumb',
					'label'		=> __('Enable thumbnail support','rhc'),
					'type'		=> 'yesno',
					'description'=> __('Choose yes only if the thumbnail metabox is not showing when you edit event.  Usually themes enable this.','rhc'),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'id'		=> 'enable_debug',
					'label'		=> __('Enable debug','rhc'),
					'type'		=> 'yesno',
					'description'=> __('Choose yes to display a debug menu.  This provide technical information that support can use to troubleshoot problems.','rhc'),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'id'		=> 'debug_javascript',
					'label'		=> __('Debug css and javascript','rhc'),
					'type'		=> 'yesno',
					'description'=> __('Choose yes to load javascript and css files that are not minified, for easier debugging.','rhc'),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'id'			=> 'rhc-api-url',
					'type' 			=> 'text',
					'label'			=> __('Api url','rhc'),
					'description'	=> __('On some setups, wordpress is installed in a non-standard way and causes the site_url() function to return a value that is diferent from the real url, causing the browser to reject the ajax.  You need to add rhc_action=get_calendar_events to the query string.','rhc'),
					'el_properties' => array('class'=>'widefat'),
					'save_option'=>true,
					'load_option'=>true
				),				
				(object)array(
					'id'		=> 'in_footer',
					'label'		=> __('Scripts in footer','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Choose yes if you want this plugin scripts loaded in the footer.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),		
				(object)array(
					'id'		=> 'disable_bootstrap',
					'label'		=> __('Disable bootstrap','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Choose yes to avoid loading the bundled bootstrap.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				
				(object)array(
					'id'		=> 'hierarchichal_events',
					'label'		=> __('Hierarchical Events','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Turn on if for some special usage you require that events post type are hierarchical.  Observe that on large sets of data this may exhaust memory in the backend.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),					
												
				(object)array(
					'type'=>'clear'
				),
				
				(object)array(
					'type'=>'subtitle',
					'label'=>__('Events ajax','rhc')
				),				
				
				(object)array(
					'id'		=> 'cal_shrink',
					'label'		=> __('Enable ajax data shrink','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Ajax data shrink is a new feature introduced on version 2.7.4, it reduces the ajax data size.  Choose no if you want to disable this feature.','rhc')
					),
					'default'	=> '1',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),		
				
				(object)array(
					'id'		=> 'cal_preload',
					'label'		=> __('Preload data','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('The first set of data in a calendar view will be preloaded.  Choose no if you do not want to preload events by default.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	

				(object)array(
					'id'		=> 'ajax_suppress_filters',
					'label'		=> __('Suppress filters','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('This option was added specifically for partial compatibility with the qtranslate plugin.  Turning it on may break third party plugins that modify event content.  The qtranslate slug plugin is also need for further compatibility.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				
				(object)array(
					'type'=>'clear'
				),
				
				
				(object)array(
					'type' 			=> 'subtitle',
					'label'			=> __('jQuery UI','rhc')
				),	
					
				(object)array(
					'id'			=> 'frontend_jquery_ui',
					'label'			=> __('Frontend jQuery UI version','rhc'),
					'description'	=> sprintf("<p>%s</p><p>%s</p>",
						__('Specify the jQuery UI version to load in the frontend and backend.  By default it loads 1.9.0 on WP3.5 and higher and 1.8.22 on pre WP3.5','rhc'),
						__('If you choose to skip loading the bundled jQuery UI, you need to make sure that the theme or plugin loads it.','rhc')
					),
					'type'			=> 'select',
					'default'		=> '',
					'options'		=> array(
						''			=> __('Auto','rhc'),
						'rhc-jquery-ui-1-9-0'	=> __('jQuery UI 1.9.0','rhc'),
						'rhc-jquery-ui-1-8-22'	=> __('jQuery UI 1.8.22','rhc'),
						'rhc-jquery-ui-1-10-3'	=> __('jQuery UI 1.10.3','rhc'),
						'none'		=> __('Do not load bundled jQuery UI','rhc'),
						'wp'		=> __('Load current WordPress jQuery UI','rhc')
					),
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
					
				(object)array(
					'id'			=> 'backend_jquery_ui',
					'label'			=> __('Backend jQuery UI version','rhc'),
					'type'			=> 'select',
					'default'		=> '',
					'options'		=> array(
						''			=> __('Auto','rhc'),
						'rhc-jquery-ui-1-9-0'	=> __('jQuery UI 1.9.0','rhc'),
						'rhc-jquery-ui-1-8-22'	=> __('jQuery UI 1.8.22','rhc'),
						'rhc-jquery-ui-1-10-3'	=> __('jQuery UI 1.10.3','rhc'),
						'none'		=> __('Do not load bundled jQuery UI','rhc'),
						'wp'		=> __('Load current WordPress jQuery UI','rhc')
					),
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),					
				(object)array(
					'id'			=> 'righthere_api_url',
					'type' 			=> 'select',
					'label'			=> __('Registration api url','rhc'),
					//'description'	=> __('If you keep getting the message "Service not available." when trying to add a license, switch this to Option 2 to try an alternative.','rhc'),
					'description'	=> __('This option is currently not available.','rhc'),
					'options'		=> array(
						''			=> __('Default','rhc')/*,
						'secondary'	=> __('Option 2','rhc')*/
					),					
					'save_option'=>true,
					'load_option'=>true
				),		
				
				(object)array(
					'type'=>'subtitle',
					'label'=>__('Upcoming events widget','rhc')
				),
				(object)array(
					'id'		=> 'uew_original_enable',
					'label'		=> __('Use original upcoming events widget.','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('If you experience problems with the upcoming events widget after updating, use this option to go back to the original upcoming events widget code.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'id'		=> 'enable_uew_author_dropdown',
					'label'		=> __('Use author dropdown in settings.','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Choose No in sites with too many users so that an open text field is shown in the Upcoming Events Widget settings instead of a dropdon for the author attribute.','rhc')
					),
					'default'	=> '1',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),				
				
											
				(object)array(
					'type'=>'clear'
				),
				(object)array(
					'type'=>'subtitle',
					'label'=>__('Improved events query','rhc')
				),							
				(object)array(
					'id'		=> 'original_ajax_enable',
					'label'		=> __('Ajax events query version.','rhc'),
					'type'		=> 'select',
					'description'=> sprintf('<p><strong>%s</strong>%s</p><p><strong>%s</strong>%s</p>',
						__('Version 3.1.4'),
						__('Requires PHP 5.3 or greater.  If PHP requirement is not met, will fallback to version 2.4.4.  Uses a supplementary wp_rhc_events table for faster querying of recurring events','rhc'),
						__('Version 2.4.4'),
						__('Implemented a pair of post meta data that defined the event range start and end.  Faster than the original query methods.','rhc')
					),
					'options'	=> array(
						'0'	=> __('Latest version (3.1.4)','rhc'),
						'2'	=> __('Version 2.4.4', 'rhc'),
						'1'	=> __('Original', 'rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'id'		=> 'force_recur_update',
					'label'		=> __('Force ajax install.','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Turning this option will reset the internal ajax version so that it re-installs needed tables and re-generate event recurring dates.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),					
				(object)array(
					'type'		=> 'callback',
					'callback'	=> array(&$this,'handle_fc_range_check')
				),				
				(object)array(
					'type'=>'clear'
				),
				(object)array(
					'id'		=> 'ajax_catch_warnings',
					'label'		=> __('Ajax catch php warnings.','rhc'),
					'type'		=> 'yesno',
					'description'=> __('Choose yes if the calendar is rendered but events are not showing.  You can verify the browser console, and check if the ajax dat is returned with a php warning.  If that is the case, turning on this option will try to catch and discard the warning so it doesnt breaks the expected calendar data.','rhc'),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'id'		=> 'force_browser_cache',
					'label'		=> __('Force disable browser cache','rhc'),
					'type'		=> 'yesno',
					'description'=> __('Force disable browser cache.','rhc'),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),				
				
				//---------
				(object)array(
					'id'		=> 'disable_icalendar_utc',
					'label'		=> __('Disable iCal UTC','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Up to version 2.4.4 ical dates where set in local time.  Latest version default converts dtstart, dtend, rdate and exrdate to UTC depending on the configured offset in WordPress settings.  Choose yes to disable converting dates.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				
				(object)array(
					'id'		=> 'disable_google_map_api_load',
					'label'		=> __('Disable loading google map api','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Choose yes if you are using another plugin or if the theme loads google maps api.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				
				(object)array(
					'id'		=> 'disable_google_map_api_load_backend',
					'label'		=> __('Disable loading google map api in wp-admin','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Choose yes if you are using another plugin or if the theme loads google maps api in wp-admin.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				
				(object)array(
					'id'		=> 'trouble_force_gmap3',
					'label'		=> __('Force Google Map scripts output','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('Choose yes if you are using the Accordion Upcoming Events widget, and the google map is not showing in the widget content.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),					
				
				(object)array(
					'id'			=> 'rhc_scripts_on_specific_pages',
					'type' 			=> 'textarea',
					'label'			=> __('Load Scripts and Styles on page id','rhc'),
					'description'	=> __('Specify comma separated page ids where you wich the calendarize it scripts and styles to be loaded.  Please observe that upcoming events widget needs them also.','rhc'),
					'el_properties' => array('rows'=>'15','cols'=>'50'),
					'save_option'=>true,
					'load_option'=>true
				),
												
				(object)array(
					'type'=>'clear'
				),
				
				(object)array(
					'type'=>'subtitle',
					'label'=>__('Theme integration','rhc')
				),	
				(object)array(
					'id'			=> 'rhc_theme_meta_fields',
					'type' 			=> 'textarea',
					'label'			=> __('Theme meta fields','rhc'),
					'description'	=> __('Specify comma separated meta field names used by the theme to store layout information per post.  This is used if for example the theme allows to configure a sidebar per page, but it is not showing in the event page although it has been configured on the template.','rhc'),
					'el_properties' => array('rows'=>'15','cols'=>'50'),
					'save_option'=>true,
					'load_option'=>true
				),		
				
				(object)array(
					'type'=>'clear'
				),	
				
				(object)array(
					'type'=>'subtitle',
					'label'=>__('Compatibility fixes','rhc')
				),				

				(object)array(
					'id'			=> 'save_post_priority',
					'type' 			=> 'select',
					'label'			=> __('Save post priority','rhc'),
					'options'		=> array(
						''		=> __('Normal(10/default)','rhc'),
						'high'	=> __('Higher priority(3)','rhc'),
						'max'	=> __('Max priority(1)', 'rhc')
					),
					'description'	=> sprintf( "<p>%s</p><p>%s</p>",
						__('Problem: When saving an event, it does not show in the calendar and there are no javascript errors.','rhc'),
						__('Cause: A third party plugin(or the theme) is crashing in the save_post action hook and not letting the calendar generate required metadata.','rhc')
					),
					'el_properties' => array(),
					'save_option'=>true,
					'load_option'=>true
				),	

				(object)array(
					'type'=>'clear'
				),				
				
				(object)array(
					'type'=>'subtitle',
					'label'=>__('Downloads','rhc')
				),
				
				(object)array(
					'id'		=> 'alt_temp',
					'label'		=> __('Use uploads as temp folder','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p><p>%s</p>',
						__('Turn this option ON if you are getting the error message "There was an error extracting the bundled resources" when downloading addons.','rhc'),
						__('This option was originally created for IIS hosted sites that have problem downloading DLC.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				
				(object)array(
					'type'=>'clear'
				),	

				(object)array(
					'type'=>'subtitle',
					'label'=>__('Single event (version 2)','rhc')
				),	

				(object)array(
					'id'		=> 'single_event_the_content',
					'label'		=> __('Apply the_content filter to the Event page content','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('This option may fix issues where sharing buttons are not showing on the event page.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'id'			=> 'menu_position',
					'type' 			=> 'text',
					'label'			=> __('Menu Position (number)','rhc'),
					'description'	=> __('If the calendarize menu does not show in the admin menu, use this option to change its position.  For cases where other plugins overwrite Calendarize It! menu position.','rhc'),
					'el_properties' => array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				
				(object)array(
					'id'		=> 'disable_static_list',
					'label'		=> __('Disable static event list.','rhc'),
					'type'		=> 'yesno',
					'description'=> sprintf('<p>%s</p>',
						__('A static list of events is rendered in a noscript tag for people browsing the calendar without javascript.  This makes the events visible to search enginges too.','rhc')
					),
					'default'	=> '0',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),					

				(object)array(
					'type' 			=> 'subtitle',
					'label'			=> __('Clear event colors.','rhc'),
					'description'	=> sprintf('<p>%s</p><p>%s</p>',
						__('This action cannot be undone!','rhc'),
						__('The text color and color background of all events will be cleared.  This action includes custom post types that have been calendarized.','rhc')
					)
				),		
					
				(object)array(
					'id'		=> 'btn_clear_event_color',
					'label'		=> __('Clear all event colors','rhc'),
					'type'		=> 'callback',
					'callback'	=> array(&$this,'render_clear_event_color'),
					'el_properties'	=> array(),
					'save_option'=>false,
					'load_option'=>false
				),	

				(object)array(
					'type'=>'clear'
				),					
				
				(object)array(
					'type' 			=> 'subtitle',
					'label'			=> __('Upgrading bugs','rhc')
				),					

				(object)array(
					'id'		=> 'btn_wp41_empty_posts_bug',
					'label'		=> __('WP 4.1 cannot delete events','rhc'),
					'type'		=> 'callback',
					'description' => __('After upgrading to WP 4.1, as an admin you cannot edit or trash events created by other users before the upgrade.','rhc'),
					'callback'	=> array(&$this,'render_btn_wp41_empty_posts_bug'),
					'el_properties'	=> array(),
					'save_option'=>false,
					'load_option'=>false
				),	
				
				(object)array(
					'id'		=> 'enable_addons',
					'label'		=> __('Enable add-ons.','rhc'),
					'type'		=> 'yesno',
					'default'	=> '1',
					'description'=> __('If an addon is generating php warnings, it may break the downloads section preventing add-on update.  Turn this off, update the addon, and turn this option back on.','rhc'),
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),				

				(object)array(
					'id'		=> 'btn_wp44_empty_taxonomy_metadata',
					'label'		=> __('WP 4.4 taxonomy metadata dissappeared.','rhc'),
					'type'		=> 'callback',
					'description' => __('After upgrading to WP 4.4, taxonomy metadata have dissappeared.  Example venue and organizer details are empty.','rhc'),
					'callback'	=> array(&$this,'render_btn_wp44_empty_taxonomy_metadata'),
					'el_properties'	=> array(),
					'save_option'=>false,
					'load_option'=>false
				),				
				
				(object)array(
					'type'=>'clear'
				),	
				
				(object)array(
					'id'		=> 'enable_notifications',
					'label'		=> __('Enable notifications on non options pages.','rhc'),
					'type'		=> 'yesno',
					'default'	=> '1',
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				
				(object)array(
					'type'=>'clear'
				),						

				(object)array(
					'type' 			=> 'subtitle',
					'label'			=> __('Theme issues','rhc')
				),	
				(object)array(
					'id'		=> 'bug_fix_theme_single_title',
					'label'		=> __('Single event shows template title instead of event.','rhc'),
					'type'		=> 'yesno',
					'default'	=> '0',
					'description'=> __('This applies to theme integration version 2.  Turn this option on if the single event page shows the template page title, instead of the event title','rhc'),
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'type'=>'clear'
				),	

				(object)array(
					'type' 			=> 'subtitle',
					'label'			=> __('Visual Composer','rhc')
				),
				
				(object)array(
					'id'		=> 'enable_rhc_vc',
					'label'		=> __('Enable Visual Composer module','rhc'),
					'type'		=> 'onoff',
					'default'	=> '1',
					'description'=> __('If you are experiencing issues with the visual composer module, you can turn this option off to disable it.','rhc'),
					'el_properties'	=> array(),
					'save_option'=>true,
					'load_option'=>true
				),	
				(object)array(
					'type'=>'clear'
				),					

				
				(object)array(
					'type'	=> 'submit',
					'label'	=> __('Save','rhc'),
					'class' => 'button-primary',
					'save_option'=>false,
					'load_option'=>false
				)								
			);
		}				
				
		return $t;
	}

	function render_btn_wp41_empty_posts_bug(){
		global $rhc_plugin;
		$out = sprintf('<span>%s</span><br>', __('WP 4.1 cannot delete events','rhc') );
		$out .= sprintf('<input type="submit" name="btn_wp41_empty_posts_bug" value="%s" class="button-primary" />',
			htmlspecialchars(__('Click to fix','rhc'))
		);
		return $out;
	}
	
	function render_btn_wp44_empty_taxonomy_metadata(){
		global $rhc_plugin;
		$out = sprintf('<span>%s</span><br>', __('WP 4.4 taxonomy metadata dissappeared.','rhc') );
		$out .= sprintf('<input type="submit" name="btn_wp44_empty_taxonomy_metadata" value="%s" class="button-primary" />',
			htmlspecialchars(__('Click to fix','rhc'))
		);
		return $out;	
	}
	
	function render_clear_event_color(){
		global $rhc_plugin;
		$out = sprintf('<input type="submit" OnClick="javascript:return confirm(\'%s\');" name="btn_clear_event_color" value="%s" class="button-primary" />',
			__('This action cannot be undone!  Confirm to remove all event font color and background color.','rhc'),
			htmlspecialchars(__('Clear all event colors.','rhc'))
		);
		return $out;
	}
	
	function cb_rhc_cache(){
		global $wpdb;
		$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}rhc_cache'");
		if(!count($tables)){
			$charset_collate = '';  
			if ( ! empty($wpdb->charset) )$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )$charset_collate .= " COLLATE $wpdb->collate";
			$result = $wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}rhc_cache` (
			  `request_md5` char(32) NOT NULL,
			  `user_id` int(11) NOT NULL DEFAULT '0',
			  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `action` varchar(50) DEFAULT NULL,
			  `response` longtext NOT NULL,
			  PRIMARY KEY (`request_md5`,`user_id`)
			) $charset_collate;");
			
			if(false===$result){
				return __('Error trying to create cache table.','rhc').' '.$wpdb->last_error;
			}			
		}
		return '';
	}
	
	function handle_fc_range_check(){
		global $wpdb;
		$sql = "SELECT COUNT(O.post_id) AS total FROM $wpdb->postmeta O LEFT JOIN $wpdb->postmeta P ON (O.post_id=P.post_id AND P.meta_key='fc_range_start') WHERE P.meta_id IS NULL AND (O.meta_key='fc_start' AND O.meta_value!='')";
		$total = intval( $wpdb->get_var($sql,0,0) );		

		if($total>0){
			$sql="SELECT O.post_id AS post_id FROM $wpdb->postmeta O LEFT JOIN $wpdb->postmeta P ON (O.post_id=P.post_id AND P.meta_key='fc_range_start') WHERE P.meta_id IS NULL AND (O.meta_key='fc_start' AND O.meta_value!='') LIMIT 1000";
			$post_ids = $wpdb->get_col($sql,0);
			if(is_array($post_ids) && $post_ids>0){
				foreach($post_ids as $post_ID){
					$notused=apply_filters('generate_calendarize_meta',$post_ID,null);
				}
			}
		}
		return '';
	}

	function save_file_cache(){
		if( iis7_supports_permalinks() ){
			return;
		}
		global $rhc_plugin;	
		if( '1'==$rhc_plugin->get_option('file_cache','',true) ){
			$content = $this->get_htaccess();
			$rules_arr = explode( "\n", $content );
		}else{
			$rules_arr = array();
		}
		
		$filename = get_home_path() . '.htaccess';
		
		if (file_exists( $filename ) && is_writeable( $filename ) ) {
			$str = file_get_contents($filename);
			if(false===strpos($str,'BEGIN RHC')){
				$prepend = "# BEGIN RHC\n";
				$prepend.= "# END RHC\n";
				$str = $prepend.$str;
				file_put_contents($filename,$str);
			}
		}		
		
		insert_with_markers( $filename, 'RHC', $rules_arr);
	}
	
	function get_htaccess($htmlentities=false){
		global $rhc_plugin;

		$home_root = parse_url(home_url());
		if ( isset( $home_root['path'] ) )
			$home_root = trailingslashit($home_root['path']);
		else
			$home_root = '/';
			
		
		$output = "<IfModule mod_rewrite.c>\n";
		$output.= "RewriteEngine On\n";
		$output.= "RewriteBase $home_root\n";
		
		$output.= "RewriteCond &%{QUERY_STRING} &rhc_action=([^&]+) [NC]\n";
		$output.= "RewriteCond %1!&%{QUERY_STRING} (.+)!.*&_=([^&]+) [NC]\n";
		
		$cache_path = trailingslashit($rhc_plugin->calendar_ajax->get_cache_path());
		$rewrite_path = str_replace(ABSPATH,'',$cache_path);
		
		$cond = trailingslashit(trim($home_root.$rewrite_path,'/'));
		$output .= "RewriteCond %{DOCUMENT_ROOT}/{$cond}%1/%2 -f\n";
		$output .= "RewriteRule (.*) ".trailingslashit($rewrite_path)."%1/%2 [L]\n";
		//$output .= "#RewriteRule . atest.php?sample=wp-content/uploads/calendarize-it/cache/%1/%2 [L]\n";
		$output.= "</IfModule>\n";
		
		if($htmlentities){
			$output = htmlentities($output);
		}
		
		return $output;
	}	
	
	function render_rhc_cache_clear(){
		global $rhc_plugin;
		$out = sprintf('<input type="submit" name="rhc_cache_clear" value="%s" class="button-primary" />',htmlspecialchars(__('Clear Cache','rhc')));
		return $out;
	}	
}
?>