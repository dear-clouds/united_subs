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

if ( !isset( $_GET['info_hash'] ) ) return;

// strip auto-escaped data
$_GET['info_hash'] = esc_sql( bin2hex( $_GET['info_hash'] ) );

// 20-bytes - info_hash
// sha-1 hash of torrent being tracked
if ( strlen( $_GET['info_hash'] ) != 40 )
{
	// full scrape disabled
	if ( !$_SERVER['tracker']['full_scrape'] ) return;
	// full scrape enabled
	else unset( $_GET['info_hash'] );
}

// Handle Request //////////////////////////////////////////////////////////////////////////////////

// check if the torrent is approved by the tracker
KatrackerCore::validate();

// perform scrape
KatrackerCore::scrape();

exit;

?>
