<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
 
if( defined('RHP_PATH') ){
	global $rhp_plugin;
	$settings = array(
		'enable_facebook'	=> $rhp_plugin->get_option('enable_facebook','1',true),
		'enable_twitter'	=> $rhp_plugin->get_option('enable_twitter','1',true),
		'enable_linkedin'	=> $rhp_plugin->get_option('enable_linkedin','1',true),
		'enable_google'		=> $rhp_plugin->get_option('enable_google','1',true)		
	);
}else{
	$settings = array(
		'enable_facebook'	=> false,
		'enable_twitter'	=> false,
		'enable_linkedin'	=> false,
		'enable_google'		=> false		
	);
} 

global $rhc_plugin;
$time_format = $rhc_plugin->get_option( 'cal_eventlistexttimeformat', 'h(:mm)tt', true );
$time_format = empty( $time_format ) ? 'h(:mm)tt' : $time_format ;



?>
<div class="rhc_calendar_widget_day_click">
	<div class="rhc_calendar_widget_day_click_holder"></div>
	<div class="rhc_calendar_widget_day_click_template" style="display:none;">
		<div class="rhc-widget-event-list map-close">
			<div class="rhc-widget-event-list-head">
		        <div class="rhc-widget-event-list-date">
                   <div class="rhc-dayname rhc_date rhc_start" data-fc_field="start" data-fc_date_format="dddd"></div>
		           <div class="rhc-day rhc_date rhc_start" data-fc_field="start" data-fc_date_format="d"></div>
		        </div>
                <div class="rhc-title-date-venue">
                	<div class="rhc_title"></div>
                    <div class="rhc-time-location">
                        <div class="rhc-event-time"><span class="rhc-icon-time rhc_start_time rhc_date" data-fc_field="start" data-fc_date_format="<?php echo $time_format?>"></span></div>
                        <div class="rhc-widget-taxonomy">
                            <div class="taxonomy-venue"></div>
                        </div>
                    </div>
                </div>
		    </div>
			<div class="rhc-widget-event-list-body">
            	 
	        	  <div class="rhc-details">
	                <div class="rhc_description"></div>
                    <div class="rhc-map-social-buttons">
                    	<div class="rhc-left-buttons">
                            <a href="javascript:void(0);" class="rhc-icon-map" title="<?php _e('View Google Map','rhc')?>"></a>
                            <a href="javascript:void(0);" class="rhc-icon-ical" title="<?php _e('Add to your calendar','rhc')?>"></a>
                        </div>
                        <div class="rhc-right-buttons">
							<?php if( $settings['enable_facebook'] ): ?>
                            <a href="javascript:void(0);" class="rhc-icon-facebook" title="<?php _e('Share on Facebook','rhc')?>"></a>							
							<?php endif; ?>
							
							<?php if( $settings['enable_twitter'] ): ?>
                            <a href="javascript:void(0);" class="rhc-icon-twitter" title="<?php _e('Share on Twitter','rhc')?>"></a>							
							<?php endif; ?>
							<?php if( $settings['enable_linkedin'] ): ?>
                            <a href="javascript:void(0);" class="rhc-icon-linkedin" title="<?php _e('Share on LinkedIn','rhc')?>"></a>							
							<?php endif; ?>
							<?php if( $settings['enable_google'] ): ?>
                            <a href="javascript:void(0);" class="rhc-icon-googleplus" title="<?php _e('Share on Google+','rhc')?>"></a>							
							<?php endif; ?>

                        </div>
						
                    </div>
                    <div class="rhc-map-view" data-size="300x150" data-zoom="13" data-maptype="roadmap" data-ratio="4:3"></div>
	              </div>
	           <div class="rhc_featured_image"></div>			
			</div>
		</div>
	</div>
</div>