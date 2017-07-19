<?php
/**
 * Display for Event Custom Post Types
 */
if (!defined('ABSPATH')) {
    die('-1');
}

$post = get_post($post_id);
global $wp;
global $ecwd_options;
global $wp_query;

$meta = get_post_meta($post_id);

$date_format = 'Y-m-d';
$time_format = 'H:i';
$ecwd_social_icons = false;
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
// Load up all post meta data


$ecwd_event = $post;
$ecwd_event_metas = get_post_meta($ecwd_event->ID, '', true);
$ecwd_event_date_from = $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'][0];
$ecwd_event_date_to = $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'][0];
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

$permalink = get_the_permalink($ecwd_event->ID);
$this_event = $events[$ecwd_event->ID] = new ECWD_Event($ecwd_event->ID, '', $ecwd_event->post_title, $ecwd_event->post_content, $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_location'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_lat_long'][0], $permalink, $ecwd_event, '', $ecwd_event_metas);
$ecwd_event_date_from = $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'][0];
$ecwd_event_date_to = $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'][0];
$d = new ECWD_Display('');
if ($ajax_date != null) {
    $start_time = date('H:i', strtotime($ecwd_event_date_from));
    $end_time = date('H:i', strtotime($ecwd_event_date_to));

    $eventdayslong = $d->dateDiff($ecwd_event_date_from, $ecwd_event_date_to);
    $ecwd_event_date_from = $ajax_date;
    $ecwd_event_date_to = date('Y-m-d', strtotime(( date("Y-m-d", ( strtotime($ecwd_event_date_from))) . " +" . ( $eventdayslong ) . " days")));



    $ecwd_event_date_from = $ecwd_event_date_from . ' ' . $start_time;
    $ecwd_event_date_to = $ecwd_event_date_to . ' ' . $end_time;
}


$ecwd_event_location = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_location'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_location'][0] : '';
$ecwd_event_latlong = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_lat_long'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_lat_long'][0] : '';
$ecwd_event_zoom = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_map_zoom'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_map_zoom'][0] : '';
$ecwd_event_show_map = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_show_map'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_show_map'][0] : 0;
if ($ecwd_event_show_map == '') {
    $ecwd_event_show_map = 1;
}
if (!$ecwd_event_zoom) {
    $ecwd_event_zoom = 17;
}
$ecwd_event_organizers = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0] : '';
if ($ecwd_event_organizers != '') {
    $ecwd_event_organizers = get_post_meta($ecwd_event->ID, ECWD_PLUGIN_PREFIX . '_event_organizers', true);
}
$ecwd_event_url = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'][0] : '';
if ($ecwd_event_url == "") {
    $ecwd_event_url = get_post_meta($ecwd_event->ID, ECWD_PLUGIN_PREFIX . '_event_url', true);
}
$ecwd_event_video = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_video'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_video'][0] : '';
$ecwd_all_day_event = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_all_day_event'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_all_day_event'][0] : 0;
$venue = '';
$venue_permalink = '';
$venue_post_id = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0] : 0;
if ($venue_post_id) {
    $venue_post = get_post($venue_post_id);
    if ($venue_post) {
        $venue = $venue_post->post_title;
        $venue_permalink = get_permalink($venue_post->ID);
    }
}

$organizers = array();

if (is_array($ecwd_event_organizers) || is_object($ecwd_event_organizers)) {
    foreach ($ecwd_event_organizers as $ecwd_event_organizer) {
        $organizers[] = get_post($ecwd_event_organizer, ARRAY_A);
    }
}
if (function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID)) {
    $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
    $featured_image = $thumbnail[0];
} else {
    $featured_image = '';
}
$category_and_tags = false;

if (isset($ecwd_options['category_and_tags']) && $ecwd_options['category_and_tags'] != '') {
    $category_and_tags = $ecwd_options['category_and_tags'];
}
$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
$event_tags = wp_get_post_terms($post->ID, 'ecwd_event_tag', $args);
$event_categories = wp_get_post_terms($post->ID, 'ecwd_event_category', $args);
?>
<div id="ecwd-events-content" class="ecwd-events-single">
    <div id="post-<?php echo $post_id; ?>" >

        <div class="ecwd-event" itemscope itemtype="http://schema.org/Event">
            <header class="entry-header">
                <h1 class="ecwd-events-single-event-title summary entry-title"><?php echo $post->post_title; ?></h1>
            </header>
            <div class="event-detalis">

                <?php ?>
                <?php if ($featured_image && $featured_image !== '') { ?>
                    <div class="event-featured-image">
                        <img src="<?php echo $featured_image; ?>"/>
                    </div>
                <?php } ?>
                <div class="ecwd-event-details">
                    <div class="event-detalis-date">
                        <label class="ecwd-event-date-info" title="<?php _e('Date', 'ecwd'); ?>"></label>
                        <span class="ecwd-event-date" itemprop="startDate"
                              content="<?php echo date('Y-m-d', strtotime($ecwd_event_date_from)) . 'T' . date('H:i', strtotime($ecwd_event_date_from)) ?>">
                                  <?php
                                  if ($ecwd_all_day_event == 1) {
                                      echo date($date_format, strtotime($ecwd_event_date_from));
                                      if ($ecwd_all_day_event == 1) {
                                          if ($ecwd_event_date_to && date($date_format, strtotime($ecwd_event_date_from)) !== date($date_format, strtotime($ecwd_event_date_to))) {
                                              echo ' - ' . date($date_format, strtotime($ecwd_event_date_to));
                                          }
                                          echo ' ' . __('All day', 'ecwd');
                                      }
                                  } else {
                                      echo date($date_format, strtotime($ecwd_event_date_from)) . ' ' . date($time_format, strtotime($ecwd_event_date_from));

                                      if ($ecwd_event_date_to) {
                                          echo ' - ' . date($date_format, strtotime($ecwd_event_date_to)) . ' ' . date($time_format, strtotime($ecwd_event_date_to));
                                      }
                                  }
                                  ?>
                        </span>
                    </div>
                    <?php if (isset($ecwd_options['show_repeat_rate'])) { ?>
                        <div class="ecwd_repeat_rate_text">
                            <span><?php echo $d->get_repeat_rate($post_id, '', $date_format); ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($ecwd_event_url) { ?>
                        <div class="ecwd-url">

                            <a href="<?php echo $ecwd_event_url; ?>" target="_blank">
                                <label class="ecwd-event-url-info"
                                       title="<?php _e('Url', 'ecwd'); ?>"></label>    <?php echo $ecwd_event_url; ?>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if (count($organizers) > 0) { ?>
                        <div class="event-detalis-org">
                            <label class="ecwd-event-org-info"
                                   title="<?php _e('Organizers', 'ecwd'); ?>"></label>
                                   <?php foreach ($organizers as $organizer) { ?>
                                <span itemprop="organizer">
                                    <a href="<?php echo get_permalink($organizer['ID']) ?>"><?php echo $organizer['post_title'] ?></a>
                                </span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="event-venue" itemprop="location" itemscope
                         itemtype="http://schema.org/Place">
                             <?php if ($venue_post_id) { ?>
                            <label class="ecwd-venue-info"
                                   title="<?php _e('Venue', 'ecwd'); ?>"></label>
                            <span itemprop="name"><a href="<?php echo $venue_permalink ?>"><?php echo $venue; ?></a></span>
                            <div class="address" itemprop="address" itemscope
                                 itemtype="http://schema.org/PostalAddress">
                                     <?php echo $ecwd_event_location; ?>
                            </div>

                        <?php } elseif ($ecwd_event_location) { ?>
                            <span class="ecwd_hidden" itemprop="name"><?php echo $ecwd_event_location; ?></span>
                            <label class="ecwd-venue-info"
                                   title="<?php _e('Location', 'ecwd'); ?>"></label>
                            <span class="address" itemprop="address" itemscope
                                  itemtype="http://schema.org/PostalAddress">
                                      <?php echo $ecwd_event_location; ?>
                            </span>
                        <?php } ?>
                    </div>
                    <?php do_action('ecwd_view_ext', $post_id); ?>
                </div>
            </div>
            <?php if ($ecwd_social_icons) {
                ?>

                <div class="ecwd-social">
                    <span class="share-links">
                        <a href="http://twitter.com/home?status=<?php echo get_permalink($post_id) ?>"
                           class="ecwd-twitter"
                           target="_blank" data-original-title="Tweet It">
                            <span class="visuallyhidden">Twitter</span></a>
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink($post_id) ?>"
                           class="ecwd-facebook"
                           target="_blank" data-original-title="Share on Facebook">
                            <span class="visuallyhidden">Facebook</span></a>
                        <a href="http://plus.google.com/share?url=<?php echo get_permalink($post_id) ?>"
                           class="ecwd-google-plus"
                           target="_blank" data-original-title="Share on Google+">
                            <span class="visuallyhidden">Google+</span></a>
                    </span>
                </div>
            <?php } ?>
            <?php
            if ($ecwd_event_show_map == 1 && $ecwd_event_latlong) {
                $map_events = array();
                $map_events[0]['latlong'] = explode(',', $ecwd_event_latlong);
                if ($ecwd_event_location != '') {
                    $map_events[0]['location'] = $ecwd_event_location;
                }
                $map_events[0]['zoom'] = $ecwd_event_zoom;
                $map_events[0]['infow'] = '<div class="ecwd_map_event">';
                $map_events[0]['infow'] .= '<span class="location">' . $ecwd_event_location . '</span>';
                $map_events[0]['infow'] .= '</div>';
                $map_events[0]['infow'] .= '<div class="event-detalis-date">
			 <label class="ecwd-event-date-info" title="' . __('Date', 'ecwd') . '"></label>
			 <span class="ecwd-event-date" itemprop="startDate" content="' . date('Y-m-d', strtotime($ecwd_event_date_from)) . 'T' . date('H:i', strtotime($ecwd_event_date_from)) . '">';
                if ($ecwd_all_day_event == 1) {
                    $map_events[0]['infow'] .= date($date_format, strtotime($ecwd_event_date_from));
                    if ($ecwd_event_date_to) {
                        $map_events[0]['infow'] .= ' - ' . date($date_format, strtotime($ecwd_event_date_to)) . '  ' . __('All day', 'ecwd');
                    }
                } else {
                    $map_events[0]['infow'] .= date($date_format, strtotime($ecwd_event_date_from)) . ' ' . date($time_format, strtotime($ecwd_event_date_from));

                    if ($ecwd_event_date_to) {
                        $map_events[0]['infow'] .= date($date_format, strtotime($ecwd_event_date_to)) . ' ' . date($time_format, strtotime($ecwd_event_date_to));
                    }
                }
                $map_events[0]['infow'] .= ' </span>
		 </div>';

                $markers = json_encode($map_events);
                ?>
                <div class="ecwd-show-map">
                    <div class="ecwd_map_div">
                    </div>
                    <textarea class="hidden ecwd_markers"
                              style="display: none;"><?php echo $markers; ?></textarea>
                </div>
            <?php } ?>
            <div class="clear"></div>


            <div class="ecwd-event-video">
                <?php
                if (strpos($ecwd_event_video, 'youtube') > 0) {
                    parse_str(parse_url($ecwd_event_video, PHP_URL_QUERY), $video_array_of_vars);
                    if (isset($video_array_of_vars['v']) && $video_array_of_vars['v']) {
                        ?>
                        <object data="http://www.youtube.com/v/<?php echo $video_array_of_vars['v'] ?>"
                                type="application/x-shockwave-flash" width="400" height="300">
                            <param name="src"
                                   value="http://www.youtube.com/v/<?php echo $video_array_of_vars['v'] ?>"/>
                        </object>
                        <?php
                    }
                } elseif (strpos($ecwd_event_video, 'vimeo') > 0) {
                    $videoID = explode('/', $ecwd_event_video);
                    $videoID = $videoID[count($videoID) - 1];
                    if ($videoID) {
                        ?>
                        <iframe
                            src="http://player.vimeo.com/video/<?php echo $videoID; ?>?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff"
                            width="" height="" frameborder="0" webkitAllowFullScreen mozallowfullscreen
                            allowFullScreen></iframe>
                            <?php
                        }
                    }
                    ?>
            </div>
            <!-- Content -->

            <div class="ecwd_events_single_event_content">
                <?php
                $post_content = apply_filters('the_content', $post->post_content);
                echo do_shortcode($post_content);
                ?>
            </div>
            <!-- End Content -->
            <!-- Categories and tags -->
            <?php if ($category_and_tags == 1) { ?>
                <div class="event_cageory_and_tags">

                    <?php if (!empty($event_categories)) { ?>
                        <ul class="event_categories">
                            <?php
                            foreach ($event_categories as $category) {

                                $metas = get_option("ecwd_event_category_$category->term_id");
                                ?>
                                <li class="event_category event-details-title">
                                    <?php if ($metas['color']) { ?>
                                        <span class="event-metalabel"
                                              style="background:<?php echo $metas['color']; ?>"></span>
                                        <span class="event_catgeory_name"> <a
                                                href="<?php echo get_category_link($category); ?>"
                                                style="color:<?php echo $metas['color']; ?>"><?php echo $category->name; ?> </a></span>
                                        <?php } else { ?>
                                        <span class="event_catgeory_name"> <a
                                                href="<?php echo get_category_link($category); ?>"><?php echo $category->name; ?> </a></span>
                                        <?php } ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>


                    <?php
                    if (!empty($event_tags)) {
                        ?>

                        <ul class="event_tags">

                            <?php
                            foreach ($event_tags as $tag) {
                                ?>
                                <li class="event_tag">
                                    <span class="event_tag_name">
                                        <a href="<?php echo get_tag_link($tag); ?>">#<?php echo $tag->name; ?> </a>
                                    </span>
                                </li>
                                <?php
                            }
                            ?></ul>
                        <?php
                    }
                    ?>
                </div>
            <?php } ?>
            <?php do_action('ecwd_tickets_events_single_meta', '', $ecwd_event_date_to, $post_id); ?>
        </div>
    </div>
</div>