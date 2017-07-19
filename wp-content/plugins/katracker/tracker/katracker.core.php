<?php

// License Information /////////////////////////////////////////////////////////////////////////////

/*
 * KaTracker - BitTorrent Tracker Wordpress Plugin
 * The tracker functionality mostly on peertracker's mysql version,
 * and ported to use native wordpress functions.
 *
 * For more information about the peertracker project,
 * please visit https://github.com/JonnyJD/peertracker
 *
 * KatrackerCore is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * KaTracker is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with KaTrackerCore. If not, see <http://www.gnu.org/licenses/>.
 */

// Configuration ///////////////////////////////////////////////////////////////////////////////////

// tracker state
$_SERVER['tracker'] = array(
	// general tracker options
	'open_tracker'       => get_katracker_option( 'open-tracker' ),
	'announce_interval'  => get_katracker_option( 'announce-interval' ) * 60,
	'min_interval'       => get_katracker_option( 'min-interval' ) * 60,
	'default_peers'      => get_katracker_option( 'num-peers' ),
	'max_peers'          => get_katracker_option( 'max-peers' ),

	// advanced tracker options
	'external_ip'       => get_katracker_option( 'external-ip' ),
	'force_compact'     => get_katracker_option( 'force-compact' ),
	'full_scrape'       => get_katracker_option( 'full-scrape' ),
	'random_limit'      => get_katracker_option( 'random-limit' )
);

// Tracker Operations //////////////////////////////////////////////////////////////////////////////


class KatrackerCore {
	/**
	 * fatal error, stop execution
	 *
	 * @param string $error error to send to the client
	 */
	public static function error( $error )
	{
		exit( 'd14:failure reason' . strlen( $error ) . ":{$error}e" );
	}


	/**
	 * insert new peer
	 */
	public static function new_peer()
	{
		// include wordpress database
		global $wpdb;

		// insert peer
		$wpdb->query(
			// insert into the peers table
			"INSERT IGNORE INTO `" . KATRACKER_DB_PREFIX . "peers` " .
			// table columns
			'( info_hash, peer_id, compact, ip, port, state, updated ) ' .
			// 20-byte info_hash, 20-byte peer_id
			"VALUES ( '{$_GET['info_hash']}', '{$_GET['peer_id']}', '" .
			// 6-byte compacted peer info
			esc_sql( pack( 'Nn', ip2long( $_GET['ip'] ), $_GET['port'] )) . "', " .
			// dotted decimal string ip, integer port, integer state and unix timestamp updated
			"'{$_GET['ip']}', {$_GET['port']}, {$_SERVER['tracker']['seeding']}, " . time() . ' ); '
		) OR self::error( 'failed to add new peer data' );
	}


	/**
	 * full peer update
	 */
	public static function update_peer()
	{
		// include wordpress database
		global $wpdb;

		// update peer
		$wpdb->query(
			// update the peers table
			"UPDATE `" . KATRACKER_DB_PREFIX . "peers` " .
			// set the 6-byte compacted peer info
			"SET compact='" . esc_sql( pack( 'Nn', ip2long( $_GET['ip'] ), $_GET['port'] )) .
			// dotted decimal string ip, integer port
			"', ip='{$_GET['ip']}', port={$_GET['port']}, " .
			// integer state and unix timestamp updated
			"state={$_SERVER['tracker']['seeding']}, updated=" . time() .
			// that matches the given info_hash and peer_id
			" WHERE info_hash='{$_GET['info_hash']}' AND peer_id='{$_GET['peer_id']}'"
		) OR self::error( 'failed to update peer data' );
	}


	/**
	 * update peers last access time
	 */
	public static function update_last_access()
	{
		// include wordpress database
		global $wpdb;

		// update peer
		$wpdb->query(
			// set updated to the current unix timestamp
			"UPDATE `" . KATRACKER_DB_PREFIX . "peers` SET updated=" . time() .
			// that matches the given info_hash and peer_id
			" WHERE info_hash='{$_GET['info_hash']}' AND peer_id='{$_GET['peer_id']}'"
		) OR self::error( 'failed to update peers last access' );
	}


	/**
	 * remove existing peer
	 */
	public static function delete_peer()
	{
		// include wordpress database
		global $wpdb;

		// delete peer
		$wpdb->query(
			// delete a peer from the peers table
			"DELETE FROM `" . KATRACKER_DB_PREFIX . "peers` " .
			// that matches the given info_hash and peer_id
			"WHERE info_hash='{$_GET['info_hash']}' AND peer_id='{$_GET['peer_id']}'"
		) OR self::error( 'failed to remove peer data' );
	}


	/**
	 * tracker event handling
	 */
	public static function event()
	{
		// include wordpress database
		global $wpdb;

		// execute peer select
		$pState = $wpdb->get_row(
			// select a peer from the peers table
			"SELECT ip, port, state FROM `" . KATRACKER_DB_PREFIX . "peers` " .
			// that matches the given info_hash and peer_id
			"WHERE info_hash='{$_GET['info_hash']}' AND peer_id='{$_GET['peer_id']}'", ARRAY_N
		);

		// process tracker event
		switch ( (isset( $_GET['event'] ) ? $_GET['event'] : false ))
		{
			// client gracefully exited
			case 'stopped':
				// remove peer
				if ( isset( $pState[2] )) self::delete_peer();
				break;
			// client completed download
			case 'completed':
				// force seeding status
				$_SERVER['tracker']['seeding'] = 1;
			// client started download
			case 'started':
			// client continuing download
			default:
				// new peer
				if ( !isset( $pState[2] )) self::new_peer();
				// peer status
				elseif (
					// check that ip addresses match
					$pState[0] != $_GET['ip'] ||
					// check that listening ports match
					( $pState[1]+0 ) != $_GET['port'] ||
					// check whether seeding status match
					( $pState[2]+0 ) != $_SERVER['tracker']['seeding']
				) self::update_peer();
				// update time
				else self::update_last_access();
		}
	}


	/**
	 * return compact peers
	 *
	 * @param string $sql	sql to run
	 * @param string $response	response to modify
	 */
	public static function peers_compact( $sql, &$peers )
	{
		// include wordpress database
		global $wpdb;

		// fetch peers
		$peer_list = $wpdb->get_results( $sql, ARRAY_N );

		// build response
		foreach( $peer_list as $peer ) $peers .= $peer[0];

	}

	/**
	 * return dictionary peers
	 *
	 * @param string $sql	sql to run
	 * @param string $response	response to modify
	 */
	public static function peers_dictionary( $sql, &$response )
	{
		// include wordpress database
		global $wpdb;

		// fetch peers
		$peer_list = $wpdb->get_results( $sql, ARRAY_N );

		// dotted decimal string ip, 20-byte peer_id, integer port
		foreach( $peer_list as $peer ) $response .= 'd2:ip' . strlen( $peer[1] ) . ":{$peer[1]}" . "7:peer id20:{$peer[0]}4:porti{$peer[2]}ee";
	}

	/**
	 * return dictionary peers without peer_id
	 *
	 * @param string $sql	sql to run
	 * @param string $response	response to modify
	 */
	public static function peers_dictionary_no_peer_id( $sql, &$response )
	{
		// include wordpress database
		global $wpdb;

		// fetch peers
		$peer_list = $wpdb->get_results( $sql, ARRAY_N );

		// dotted decimal string ip, integer port
		foreach( $peer_list as $peer ) $response .= 'd2:ip' . strlen( $peer[0] ) . ":{$peer[0]}4:porti{$peer[1]}ee";
	}

	/**
	 * tracker peer list
	 */
	public static function peers()
	{
		// include wordpress database
		global $wpdb;

		// fetch peer total
		$total = $wpdb->get_var(
			// select a count of the number of peers
			"SELECT COUNT( * ) FROM `" . KATRACKER_DB_PREFIX . "peers` " .
			// that match the given info_hash
			"WHERE info_hash='{$_GET['info_hash']}'"
		);

			// select
		$sql = 'SELECT ' .
			// 6-byte compacted peer info
			( $_GET['compact'] ? 'compact ' :
			// 20-byte peer_id
			( !$_GET['no_peer_id'] ? 'peer_id, ' : '' ) .
			// dotted decimal string ip, integer port
			'ip, port '
			) .
			// from peers table matching info_hash
			"FROM `" . KATRACKER_DB_PREFIX . "peers` WHERE info_hash='{$_GET['info_hash']}'" .
			// less peers than requested, so return them all
			( $total <= $_GET['numwant'] ? ';' :
				// if the total peers count is low, use SQL RAND
				( $total <= $_SERVER['tracker']['random_limit'] ?
					" ORDER BY RAND() LIMIT {$_GET['numwant']};" :
					// use a more efficient but less accurate RAND
					" LIMIT {$_GET['numwant']} OFFSET " .
					mt_rand( 0, ( $total-$_GET['numwant'] ))
				)
			);

		// begin response
		$response = 'd8:intervali' . $_SERVER['tracker']['announce_interval'] .
						'e12:min intervali' . $_SERVER['tracker']['min_interval'] .
						'e5:peers';

		// compact announce
		if ( $_GET['compact'] )
		{
			// peers list
			$peers = '';

			// build response
			self::peers_compact( $sql, $peers );

			// 6-byte compacted peer info
			$response .= strlen( $peers ) . ':' . $peers;
		}
		// dictionary announce
		else
		{
			// list start
			$response .= 'l';

			// include peer_id
			if ( !$_GET['no_peer_id'] ) self::peers_dictionary( $sql, $response );
			// omit peer_id
			else self::peers_dictionary_no_peer_id( $sql, $response );

			// list end
			$response .= 'e';
		}

		// send response
		echo $response . 'e';

		// cleanup
		unset( $peers );
	}

	/**
	 * full scrape of all torrents
	 *
	 * @param string $sql	sql to run
	 * @param string $response	response to modify
	 */
	public static function full_scrape( $sql, &$response )
	{
		// include wordpress database
		global $wpdb;

		// fetch scrape
		$query = $wpdb->get_results( $sql, ARRAY_N );

		// 20-byte info_hash, integer complete, integer downloaded, integer incomplete
		foreach( $query as $scrape ) $response .= "20:{$scrape[0]}d8:completei{$scrape[1]}e10:downloadedi0e10:incompletei{$scrape[2]}ee";

	}

	/**
	 * tracker scrape
	 */
	public static function scrape()
	{
		// include wordpress database
		global $wpdb;

		// scrape response
		$response = 'd5:filesd';

		// scrape info_hash
		if ( isset( $_GET['info_hash'] ))
		{
			// scrape
			$scrape = $wpdb->get_row(
				// select total seeders and leechers
				'SELECT SUM( state=1 ), SUM( state=0 ) ' .
				// from peers
				"FROM `" . KATRACKER_DB_PREFIX . "peers` " .
				// that match info_hash
				"WHERE info_hash='{$_GET['info_hash']}'", ARRAY_N
			) OR self::error( 'unable to scrape the requested torrent'.$wpdb->last_error );

			// 20-byte info_hash, integer complete, integer downloaded, integer incomplete
			$response .= "20:{$_GET['info_hash']}d8:completei" . ( $scrape[0]+0 ) .
							'e10:downloadedi0e10:incompletei' . ( $scrape[1]+0 ) . 'ee';
		}
		// full scrape
		else
		{
			// scrape
			$sql = 'SELECT ' .
				// info_hash, total seeders and leechers
				'info_hash, SUM( state=1 ), SUM( state=0 ) ' .
				// from peers
				"FROM `" . KATRACKER_DB_PREFIX . "peers` " .
				// grouped by info_hash
				'GROUP BY info_hash';

			// build response
			self::full_scrape( $sql, $response );
		}

		// send response
		echo $response . 'ee';
	}

	/**
	 * Flush Torrent Statistics
	 */
	public static function flush_statistics()
	{
		// if the torrent does not exists as file in wordpress db, do nothing.
		if ( !$torrent_id = get_torrent_id_from_hash( $_GET['info_hash'] ) ) return;

		update_torrent_meta( $torrent_id, 'seeders', get_seeder_count( $torrent_id ) );
		update_torrent_meta( $torrent_id, 'leechers', get_leecher_count( $torrent_id ) );
	}

	/**
	 * check if the torrent approved by the tracker
	 */
	public static function validate()
	{
		if ( $_SERVER['tracker']['open_tracker'] ) return;
		// include wordpress database
		global $wpdb;
		$torrent = $wpdb->get_var( $wpdb->prepare(
			// select torrent ids
			"SELECT post_id " .
			// from wordpress postmeta table
			"FROM $wpdb->postmeta ".
			// where info hash is identical to current torrent
			"WHERE meta_value = %s AND meta_key = %s"
			,
			$_GET['info_hash'], KATRACKER_META_PREFIX . 'hash-info'
		) );

		// if the torrent is not approved exit
		if ( !get_torrent_meta( $torrent, 'track' )){
			self::error( 'torrent is not authorized on this tracker' );
		}

		unset( $torrent );
	}
}

?>
