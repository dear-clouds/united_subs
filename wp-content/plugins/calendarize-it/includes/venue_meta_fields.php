<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
 		require 'iso3166_countries.php';
	
		$fields = array(
			(object)array(
				'id'		=>	'content',
				'label'		=> 	__('HTML Description','rhc'),
				'description'=> __('The description of the venue, will be used in the venue page content.','rhc'),
				'type'		=> 'callback',
				'callback'	=> 'venue_html_description_input'
			),
			(object)array(
				'id'	=>	'address',
				'label'	=> 	__('Address','rhc'),
				'description'=> __('Street address of this venue','rhc')
			),
			(object)array(
				'id'	=> 'city',
				'label'	=> __('City','rhc')
			),
			(object)array(
				'id'	=> 'state',
				'label'	=> __('State/Province/Other','rhc')
			),
			(object)array(
				'id'	=> 'zip',
				'label'	=> __('Postal code','rhc')
			),
			
			(object)array(
				'id'			=> 'iso3166_country_code',
				'label'			=> __('Country ISO3166 code','rhc'),
				'type'  		=> 'select',
				'empty_option'	=> __('--choose--','rhc'),
				'options'		=> $iso3166_countries,
				'format_label'	=> '%2$s ( %1$s )',
				'el_properties' => array( 'onchange' => "javascript:jQuery('#country').val( jQuery(this).find(':selected').attr('data-label_no_format') ).trigger('change'); " )
			),			

			(object)array(
				'id'	=> 'country',
				'label'	=> __('Country','rhc')
			),

			(object)array(
				'id'			=>'sub_gmap',
				'label'			=> __('Details for google map','rhc'),
				'type'			=> 'subtitle'
			),
			(object)array(
				'id'	=> 'gaddress',
				'label'	=> __('Google address','rhc')
			),
			(object)array(
				'id'	=> 'glat',
				'label'	=> __('Latitude','rhc'),
				'description'=> __('Optional, if not provided will attempt to use address','rhc')
			),
			(object)array(
				'id'	=> 'glon',
				'label'	=> __('Longitud','rhc'),
				'description'=> __('Optional, if not provided will attempt to use address','rhc')
			),
			(object)array(
				'id'	=> 'gzoom',
				'label'	=> __('Zoom','rhc'),
				'description'=> __('Optional, specify the google map zoom value (default: 13)','rhc')
			),
			(object)array(
				'id'	=> 'ginfo',
				'label'	=> __('Text for info windows','rhc'),
				'type'	=> 'textarea'
			),
			(object)array(
				'id'	=> 'sub_contact',
				'label'			=> __('Contact Details','rhc'),
				'type'			=> 'subtitle'
			),
			(object)array(
				'id'	=> 'phone',
				'label'	=> __('Phone','rhc')
			),
			(object)array(
				'id'	=> 'email',
				'label'	=> __('Email','rhc')
			),
			(object)array(
				'id'	=> 'website',
				'label'	=> __('Website url','rhc')
			),
			(object)array(
				'id'	=> 'websitelabel',
				'label'	=> __('Website label','rhc'),
				'description'=> __('Optional, display this label in the link instead of the site url.','rhc')
			),
			(object)array(
				'id'			=> 'website_nofollow',
				'label'			=> __('Check to add rel="nofollow" to the website link','rhc'),
				'type'			=> 'checkbox',
				'option_value'	=> 'rel="nofollow"'
			),
			(object)array(
				'id'	=> 'image',
				'label'	=> __('Image','rhc'),
				'description'=> __('Url to an image to display at the venue category page', 'rhc')
			)/*,
			(object)array(
				'label'			=> __('Custom template','rhc'),
				'type'			=> 'subtitle'
			),
			(object)array(
				'id'	=> 'template_page_id',
				'label'	=> __('Template page id (optional)','rhc'),
				'description'=> __('Specify the id of a page that you want to use as model for this venue', 'rhc')
			)		
			*/
			/* capacity info is not used in this version.
			,
			(object)array(
				'label'			=> __('Information','rhc'),
				'type'			=> 'subtitle'
			),
			(object)array(
				'id'	=> 'capacity',
				'label'	=> __('Capacity','rhc')
			)
			*/
		);		

?>