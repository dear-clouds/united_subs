<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class calendar_ajax {
	var $numberposts = -1;
	var $skip_duplicates = true;
	var $done_ids = array();
	var $request_md5=false;
	var $month_event_image=false;
	var $post_status = false;
	var $is_search = false;
	function __construct(){
		global $rhc_plugin;
		if( '1'==$rhc_plugin->get_option('cal_month_event_image','',true) || '1'==$rhc_plugin->get_option('cal_month_event_image_metabox','',true)){
			$this->month_event_image = true;	
		}
	
		//add_action('wp_loaded', array(&$this,'init'));
		add_action('init', array(&$this,'init'),11);
		$this->fc_intervals = array(
					''			=> __('Never(Not a recurring event)','rhc'),
					'1 DAY'		=> __('Every day','rhc'),
					'1 WEEK'	=> __('Every week','rhc'),
					'2 WEEK'	=> __('Every 2 weeks','rhc'),
					'1 MONTH'	=> __('Every month','rhc'),
					'1 YEAR'	=> __('Every year','rhc')
				);		
		//$this->init();	
	}
	
	function init(){
		if(!isset($_REQUEST['rhc_action']))return;
		define('DONOTCACHEPAGE',true);//compat fix wp super cache
		$action = $_REQUEST['rhc_action'];
//sleep(10);
		$this->handle_browser_headers();
//error_log( date('YmdHis')."\n",3,ABSPATH.'api.log' );		
		$this->handle_rhc_cache($_REQUEST);
	
		if(method_exists($this,$action))$this->$action();
	}
	
	function handle_rhc_cache( $request, $return=false ){
		global $rhc_plugin,$wpdb;

		if('1'==$rhc_plugin->get_option('disable_rhc_cache','',true))return false;
		$client_md5 = isset($request['_']) ? $request['_'] : '';
		
		if(isset($request['_'])){
			unset($request['_']);
		}

		$query_arr = array();
		foreach( $request as $field => $value ){
			if(is_array($value)){
				foreach($value as $v){
					
					$query_arr[]=sprintf("%s[]=%s",$field,$v);
				}			
			}else{
				$query_arr[]="$field=$value";
			}
		}
		
		$query_string = implode('&',$query_arr);

		$this->request_md5 = md5($query_string);						
		
		$minutes_field 		= isset($request['rhc_action']) ? 'rhc_cache_minutes' : 'rhc_external_cache_minutes' ;
		$default_minutes 	= isset($request['rhc_action']) ? '10080' : '120'; 
		$minutes = intval($rhc_plugin->get_option($minutes_field,$default_minutes,true));//default to a week for local and 2 hour for external sources.
		if($minutes==0)return false;

		$user_id = ('1'==$rhc_plugin->get_option('rhc_cache_by_user','',true)) ? intval(get_current_user_id()) : 0 ;
		
		$sql = "SELECT `response` FROM `{$wpdb->prefix}rhc_cache` C ";
		$sql.= " WHERE (1)";
		$sql.= " AND( `request_md5`='{$this->request_md5}')";
		$sql.= " AND( `user_id`={$user_id} )";
		$sql.= " AND( DATE_ADD(C.cdate, INTERVAL $minutes MINUTE) > NOW() )";
		$sql = "SELECT COALESCE(($sql),'')";
		$cached_response = $wpdb->get_var($sql,0,0);
		if(!empty($cached_response)){
			//--
			global $rhc_plugin;
			if(false===$return && '1'==$rhc_plugin->get_option('ajax_catch_warnings','',true)){
				ob_end_clean();
			}
			//---			
//file_put_contents(ABSPATH.'api.log','');				
//error_log(time()." issuing a cached response\n".print_r($request,true)."\n",3,ABSPATH.'api.log');					
			if(false===$return){
				$this->custom_header('rhc-ajax: cache');	
				die($cached_response);
			}else{	
				return $cached_response;
			}
		}	
		return false;
	}
	
	function custom_header($value){
		header($value);
	}
	
	function handle_browser_headers(){
		global $rhc_plugin;
		
		$ajax_catch_warnings = '1'==$rhc_plugin->get_option('ajax_catch_warnings','',true) ? true : false;
		//-- clear output buffer
		if($ajax_catch_warnings){
			ob_end_clean();
		}
		//--- send headers
		if( '1' != $rhc_plugin->get_option('force_browser_cache','',true) ){
			$last_modified = $rhc_plugin->get_option('data-last-modified', gmdate("D, d M Y H:i:s") . " GMT", true);
			header('Cache-Control: max-age=28800');
			header("Last-Modified: $last_modified");
			header('Expires: ' . gmdate('D, d M Y H:i:s', time() + (60*60*24)) . ' GMT');
			/*
			if(false!==$this->request_md5){
				header("Etag: " . $this->request_md5);
			}
			*/
			if( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ){
				if( $last_modified == $_SERVER['HTTP_IF_MODIFIED_SINCE'] ){
					header('HTTP/1.1 304 Not Modified');				
					exit();
				}
			}		
		}		
		//-- 
		if( '1' == $rhc_plugin->get_option('ajax_allow_origin', '0', true) ){
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		}
		
		//-- restart output buffer
		if($ajax_catch_warnings){
			ob_start();
		}
	}
	
	function send_response( $response, $format='json', $return=false, $request=false ){
		$request = false===$request ? $_REQUEST : $request ;
		//--
		global $rhc_plugin;
		if( false===$return && '1'==$rhc_plugin->get_option('ajax_catch_warnings','',true)){
			ob_end_clean();
		}
	
		//---
		if(false!==$this->request_md5){
			$encoded_response = $this->encode_response($response,$format);
			//---save
			try {
				global $wpdb,$rhc_plugin;
				$action = (isset($request['rhc_action'])?$request['rhc_action']:@$request['rhc_addon_action']);
				$action = str_replace('/','',$action);
				$action = stripslashes($action);
				//--
				$user_id = ('1'==$rhc_plugin->get_option('rhc_cache_by_user','',true)) ? intval(get_current_user_id()) : 0 ;
				$sql = $wpdb->prepare("INSERT INTO `{$wpdb->prefix}rhc_cache` (`request_md5`,`user_id`,`cdate`,`action`,`response`)VALUES(%s,%d,NOW(),%s,%s) ON DUPLICATE KEY UPDATE cdate=NOW(),`response`=%s",
					$this->request_md5,
					$user_id,
					$action,
					$encoded_response,
					$encoded_response
				);
//error_log(time()." saving a response to cache\n",3,ABSPATH.'api.log');	
				if($wpdb->query($sql)){
				
				}else{
					
				}			
				
				$this->handle_cache_file_write($this->request_md5, $action, $encoded_response);
			}catch(Exception $e){
			
			}
			//----
		}else{
			$encoded_response = $this->encode_response($response,$format);
		}
		
//error_log(time()." issuing a NON cached response\n",3,ABSPATH.'api.log');
		if(false===$return){
			$this->custom_header('rhc-ajax: active');
			ob_start();
			echo $encoded_response;
			ob_end_flush();
			die();		
		}else{
			return $response;
		}
	}
	
	function get_cache_path( $action=false ){
	
		global $rhc_plugin;
		$upload_dir = wp_upload_dir();

		$resource_path = $upload_dir['basedir'].'/'.$rhc_plugin->resources_path;
		
		if(!is_dir($resource_path)){
			mkdir($resource_path);
		}
		
		$path = $upload_dir['basedir'].'/'.$rhc_plugin->resources_path.'/cache/';				
		if( is_dir($resource_path) && !is_dir($path)){
			mkdir($path);
		}
		
		if(false!==$action){
			$path = $path.$action.'/';
			if( is_dir($path) && is_dir($resource_path) && !is_dir($path)){
				mkdir($path);
			}		
		}
				
		return $path;
	}
	
	function handle_cache_file_write($filename, $action, $content){
		global $rhc_plugin;
		if('1'==$rhc_plugin->get_option('file_cache','',true)  ){

			$filename = stripslashes($filename);
			$filename = str_replace('/','',$filename);
			if( strlen($filename)<33 ){
				$path = $this->get_cache_path( $action );
				$filename = $path.$filename;
				if(false===file_put_contents($filename,$content)){

				}else{
										
				}		
			}
		}
	}
	
	function encode_response($response,$format='json'){
		switch($format){
			case 'json':
				return json_encode($response);	
			default://raw output.
				return $response;
		}
	}
	
	function get_rendered_item(){
		$item_id = explode('-',$_REQUEST['id']);
		if(count($item_id)==2){
			global $wp_query;
			query_posts( 'page_id='.$item_id[0] );	
			query_posts( array(
				'p'=>$item_id[0],
				'post_type'=>$item_id[1]
			) );	

			ob_start();
			wp_head();
			$header = ob_get_contents();
			ob_end_clean();
			
			ob_start();
			include RHC_PATH.'templates/calendar-single-post.php';
			$content = ob_get_contents();
			ob_end_clean();
			
			ob_start();
			wp_footer();
			$footer = ob_get_contents();
			ob_end_clean();
			
			$response = (object)array(
				'R'=>'OK',
				'MSG'=>'',
				'DATA'=>array(
					'body'		=> $content,
					'footer'	=> $footer
				)
			);
			$this->send_response($response);	
		}else{
			$this->send_response(array('R'=>'ERR','MSG'=> __('Invalid item id','rhc') ));
		}
	}
	
	function get_calendar_items(){
		$this->send_response($this->_get_calendar_items());
	}
	
	function get_calendar_events( $request=false, $format='json', $return=false ){
		$request = false===$request ? $_REQUEST : $request;
		if(isset($request['uew']))return $this->get_upcoming_events_widget();
		$map=array();
		$terms=array();
		$r = array(
			'R'			=> 'OK',
			'MSG'		=> '',
			'EVENTS' 	=> $this->shrink_events( $this->_get_calendar_items( false, $request ), $map, $terms, true, $request ),
			'TERMS'		=> $terms,
			'MAP'		=> $map,
			'SEARCH'	=> intval($this->is_search),
			'GMT_OFFSET'=> get_option('gmt_offset')
		);	

		if(isset($request['rhc_debug'])){
			echo "<pre>";
			print_r($r);
			echo "</pre>";			
		}

		return $this->send_response( $r, $format, $return );  
	}

	function shrink_events($r, &$map, &$terms, $skip_empty=true, $request=array()){

		$shrink_level = isset($request['rhc_shrink']) ? intval($request['rhc_shrink']) : 0 ;
		if( $shrink_level > 0 ){
			if(count($r)>0){
				$new_set = array();
				$map=array();
				foreach($r as $ev){
					$new_ev = array();
					//$ev_arr = ;
					foreach( (array)$ev as $field => $value ){
						$new_field = $this->get_shrinked_field_name( $field, $map );
						$map[$field]=$new_field;
						if($skip_empty && empty($value))continue;
						$new_ev[$new_field]=$value;
					}

					//shrink terms
					if( isset($ev['terms']) && count($ev['terms'])>0 ){
						$new_terms = array();
						foreach( $ev['terms'] as $term ){
							$new_term = array();
							foreach( (array)$term as $field => $value ){
								$new_field = $this->get_shrinked_field_name( $field, $map );
								$map[$field]=$new_field;
								if($skip_empty && empty($value))continue;
								$new_term[$new_field]=$value;
							}	
							$new_terms[]=(object)$new_term;
						}
						$new_ev[ $map['terms'] ] = $new_terms;
					}
					
					//pack terms
					
					if( isset($map['term_id']) && isset($ev['terms']) && count($ev['terms'])>0 ){
						$new_terms = array();
						$term_id_index = $map['term_id'];
						foreach($new_ev[ $map['terms'] ] as $term){
							$t = (array)$term;
							$id = $t[$term_id_index];
							
							$terms[$id]=$term;
							if(!in_array($id,$new_terms)){
								$new_terms[]=$id;
							}
						}				
						$new_ev[ $map['terms'] ] = $new_terms;
						
					}


					$new_set[]=(object)$new_ev;
				}
				//--ready map for client side.
				$new_map=array();
				foreach($map as $field => $value){
					$new_map[]=array($value,$field);
				}
				$map = $new_map;
				//--ready terms for client side
				/*
				if(is_array($terms)&&count($terms)>0){
					$new_terms=array();
					foreach($terms as $term){
						$new_terms[]=$term;//remove associative keys. so that js parses it as array and not object.
					}	
					$terms = $new_terms;
				}
				*/
				
				return $new_set;
			}
		}
		return $r;
	}
	
	function get_shrinked_field_name( $field, $map ){
		if(isset($map[$field])){
			return $map[$field];
		}else{
			return count($map);
		}
	}
	
	function get_upcoming_events_widget(){
		global $rhc_plugin;
		
		foreach(array('args','calendar_url','words') as $var){
			$$var = isset($_REQUEST[$var])?$_REQUEST[$var]:null;
		}

		foreach($args as $index => $value){
			if(in_array($value,array('true','false'))){
				$args[$index]=$value=='true'?true:false;
			}
		}
		
		//---
		$valid_args = array(
			'post_type' => false,
			'start'		=> false,
			'end'		=> false,
			'taxonomy'	=> false,
			'terms'		=> false,
			'calendar'	=> false,
			'venue'		=> false,
			'organizer'	=> false,
			'author'	=> false,
			'author_name'=>false,
			'tax'		=> false,
			'tax_by_id' => false,
			'numberposts' => false
		);		
		
		//--only use limited arguments.
		$query_args = array();
		foreach($valid_args as $field => $notusednow){
			if(isset($args[$field])){
				$query_args[$field] = $args[$field];
			}
		}
		//--- do some server side post validation
		$post_types = $rhc_plugin->get_option('post_types',array());
		$post_types[] = RHC_EVENTS;
		if(is_array($query_args['post_type']) && count($query_args['post_type'])>0){
			foreach($query_args['post_type'] as $post_type){
				if(!in_array($post_type,$post_types)){
					$query_args['post_type'] = RHC_EVENTS;
				}
			}
		}else if(is_string($query_args['post_type']) &&!in_array($query_args['post_type'],$post_types) ){
			$query_args['post_type'] = RHC_EVENTS;
		}
		//---
				
		$events = $this->get_events_set($query_args);
		
		if(is_array($events)&&count($events)>0){
			$using_calendar_url = false;
			if($calendar_url!=''){
				$using_calendar_url = true;
				foreach($events as $index => $e){
					$events[$index]['url']=$calendar_url;
				}
			}		
			//---	
			foreach($events as $i => $e){			
				$description = '';
				$drr = explode(' ',$e['description']);
				for($a=0;$a<$words;$a++){
					if(isset($drr[$a]))
						$description.=" ".$drr[$a];
				}
				
				if(count($drr)>$words)
				$description.="<a href=\"".$e['url']."\">...</a>";
				
				$events[$i]['description']=$description;
			}				
		}
	
		$r = array(
			'R'			=> 'OK',
			'MSG'		=> '',
			'EVENTS' 	=> $events
		);		
		$this->send_response($r);
	}
	
	function get_icalendar_events(){
		global $rhc_plugin;
		require 'class.rhc_icalendar.php';
		$_REQUEST['start']=0;
		$_REQUEST['end']=mktime(0,0,0,0,0,date('Y')+20);
		$post_ID = isset($_REQUEST['ID'])&&intval($_REQUEST['ID'])>0?intval($_REQUEST['ID']):false;
		if( '1'==$rhc_plugin->get_option('disable_icalendar_utc','',true) ){
			$gmt_offset = false;
		}else{
			$gmt_offset = get_option('gmt_offset');
		}
		$tzid = apply_filters('rhc_tzid','');
		$vtimezone = apply_filters('rhc_vtimezone','');
		$ical = new events_to_vcalendar( $this->_get_calendar_items($post_ID), $gmt_offset, $tzid, $vtimezone );
		$output=trim($ical->get_vcalendar());
		if(isset($_REQUEST['ics'])){
			if($post_ID>0){
				$filename = "event_".$post_ID.".ics";
			}else{
				$filename = "events.ics";
			}
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Length: ". strlen($output) .";");
			header('Content-Type: text/calendar; charset=utf-8');//change mainly for google.
			header("Content-Disposition: attachment; filename=$filename");
			//header("Content-Type: application/octet-stream; "); 
			header("Content-Transfer-Encoding: binary");		
		}else{
			$this->handle_get_icalendar_events_header();
		}
		die( $output );
	}
	
	function handle_get_icalendar_events_header(){
		if( $_SERVER['HTTP_USER_AGENT']=='Google-Calendar-Importer' ){
			header('Content-Type: text/calendar; charset=UTF-8');
			//Notes: google will not parse if charset utf-8 lowercase is set.
		}else{
			header('Content-Type: text/html; charset=utf-8');
		}
	}
	
	function _get_calendar_items($post_ID=false, $request=false){
		$request = false===$request ? $_REQUEST : $request ;

		global $rhc_plugin;

		$post_types = $rhc_plugin->get_option('post_types',array());
		$post_types[] = RHC_EVENTS;
		
		$post_fields = array(
			'post_type' 	=> RHC_EVENTS,
			'start'		=> date('Y-m-d 00:00:00'),
			'end'		=> date('Y-m-d 23:59:59'),
			'taxonomy'	=> false,
			'terms'		=> false,
			'calendar'	=> false,
			'venue'		=> false,
			'organizer'	=> false,
			'author'	=> false,
			'author_name'=>false,
			'tax'		=> false,
			'tax_by_id'	=> false
		);
		
		//limit query to a specific id.
		if(false!==$post_ID){
			$post_fields['ID']=$post_ID;
		}
		
		foreach($post_fields as $field => $default){
			if($field=='tax_by_id'){
				$value = isset($request[$field])&&$request[$field]=='1'?true:false;
			}else if($field=='start'){
				$value = isset($request[$field])? date('Y-m-d 00:00:00', intval($request['start'])):$default;
			}else if($field=='end'){
				$value = isset($request[$field])? date('Y-m-d 23:59:59', intval($request['end'])):$default;			
			}else{
				$value = isset($request[$field])?$request[$field]:$default;
			}
			$$field = $value;
		}
		
		if(is_array($post_type)){
			$arr = $post_type;
		}else{
			$arr = explode(',',$post_type);
		}
		
		if(is_array($arr)&&count($arr)>0){
			$tmp=array();
			foreach($arr as $post_type){
				if(!in_array($post_type,$post_types)){
					continue;
				}	
				$tmp[]=$post_type;
			}
			if(empty($tmp)){
				return array();
			}else{
				$post_type=$tmp;
			}
		}else{
			if(!in_array($post_type,$post_types)){
				return array();
				//die(json_encode(array()));
			}		
		}
				
		$field_names = array_keys($post_fields);
		
		$args = compact($field_names);		
		if('1'==$rhc_plugin->get_option('show_all_post_types','',true)){
			$args['post_type']=$post_types;
		}
		//--- handle search
		if( isset($request['s']) && !empty($request['s']) ){
			$args['s']=$request['s'];
		}
		//---
		$args['feed'] = isset( $request['feed'] ) ? $request['feed'] : '' ;
		
		return $this->get_events_set($args, $request);
	}
	
	function get_events_set($args, $request=false){
		global $rhc_plugin;
	
		$this->done_ids = array();
		$events = array();
		
		if( isset( $args['feed'] ) && '1'==$args['feed'] ){
			//feed only, do not load local events.
		}else{
			$version = $rhc_plugin->get_option('original_ajax_enable','0',true);
			if( PHP_VERSION_ID < 50300 && $version=='0' ){
				//rollback as this site does not supports some feature from the latest.
				$version='2';
			}
			if( '1'==$version ){
				$events = $this->events_in_start_range($events, $args);
				$events = $this->events_in_rdatetime_range($events, $args); //for some cases where the events on the first day do not show	
				$events = $this->non_recurring_events_in_range($events,$args);//this one is redundant with the previous, but this fails when an end date is not specified, so keep it an just remove the duplicates.		
				$events = $this->recurring_events_with_end_interval($events, $args);
				$events = $this->recurring_events_without_end_interval($events, $args);				
			}else if( '2'==$version ){
				$events = $this->events_in_fc_range($events, $args);
				$events = $this->recurring_events_without_end_interval($events, $args);
			}else{
				$events = $this->events_in_rhc_events($events, $args, $request);
			}		
		}

		return apply_filters('rhc_get_events_set', $events, $args, $request);
	}
	
	function repeat_recurring_events($events){
		return $events;
	}
	
	function get_tooltip_image($post_ID, $attachment_id, $size){
		$image = wp_get_attachment_image_src( $attachment_id, $size );
		if(false===$image){
			$image = (has_post_thumbnail( $post_ID )?wp_get_attachment_image_src( get_post_thumbnail_id( $post_ID ), $this->get_image_size() ):'');
		}
		if(empty($image)){
			global $rhc_plugin;
			$default_id = intval( $rhc_plugin->get_option('default_event_featured_image',0,true) );
			if( $default_id > 0 ){
				$image = wp_get_attachment_image_src( $default_id, $size );	
				$image = false===$image ? '' : $image ;
			}
		}
		
		return $image;
	}
	
	function get_events($r,$args,$request=false){
		$request = false===$request ? $_REQUEST : $request ;
		global $rhc_plugin,$wpdb;
		$disable_event_link = '1'==$rhc_plugin->get_option('disable_event_link')?true:false;
		$ajax_suppress_filters = '1'==$rhc_plugin->get_option('ajax_suppress_filters','0',true)?true:false;
		//----
		$args['numberposts'] = $this->numberposts;
		$args['suppress_filters'] = $ajax_suppress_filters;
//error_log(print_r($args,true)."\n\r",3,ABSPATH.'cal2.log');	
		if(isset($args['author'])&&empty($args['author']))return $r;
		if(isset($args['author_name'])&&empty($args['author_name']))return $r;
		//---- plugin types consumes too much memory, uncomment this to fix a random memory crash when using that plugin
		/*
		global $wp_filter;
		if( isset($wp_filter['the_posts']) && isset($wp_filter['the_posts'][10]) && isset($wp_filter['the_posts'][10]['WPCF_Loader::wpcf_cache_complete_postmeta']) ){
			unset($wp_filter['the_posts'][10]['WPCF_Loader::wpcf_cache_complete_postmeta']);
		}
		*/
		
		$posts = get_posts($args);
		if(!empty($posts)){
			if(!function_exists('get_term_meta'))require_once RHC_PATH.'custom-taxonomy-with-meta/taxonomy-metadata.php';
			
			//note: bug fix, when both this options are active the events that load in the organizer page show the organizer name instead of the vent name.
			if( '1'==$rhc_plugin->get_option('cal_preload') && '1'==$rhc_plugin->get_option('bug_fix_theme_single_title') ){
				global $post;
			}
			
			foreach($posts as $post){
				setup_postdata($post);	
				//---
				$attachment_id = get_post_meta($post->ID,'rhc_tooltip_image',true);
				$size = $this->get_image_size();
				$image = $this->get_tooltip_image($post->ID, $attachment_id, $size);
				$image_full = $this->get_tooltip_image($post->ID, $attachment_id, 'full');
				//---
				$url = $disable_event_link ? false : get_permalink($post->ID) ;
				if( false===$url ){
					if( $request['rhc_action']=='get_icalendar_events' ){
						$url = '';
					}else{
						$url = "javascript:void(0);";
					}
				}
				//---
				$tmp = array(
					'id' 			=> sprintf("%s-%s",$post->ID,$post->post_type),
					'local_id'		=> $post->ID,
					//'title' 		=> str_replace('&#8211;','-',get_the_title($post->ID)),
					'title' 		=> $this->get_title( get_the_title($post->ID) ),
					'start' 		=> $this->get_start_from_post_id($post->ID),
					'end' 			=> $this->get_end_from_post_id($post->ID),
					'url' 			=> $url,
					'description'	=> do_shortcode($post->post_excerpt),
					'image'			=> $image,
					'image_full'	=> $image_full,
					'terms'			=> array(),
					'fc_click_link' => 'view',
					'menu_order'	=> intval( $post->menu_order )
				);
				//-- month view image
				if($this->month_event_image){			
					$attachment_id = get_post_meta($post->ID,'rhc_month_image',true);					
					$size = $this->get_image_size('rhc_media_size');
					$image = wp_get_attachment_image_src( $attachment_id, $size );				
					if(false!==$image){
						$tmp['month_image']=$image;
					}
				}		
				
				//----handle duplicates
				if($this->skip_duplicates){
					if(in_array($tmp['id'],$this->done_ids)){
						continue;
					}else{
						$this->done_ids[]=$tmp['id'];
					}
				}
				//----
				foreach(array( 'fc_rdate'=>'fc_rdate', 'fc_exdate'=>'fc_exdate', 'fc_allday'=>'allDay', 'fc_start'=>'fc_start','fc_start_time'=>'fc_start_time','fc_end'=>'fc_end','fc_end_time'=>'fc_end_time', 'fc_interval'=>'fc_interval','fc_rrule'=>'fc_rrule','fc_end_interval'=>'fc_end_interval','fc_color'=>'color','fc_text_color'=>'textColor','fc_click_link'=>'fc_click_link','fc_click_target'=>'fc_click_target') as $meta_field => $event_field){
					$meta_value = get_post_meta($post->ID,$meta_field,true);
					if(''!=trim($meta_value)){
						$tmp[$event_field]=$meta_value;
					}
				}
				$tmp['allDay']=isset($tmp['allDay'])&&$tmp['allDay']?true:false;
				//----
				$taxonomies = get_object_taxonomies(array('post_type'=>$post->post_type),'objects');
				if(!empty($taxonomies)){
					foreach($taxonomies as $taxonomy => $tax){
						$terms = wp_get_post_terms( $post->ID, $taxonomy );
						if(is_array($terms) && count($terms)>0){
							foreach($terms as $term){
//								$url = get_term_meta($term->term_id,'website',true);
//								$url = trim($url)==''?get_term_meta($term->term_id,'url',true):$url;
//								$url = trim($url)==''?get_term_link( $term, $taxonomy ):$url;
								$url = get_term_link( $term, $taxonomy );
								$gaddress = get_term_meta($term->term_id,'gaddress',true);
								$color = get_term_meta($term->term_id,'color',true);
								$bg = get_term_meta($term->term_id,'background_color',true);
								$image = get_term_meta($term->term_id,'image',true);

								//taxonomy image addon
								if( defined('RHC_ETI_VERSION') ){
									$images = get_option( 'term-images' );
									if( is_array( $images ) && isset( $images[ $term->term_id ] ) ){
										$src = wp_get_attachment_image_src( $images[ $term->term_id ], 'full', false );
										if( isset( $src[0] ) ){
											$image = $src[0];
										}										
									}
								}

								if( empty($image) && function_exists('get_term_thumbnail') ){
									$term_thumbnail_id = get_term_thumbnail_id( $term->term_id );
									$src = wp_get_attachment_image_src( $term_thumbnail_id, 'full' );
									if( isset( $src[0] ) ){
										$image = $src[0];
									}
								}								


								
								$glat = get_term_meta($term->term_id,'glat',true);
								$glon = get_term_meta($term->term_id,'glon',true);
								
								$new = (object)array(
									'term_id'=>$term->term_taxonomy_id,
									'taxonomy'=>$taxonomy,
									'taxonomy_label'=>$tax->labels->singular_name,
									'slug'=>$term->slug,
									'name'=>$term->name,
									'url'=>$url,
									'gaddress'=>$gaddress,
									'glat'	=> $glat,
									'glon'	=> $glon,
									'color'=>$color,
									'background_color'=>$bg,
									'image'=>$image
								);
								
								foreach(array('address','city','state','zip','country') as $meta){
									$new->$meta = get_term_meta($term->term_id,$meta,true);
								}
								
								$tmp['terms'][]=apply_filters('rhc_event_term_meta', $new, $term->term_id, $taxonomy);
							}						
						}
					}
				}
				//----
				$r[]=$tmp;
			}
			 
			
			if( '1'==$rhc_plugin->get_option('cal_preload') && '1'==$rhc_plugin->get_option('bug_fix_theme_single_title') ){
				wp_reset_postdata();
			}			
		}
		return $r;
	}
	
	function get_title( $title ){
		$title = htmlspecialchars_decode( $title );
		$title = html_entity_decode( $title );
		return $title;
	}
	
	function events_in_fc_range($r,$parameters){
		extract($parameters);
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'meta_query'	=> array(		
				'relation'	=> 'AND',
				array(
					'key'		=> 'fc_range_end',
					'value'		=> $start,
					'compare'	=> '>=',
					'type'		=> 'DATE'
				),	
				array(
					'key'		=> 'fc_range_start',
					'value'		=> $end,
					'compare'	=> '<=',
					'type'		=> 'DATE'
				)					
			)
		);
	
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args);
	}
	
	function events_in_rhc_events($r,$parameters,$request){
		extract($parameters);
		global $wpdb;
		$sql = "SELECT post_id FROM `{$wpdb->prefix}rhc_events`";
		$sql.= " WHERE ( event_start <= '$end' )";
		$sql.= " AND ( event_end >= '$start' ) ";		
		$post_ids = $wpdb->get_col($sql,0);
		if(count($post_ids)==0)return array();
		//--
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'post__in'		=> $post_ids
		);
	
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args,$request);
	}	
	
	function non_recurring_events_in_range($r,$parameters){
		extract($parameters);
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'meta_query'	=> array(
				'relation' => 'AND',
				array(
					'key'		=> 'fc_interval',
					'value'		=> '',
					'compare'	=> '=',
					'type'		=> 'CHAR'
				),	
				array(
					'key'		=> 'fc_start_datetime',
					'value'		=> $end,
					'compare'	=> '<',
					'type'		=> 'DATETIME'
				),	
				array(
					'key'		=> 'fc_end_datetime',
					'value'		=> $start,
					'compare'	=> '>',
					'type'		=> 'DATETIME'
				)
			)
		);
	
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args);
	}
	/* MySQL is not liking the query WordPress generates from this
	// the OR and fc_rdatetime part of the query was added for a case where a customer had events that where not showing when on the first calendar day. 
	function events_in_start_range($r,$parameters){
		extract($parameters);
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'meta_query'	=> array(
				'relation'		=> 'OR',
				array(
					'key'		=> 'fc_start',
					'value'		=> array($start,$end),
					'compare'	=> 'BETWEEN',
					'type'		=> 'DATE'
				),
				array(
					'key'		=> 'fc_rdatetime',
					'value'		=> array($start,$end),
					'compare'	=> 'BETWEEN',
					'type'		=> 'DATE'
				)		
			)
		);
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args);
	}
	*/ 
	
	function events_in_start_range($r,$parameters){
		extract($parameters);
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'meta_query'	=> array(
				array(
					'key'		=> 'fc_start',
					'value'		=> array($start,$end),
					'compare'	=> 'BETWEEN',
					'type'		=> 'DATE'
				)	
			)
		);
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args);
	}
	
	function events_in_rdatetime_range($r,$parameters){
		extract($parameters);
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'meta_query'	=> array(
				
				/*
				array(
					'key'		=> 'fc_rdatetime',
					'value'		=> array($start,$end),
					'compare'	=> 'BETWEEN',
					'type'		=> 'DATE'
				)	
				*/
				'relation'	=> 'AND',
				array(
					'key'		=> 'fc_range_end',
					'value'		=> $start,
					'compare'	=> '>=',
					'type'		=> 'DATE'
				),	
				array(
					'key'		=> 'fc_range_start',
					'value'		=> $end,
					'compare'	=> '<=',
					'type'		=> 'DATE'
				)						
			)
		);
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args);
	}
	
	function events_in_end_range($r,$parameters){
		extract($parameters);
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'meta_query'	=> array(
				array(
					'key'		=> 'fc_end',
					'value'		=> array($start,$end),
					'compare'	=> 'BETWEEN',
					'type'		=> 'DATE'
				)			
			)
		);
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args);
	}
	
	function recurring_events_with_end_interval($r,$parameters){
		extract($parameters);
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'meta_query'	=> array(
				'relation' => 'AND',
				array(
					'key'		=> 'fc_start',
					'value'		=> $start,
					'compare'	=> '<',
					'type'		=> 'DATE'
				),
				array(
					'key'		=> 'fc_interval',
					'value'		=> '',
					'compare'	=> '!=',
					'type'		=> 'CHAR'
				),
				array(
					'key'		=> 'fc_end_interval',
					'value'		=> '',
					'compare'	=> '!=',
					'type'		=> 'CHAR'
				),
				array(
					'key'		=> 'fc_end_interval',
					'value'		=> $start,
					'compare'	=> '>',
					'type'		=> 'DATE'
				)
			)
		);	
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args);
	}
	
	function recurring_events_without_end_interval($r,$parameters){
		extract($parameters);
		$args = array(
			'post_type'		=> $post_type,
			'post_status' 	=> $this->status_for_query(),
			'meta_query'	=> array(
				'relation' => 'AND',
				array(
					'key'		=> 'fc_start',
					'value'		=> $start,
					'compare'	=> '<',
					'type'		=> 'DATE'
				),
				array(
					'key'		=> 'fc_interval',
					'value'		=> '',
					'compare'	=> '!=',
					'type'		=> 'CHAR'
				),
				array(
					'key'		=> 'fc_end_interval',
					'value'		=> '',
					'compare'	=> '=',
					'type'		=> 'CHAR'
				)
			)
		);	
		$args = $this->apply_parameters($args,$parameters);
		return $this->get_events($r,$args);
	}
	
	function get_start_from_post_id($post_ID){
		return $this->event_date(get_post_meta($post_ID,'fc_start',true),get_post_meta($post_ID,'fc_start_time',true));
	}
	
	function get_end_from_post_id($post_ID){
		$date = get_post_meta($post_ID,'fc_end',true);
		if( get_post_meta($post_ID,'fc_allday',true) ){
			$time = '23:59:59';
		}else{
			$time = get_post_meta($post_ID,'fc_end_time',true);
		}
		return $this->event_date($date,$time);
	}
	
	function event_date($date,$time,$default=null){
		$time = $this->parseTime($time);
		$time = ''==trim($time)?'00:00:00':$time;
		if(''==trim($date))return $default;
		return date('Y-m-d H:i:s',strtotime(sprintf("%s %s", trim($date), trim($time) )));
	}
	
	function parseTime($timeString) {    
	    if ($timeString == '') return null;
	    //if(preg_match("/(\d+)(:(\d\d))?\s*(p|a?)/i",$timeString,$time)){
		if(preg_match("/(\d+)([:\.]{1}(\d\d))?\s*(p|a?)/i",$timeString,$time)){
			$str = $time[1].':'.str_pad($time[3],2,'0',STR_PAD_LEFT).' '.(strlen($time[4])>0?$time[4].'m':'');
			return date('H:i:s',strtotime($str));
		}else{
			return null;
		}  
	}	
	
	function apply_parameters($args,$parameters){			
//file_put_contents(ABSPATH.'cal.log', mktime()."<br>".print_r($parameters,true));		
		foreach(array('taxonomy','terms','tax','calendar','venue','organizer','tax_by_id') as $field){
			if(empty($parameters[$field])){
				$parameters[$field]=false;
			}
		}		
		foreach(array('author','author_name') as $field){
			if(''==$parameters[$field]){
				$parameters[$field]=false;
			}
		}
	
		extract($parameters);
		//--
		if(isset($parameters['ID'])){
			$args['p']=$parameters['ID'];
		}
		
		//--- build taxonomies query
		// tax have priority over taxonomy, tax is passed when checking terms on the search dialog
		$taxonomies = array();	
		if(false!==$tax && is_array($tax) && count($tax)>0){
			foreach($tax as $slug => $tmp_terms){
				$taxonomies[$slug]=explode(',',str_replace(' ','',$tmp_terms));
			}
			//--- 
			if( apply_filters( 'rhc_filter_preserve_initial', true ) ){
				if( false!==$taxonomy && false!==$terms && !isset( $taxonomies[$taxonomy] ) ){
					$taxonomies[$taxonomy]=explode(',',str_replace(' ','',$terms));
				}			
			}
			
		}else{
			if(false!==$taxonomy && false!==$terms){
				$taxonomies[$taxonomy]=explode(',',str_replace(' ','',$terms));
			}
			
			if(false!==$calendar){
				$taxonomies[RHC_CALENDAR]=$calendar;
			}
			
			if(false!==$venue){
				$taxonomies[RHC_VENUE]=$venue;
			}
			
			if(false!==$organizer){
				$taxonomies[RHC_ORGANIZER]=$organizer;
			}	
		}
			
		if(!empty($taxonomies)){
			$args['tax_query']=array(
				/*'relation'=>'OR'*/////--- multiple taxonomies with relation OR does not work as expected when combined with meta_query
				/*'relation'=>'AND'*/
			);
			foreach($taxonomies as $taxonomy => $terms){
				$args['tax_query'][]=array(
					'taxonomy'	=> $taxonomy,
					'field'		=> $tax_by_id?'id':'slug',
					'terms'		=> $terms,
					'operator'	=> 'IN'
				);
			}
		}

//error_log(print_r($args,true)."\n\r",3,ABSPATH.'cal.log');		
		//---done with taxonomies
		//---built author query
		if(false!==$author){
			//$args['author']=explode(',',str_replace(' ','',$author));
			$args['author']=$author;
		}
		if(false!==$author_name){
			$args['author_name']=$author_name;
		}		
		//---end author query
		//-- s search
		if( isset($parameters['s']) && !empty($parameters['s']) ){
			$this->is_search = true;
			$args['s'] = $parameters['s'];
		}
		//--
		return $args;
	}
	
	function get_image_size($option='rhc_media_size'){
		global $rhc_plugin;
		return $rhc_plugin->get_option($option,'thumbnail',true);
	}
	
	function extended_details(){
		global $post;
	
		$output = '<div>';
		$ids = isset($_REQUEST['ids'])&&is_array($_REQUEST['ids'])?$_REQUEST['ids']:array();
		if(!empty($ids)){
			foreach($ids as $id){
				$arr = explode('-',$id);
				if(count($arr)=='2'){
					if( defined('RHP_PATH') ){
						$post = get_post( $arr[0] ); //social panel needs the real thing loaded.
					}else{
						$post = (object)array(
							'ID'		=> $arr[0],
							'post_type'	=> $arr[1]
						);
					}

					$output.=rhc_post_info_shortcode::handle_shortcode(array('class'=>'se-dbox '.$id));
				}
			}
		}
		$output.= '</div>';
//sleep(3);		
		$this->send_response($output,'html');
	}
	
	function rhc_tooltip_detail(){
		global $post;	
		$arr = explode('-',$_REQUEST['id']);
		$post = get_post($arr[0]);
		$output = do_shortcode('[rhc_post_info id="tooltipbox"]');
		//die($output); 

		if( empty($output) ){
			$output = '<div style="display:none;"><div class="fe-extrainfo-holder fe-empty"></div></div>';

		}
	
		$this->send_response($output,'html');  
	}
	
	function supe_get_events(){
	
		$defaults = array(
			'uid'		=> $uid,
			'test' 		=> '',
			'page' 		=> '0',
			'number'	=> '5',
			'taxonomy'	=> '',
			'terms'		=> '',
			'template'	=> 'widget_upcoming_events.php',
			'class'		=> 'rhc_supe_holder',
			'prefix'			=> 'uew',//not really used.
			'parse_postmeta' => '',//comma separated fields to include in the event ovent as a meta array().
			'parse_taxonomy'	=> '0',
			'parse_taxonomymeta'=> '1',
			'order'		=> 'ASC',
			'date'		=> 'NOW',
			'date_end'	=> '',
			'horizon'	=> 'hour',
			'allday'	=> '', //empty for any, 1 for allday only, 0 for non-allday only.
			'post_status' => 'publish',
			'post_type'	=> '',
			'author'	=> '',
			'do_shortcode' => '1',
			'the_content'  => '0',
			'separator' => '',
			'holder'	=> '1',
			'dayspast'	=> '',  //for compat with upcoming evengts widget
			'premiere'		=> '0',
			'auto'			=> '0',
			'feed'			=> '',
			'words'			=> '',
			'render_images' => '',
			'calendar_url'	=> '',
			'loading_overlay'		=> '0',
			'for_sidebar' 	=> '0',
			'post_id'		=> '',
			//'current_post'	=> '', this is not usable in ajax.
			'rdate'			=> ''		
		);
			
		$posted = array();
		foreach( $defaults as $field => $value ){
			if( isset( $_POST['data'][$field] ) ) {
				$posted[$field] = $_POST['data'][$field];
			}
		}
			
		$shortcode_atts = shortcode_atts($defaults, $posted);			
		$shortcode_atts['page'] = $shortcode_atts['page'] + intval( $_POST['delta'] );
	
		$params = array();
		foreach( $shortcode_atts as $field => $value ){
			$params[] = sprintf( '%s="%s"', $field, esc_attr($value) );
		}
				
		$sc = sprintf( '[rhc_static_upcoming_events %s]', implode(' ', $params ) );	
		$this->send_response(array(
			'R'=>'OK',
			'PAGE'=> $shortcode_atts['page'],
			//'SC' => $sc,
			'HTML'=> do_shortcode($sc) 
		));
	}
	
	function status_for_query(){
		if( false===$this->post_status ){
			$this->post_status = apply_filters('rhc_query_post_status', array('publish') );
		}
		return $this->post_status;
	}
}

?>