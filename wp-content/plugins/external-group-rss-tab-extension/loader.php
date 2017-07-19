<?php
/*
  Plugin Name: External Group RSS tab extension
  PLugin URI: http://lenasterg.wordpress.com/
  Description: Adds tab in groups for external blog RSS feeds that attach  posts from rss's  to group activity. Requires External Group Blogs plugin (http://wordpress.org/extend/plugins/external-group-blogs/) to by installed.
  Version: 2.0
  Revision Date: October 22, 2013
  Requires at least: WP 3.5.1, BuddyPress 1.7
  Tested up to: WP 3.6.1, BuddyPress 1.8.1
  License:  GNU General Public License 3.0 or newer (GPL) http://www.gnu.org/licenses/gpl.html
  Author: Lena Stergatu,  NTS on cti.gr
  Author URI: http://lenasterg.wordpress.com)


  /* Only load code that needs BuddyPress to run once BP is loaded and initialized. */

define('EXTGR_RSS_TAB_PLUGIN_SELF_DIRNAME', basename(dirname(__FILE__)), true);
define('EXTGR_RSS_TAB_PROTOCOL', (@$_SERVER["HTTPS"] == 'on' ? 'https://' : 'http://'), true);


//Setup proper paths/URLs and load text domains
if (is_multisite() && defined('WPMU_PLUGIN_URL') && defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . '/' . basename(__FILE__))) {
    define('EXTGR_RSS_TAB_PLUGIN_LOCATION', 'mu-plugins', true);
    define('EXTGR_RSS_TAB_PLUGIN_BASE_DIR', WPMU_PLUGIN_DIR, true);
    define('EXTGR_RSS_TAB_PLUGIN_URL', str_replace('http://', EXTGR_RSS_TAB_PROTOCOL, WPMU_PLUGIN_URL), true);
    $textdomain_handler = 'load_muplugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . EXTGR_RSS_TAB_PLUGIN_SELF_DIRNAME . '/' . basename(__FILE__))) {
    define('EXTGR_RSS_TAB_PLUGIN_LOCATION', 'subfolder-plugins', true);
    define('EXTGR_RSS_TAB_PLUGIN_BASE_DIR', WP_PLUGIN_DIR . '/' . EXTGR_RSS_TAB_PLUGIN_SELF_DIRNAME, true);
    define('EXTGR_RSS_TAB_PLUGIN_URL', str_replace('http://', EXTGR_RSS_TAB_PROTOCOL, WP_PLUGIN_URL) . '/' . EXTGR_RSS_TAB_PLUGIN_SELF_DIRNAME, true);
    $textdomain_handler = 'load_plugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . basename(__FILE__))) {
    define('EXTGR_RSS_TAB_PLUGIN_LOCATION', 'plugins', true);
    define('EXTGR_RSS_TAB_PLUGIN_BASE_DIR', WP_PLUGIN_DIR, true);
    define('EXTGR_RSS_TAB_PLUGIN_URL', str_replace('http://', EXTGR_RSS_TAB_PROTOCOL, WP_PLUGIN_URL), true);
    $textdomain_handler = 'load_plugin_textdomain';
} else {
    // No textdomain is loaded because we can't determine the plugin location.
    // No point in trying to add textdomain to string and/or localizing it.
    wp_die(__('There was an issue determining where External Group RSS tab extension plugin is installed. Please reinstall.'));
}

/**
 * @author Stergatu Eleni 
 * @global type $wpdb
 * @return type
 * @version 1, 28/8/2013
 */
function extgr_rss_tab_init() {
    global $wpdb;
    if (is_multisite() && BP_ROOT_BLOG != $wpdb->blogid)
        return;
    if (!bp_is_active('groups'))
        return;
    if (!is_external_group_blogs_active())
        return;
    require_once(EXTGR_RSS_TAB_PLUGIN_BASE_DIR . '/extgr_rss_tab.php');
}

add_action('bp_include', 'extgr_rss_tab_init');

/**
 * @version 1, 28/8/2013
 * @return boolean
 */
function is_external_group_blogs_active() {
    if (in_array('external-group-blogs/loader.php', (array) get_option('active_plugins', array()))) {
        return true;
    } else {
        if (array_key_exists('external-group-blogs/loader.php', (array) get_site_option('active_sitewide_plugins'))) {
            return true;
        }
    }
    return false;
}
