<?php
/**
 * Dashboard template: Support Functions > System Info
 * This file is loaded when the URL param `&view=system` is set.
 *
 * Displays details about the current WordPress setup.
 *
 * Following variables are passed into the template:
 *   $data (membership data)
 *   $profile (user profile data)
 *   $urls (urls of all dashboard menu items)
 *
 * @since  4.0.0
 * @package WPMUDEV_Dashboard
 */

// Collect system details to display.
global $wpdb, $wp_version;

// 1. PHP ---------------------------------------------------------------------
$dump_php = array();
$php_vars = array(
	'max_execution_time',
	'open_basedir',
	'memory_limit',
	'upload_max_filesize',
	'post_max_size',
	'display_errors',
	'log_errors',
	'track_errors',
	'session.auto_start',
	'session.cache_expire',
	'session.cache_limiter',
	'session.cookie_domain',
	'session.cookie_httponly',
	'session.cookie_lifetime',
	'session.cookie_path',
	'session.cookie_secure',
	'session.gc_divisor',
	'session.gc_maxlifetime',
	'session.gc_probability',
	'session.referer_check',
	'session.save_handler',
	'session.save_path',
	'session.serialize_handler',
	'session.use_cookies',
	'session.use_only_cookies',
);

$dump_php['Version'] = phpversion();
foreach ( $php_vars as $setting ) {
	$dump_php[ $setting ] = ini_get( $setting );
}
$dump_php['Error Reporting'] = implode( '<br>', __error_reporting() );
$extensions = get_loaded_extensions();
natcasesort( $extensions );
$dump_php['Extensions'] = implode( '<br>', $extensions );

// 2. MySQL -------------------------------------------------------------------
$dump_mysql = array();
$mysql_vars = array(
	'key_buffer_size'    => true,   // Key cache size limit.
	'max_allowed_packet' => false,  // Individual query size limit.
	'max_connections'    => false,  // Max number of client connections.
	'query_cache_limit'  => true,   // Individual query cache size limit.
	'query_cache_size'   => true,   // Total cache size limit.
	'query_cache_type'   => 'ON',   // Query cache on or off.
);
$extra_info = array();
$variables = $wpdb->get_results( "
	SHOW VARIABLES
	WHERE Variable_name IN ( '" . implode( "', '", array_keys( $mysql_vars ) ) . "' )
" );
$dbh = $wpdb->dbh;
if ( is_resource( $dbh ) ) {
	$driver  = 'mysql';
	$version = mysql_get_server_info( $dbh );
} elseif ( is_object( $dbh ) ) {
	$driver  = get_class( $dbh );
	if ( method_exists( $dbh, 'db_version' ) ) {
		$version = $dbh->db_version();
	} elseif ( isset( $dbh->server_info ) ) {
		$version = $dbh->server_info;
	} elseif ( isset( $dbh->server_version ) ) {
		$version = $dbh->server_version;
	} else {
		$version = __( 'Unknown', 'wpmudev' );
	}
	if ( isset( $dbh->client_info ) ) {
		$extra_info['Driver version'] = $dbh->client_info;
	}
	if ( isset( $dbh->host_info ) ) {
		$extra_info['Connection info'] = $dbh->host_info;
	}
} else {
	$version = $driver = __( 'Unknown', 'wpmudev' );
}
$extra_info['Database'] = $wpdb->dbname;
$extra_info['Charset'] = $wpdb->charset;
$extra_info['Collate'] = $wpdb->collate;
$extra_info['Table Prefix'] = $wpdb->prefix;

$dump_mysql['Server Version'] = $version;
$dump_mysql['Driver'] = $driver;
foreach ( $extra_info as $key => $val ) {
	$dump_mysql[ $key ] = $val;
}
foreach ( $mysql_vars as $key => $val ) {
	$dump_mysql[ $key ] = $val;
}
foreach ( $variables as $item ) {
	$dump_mysql[ $item->Variable_name ] = __value_format( $item->Value );
}

// 3. WordPress ---------------------------------------------------------------
$dump_wp = array();
$wp_consts = array(
	'ABSPATH',
	'WP_CONTENT_DIR',
	'WP_PLUGIN_DIR',
	'WPINC',
	'WP_LANG_DIR',
	'UPLOADBLOGSDIR',
	'UPLOADS',
	'WP_TEMP_DIR',
	'SUNRISE',
	'WP_ALLOW_MULTISITE',
	'MULTISITE',
	'SUBDOMAIN_INSTALL',
	'DOMAIN_CURRENT_SITE',
	'PATH_CURRENT_SITE',
	'SITE_ID_CURRENT_SITE',
	'BLOGID_CURRENT_SITE',
	'BLOG_ID_CURRENT_SITE',
	'COOKIE_DOMAIN',
	'COOKIEPATH',
	'SITECOOKIEPATH',
	'DISABLE_WP_CRON',
	'ALTERNATE_WP_CRON',
	'DISALLOW_FILE_MODS',
	'WP_HTTP_BLOCK_EXTERNAL',
	'WP_ACCESSIBLE_HOSTS',
	'WP_DEBUG',
	'WP_DEBUG_LOG',
	'WP_DEBUG_DISPLAY',
	'ERRORLOGFILE',
	'SCRIPT_DEBUG',
	'WP_LANG',
	'WP_MAX_MEMORY_LIMIT',
	'WP_MEMORY_LIMIT',
	'WPMU_ACCEL_REDIRECT',
	'WPMU_SENDFILE',
);
$dump_wp['WordPress Version'] = $wp_version;
foreach ( $wp_consts as $const ) {
	$dump_wp[ $const ] = __const_format( $const );
}

// 4. Server ------------------------------------------------------------------
$dump_server = array();
$server = explode( ' ', $_SERVER['SERVER_SOFTWARE'] );
$server = explode( '/', reset( $server ) );

if ( isset( $server[1] ) ) {
	$server_version = $server[1];
} else {
	$server_version = 'Unknown';
}
$lt = localtime();

$dump_server['Software Name'] = $server[0];
$dump_server['Software Version'] = $server_version;
$dump_server['Server IP'] = $_SERVER['SERVER_ADDR'];
$dump_server['Server Hostname'] = $_SERVER['SERVER_NAME'];
$dump_server['Server Admin'] = $_SERVER['SERVER_ADMIN'];
$dump_server['Server local time'] = date( 'Y-m-d H:i:s (\U\T\C P)' );
$dump_server['Operating System'] = @php_uname( 's' );
$dump_server['OS Hostname'] = @php_uname( 'n' );
$dump_server['OS Version'] = @php_uname( 'v' );

// 5. HTTP Requests -----------------------------------------------------------
$dump_http = array();
$options = array();
if ( WPMUDEV_API_UNCOMPRESSED ) { $options['decompress'] = false; }

$remote_url = WPMUDEV_Dashboard::$api->get_test_url();
$url = parse_url( $remote_url );
$remote_get = wp_remote_get( $remote_url, $options );
$remote_post = wp_remote_post( $remote_url, $options );
$remote_paypal = wp_remote_post(
	'https://api-3t.paypal.com/nvp',
	array( 'body' => '"METHOD=SetExpressCheckout&VERSION=63.0&USER=xxxxx&PWD=xxxxx&SIGNATURE=xxxxx' )
);

if ( is_wp_error( $remote_get ) ) {
	$remote_get = $remote_get->get_error_message();
} else {
	$remote_get = wp_remote_retrieve_response_message( $remote_get );
}

if ( is_wp_error( $remote_post ) ) {
	$remote_post = $remote_post->get_error_message();
} else {
	$remote_post = wp_remote_retrieve_response_message( $remote_post );
}

if ( is_wp_error( $remote_paypal ) ) {
	$remote_paypal = $remote_paypal->get_error_message();
} else {
	$remote_paypal = wp_remote_retrieve_response_message( $remote_paypal );
}

$dump_http['WPMU DEV API Server'] = $url['scheme'] . '://' . $url['host'];
$dump_http['WPMU DEV: GET'] = $remote_get;
$dump_http['WPMU DEV: POST'] = $remote_post;
$dump_http['PayPal API: POST'] = $remote_paypal;


/* -------------------------------------------------------------------------- */

// Render the page header section.
$page_title = __( 'Support', 'wpmudev' );
$page_title .= sprintf(
	' <a href="%s" class="button button-light title-function">%s</a>',
	$urls->support_url,
	__( 'Back to support', 'wpmudev' )
);
$this->render_header( $page_title );
?>

<div class="row">
<div class="tabs">

	<div class="tab">
		<input type="radio" id="tab-php" name="sysinfo" checked>
		<label for="tab-php">PHP</label>

		<div class="content">
			<?php __render_list( $dump_php ); ?>
		</div>
	</div>

	<div class="tab">
		<input type="radio" id="tab-mysql" name="sysinfo">
		<label for="tab-mysql">MySQL</label>

		<div class="content">
			<?php __render_list( $dump_mysql ); ?>
		</div>
	</div>

	<div class="tab">
		<input type="radio" id="tab-wordpress" name="sysinfo">
		<label for="tab-wordpress">WordPress</label>

		<div class="content">
			<?php __render_list( $dump_wp ); ?>
		</div>
	</div>

	<div class="tab">
		<input type="radio" id="tab-server" name="sysinfo">
		<label for="tab-server">Server</label>

		<div class="content">
			<?php __render_list( $dump_server ); ?>
		</div>
	</div>

	<div class="tab">
		<input type="radio" id="tab-http" name="sysinfo">
		<label for="tab-http">HTTP Requests</label>

		<div class="content">
			<?php __render_list( $dump_http ); ?>
		</div>
	</div>

	<?php if ( ! empty( $_COOKIE['wpmudev_is_staff'] ) || ! empty( $_GET['staff'] ) ) : ?>
	<div class="tab">
		<input type="radio" id="tab-notifications" name="sysinfo">
		<label for="tab-notifications">Notifications</label>

		<div class="content">
			<p class="tc"><em>- Additional briefing for support heroes -</em></p>
			<?php
			// @codingStandardsIgnoreStart: Dump is HTML code, no escaping!
			echo WPMUDEV_Dashboard::$notice->dump_queue();
			// @codingStandardsIgnoreEnd
			?>
		</div>
	</div>
	<?php endif; ?>

</div>
<?php
printf(
	esc_html__( 'Dashboard version %s', 'wpmudev' ),
	esc_html( WPMUDEV_Dashboard::$version )
);
?>
</div>


<?php

/**
 * Helper function
 *
 * @since  4.0.0
 * @param  array $list List of settings.
 */
function __render_list( $list ) {
	echo '<ul class="dev-list left top">';

	foreach ( $list as $key => $value ) {
		printf(
			'<li><div><span class="list-label list-header">%s</span><span class="list-detail">%s</span></div></li>',
			esc_html( $key ),
			// @codingStandardsIgnoreStart: Value contains HTML code, no escaping!
			$value
			// @codingStandardsIgnoreEnd
		);
	}
	echo '</ul>';
}

/**
 * Helper function.
 *
 * @since  4.0.0
 * @return array
 */
function __error_reporting() {
	$levels = array();
	$error_reporting = error_reporting();

	$constants = array(
		'E_ERROR',
		'E_WARNING',
		'E_PARSE',
		'E_NOTICE',
		'E_CORE_ERROR',
		'E_CORE_WARNING',
		'E_COMPILE_ERROR',
		'E_COMPILE_WARNING',
		'E_USER_ERROR',
		'E_USER_WARNING',
		'E_USER_NOTICE',
		'E_STRICT',
		'E_RECOVERABLE_ERROR',
		'E_DEPRECATED',
		'E_USER_DEPRECATED',
		'E_ALL',
	);

	foreach ( $constants as $level ) {
		if ( defined( $level ) ) {
			$c = constant( $level );
			if ( $error_reporting & $c ) {
				$levels[ $c ] = $level;
			}
		}
	}

	return $levels;
}

/**
 * Helper function.
 *
 * @since  4.0.0
 * @param  mixed $val Value to format.
 * @return string
 */
function __value_format( $val ) {
	if ( is_numeric( $val ) and ( $val >= ( 1024 * 1024 ) ) ) {
		$val = size_format( $val );
	}
	return $val;
}

/**
 * Helper function.
 *
 * @since  4.0.0
 * @param  string $constant Name of a PHP const.
 * @return string
 */
function __const_format( $constant ) {
	if ( ! defined( $constant ) ) {
		return '<em>undefined</em>';
	}

	$val = constant( $constant );
	if ( ! is_bool( $val ) ) {
		return $val;
	} elseif ( ! $val ) {
		return 'FALSE';
	} else {
		return 'TRUE';
	}
}
