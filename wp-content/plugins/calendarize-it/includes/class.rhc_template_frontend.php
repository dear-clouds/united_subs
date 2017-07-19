<?php

/**
 * 
 * I control what template is used.
 * @version $Id$
 * @copyright 2003 
 **/

class rhc_template_frontend {
	var $is_taxonomy = false;
	var $is_custom_tax = false;
	var $theme_meta_fields=array();
	var $template_page = false;
	var $taxonomy_template_page_id = false;
	var $term_permalink = false;
	function __construct(){
		global $rhc_plugin;
		if( '1'!=$rhc_plugin->get_option('template_archive')){
			add_filter('archive_template', array(&$this,'archive_template'));	
		}
		if( '1'!=$rhc_plugin->get_option('template_single')){
			//add_filter('single_template', array(&$this,'single_template'),1,1);
			add_filter('page_template', array(&$this,'page_template'),1,1);
		}
		if( '1'!=$rhc_plugin->get_option('template_taxonomy')){
			add_filter('taxonomy_template', array(&$this,'taxonomy_template'));	
			//---
			//bug fix, taxonomies returning the permalink to the template and not the taxonomy due to how template is implemented.
			add_filter( 'page_link', array(&$this,'taxonomy_get_permalink'), 10, 3);
			add_filter( 'pre_get_shortlink', array(&$this,'taxonomy_get_shortlink'), 10, 4);
			add_filter( 'get_the_excerpt', array(&$this,'taxonomy_get_the_excerpt'), 10, 1);						
		}
		
		add_filter( 'query_vars', array(&$this,'query_vars') );

		//theme integration:
		$theme_meta_fields = array();
		//-- append fields set in options
		$tmp = $rhc_plugin->get_option('rhc_theme_meta_fields','',true);
		if(!empty($tmp)){
			$arr = explode(',',str_replace(' ','',$tmp));
			if(is_array($arr)&&count($arr)){
				foreach($arr as $meta){
					if(!in_array($meta,$theme_meta_fields)){
						$theme_meta_fields[]=$meta;
					}
				}
			}
		}
		//--
		$theme_meta_fields = apply_filters('rhc_theme_meta_fields', $theme_meta_fields );
		if(!empty($theme_meta_fields)){
			$this->theme_meta_fields = $theme_meta_fields;
			add_filter('get_post_metadata', array(&$this,'theme_meta_fields'),10,4);
		}	
		//---------------------	
		add_action( apply_filters('rhc_theme_fix_get_queried_object', 'template_redirect'), array(&$this,'handle_main_query'), 999);

		if( '1'==$rhc_plugin->get_option('single_event_the_content', '0', true)){
			add_filter('the_events_content', array(&$this,'the_events_content'), 10, 1 );
		}
		
		add_shortcode("rhc_event_microdata", array(&$this,'handle_rhc_event_microdata') );
		add_filter('the_events_content', array(&$this,'auto_microdata'), 10, 1 );
		//--custom singular template handling
		add_filter('the_content', array( &$this, 'the_content' ) );
		add_filter('custom_content_single_event', array( &$this, 'custom_content_single_event' ), 10, 2 );
	}

	function auto_microdata( $out ){
		global $rhc_plugin;		
		if( '1' == $rhc_plugin->get_option( 'enable_rhc_auto_microdata', '1', true) ){
			return $out."\n[rhc_event_microdata]";
		}else{
			return $out;
		}
	}

	function custom_content_single_event( $output, $args ){
		global $rhc_plugin;		
		if( '1' == $rhc_plugin->get_option( 'enable_cctpl_'.RHC_EVENTS, '1', true) ){
			$custom_template = $rhc_plugin->get_option( 'cctpl_'.RHC_EVENTS, '', true);
			if( empty($custom_template) ){
				return $output;
			}else{
				extract( $args );
				return  $this->inject_content( $custom_template, $content );
			} 
		}else{
			extract( $args );
			return  $this->inject_content( '[CONTENT]', $content );
		}

		return $output;
	}

	function the_content( $content ){
		// RHC_EVENTS is handled diferently. this is only for extra post types.
		global $post, $rhc_plugin;


	
		if( $post && property_exists( $post, 'post_type' ) ){
			$post_type = $post->post_type;
			if( $post_type==RHC_EVENTS ) return $content; //<-- RHC_EVENTS post_type not handled by this filter.
			
			$enabled_post_types = $rhc_plugin->get_option('dbox_post_types',array());
			$enabled_post_types = is_array($enabled_post_types)?$enabled_post_types:array();
			$enabled_post_types = apply_filters('rhc_dbox_metabox_post_types',$enabled_post_types);		
	
			if( in_array( $post_type, $enabled_post_types ) && intval( $rhc_plugin->get_option( 'enable_cctpl_' . $post_type, '0', true ) ) ){

				$wrap = $rhc_plugin->get_option( 'cctpl_' .$post_type, '[CONTENT]', true );
				return do_shortcode( $this->inject_content($wrap,$content) );
			}
		}
		return $content;
	}

	function the_events_content( $out ){
		return apply_filters('the_content', $out);
	}
	
	function taxonomy_get_the_excerpt( $str ){
		if( $this->taxonomy_template_page_id > 0 ){
			$str = term_description( $this->term_id, $this->taxonomy );			
		}
		return $str;
	}
	
	function taxonomy_get_shortlink( $shortlink, $id, $context, $allow_slugs ){
		if ( false !== $shortlink )
			return $shortlink;
	
		global $wp_query;
		$post_id = 0;
		if ( 'query' == $context && is_singular() ) {
			$post_id = $wp_query->get_queried_object_id();
			$post = get_post( $post_id );
		} elseif ( 'post' == $context ) {
			$post = get_post( $id );
			if ( ! empty( $post->ID ) )
				$post_id = $post->ID;
		}
	
		// Return p= link for all public post types.
		if ( $post_id > 0 && $post_id == $this->taxonomy_template_page_id ) {
			$shortlink = home_url( sprintf( '?%s=%s', $this->taxonomy, $this->term_slug ) );
		}
		return $shortlink;
	}
	
	function taxonomy_get_permalink( $link, $post_ID, $sample ){
		if( $post_ID == $this->taxonomy_template_page_id ){
			//return the taxonomy permalink, not the page template one.
			return $this->get_term_permalink( $this->term_permalink );	
		}
		return $link;
	}

	function get_term_permalink( $url ){
		if( $this->taxonomy_template_page_id ){		
			return apply_filters('rhc_term_permalink', $this->term_permalink, $url, $this);		
		}
		return $url;
	}
	
	function handle_main_query( $wp ){
		global $rhc_plugin,$wp_query,$wp_the_query,$rhc_template_page_id;
		$o = get_queried_object();
		if(is_single() && $o->post_type==RHC_EVENTS){
			//NOTE: WordPress only allows page post type to use page templates.
			//So this lines are a hack to allow events to be treated as pages and use theme page templates.
			$template_page_id = intval($rhc_plugin->get_option('event_template_page_id',0,true));
			if($template_page_id>0){
				$rhc_template_page_id = $template_page_id;
				$copy_fields = array(
				'ID',
				'post_author','post_date','post_date_gmt'
				,'post_content','post_title','post_excerpt','post_status'
				,'comment_status','ping_status','post_password','post_name','to_ping','pinged','post_modified','post_modified_gmt','post_content_filtered'
				,'post_parent','guid','menu_order'
				,'post_type'
				,'post_mime_type','comment_count','ancestors','filter');
				$copy_fields = apply_filters('rhc_single_template_copy_fields',$copy_fields);
				$values = array();
				foreach( $copy_fields as $field){
					$values[$field] = $o->$field;
				}			
			
				global $wp_filter;	
				if(isset($wp_filter['pre_get_posts'])){
					$bak = $wp_filter['pre_get_posts'];
					unset($wp_filter['pre_get_posts']);				
				}else{
					$bak = false;
				}			
			
				$wp_query = new WP_Query('page_id='.$template_page_id);
			
				$o = $wp_query->get_queried_object();	
				$wrap = $o->post_content;			
				//----- without this, template selection does not gets correctly done, always default.
				global $post;
				$post = $o;
				$post = is_object($post)?$post:(object)array();
				$post->rhc_template_id = $template_page_id;
				$post->post_status = 'publish';//force it as publish 
				//------------			
				$this->template_page = get_page_template();//fetch template before overwritting post.

				if(false!==$bak){
					$wp_filter['pre_get_posts'] = $bak;
				}
				
				foreach( $copy_fields as $field){
					$post->$field = $values[$field];
				}
				$post->post_content = $this->single_template_content($o->post_content,$wrap);		
				$wp_query->post = $post;		
				$wp_the_query = $wp_query;	
			}else{
				$wp_query->is_single = false;
				$wp_query->is_page = true;
			
				$o->post_content = $this->single_template_content($post->post_content);	
				$this->template_page = get_page_template();			
			}			
			//infocus theme fix: autop not applied: if(class_exists('Mysitemyway'))$o->post_content = apply_filters('the_content',$o->post_content);
		}
		return $wp;
	}
	
	function theme_meta_fields($value, $object_id, $meta_key, $single){
		global $post, $rhc_template_page_id;

		$rhc_template_id = is_object($post) && property_exists($post,'rhc_template_id') ? $post->rhc_template_id : 0 ;
		$rhc_template_id = 	$rhc_template_id==0 && isset($rhc_template_page_id) && $rhc_template_page_id>0 ? $rhc_template_page_id : $rhc_template_id ;		

		if($single==='mix'){
			return $value;
		}else if( $rhc_template_id > 0  && $object_id!=$rhc_template_id ){
			if( empty($meta_key)){
				$default = get_post_meta($rhc_template_id,'',$single);
				$default = is_array($default) ? $default : array();
				$current = array();
				//this is need to put the event meta data on top of the default meta data from the template.
				$current = get_post_meta($post->ID,'','mix');//hack, i couldnt figure out how to skip this block to avoid an infinite loop. 
				$current = is_array($current) ? $current : array();
				return array_replace( $default, $current );
			}else if( in_array($meta_key,$this->theme_meta_fields) ){
				return get_post_meta($post->rhc_template_id,$meta_key,$single);	
			}		
		}

		return $value;
	}
	
	function get_template_path(){
		global $rhc_plugin;
		return $rhc_plugin->get_template_path();
	}
	
	function query_vars($vars){
		array_push($vars,RHC_DISPLAY);
		return $vars;
	}
	
	function is_calendar(){
		global $rhc_plugin;
		return (get_query_var( RHC_DISPLAY )==$rhc_plugin->get_option('rhc-visualcalendar-slug',RHC_VISUAL_CALENDAR,true));
	}
	
	function archive_template($template){	
		if( $this->is_calendar() ){
			global $rhc_plugin,$wp_query,$post; 
			$template_page_id = intval($rhc_plugin->get_option('calendar_template_page_id',0,true));
			if($template_page_id>0){
				$wp_query = new WP_Query('page_id='.$template_page_id);
				$o = $wp_query->get_queried_object();				
				//----- without this, template selection does not gets correctly done, always default.
				$post = $o;
				//------------			
				$template = get_page_template();//fetch template before overwritting post.
				$o->post_content = $this->archive_template_content($o->post_content);	
			}else{
				$template = $this->query_template( $this->get_template_path().'archive-'.get_query_var( 'post_type' ).'-calendar.php' );			
			}			
		}	
		return $template;
	}
	
	function archive_template_content($content){
		global $rhc_plugin;
		$rhc_plugin->enqueue_scripts = true;	
		$filename = $this->get_template_path().'content-calendar.php';
		ob_start();
		if(file_exists($filename)){
			include($filename);
		}else{
			echo '[calendarizeit]';
		}	
		$output = ob_get_contents();
		ob_end_clean();
		return $this->inject_content($content,$output);
	}
	
	function page_template($template){
		if(false!==$this->template_page){
			return $this->template_page;
		}
		return $template;
	}
	
	function single_template($template){
		if(false!==$this->template_page){
			return $this->template_page;
		}
		return $template;
	}
	
	function single_template_content($content,$wrap=''){
		global $rhc_plugin;
		//--- prefilter content
		$content = apply_filters( 'rhc_single_template_content_before', $content );
		//--- apply custom content
		$custom_content_single_event = apply_filters( 'custom_content_single_event', false, compact('content','wrap') );
		if( false !== $custom_content_single_event ){
			//$custom_content_single_event = $this->inject_content( $custom_content_single_event, $content );
			return apply_filters('the_events_content', $this->inject_content($wrap, $custom_content_single_event));
		}
		//---
		$rhc_plugin->enqueue_scripts = true;
		$filename = $this->get_template_path().'content-single-event.php';
		ob_start();
		if(file_exists($filename)){
			include($filename);
		}else{
?>
[featuredimage meta_key='enable_featuredimage' meta_value='1' default='1' custom='rhc_top_image']
<?php echo $content ?>
[postinfo meta_key='enable_postinfo' meta_value='1' default='1' class="se-dbox"]
[postinfo meta_key='enable_venuebox' meta_value='1' default='1' id="venuebox" class="se-vbox"]
<?php		
		}	
		$output = ob_get_contents();
		ob_end_clean();
		return apply_filters('the_events_content', $this->inject_content($wrap, $output));
	}

	function handle_rhc_event_microdata($atts,$template='',$code=""){
		//shortcode wrapper for this::event_microdata
		extract(shortcode_atts(array(
			'post_id' 		=> '',
			'next_upcoming'	=> ''
		), $atts));		
		
		if( intval($post_id) > 0 && $post = get_post( $post_id ) ){
		
		}else{
			$post = null;
		}
		
		$next_upcoming = intval( $next_upcoming ) ? true : false ;
				
		return $this->event_microdata( $post, false, $next_upcoming);
	}

	public static function event_microdata( $arg_post=null, $echo=true, $next_upcoming=false ){
		global $post, $rhc_plugin;
		ob_start();
		$p = is_null($arg_post) ? $post : $arg_post ;
		
		$rhc_plugin->done_microdata = !property_exists( $rhc_plugin, 'done_microdata' ) || !is_array( $rhc_plugin->done_microdata ) ? array() : $rhc_plugin->done_microdata ;
		if( in_array( $p->ID, $rhc_plugin->done_microdata ) ){
			return '';//avoid double microdata.
		}else{
			$rhc_plugin->done_microdata[] = $p->ID;
		}		
		
?><div itemscope itemtype="http://schema.org/Event"><?php
?><meta itemprop="name" content="<?php the_title() ?>"><?php	
?><meta itemprop="url" content="<?php echo get_permalink( $p->ID ) ?>"><?php	
		if(isset($_REQUEST['event_rdate'])&&''!=$_REQUEST['event_rdate']){
			$arr = explode(',',$_REQUEST['event_rdate']);
			$event_start = $arr[0];
			$event_end = $arr[1];
		}else{
			if( $next_upcoming ){
				global $wpdb;
				$sql = "SELECT event_start, event_end FROM `{$wpdb->prefix}rhc_events` WHERE post_id={$p->ID} AND event_start>NOW() ORDER BY event_start ASC LIMIT 1;";
				$event_start = $wpdb->get_var($sql,0,0);
				$event_end = $wpdb->get_var($sql,1,0);
				if( empty($event_start) || empty($event_end) ){
					$event_start = get_post_meta($p->ID,'fc_start_datetime',true);
					$event_end = get_post_meta($p->ID,'fc_end_datetime',true);							
				}
			}else{
				$event_start = get_post_meta($p->ID,'fc_start_datetime',true);
				$event_end = get_post_meta($p->ID,'fc_end_datetime',true);			
			}	

		}
		$ts_start = strtotime($event_start);
		$ts_end = strtotime($event_end);		
		if($ts_end<$ts_start){
			$ts_end = $ts_start;
		}
		$start = date('Y-m-d\TH:i:s',$ts_start);
		$end = date('Y-m-d\TH:i:s',$ts_end);
		
?><meta itemprop="startDate" content="<?php echo esc_attr( $start ) ?>"><?php
?><meta itemprop="endDate" content="<?php echo esc_attr( $end ) ?>"><?php		

		//venues
		$venues =  wp_get_post_terms( $p->ID, RHC_VENUE, array() );
		if( is_array($venues) && count($venues)>0 ){
			foreach($venues as $v ){
				rhc_template_frontend::venue_microdata( $v );
			}
		}
		//organizers
		$organizers =  wp_get_post_terms( $p->ID, RHC_ORGANIZER, array() );
		if( is_array($organizers) && count($organizers)>0 ){
			foreach($organizers as $organizer ){
				rhc_template_frontend::organizer_microdata( $organizer );
			}
		}		
?></div><?php
		$output = ob_get_contents();
		if(!$echo){
			ob_end_clean();
		}
		return $output;
	}
	
	public static function organizer_microdata( $organizer, $inside_event=true ){
?><div <?php if($inside_event):?>itemprop="organizer"<?php endif;?> itemscope itemtype="http://schema.org/Organization"><?php
?><meta itemprop="name" content="<?php echo esc_attr( $organizer->name ) ?>"><?php	
				//-- several independant
				foreach( array(
					'url'		=> 'website',
					'telephone'	=> 'phone',
					'image'		=> 'image',
					'email'		=> 'email'
					) as $field => $meta ){
					$$field = get_term_meta($organizer->term_id, $meta, true);
if(!empty($$field)):?><meta itemprop="<?php echo $field?>" content="<?php echo esc_attr( $$field )?>"><?php endif;	
				}
				
				
?></div><?php
	}
	
	public static function venue_microdata( $v, $inside_event=true ){
?><div <?php if($inside_event):?>itemprop="location"<?php endif;?> itemscope itemtype="http://schema.org/Place"><?php
?><meta itemprop="name" content="<?php echo esc_attr( $v->name ) ?>"><?php	
				//-- several independant
				foreach( array(
					'url'		=> 'website',
					'telephone'	=> 'phone',
					'image'		=> 'image'
					) as $field => $meta ){
					$$field = get_term_meta($v->term_id, $meta, true);
if(!empty($$field)):?><meta itemprop="<?php echo $field?>" content="<?php echo esc_attr( $$field )?>"><?php endif;	
				}
				
				$gaddress = get_term_meta($v->term_id,'gaddress',true);
				if(!empty($gaddress)){
?><meta itemprop="hasMap" content="http://maps.google.com/?q=<?php echo urlencode($gaddress)?>"><?php				
				}

				//-- postal address
				$address 	= get_term_meta($v->term_id, 'address', true);
				$locality	= get_term_meta($v->term_id, 'city', true);
				$region		= get_term_meta($v->term_id, 'state', true);
				$zip 		= get_term_meta($v->term_id, 'zip', true);
				
				if( !empty($address) || !empty($locality) || !empty($region) || !empty($zip) ){
?><div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><?php
if(!empty($address)):?><meta itemprop="streetAddress" content="<?php echo esc_attr( $address )?>"><?php endif;	
if(!empty($locality)):?><meta itemprop="addressLocality" content="<?php echo esc_attr( $locality )?>"><?php	 endif;
if(!empty($region)):?><meta itemprop="addressRegion" content="<?php echo esc_attr( $region )?>"><?php endif;	
if(!empty($zip)):?><meta itemprop="postalCode" content="<?php echo esc_attr( $zip )?>"><?php endif;	
?></div><?php				
				}
				
				//-- geo
				$lat = get_term_meta($v->term_id, 'glat', true);
				$lng = get_term_meta($v->term_id, 'glon', true);
				if( !empty($lat) && !empty($lng) ){
?><div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates"><?php
?><meta itemprop="latitude" content="<?php echo esc_attr($lat)?>"><?php	
?><meta itemprop="longitude" content="<?php echo esc_attr($lng)?>"><?php	
?></div><?php
				}
				
?></div><?php
	}
		
	function taxonomy_template($template){	
		global $wp_query,$wp_the_query,$rhc_plugin;

		$cat = $wp_query->get_queried_object();
		//handle a situation where plugins or themes takeover the main query object and does not return it to its original state.
		//causing this script to load the version 1 template instead of the version 2.
		if(!is_object($cat)||!property_exists($cat,'taxonomy')){
			$taxonomies = apply_filters('rhc-taxonomies',array());
			if( is_array($taxonomies) && count($taxonomies)>0 && is_array($wp_query->query) && count($wp_query->query)>0 ){
				foreach( $wp_query->query as $q_taxonomy => $q_term ){
					if( array_key_exists($q_taxonomy, $taxonomies) ){
						$o_term = get_term_by('slug', $q_term, $q_taxonomy);
						$cat = $o_term;
						break;
					}
				}
			}						
		}
		//---			
		$this->is_taxonomy = true;
		$term_id 	= $this->term_id = $cat->term_id;
		$name 		= $cat->name;
		$taxonomy	= $this->taxonomy = $cat->taxonomy;
		$this->term_slug = $cat->slug;
		$term_permalink = $this->term_permalink = get_term_link($cat, $taxonomy);
		$this->term = $cat;
		
		$template_page_id = $this->get_taxonomy_template_page_id($term_id,$taxonomy);
		if($template_page_id){
			global $wp_filter;	
			//---wpml fix part 1	
			$backup_filters = array();
			foreach(array('posts_join','posts_where','pre_get_posts') as $hook_name){
				if(isset($wp_filter[$hook_name])){
					$backup_filters[$hook_name] = $wp_filter[$hook_name];
					unset($wp_filter[$hook_name]);				
				}
			}
			//---	
					
			$wp_query = new WP_Query('page_id='.$template_page_id);
			$o = $wp_query->get_queried_object();
			//----- without this, template selection does not gets correctly done, always default.
			global $post;
			$post = $o;
			//------------
			$template = get_page_template();
			//---wpml fix part 2
			if(!empty($backup_filters)){
				foreach($backup_filters as $hook_name => $backup_filter){
					$wp_filter[$hook_name] = $backup_filter;				
				}
				unset($backup_filters);
			}
			//---
			$post_content = do_shortcode( $o->post_content ) ; //do template shortcodes so that it flags if there is custom content
			$post_content = $this->get_taxonomy_content($term_id,$taxonomy, $post_content );
/*
			$post_content = str_replace("\n","",$post_content);//autop adds p tags
			$post_content = str_replace("\r","",$post_content);
			$post_content = str_replace("\t","",$post_content);
*/
			$o->guid = $term_permalink;
			$o->post_title = $name;
			$rhc_plugin->template_taxonomy_title = $name;
			$o->post_content = do_shortcode($post_content);
			$wp_query->post = $o;	
			$wp_the_query = $wp_query;
			
			do_action('rhc_taxonomy_template_page_id_set', $template_page_id, $this->term );
			
			return $template;		
		}
		return $this->_taxonomy_template($template);
	}

	function _taxonomy_template($template){	
		if( $this->is_calendar() ){
			$template = $this->query_template( $this->get_template_path().'taxonomy-calendar.php' );				
		}else{
			$map_original_name = array(
				RHC_VENUE 		=> 'venue',
				RHC_ORGANIZER	=> 'organizer',
				RHC_CALENDAR	=> 'calendar'
			);
			$o = get_queried_object();
			//handle a situation where plugins or themes takeover the main query object and does not return it to its original state.
			if(!is_object($o)||!property_exists($o,'taxonomy')){
				global $wp_query;
				$taxonomies = apply_filters('rhc-taxonomies',array());
				if( is_array($taxonomies) && count($taxonomies)>0 && is_array($wp_query->query) && count($wp_query->query)>0 ){
					foreach( $wp_query->query as $q_taxonomy => $q_term ){
						if( array_key_exists($q_taxonomy, $taxonomies) ){
							$o = (object)array(
								'taxonomy' => $q_taxonomy
							);
							break;
						}
					}
				}						
			}
			//---			
			$filename = sprintf('%staxonomy-%s.php',
				$this->get_template_path(),
				isset($map_original_name[$o->taxonomy])?$map_original_name[$o->taxonomy]:$o->taxonomy
			);

			if(file_exists( $filename )){
				return $filename;
			}else{
				$taxonomies = apply_filters('rhc-taxonomies',array());
				if(is_array($taxonomies) && count($taxonomies)>0 && array_key_exists($o->taxonomy,$taxonomies)){
					return sprintf('%staxonomy-%s.php',
						$this->get_template_path(),
						'custom'
					);					
				}	
			}
		}		

		return $template;
	}
	
	function get_taxonomy_template_page_id($term_id,$taxonomy){
		global $wpdb;
		//-------------------------
		if(false!==$this->taxonomy_template_page_id && $this->taxonomy_template_page_id > 0){
			return $this->taxonomy_template_page_id;
		}		
		//-------------------------
		$default_taxonomies = array(
			RHC_CALENDAR 	=> __('Calendar','rhc'),
			RHC_ORGANIZER	=> __('Organizer','rhc'),
			RHC_VENUE		=> __('Venues','rhc')
		);
		
		$taxonomies = apply_filters('rhc-taxonomies',$default_taxonomies);
		//-------------------------	
		$page_id = intval(get_term_meta($term_id,'template_page_id',true));
		if($page_id==0 && in_array($taxonomy, array_keys($taxonomies) )){
			global $rhc_plugin; 
			$page_id = intval($rhc_plugin->get_option( $taxonomy.'_template_page_id',0,true));
			if($page_id==0){
				$page_id = intval($rhc_plugin->get_option('taxonomy_template_page_id',0,true));
			}
		}

		if($page_id>0){
			if('page'==$wpdb->get_var("SELECT post_type FROM {$wpdb->posts} WHERE ID={$page_id}",0,0)){
				$this->taxonomy_template_page_id = $page_id;
				return $page_id;		
			}
		}
		
		return 0;
	}
	
	function get_taxonomy_content($_term_id,$_taxonomy,$wrap=''){
		if( $this->is_custom_tax ){
			return $wrap;
		}
		global $term_id,$taxonomy;
		global $rhc_plugin;
		$rhc_plugin->enqueue_scripts = true;
				
		$term_id = $_term_id;
		$taxonomy = $_taxonomy;
		$term = get_term($term_id,$taxonomy);
		$content = get_term_meta($term_id,'content',true);
		$content = trim($content)==''?$term->description:$content;
		
		$website = get_term_meta($term_id,'website',true);
		$href = false===strpos($website,'://')?'http://'.$website:$website;
		ob_start();
		
		if($taxonomy==RHC_VENUE){
			$this->venue_microdata( $term, false );
		}
		
		$feed = '1'==$rhc_plugin->get_option( 'enable_feed_in_taxonomy_page', '0', true) ? '' : '0';
		
		$filename1 = $this->get_template_path().'content-taxonomy-'.$taxonomy.'.php';
		$filename2 = $this->get_template_path().'content-taxonomy.php';
		if(file_exists($filename1)){
			include($filename1);
		}else if(file_exists($filename2)){
			include($filename2);
		}else{	
			echo '[CONTENT]';
		}
		$output = ob_get_contents();
		ob_end_clean();
		return $this->inject_content($wrap,$output);
	}
	
	function query_template($filename){
		if(file_exists($filename)){
			return $filename;
		}else{
			$filename = $this->get_template_path().'calendar.php';
			if(file_exists( $filename )){
				return $filename;
			}else{
				return RHC_PATH.'templates/default/calendar.php';
			}
		}
	}
	
	function inject_content($wrap,$content){
		if(false!==strpos($wrap,'[CONTENT]')){
			$content = str_replace('[CONTENT]',$content,$wrap);
		}else{
			$content = $wrap.$content;
		}
		return $content;
	}
	
	function get_page_template( $id ) {//based on wp template.php, modified so it can take an id instead of using the main query, as we want to fetch the template of anohter page.
		//$id = get_queried_object_id();
		$template = get_page_template_slug( $id );
		$pagename = get_query_var('pagename');
	
		if ( ! $pagename && $id ) {
			// If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object
			$post = get_post( $id );
			if ( $post )
				$pagename = $post->post_name;
		}
	
		$templates = array();
		if ( $template && 0 === validate_file( $template ) )
			$templates[] = $template;
		if ( $pagename )
			$templates[] = "page-$pagename.php";
		if ( $id )
			$templates[] = "page-$id.php";
		$templates[] = 'page.php';
	
		return get_query_template( 'page', $templates );
	}	
}
?>