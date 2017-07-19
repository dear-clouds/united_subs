<?php 
/**
 * Table Manager Page
 */


// Get plugin global
global $go_pricing;

// Get current user id
$user_id = get_current_user_id();

// Get general settings
$general_settings = get_option( self::$plugin_prefix . '_table_settings' );

$table_order = isset( $_POST['_order'] ) ? $_POST['_order'] : ( isset( $_COOKIE['go_pricing']['settings']['tm']['order'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['tm']['order'][$user_id] : '' );
$table_orderby = isset( $_POST['_orderby'] ) ? $_POST['_orderby'] : ( isset( $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] : '' );

// Get table order
if ( !empty( $table_order ) && !empty( $table_orderby ) ) {
	$pricing_tables = GW_GoPricing_Data::get_tables( '', false, $table_orderby, $table_order );
} else {
	$pricing_tables = GW_GoPricing_Data::get_tables();
}	

?>
<!-- Top Bar -->
<div class="gwa-ptopbar">
	<div class="gwa-ptopbar-icon"></div>
	<div class="gwa-ptopbar-title">Go Pricing</div>
	<div class="gwa-ptopbar-content"><label><span class="gwa-label"><?php _e( 'Rows', 'go_pricing_textdomain' ); ?></span><select data-action="tm-rows" class="gwa-w80"><option value="3"<?php echo isset( $_COOKIE['go_pricing']['settings']['tm-rows'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm-rows'][$user_id] == 3 ? ' selected="selected"' : ''; ?>>3</option><option value="5"<?php echo isset( $_COOKIE['go_pricing']['settings']['tm-rows'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm-rows'][$user_id] == 5 ? ' selected="selected"' : ''; ?>>5</option><option value="10"<?php echo isset( $_COOKIE['go_pricing']['settings']['tm-rows'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm-rows'][$user_id] == 10 ? ' selected="selected"' : ''; ?>>10</option></select></label></div>
</div>
<!-- /Top Bar -->

<!-- Page Content -->
<div class="gwa-pcontent" data-ajax="<?php echo esc_attr( isset( $general_settings['admin']['ajax'] ) ? "true" : "false" ); ?>" data-help="<?php echo esc_attr( isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['help'][$user_id] : '' ); ?>">
	<form id="go-pricing-form" name="tm-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="_action" value="table_manager">
		<input type="hidden" id="action-type" name="_action_type" value="create">
		<?php wp_nonce_field( $this->nonce, '_nonce' ); ?>
		
		<?php 
		if ( isset( $_COOKIE['go_pricing']['settings']['tm-rows'][$user_id] ) ) {
			switch ( $_COOKIE['go_pricing']['settings']['tm-rows'][$user_id] ) {
				case 5 :	
					$abox_header_class = 'gwa-thumbs-rows5';
					break;
					
				case 10 :	
					$abox_header_class = 'gwa-thumbs-rows10';
					break;

				default:
					$abox_header_class = '';
					
			}
		}
		?>
		<!-- Admin Box -->
		<div id="go-pricing-table-manager" class="gwa-abox<?php echo ( !empty( $abox_header_class ) ? ' ' . $abox_header_class : '' ); ?>" data-cnt="<?php echo !empty( $pricing_tables ) ? count( $pricing_tables ) : '0'; ?>" data-filtered-cnt="0">
			<div class="gwa-abox-header gwa-abox-header-has-nav">
	            <div class="gwa-abox-header-tab gwa-current">
					<div class="gwa-abox-header-icon"><i class="fa fa-tachometer"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Dashboard', 'go_pricing_textdomain' ); ?> <span><?php echo !empty( $pricing_tables ) ? '(' . count( $pricing_tables ) . ')' : '(0)'; ?></span></div>
	                <div class="gwa-abox-header-nav">
                    	<a href="#" data-action="create" title="++ <?php esc_attr_e( 'Create', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-create">++ <?php _e( 'Create', 'go_pricing_textdomain' ); ?></a>
                        <a href="<?php echo esc_attr( admin_url( 'admin.php?page=go-pricing-import-export&tab=import' ) ); ?>" title="<?php esc_attr_e( 'Import', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-import"><?php _e( 'Import', 'go_pricing_textdomain' ); ?></a>
                        <a href="<?php echo esc_attr( admin_url( 'admin.php?page=go-pricing-import-export&tab=export' ) ); ?>" title="<?php esc_attr_e( 'Export', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-export"><?php _e( 'Export', 'go_pricing_textdomain' ); ?></a>
                        <a href="https://granth.ticksy.com/articles/10236/" target="_blank" title="<?php esc_attr_e( 'Help', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-help"><?php _e( 'Help', 'go_pricing_textdomain' ); ?></a>
                        <a href="<?php echo esc_attr( admin_url( 'admin.php?page=go-pricing-settings' ) ); ?>" title="<?php esc_attr_e( 'Settings', 'go_pricing_textdomain' ); ?>" class="gwa-abox-header-nav-settings"><?php _e( 'Settings', 'go_pricing_textdomain' ); ?></a>
                    </div>                      
	                <div class="gwa-abox-header-info"><label class="gwa-fl"><span class="gwa-label"><?php _e( 'Shortcode', 'go_pricing_textdomain' ); ?></span><input type="text" value="" readonly="readonly"></label></div>                  
				</div>
    		</div>
			<div class="gwa-abox-content-wrap">
				<div class="gwa-abox-content-header">
					<div class="gwa-abox-content-header-cells">
						<div class="gwa-abox-content-header-cell-left">
							<div class="gwa-input-btn gwa-search-input gwa-w203 gwa-fl" data-action="tm-search"><input type="text" placeholder="<?php esc_attr_e( 'e.g. \'Name\' or \'Post ID\'', 'go_pricing_textdomain' ); ?>" value="" class="gwa-w203"><a href="#" tabindex="-1" title="<?php esc_attr_e( 'Search', 'go_pricing_textdomain' ); ?>"><i class="fa fa-search"></i></a></div>
							<?php if ( !empty( $go_pricing['styles'] ) && is_array( $go_pricing['styles'] ) ) : ?>
							<label class="gwa-fl">
								<span class="gwa-label"><?php _e( 'Skin', 'go_pricing_textdomain' ); ?></span>                           
								<select class="gwa-w150" data-action="tm-filter-skin">
									<option value=""><?php _e( 'All', 'go_pricing_textdomain' ); ?></option>
									<?php foreach( $go_pricing['styles'] as $style ) : ?>								
									<option value="<?php echo esc_attr( isset( $style['id'] ) && $style['id'] != '' ? $style['id'] : '' );  ?>"><?php echo isset( $style['name'] ) && $style['name'] != '' ? $style['name'] : '';  ?></option>									
									<?php endforeach; ?>
								</select>
							</label>
							<?php endif; ?>
							<div class="gwa-search-assets"><span class="gwa-info"><?php echo !empty( $pricing_tables ) ? '(' . count( $pricing_tables ) . ')' : '(0)'; ?></span><a href="#" data-action="tm-search-reset" title="<?php esc_attr_e( 'Reset', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1"><?php _e( 'Reset', 'go_pricing_textdomain' ); ?></a></div>						
						</div>
						<div class="gwa-abox-content-header-cell-right">
								<label>
									<span class="gwa-label"><?php _e( 'Sort', 'go_pricing_textdomain' ); ?></span>
									<select name="_orderby" class="gwa-w150" data-action="order">
										<option value="ID"<?php echo ( !empty( $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] =='ID' ? ' selected="selected"' : '' ); ?>><?php _e( 'Post ID', 'go_pricing_textdomain' ); ?></option>
										<option value="date"<?php echo ( !empty( $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] =='date' ? ' selected="selected"' : '' ); ?>><?php _e( 'Date', 'go_pricing_textdomain' ); ?></option>
										<option value="title"<?php echo ( !empty( $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] =='title' ? ' selected="selected"' : '' ); ?>><?php _e( 'Title', 'go_pricing_textdomain' ); ?></option>
										<option value="modified"<?php echo ( !empty( $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm']['orderby'][$user_id] =='modified' ? ' selected="selected"' : '' ); ?>><?php _e( 'Last Modified Date', 'go_pricing_textdomain' ); ?></option>
									</select>
								</label>
								<label>
									<select name="_order" data-action="order" class="gwa-w80" style="margin-left:15px;">
										<option value="ASC"<?php echo ( !empty( $_COOKIE['go_pricing']['settings']['tm']['order'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm']['order'][$user_id] =='ASC' ? ' selected="selected"' : '' ); ?>><?php _e( 'ASC', 'go_pricing_textdomain' ); ?></option>
										<option value="DESC"<?php echo ( !empty( $_COOKIE['go_pricing']['settings']['tm']['order'][$user_id] ) && $_COOKIE['go_pricing']['settings']['tm']['order'][$user_id] =='DESC' ? ' selected="selected"' : '' ); ?>><?php _e( 'DESC', 'go_pricing_textdomain' ); ?></option>
									</select>
								</label>
						</div>
					</div>
				</div>			
				<div class="gwa-abox-content">
					<div class="gwa-thumbs-assets gwa-assets-nav"><a href="#" class="gwa-asset-icon-select" data-action="select" title="<?php esc_attr_e( 'Select / Deselect All', 'go_pricing_textdomain' ); ?>"><span></span></a><a href="#" class="gwa-asset-icon-clone" data-action="clone" data-confirm="<?php esc_attr_e( 'Are you sure you wanto clone the selected table(s)?', 'go_pricing_textdomain' ); ?>" title="<?php esc_attr_e( 'Clone', 'go_pricing_textdomain' ); ?>"><span></span></a><a href="#" class="gwa-asset-icon-export" data-action="export" title="<?php esc_attr_e( 'Export', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a><a href="#" class="gwa-asset-icon-delete" data-action="delete" data-confirm="<?php esc_attr_e( 'Are you sure you want to delete the selected table(s)?', 'go_pricing_textdomain' ); ?>" title="<?php esc_attr_e( 'Delete', 'go_pricing_textdomain' ); ?>"><span></span></a><div class="gwa-counter"></div></div>
					 <div class="gwa-thumbs"><div class="gwa-thumbs-inner gwa-clearfix">
						<input type="hidden" id="go-pricing-tm-select" name="postid">
						<?php 

						// Get pricing tables
						if ( $pricing_tables !== false ) :
						$table_count = 1;
						foreach( (array)$pricing_tables as $table_key=>$table_value ) : 
						
						// Get thumbnail
						$imgsrc = '';
						$column_style = '';
						$meta_column_data = get_post_meta( $table_value['postid'], 'col-data', true );
						$meta_pricing_style = get_post_meta( $table_value['postid'], 'style', true );
						if ( !empty( $meta_pricing_style ) && !empty( $meta_column_data[0]['col-style-type'] ) ) {

							$column_style = $meta_column_data[0]['col-style-type'];
							$registered_styles = isset ( $go_pricing['style_types'][$meta_pricing_style] ) ? $go_pricing['style_types'][$meta_pricing_style] : array();
							foreach ( (array)$registered_styles as $registered_style) {
								
								if ( !empty( $registered_style['group_name'] ) && !empty( $registered_style['group_data'] ) ) {
									foreach ( $registered_style as $key => $value) {
										if ($key == 'group_data') {
											foreach ( (array)$value as $style_data ) {
												if ( !empty( $style_data['value'] ) && !empty( $style_data['data'] ) && $style_data['value'] == $column_style ) $imgsrc = $style_data['data'];
											}
										}
									
									}
								} else {
									foreach ( (array)$registered_styles as $style_data ) {
										if ( !empty( $style_data['value'] ) && !empty( $style_data['data'] ) && $style_data['value'] == $column_style ) $imgsrc = $style_data['data'];
									}
								}
								
							}
						}
						?>
						<?php  
						$meta_style = get_post_meta( $table_value['postid'], 'style', true );
						$style = $meta_style ? $meta_style : '';
						$meta_thumb = get_post_meta( $table_value['postid'], 'thumbnail', true );
						$imgsrc = $meta_thumb ? $meta_thumb : $imgsrc;
						?>
						<!-- Thumbnail -->
						<div class="gwa-thumb" data-id="<?php echo esc_attr( $table_key ); ?>" tabindex="0" data-style="<?php echo esc_attr( $style ); ?>" data-table-id="<?php echo esc_attr( !empty( $table_value['id'] ) ?  $table_value['id'] : '' ); ?>">
							<a href="#" class="gwa-thumb-link" title="<?php echo esc_attr( !empty( $table_value['name'] ) ? $table_value['name'] : '' ); ?>" tabindex="-1"></a>
							<div class="gwa-thumb-media" data-src="<?php echo esc_attr( $imgsrc ) ; ?>"></div>
							<div class="gwa-thumb-title" data-no="<?php echo esc_attr( sprintf( '%02d.', $table_count ) ); ?>" data-id="<?php echo esc_attr( !empty( $table_value['postid'] ) ?  sprintf( '#%s', $table_value['postid'] ) : '' ); ?>"><?php echo ( !empty( $table_value['name'] ) ? $table_value['name'] : '' ); ?></div>
							<div class="gwa-assets-nav"><a href="#" class="gwa-asset-icon-edit" data-action="edit" title="<?php esc_attr_e( 'Edit', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a><a href="#" class="gwa-asset-icon-preview" data-action="popup" data-popup="live-preview" data-id="<?php echo esc_attr( !empty( $table_value['postid'] ) ? $table_value['postid'] : 0 ); ?>" data-popup-type="iframe" data-popup-subtitle="<?php echo esc_attr( !empty( $table_value['name'] ) ? $table_value['name'] : '' ); ?>" data-popup-maxwidth="1200" title="<?php esc_attr_e( 'Preview', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a><a href="#" class="gwa-asset-icon-clone" data-action="clone" data-confirm="<?php esc_attr_e( 'Are you sure you wanto clone the selected table(s)?', 'go_pricing_textdomain' ); ?>" title="<?php esc_attr_e( 'Clone', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a><a href="#"  class="gwa-asset-icon-delete" data-action="delete" data-confirm="<?php esc_attr_e( 'Are you sure you want to delete the selected table(s)?', 'go_pricing_textdomain' ); ?>" title="<?php esc_attr_e( 'Delete', 'go_pricing_textdomain' ); ?>" tabindex="-1"><span></span></a></div>									
						</div>
						<!-- / Thumbnail -->
						<?php 
						$table_count++;
						endforeach; 
						else :
						?>
                       	<div class="gwa-dash-welcome">
                        	<div class="gwa-dash-wlogo"></div>
							<div class="gwa-dash-wtitle"><?php _e( 'Let\'s get started!', 'go_pricing_textdomain' ); ?></div>
                        	<div class="gwa-dash-wdesc"><?php _e( 'Create a new table from scratch or import existing ones from our demo tables.', 'go_pricing_textdomain' ); ?></div>
                            <div class="gwa-dash-wimg"><img src="<?php echo $this->plugin_url . 'assets/admin/images/welcome.png' ?>"></div>
                        </div>
                        <?php
						endif;
						?>
                        <div class="gwa-dash-nores"><?php _e( 'Oops, couldn\'t find it. ', 'go_pricing_textdomain' ); ?></div>
					</div></div>																																																																			
				</div>
			 </div>
		</div>
		<!-- /Admin Box -->

		<!-- Submit -->	
		<div class="gwa-submit"><a href="#" data-action="create" title="++ <?php esc_attr_e( 'Create', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style5">++ <?php _e( 'Create', 'go_pricing_textdomain' ); ?></a><a href="<?php echo esc_attr( admin_url( 'admin.php?page=go-pricing-import-export&tab=import' ) ); ?>" title="<?php esc_attr_e( 'Export', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style2 gwa-fr"><?php _e( 'Export', 'go_pricing_textdomain' ); ?></a><a href="<?php echo esc_attr( admin_url( 'admin.php?page=go-pricing-import-export&tab=export' ) ); ?>" title="<?php esc_attr_e( 'Import', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1 gwa-fr gwa-mr10"><?php _e( 'Import', 'go_pricing_textdomain' ); ?></a></div>
		<!-- /Submit -->

		<!-- Info Box -->
		<div class="gwa-tm-info-wrap">
			<div class="gwa-tm-info-spacer"></div>
			<div class="gwa-tm-info"></div>
			<div class="gwa-tm-info-spacer"></div>
		</div>
		<!-- /Info Box -->

	</form>
</div>
<!-- Page /Content -->