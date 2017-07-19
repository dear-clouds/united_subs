<?php 
/**
 * DB Update Page
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Get current user id
$user_id = get_current_user_id();

// Get general settings
$general_settings = get_option( self::$plugin_prefix . '_table_settings' );

// Get old pricing tables data
$old_db_tables = get_option( self::$plugin_prefix . '_tables' );

?>
<!-- Top Bar -->
<div class="gwa-ptopbar">
	<div class="gwa-ptopbar-icon"></div>
	<div class="gwa-ptopbar-title">Go Pricing</div>
	<div class="gwa-ptopbar-content"><label><span class="gwa-label"><?php _e( 'Help', 'go_pricing_textdomain' ); ?></span><select data-action="help" class="gwa-w90"><option value="1"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 1 ? ' selected="selected"' : ''; ?>><?php _e( 'Tooltip', 'go_pricing_textdomain' ); ?></option><option value="2"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 2 ? ' selected="selected"' : ''; ?>><?php _e( 'Show', 'go_pricing_textdomain' ); ?></option><option value="0"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 0 ? ' selected="selected"' : ''; ?>><?php _e( 'None', 'go_pricing_textdomain' ); ?></option></select></label><a href="#" data-action="submit" title="<?php esc_attr_e( 'Next', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1 gwa-ml20"><?php _e( 'Update', 'go_pricing_textdomain' ); ?></a></div>
</div>
<!-- / Top Bar -->

<!-- Page Content -->
<div class="gwa-pcontent" data-ajax="false" data-help="<?php echo esc_attr( isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['help'][$user_id] : '' ); ?>">
	<form id="go-pricing-form" name="db-update-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="_action" value="db_update">
		<?php wp_nonce_field( $this->nonce, '_nonce' ); ?>

		<!-- Admin Box -->
		<div class="gwa-abox">
			<div class="gwa-abox-header">
				<div class="gwa-abox-header-icon"><i class="fa fa-database"></i></div>
				<div class="gwa-abox-title"><?php _e( 'Database Update', 'go_pricing_textdomain' ); ?></div>
				<div class="gwa-abox-ctrl"></div>
			</div>
			<div class="gwa-abox-content-wrap">
				<div class="gwa-abox-content">
					<table class="gwa-table">
						<tr class="gwa-row-fullwidth">
							<td>
								<p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( '<strong>Your plugin database update is required.</strong> Create a backup of your existing table data first, then click to the "Update" button.', 'go_pricing_textdomain' ); ?></p>
							</td>					
						</tr>
						<tr class="gwa-row-fullwidth">
							<th><label><?php _e( 'Export Data', 'go_pricing_textdomain' ); ?></label></strong></th>
							<td><textarea rows="10"><?php echo  !empty( $old_db_tables ) ? esc_textarea( base64_encode( serialize( $old_db_tables ) ) ) : ''; ?></textarea></td>
							<td><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Copy the content of the textarea and save into a file on your hard drive.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>
					</table>			
				</div>
			 </div>
		</div>
		<!-- /Admin Box -->
	
		<!-- Submit -->
		<div class="gwa-submit"><button type="submit" class="gwa-btn-style1"><?php _e( 'Update', 'go_pricing_textdomain' ); ?></button></div>
		<!-- /Submit -->
		
	</form>	

</div>
<!-- /Page Content -->