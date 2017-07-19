<?php
/**
 * Editor popup part - Button view
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;
 
?>

<tr>
	<th><label><?php _e( 'Size', 'go_pricing_textdomain' ); ?></label></th>
	<td>
		<select name="button[size]">
			<option value="small"<?php echo !empty ( $postdata['button']['size'] ) && $postdata['button']['size']=='small' ? ' selected="selected"' : ''; ?>><?php _e( 'Small', 'go_pricing_textdomain' ); ?></option>
			<option value="medium"<?php echo ( !empty ( $postdata['button']['size'] ) && $postdata['button']['size']=='medium' ) ||  empty ( $postdata['button']['size'] ) ? ' selected="selected"' : ''; ?>><?php _e( 'Medium', 'go_pricing_textdomain' ); ?></option>
			<option value="large"<?php echo !empty ( $postdata['button']['size'] ) && $postdata['button']['size']=='large' ? ' selected="selected"' : ''; ?>><?php _e( 'Large', 'go_pricing_textdomain' ); ?></option>
		</select>							
	</td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Size of the button.', 'go_pricing_textdomain' ); ?></p></td>
</tr>
<tr>
	<th><label><?php _e( 'Font Family', 'go_pricing_textdomain' ); ?></label></th>
	<td>
		<select name="button[font-family]">
			<?php 
			foreach ( (array)$go_pricing['fonts'] as $fonts ) : 
			if ( !empty( $fonts['group_name'] ) )	:
			?>
			<optgroup label="<?php echo esc_attr( $fonts['group_name'] ); ?>"></optgroup>
			<?php 
			foreach ( (array)$fonts['group_data'] as $font_data ) :
			?>
			<option value="<?php echo esc_attr( !empty( $font_data['value'] ) ? $font_data['value'] : '' ); ?>"<?php echo ( !empty( $font_data['value'] ) && isset( $postdata['button']['font-family'] ) && $font_data['value'] == $postdata['button']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $font_data['name'] ) ? $font_data['name'] : '' ); ?></option>
			<?php
			endforeach;
			else :
			?>
			<option value="<?php echo esc_attr( !empty( $fonts['value'] ) ? $fonts['value'] : '' ); ?>"<?php echo ( !empty( $fonts['value'] ) && isset( $postdata['button']['font-family'] ) && $fonts['value'] == $postdata['button']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $fonts['name'] ) ? $fonts['name'] : '' ); ?></option>
			<?php 
			endif;
			endforeach;
			?>
		</select>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font family of the button.', 'go_pricing_textdomain' ); ?></p></td>
</tr>
<tr>
	<th><label><?php _e( 'Font Size / Line H.', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
	<td><input type="text" name="button[font-size]" value="<?php echo !empty( $postdata['button']['font-size'] ) ? esc_attr( $postdata['button']['font-size'] ) : 12; ?>" class="gwa-input-mid"><input type="text" name="button[line-height]" value="<?php echo !empty( $postdata['button']['line-height'] ) ? esc_attr( $postdata['button']['line-height'] ) : 16; ?>" class="gwa-input-mid"><div class="gwa-icon-btn"><a href="#" title="<?php esc_attr_e( 'Bold', 'go_pricing_textdomain' ); ?>" data-action="font-style-bold"<?php echo !empty( $postdata['button']['font-style']['bold'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-bold"></i><input type="hidden" name="button[font-style][bold]" value="<?php echo !empty( $postdata['button']['font-style']['bold'] ) ? esc_attr( $postdata['button']['font-style']['bold'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Italic', 'go_pricing_textdomain' ); ?>" data-action="font-style-italic"<?php echo !empty( $postdata['button']['font-style']['italic'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-italic"></i><input type="hidden" name="button[font-style][italic]" value="<?php echo !empty( $postdata['button']['font-style']['italic'] ) ? esc_attr( $postdata['button']['font-style']['italic'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Strikethrough', 'go_pricing_textdomain' ); ?>" data-action="font-style-strikethrough"<?php echo !empty( $postdata['button']['font-style']['strikethrough'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-strikethrough"></i><input type="hidden" name="button[font-style][strikethrough]" value="<?php echo !empty( $postdata['button']['font-style']['strikethrough'] ) ? esc_attr( $postdata['button']['font-style']['strikethrough'] ) : ''; ?>"></a></div></td>
	<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font size and line height of the button in pixels.', 'go_pricing_textdomain' ); ?></p></td>
</tr>																													