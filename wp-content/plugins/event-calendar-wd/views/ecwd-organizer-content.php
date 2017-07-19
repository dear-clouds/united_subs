<?php
/**
 * Display for Organiser Custom Post Types
 */
$post_id = $post->ID;

$date_format = 'Y-m-d';
$time_format = 'H:i';
$ecwd_social_icons = false;
$events = array();
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
if (isset($ecwd_options['social_icons']) && $ecwd_options['social_icons'] != '') {
    $ecwd_social_icons = $ecwd_options['social_icons'];
}
$organizer_url = get_permalink($post_id);


//$args = array('numberposts' => -1, 'post_type' => ECWD_PLUGIN_PREFIX.'_event', 'meta_key' => ECWD_PLUGIN_PREFIX.'_event_organizers', 'meta_value' => $post->ID, 'meta_compare' => 'LIKE');
//$ecwd_events = get_posts($args);
$today = date('Y-m-d');

$args = array(
    'numberposts' => - 1,
    'post_type' => ECWD_PLUGIN_PREFIX . '_event',
    'meta_query' => array(
        array(
            'key' => ECWD_PLUGIN_PREFIX . '_event_organizers',
            'value' => serialize(strval($post->ID)),
            'compare' => 'LIKE'
        ),
    ),
    'meta_key' => ECWD_PLUGIN_PREFIX . '_event_date_from',
    'orderby' => 'meta_value',
    'order' => 'ASC'
);
$ecwd_events = get_posts($args);


foreach ($ecwd_events as $ecwd_event) {
    $term_metas = '';
    $categories = get_the_terms($ecwd_event->ID, ECWD_PLUGIN_PREFIX . '_event_category');
    if (is_array($categories)) {
        foreach ($categories as $category) {
            $term_metas = get_option("ecwd_event_category_$category->term_id");
            $term_metas['id'] = $category->term_id;
            $term_metas['name'] = $category->name;
            $term_metas['slug'] = $category->slug;
        }
    }
    $ecwd_event_metas = get_post_meta($ecwd_event->ID, '', true);
    $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'] = array(0 => '');
    if (!isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_location'])) {
        $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_location'] = array(0 => '');
    }
    if (!isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_lat_long'])) {
        $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_lat_long'] = array(0 => '');
    }
    if (!isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'])) {
        $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'] = array(0 => '');
    }
    if (!isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'])) {
        $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'] = array(0 => '');
    }

    $permalink = get_permalink($ecwd_event->ID);
    $events[$ecwd_event->ID] = new ECWD_Event($ecwd_event->ID, 0, $ecwd_event->post_title, $ecwd_event->post_content, $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_location'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_lat_long'][0], $permalink, $ecwd_event, $term_metas, $ecwd_event_metas);
}

$d = new ECWD_Display(0, '', '', $today);
$max_date = date('Y-m-d', strtotime(( date("Y-m-t", ( strtotime(date('Y-m-d')))) . " +" . ( ( 12 ) ) . " month")));
$events = $d->get_event_days($events, 1, date('Y-m-d'), $max_date);
$events = $d->events_unique($events);


echo wpautop($content);
?>

<div class="ecwd-organizer">
    <?php if ($ecwd_social_icons) { ?>
        <div class="ecwd-social">
            <span class="share-links">
                <a href="http://twitter.com/home?status=<?php echo get_permalink($post_id) ?>" class="ecwd-twitter"
                   target="_blank" data-original-title="Tweet It">
                    <span class="visuallyhidden">Twitter</span></a>

                <a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink($post_id) ?>" class="ecwd-facebook"
                   target="_blank" data-original-title="Share on Facebook">
                    <span class="visuallyhidden">Facebook</span></a>

                <a href="http://plus.google.com/share?url=<?php echo get_permalink($post_id) ?>" class="ecwd-google-plus"
                   target="_blank" data-original-title="Share on Google+">
                    <span class="visuallyhidden">Google+</span></a>

            </span>
        </div>
    <?php
    }
    do_action('ecwd_show_related_events', $events, true);
    ?>    
</div>
<script id="ecwd_script_handler" type="text/javascript">
    if (typeof ecwd_js_init_call == "object") {
        ecwd_js_init_call = new ecwd_js_init();
    }
</script>

