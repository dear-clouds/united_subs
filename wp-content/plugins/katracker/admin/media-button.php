<?php

// Add Torrent Button //////////////////////////////////////////////////////////////////////////////


add_action('media_buttons', function() { ?>
	<button type="button" id="<?php echo KATRACKER_PREFIX; ?>torrent_button" class="button add_media" title="<?php _e( 'Add Torrent', 'katracker' ); ?>">
		<span class="dashicons dashicons-download" style="color:#82878c;font:400 18px/1 dashicons;display: inline-block;width: 18px;height: 18px;vertical-align: text-top;margin: 0 2px;"></span><?php _e( 'Add Torrent', 'katracker' ); ?>
	</button>
<?php }, 15);

add_action( 'admin_enqueue_scripts', function () {

	// registers and enqueues the required javascript.

	wp_register_script( 'meta-box-torrent', plugin_dir_url( __FILE__ ) . 'media-button.js', array( 'jquery' ) );
	wp_localize_script( 'meta-box-torrent', 'meta_image',
		array(
			'title'   => __( 'Add Torrent', 'katracker' ),
			'button'  => __( 'Add Torrent', 'katracker' ),
		)
	);
	wp_enqueue_script( 'meta-box-torrent' );

} );
?>
