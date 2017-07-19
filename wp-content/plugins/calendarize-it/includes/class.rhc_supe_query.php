<?php

class rhc_supe_query {
	function __construct(){
	
	}
	
	public static function get_events( $args=array(), $atts=array() ){
		global $wpdb;
	
		$defaults = array(
			'page' 		=> '0',
			'number'	=> '5',
			'order' 	=> 'ASC',
			'date'		=> 'NOW',
			'date_end' 	=> '',
			'dayspast'	=> '',
			'horizon'	=> 'hour',//hour,day,end
			'allday'	=> '',
			'post_status' 	=> 'publish',
			'post_type'		=> '',
			'author'	=> '',
			'parse_postmeta' => '',//comma separated fields to include in the event ovent as a meta array().
			'parse_taxonomy' => '0',
			'parse_taxonomymeta' => '0',
			'premiere'		=> '0',
			'auto'			=> '0',
			'feed'			=> '',
			'post_id'		=> '',
			'current_post'	=> '',
			'rdate'			=> ''
		);
		
//TODO:take into consideration the browser tz.
		$r = wp_parse_args( $args, $defaults );

		extract( $r, EXTR_SKIP );
		
		$events_reverse = false;
		//-------------
		$order = 'ASC'==strtoupper($order)? 'ASC' : 'DESC';
		$parse_taxonomy = '1'==$parse_taxonomy?true:false;
		//-------------
		$date_oper 		= '>=';
		$date_end_oper 	= '<=';
		//-------------
		if( '-1' == $number ){
			$limit = '';//no limit !!
		}else{
			$page 	= intval($page);
			$number = intval($number);
			
			if( $page < 0 ){
				//interchange operators
				$date_oper = '<';
				$date_end_oper = '>';
				$page = abs( $page ) -1;
				
				$events_reverse = true;
				
				$order = 'ASC' == $order ? 'DESC' : 'ASC' ;
			}
			
			if( $page==0 ){
				$limit = "LIMIT $number";	
			}else{
				$offset = $number * $page;
				$limit = "LIMIT $offset,$number";	
			}
	
		}

		//-----
		//-------------- build taxonomy/term filter
		if( '1'==$auto && is_tax() ){
			$args['taxonomy'] = get_query_var( 'taxonomy' );
			$args['terms'] = get_query_var( 'term' );
		}
		
		$terms = isset($args['terms']) && !empty($args['terms']) ? $args['terms'] : false;
		if(false!==$terms){
			$terms=explode(',',$terms);
			$tmp = array();
			foreach($terms as $slug){
				$tmp[]=sprintf("'%s'", trim($slug) );
			}
			$terms = implode(",",$tmp);
		}
		
		$taxonomy = isset($args['taxonomy'])?$args['taxonomy']:false;
		if(false!==$taxonomy){
			$taxonomy=explode(',',$taxonomy);
			$tmp = array();
			foreach($taxonomy as $slug){
				if(empty($slug))continue;
				$tmp[]=sprintf("'%s'", trim( $slug ) );
			}
			$taxonomy = implode(",",$tmp);
		}
		
		if( false===$taxonomy || false===$terms ){
			$taxonomy_tables = "";
			$taxonomy_filters = "";
		}else{
			$taxonomy_tables = "INNER JOIN $wpdb->term_relationships R ON R.object_id=E.post_id
INNER JOIN $wpdb->term_taxonomy TT ON TT.term_taxonomy_id=R.term_taxonomy_id
INNER JOIN $wpdb->terms T ON T.term_id=TT.term_id";

			$taxonomy_filters= "AND TT.taxonomy IN ($taxonomy)
AND T.slug IN ($terms)";	
		}	
		//------------
		$groupby_arr = array();
		$filters = "";
		//--- EVENT Date filters
		
		$date_filter = "";
		if(!empty($date)){
			$date = 'NOW'==$date ? current_time('mysql') : $date;
			$ts = strtotime($date);
			$format = $horizon=='day' ? 'Y-m-d' : 'Y-m-d H:i:s' ;
			
			$db_field = 'E.event_start';
			if( $horizon=='end' ){
				$db_field = 'E.event_end';
			}
			
			if(false!==$ts){
				$date_filter.= sprintf(" AND (%s %s '%s')",
					$db_field,
					$date_oper, // >=
					date($format,$ts)
				);
			}
		}	
		
		if(!empty($date_end)){
			$date_end = 'NOW'==$date_end ? current_time('mysql') : $date_end;

			if(strlen($date_end)<=10){
				$date_end = date('Y-m-d 23:59:59', strtotime($date_end) );
			}
			
			$ts = strtotime($date_end);
			//$format = $horizon=='day' ? 'Y-m-d' : 'Y-m-d H:i:s' ;
			$format = 'Y-m-d H:i:s' ;
		
			if(false!==$ts){
				$date_filter.= sprintf(" AND (E.event_end %s '%s')", 
					$date_end_oper, // <=
					date($format,$ts)
				);
			}
		}
		
		if(!empty($dayspast)){
			if( false===$date ){
				$ts = mktime(0,0,0,date('m'),date('d')-$dayspast,date('Y')) ;
			}else{
				$ts = mktime(0,0,0,date('m', $ts),date('d', $ts)-$dayspast,date('Y', $ts)) ;
			}
			$format = $horizon=='day' ? 'Y-m-d' : 'Y-m-d H:i:s' ;
			if(false!==$ts){
				$date_filter.= sprintf(" AND (E.event_start >= '%s')",
					date($format,$ts)
				);
			}
		}
	
		//-- by specific post_id
		if( 'current' == $post_id ){
			$post_id = get_the_ID();
		}
		if( $post_id > 0 ){
			$filters.= " AND(E.post_id=" . intval( $post_id ) . ")";
		}
		//-- intended for use with post_ID, not alone, althought you can.
		if( !empty( $rdate ) && is_numeric( $rdate ) ){
			$filters.= sprintf(" AND(E.event_start='%s')", $rdate);
		}
		
		//-- Premiere
		if('1'==$premiere){
			$filters.=" AND(E.number=0)";
		}else if('2'==$premiere){
			$groupby_arr[]="E.post_id";
		}
		
		//-- ALL day filter --------------------
		if(!empty($allday)){
			$allday = intval($allday) ? 1 : 0;
			$filters.=" AND(E.allday=$allday)";
		}
		
		//-- maybe csv values: Post status, post type
		foreach( array(
				'post_status' => 'P.post_status',
				'post_type'	 => 'P.post_type'
			) as $field => $sql_field ){
			if(!empty($$field)){
				$sql_val = rhc_supe_query::csv_to_sql_strings( $$field );
				$filters.=sprintf(" AND(%s IN (%s))",$sql_field,$sql_val);
			}
		}
		//--- author filter
		$filters.=rhc_supe_query::get_author_sql_filter( $author );
		
		$groupby = empty( $groupby_arr ) ? '' : sprintf("GROUP BY %s", implode(',', $groupby_arr) );
		//----------------------
		$sql = "SELECT E.*,P.*
FROM `{$wpdb->prefix}rhc_events` E
INNER JOIN $wpdb->posts P ON P.ID=E.post_id
$taxonomy_tables
WHERE (1) 
$date_filter
$taxonomy_filters
$filters
$groupby
ORDER BY E.event_start $order
$limit
";
		
if(isset($_REQUEST['rhc_debug']) && current_user_can('manage_options')){
echo "SQL:$sql<br><-----";
}		

		$events = array();
//error_log( "\n"."\n".$sql."\n", 3, ABSPATH.'api.log' );			
		if( '1'!=$feed && $wpdb->query($sql) ){	
			$events = rhc_supe_query::handle_get_taxonomy_and_terms( $wpdb->last_result, $parse_taxonomy, $parse_taxonomymeta, $atts );	
			if( $events_reverse ){
//file_put_contents( 	ABSPATH.'api.log',print_r( $events,true) );	
				$events = array_reverse( $events );	
			}				
		}
		
		//permalink
		$events = rhc_supe_query::handle_get_permalink( $events, $atts );
		
		//fill post meta
		$events = rhc_supe_query::handle_get_postmeta( $events, $atts );
		
		//fill in images
		$events = rhc_supe_query::handle_get_images( $events, $atts );
		
		if( '0'!=$feed ){
			$taxonomy = isset($args['taxonomy'])?$args['taxonomy']:'';
			$terms = isset($args['terms']) && !empty($args['terms']) ? $args['terms'] : '';			
			$json_feed = apply_filters('rhc_json_feed',false,$taxonomy,$terms,(is_numeric($author)?$author:''),(is_string($author)?$author:''));		
		}else{
			$json_feed = array();
		}

		/*
		if(true||$feed!='0'){
			if(!empty($calendar)){
				$json_feed = apply_filters('rhc_json_feed',false,RHC_CALENDAR,$calendar,$author,$author_name);	
			}else{
				$json_feed = apply_filters('rhc_json_feed',false,$taxonomy,$terms,$author,$author_name);	
			}	
		}
		*/
		
		if( !empty($events) ){
			$calendar_url = isset( $atts['calendar_url'] ) && !empty( $atts['calendar_url'] ) ? $atts['calendar_url'] : false ;
			if( false!==$calendar_url ){
				foreach( $events as $i => $e ){
					$e->the_permalink = $calendar_url;
				}
			}		
		}
			
		return apply_filters('rhc_supe_get_events', $events, compact('args','atts','json_feed','date','date_end') );	
	}

	public static function handle_get_permalink( $events, $atts ){
		if( empty( $events ) ) return $events;
		foreach($events as $i => $e){
			$e->the_permalink = get_the_permalink( $e->ID );
		}
		return $events;
	}
	
	public static function handle_get_postmeta( $events, $atts ){
		$parse_postmeta = isset( $atts['parse_postmeta'] ) ? $atts['parse_postmeta'] : '' ;
		if( empty( $parse_postmeta ) ) return $events;
		if( empty( $events ) ) return $events;
		
		$fields = explode( ',', $parse_postmeta );
		foreach($events as $i => $e){
			if( !property_exists( $e, 'meta' ) ){
				$e->meta = array();
			}
			//--
			if( $e->ID > 0 ){
				foreach( $fields as $field ){
					$v = get_post_meta( $e->ID, $field, true );
					//-- 
					if( in_array( $field, array('fc_color','fc_text_color') ) ){
						$v = '#'==$v ? '' : $v ;
					}
					$e->meta[ $field ] = $v;
				}			
			}
		}
		return $events;
	}
	
	public static function handle_get_images( $events, $atts ){
		if( empty( $events ) ) return $events;
		$tools = new calendar_ajax;
		$images = apply_filters( 'rhc_images', array('rhc_top_image','rhc_dbox_image','rhc_tooltip_image','rhc_month_image') );
		foreach( $events as $i => $e ){
			if( !property_exists( $e, 'images' ) ){
				$events[$i]->images = array();
			}
		
			foreach( $images as $meta_key ){
				$attachment_id = get_post_meta( $e->ID, $meta_key, true );

				$size = 'full';
				$image = $tools->get_tooltip_image($e->ID, $attachment_id, $size);

				if(is_array($image)&&isset($image[0])){		
					$events[$i]->images[$meta_key] = $image[0];
				}			
			}				
		}
		return $events;
	}
	
	public static function handle_get_taxonomy_and_terms( $events, $parse_taxonomy=false, $parse_taxonomymeta=false, $atts=array() ){
		if(!$parse_taxonomy)return $events;
		if(empty($events))return $events;
		$parse_taxonomymeta = '1'==$parse_taxonomymeta?true:false;
		if($parse_taxonomymeta){
			global $wpdb,$rhc_plugin;
			if( $rhc_plugin->wp44plus ){
				$meta_fields = $wpdb->get_col("SELECT DISTINCT(meta_key) FROM `{$wpdb->prefix}termmeta`;",0); 
			}else{
				$meta_fields = $wpdb->get_col("SELECT DISTINCT(meta_key) FROM `{$wpdb->prefix}taxonomymeta`;",0); 
			}
			
			$meta_fields = is_array($meta_fields)?$meta_fields:array();
			if(empty($meta_fields)){
				$parse_taxonomymeta=false;
			}
		}

		//-----
		foreach($events as $i => $post){
			$events[$i]->taxonomies = array();
			$taxonomies = get_object_taxonomies(array('post_type'=>$post->post_type),'objects');
			if(!empty($taxonomies)){
				foreach($taxonomies as $taxonomy => $tax){
					$terms = wp_get_post_terms( $post->ID, $taxonomy );
				
					if( is_array($terms) && count($terms)>0 ){
						
						if( $parse_taxonomymeta ){
							foreach($terms as $j => $term){

								//--term url is missing
								$term->term_link = get_term_link( $term, $taxonomy );

								$term->meta = array();
								foreach($meta_fields as $meta_field){
									$value = get_term_meta( $term->term_id, $meta_field, true );
									if(!empty($value)){
										$term->meta[ $meta_field ] = $value;
									}
								}
								
							}
						}
						
						$tax = clone $tax;
						$tax->terms = $terms;	
						$events[$i]->taxonomies[]=$tax;
					
					}
				}
			}
		}
	
		return $events;
	}
	
	public static function handle_get_event_terms( $events, $parse_taxonomy=false, $atts=array() ){
		if(!$parse_taxonomy)return $events;
		if(empty($events))return $events;
		foreach($events as $i => $post){
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
							if( empty($image) && function_exists('get_term_thumbnail') ){
								$term_thumbnail_id = get_term_thumbnail_id( $term->term_id );
								$src = wp_get_attachment_image_src( $term_thumbnail_id, 'full' );
								if( isset( $src[0] ) ){
									$image = $src[0];
								}
							}								
							
							$glat = get_term_meta($term->term_id,'glat',true);
							$glon = get_term_meta($term->term_id,'glon',true);
							$ginfo = get_term_meta($term->term_id,'ginfo',true);
							
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
								'ginfo'	=> $ginfo,
								'color'=>$color,
								'background_color'=>$bg,
								'image'=>$image
							);
							
							foreach(array('address','city','state','zip','country') as $meta){
								$new->$meta = get_term_meta($term->term_id,$meta,true);
							}
							
							if(!property_exists($events[$i],'terms')){
								$events[$i]->terms = array();	
							}
							$events[$i]->terms[]=apply_filters('rhc_event_term_meta', $new, $term->term_id, $taxonomy);
						}						
					}
				}
			}
			//----		
		}

		return $events;
	}
	
	public static function get_author_sql_filter( $author ){
		if(''==trim($author)){
			return '';
		}else if('current'==$author){//this locks a username named current.
			if( is_user_logged_in() ){
				global $userdata;
				return sprintf(" AND( P.post_author=%s)", $userdata->ID);
			}else{
				return ' AND(0)';//force nothing as user is not logged.
			}
		}else{
			$arr = explode(',', $author);
			$tmp = array();
			if(is_array($arr) && count($arr)>0){
				foreach($arr as $arr_author){
					if( is_numeric( $arr_author ) ){
						$tmp[]=$arr_author;
					}else{
						if($author_id=rhc_supe_query::get_author_id( $arr_author )){
							$tmp[]=$author_id;
						}
					}
				}
			}
			if(count($tmp)>0){
				return sprintf(" AND( P.post_author IN (%s) )", implode(",",$tmp));
			}
		}
		return '';
	}
	
	public static function get_author_id( $author ){
		global $wpdb;
		$sql = sprintf("SELECT COALESCE((SELECT ID FROM $wpdb->users WHERE user_login LIKE \"%s\" LIMIT 1),'')",addslashes(stripslashes($author)));
		return $wpdb->get_var($sql,0,0);
	}
	
	public static function csv_to_sql_strings( $str ){
		$arr = explode(',',$str);
		$tmp = array();
		foreach($arr as $value){
			$tmp[]=sprintf("'%s'",addslashes($value));
		}
		return implode(',',$tmp);
	}	
}

?>