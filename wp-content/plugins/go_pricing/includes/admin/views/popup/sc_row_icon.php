<?php
$maxwidth = !empty( $_POST['maxwidth'] ) && $_POST['maxwidth'] != 'auto' ? (int)$_POST['maxwidth'] : 700;
$user_id = get_current_user_id();
?>
<div class="gwa-popup" data-help="<?php echo esc_attr( isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['help'][$user_id] : '' ); ?>">
	<div class="gwa-popup-inner"<?php echo !empty( $_POST['maxwidth'] ) && $_POST['maxwidth'] != 'auto' ? sprintf( ' style="width:%dpx;"', (int)$_POST['maxwidth'] ) : ''; ?>>
		<div class="gwa-popup-header">
			<div class="gwa-popup-header-icon-code"></div>
			<div class="gwa-popup-title"><?php _e( 'Shortcode Editor', 'go_pricing_textdomain' ); ?><small><?php _e( 'Insert Custom Shortcode', 'go_pricing_textdomain'); ?></small></div>
			<a href="#" title="<?php _e( 'Close', 'go_pricing_textdomain' ); ?>" class="gwa-popup-close"></a>
		</div>
		<div class="gwa-popup-content-wrap">
			<div class="gwa-popup-content">	
				<div class="gwa-abox">
					<div class="gwa-abox-content-wrap">
						<div class="gwa-abox-content">
							<table class="gwa-table">
								<tr>
									<th><label><?php _e( 'Iconset', 'go_pricing_textdomain' ); ?></label></th>
									<td>
										<select name="shortcode">                                
											<option value="fa"><?php _e( 'Font Awesome 4.5 (694)', 'go_pricing_textdomain' ); ?></option>
											<option value="linecon"><?php _e( 'Linecon (48)', 'go_pricing_textdomain' ); ?></option>
											<option value="icomoon"><?php _e( 'Icomoon (491)', 'go_pricing_textdomain' ); ?></option>
											<option value="material"><?php _e( 'Material Icons (795)', 'go_pricing_textdomain' ); ?></option>											
											<option value="image"><?php _e( 'Image icons', 'go_pricing_textdomain' ); ?></option>											
			                            </select>
									</td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Set of the icons.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>
							</table>
							<div class="gwa-table-separator"></div>
							<?php include('parts/part_fa.php'); ?>
							<?php include('parts/part_linecon.php'); ?>
							<?php include('parts/part_icomoon.php'); ?>
							<?php include('parts/part_material.php'); ?>
							<table class="gwa-table" data-id="sc-fields" data-shortcode="<span{atts}></span>" data-parent-id="shortcode" data-parent-value="image">
								<tr class="gwa-row-fullwidth">
									<th><label><?php _e( 'Icon', 'go_pricing_textdomain' ); ?></label></th>
									<td>
									<input type="hidden" name="image-class" data-attr="class" value="gw-go-icon">
									<div class="gwa-icon-picker">
										<div class="gwa-icon-picker-header">
											<div class="gwa-icon-picker-selected gwa-clearfix">
												<a href="#" class="gwa-icon-picker-icon" tabindex="-1" data-action="ip-bg-switch"></a>
												<input type="hidden" name="image-icon" data-attr="class">
											</div>
											<div class="gwa-icon-picker-alignment">
												<span class="gwa-info"><?php _e( 'Icon Alignment', 'go_pricing_textdomain' ); ?></span>
												<div class="gwa-icon-btn"><a href="#" data-id="gw-go-icon-left" title="<?php _e( 'Align Left', 'go_pricing_textdomain' ); ?>"><i class="fa fa-align-left"></i></a><a href="#" data-id="" title="<?php _e( 'Align Center', 'go_pricing_textdomain' ); ?>" class="gwa-current"><i class="fa fa-align-center"></i></a><a href="#" data-id="gw-go-icon-right" title="<?php _e( 'Align Right', 'go_pricing_textdomain' ); ?>"><i class="fa fa-align-right"></i></a><input type="hidden" name="footer-align" data-attr="class"></div>
											</div>												
										</div>
										<div class="gwa-icon-picker-content gwa-clearfix">
											<a href="#" class="gwa-icon-picker-icon gwa-current" data-action="ip-select-blank" tabindex="0" title="<?php esc_attr_e( 'None', 'go_pricing_textdomain' ); ?>"><i class="fa fa-ban"></i></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-arrow"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_arrow.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-arrow2"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_arrow2.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-circle"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_circle.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-cross"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_cross.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-dot"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_dot.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-minus"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_minus.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-ok"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_ok.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-plus"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_plus.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-star"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_light_star.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-email"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_team_light_email.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-facebook"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_team_light_facebook.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-skype"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_team_light_skype.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-light-twitter"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_team_light_twitter.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-arrow"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_arrow.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-arrow2"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_arrow2.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-circle"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_circle.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-cross"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_cross.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-dot"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_dot.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-minus"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_minus.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-ok"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_ok.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-plus"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_plus.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-star"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_dark_star.png' ); ?>"></a>																						
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-email"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_team_dark_email.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-facebook"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_team_dark_facebook.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-skype"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_team_dark_skype.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-dark-twitter"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_team_dark_twitter.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-arrow"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_arrow.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-arrow2"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_arrow2.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-circle"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_circle.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-cross"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_cross.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-dot"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_dot.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-minus"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_minus.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-ok"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_ok.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-plus"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_plus.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-red-star"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_red_star.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-arrow"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_arrow.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-arrow2"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_arrow2.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-circle"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_circle.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-cross"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_cross.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-dot"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_dot.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-minus"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_minus.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-ok"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_ok.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-plus"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_plus.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select" tabindex="0" data-value="gw-go-icon-green-star"><img src="<?php echo esc_attr( $this->plugin_url . 'assets/images/icons/icon_green_star.png' ); ?>"></a>
											<a href="#" class="gwa-icon-picker-icon" data-action="ip-select-custom" tabindex="0" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>"><i class="fa fa-plus-circle"></i></a>											
										</div>
									</div>		
									</td>
								</tr>
								<tr style="display:none;">
									<th><label><?php _e( 'Custom Icon', 'go_pricing_textdomain' ); ?></label></th>
									<td>					
										<div class="gwa-img-upload">
											<div class="gwa-img-upload-media">
												<a href="#" title="<?php esc_attr_e( 'Remove', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-remove"></a>		
											</div>
											<div class="gwa-input-btn"><input type="text" name="image-custom-icon" data-attr="style" data-value="background-image:url({value});"><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="img-upload"><span class="gwa-icon-add"></span></a></div>
										</div>	
									</td>
									<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Custom icon.', 'go_pricing_textdomain' ); ?></p></td>									
								</tr>								
								
							</table>
						</div>
					 </div>
				</div>
			</div>
		</div>
		<div class="gwa-popup-footer">
			<div class="gwa-popup-assets gwa-fl">
				<a href="#" data-action="insert-sc" title="<?php esc_attr_e( 'Insert Shortcode', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1"><?php esc_attr_e( 'Insert Shortcode', 'go_pricing_textdomain' ); ?></a>
			</div>
		</div>		
	</div>	
</div>