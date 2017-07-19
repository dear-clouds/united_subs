<?php

/**
 * ECWD
 *
 */
class ECWD {

    protected $version = '1.0.83';
    protected $plugin_name = 'event-calendar-wd';
    protected $prefix = 'ecwd';
    protected static $instance = null;

    private function __construct() {

        $this->setup_constants();
        add_action('init', array($this, 'add_localization'), 1);
        include_once( 'includes/ecwd-shortcodes.php' );
        $this->includes();
        $cpt_instance = ECWD_Cpt::get_instance();
        $this->user_info();

        add_filter('body_class', array($this, 'theme_body_class'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 5);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('ecwd_show_related_events', array($this, 'show_related_events'), 10, 2);
    }

    public function show_related_events($events, $upcoming_events = false) {
        global $ecwd_options;
        $today = date('Y-m-d');
        $date_format = 'Y-m-d';
        $time_format = 'H:i';
        if (isset($ecwd_options['date_format']) && $ecwd_options['date_format'] != '') {
            $date_format = $ecwd_options['date_format'];
        }
        if (isset($ecwd_options['time_format']) && $ecwd_options['time_format'] != '') {
            $time_format = $ecwd_options['time_format'];
        }
        $time_format .= (isset($ecwd_options['time_type']) ? ' ' . $ecwd_options['time_type'] : '');
        if (isset($ecwd_options['time_type']) && $ecwd_options['time_type'] != '') {
            $time_format = str_replace('H', 'g', $time_format);
            $time_format = str_replace('h', 'g', $time_format);
        }


        if (isset($ecwd_options['related_events_count']) && intval($ecwd_options['related_events_count'])) {
            $related_events_count = intval($ecwd_options['related_events_count']);
        } else {
            $related_events_count = -1;
        }
        $related_events_count -= 1;
        include_once 'views/related_events.php';
    }

    /**
     * Setup constants
     */
    public function setup_constants() {
        if (!defined('ECWD_PLUGIN_DIR')) {
            define('ECWD_PLUGIN_DIR', dirname(__FILE__));
        }

        if (!defined('ECWD_PLUGIN_PREFIX')) {
            define('ECWD_PLUGIN_PREFIX', $this->prefix);
        }
        if (!defined('ECWD_PLUGIN_NAME')) {
            define('ECWD_PLUGIN_NAME', $this->plugin_name);
        }
        if (!defined('ECWD_URL')) {
            define('ECWD_URL', plugins_url(plugin_basename(dirname(__FILE__))));
        }if (!defined('ECWD_VERSION')) {
            define('ECWD_VERSION', $this->version);
        }
    }

    public function add_localization() {
        $path = dirname(plugin_basename(__FILE__)) . '/languages/';
        $loaded = load_plugin_textdomain('ecwd', false, $path);
        if (isset($_GET['page']) && $_GET['page'] == basename(__FILE__) && !$loaded) {
            echo '<div class="error">Event calendar WD ' . __('Could not load the localization file: ' . $path, 'ecwd') . '</div>';

            return;
        }
    }

    public function user_info() {
        //detect timezone
    }

    public static function theme_body_class(
    $classes
    ) {
        $child_theme = get_option('stylesheet');
        $parent_theme = get_option('template');
        if (!defined('ECWD_TEHEME')) {
            define('ECWD_TEHEME', $parent_theme);
        }

        if ($child_theme == $parent_theme) {
            $child_theme = false;
        }

        if ($child_theme) {
            $theme_classes = "ecwd-theme-parent-$parent_theme ecwd-theme-child-$child_theme";
        } else {
            $theme_classes = "ecwd-theme-$parent_theme";
        }
        $classes[] = $theme_classes;

        return $classes;
    }

    /**
     * Include all necessary files
     */
    public static function includes() {
        global $ecwd_options;

        include_once( 'includes/ecwd-cpt-class.php' );
        include_once( 'includes/register-settings.php' );
        $ecwd_options = ecwd_get_settings();

        if (isset($ecwd_options['time_zone'])) {
            $timezone = (self::isValidTimezone($ecwd_options['time_zone'])) ? $ecwd_options['time_zone'] : "";
        }else{
            $timezone = self::get_default_timezone();
        }

        if(!empty($timezone)) {
            date_default_timezone_set($timezone);
        }

        include_once('includes/ecwd-notices-class.php');
        require_once('includes/notices.php');
        include_once( 'includes/ecwd-functions.php' );
        include_once( 'includes/ecwd-event-class.php' );
        include_once( 'includes/ecwd-display-class.php' );

        include_once( 'views/widgets.php' );
    }

    /**
     * Load public facing scripts
     */
    public function enqueue_scripts() {
        global $wp_scripts, $post,$ecwd_options;        
        $gmap_key = (isset($ecwd_options['gmap_key'])) ? $ecwd_options['gmap_key'] : "";
        
        $map_included = false;
        if (is_object($post))
            if (isset($post->post_type) && ($post->post_type == 'ecwd_event' || $post->post_type == 'ecwd_venue' || strpos($post->post_content, 'ecwd id') !== false)) {
                if (isset($wp_scripts->registered) && $wp_scripts->registered) {
                    foreach ($wp_scripts->registered as $wp_script) {
                        if (isset($wp_scripts->src) && $wp_script->src && ( strpos($wp_script->src, 'maps.googleapis.com') || strpos($wp_script->src, 'maps.google.com') ) !== false) {
                            if (is_array($wp_scripts->queue) && in_array($wp_script->handle, $wp_scripts->queue)) {
                                $map_included = true;
                                break;
                            }
                        }
                    }
                }

                if (!$map_included && false) {
                    wp_enqueue_script($this->prefix . '-maps-public', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key='.$gmap_key, array('jquery'), $this->version, false);
                }
            }

        wp_enqueue_script($this->prefix . '-gmap-public', plugins_url('js/gmap/gmap3.js', __FILE__), array('jquery'), $this->version, true);
        wp_enqueue_script($this->prefix . '-popup', plugins_url('js/ecwd_popup.js', __FILE__), array('jquery'), $this->version, true);
        wp_enqueue_script($this->prefix . '-public', plugins_url('js/scripts.js', __FILE__), array(
            'jquery',
            'jquery-ui-draggable',
            'masonry',
            $this->prefix . '-popup'
                ), $this->version, true);
        wp_localize_script(ECWD_PLUGIN_PREFIX . '-public', 'ecwd', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'ajaxnonce' => wp_create_nonce(ECWD_PLUGIN_PREFIX . '_ajax_nonce'),
            'loadingText' => __('Loading...', 'ecwd'),
            'event_popup_title_text' => __('Event Details','ecwd'),
            'plugin_url' => ECWD_URL,
            'gmap_key'   => $gmap_key,
            'gmap_style' => (isset($ecwd_options['gmap_style'])) ? $ecwd_options['gmap_style'] : ""
        ));
        
    }

    /*
     * Load public facing styles
     */

    public function enqueue_styles() {
        global $ecwd_options;
        wp_enqueue_style($this->prefix . '-popup-style', plugins_url('/css/ecwd_popup.css', __FILE__), '', $this->version, 'all');
        wp_enqueue_style($this->prefix . '_font-awesome', plugins_url('/css/font-awesome/font-awesome.css', __FILE__), '', $this->version, 'all');
        wp_enqueue_style($this->prefix . '-public', plugins_url('css/style.css', __FILE__), '', $this->version, 'all');
        $css = (isset($ecwd_options['custom_css'])) ? $ecwd_options['custom_css'] : "";
        wp_add_inline_style($this->prefix . '-public', $css);
    }

    public static function isValidTimezone($timezone) {
        return in_array($timezone, timezone_identifiers_list());
    }

    public static function get_default_timezone() {
        $default_timezone = self::isValidTimezone(@ini_get('date.timezone')) ? ini_get('date.timezone') : 'Europe/Berlin';
        return $default_timezone;
    }

    /**
     * Return the plugin name.
     */
    public function get_name() {
        return $this->plugin_name;
    }

    /**
     * Return the plugin prefix.
     */
    public function get_prefix() {
        return $this->prefix;
    }

    /**
     * Return the plugin version.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * Return an instance of this class.
     */
    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

}
