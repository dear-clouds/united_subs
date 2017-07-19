<?php
/**
 * Table Editor Page
 */


// Get plugin global
global $go_pricing;

// Get current user id
$user_id = get_current_user_id();

// Get general settings
$general_settings = get_option( self::$plugin_prefix . '_table_settings' );

// Get table data
if ( $this->is_ajax === false ) {
	if ( !empty( $_GET['id'] ) ) $postid = (int)$_GET['id'];	
} else {
	if ( !empty( $_POST['postid'] ) ) $postid = (int)$_POST['postid'];	
}

if ( !empty( $postid ) ) $table_data = GW_GoPricing_Data::get_table( $postid );

$data = $this->get_temp_postdata();
if ( !empty( $data ) ) $table_data = $data;
$this->delete_temp_postdata();

?>

<!-- Top Bar -->
<div class="gwa-ptopbar">
	<div class="gwa-ptopbar-icon"></div>
	<div class="gwa-ptopbar-title">Go Pricing</div>
	<div class="gwa-ptopbar-content"><label><span class="gwa-label"><?php _e( 'Help', 'go_pricing_textdomain' ); ?></span><select data-action="help" class="gwa-w90"><option value="1"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 1 ? ' selected="selected"' : ''; ?>><?php _e( 'Tooltip', 'go_pricing_textdomain' ); ?></option><option value="2"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 2 ? ' selected="selected"' : ''; ?>><?php _e( 'Show', 'go_pricing_textdomain' ); ?></option><option value="0"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 0 ? ' selected="selected"' : ''; ?>><?php _e( 'None', 'go_pricing_textdomain' ); ?></option></select></label><div class="gwa-abox-header-nav">
	       <a data-action="submit" href="#" title="<?php esc_attr_e( 'Save', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-save"><?php _e( 'Save', 'go_pricing_textdomain' ); ?></a>
	       <a href="#" data-action="popup" data-alert="<?php echo empty( $postid ) ? esc_attr_e( 'Please save the table first!', 'go_pricing_textdomain' ) : ''; ?>" data-popup="live-preview-edit" data-id="<?php echo esc_attr( !empty( $postid ) ? $postid : 0 ); ?>" data-popup-type="iframe" data-popup-subtitle="<?php echo esc_attr( !empty( $table_data['name'] ) ? $table_data['name'] : '' ); ?>" data-popup-maxwidth="1200" title="<?php esc_attr_e( 'Preview', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-preview"><?php _e( 'Preview', 'go_pricing_textdomain' ); ?></a>
	       <a href="https://granth.ticksy.com/articles/10236/" target="_blank" title="<?php esc_attr_e( 'Help', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-help"><?php _e( 'Help', 'go_pricing_textdomain' ); ?></a>
	       <a href="<?php echo esc_attr( admin_url( 'admin.php?page=go-pricing-settings' ) ); ?>" title="<?php esc_attr_e( 'Settings', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-settings"><?php _e( 'Settings', 'go_pricing_textdomain' ); ?></a>
       </div>
	</div>
</div>
<!-- /Top Bar -->

<!-- Page Content -->
<div class="gwa-pcontent" data-ajax="<?php echo esc_attr( isset( $general_settings['admin']['ajax'] ) ? "true" : "false" ); ?>" data-help="<?php echo esc_attr( isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['help'][$user_id] : '' ); ?>" data-reminder="<?php _e( 'Settings has been changed. Don\'t forget to save!', 'go_pricing_textdomain' ); ?>">
	<form id="go-pricing-form" name="te-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="_action" value="table_editor">
		<input type="hidden" name="db_version" value="2.0">
		<?php wp_nonce_field( $this->nonce, '_nonce' ); ?>

		<?php if ( !empty( $postid ) ) : ?>
		<input type="hidden" name="postid" value="<?php echo esc_attr( $postid ); ?>"><?php endif; ?>

			<!-- Admin Box -->
			<div id="go-pricing-table-editor-global" class="gwa-abox">
				<div class="gwa-abox-header gwa-abox-header-tabs">
					<div class="gwa-abox-header-tab gwa-current">
						<div class="gwa-abox-header-icon"><i class="fa fa-dot-circle-o"></i></div>
						<div class="gwa-abox-title"><?php _e( 'Name & ID', 'go_pricing_textdomain' ); ?></div>
					</div>
					<div class="gwa-abox-header-tab">
						<div class="gwa-abox-header-icon"><i class="fa fa-stack-exchange"></i></div>
						<div class="gwa-abox-title"><?php _e( 'Skin & Style', 'go_pricing_textdomain' ); ?></div>
					</div>					
					<div class="gwa-abox-header-tab">
						<div class="gwa-abox-header-icon"><i class="fa fa-th"></i></div>
						<div class="gwa-abox-title"><?php _e( 'Layout', 'go_pricing_textdomain' ); ?></div>	
					</div>
					<div class="gwa-abox-header-tab">
						<div class="gwa-abox-header-icon"><i class="fa fa-columns"></i></div>
						<div class="gwa-abox-title"><?php _e( 'Responsivity', 'go_pricing_textdomain' ); ?></div>	
					</div>
					<div class="gwa-abox-header-tab">
						<div class="gwa-abox-header-icon"><i class="fa fa-video-camera"></i></div>
						<div class="gwa-abox-title"><?php _e( 'Animation', 'go_pricing_textdomain' ); ?></div>	
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
								<th><label><?php _e( 'Table Name', 'go_pricing_textdomain' ); ?></label></th>
								<td><input type="text" name="name" value="<?php echo esc_attr( isset( $table_data['name'] ) ? $table_data['name'] : '' ); ?>"></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Pricing table name, used only in admin area.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr>
								<th><label><?php _e( 'Table ID', 'go_pricing_textdomain' ); ?></label></th>
								<td><input type="text" name="id" value="<?php echo esc_attr( isset( $table_data['id'] ) ? $table_data['id'] : '' ); ?>"></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Unique ID, used in shortcodes. (e.g. If your table ID is "my_table", your shortcode will be: [go_pricing id="my_table"]).<br>Only lowercase letters, numbers, hyphens and underscores are allowed.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr class="gwa-shortcode-row"<?php echo !isset( $table_data['id'] ) ? ' style="display:none;"' : ''; ?>>
								<th><label><?php _e( 'Shortcode', 'go_pricing_textdomain' ); ?></label></th>
								<td><input type="text" value="<?php echo esc_attr( isset( $table_data['id'] ) ? sprintf ( '[go_pricing id="%s"]', $table_data['id'] ) : '' ); ?>" readonly="readonly"></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Your shortcode. Paste it into any post or page.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>                                                        						
							<tr class="gwa-row-separator"></tr>
							<tr>
								<th><label><?php _e( 'Thumbnail', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(<?php _e( 'optional', 'go_pricing_textdomain' ); ?>)</span></label></th>
								<td>
									<div class="gwa-img-upload">
										<div class="gwa-img-upload-media"<?php echo empty( $table_data['thumbnail'] ) ? ' style="display:none;"' : ''; ?>>
											<?php if ( !empty( $table_data['thumbnail'] ) ) : ?>
											<span class="gwa-img-upload-media-container"><a href="#" title="<?php esc_attr_e( 'Remove', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-remove"></a><a href="#" title="<?php esc_attr_e( 'Preview', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-popup" data-action="popup" data-popup="image-preview" data-popup-type="image" data-popup-subtitle="<?php echo esc_attr( $table_data['thumbnail'] ); ?>" data-id="<?php echo esc_attr( $table_data['thumbnail'] ); ?>" data-popup-maxwidth="auto"><img src="<?php echo esc_attr( $table_data['thumbnail'] ); ?>"></a></span>
											<?php else : ?>
											<a href="#" title="<?php esc_attr_e( 'Remove', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-remove"></a>					
											<?php endif; ?>							
										</div>
										<div class="gwa-input-btn"<?php echo ( !empty( $table_data['thumbnail'] ) ? 'style="display:none;"': '' ); ?>><input type="text" name="thumbnail" value="<?php echo ( !empty( $table_data['thumbnail'] ) ?  esc_attr( $table_data['thumbnail'] ) : '' ); ?>"><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="img-upload"><span class="gwa-icon-add"></span></a></div>
									</div>
								</td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Unique thumbnail image. It helps you identify you table in admin area. Enter an URL or select an image from the Media Library.<br><strong>Recommended size 400x196px.</strong>', 'go_pricing_textdomain' ); ?></p></td>
							</tr>																								
						</table>																																																														
					</div>
					
					<div class="gwa-abox-content gwa-abox-tab-content">
						<table class="gwa-table">													
							<tr>
								<td><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Unsaved column data will be lost on skin change!', 'go_pricing_textdomain' ); ?></p></td>
							</tr>							
							<tr>
								<th><label><?php _e( 'Skin', 'go_pricing_textdomain' ); ?></label></th>
								<td>
									<select id="go-pricing-style" name="style">
										<?php 
										if ( !empty( $go_pricing['styles'] ) ) : 
										foreach ( (array)$go_pricing['styles'] as $style ) : 
										if ( !empty( $style['name'] ) && !empty( $style['id'] ) )	:
										?>
										<option value="<?php echo esc_attr( $style['id'] ); ?>"<?php echo !empty( $table_data['style'] ) && $style['id'] == $table_data['style'] ? ' selected="selected"' : ''; ?>><?php echo $style['name']; ?></option>
										<?php 
										endif;
										endforeach;
										endif;
										?>
									</select>
								</td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Skin of the pricing table.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
						</table>
						<?php 
						$table_style = !empty( $table_data['style'] )  ? $table_data['style'] : 'clean';
						?>
						<div id="go-pricing-global-style"><?php do_action( "go_pricing_admin_global_style_opts_{$table_style}", !empty( $table_data ) ? $table_data : '' ); ?></div>
                        </table>
                        <div class="gwa-table-separator"></div>
						<table class="gwa-table">							
                        <tr>
                            <th><label><?php _e( 'Default Font Family', 'go_pricing_textdomain' ); ?></label></th>
                            <td>
                                <select name="default-font">
                                    <?php 
                                    foreach ( (array)$go_pricing['fonts'] as $fonts ) : 
                                    if ( !empty( $fonts['group_name'] ) )	:
                                    ?>
                                    <optgroup label="<?php echo esc_attr( $fonts['group_name'] ); ?>"></optgroup>
                                    <?php 
                                    foreach ( (array)$fonts['group_data'] as $font_data ) :
                                    ?>
                                    <option value="<?php echo esc_attr( !empty( $font_data['value'] ) ? $font_data['value'] : '' ); ?>"<?php echo ( !empty( $font_data['value'] ) && isset( $table_data['default-font'] ) && $font_data['value'] == $table_data['default-font'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $font_data['name'] ) ? $font_data['name'] : '' ); ?></option>
                                    <?php
                                    endforeach;
                                    else :
                                    ?>
                                    <option value="<?php echo esc_attr( !empty( $fonts['value'] ) ? $fonts['value'] : '' ); ?>"<?php echo ( !empty( $fonts['value'] ) && isset( $table_data['default-font'] ) && $fonts['value'] == $table_data['default-font'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $fonts['name'] ) ? $fonts['name'] : '' ); ?></option>
                                    <?php 
                                    endif;
                                    endforeach;
                                    ?>
                                </select>
                            </td>
                            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Default font family for the pricing table. Select "Default / Inherit" to use your theme default font family. ', 'go_pricing_textdomain' ); ?></p></td>
                        </tr>
                        </table>
                        <div class="gwa-table-separator"></div>
						<table class="gwa-table">
                        	<tr>
								<th><label><?php _e( 'Tooltip Width', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
								<td><input type="text" name="tooltip[width]" value="<?php echo esc_attr( isset( $table_data['tooltip']['width'] ) ? (int)$table_data['tooltip']['width'] : 130 ); ?>"></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Width of the tooltip in pixels.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr>
								<th><label><?php _e( 'Tooltip Bg Color', 'go_pricing_textdomain' ); ?></label></th>
								<td><label><div class="gwa-colorpicker" tabindex="0"><input type="hidden" name="tooltip[bg-color]" value="<?php echo esc_attr( isset( $table_data['tooltip']['bg-color'] ) ? $table_data['tooltip']['bg-color'] : '#9d9d9d' ); ?>"><span class="gwa-cp-picker"><span<?php echo ( !empty( $table_data['tooltip']['bg-color'] ) ? ' style="background:' . $table_data['tooltip']['bg-color'] . ';"' : ' style="background:#9d9d9d";' ); ?>></span></span><span class="gwa-cp-label"><?php echo ( !empty( $table_data['tooltip']['bg-color'] ) ? $table_data['tooltip']['bg-color'] : '#9d9d9d' ); ?></span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $table_data['tooltip-bg-color'] ) ? $table_data['tooltip-bg-color'] : '#9d9d9d' ); ?>"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></div></label></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Background color of the tooltip.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr>
								<th><label><?php _e( 'Tooltip Text Color', 'go_pricing_textdomain' ); ?></label></th>
								<td><label><div class="gwa-colorpicker" tabindex="0"><input type="hidden" name="tooltip[text-color]" value="<?php echo esc_attr( isset( $table_data['tooltip']['text-color'] ) ? $table_data['tooltip']['text-color'] : '#333333' ); ?>"><span class="gwa-cp-picker"><span<?php echo ( !empty( $table_data['tooltip']['text-color'] ) ? ' style="background:' . $table_data['tooltip']['text-color'] . ';"' : ' style="background:#333333;"' ); ?>></span></span><span class="gwa-cp-label"><?php echo ( !empty( $table_data['tooltip']['text-color'] ) ? $table_data['tooltip']['text-color'] : '#333333' ); ?></span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $table_data['tooltip-text-color'] ) ? $table_data['tooltip-text-color'] : '#333333' ); ?>"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></div></label></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Text color of the tooltip.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>																							
						</table>																																																																																								
					</div>					
					
					<div class="gwa-abox-content gwa-abox-tab-content">
						<table class="gwa-table">							
							<tr>
								<th><label><?php _e( 'Column Space', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
								<td><input type="text" name="col-space" value="<?php echo esc_attr( isset( $table_data['col-space'] ) ? (int)$table_data['col-space'] : 0 ); ?>"></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Horizontal space between columns in pixels.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr>
								<th><label><?php _e( 'Column Min/Max Width', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
								<td><input type="text" name="col-width[min]" value="<?php echo esc_attr( isset( $table_data['col-width']['min'] ) ? (int)$table_data['col-width']['min'] : 130 ); ?>" class="gwa-w110 gwa-mr10"><input type="text" name="col-width[max]" value="<?php echo esc_attr( isset( $table_data['col-width']['max'] ) ? (int)$table_data['col-width']['max'] : '' ); ?>" class="gwa-w110"></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Minimum width of the colums in pixels.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
						</table>
						<div class="gwa-table-separator"></div>
						<table class="gwa-table">						
							<tr>
								<th><label><?php _e( 'Hide Footer?', 'go_pricing_textdomain' ); ?></label></th>
								<td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['hide-footer'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="hide-footer" tabindex="-1" value="1" <?php echo !empty( $table_data['hide-footer'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to hide the table footer.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>													
							<tr>
								<th><label><?php _e( 'Enlarge Current Column?', 'go_pricing_textdomain' ); ?></label></th>
								<td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['enlarge-current'] ) || empty( $table_data ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="enlarge-current" tabindex="-1" value="1" <?php echo !empty( $table_data['enlarge-current'] ) || empty( $table_data ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to increase the size of the columns on hover/highlighted state.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
						</table>
						<div class="gwa-table-separator"></div>
						<table class="gwa-table">
							<tr>
								<th><label><?php _e( 'Equalize Columns?', 'go_pricing_textdomain' ); ?></label></th>
								<td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['equalize']['column'] ) || empty( $table_data ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="equalize[column]" tabindex="-1" value="1" <?php echo !empty( $table_data['equalize']['column'] ) || empty( $table_data ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to equalize the height of the columns (recommended).', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr>
								<th><label><?php _e( 'Equalize Rows in Body?', 'go_pricing_textdomain' ); ?></label></th>
								<td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['equalize']['body'] ) || empty( $table_data ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="equalize[body]" tabindex="-1" value="1" <?php echo !empty( $table_data['equalize']['body'] ) || empty( $table_data ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to equalize the height of the rows in body (recommended).', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr>
								<th><label><?php _e( 'Equalize Rows in Footer?', 'go_pricing_textdomain' ); ?></label></th>
								<td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['equalize']['footer'] ) || empty( $table_data ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="equalize[footer]" tabindex="-1" value="1" <?php echo !empty( $table_data['equalize']['footer'] ) || empty( $table_data ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to equalize the height of the rows in footer (recommended).', 'go_pricing_textdomain' ); ?></p></td>
							</tr>																																		
						</table>																																																														
					</div>

					<div class="gwa-abox-content gwa-abox-tab-content">				
						<table class="gwa-table">
							<tr>
								<th><label><?php _e( 'Enable Responsivity', 'go_pricing_textdomain' ); ?></label></th>
								<td><p><label><span class="gwa-checkbox<?php echo !isset( $table_data ) || isset( $table_data['responsivity']['enabled'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="responsivity[enabled]" value="1" <?php echo !isset( $table_data ) || isset( $table_data['responsivity']['enabled'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to enable or disable responsiveness.', 'go_pricing_textdomain' ); ?></p></td>									
							</tr>
							<tr class="gwa-row-separator" data-parent-id="responsivity[enabled]" data-parent-value="on"></tr>						
							<tr data-parent-id="responsivity[enabled]" data-parent-value="on">
								<th><label><?php _e( 'Tablet Portrait View', 'go_pricing_textdomain' ); ?></label></th>
								<td><label><span class="gwa-label"><?php _e( 'Min.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></span><input type="text" name="responsivity[views][tp][min]" value="<?php echo isset( $table_data['responsivity']['views']['tp']['min'] ) ? ( $table_data['responsivity']['views']['tp']['min'] != '' ? (int)$table_data['responsivity']['views']['tp']['min'] : $table_data['responsivity']['views']['tp']['min'] ) : '768'; ?>" class="gwa-w60"></label><label><span class="gwa-label"><?php _e( 'Max.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></span><input type="text" name="responsivity[views][tp][max]" value="<?php echo isset( $table_data['responsivity']['views']['tp']['max'] ) ? ( $table_data['responsivity']['views']['tp']['max'] != '' ? (int)$table_data['responsivity']['views']['tp']['max'] : $table_data['responsivity']['views']['tp']['max'] ) : '959'; ?>" class="gwa-w60"></label><label><span class="gwa-label"><?php _e( 'Columns', 'go_pricing_textdomain' ); ?></span><select name="responsivity[views][tp][cols]" class="gwa-w60"><option value=""><?php _e( 'All', 'go_pricing_textdomain' ); ?></option><option value="10"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 10 ? ' selected="selected"' : '' ); ?>>10</option><option value="9"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 9 ? ' selected="selected"' : '' ); ?>>9</option><option value="8"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 8 ? ' selected="selected"' : '' ); ?>>8</option><option value="7"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 7 ? ' selected="selected"' : '' ); ?>>7</option><option value="6"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 6 ? ' selected="selected"' : '' ); ?>>6</option><option value="5"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 5 ? ' selected="selected"' : '' ); ?>>5</option><option value="4"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 4 ? ' selected="selected"' : '' ); ?>>4</option><option value="3"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 3 ? ' selected="selected"' : '' ); ?>>3</option><option value="2"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 2 ? ' selected="selected"' : '' ); ?>>2</option><option value="1"<?php echo esc_attr( isset( $table_data['responsivity']['views']['tp']['cols'] ) && $table_data['responsivity']['views']['tp']['cols'] == 1 ? ' selected="selected"' : '' ); ?>>1</option></select></label></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Minimum and maximum screen width breakpoints in pixels and the number of columns to show in a row for Tablet Portrait View.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr data-parent-id="responsivity[enabled]" data-parent-value="on">
								<th><label><?php _e( 'Mobile Landscape View', 'go_pricing_textdomain' ); ?></label></th>
								<td><label><span class="gwa-label"><?php _e( 'Min.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></span><input type="text" name="responsivity[views][ml][min]" value="<?php echo isset( $table_data['responsivity']['views']['ml']['min'] ) ? ( $table_data['responsivity']['views']['ml']['min'] != '' ? (int)$table_data['responsivity']['views']['ml']['min'] : $table_data['responsivity']['views']['ml']['min'] ) : '480'; ?>" class="gwa-w60"></label><label><span class="gwa-label"><?php _e( 'Max.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></span><input type="text" name="responsivity[views][ml][max]" value="<?php echo isset( $table_data['responsivity']['views']['ml']['max'] ) ? ( $table_data['responsivity']['views']['ml']['max'] != '' ? (int)$table_data['responsivity']['views']['ml']['max'] : $table_data['responsivity']['views']['ml']['max'] ) : '767'; ?>" class="gwa-w60"></label><label><span class="gwa-label"><?php _e( 'Columns', 'go_pricing_textdomain' ); ?></span><select name="responsivity[views][ml][cols]" class="gwa-w60"><option value=""><?php _e( 'All', 'go_pricing_textdomain' ); ?></option><option value="10"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 10 ? ' selected="selected"' : '' ); ?>>10</option><option value="9"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 9 ? ' selected="selected"' : '' ); ?>>9</option><option value="8"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 8 ? ' selected="selected"' : '' ); ?>>8</option><option value="7"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 7 ? ' selected="selected"' : '' ); ?>>7</option><option value="6"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 6 ? ' selected="selected"' : '' ); ?>>6</option><option value="5"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 5 ? ' selected="selected"' : '' ); ?>>5</option><option value="4"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 4 ? ' selected="selected"' : '' ); ?>>4</option><option value="3"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 3 ? ' selected="selected"' : '' ); ?>>3</option><option value="2"<?php echo esc_attr( !isset( $table_data['responsivity']['views']['mp']['cols'] ) || ( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 2 ) ? ' selected="selected"' : '' ); ?>>2</option><option value="1"<?php echo esc_attr( isset( $table_data['responsivity']['views']['ml']['cols'] ) && $table_data['responsivity']['views']['ml']['cols'] == 1 ? ' selected="selected"' : '' ); ?>>1</option></select></label></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Minimum and maximum screen width breakpoints in pixels and the number of columns to show in a row for Mobile Landscape View.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr data-parent-id="responsivity[enabled]" data-parent-value="on">
								<th><label><?php _e( 'Mobile Portrait View', 'go_pricing_textdomain' ); ?></label></th>
								<td><label><span class="gwa-label"><?php _e( 'Min.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></span><input type="text" name="responsivity[views][mp][min]" value="<?php echo isset( $table_data['responsivity']['views']['mp']['min'] ) ? ( $table_data['responsivity']['views']['mp']['min'] != '' ? (int)$table_data['responsivity']['views']['mp']['min'] : $table_data['responsivity']['views']['mp']['min'] ) : ''; ?>" class="gwa-w60"></label><label><span class="gwa-label"><?php _e( 'Max.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></span><input type="text" name="responsivity[views][mp][max]" value="<?php echo isset( $table_data['responsivity']['views']['mp']['max'] ) ? ( $table_data['responsivity']['views']['mp']['max'] != '' ? (int)$table_data['responsivity']['views']['mp']['max'] : $table_data['responsivity']['views']['mp']['max'] ) : '479'; ?>" class="gwa-w60"></label><label><span class="gwa-label"><?php _e( 'Columns', 'go_pricing_textdomain' ); ?></span><select name="responsivity[views][mp][cols]" class="gwa-w60"><option value=""><?php _e( 'All', 'go_pricing_textdomain' ); ?></option><option value="10"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 10 ? ' selected="selected"' : '' ); ?>>10</option><option value="9"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 9 ? ' selected="selected"' : '' ); ?>>9</option><option value="8"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 8 ? ' selected="selected"' : '' ); ?>>8</option><option value="7"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 7 ? ' selected="selected"' : '' ); ?>>7</option><option value="6"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 6 ? ' selected="selected"' : '' ); ?>>6</option><option value="5"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 5 ? ' selected="selected"' : '' ); ?>>5</option><option value="4"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 4 ? ' selected="selected"' : '' ); ?>>4</option><option value="3"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 3 ? ' selected="selected"' : '' ); ?>>3</option><option value="2"<?php echo esc_attr( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 2 ? ' selected="selected"' : '' ); ?>>2</option><option value="1"<?php echo esc_attr( !isset( $table_data['responsivity']['views']['mp']['cols'] ) || ( isset( $table_data['responsivity']['views']['mp']['cols'] ) && $table_data['responsivity']['views']['mp']['cols'] == 1 ) ? ' selected="selected"' : '' ); ?>>1</option></select></label></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Minimum and maximum screen width breakpoints in pixels and the number of columns to show in a row for Mobile Landscape View.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>														
						</table>
						
					</div>
                    <!-- Anim -->
					<div class="gwa-abox-content gwa-abox-tab-content">				
						<table class="gwa-table">
							<tr>
								<th><label><?php _e( 'Enable Animation', 'go_pricing_textdomain' ); ?></label></th>
								<td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['col-animation'] ) || empty( $table_data ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="col-animation" tabindex="-1" value="1" <?php echo !empty( $table_data['col-animation'] ) || empty( $table_data ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Column animation is played when table gets in the viewport of screen.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
							<tr data-parent-id="col-animation" data-parent-value="on">
								<th><label><?php _e( 'Play Once', 'go_pricing_textdomain' ); ?></label></th>
								<td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['col-anim-once'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="col-anim-once" tabindex="-1" value="1" <?php echo !empty( $table_data['col-anim-once'] )? ' checked="checked"' : ''; ?>></span></label></p></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to play animation only once or every time if the table gets in the viewport of screen.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
                        	<tr data-parent-id="col-animation" data-parent-value="on">
								<th><label><?php _e( 'Scroll Offset', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(%)</span></label></th>
								<td><input type="text" name="col-anim-offset" value="<?php echo esc_attr( isset( $table_data['col-anim-offset'] ) ? (int)$table_data['col-anim-offset'] : 70 ); ?>"></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Distance from the top of the screen where the animation starts playing.  ', 'go_pricing_textdomain' ); ?></p></td>
							</tr>
						</table>
					</div>	                    
                 	<!-- /Anim -->
                    
					<div class="gwa-abox-content gwa-abox-tab-content">				
						<table class="gwa-table">                        
							<tr class="gwa-row-fullwidth">
								<th><label><?php _e( 'Code', 'go_pricing_textdomain' ); ?></label></th>
                                <td><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'CSS code will be automatically prefixed with a table id selector (e.g. #go-pricing-1234 .my-custom-rule { ... }) and will be applied to this table only, so please don\'t use id selectors! For general - not table specific - CSS codes use the "Custom CSS" tab under General Settings page.', 'go_pricing_textdomain' ); ?></p></td>
								<td><div class="gwa-textarea-code"><textarea name="custom-css" rows="10" data-editor-type="css"><?php echo isset( $table_data['custom-css'] ) ? ( $table_data['custom-css'] ) : ''; ?></textarea></div></td>
								<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'This code will be applied to the current table style.', 'go_pricing_textdomain' ); ?></p></td>
							</tr>						
						</table>
					</div>									
										
				 </div>
			</div>
			<!-- /Admin Box -->
 
 			<!-- Submit -->
			<div class="gwa-submit"><button type="submit" title="<?php esc_attr_e( 'Save', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1 gwa-mr10"><?php _e( 'Save', 'go_pricing_textdomain' ); ?></button><a href="#" data-action="popup" data-alert="<?php echo empty( $postid ) ? esc_attr_e( 'Please save the table first!', 'go_pricing_textdomain' ) : ''; ?>" data-popup="live-preview-edit" data-id="<?php echo esc_attr( !empty( $postid ) ? $postid : 0 ); ?>" data-popup-type="iframe" data-popup-subtitle="<?php echo esc_attr( !empty( $table_data['name'] ) ? $table_data['name'] : '' ); ?>" data-popup-maxwidth="1200" title="<?php esc_attr_e( 'Preview', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style2"><?php _e( 'Preview', 'go_pricing_textdomain' ); ?></a><a href="<?php echo esc_attr( admin_url( 'admin.php?page=go-pricing' ) ); ?>" title="<?php esc_attr_e( 'Go to Dashboard', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style5 gwa-fr"><?php _e( 'Go to Dashboard', 'go_pricing_textdomain' ); ?></a></div>
			<!-- /Submit -->									

			<!-- Column Editor -->	
			<div id="go-pricing-column-editor" class="gwa-abox" data-jump-row="<?php echo esc_attr( !empty( $general_settings['ep-row-jump'] ) ? 'true' : 'false' ); ?>">
				<div id="go-pricing-column-editor-inner">
				<div class="gwa-abox-header gwa-abox-header-has-nav">
	                <div class="gwa-abox-header-tab gwa-current">
						<div class="gwa-abox-header-icon"><i class="fa fa-th-list"></i></div>
						<div class="gwa-abox-title"><?php _e( 'Column Editor', 'go_pricing_textdomain' ); ?> <span><?php echo isset( $table_data['col-data'] ) ? '(' . count( $table_data['col-data'] ) . ')' : '(0)'; ?></span></div>
                        <div class="gwa-abox-header-nav">
                            <a href="#" action="add-col" title="<?php _e( 'Add New Column', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-create">++ <?php _e( 'Add', 'go_pricing_textdomain' ); ?></a>
                            <?php do_action( 'go_pricing_colum_editor_nav_html', isset( $table_data ) ? $table_data : '' ); ?>
                        </div>                        
					</div>
				</div>
				<div class="gwa-abox-content-wrap">			
					<div class="gwa-abox-content">
						<?php do_action( 'go_pricing_colum_editor_content_before_html', isset( $table_data ) ? $table_data : '' ); ?>
						<div class="go-pricing-cols-wrap">					
							<div class="go-pricing-cols gwa-clearfix">
								<!-- Columns -->
								<?php if ( !empty( $table_data['col-data'] ) ) $this->get_column( $table_data ); ?>
								<!-- /Columns -->								
								
								<!-- Add New Column -->
								<div class="go-pricing-col-new"<?php printf( ' style="%s"', isset( $table_data['col-data'] ) && is_array( $table_data['col-data'] ) && count( $table_data['col-data'] ) > 0 ? 'margin-top:48px;' : '' ); ?> data-param-style="<?php echo esc_attr( isset( $table_data['style'] ) ? $table_data['style'] : '' ); ?>"><?php do_action( 'go_pricing_colum_new_assets_html', isset( $table_data ) ? $table_data : '' ); ?>	<a href="#" action-type="add-col" title="<?php _e( 'Add New Column', 'go_pricing_textdomain' ); ?>" class="go-pricing-col-new-link"><span class="go-pricing-col-new-front"></span><span class="go-pricing-col-new-back"></span></a></div>
								<!-- /Add New Column -->
								
							</div>
						</div>
						<?php do_action( 'go_pricing_column_editor_content_after_html', isset( $table_data ) ? $table_data : '' ); ?>						
					</div>
				</div>
			</div>
			</div>
			<!-- /Column Editor -->	
			
			<!-- Submit -->	
			<div class="gwa-submit"><button type="submit" title="<?php esc_attr_e( 'Save', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1 gwa-mr10"><?php _e( 'Save', 'go_pricing_textdomain' ); ?></button><a href="#" data-action="popup" data-alert="<?php echo empty( $postid ) ? esc_attr_e( 'Please save the table first!', 'go_pricing_textdomain' ) : ''; ?>" data-popup="live-preview-edit" data-id="<?php echo esc_attr( !empty( $postid ) ? $postid : 0 ); ?>" data-popup-type="iframe" data-popup-subtitle="<?php echo esc_attr( !empty( $table_data['name'] ) ? $table_data['name'] : '' ); ?>" data-popup-maxwidth="1200" title="<?php esc_attr_e( 'Preview', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style2"><?php _e( 'Preview', 'go_pricing_textdomain' ); ?></a><a href="<?php echo esc_attr( admin_url( 'admin.php?page=go-pricing' ) ); ?>" title="<?php esc_attr_e( 'Go to Dashboard', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style5 gwa-fr"><?php _e( 'Go to Dashboard', 'go_pricing_textdomain' ); ?></a></div>
			<!-- /Submit -->
			
	</form>
</div>
<!-- /Page Content -->