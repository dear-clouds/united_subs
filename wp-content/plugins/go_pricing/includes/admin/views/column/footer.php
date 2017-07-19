<?php
/**
 * Column footer view
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;
 
?>

<div class="gwa-col-box-wrap">
<?php
for ($x = 0; $x < $footer_row_count; $x++) :

$raw_postdata = isset( $table_data['col-data'][$col_index]['footer-row'][$x] ) ? $table_data['col-data'][$col_index]['footer-row'][$x] : '';
if ( $raw_postdata !='' && is_string( $raw_postdata ) ) {
	$postdata = GW_GoPricing_Helper::parse_data( $raw_postdata );	
} else {
	$postdata = array();
}

$row_type = isset( $postdata['type'] ) ? $postdata['type'] : 'button';

switch( $row_type )	{

	case 'html' :
		$row_type_label = __( 'HTML Content', 'go_pricing_textdomain' );
		break;
		
	case 'button' : 
		$row_type_label = __( 'Button', 'go_pricing_textdomain' );
		break;
		
}
?>
	<div class="gwa-col-box">
		<a href="#" class="gwa-col-box-link" title="<?php esc_attr_e( 'Row', 'go_pricing_textdomain' ); ?>" tabindex="-1" ></a>
		<div class="gwa-assets-nav"><a href="#" class="gwa-asset-icon-edit" data-action="edit-box" data-popup="footer_row" title="<?php esc_attr_e( 'Edit', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a><a href="#" class="gwa-asset-icon-clone" data-action="clone-footer-row" title="<?php esc_attr_e( 'Clone', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a><a href="#" class="gwa-asset-icon-delete" data-action="delete-footer-row" data-confirm="<?php esc_attr_e( 'Are you sure you want to delete the selected row?', 'go_pricing_textdomain' ); ?>" title="<?php esc_attr_e( 'Delete', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a></div>
		<input type="hidden" name="col-data[<?php echo $col_index ?>][footer-row][<?php echo $x; ?>]" value="<?php echo esc_attr( $raw_postdata ); ?>">
		<div class="gwa-col-box-header">
			<div class="gwa-col-box-header-icon"><i class="fa fa-bars"></i></div>
			<div class="gwa-col-box-title"><?php _e( 'Row', 'go_pricing_textdomain' ); ?> <span data="index"><?php echo $x+1; ?></span> (<span data="type"><?php echo !empty ( $row_type_label ) ? $row_type_label : ''; ?></span>)</div>
		</div>
		<div class="gwa-col-box-content">
		<?php 
		switch( $row_type ) {
		
			case 'html' : 
				?>
				<p><?php _e( 'Content', 'go_pricing_textdomain' ); ?>: <span><?php echo isset( $postdata['type'] ) && isset( $postdata[$postdata['type']]['content'] ) && $postdata[$postdata['type']]['content'] != ''  ? htmlentities( $postdata[$postdata['type']]['content'] ) : '-' ?></span></p>
				<?php 
				break;
				
			case 'button' : 
				?>
				<p><?php _e( 'Text', 'go_pricing_textdomain' ); ?>: <span><?php echo isset( $postdata['type'] ) && isset( $postdata[$postdata['type']]['content'] ) && $postdata[$postdata['type']]['content'] != ''  ? htmlentities( $postdata[$postdata['type']]['content'] ) : '-' ?></span></p>
				<p><?php _e( 'Link / Code', 'go_pricing_textdomain' ); ?>: <span><?php echo isset( $postdata['type'] ) && isset( $postdata[$postdata['type']]['code'] ) && $postdata[$postdata['type']]['code'] != ''  ? htmlentities( $postdata[$postdata['type']]['code'] ) : '-' ?></span></p>
				<?php
				break;
		
		}
		?>
		</div>
	</div>
	<?php endfor; ?>
</div>		
<div class="gwa-col-box-add">
	<div class="gwa-col-box-content">							
		<a href="#" data-action="add-footer-row" title="<?php esc_attr_e( 'Add Row', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1"><span class="gwa-icon-add"></span><?php _e( 'Add Row', 'go_pricing_textdomain' ); ?></a>
	</div>									
</div>