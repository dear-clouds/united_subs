<?php
/**
 * Style definition - clean styles
 */

add_action( 'go_pricing_admin_global_style_opts_clean', 'go_pricing_global_table_style_clean' );

function go_pricing_global_table_style_clean( $table_data ) {
	
	?>
	<div class="gwa-table-separator"></div>
	<table class="gwa-table">
        <tr>
            <th><label><?php _e( 'Enable Column Borders?', 'go_pricing_textdomain' ); ?></label></th>
            <td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['col-border'] ) || empty( $table_data ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="col-border" tabindex="-1" value="1" <?php echo !empty( $table_data['col-border'] ) || empty( $table_data ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to enable or disable borders of the columns.', 'go_pricing_textdomain' ); ?></p></td>
        </tr>				
        <tr>
            <th><label><?php _e( 'Column Border Radius', 'go_pricing_textdomain' ); ?> <span class="gwa-info">(px)</span></label></th>
            <td><input type="text" name="col-border-radius[top]" value="<?php echo esc_attr( isset( $table_data['col-border-radius']['top'] ) ? (int)$table_data['col-border-radius']['top'] : 0 ); ?>" class="gwa-input-mid"><input type="text" name="col-border-radius[right]" value="<?php echo esc_attr( isset( $table_data['col-border-radius']['right'] ) ? (int)$table_data['col-border-radius']['right'] : 0 ); ?>" class="gwa-input-mid"><input type="text" name="col-border-radius[bottom]" value="<?php echo esc_attr( isset( $table_data['col-border-radius']['bottom'] ) ? (int)$table_data['col-border-radius']['bottom'] : 0 ); ?>" class="gwa-input-mid"><input type="text" name="col-border-radius[left]" value="<?php echo esc_attr( isset( $table_data['col-border-radius']['left'] ) ? (int)$table_data['col-border-radius']['left'] : 0 ); ?>" class="gwa-input-mid"></td>
            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Top, Right, Bottom and Left border radius of the columns in pixels.', 'go_pricing_textdomain' ); ?></p></td>
        </tr>
        <tr>
            <th><label><?php _e( 'Enable Row Borders?', 'go_pricing_textdomain' ); ?></label></th>
            <td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['col-row-border'] ) || empty( $table_data ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="col-row-border" tabindex="-1" value="1" <?php echo !empty( $table_data['col-row-border'] ) || empty( $table_data ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to enable or disable row separator borders.', 'go_pricing_textdomain' ); ?></p></td>
        </tr>
        <tr>
            <th><label><?php _e( 'Enable Box Shadow?', 'go_pricing_textdomain' ); ?></label></th>
            <td><p><label><span class="gwa-checkbox<?php echo !empty( $table_data['col-box-shadow'] ) || empty( $table_data ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="col-box-shadow" tabindex="-1" value="1" <?php echo !empty( $table_data['col-box-shadow'] ) || empty( $table_data ) ? ' checked="checked"' : ''; ?>></span></label></p></td>
            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to enable or disable shadow of the columns on hover/highlighted state.', 'go_pricing_textdomain' ); ?></p></td>
        </tr>						
	</table>
	<?php	
}