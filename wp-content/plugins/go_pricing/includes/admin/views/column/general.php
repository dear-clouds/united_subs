<?php
/**
 * Column general view
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die; 

global $go_pricing;

ob_start();
?>

<!-- Column Style -->
<?php if ( !empty( $go_pricing['style_types'] ) && count( (array)$go_pricing['style_types'] ) <= 2 ) : ?>
<div class="gwa-col-box gwa-col-box-main">
	<div class="gwa-col-box-header">
		<div class="gwa-col-box-header-icon"><i class="fa fa-bars fa-rotate-90"></i></div>
		<div class="gwa-col-box-title"><?php _e( 'Column Style', 'go_pricing_textdomain' ); ?></div>
	</div>
	<div class="gwa-col-box-content">
		<table class="gwa-table">
			<?php 
			$selected_style = isset( $_POST['param']['style'] ) ? $_POST['param']['style'] : ( isset( $table_data['style'] ) ? $table_data['style'] : 'clean' ); 
			if ( !empty( $go_pricing['style_types'] ) ) : 
			foreach ( (array)$go_pricing['style_types'] as $style_type => $style_type_data ) :
			
			if ( $style_type != $selected_style ) continue;
			?>					
			<tr class="gwa-row-fullwidth">
				<td>
					<select name="col-data[<?php echo $col_index ?>][col-style-type]" class="gwa-img-selector">
						<?php 
						$style_img_src = '';
						foreach ( $style_type_data as $col_style ) : 
						if ( !empty( $col_style['group_name'] ) && !empty( $col_style['group_data'] ) )	:
						?>
						<optgroup label="<?php echo esc_attr( $col_style['group_name'] ); ?>"></optgroup>
						<?php 
						foreach ( (array)$col_style['group_data'] as $col_style ) :
						if ( !empty( $col_style['value'] ) && !empty( $col_style['data'] ) ) {
							if ( empty( $style_img_src ) ) $style_img_src = $col_style['data'];	
							if ( !empty( $col_data['col-style-type'] ) && $col_style['value'] == $col_data['col-style-type'] ) $style_img_src = $col_style['data'];	
						}
						?>
						<option data-type="<?php echo esc_attr( !empty( $col_style['type'] ) ? $col_style['type'] : '' ); ?>" data-src="<?php echo esc_attr( !empty( $col_style['data'] ) ? $col_style['data'] : '' ); ?>" value="<?php echo esc_attr( !empty( $col_style['value'] ) ? $col_style['value'] : '' ); ?>"<?php echo ( !empty( $col_style['value'] )  && !empty ( $col_data['col-style-type'] ) && $col_style['value'] == $col_data['col-style-type'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $col_style['name'] ) ? $col_style['name'] : '' ); ?></option>
						<?php
						endforeach;
						else :
						?>
						<option data-type="<?php echo esc_attr( !empty( $col_style['type'] ) ? $col_style['type'] : '' ); ?>" data-src="<?php echo esc_attr( !empty( $col_style['data'] ) ? $col_style['data'] : '' ); ?>" value="<?php echo esc_attr( !empty( $col_style['value'] ) ? $col_style['value'] : '' ); ?>"<?php echo ( !empty( $col_style['value'] )  && !empty ( $col_data['col-style-type'] ) && $col_style['value'] == $col_data['col-style-type'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $col_style['name'] ) ? $col_style['name'] : '' ); ?></option>
						<?php 
						endif;
						if ( !empty( $col_style['value'] ) && !empty( $col_style['data'] ) ) {
							if ( empty( $style_img_src ) ) $style_img_src = $col_style['data'];	
							if ( !empty( $col_data['col-style-type'] ) && $col_data['col-style-type'] == $col_style['value'] ) $style_img_src = $col_style['data'];
						}
						endforeach;
						?>
					</select>
					<div class="gwa-img-selector-media">
					<?php if ( !empty( $style_img_src ) ) : ?>
					<img src="<?php echo esc_attr( $style_img_src ); ?>">
					<?php endif; ?>					
					</div>
				</td>
				<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Style of the column.', 'go_pricing_textdomain' ); ?></p></td>
			</tr>
			<?php 
			endforeach;
			endif;
			?>
		</table>							
	</div>
</div>
<?php endif; ?>
<!-- / Column Style -->

<!-- Style & Layout -->
<?php
$postdata = array();
$raw_postdata = isset( $table_data['col-data'][$col_index]['layout-style'] ) ? $table_data['col-data'][$col_index]['layout-style'] : '';

/* backward compatibility */
if ( !isset( $table_data['col-data'][$col_index]['layout-style'] ) ) {

	$new_raw_postdata = array();	
	
	if ( !empty( $col_data['col-highlight'] ) ) $new_raw_postdata[] = 'highlight=1';
	if ( !empty( $col_data['col-disable-hover'] ) ) $new_raw_postdata[] = 'disable-hover=1';		
	if ( !empty( $col_data['col-disable-enlarge'] ) ) $new_raw_postdata[] = 'disable-enlarge=1';
	if ( !empty( $col_data['main-color'] ) ) $new_raw_postdata[] = 'main-color=' . str_replace( '#', '%23', $col_data['main-color'] );
	if ( !empty( $new_raw_postdata ) ) $raw_postdata = implode( '&', $new_raw_postdata );
	
}

if ( $raw_postdata !='' && is_string( $raw_postdata ) ) $postdata = GW_GoPricing_Helper::parse_data( $raw_postdata );
?>
<div class="gwa-col-box">
	<a href="#" class="gwa-col-box-link" title="<?php esc_attr_e( 'Layout & Style', 'go_pricing_textdomain' ); ?>" tabindex="-1"></a>
	<div class="gwa-assets-nav"><a href="#" class="gwa-asset-icon-edit" data-action="edit-box" data-popup="general_layout-style" data-popup-subtitle="<?php esc_attr_e( 'Layout & Style Settings', 'go_pricing_textdomain' ); ?>" title="<?php esc_attr_e( 'Edit', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a></div>
	<input type="hidden" name="col-data[<?php echo $col_index ?>][layout-style]" value="<?php echo esc_attr( $raw_postdata ); ?>">    
	<div class="gwa-col-box-header">
		<div class="gwa-col-box-header-icon"><i class="fa fa fa-stack-exchange"></i></div>
		<div class="gwa-col-box-title"><?php _e( 'Layout & Style', 'go_pricing_textdomain' ); ?></div>
	</div>
	<div class="gwa-col-box-help-icon"><i class="fa fa-info"></i></div>
	<div class="gwa-col-box-help">
    	<p><?php _e( 'General Layout and Style Settings', 'go_pricing_textdomain' ); ?></p>
        <p><em><i class="fa fa-lightbulb-o"></i> <?php _e( 'You can set Highlight, Disable hover or Enlarge effect and column styling properties.', 'go_pricing_textdomain' ); ?></em></p> 
    </div>
	<div class="gwa-col-box-content" style="height:auto;">
		<p><?php _e( 'Highlighted', 'go_pricing_textdomain' ); ?>: <span><?php echo !empty( $postdata['highlight'] ) ? '<i class="fa fa-check" style="color:#90c820"></i>': '<i class="fa fa-times" style="color:#fa5541"></i>' ?></span></p>
		<p><?php _e( 'Disable Hover', 'go_pricing_textdomain' ); ?>: <span><?php echo !empty( $postdata['disable-hover'] ) ? '<i class="fa fa-check" style="color:#90c820"></i>': '<i class="fa fa-times" style="color:#fa5541"></i>' ?></span></p>
		<p><?php _e( 'Disable Enlarge', 'go_pricing_textdomain' ); ?>: <span><?php echo !empty(  $postdata['disable-enlarge'] ) ? '<i class="fa fa-check" style="color:#90c820"></i>': '<i class="fa fa-times" style="color:#fa5541"></i>' ?></span></p>	
	</div>
</div>
<!-- / Style & Layout -->

<!-- Decoration -->
<?php
$postdata = array();
$raw_postdata = isset( $table_data['col-data'][$col_index]['decoration'] ) ? $table_data['col-data'][$col_index]['decoration'] : '';
if ( $raw_postdata !='' && is_string( $raw_postdata ) ) $postdata = GW_GoPricing_Helper::parse_data( $raw_postdata );
$setting_shadow = __( 'None', 'go_pricing_textdomain' );
$setting_sign = __( 'None', 'go_pricing_textdomain' );
?>
<div class="gwa-col-box">
	<a href="#" class="gwa-col-box-link" title="<?php esc_attr_e( 'Decoration', 'go_pricing_textdomain' ); ?>" tabindex="-1"></a>
	<div class="gwa-assets-nav"><a href="#" class="gwa-asset-icon-edit" data-action="edit-box" data-popup="general_decoration" data-popup-subtitle="<?php esc_attr_e( 'Shadow & Sign Settings', 'go_pricing_textdomain' ); ?>" title="<?php esc_attr_e( 'Edit', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a></div>
	<input type="hidden" name="col-data[<?php echo $col_index ?>][decoration]" value="<?php echo esc_attr( $raw_postdata ); ?>">
	<div class="gwa-col-box-header">
		<div class="gwa-col-box-header-icon"><i class="fa fa-sun-o"></i></div>
		<div class="gwa-col-box-title"><?php _e( 'Decoration', 'go_pricing_textdomain' ); ?></div>
	</div>
	<div class="gwa-col-box-help-icon"><i class="fa fa-info"></i></div>
	<div class="gwa-col-box-help">
    	<p><?php _e( 'Shadow and Sign Settings', 'go_pricing_textdomain' ); ?></p>
        <p><em><i class="fa fa-lightbulb-o"></i> <?php _e( 'You can create text and image Signs and Ribbons.', 'go_pricing_textdomain' ); ?></em></p>        
    </div>     
	<div class="gwa-col-box-content">
		<?php 
		if ( isset( $postdata['col-shadow'] ) && !empty( $go_pricing['shadows'] ) ) {
			foreach ( (array)$go_pricing['shadows'] as $col_shadow ) {
				if ( $col_shadow['value'] == $postdata['col-shadow'] ) $setting_shadow = $col_shadow['name'];
			}
		}

		if ( isset( $postdata['col-sign-type'] ) && !empty( $go_pricing['sign_types'] ) ) {
			foreach ( (array)$go_pricing['sign_types'] as $sign_type ) {
				if ( !empty( $sign_type['group_name'] ) && !empty( $sign_type['group_data'] ) )	{
					foreach ( (array)$sign_type['group_data'] as $sign ) {
						if ( $sign['id'] == $postdata['col-sign-type'] ) $setting_sign = $sign['name'];
					}
				} else {
					if ( $sign_type['id'] == $postdata['col-sign-type'] ) $setting_sign = $sign_type['name'];
				}
			}
		}
		?>
		<p><?php _e( 'Shadow Style', 'go_pricing_textdomain' ); ?>: <span><?php echo htmlentities( $setting_shadow ); ?></span></p>		
		<p><?php _e( 'Sign Type', 'go_pricing_textdomain' ); ?>: <span><?php echo htmlentities( $setting_sign ); ?></span></p>		
	</div>
</div>
<!-- / Decoration -->

<!-- Animation -->
<?php
$postdata = array();
$raw_postdata = isset( $table_data['col-data'][$col_index]['animation'] ) ? $table_data['col-data'][$col_index]['animation'] : '';
if ( $raw_postdata !='' && is_string( $raw_postdata ) ) $postdata = GW_GoPricing_Helper::parse_data( $raw_postdata );
$setting_shadow = __( 'None', 'go_pricing_textdomain' );
$setting_sign = __( 'None', 'go_pricing_textdomain' );
?>
<div class="gwa-col-box">
	<a href="#" class="gwa-col-box-link" title="<?php esc_attr_e( 'Animation', 'go_pricing_textdomain' ); ?>" tabindex="-1"></a>
	<div class="gwa-assets-nav"><a href="#" class="gwa-asset-icon-edit" data-action="edit-box" data-popup="general_animation" data-popup-subtitle="<?php esc_attr_e( 'Column Animation Settings', 'go_pricing_textdomain' ); ?>" title="<?php esc_attr_e( 'Edit', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a></div>
	<input type="hidden" name="col-data[<?php echo $col_index ?>][animation]" value="<?php echo esc_attr( $raw_postdata ); ?>">
	<div class="gwa-col-box-header">
		<div class="gwa-col-box-header-icon"><i class="fa fa-video-camera"></i></div>
		<div class="gwa-col-box-title"><?php _e( 'Animation', 'go_pricing_textdomain' ); ?></div>
	</div>
	<div class="gwa-col-box-help-icon"><i class="fa fa-info"></i></div>
	<div class="gwa-col-box-help">
    	<p><?php _e( 'Column Animation Settings', 'go_pricing_textdomain' ); ?></p>
        <p><em><i class="fa fa-lightbulb-o"></i> <?php _e( 'You can select the Type, Duration, Delay and Easing of the animation.', 'go_pricing_textdomain' ); ?></em></p>
    </div>     
	<div class="gwa-col-box-content">
    	<?php 
		$selected_trans = __( 'None', 'go_pricing_textdomain' );
		if ( isset( $go_pricing['column-transition'] ) && isset( $postdata['transition'] ) ) {
			foreach ( (array)$go_pricing['column-transition'] as $trans ) {
				if ( !empty( $trans['group_name'] )  && !empty( $trans['group_data'] ) ) {
					foreach ( $trans['group_data'] as $trans_child ) {						
						if ( isset( $trans_child['value'] ) && $trans_child['value'] == $postdata['transition'] ) $selected_trans = $trans_child['name'];
					}
				} else {
					if ( isset( $trans['value'] ) && $trans['value'] == $postdata['transition'] ) $selected_trans = $trans['name'];
				}
			}			
		}
		?>
		<p><?php _e( 'Transition', 'go_pricing_textdomain' ); ?>: <span><?php echo $selected_trans; ?></span></p>
		<p><?php _e( 'Price Counter', 'go_pricing_textdomain' ); ?>: <span><?php echo !empty(  $postdata['counter'] ) ? '<i class="fa fa-check" style="color:#90c820"></i>': '<i class="fa fa-times" style="color:#fa5541"></i>' ?></span></p>
	</div>
</div>
<!-- / Animation -->

<?php
$content = ob_get_clean();
$style = !empty( $_POST['param']['style'] ) ? $_POST['param']['style'] : ( isset( $table_data['style'] ) ? $table_data['style'] : 'clean' );
$content = apply_filters( "go_pricing_admin_column_general_{$style}", $content, ( !empty( $table_data ) ? $table_data : '' ), $col_index );
echo $content;
?>