<?php
/**
 * Display for Event Custom Post Types
 */
global $post;

$post_id = $post->ID;
$type = ECWD_PLUGIN_PREFIX.'_organizer';
$args = array(
    'post_type' => $type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'ignore_sticky_posts' => 1
);
$organizer_posts = get_posts($args);
$event_organizers = get_post_meta($post->ID, ECWD_PLUGIN_PREFIX.'_event_organizers', true);
if(!$event_organizers || $event_organizers == '' || !is_array($event_organizers)){
    $event_organizers = array();
}
?>
<div id="<?php echo ECWD_PLUGIN_PREFIX;?>-display-options-wrap">
    <div class="ecwd-meta-control">
        <?php
        if(count($organizer_posts)>0){
        foreach ($organizer_posts as $organizer_post) { ?>
            <p>
                <label for = "<?php echo ECWD_PLUGIN_PREFIX;?>_event_organizers_<?php echo $organizer_post->ID; ?>" id = "<?php echo ECWD_PLUGIN_PREFIX;?>_event_calendar_label_<?php echo $organizer_post->ID ?>">
                    <input type = "checkbox" name = "<?php echo ECWD_PLUGIN_PREFIX;?>_event_organizers[]" id = "<?php echo ECWD_PLUGIN_PREFIX;?>_event_organizers_<?php echo $organizer_post->ID; ?>" value = "<?php echo $organizer_post->ID; ?>" <?php if(in_array($organizer_post->ID, $event_organizers)){echo 'checked="checked"';}
        ?> />
                           <?php echo $organizer_post->post_title; ?>
                </label>
            </p>

        <?php }

        } else {
           ?><a href="post-new.php?post_type=<?php echo ECWD_PLUGIN_PREFIX;?>_organizer"><?php _e('Add organizer', 'ecwd');?></a><?php
        }
        ?>

    </div>
</div>

