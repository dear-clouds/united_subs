<?php
/**
 */
 
?>
<div class="fc-filters-dialog-holder fc-display-none" style="display:none;">
	<div class="fc-filters-dialog">
		<div class="fbd-main-holder">
			<div class="fbd-head">
				<div class="fbd-close-tooltip rhc-close-icon"><a title="<?php _e('Close dialog','rhc')?>" href="javascript:void(0);"></a></div>			
			</div>
			<div class="fbd-body">
				<?php if('1'==$search_enable): ?>
				<div class="fbd-search-holder">
					<input type="text" class="fbd-search" value="" name="s" placeholder="<?php echo $search_placeholder?>" />
				</div>
				<?php endif; ?>
				<div class="fbd-dialog-content">
<?php echo $this->calendars_form_tabs($post_type, $tax_query);?>			
				</div>
				<div class="fbd-dialog-controls">
					<input type="button" class="fbd-button-secondary fbd-dg-remove" name="fbd-dg-remove" value="<?php _e('Show all','rhc')?>" />
					<input type="button" class="fbd-button fbd-button-primary fbd-dg-apply" name="fbd-dg-apply" value="<?php _e('Apply filters','rhc')?>" />
					<div class="fbd-status">
						<img src="<?php echo admin_url('/images/wpspin_light.gif')?>" alt="" />
					</div>
					<div class="fbd-clear"></div>
				</div>
				<div class="fbd-clear"></div>
			</div>
			<div class="fbd-clear"></div>
		</div>
	</div>
</div>
