<style>
@import url(<?php echo $this->plugin_url . 'assets/lib/linecon/linecon.min.css'; ?>);
</style>
<table class="gwa-table" data-id="sc-fields" data-shortcode="<i{atts}></i>" data-parent-id="shortcode" data-parent-value="linecon">
<tr>
	<th><label><?php _e( 'Color', 'go_pricing_textdomain' ); ?></label></th>
	<td><label><div class="gwa-colorpicker gwa-colorpicker-inline" tabindex="0"><input type="hidden" name="linecon-color" data-attr="style" data-value="color:{value};" value=""><span class="gwa-cp-picker"><span></span></span><span class="gwa-cp-label">&nbsp;</span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $col_data['main-color'] ) ? $col_data['main-color'] : '' ); ?>"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></label></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Color of icon (optional).', 'go_pricing_textdomain' ); ?></p></td>									
</tr>
<tr>
	<th><label><?php _e( 'Size', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
	<td><input type="text" name="linecon-size" data-attr="style" data-value="font-size:{value}px;"  data-type="int"></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font size of the icon. (optional).', 'go_pricing_textdomain' ); ?></p></td>									
</tr>
<tr>
	<th><label><?php _e( 'Width', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
	<td><input type="text" name="fa-width" data-attr="style" data-value="width:{value}px;"  data-type="int"></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Width of the icon. Leave blank if want to specify auto width (optional).', 'go_pricing_textdomain' ); ?></p></td>									
</tr>
<tr>
	<th><label><?php _e( 'Aligment', 'go_pricing_textdomain' ); ?></label></th>
	<td>
		<select name="linecon-alignment" data-attr="style" data-value="text-align:{value};">                                
			<option value=""><?php _e( 'Left', 'go_pricing_textdomain' ); ?></option>
			<option value="center"><?php _e( 'Center', 'go_pricing_textdomain' ); ?></option>
			<option value="right"><?php _e( 'Right', 'go_pricing_textdomain' ); ?></option>
		</select>	
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Alignment of the icon. You can set it when fixed with is used (optional).', 'go_pricing_textdomain' ); ?></p></td>									
</tr>
<tr class="gwa-row-fullwidth">
	<th><label><?php _e( 'Icon', 'go_pricing_textdomain' ); ?></label></th>
	<td>
	<div class="gwa-icon-picker">
		<div class="gwa-icon-picker-header">
			<div class="gwa-icon-picker-selected gwa-clearfix">
				<a href="#" class="gwa-icon-picker-icon" tabindex="-1" data-action="ip-bg-switch"></a>
				<input type="hidden" name="linecon-icon" data-attr="class">
			</div>
			<div class="gwa-icon-picker-search">
				<div class="gwa-input-btn gwa-search-input" data-action="ip-search"><input type="text" placeholder="<?php esc_attr_e( 'e.g. \'Icon Name\'', 'go_pricing_textdomain' ); ?>"><a href="#" tabindex="-1" title="<?php esc_attr_e( 'Search', 'go_pricing_textdomain' ); ?>"><i class="fa fa-search"></i></a><span class="gwa-info"></span></div>
			</div>		
		</div>
		<div class="gwa-icon-picker-content gwa-clearfix">
			<a href="#" class="gwa-icon-picker-icon gwa-current" data-action="ip-select-blank" tabindex="0" title="<?php esc_attr_e( 'None', 'go_pricing_textdomain' ); ?>"><i class="fa fa-ban"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-heart2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-cloud2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-star"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-tv2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-sound"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-video"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-trash"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-user2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-key3"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-search2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-settings"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-camera2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-tag"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-lock2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-bulb"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-pen2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-diamond"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-display2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-location3"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-eye2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-bubble3"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-stack2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-cup"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-phone2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-news"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-mail5"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-like"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-photo"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-note"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-clock3"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-paperplane"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-params"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-banknote"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-data"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-music2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-megaphone"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-study"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-lab2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-food"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-t-shirt"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-fire2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-clip"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-shop"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-calendar2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-wallet"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-vynil"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-truck2"></i></a> 			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="linecon-world"></i></a>
		</div>
	</div>		
	</td>
</tr>