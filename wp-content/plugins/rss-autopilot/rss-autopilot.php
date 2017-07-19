<?php
/*
    Plugin Name: RSS Autopilot (shared on themelot.net)
    Plugin URI: http://rss-autopilot.co (shared on themelot.net)detiburon.com/
    Description: Automate postings to your WordPress from various sources
    Version: 1.1.1
    Author: CodeTiburon
    Author URI: http://codetiburon.com
*/

define( 'RSSAP_VERSION', '1.1.1' );
define( 'RSSAP_REQUIRED_WP_VERSION', '3.8' );
define( 'RSSAP_PLUGIN', __FILE__ );
define( 'RSSAP_PLUGIN_BASENAME', plugin_basename( RSSAP_PLUGIN ) );
define( 'RSSAP_PLUGIN_NAME', trim( dirname( RSSAP_PLUGIN_BASENAME ), '/' ) );
define( 'RSSAP_PLUGIN_DIR', untrailingslashit( dirname( RSSAP_PLUGIN ) ) );
define( 'RSSAP_PLUGIN_MODULES_DIR', RSSAP_PLUGIN_DIR . '/modules' );

require_once RSSAP_PLUGIN_DIR . '/bootstrap.php';
$rssapBootstrap = new \RSSAutopilot\Bootstrap();
if ( is_admin() ) {
    $rssapBootstrap->loadAdmin();
}

/**
 * Get plugin URL
 * @param string $path
 * @return string
 */
function rssap_plugin_url( $path = '' ) {
    $url = plugins_url( $path, RSSAP_PLUGIN );

    if ( is_ssl() && 'http:' == substr( $url, 0, 5 ) ) {
        $url = 'https:' . substr( $url, 5 );
    }

    return $url;
}
//rss_autopilot_update_feeds();
/**
 * Admin panel CSS
 */
add_action( 'admin_enqueue_scripts', 'rssap_admin_enqueue_scripts' );
function rssap_admin_enqueue_scripts( $hook_suffix ) {
    wp_enqueue_style( 'rss-autopilot-admin',
        rssap_plugin_url( 'admin/css/styles.css' ),
        array(), RSSAP_VERSION, 'all' );

    if ( false !== strpos( $hook_suffix, 'rssap' ) )
    {
        wp_enqueue_style( 'rss-autopilot-main',
            rssap_plugin_url( 'admin/css/main.css' ),
            array(), RSSAP_VERSION, 'all' );
    }
}

/**
 * Activate plugin hook
 */
register_activation_hook( __FILE__, 'rss_autopilot_activate' );
add_action('rss_autopilot_update_event', 'rss_autopilot_update_feeds');

function logRSSAutoPilot($message) {
    $file = RSSAP_PLUGIN_DIR .'/logs.txt';

    if (!file_exists($file)) {
        $fp = fopen($file, 'w');
        fclose($fp);
    }

    if (is_writable($file)) {
        if (filesize($file) > 3000000) {
            @unlink($file);
        }

        $content = "\n".'['.date("Y-m-d H:i:s",time()).'] '.$message;
        $fp = fopen($file, 'a');
        fwrite($fp, $content);
        fclose($fp);
    }
}

function rss_autopilot_update_feeds() {
    logRSSAutoPilot('Task started');
    @set_time_limit(600);
    require_once(RSSAP_PLUGIN_DIR.'/../../../wp-admin/includes/file.php');
    global $rssapBootstrap;
    $rssapBootstrap->updateFeeds();
    logRSSAutoPilot('Task completed');
}

add_filter('cron_schedules', 'rss_autopilot_new_interval');

// add every minute interval to wp schedules
function rss_autopilot_new_interval($interval) {

    $interval['every_minute'] = array('interval' => 60, 'display' => 'Every minute');

    return $interval;
}

function rss_autopilot_activate()
{
    $version = get_option( '_rssap_version' );

    if ((!$version) || (version_compare($version, RSSAP_VERSION) < 0)) {
        update_option( '_rssap_version', RSSAP_VERSION );
    }

    wp_schedule_event(time(), 'every_minute', 'rss_autopilot_update_event');
}

/**
 * Register deactivation hook
 */
register_deactivation_hook(__FILE__, 'rss_autopilot_deactivate');
function rss_autopilot_deactivate() {
    wp_clear_scheduled_hook('rss_autopilot_update_event');
}



/**
 * Registering translations path
 */
add_action('plugins_loaded', 'rssap_load_textdomain');
function rssap_load_textdomain() {
    load_plugin_textdomain( 'rss-autopilot', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}

function rssap_json_encode($input)
{
    return preg_replace_callback(
        '/\\\\u([0-9a-zA-Z]{4})/',
        function ($matches) {
            return mb_convert_encoding(pack('H*',$matches[1]),'UTF-8','UTF-16');
        },
        json_encode($input)
    );
}



add_action( 'wp', 'rssap_remove_canonical' );
add_action( 'wp_head', 'rssap_on_head_load' );

function rssap_remove_canonical()
{
    if ( 'post' === get_post_type() && is_singular() ) {
        $feedId = get_post_meta( get_the_ID(), '_rss_feed_id', true );
        if ($feedId) {
            $addCanonical = get_post_meta( $feedId, '_add_canonical', true );
            if ($addCanonical) {
                remove_action( 'wp_head', 'rel_canonical' );
            }
        }
    }
}

/**
 * Add canonical URL if set
 */
function rssap_on_head_load() {
    if ( 'post' === get_post_type() && is_singular() ) {
        $feedId = get_post_meta( get_the_ID(), '_rss_feed_id', true );
        if ($feedId) {
            $addCanonical = get_post_meta( $feedId, '_add_canonical', true );
            if ($addCanonical) {
                $originalUrl = get_post_meta( get_the_ID(), '_rss_original_url', true );
                if ($originalUrl) {
                    echo '<link href="'.esc_attr($originalUrl).'" rel="canonical" />' . "\n";
                }
            }
        }
    }
}
?>