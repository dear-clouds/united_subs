<?php

//if (!defined())
function ecwd_print_calendar($calendar_ids, $display = 'mini', $args = array(), $widget = false, $ajax = false, $ecwd_views = array(), $preview = false) {
    global $ecwd_options;
    (isset($ecwd_options['events_in_popup']) && $ecwd_options['events_in_popup'] == "1") ? $popup = "yes" : $popup = "no";
    wp_enqueue_script(ECWD_PLUGIN_PREFIX . '-public');
    $gmap_key = (isset($ecwd_options['gmap_key'])) ? $ecwd_options['gmap_key'] : "";
    wp_localize_script(ECWD_PLUGIN_PREFIX . '-public', 'ecwd', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'ajaxnonce' => wp_create_nonce(ECWD_PLUGIN_PREFIX . '_ajax_nonce'),
        'loadingText' => __('Loading...', 'ecwd'),
        'plugin_url' => ECWD_URL,
        'gmap_key'=>$gmap_key,
        'gmap_style' => (isset($ecwd_options['gmap_style'])) ? $ecwd_options['gmap_style'] : ""
    ));

    $defaults = array(
        'title_text' => '',
        'sort' => 'asc',
        'grouped' => 0
    );

    $args = array_merge($defaults, $args);

    extract($args);
    if (!is_array($calendar_ids)) {
        $ids = explode('-', str_replace(' ', '', $calendar_ids));
    } else {
        $ids = $calendar_ids;
    }

    if($widget == true &&  isset($args['widget_theme']) && $args['widget_theme'] !== null){
        $ecwd_calendar_theme = $args['widget_theme'];
    }else {
        $ecwd_calendar_theme = get_post_meta($ids[0], ECWD_PLUGIN_PREFIX . '_calendar_theme', true);
    }

    $ecwd_default_color = (!empty($ecwd_calendar_theme)) ? $ecwd_calendar_theme : "calendar_grey";
    if ($ecwd_default_color && file_exists(ECWD_DIR . '/css/' . $ecwd_default_color . ".css")) {
        wp_enqueue_style('ecwd-calendar-main-'.$ecwd_default_color, plugins_url('../css/' . $ecwd_default_color . '.css', __FILE__), '', 1);
    }


    $calendar_ids_html = implode('-', $ids);
    $date = ( isset($args['date']) ? $args['date'] : '' );
    $prev_display = ( isset($args['prev_display']) ? $args['prev_display'] : '' );
    $page = ( isset($args['cpage']) ? $args['cpage'] : 1 );
    $page_items = ( isset($args['page_items']) ? $args['page_items'] : 5 );
    $displays = ( isset($args['displays']) ? $args['displays'] : null );
    $filters = ( isset($args['filters']) ? $args['filters'] : null );
    $event_search = ( isset($args['event_search']) ? $args['event_search'] : 'yes' );
    if (!isset($args['search_params'])) {
        $args['search_params'] = array();
    }

    //Create new display object, passing array of calendar id(s)
    $d = new ECWD_Display($ids, $title_text, $sort, $date, $page, $args['search_params'], $displays, $filters, $page_items, $event_search, $display);
    $markup = '';
    $start = current_time('timestamp');

    if (!$display && !$prev_display) {
        if ($widget == 1) {
            $display = 'mini';
        } else {
            $display = 'full';
        }
    } elseif (!$display && $prev_display) {
        $display = $prev_display;
    }
    if ($ajax == false) {
        if ($widget == 1) {
            $markup .= '<div class="ecwd_' . $calendar_ids_html . ' ecwd_theme_'.$ecwd_default_color.' calendar_widget_content calendar_main">';
        } else {
            $markup .= '<div class="ecwd_' . $calendar_ids_html . ' ecwd_theme_'.$ecwd_default_color.' calendar_full_content calendar_main">';
        }
        if ($widget !== 1) {
            if (defined('ECWD_FILTERS_EVENT_MAIN_FILE') && is_plugin_active(ECWD_FILTERS_EVENT_MAIN_FILE)) {
                if (defined('ECWD_FILTERS_EVENT_DIR')) {
                    require_once( ECWD_FILTERS_EVENT_DIR . 'ecwd_display_filters_class.php' );
                    $filters_obj = ECWD_Display_Filters::get_instance();
                    $filters_obj->set_filters($filters);
                    $markup .= $filters_obj->show_filters();
                }
            }
        }
    }
    if ($widget == 1) {
        $markup .= '<div class="ecwd-widget-mini ecwd_calendar">';
        $markup .= '<div class="ecwd-widget-' . $calendar_ids_html . '">';
    } else {

        $markup .= '<div class="ecwd-page-' . $display . ' ecwd_calendar">';
        $markup .= '<div class="ecwd-page-' . $calendar_ids_html . '">';
    }

    $markup .= $d->get_view($date, $display, $widget, $ecwd_views, $preview);
    $markup .= '</div>';
    $markup .= '<div class="ecwd-events-day-details"></div>';
    if ($displays) {
        $markup .= '<input type="hidden" class="ecwd_displays" value="' . $displays . '"/>';
    }
    if ($event_search) {
        $markup .= '<input type="hidden" class="event_search" value="' . $event_search . '"/>';
    }
    if ($filters) {
        $markup .= '<input type="hidden" class="ecwd_filters" value="' . $filters . '"/>';
    }
    if ($page_items) {
        $markup .= '<input type="hidden" class="ecwd_page_items" value="' . $page_items . '"/>';
    }
    if ($date) {
        $markup .= '<input type="hidden" class="ecwd_date" value="' . $date . '"/>';
    }
    $markup .= '<div class="ecwd_loader"></div>';
    if ($preview == false) {
        $markup .= '<div class="single_event_popup"></div>';
    }
    $markup .= '</div>';

    if (!$ajax) {

        $markup .= '</div>';
    }
    $markup .='<script id="ecwd_script_handler" type="text/javascript">if(typeof ecwd_js_init_call=="object"){ecwd_js_init_call = new ecwd_js_init();}</script>';
    return do_shortcode($markup);
}

/**
 * AJAX function change calendar months
 */
function ecwd_ajax() {

    // check to see if the submitted nonce matches with the
    // generated nonce
//	if ( ! check_ajax_referer( ECWD_PLUGIN_PREFIX . '_ajax_nonce', ECWD_PLUGIN_PREFIX . '_nonce' ) ) {
//		die( 'Request has failed.' );
//	}

    $ids = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_calendar_ids']);
    $args = array();
    $display = '';
    if (isset($_POST[ECWD_PLUGIN_PREFIX . '_link'])) {
        $link = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_link']);
        parse_str($link, $link_arr);
        $date = $link_arr['?date'];
        $page = isset($link_arr['amp;cpage']) ? $link_arr['amp;cpage'] : 1;

        $display = isset($link_arr['amp;t']) ? $link_arr['amp;t'] : 'full';
    } else {
        if (isset($_POST[ECWD_PLUGIN_PREFIX . '_prev_display'])) {
            $display = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_prev_display']);
        }
    }
    $type = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_type']);
    if (isset($_POST[ECWD_PLUGIN_PREFIX . '_date']) && $_POST[ECWD_PLUGIN_PREFIX . '_date'] == 1 && !empty($date)) {
        $args['date'] = $date;
    } else {
        $args['date'] = '';
    }
    if ($args['date'] == '' && isset($_POST[ECWD_PLUGIN_PREFIX . '_date_filter'])) {
        $args['date'] = $_POST[ECWD_PLUGIN_PREFIX . '_date_filter'];
    }
    if (isset($_POST[ECWD_PLUGIN_PREFIX . '_prev_display']) && $_POST[ECWD_PLUGIN_PREFIX . '_prev_display'] != '') {
        $args['prev_display'] = $_POST[ECWD_PLUGIN_PREFIX . '_prev_display'];
    } else {
        $args['prev_display'] = '';
    }
    $args['widget'] = 0;
    if ('widget' == $type) {
        $args['widget'] = 1;
    }

    if ($display == '') {
        if ($args['widget'] == 1) {
            $display = 'mini';
        } else {
            $display = 'full';
        }
    }
    if (isset($page)) {
        $args['cpage'] = $page;
    } else {
        $args['cpage'] = 1;
    }
    $args['search_params'] = array();
    if (( isset($_POST[ECWD_PLUGIN_PREFIX . '_query']) && $_POST[ECWD_PLUGIN_PREFIX . '_query'] != '' ) || isset($_POST[ECWD_PLUGIN_PREFIX . '_categories']) || ( isset($_POST[ECWD_PLUGIN_PREFIX . '_tags']) ) || isset($_POST[ECWD_PLUGIN_PREFIX . '_venues']) || isset($_POST[ECWD_PLUGIN_PREFIX . '_organizers']) || isset($_POST[ECWD_PLUGIN_PREFIX . '_weekdays'])) {

        $args['search_params']['query'] = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_query']) ? $_POST[ECWD_PLUGIN_PREFIX . '_query'] : 0 );
        $args['search_params']['categories'] = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_categories']) ? $_POST[ECWD_PLUGIN_PREFIX . '_categories'] : 0 );
        $args['search_params']['weekdays'] = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_weekdays']) ? $_POST[ECWD_PLUGIN_PREFIX . '_weekdays'] : 0 );
        $args['search_params']['tags'] = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_tags']) ? $_POST[ECWD_PLUGIN_PREFIX . '_tags'] : 0 );
        $args['search_params']['venues'] = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_venues']) ? $_POST[ECWD_PLUGIN_PREFIX . '_venues'] : 0 );
        $args['search_params']['organizers'] = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_organizers']) ? $_POST[ECWD_PLUGIN_PREFIX . '_organizers'] : 0 );
        $args['search'] = 1;
        //$display = 'list';
    }
    $displays = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_displays']) ? $_POST[ECWD_PLUGIN_PREFIX . '_displays'] : null );
    $filters = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_filters']) ? $_POST[ECWD_PLUGIN_PREFIX . '_filters'] : null );
    $page_items = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_page_items']) ? $_POST[ECWD_PLUGIN_PREFIX . '_page_items'] : null );
    $event_search = ( isset($_POST[ECWD_PLUGIN_PREFIX . '_event_search']) ? $_POST[ECWD_PLUGIN_PREFIX . '_event_search'] : null );
    $args['displays'] = $displays;
    $args['filters'] = $filters;
    $args['event_search'] = $event_search;
    $args['page_items'] = $page_items;
    echo ecwd_print_calendar($ids, $display, $args, $args['widget'], true);
    wp_die();
}

add_action('wp_ajax_nopriv_ecwd_ajax', ECWD_PLUGIN_PREFIX . '_ajax', 999999);
add_action('wp_ajax_ecwd_ajax', ECWD_PLUGIN_PREFIX . '_ajax', 999999);

/**
 * AJAX function for mini pagination
 */
function ecwd_ajax_list() {
    if (!check_ajax_referer(ECWD_PLUGIN_PREFIX . '_ajax_nonce', ECWD_PLUGIN_PREFIX . '_nonce')) {
        die('Request has failed.');
    }

    $grouped = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_grouped']);
    $start = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_start']);
    $ids = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_event_ids']);
    $title_text = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_title_text']);
    $sort = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_sort']);
    //$paging = esc_html($_POST[ECWD_PLUGIN_PREFIX.'_paging']);
    //$paging_interval = esc_html($_POST[ECWD_PLUGIN_PREFIX.'_paging_interval']);
    //$paging_direction = esc_html($_POST[ECWD_PLUGIN_PREFIX.'_paging_direction']);
    $start_offset = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_start_offset']);
    $paging_type = esc_html($_POST[ECWD_PLUGIN_PREFIX . '_paging_type']);

    if ($paging_direction == 'back') {
        if ($paging_type == 'month') {
            $this_month = mktime(0, 0, 0, date('m', $start) - 1, 1, date('Y', $start));
            $prev_month = mktime(0, 0, 0, date('m', $start) - 2, 1, date('Y', $start));
            $prev_interval_days = date('t', $prev_month);
            $month_days = date('t', $this_month);

            $int = $month_days + $prev_interval_days;
            $int = $int * 86400;

            $start = $start - ( $int );

            $changed_month_days = date('t', $start);
            $paging_interval = $changed_month_days * 86400;
        } else {
            $start = $start - ( $paging_interval * 2 );
        }
    } else {
        if ($paging_type == 'month') {
            $days_in_month = date('t', $start);
            $paging_interval = 86400 * $days_in_month;
        }
    }

    $d = new ECWD_Display(explode('-', $ids), $title_text, $sort);

    echo $d->get_list($grouped, $start, $paging, $paging_interval, $start_offset);

    die();
}

add_action('wp_ajax_nopriv_ecwd_ajax_list', ECWD_PLUGIN_PREFIX . '_ajax_list');
add_action('wp_ajax_ecwd_ajax_list', ECWD_PLUGIN_PREFIX . '_ajax_list');

function replaceFirstImages($content) {
    $content = preg_replace("/<img[^>]+\>/i", " ", $content, 1);

    return $content;
}

function ecwd_event_popup_ajax() {
    $ajax_date = isset($_POST['date']) ? $_POST['date'] : null;
    if (isset($_POST['id'])) {
        $post_id = $_POST['id'];
        include_once(ECWD_DIR . '/views/ecwd-event-popup.php');
        die;
    }
}

add_action('wp_ajax_nopriv_ecwd_event_popup_ajax', ECWD_PLUGIN_PREFIX . '_event_popup_ajax');
add_action('wp_ajax_ecwd_event_popup_ajax', ECWD_PLUGIN_PREFIX . '_event_popup_ajax');

function ecwd_event_content($content) {
    global $post;
    global $wp;
    global $ecwd_options;
    //echo $content;
    if (is_single()) {
        $feat_image = '';
        if ($post->post_type == ECWD_PLUGIN_PREFIX . '_organizer') {
            $organizer_content = '';
            include( ECWD_DIR . '/views/ecwd-organizer-content.php' );
            $organizer_content .= ob_get_clean();
            $content = $organizer_content;
        } elseif ($post->post_type == ECWD_PLUGIN_PREFIX . '_venue') {
            $venue_content = '';
            ob_start();
            include( ECWD_DIR . '/views/ecwd-venue-content.php' );
            $venue_content .= ob_get_clean();
            $content = $venue_content;
        }
    }

    return $content;
}

function getAndReplaceFirstImage($content) {
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    if (isset($matches [1] [0])) {
        $first_img = $matches [1] [0];
    }

    if (empty($first_img)) { //Defines a default image
        return false;
    } else {
        $content = replaceFirstImages($content);
    }

    return array(
        'image' => $first_img,
        'content' => $content
    );
}

add_filter('the_content', ECWD_PLUGIN_PREFIX . '_event_content');

//add_filter('template_include', ECWD_PLUGIN_PREFIX . '_set_template');

function ecwd_set_template($template) {
    if (is_singular(ECWD_PLUGIN_PREFIX . '_event') && ECWD_DIR . '/views/ecwd-event-content.php' != $template) {
        $template = ECWD_DIR . '/views/ecwd-event-content.php';
    }

    return $template;
}

function ecwd_event_post($post) {
    global $ecwd_options;
    if (is_single() && isset($post->comment_status) && $post->post_type == ECWD_PLUGIN_PREFIX . '_event') {
        $post->comment_status = 'closed';
        if (isset($ecwd_options['event_comments']) && $ecwd_options['event_comments'] == 1) {
            $post->comment_status = 'open';
        }
    }

    return $post;
}

add_action('the_post', ECWD_PLUGIN_PREFIX . '_event_post');

function ecwd_add_meta_tags() {
    global $post, $ecwd_options;
    if (is_single() && $post->post_type == ECWD_PLUGIN_PREFIX . '_event' && isset($ecwd_options['social_icons']) && $ecwd_options['social_icons'] != '') {
        echo '<meta property="og:title" content="' . $post->post_title . '"/>';
        $ecwd_event_date_from = get_post_meta($post->ID, ECWD_PLUGIN_PREFIX . '_event_date_from', true);
        $ecwd_event_date_to = get_post_meta($post->ID, ECWD_PLUGIN_PREFIX . '_event_date_to', true);
        $ecwd_all_day_event = get_post_meta($post->ID, ECWD_PLUGIN_PREFIX . '_all_day_event', true);
        $date_format = 'Y-m-d';
        $time_format = 'H:i';
        if (isset($ecwd_options['date_format']) && $ecwd_options['date_format'] != '') {
            $date_format = $ecwd_options['date_format'];
        }
        if (isset($ecwd_options['time_format']) && $ecwd_options['time_format'] != '') {
            $time_format = $ecwd_options['time_format'];
        }
        $time_format .= ( isset($ecwd_options['time_type']) ? ' ' . $ecwd_options['time_type'] : '' );
        if (isset($ecwd_options['time_type']) && $ecwd_options['time_type'] != '') {
            $time_format = str_replace('H', 'g', $time_format);
            $time_format = str_replace('h', 'g', $time_format);
        }
        $ecwd_event_location = get_post_meta($post->ID, ECWD_PLUGIN_PREFIX . '_event_location', true);
        $description = '';
        if ($ecwd_all_day_event == 1) {
            $description .= date($date_format, strtotime($ecwd_event_date_from));
            if ($ecwd_all_day_event == 1) {
                if ($ecwd_event_date_to && date($date_format, strtotime($ecwd_event_date_from)) !== date($date_format, strtotime($ecwd_event_date_to))) {
                    $description .= ' - ' . date($date_format, strtotime($ecwd_event_date_to));
                }
                $description .= '  ' . __('All day', 'ecwd') . ' ';
            }
        } else {
            $description .= date($date_format, strtotime($ecwd_event_date_from)) . ' ' . date($time_format, strtotime($ecwd_event_date_from));

            if ($ecwd_event_date_to) {
                $description .= ' - ' . date($date_format, strtotime($ecwd_event_date_to)) . ' ' . date($time_format, strtotime($ecwd_event_date_to));
            }
        }
        $description .= ' ' . $ecwd_event_location;
        echo '<meta property="og:description" content="' . $description . '"/>';
        $feat_image = '';
        if (has_post_thumbnail($post->ID)) {
            $feat_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'pull'));
        }
        echo '<meta property="og:image" content="' . $feat_image . '"/>';
    }
}

add_action('wp_head', 'ecwd_add_meta_tags', 2);

function ecwd_print_countdown($event_id, $widget = 1, $theme_id = null, $args = array()) {
    global $ecwd_options;

    $date_format = 'Y-m-d';
    $time_format = 'H:i';
    if (isset($ecwd_options['date_format']) && $ecwd_options['date_format'] != '') {
        $date_format = $ecwd_options['date_format'];
    }
    if (isset($ecwd_options['time_format']) && $ecwd_options['time_format'] != '') {
        $time_format = $ecwd_options['time_format'];
    }
    $time_format .= ( isset($ecwd_options['time_type']) ? ' ' . $ecwd_options['time_type'] : '' );
    if (isset($ecwd_options['time_type']) && $ecwd_options['time_type'] != '') {
        $time_format = str_replace('H', 'g', $time_format);
        $time_format = str_replace('h', 'g', $time_format);
    }
    $defaults = array(
        'title_text' => '',
        'sort' => 'asc',
        'grouped' => 0
    );

    $args = array_merge($defaults, $args);
    extract($args);
    $finish_text = isset($args['finish_text']) ? $args['finish_text'] : '';

    $date = ( isset($args['date']) ? $args['date'] : '' );
    $d = new ECWD_Display('', $title_text, $sort);
    $markup = '';

    $next_event = $d->get_countdown($event_id, $date, '', $widget);
    if ($next_event) {
        $gmt = gmdate("Y-m-d H:i:s");
        $currentgmt = date('Y-m-d H:i:s');
        $diff = ( strtotime($currentgmt) - strtotime($gmt) ) / 60 / 60;
        $start = date('Y/m/d H:i:s', strtotime($next_event['from'] . 'T' . $next_event['starttime']));
        $markup .= '<div class="ecwd_countdown_container">';
        $markup .= '<div class="ecwd_countdown_info">';
        $markup .= '<div class="ecwd-date">';
        $markup .= '<span class="metainfo">' . date($date_format . ' ' . $time_format, strtotime($start)) . ' (UTC ' . $diff . ')</span>';
        $markup .= '</div>';
        $markup .= '<div class="info">';
        if ($next_event['permalink'] !== '') {
            $markup .= '<span><a href="' . $next_event['permalink'] . '">' . $next_event['title'] . '</a></span>';
        } else {
            $markup .= '<span>' . $next_event['title'] . '</span>';
        }


        $markup .= '<span>' . $next_event['location'] . '</span>';
        $markup .= ' </div>';
        $markup .= '<div class="clear"></div>';
        $markup .= ' </div>';
        $markup .= '<div class="ecwd_countdown">';
        $markup .= '<input type="hidden" name="ecwd_end_time" value="' . $start . '"/>';
        $markup .= '<input type="hidden" name="ecwd_timezone" value="' . $diff . '"/>';
        $markup .= '<input type="hidden" name="ecwd_text_days" value="' . __('DAYS', 'ecwd') . '"/>';
        $markup .= '<input type="hidden" name="ecwd_text_hours" value="' . __('HOURS', 'ecwd') . '"/>';
        $markup .= '<input type="hidden" name="ecwd_text_minutes" value="' . __('MINUTES', 'ecwd') . '"/>';
        $markup .= '<input type="hidden" name="ecwd_text_seconds" value="' . __('SECONDS', 'ecwd') . '"/>';
        $markup .= '<input type="hidden" name="ecwd_finish_text" value="' . $finish_text . '"/>';
        if ($theme_id) {
            $theme = get_post_meta($theme_id, 'ecwd_countdown_theme', true);
            $markup .= '<textarea class="hidden" name="ecwd_theme">' . $theme . '</textarea>';
        }

        $markup .= '<div class="clear"></div>';
        $markup .= '</div>';
        $markup .= '</div>';
        $markup .= '<div class="clear"></div>';
    }

    return $markup;
}
