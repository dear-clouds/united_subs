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

// Enviroment Runtime //////////////////////////////////////////////////////////////////////////////

// ignore disconnects
ignore_user_abort( true );

// load tracker core
require_once plugin_dir_path( __FILE__ ) . 'katracker.core.php';

// Verify Request //////////////////////////////////////////////////////////////////////////////////

if ( !isset( $_GET['info_hash'] ) || !isset( $_GET['peer_id'] )) return;

// strip auto-escaped data and
// make info_hash & peer_id SQL friendly
$_GET['info_hash'] = esc_sql( bin2hex( $_GET['info_hash'] ) );
$_GET['peer_id']   = esc_sql( bin2hex( $_GET['peer_id'] ) );

// 20-bytes - hex info_hash
// sha-1 hash of torrent metainfo
if ( strlen( $_GET['info_hash'] ) != 40 || strlen( $_GET['peer_id'] ) != 40 ) return;

// integer - port
// port the client is accepting connections from
if ( !( isset( $_GET['port'] ) && is_numeric( $_GET['port'] )) ) KatrackerCore::error( 'client listening port is invalid' );

// integer - left
// number of bytes left for the peer to download
if ( isset( $_GET['left'] ) && is_numeric( $_GET['left'] )) $_SERVER['tracker']['seeding'] = ( $_GET['left'] > 0 ? 0 : 1 );
else KatrackerCore::error( 'client data left field is invalid' );

// integer boolean - compact - optional
// send a compact peer response
// http://bittorrent.org/beps/bep_0023.html
if ( !isset( $_GET['compact'] ) || $_SERVER['tracker']['force_compact'] ) $_GET['compact'] = 1; else $_GET['compact'] += 0;

// integer boolean - no_peer_id - optional
// omit peer_id in dictionary announce response
if ( !isset( $_GET['no_peer_id'] )) $_GET['no_peer_4id'] = 0; else $_GET['no_peer_id'] += 0;

// string - ip - optional
// ip address the peer requested to use
if ( isset( $_GET['ip'] ) && $_SERVER['tracker']['external_ip'] )
{
	// dotted decimal only
	$_GET['ip'] = trim( $_GET['ip'],'::ffff:' );
	if ( !ip2long( $_GET['ip'] )) KatrackerCore::error( 'invalid ip, dotted decimal only' );
}
// set ip to connected client
elseif ( isset( $_SERVER['REMOTE_ADDR'] )) $_GET['ip'] = trim( $_SERVER['REMOTE_ADDR'],'::ffff:' );
// cannot locate suitable ip, must abort
else KatrackerCore::error( 'could not locate clients ip' );

// integer - numwant - optional
// number of peers that the client has requested
if ( !isset( $_GET['numwant'] )) $_GET['numwant'] = $_SERVER['tracker']['default_peers'];
elseif ( ($_GET['numwant']+0 ) > $_SERVER['tracker']['max_peers'] ) $_GET['numwant'] = $_SERVER['tracker']['max_peers'];
else $_GET['numwant'] += 0;

// Handle Request //////////////////////////////////////////////////////////////////////////////////

// check if the torrent is approved by the tracker
KatrackerCore::validate();

// announce peers
KatrackerCore::peers();

// track client
KatrackerCore::event();

// flush wordpress statistics
KatrackerCore::flush_statistics();

exit;

?>
