<?php

// Triggers and Actions for new torrents ///////////////////////////////////////////////////////////

add_action( 'add_attachment', 'katracker_torrent_init' );

add_filter( 'wp_handle_upload_prefilter', function ( $attachment ) {
	if ( pathinfo( basename( $attachment['name'] ), PATHINFO_EXTENSION ) != 'torrent' ) return $attachment;
	$torrent = new TorrentFile( $attachment['tmp_name'] );	
	if ( !katracker_valid_hash_info( $torrent->hash_info() ) ) {
		$attachment['error'] = __( 'Error: Hash info contains null bytes! ', 'katracker' ); 
		return $attachment;
	}
	global $wpdb;
	$torrents_ids = $wpdb->get_results( $wpdb->prepare(
	                	"SELECT post_id
	                	FROM $wpdb->postmeta
	                	WHERE meta_value = %s",
	                	$torrent->hash_info()
	                ) );
	if ( count( $torrents_ids ) > 0 ) {
		$attachment['error'] = ' ';
		foreach ( $torrents_ids as $torrent_id ) {
			$attachment['error'] .= get_edit_post_link( $torrent_id->post_id ) . ' ';
		}
		$attachment['error'] = __( 'Error: This torrent already exists:', 'katracker' ) . $attachment['error'];
		return $attachment;
	}
	add_filter( 'upload_dir', 'set_torrent_upload_dir' );
	$torrent->save( $attachment['tmp_name'] );
	$attachment['name'] = sanitize_file_name( $torrent->hash_info().'.torrent' );
	return $attachment;
} );

add_filter( 'wp_handle_upload', function ( $attachment ) {
	remove_filter( 'upload_dir', 'set_torrent_upload_dir' );
	return $attachment;
} );

/**
 * Modifies the upload directory for torrents
 *
 * @param string $path
 */
function set_torrent_upload_dir( $path ) {
	if( !empty( $path['error'] )) return $path;
	$path['path']    = str_replace( $path['subdir'], '', $path['path'] );
	$path['url']     = str_replace( $path['subdir'], '', $path['url'] );
	$path['subdir']  = '/torrent';
	$path['path']    .= '/torrent';
	$path['url']     .= '/torrent';
	return $path;
}

// Allow uploading torrents to wordpress media library
add_filter( 'mime_types', function ( $existing_mimes ) {
	$existing_mimes['torrent'] = 'torrent/torrent';
	return $existing_mimes;
} );

// Add wordpress torrent media type
add_filter( 'post_mime_types', function ( $post_mime_types ) {
	$post_mime_types['torrent'] = array(
	                              	__( 'Torrents' ),
	                              	__( 'Manage Torrents' ),
	                              	_n_noop( 'Torrent <span class="count">( %s )</span>', 'Torrents <span class="count">( %s )</span>' )
	                              );
	return $post_mime_types;
} );

// Change the torrent permalinks
if ( !get_katracker_option( 'torrent-page' ) ) {
	add_filter( 'attachment_link', function( $link, $id ) {
		if ( get_post_mime_type( $id ) != 'torrent/torrent' ) return $link;
		return katracker_download_url( $id );
	}, 10, 2 );
}

add_filter( 'wp_get_attachment_url', function( $url, $id ) {
	if ( get_post_mime_type( $id ) != 'torrent/torrent' ) return $url;
	return katracker_download_url( $id );
}, 10, 2 );

add_filter( 'wp_mime_type_icon', function( $icon, $mime, $post_id ) {
	if ( $mime == 'torrent/torrent' ) $icon = plugin_dir_url( __FILE__ ) . 'media-torrent.png';
	return $icon;
}, 10, 3 );

add_filter( 'wp_get_attachment_image_src', function( $image, $attachment_id, $size, $icon ) {
	if ( get_post_mime_type( $attachment_id ) == 'torrent/torrent' ) {
		if ( $thumbnail_id = get_torrent_meta( $attachment_id, 'thumbnail', true ) ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $size, true );
		} elseif( $icon ) {
			$image = array_merge( array( plugin_dir_url( __FILE__ ) . 'media-torrent.png' ), array( 48,60 ) );
		}
	}
	return $image;
}, 10, 4 );

add_filter( 'wp_prepare_attachment_for_js', function( $response ) {
	unset( $response['link'] );
	if ( $response['mime'] != 'torrent/torrent' ) return $response;
	$response['filename'] = get_torrent_meta( $response['id'], 'name' );
	if ( $thumbnail_id = get_torrent_meta( $response['id'], 'thumbnail', true ) ) {
		list( $src, $width, $height ) = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
		$response['image'] = compact( 'src', 'width', 'height' );
		list( $src, $width, $height ) = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
		$response['thumb'] = compact( 'src', 'width', 'height' );
	}
	return $response;
} );

?>
