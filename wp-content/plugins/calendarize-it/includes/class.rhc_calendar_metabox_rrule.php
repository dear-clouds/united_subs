<?php

class rhc_calendar_metabox {
	var $uid=0;
	var $post_type;
	var $debug=false;
	function __construct($post_type='rhcevents',$debug=false){
		global $rhc_plugin;
		$this->debug = $debug;
		if(!class_exists('post_meta_boxes'))
			require_once('class.post_meta_boxes.php');		
		$this->post_type = $post_type;
		$this->metabox_meta_fields = array(
			"fc_allday","fc_start","fc_start_time","fc_end","fc_end_time","fc_interval","fc_rrule",
			"fc_end_interval","fc_dow_except","fc_color","fc_text_color","fc_click_link",
			"fc_click_target","fc_exdate","fc_rdate","fc_event_map",
			"enable_featuredimage", "enable_postinfo","enable_postinfo_image","enable_venuebox","enable_venuebox_gmap"
		);
		$this->fc_intervals = $rhc_plugin->get_rrule_freq();
		$this->post_meta_boxes = new post_meta_boxes(array(
			'post_type'	=>$post_type,
			'options'	=> apply_filters( 'rhc_calendar_metabox_options', $this->metaboxes() ),
			'styles'	=>array('post-meta-boxes','rhc-admin','rhc-jquery-ui','calendarize-metabox','farbtastic','rhc-options'),
			'scripts'	=>array('calendarize','rhc-admin','calendarize-metabox','farbtastic','pop'),
			'metabox_meta_fields' =>  'calendar_metabox_meta_fields',
			'pluginpath'=>RHC_PATH
		));
		$this->post_meta_boxes->save_fields = apply_filters( 'rhc_calendar_metabox_save_fields', $this->metabox_meta_fields );
		add_action('wp_ajax_calendarize_'.$post_type, array(&$this,'ajax_calendarize'));
		//----
		add_action('save_post', array(&$this,'save_post'), $rhc_plugin->get_save_post_priority(2), 2 );//2 units above post_meta_boxes save_post for an effective 12 at normal priority set in options. high(5), max(3)
		//----
		add_filter('generate_calendarize_meta', array(&$this,'generate_calendarize_meta'), 10, 2);
		add_filter('generate_calendarize_meta', array(&$this,'repair_calendarize_meta'), 20, 2);
		add_action( 'delete_post', array(&$this,'delete_post'), 10, 1 );
		add_action( 'wp_trash_post', array(&$this,'delete_post'), 10, 1 );
		add_action( 'untrash_post', array(&$this,'delete_post'), 10, 1 );
	}
	
	function save_post($post_id, $post=null){
		if(isset($_REQUEST['action']) && $_REQUEST['action']=='autosave')return;//leave autosave unhandled. some problems from delete_post_meta where the main post was getting the meta data deleted.
		//if(  $this->post_type != $post->post_type ) return $post_id;
		
		if(is_object($post) && property_exists($post, 'post_type') && $this->post_type!=$post->post_type){
			return $post_id;
		}
		
		if ( !wp_verify_nonce( @$_POST[$this->post_type.'-nonce'], $this->post_type.'-nonce' )) {
			$this->handle_delete_events_cache();//quick edit dont get past this point.
			return $post_id;
		}
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
		// Check permissions
     
		//add_post_meta
		if ( $this->post_type == $_POST['post_type'] ) {
		  if ( !current_user_can( 'edit_post', $post_id ) ){
		  	return $post_id;
		  }    
		} else {
		    return $post_id;
		}
		//------------------------------

		return apply_filters('generate_calendarize_meta', $post_id, $post);
	}

	function delete_post($post_id){
		global $post_type; 
		if(isset($post_type) && $this->post_type==$post_type){
			$this->handle_delete_events_cache();
		}
	}
	
	function handle_delete_events_cache(){
		if(!function_exists('rhc_handle_delete_events_cache')){
			require_once RHC_PATH.'includes/function.rhc_handle_delete_events_cache.php';
		}
		rhc_handle_delete_events_cache();
	}
	
	function repair_calendarize_meta($post_id, $post=null){
		//some unknown condition is generating an rrule with NaN in the until portion that breaks both frontend
		//and backend calendar views.
		//this fix will prevent the invalid data from making it imposible to fix, however it will give the appearance that the Until field is not saving.
		$fc_rrule = get_post_meta($post_id,'fc_rrule',true);
		$fc_rrule = str_replace( ';UNTIL=NaNNaNNaN','', $fc_rrule );
		update_post_meta( $post_id, 'fc_rrule', $fc_rrule );
		
		return $post_id;
	}
	
	function generate_calendarize_meta($post_id, $post=null){
		global $rhc_plugin,$wpdb;		
		$this->handle_delete_events_cache();

		$fc_range_start = '';
		$fc_range_end = '';
		
		$is_allday = '1' == get_post_meta( $post_id, 'fc_allday', true ) ? true : false ;
		if( $is_allday ){
			delete_post_meta($post_id, 'fc_start_time');
			delete_post_meta($post_id, 'fc_end_time');
		}
		
		$date = get_post_meta($post_id,'fc_start',true);
		if(trim($date)!=''){
			global $wpdb;
			$time = get_post_meta($post_id,'fc_start_time',true);		
			$time = $is_allday || trim($time)==''?'12:00 am':$time;
			$time = $this->parseTime($time);
			$sql = "SELECT COALESCE((SELECT DATE_FORMAT(STR_TO_DATE('$date $time','%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s')),'')";
			$datetime = $wpdb->get_var($sql,0,0);
			if(trim($datetime)!=''){
				$fc_range_start = $datetime;
				update_post_meta($post_id,'fc_start_datetime',$datetime);
			}
		}
		//--
		$date = get_post_meta($post_id,'fc_end',true);
		if(''==$date){
			$date = get_post_meta($post_id,'fc_start',true);
			if(''!=$date){
				update_post_meta($post_id,'fc_end',$date);
			}
		}
		//--
		if(trim($date)!=''){
			global $wpdb;
			$time = get_post_meta($post_id,'fc_end_time',true);		
			$time = $is_allday || trim($time)==''?'12:00 am':$time;
			$time = $this->parseTime($time);
			$sql = "SELECT COALESCE((SELECT DATE_FORMAT(STR_TO_DATE('$date $time','%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s')),'')";
			$datetime = $wpdb->get_var($sql,0,0);
			if(trim($datetime)!=''){
				$fc_range_end = $datetime;
				update_post_meta($post_id,'fc_end_datetime',$datetime);
			}
		}	
		
		$duration = 0;
		if(!empty($fc_range_start) && !empty($fc_range_end)){
			$duration = intval( strtotime($fc_range_end) - strtotime($fc_range_start) );
		}
		//-- save repeat individually for friendly query
		delete_post_meta($post_id, 'fc_rdatetime');
		delete_post_meta($post_id, 'fc_range_start');
		delete_post_meta($post_id, 'fc_range_end');

		$fc_rdate = get_post_meta($post_id,'fc_rdate',true);
		if(trim($fc_rdate)!=''){
			$array_of_repeat_dates = explode(',',$fc_rdate);
			foreach($array_of_repeat_dates as $rdate){
				$sql = "SELECT COALESCE((SELECT DATE_FORMAT(STR_TO_DATE('$rdate','%Y%m%dT%H%i%s'), '%Y-%m-%d %H:%i:%s')),'')";
				$datetime = $wpdb->get_var($sql,0,0);
				if(trim($datetime)!=''){
					//NOTE: In the DB, there must be multiple fc_rdatetime records, 1 per rdate.
					add_post_meta($post_id,'fc_rdatetime',$datetime);
					//----
					if( !empty($fc_range_start) ){
						if( strtotime($datetime) < strtotime($fc_range_start) ){
							$fc_range_start = $datetime;// handle an rdate that is before the start date; not standard, but people wants it.
						}
					}
					
					$end = strtotime($datetime)+$duration; 
					if(  empty($fc_range_end) || $end > strtotime($fc_range_end) ){
						$fc_range_end = date('Y-m-d H:i:s',$end);
					}
				}				
			}
		
		}	
		
		//--- some cleanup
		if(''==get_post_meta($post_id,'fc_interval',true)){
//			delete_post_meta($post_id,'fc_end_interval');//clear end interval.
		}
		
		//--- extend range end on/if recur end interval 
		$date = get_post_meta($post_id,'fc_end_interval',true);
		if( !empty($date) && !empty($fc_range_end) ){
		
			$end_datetime = get_post_meta($post_id,'fc_end_datetime',true);
			if( !empty($end_datetime) && $end_time=strtotime($end_datetime)){
				$time = date('H:i:s',$end_time);
			}else{
				$time = '23:59:59';
			}
		
			$sql = "SELECT COALESCE((SELECT DATE_FORMAT(STR_TO_DATE('$date $time','%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s')),'')";
			$datetime = $wpdb->get_var($sql,0,0);
			if(trim($datetime)!=''){
				if( strtotime($datetime) > strtotime($fc_range_end) ){
					$fc_range_end = $datetime;// handle an rdate that is before the start date; not standard, but people wants it.
				}
			}		
		}		
		
		if( !empty($fc_range_start) ){
			update_post_meta($post_id,'fc_range_start',$fc_range_start);
		}	
		
		if( !empty($fc_range_end) ){
			update_post_meta($post_id,'fc_range_end',$fc_range_end);		
		}		
		
		return $post_id;	
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
	
	function ajax_calendarize(){
		$post_ID = intval($_POST['post_ID']);
		if('page' == $this->post_type) {
		    if (!current_user_can('edit_page', $post_ID)) {
		        die(json_encode(array('R'=>'ERR','MSG'=>__('No access','rhc') )));
		    }
		} elseif (!current_user_can('edit_post', $post_ID)) {
		    die(json_encode(array('R'=>'ERR','MSG'=>__('No access','rhc') )));
		}		
		
		$data = isset($_POST['data'])&&count($_POST['data'])>0?$_POST['data']:false;
		if(false===$data){
			die(json_encode(array('R'=>'ERR','MSG'=>__('Missing parameter.','rhc') )));
		}
		
		$allempty = true;
		foreach($data as $i => $arr){
			$arr = is_array($arr)?$arr:explode(',',$arr,2);
			if(!in_array($arr[0], $this->metabox_meta_fields ))continue;
			$var = $arr[0];
			$$var = trim($arr[1]);
			if(''!=trim($$var))$allempty=false;
		}
		
		if($allempty)
			return die(json_encode(array('R'=> 'OK','MSG'=> '','EVENTS' 	=> array())));		
		
		$fc_allday = ''==trim($fc_allday)?1:$fc_allday;
		$fc_start = ''==trim($fc_start)?date('Y-m-d'):$fc_start;
		$fc_start_time = ''==trim($fc_start_time)?'12:00 am':$fc_start_time;
		$fc_end = ''==trim($fc_end)?$fc_start:$fc_end;
		$fc_end_time = ''==trim($fc_end_time)?$fc_start_time:$fc_end_time;
	
		$fc_start_time 	= $this->parseTime($fc_start_time);
		$fc_end_time	= $this->parseTime($fc_end_time);	

		$events = array();
		
		$event = array(
				'id'	=> $post_ID,
				'title' => get_the_title($post_ID),
				'start' => date('Y-m-d H:i:s',strtotime(trim($fc_start.' '.$fc_start_time))),
				'end' 	=> date('Y-m-d H:i:s',strtotime(trim( $fc_end.' '.$fc_end_time ))),
				'allDay'=> $fc_allday==1?true:false
			);	
			
		foreach($this->metabox_meta_fields as $field){
			$event[$field] = $$field;
		}
		
		foreach(array('fc_color'=>'color','fc_text_color'=>'textColor') as $field => $event_field){
			if(!in_array( trim($event[$field]), array('','#') )){
				$event[$event_field]=$event[$field];
			}		
		}
		
		if(!in_array( trim($event['fc_color']), array('','#') )){
			$event['color']=$event['fc_color'];
		}
		
		if(""!=trim($fc_interval) && array_key_exists($fc_interval,$this->fc_intervals) ){
//--will do repeat on client
		}
		
		if(count($events)==0){
			$events[]=(object)$event;
		}
	
		$r = array(
			'R'			=> 'OK',
			'MSG'		=> '',
			'EVENTS' 	=> $events
		);
	
		return die(json_encode($r));
	}
	
	
	function _ajax_calendarize(){
		global $rhc_plugin;
		// check permissions
		$post_ID = intval($_POST['post_ID']);
		if('page' == $this->post_type) {
		    if (!current_user_can('edit_page', $post_ID)) {
		        die(json_encode(array('R'=>'ERR','MSG'=>__('No access','rhc') )));
		    }
		} elseif (!current_user_can('edit_post', $post_ID)) {
		    die(json_encode(array('R'=>'ERR','MSG'=>__('No access','rhc') )));
		}		
		
		$data = isset($_POST['data'])&&count($_POST['data'])>0?$_POST['data']:false;
		if(false===$data){
			die(json_encode(array('R'=>'ERR','MSG'=>__('Missing parameter.','rhc') )));
		}
		
		$allempty = true;
		foreach($data as $i => $arr){
			$arr = is_array($arr)?$arr:explode(',',$arr);
			if(!in_array($arr[0], $this->metabox_meta_fields ))continue;
			$var = $arr[0];
			$$var = trim($arr[1]);
			if(''!=trim($$var))$allempty=false;
		}
		
		if($allempty)
			return die(json_encode(array('R'=> 'OK','MSG'=> '','EVENTS' 	=> array())));	
						
		$events = $rhc_plugin->calendar_ajax->_get_calendar_items($post_ID);
		return die(json_encode(array('R'=> 'OK','MSG'=> '','EVENTS' 	=> $events)));	
	}
	
	
	function metaboxes($t=array()){
		global $rhc_plugin;
		
		$i = count($t);
		//------------------------------
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-calendarize'; 
		$t[$i]->label 		= __('Calendarize','rhc');
		$t[$i]->right_label	= __('Calendarize','rhc');
		$t[$i]->page_title	= __('Calendarize','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'=>'calendarize',
				'type'=>'callback',
				'callback'=> array(&$this,'fullcalendar')
			),
			(object)array(
				'type'=>'clear'
			)
		);
		/*
		if(RHC_EVENTS!=$this->post_type){
			//return $t; 
			//the rest of the options are only specific to rhc events post type.
		}
		*/
		//------------------------------
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-layout-options'; 
		$t[$i]->label 		= __('Layout Options','rhc');
		$t[$i]->right_label	= __('Layout Options','rhc');
		$t[$i]->page_title	= __('Layout Options','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->context = 'side';
		$t[$i]->priority = 'default';
		$t[$i]->options = array(
			(object)array(
				'id'			=> 'enable_featuredimage',
				'type'			=> 'onoff',
				'default'		=> $rhc_plugin->get_option('enable_featuredimage','1',true),
				'label'			=>  __('Event Page Top Image','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			),		
			(object)array(
				'id'			=> 'enable_postinfo',
				'type'			=> 'onoff',
				'default'		=> $rhc_plugin->get_option('enable_postinfo','1',true),
				'label'			=>  __('Event Details Box','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			),	
			(object)array(
				'id'			=> 'enable_postinfo_image',
				'type'			=> 'onoff',
				'default'		=> $rhc_plugin->get_option('enable_postinfo_image','1',true),
				'label'			=>  __('Event Details Box Image','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			),
			(object)array(
				'id'			=> 'enable_venuebox',
				'type'			=> 'onoff',
				'default'		=> $rhc_plugin->get_option('enable_venuebox','1',true),
				'label'			=>  __('Venue Details Box','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			),
			(object)array(
				'id'			=> 'enable_venuebox_gmap',
				'type'			=> 'onoff',
				'default'		=> $rhc_plugin->get_option('enable_venuebox_gmap','1',true),
				'label'			=>  __('Venue Details Box Map','rhc'),
				'save_option'	=> true,
				'load_option'	=> true
			),
			(object)array(
				'type'=>'clear'
			)
		);		
		//-----
		return $t;
	}	

	function fullcalendar($tab,$i,$o){
		global $post;
		if($this->debug){
			echo sprintf('fc_range_start: %s fc_range_end: %s |',
				get_post_meta($post->ID,'fc_range_start',true),
				get_post_meta($post->ID,'fc_range_end',true)
			);
			return $this->fullcalendar_debug($tab,$i,$o);
		}
			
		//-----------------
		foreach($this->metabox_meta_fields as $meta_field){
		//	echo sprintf('%s <input id="%s" type="text" class="calendarize_meta_data" name="%s" value="%s" />',
		//		$meta_field,
			if( false!==strpos($meta_field,'enable_') )continue;
			echo sprintf('<input id="%s" type="hidden" class="calendarize_meta_data" name="%s" value="%s" />',
				$meta_field,
				$meta_field,
				apply_filters( 'bop_meta_field', get_post_meta( $post->ID, $meta_field, true ), $meta_field )
			);
		//	echo "<br />";
		}	
?>
<div id="calendarize" class="calendarize"></div>
<?php		
		add_action('admin_footer',array(&$this,'admin_footer'));
	}

	function fullcalendar_debug($tab,$i,$o){
		global $post;
		foreach($this->metabox_meta_fields as $meta_field){
			if( false!==strpos($meta_field,'enable_') )continue;
			echo sprintf('%s <input id="%s" type="text" class="calendarize_meta_data" name="%s" value="%s" />',
				$meta_field,
		//	echo sprintf('<input id="%s" type="hidden" class="calendarize_meta_data" name="%s" value="%s" />',
				$meta_field,
				$meta_field,
				apply_filters( 'bop_meta_field', get_post_meta( $post->ID, $meta_field, true ), $meta_field )
			);
		//	echo "<br />";
		}	
		
		global $wpdb;
		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}rhc_events WHERE post_id=".$post->ID;
		$count = $wpdb->get_var( $sql, 0, 0 );
		echo " rhc_events_count:".$count;
?>
<div id="calendarize" class="calendarize"></div>
<?php		
		add_action('admin_footer',array(&$this,'admin_footer'));
	}
	
	function admin_footer(){
		global $post;	
		$post_type = get_post_type_object( get_post_type($post) );
	
?>

	<div class="fc-dialog metabox-holder">
		<input type="hidden" class="clicked_start_date" name="clicked_start_date" value="" />
		<ul style="display:none;">
			<li id="prompt-remove"><?php _e('This will remove all calendarize date and recurring date settings.','rhc')?></li>
			<li id="prompt-overwrite"><?php _e('This will overwrite all calendarize date and recurring date settings.','rhc')?></li>
			<li id="prompt-allday"><?php _e('This is an all day event.','rhc')?></li>
		</ul>
		<div class="fc-arrow-holder">
			<div class="fc-arrow"></div>
			<div class="fc-arrow-border"></div>
		</div>
		<div id="fc-content-tabs" class="fc-widget postbox taxonomydiv">
			<h3 class="fc-hndle"><?php echo sprintf(__('Calendarize %s','rhc'),$post_type->label)?></h3>

			<div class="inside  main-content">
				<div>&nbsp;</div>

				<div class="fc-dialog-content">
					<ul class="category-tabs wp-tab-bar">
						<li class="tabs"><a class="first-tab" rel=".tab-date" data-tab_group="main">Date</a></li>
						<li class="tabs"><a rel=".tab-color" data-tab_group="main">Color</a></li>
						<li class="tabs"><a rel=".tab-calendar" data-tab_group="main">Calendar</a></li>
						<li class="tabs tabs-rdate"><a rel=".tab-rdate" data-tab_group="main">Repeat</a></li>
						<li class="tabs tabs-exclude"><a rel=".tab-exdate" data-tab_group="main">Exclude</a></li>
					</ul>
					<div class="tab-date tabs-panel tab-open" data-tab_group="main">
						<div class="fc-form-field">
							<label for="_fc_allday" class="left-label"><?php _e('All-day','rhc')?></label>
							<input type="checkbox" class="fc_allday fc_input" name="fc_allday" value="1" />
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<div id="fc_start_fullcalendar_holder" class="fc_start_fullcalendar_holder postbox close-on-click" rel="fc_start">
								<div class="fc_start_fullcalendar"></div>
							</div>
							<label for="_fc_start" class="left-label"><?php _e('Start','rhc')?></label>
							<div class="fc-date-time">
								<input type="text" class="fc_start fc_input" name="fc_start" value="" /><span class="fc-time-label"><?php _e('at','rhc')?></span>
								<input type="text" class="fc_start_time fc_input" name="fc_start_time" value="" placeholder="<?php _e('any time','rhc')?>" />					
							</div>
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<div id="fc_end_fullcalendar_holder" class="fc_end_fullcalendar_holder fc_start_fullcalendar_holder postbox close-on-click" rel="fc_end">
								<div class="fc_start_fullcalendar"></div>
							</div>
							<label for="_fc_end" class="left-label"><?php _e('End','rhc')?></label>
							<div class="fc-date-time">
								<input type="text" class="fc_end fc_input" name="fc_end" value="" /><span class="fc-time-label"><?php _e('at','rhc')?></span>
								<input type="text" class="fc_end_time fc_input" name="fc_end_time" value="" placeholder="<?php _e('any time','rhc')?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<label for="_fc_repeat" class="left-label"><?php _e('Repeat','rhc')?></label>
							<select id='dg_fc_interval' name="fc_interval" class="fc_input fc_interval">
							<?php foreach($this->fc_intervals as $value => $label):?>
								<option value="<?php echo $value?>"><?php echo $label?></option>
							<?php endforeach;?>
								<option value="rrule"><?php _e('More options','rhc')?></option>
							</select>
							<div class="clear"></div>
						</div>
						
						<?php $this->rrule_section();?>
						
						<div class="end-repeat-section">
							<div class="fc-form-field">
								<div id="fc_end_interval_fullcalendar_holder" class="fc_start_fullcalendar_holder fc_end_interval_fullcalendar_holder postbox close-on-click" rel="fc_end_interval">
									<div class="fc_start_fullcalendar"></div>
								</div>
								<label for="_fc_end_interval" class="left-label"><?php _e('End repeat','rhc')?></label>
								<select id="rrule_repeat_end_type" name="rrule_repeat_end_type" class="rrule_inp_section">
									<option value="until"><?php _e('by date','rhc')?></option>
									<option value="count"><?php _e('by count','rhc')?></option>
									<option value="never"><?php _e('never','rhc')?></option>
								</select>
								<div class="clear"></div>
							</div>
							
							<div class="fc-form-field repeat_type repeat_type_until">
								<div id="fc_end_interval_fullcalendar_holder" class="fc_start_fullcalendar_holder rrule_inp_section fc_end_interval_fullcalendar_holder postbox close-on-click" rel="fc_end_interval">
									<div class="fc_start_fullcalendar"></div>
								</div>
								<label for="_fc_end_interval" class="left-label"><?php _e('End date','rhc')?></label>
								<div class="fc-date-time">
									<input id="rrule_until" type="text" class="fc_end_interval fc_input" name="fc_end_interval" value="" />
								</div>
								<div class="clear"></div>
							</div>
							
							<div class="fc-form-field repeat_type repeat_type_count">
								<div id="fc_end_interval_fullcalendar_holder" class="fc_start_fullcalendar_holder rrule_inp_section fc_end_interval_fullcalendar_holder postbox close-on-click" rel="fc_end_interval">
									<div class="fc_start_fullcalendar"></div>
								</div>
								<label for="_fc_end_interval" class="left-label"><?php _e('End count','rhc')?></label>
								<div class="fc-end-count">
									<input id="fc_end_count" type="text" class="fc_end_count fc_input" name="fc_end_count" value="" />
								</div>
								<div class="clear"></div>
							</div>
						</div>
					</div>			
					<div class="tab-color tabs-panel" data-tab_group="main">
						<div class="fc-form-field">
							<label for="_fc_color" class="left-label"><?php _e('Color','rhc')?></label>
							
							<div class="farbtastic-holder">
								<input id="frm_fc_color" type='text' class='fc_color fc_input fc_color_input' name='fc_color' value='<?Php echo get_post_meta($post->ID,'fc_color',true)?>' /><a title="<?PHP _e('Choose color','rhc')?>" class="farbtastic-choosecolor" href="javascript:void(0);" rel="<?PHP _e('Close','rhc')?>"><?PHP _e('Show','rhc')?></a>
								<div id="farbtastic_fc_color" rel="#frm_fc_color" class="pop-farbtastic"></div>
							</div>
							<div class="pop-float-separator">&nbsp;</div>
							
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<label for="_fc_text_color" class="left-label"><?php _e('Text color','rhc')?></label>
							
							<div class="farbtastic-holder">
								<input id="frm_fc_text_color" type='text' class='fc_text_color fc_input fc_color_input' name='fc_text_color' value='<?Php echo get_post_meta($post->ID,'fc_text_color',true)?>' /><a title="<?PHP _e('Choose color','rhc')?>" class="farbtastic-choosecolor" href="javascript:void(0);" rel="<?PHP _e('Close','rhc')?>"><?PHP _e('Show','rhc')?></a>
								<div id="farbtastic_fc_text_color" rel="#frm_fc_text_color" class="pop-farbtastic"></div>
							</div>
							<div class="pop-float-separator">&nbsp;</div>							
							
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>		
					<div class="tab-calendar tabs-panel" data-tab_group="main">
						<div class="fc-form-field">
							<label for="_fc_click_link" class="left-label"><?php _e('Click links to','rhc')?></label>
							<div class="fc-click-link">
								<select class="fc_click_link fc_input" name="fc_click_link">
									<option value="view"><?php _e('Tooltip','rhc')?></option>
									<option value="page"><?php _e('Page','rhc')?></option>
									<option value="none"><?php _e('No link','rhc')?></option>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="fc-form-field fc-click-target-holder">
							<label for="_fc_click_target" class="left-label"><?php _e('Target','rhc')?></label>
							<div class="fc-click-target">
								<select class="fc_click_target fc_input" name="fc_click_target">
									<option value="_blank"><?php _e('_blank new window or tab','rhc')?></option>
									<option value="_self"><?php _e('_self same window or tab','rhc')?></option>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>						
					<div class="tab-rdate tabs-panel" data-tab_group="main">
						<p><?php _e('In addition to recurring rules you can set arbitrary repeat dates.','rhc')?></p>
						<p><?php _e('After adding the initial event simply click on any date in order to add the arbitrary repeat date.','rhc')?></p>
					
						<div class="fc-form-field">
							<label for="_fc_rdate" class="fullwidth-label"><?php _e('Repeat dates','rhc')?></label>
							<p class="fc-no-rdate"><?php _e("No repeat dates set.","rhc")?></p>
							<div class="fc-repeat-dates"></div>
							<div class="clear"></div>
						</div>									
					</div>		
					<div class="tab-exdate tabs-panel" data-tab_group="main">
						<p><?php _e('Excluded dates are only applicable when using recurring events.','rhc')?></p>
						<div class="fc-form-field">
							<label for="_fc_exdate" class="fullwidth-label"><?php _e('Excluded dates','rhc')?></label>
							<p class="fc-no-excluded"><?php _e("No excluded dates selected.  After setting up recurring events, click on a calendar event, then on the dialog press the exclude button to add the clicked date to the excluded dates list.","rhc")?></p>
							<div class="fc-excluded-dates"></div>
							<div class="clear"></div>
						</div>									
					</div>					
				</div>	
			</div>
			<div class="fc-dialog-controls main-content">
				<input type="button" class="button-primary fc-dg-ok" name="fc-dg-ok" value="<?php _e('Accept','rhc')?>" />
				<input type="button" class="button-secondary fc-dg-exclude" name="fc-dg-exclude" title="<?php _e('Exclude this date.  Only applicable with recurring events','rhc')?>" value="<?php _e('Exclude','rhc')?>" />
				<input type="button" class="button-secondary fc-dg-cancel" name="fc-dg-cancel" value="<?php _e('Cancel','rhc')?>" />
				<input type="button" class="button-secondary fc-dg-remove" name="fc-dg-remove" value="<?php _e('Reset settings','rhc')?>" />
				<div class="fc-status">
					<img src="<?php echo admin_url('/images/wpspin_light.gif')?>" alt="" />
				</div>
				<div class="clear"></div>
			</div>		
			
			<div class="inside secondary-content">			
				<p><?php _e('In addition to recurring rules you can set arbitrary repeat dates.  Click accept to save an arbitrary repeat date.','rhc')?></p>
				<p class="not-allday-input"><?php _e('The current calendarize settings require that you specify the repeat date time.','rhc')?></p>
					<div class="secondary-content-fields">
						<div class="fc-form-field not-allday-input">
							<label for="_fc_rdate" class="left-label"><?php _e('Repeat time','rhc')?></label>
							<div class="fc-date-time">
								<input type="hidden" class="fc-selected-date-inp" value="" />
								<span class="fc-selected-date"></span><span class="fc-time-label"><?php _e('at','rhc')?></span>
								<input type="text" class="fc_rdate_time fc_input" name="fc_rdate_time" value="" placeholder="<?php _e('any time','rhc')?>" />					
							</div>
							<div class="clear"></div>
						</div>
					</div>	
			</div>
			<div class="fc-dialog-controls secondary-content">
				<input type="button" class="button-primary fc-dg-repeat" name="fc-dg-repeat" value="<?php _e('Accept','rhc')?>" />
				<input type="button" class="button-primary fc-dg-repeat-remove" name="fc-dg-repeat-remove" value="<?php _e('Remove','rhc')?>" />
				<input type="button" class="button-secondary fc-dg-cancel" name="fc-dg-cancel" value="<?php _e('Cancel','rhc')?>" />
				<input type="button" class="button-secondary fc-dg-main" name="fc-dg-main" value="<?php _e('Main settings','rhc')?>" />
				<div class="clear"></div>
			</div>	
			
			
			<div class="clear"></div>
		</div>
	</div>

<?php	
		$this->_calendar_options();
	}	//admin_footer
	
	function rrule_section(){	
		global $rhc_plugin;
		$byvals = array(
			array(
				'label'		=> __('months','rhc'),
				'name'		=> 'rrule_bymonth[]',
				'options'	=> array(
					array(
						1 => __('jan','rhc'),
						2 => __('feb','rhc'),
						3 => __('mar','rhc'),
						4 => __('apr','rhc'),
						5 => __('may','rhc'),
						6 => __('jun','rhc')
					),
					array(
						7 => __('jul','rhc'),
						8 => __('aug','rhc'),
						9 => __('sep','rhc'),
						10 => __('oct','rhc'),
						11 => __('nov','rhc'),
						12 => __('dec','rhc')
					)
				),
				'class'		=> 'rrule_bymonth',
				'visible_class'=> ' vis_YEARLY vis_MONTHLY vis_WEEKLY vis_DAILY vis_HOURLY vis_MINUTELY'
			),
			array(
				'label'		=> __('week of year','rhc'),
				'name'		=> 'rrule_byweekno[]',
				'options'	=> array(
					$this->_fill_numbers_array(1,8),
					$this->_fill_numbers_array(8,15),
					$this->_fill_numbers_array(15,22),
					$this->_fill_numbers_array(22,29),
					$this->_fill_numbers_array(29,36),
					$this->_fill_numbers_array(36,43),
					$this->_fill_numbers_array(43,50),
					$this->_fill_numbers_array(50,54)
				),
				'class'		=> 'rrule_byweekno',
				'visible_class'=> ' vis_YEARLY'
			),
			array(
				'label'		=> __('days of the month','rhc'),
				'name'		=> 'rrule_bymonthday[]',
				'options'	=> array(
					$this->_fill_numbers_array(1,8),
					$this->_fill_numbers_array(8,15),
					$this->_fill_numbers_array(15,22),
					$this->_fill_numbers_array(22,29),
					$this->_fill_numbers_array(29,32)
				),
				'class'		=> 'rrule_bymonthday',
				'visible_class'=> ' vis_YEARLY vis_MONTHLY'
			),
			array(
				'label'		=> __('days of the week','rhc'),
				'visible_class'=> ' vis_YEARLY vis_MONTHLY vis_WEEKLY'
			),
			array(
				'name'		=> 'rrule_bysetpos[]',
				'options'	=> array(
					array(
						'1'		=> __('1st','rhc'),
						'2'		=> __('2nd','rhc'),
						'3'		=> __('3rd','rhc'),
						'4'		=> __('4th','rhc'),
						'5'		=> __('5th','rhc'),
						'-1'	=> __('last','rhc')		
					)
				),
				'class'		=> 'rrule_bysetpos',
				'visible_class'=> ' vis_MONTHLY'
			),			
			array(
				//'label'		=> __('days of the week','rhc'),
				'name'		=> 'rrule_bywkst[]',
				'options'	=> array(
					array(
						'SU'	=> __('sun','rhc'),
						'MO'	=> __('mon','rhc'),
						'TU'	=> __('tue','rhc'),
						'WE'	=> __('wed','rhc'),
						'TH'	=> __('thu','rhc'),
						'FR'	=> __('fri','rhc'),
						'SA'	=> __('sat','rhc')					
					)
				),
				'class'		=> 'rrule_bywkst',
				'visible_class'=> ' vis_YEARLY vis_MONTHLY vis_WEEKLY'
			),
			array(
				'name'		=> 'rrule_several_hours',
				'options'	=> array(
					array(
						'1'=>__('Several times','rhc')
					)
				),
				'class'		=> 'rrule_several_hours',
				'visible_class'=> ' vis_YEARLY vis_MONTHLY vis_WEEKLY vis_DAILY vis_HOURLY'
			),
			array(
				'label'		=> __('hours','rhc').'<a id="rhc-switch-12h-format" class="button-secondary">12h</a>',
				'name'		=> 'rrule_byhour[]',
				'options'	=> array(
					$this->_fill_numbers_array(0,6),
					$this->_fill_numbers_array(6,12),
					$this->_fill_numbers_array(12,18),
					$this->_fill_numbers_array(18,24)
				),
				'class'		=> 'rrule_byhour',
				'visible_class'=> ' '
			),
			array(
				'label'		=> __('minutes','rhc'),
				'name'		=> 'rrule_byminute[]',
				'options'	=> array(
					$this->_fill_numbers_array(0,60)
				),
				'class'		=> 'rrule_byminute',
				'visible_class'=> ' '
			)
		);

		$wkst_map = array(
					'0'	=> 'SU',
					'1'	=> 'MO',
					'2'	=> 'TU',
					'3'	=> 'WE',
					'4' => 'TH',
					'5'	=> 'FR',
					'6'	=> 'SA'
				);
		
		$rhc_firstday = $rhc_plugin->get_option( 'cal_firstday', '1', true );
		$wkst =$wkst_map[$rhc_firstday];
?>
<div class="rrule_section rhcalendar">
	<div>
		<?php _e('Repeat every','rhc') ?> 
		<input id="rrule_interval" class="rrule_interval rrule_inp_section" type="text" name="rrule_interval" value="1" /> 
		<select id="rrule_freq" class="rrule_freq rrule_inp_section" name="rrule_freq">
			<option value="YEARLY"><?php _e('year(s)','rhc')?></option>
			<option value="MONTHLY"><?php _e('month(s)','rhc')?></option>
			<option value="WEEKLY"><?php _e('week(s)','rhc')?></option>
			<option value="DAILY"><?php _e('day(s)','rhc')?></option>
			<option value="HOURLY"><?php _e('hour(s)','rhc')?></option>
			<option value="MINUTELY"><?php _e('minute(s)','rhc')?></option>
		</select>	
	</div>
	<div class="rhc-bysetpos">
		<ul class="category-tabs wp-tab-bar">
			<li class="tabs">
				<a class="first-tab" rel=".tab-rrule" data-tab_group="sub-bysetpos"><?php _e('Recurring rules','rhc');?></a>
			</li>
			<li class="tabs">
				<a rel=".tab-recurring" data-tab_group="sub-bysetpos"><?php _e('Dates','rhc');?></a>
			</li>
		</ul>
		<div class="tabs-panel tab-rrule  tab-open" data-tab_group="sub-bysetpos">
		<!-- tab1 start -->
		<div class="rrule_holder vis_YEARLY vis_WEEKLY">
			<span><?php _e('Week start','rhc');?></span>
			<select id="rrule_input_wkst" name="rr_wkst" class="rrue_input rrule_inp_section">
				<option value="SU" <?php echo "SU"==$wkst ? 'checked="checked"' : ''; ?>><?php _e('Sunday','rhc'); ?></option>
				<option value="MO" <?php echo "MO"==$wkst ? 'checked="checked"' : ''; ?> ><?php _e('Monday','rhc'); ?></option>
				<option value="TU" <?php echo "TU"==$wkst ? 'checked="checked"' : ''; ?>><?php _e('Tuesday','rhc'); ?></option>
				<option value="WE" <?php echo "WE"==$wkst ? 'checked="checked"' : ''; ?>><?php _e('Wednesday','rhc'); ?></option>
				<option value="TH" <?php echo "TH"==$wkst ? 'checked="checked"' : ''; ?>><?php _e('Thursday','rhc'); ?></option>
				<option value="FR" <?php echo "FR"==$wkst ? 'checked="checked"' : ''; ?>><?php _e('Friday','rhc'); ?></option>
				<option value="SA" <?php echo "SA"==$wkst ? 'checked="checked"' : ''; ?>><?php _e('Saturday','rhc'); ?></option>				
			</select>
		</div>
<?php foreach($byvals as $byval):  ?>
	<div class="<?php echo @$byval['class'];?>_holder rrule_holder <?php echo isset($byval['visible_class'])?$byval['visible_class']:'';?>">
		<?php if(isset($byval['label'])):?>
		<label class="<?php echo @$byval['class'];?>_label"><?php echo sprintf('On the following %s',$byval['label'])?></label>
		<?php endif; ?>
		<?php if(isset($byval['render'])):$method=$byval['render'];$this->$method($byval);else:?>
		<?php if(isset($byval['options'])): ?>
		<?php foreach($byval['options'] as $options): ?>
		<div class="<?php echo $byval['class'];?>_group">
			<?php foreach($options as $value => $label): $id=$this->uid++;?>
				<input id="rrule_input_<?php echo $id;?>" class="<?php echo $byval['class'];?>_inp rrule_input rrule_inp_section rrule_val_<?php echo $this->_class($value);?>" type="checkbox" name="<?php echo $byval['name'];?>" value="<?php echo $value?>" />
				<label for="rrule_input_<?php echo $id;?>"><?php echo $label?></label>
			<?php endforeach; ?>
		</div>
		<?php endforeach; ?>
		<?php endif;endif; ?>
	</div>
<?php endforeach; ?>
	<div class="rhc-clear"></div>

	<div class="rhc-clear" style="clear:both;"></div>		
		<!-- tab1 end -->
		</div>
		<div class="tabs-panel tab-recurring" data-tab_group="sub-bysetpos">
			<div class="recurring-dates-holder">

			</div>
		</div>
	</div>
</div>	
<?php		
	}
	
	function _switch_timte_format(){
	echo "TODO";
	}
	
	function _fill_numbers_array($start,$end){
		$arr=array();
		for($a=$start;$a<$end;$a++){
			$arr[$a]=$a;
		}
		return $arr;
	}	
	
	function _class($val){
		return $val;
	}	
	
	function _calendar_options(){
		global $rhc_plugin;
		$field_option_map = array(
			"firstday" 				=> "1",
			"button_text_today"		=> __('today','rhc'),
			"button_text_month"		=> __('month','rhc'),
			"button_text_day"		=> __('day','rhc'),
			"button_text_week"		=> __("week",'rhc'),
			"button_text_calendar"	=> __('Calendar','rhc'),
			"button_text_event"		=> __('event','rhc')
		);
	
		foreach($field_option_map as $field => $default){
			$option = 'cal_'.$field;
			$$field = $rhc_plugin->get_option($option,$default,true);
		}
	//--	
		$monthnames = __('January,February,March,April,May,June,July,August,September,October,November,December','rhc');
		$monthnamesshort = __('Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec','rhc');
		$daynames = __('Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday','rhc');
		$daynamesshort = __('Sun,Mon,Tue,Wed,Thu,Fri,Sat','rhc');
		$options = (object)array(	
			'firstDay'			=> $firstday,
			'monthNames' 		=> explode(',',$monthnames),
			'monthNamesShort' 	=> explode(',',$monthnamesshort),
			'dayNames' 			=> explode(',',$daynames),
			'dayNamesShort'		=> explode(',',$daynamesshort),		
			'buttonText'		=> (object)array(
				'today'	=> $button_text_today,
				'month'	=> $button_text_month,
				'week'	=> $button_text_week,
				'day'	=> $button_text_day,
				'rhc_search'=> $button_text_calendar,
				'rhc_event' => $button_text_event
			),
			'header'	=> (object)array(
				'left' 		=> 'prevYear,prev,next,nextYear today ',
				'center'	=> 'title',
				'right'		=> 'month,agendaWeek,agendaDay'
			)					
		);
		$options = apply_filters( 'rhc_bop_options', $options );
?>
<script>
var rh_calendar_options = <?php echo json_encode($options)?>;
</script>
<?php	
	}
	
}
?>