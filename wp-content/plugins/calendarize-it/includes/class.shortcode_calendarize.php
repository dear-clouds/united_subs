<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class shortcode_calendarize {
	var $id = 0;
	var $added_footer = false;
	var $wp_footer = '';
	var $event_list_templates = array();
	var $capabilities = array();
	var $list_printed = false;
	function __construct($args=array()){
		$defaults = array(
			'capabilities'				=> array(
				'calendarize_author'	=> 'calendarize_author'
			)
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}	
		//---------
		
		
		add_shortcode(SHORTCODE_CALENDARIZE, array(&$this,'calendarize'));
		add_shortcode(SHORTCODE_CALENDARIZEIT, array(&$this,'calendarizeit'));
		add_shortcode('btn_ical_feed', array(&$this,'sc_ical_feed'));
		
		add_shortcode('rhc_start_date', array(&$this,'handle_date_shortcode'));
		add_shortcode('rhc_end_date', array(&$this,'handle_date_shortcode'));
		
		add_shortcode('rhc_upcoming_events', array(&$this,'rhc_upcoming_events'));
		
		add_action('init', array(&$this,'static_list_endpoints'));
	}
	
	function static_list_endpoints(){
		global $rhc_plugin;
		if( '1'==$rhc_plugin->get_option('enable_static_list_endpoint','1',true) ){
			$upcoming = $rhc_plugin->get_option('enable_static_list_upcoming_slug','rhc-upcoming-events',true);
			$past = $rhc_plugin->get_option('enable_static_list_past_slug','rhc-past-events',true);
			add_rewrite_endpoint( $upcoming, EP_ALL );
			add_rewrite_endpoint( $past, EP_ALL );
		}
	}
	
	function rhc_upcoming_events($atts,$content=null,$code=""){
		$output='';

		$fields = array(
			'number'			=> 5,
			'fcdate_format'		=> 'MMM d, yyyy',
			'fctime_format'		=> 'h:mmtt',
			'post_type'			=> false,
			'template'			=> false,
			'calendar'			=> false,
			'venue'				=> false,
			'organizer'			=> false,
			'words'				=> '1000',
			'horizon'			=> 'hour',
			'showimage'			=> '1',
			'loading_method'	=> 'ajax',
			'auto'				=> 0,
			'calendar_url'		=> '',
			'taxonomy'			=> false,
			'terms'				=> false,
			'premiere'			=> '0',
			'feed'				=> ''
		);
		
		foreach($fields as $field => $default){
			if(isset($atts[$field])){
				$instance[$field]=$atts[$field];
			}else if(false!==$default){
				$instance[$field]=$default;
			}
		}

		if( isset($instance['post_type']) && ''!=$instance['post_type']){
			$arr=explode(',',$instance['post_type']);
			if(is_array($arr)&&count($arr)>0){
				$instance['post_type']=array();
				foreach($arr as $post_type){
					$instance['post_type'][]=$post_type;
				}
			}
		}
		
		foreach( array('calendar'=>RHC_CALENDAR,'venue'=>RHC_VENUE,'organizer'=>RHC_ORGANIZER) as $field => $taxonomy ){
			if( isset($instance[$field]) && false!=$instance[$field] ){
				$term = get_term_by('slug', $instance[$field], $taxonomy);
				if(false!=$term){
					$instance[$field]=$term->term_id;
				}else{
					$instance[$field]=false;
				}					
			}
		}		

		do_action('enqueue_frontend_only');
		
		ob_start();
		the_widget('UpcomingEvents_Widget',$instance);
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
	
	function get_bool($value){
		return (in_array(trim(strtolower($value)),array('1','yes','y','true','s')))?true:false;
	}
	
	function calendarizeit($atts,$content=null,$code=""){
		return do_shortcode(generate_calendarize_shortcode($atts));
	}
	
	function calendarize($atts,$content=null,$code=""){
		$atts = apply_filters( 'calendarize_atts', $atts, $content, $code );
		
		try {
			require 'class.shortcode_calendarize.calendarize.php';
		}catch( Exception $e ){
			return '';//conditions for calendar output not met.
		}
		

		if(isset($taxonomy) && isset($terms) && RHC_VENUE==$taxonomy){
			if( $t=get_term_by('slug',$terms,$taxonomy) ){
				if( $t->count==0 ){
					return '';
				}			
			}
		}
		
		if( ''==trim($header_left.$header_center.$header_right) ){
			$class.=" rhc-empty-header ";
		}
		
		foreach( array('month_hide_time') as $class_option ){
			if('1'==$$class_option){
				$class.=" rhc_".$class_option;
			}
		}
		
		do_action('enqueue_frontend_only');//this triggers printings styles and scripts in the footer.
		
		$rhc_options = $this->get_calendarize_args($options,$atts);
		
		return sprintf('<div id="%s" class="rhcalendar %s rhc_holder" data-rhc_ui_theme="%s" data-rhc_options="%s"><div class="fullCalendar"></div>%s%s%s%s<div style="clear:both"></div>%s</div>',
			$id,
			$class,
			(trim($theme)==''?'':$this->get_ui_theme_url($theme)),
			htmlspecialchars($rhc_options),
			$this->calendars_form($post_types, $search_enable, $search_placeholder, apply_filters('tax_query_filter',compact('calendar','venue','organizer','taxonomy','terms','hierarchical_filter','feed')) ),
			$this->icalendar_dialog($icalendar,$icalendar_title,$icalendar_description,$icalendar_button,$icalendar_width,$icalendar_align),
			$this->widget_day_click_template($atts),
			$this->handle_preloaded_events( compact('rhc_options','preload','atts','events_source','events_source_query','defaultview','firstday','hiddendays','gotodate','shrink','json_feed') ),
			$this->handle_static_event_list( $atts, $post_types, $events_source_query, $noscript )
		);

	}

	function handle_preloaded_events( $args=array() ){
		extract($args);
		//---
		global $rhc_plugin;
		if( !intval($preload) ) return '';
		
		$url = $events_source . $events_source_query;
					
		$parse_url = parse_url( $url );
		parse_str($parse_url['query'], $request );
		$request = array_merge($request, $this->get_vis_start_and_end( $atts, $defaultview, $gotodate ) );

		$request['rhc_shrink'] =$shrink;
		$request['view'] =$defaultview;
		$request['ver']  = ( '1' == $rhc_plugin->get_option('force_browser_cache','',true) ? '' : $rhc_plugin->get_option('data-last-modified-md5', '', true) ) ;
		$request['_']  = '';
		
		$events = $rhc_plugin->calendar_ajax->handle_rhc_cache( $request, true );
		if(false===$events){
			//temporary fix:
			if( 'rhc_grid'==$request['view'] ){
				$_REQUEST['view']='rhc_grid';
			}
			//---
			$events = $rhc_plugin->calendar_ajax->get_calendar_events( $request, 'json', true );
		}
		
		if(!is_string($events)){
			$events = json_encode($events);
		}
		
		if(empty($events)){
			$out = '';
		}else{
			$out = sprintf("<object class=\"rhc-preload\" style=\"display:none;\" data-start=\"%s\" data-end=\"%s\"  data-url=\"%s\" data-request=\"%s\" data-events=\"%s\"></object>",
				$request['start'],
				$request['end'],
				$url,
				htmlspecialchars(json_encode($request)),
				htmlspecialchars($events)
			);			
		}
		
		return apply_filters('rhc_preloaded_events', $out, compact('request', 'rhc_options','preload','atts','events_source','events_source_query','defaultview','firstday','hiddendays','gotodate','shrink','json_feed') );
	}
	
	function get_vis_start_and_end( $atts, $defaultview, $gotodate='' ){
		global $rhc_plugin;
		//TODO: maybe narrow the initial range to fit closer with the loaded view.
		$date = empty($gotodate) ? time() : strtotime( $gotodate) ;
		$date = false===$date ? time() : $date;
		//----
		if( isset($atts['class']) && 'upcoming-widget'==$atts['class'] ){
			$months = isset($atts['eventlistmonthsahead']) ? intval($atts['eventlistmonthsahead']) : 6;
			$start = mktime( 0, 0, 0, date('m',$date), 1, date('Y',$date) );
			$end = mktime( 23, 59, 59, date('m',$start)+$months, date('d',$start)+15, date('Y',$start) );
			$start = mktime( 0, 0, 0, date('m',$start), date('d',$start)-15, date('Y',$start) );				
		}elseif('rhc_gmap'==$defaultview){
			$months = isset($atts['gmap_months']) ? $atts['gmap_months'] : $rhc_plugin->get_option('gmap_months',24,true);
			$start = mktime( 0, 0, 0, date('m',$date), 1, date('Y',$date) );
			$end = mktime( 23, 59, 59, date('m',$start)+$months, date('d',$start)+15, date('Y',$start) );
			$start = mktime( 0, 0, 0, date('m',$start), date('d',$start)-15, date('Y',$start) );	
		}else{
			$start = mktime( 0, 0, 0, date('m',$date), 1, date('Y',$date) );
			$end = mktime( 23, 59, 59, date('m',$start)+1, date('d',$start)+15, date('Y',$start) );
			$start = mktime( 0, 0, 0, date('m',$start), date('d',$start)-15, date('Y',$start) );		
		}

		return compact('start','end');
	}
	
	function handle_static_event_list( $atts, $post_types, $events_source_query, $noscript ){
		global $wpdb,$rhc_plugin,$wp_query;
		if( '1'==$rhc_plugin->get_option('disable_static_list', false,true) ) return '';
		if( $this->list_printed )return'';
		$this->list_printed = true;
		//---			
		$slug_upcoming = $rhc_plugin->get_option('enable_static_list_upcoming_slug','rhc-upcoming-events',true);
		$slug_past = $rhc_plugin->get_option('enable_static_list_past_slug','rhc-past-events',true);		
		
//echo	"slug up $slug_upcoming:" .	(get_query_var( $slug_upcoming ))."<br>";
//echo	"slug past $slug_past:" .	(get_query_var( $slug_past ))."<br>";
		
		$up_qvar = get_query_var( $slug_upcoming );
		$past_qvar = get_query_var( $slug_past );
		if( !empty( $up_qvar ) ){
			$page = intval( $up_qvar );
			$direction = 1;
		}else if( !empty( $past_qvar ) ){
			$page = intval( $past_qvar );
			$direction = 0;
		}else{
			$page = 0;
			$direction = 1;
		}
		//----
		
		 
		//----		
		$microdata = '';
		$out = '1'==$noscript ? '<noscript>' : '';
		
		$dir = $direction>0?'>=':'<';
		$order_dir = $direction==0 ? 'DESC' : 'ASC';
		
		$limit = intval( $rhc_plugin->get_option('static_list_limit',50,true) );
//$limit = isset($_REQUEST['limit'])?intval($_REQUEST['limit']):$limit;		
		$offset = $page*$limit;
		$now = date('Y-m-d 00:00:00');
		$sql = "SELECT DISTINCT(E.post_id)
		FROM `{$wpdb->prefix}rhc_events` E 
		WHERE E.event_start $dir '$now'
		GROUP BY E.post_id
		ORDER BY E.event_start $order_dir
		LIMIT $limit OFFSET $offset";
		
		$post_ids = $wpdb->get_col( $sql , 0 );
		$haveposts = false;
		if( is_array($post_ids) && count($post_ids) >0 ){
			$haveposts=true;
			
			$args = array(
				'post_type'		=> $post_types,
				'post__in'		=> $post_ids,
				'post_status' 	=> 'publish',
				'numberposts'	=> -1,
				'orderby'		=> 'post__in',
				'ignore_sticky_posts' => true
			);
			
			parse_str($events_source_query,$params);

			foreach(array('tax','taxonomy','terms','calendar','venue','organizer','author','author_name','s') as $field ){
				$$field = isset($params[$field]) ? $params[$field] : false;	
			}
			
			$taxonomies = array();	
			if(false!==$tax && is_array($tax) && count($tax)>0){
				foreach($tax as $slug => $terms){
					$taxonomies[$slug]=explode(',',str_replace(' ','',$terms));
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
				);
				foreach($taxonomies as $taxonomy => $terms){
					$args['tax_query'][]=array(
						'taxonomy'	=> $taxonomy,
						'field'		=> 'slug',
						'terms'		=> $terms,
						'operator'	=> 'IN'
					);
				}
			}
			
			if(false!==$author){
				$args['author']=$author;
			}
			if(false!==$author_name){
				$args['author_name']=$author_name;
			}	
			if(false!==$s){
				$args['s']=$s;
			}			
						
			$posts = get_posts( $args );		
			
			if( is_array($posts) && count($posts)> 0 ){
				$out .= '<ul>';
				
				foreach($posts as $p){
					$out.= sprintf('<li><a href="%s">%s</a></li>',
						get_permalink( $p->ID ),
						$p->post_title
					);
					
					$microdata .= rhc_template_frontend::event_microdata( $p, false, true );
				}
				$out.= '</ul>';
			}
		}else{
			$args=array();
		}
		
		$url_data = parse_url( site_url('/') );
		$url_data['path'] = str_replace('/'.$slug_upcoming.'/'.$page,'',$_SERVER['REQUEST_URI']);
		$url_data['path'] = str_replace('/'.$slug_past.'/'.$page,'',$url_data['path']);

		$current_url = $this->build_url( $url_data );

		if( $page > 0 ){
			$next_dir = $direction;
			$prev_dir = $direction;
			if( $direction > 0 ){
				$next_page = $page+1;
				$prev_page = $page-1;			
			}else{
				$next_page = $page-1;
				$prev_page = $page+1;						
			}

		}else{
			if( $direction > 0 ){
				$next_dir = 1;
				$prev_dir = 0;					
				$next_page = $page+1;
				$prev_page = 0;
			}else{
				$next_dir = 1;
				$prev_dir = 0;					
				$next_page = 0;
				$prev_page = $page+1;
			}			
		}

		if ( get_option('permalink_structure') != '' ){
			$url_data = parse_url($current_url);
			$next_data = $url_data;
			$prev_data = $url_data;
			//---
			$next_slug = ($next_dir==1?$slug_upcoming:$slug_past);
			$prev_slug = ($prev_dir==1?$slug_upcoming:$slug_past);
			
			$next_data['path'] = trailingslashit( $next_data['path'] ). $next_slug . '/'.$next_page.'/';
			$prev_data['path'] = trailingslashit( $prev_data['path'] ). $prev_slug . '/'.$prev_page.'/';

			$next_url =	$this->build_url($next_data) ;
			$prev_url = $this->build_url($prev_data) ;

			$next_url = $this->addURLParameter($next_url, $next_slug, false);
			$prev_url = $this->addURLParameter($prev_url, $prev_slug, false);			

		}else{
			$next_url = $this->addURLParameter($current_url, ($next_dir==1?$slug_upcoming:$slug_past), $next_page);
			$prev_url = $this->addURLParameter($current_url, ($prev_dir==1?$slug_upcoming:$slug_past), $prev_page);
		}		
		
		if( !$haveposts ){
			if($direction>0){
				$next_url='';
			}else{
				$prev_url='';
			}
		}
		
		if(!empty($prev_url)){
			$out.=sprintf('<a href="%s">%s</a>',
				$prev_url,
				( $direction==0 || ($direction==1 && $page==0) ) ? __('Older events','rhc') : __('Previous events','rhc')
			);		
		}
		
		if(!empty($next_url)){
			$out.=sprintf('<a href="%s">%s</a>',
				$next_url,
				__('Next events','rhc')
			);
		}

		$out = apply_filters('rhc_noscript', $out, $args );
		
		$out .= '1'==$noscript ? '</noscript>' : '';
		$out.= $microdata;
		return $out;
	}
	
	function widget_day_click_template($atts){
		global $rhc_plugin;
		if( isset($atts['widget_dayclick']) ){
			ob_start();	
			include $rhc_plugin->get_template_path('widget_calendar_event_list.php');		
			$out = ob_get_contents();
			ob_end_clean();		
			return $out;
		}
		return '';
	}
	
	function replace_att_with_posted($atts){
		if(isset($atts['ignoreposted'])&&$atts['ignoreposted']==1)return $atts;
		global $rhc_plugin;
		$str = $rhc_plugin->get_option('postable_args','',true);
		$str = str_replace("\n","",trim($str));
		$str = str_replace("\r","",trim($str));
		$arr = explode(',',$str);
		$arr = is_array($arr)?$arr:array();
		$arr[]='defaultview';
		$arr[]='gotodate';

		$posted_arguments = isset($atts['posted_arguments']) && !empty($atts['posted_arguments']) ? $atts['posted_arguments'] : '';
		if( !empty($posted_arguments) ){
			$posted_arguments = str_replace("\n","",trim($posted_arguments));
			$posted_arguments = str_replace("\r","",trim($posted_arguments));
			$posted_arguments_arr = explode(',',$posted_arguments);		
			$arr = $posted_arguments_arr;
		}
		
		foreach($arr as $field){
			if(isset($_REQUEST[$field])){
				$atts[$field]=$_REQUEST[$field];
			}
			$field_name = 'rhc_'.$field;
			if(isset($_REQUEST[$field_name])){
				$atts[$field]=$_REQUEST[$field_name];
			}			
		}
		foreach(array('venue','calendar','organizer') as $_field){
			$field = 'f'.$_field;
			if(isset($_REQUEST[$field])){
				$atts[$_field]=$_REQUEST[$field];
			}
		}		
	
		return $atts;
	}
	
	function get_ui_theme_url($theme){
		return '';//ui-theme is no longer supported.
		$url = sprintf('%sui-themes/%s/style.css',RHC_URL,$theme);
		return apply_filters('rhc_ui_theme_url',$url,$theme);
	}
	
	function get_calendarize_args($options,$atts){
		$options = apply_filters('get_calendarize_args_options',$options,$atts);
		$out = json_encode($options); 
		$out = apply_filters('get_calendarize_args_output',$out);
		foreach(array('fc_select','fc_click','no_link','fc_mouseover','fc_click_no_action') as $method_name){
			$out = str_replace('"'.$method_name.'"',$method_name,$out);
		}
		return $out;
	}
	
	function wp_footer(){	
		$this->items_tooltip();
		$this->event_list_template();
		echo $this->wp_footer;		
	}
	
	function event_list_template(){
		global $rhc_plugin; 
		$value = $rhc_plugin->get_option('rhc-list-layout');
		
		if(''==trim($value)){
			ob_start();	
			include $rhc_plugin->get_template_path('event_list_content.php');		
			$value = ob_get_contents();
			ob_end_clean();
		}
?>
<script type="text/javascript">
var rhc_event_tpl = <?php echo json_encode($value)?>;
</script>
<?php		
	}
	
	function calendarize_form_fields($t){
		$i = count($t);
		//--Custom Post Types -----------------------		
		$i++;
		$t[$i]->id 			= 'cbw-custom-types'; 
		$t[$i]->label 		= __('Custom Post Types','rhc');
		$t[$i]->right_label	= __('Enable calendar metabox for other post types.','rhc');
		$t[$i]->page_title	= __('Custom Post Types','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array();
		
		//--------------
		$post_types=array();
		foreach(get_post_types(array(/*'public'=> true,'_builtin' => false*/),'objects','and') as $post_type => $pt){
			if(in_array($post_type,array('revision','nav_menu_item')))continue;
			$post_types[$post_type]=$pt;
		} 
		$post_types = apply_filters('calendar_metabox_post_type_options',$post_types);
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
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);
			
		return $t;	
	}
	
	function calendarize_form(){
		global $rhc_plugin;
		$this->fc_intervals = $rhc_plugin->get_intervals();
		include $rhc_plugin->get_template_path('calendarize_form.php');				
	}
	
	function terms_clauses($clauses, $taxonomy, $args) {
		if (!empty($args['post_type']) && false!==$args['post_type'] )	{
			global $wpdb;
			$args['post_type'] = is_string($args['post_type'])? array($args['post_type']) : $args['post_type'] ;
			$post_types = array();
	
			foreach($args['post_type'] as $cpt)	{
				$post_types[] = "'".$cpt."'";
			}
	
		    if(!empty($post_types))	{
				$clauses['fields'] = 'DISTINCT '.str_replace('tt.*', 'tt.term_taxonomy_id, tt.term_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields']).', COUNT(t.term_id) AS count';
				$clauses['join'] .= ' INNER JOIN '.$wpdb->term_relationships.' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN '.$wpdb->posts.' AS p ON p.ID = r.object_id';
				$clauses['where'] .= ' AND p.post_type IN ('.implode(',', $post_types).')';
				$clauses['orderby'] = 'GROUP BY t.term_id '.$clauses['orderby'];
			}
	    }
	    return $clauses;
	}

	function get_terms_for_tabs($taxonomy,$tax_query,$post_type){
		add_filter('terms_clauses', array( &$this, 'terms_clauses' ), 10, 3);	
		if( !empty($tax_query) && intval( $tax_query['hierarchical_filter'] ) ){
			if( empty( $tax_query['taxonomy'] ) ){
				switch( $taxonomy )  {
					case RHC_CALENDAR:
						$tax_query['taxonomy']=RHC_CALENDAR;
						$tax_query['terms']=$tax_query['calendar'];		
						break;		
					case RHC_ORGANIZER:
						$tax_query['taxonomy']=RHC_ORGANIZER;
						$tax_query['terms']=$tax_query['organizer'];		
						break;						
					case RHC_VENUE:
						$tax_query['taxonomy']=RHC_VENUE;
						$tax_query['terms']=$tax_query['venue'];		
						break;		
				}
			}
			//--
			if( $taxonomy==$tax_query['taxonomy'] ){
				$terms_arr = explode(',', str_replace(' ','',$tax_query['terms']));
				if(count($terms_arr)>0){
					$result = array();
					$done = array();
					foreach($terms_arr as $slug){
						if( $term = get_term_by('slug',$slug,$taxonomy) ){
							if( $tmp_terms = get_terms( $taxonomy, array( 'child_of' => $term->term_id, 'post_type' => $post_type ) ) ){
								if( is_array($tmp_terms) && count($tmp_terms) > 0){
									foreach($tmp_terms as $tmp_term){
										if(in_array($tmp_term->term_id,$done))continue;
										$done[]=$tmp_term->term_id;
										$result[]=$tmp_term;
									}
								}
							}								
						}

					
					}
					return $result;			
				}				
			}
		}	
		
		return get_terms( $taxonomy, array( 'post_type' => $post_type ) );
	}
	
	function get_object_taxonomies( $post_types ){
		if( is_array($post_types) ){
			$taxonomies = array();
			foreach( $post_types as $post_type ){
				$tmp = get_object_taxonomies(array('post_type'=>$post_type),'objects');
				if( is_array($tmp) && count($tmp) > 0 ){
					foreach( $tmp as $taxonomy => $tax ){
						$taxonomies[$taxonomy] = $tax;
					}
				}
			}
		}else{
			$taxonomies = get_object_taxonomies(array('post_type'=>$post_types),'objects');
		}
		
		return $taxonomies;
	}
	
	function calendars_form_tabs($post_type, $tax_query=array()){
		//--- bug fix, when option to show all post types is enabled, calendar btn does not show all terms from all post types.
		global $rhc_plugin;
		if('1'==$rhc_plugin->get_option('show_all_post_types','',true)){
			$post_type = $rhc_plugin->get_option('post_types',array());
			$post_type[] = RHC_EVENTS;			
		}		
		//---
		
		//---
		if( isset($tax_query['feed']) && defined('RHCS_PATH') ){
			if( $tax_query['feed']=='1' ){
				$post_type = 'rhc_source';
			}else if( $tax_query['feed']=='' ){
				if( is_array($post_type) && !in_array('rhc_source',$post_type) ){
					$post_type[]='rhc_source';
				}
			}
		}
		//---
		$taxonomies = $this->get_object_taxonomies( $post_type );
		$taxonomies = apply_filters('calendar_filter_taxonomies',$taxonomies,$post_type);
		if(!empty($taxonomies)){	
			$tabs = array();
			foreach($taxonomies as $taxonomy => $tax){
				$tabs[$taxonomy] = sprintf('<li class="fbd-tabs"><a data-tab-target=".tab-%s">%s</a></li>',$taxonomy,$tax->label);
			}
			//--
			
			$tabs_content = array();
			foreach($taxonomies as $taxonomy => $tax){
				$terms = $this->get_terms_for_tabs($taxonomy, $tax_query, $post_type);
				if(is_array($terms) && count($terms)>0){
					$tmp = sprintf("<div data-taxonomy=\"%s\" class='fbd-filter-group fbd-tabs-panel tab-%s'>",$taxonomy,$taxonomy);
					
					$tmp.='<div class="fbd-checked"></div>';
					$tmp.='<div class="fbd-unchecked">';
					foreach($terms as $i => $term){
						$id = $taxonomy.'_'.$term->slug.'_'.$i;
						$background_color = get_term_meta($term->term_id, 'background_color', true);
						$tmp.=sprintf('<div data-tab-index="%s" class="fbd-cell"><label for="%s"><input %s data-taxonomy="%s" id="%s" class="fbd-checkbox fbd-filter" type="checkbox" name="%s" value="%s" title="%s"/>&nbsp;<span class="fbd-term-label">%s</span></label></div>',
							$i,
							esc_attr($id),
							(empty($background_color)?'':'data-bgcolor="'.$background_color.'"'),
							$taxonomy,
							esc_attr($id),
							$taxonomy.'_'.$term->slug,
							$term->slug,
							esc_attr($term->name),
							$term->name
						);
					}
					$tmp.='</div>';
					$tmp.='<div class="fbd-clear"></div>';
					$tmp.= '</div>';
					
					$tabs_content[$taxonomy] = $tmp;
				}else{
					unset($tabs[$taxonomy]);	
				}
			}
			
			if(count($tabs)>0){
				$content = "<ul class='fbd-ul'>".implode('',$tabs)."</ul>";
				$content.= implode("",$tabs_content);
				return $content;			
			}
		}
		return sprintf('<div class="no-filters">%s</div>',__('No filters available.','rhc'). 'post_type:'.print_r($post_type,true)  );	
	}
	
	function calendars_form($post_type,$search_enable,$search_placeholder, $tax_query){
		global $rhc_plugin; 
		ob_start();
		include $rhc_plugin->get_template_path('calendars_form.php');			
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	function items_tooltip(){
		global $rhc_plugin; 
		include $rhc_plugin->get_template_path('calendar_item_tooltip.php');	
	}
	
	function icalendar_dialog($icalendar,$icalendar_title,$icalendar_description,$icalendar_button,$width=450,$align,$id='rhc-icalendar-modal',$class=""){
		//return '';
		if($icalendar!='1')return;
		ob_start();
?>
<div class="ical-tooltip-template" title="<?php echo $icalendar_title?>" style='display:none;width:<?php echo $width?>px;' data-button_text="<?php echo $icalendar_button ?>">
	<div class="ical-tooltip-holder">
		<div class="fbd-main-holder">
			<div class="fbd-head">
				<div class="rhc-close-icon"><a title="<?php _e('Close','rhc')?>" class="ical-close" href="javascript:void(0);"></a></div>				
			</div>
			<div class="fbd-body">
				<div class="fbd-dialog-content">
					<label for="ical_tooltip_textarea_<?php echo $this->id ?>" class="fbd-label"><?php _e('iCal feed URL','rhc')?>
					<textarea id="ical_tooltip_textarea_<?php echo $this->id ?>" class="ical-url"></textarea>
					</label>
					<p class="rhc-icalendar-description"><?php echo $icalendar_description?></p>			
					<div class="fbd-buttons">
						<a class="ical-clip fbd-button-secondary" href="#"><?php _e('Copy feed url to clipboard','rhc')?></a>
						<a class="ical-ics fbd-button-primary" href="#"><?php _e('Download ICS file','rhc')?></a>
						
					</div>
				</div>
		
			</div>	
		</div>
	</div>
</div>
<?php	
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	function sc_ical_feed($atts,$content=null,$code=""){
		extract(shortcode_atts(array(
			'post_ID'					=> false,
			'icalendar_title'			=> __('iCal Feed','rhc'),
			'icalendar_description'		=> __('Get Feed for iCal (Google Calendar). This is for subscribing to the events in the Calendar. Add this URL to either iCal (Mac) or Google Calendar, or any other calendar that supports iCal Feed.','rhc'),
			'icalendar_button'			=> __('iCal Feed','rhc'),
			'icalendar_width'			=> 450,
			'theme'						=> 'fc',//or ui
			'linkonly'					=> false
		), $atts));
		
		global $rhc_plugin,$post;
		$field_option_map = array(
			"icalendar_width", "icalendar_button", "icalendar_title", "icalendar_description"
		);
		foreach($field_option_map as $field){
			$option = 'cal_'.$field;
			$value = $rhc_plugin->get_option($option,false,true);
			$$field = false===$value?$$field:$value;
		}		
		$id = 'rhc-btn-single-feed-'.$this->id++;

		$post_ID = is_object($post) && property_exists($post,'ID') ? $post->ID : $post_ID;
		$post_ID = intval($post_ID);
		if(0==$post_ID)return '';
		
		$feed = site_url('/?rhc_action=get_icalendar_events&ID='.$post_ID);
		$ics_download = $feed.'&ics=1';
		//------
		
		//------
		ob_start();
?>

<div class="rhcalendar">
	<div id="<?php echo $id ?>" data-width="<?php echo $icalendar_width?>" data-title="<?php echo $icalendar_title?>" data-theme="<?php echo $theme?>" class="rhc-ical-feed-cont ical-tooltip ical-tooltip-holder" title="<?php echo $icalendar_title?>" style='display:none;' data-icalendar_button="<?php echo $icalendar_button ?>">
		<div class="fbd-main-holder">
			<div class="fbd-head">
				<div class="rhc-close-icon"><a title="<?php _e('Close dialog','rhc')?>" class="ical-close" href="javascript:void(0);"></a></div>				
			</div>
			<div class="fbd-body">
				<div class="fbd-dialog-content">
					<label for="fbd_ical_tooltip_textarea_<?php echo $this->id.'_'.$post->ID ?>" class="fbd-label"><?php _e('iCal feed URL','rhc')?>
					<textarea id="fbd_ical_tooltip_textarea_<?php echo $this->id.'_'.$post->ID ?>" class="ical-url"><?php echo $feed?></textarea>
					</label>
					<p class="rhc-icalendar-description"><?php echo $icalendar_description?></p>			
					<div class="fbd-buttons">
						<a rel="nofollow" class="ical-ics fbd-button-primary" href="<?php echo ($ics_download)?>"><?php _e('Download ICS file','rhc')?></a>						
					</div>
				</div>
		
			</div>	
		</div>
	</div>
</div>
<?php	
		$content = ob_get_contents();
		ob_end_clean();
		return $content;		
	}
	
	function handle_date_shortcode($atts,$content=null,$code=""){
		extract(shortcode_atts(array(
			'post_id'				=> false,
			'date_format'			=> false
		), $atts));
		
		do_action('enqueue_frontend_only');
		
		$post_id = false===$post_id ? get_the_ID() : $post_id ;
		if($code=='rhc_start_date'){
			return fc_get_repeat_start_date($post_id, $date_format);
		}elseif($code=='rhc_end_date'){
			return fc_get_repeat_end_date($post_id, $date_format);
		}else{
			return '';
		}
	}
	
	static function addURLParameter($url, $paramName, $paramValue) {
	     $url_data = parse_url($url);
	     if(!isset($url_data["query"])){
		 	$url_data["query"]="";
		 }
	     $params = array();
	     parse_str($url_data['query'], $params);
	     if(false===$paramValue){
		 	if(isset($params[$paramName])){
				unset($params[$paramName]);
			}
		 }else{
		 	$params[$paramName] = $paramValue;
		 }
		 if(empty($params)){
		 	if(isset($url_data['query'])){
				unset($url_data['query']);
			}
		 }else{
		 	$url_data['query'] = http_build_query($params);
		 }
	     
	     return shortcode_calendarize::build_url($url_data);
	}

	static function build_url($url_data) {

	    $url="";
	    if(isset($url_data['host']))
	    {
	        $url .= $url_data['scheme'] . '://';
	        if (isset($url_data['user'])) {
	            $url .= $url_data['user'];
	                if (isset($url_data['pass'])) {
	                    $url .= ':' . $url_data['pass'];
	                }
	            $url .= '@';
	        }
	        $url .= $url_data['host'];
	        if (isset($url_data['port'])) {
	            $url .= ':' . $url_data['port'];
	        }
	    }
	    $url .= $url_data['path'];
	    if (isset($url_data['query'])) {
	        $url .= '?' . $url_data['query'];
	    }
	    if (isset($url_data['fragment'])) {
	        $url .= '#' . $url_data['fragment'];
	    }
	    return $url;
	}	
	
	function get_gotodate( $gotodate ){
		//--- next/previous week
		foreach( array(
			'next_week' 	=> 7,
			'previous_week'	=> -7,
			'prev_week'		=> -7
		) as $needle => $days){
			if( 0===strpos($gotodate,$needle) ){
				$multiplier = str_replace($needle,'',$gotodate);
				$multiplier = intval(str_replace('+','',$multiplier));
				$multiplier = $multiplier<1 ? 1 : $multiplier;
				$gotodate = date('Y-m-d', mktime(0,0,0, date('m'), date('d')+($days*$multiplier), date('Y')) ); 
				return $gotodate;
			}
		}
		//--- next/previous month
		foreach( array(
			'next_month' 		=> 1,
			'previous_month'	=> -1,
			'prev_month'		=> -1
		) as $needle => $months){
			if( 0===strpos($gotodate,$needle) ){
				$multiplier = str_replace($needle,'',$gotodate);
				$multiplier = intval(str_replace('+','',$multiplier));
				$multiplier = $multiplier<1 ? 1 : $multiplier;
				$gotodate = date('Y-m-d', mktime(0,0,0, date('m')+($months*$multiplier), date('d'), date('Y')) ); 
				return $gotodate;
			}
		}
		return $gotodate;
	}
	
	function sc_output_conditions_met ($atts,$content=null,$code=""){
		extract(shortcode_atts(array(
			'conditional_tag' 		=> '',
			'capability'	 		=> '',
			'meta_key'				=> '',
			'meta_value'			=> '',
			'meta_value_default'	=> '' //value to give meta_value if it is empty.
		), $atts));
		
		//---
		if( !empty( $capability ) ){
			if( !current_user_can( $capability ) ){
				return false;
			}
		}	
		
		//---------test wp conditional tags
		if(''!=trim($conditional_tag)){
			$allowed_conditional_tags = apply_filters( 'shortcode_allowed_conditional_tags', array( 
				'is_home',
				'is_front_page',
				'is_singular',
				'is_page',
				'is_single',
				'is_sticky',
				'is_category',
				'is_tax',
				'is_author',
				'is_archive',
				'is_search',
				'is_attachment',
				'is_tag',
				'is_date',
				'is_paged',
				'is_main_query',
				'is_feed',
				'is_trackback',
				'in_the_loop',
				'is_user_logged_in'
				), $code );
			
			$test_tags = explode(',',trim(str_replace(' ','',$conditional_tag)));
			if(is_array($test_tags) && count($test_tags)>0){
				$condition_matched = false;
				foreach($test_tags as $test_method){
					if( in_array($test_method,$allowed_conditional_tags) && $test_method() ){
						$condition_matched = true;
						break;
					}
				}
				if(false===$condition_matched){
					return false;
				}
			}
		}	
		
		//-------- test for post meta_key conditional value 
		if($meta_key!=''){
			global $post; //to be used in a loop where $post is defined.
			$post_ID = property_exists($post,'ID') ? $post->ID : false;

			if(false!==$post_ID){
				$value = get_post_meta($post_ID,$meta_key,true);
				$value = ''==$value?$meta_value_default:$value;		
				//TODO: allow other operators
				if( $value != $meta_value ){
					//condition was not matched.
					return false;
				}
			}		
		}
		//--------
		return true;
	}
		
}

?>