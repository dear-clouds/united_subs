<?php

// Admin Tracker Information ///////////////////////////////////////////////////////////////////////

global $katracker_section;
$katracker_section[basename( __FILE__ )] = array(
	'title'   => __( 'Information', 'katracker' ),
	'name'    => 'katrackerTrackerInfo',
	'slug'    => preg_replace( array( '/^section-\d{1}-/', '/.php$/' ), array( '', '' ) , basename( __FILE__ ) ),
	'submit'  => false,
	'action'  => ''
);


add_action( 'admin_init', function () {

	global $katracker_section;

	add_settings_section(
		KATRACKER_PREFIX . 'section-'.$katracker_section[basename( __FILE__ )]['name'],
		__( $katracker_section[basename( __FILE__ )]['title'], 'katracker' ),
		function () {
			$url = array(
				'announce' => get_katracker_url( 'announce' ),
				'scrape' => get_katracker_url( 'scrape' ),
				'feed' => get_katracker_url( 'feed' ),
			);
			$stats = get_torrent_stats();
			?>
			<p><strong><?php echo get_katracker_option( 'active' ) ? __( 'The tracker is up and running.', 'katracker' ) : __( 'The tracker is disabled.', 'katracker' ); ?></strong></p>
			<table>
				<thead><th colspan="2"><?php _e( 'Useful Tracker Urls', 'katracker' ); ?></th></thead>
				<tr>
					<td><?php _e( 'Announce', 'katracker' ); ?>: </td>
					<td><input readonly class="regular-text code" onClick="this.select();" type="url" value="<?php echo $url['announce']; ?>" title="<?php echo $url['announce']; ?>"/></td>
				</tr>
				<tr>
					<td><?php _e( 'Scrape', 'katracker' ); ?>: </td>
					<td><input readonly class="regular-text code" onClick="this.select();" type="url" value="<?php echo $url['scrape']; ?>" title="<?php echo $url['scrape']; ?>"/></td>
				</tr>
				<tr>
					<td><?php _e( 'RSS Feed', 'katracker' ); ?>: </td>
					<td><input readonly class="regular-text code" onClick="this.select();" type="url" value="<?php echo $url['feed']; ?>" title="<?php echo $url['feed']; ?>"/></td>
				</tr>
			</table>
			<p></p>
			<table>
				<thead><th colspan="2"><?php _e( 'Statistics', 'katracker' ); ?></th></thead>
				<tr>
					<td><?php _e( 'Torrent Count', 'katracker' ); ?>: </td>
					<td><?php echo get_torrent_count(); ?></td>
				</tr>
				<tr>
					<td><?php _e( 'Seeders', 'katracker' ); ?>: </td>
					<td><?php echo $stats['seeders']; ?></td>
				</tr>
				<tr>
					<td><?php _e( 'Leechers', 'katracker' ); ?>: </td>
					<td><?php echo $stats['leechers']; ?></td>
				</tr>
			</table>
			<?php
		},
		$katracker_section[basename( __FILE__ )]['name']
	);

} );

?>
