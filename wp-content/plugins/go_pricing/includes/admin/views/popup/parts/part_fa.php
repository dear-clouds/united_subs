<table class="gwa-table" data-id="sc-fields" data-shortcode="<i{atts}></i>" data-parent-id="shortcode" data-parent-value="fa">
<tr>
	<th><label><?php _e( 'Color', 'go_pricing_textdomain' ); ?></label></th>
	<td><label><div class="gwa-colorpicker gwa-colorpicker-inline" tabindex="0"><input type="hidden" name="fa-color" data-attr="style" data-value="color:{value};" value=""><span class="gwa-cp-picker"><span></span></span><span class="gwa-cp-label">&nbsp;</span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $col_data['main-color'] ) ? $col_data['main-color'] : '' ); ?>"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></label></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Color of icon (optional).', 'go_pricing_textdomain' ); ?></p></td>									
</tr>
<tr>
	<th><label><?php _e( 'Size', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
	<td><input type="text" name="fa-size" data-attr="style" data-value="font-size:{value}px;"  data-type="int"></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font size of the icon (optional).', 'go_pricing_textdomain' ); ?></p></td>									
</tr>
<tr>
	<th><label><?php _e( 'Width', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
	<td><input type="text" name="fa-width" data-attr="style" data-value="width:{value}px;"  data-type="int"></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Width of the icon. Leave blank if want to specify auto width (optional).', 'go_pricing_textdomain' ); ?></p></td>									
</tr>
<tr>
	<th><label><?php _e( 'Aligment', 'go_pricing_textdomain' ); ?></label></th>
	<td>
		<select name="fa-alignment" data-attr="style" data-value="text-align:{value};">                                
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
				<input type="hidden" name="fa-icon" data-attr="class">
			</div>
			<div class="gwa-icon-picker-search">
				<div class="gwa-input-btn gwa-search-input" data-action="ip-search"><input type="text" placeholder="<?php esc_attr_e( 'e.g. \'Icon Name\'', 'go_pricing_textdomain' ); ?>"><a href="#" tabindex="-1" title="<?php esc_attr_e( 'Search', 'go_pricing_textdomain' ); ?>"><i class="fa fa-search"></i></a><span class="gwa-info"></span></div>
				<select data-action="ip-filter" class="gwa-w120 gwa-ml10">                                
					<option value=""><?php _e( 'All versions', 'go_pricing_textdomain' ); ?></option>
					<option value="4.0">4.0 (15)</option>
					<option value="4.1">4.1 (92)</option>
					<option value="4.2">4.2 (43)</option>
					<option value="4.3">4.3 (42)</option>
					<option value="4.4">4.4 (78)</option>
					<option value="4.5">4.5 (20)</option>																																	
			    </select>
			</div>			
		</div>
		<div class="gwa-icon-picker-content gwa-clearfix">
			<a href="#" class="gwa-icon-picker-icon gwa-current" data-action="ip-select-blank" tabindex="0" title="<?php esc_attr_e( 'None', 'go_pricing_textdomain' ); ?>"><i class="fa fa-ban"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-500px" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-adjust"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-adn"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-align-center"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-align-justify"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-align-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-align-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-amazon" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ambulance"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-anchor"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-android"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angellist" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angle-double-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angle-double-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angle-double-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angle-double-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angle-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angle-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-angle-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-apple"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-archive"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-area-chart" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-circle-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-circle-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-circle-o-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-circle-o-left" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-circle-o-right" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-circle-o-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-circle-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-circle-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrow-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrows"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrows-alt"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrows-h"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-arrows-v"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-asterisk"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-at" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-automobile" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-backward"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-balance-scale" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ban"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bank" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bar-chart"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bar-chart-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-barcode"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bars"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-0" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-1" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-2" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-3" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-4" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-empty" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-full" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-half" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-quarter" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-battery-three-quarters" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bed" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-beer"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-behance" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-behance-square" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bell"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bell-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bell-slash" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bell-slash-o" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bicycle" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-binoculars" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-birthday-cake" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bitbucket"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bitbucket-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bitcoin"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-black-tie" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bluetooth" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bluetooth-b" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bold"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bolt"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bomb" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-book"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bookmark"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bookmark-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-briefcase"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-btc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bug"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-building" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-building-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bullhorn"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bullseye"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-bus" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-buysellads" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cab" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-calculator" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-calendar"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-calendar-check-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-calendar-minus-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-calendar-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-calendar-plus-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-calendar-times-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-camera"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-camera-retro"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-car" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-caret-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-caret-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-caret-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-caret-square-o-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-caret-square-o-left" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-caret-square-o-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-caret-square-o-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-caret-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cart-arrow-down" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cart-plus" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc-amex" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc-diners-club" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc-discover" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc-jcb" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc-mastercard" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc-paypal" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc-stripe" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cc-visa" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-certificate"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chain"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chain-broken"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-check"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-check-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-check-circle-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-check-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-check-square-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chevron-circle-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chevron-circle-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chevron-circle-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chevron-circle-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chevron-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chevron-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chevron-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chevron-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-child" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-chrome" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-circle-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-circle-o-notch" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-circle-thin" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-clipboard"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-clock-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-clone" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-close"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cloud"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cloud-download"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cloud-upload"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cny"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-code"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-code-fork"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-codepen" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-codiepie" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-coffee"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cog"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cogs"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-columns"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-comment"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-comment-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-commenting" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-commenting-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-comments"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-comments-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-compass"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-compress"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-connectdevelop" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-contao" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-copy"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-copyright" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-creative-commons" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-credit-card"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-credit-card-alt" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-crop"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-crosshairs"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-css3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cube" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cubes" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cut"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-cutlery"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-dashboard"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-dashcube" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-database" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-dedent"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-delicious" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-desktop"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-deviantart" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-diamond" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-digg" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-dollar"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-dot-circle-o" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-download"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-dribbble"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-dropbox"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-drupal" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-edge" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-edit"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-eject"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ellipsis-h"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ellipsis-v"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-empire" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-envelope"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-envelope-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-envelope-square" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-eraser"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-eur"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-euro"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-exchange"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-exclamation"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-exclamation-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-exclamation-triangle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-expand"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-expeditedssl" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-external-link"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-external-link-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-eye"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-eye-slash"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-eyedropper" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-facebook"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-facebook-f"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-facebook-official" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-facebook-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-fast-backward"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-fast-forward"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-fax" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-feed"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-female"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-fighter-jet"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-archive-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-audio-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-code-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-excel-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-image-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-movie-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-pdf-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-photo-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-picture-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-powerpoint-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-sound-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-text"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-text-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-video-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-word-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-file-zip-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-files-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-film"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-filter"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-fire"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-fire-extinguisher"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-firefox" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-flag"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-flag-checkered"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-flag-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-flash"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-flask"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-flickr"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-floppy-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-folder"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-folder-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-folder-open"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-folder-open-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-font"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-fonticons" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-forumbee" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-fort-awesome" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-forward"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-foursquare"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-frown-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-futbol-o" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gamepad"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gavel"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gbp"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ge" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gear"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gears"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-genderless" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-get-pocket" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gg" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gg-circle" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gift"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-git" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-git-square" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-github"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-github-alt"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-github-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gittip"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-glass"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-globe"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-google" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-google-plus"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-google-plus-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-google-wallet" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-graduation-cap" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-gratipay"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-group"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-h-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hacker-news" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-grab-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-lizard-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-o-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-o-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-o-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-o-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-paper-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-peace-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-pointer-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-rock-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-scissors-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-spock-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hand-stop-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hashtag" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hdd-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-header" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-headphones"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-heart"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-heart-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-heartbeat" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-history" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-home"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hospital-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hotel" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hourglass" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hourglass-1" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hourglass-2" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hourglass-3" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hourglass-end" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hourglass-half" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hourglass-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-hourglass-start" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-houzz" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-html5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-i-cursor" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ils" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-image"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-inbox"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-indent"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-industry" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-info"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-info-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-inr"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-instagram"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-institution" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-internet-explorer" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-intersex" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ioxhost" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-italic"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-joomla" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-jpy"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-jsfiddle" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-key"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-keyboard-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-krw"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-language" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-laptop"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-lastfm" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-lastfm-square" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-leaf"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-leanpub" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-legal"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-lemon-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-level-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-level-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-life-bouy" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-life-buoy" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-life-ring" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-life-saver" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-lightbulb-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-line-chart" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-link"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-linkedin"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-linkedin-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-linux"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-list"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-list-alt"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-list-ol"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-list-ul"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-location-arrow"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-lock"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-long-arrow-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-long-arrow-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-long-arrow-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-long-arrow-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-magic"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-magnet"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mail-forward"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mail-reply"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mail-reply-all"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-male"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-map" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-map-marker"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-map-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-map-pin" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-map-signs" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mars" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mars-double" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mars-stroke" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mars-stroke-h" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mars-stroke-v" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-maxcdn"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-meanpath" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-medium" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-medkit"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-meh-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mercury" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-microphone"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-microphone-slash"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-minus"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-minus-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-minus-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-minus-square-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mixcloud" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mobile"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mobile-phone"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-modx" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-money"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-moon-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mortar-board" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-motorcycle" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-mouse-pointer" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-music"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-navicon"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-neuter" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-newspaper-o" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-object-group" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-object-ungroup" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-odnoklassniki" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-odnoklassniki-square" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-opencart" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-openid" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-opera" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-optin-monster" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-outdent"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pagelines" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-paint-brush" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-paper-plane" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-paper-plane-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-paperclip"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-paragraph" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-paste"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pause"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pause-circle" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pause-circle-o" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-paw" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-paypal" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pencil"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pencil-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pencil-square-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-percent" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-phone"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-phone-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-photo"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-picture-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pie-chart" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pied-piper" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pied-piper-alt" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pinterest"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pinterest-p" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-pinterest-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-plane"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-play"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-play-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-play-circle-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-plug" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-plus"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-plus-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-plus-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-plus-square-o" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-power-off"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-print"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-product-hunt" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-puzzle-piece"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-qq" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-qrcode"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-question"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-question-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-quote-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-quote-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ra" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-random"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rebel" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-recycle" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-reddit" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-reddit-alien" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-reddit-square" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-refresh"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-registered" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-remove"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-renren"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-reorder"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-repeat"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-reply"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-reply-all"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-retweet"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rmb"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-road"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rocket"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rotate-left"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rotate-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rouble" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rss"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rss-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rub" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ruble" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-rupee"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-safari" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-save"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-scissors"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-search"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-search-minus"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-search-plus"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sellsy" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-send" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-send-o" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-server" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-share"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-share-alt" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-share-alt-square" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-share-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-share-square-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-shekel" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sheqel" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-shield"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ship" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-shirtsinbulk" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-shopping-bag" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-shopping-basket" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-shopping-cart"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sign-in"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sign-out"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-signal"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-simplybuilt" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sitemap"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-skyatlas" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-skype"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-slack" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sliders" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-slideshare" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-smile-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-scribd" data-filter="4.5"></i></a>			
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-soccer-ball-o" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-alpha-asc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-alpha-desc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-amount-asc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-amount-desc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-asc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-desc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-numeric-asc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-numeric-desc"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sort-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-soundcloud" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-space-shuttle" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-spinner"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-spoon" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-spotify" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-square-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-stack-exchange" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-stack-overflow"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-star"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-star-half"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-star-half-empty"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-star-half-full"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-star-half-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-star-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-steam" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-steam-square" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-step-backward"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-step-forward"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-stethoscope"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sticky-note" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sticky-note-o" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-stop"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-stop-circle" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-stop-circle-o" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-street-view" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-strikethrough"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-stumbleupon" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-stumbleupon-circle" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-subscript"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-subway" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-suitcase"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-sun-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-superscript"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-support" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-table"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tablet"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tachometer"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tag"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tags"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tasks"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-taxi" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-television" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tencent-weibo" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-terminal"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-text-height"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-text-width"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-th"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-th-large"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-th-list"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-thumb-tack"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-thumbs-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-thumbs-o-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-thumbs-o-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-thumbs-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-ticket"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-times"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-times-circle"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-times-circle-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tint"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-toggle-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-toggle-left" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-toggle-off" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-toggle-on" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-toggle-right"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-toggle-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-trademark" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-train" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-transgender" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-transgender-alt" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-trash" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-trash-o"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tree" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-trello"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tripadvisor" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-trophy"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-truck"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-try" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tty" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tumblr"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tumblr-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-turkish-lira" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-tv" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-twitch" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-twitter"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-twitter-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-umbrella"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-underline"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-undo"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-university" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-unlink"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-unlock"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-unlock-alt"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-unsorted"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-upload"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-usb" data-filter="4.5"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-usd"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-user"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-user-md"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-user-plus" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-user-secret" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-user-times" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-users"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-venus" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-venus-double" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-venus-mars" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-viacoin" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-video-camera"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-vimeo" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-vimeo-square" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-vine" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-vk"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-volume-down"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-volume-off"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-volume-up"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-warning"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-wechat" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-weibo"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-weixin" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-whatsapp" data-filter="4.3"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-wheelchair" data-filter="4.0"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-wifi" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-wikipedia-w" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-windows"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-won"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-wordpress" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-wrench"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-xing"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-xing-square"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-y-combinator" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-y-combinator-square" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-yahoo" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-yc" data-filter="4.4"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-yc-square" data-filter="4.1"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-yelp" data-filter="4.2"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-yen"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-youtube"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-youtube-play"></i></a>
			<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0"><i class="fa fa-youtube-square"></i></a>
		</div>
	</div>		
	</td>
</tr>