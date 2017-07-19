<?php 
/**
 * Import & Export Page - Main View
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

$tab = isset( $_GET['tab'] ) && $_GET['tab'] == 'export' ? 'export' : 'import';
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
	<form id="go-pricing-form" name="impex-form" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="_action" value="impex">
        <input type="hidden" name="_action_type" value="import">
		<?php wp_nonce_field( $this->nonce, '_nonce' ); ?>
		
		<!-- Admin Box -->
		<div class="gwa-abox">
			<div class="gwa-abox-header gwa-abox-header-tabs">
				<div class="gwa-abox-header-tab<?php echo ( $tab == 'import' ? ' gwa-current' : '' ) ; ?>" data-action-type="import">
					<div class="gwa-abox-header-icon"><i class="fa fa-sign-in"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Import', 'go_pricing_textdomain' ); ?></div>
				</div>
				<div class="gwa-abox-header-tab<?php echo ( $tab == 'export' ? ' gwa-current' : '' ) ; ?>" data-action-type="export">
					<div class="gwa-abox-header-icon"><i class="fa fa-sign-in fa-flip-horizontal"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Export', 'go_pricing_textdomain' ); ?></div>
				</div>
                <div class="gwa-abox-ctrl"></div>
            </div>				
			<div class="gwa-abox-content-wrap gwa-abox-tab-contents">
				<div class="gwa-abox-content gwa-abox-tab-content<?php echo ( $tab == 'import' ? ' gwa-current' : '' ) ; ?>">
                    <table class="gwa-table">
                        <tr class="gwa-row-fullwidth" data-parent-id="_action_type" data-parent-value="import"<?php echo !empty( $_action_type ) && $_action_type != 'import' ? ' style="display:none;"' : '' ?>>
                            <th><label><?php _e( 'Import Data File', 'go_pricing_textdomain' ); ?></label></th>
                            <td>
                                <div class="gwa-dnd-upload">
                                    <span class="gwa-dnd-upload-icon-front"></span>
                                    <span class="gwa-dnd-upload-icon-back"></span>
                                    <div class="gwa-dnd-upload-label">
                                        <p><?php _e( 'Drop file here or', 'go_pricing_textdomain' ); ?></p>
                                        <p><input type="file" name="import-data" data-max-size="<?php echo esc_attr( $max_upload_size );?>" data-allowed-ext="txt"><a href="#" data-action="dnd-upload" title="<?php esc_attr_e( 'Select File', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1"><?php _e( 'Select File', 'go_pricing_textdomain' ); ?></a></p>
                                    </div>
                                </div>							
                            </td>
                            <td><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'For older browsers or with disabled AJAX, please use the "Select File" button to upload files.', 'go_pricing_textdomain' ); ?><br><?php printf( __( 'Maximum file size: %s.', 'go_pricing_textdomain' ), '<strong>' . size_format( $max_upload_size ) ) . '</strong>'; ?></p></td>
                        </tr>
                    </table>																																																			
				</div>
				<div class="gwa-abox-content gwa-abox-tab-content<?php echo ( $tab == 'export' ? ' gwa-current' : '' ) ; ?>">				
                    <table class="gwa-table">				
                        <tr>
                            <th><label><?php printf ( __( 'Select Tables%s', 'go_pricing_textdomain' ), sprintf( ' <span class="gwa-info">(%d)</span>', is_array( $pricing_tables ) ? count( $pricing_tables ) : 0 ) ); ?></label></th>
                            <td>
                            <?php if ( !empty( $pricing_tables ) ) : ?>
                            <ul class="gwa-checkbox-list gwa-closed">
                                <li><label><span class="gwa-checkbox gwa-checked" tabindex="0"><span></span><input type="checkbox" name="export[]" value="all" checked="checked" class="gwa-checkbox-parent"></span><?php _e( 'All tables', 'go_pricing_textdomain' ); ?></label><a href="#" title="<?php esc_attr_e( 'Show / Hide', 'go_pricing_textdomain' ); ?>" class="gwa-checkbox-list-toggle"></a>
                                    <ul class="gwa-checkbox-list">
                                        <?php 
                                        foreach( (array)$pricing_tables as  $pricing_table_key=>$pricing_table ) : 
                                        ?>
                                        <li><label><span class="gwa-checkbox" tabindex="0"><span></span><input type="checkbox" name="export[]" value="<?php echo esc_attr( $pricing_table_key ); ?>"></span><?php echo $pricing_table['name']; ?></label>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>	
                            </ul>							
                            <?php else: ?>
                            <p><?php _e( 'No tables found.', 'go_pricing_textdomain' ); ?></p>
                            <?php endif; ?>
                            </td>
                            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Select the pricing tables you would like to export.', 'go_pricing_textdomain' ); ?></p></td>
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