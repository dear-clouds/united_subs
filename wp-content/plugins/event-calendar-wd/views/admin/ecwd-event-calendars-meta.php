<?php
/**
 * Display for Event Custom Post Types
 */
global $post;

$post_id = $post->ID;
$type = ECWD_PLUGIN_PREFIX.'_calendar';
$args = array(
    'post_type' => $type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'ignore_sticky_posts' => 1
);
$calendar_posts = get_posts($args);
$event_calendars = get_post_meta($post->ID, ECWD_PLUGIN_PREFIX.'_event_calendars', true);
if(!$event_calendars){
    $event_calendars = array();
}
if(isset($_GET['cal_id']) && $_GET['cal_id']){
    $event_calendars[] = $_GET['cal_id'];
}

?>
<div id="ecwd-display-options-wrap">
    <div class="ecwd-meta-control">
        <?php foreach ($calendar_posts as $calendar_post) { ?>
            <p>
                <label for = "ecwd_event_calendar_<?php echo $calendar_post->ID; ?>" id = "ecwd_event_calendar_label_<?php echo $calendar_post->ID ?>">
                    <input type = "checkbox" name = "ecwd_event_calendars[]" id = "ecwd_event_calendar_<?php echo $calendar_post->ID; ?>" value = "<?php echo $calendar_post->ID; ?>" <?php if(in_array($calendar_post->ID, $event_calendars)){echo 'checked="checked"';}
                    ?> />
                    <?php echo $calendar_post->post_title; ?>
                </label>
            </p>

        <?php }
        ?>

    </div>
</div>

