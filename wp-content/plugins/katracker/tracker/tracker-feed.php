<?php

// Wordpress Override //////////////////////////////////////////////////////////////////////////////
remove_all_actions( 'do_feed' );
remove_all_actions( 'do_feed_rdf' );
remove_all_actions( 'do_feed_rss' );
remove_all_actions( 'do_feed_rss2' );
remove_all_actions( 'do_feed_atom' );

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'torrent/torrent-class.php';

// Serve Torrents //////////////////////////////////////////////////////////////////////////////////
add_action( 'do_feed_rss2', function() {
	if ( isset( $_GET['cat'] ) ) {
		$category = get_term_by( is_int( $_GET['cat'] ) ? 'id' : 'slug', $_GET['cat'], KATRACKER_CATEGORY );
	}
	$atts = array(
		'category'     => isset( $category )            ? $category->term_id                       : null,
		'orderby'      => isset( $_GET['orderby'] )     ? sanitize_sql_orderby( $_GET['orderby'] ) : 'date',
		'order'        => isset( $_GET['order'] )       ? sanitize_text_field( $_GET['order'] )    : 'DESC',
		'numtorrents'  => isset( $_GET['numtorrents'] ) ? intval( $_GET['numtorrents'] )           : -1
	);


	header( 'Content-Type: '.feed_content_type( 'rss-http' ).'; charset='.get_option( 'blog_charset' ), true );
	echo '<?xml version="1.0" encoding="'.get_option( 'blog_charset' ).'"?'.'>';
	?>
	<rss version="2.0"
		xmlns:bittorrent="http://www.borget.info/bittorrent-rss/"
		xmlns:atom="http://www.w3.org/2005/Atom"
		<?php do_action( 'rss2_ns' ); ?>>
		<channel>
			<title><?php echo get_bloginfo( 'name' ) . ( isset( $category ) ? ': ' . $category->name : '' ); ?> - Torrent Feed</title>
			<link><?php bloginfo_rss( 'url' ) ?></link>
			<description><?php bloginfo_rss( 'description' ) ?></description>
			<lastBuildDate><?php echo mysql2date( 'D, d M Y H:i:s +0000', get_lastpostmodified( 'GMT' ), false ); ?></lastBuildDate>
			<language><?php echo get_option( 'rss_language' ); ?></language>
			<generator>KaTracker</generator>
			<?php if ( isset( $category ) ): ?>
				<category><?php echo $category->name; ?></category>
			<?php endif;
			if ( $torrents = get_torrents( $atts ) ):
				foreach( $torrents as $torrent ):
					setup_postdata( $torrent );
					$stats = get_torrent_stats( $torrent->ID );
					$category = get_term_by( 'id', get_torrent_meta( $torrent->ID, 'category' ), KATRACKER_CATEGORY );
					?>
					<item>
							<title><?php echo ( get_katracker_option( 'rename-files' ) ?
									sanitize_file_name( get_the_title( $torrent->ID ) ).'.torrent' :
									sanitize_file_name( get_torrent_meta( $torrent->ID, 'name' ) ).'.torrent' ); ?></title>
							<description><![CDATA[<?php echo $stats['seeders'];?> seeder( s ), <?php echo $stats['leechers']; ?> leecher( s ); <?php echo TorrentFile::format( get_torrent_meta( $torrent->ID, 'size' ) );?>]]></description>
							<category><![CDATA[<?php echo $category->name; ?>]]></category>
							<author><?php echo get_the_author(); ?></author>
							<link><?php echo katracker_download_url( $torrent->ID ); ?></link>
							<guid><?php echo get_site_url(); ?></guid>
							<pubDate><?php echo mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true, $torrent->ID ), false ); ?></pubDate>
							<bittorrent:seeders><?php echo $stats['seeders'];?></bittorrent:seeders>
							<bittorrent:leechers><?php echo $stats['leechers']; ?></bittorrent:leechers>
							<bittorrent:creator>KaTracker</bittorrent:creator>
							<bittorrent:info_hash><?php echo get_torrent_meta( $torrent->ID, 'hash-info' ); ?></bittorrent:info_hash>
							<bittorrent:magnet><?php echo katracker_magnet_url( $torrent->ID ); ?></bittorrent:magnet>
					</item>
			<?php endforeach; endif; ?>
		</channel>
	</rss>
	<?php
	exit;
} );
do_action( 'do_feed_rss2' );

?>
