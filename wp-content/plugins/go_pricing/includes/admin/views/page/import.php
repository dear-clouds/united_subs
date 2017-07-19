<?php
/**
 * Import & Export Page - Import View
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;

// Get current user id
$user_id = get_current_user_id();
 
// Get general settings
$general_settings = get_option( self::$plugin_prefix . '_table_settings' );

// Get temporary postdata
$data = $this->get_temp_postdata();
$this->delete_temp_postdata();

if ( $data === false || empty( $data['data'] ) || empty( $data['file'] ) ) return;

?>
<!-- Top Bar -->
<div class="gwa-ptopbar">
	<div class="gwa-ptopbar-icon"></div>
	<div class="gwa-ptopbar-title">Go Pricing</div>
	<div class="gwa-ptopbar-content"><label><span class="gwa-label"><?php _e( 'Help', 'go_pricing_textdomain' ); ?></span><select data-action="help" class="gwa-w90"><option value="1"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 1 ? ' selected="selected"' : ''; ?>><?php _e( 'Tooltip', 'go_pricing_textdomain' ); ?></option><option value="2"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 2 ? ' selected="selected"' : ''; ?>><?php _e( 'Show', 'go_pricing_textdomain' ); ?></option><option value="0"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 0 ? ' selected="selected"' : ''; ?>><?php _e( 'None', 'go_pricing_textdomain' ); ?></option></select></label><div class="gwa-abox-header-nav"><a data-action="submit" href="#" title="<?php esc_attr_e( 'Next', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-next"><?php _e( 'Next', 'go_pricing_textdomain' ); ?></a></div>
    </div>
</div>
<!-- /Top Bar -->

<!-- Page Content -->
<div class="gwa-pcontent" data-ajax="<?php echo esc_attr( isset( $general_settings['admin']['ajax'] ) ? "true" : "false" ); ?>" data-help="<?php echo esc_attr( isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['help'][$user_id] : '' ); ?>">
	<form id="go-pricing-form" name="import-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="_action" value="import">
		<input type="hidden" name="import-data" value="<?php echo esc_attr( $data['file'] ); ?>">
		<?php wp_nonce_field( $this->nonce, '_nonce' ); ?>
		
		<!-- Admin Box -->
		<div class="gwa-abox">
			<div class="gwa-abox-header">
            	<div class="gwa-abox-header-tab gwa-current">
					<div class="gwa-abox-header-icon"><i class="fa fa-sign-in"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Import', 'go_pricing_textdomain' ); ?></div>
                </div>
				<div class="gwa-abox-ctrl"></div>
			</div>            
			<div class="gwa-abox-content-wrap">
				<div class="gwa-abox-content">
					<table class="gwa-table">							
						<tr class="go-pricing-group" data-parent="import-export" data-children="export">
							<th><label><?php printf( __( 'Select Tables%s', 'go_pricing_textdomain' ), sprintf( ' <span class="gwa-info">(%d)</span>', is_array( $data['data'] ) ? count( $data['data'] ) : 0 ) ); ?></label></th>
							<td>
							<?php if ( !empty( $data['data'] ) ) : ?>
							<ul class="gwa-checkbox-list">
								<li><label><span class="gwa-checkbox gwa-checked" tabindex="0"><span></span><input type="checkbox" name="import[]" value="all" checked="checked" class="gwa-checkbox-parent"></span><?php _e( 'All tables', 'go_pricing_textdomain' ); ?></label><span class="gwa-checkbox-list-toggle"></span>
									<ul class="gwa-checkbox-list">
										<?php foreach( $data['data'] as $pricing_table_key => $pricing_table ) : ?>
										<li><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="import[<?php echo esc_attr( $pricing_table_key ); ?>]" value="<?php echo esc_attr( $pricing_table_key ); ?>"></span><?php echo $pricing_table; ?></label>
										<?php endforeach; ?>
									</ul>
								</li>	
							</ul>							
							<?php else : ?>
							<p><?php _e( 'No tables found.', 'go_pricing_textdomain' ); ?></p>
							<?php endif; ?>
							</td>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Select the pricing tables you would like to import.', 'go_pricing_textdomain' ); ?></p></td>
						</tr>
						<tr>
							<th><label><?php _e( 'Replace existing items?', 'go_pricing_textdomain' ); ?></label></strong></th>
							<td><p><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="replace" value="1"></span><?php _e( 'Yes', 'go_pricing_textdomain' ); ?></label></p></td>
							<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Whether to replace existing items with same ids or create new copy of them.', 'go_pricing_textdomain' ); ?></p></td>									
						</tr>												
					</table>			
				</div>
			 </div>
		</div>
		<!-- /Admin Box -->
		
		<!-- Submit -->
		<div class="gwa-submit"><button type="submit" class="gwa-btn-style1"><?php _e( 'Next', 'go_pricing_textdomain' ); ?></button></div>
		<!-- /Submit -->
		
	</form>
</div>
<!-- /Page Content -->