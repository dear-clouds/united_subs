<?php 
/**
 * Plugin Update Page
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Get current user id 
$user_id = get_current_user_id();

// Get general settings
$general_settings = get_option( self::$plugin_prefix . '_table_settings' );

// Get pricing tables data
$pricing_tables = GW_GoPricing_Data::get_tables();

$max_upload_size = wp_max_upload_size();
if ( !$max_upload_size ) $max_upload_size = __( 'Unknown', 'go_pricing_textdomain' );

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
	<form id="go-pricing-form" name="plugin-update-form" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="_action" value="update">
        <?php 
		global $go_pricing;
		$products['go_pricing'] = 'Go Pricing - WordPress Responsive Pricing Tables';
		if ( !empty( $go_pricing['addons'] ) ) {
			foreach( $go_pricing['addons'] as $id => $addon ) {
				if ( !empty( $id ) && !empty( $addon['name'] ) ) {
					$products[$id] = $addon['name'];
				}
			}
		}
		?>        
		<?php wp_nonce_field( $this->nonce, '_nonce' ); ?>
		
		<!-- Admin Box -->
		<div class="gwa-abox">
			<div class="gwa-abox-header">
	            <div class="gwa-abox-header-tab gwa-current">
					<div class="gwa-abox-header-icon"><i class="fa fa-plug"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Update Plugin & Add-ons', 'go_pricing_textdomain' ); ?></div>
				</div>
                <div class="gwa-abox-ctrl"></div>
			</div>
			<div class="gwa-abox-content-wrap">
				<div class="gwa-abox-content">
                    <table class="gwa-table">
                        <tr class="gwa-row-fullwidth">
                            <th style="padding-top:4px;">
                            	<p><strong><?php _e( 'Please ensure that your copy is from safe source. Most of downloaded plugins from warez sites include harmful codes, which can endanger your whole site.', 'go_pricing_textdomain' ); ?></strong></p>
                            	<div class="go-pricing-separator go-pricing-separator-big" style="margin-bottom:10px;"></div>
                            </th>
                        </tr>
						<?php 
						$fs_method = get_filesystem_method();
						if ( $fs_method != 'direct' ) : 
						?>
							<div class="gwa-abox-content gwa-abox-content-big">
								<p><strong><?php _e( 'Oops, it seems WordPress has no direct access to the file system, please update the plugin using FTP.', 'go_pricing_textdomain' ); ?></strong></p>
							</div>
						<?php 
						else : 
						?>

						<?php
                        if ( count( $products ) == 1 ) :
                        ?>
                        <input type="hidden" name="product" value="go_pricing">
                        <?php
                        else :
                        ?>
						<tr>
							<th><label><?php _e( 'Select Product', 'go_pricing_textdomain' ); ?></label></th>
                            <td><select name="product">
                        <?php
                        foreach( $products as $id => $product ) : 
                        ?>
                        	<option value="<?php echo esc_attr( $id ); ?>"><?php echo $product; ?></option>
                        <?php
                        endforeach;
                        ?>
                        	</select><td>
                            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Select the product which you want to update.', 'go_pricing_textdomain' ); ?></p></td>									
                        </tr>
                        <?php	
                        endif;
                        ?>                        
						<tr class="gwa-row-fullwidth">
							<th><label><?php _e( 'Plugin Zip File', 'go_pricing_textdomain' ); ?></label></th>
                            <td>
								<div class="gwa-dnd-upload">
									<span class="gwa-dnd-upload-icon-front"></span>
									<span class="gwa-dnd-upload-icon-back"></span>
									<div class="gwa-dnd-upload-label">
										<p><?php _e( 'Drop file here or', 'go_pricing_textdomain' ); ?></p>
										<p><input type="file" name="plugin-data" data-max-size="<?php echo esc_attr( $max_upload_size );?>" data-allowed-ext="zip"><a href="#" data-action="dnd-upload" title="<?php esc_attr_e( 'Select File', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1"><?php _e( 'Select File', 'go_pricing_textdomain' ); ?></a></p>
									</div>
								</div>							
							</td>
							<td>
                            <p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Downgrading (uploading older versions) is not supported.', 'go_pricing_textdomain' ); ?><br></p>
                            <p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'For older browsers or with disabled AJAX, please use the "Select File" button to upload files.', 'go_pricing_textdomain' ); ?><br><?php printf( __( 'Maximum file size: %s.', 'go_pricing_textdomain' ), '<strong>' . size_format( $max_upload_size ) ) . '</strong>'; ?></p></td>
						</tr>                        
						<?php 
						endif;
						?>															
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