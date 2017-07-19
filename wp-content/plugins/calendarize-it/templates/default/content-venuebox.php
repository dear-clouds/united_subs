[venuemeta]
<div class="rhc fe-extrainfo-container single-event-venue-box fe-have-image-0" style="width:100%;">
	<div class="fe-extrainfo-container2 row-fluid">
		<div class="fe-extrainfo-holder fe-extrainfo-col2 span6">
	    	<div class="rhc-venuebox-row rhc-venuebox-title">
				<span><?php _e('Venue details','rhc')?></span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-name">
				<label><?php _e('Name:','rhc')?></label>
				<span>{name}</span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-gaddress">
				<label><?php _e('Address:','rhc')?></label>
				<span>{gaddress}</span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-phone">
				<label><?php _e('Phone:','rhc')?></label>
				<span>{phone}</span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-email">
				<label><?php _e('Email:','rhc')?></label>
				<span>{email}</span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-website">
				<label><?php _e('Website:','rhc')?></label>
				<span>{website}</span>
			</div>
		</div>
		<div class="fe-map-holder span6">[venue_gmap canvas_width='500' canvas_height='300' zoom='{gzoom}' address="{gaddress}" glat='{glat}' glon='{glon}' info_windows='{ginfo}']</div>
	</div>
</div>
[/venuemeta]