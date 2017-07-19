<?php
/**
 * Editor popup - Header general view
 */

// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;
 
// Get column type
$col_type = isset( $_POST['col_type'] ) ? $_POST['col_type'] : '';  
$skin = isset( $_POST['skin'] ) ? sanitize_key( $_POST['skin'] ) : 'clean';
$action_type = isset( $_POST['_action_type'] ) ? sanitize_key( $_POST['_action_type'] ) : '';
?>

<!-- Specific Settings -->
<?php 
ob_start();
switch ( $col_type ) {
	case 'pricing3'	:
	case 'team' :
	case 'product' :
	case 'cpricing3' :
	case 'cteam' :
	case 'cproduct' :
	?>
	<tr>
		<th><label><?php _e( 'Background Image', 'go_pricing_textdomain' ); ?></label></th>
		<td>
			<div class="gwa-img-upload">
				<div class="gwa-img-upload-media"<?php echo empty( $postdata['custom']['img']['data'] ) ? ' style="display:none;"' : ''; ?>>
					<?php if ( !empty( $postdata['custom']['img']['data'] ) ) : ?>
					<span class="gwa-img-upload-media-container"><a href="#" title="<?php esc_attr_e( 'Remove', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-remove"></a><a href="#" title="<?php esc_attr_e( 'Preview', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-popup" data-action="popup" data-popup="image-preview" data-popup-type="image" data-popup-subtitle="<?php echo esc_attr( $postdata['custom']['img']['data'] ); ?>" data-id="<?php echo esc_attr( $postdata['custom']['img']['data'] ); ?>" data-popup-maxwidth="auto"><img src="<?php echo esc_attr( $postdata['custom']['img']['data'] ); ?>"></a></span>
					<p><label><span class="gwa-checkbox<?php echo !empty( $postdata['custom']['img']['responsive'] ) || empty( $postdata['custom']['img']['data'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="custom[img][responsive]" tabindex="-1" value="1" <?php echo !empty( $postdata['custom']['img']['responsive'] ) || empty( $postdata['custom']['img']['data'] ) ? ' checked="checked"' : ''; ?>></span><?php _e( 'Responsive image?', 'go_pricing_textdomain' ); ?></label></p>
					<?php else : ?>
					<a href="#" title="<?php esc_attr_e( 'Remove', 'go_pricing_textdomain' ); ?>" class="gwa-img-upload-media-remove"></a>
					<p><label><span class="gwa-checkbox<?php echo !empty( $postdata['custom']['img']['responsive'] ) || empty( $postdata['custom']['img']['data'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="custom[img][responsive]" tabindex="-1" value="1" <?php echo !empty( $postdata['custom']['img']['responsive'] ) || empty( $postdata['custom']['img']['data'] ) ? ' checked="checked"' : ''; ?>></span><?php _e( 'Responsive image?', 'go_pricing_textdomain' ); ?></label></p>					
					<?php endif; ?>							
				</div>
				<input type="hidden" name="custom[img][alt]" data-attr="alt" value="<?php echo ( !empty( $postdata['custom']['img']['alt'] ) ? esc_attr( $postdata['custom']['img']['alt'] ) : '' ); ?>">
				<input type="hidden" name="custom[img][width]" data-attr="width" value="<?php echo ( !empty( $postdata['custom']['img']['width'] ) ? esc_attr( $postdata['custom']['img']['width'] ) : '' ); ?>">
				<input type="hidden" name="custom[img][height]" data-attr="height" value="<?php echo ( !empty( $postdata['custom']['img']['height'] ) ? esc_attr( $postdata['custom']['img']['height'] ) : '' ); ?>">					
				<div class="gwa-input-btn"<?php echo ( !empty( $postdata['custom']['img']['data'] ) ? 'style="display:none;"': '' ); ?>><input type="text" name="custom[img][data]" value="<?php echo ( !empty( $postdata['custom']['img']['data'] ) ? esc_attr( $postdata['custom']['img']['data'] ) : '' ); ?>"><a href="#" title="<?php esc_attr_e( 'Add', 'go_pricing_textdomain' ); ?>" data-action="img-upload"><span class="gwa-icon-add"></span></a></div>
			</div>
		</td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Background image of the header.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>	
	<?php
	break;
	
}

switch ( $col_type ) {
	case 'pricing2' :
	case 'cpricing2' :	
	?>
	<tr class="gwa-row-fullwidth">
		<th><label><?php _e( 'HTML Content', 'go_pricing_textdomain' ); ?></label></th>
		<td><div class="gwa-textarea-code"><div class="gwa-textarea-btn-top"><a href="#" data-action="popup" data-popup="sc-media" title="<?php _e( 'Add Shortcode', 'go_pricing_textdomain' ); ?>" class="gwa-fr"><i class="fa fa-code"></i></a></div><textarea name="custom[html]" rows="5" data-editor-height="180" data-editor-type="htmlmixed" data-popup="sc-media"><?php echo isset( $postdata['custom']['html'] ) ? esc_textarea( $postdata['custom']['html'] ) : '' ; ?></textarea></div>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'HTML content of the header.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>	
	<?php
	break;
}

switch ( $col_type ) {
	case 'pricing2'	:
	case 'pricing3' :
	case 'team' :
	case 'cpricing2' :
	case 'cpricing3' :	
	case 'cteam' :	
	?>
	<tr class="gwa-row-fullwidth">
		<th><label><?php _e( 'CSS Code', 'go_pricing_textdomain' ); ?></label></th>
		<td><div class="gwa-textarea-code"><textarea name="custom[css]" rows="5" data-editor-height="180" data-editor-type="css"><?php echo isset( $postdata['custom']['css'] ) ? esc_textarea( $postdata['custom']['css'] ) : '' ; ?></textarea></div></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'CSS code of the header.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>	
	<?php
	break;
}
$content = ob_get_clean();
if ($content != '') : ?>
<div class="gwa-section"><span><?php _e( 'Type Specific Settings', 'go_pricing_textdomain' ); ?></span></div>
<table class="gwa-table">
<?php echo $content; ?>
</table>
<div class="gwa-table-separator"></div>
<div class="gwa-section"><span><?php _e( 'General Settings', 'go_pricing_textdomain' ); ?></span></div>
<?php endif; ?>
<!-- Specific Settings -->

<!-- General Settings -->

<table class="gwa-table">
<?php
switch ( $col_type ) {
	case 'pricing'	:
	case 'pricing2'	:
	case 'pricing3' :
	case 'team' :
	case 'product' :
	case 'cpricing'	:
	case 'cpricing2' :
	case 'cpricing3' :
	case 'cteam' :
	case 'cproduct' :
	?>
	<tr>
		<th><label><?php _e( 'Replace Header?', 'go_pricing_textdomain' ); ?></label></th>
		<td><p><label><span class="gwa-checkbox<?php echo !empty( $postdata['replace'] ) ? ' gwa-checked' : ''; ?>" tabindex="0"><span></span><input type="checkbox" name="replace" tabindex="-1" value="1" <?php echo !empty( $postdata['replace'] ) ? ' checked="checked"' : ''; ?> data-preview="<?php _e( 'HTML / Custom header', 'go_pricing_textdomain' ); ?>"></span></label></p></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to replace to origianal header with custom HTML & CSS code.', 'go_pricing_textdomain' ); ?></p></td>									
	</tr>			
	<?php
	break;
}
?>
	<tr class="gwa-row-fullwidth">
		<th><label><?php _e( 'HTML Content', 'go_pricing_textdomain' ); ?></label></th>
		<td><div class="gwa-textarea-code"><div class="gwa-textarea-btn-top"><a href="#" data-action="popup" data-popup="sc-media" title="<?php _e( 'Add Shortcode', 'go_pricing_textdomain' ); ?>" class="gwa-fr"><i class="fa fa-code"></i></a></div><textarea name="html" rows="5" data-editor-height="180" data-editor-type="htmlmixed" data-popup="sc-media"><?php echo isset( $postdata['html'] ) ? esc_textarea( $postdata['html'] ) : '' ; ?></textarea></div>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'HTML content of the header.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>
	<tr class="gwa-row-fullwidth">
		<th><label><?php _e( 'CSS Code', 'go_pricing_textdomain' ); ?></label></th>
		<td><div class="gwa-textarea-code"><textarea name="css" rows="5" data-editor-height="180" data-editor-type="css"><?php echo isset( $postdata['html'] ) ? esc_textarea( $postdata['css'] ) : '' ; ?></textarea></div></td>
		<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'CSS code of the header.', 'go_pricing_textdomain' ); ?></p></td>
	</tr>
</table>
<!-- / General Settings -->

<?php
$content = ob_get_clean();
$content = apply_filters( "go_pricing_admin_editor_popup_{$action_type}_{$skin}", $content, ( !empty( $postdata ) ? $postdata : '' ) );
echo $content;
?>
