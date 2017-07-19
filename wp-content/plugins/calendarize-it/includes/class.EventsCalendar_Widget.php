<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class EventsCalendar_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
	 		'events_calendar_widget', 
			__('Calendarize (Events calendar)','rhc'), 
			array( 'description' => __( 'Events calendar', 'rhc' ), ) 
		);
	}

	function widget( $args, $instance ) {
		extract( $args );
		//----
		foreach(array('title','venue','organizer','calendar','view','theme','weekend','url','icalendar') as $field ){
			$$field = $instance[$field];
		}
		
		global $rhc_plugin;
		
		$events_slug = $rhc_plugin->get_option('rhc-events-slug',RHC_EVENTS,true);
		$visual_calendar_slug = $rhc_plugin->get_option('rhc-visualcalendar-slug',RHC_VISUAL_CALENDAR, true);
		
		if(trim($url)==''){
			$widget_link_page_id = $rhc_plugin->get_option('widget_link_template_page_id',false,true);
			$widget_link = false===$widget_link_page_id?'':get_page_link($widget_link_page_id);
			if(''==$widget_link){
	 			if( get_option( 'permalink_structure' ) !== '' ) {
	 				$widget_link = site_url( sprintf("/%s/%s/",$events_slug,$visual_calendar_slug) );    
	 			} else {
	 			    $widget_link = site_url("/?post_type=".RHC_EVENTS."&".RHC_DISPLAY."=".$visual_calendar_slug);
	 			}			
			}
		}else{
			$widget_link = $url;
		}
	
		echo $before_widget;
		echo trim($title)==''?'':$before_title.$title.$after_title;

		//-------- this portion is based on the code used on function.generate_calendarize_shortcode.php, TODO: simplify with a function
		$args=array();
		global $rhc_plugin;
		$field_option_map = array(
			"monthnames","monthnamesshort","daynames","daynamesshort","firstday"
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
		
		$str = sprintf("[calendarize icalendar='%s' weekends='%s' theme='%s' venue='%s' organizer='%s' calendar='%s' widget_link='%s' widget_link_view='%s' class='for-widget' header_left='prev,next' header_center='' header_right='title' defaultview='month' ignoreposted=1 for_widget=1 %s]",
			$icalendar,
			$weekend,
			$theme,
			$venue,
			$organizer,
			$calendar,
			$widget_link,
			$view,
			implode(' ',$args)
		);

		//echo $str;
		echo do_shortcode($str);
		
		
		echo $after_widget;				
		//-----
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = array();
		foreach(array('calendar','venue','organizer','title','url','view','theme','weekend','icalendar') as $field){
			$instance[$field] = $new_instance[$field];
		}
		return $instance;
	}

	function form( $instance ) {
		$taxmap = array('venue'=>RHC_VENUE,'organizer'=>RHC_ORGANIZER,'calendar'=>RHC_CALENDAR);
		foreach(array('title'=>'','view'=>'agendaDay','theme'=>'','weekend'=>1,'url'=>'','icalendar'=>'0') as $field =>$default){
			$$field = isset( $instance[$field] )?$instance[$field]:$default;		
		}
?>
<div>
	<div class="" style="margin-top:10px;">
		<label><?php _e('Title','rhc')?></label>
		<input type="text" id="<?php echo $this->get_field_id('title')?>" class="widefat" name="<?php echo $this->get_field_name('title')?>" value="<?php echo $title?>" />
	</div>
	<label><?php _e('Specific taxonomy:','wlbadds')?></label>
<?php foreach(array('calendar'=>__('Calendar','rhc'),'venue'=>__('Venue','rhc'),'organizer'=>__('Organizer','rhc')) as $field => $label):$$field = isset( $instance[$field] )?$instance[$field]:'';?>
	
	<div class="" style="margin-top:10px;">
	<label for="<?php echo $field ?>"><?php echo $label?></label>
	<?php $this->taxonomy_dropdown($taxmap[$field],$this->get_field_id($field),$this->get_field_name($field),(isset( $instance[$field] )?$instance[$field]:''))?>
	</div>
<?php endforeach;?>
	<div class="" style="margin-top:10px;">
		<?php _e('Calendar url(optional)','rhc')?>
		<input type="text" id="<?php echo $this->get_field_id('url')?>" name="<?php echo $this->get_field_name('url')?>" class="widefat" value="<?php echo $url?>" />
	</div>
	<div class="" style="margin-top:10px;">
		<?php _e('Link view','rhc')?>
		<select id="<?php echo $this->get_field_id('view')?>" name="<?php echo $this->get_field_name('view')?>" class="widefat">
			<?php foreach(array('agendaDay'=>__('Agenda day','rhc'),'rhc_event'=>__('Event list','rhc'),'agendaWeek'=>__('Agenda week','rhc'),'month'=>__('Month','rhc')) as $value => $label):?>
			<option value="<?php echo $value?>" <?php echo $value==$view?'selected="selected"':''?> ><?php echo $label?></option>
			<?php endforeach;?>
		</select>
	</div>
	<div class="" style="margin-top:10px;">
		<?php _e('Theme','rhc')?>
		<select id="<?php echo $this->get_field_id('theme')?>" name="<?php echo $this->get_field_name('theme')?>" class="widefat">
			<?php foreach( apply_filters('rhc-ui-theme',array()) as $value => $label):?>
			<option value="<?php echo $value?>" <?php echo $value==$theme?'selected="selected"':''?> ><?php echo $label?></option>
			<?php endforeach;?>
		</select>
	</div>
	<div class="" style="margin-top:10px;">
		<?php _e('Show weekend','rhc')?>
		<select id="<?php echo $this->get_field_id('weekend')?>" name="<?php echo $this->get_field_name('weekend')?>" class="widefat">
			<option value="1" <?php echo $weekend=='1'?'selected="selected"':''?> ><?php _e('Yes','rhc')?></option>
			<option value="0" <?php echo $weekend=='0'?'selected="selected"':''?> ><?php _e('No','rhc')?></option>
		</select>
	</div>	
	<div class="" style="margin-top:10px;">
		<?php _e('Show iCal button','rhc')?>
		<select id="<?php echo $this->get_field_id('icalendar')?>" name="<?php echo $this->get_field_name('icalendar')?>" class="widefat">
			<option value="1" <?php echo $icalendar=='1'?'selected="selected"':''?> ><?php _e('Yes','rhc')?></option>
			<option value="0" <?php echo $icalendar=='0'?'selected="selected"':''?> ><?php _e('No','rhc')?></option>
		</select>
	</div>	
</div>
<?php
	}
	
	function taxonomy_dropdown($taxonomy,$id,$name,$posted_value){
		$terms = get_terms($taxonomy);
?>
<select id="<?php echo $id?>" name="<?php echo $name?>" class="widefat upcoming-<?php echo $taxonomy?>">
<?php if(is_array($terms)&&count($terms)>0):?>
<option value=""><?php _e('--any--','rhc')?></option>
<?php foreach($terms as $t):?>
<option value="<?php echo $t->slug?>" <?php echo $posted_value==$t->slug?'selected="selected"':''?> ><?php echo $t->name?></option>
<?php endforeach;?>
<?php else: ?>
<option value=""><?php _e('--no options--','rhc')?></option>
<?php endif;?>
</select>
<?php		
	}
}
?>