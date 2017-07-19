<?php
		global $rhc_plugin; 

		$weekdays = array(
			0 => __('Sunday','rhc'),
			1 => __('Monday','rhc'),
			2 => __('Tuesday','rhc'),
			3 => __('Wednesday','rhc'),
			4 => __('Thursday','rhc'),
			5 => __('Friday','rhc'),
			6 => __('Saturday','rhc')
		);
		//----
		$i = count($t);
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhc-default-cal-settings'; 
		$t[$i]->label 		= __('Calendarize shortcode','rhc');
		$t[$i]->right_label	= __('Default calendar settings','rhc');
		$t[$i]->page_title	= __('Calendarize shortcode','rhc');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array();	 

		//-- exclusively for VC-- not used on POP, perhaps we should.
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_general',
				'type' 			=> 'vc_tab', 
				'label'			=> __('General','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_defaultview',
				'type' 			=> 'select',
				'label'			=> __('Default view','rhc'),
				'options'		=> apply_filters('rhc_views', array(
					''			=> __('--choose--','rhc'),
					'month'		=> __('Month','rhc'),
					'basicWeek'	=> __('Week','rhc'),
					'basicDay'	=> __('Day','rhc'),
					'agendaWeek'=> __('Agenda Week','rhc'),
					'agendaDay'	=> __('Agenda Day','rhc'),
					'rhc_event'	=> __('Events list','rhc')
				)),
				'save_option'=>true,
				'load_option'=>true,
				'vc_admin_label'=>true
			);	
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_aspectratio',
				'type' 			=> 'text',
				'label'			=> __('Aspect ratio','rhc'),
				'default'		=> '1.35',
				'save_option'=>true,
				'load_option'=>true
			);	

		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_header_left',
				'type' 			=> 'text',
				'label'			=> __('Left header','rhc'),
				'default'		=> 'rhc_search prevYear,prev,next,nextYear today',
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);	

		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_header_center',
				'type' 			=> 'text',
				'label'			=> __('Center header','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'default'		=> 'title',
				'save_option'=>true,
				'load_option'=>true
			);	

		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_header_right',
				'type' 			=> 'text',
				'label'			=> __('Right header','rhc'),
				'default'		=> 'month,agendaWeek,agendaDay,rhc_event',
				'description'	=> __('Defaults to: <b>month,agendaWeek,agendaDay,rhc_event</b>. Also available: basicWeek','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);	

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_upcoming',
				'label'		=> __('Upcoming only (all views)','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description' => __('Choose yes if only want to display upcoming events.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_allday_group',
				'type' 			=> 'select',
				'label'			=> __('Allday group','rhc'),
				'description'	=> __('By default allday events are rendered ordered by title.  Choose color to group by color, or by order to use the menu order from the edit event screen.','rhc'),
				'options'		=> array(
					''		=> __('By title(default)','rhc'),
					'color'	=> __('By event color','rhc'),
					'order'	=> __('By menu order','rhc')
				),
				'default'	=> '',
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_upcoming_trim_past',
				'label'		=> __('Month View, trim past weeks','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description' => __('Choose yes if you want to remove past weeks from the Month view.  Only applicable when Upcoming only is also enabled.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);

		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Disable months','rhc'),
				'vc_skip'		=> true
			);
		
		//the values are meant for javascript so jan is 0 while december is 11.
		$months = array(
					'0'	=> __('January','rhc'),
					'1'	=> __('February','rhc'),
					'2'	=> __('March','rhc'),
					'3'	=> __('April','rhc'),
					'4' => __('May','rhc'),
					'5'	=> __('June','rhc'),
					'6'	=> __('July','rhc'),
					'7'	=> __('August','rhc'),
					'8'	=> __('September','rhc'),
					'9'	=> __('October','rhc'),
					'10'=> __('November','rhc'),
					'11'=> __('December','rhc')
				);		
		$j = 0;	
		foreach($months as $value => $label){
			$tmp=(object)array(
				'id'	=> 'skipmonths_'.$value,
				'name'	=> 'cal_skipmonths[]',
				'type'	=> 'checkbox',
				'option_value'=>$value,
				'default'	=> '',
				'label'	=> $label,
				'el_properties' => array(),
				'save_option'=>true,
				'load_option'=>true,
				'vc_label'=> __('Disable months','rhc')
			);
			if($j==0){
				$tmp->description = __("Check months that you do NOT want to show. Pressing prev or next button in calendar will skip to the next available month.",'rhc');
				$tmp->description_rowspan = count($weekdays);
			}
			$t[$i]->options[]=$tmp;
			$j++;
		}
		
		$weekdays = array(
					'0'	=> __('Sunday','rhc'),
					'1'	=> __('Monday','rhc'),
					'2'	=> __('Tuesday','rhc'),
					'3'	=> __('Wednesday','rhc'),
					'4' => __('Thursday','rhc'),
					'5'	=> __('Friday','rhc'),
					'6'	=> __('Saturday','rhc')
				);
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Hide days from view','rhc'),
				'vc_skip'		=> true
			);
		$j = 0;	
		foreach($weekdays as $value => $label){
			$tmp=(object)array(
				'id'	=> 'hiddendays_'.$value,
				'name'	=> 'cal_hiddendays[]',
				'type'	=> 'checkbox',
				'option_value'=>$value,
				'default'	=> '',
				'label'	=> $label,
				'el_properties' => array(),
				'save_option'=>true,
				'load_option'=>true,
				'vc_label'=>__('Hide days from view','rhc')
			);
			if($j==0){
				$tmp->vc_description = __("Check days that you do NOT want to show.",'rhc');
				$tmp->description = sprintf("<p>%s</p><p><strong>%s</strong>&nbsp;hiddendays</p><p><strong>%s</strong>&nbsp;%s</p><p><strong>%s</strong>&nbsp;&#91;calendarizeit hiddendays='0,1'&#93;</p>",
					__("Check days that you do NOT want to show.",'rhc'),
					__("Shortcode argument:",'rhc'),
					__("Shortcode values:",'rhc'),
					__("Comma separated numeric values.  0 for sunday, 1 for monday, 2 for tuesday, 3 for wednsday, 4 for thursday, 5 for friday, 6 for saturday",'rhc'),
					__("Example(hiding sunday and monday):")
				);
				$tmp->description_rowspan = count($weekdays);
			}
			$t[$i]->options[]=$tmp;
			$j++;
		}
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_weekends',
				'type' 			=> 'yesno',
				'label'			=> __('Show weekends','rhc'),
				'default'		=> '1',
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'clear'
			);
								
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_firstday',
				'type' 			=> 'select',
				'label'			=> __('Calendar First Day','rhc'),
				'default'		=> 0,
				'options'		=> $weekdays,
				'save_option'=>true,
				'load_option'=>true
			);
		/*
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_hiddendays',
				'type' 			=> 'checkbox_array',
				'label'			=> __('Hidden days','rhc'),
				'options'		=> $weekdays,
				'save_option'=>true,
				'load_option'=>true
			);
			*/
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_loading_overlay',
				'type' 			=> 'yesno',
				'label'			=> __('Show loading overlay','rhc'),
				'default'		=> '0',
				'description'	=> __('Show a loading overlay on the calendar viewport when fetching events','rhc'),
				'save_option'=>true,
				'load_option'=>true
			)	;
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_week_numbers',
				'type' 			=> 'yesno',
				'label'			=> __('Enable week numbers','rhc'),
				'default'		=> '0',
				'description'	=> sprintf("<p>%s</p><p>%s</p>",
					__('Enables displaying week numbers on the calendar views.','rhc'),
					__('<b>Week number label</b>: By default it is "W", this is the label shown on the week column in month view.  In agenda views it is shown in the top left corner.','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_week_numbers_title',
				'type' 			=> 'text',
				'label'			=> __('Week number label','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);
			
		//-- exclusively for VC-- not used on POP, perhaps we should.
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_labels',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Labels','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);			
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Calendar labels','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p><p><b>%s</b> %s</p><p><b>%s</b> %s</p><p><b>%s</b> %s</p><p><b>%s</b> %s</p>',
					__('Only use this options if you want to use diferent labels from the localized ones, or if the plugin is not providing localization at all.','rhc'),
					__('Write <b>comma separated</b> and <b>no space</b> labels on each setting in this section','rhc'),
					__('Default month names:','rhc'),
					__('January, February, March, April, May, June, July, August, September, October, November, December','rhc'),
					__('Default short month names:','rhc'),
					__('Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec','rhc'),
					__('Default day names:','rhc'),
					__('Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday','rhc'),
					__('Default short day names:','rhc'),
					__('Sun, Mon, Tue, Wed, Thu, Fri, Sat','rhc')
				),
				'vc_description' => sprintf('<p>%s</p><p>%s</p>',
					__('Only use this options if you want to use diferent labels from the localized ones, or if the plugin is not providing localization at all.','rhc'),
					__('Write <b>comma separated</b> and <b>no space</b> labels on each setting in this section','rhc')
				)				
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_monthnames',
				'type' 			=> 'text',
				'label'			=> __('Month names','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'	=> true,
				'load_option'	=> true,
				'vc_description' => sprintf('<p>%s</p><p>%s</p>',
					__('Default month names:','rhc'),
					__('January, February, March, April, May, June, July, August, September, October, November, December','rhc')
				)	
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_monthnamesshort',
				'type' 			=> 'text',
				'label'			=> __('Short month names','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => sprintf('<p>%s</p><p>%s</p>',
					__('Default short month names:','rhc'),
					__('Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec','rhc')
				)	
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_daynames',
				'type' 			=> 'text',
				'label'			=> __('Day names','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => sprintf('<p>%s</p><p>%s</p>',
					__('Default day names:','rhc'),
					__('Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday','rhc')
				)	
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_daynamesshort',
				'type' 			=> 'text',
				'label'			=> __('Short day names','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => sprintf('<p>%s</p><p>%s</p>',
					__('Default short day names:','rhc'),
					__('Sun, Mon, Tue, Wed, Thu, Fri, Sat','rhc')
				)
			);
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Button labels','rhc'),
				'description'	=> sprintf("%s<br /><img src=\"%s\" class=\"rhc-option-preview\"/>",
					__('Change the labels of the buttons in the calendar top controls.  Please observe that this will overwrite localization, so if you are using multiple languages, leave this fields empty.','rhc'),
					RHC_URL.'css/images/opt_preview_cal_button_labels.png'
				)
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_button_text_today',
				'type' 			=> 'text',
				'label'			=> __('Button today','rhc'),
				//'default'		=> __('today','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_button_text_month',
				'type' 			=> 'text',
				'label'			=> __('Button month','rhc'),
				//'default'		=> __('month','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_button_text_day',
				'type' 			=> 'text',
				'label'			=> __('Button day','rhc'),
				//'default'		=> __('day','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_button_text_week',
				'type' 			=> 'text',
				'label'			=> __('Button week','rhc'),
				//'default'		=> __('week','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_button_text_calendar',
				'type' 			=> 'text',
				'label'			=> __('Button Calendar','rhc'),
				//'default'		=> __('Calendar','rhc'),
				'save_option'=>true,
				'load_option'=>true
			)	;
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_button_text_event',
				'type' 			=> 'text',
				'label'			=> __('Button event','rhc'),
				//'default'		=> __('event','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		/*
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_button_text_prev',
				'type' 			=> 'text',
				'label'			=> __('Button previous','rhc'),
				//'default'		=> __('event','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_button_text_next',
				'type' 			=> 'text',
				'label'			=> __('Button next','rhc'),
				//'default'		=> __('event','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		*/	
		/* this are not working.	
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Header icons','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_buttonicons_prev',
				'type' 			=> 'text',
				'label'			=> __('Button previous','rhc'),
				'default'		=> 'circle-triangle-w',
				'save_option'=>true,
				'load_option'=>true
			)	;
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_buttonicons_next',
				'type' 			=> 'text',
				'label'			=> __('Button previous','rhc'),
				'default'		=> 'circle-triangle-e',
				'save_option'=>true,
				'load_option'=>true
			);
		*/	
		$t[$i]->options[]=(object)array(
				'type' 			=> 'clear'
			);
			
		//-- exclusively for VC-- not used on POP, perhaps we should.
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_month',
				'type' 			=> 'vc_tab', 
				'label'			=> __('Month','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);				
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Month view','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_week_mode',
				'label'		=> __('Week mode','rhc'),
				'type'		=> 'select',
				'default'	=> 'fixed',
				'options'	=> array(
					'fixed'		=> __('Fixed','rhc'),
					'liquid'	=> __('Liquid','rhc'),
					'variable'	=> __('Variable','rhc')
				),
				'description'	=> __('Determines the number of weeks displayed in the calendar.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_matchbackground',
				'label'		=> __('Background matches event color','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description' => __('Choose yes if you want the day cell match the background color of the event.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_render_events',
				'label'		=> __('Render events','rhc'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'description' => __('Choose no if you dont want the event titles to render.  This is to be used in combination with the match background option.  Only applicable to month view.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_fixed_title',
				'label'		=> __('Fixed title','rhc'),
				'type'		=> 'text',
				'description' => __('Replace the event title with a fixed label.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_month_event_image',
				'label'		=> __('Month view image','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description' => __('Choose yes to enable inserting the "Month view image" in events that has this image set.  Then "Month view image" is set in a metabox when editing an event.  The metabox has to be enabled separately on the next option.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_month_event_image_metabox',
				'label'		=> __('Month view image metabox','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description' => __('Choose yes to enable the "Month view image" metabox.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_next_day_threshold',
				'label'		=> __('Next day threshold','rhc'),
				'type'		=> 'select',
				'default'	=> '',
				'options'	=> array(
					''			=> __('Not used', 'rhc'),
					'00'			=> '00:00',
					'1'			=> '01:00',
					'2'			=> '02:00',
					'3'			=> '03:00',
					'4'			=> '04:00',
					'5'			=> '05:00',
					'6'			=> '06:00',
					'7'			=> '07:00',
					'8'			=> '08:00',
					'9'			=> '09:00',
					'10'		=> '10:00',
					'11'		=> '11:00',
					'12'		=> '12:00'
				),
				'description'	=> sprintf("<p>%s</p><p>%s</p><p>%s</p>",
					__('Determines how much time an event can get past midnight without displaying it on that day.','rhc'),
					__('Shortcode argument: next_day_threshold','rhc'),
					__('Possible values: 0,1,2... 12','rhc')
				),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_showothermonth',
				'label'		=> __('Show other month events','rhc'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'description' => __('In month view, some dates from other months are rendered to complete the week.  Choose yes to display events on it, or no to leave them blank.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_month_hide_time',
				'label'		=> __('Hide time','rhc'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description' => __('Choose yes if you do not want the time to be rendered.','rhc'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'clear'
			)	;
			
		//-- exclusively for VC-- not used on POP, perhaps we should.
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_agenda',		
				'type' 			=> 'vc_tab', 
				'label'			=> __('Agenda','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);				
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Agenda view (week and day view)','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_alldayslot',
				'label'		=> __('Show all-day slot','rhc'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_alldaytext',
				'type' 			=> 'text',
				'label'			=> __('all-day label','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_firsthour',
				'type'	=> 'range',
				'label'	=> __('First hour','rhc'),
				'min'	=> 0,
				'max'	=> 24,
				'step'	=> 1,
				'default'=> 6,
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_slotminutes',
				'type'	=> 'range',
				'label'	=> __('Slot minutes','rhc'),
				'min'	=> 5,
				'max'	=> 60,
				'step'	=> 1,
				'default'=> 30,
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_mintime',
				'type'	=> 'range',
				'label'	=> __('Minimun displayed time','rhc'),
				'min'	=> 0,
				'max'	=> 24,
				'step'	=> 1,
				'default'=> 0,
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_maxtime',
				'type'	=> 'range',
				'label'	=> __('Maximun displayed time','rhc'),
				'min'	=> 0,
				'max'	=> 24,
				'step'	=> 1,
				'default'=> 24,
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'type' 			=> 'clear'
			);
			
		//-- exclusively for VC-- not used on POP, perhaps we should.
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_event_list',		
				'type' 			=> 'vc_tab', 
				'label'			=> __('Event list','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);				
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Event list view','rhc'),
				'description'	=> sprintf('<p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p>',
					__('<b>Show same date header:</b>  choose yes to show a label with the date before events on the same date.','rhc'),
					__('<b>Upcoming only:</b>  choose yes if you only want to display upcoming events.','rhc'),
					__('<b>Reverse order:</b>  choose yes to invert the order of events','rhc'),
					__('<b>Stack behaviour:</b>When clicking Next, the view will not be cleared, instead new events will stack.','rhc'),
					__('<b>Stack autoload:</b>Automatically fetch and stack the next group of events','rhc'),
					__('<b>Custom Days per page:</b>  By default when clicking next or previous, the view will go to the next month, behaving in a similar way to the month view.  You can specify the number of days to advance with this option.','rhc'),
					__('<b>Months ahead:</b>  By default the events view show up to one month of upcoming events.  Use this option to show more events.','rhc'),
					__('<b>Days ahead:</b>  Similar to months ahead, but allows specifying days intead of months.  This option overwrites the months option.','rhc'),
					__('<b>Max displayed events:</b>  Optionally limit the number of events displayed.','rhc'),
					__('<b>Show multi month events:</b> By default long spanning events that started on a diferent month will not be displayed in the event list.  Check yes to show them.','rhc'),
					__('<b>Remove ended:</b> Remove event if it has ended.  Event end date is compared against the time in the client side.','rhc'),
					__('<b>Load Dynamic Event Details Box:</b> Choose yes to load the "custom event fields", which is configured on the Event Details metabox.','rhc')
				),
				'vc_description' => ''			
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistshowheader',
				'type' 			=> 'yesno',
				'label'			=> __('Show same date header','rhc'),
				'default'		=> '1',
				'save_option'	=> true,
				'load_option'	=> true,
				'vc_description' => __('<b>Show same date header:</b>  choose yes to show a label with the date before events on the same date.','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistnoeventstext',
				'type' 			=> 'text',
				'label'			=> __('No events text','rhc'),
				'default'		=> __('No upcoming events in this date range','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true				
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistupcoming',
				'type' 			=> 'yesno',
				'label'			=> __('Upcoming only','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Upcoming only:</b>  choose yes if you only want to display upcoming events.','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistreverse',
				'type' 			=> 'yesno',
				'label'			=> __('Reverse order','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Reverse order:</b>  choose yes to invert the order of events','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistoutofrange',
				'type' 			=> 'yesno',
				'label'			=> __('Show multi month events','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Show multi month events:</b> By default long spanning events that started on a diferent month will not be displayed in the event list.  Check yes to show them.','rhc')
				
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistremoveended',
				'type' 			=> 'yesno',
				'label'			=> __('Remove ended','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Remove ended:</b> Remove event if it has ended.  Event end date is compared against the time in the client side.','rhc')				
		
			);
			
				
			
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventliststack',
				'type' 			=> 'yesno',
				'label'			=> __('Stack behaviour','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Stack behaviour:</b>When clicking Next, the view will not be cleared, instead new events will stack.','rhc')
			);	
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistauto',
				'type' 			=> 'yesno',
				'label'			=> __('Stack autoload','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Stack autoload:</b>Automatically fetch and stack the next group of events','rhc')
			);	
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistdelta',
				'type' 			=> 'text',
				'label'			=> __('Custom Days per page(optional)','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'   => true,
				'load_option'   => true,
				'vc_description' => __('<b>Custom Days per page:</b>  By default when clicking next or previous, the view will go to the next month, behaving in a similar way to the month view.  You can specify the number of days to advance with this option.','rhc')
			);
		
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistmonthsahead',
				'type' 			=> 'text',
				'label'			=> __('Months ahead to show(optional)','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Months ahead:</b>  By default the events view show up to one month of upcoming events.  Use this option to show more events.','rhc')
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistdaysahead',
				'type' 			=> 'text',
				'label'			=> __('Days ahead to show(optional)','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Days ahead:</b>  Similar to months ahead, but allows specifying days intead of months.  This option overwrites the months option.','rhc')
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlist_display',
				'type' 			=> 'text',
				'label'			=> __('Max displayed events(optional)','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Max displayed events:</b>  Optionally limit the number of events displayed.','rhc')
			)	;
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_eventlistextendeddetails',
				'type' 			=> 'yesno',
				'label'			=> __('Load Dynamic Event Details Box','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true,
				'vc_description' => __('<b>Load Dynamic Event Details Box:</b> Choose yes to load the "custom event fields", which is configured on the Event Details metabox.','rhc')	
			);
			
					
		$t[$i]->options[]=(object)array(
				'type' 			=> 'clear'
			);
			
		//-- exclusively for VC-- not used on POP, perhaps we should.
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_tooltip',		
				'type' 			=> 'vc_tab', 
				'label'			=> __('Tooltip','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);				
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Tooltip behaviour','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_tooltip_target',
				'type' 			=> 'select',
				'label'			=> __('Tooltip links target','rhc'),
				'default'		=> '_blank',
				'options'		=> array(
					'_self'		=> __('_self','rhc'),
					'_blank'	=> __('_blank','rhc'),
					'_top'		=> __('_top','rhc'),
					'_parent'	=> __('_parent','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_tooltip_disable_title_link',
				'type' 			=> 'yesno',
				'label'			=> __('Disable title link','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_tooltip_enable_custom',
				'type' 			=> 'yesno',
				'label'			=> __('Enable custom details layout','rhc'),
				'description'	=> __('Choose no if you dont want to use the custom layout that can be set on the event edit page.','rhc'),
				'default'		=> '1',
				'save_option'=>true,
				'load_option'=>true
			);			

		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_tooltip_on_hover',
				'type' 			=> 'yesno',
				'label'			=> __('Show on hover','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true
			);

		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_tooltip_close_on_title_leave',
				'type' 			=> 'yesno',
				'label'			=> __('Close on event title leave','rhc'),
				'default'		=> '0',
				'save_option'=>true,
				'load_option'=>true
			);
			
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_tooltip_image',
				'type' 			=> 'yesno',
				'label'			=> __('Render image in tooltip','rhc'),
				'default'		=> '1',
				'save_option'=>true,
				'load_option'=>true
			);			
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'clear'
			);
			
		//-- exclusively for VC-- not used on POP, perhaps we should.
		$t[$i]->options[]=(object)array(
				'id'			=> 'vc_tab_other',		
				'type' 			=> 'vc_tab', 
				'label'			=> __('Other','rhc'),
				'vc_tab'		=> true //flat the start of a tab in vc.
			);				
			
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('icalendar button','rhc')
			);
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_icalendar',
				'label'		=> __('Enable icalendar button','rhc'),
				'type'		=> 'yesno',
				//'hidegroup'	=> '#icalendar_group',
				'default'	=> '1',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'	=> 'icalendar_group',
				'type'=>'div_start'
			);
		$t[$i]->options[]=(object)array(
				'id'	=> 'cal_icalendar_width',
				'type'	=> 'range',
				'label'	=> __('Dialog width','rhc'),
				'min'	=> 0,
				'max'	=> 1024,
				'step'	=> 1,
				'default'=> 460,
				'save_option'=>true,
				'load_option'=>true,
				'vc_default' => 460
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_icalendar_button',
				'type' 			=> 'text',
				'label'			=> __('Button label','rhc'),
				'el_properties'	=> array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_icalendar_title',
				'type' 			=> 'text',
				'label'			=> __('Dialog title','rhc'),
				'el_properties'	=> array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_icalendar_description',
				'type' 			=> 'textarea',
				'el_properties'	=> array('class'=>'widefat'),
				'label'			=> __('Dialog description','rhc'),
				'save_option'=>true,
				'load_option'=>true
			);
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_icalendar_align',
				'type' 			=> 'select',
				'label'			=> __('Alignment','rhc'),
				'default'		=> 0,
				'options'		=> array(
					'left'		=> __('Left','rhc'),
					'center'	=> __('Center','rhc'),
					'right'		=> __('Right','rhc')
				),
				'save_option'=>true,
				'load_option'=>true
			);
		
		$t[$i]->options[]=(object)array(
				'type'=>'div_end'
			);
		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);

		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Calendar button (filter)','rhc')
			);

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_hierarchical_filter',
				'label'		=> __('Hierarchical filter','rhc'),
				'type'		=> 'yesno',
				'description' => __('Choose yes to limit the terms listed under a taxonomy in the taxonomy filter.  For example, lets say that the calendar is configured to only show events from the "Sports" category, the filter will only display terms that contains events and that are children of the "Sports" term.','rhc'),
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);			

		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);

		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Event click behavior','rhc')
			);

		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_event_click',
				'label'		=> __('Event click behavior','rhc'),
				'type'		=> 'select',
				'options'	=> apply_filters('rhc_event_click_functions', array(
					'fc_click'				=> __( 'Default', 'rhc' ),
					'fc_click_no_action'	=> __( 'No action', 'rhc' )
				)),
				'default'	=> 'fc_click',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);	
			
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
 
		/*	
		$t[$i]->options[]=(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Search field','rhc')
			);
			
		$t[$i]->options[]=(object)array(
				'id'		=> 'cal_search_enable',
				'label'		=> __('Enable search field','rhc'),
				'type'		=> 'yesno',
				//'hidegroup'	=> '#icalendar_group',
				'description'	=> __('Choose yes to add a search field to the calendar filter dialog.','rhc'),
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			);
						
		$t[$i]->options[]=(object)array(
				'id'			=> 'cal_search_placeholder',
				'type' 			=> 'text',
				'label'			=> __('Search placeholder','rhc'),
				'default'		=> __('Search','rhc'),
				'el_properties' => array('class'=>'widefat'),
				'save_option'=>true,
				'load_option'=>true
			);
		*/		
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
			 			
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhc'),
				'class' => 'button-primary'
			);	
					
?>