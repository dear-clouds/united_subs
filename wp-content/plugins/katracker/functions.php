<?php

// Torrent Files Functions /////////////////////////////////////////////////////////////////////////

require_once plugin_dir_path( __FILE__ ) . 'torrent/torrent-class.php';

/**
 * A wrapper around wordpress get_posts function,
 * used to get the torrent post obects.
 *
 *
 * @see get_posts
 *
 * @param array $args {
 *	Optional. Arguments to retrieve posts.
 *
 *	@type int           $numtorrents  Total number of posts to retrieve. Accept -1 for all.
 *	                                  Defaults to -1.
 *	@type int|string    $category     Category ID or category slug.
 *	                                  Defaults null for all categories.
 *	@type array|string  $include      An array or comma-separated list of torrents IDs to retrieve.
 *	                                  Defaults to null.
 *	@type array|string  $exclude      An array or comma-separated list of torrents IDs to not retrieve.
 *	                                  Defaults to null.
 *	@type bool          $untracked    For closed trackers - whether to include untracked torent or not.
 *	                                  Defaults to open-tracker option.
 *	@type string        $orderby      Sort retrieved posts by parameter.
 *	                                  Defaults to title.
 *	@type string        $order        Designates the ascending or descending order of the 'orderby' parameter.
 *	                                  Defaults to ASC.
 * }
 * @return bool true on success false on fail or if not changed
 */
function get_torrents( $args = array() ) {
	$args = shortcode_atts( array(
		'numtorrents'  => -1,
		'torrent_ids'  => null,
		'category'     => null,
		'exclude'      => null,
		'include'      => null,
		'untracked'    => get_katracker_option( 'open-tracker' ),
		'orderby'      => 'title',
		'order'        => 'ASC',
		'bonus'        => null,
	), $args );
	$args = array(
		'posts_per_page'  => $args['numtorrents'],
		'post_type'       => 'attachment',
		'post_mime_type'  => 'torrent/torrent',
		'orderby'         => $args['orderby'],
		'order'           => $args['order'],
		'post__in'        => $args['torrent_ids'],
		'tax_query'       => isset( $args['category'] ) ?
		                     	( is_int( $args['category'] ) ? array(
		                     		array(
		                     			'taxonomy'  => KATRACKER_CATEGORY,
		                     			'field'     => 'term_id',
		                     			'terms'     => $args['category'],
		                     			)
		                     		) : array(
		                     			array(
		                     				'taxonomy'  => KATRACKER_CATEGORY,
		                     				'field'     => 'slug',
		                     				'terms'     => $args['category'],
		                     			)
		                     		) ) : null,
		'meta_query'      => array(
		                     	$args['untracked'] ?
		                     		array(
		                     			'key'    => KATRACKER_META_PREFIX . 'track',
		                     			'value'  => 1
		                     		) : null,
		                     	isset( $args['bonus'] ) ?
		                     		array(
		                     			'key'    => KATRACKER_META_PREFIX . 'bonus',
		                     			'value'  => $args['bonus'] ? 1 : 0
		                     		) : null
		                     ),
		'include'         => is_string( $args['include'] ) ?
		                     	explode( ',', $args['include'] ) :
		                     	$args['include'],
		'exclude'         => is_string( $args['exclude'] ) ?
		                     	explode( ',', $args['exclude'] ) :
		                     	$args['exclude'],
		'post_status'     => null
	);

	return get_posts( $args );
}

/**
 * Get the torrent ID from a given hash info
 *
 * @param int $hash_info
 * @return int torrent id or null on fail
 */
function get_torrent_id_from_hash ( $hash_info ) {
	global $wpdb;
	return $wpdb->get_var( $wpdb->prepare(
	       	// select torrent post_id
	       	'SELECT post_id ' .
	       	// from postmeta
	       	"FROM $wpdb->postmeta " .
	       	// that match hash_info
	       	"WHERE meta_value = %s",
	       	$hash_info
	       ) );
}

/**
 * Get the torrent ID from a given hash info
 *
 * @param int $hash_info
 * @return int torrent id or null on fail
 */
function generate_torrent_shortcode ( $torrent_id ) {
	return '['. KATRACKER_SHORTCODE .' id="' . $torrent_id . '"]';
}

/**
 * Get number of torrent seeders
 *
 * @param int $torrent_id if null return number of all seeders in the tracker
 * @return int
 */
function get_seeder_count( $torrent_id=null ) {
	global $wpdb;
	return $wpdb->get_var(
	       	// select total count
	       	'SELECT count( * ) ' .
	       	// from peers
	       	"FROM `" . KATRACKER_DB_PREFIX . "peers` " .
	       	// that match info_hash
	       	( isset( $torrent_id ) ? "WHERE info_hash = '" . get_torrent_meta( $torrent_id, 'hash-info' ) . "' AND " : "WHERE " ) .
	       	// and are currently seeding
	       	"state = 1"
	       ) + 0;
}

/**
 * Get number of torrent leechers
 *
 * @param int $torrent_id if null return number of all leechers in the tracker
 * @return int
 */
function get_leecher_count( $torrent_id=null ) {
	global $wpdb;
	return $wpdb->get_var(
	       	// select total count
	       	'SELECT count( * ) ' .
	       	// from peers
	       	"FROM `" . KATRACKER_DB_PREFIX . "peers` " .
	       	// that match info_hash
	       	( isset( $torrent_id ) ? "WHERE info_hash = '" . get_torrent_meta( $torrent_id, 'hash-info' ) . "' AND " : "WHERE " ) .
	       	// and are currently leeching
	       	"state = 0"
	) + 0;
}

/**
 * Increments a torrent hits by 1
 * 
 * @param int $torrent_id
 * @return bool true if succeeded, false otherwise
 */
function increment_torrent_hits($torrent_id) {
	return update_torrent_meta( $torrent_id, 'hits', get_torrent_meta( $torrent_id, 'hits') + 1);
}


/**
 * Get torrent stats array
 *
 * @param int $torrent_id
 * @return array
 */
function get_torrent_stats( $torrent_id=null ) {
	return isset( $torrent_id ) ?
	       	array(
	       		'seeders'   => get_torrent_meta( $torrent_id, 'seeders' ),
	       		'leechers'  => get_torrent_meta( $torrent_id, 'leechers' ),
	       	) : array(
	       		'seeders'   => get_seeder_count(),
	       		'leechers'  => get_leecher_count(),
	       	);
}

/**
 * Get count of all torrents
 *
 * @return int
 */
function get_torrent_count() {
	global $wpdb;
	return $wpdb->get_var(
	       	// select count
	       	"SELECT COUNT( * ) " .
	       	// from wordpress posts table
	       	"FROM `{$wpdb->posts}` " .
	       	// only attachment
	       	"WHERE post_type = 'attachment' " .
	       	// of type torrent
	       	"AND post_mime_type = 'torrent/torrent'"
	       ) + 0;
}


/**
 * Registers categories for attachments, to be used with torrents
 */
function register_torrent_category() {
	$args = array(
	        	'hierarchical'       => true,
	        	'show_ui'            => true,
	        	'show_admin_column'  => true,
	        	'query_var'          => true,
	        	'rewrite'            => array( 'slug' => get_katracker_option( 'slug' ) ),
	        );
	register_taxonomy( KATRACKER_CATEGORY, 'attachment', $args );
}

/**
 * Getter for the categories
 *
 * @param array $atts
 * @return array category list
 */
function get_katracker_categories( $atts=array() ) {
	$atts = shortcode_atts( array(
	        	'orderby'     => 'name',
	        	'hide_empty'  => 0
	        ), $atts );
	return get_terms( KATRACKER_CATEGORY, $atts );
}

/**
 * Getter for single category
 *
 * @param array $atts
 * @return array category list
 */
function get_katracker_category( $term_id ) {
	return get_term( $term_id, KATRACKER_CATEGORY );
}

/**
 *  Wrapper around wordpress get_post_meta
 *
 * This function will return only custom metadata used by this plugin!
 * if you want to get different metadata use get_post_meta.
 *
 * @see get_post_meta
 *
 * @param int			$torrent_id
 * @param string		$key
 * @return mixed
 */
function get_torrent_meta( $torrent_id, $key='' ) {
	switch ( $key ) {
		case '':
			$meta = array();
			$post_meta = get_post_meta( $torrent_id, '', true );
			foreach ( $post_meta as $key => $value ) {
				if ( preg_match( '/^' . KATRACKER_META_PREFIX . '/', $key ) ) {
					$meta[preg_replace( '/^' . KATRACKER_META_PREFIX . '/', '', $key )] = $value[0];
				}
			}
			$meta['thumbnail'] = isset( $post_meta['_thumbnail_id'][0] ) ? $post_meta['_thumbnail_id'][0] : false;
			return $meta;
		case 'thumbnail':
			return get_post_meta( $torrent_id, '_thumbnail_id', true );
		default:
			return get_post_meta( $torrent_id, KATRACKER_META_PREFIX . $key, true );
	}
}

/**
 * Wrapper around wordpress update_post_meta
 *
 * @see update_post_meta
 *
 * @param int     $torrent_id
 * @param string  $key
 * @param mixed   $value
 * @param bool    $add Optional. If true uses add_post_meta instead update_post_meta
 * @return mixed
 */
function update_torrent_meta( $torrent_id, $key, $value, $add=false ) {
	switch ( $key ) {
		case 'thumbnail':
			return $add ? add_post_meta( $torrent_id, '_thumbnail_id', $value, true ) : update_post_meta( $torrent_id, '_thumbnail_id', $value );
		default:
			return $add ? add_post_meta( $torrent_id, KATRACKER_META_PREFIX . $key, $value, true ) : update_post_meta( $torrent_id, KATRACKER_META_PREFIX . $key, $value );
	}
}

/**
 * Change the torrent status to active
 *
 * @param int $torrent_id
 * @return bool true on success false on fail or if not changed
 */
function track_katracker_torrent ( $torrent_id ) {
	if ( !katracker_valid_hash_info( get_torrent_meta( $torrent_id, 'hash-info' ) ) ) {
		return false;
	}
	return update_torrent_meta( $torrent_id, 'track', 1 );
}

/**
 * Change the torrent status to not active
 *
 * @param int $torrent_id
 * @return bool true on success false on fail or if not changed
 */
function untrack_katracker_torrent( $torrent_id ) {
	return update_torrent_meta( $torrent_id, 'track', 0 );
}

/**
 * Check if a given torrent hash info is validate
 *
 * @param string $hash_info hexadecimal string torrent hash info
 * @return bool
 */
function katracker_valid_hash_info( $hash_info ) {
	return !get_katracker_option( 'validate-hash' ) ||
	       !strpos( $hash_info, "00" ) ||
	       !( strpos( $hash_info, "00" ) % 2 == 0 );
}

/**
 * Tracker external page url generator
 *
 * @param string	$page desired tracker page
 * @param array	$args array of arguments to add to the url
 * @return string
 */
function get_katracker_url( $page, $args=array() ) {
	return get_option( 'permalink_structure' ) ?
	       esc_url( add_query_arg( $args, KATRACKER_URL . $page ) ) :
	       esc_url( add_query_arg( array_merge( array( 'page' => $page ), $args ), KATRACKER_URL ) );
}

/** Torrent download url generator
 * @param int $torrent_id
 * @return string
 */
function katracker_download_url( $torrent_id ) {
	return get_katracker_url( 'download', array( 'torrent' => $torrent_id ) );
}

/** Torrent magnet url generator
* @param int $torrent_id
* @return string
*/
function katracker_magnet_url( $torrent_id ) {
	return get_katracker_url( 'magnet', array( 'torrent' => $torrent_id ) );
}



// Tracker Settings Functions //////////////////////////////////////////////////////////////////////

/** Wrapper around wordpress get_option
 *
 * @see get_option
 *
 * @param string		$option
 * @param string|bool	$default
 * @return bool
 */
function get_katracker_option( $option, $default=false ) {
	return get_option( KATRACKER_PREFIX . $option, $default );
}

/** Wrapper around wordpress update_option
 *
 * @see update_option
 *
 * @param string		$option
 * @param mixed			$value
 * @param string|bool	$autoload
 * @return bool
 */
function update_katracker_option( $option, $value, $autoload=null ) {
	return update_option( KATRACKER_PREFIX . $option, $value, $autoload );
}


/**
* Uninstall function for the tracker.
*
* @param bool|string $part uninstalls only the part specifiedm default false.
*
* @return bool true if succeeded, false otherwise
*/
function katracker_settings_init( $uninstall=null ) {
	$options = array(
	           	'init'               => 1,
	           	'acitve'             => 1,
	           	'validate-hash'      => 1,
	           	'labels'             => '',
	           	'rename-files'       => 0,
	           	'tracked-access'     => 0,
	           	'torrent-page'       => 1,
	           	'slug'               => 'katracker',
	           	'subdomain'          => 0,
	           	'reset-announce'     => 0,
	           	'default-announce'   => '',
	           	'reset-comment'      => 0,
	           	'default-comment'    => '',
	           	'open-tracker'       => 0,
	           	'announce-interval'  => 30,
	           	'min-interval'       => 15,
	           	'num-peers'          => 50,
	           	'max-peers'          => 100,
	           	'external-ip'        => true,
	           	'force-compact'      => false,
	           	'full-scrape'        => false,
	           	'random-limit'       => 500,
	           );
	$success = true;
	if ( isset( $uninstall ) && $uninstall ) {
		foreach ( array_keys( $options ) as $option ) {
			delete_option( KATRACKER_PREFIX . $option );
		}
	}
	else {
		foreach ( $options as $key => $value ) {
			$success &= update_katracker_option( $key, $value );
		}
	}
	return $success;
}

// Init and Uninstall Functions ////////////////////////////////////////////////////////////////////

/**
 * Uninstall function for the tracker.
 *
 * @param bool|string $part uninstalls only the part specifiedm default false.
 *
 * @return bool true if succeeded, false otherwise
 */
function katracker_uninstall( $part=false ) {
	switch ( $part ){
		case 'torrents':
			$torrents = get_posts( array(
			            	'posts_per_page' => -1,
			            	'post_type' => 'attachment',
			            	'post_mime_type' => 'torrent/torrent',
			            	'post_status' => null
			            ) );

			$success = true;

			foreach ( $torrents as $torrent ) {
				$success &= ( bool )wp_delete_post( $torrent->ID, true );
			}

			return $success;
		case 'full':
			return katracker_db_init( true ) &&
			       katracker_settings_init( true ) &&
			       katracker_torrent_init( null, true );
	}
}

/**
 * Create the database tables required for the tracker,
 * also servse as uninstall function for the database tables.
 *
 * @param bool uninstall default false.
 *
 * @return bool true if succeeded, false otherwise
 */
function katracker_db_init( $uninstall=false ) {
	global $wpdb;
	return $uninstall ?
		$wpdb->query(
			"DROP TABLE IF EXISTS `" . KATRACKER_DB_PREFIX . "peers`"
		) :
		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS `" . KATRACKER_DB_PREFIX . "peers` ( " .
				"`info_hash` varchar( 40 ) COLLATE {$wpdb->collate} NOT NULL," .
				"`peer_id` varchar( 40 ) COLLATE {$wpdb->collate} NOT NULL," .
				"`compact` binary( 6 ) NOT NULL," .
				"`ip` char( 15 ) NOT NULL," .
				"`port` smallint( 5 ) unsigned NOT NULL," .
				"`state` tinyint( 1 ) unsigned NOT NULL DEFAULT '0'," .
				"`updated` int( 10 ) unsigned NOT NULL," .
				"PRIMARY KEY ( `info_hash`,`peer_id` )" .
			" )" . $wpdb->get_charset_collate()
		);
}

/**
 * Generates all torrent metadata and sets default values,
 * servse also as uninstall function for a torrent.
 *
 * @param null|int  $attachment_id torrent id to init
 * @param bool      $uninstall if true, uninstalls the torrent
 *
 * @return bool true if succeeded, false otherwise
 */
function katracker_torrent_init( $attachment_id=null, $uninstall=false ) {
	if ( isset( $attachment_id ) && get_post_mime_type( $attachment_id ) != 'torrent/torrent' ) return;
	$torrent = isset( $attachment_id ) ? new TorrentFile( get_attached_file( $attachment_id ) ) : null;

	$metadata = array(
		'magnet'        => isset( $torrent ) ? $torrent->magnet()     : '',
		'hash-info'     => isset( $torrent ) ? $torrent->hash_info()  : '',
		'size'          => isset( $torrent ) ? $torrent->size()       : '',
		'name'          => isset( $torrent ) ? $torrent->name()       : '',
		'files'         => isset( $torrent ) ? $torrent->offset()     : '',
		'announce'      => isset( $torrent ) ? $torrent->announce()   : '',
		'comment'       => isset( $torrent ) ? $torrent->comment()    : '',
		'ep-start'      => null,
		'ep-end'        => null,
		'label'         => 'Default',
		'bonus'         => 0,
		'track'         => 0,
		'update-title'  => 1,
		'hits'          => 0,
		'seeders'       => 0,
		'leechers'      => 0
	);

	$success = true;

	if ( !isset( $attachment_id ) && $uninstall ) {
		foreach( array_keys( $metadata ) as $key ) {
			$success &= delete_post_meta_by_key( KATRACKER_META_PREFIX . $key );
		}
	} elseif ( isset( $attachment_id ) ) {
		foreach ( $metadata as $key => $value ) {
			update_torrent_meta( $attachment_id, $key, $value, true );
		}
	} else {
		return false;
	}
	return $success;
}

/**
 * Katracker Init Function
 * Generates metadata for all exsiting torrents
 *
 * @param array $atts attributes for get_torrents function
 * @see get_torrents
 *
 * @return bool true if succeeded, false otherwise
 */
function katracker_install_torrents_meta( $atts=array() ) {
	if ( !isset( $atts['untracked'] ) ) $atts['untracked'] = true;
	$torrents = get_torrents( $atts );
	$success = true;
	foreach ( $torrents as $torrent ) {
		$success &= katracker_torrent_init( $torrent->ID );
	}
	return $success;
}

function katracker_load_text_domain() {
	// Traditional WordPress plugin locale filter
	$locale        = apply_filters( 'plugin_locale', get_locale(), KATRACKER_PRE );
	$mofile        = sprintf( '%1$s-%2$s.mo', KATRACKER_PRE, $locale );
	
	// Setup paths to current locale file
	$mofile_local  = trailingslashit( plugin_dir_path( __FILE__ ), 'languages' ) . $mofile;
	$mofile_global = WP_LANG_DIR . '/' . KATRACKER_PRE . '/' . $mofile;
	
	// Look in global /wp-content/languages/bbpress folder
	load_textdomain( KATRACKER_PRE, $mofile_global );
	
	// Look in local /wp-content/plugins/bbpress/bbp-languages/ folder
	load_textdomain( KATRACKER_PRE, $mofile_local );
	
	// Look in global /wp-content/languages/plugins/
	load_plugin_textdomain( KATRACKER_PRE );
}

?>
