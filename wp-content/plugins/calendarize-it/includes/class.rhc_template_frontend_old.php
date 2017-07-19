<?php

/**
 * 
 * I control what template is used.
 * @version $Id$
 * @copyright 2003 
 **/

class rhc_template_frontend {
	function __construct(){
		global $rhc_plugin;
		if( '1'!=$rhc_plugin->get_option('template_archive')){
			add_filter('archive_template', array(&$this,'archive_template'));	
		}
		if( '1'!=$rhc_plugin->get_option('template_single')){
			add_filter('single_template', array(&$this,'single_template'));
		}
		if( '1'!=$rhc_plugin->get_option('template_taxonomy')){
			add_filter('taxonomy_template', array(&$this,'taxonomy_template'));	
			add_filter('category_template', array(&$this,'taxonomy_template'));	
		}
		
		add_filter( 'query_vars', array(&$this,'query_vars') );
		
		add_action('rhc_before_content',array(&$this,'before_content'));
		add_action('rhc_after_content',array(&$this,'after_content'));
		add_shortcode('rhc_sidebar', array(&$this,'rhc_sidebar_shortcode') );
	}

	function rhc_sidebar_shortcode($atts,$content=null,$code=""){
		$output = '';
		include_once RHC_PATH.'includes/class.rhc_sidebar_shortcode.php';
		return $output;
	}
	
	function before_content(){
		global $rhc_plugin;
		echo do_shortcode($rhc_plugin->get_option('rhc-before-content'));
	}
	
	function after_content(){
		global $rhc_plugin;
		echo do_shortcode($rhc_plugin->get_option('rhc-after-content'));
	}
	
	function get_template_path(){
		global $rhc_plugin;
		return $rhc_plugin->get_template_path();
		//return apply_filters('rhc_templates_path',RHC_PATH.'templates/default/');
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
			$template = $this->query_template( $this->get_template_path().'archive-'.get_query_var( 'post_type' ).'-calendar.php' );				
		}	
		return $template;
	}
	
	function single_template($template){
		$o = get_queried_object();
		if($o->post_type==RHC_EVENTS){
			$filename = $this->get_template_path().'single-event.php';
			if(file_exists($filename)){
				return $filename;
			}
		}

		return $template;
	}
	
	function taxonomy_template($template){	
		if( $this->is_calendar() ){
			$template = $this->query_template( $this->get_template_path().'taxonomy-calendar.php' );				
		}else{
			$map_original_name = array(
				RHC_VENUE 		=> 'venue',
				RHC_ORGANIZER	=> 'organizer',
				RHC_CALENDAR	=> 'calendar'
			);
			$o = get_queried_object();
			$filename = sprintf('%staxonomy-%s.php',
				$this->get_template_path(),
				isset($map_original_name[$o->taxonomy])?$map_original_name[$o->taxonomy]:$o->taxonomy
			);

			if(file_exists( $filename )){
				return $filename;
			}
		}		

		return $template;
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
	
	public static function event_microdata( $arg_post=null, $echo=true, $next_upcoming=false ){
		global $post;
		ob_start();
		$p = is_null($arg_post) ? $post : $arg_post ;
		
		
		
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
}
?>