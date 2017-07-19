<?php

// Admin Reset to Defaults /////////////////////////////////////////////////////////////////////////

global $katracker_section;

$katracker_section[basename( __FILE__ )] = array( 
	'title'   => __( 'Reset', 'katracker' ),
	'name'    => 'katrackerResetOptions',
	'slug'    => preg_replace( array( '/^section-\d{1}-/', '/.php$/' ), array( '', '' ) , basename( __FILE__ ) ),
	'submit'  => false,
	'action'  => ''
);

add_action( 'admin_init', function () {

	global $katracker_section;

	if ( isset( $_GET['tab'] ) && $_GET['tab'] == $katracker_section[basename( __FILE__ )]['slug'] ) {
		add_action( 'admin_notices', function() {
			$class = 'notice notice-warning';
			$message = __( 'All actions performed in this page cannot be undone!', 'katracker' );
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
		} );
	}

	add_settings_section(
		KATRACKER_PREFIX . ''.$katracker_section[basename( __FILE__ )]['name'].'_section', 
		__( $katracker_section[basename( __FILE__ )]['title'], 'katracker' ),
		function () { ?>
			<p><?php _e( 'Here you can reset options and metadata. Use with caution!', 'katracker' ); ?><br/>
			<?php wp_nonce_field( KATRACKER_PREFIX . 'reset_delete', KATRACKER_PREFIX . 'reset_delete' );
			$attributes = array(
				'style' => 'color:red;margin:5px'
			);
			submit_button( __( 'Reset tracker options', 'katracker' ), 'delete', 'katracker-reset-default', false, array_merge( $attributes, array(
				'title' => __( 'Reset tracker options to default', 'katracker' ),
				'onclick' => "return confirm( '" . __( 'All tracker options will be reset to default.', 'katracker' ) . "' );"
				) ) );
			echo '</br>';
			submit_button( __( 'Recreate database tables', 'katracker' ), 'delete', 'katracker-db-reset', false, array_merge( $attributes, array(
				'title' => __( 'Drop and recreated the tracker database tables', 'katracker' ),
				'onclick' => "return confirm( '" . __( 'Seeders/peers statistics will be reset, and all exsiting peer ids will be lost.', 'katracker' ) . "' );"
				) ) );
			echo '</br>';
			submit_button( __( 'Delete metadata', 'katracker' ), 'delete', 'katracker-torrent-reset', false, array_merge( $attributes, array(
				'title' => __( 'Delete all torrent file metadata', 'katracker' ),
				'onclick' => "return confirm( '" . __( 'The metadata of all torrents will be deleted.', 'katracker' ) . "' );"
				) ) );
		}, 
		$katracker_section[basename( __FILE__ )]['name']
	);
	
	if ( isset( $_POST[KATRACKER_PREFIX . 'reset_delete'] ) && wp_verify_nonce( $_POST[KATRACKER_PREFIX . 'reset_delete'], KATRACKER_PREFIX . 'reset_delete' ) ) {

		if ( isset( $_POST['katracker-db-reset'] ) )
			$action = ( katracker_db_init( true ) && katracker_db_init() ) ?
				array( 'type' => 'updated', 'message' => __( 'The Database tables was successfully recreated!', 'katracker' ) ) :
				array( 'type' => 'error', 'message' => __( 'Failed to recreated the database tables!', 'katracker' ) );

		if ( isset( $_POST['katracker-torrent-reset'] ) )
			$action = katracker_torrent_init( false, true ) && katracker_install_torrents_meta() ?
				array( 'type' => 'updated', 'message' => __( 'The torrent metadata was successfully deleted!', 'katracker' ) ) :
				array( 'type' => 'error', 'message' => __( 'Failed to delete the torrent metadata!', 'katracker' ) );

		if ( isset( $_POST['katracker-torrent-delete'] ) )
			$action = katracker_uninstall( 'torrents' ) ?
				array( 'type' => 'updated', 'message' => __( 'All torrent files was successfully deleted!', 'katracker' ) ) :
				array( 'type' => 'error', 'message' => __( 'Failed to delete torrent files!', 'katracker' ) );

		if ( isset( $_POST['katracker-reset-default'] ) ) 
			$action = katracker_settings_init( true ) && katracker_settings_init() ?
				array( 'type' => 'updated', 'message' => __( 'Tracker options was successfully reset to it\'s defaults!', 'katracker' ) ) :
				array( 'type' => 'error', 'message' => __( 'Failed to reset tracker options!', 'katracker' ) );

		add_settings_error(
			'katracker',
			esc_attr( 'settings_updated' ),
			$action['message'],
			$action['type']
		);
	}

} );

?>
