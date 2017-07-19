<?php

/**
 * ECWD_Admin
 */
class ECWD_Admin {

    protected static $instance = null;
    protected $version = '1.0.83';
    protected $ecwd_page = null;
    protected $notices = null;

    private function __construct() {
        $plugin = ECWD::get_instance();
        $this->prefix = $plugin->get_prefix();
        $this->version = $plugin->get_version();
        $this->notices = new ECWD_Notices();
        add_filter('plugin_action_links_' . plugin_basename(plugin_dir_path(__FILE__) . $this->prefix . '.php'), array(
            $this,
            'add_action_links'
        ));
        $this->ecwd_config();
        // Setup admin stants
        add_action('init', array($this, 'define_admin_constants'));
        add_action('init', array($this, ECWD_PLUGIN_PREFIX . '_shortcode_button'));

        // Add admin styles and scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

        // Add the options page and menu item.
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'), 10);
        add_action('admin_menu', array($this, 'featured_plugins'), 30);
        add_filter('parent_file', array($this,'ecwd_set_current_menu'));

        foreach (array('post.php', 'post-new.php') as $hook) {
            add_action("admin_head-$hook", array($this, 'admin_head'));
        }
        //add_filter( 'auto_update_plugin', array($this, 'ecwd_update'), 10, 2 );
        //Web Dorado Logo
        add_action('admin_notices', array($this, 'create_logo_to_head'));
        // Runs the admin notice ignore function incase a dismiss button has been clicked
        add_action('admin_init', array($this, 'admin_notice_ignore'));
        add_action('admin_notices', array($this, 'ecwd_admin_notices'));
        add_action('admin_init', array($this, 'include_ecwd_pointer_class'));
    }

    /**
     * Check user is on plugin page
     * @return  bool
     */
    private function ecwd_page() {
        if (!isset($this->ecwd_page)) {
            return false;
        }
        $screen = get_current_screen();
        if ($screen->id == 'edit-ecwd_event' || $screen->id == ECWD_PLUGIN_PREFIX . '_event' || in_array($screen->id, $this->ecwd_page) || $screen->post_type == ECWD_PLUGIN_PREFIX . '_event' || $screen->post_type == ECWD_PLUGIN_PREFIX . '_theme' || $screen->post_type == ECWD_PLUGIN_PREFIX . '_venue' || $screen->id == 'edit-ecwd_calendar' || $screen->id == ECWD_PLUGIN_PREFIX . '_calendar' || $screen->id == ECWD_PLUGIN_PREFIX . '_countdown_theme' || $screen->post_type == ECWD_PLUGIN_PREFIX . '_organizer') {
            return true;
        } else {
            return false;
        }
    }

    public static function activate() {
        if (!defined('ECWD_PLUGIN_PREFIX')) {
            define('ECWD_PLUGIN_PREFIX', 'ecwd');
        }
        $has_option = get_option('ecwd_old_events');
        if ($has_option === false) {
            $old_event = get_posts(array(
                'posts_per_page' => 1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_type' => 'ecwd_event',
                'post_status' => 'any'
            ));
            if ($old_event && isset($old_event[0]->post_date)) {
                add_option('ecwd_old_events', 1);
            } else {
                add_option('ecwd_old_events', 0);
            }
        }

        $calendars = get_posts(array(
          'post_type' => 'ecwd_calendar',
        ));

      $blue_theme = get_page_by_title('Default', 'OBJECT', 'ecwd_theme');
      $blue_id = (isset($blue_theme->ID)) ? $blue_theme->ID : 0;

      $calendar = get_posts($calendars);
      if (!empty($calendar)) {
        foreach ($calendars as $calendar) {
          $theme_id = get_post_meta($calendar->ID, 'ecwd_calendar_theme', true);
          if ($theme_id == $blue_id) {
            update_post_meta($calendar->ID, 'ecwd_calendar_theme', "calendar");
          } else {
            update_post_meta($calendar->ID, 'ecwd_calendar_theme', "calendar_grey");
          }
        }
      }

        include_once ECWD_DIR . '/includes/ecwd_config.php';
        $conf = ECWD_Config::get_instance();
        $conf->update_conf_file();
        if (get_option("ecwd_version") == false) {
            self::fix_events_locations();
        }
        update_option('ecwd_version', ECWD_VERSION);
    }

    static function fix_events_locations(){
        $venue_cache = array();
        $args = array(
            'numberposts' => -1,
            'post_type' => 'ecwd_event'
        );
        $events = get_posts($args);
        if(empty($events)){
            return;
        }

        foreach ($events as $event) {
            $venue_id = intval(get_post_meta($event->ID,'ecwd_event_venue',true));
            if(empty($venue_id)){
                continue;
            }

            if(!isset($venue_cache[$venue_id])){
                $venue_cache[$venue_id] = array(
                    'ecwd_venue_location' => get_post_meta($venue_id,'ecwd_venue_location',true),
                    'ecwd_venue_lat_long' => get_post_meta($venue_id,'ecwd_venue_lat_long',true)
                );
            }
            update_post_meta($event->ID,'ecwd_event_location',$venue_cache[$venue_id]['ecwd_venue_location']);
            update_post_meta($event->ID,'ecwd_lat_long',$venue_cache[$venue_id]['ecwd_venue_lat_long']);
        }

    }

    public static function uninstall() {

    }

    public function add_plugin_admin_menu() {
        global $ecwd_config;
        $this->ecwd_page[] = add_submenu_page(
            'edit.php?post_type=ecwd_calendar',
            __('Event Categories', 'ecwd'),
            __('Event Categories', 'ecwd'),
            'manage_options',
            'edit-tags.php?taxonomy=ecwd_event_category&post_type=ecwd_event',
            null
        );

        $this->ecwd_page[] = add_submenu_page(
            'edit.php?post_type=ecwd_calendar',
            __('Event Tags', 'ecwd'),
            __('Event Tags', 'ecwd'),
            'manage_options',
            'edit-tags.php?taxonomy=ecwd_event_tag&post_type=ecwd_event',
            null
        );

        $this->ecwd_page[] = add_submenu_page(
          'edit.php?post_type=ecwd_calendar', __('Settings', 'ecwd'), __('Settings', 'ecwd'), 'manage_options', $this->prefix . '_general_settings', array(
            $this,
            'display_admin_page'
          )
        );

        $this->ecwd_page[] = add_submenu_page(
                'edit.php?post_type=ecwd_calendar', __('Licensing', 'ecwd'), __('Licensing', 'ecwd'), 'manage_options', $this->prefix . '_licensing', array(
            $this,
            'display_license_page'
                )
        );

//        $this->ecwd_page[] = add_submenu_page(
//                'edit.php?post_type=ecwd_calendar', __('Featured plugins', 'ecwd'), __('Featured plugins', 'ecwd'), 'manage_options', $this->prefix . '_featured_plugins', array(
//            $this,
//            'display_featured_plugins'
//                )
//        );
//        $this->ecwd_page[] = add_submenu_page(
//                'edit.php?post_type=ecwd_calendar', __('Featured themes', 'ecwd'), __('Featured themes', 'ecwd'), 'manage_options', $this->prefix . '_featured_themes', array(
//            $this,
//            'display_featured_themes'
//                )
//        );
        $this->ecwd_page[] = add_menu_page(
                __('Calendar Add-ons', 'ecwd'), __('Calendar Add-ons', 'ecwd'), 'manage_options', $this->prefix . '_addons', array(
            $this,
            'display_addons_page'
                ), plugins_url('/assets/add-ons-icon.png', ECWD_MAIN_FILE), '26,12'
        );
        $this->ecwd_page[] = add_menu_page(
                __('Calendar Themes', 'ecwd'), __('Calendar Themes', 'ecwd'), 'manage_options', $this->prefix . '_themes', array(
            $this,
            'display_themes_page'
                ), plugins_url('/assets/themes-icon.png', ECWD_MAIN_FILE), '26,18'
        );
        if ($ecwd_config['show_config_submenu']) {
            $this->ecwd_page[] = add_submenu_page(
                    'edit.php?post_type=ecwd_calendar', __('Config', 'ecwd'), __('Config', 'ecwd'), 'manage_options', $this->prefix . '_config', array(
                $this,
                'display_config_page'
                    )
            );
        }
    }

    public function featured_plugins(){
        $this->ecwd_page[] = add_submenu_page(
          'edit.php?post_type=ecwd_calendar', __('Featured plugins', 'ecwd'), __('Featured plugins', 'ecwd'), 'manage_options', $this->prefix . '_featured_plugins', array(
            $this,
            'display_featured_plugins'
          )
        );
        $this->ecwd_page[] = add_submenu_page(
          'edit.php?post_type=ecwd_calendar', __('Featured themes', 'ecwd'), __('Featured themes', 'ecwd'), 'manage_options', $this->prefix . '_featured_themes', array(
            $this,
            'display_featured_themes'
          )
        );
    }

    public function ecwd_set_current_menu() {

        global $submenu_file, $current_screen, $pagenow;
        if ($current_screen->post_type == 'ecwd_event') {
            if ($pagenow == 'post.php') {
                $submenu_file = 'edit.php?post_type=' . $current_screen->post_type;
            }

            if ($pagenow == 'edit-tags.php') {
                if($_GET['taxonomy'] == 'ecwd_event_tag'){
                    $submenu_file = 'edit-tags.php?taxonomy=ecwd_event_tag&post_type=' . $current_screen->post_type;
                }else{
                    $submenu_file = 'edit-tags.php?taxonomy=ecwd_event_category&post_type=' . $current_screen->post_type;
                }
            }
            $parent_file = 'edit.php?post_type=ecwd_calendar';
            return $parent_file;
        }
    }

    public function include_ecwd_pointer_class() {
        include_once ('includes/ecwd_pointers.php');
        $ecwd_pointer = new Ecwd_pointers();
    }

    public function display_addons_page() {

        $addons = array(
            'Management' => array(
                'add_event' => array(
                    'name' => 'ECWD Frontend Event Management',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/frontend-event-management.html',
                    'description' => 'This add-on is designed for  allowing the users/guests to add events to the calendar from the front end. In addition, the users can also have permissions to edit/delete their events.',
                    'icon' => '',
                    'image' => plugins_url('assets/add_addevent.jpg', __FILE__),
                ),
                'import_export' => array(
                    'name' => 'ECWD Import/Export',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/import-export.html',
                    'description' => 'The following data of the Event Calendar WD can be exported and imported: Events, Categories, Venues,Organizers and Tags. The exported/imported data will be in CSV format, which can be further edited, modified and imported',
                    'icon' => '',
                    'image' => plugins_url('assets/import_export.png', __FILE__)
                ),
                'custom_fields' => array(
                    'name' => 'ECWD Custom Fields',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/custom-fields.html',
                    'description' => 'Custom Fields Add-On will enable you to have more fields for more detailed and structured content: you can use this add-on and create additional fields for each event, venue and organizer.',
                    'icon' => '',
                    'image' => plugins_url('assets/custom_fields.png', __FILE__)
                ),
                'ecwd_subscribe' => array(
                    'name' => 'ECWD Subscribe',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/subscribe.html',
                    'description' => 'Event Calendar Subscription Add-on  is a great too which allows subscribing to events based on category, tag, organizer and venue.',
                    'icon' => '',
                    'image' => plugins_url('assets/Subscribe.png', __FILE__)
                ),
                'ecwd_export' => array(
                    'name' => 'ECWD Export to GCal/ICal',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/export.html',
                    'description' => 'Export add-on will enable your calendar users to export single or whole month events in CSV and ICS formats and import to their iCalendars and Google calendars.',
                    'icon' => '',
                    'image' => plugins_url('assets/export_addon.png', __FILE__),
                )
            ),
            'Events Grouping' => array(
                'event_filters' => array(
                    'name' => 'ECWD Filter Bar',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/filter.html',
                    'description' => 'This add-on is designed for advanced event filter and browsing. It will display multiple filters, which will make it easier for the user to find the relevant event from the calendar.',
                    'icon' => '',
                    'image' => plugins_url('assets/add_filters.png', __FILE__),
                ),
                'event_countdown' => array(
                    'name' => 'ECWD Event Countdown',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/countdown.html',
                    'description' => 'With this add-on you can add an elegant countdown to your site. It supports calendar events or a custom one. The styles and colors of the countdown can be modified. It can be used as both as widget and shortcode.',
                    'icon' => '',
                    'image' => plugins_url('assets/add_cdown.jpg', __FILE__),
                ),
                'upcoming_events' => array(
                    'name' => 'ECWD Upcoming events widget',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/upcoming-events.html',
                    'description' => 'The Upcoming events widget is designed for displaying upcoming events lists. The number of events, the event date ranges, as well as the appearance of the widget is fully customizable and easy to manage.',
                    'icon' => '',
                    'image' => plugins_url('assets/upcoming_events.png', __FILE__),
                ),
                'ecwd_views' => array(
                    'name' => 'ECWD views',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/views.html',
                    'description' => 'ECWD Views is a convenient add-on for displaying one of the additional Pro views within the pages and posts. The add-on allows choosing the time range of the events, which will be displayed with a particular view.',
                    'icon' => '',
                    'image' => plugins_url('assets/ecwd_views.png', __FILE__),
                ),
            ),
            'Integrations' => array(
                'fb' => array(
                    'name' => 'ECWD Facebook Integration',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/facebook-integration.html',
                    'description' => 'This addon integrates ECWD with your Facebook page and gives functionality to import events or just display events without importing.',
                    'icon' => '',
                    'image' => plugins_url('assets/add_fb.jpg', __FILE__),
                ),
                'gcal' => array(
                    'name' => 'ECWD Google Calendar Integration',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/google-calendar-integration.html',
                    'description' => 'This addon integrates ECWD with your Google Calendar and gives functionality to import events or just display events without importing.',
                    'icon' => '',
                    'image' => plugins_url('assets/add_gcal.jpg', __FILE__),
                ),
                'ical' => array(
                    'name' => 'ECWD iCAL Integration',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/ical-integration.html',
                    'description' => 'This addon integrates ECWD with your iCAL Calendar and gives functionality to import events or just display events without importing.',
                    'icon' => '',
                    'image' => plugins_url('assets/add_ical.jpg', __FILE__)
                ),
                'tickets' => array(
                    'name' => 'ECWD Event Tickets',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/event-tickets.html',
                    'description' => 'Event Tickets Add-on is an easy set up tool for integrating ECWD with WooCommerce to sell tickets for your events.',
                    'icon' => '',
                    'image' => plugins_url('assets/ticketing_addon.png', __FILE__)
                ),
                'ecwd_embed' => array(
                    'name' => 'ECWD Embed',
                    'url' => 'https://web-dorado.com/products/wordpress-event-calendar-wd/add-ons/embed.html',
                    'description' => 'This add-on will allow displaying a calendar from your site  to other websites using embed code without need of installing ECWD plugin.',
                    'icon' => '',
                    'image' => plugins_url('assets/embed_addon.png', __FILE__),
                )
            )
        );
        include_once( 'views/admin/addons.php' );
    }

    public function display_featured_themes() {
        include_once( ECWD_DIR . '/views/admin/ecwd-featured-themes.php' );
        $theme = new ECWDFeaturedThemes();
        $theme->display();
    }

    public function display_featured_plugins() {
        include_once( ECWD_DIR . '/views/admin/ecwd-featured-plugins.php' );
    }

    public function display_themes_page() {
        include_once( ECWD_DIR . '/views/admin/ecwd-theme-meta.php' );
    }

    public function display_license_page() {
        include_once( ECWD_DIR . '/views/admin/licensing.php' );
    }

    public function display_admin_page() {
        include_once( 'views/admin/admin.php' );
    }

    public function display_config_page() {
        $post_type = (isset($_GET['post_type']) && $_GET['post_type'] == 'ecwd_calendar');
        $page = (isset($_GET['page']) && $_GET['page'] == 'ecwd_config');
        $save_config = (isset($_GET['ecwd_save_config']) && $_GET['ecwd_save_config'] == '1');

        $config_obj = ECWD_Config::get_instance();

        if ($post_type && $page && $save_config) {
            $config_obj->save_new_config($_POST);
        }

        $configs = $config_obj->get_config();
        $response = $config_obj->get_response();
        $action = $_SERVER['REQUEST_URI'] . '&ecwd_save_config=1';

        include(ECWD_DIR . '/views/admin/ecwd-config.php');
    }

    public function ecwd_edit_template($type) {
        $option = $this->mail_template[$type]['option_name'];
        $name = $this->mail_template[$type]['name'];

        if (isset($_POST['mail_content']) && isset($_POST['ecwd_edit_template']) && check_admin_referer($type, 'ecwd_edit_template')) {
            update_option($option, $_POST['mail_content']);
        }
        $html = get_option($option);
        if ($html !== false) {
            $ajax_action = (isset($_GET['action'])) ? $_GET['action'] : "";
            $events = array();
            if (isset($_GET['ecwd_event_list']) && $_GET['ecwd_event_list'] == true) {
                $events = get_posts(array('numberposts' => -1, 'post_type' => 'ecwd_event', 'post_status' => 'publish'));
            }
            include_once('views/admin/ecwd-mail-template.php');
        }
    }

    /**
     * Enqueue styles for the admin area
     */
    public function enqueue_admin_styles() {
        wp_enqueue_style($this->prefix . '-calendar-buttons-style', plugins_url('css/admin/mse-buttons.css', __FILE__), '', $this->version, 'all');
        if ($this->ecwd_page()) {
            //wp_enqueue_style($this->prefix . '-main', plugins_url('css/calendar.css', __FILE__), '', $this->version);
            wp_enqueue_style('ecwd-admin-css', plugins_url('css/admin/admin.css', __FILE__), array(), $this->version, 'all');
            wp_enqueue_style('ecwd-admin-datetimepicker-css', plugins_url('css/admin/jquery.datetimepicker.css', __FILE__), array(), $this->version, 'all');
            wp_enqueue_style('ecwd-admin-colorpicker-css', plugins_url('css/admin/evol.colorpicker.css', __FILE__), array(), $this->version, 'all');
            wp_enqueue_style($this->prefix . '-calendar-style', plugins_url('css/style.css', __FILE__), '', $this->version, 'all');
            wp_enqueue_style($this->prefix . '_font-awesome', plugins_url('/css/font-awesome/font-awesome.css', __FILE__), '', $this->version, 'all');
            wp_enqueue_style($this->prefix . '-featured_plugins', plugins_url('/css/admin/featured_plugins.css', __FILE__), '', $this->version, 'all');
           // wp_enqueue_style($this->prefix . '-featured_themes', plugins_url('/css/admin/featured_themes.css', __FILE__), '', $this->version, 'all');
            wp_enqueue_style($this->prefix . '-licensing', plugins_url('/css/admin/licensing.css', __FILE__), '', $this->version, 'all');
            wp_enqueue_style($this->prefix . '-popup-styles', plugins_url('/css/ecwd_popup.css', __FILE__), '', $this->version, 'all');
        }
    }

    /**
     * Register scripts for the admin area
     */
    public function enqueue_admin_scripts() {
        if ($this->ecwd_page()) {
          global $ecwd_options;

            wp_enqueue_script($this->prefix . '-gmap-public-admin', plugins_url('js/gmap/gmap3.js', __FILE__), array('jquery'), $this->version, true);
            wp_enqueue_script($this->prefix . '-admin-datetimepicker', plugins_url('js/admin/jquery.datetimepicker.js', __FILE__), array(
                'jquery',
                'jquery-ui-widget'
                    ), $this->version, true);
            wp_enqueue_script($this->prefix . '-admin-colorpicker', plugins_url('js/admin/evol.colorpicker.js', __FILE__), array('jquery'), $this->version, true);
            wp_enqueue_script($this->prefix . '-admin-ecwd-popup', plugins_url('js/ecwd_popup.js', __FILE__), array('jquery'), $this->version, true);
            wp_enqueue_script($this->prefix . '-public', plugins_url('js/scripts.js', __FILE__), array(
                'jquery',
                'masonry',
                $this->prefix . '-admin-ecwd-popup'
                    ), $this->version, true);
            wp_register_script($this->prefix . '-admin-scripts', plugins_url('js/admin/admin.js', __FILE__), array(
                'jquery',
                'jquery-ui-datepicker',
                'jquery-ui-tabs',
                'jquery-ui-selectable',
                $this->prefix . '-public',
                $this->prefix . '-admin-ecwd-popup'
                    ), $this->version, true);
            wp_enqueue_script($this->prefix . '-admin-datetimepicker-scripts', plugins_url('js/admin/datepicker.js', __FILE__), array('jquery'), $this->version, true);

            $params['ajaxurl'] = admin_url('admin-ajax.php');
            $params['version'] = get_bloginfo('version');
            if ($params['version'] >= 3.5) {
                wp_enqueue_media();
            } else {
                wp_enqueue_style('thickbox');
                wp_enqueue_script('thickbox');
            }

            $gmap_key = (isset($ecwd_options['gmap_key'])) ? $ecwd_options['gmap_key'] : "";
            $params['gmap_style'] = (isset($ecwd_options['gmap_style'])) ? $ecwd_options['gmap_style'] : "";

            wp_localize_script($this->prefix . '-admin-scripts', 'params', $params);
            wp_localize_script(ECWD_PLUGIN_PREFIX . '-public', 'ecwd', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'ajaxnonce' => wp_create_nonce(ECWD_PLUGIN_PREFIX . '_ajax_nonce'),
                'loadingText' => __('Loading...', 'ecwd'),
                'plugin_url' => ECWD_URL,
                'gmap_key' => $gmap_key,
                'gmap_style' => (isset($ecwd_options['gmap_style'])) ? $ecwd_options['gmap_style'] : ""
            ));

            wp_enqueue_script($this->prefix . '-admin-scripts');
        }
    }

    /**
     * Localize Script
     */
    public function admin_head() {

        $args = array(
            'post_type' => ECWD_PLUGIN_PREFIX . '_calendar',
            'post_status' => 'publish',
            'posts_per_page' => - 1,
            'ignore_sticky_posts' => 1
        );
        $calendar_posts = get_posts($args);
        $args = array(
            'post_type' => $this->prefix . '_event',
            'post_status' => 'publish',
            'posts_per_page' => - 1,
            'ignore_sticky_posts' => 1
        );
        $event_posts = get_posts($args);
        $plugin_url = plugins_url('/', __FILE__);
        ?>
        <!-- TinyMCE Shortcode Plugin -->
        <script type='text/javascript'>
            var ecwd_plugin = {
            'url': '<?php echo $plugin_url; ?>',
                    'ecwd_calendars': [
        <?php foreach ($calendar_posts as $calendar) { ?>
                        {
                        text: '<?php echo str_replace("'", "\'", $calendar->post_title); ?>',
                                value: '<?php echo $calendar->ID; ?>'
                        },
        <?php } ?>
                    ],
                    'ecwd_events': [
                    {text: 'None', value: 'none'},
        <?php foreach ($event_posts as $event) { ?>
                        {
                        text: '<?php echo str_replace("'", "\'", $event->post_title); ?>',
                                value: '<?php echo $event->ID; ?>'
                        },
        <?php } ?>
                    ],
                    'ecwd_views': [
                    {text: 'None', value: 'none'},
                    {text: 'Month', value: 'month'},
                    {text: 'List', value: 'list'},
                    {text: 'Week', value: 'week'},
                    {text: 'Day', value: 'day'},
                    ]
            };
        </script>
        <!-- TinyMCE Shortcode Plugin -->
        <?php
    }

    public function ecwd_shortcode_button() {

        // Don't bother doing this stuff if the current user lacks permissions
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        // Add only in Rich Editor mode
        if (get_user_option('rich_editing') == 'true') {
            // filter the tinyMCE buttons and add our own
            add_filter("mce_external_plugins", array($this, 'add_tinymce_plugin'));
            add_filter('mce_buttons', array($this, 'register_buttons'));
        }
    }

// registers the buttons for use
    function register_buttons($buttons) {
        // inserts a separator between existing buttons and our new one
        if (!$this->ecwd_page()) {
            array_push($buttons, "|", ECWD_PLUGIN_PREFIX);
        }

        return $buttons;
    }

// add the button to the tinyMCE bar
    function add_tinymce_plugin($plugin_array) {
        if (!$this->ecwd_page()) {
            $plugin_array[ECWD_PLUGIN_PREFIX] = plugins_url('js/admin/editor-buttons.js', __FILE__);
        }

        return $plugin_array;
    }

    //auto update plugin
    function ecwd_update($update, $item) {
        global $ecwd_options;
        if (!isset($ecwd_options['auto_update']) || $ecwd_options['auto_update'] == 1) {
            $plugins = array(// Plugins to  auto-update
                'event-calendar-wd'
            );
            if (in_array($item->slug, $plugins)) {
                return true;
            } // Auto-update specified plugins
            else {
                return false;
            } // Don't auto-update all other plugins
        }
    }

    public function define_admin_constants() {
        if (!defined('ECWD_DIR')) {
            define('ECWD_DIR', dirname(__FILE__));
        }
    }

    /*     * ******ECWD notices*********** */

    function ecwd_admin_notices() {
        // Notices filter and run the notices function.

        $admin_notices = apply_filters('ecwd_admin_notices', array());
        $this->notices->admin_notice($admin_notices);
    }

    // Ignore function that gets ran at admin init to ensure any messages that were dismissed get marked
    public function admin_notice_ignore() {
        $slug = ( isset($_GET['ecwd_admin_notice_ignore']) ) ? $_GET['ecwd_admin_notice_ignore'] : '';
        if (isset($_GET['ecwd_admin_notice_ignore']) && current_user_can('manage_options')) {
            $admin_notices_option = get_option('ecwd_admin_notice', array());
            $admin_notices_option[$_GET['ecwd_admin_notice_ignore']]['dismissed'] = 1;
            update_option('ecwd_admin_notice', $admin_notices_option);
            $query_str = remove_query_arg('ecwd_admin_notice_ignore');
            wp_redirect($query_str);
            exit;
        }
    }

    public function ecwd_config() {
        include_once ECWD_DIR . '/includes/ecwd_config.php';
        ECWD_Config::get_instance();
    }

    /**
     * Set Web Dorado Logo in admin pages
     */
    public function create_logo_to_head() {
        global $pagenow, $post;

        if ($this->ecwd_page()) {
            ?>
            <div style="width: 100%; text-align: right;clear:both;">
                <a href="https://web-dorado.com/files/fromEventCalendarWD.php" target="_blank"
                   style="text-decoration:none;box-shadow: none;">
                    <img src="<?php echo plugins_url('/assets/pro.png', __FILE__); ?>" border="0"
                         alt="https://web-dorado.com/files/fromEventCalendarWD.php" width="215">
                </a>
            </div>
            <?php
        }
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

    /**
     * Return the page
     */
    public function get_page() {
        return $this->ecwd_page();
    }

    /**
     * Return plugin name
     */
    public function get_plugin_title() {
        return __('Event Calendar WD', 'ecwd');
    }

    public function add_action_links($links) {
        return array_merge(
                array(
            'settings' => '<a href="' . admin_url('edit.php?post_type=ecwd_calendar&page=ecwd_general_settings') . '">' . __('Settings', 'ecwd') . '</a>',
            'events' => '<a href="' . admin_url('edit.php?post_type=ecwd_event') . '">' . __('Events', 'ecwd') . '</a>'
                ), $links
        );
    }

}
