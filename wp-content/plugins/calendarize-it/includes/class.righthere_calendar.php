<?php

class righthere_calendar {
	var $taxonomies = array();
	var $adm_event_list_disabled_tax = array();
	function __construct($args=array()){
		$defaults = array(
			'show_ui'				=> true,
			'show_in_menu'			=> 'rhc',
			'menu_position'			=> null
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}	
		//---------
		global $rhc_plugin;
		$init_hook = '1'==$rhc_plugin->get_option('ignore_wordpress_standard',false,true)?'setup_theme':'init';
		//add_action($init_hook,array(&$this,'init'));
		$this->add_action_init_hook( $init_hook, array(&$this,'init') );
		
		add_action('admin_init',array(&$this,'admin_init'));
		add_action('restrict_manage_posts',array(&$this,'restrict_manage_posts'));
		add_filter( 'pre_get_posts', array(&$this,'pre_get_posts') );	
		add_filter('rhc-taxonomies',array(&$this,'rhc_taxonomies'),10,1);
		//----
		$this->taxonomies = apply_filters('rhc-taxonomies',array(
			RHC_CALENDAR 	=> __('Calendar','rhc'),
			RHC_ORGANIZER	=> __('Organizer','rhc'),
			RHC_VENUE		=> __('Venues','rhc')
		));

		if(count($this->taxonomies)>0){
			foreach($this->taxonomies as $taxonomy => $label){
				add_filter("$taxonomy-object-type",array(&$this,'add_taxonomy_post_types'),10,2);
			}		
		}
		//----
		$this->adm_event_list_disabled_tax = $rhc_plugin->get_option( 'adm_lst_disabled_tax', array(), true );
		$this->adm_event_list_disabled_tax = is_array( $this->adm_event_list_disabled_tax ) ? $this->adm_event_list_disabled_tax : array() ;
	}
	
	function add_action_init_hook( $init_hook, $cb, $priority=10 ){
		//vc loads on init priority 9 and thus when form fields data is obtained our taxonomies are not registered yet.
		if( defined('DOING_AJAX') && DOING_AJAX && isset( $_REQUEST['action'] ) && $_REQUEST['action']=='vc_edit_form' ){
			$priority = 8;
		}
		add_action($init_hook, $cb, $priority);
	}
	
	function rhc_taxonomies($taxonomies){
		global $rhc_plugin;
		foreach(array(RHC_CALENDAR,RHC_ORGANIZER,RHC_VENUE) as $tax){
			if(isset($taxonomies[$tax]) && $rhc_plugin->get_option('disable_'.$tax,0,true) )
				unset($taxonomies[$tax]);		
		}
		return $taxonomies;
	}
	
	function add_taxonomy_post_types($taxonomy,$post_type){
		//this filter is applied in class.custom_taxonomy_with_meta.php
		if(is_array($post_type)){
			$post_types = $post_type;
		}else{
			$post_types[]=$post_type;
		}
		//--
		global $rhc_plugin;
		$taxonomy_post_types = $rhc_plugin->get_option($taxonomy.'_post_types',array(),true);
		if(is_array($taxonomy_post_types)&&count($taxonomy_post_types)>0){
			$post_types = array_merge($post_types,$taxonomy_post_types);
		}	
		return $post_types;
	}
	
	function init($install=false){
		global $rhc_plugin; 
		//NEW POST TYPE	
		$slug = $rhc_plugin->get_option('rhc-events-slug',RHC_EVENTS,true);
		$exclude_from_search = $rhc_plugin->get_option('disable_event_search',false,true);
		
		$capabilities = array(
            	'edit_post' 			=> 'edit_'.RHC_CAPABILITY_TYPE,
				'read_post'				=> 'read_'.RHC_CAPABILITY_TYPE,
            	'delete_post'			=> 'delete_'.RHC_CAPABILITY_TYPE,
            	'edit_posts'			=> 'edit_'.RHC_CAPABILITY_TYPE.'s',
            	'edit_others_posts'		=> 'edit_others_'.RHC_CAPABILITY_TYPE.'s',
            	'publish_posts'			=> 'publish_'.RHC_CAPABILITY_TYPE.'s',
            	'read_private_posts'	=> 'read_private_'.RHC_CAPABILITY_TYPE.'s',
            	'read'					=> 'read',
            	'delete_posts'			=> 'delete_'.RHC_CAPABILITY_TYPE.'s',
            	'delete_private_posts'	=> 'delete_private_'.RHC_CAPABILITY_TYPE.'s',
            	'delete_published_posts'=> 'delete_published_'.RHC_CAPABILITY_TYPE.'s',
            	'delete_others_posts'	=> 'delete_others_'.RHC_CAPABILITY_TYPE.'s',
            	'edit_private_posts'	=> 'edit_private_'.RHC_CAPABILITY_TYPE.'s',
            	'edit_published_posts'	=> 'edit_published_'.RHC_CAPABILITY_TYPE.'s'	
			);
		
		$capabilities = apply_filters('rhc_event_caps',$capabilities);
		
		$hierarchichal_events = '1'==$rhc_plugin->get_option('hierarchichal_events','0',true) ? true : false;
		
		register_post_type( RHC_EVENTS, array(
			'label' => __('Events','rhc'),
			'labels' => array(
				'menu_name'			=> __('Calendarize It','rhc'),
				'all_items'			=> __('Events','rhc'),
				'name' 				=> __('Events','rhc'),
				'singular_name' 	=> __('Event','rhc'),
				'add_new' 			=> __('Add new event','rhc'),
				'edit_item' 		=> __('Edit event','rhc'),
				'new_item' 			=> __('New event','rhc'),
				'view_item'			=> __('View event','rhc'),
				'search_items'		=> __('Search events','rhc'),
				'not_found'			=> __('No events found','rhc'),
				'not_found_in_trash'=> __('No events found in trash','rhc'),
				'add_new_item'		=> __('Add new event','rhc')
			),
			'public' => true,
			'show_ui' => true,
			'map_meta_cap'	=> true,
			'capability_type' => RHC_CAPABILITY_TYPE,
			'capabilities'	=> $capabilities,
			'hierarchical' => $hierarchichal_events,
			'has_archive'	=> false,
			'rewrite' => array(
				'slug'			=> $slug,
				'with_front'	=> false
			),
			'query_var' => true,
			'supports' => array('title','editor','excerpt','revisions','page-attributes','comments','author','thumbnail'/*,'custom-fields'*/),
			'exclude_from_search' => $exclude_from_search,
			'menu_position' => $this->menu_position,
			'show_in_menu'=>$this->show_in_menu,
			'show_in_nav_menus' => false,
			'taxonomies' => array(),
			'menu_icon'=> 'dashicons-calendarize-it'		
		));
		
		
		//-- Custom taxonomies
		require_once RHC_PATH.'custom-taxonomy-with-meta/class.custom_taxonomy_with_meta.php';  

		//-- Calendar
		if(isset($this->taxonomies[RHC_CALENDAR]))
			require_once RHC_PATH.'includes/class.rhc_calendar.php';
		
		//-- Organizers --------------------------------------
		if(isset($this->taxonomies[RHC_ORGANIZER]))
			require_once RHC_PATH.'includes/class.rhc_organizers.php';
		
		//-- Venues
		if(isset($this->taxonomies[RHC_VENUE]))
			require_once RHC_PATH.'includes/class.rhc_venues.php';
		
		
		do_action('rhcevents_init');
	}	
	
	function admin_init(){
		global $wp_version;
		if($wp_version<3.3){
			add_filter( sprintf('manage_edit-%s_columns',RHC_EVENTS), array(&$this,'admin_columns')  );
			add_action( 'manage_posts_custom_column', array(&$this,'custom_column'),10,2);					
		}else{
			add_filter( sprintf('manage_%s_posts_columns',RHC_EVENTS), array(&$this,'admin_columns')  );
			add_action( sprintf('manage_%s_posts_custom_column',RHC_EVENTS), array(&$this,'custom_column'),10,2);				
		}
		//-- filter for sortable custom post type fields
		add_filter( sprintf('manage_edit-%s_sortable_columns',RHC_EVENTS), array(&$this,'register_sortable_column'), 10, 1 );
		add_filter( 'request', array(&$this,'events_column_orderby'), 10, 1 );
	}	
	
	function events_column_orderby( $vars ){
		if( isset($vars['orderby']) && 'fc_start'==$vars['orderby'] ){
			$vars = array_merge( $vars, array(
					'meta_key' => "fc_start",
					'orderby' => 'meta_value'
				)
			);
		}
		return $vars;
	}
	
	function register_sortable_column($columns){
		$columns['fc_start']='fc_start';
		return $columns;
	}
	
	function admin_columns($defaults){
		//--currently only for tags as categories
		$map = array(
			'tags' 		=> 'post_tag',
			'categories'=> 'category'
		);
		if( count($defaults) > 0 && count($this->adm_event_list_disabled_tax) > 0 ){
			foreach( $defaults as $index => $ignore){
				if( isset($map[$index]) && in_array( $map[$index], $this->adm_event_list_disabled_tax) ){
					unset($defaults[$index]);
				}
			}
		}
		//--	
		$new = array();
		foreach($defaults as $key => $title){
			$new[$key]=$title;
			if($key=='title'){
				$new['fc_start']=__("Start",'rhc');
				if(!empty($this->taxonomies)){
					foreach($this->taxonomies as $tax => $label){
						if( count($this->adm_event_list_disabled_tax) > 0 && in_array( $tax, $this->adm_event_list_disabled_tax ) )
							continue;
						$new[$tax]=$label;					
					}
				}
			}
		}
		return $new;
	}
	
	function custom_column($field, $post_id=null){
		global $post;	
		$post_id = $post_id==null?$post->ID:$post_id;
		$taxonomies = array_keys($this->taxonomies);// array(RHC_CALENDAR,RHC_VENUE,RHC_ORGANIZER);
		//-----
		$meta_fields = array();
		//-----
		if(in_array($field,$taxonomies)){
			$groups = get_the_terms($post_id, $field);
			$tmp = array();
			if(is_array($groups)&&count($groups)>0){
				foreach($groups as $group){
					$tmp[]=$group->name;
				}
			}
			echo implode(",",$tmp);
		}else if(in_array($field,$meta_fields)){
			echo get_post_meta($post_id,$field,true);
		}else if($field=='fc_start'){
			$format = get_option('date_format');
			$raw = get_post_meta($post_id,$field,true);
			if(''!=trim($raw)){
				echo date($format,strtotime($raw));
			}
		}
	}
	
	function restrict_manage_posts($arg){
		if(isset($_REQUEST['post_type'])&&$_REQUEST['post_type']==RHC_EVENTS){
?>
<label class="rhc_filter_label"><?php _e('Event start (YYYY-mm-dd)','rhc')?></label>:&nbsp;<input class="rhc_list_filter" type="" name="rhc_filter_fc_start" value="<?php echo @$_REQUEST['rhc_filter_fc_start']?>" title="<?php _e('You can also write the year only, or the year and the month.  Example 2012-06 to get events from june 6.','rhc')?>" />
<?php if(isset($this->taxonomies[RHC_VENUE])):?>
<label class="rhc_filter_label rhc_opt_filter"><?php _e('Venue','rhc')?></label>:&nbsp;<?php wp_dropdown_categories( array('class'=>'rhc_opt_filter','selected'=>(isset($_REQUEST['f_rhc_venue'])?$_REQUEST['f_rhc_venue']:0), 'name'=>'f_rhc_venue','id'=>'f_rhc_venue', 'show_option_all'=> sprintf('--%s--',__('show all','rhc')),'taxonomy'=>RHC_VENUE,'orderby'=>'NAME') );?>
<?php endif;?>
<?php if(isset($this->taxonomies[RHC_CALENDAR])):?>
<label class="rhc_filter_label rhc_opt_filter"><?php _e('Calendar','rhc')?></label>:&nbsp;<?php wp_dropdown_categories( array('class'=>'rhc_opt_filter','selected'=>(isset($_REQUEST['f_rhc_calendar'])?$_REQUEST['f_rhc_calendar']:0), 'name'=>'f_rhc_calendar','id'=>'f_rhc_calendar', 'show_option_all'=> sprintf('--%s--',__('show all','rhc')),'taxonomy'=>RHC_CALENDAR,'orderby'=>'NAME') );?>
<?php endif;?>
<?php if(isset($this->taxonomies[RHC_ORGANIZER])):?>
<label class="rhc_filter_label rhc_opt_filter"><?php _e('Organizer','rhc')?></label>:&nbsp;<?php wp_dropdown_categories( array('class'=>'rhc_opt_filter','selected'=>(isset($_REQUEST['f_rhc_organizer'])?$_REQUEST['f_rhc_organizer']:0), 'name'=>'f_rhc_organizer','id'=>'f_rhc_organizer', 'show_option_all'=> sprintf('--%s--',__('show all','rhc')),'taxonomy'=>RHC_ORGANIZER,'orderby'=>'NAME') );?>
<?php endif;?>
<?php		
		}
	}	
	
	function pre_get_posts($query){
		if( is_admin() && isset( $query->query['post_type'] ) && $query->query['post_type']==RHC_EVENTS){
			if(isset($_REQUEST['rhc_filter_fc_start'])&&trim($_REQUEST['rhc_filter_fc_start'])!=''){
				if(strlen($_REQUEST['rhc_filter_fc_start'])==10){
					$query->set( 'meta_key', 	'fc_start' );
					$query->set( 'meta_value', 	$_REQUEST['rhc_filter_fc_start']);						
				}else{
					$query->set( 'meta_query', array(
						array(
							'key'=>'fc_start',
							'value'=>$_REQUEST['rhc_filter_fc_start'],
							'compare'=> 'LIKE'
						)
					));	
				}
 			}
			//--
			foreach(array('f_rhc_venue'=>RHC_VENUE,'f_rhc_calendar'=>RHC_CALENDAR,'f_rhc_organizer'=>RHC_ORGANIZER) as $field => $taxonomy){
				if(isset($_REQUEST[$field])&&$_REQUEST[$field]>0){
					$term = get_term($_REQUEST[$field],$taxonomy);
					$query->set( $taxonomy , $term->slug );
					$query->is_tax = true ;	// Doesnt seems that edit.php follows a standard wp_query get_posts						
				}					
			}			
		}
	}	
}
?>