<?php

$vc_default_templates = array(
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Custom Event Details Box and Custom Venue Details Box (Image and Map Left)', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_01',
		'content'		=> sprintf('[vc_row foundry_padding="pb0"][vc_column][rhc_image][CONTENT][/vc_column][/vc_row][vc_row foundry_padding="pb0" css=".vc_custom_1446845753936{padding: 0px !important;background-color: #ffffff !important;border: 0px solid #ebebeb !important;border-radius: 1px !important;}"][vc_column][rhc_dbox][vc_row_inner css=".vc_custom_1446827691529{padding: 5px !important;background-color: #f9f9f9 !important;}"][vc_column_inner width="1/3"][rhc_image custom="rhc_dbox_image"][/vc_column_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_start label="%s"][rhc_end label="%s"][rhc_calendar_term][/vc_column_inner][vc_column_inner width="1/3"][rhc_organizer_loop][rhc_label label="%s"][rhc_organizer_term][rhc_organizer_meta_info_cell field="phone" label="%s" raw="0"][rhc_organizer_meta_info_cell field="email" label="%s" raw="0"][rhc_organizer_website][/rhc_organizer_loop][/vc_column_inner][/vc_row_inner][/rhc_dbox][/vc_column][/vc_row][vc_row css=".vc_custom_1446827723043{padding: 1px !important;background-color: #ffffff !important;border: 1px solid #ebebeb !important;border-radius: 1px !important;}"][vc_column][rhc_dbox][rhc_venue_loop][vc_row_inner css=".vc_custom_1446827746353{padding: 5px !important;background-color: #f9f9f9 !important;}"][vc_column_inner width="1/3"][rhc_gmap zoom="15"][/vc_column_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_venue_term][rhc_venue_meta_info_cell field="address" label="%s"][rhc_venue_meta_info_cell field="city" label="%s"][rhc_venue_meta_info_cell field="state" label="%s"][rhc_venue_meta_info_cell field="zip" label="%s"][/vc_column_inner][vc_column_inner width="1/3"][vc_empty_space height="28px"][rhc_venue_meta_info_cell field="country" label="%s" raw="0"][rhc_venue_meta_info_cell field="phone" label="%s"][rhc_venue_meta_info_cell field="email" label="%s"][rhc_venue_website][/vc_column_inner][/vc_row_inner][/rhc_venue_loop][/rhc_dbox][/vc_column][/vc_row]',
			__('Event Details', 'rhc'),
			__('Start Date &amp; Time', 'rhc'),
			__('End Date &amp; Time', 'rhc'),
			__('Organizer Details', 'rhc'),
			__('Organizer Phone', 'rhc'),
			__('Organizer Email', 'rhc'),
			__('Venue Details', 'rhc'),
			__('Address', 'rhc'),
			__('City', 'rhc'),
			__('State', 'rhc'),
			__('Zip Code', 'rhc'),
			__('Country', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc')
		)
	),
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Default Event Details Box and Default Venue Details Box', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_02',
		'content'		=> '[vc_row foundry_padding="pb0" css=".vc_custom_1446837314813{margin-top: 0px !important;margin-bottom: 4px !important;}"][vc_column][rhc_image][CONTENT][/vc_column][/vc_row][vc_row foundry_padding="pb0" css=".vc_custom_1446837340273{margin-top: 4px !important;margin-bottom: 4px !important;}"][vc_column][event_detailbox width="0"][/vc_column][/vc_row][vc_row css=".vc_custom_1446837355495{margin-top: 4px !important;margin-right: 0px !important;margin-bottom: 4px !important;margin-left: 0px !important;border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;padding-top: 1px !important;padding-right: 1px !important;padding-bottom: 1px !important;padding-left: 1px !important;background-color: #ffffff !important;border-left-color: #ebebeb !important;border-left-style: solid !important;border-right-color: #ebebeb !important;border-right-style: solid !important;border-top-color: #ebebeb !important;border-top-style: solid !important;border-bottom-color: #ebebeb !important;border-bottom-style: solid !important;border-radius: 1px !important;}"][vc_column][venue_detailbox width="0"][/vc_column][/vc_row]'
	),
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Custom Event Details Box and Custom Venue Details Box (Image and Map Left without Box)', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_03',
		'content'		=> sprintf('[vc_row][vc_column][rhc_image][vc_row_inner][vc_column_inner][CONTENT][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][rhc_image custom="rhc_dbox_image"][/vc_column_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_start][rhc_end][rhc_calendar_term][/vc_column_inner][vc_column_inner width="1/3"][rhc_organizer_loop][rhc_label label="%s"][rhc_organizer_term][rhc_organizer_meta_info_cell field="phone" label="%s"][rhc_organizer_meta_info_cell field="email" label="%s"][rhc_organizer_website][/rhc_organizer_loop][/vc_column_inner][/vc_row_inner][rhc_venue_loop][rhc_venue_loop][vc_row_inner][vc_column_inner width="1/3"][rhc_gmap zoom="15"][/vc_column_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_venue_term][rhc_venue_meta_info_cell field="address" label="%s"][rhc_venue_meta_info_cell field="city" label="%s"][rhc_venue_meta_info_cell field="state" label="%s"][rhc_venue_meta_info_cell field="zip" label="%s"][/vc_column_inner][vc_column_inner width="1/3"][vc_empty_space height="75px"][rhc_venue_meta_info_cell field="country" label="%s"][rhc_venue_meta_info_cell field="phone" label="%s"][rhc_venue_meta_info_cell field="email" label="%s"][rhc_venue_website][/vc_column_inner][/vc_row_inner][/rhc_venue_loop][/rhc_venue_loop][/vc_column][/vc_row]',
			__('Event Details', 'rhc'),
			__('Organizer Details', 'rhc'),
			__('Organizer Phone', 'rhc'),
			__('Organizer Email', 'rhc'),
			__('Venue Details', 'rhc'),
			__('Address', 'rhc'),
			__('City', 'rhc'),
			__('State', 'rhc'),
			__('Zip Code', 'rhc'),
			__('Country', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc')
		)
	),
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Custom Event Details Box and Custom Venue Details Box (Image and Map Right)', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_04',
		'content'		=> sprintf('[vc_row][vc_column][rhc_image][CONTENT][/vc_column][/vc_row][vc_row][vc_column][rhc_dbox][vc_row_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_start][rhc_end][rhc_calendar_term][/vc_column_inner][vc_column_inner width="1/3"][rhc_organizer_loop][rhc_label label="%s"][rhc_organizer_term][rhc_organizer_meta_info_cell field="phone" label="%s"][rhc_organizer_meta_info_cell field="email" label="%s"][rhc_organizer_website][/rhc_organizer_loop][/vc_column_inner][vc_column_inner width="1/3"][rhc_image custom="rhc_tooltip_image"][/vc_column_inner][/vc_row_inner][/rhc_dbox][/vc_column][/vc_row][vc_row][vc_column][rhc_dbox][rhc_venue_loop][vc_row_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_venue_term][rhc_venue_meta_info_cell field="address" label="%s"][rhc_venue_meta_info_cell field="city" label="%s"][rhc_venue_meta_info_cell field="state" label="%s"][rhc_venue_meta_info_cell field="zip" label="%s"][/vc_column_inner][vc_column_inner width="1/3"][vc_empty_space height="28px"][rhc_venue_meta_info_cell field="country" label="%s"][rhc_venue_meta_info_cell field="phone" label="%s"][rhc_venue_meta_info_cell field="email" label="%s"][rhc_venue_website][/vc_column_inner][vc_column_inner width="1/3"][rhc_gmap zoom="15"][/vc_column_inner][/vc_row_inner][/rhc_venue_loop][/rhc_dbox][/vc_column][/vc_row]',
			__('Event Details', 'rhc'),
			__('Organizer Details', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc'),
			__('Venue Details', 'rhc'),
			__('Address', 'rhc'),
			__('City', 'rhc'),
			__('State', 'rhc'),
			__('Zip Code', 'rhc'),
			__('Country', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc')
		)
	),
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Organizer Details Box (Image Left)', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_05',
		'content'		=> sprintf('[vc_row][vc_column][rhc_dbox][vc_row_inner][vc_column_inner width="1/4"][rhc_organizer_image][/vc_column_inner][vc_column_inner width="3/4"][rhc_label label="%s"][rhc_organizer_term][rhc_organizer_meta_info_cell field="phone" label="%s"][rhc_organizer_meta_info_cell field="email" label="%s"][rhc_organizer_website][/vc_column_inner][/vc_row_inner][/rhc_dbox][/vc_column][/vc_row]',
			__('Organizer Details', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc')
		)
	),
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Organizer Details Box (Image Right)', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_06',
		'content'		=> sprintf('[vc_row][vc_column][rhc_dbox][vc_row_inner][vc_column_inner width="2/3"][rhc_label label="%s"][rhc_organizer_term][rhc_organizer_meta_info_cell field="phone" label="%s"][rhc_organizer_meta_info_cell field="email" label="%s"][rhc_organizer_website][/vc_column_inner][vc_column_inner width="1/3"][rhc_organizer_image][/vc_column_inner][/vc_row_inner][/rhc_dbox][/vc_column][/vc_row]',
			__('Organizer Details', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc')
		)
	),
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Venue Details Box (Map Left)', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_07',
		'content'		=> sprintf('[vc_row][vc_column][rhc_dbox][rhc_venue_loop][vc_row_inner][vc_column_inner width="1/3"][rhc_gmap zoom="15"][/vc_column_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_venue_term][rhc_venue_meta_info_cell field="address" label="%s"][rhc_venue_meta_info_cell field="city" label="%s"][rhc_venue_meta_info_cell field="state" label="%s"][rhc_venue_meta_info_cell field="zip" label="%s"][/vc_column_inner][vc_column_inner width="1/3"][vc_empty_space height="28px"][rhc_venue_meta_info_cell field="country" label="%s"][rhc_venue_meta_info_cell field="phone" label="%s"][rhc_venue_meta_info_cell field="email" label="%s"][rhc_venue_website][/vc_column_inner][/vc_row_inner][/rhc_venue_loop][/rhc_dbox][/vc_column][/vc_row]',
			__('Venue Details', 'rhc'),
			__('Address', 'rhc'),
			__('City', 'rhc'),
			__('State', 'rhc'),
			__('Zip Code', 'rhc'),
			__('Country', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc')
		)
	),
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Venue Details Box (Map Right)', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_08',
		'content'		=> sprintf('[vc_row][vc_column][rhc_dbox][rhc_venue_loop][vc_row_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_venue_term][rhc_venue_meta_info_cell field="address" label="%s"][rhc_venue_meta_info_cell field="city" label="%s"][rhc_venue_meta_info_cell field="state" label="%s"][rhc_venue_meta_info_cell field="zip" label="%s"][/vc_column_inner][vc_column_inner width="1/3"][rhc_venue_meta_info_cell field="country" label="%s"][rhc_venue_meta_info_cell field="phone" label="%s"][rhc_venue_meta_info_cell field="email" label="%s"][rhc_venue_website][/vc_column_inner][vc_column_inner width="1/3"][rhc_gmap zoom="15"][/vc_column_inner][/vc_row_inner][/rhc_venue_loop][/rhc_dbox][/vc_column][/vc_row]',
			__('Venue Details', 'rhc'),
			__('Address', 'rhc'),
			__('City', 'rhc'),
			__('State', 'rhc'),
			__('Zip Code', 'rhc'),
			__('Country', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc')
		)
	),
	array(
		'name'			=> __('Calendarize it!').' - '.__( 'Custom Event Details Box and Custom Venue Details Box (Image and Map Right without Box)', 'rhc' ),
		'weight'		=> 10,
		//'image_path'	=> preg_replace( '/\s/', '%20', RHC_URL . 'images/custom_template_thumbnail.jpg' ),
		'custom_class'	=> 'rhc_vc_tpl_08',
		'content'		=> sprintf('[vc_row][vc_column][rhc_image][CONTENT][vc_row_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_start][rhc_end][rhc_calendar_term][/vc_column_inner][vc_column_inner width="1/3"][rhc_organizer_loop][rhc_label label="%s"][rhc_organizer_term][rhc_organizer_meta_info_cell field="phone" label="%s"][rhc_organizer_meta_info_cell field="email" label="%s"][rhc_organizer_website][/rhc_organizer_loop][/vc_column_inner][vc_column_inner width="1/3"][rhc_image custom="rhc_dbox_image"][/vc_column_inner][/vc_row_inner][rhc_venue_loop][vc_row_inner][vc_column_inner width="1/3"][rhc_label label="%s"][rhc_venue_term][rhc_venue_meta_info_cell field="address" label="%s"][rhc_venue_meta_info_cell field="city" label="%s"][rhc_venue_meta_info_cell field="state" label="%s"][rhc_venue_meta_info_cell field="zip" label="%s"][/vc_column_inner][vc_column_inner width="1/3"][vc_empty_space height="75px"][rhc_venue_meta_info_cell field="country" label="%s"][rhc_venue_meta_info_cell field="phone" label="%s"][rhc_venue_meta_info_cell field="email" label="%s"][rhc_venue_website][/vc_column_inner][vc_column_inner width="1/3"][rhc_gmap][/vc_column_inner][/vc_row_inner][/rhc_venue_loop][/vc_column][/vc_row]',
			__('Event Details', 'rhc'),
			__('Organizer Details', 'rhc'),
			__('Organizer Phone', 'rhc'),
			__('Organizer Email', 'rhc'),
			__('Venue Details', 'rhc'),
			__('Address', 'rhc'),
			__('City', 'rhc'),
			__('State', 'rhc'),
			__('Zip Code', 'rhc'),
			__('Country', 'rhc'),
			__('Phone', 'rhc'),
			__('Email', 'rhc')
		)
	)
);



?>