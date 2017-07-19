<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

$postinfo_boxes = array(
	'detailbox'	=> (object)array(
		'id'	=> 'detailbox',
		'label' => __('Event Details Box','rhc'),
		'type'	=> 'attachment',
		'enable_meta' => 'enable_postinfo_image',
		'enable_default' => '1',
		'attachment_id_meta_key' => 'rhc_dbox_image',
		'holder_class' => 'fe-image-holder'
	),
	'venuebox' => (object)array(
		'id'	=> 'venuebox',
		'label' => __('Venue Details Box','rhc'),
		'type'	=> 'shortcode',
		'enable_meta' => 'enable_venuebox_gmap',
		'enable_default' => '1',
		'shortcode' => "[venuemeta][venue_gmap canvas_width='500' canvas_height='300' zoom='{gzoom}' address=\"{gaddress}\" glat='{glat}' glon='{glon}' info_windows='{ginfo}'][/venuemeta]",
		'holder_class' => 'fe-map-holder'
	),
	'tooltipbox' 	=> (object)array(
		'id'		=> 'tooltipbox',
		'label'		=> __('Tooltip Details','rhc'),
		'holder_class' => 'fct-custom-details',
		'enable_meta' => false,
		'type'		=> 'tooltip'
	)	
	
);

$postinfo_boxes = apply_filters('postinfo_boxes',$postinfo_boxes);
?>