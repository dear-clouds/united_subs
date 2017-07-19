<?php

class rhc_calendar_meta {
	var $post_meta_boxes = array();
	function __construct($post_type='rhcevents'){
		if(!class_exists('post_meta_boxes'))require_once('class.post_meta_boxes.php');		
		$this->post_meta_boxes = new post_meta_boxes(array(
			'post_type'=>$post_type,
			'options'=>$this->metaboxes(),
			'styles'=>array('post-meta-boxes','rhc-admin','rhc-jquery-ui'),
			'scripts'=>array('rhc-admin'),
			'metabox_meta_fields' => 'calendar_metabox_meta_fields'
		));
	}
	
	function metaboxes($t=array()){
		$i = count($t);
		//------------------------------
		$i++;
		$t[$i]->id 			= 'rhc-event-date'; 
		$t[$i]->label 		= __('Calendar','rhc');
		$t[$i]->right_label	= __('Calendar','rhc');
		$t[$i]->page_title	= __('Calendar','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'=>'rhc_dates',
				'type'=>'callback',
				'callback'=> array(&$this,'calendar_date')
			),		
			(object)array(
				'type'=>'hr'
			),			
			(object)array(
				'type'=>'label',
				'label'=>'Recurring event'
			),		
			(object)array(
				'id'		=> 'rhc_interval',
				'label'		=> __('Repeat','rhc'),
				'type'		=> 'callback',
				'callback'	=> array(&$this,'interval'),
				'default'	=> '',
				'options'	=> array(
					''			=> __('Never(Not a recurring event)','rhc'),
					'1 DAY'		=> __('Every day','rhc'),
					'1 WEEK'	=> __('Every week','rhc'),
					'2 WEEK'	=> __('Every 2 weeks','rhc'),
					'1 MONTH'	=> __('Every month','rhc'),
					'1 YEAR'	=> __('Every year','rhc'),
					'custom'	=> __('Custom interval','rhc')
				),
				'el_properties'=>array('class'=>'rhc_interval'),
				'save_option'=>true,
				'load_option'=>true
			),		
			(object)array(
				'id'		=> 'rhc_custom_interval',
				'label'		=> __('Custom','rhc'),
				'type'		=> 'callback',
				'callback'	=> array(&$this,'custom_interval'),
				'save_option'=>false,
				'load_option'=>false
			),				
		
			(object)array(
				'type'=>'clear'
			)
		);
		//------------------------------
		return $t;
	}	

	function calendar_date($tab,$i,$o,&$save_fields){
		global $post;
		$this->post_meta_boxes->save_fields[]='rhc_date_start';
		$this->post_meta_boxes->save_fields[]='rhc_date_end';	
?>
<div class="pt-option pt-option-calendar-dates">
	<label for="rhc-date-start">Date start</label>
	<input type="text" class="rhc_date_start rc-datetimepicker" name="rhc_date_start" value="<?php echo get_post_meta($post->ID,'rhc_date_start',true)?>" />
</div>

<div class="pt-option pt-option-calendar-dates">
	<label for="rhc-date-end">Date end (optional)</label>
	<input type="text" class="rhc_date_end rc-datetimepicker" name="rhc_date_end" value="<?php echo get_post_meta($post->ID,'rhc_date_end',true)?>" />
</div>
<?php	
	}
	
	function numeric_options($start=1,$end=100,$first_option=false){
		$options = array();
		if(false!==$first_option)
			$options[]=$first_option;
		for($a=$start;$a<=$end;$a++){
			$options[$a]=$a;
		}
		return $options;
	}
	
	function interval_type_options(){
		return array(
			'DAY'	=>'DAY',
			'WEEK'	=>'WEEK',
			'MONTH'	=>'MONTH',
			'YEAR'	=>'YEAR'
		);
	}
	
	function dropdown($name,$selected_value,$options){
		$str = "<select name=\"$name\">";
		foreach($options as $value => $label){
			$selected = $value==$selected_value?'selected="selected"':'';
			$str .= sprintf("<option %s value=\"%s\">%s</option>",$selected,$value,$label);
		}
		$str .= "</select>";
		return $str;
	}
	
	function custom_interval($tab,$i,$o,&$save_fields){
		global $post;
		$this->post_meta_boxes->save_fields[]='rhc_interval_frequency';
		$this->post_meta_boxes->save_fields[]='rhc_interval_type';
?>
<div class="pt-option pt-option-custom-interval ">
	<?php echo sprintf("Repeat every %s %s",$this->dropdown('rhc_interval_frequency',get_post_meta($post->ID,'rhc_interval_frequency',true),$this->numeric_options(1,100)),$this->dropdown('rhc_interval_type',get_post_meta($post->ID,'rhc_interval_type',true),$this->interval_type_options()))?>
</div>
<?php	
	}	
	
	function interval($tab,$i,$o,&$save_fields){
		$this->post_meta_boxes->save_fields[]=$o->id;
		echo sprintf("<div class=\"pt-option pt-option-%s rhc-interval\">",$o->type);
		echo sprintf("<div class=\"rhc-interval-label\"><span class=\"pt-label\">%s</span></div>",$o->label);
		echo sprintf("%s",$this->_radio($tab,$i,$o,$save_fields));
		echo "</div>";
	}
	
	function _radio($tab,$i,$o,&$save_fields){
		$str = '';
		if(!empty($o->options)){
			$k=0;
			foreach($o->options as $value => $label){
				$id = $o->id.'_'.($k++);
				$name = $o->id;
				$selected = $o->value==$value?'checked':'';
				$str.=sprintf("<div class=\"rhc-interval-option\"><input id=\"%s\" name=\"%s\" type=\"radio\" %s value=\"%s\" />&nbsp;<label>%s</label>&nbsp;&nbsp;</div>", $id, $name, $selected, $value, $label);
			}
			if(true===$o->save_option){
				$save_fields[]=$name;	
			}
		}
		return $str;
	}	
}
?>