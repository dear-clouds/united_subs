<?php
$user_id = get_current_user_id();
$maxwidth = !empty( $_POST['maxwidth'] ) && $_POST['maxwidth'] != 'auto' ? (int)$_POST['maxwidth'] : 768;
$general_settings = get_option( self::$plugin_prefix . '_table_settings' );
$iframe_url = !isset( $general_settings['safe-preview'] )  ? esc_attr( add_query_arg( array( 'id' => (int)$_POST['data'],  'nonce' => wp_create_nonce( $this->plugin_base .'-preview' ), 'rnd' => uniqid() ), $this->plugin_url . 'includes/preview.php' ) ) : esc_attr( add_query_arg( array( 'go_pricing_preview_id' => (int)$_POST['data'],  'nonce' => wp_create_nonce( $this->plugin_base .'-preview' ), 'rnd' => uniqid() ), home_url() ) );
?>
<div class="gwa-popup"<?php echo !empty( $maxwidth ) ? sprintf( ' style="max-width:%dpx;"', $maxwidth ) : ''; ?>>
	<div class="gwa-popup-inner"<?php echo !empty( $_POST['maxwidth'] ) && $_POST['maxwidth'] != 'auto' ? sprintf( ' style="width:%dpx;"', (int)$_POST['maxwidth'] ) : ''; ?>>
		<div class="gwa-popup-header">
			<div class="gwa-popup-header-icon-preview"></div>
			<div class="gwa-popup-title"><?php _e( 'Live Preview', 'go_pricing_textdomain' ); ?><small><?php echo !empty( $_POST['subtitle'] ) ? $_POST['subtitle'] : ''; ?></small></div>
			<a href="#" title="<?php _e( 'Close', 'go_pricing_textdomain' ); ?>" class="gwa-popup-close"></a>
		</div>
		<div class="gwa-popup-content-wrap">
			<div class="gwa-popup-content">
				<iframe class="gwa-popup-iframe" src="<?php echo  $iframe_url; ?>"></iframe>
			</div>
		</div>
		<div class="gwa-popup-footer">
			<div class="gwa-popup-assets gwa-popup-assets-left gwa-fl gwa-popup-timeline">
				<a class="gwa-btn-style1 fa fa-play" title="<?php esc_attr_e( 'Play / Pause Animation', 'go_pricing_textdomain' ); ?>"></a>
				<input id="gs-timeline" type="range" value="0" min="0" max="2400">
				<i class="fa fa-video-camera"></i>
			</div>        
			<div class="gwa-popup-views">
				<a href="#" data-action="view" data-view="desktop" title="<?php esc_attr_e( 'Desktop View', 'go_pricing_textdomain' ); ?>" class="gwa-popup-view-icon-desktop gwa-current"></a><a href="#" data-action="view" data-view="tablet" title="<?php _e( 'Tablet View', 'go_pricing_textdomain' ); ?>" class="gwa-popup-view-icon-tablet"></a><a href="#" data-action="view" data-view="mobile" title="<?php _e( 'Mobile View', 'go_pricing_textdomain' ); ?>" class="gwa-popup-view-icon-mobile"></a>			
			</div>
			<div class="gwa-popup-assets gwa-popup-assets-right gwa-fr">
            <div class="gwa-colorpicker gwa-colorpicker-prev" tabindex="0"><input type="hidden" value="#ffffff"><span class="gwa-cp-picker"><span style="background:#ffffff"></span></span><span class="gwa-cp-label">#ffffff</span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="#ffffff"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></div>
				<?php if ( empty( $noedit ) ) : ?><a href="#" data-action="popup-edit" data-id="<?php echo (int)$_POST['data']; ?>" title="<?php esc_attr_e( 'Edit', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style1 gwa-ml20"><?php _e( 'Edit', 'go_pricing_textdomain' ); ?></a><?php endif; ?><a href="#" data-action="popup-export" data-id="<?php echo (int)$_POST['data']; ?>" title="<?php esc_attr_e( 'Export', 'go_pricing_textdomain' ); ?>" class="gwa-btn-style2 gwa-ml10"<?php echo empty( $_COOKIE['go_pricing']['settings']['popup'][$user_id] ) || ( !empty( $_COOKIE['go_pricing']['settings']['popup'][$user_id] ) && $_COOKIE['go_pricing']['settings']['popup'][$user_id] != 'mobile' ) ? '' : ' style="display:none;"'; ?>><?php _e( 'Export', 'go_pricing_textdomain' ); ?></a>
			</div>
		</div>
	</div>	
</div>