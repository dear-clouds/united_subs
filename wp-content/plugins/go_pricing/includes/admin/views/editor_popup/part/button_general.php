<?php
/**
 * Editor popup part - Button view
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;
 
?>

<tr>
	<th><label><?php _e( 'Type', 'go_pricing_textdomain' ); ?></label></th>
	<td>
		<select name="button[type]">
			<option value="button"<?php echo !empty ( $postdata['button']['type'] ) && $postdata['button']['type']=='button' ? ' selected="selected"' : ''; ?>><?php _e( 'Regular Button', 'go_pricing_textdomain' ); ?></option>
			<option value="submit"<?php echo !empty ( $postdata['button']['type'] ) && $postdata['button']['type']=='submit' ? ' selected="selected"' : ''; ?>><?php _e( 'Form Submit Button (e.g. Paypal)', 'go_pricing_textdomain' ); ?></option>                                                
			<option value="custom"<?php echo !empty ( $postdata['button']['type'] ) && $postdata['button']['type']=='custom' ? ' selected="selected"' : ''; ?>><?php _e( 'Custom Button', 'go_pricing_textdomain' ); ?></option>                                                
		</select>							
	</td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Type of the button.', 'go_pricing_textdomain' ); ?></p></td>
</tr>
<tr class="gwa-row-fullwidth">
	<th><label><?php _e( 'Text', 'go_pricing_textdomain' ); ?></label></th>
	<td><div class="gwa-textarea-code"><div class="gwa-textarea-btn-top"><a href="#" data-action="popup" data-popup="sc-button-icon" title="<?php _e( 'Add Shortcode', 'go_pricing_textdomain' ); ?>" class="gwa-fr"><i class="fa fa-code"></i></a></div><textarea name="button[content]" rows="5" data-popup="sc-button-icon"  data-editor-height="90" data-editor-type="htmlmixed" data-preview="<?php esc_attr_e( 'Text', 'go_pricing_textdomain' ); ?>"><?php echo isset( $postdata['button']['content'] ) ? esc_textarea( $postdata['button']['content'] ) : '' ; ?></textarea></div>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Text of the "Regular" and "Paypal" buttons. Leave blank for "Custom" buttons.', 'go_pricing_textdomain' ); ?></p></td>
</tr>
<tr class="gwa-row-fullwidth">
	<th><label><?php _e( 'Link / Code', 'go_pricing_textdomain' ); ?></label></th>
	<td><div class="gwa-textarea-code"><textarea name="button[code]" rows="5"  data-editor-height="180" data-editor-type="htmlmixed" data-preview="<?php esc_attr_e( 'Link / Code', 'go_pricing_textdomain' ); ?>"><?php echo isset( $postdata['button']['code'] ) ? esc_textarea( $postdata['button']['code'] ) : '' ; ?></textarea></div></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'URL of the "Regular" button or code of the "Paypal" and "Custom" buttons.', 'go_pricing_textdomain' ); ?></p></td>
</tr>																								
<tr data-parent-id="button[type]" data-parent-value="button"<?php echo ( isset( $postdata['button']['type'] ) && $postdata['button']['type'] == 'button' ) || !isset( $postdata['button']['type'] ) ? ' style="display:none;"' : ''; ?>>
	<th><label><?php _e( 'Open In New Window?', 'go_pricing_textdomain' ); ?></label></th>
	<td><p><label><span class="gwa-checkbox<?php echo isset( $postdata['button']['target'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="button[target]" tabindex="-1" value="1" <?php echo isset( $postdata['button']['target'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to open the link in a new window.', 'go_pricing_textdomain' ); ?></p></td>									
</tr>
<tr data-parent-id="button[type]" data-parent-value="button"<?php  echo ( isset( $postdata['button']['type'] ) && $postdata['button']['type'] == 'button' ) || !isset( $postdata['button']['type'] ) ? ' style="display:none;"' : ''; ?>>
	<th><label><?php _e( 'Nofollow Link?', 'go_pricing_textdomain' ); ?></label></th>
	<td><p><label><span class="gwa-checkbox<?php echo isset( $postdata['button']['nofollow'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="button[nofollow]" tabindex="-1" value="1" <?php echo isset( $postdata['button']['nofollow'] ) ? ' checked="checked"' : ''; ?>></span></label></p></td>                                                                                
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to tell the search engines "Don\'t follow the link".', 'go_pricing_textdomain' ); ?></p></td>
</tr>																														