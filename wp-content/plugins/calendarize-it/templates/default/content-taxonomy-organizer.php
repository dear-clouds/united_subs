[organizermeta term='<?php echo $term->slug?>']
<div class="rhc fe-extrainfo-container organizer-box fe-have-image-1" style="width:100%;">
	<div class="fe-extrainfo-container2 row-fluid">
		<div class="fe-extrainfo-holder fe-extrainfo-col2 span6">
	    	<div class="rhc-venuebox-row rhc-venuebox-title rhc-info-cell fe-cell-label">
				<label class="fe-extrainfo-label">{name}</label>
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
				<span class="fe-extrainfo-value"><a href="{website}">{websitelabel,website}</a></span>
			</div>
		
		</div>
		<div class="fe-image-holder span6">
			[tax_detail field="image"]
		</div>
	</div>
</div>[/organizermeta] <div class="organizer-page-description"><?php echo get_the_tax_content();?> </div> [calendarizeit feed="<?php echo $feed?>" defaultview="rhc_event" taxonomy="<?php echo $taxonomy ?>" terms="<?php echo $term->slug?>"]
