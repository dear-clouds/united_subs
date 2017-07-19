<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
		$fields = array(
			(object)array(
				'id'		=>	'content',
				'label'		=> 	__('HTML Description','rhc'),
				'description'=> __('The description of the organizer, will be used in the organizer page content.','rhc'),
				'type'		=> 'callback',
				'callback'	=> 'organizer_html_description_input'
			),		
			(object)array(
				'id'	=> 'contact_details',
				'label'	=> __('Contact Details','rhc'),
				'type'	=> 'subtitle'
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
				'label'	=> __('Website','rhc')
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
				'description'=> __('Url to an image to display at the organizer category page', 'rhc')
			)
		);	

?>