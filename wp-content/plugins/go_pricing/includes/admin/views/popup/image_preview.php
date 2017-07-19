<?php
$img_url = !empty( $_POST['data'] ) ? $_POST['data'] : '';
?>
<div class="gwa-popup">
	<div class="gwa-popup-inner" style="width:auto;">
		<div class="gwa-popup-header">
			<div class="gwa-popup-header-icon-preview"></div>
			<div class="gwa-popup-title"><?php _e( 'Image Preview', 'go_pricing_textdomain' ); ?><small><?php echo !empty( $_POST['subtitle'] ) ? $_POST['subtitle'] : ''; ?></small></div>
			<a href="#" title="<?php _e( 'Close', 'go_pricing_textdomain' ); ?>" class="gwa-popup-close"></a>
		</div>
		<div class="gwa-popup-content-wrap">
			<div class="gwa-popup-content">
				<?php if ( !empty( $img_url ) ) : ?>
				<div class="gwa-popup-img-wrap"><div class="gwa-popup-img-wrap-inner"><img src="" class="gwa-popup-img"></div></div>
				<?php endif; ?>
			</div>
		</div>
	</div>	
</div>