<div class="fc-event-list-container">
	<!-- you can replace with custom content to be displayed before the items -->
	<div class="fc-event-list-holder">
		<div class="fc-event-list-no-events fc-remove"><div class="fc-no-list-events-message"></div></div>
		<div class="fc-event-list-date fc-remove"><h3 class="fc-event-list-date-header"></h3></div>
		<div class="fc-event-list-item fc-remove">
			<div class="fc-event-list-content">
				<h4><a class="fc-event-link fc-event-list-title" href="{link}" target="_BLANK">{title}</a></h4>

				<div class="rhc fe-extrainfo-container elist-dbox fe-have-image-1" >
					<div class="fe-extrainfo-container2 row-fluid">
						<div class="fe-extrainfo-holder fe-extrainfo-col2 span8">
							<div class="row-fluid">
								<div class="span12 fe-cell-label dbox-title rhc-info-cell fe-cell-label">
									<label class="fe-extrainfo-label"><?php _e('Event details','rhc') ?></label>
								</div>
							</div>
							
							<div class="row-fluid">
								<div class="span6 fe-maincol fe-maincol-0">
									<div class="rhc-info-cell">
										<label class="fe-extrainfo-label"><?php _e('Start','rhc')?></label>
										<span class="fe-extrainfo-value fc-start">{fc-start}</span>&nbsp;
										<span class="fe-extrainfo-value fc-time"></span>
									</div>	
									
									<div class="rhc-info-cell">
										<label class="fe-extrainfo-label"><?php _e('End','rhc')?></label>
										<span class="fe-extrainfo-value fc-end">{fc-end}</span>&nbsp;
										<span class="fe-extrainfo-value fc-end-time"></span>
									</div>	
									
									<div class="rhc-info-cell">
										<label class="fe-extrainfo-label"><?php _e('Address','rhc')?></label>
										<span class="fe-extrainfo-value fc-event-term taxonomy-<?php echo RHC_VENUE?>-gaddress"></span>
									</div>	
								</div>
								<div class="span6 fe-maincol fe-maincol-1">						
									<div class="rhc-info-cell">
										<label class="fe-extrainfo-label"><?php _e('Venue','rhc')?></label>
										<span class="fe-extrainfo-value fc-event-term taxonomy-<?php echo RHC_VENUE?>">{venue}</span>
									</div>	
									<div class="rhc-info-cell">
										<label class="fe-extrainfo-label"><?php _e('Organizer','rhc')?></label>
										<span class="fe-extrainfo-value fc-event-term taxonomy-<?php echo RHC_ORGANIZER?>">{organizer}</span>
									</div>	
								</div>
							</div>
			
							<div class="fc-event-list-description dbox-description">{description}</div>
								
						</div>
						<div class="fe-image-holder span4">
							<div class="fc-event-list-featured-image">
								<a class="fc-event-link" href="{link}" target="_BLANK"><img class="fc-event-list-image" src="" /></a>
							</div>
						</div>
					</div>
				</div>				

			</div>
			<div class="fc-event-list-clear"></div>
			
		</div>
	</div>
</div>