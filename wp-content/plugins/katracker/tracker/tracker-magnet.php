<?php

// External Magnet Links ///////////////////////////////////////////////////////////////////////////

if ( isset( $_GET['info_hash'] ) && katracker_valid_hash_info( $_GET['info_hash'] ) ) {
	$_GET['torrent'] = get_torrent_id_from_hash( $_GET['info_hash'] );
}
if ( !isset( $_GET['torrent'] ) ) return;
$torrent_id = intval( $_GET['torrent'] );

if ( get_torrent_meta( $_GET['torrent'], 'track' ) ||
     get_katracker_option( 'tracked-access' ) ||
     get_katracker_option( 'open-tracker' ) ) {
	if ( $magnet = get_torrent_meta( $_GET['torrent'], 'magnet' ) ) {
		update_torrent_meta( $_GET['torrent'], 'completed', get_torrent_meta( $_GET['torrent'], 'completed' ) + 1 );
		wp_redirect( $magnet ); ?>
			<a href="javascript:history.go(-1)" style="position:absolute;right:50%;">Back</a>
		<?php exit;
	}
}

?>
