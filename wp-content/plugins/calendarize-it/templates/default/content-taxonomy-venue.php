[venuemeta term='<?php echo $term->slug?>']
<div class="rhc fe-extrainfo-container venue-box fe-have-image-0" style="width:100%;">
	<div class="fe-extrainfo-container2 row-fluid">
		<div class="fe-extrainfo-holder fe-extrainfo-col2 span6">
	    	<div class="rhc-venuebox-row rhc-venuebox-title rhc-info-cell fe-cell-label">
				<label class="fe-extrainfo-label"><?php _e('Venue details','rhc')?></label>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-name rhc-info-cell">
				<label class="fe-extrainfo-label"><?php _e('Name:','rhc')?></label>
				<span class="fe-extrainfo-value">{name}</span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-gaddress rhc-info-cell">
				<label class="fe-extrainfo-label"><?php _e('Address:','rhc')?></label>
				<span class="fe-extrainfo-value">{gaddress}</span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-phone rhc-info-cell">
				<label class="fe-extrainfo-label"><?php _e('Phone:','rhc')?></label>
				<span class="fe-extrainfo-value">{phone}</span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-email rhc-info-cell">
				<label class="fe-extrainfo-label"><?php _e('Email:','rhc')?></label>
				<span class="fe-extrainfo-value"><a href="mailto:{email}">{email}</a></span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-website rhc-info-cell">
				<label class="fe-extrainfo-label"><?php _e('Website:','rhc')?></label>
				<span class="fe-extrainfo-value"><a {website_nofollow} href="{website}">{websitelabel,website}</a></span>
			</div>
			<div class="rhc-venuebox-row rhc-venuebox-empty-empty-gaddress rhc-info-cell">
				<span class="fe-extrainfo-value"><a target="_BLANK" href="http://maps.google.com/?q=<?php echo urlencode(get_term_meta($term->term_id,'gaddress',true))?>"><?php _e('Google address','rhc')?></a></span>
			</div>			
		</div>
		<div class="fe-map-holder span6">[venue_gmap canvas_width='500' canvas_height='300' zoom='{gzoom}' address="{gaddress}" glat='{glat}' glon='{glon}' info_windows='{ginfo}']</div>
	</div>
</div>[/venuemeta]<div class="venue-page-description"><?php echo get_the_tax_content();?> </div>[calendarizeit feed="<?php echo $feed?>" defaultview="rhc_event" taxonomy="<?php echo $taxonomy ?>" terms="<?php echo $term->slug?>" ]