<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class rhc_general_calendar {
	function __construct(){
		$this->fc_intervals = array(
					''			=> __('Never(Not a recurring event)','rhc'),
					'1 DAY'		=> __('Every day','rhc'),
					'1 WEEK'	=> __('Every week','rhc'),
					'2 WEEK'	=> __('Every 2 weeks','rhc'),
					'1 MONTH'	=> __('Every month','rhc'),
					'1 YEAR'	=> __('Every year','rhc')
				);
	}
	
	function calendar_holder(){
		echo sprintf('<div id="calendarize" class="calendarize"></div>');
	}
	
	function calendar_form(){
?>
<div class="fc-dialog-holder">
	<div class="fc-dialog metabox-holder">
		<div class="fc-arrow-holder">
			<div class="fc-arrow"></div>
			<div class="fc-arrow-border"></div>
		</div>
		<div class="fc-widget postbox taxonomydiv">
			<h3 class="hndle"><?php echo sprintf(__('Calendarize %s','rhc'),'' )?></h3>
			<div class="inside">
				<div>&nbsp;</div>
				<div class="fc-dialog-content tabs-panel">
					<div class="fc-form-field">
						<label for="fc_allday" class="left-label"><?php _e('All-day','rhc')?></label>
						<input type="checkbox" class="fc_allday fc_input" name="fc_allday" value="1" />
						<div class="clear"></div>
					</div>
					<div class="fc-form-field">
						<div id="fc_start_fullcalendar_holder" class="fc_start_fullcalendar_holder postbox close-on-click" rel="fc_start">
							<div class="fc_start_fullcalendar"></div>
						</div>
						<label for="fc_start" class="left-label"><?php _e('Start','rhc')?></label>
						<div class="fc-date-time">
							<input type="text" class="fc_start fc_input" name="fc_start" value="" /><span class="fc-time-label"><?php _e('at','rhc')?></span>
							<input type="text" class="fc_start_time fc_input" name="fc_start_time" value="" placeholder="<?php _e('any time','rhc')?>" />					
						</div>
						<div class="clear"></div>
					</div>
					<div class="fc-form-field">
						<div id="fc_end_fullcalendar_holder" class="fc_end_fullcalendar_holder fc_start_fullcalendar_holder postbox close-on-click" rel="fc_end">
							<div class="fc_start_fullcalendar"></div>
						</div>
						<label for="fc_end" class="left-label"><?php _e('End','rhc')?></label>
						<div class="fc-date-time">
							<input type="text" class="fc_end fc_input" name="fc_end" value="" /><span class="fc-time-label"><?php _e('at','rhc')?></span>
							<input type="text" class="fc_end_time fc_input" name="fc_end_time" value="" placeholder="<?php _e('any time','rhc')?>" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="fc-form-field">
						<label for="fc_repeat" class="left-label"><?php _e('Repeat','rhc')?></label>
						<select name="fc_interval" class="fc_input fc_interval">
						<?php foreach($this->fc_intervals as $value => $label):?>
							<option value="<?php echo $value?>"><?php echo $label?></option>
						<?php endforeach;?>
						</select>
						<div class="clear"></div>
					</div>
					<div class="fc-form-field">
						<div id="fc_end_interval_fullcalendar_holder" class="fc_start_fullcalendar_holder fc_end_interval_fullcalendar_holder postbox close-on-click" rel="fc_end_interval">
							<div class="fc_start_fullcalendar"></div>
						</div>
						<label for="fc_end_interval" class="left-label"><?php _e('End repeat','rhc')?></label>
						<div class="fc-date-time">
							<input type="text" class="fc_end_interval fc_input" name="fc_end_interval" value="" />
						</div>
						<div class="clear"></div>
					</div>
				</div>		
			</div>
			<div class="fc-dialog-controls">
				<input type="button" class="button-primary fc-dg-ok" name="fc-dg-ok" value="<?php _e('Accept','rhc')?>" />
				<input type="button" class="button-secondary fc-dg-cancel" name="fc-dg-cancel" value="<?php _e('Cancel','rhc')?>" />
				<div class="fc-status">
					<img src="<?php echo admin_url('/images/wpspin_light.gif')?>" alt="" />
				</div>
				<div class="clear"></div>
			</div>		
		</div>
	</div>
</div>
<?php	
	}
}
?>