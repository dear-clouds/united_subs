
	<div class="venue-top-info">
		<div class="venue-small-map">[tax_detail field="map"]</div>
        <div class="venue-name">[tax_detail field="title"]</div>
		<div class="venue-details-holder">
			<div class="venue-image-holder">[tax_detail field="image"]</div>
			<div class="venue-defails">
            	[tax_detail field="gaddress" label="<?php _e('Address','rhl')?>"]
				[tax_detail field="phone" label="<?php _e('Telephone','rhl')?>"]
				[tax_detail field="email" label="<?php _e('Email','rhl')?>"]
				[tax_detail field="website" label="<?php _e('Website','rhl')?>"]
				<div class="venue-description">[tax_detail field="content"]</div>
			</div>
           
		</div>
		<div class="clear"></div>
	</div>
	[calendarizeit feed="<?php echo $feed?>" defaultview="rhc_event" taxonomy="<?php echo $taxonomy ?>" terms="<?php echo $term->slug?>"]
