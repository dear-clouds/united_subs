<?php

/**
 * 
 * I control what template is used.
 * @version $Id$
 * @copyright 2003 
 **/

if($this && 'rhc_template_frontend'==get_class($this)):
		extract(shortcode_atts(array(
			'default' 		=> '',
			'event'			=> '',
			'venue'			=> '',
			'calendar'		=> ''
		), $atts));
		
		$sidebar = '';
		$o = get_queried_object();
		if( ''!=$event && $o->post_type==RHC_EVENTS ){
			$sidebar = $event;
		}else if( ''!=$calendar && $this->is_calendar() ){
			$sidebar = $calendar;	
		}else if( ''!=$venue && @$o->taxonomy==RHC_VENUE){
			$sidebar = $venue;
		}else{
			$sidebar = $default;
		}

		if('false'==$sidebar){
		
		}else{
			ob_start();
			if(''!=$sidebar){
				get_sidebar($sidebar);	
			}else{
				get_sidebar();
			}
			$output = ob_get_contents();
			ob_end_clean();		
		}
endif;
?>