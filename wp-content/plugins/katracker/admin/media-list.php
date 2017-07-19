<?php

// Admin Media List ////////////////////////////////////////////////////////////////////////////////

// Add columns to the torrent media list
add_filter( 'manage_media_columns', function ( $cols ) {
	if ( ( !isset( $_GET['attachment-filter'] ) || $_GET['attachment-filter'] != 'post_mime_type:torrent' ) && !isset( $_GET[KATRACKER_CATEGORY] ) ) {
		unset ( $cols['taxonomy-' . KATRACKER_CATEGORY] );
		return $cols;
	}
	unset( $cols['comments'] );
	unset( $cols['parent'] );
	$cols['size'] = __( 'Size', 'katracker' );
	if ( !get_katracker_option( 'open-tracker' ) ) $cols['tracked'] = __( 'Active', 'katracker' );
	$cols['leechers'] = '<span title="'.__( 'Leechers', 'katracker' ).'">Le</span>';
	$cols['seeders'] = '<span title="'.__( 'Seeders', 'katracker' ).'">Se</span>';
	$cols['hits'] = '<span title="'.__( 'Hits', 'katracker' ).'">Hits</span>';
	// $cols['shortcode'] = '<span title="'.__( 'Shortcode', 'katracker' ).'">Shortcode</span>';
	return $cols;
} );

// Print the columns content for each torrent
add_action( 'manage_media_custom_column', function ( $column_name, $torrent_id ) {
	if ( ( !isset( $_GET['attachment-filter'] ) || $_GET['attachment-filter'] != 'post_mime_type:torrent' ) && !isset( $_GET[KATRACKER_CATEGORY] ) ) return;
	switch ( $column_name ) {
		case 'tracked':
			echo get_torrent_meta( $torrent_id, 'track' ) ?
				'<strong style="color: green;">' . __( 'Yes', 'katracker' ) . '</strong>' :
				'<strong style="color: red;">' . __( 'No', 'katracker' ) . '</strong>';
			break;
		case 'leechers':
			echo '<span style="color: blue;">' . get_torrent_meta( $torrent_id, 'leechers' ) . '</span>';
			break;
		case 'seeders':
			echo '<span style="color: green;">' . get_torrent_meta( $torrent_id, 'seeders' ) . '</span>';
			break;
		case 'hits':
			echo '<span style="color: black;">' . get_torrent_meta( $torrent_id, 'hits' ) . '</span>';
			break;
		// case 'shortcode':
		// 	echo '<input readonly class="code" type="text" style="width:9em;" onClick="this.select();" value=\'' . generate_torrent_shortcode( $torrent_id ) . '\'/>';
		// 	break;
		case 'size':
			echo TorrentFile::format( get_torrent_meta( $torrent_id, 'size' ) );
			break;
		case 'hash_info' :
			echo get_torrent_meta( $torrent_id, 'hash-info' );
			break;
	}
}, 10, 2 );

// Register the column as sortable
add_filter( 'manage_upload_sortable_columns', function ( $cols ) {
	if ( ( !isset( $_GET['attachment-filter'] ) || $_GET['attachment-filter'] != 'post_mime_type:torrent' ) && !isset( $_GET[KATRACKER_CATEGORY] ) ) return $cols;
	$cols['size']                            = 'size';
	$cols['tracked']                         = 'active';
	$cols['taxonomy-' . KATRACKER_CATEGORY]  = 'cat';
	$cols['leechers']                        = 'leechers';
	$cols['seeders']                         = 'seeders';
	$cols['hits']                            = 'hits';
	return $cols;
} );

// Setup sortable columns
add_action( 'pre_get_posts', function ( $query ) {
	global $pagenow;
	if( $pagenow != 'upload.php' ) {
		return $query;
	}
	if ( ( !isset( $_GET['attachment-filter'] ) || $_GET['attachment-filter'] != 'post_mime_type:torrent' ) && !isset( $_GET[KATRACKER_CATEGORY] ) ) {
		$allowed_mimes = get_allowed_mime_types();
		unset( $allowed_mimes['torrent'] );
		$query->set( 'post_mime_type', $allowed_mimes );
		return $query;
	}

	$_GET['mode'] = 'list';
	$orderby = $query->get( 'orderby' );

	switch( $orderby ) {
		case 'size':
			$query->set( 'meta_key', KATRACKER_META_PREFIX . 'size' );
			$query->set( 'orderby','meta_value_num' );
			break;
		case 'cat':
			$query->set( 'meta_key', KATRACKER_META_PREFIX . 'category' );
			$query->set( 'orderby','meta_value' );
			break;
		case 'active':
			$query->set( 'meta_key', KATRACKER_META_PREFIX . 'track' );
			$query->set( 'orderby','meta_value' );
			break;
		case 'leechers':
			$query->set( 'meta_key', KATRACKER_META_PREFIX . 'leechers' );
			$query->set( 'orderby','meta_value_num' );
			break;
		case 'seeders':
			$query->set( 'meta_key', KATRACKER_META_PREFIX . 'seeders' );
			$query->set( 'orderby','meta_value_num' );
			break;
		case 'hits':
			$query->set( 'meta_key', KATRACKER_META_PREFIX . 'hits' );
			$query->set( 'orderby','meta_value_num' );
			break;
	}
} );

// Add required javascript for bulk actions
add_action( 'admin_footer-upload.php', function () {
	if ( ( !isset( $_GET['attachment-filter'] ) || $_GET['attachment-filter'] != 'post_mime_type:torrent' ) && !isset( $_GET[KATRACKER_CATEGORY] ) ) return; ?>
	<script type="text/javascript">
		jQuery( document ).ready( function() {
			jQuery( "<option>" ).val( "track" ).text( "<?php _e( 'Track', 'katracker' ); ?>" ).appendTo( 'select[name="action"], select[name="action2"]' );
			jQuery( "<option>" ).val( "untrack" ).text( "<?php _e( 'Untrack', 'katracker' ); ?>" ).appendTo( 'select[name="action"], select[name="action2"]' );
			jQuery( )
		} );
	</script>
	<style>
		.column-title {width: 42%;}
		.column-date, .column-author, .column-size, .column-shortcode {width: 5em;}
		.column-taxonomy-<?php echo KATRACKER_CATEGORY; ?> {width: 9em;}
		.column-leechers, .column-seeders, .column-hits {width: 2.7em;}
		.column-tracked {width: 4.15em;}
	</style>
<?php
} );

// Add admin bulk actions callback
add_action( 'admin_action_track', function () {
	if ( isset( $_REQUEST['media'] ) )
		foreach( $_REQUEST['media'] as $torrent )
			track_katracker_torrent( $torrent );
} );
add_action( 'admin_action_untrack', function () {
	if ( isset( $_REQUEST['media'] ) )
		foreach( $_REQUEST['media'] as $torrent )
			untrack_katracker_torrent( $torrent );
} );


// Add a menu button to redirect to correct media library page
add_action( 'admin_menu',function () {
	add_media_page( __( 'Torrents', 'katracker' ), __( 'Torrents', 'katracker ' ), 'upload_files', 'admin-torrents', function () { return; }, -1 );
} );
add_action( 'admin_init', function () {
	global $pagenow;
	if ( $pagenow == 'upload.php' && isset( $_GET['page'] ) && $_GET['page'] == 'admin-torrents' ) {
		wp_redirect( add_query_arg( 'attachment-filter', 'post_mime_type:torrent', admin_url( 'upload.php' ) ) );
		exit;
	}
} );

?>
