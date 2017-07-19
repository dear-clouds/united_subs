<?php

// Shared Constants ////////////////////////////////////////////////////////////////////////////////

 // Define Constants
global $wpdb;
define( 'KATRACKER_VERSION',      '1.0.7' );
define( 'KATRACKER_PRE',          'katracker' );
define( 'KATRACKER_PREFIX',       KATRACKER_PRE . '_' );
define( 'KATRACKER_META_PREFIX',  '_' . KATRACKER_PREFIX );
define( 'KATRACKER_DB_PREFIX',    $wpdb->base_prefix . 'tracker_' );
define( 'KATRACKER_CATEGORY',     'torrent-category' );
define( 'KATRACKER_SHORTCODE',    'torrent' );
define( 'KATRACKER_SHORTCODES',   'torrents' );
define( 'KATRACKER_URL',          ( get_option( 'permalink_structure' ) ?
                                  	( get_katracker_option( 'subdomain' ) ?
                                  	esc_url( str_replace( '://', '://' . get_katracker_option( 'slug' ) . '.', str_replace( 'www.', '', get_site_url() ) ) ) . '/' :
                                  		esc_url( get_site_url() . '/' . get_katracker_option( 'slug' ) . '/' ) ) :
                                  	esc_url( add_query_arg( 'pagename', get_katracker_option( 'slug' ), get_site_url() . '/' ) ) )
                                  );

?>
