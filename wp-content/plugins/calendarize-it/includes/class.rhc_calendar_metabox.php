<?php

class rhc_calendar_metabox {
	var $post_type;
	function __construct($post_type='rhcevents'){
		if(!class_exists('post_meta_boxes'))
			require_once('class.post_meta_boxes.php');		
		$this->post_type = $post_type;
		$this->metabox_meta_fields = array("fc_allday","fc_start","fc_start_time","fc_end","fc_end_time","fc_interval","fc_end_interval","fc_dow_except","fc_color","fc_text_color","fc_click_link","fc_click_target");
		$this->fc_intervals = plugin_righthere_calendar::get_intervals();
		$this->post_meta_boxes = new post_meta_boxes(array(
			'post_type'=>$post_type,
			'options'=>$this->metaboxes(),
			'styles'=>array('post-meta-boxes','rhc-admin','rhc-jquery-ui','calendarize-metabox','farbtastic'),
			'scripts'=>array('rhc-admin','fechahora','calendarize-metabox','farbtastic'),
			'metabox_meta_fields' =>  'calendar_metabox_meta_fields',
			'pluginpath'=>RHC_PATH
		));
		$this->post_meta_boxes->save_fields = $this->metabox_meta_fields;
		add_action('wp_ajax_calendarize_'.$post_type, array(&$this,'ajax_calendarize'));
		//----
		add_action('save_post', array(&$this,'save_post') );
	}
	
	function save_post($post_id){
		$date = get_post_meta($post_id,'fc_start',true);
		if(trim($date)!=''){
			global $wpdb;
			$time = get_post_meta($post_id,'fc_start_time',true);		
			$time = trim($time)==''?'12:00 am':$time;
			$sql = "SELECT COALESCE((SELECT DATE_FORMAT(STR_TO_DATE('$date $time','%Y-%m-%d %h:%i %p'), '%Y-%m-%d %H:%i:%s')),'')";
			$datetime = $wpdb->get_var($sql,0,0);
			if(trim($datetime)!=''){
				update_post_meta($post_id,'fc_start_datetime',$datetime);
			}
		}
	}
	
	function ajax_calendarize(){
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
		
		$fc_allday = ''==trim($fc_allday)?1:$fc_allday;
		$fc_start = ''==trim($fc_start)?date('Y-m-d'):$fc_start;
		$fc_start_time = ''==trim($fc_start_time)?'12:00 am':$fc_start_time;
		$fc_end = ''==trim($fc_end)?$fc_start:$fc_end;
		$fc_end_time = ''==trim($fc_end_time)?$fc_start_time:$fc_end_time;
	
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
			$arr = explode(" ",$fc_interval);
			$sql = sprintf("SELECT (start_date+INTERVAL seq %s) as start_date, (end_date+INTERVAL seq %s) as end_date FROM 
(SELECT STR_TO_DATE('%s','%%Y-%%m-%%d %%h:%%i %%p') as start_date, STR_TO_DATE('%s','%%Y-%%m-%%d %%h:%%i %%p') as end_date ) as A,
(
SELECT (seq) as seq FROM 
(SELECT (A.i+B.i*10+C.i*100) as seq FROM
(SELECT 0 as i UNION select 1 as i UNION SELECT 2 as i UNION SELECT 3 as i UNION SELECT 4 as i UNION SELECT 5 as i UNION SELECT 6 as i UNION SELECT 7 as i UNION SELECT 8 as i UNION SELECT 9 as i) 
as A JOIN (SELECT 0 as i UNION select 1 as i UNION SELECT 2 as i UNION SELECT 3 as i UNION SELECT 4 as i UNION SELECT 5 as i UNION SELECT 6 as i UNION SELECT 7 as i UNION SELECT 8 as i UNION SELECT 9 as i) 
as B JOIN (SELECT 0 as i UNION select 1 as i UNION SELECT 2 as i UNION SELECT 3 as i UNION SELECT 4 as i UNION SELECT 5 as i UNION SELECT 6 as i UNION SELECT 7 as i UNION SELECT 8 as i UNION SELECT 9 as i) 
as C 
) as baseseq WHERE MOD(seq,%s)=0 HAVING seq>=0 AND seq<1000
) as B HAVING start_date >= STR_TO_DATE('%s','%%Y-%%m-%%d %%H:%%i:%%s') AND end_date <= STR_TO_DATE('%s','%%Y-%%m-%%d %%H:%%i:%%s')",
	$arr[1],$arr[1],
	($fc_start.' '.$fc_start_time),($fc_end.' '.$fc_end_time),
	$arr[0],
	date('Y-m-d H:i:s',$_POST['start']),date('Y-m-d H:i:s',$_POST['end'])
);

			if(trim($fc_end_interval)!=''){
				$sql.= sprintf(" AND start_date <= STR_TO_DATE('%s 23:59:59','%%Y-%%m-%%d %%H:%%i:%%s')", $fc_end_interval );
			}
//			$fc_dow_except=array(2);//for debugging			
			$fc_dow_except = trim($fc_dow_except)!=''?explode('|',$fc_dow_except):array();
			if(is_array($fc_dow_except)&&count($fc_dow_except)>0 && is_numeric(implode('',$fc_dow_except)) ){
				$sql.= sprintf(" AND DAYOFWEEK(start_date) NOT IN (%s)", implode(',',$fc_dow_except) );
			}
			
			global $wpdb;
			if(false!==$wpdb->query($sql)){
				foreach($wpdb->last_result as $row){
					$event['start']	= $row->start_date;
					$event['end']	= $row->end_date;
					$events[]=(object)$event;
				}
			}
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
	
	
	function metaboxes($t=array()){
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
		//------------------------------
		return $t;
	}	

	function fullcalendar($tab,$i,$o){
		global $post;
		foreach($this->metabox_meta_fields as $meta_field){
		//	echo sprintf('%s <input id="%s" type="text" class="calendarize_meta_data" name="%s" value="%s" />',
		//		$meta_field,
			echo sprintf('<input id="%s" type="hidden" class="calendarize_meta_data" name="%s" value="%s" />',
				$meta_field,
				$meta_field,
				get_post_meta($post->ID,$meta_field,true)
			);
		//	echo "<br />";
		}	
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
		<div class="fc-arrow-holder">
			<div class="fc-arrow"></div>
			<div class="fc-arrow-border"></div>
		</div>
		<div class="fc-widget postbox taxonomydiv">
			<h3 class="hndle"><?php echo sprintf(__('Calendarize %s','rhc'),$post_type->label)?></h3>
			<div class="inside">
				<div>&nbsp;</div>

				<div class="fc-dialog-content">
					<ul class="category-tabs wp-tab-bar">
						<li class="tabs"><a rel=".tab-date">Date</a></li>
						<li class="tabs"><a rel=".tab-color">Color</a></li>
						<li class="tabs"><a rel=".tab-calendar">Calendar</a></li>
					</ul>
					<div class="tab-date tabs-panel">
						<div class="fc-form-field">
							<label for="fc_allday" class="left-label"><?php _e('All-day','rhc')?></label>
							<input type="checkbox" class="fc_allday fc_input" name="fc_allday" value="1" />
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<div id="fc_start_fullcalendar_holder" class="fc_start_fullcalendar_holder postbox close-on-click" rel="fc_start">
								<div class="fc_start_fullcalendar"></div>
							</div>
							<label for="fc_start" class="left-label"><?php _e('Start','rhc')?></label>
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
							<label for="fc_end" class="left-label"><?php _e('End','rhc')?></label>
							<div class="fc-date-time">
								<input type="text" class="fc_end fc_input" name="fc_end" value="" /><span class="fc-time-label"><?php _e('at','rhc')?></span>
								<input type="text" class="fc_end_time fc_input" name="fc_end_time" value="" placeholder="<?php _e('any time','rhc')?>" />
							</div>
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<label for="fc_repeat" class="left-label"><?php _e('Repeat','rhc')?></label>
							<select name="fc_interval" class="fc_input fc_interval">
							<?php foreach($this->fc_intervals as $value => $label):?>
								<option value="<?php echo $value?>"><?php echo $label?></option>
							<?php endforeach;?>
							</select>
							<div class="clear"></div>
						</div>
						<div class="fc-form-field fc_dow_except_holder">
							<label for="fc_dow_except" class="left-label"><?php _e('Except','rhc')?></label>
							<div class="fc-dow-except-options">
							<?php foreach(array('1'=>__('Sun','rhc'),'2'=>__('Mon','rhc'),'3'=>__('Tue','rhc'),'4'=>__('Wed','rhc'),'5'=>__('Thu','rhc'),'6'=>__('Fri','rhc'),'7'=>__('Sat','rhc')) as $value => $label):?>
							<div class="fc-dow-except-option">
								<input type="checkbox" class="fc_input fc_dow_except fc_array" name="fc_dow_except[]" value="<?PHP echo $value?>" />&nbsp;<span class="fc-dow-except-label"><?php echo $label?></span>							
							</div>
							<?php endforeach;?>							
							</div>
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<div id="fc_end_interval_fullcalendar_holder" class="fc_start_fullcalendar_holder fc_end_interval_fullcalendar_holder postbox close-on-click" rel="fc_end_interval">
								<div class="fc_start_fullcalendar"></div>
							</div>
							<label for="fc_end_interval" class="left-label"><?php _e('End repeat','rhc')?></label>
							<div class="fc-date-time">
								<input type="text" class="fc_end_interval fc_input" name="fc_end_interval" value="" />
							</div>
							<div class="clear"></div>
						</div>
					</div>			
					
					<div class="tab-color tabs-panel">
						<div class="fc-form-field">
							<label for="fc_color" class="left-label"><?php _e('Color','rhc')?></label>
							
							<div class="farbtastic-holder">
								<input id="frm_fc_color" type='text' class='fc_color fc_input fc_color_input' name='fc_color' value='<?Php echo get_post_meta($post->ID,'fc_color',true)?>' /><a title="<?PHP _e('Choose color','rhc')?>" class="farbtastic-choosecolor" href="javascript:void(0);" rel="<?PHP _e('Close','rhc')?>"><?PHP _e('Show','rhc')?></a>
								<div id="farbtastic_fc_color" rel="#frm_fc_color" class="pop-farbtastic"></div>
							</div>
							<div class="pop-float-separator">&nbsp;</div>
							
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<label for="fc_text_color" class="left-label"><?php _e('Text color','rhc')?></label>
							
							<div class="farbtastic-holder">
								<input id="frm_fc_text_color" type='text' class='fc_text_color fc_input fc_color_input' name='fc_text_color' value='<?Php echo get_post_meta($post->ID,'fc_text_color',true)?>' /><a title="<?PHP _e('Choose color','rhc')?>" class="farbtastic-choosecolor" href="javascript:void(0);" rel="<?PHP _e('Close','rhc')?>"><?PHP _e('Show','rhc')?></a>
								<div id="farbtastic_fc_text_color" rel="#frm_fc_text_color" class="pop-farbtastic"></div>
							</div>
							<div class="pop-float-separator">&nbsp;</div>							
							
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>		
					
					<div class="tab-calendar tabs-panel">
						<div class="fc-form-field">
							<label for="fc_click_link" class="left-label"><?php _e('Click links to','rhc')?></label>
							<div class="fc-click-link">
								<select class="fc_click_link fc_input" name="fc_click_link">
									<option value="view"><?php _e('Calendar view','rhc')?></option>
									<option value="page"><?php _e('Page','rhc')?></option>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<label for="fc_click_target" class="left-label"><?php _e('Target','rhc')?></label>
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
				</div>	
			</div>
			<div class="fc-dialog-controls">
				<input type="button" class="button-primary fc-dg-ok" name="fc-dg-ok" value="<?php _e('Accept','rhc')?>" />
				<input type="button" class="button-secondary fc-dg-cancel" name="fc-dg-cancel" value="<?php _e('Cancel','rhc')?>" />
				<input type="button" class="button-secondary fc-dg-remove" name="fc-dg-remove" value="<?php _e('Remove','rhc')?>" />
				<div class="fc-status">
					<img src="<?php echo admin_url('/images/wpspin_light.gif')?>" alt="" />
				</div>
				<div class="clear"></div>
			</div>		
			<div class="clear"></div>
		</div>
	</div>

<?php	
	}	
}
?>