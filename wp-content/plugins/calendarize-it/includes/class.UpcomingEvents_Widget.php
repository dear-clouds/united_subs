<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class UpcomingEvents_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
	 		'upcoming_events_widget', 
			__('Calendarize (Upcoming Events)','rhc'), 
			array( 'description' => __( 'Upcoming events', 'rhc' ), ) 
		);
	}

	function widget( $args, $instance ) {
		$args = apply_filters( 'uew_args', $args, $instance );
		$instance = apply_filters( 'uew_instance', $instance, $args );
		if( false===$instance ) return true;
		extract( $args );
		global $post,$rhc_plugin;
		$tmp_post = $post;
		//----
		foreach(array('title','number','template') as $field ){
			$$field = @$instance[$field];
		}
		if(intval($number)==0)return;		
		echo $before_widget;
		echo trim($title)==''?'':$before_title.$title.$after_title;

		$sel = 'rhc-upcoming-'.$rhc_plugin->uid++;
		echo sprintf("<div id=\"%s\"></div>",$sel);
		
		if( '1'==$rhc_plugin->get_option('uew_original_enable','0',true) ){
			//original widget.
			$this->get_upcoming($instance,$sel);		
			echo "<!-- original uew -->";			
		}else{
			//fullcalendar integrated widget
			$this->get_shortcode($instance, $sel);
			echo "<!-- fullcalendar integrated uew -->";			
		}
		
		echo apply_filters('rhc_after_upcoming_events_widget','',$args,$instance);
		echo $after_widget;				
		//-----
		$post = $tmp_post;	
	}
	
	function get_supe_shortcode($args,$sel){
		extract($args);

		$class = isset( $class ) ? $class : '';

		$extra = array();
		
		$extra[] = 'for_sidebar="1"';
		
		$number = intval($number);
		$number = $number==0?5:$number;
		
		$words = intval($words);
	
		$map = array(
			'fcdate_format' => 'date_format',
			'fctime_format' => 'time_format'
		);
		foreach( array('class','template','number','horizon','feed','words','fcdate_format','fctime_format','calendar_url') as $field ){
			if( ''!=trim($$field) ){//fixed in the previous commit.
				$value = $$field;
				$field = isset( $map[$field] ) ? $map[$field] : $field;
				$extra[] = sprintf('%s="%s"', $field, $value );
			}
		}
		
		$extra[] = "order=\"ASC\"";
		
		if(trim($specific_date)!=''){
			$start = $specific_date.' 00:00:00';				
			$ts = strtotime($start);
			$end = date('Y-m-d 23:59:59', mktime(0,0,0,date('m',$ts)+12, date('d',$ts), date('Y',$ts)));
			if(trim($specific_date_end)!=''){
				$ts = strtotime($specific_date_end);
				$end = date('Y-m-d 23:59:59', mktime(0,0,0,date('m',$ts), date('d',$ts), date('Y',$ts)));
			}
			$historic=1;
		
			$extra[] = "date=\"$start\"";
			$extra[] = "date_end=\"$end\"";
		}else{
			/*
			$start = date('Y-m-d 00:00:00',mktime(0,0,0,date('m'),date('d')-1,date('Y')));		
			$end = date('Y-m-d 23:59:59',mktime(0,0,0,date('m')+12,date('d'),date('Y')));		
			$historic=0;
			*/
		}	

		
		if(empty($taxonomy)){
			$taxonomies = array();
			$terms = array();
			
			if( !empty($calendar) ){
				$taxonomies[] = RHC_CALENDAR;
				$term = get_term_by( 'id', $calendar, RHC_CALENDAR );				
				$terms[] = $term->slug;
			}
			
			if( !empty($venue) ){
				$taxonomies[] = RHC_VENUE;
				$term = get_term_by( 'id', $venue, RHC_VENUE );				
				$terms[] = $term->slug;
			}
			
			if( !empty($organizer)){
				$taxonomies[] = RHC_ORGANIZER;
				$term = get_term_by( 'id', $organizer, RHC_ORGANIZER );				
				$terms[] = $term->slug;
			}
			
			if( !empty($taxonomies) ){
				$taxonomy = implode(',',$taxonomies);
				$terms = implode(',',$terms);
			}	
		}
		
		if( !empty($taxonomy) && !empty($terms) ){
			$extra[] = sprintf('taxonomy="%s"', $taxonomy );
			$extra[] = sprintf('terms="%s"', $terms );
		}

		if(is_array($post_type)&&count($post_type)>0){
			$extra[] = sprintf('post_type="%s"', implode(',',$post_type) );
		}
		
		if( '1'==$showimage){
			$extra[] = 'showimage="1"';
		}else{
			$extra[] = 'showimage="0"';
		}
		
		if(''!=trim($no_events_message)){
			$extra[]='no_events_message="'.$no_events_message.'"';		
		}

		if( trim( $premiere ) != '' ){
			$extra[] = sprintf('premiere="%s"',$premiere);
		}
		
		$extra[]='parse_postmeta="fc_click_link"';
		
		$sc = sprintf('[rhc_static_upcoming_events %s]',
			implode(' ', $extra)
		);
		
		if(isset($_REQUEST['rhc_debug']) && current_user_can('manage_options'))
			echo $sc;
		
		echo do_shortcode( $sc );
	}
	
	function get_shortcode($widget_args,$sel){
		global $rhc_plugin;
		
		foreach(array('class','feed', 'premiere', 'loading_method', 'template', 'post_type','calendar','venue','organizer','taxonomy','terms','auto','horizon','number','showimage','words','dayspast','fcdate_format','fctime_format','calendar_url','specific_date','specific_date_end','author_name','no_events_message') as $field ){
			$$field = isset($widget_args[$field])?$widget_args[$field]:'';
			//echo $field.": ".$$field."<BR />";
		}		
		
		if( $loading_method=='server' ){
			return $this->get_supe_shortcode( compact('class','feed', 'premiere', 'loading_method', 'template', 'post_type','calendar','venue','organizer','taxonomy','terms','auto','horizon','number','showimage','words','dayspast','fcdate_format','fctime_format','calendar_url','specific_date','specific_date_end','author_name','no_events_message'), $sel );
		}
		
		if(trim($specific_date)!=''){
			$start = $specific_date.' 00:00:00';				
			$ts = strtotime($start);
			$end = date('Y-m-d 23:59:59', mktime(0,0,0,date('m',$ts)+12, date('d',$ts), date('Y',$ts)));
			if(trim($specific_date_end)!=''){
				$ts = strtotime($specific_date_end);
				$end = date('Y-m-d 23:59:59', mktime(0,0,0,date('m',$ts), date('d',$ts), date('Y',$ts)));
			}
			$historic=1;
		}else{
			$start = date('Y-m-d 00:00:00',mktime(0,0,0,date('m'),date('d')-1,date('Y')));		
			$end = date('Y-m-d 23:59:59',mktime(0,0,0,date('m')+12,date('d'),date('Y')));		
			$historic=0;
		}	

		$number = intval($number);
		$number = $number==0?5:$number;
		
		$extra = array();
		if( !empty($class) ){
			$extra[]=sprintf('class="%s"', $class );
		}
		
		if(is_array($post_type)&&count($post_type)>0){
			$extra[]=sprintf('post_type="%s"', implode(',',$post_type) );
		}

		if(!empty($taxonomy)){
			$extra[]='taxonomy="'.$taxonomy.'"';
			$extra[]='terms="'.$terms.'"';
		}else{
			if(!empty($calendar)){
				if($slug = get_term_by('id',$calendar,RHC_CALENDAR)){
					$extra[]='calendar="'.$slug->slug.'"';	
				}
			}
			if(!empty($organizer)){
				if($slug = get_term_by('id',$organizer,RHC_ORGANIZER)){
					$extra[]='organizer="'.$slug->slug.'"';	
				}
			}
			if(!empty($venue)){
				if($slug = get_term_by('id',$venue,RHC_VENUE)){
					$extra[]='venue="'.$slug->slug.'"';	
				}
			}
		}		
		
		$extra[]='loading_overlay="1"';
		
		$extra[]= sprintf('preload="%s"',
			$rhc_plugin->get_option('cal_preload','1',true)
		);
		
		$extra[]='tax_filter="0"';
		
		$extra[]='eventlistupcoming="1" eventlistmonthsahead="24"';
		
		if(''!=trim($feed)){
			$extra[]='feed="'.$feed.'"';
		}

		if(''!=trim($author_name)){
			$extra[]='author_name="'.$author_name.'"';		
		}
		
		//-------- this portion is based on the code used on function.generate_calendarize_shortcode.php, TODO: simplify with a function
		$args=array();
		$params=array();
		global $rhc_plugin;
		$field_option_map = array(
			"monthnames","monthnamesshort","daynames","daynamesshort","firstday","eventlistnoeventstext"
		);
		foreach($field_option_map as $field){
			$option = 'cal_'.$field;
			if(isset($params[$field]))continue;
			$value = $rhc_plugin->get_option($option);
			if(trim($value)!=''){
				$params[$field]=$value;
			}
		}
		//--
		if(is_array($params) && count($params)>0){
			foreach($params as $field => $value){
				foreach(array('['=>'&#91;',']'=>'&#93;') as $replace => $with){
					$value = str_replace($replace,$with,$value);
				}
				$args[$field]=sprintf('%s="%s"',$field,$value);
			}	
		}			
		//--------
		
		$sc = sprintf('[calendarize class="upcoming-widget" %s widgetlist_dayspast="%s" eventlist_display="%s" eventlist_template="%s" defaultview="rhc_event" eventlistshowheader="0" header_left="" header_center="" header_right="" icalendar="0" widgetlist_sel="%s" widgetlist_number="%s" widgetlist_showimage="%s" widgetlist_fcdate_format="%s" widgetlist_fctime_format="%s" widgetlist_start="%s" widgetlist_end="%s" widgetlist_horizon="%s" widgetlist_using_calendar_url="%s" widgetlist_loading_method="%s" widgetlist_historic="%s" widgetlist_specific_date="%s" widgetlist_words="%s" widgetlist_premiere="%s" %s]',
			implode(' ',$extra),
			$dayspast,
			$number,
			$template,
			//--
			$sel,
			$number,
			$showimage,
			$fcdate_format,
			$fctime_format,
			$start,
			$end,
			$horizon,
			$calendar_url,
			$loading_method,
			$historic,
			$specific_date,
			$words,
			$premiere,
			implode(' ',$args)
		);
		if(isset($_REQUEST['rhc_debug']) && current_user_can('manage_options'))
			echo $sc;
		echo do_shortcode($sc);
	}
	
	function get_upcoming($widget_args,$sel){
		global $rhc_plugin;
		
		$using_calendar_url = false;
		
		foreach(array('premiere', 'loading_method', 'template', 'post_type','calendar','venue','organizer','taxonomy','terms','auto','horizon','number','showimage','words','fcdate_format','fctime_format','calendar_url','specific_date','specific_date_end','author_name') as $field ){
			$$field = isset($widget_args[$field])?$widget_args[$field]:'';
			//echo $field.": ".$$field."<BR />";
		}		
		
		if(trim($specific_date)!=''){
			$start = $specific_date.' 00:00:00';				
			$ts = strtotime($start);
			$end = date('Y-m-d 23:59:59', mktime(0,0,0,date('m',$ts)+12, date('d',$ts), date('Y',$ts)));
			if(trim($specific_date_end)!=''){
				$ts = strtotime($specific_date_end);
				$end = date('Y-m-d 23:59:59', mktime(0,0,0,date('m',$ts), date('d',$ts), date('Y',$ts)));
			}
			$historic=1;
		}else{
			$start = date('Y-m-d 00:00:00',mktime(0,0,0,date('m'),date('d')-1,date('Y')));		
			$end = date('Y-m-d 23:59:59',mktime(0,0,0,date('m')+12,date('d'),date('Y')));		
			$historic=0;
		}	

		$author_name = ''==$author_name ? false : $author_name;
		
		$number = intval($number);
		$number = $number==0?5:$number;

		$post_type = is_array($post_type)&&!empty($post_type)?$post_type:array(RHC_EVENTS);
		
		if(is_tax()){
			$is_tax = true;
			$o = get_queried_object();
			$args = array(
				'post_type' 	=> $post_type,
				'start'		=> $start,
				'end'		=> $end,
				'taxonomy'	=> $o->taxonomy,
				'terms'		=> $o->slug,
				'calendar'	=> false,
				'venue'		=> false,
				'organizer'	=> false,
				'author'	=> false,
				'author_name'=>$author_name,
				'tax'		=> false,
				'numberposts' => $number
			);			
		}else{
			$is_tax = false;
			$args = array(
				'post_type' 	=> $post_type,
				'start'		=> $start,
				'end'		=> $end,
				'taxonomy'	=> $taxonomy==''?false:$taxonomy,
				'terms'		=> $terms==''?false:$terms,
				'calendar'	=> $calendar==''?false:$calendar,
				'venue'		=> $venue==''?false:$venue,
				'organizer'	=> $organizer==''?false:$organizer,
				'author'	=> false,
				'author_name'=>$author_name,
				'tax'		=> false,
				'tax_by_id' => true,
				'numberposts' => $number
			);
			
			if($args['taxonomy']!==false && $args['terms']!==false){
				$args['tax_by_id']=false;
			}
		}

		if($loading_method=='ajax'){
			$default_events_source = $rhc_plugin->get_option( 'rhc-api-url', '', true );
			if(''==trim($default_events_source)){
				$default_events_source = site_url('/?rhc_action=get_calendar_events');
			}	
			$events = (object)array(
				'ajax_url' 		=> $default_events_source.'&uew=1',
				'args'			=> $args,
				'is_tax'		=> $is_tax,
				'words'			=> $words,
				'calendar_url'	=> $calendar_url
			);		
		}else{
			$events = $rhc_plugin->calendar_ajax->get_events_set($args);			
			if(empty($events))return '';
			$using_calendar_url = false;
			if($calendar_url!=''){
				$using_calendar_url = true;
				foreach($events as $index => $e){
					$events[$index]['url']=$calendar_url;
				}
			}			
		}
	
		if('1'==$premiere && is_array($events)&&count($events)>0){
			foreach($events as $i => $e){
				$events[$i]['fc_rrule']="FREQ=DAILY;INTERVAL=1;COUNT=1";
			}
		}
	
		return $this->render_events($start,$end,$sel,$events,$number,$showimage,$words,$fcdate_format,$fctime_format,$horizon,$using_calendar_url,$template,$loading_method,$historic,$specific_date);
	}

	
	function render_events($start,$end,$sel,$events,$number,$showimage,$description_words=10,$fcdate_format='',$fctime_format='',$horizon='day',$using_calendar_url=false,$template_filename,$loading_method='server',$historic=0,$specific_date){
		global $rhc_plugin;
		$description_words = is_numeric($description_words)?$description_words:10;
		$count = 0;

		$template_filename = ''==$template_filename?'widget_upcoming_events.php':$template_filename;
		$template_filename = $rhc_plugin->get_template_path($template_filename);
		$template_filename = file_exists($template_filename)?$template_filename:$rhc_plugin->get_template_path('widget_upcoming_events.php');	
		$template = file_get_contents($template_filename);
		
		if($loading_method=='server'){
			foreach($events as $i => $e){			
				$description = '';
				$drr = explode(' ',$e['description']);
				for($a=0;$a<$description_words;$a++){
					if(isset($drr[$a]))
						$description.=" ".$drr[$a];
				}
				
				if(count($drr)>$description_words)
				$description.="<a href=\"".$e['url']."\">...</a>";
				
				$events[$i]['description']=$description;
			}
			
			if(empty($events))return '';		
		}
		
		$args = (object)array(
			'sel'=>$sel,
			'number'=>$number,
			'showimage'=>$showimage,
			'fcdate_format'=>$fcdate_format,
			'fctime_format'=>$fctime_format,
			'start'=>$start,
			'end'=>$end,
			'horizon'=>$horizon,
			'using_calendar_url'=>$using_calendar_url,
			'loading_method'=>$loading_method,
			'historic'		=> $historic,
			'specific_date'	=> $specific_date
		);
		
		//-- fill day and month names
		//-------- this portion is based on the code used on function.generate_calendarize_shortcode.php, TODO: simplify with a function
		global $rhc_plugin;
		
		$defaults = array(
			"monthnames"		=> __('January,February,March,April,May,June,July,August,September,October,November,December','rhc'),
			"monthnamesshort"	=> __('Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec','rhc'),
			"daynames"			=> __('Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday','rhc'),
			"daynamesshort"		=> __('Sun,Mon,Tue,Wed,Thu,Fri,Sat','rhc')
		);
		
		$options = (object)array();
		$field_option_map = array(
			"monthnames"=>"monthNames",
			"monthnamesshort"=>"monthNamesShort",
			"daynames"=>"dayNames",
			"daynamesshort"=>"dayNamesShort"
		);
		foreach($field_option_map as $field => $js_field){
			$option = 'cal_'.$field;
			if(isset($params[$field]))continue;
			$value = $rhc_plugin->get_option($option,$defaults[$field],true);
			if(trim($value)!=''){
				$params[$field]=$value;
			}
		}
		//--
		if(is_array($params) && count($params)>0){
			foreach($params as $field => $value){
				foreach(array('['=>'&#91;',']'=>'&#93;') as $replace => $with){
					$value = str_replace($replace,$with,$value);
				}
				$options->$field_option_map[$field]=explode(',',str_replace(' ','',$value));
			}	
		}			
		//--------		
		
		echo "<div class=\"rhc-widget-template\" style=\"display:none;\">".$template."</div>";
		echo sprintf("<script>jQuery(document).ready(function($){try{render_upcoming_events(%s,%s,%s);}catch(error){}});</script>",
			json_encode($args),
			json_encode($events),
			json_encode($options)
		);
//		echo "<pre>";
//		print_r($events);
//		echo "</prE>";

		//echo $sel;		
	}

	function get_template_parts(){
		global $rhc_plugin;
		$template = file_get_contents($rhc_plugin->get_template_path('widget_upcoming_events.php'));
		$parts = (object)array(
			'holder'=>$template,
			'featured'=>''
		);
		if(preg_match('/<!--featured-->(.*)<!--featured-->/si',$template,$matches)){
			$parts->featured = $matches[1];
			$parts->holder = str_replace('<!--featured-->'.$parts->featured.'<!--featured-->','<!--featured-->',$parts->holder);
		}	
		return $parts;	
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = array();
		foreach(array('taxonomy', 'terms', 'loading_method', 'template', 'post_type','calendar','venue','organizer','auto','premiere','title','fcdate_format','fctime_format','horizon','number','showimage','words','dayspast','calendar_url','specific_date','specific_date_end','author_name','no_events_message') as $field){
			$instance[$field] = $new_instance[$field];
		}
		$instance = apply_filters('rhc_widget_upcoming_events_update',$instance,$new_instance,$old_instance);
		return $instance;
	}

	function form( $instance ) {
		$taxmap = array('venue'=>RHC_VENUE,'organizer'=>RHC_ORGANIZER,'calendar'=>RHC_CALENDAR);
		foreach(array('taxonomy'=>'', 'terms'=>'', 'loading_method'=>'server', 'calendar_url'=>'', 'auto'=>0, 'premiere'=>0,'title'=>'','horizon'=>'hour','number'=>5,'showimage'=>0,'words'=>10, 'dayspast'=>'', 'fcdate_format'=>'MMM d, yyyy','fctime_format'=>'h:mmtt', 'specific_date'=>'', 'specific_date_end'=>'', 'author_name'=>'', 'no_events_message'=>'') as $field =>$default){
			$$field = isset( $instance[$field] )?$instance[$field]:$default;		
		}
		//---
		global $rhc_plugin;
		$post_types = $rhc_plugin->get_option('post_types',array(),true);
		array_unshift($post_types,RHC_EVENTS);	
		$checked = isset($instance['post_type'])&&is_array($instance['post_type'])&&count($instance['post_type'])>0?$instance['post_type']:array(RHC_EVENTS);
		//----
		require_once RHC_PATH.'includes/class.rh_templates.php';
		$t = new rh_templates( array('template_directory'=>$rhc_plugin->get_template_path()) );
		$templates = $t->get_template_files('widget_upcoming_events');
		$templates = is_array($templates)&&count($templates)>0?$templates:array('widget_upcoming_events.php');		
		$templates = apply_filters('rhc_uew_templates', $templates);
		
		$current_template = isset($instance['template'])?$instance['template']:'widget_upcoming_events.php';	
?>
<div>
	<div class="" style="margin-top:10px;">
		<label><?php _e('Title','rhc')?></label>
		<input type="text" id="<?php echo $this->get_field_id('title')?>" class="widefat" name="<?php echo $this->get_field_name('title')?>" value="<?php echo $title?>" />
	</div>
	<div class="" style="margin-top:10px;">
		<?php _e('Date format','rhc')?>
		<input type="text" class="widefat" value="<?php echo $fcdate_format ?>" id="<?php echo $this->get_field_id('fcdate_format')?>" name="<?php echo $this->get_field_name('fcdate_format')?>" />
	</div>	
	<div class="" style="margin-top:10px;">
		<?php _e('Time format','rhc')?>
		<input type="text" class="widefat" value="<?php echo $fctime_format ?>" id="<?php echo $this->get_field_id('fctime_format')?>" name="<?php echo $this->get_field_name('fctime_format')?>" />
	</div>
	<div class="" style="margin:10px 0 10px 0;">
		<label><?php _e('Post type','rhc')?></label>
		<div class="widefat" style="border:none;">
			<?php foreach($post_types as $post_type):?>
			<input type="checkbox" <?php echo in_array($post_type,$checked)?'checked="checked"':''?> name="<?php echo $this->get_field_name('post_type')?>[]" value="<?php echo $post_type ?>" />&nbsp;<?php echo $post_type ?><br />
			<?php endforeach;?>		
		</div>
	</div>		
	<?php $this->form_author_name( $author_name );?>
	<div class="" style="margin:10px 0 10px 0;">
		<?php _e('Template','rhc')?>
		<select id="<?php echo $this->get_field_id('template')?>" name="<?php echo $this->get_field_name('template')?>" class="widefat">
			<?php foreach($templates as $value => $label):?>
			<option <?php echo $current_template==$value?'selected="selected"':''?> value="<?php echo $value?>"><?php echo $label?></option>
			<?php endforeach; ?>
		</select>
	</div>	
	<label><?php _e('Event taxonomies:','rhc')?></label>
<?php foreach(array('calendar'=>__('Calendar','rhc'),'venue'=>__('Venue','rhc'),'organizer'=>__('Organizer','rhc')) as $field => $label):$$field = isset( $instance[$field] )?$instance[$field]:'';?>	
	<div class="tax-events tax-field" style="margin-top:10px;">
	<label for="<?php echo $field ?>"><?php echo $label?></label>
	<?php $this->taxonomy_dropdown($taxmap[$field],$this->get_field_id($field),$this->get_field_name($field),(isset( $instance[$field] )?$instance[$field]:''))?>
	</div>
<?php endforeach;?>
	

	<div class="tax-custom tax-field" style="margin-top:10px;">
		<label><?php _e('Custom taxonomies:','rhc')?></label>
		<?php _e('Taxonomy','rhc')?>
		<input type="text" class="widefat" value="<?php echo $taxonomy ?>" id="<?php echo $this->get_field_id('taxonomy')?>" name="<?php echo $this->get_field_name('taxonomy')?>" />
	</div>
	<p style="margin-top:3px;">
		<?php _e('*Overwrites event taxonomies filter.','rhc')?>
	</p>	
	<div class="tax-custom tax-field" style="margin-top:10px;">
		<?php _e('Terms','rhc')?>
		<input type="text" class="widefat" value="<?php echo $terms ?>" id="<?php echo $this->get_field_id('terms')?>" name="<?php echo $this->get_field_name('terms')?>" />
	</div>
	
	<div class="" style="margin-top:10px;">
		<?php _e('Max number of posts','rhc')?>
		<input type="text" class="widefat" value="<?php echo $number ?>" id="<?php echo $this->get_field_id('number')?>" name="<?php echo $this->get_field_name('number')?>" />
	</div>
	
	<div class="" style="margin-top:10px;">
		<?php _e('Max description word count','rhc')?>
		<input type="text" class="widefat" value="<?php echo $words ?>" id="<?php echo $this->get_field_id('words')?>" name="<?php echo $this->get_field_name('words')?>" />
	</div>
	
	<div class="" style="margin-top:10px;">
		<?php _e('Remove event by','rhc')?>
		<select id="<?php echo $this->get_field_id('horizon')?>" name="<?php echo $this->get_field_name('horizon')?>" class="widefat">
			<option value="hour" <?php echo $horizon=='hour'?'selected="selected"':''?> ><?php _e('Hour','rhc')?></option>
			<option value="end" <?php echo $horizon=='end'?'selected="selected"':''?> ><?php _e('At event end','rhc')?></option>			
			<option value="day" <?php echo $horizon=='day'?'selected="selected"':''?> ><?php _e('Day','rhc')?></option>
		</select>
	</div>

	<div class="" style="margin-top:10px;">
		<?php _e('Days in the past','rhc')?>
		<input type="text" class="widefat" value="<?php echo $dayspast ?>" id="<?php echo $this->get_field_id('dayspast')?>" name="<?php echo $this->get_field_name('dayspast')?>" />
	</div>
	
	<div class="" style="margin-top:10px;">
		<?php _e('Show featured image','rhc')?>
		<select id="<?php echo $this->get_field_id('showimage')?>" name="<?php echo $this->get_field_name('showimage')?>" class="widefat">
			<option value="0" <?php echo $showimage=='0'?'selected="selected"':''?> ><?php _e('No image','rhc')?></option>
			<option value="1" <?php echo $showimage=='1'?'selected="selected"':''?> ><?php _e('Show image','rhc')?></option>
		</select>
	</div>	
	
	<div class="" style="margin-top:10px;">
		<?php _e('Loading method','rhc')?>
		<select id="<?php echo $this->get_field_id('loading_method')?>" name="<?php echo $this->get_field_name('loading_method')?>" class="widefat">
			<option value="server" <?php echo $loading_method=='server'?'selected="selected"':''?> ><?php _e('Server side','rhc')?></option>
			<option value="ajax" <?php echo $loading_method=='ajax'?'selected="selected"':''?> ><?php _e('Ajax','rhc')?></option>
		</select>
	</div>
<?php /* currently this would only work with accordion */ ?>
<!--
	<div class="" style="margin-top:10px;">
		<label><?php _e('No event message','rhc')?></label>
		<input type="text" id="<?php echo $this->get_field_id('no_events_message')?>" class="widefat" name="<?php echo $this->get_field_name('no_events_message')?>" value="<?php echo $no_events_message?>" />
	</div>
-->
	<div class="" style="margin-top:10px;">
		<?php _e('Specific date (Y-m-d)','rhc')?>
		<input type="text" class="widefat rhc-date-picker" value="<?php echo $specific_date ?>" id="<?php echo $this->get_field_id('specific_date')?>" name="<?php echo $this->get_field_name('specific_date')?>" />
	</div>	

	<div class="" style="margin-top:10px;">
		<?php _e('Specific date End (Y-m-d)','rhc')?>
		<input type="text" class="widefat rhc-date-picker" value="<?php echo $specific_date_end ?>" id="<?php echo $this->get_field_id('specific_date_end')?>" name="<?php echo $this->get_field_name('specific_date_end')?>" />
	</div>	
	
	<div class="" style="margin-top:10px;">
		<input type="checkbox" id="<?php echo $this->get_field_id('auto')?>" name="<?php echo $this->get_field_name('auto')?>" <?php echo $auto==1?'checked="checked"':''?> value=1 />&nbsp;*<?php _e('Only related events.','rhc')?>
	</div>
	<p style="margin-top:3px;">*<?php _e('If the loaded page is a calendar, venue or organizer (taxonomy), only show events from the same taxonomy.','rhc')?></p>

	<div class="" style="margin-top:10px;">
		<?php _e('Only premiere events.','rhc')?>
		<select id="<?php echo $this->get_field_id('premiere')?>" name="<?php echo $this->get_field_name('premiere')?>" class="widefat">
			<option value="" <?php echo $premiere==''?'selected="selected"':''?> ><?php _e('disabled','rhc')?></option>
			<option value="1" <?php echo $premiere=='1'?'selected="selected"':''?> ><?php _e('Premiere date','rhc')?></option>
			<option value="2" <?php echo $premiere=='2'?'selected="selected"':''?> ><?php _e('First date in range','rhc')?></option>
		</select>	
	</div>	
	<p style="margin-top:3px;">*<?php _e('Premiere:  The first event in a series.','rhc')?></p>
	<p style="margin-top:3px;">*<?php _e('First date in range:  Show only the first repetition of an event in the requested range','rhc')?></p>

	<div class="" style="margin-top:10px;">
		<?php _e('Calendar url(optional)','rhc')?>
		<input type="text" class="widefat" value="<?php echo $calendar_url ?>" id="<?php echo $this->get_field_id('calendar_url')?>" name="<?php echo $this->get_field_name('calendar_url')?>" />
	</div>
	<?php do_action('rhc_widget_upcoming_events_form',$this,$instance)?>
</div>
<script>jQuery(document).ready(function($) {init_datepicker();});</script>
<?php
		add_action('admin_footer',array(&$this,'admin_footer'));
		add_action('customize_controls_print_footer_scripts',array(&$this,'admin_footer'));
	}
	
	function form_author_name( $author_name='' ){
		global $rhc_plugin;
?>
	<div class="" style="margin-top:10px;">
		<?php _e('Author','rhc')?>
		<?php if( '1' == $rhc_plugin->get_option( 'enable_uew_author_dropdown', '1',true ) ):?>
			<select class="widefat" id="<?php echo $this->get_field_id('author_name')?>" name="<?php echo $this->get_field_name('author_name')?>">
				<option <?php echo $author_name==''?'selected="selected"':''?> value=""><?php _e('Any user','rhc')?></option>
				<option <?php echo $author_name=='current_user'?'selected="selected"':''?> value="current_user"><?php _e('Logged user','rhc')?></option>
			<?php if( $users=$this->get_users() ):?>
				<?php foreach( $users as $u):?>
				<option <?php echo $author_name==$u->data->user_login?'selected="selected"':''?> value="<?php echo $u->data->user_login?>"><?php echo $u->data->user_login?></option>
				<?php endforeach;?>
			<?php endif; ?>	
			</select>
		<?php else: ?>
			<input type="text" class="widefat" value="<?php echo esc_attr($author_name) ?>" id="<?php echo $this->get_field_id('author_name')?>" name="<?php echo $this->get_field_name('author_name')?>" />
		<?php endif; ?>
	</div>
<?php
	}
	
	function get_users(){
		$users = get_users( array() );
		return is_array( $users ) && count( $users ) > 0 ? $users : false ;
	}
	
	function admin_footer(){
		wp_register_style( 'rhc-jquery-ui', RHC_URL.'css/jquery-ui/righthere-calendar/jquery-ui-1.8.14.custom.css', array(),'1.8.14');
		wp_print_styles('rhc-jquery-ui');
		wp_print_scripts('jquery-ui-datepicker');	
?>
<script>
function init_datepicker(){
	jQuery(document).ready(function($) {
		$('BODY').addClass('rhcalendar').addClass('righthere-calendar');
	    $('.rhc-date-picker').datepicker({
	        dateFormat : 'yy-mm-dd'
	    });
	});
}
</script>
<?php 	
	}
	
	function taxonomy_dropdown($taxonomy,$id,$name,$posted_value){
		$terms = get_terms($taxonomy);
?>
<select id="<?php echo $id?>" name="<?php echo $name?>" class="widefat upcoming-<?php echo $taxonomy?>">
<?php if(is_array($terms)&&count($terms)>0):?>
<option value=""><?php _e('--any--','rhc')?></option>
<?php foreach($terms as $t):?>
<option value="<?php echo $t->term_id?>" <?php echo $posted_value==$t->term_id?'selected="selected"':''?> ><?php echo $t->name?></option>
<?php endforeach;?>
<?php else: ?>
<option value=""><?php _e('--no options--','rhc')?></option>
<?php endif;?>
</select>
<?php		
	}
}
?>