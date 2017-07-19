<?php

/**
 * Register all settings needed for the Settings API.
 *
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


if (isset($_GET[ECWD_PLUGIN_PREFIX . '_clear_cache']) && $_GET[ECWD_PLUGIN_PREFIX . '_clear_cache'] == 1) {
    $cpt = ECWD_Cpt::get_instance();
    add_action('admin_init', array($cpt, 'ecwd_clear_cache_option'));
}
if (isset($_GET['ecwd_start_tour']) && $_GET['ecwd_start_tour'] == 1) {
    delete_user_meta(get_current_user_id(), 'ecwd_calendar_tour');
    wp_redirect('edit.php?post_type=ecwd_calendar');
}

if (isset($_GET[ECWD_PLUGIN_PREFIX . '_clear_autogen']) && $_GET[ECWD_PLUGIN_PREFIX . '_clear_autogen'] == 1) {
    $posts = get_option('auto_generated_posts');
    if ($posts) {
        $calen_id = $posts[0];
        $venue_id = $posts[1];
        $org_ids = $posts[2];
        $ev_ids = $posts[3];
        foreach ($ev_ids as $id)
            wp_delete_post($id, true);
        foreach ($org_ids as $id)
            wp_delete_post($id, true);
        wp_delete_post($venue_id, true);
        wp_delete_post($calen_id, true);
        delete_option('auto_generated_posts');
        echo '<div class= "updated" ><p> ' . __('Auto generated data has been deleted.', 'ecwd') . '</p></div>';
    } else {
        echo '<div class= "updated" ><p> ' . __('Auto generated data has already deleted.', 'ecwd') . '</p></div>';
    }
}

/**
 *  Main function to register all of the plugin settings
 */
function ecwd_register_settings() {

    global $ecwd_settings;
    global $ecwd_tabs;

    $ecwd_tabs = array(
        'general' => 'General',
        'events'  => 'Events',
        'category_archive' => 'Category Page',
        'custom_css' => 'Custom CSS',
        'google_map' => 'Google Maps',
        'fb' => 'FB settings',
        'gcal' => 'Gcal settings',
        'ical' => 'Ical settings',
        'add_event' => 'Add Event'
    );
    $ecwd_settings = array(
        /* General Settings */

        'general' => array(
            'toure_option' => array(
                'id' => 'toure_option',
                'name' => __('Start tour', 'ecwd'),
                'desc' => __('Click to start tour.', 'ecwd'),
                'size' => 'small-text',
                'type' => 'link',
                'href' => $_SERVER['REQUEST_URI'] . '&ecwd_start_tour=1'
            ),
            'clear_auto_gen' => array(
                'id' => 'clear_auto_gen',
                'name' => __('Clear auto generated data', 'ecwd'),
                'desc' => __('Click to clear auto generated data', 'ecwd'),
                'size' => 'small-text',
                'type' => 'link',
                'href' => $_SERVER['REQUEST_URI'] . '&ecwd_clear_autogen=1'
            ),
            'time_zone' => array(
                'id' => 'time_zone',
                'name' => __('TimeZone', 'ecwd'),
                'desc' => __('Use Continent/City format, e.g. Europe/Berlin. If left empty, the server timezone will be used (if set in php settings), otherwise default Europe/Berlin', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'text',
                'default'   => ECWD::get_default_timezone()
            ),
            'date_format' => array(
                'id' => 'date_format',
                'name' => __('Date format', 'ecwd'),
                'desc' => __('Set the format for displaying event dates. Ex Y-m-d or Y/m/d', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'text'
            ),
            'time_format' => array(
                'id' => 'time_format',
                'name' => __('Time format', 'ecwd'),
                'desc' => __('Set the format for displaying event time. Ex H:i or H/i', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'text'
            ),
            'time_type' => array(
                'id' => 'time_type',
                'name' => __('Show AM/PM', 'ecwd'),
                'desc' => __('Select the time format type', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'time_type_select'
            ),
            'list_date_format' => array(
                'id' => 'list_date_format',
                'name' => __('List,Week,Day views day format', 'ecwd'),
                'desc' => __('Note: Changed date format will not be translatable', 'ecwd'),
                'default' => 'd.F.l',
                'size' => 'medium-text',
                'type' => 'text'
            ),
            'week_starts' => array(
                'id' => 'week_starts',
                'name' => __('Week start day', 'ecwd'),
                'desc' => __('Define the starting day for the week.', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'week_select'
            ),
            'enable_rewrite' => array(
                'id' => 'enable_rewrite',
                'name' => __('Enable rewrite', 'ecwd'),
                'default' => 'events',
                'desc' => __('Check yes to enable event(s) url rewrite rule.', 'ecwd'),
                'type' => 'radio',
                'default' => 1
            ),
            'cpt_order' => array(
                'id' => 'cpt_order',
                'name' => __('Order of Organizers and Venues by', 'ecwd'),
                'desc' => __('Select Order of Organizers and Venues.', 'ecwd'),
                'type' => 'order_select'
            ),
            'social_icons' => array(
                'id' => 'social_icons',
                'name' => __('Enable Social Icons', 'ecwd'),
                'desc' => __('Check to display social icons in event, organizer and venue pages.', 'ecwd'),
                'type' => 'checkbox'
            ),
            'cat_title_color' => array(
                'id' => 'cat_title_color',
                'name' => __('Apply category color to event title in event page', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 0
            ),
            'category_and_tags' => array(
                'id' => 'category_and_tags',
                'name' => __('Enable Category and Tags', 'ecwd'),
                'desc' => __('Check to display category and Tags.', 'ecwd'),
                'type' => 'checkbox'
            ),
            'move_first_image' => array(
                'id' => 'move_first_image',
                'name' => __('Grab the first post image', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 1
            ),
            'event_description_max_length' => array(
                'id' => 'event_description_max_length',
                'name' => __('Event description max length.', 'ecwd'),
                'desc' => __('Event description max length.', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'text'
            ),
        ),
        'events' => array(
            'events_archive_page_order' => array(
                'id' => 'events_archive_page_order',
                'name' => __('Order of events archive page', 'ecwd'),
                'desc' => __('Sort by event start', 'ecwd'),
                'type' => 'custom_radio',
                'default' => '0',
                'labels' => array('DESC', 'ASC')
            ),
            'change_events_archive_page_post_date' => array(
              'id' => 'change_events_archive_page_post_date',
              'name' => __('In Events Archive page change post date to event start date', 'ecwd'),
              'desc' => '',
              'type' => 'radio',
              'default' => 0
            ),
            'enable_sidebar_in_event' => array(
                'id' => 'enable_sidebar_in_event',
                'name' => __('Enable sidebar in event page', 'ecwd'),
                'desc' => __('', 'ecwd'),
                'type' => 'checkbox'
            ),
            'event_default_description' => array(
                'id' => 'event_default_description',
                'name' => __('Description for events.', 'ecwd'),
                'default' => __('No additional detail for this event.', 'ecwd'),
                'desc' => __('Define the default text for empty events description.', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'text'
            ),
            'events_date' => array(
                'id' => 'events_date',
                'name' => __('Show event date in the events list page', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 0
            ),
            'long_events' => array(
                'id' => 'long_events',
                'name' => __('Mark all days of multi-day event', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 0
            ),
            'related_events_count' => array(
                'id' => 'related_events_count',
                'name' => __('Related events count', 'ecwd'),
                'desc' => 'empty for all events',
                'type' => 'text',
                'default' => ''
            ),
            'events_in_popup' => array(
                'id' => 'events_in_popup',
                'name' => __('Display Events in popup', 'ecwd'),
                'desc' => __('Check to display events in popup.', 'ecwd'),
                'type' => 'checkbox'
            ),
            'events_slug' => array(
                'id' => 'events_slug',
                'name' => __('Events slug', 'ecwd'),
                'default' => 'events',
                'desc' => __('Define the slug for the events list page.', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'text'
            ),
            'event_slug' => array(
                'id' => 'event_slug',
                'name' => __('Single Event slug', 'ecwd'),
                'default' => 'event',
                'desc' => __('Define the slug for the single event page.', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'text'
            ),
            'event_comments' => array(
                'id' => 'event_comments',
                'name' => __('Enable comments for events', 'ecwd'),
                'desc' => __('Check to enable commenting.', 'ecwd'),
                'type' => 'checkbox'
            ),
            'event_loop' => array(
                'id' => 'event_loop',
                'name' => __('Include events in main loop', 'ecwd'),
                'desc' => __('Check to display events within website post list in main pages.', 'ecwd'),
                'type' => 'checkbox'
            ),
            'show_events_detail' => array(
                'id' => 'show_events_detail',
                'name' => __('Show events detail on hover', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 1
            ),
            'events_new_tab' => array(
                'id' => 'events_new_tab',
                'name' => __('Open events in new tab', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 0
            ),
            'related_events' => array(
                'id' => 'related_events',
                'name' => __('Show related events in the event page', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 1
            ),
        ),
        'category_archive' => array(
            'category_archive_slug' => array(
                'id' => 'category_archive_slug',
                'name' => __('Events category slug', 'ecwd'),
                'default' => 'event_category',
                'desc' => 'Note: Please do not use default slugs such as "category"',
                'size' => 'medium-text',
                'type' => 'text'
            ),
            'category_archive_description' => array(
                'id' => 'category_archive_description',
                'name' => __('Display Description', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 1
            ),
            'category_archive_image' => array(
                'id' => 'category_archive_image',
                'name' => __('Display Image', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 1
            ),
        ),
        'custom_css' => array(
            'custom_css' => array(
                'id' => 'custom_css',
                'name' => __('Custom css', 'ecwd'),
                'desc' => '',
                'type' => 'textarea',
                'cols' => '45',
                'rows' => '15'
            ),
          ),
          'google_map' => array(
            'add_project' => array(
                'id' => 'add_project',
                'name' => __('Get key', 'ecwd'),
                'desc' => '',
                'type' => 'link',
                'href' => 'https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend,places_backend&keyType=CLIENT_SIDE&reusekey=true',
                'target' => '_blank'
            ),
            'gmap_key' => array(
                'id' => 'gmap_key',
                'name' => __('API key', 'ecwd'),
                'desc' => '',
                'type' => 'text',                
            ),
            'gmap_style' => array(
              'id' => 'gmap_style',
              'name' => __('Map style', 'ecwd'),
              'desc' => '',
              'type' => 'textarea',
              'cols' => '45',
              'rows' => '15'
            )
        )
    );
    
    
    /*disabled options*/
    
    $ecwd_disabled_settings = array(
      /* General Settings */
        'general' => array(                                                            
            'show_repeat_rate' => array(
                'id' => 'show_repeat_rate',
                'name' => __('Show the repeat rate', 'ecwd'),
                'desc' => __('Check to show the repeat rate in event page .', 'ecwd'),
                'type' => 'checkbox'
            ),            
            'posterboard_fixed_height' => array(
                'id' => 'posterboard_fixed_height',
                'name' => __('Add fixed height for events in posterboard view', 'ecwd'),
                'desc' => __('', 'ecwd'),
                'type' => 'radio',
                'default' => 0
            ),                                    
            'period_for_list' => array(
                'id' => 'period_for_list',
                'name' => __('Period for List view', 'ecwd'),
                'desc' => __('Period for showing events', 'ecwd'),
                'size' => 'medium-text',
                'type' => 'agenda_select'
            ),                        
        ),             
        'google_map' => array(         
          'gmap_type' => array(
                'id' => 'gmap_type',
                'name' => __('Satellite Gmap Type', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 0
            ),
          'gmap_marker_click' => array(
                'id' => 'gmap_marker_click',
                'name' => __('Open Google map when Marker is clicked', 'ecwd'),
                'desc' => '',
                'type' => 'radio',
                'default' => 0
            ),
        )
    );
    
    if (1 == get_option('ecwd_old_events')) {
        $ecwd_settings['general']['show_repeat_rate'] = array(
            'id' => 'show_repeat_rate',
            'name' => __('Show the repeat rate', 'ecwd'),
            'desc' => __('Check to show the repeat rate in event page .', 'ecwd'),
            'type' => 'checkbox'
        );
    }

    /* If the options do not exist then create them for each section */
    if (false == get_option(ECWD_PLUGIN_PREFIX . '_settings')) {
        add_option(ECWD_PLUGIN_PREFIX . '_settings');
    }


    /* Add the  Settings sections */

    $calendar = get_posts(array(
        'post_type' => 'ecwd_calendar'
    ));
    $settings_init_on_activate = ((strpos($_SERVER['REQUEST_URI'], 'plugins.php')) && ((empty($calendar) && (get_option("activation_page_option") === false)) || isset($_POST['ecwd_settings_general']['week_starts'])));
    if ($settings_init_on_activate) {
        update_option("activation_page_option", "submit");
        include_once "activation_settings_page.php";
        ecwd_settings_init();
    }
    foreach ($ecwd_settings as $key => $settings) {

        add_settings_section(
                ECWD_PLUGIN_PREFIX . '_settings_' . $key, __($ecwd_tabs[$key], 'ecwd'), '__return_false', ECWD_PLUGIN_PREFIX . '_settings_' . $key
        );


        foreach ($settings as $option) {
            add_settings_field(
                    ECWD_PLUGIN_PREFIX . '_settings_' . $key . '[' . $option['id'] . ']', $option['name'], function_exists(ECWD_PLUGIN_PREFIX . '_' . $option['type'] . '_callback') ? ECWD_PLUGIN_PREFIX . '_' . $option['type'] . '_callback' : ECWD_PLUGIN_PREFIX . '_missing_callback', ECWD_PLUGIN_PREFIX . '_settings_' . $key, ECWD_PLUGIN_PREFIX . '_settings_' . $key, ecwd_get_settings_field_args($option, $key)
            );
        }
        if ($settings_init_on_activate) {
            activation_html_view();
        }
        /* Register all settings or we will get an error when trying to save */
        register_setting(ECWD_PLUGIN_PREFIX . '_settings_' . $key, ECWD_PLUGIN_PREFIX . '_settings_' . $key, ECWD_PLUGIN_PREFIX . '_settings_sanitize');
    }
    foreach ($ecwd_disabled_settings as $key => $settings) {        
        add_settings_section(
                ECWD_PLUGIN_PREFIX . '_settings_' . $key, __($ecwd_tabs[$key], 'ecwd'), '__return_false', ECWD_PLUGIN_PREFIX . '_settings_' . $key
        );


        foreach ($settings as $option) {
          $option['disabled'] = true;
            add_settings_field(
                    ECWD_PLUGIN_PREFIX . '_settings_' . $key . '[' . $option['id'] . ']', $option['name'], function_exists(ECWD_PLUGIN_PREFIX . '_' . $option['type'] . '_callback') ? ECWD_PLUGIN_PREFIX . '_' . $option['type'] . '_callback' : ECWD_PLUGIN_PREFIX . '_missing_callback', ECWD_PLUGIN_PREFIX . '_settings_' . $key, ECWD_PLUGIN_PREFIX . '_settings_' . $key, ecwd_get_settings_field_args($option, $key)
            );
        }        
        /* Register all settings or we will get an error when trying to save */
        //register_setting(ECWD_PLUGIN_PREFIX . '_settings_' . $key, ECWD_PLUGIN_PREFIX . '_settings_' . $key, ECWD_PLUGIN_PREFIX . '_settings_sanitize');
    }            
}
add_action('admin_init', ECWD_PLUGIN_PREFIX . '_register_settings');

/*
 * Return generic add_settings_field $args parameter array.
 *
 * @param   string  $option   Single settings option key.
 * @param   string  $section  Section of settings apge.
 * @return  array             $args parameter to use with add_settings_field call.
 */

function ecwd_get_settings_field_args($option, $section) {
    $settings_args = array(
        'id' => $option['id'],
        'desc' => $option['desc'],
        'name' => $option['name'],
        'section' => $section,
        'size' => isset($option['size']) ? $option['size'] : null,
        'class' => isset($option['class']) ? $option['class'] : null,
        'options' => isset($option['options']) ? $option['options'] : '',
        'std' => isset($option['std']) ? $option['std'] : '',
        'href' => isset($option['href']) ? $option['href'] : '',
        'target' => isset($option['target']) ? $option['target'] : '',
        'default' => isset($option['default']) ? $option['default'] : '',
        'cols' => isset($option['cols']) ? $option['cols'] : '',
        'rows' => isset($option['rows']) ? $option['rows'] : '',
        'labels' => isset($option['labels']) ? $option['labels'] : array(),
        'disabled' => isset($option['disabled']) ? $option['disabled'] : false,
    );

    // Link label to input using 'label_for' argument if text, textarea, password, select, or variations of.
    // Just add to existing settings args array if needed.
    if (in_array($option['type'], array('text', 'select', 'textarea', 'password', 'number'))) {
        $settings_args = array_merge($settings_args, array('label_for' => ECWD_PLUGIN_PREFIX . '_settings_' . $section . '[' . $option['id'] . ']'));
    }

    return $settings_args;
}

/*
 * Week select callback function
 */

function ecwd_week_select_callback($args) {
    global $ecwd_options;
    $html = "\n" . '<select  id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="0" ' . selected(0, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Sunday</option>
        <option value="1" ' . selected(1, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Monday</option>
    </select>' . "\n";

    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }
    echo $html;
}

/*
 * Time type select callback function
 */

function ecwd_time_type_select_callback($args) {
    global $ecwd_options;
    $html = "\n" . '<select  id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="" ' . selected("", isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Use 24-hour format</option>
        <option value="a" ' . selected("a", isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Use am/pm</option>
        <option value="A" ' . selected("A", isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Use AM/PM</option>
    </select>' . "\n";

    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }

    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }
    
    echo $html;
}

/*
 * Order select callback function
 */

function ecwd_order_select_callback($args) {
    global $ecwd_options;
    $html = "\n" . '<select  id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="post_name" ' . selected('post_name', isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Name</option>
        <option value="ID" ' . selected('ID', isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>ID</option>
        <option value="post_date" ' . selected('post_date', isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Date</option>
    </select>' . "\n";

    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

function ecwd_update_select_callback($args) {
    global $ecwd_options;
    $html = "\n" . '<select  id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="1" ' . selected(1, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>1 hour</option>
        <option value="2" ' . selected(2, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>2 hours</option>
        <option value="3" ' . selected(3, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>3 hours</option>
        <option value="5" ' . selected(5, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>5 hours</option>
        <option value="12" ' . selected(12, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>12 hours</option>
    </select>' . "\n";

    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

function ecwd_status_select_callback($args) {
    global $ecwd_options;
    $html = "\n" . '<select  id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="draft" ' . selected('draft', isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Draft</option>
        <option value="publish" ' . selected('publish', isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Publish</option>
        <option value="pending" ' . selected('pending', isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>Pending</option>
    </select>' . "\n";

    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

/*
 * Single checkbox callback function
 */

function ecwd_checkbox_callback($args) {
    global $ecwd_options;
    
    $checked = isset($ecwd_options[$args['id']]) ? checked(1, $ecwd_options[$args['id']], false) : ( isset($args['default']) ? checked(1, $args['default'], false) : '' );
    $id = 'ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']'; 
   $html = "\n" . '<div class="checkbox-div"><input type="checkbox" id="'.$id.'" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" value="1" ' . $checked . '/><label for="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']"></label></div>' . "\n";
    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

/*
 * Radio callback function
 */

function ecwd_radio_callback($args) {  
    global $ecwd_options;

    $checked_no = isset($ecwd_options[$args['id']]) ? checked(0, $ecwd_options[$args['id']], false) : ( isset($args['default']) ? checked(0, $args['default'], false) : '' );

    $checked_yes = isset($ecwd_options[$args['id']]) ? checked(1, $ecwd_options[$args['id']], false) : ( isset($args['default']) ? checked(1, $args['default'], false) : '' );


    $html = "\n" . ' <div class="checkbox-div"><input type="radio" id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_yes" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" value="1" ' . $checked_yes . '/><label for="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_yes"></label></div> <label for="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_yes">Yes</label>' . "\n";
    $html .= '<div class="checkbox-div"> <input type="radio" id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_no" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" value="0" ' . $checked_no . '/><label for="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_no"></label></div> <label for="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_no">No</label>' . "\n";
    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

/*
 * Custom Radio callback function
 */

function ecwd_custom_radio_callback($args) {
    global $ecwd_options;

    $html = "\n";
    if (isset($ecwd_options['events_archive_page_order'])) {
        $checked_item_id = intval($ecwd_options['events_archive_page_order']);
    } else {
        if (isset($args['default'])) {
            $checked_item_id = intval($args['default']);
        } else {
            $checked_item_id = 0;
        }
    }
    foreach ($args['labels'] as $key => $label) {
        if ($checked_item_id == $key) {
            $check_text = 'checked';
        } else {
            $check_text = '';
        }
        $html .= '<div class="checkbox-div"> <input type="radio" id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_' . $key . '" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . $key . '" ' . $check_text . ' /><label for="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_' . $key . '"></label></div> <label for="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']_' . $key . '">' . $label . '</label>' . "\n";
    }

    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }
    
    echo $html;
}

/*
 * Multiple checkboxs callback function
 */

function ecwd_cats_checkbox_callback($args) {
    global $ecwd_options;
    $categories = get_categories(array('taxonomy' => ECWD_PLUGIN_PREFIX . '_event_category'));
    $html = '';
    if (!empty($categories)) {
        foreach ($categories as $cat) {
            $checked = ( isset($ecwd_options[$args['id']]) && in_array($cat->term_id, $ecwd_options[$args['id']]) ) ? 'checked="checked"' : '';
            $html .= "\n" . '<div class="checkbox-div"><input type="checkbox" id="ecwd_settings_' . $args['section'] . '_' . $args['id'] . '[' . $cat->term_id . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . '][]" value="' . $cat->term_id . '" ' . $checked . '/><label for="ecwd_settings_' . $args['section'] . '_' . $args['id'] . '[' . $cat->term_id . ']"></label></div><label for="ecwd_settings_' . $args['section'] . '_' . $args['id'] . '[' . $cat->term_id . ']">' . $cat->name . '</label>' . "\n";
        }
    }
    //$html = "\n" . '<input type="checkbox" id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" value="1" ' . $checked . '/>' . "\n";
    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

/**
 * Textbox callback function
 * Valid built-in size CSS class values:
 * small-text, regular-text, large-text
 *
 */
function ecwd_text_callback($args) {
    global $ecwd_options;

    if (isset($ecwd_options[$args['id']])) {
        $value = $ecwd_options[$args['id']];
    } else {
        $value = isset($args['default']) ? $args['default'] : '';
    }

    $size = ( isset($args['size']) && !is_null($args['size']) ) ? $args['size'] : '';
    $html = "\n" . '<input type="text" class="' . $size . '" id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . esc_attr($value) . '"/>' . "\n";

    // Render and style description text underneath if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

function ecwd_textarea_callback($args) {
    global $ecwd_options;

    if (isset($ecwd_options[$args['id']])) {
        $value = $ecwd_options[$args['id']];
    } else {
        $value = isset($args['default']) ? $args['default'] : '';
    }

    $rows = ( isset($args['rows']) && !is_null($args['rows']) ) ? 'rows="' . $args['rows'] . '"' : '';
    $cols = ( isset($args['cols']) && !is_null($args['cols']) ) ? 'cols="' . $args['cols'] . '"' : '';
    $size = ( isset($args['size']) && !is_null($args['size']) ) ? $args['size'] : '';
    $html = "\n" . '<textarea type="text" ' . $rows . ' ' . $cols . ' class="' . $size . '" id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']">' . esc_attr($value) . '</textarea>' . "\n";

    // Render and style description text underneath if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

/**
 * Button callback function
 * Valid built-in size CSS class values:
 * small-text, regular-text, large-text
 *
 */
function ecwd_link_callback($args) {
    global $ecwd_options;

    $value = isset($args['name']) ? $args['name'] : '';
    $href = isset($args['href']) ? $args['href'] : '#';
    $target = isset($args['target']) ? $args['target'] : '';    
    $html = "\n" . '<a target="'.$target.'" class="button" href="' . $href . '" id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']"  >' . esc_attr($value) . '</a>' . "\n";
    // Render and style description text underneath if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }

    echo $html;
}

function ecwd_agenda_select_callback($args) {
    global $ecwd_options;
    $html = "\n" . '<select  id="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" name="ecwd_settings_' . $args['section'] . '[' . $args['id'] . ']" >
        <option value="1" ' . selected(1, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>1 month</option>
        <option value="2" ' . selected(2, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>2 months</option>
        <option value="3" ' . selected(3, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>3 months</option>
        <option value="4" ' . selected(4, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>4 months</option>
        <option value="5" ' . selected(5, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>5 months</option>
        <option value="6" ' . selected(6, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>6 months</option>
        <option value="12" ' . selected(12, isset($ecwd_options[$args['id']]) ? $ecwd_options[$args['id']] : '', false) . '>1 year</option>
    </select>' . "\n";

    // Render description text directly to the right in a label if it exists.
    if (!empty($args['desc'])) {
        $html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
    }
    
    if($args['disabled']){
      $html .= '<p class="ecwd_disabled_text">This option is disabled in free version.</p>';
      $html .= '<input type="hidden" value="1" class="ecwd_disabled_option" />';
    }
    
    echo $html;
}

/*
 * Function we can use to sanitize the input data and return it when saving options
 * 
 */

function ecwd_settings_sanitize($input) {
    //add_settings_error( 'ecwd-notices', '', '', '' );
    return $input;
}

/*
 *  Default callback function if correct one does not exist
 * 
 */

function ecwd_missing_callback($args) {
    printf(__('The callback function used for the <strong>%s</strong> setting is missing.', 'ecwd'), $args['id']);
}

/*
 * Function used to return an array of all of the plugin settings
 * 
 */

function ecwd_get_settings() {
    $ecwd_tabs = array(
        'general' => 'General',
        'events'  => 'Events',
        'category_archive' => 'Category Page',
        'custom_css' => 'Custom CSS',
        'google_map' => 'Google Maps',
        'fb' => 'FB settings',
        'gcal' => 'Gcal settings',
        'ical' => 'Ical settings',
        'add_event' => 'Add Event'
    );
    // Set default settings
    // If this is the first time running we need to set the defaults
    if (!get_option(ECWD_PLUGIN_PREFIX . '_upgrade_has_run')) {

        $general = get_option(ECWD_PLUGIN_PREFIX . '_settings_general');
        $general['save_settings'] = 1;

        update_option(ECWD_PLUGIN_PREFIX . '_settings_general', $general);
    }
    $general_settings = array();
    foreach ($ecwd_tabs as $key => $settings) {
        $general_settings += is_array(get_option(ECWD_PLUGIN_PREFIX . '_settings_' . $key)) ? get_option(ECWD_PLUGIN_PREFIX . '_settings_' . $key) : array();
    }


    return $general_settings;
}
