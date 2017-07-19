<?php
/**
 */
 
?>
<div id="fct-item-template" style="display:none;" class="fct-tooltip">
	<div class="fct-arrow-holder">
		<div class="fct-arrow"></div>
		<div class="fct-arrow-border"></div>		
	</div>
	<div class="fct-main">
		<div class="fct-header">
			<div class="fc-close-tooltip"><a title="<?php _e('Close','rhc')?>" href="javascript:void(0);"></a></div>
			<div class="fc-title"></div>
		</div>
		<div class="fct-body">
			<div class="fct-dbox">
				<div class="fc-term-<?php echo RHC_VENUE?>-gaddress fc-term-venue-gaddress"><label><?php _e('Address','rhc')?></label></div>
				<div class="fc-start"><label class="tooltip-fc-start"><?php _e('Start','rhc')?></label></div>
				<div class="fc-end"><label class="tooltip-fc-end"><?php _e('End','rhc')?></label></div>
				<div class="fc-hide fc-tax-<?php echo RHC_VENUE?>"><label class="tax-label"></label></div>			
			</div>
			<div class="fc-description"></div>
		</div>
		<div class="fct-footer">
			<div class="fc-social"></div>
           <div class="fc-image"></div>
		</div>	
	</div>
</div>
