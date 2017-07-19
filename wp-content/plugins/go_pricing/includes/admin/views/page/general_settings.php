<?php 
/**
 * General Settings Page
 */

// Get plugin global
global $go_pricing;

// Get current user id
$user_id = get_current_user_id();

// Get general settings
$general_settings = get_option( self::$plugin_prefix . '_table_settings' );

?>
<!-- Top Bar -->
<div class="gwa-ptopbar">
	<div class="gwa-ptopbar-icon"></div>
	<div class="gwa-ptopbar-title">Go Pricing</div>
	<div class="gwa-ptopbar-content"><label><span class="gwa-label"><?php _e( 'Help', 'go_pricing_textdomain' ); ?></span><select data-action="help" class="gwa-w90"><option value="1"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 1 ? ' selected="selected"' : ''; ?>><?php _e( 'Tooltip', 'go_pricing_textdomain' ); ?></option><option value="2"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 2 ? ' selected="selected"' : ''; ?>><?php _e( 'Show', 'go_pricing_textdomain' ); ?></option><option value="0"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 0 ? ' selected="selected"' : ''; ?>><?php _e( 'None', 'go_pricing_textdomain' ); ?></option></select></label><div class="gwa-abox-header-nav"><a data-action="submit" href="#" title="<?php esc_attr_e( 'Save', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-save"><?php _e( 'Save', 'go_pricing_textdomain' ); ?></a></div>
    </div>
</div>
<!-- /Top Bar -->

<!-- Page Content -->
<div class="gwa-pcontent" data-ajax="<?php echo esc_attr( isset( $general_settings['admin']['ajax'] ) ? "true" : "false" ); ?>" data-help="<?php echo esc_attr( isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['help'][$user_id] : '' ); ?>" data-unload="<?php _e( 'Are you sure you want to leave without saving?', 'go_pricing_textdomain' ); ?>">
	<form id="go-pricing-form" name="settings-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="_action" value="general_settings">
		<?php wp_nonce_field( $this->nonce, '_nonce' ); ?>
		
		<!-- Admin Box -->
		<div class="gwa-abox">
			<div class="gwa-abox-header gwa-abox-header-tabs">
				<div class="gwa-abox-header-tab gwa-current">
					<div class="gwa-abox-header-icon"><i class="fa fa-cogs"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Admin', 'go_pricing_textdomain' ); ?></div>
				</div>               
				<div class="gwa-abox-header-tab">
					<div class="gwa-abox-header-icon"><i class="fa fa-link"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Assets', 'go_pricing_textdomain' ); ?></div>
				</div>					
				<div class="gwa-abox-header-tab">
					<div class="gwa-abox-header-icon"><i class="fa fa-code"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Custom CSS', 'go_pricing_textdomain' ); ?></div>	
				</div>									
				<div class="gwa-abox-ctrl"></div>
			</div>
			<div class="gwa-abox-content-wrap gwa-abox-tab-contents">
				<div class="gwa-abox-content gwa-abox-tab-content gwa-current">
					<table class="gwa-table">
						<tr>
							<th><label><?php _e( 'Enable AJAX', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['admin']['ajax'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="admin[ajax]" value="1" <?php echo !empty( $general_settings['admin']['ajax'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to enable AJAX request mode in admin area.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>				    							                                                       
						<tr>
							<th><label><?php _e( 'Live Preview Safe Mode', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['safe-preview'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="safe-preview" value="1" <?php echo !empty( $general_settings['safe-preview'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to enable Safe Mode for Live Previews. Required if the direct access of PHP files in "wp-content" folder is restricted. e.g. The "Restrict wp-content access" option of Sucuri Security plugin is enabled.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>
						<?php if ( current_user_can( 'manage_options' ) ) : ?>						
						<tr>
							<th><label><?php _e( 'Select User Role', 'go_pricing_textdomain' ); ?></label></th>
							<td>
								<select name="capability">
									<option value="manage_options" <?php echo isset( $general_settings['capability'] ) && $general_settings['capability'] == 'manage_options' ? 'selected="selected"' : ''; ?>><?php _e( 'Administrator', 'go_pricing_textdomain' ); ?></option>
									<option value="edit_private_posts" <?php echo isset( $general_settings['capability'] ) && $general_settings['capability'] == 'edit_private_posts' ? 'selected="selected"' : ''; ?>><?php _e( 'Editor', 'go_pricing_textdomain' ); ?></option>
									<option value="publish_posts" <?php echo isset( $general_settings['capability'] ) && $general_settings['capability'] == 'publish_posts' ? 'selected="selected"' : ''; ?>><?php _e( 'Author', 'go_pricing_textdomain' ); ?></option>
									<option value="edit_posts" <?php echo isset( $general_settings['capability'] ) && $general_settings['capability'] == 'edit_posts' ? 'selected="selected"' : ''; ?>><?php _e( 'Contributor', 'go_pricing_textdomain' ); ?></option>
								</select>								
							</td>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Set user access to the plugin.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>				    							                                                       
			    		<?php endif; ?>	
						<tr class="gwa-row-separator"></tr>
                        <tr>
							<th><p><?php _e( 'Editor Popup Settings', 'go_pricing_textdomain' ); ?></p></th>
						<tr>                    
						<tr>
							<th><label><?php _e( 'Apply On Close', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['ep-close-apply'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="ep-close-apply" value="1" <?php echo !empty( $general_settings['ep-close-apply'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to apply changes automatically when editor popup is closed.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>				    							                                                       
						<tr>
							<th><label><?php _e( 'Apply On Action', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['ep-action-apply'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="ep-action-apply" value="1" <?php echo !empty( $general_settings['ep-action-apply'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to apply changes automatically when the editor popup is changed to next or previous row.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>
						<tr>
							<th><label><?php _e( 'Open New Row', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['ep-row-jump'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="ep-row-jump" value="1" <?php echo !empty( $general_settings['ep-row-jump'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to open row content automatically for editing in popup.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>                                                					                                                       
					</table>																																																			
				</div>
                <div class="gwa-abox-content gwa-abox-tab-content">				
					<table class="gwa-table">					
						<tr>
							<th><label><?php _e( 'Plugin Page(s) Restriction', 'go_pricing_textdomain' ); ?></label></th>
							<td>
								<select name="plugin-pages-rule">
									<option value="in" <?php echo isset( $general_settings['plugin-pages-rule'] ) && $general_settings['plugin-pages-rule'] == 'in' ? 'selected="selected"' : ''; ?>><?php _e( 'Include', 'go_pricing_textdomain' ); ?></option>
									<option value="not_in" <?php echo isset( $general_settings['plugin-pages-rule'] ) && $general_settings['plugin-pages-rule'] == 'not_in' ? 'selected="selected"' : ''; ?>><?php _e( 'Exclude', 'go_pricing_textdomain' ); ?></option>
								</select>								
							</td>							
                            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Specify the rule of the restriction. Include: pages/posts where to load plugin assets (JavaScript & CSS files). Exlude: pages/posts where NOT to load plugin assets.', 'go_pricing_textdomain' ); ?></p></td>
						</tr>
						<tr>
							<th><label><?php _e( 'Plugin Page(s)', 'go_pricing_textdomain' ); ?></label></th>
							<td><input type="text" name="plugin-pages" value="<?php echo esc_attr( isset( $general_settings['plugin-pages'] ) ? $general_settings['plugin-pages'] : '' ); ?>"></td>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Comma separated list of page/post IDs (e.g. 13, 54, 126). Use to restrict the plugin to load or NOT to load JavaScript & CSS files (depending of the restriction rule) for the selected pages/posts only improving site performance. Leave blank if you don\'t want any restriction.', 'go_pricing_textdomain' ); ?></p></td>
						</tr>
						<tr>
							<th><label><?php _e( 'Load JavaScript In Header', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['js-in-header'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="js-in-header" value="1" <?php echo !empty( $general_settings['js-in-header'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to load plugin JavaScript in header section of the website. Disable it to load it in the page footer (recommended).', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>
						<tr class="gwa-row-separator"></tr>
						<tr class="gwa-row-fullwidth">
							<th><p><?php _e( 'Prevent Font Icon CSS Files From Loading', 'go_pricing_textdomain' ); ?></p></th>
							<td><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'CSS files of font icons are loaded automatically by the plugin, only when necessary. Disabling loading a fontset allows you prevent the required files are loaded multiple times.', 'go_pricing_textdomain' ); ?></p></td>
						<tr>
							<th><label><?php _e( 'Font Awesome', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['disable-font']['fa'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="disable-font[fa]" value="1" <?php echo !empty( $general_settings['disable-font']['fa'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php printf( __( 'Whether to prevent loading the required files for %s iconset.', 'go_pricing_textdomain' ), 'Font Awesome' ); ?></p></td>									
						</tr>
						<tr>
							<th><label><?php _e( 'Linecon', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['disable-font']['linecon'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="disable-font[linecon]" value="1" <?php echo !empty( $general_settings['disable-font']['linecon'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php printf( __( 'Whether to prevent loading the required files for %s iconset.', 'go_pricing_textdomain' ), 'Linecon' ); ?></p></td>									
						</tr>
						<tr>
							<th><label><?php _e( 'Icomoon', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['disable-font']['icomoon'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="disable-font[icomoon]" value="1" <?php echo !empty( $general_settings['disable-font']['icomoon'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php printf( __( 'Whether to prevent loading the required files for %s iconset.', 'go_pricing_textdomain' ), 'Icomoon' ); ?></p></td>									
						</tr>
						<tr>
							<th><label><?php _e( 'Material Icons', 'go_pricing_textdomain' ); ?></label></th>
							<td><p><label><span class="gwa-checkbox<?php echo !empty( $general_settings['disable-font']['material'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="disable-font[material]" value="1" <?php echo !empty( $general_settings['disable-font']['material'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>							
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php printf( __( 'Whether to prevent loading the required files for %s iconset.', 'go_pricing_textdomain' ), 'Material Icons' ); ?></p></td>									
						</tr>																								
					</table>
				</div>
				<div class="gwa-abox-content gwa-abox-tab-content">
					<table class="gwa-table">							
						<tr class="gwa-row-fullwidth">
							<th><label><?php _e( 'Code', 'go_pricing_textdomain' ); ?></label></th>
							<td><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Please add general CSS codes here, for table specific codes use the "Custom CSS" tab when you edit a table.', 'go_pricing_textdomain' ); ?></p></td>
                            <td><div class="gwa-textarea-code"><textarea name="custom-css" rows="10" style="margin-top:0;" data-editor-type="css"><?php echo isset( $general_settings['custom-css'] ) ? ( $general_settings['custom-css'] ) : ''; ?></textarea></div></td>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'The code will be added to the plugin frontend style.', 'go_pricing_textdomain' ); ?></p></td>
						</tr>
					</table>
				</div>				
			</div>
		</div>
		<!-- /Admin Box -->
				
		<!-- Submit -->
		<div class="gwa-submit"><button type="submit" class="gwa-btn-style1"><?php _e( 'Save', 'go_pricing_textdomain' ); ?></button></div>
		<!-- /Submit -->
				
		<!-- Admin Box -->
		<div class="gwa-abox">
			<div class="gwa-abox-header">
            	<div class="gwa-abox-header-tab gwa-current">
					<div class="gwa-abox-header-icon"><i class="fa fa-dollar"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Currency', 'go_pricing_textdomain' ); ?></div>
                </div>
				<div class="gwa-abox-ctrl"></div>
			</div>
			<div class="gwa-abox-content-wrap">
				<div class="gwa-abox-content">
					<?php 
					if ( empty( $general_settings['currency'] ) ) {
						$general_settings['currency'][] = 'e';
						
					}
					if ( !empty( $general_settings['currency'] ) ) :
					foreach( (array)$general_settings['currency'] as $currency_index => $currency_value ) : 
					?>
					<table class="gwa-table">
						<tr>
							<th><label><?php _e( 'Currency', 'go_pricing_textdomain' ); ?></label></th>
							<td>
								<select name="currency[<?php echo $currency_index; ?>][currency]">
									<?php 
									foreach ( (array)$go_pricing['currency'] as $currency ) : 
									?>
									<option value="<?php echo esc_attr( !empty( $currency['id'] ) ? $currency['id'] : '' ); ?>"<?php echo ( !empty( $currency['id'] ) && ( $currency['id'] == $currency_value['currency'] )  ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $currency['name'] ) && !empty( $currency['symbol'] ) ? sprintf( '%1$s (%2$s)', $currency['name'], $currency['symbol'] )  : '' ); ?></option>
									<?php 
									endforeach;
									?>
								<select>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Currency of the price.', 'go_pricing_textdomain' ); ?></p></td>
						</tr>							
						<tr>
							<th><label><?php _e( 'Currency Position', 'go_pricing_textdomain' ); ?></label></th>
							<td>
								<select name="currency[<?php echo $currency_index; ?>][position]">
									<option value="left"<?php echo !empty( $currency_value['position'] ) && $currency_value['position'] == 'left' ? ' selected="selected"' : '' ; ?>><?php _e( 'Left (e.g. $100)', 'go_pricing_textdomain' ); ?></option>
									<option value="right"<?php echo !empty( $currency_value['position'] ) && $currency_value['position'] == 'right' ? ' selected="selected"' : '' ; ?>><?php _e( 'Right (e.g. 100$)', 'go_pricing_textdomain' ); ?></option>						
								<select>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Currency position of the price.', 'go_pricing_textdomain' ); ?></p></td>
						</tr>
						<tr>
							<th><label><?php _e( 'Thousand Separator', 'go_pricing_textdomain' ); ?></label></th>
							<td><input type="text" name="currency[<?php echo $currency_index; ?>][thousand-sep]" id="go-pricing-secondary-font" value="<?php echo isset( $currency_value['thousand-sep'] ) && $currency_value['thousand-sep'] != '' ? esc_attr( $currency_value['thousand-sep'] ) : ','; ?>"></td>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Thuousand separator of the price.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>							
						<tr>
							<th><label><?php _e( 'Decimal Separator', 'go_pricing_textdomain' ); ?></label></th>
							<td><input type="text" name="currency[<?php echo $currency_index; ?>][decimal-sep]" id="go-pricing-secondary-font-css" value="<?php echo isset( $currency_value['decimal-sep'] ) && $currency_value['decimal-sep'] != '' ? esc_attr( $currency_value['decimal-sep'] ) : '.'; ?>"></td>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Decimal separator of the price.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>
						<tr>
							<th><label><?php _e( 'Number of Decimals', 'go_pricing_textdomain' ); ?></label></th>
							<td><input type="text" name="currency[<?php echo $currency_index; ?>][decimal-no]" id="go-pricing-secondary-font-css" value="<?php echo isset( $currency_value['decimal-no'] ) && $currency_value['decimal-no'] != '' ? esc_attr( (int)$currency_value['decimal-no'] ) : 2; ?>"></td>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Maximum number of decimals to show in price.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>																																									
					</table>
					<?php 
					endforeach;
					endif;
					?>																																																										
				</div>
			 </div>
		</div>
		<!-- /Admin Box -->
		
		<!-- Submit -->
		<div class="gwa-submit"><button type="submit" class="gwa-btn-style1"><?php _e( 'Save', 'go_pricing_textdomain' ); ?></button></div>
		<!-- /Submit -->
		
	</form>
</div>
<!-- /Page Content -->