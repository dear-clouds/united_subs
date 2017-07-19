<?php
/**
 */
 
?>
<div class="fc-dialog rhcalendar" style="display:none;">
	<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable ui-resizable">
	   <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
	      <span id="ui-dialog-title-dialog" class="ui-dialog-title">Calendarize</span>
	      <a class="ui-dialog-titlebar-close ui-corner-all" href="javascript:void(0);"><span class="ui-icon ui-icon-closethick">close</span></a>
	   </div>
	   <div class="ui-dialog-content ui-widget-content" id="dialog">
<!-- -->
					<ul class="category-tabs wp-tab-bar">
						<li class="tabs"><a rel=".tab-date">Date</a></li>
						<li class="tabs"><a rel=".tab-color">Color</a></li>
					</ul>
					<div class="tab-date tabs-panel">
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
					
					<div class="tab-color tabs-panel">
						<div class="fc-form-field">
							<label for="fc_color" class="left-label"><?php _e('Color','rhc')?></label>
							<input type='text' class='fc_color fc_input' name='fc_color' value='' />
							<div class="clear"></div>
						</div>
						<div class="fc-form-field">
							<label for="fc_text_color" class="left-label"><?php _e('Text color','rhc')?></label>
							<input type='text' class='fc_text_color fc_input' name='fc_text_color' value='' />
							<div class="clear"></div>
						</div>
					</div>		
<!-- -->
	   </div>
	</div>
</div>
