<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
 	global $rhc_plugin;
	/* used by class.rhc_post_info_metabox.php */
	$quick_icons = array(
		(object)array(
			'id'	=> 'label_icons',
			'label' => __('Custom fields','rhc'),
			'items' => array(
				new quick_icon_item(array(
					'label'	=> __('Subtitle','rhc'),//label in bar
					'post_extrainfo_type'			=> 'label',
					'post_extrainfo_label'			=> __('My label','rhc')	//label of field				
				)),	
				new quick_icon_item(array(
					'label'	=> __('Custom','rhc'),
					'post_extrainfo_type'			=> 'custom',
					'post_extrainfo_label'			=> __('My label','rhc'),
					'post_extrainfo_value'			=> __('My custom value','rhc')					
				))		
			)
		),
		(object)array(
			'id'	=> 'event_info_icons',
			'label'	=> __('Event','rhc'),
			'items'	=> array(
				new quick_icon_item(array(
					'label'	=> __('Start date','rhc'),
					'post_extrainfo_type'			=> 'postmeta',
					'post_extrainfo_label'			=> __('Start date','rhc'),
					'post_extrainfo_taxonomy'		=> '',
					'post_extrainfo_taxonomymeta'	=> '',
					'post_extrainfo_postmeta'		=> 'fc_start'						
				)),	
				new quick_icon_item(array(
					'label'	=> __('Start time','rhc'),
					'post_extrainfo_type'			=> 'postmeta',
					'post_extrainfo_label'			=> __('Start time','rhc'),
					'post_extrainfo_taxonomy'		=> '',
					'post_extrainfo_taxonomymeta'	=> '',
					'post_extrainfo_postmeta'		=> 'fc_start_time'						
				)),	
				new quick_icon_item(array(
					'label'	=> __('Start datetime','rhc'),
					'post_extrainfo_type'			=> 'postmeta',
					'post_extrainfo_label'			=> __('Start date','rhc'),
					'post_extrainfo_taxonomy'		=> '',
					'post_extrainfo_taxonomymeta'	=> '',
					'post_extrainfo_postmeta'		=> 'fc_start_datetime'						
				)),	
				new quick_icon_item(array(
					'label'	=> __('End date','rhc'),
					'post_extrainfo_type'			=> 'postmeta',
					'post_extrainfo_label'			=> __('End date','rhc'),
					'post_extrainfo_taxonomy'		=> '',
					'post_extrainfo_taxonomymeta'	=> '',
					'post_extrainfo_postmeta'		=> 'fc_end'
				)),	
				new quick_icon_item(array(
					'label'	=> __('End time','rhc'),
					'post_extrainfo_type'			=> 'postmeta',
					'post_extrainfo_label'			=> __('End time','rhc'),
					'post_extrainfo_taxonomy'		=> '',
					'post_extrainfo_taxonomymeta'	=> '',
					'post_extrainfo_postmeta'		=> 'fc_end_time'
				)),	
				new quick_icon_item(array(
					'label'	=> __('End datetime','rhc'),
					'post_extrainfo_type'			=> 'postmeta',
					'post_extrainfo_label'			=> __('End date','rhc'),
					'post_extrainfo_taxonomy'		=> '',
					'post_extrainfo_taxonomymeta'	=> '',
					'post_extrainfo_postmeta'		=> 'fc_end_datetime'
				)),	
				new quick_icon_item(array(
					'label'	=> __('Title','rhc'),
					'post_extrainfo_type'			=> 'postmeta',
					'post_extrainfo_label'			=> '',
					'post_extrainfo_taxonomy'		=> '',
					'post_extrainfo_taxonomymeta'	=> '',
					'post_extrainfo_postmeta'		=> 'rhc_post_title'
				))	,	
				new quick_icon_item(array(
					'label'	=> __('Excerpt','rhc'),
					'post_extrainfo_type'			=> 'postmeta',
					'post_extrainfo_label'			=> __('Excerpt','rhc'),
					'post_extrainfo_taxonomy'		=> '',
					'post_extrainfo_taxonomymeta'	=> '',
					'post_extrainfo_postmeta'		=> 'rhc_excerpt'
				))	
			)
		),
		(object)array(
			'id'	=> 'venues',
			'label' => __('Venue','rhc'),
			'items' => array(
				new quick_icon_item(array(
					'label'							=> __('Venue','rhc'),
					'post_extrainfo_type'			=> 'taxonomy',
					'post_extrainfo_label'			=> __('Venue','rhc'),
					'post_extrainfo_taxonomy'		=> RHC_VENUE					
				)),	
				new quick_icon_item(array(
					'label'							=> __('Phone','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Phone','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'phone|'.RHC_VENUE					
				)),	
				new quick_icon_item(array(
					'label'							=> __('Email','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Email','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'email|'.RHC_VENUE					
				)),
				new quick_icon_item(array(
					'label'							=> __('Website','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Website','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'website|'.RHC_VENUE					
				)),	
				new quick_icon_item(array(
					'label'							=> __('Address','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Address','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'address|'.RHC_VENUE					
				)),	
				new quick_icon_item(array(
					'label'							=> __('City','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('City','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'city|'.RHC_VENUE					
				))	,	
				new quick_icon_item(array(
					'label'							=> __('State','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('State','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'state|'.RHC_VENUE					
				))	,	
				new quick_icon_item(array(
					'label'							=> __('Postal code','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Postal code','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'zip|'.RHC_VENUE					
				)),	
				new quick_icon_item(array(
					'label'							=> __('Country','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Country','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'country|'.RHC_VENUE					
				))	
			)
		),
		(object)array(
			'id'	=> 'organizers',
			'label' => __('Organizer','rhc'),
			'items' => array(
				new quick_icon_item(array(
					'label'							=> __('Organizer','rhc'),
					'post_extrainfo_type'			=> 'taxonomy',
					'post_extrainfo_label'			=> __('Organizer','rhc'),
					'post_extrainfo_taxonomy'		=> RHC_ORGANIZER				
				)),
				new quick_icon_item(array(
					'label'							=> __('Phone','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Phone','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'phone|'.RHC_ORGANIZER					
				)),	
				new quick_icon_item(array(
					'label'							=> __('Email','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Email','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'email|'.RHC_ORGANIZER					
				)),
				new quick_icon_item(array(
					'label'							=> __('Website','rhc'),
					'post_extrainfo_type'			=> 'taxonomymeta',
					'post_extrainfo_label'			=> __('Website','rhc'),
					'post_extrainfo_taxonomymeta'	=> 'website|'.RHC_ORGANIZER					
				))			
			)
		),
		(object)array(
			'id'	=> 'calendars',
			'label' => __('Calendar','rhc'),
			'items' => array(
				new quick_icon_item(array(
					'label'							=> __('Calendar','rhc'),
					'post_extrainfo_type'			=> 'taxonomy',
					'post_extrainfo_label'			=> __('Calendar','rhc'),
					'post_extrainfo_taxonomy'		=> RHC_CALENDAR				
				))		
			)
		),
		(object)array(
			'id'	=> 'share',
			'label' => __('Share','rhc'),
			'items' => array(
				new quick_icon_item(array(
					'label'							=> __('iCal feed','rhc'),
					'post_extrainfo_type'			=> 'custom',
					'post_extrainfo_label'			=> '',
					'post_extrainfo_value'			=> '[btn_ical_feed]'				
				))		
			)
		)		

	);
?>