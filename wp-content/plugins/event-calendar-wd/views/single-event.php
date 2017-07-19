<?php
/**
 * Display for Event Custom Post Types
 */
if (!defined('ABSPATH')) {
    die('-1');
}

global $post;
global $wp;
global $ecwd_options;
global $wp_query;

$post_id = $post->ID;
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
if (!isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'])) {
    $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'] = array(0 => '');
}
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
$d = new ECWD_Display('');
if (isset($_GET['eventDate']) || isset($wp_query->query_vars['eventDate'])) {
    $fromDate = isset($_GET['eventDate']) ? $_GET['eventDate'] : $wp_query->query_vars['eventDate'];

    $eventdayslong = $d->dateDiff($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'][0]);
    $toDate = date('Y-m-d', strtotime(( date("Y-m-d", ( strtotime($fromDate))) . " +" . ( $eventdayslong + 2 ) . " days")));
    $this_event_dates = $d->get_event_days(array($ecwd_event->ID => $this_event), 1, $fromDate, $toDate);
    if (isset($this_event_dates[0]['from']) && strtotime($fromDate) == strtotime($this_event_dates[0]['from'])) {
        $ecwd_event_date_from = $this_event_dates[0]['from'] . ' ' . $this_event_dates[0]['starttime'];
        $ecwd_event_date_to = $this_event_dates[0]['to'] . ' ' . $this_event_dates[0]['endtime'];
    }
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



$ecwd_event_url = isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'][0]) ? $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'][0] : '';
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
$ecwd_event_organizers = maybe_unserialize($ecwd_event_organizers);
if (is_array($ecwd_event_organizers) || is_object($ecwd_event_organizers)) {
    foreach ($ecwd_event_organizers as $ecwd_event_organizer) {
        $organizers[] = get_post($ecwd_event_organizer, ARRAY_A);
    }
}
$featured_image = '';
if (has_post_thumbnail()) {
    $featured_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'full', false));
}

$category_and_tags = false;

if (isset($ecwd_options['category_and_tags']) && $ecwd_options['category_and_tags'] != '') {
    $category_and_tags = $ecwd_options['category_and_tags'];
}
$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
$event_tags = wp_get_post_terms($post->ID, 'ecwd_event_tag', $args);
$event_categories = wp_get_post_terms($post->ID, 'ecwd_event_category', $args);

$event_title_style = '';
if (isset($ecwd_options['cat_title_color']) && $ecwd_options['cat_title_color'] == 1) {
    if (!empty($event_categories)) {
        if (isset($event_categories[0])) {
            $cat = $event_categories[0];
            $metas = get_option("ecwd_event_category_$cat->term_id");
            if (isset($metas['color'])) {
                $event_title_style = 'style = "color: ' . $metas['color'] . '"';
            }
        }
    }
}

get_header();
?>
<div id="ecwd-events-content" class="ecwd-events-single hentry site-content">


    <?php
    while (have_posts()) :
        the_post();
        ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <article>
                <div class="ecwd-event" itemscope itemtype="http://schema.org/Event">
                    <header class="entry-header">
                        <?php the_title('<h1 itemprop="name" class="ecwd-events-single-event-title summary entry-title" ' . $event_title_style . '>', '</h1>'); ?>
                    </header>
                    <?php
                    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
                        if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) == parse_url(site_url(), PHP_URL_HOST)) {
                            ?>
                            <a id="ecwd_back_link" href="#"><?php _e('Back','ecwd'); ?></a>
                            <?php
                        }
                    }
                    ?>
                    <div class="event-detalis">

                        <?php ?>
                        <?php if ($featured_image && $featured_image !== '') { ?>
                            <div class="event-featured-image">
                                <img src="<?php echo $featured_image; ?>"/>
                            </div>
                        <?php } ?>
                        <div class="ecwd-event-details">
                            <div class="event-detalis-date">
                                <label class="ecwd-event-date-info"
                                       title="<?php _e('Date', 'ecwd'); ?>"></label>
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
                            <?php
                            if (isset($ecwd_options['show_repeat_rate'])) {
                                $repeat_rate_text = $d->get_repeat_rate($post_id, '', $date_format);
                                if ($repeat_rate_text != ''):
                                    ?>
                                    <div class="ecwd_repeat_rate_text">
                                        <span><?php echo $d->get_repeat_rate($post_id, '', $date_format); ?></span>
                                    </div>
                                    <?php
                                endif;
                            }
                            ?>
                            <?php if ($ecwd_event_url) { ?>
                                <div class="ecwd-url">

                                    <a href="<?php echo $ecwd_event_url; ?>" target="_blank"><label
                                            class="ecwd-event-url-info"
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
                                    <span itemprop="name"><a
                                            href="<?php echo $venue_permalink ?>"><?php echo $venue; ?></a></span>
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
                            <?php do_action('ecwd_view_ext'); ?>
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
                                $map_events[0]['infow'] .= ' ' . date($date_format, strtotime($ecwd_event_date_to)) . ' ' . date($time_format, strtotime($ecwd_event_date_to));
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
                    <div class="entry-content">
                        <?php the_content(); ?>
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
                    <!--	END Categories and tags -->



                    <?php
                    if (!isset($ecwd_options['related_events']) || $ecwd_options['related_events'] == 1) {
                        $post_cats = wp_get_post_terms($post_id, ECWD_PLUGIN_PREFIX . '_event_category');
                        $cat_ids = wp_list_pluck($post_cats, 'term_id');
                        $post_tags = wp_get_post_terms($post_id, ECWD_PLUGIN_PREFIX . '_event_tag');
                        $tag_ids = wp_list_pluck($post_tags, 'term_id');
                        $events = array();
                        $today = date('Y-m-d');

                        $args = array(
                            'numberposts' => - 1,
                            'post_type' => ECWD_PLUGIN_PREFIX . '_event',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => ECWD_PLUGIN_PREFIX . '_event_category',
                                    'terms' => $cat_ids,
                                    'field' => 'term_id',
                                )
                            ),
                            'orderby' => 'meta_value',
                            'order' => 'ASC'
                        );
                        $ecwd_events_by_cats = get_posts($args);
                        $args = array(
                            'numberposts' => - 1,
                            'post_type' => ECWD_PLUGIN_PREFIX . '_event',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => ECWD_PLUGIN_PREFIX . '_event_tag',
                                    'terms' => $tag_ids,
                                    'field' => 'term_id',
                                ),
                            ),
                            'orderby' => 'meta_value',
                            'order' => 'ASC'
                        );
                        $ecwd_events_by_tags = get_posts($args);
                        $ecwd_events = array_merge($ecwd_events_by_tags, $ecwd_events_by_cats);
                        $ecwd_events = array_map("unserialize", array_unique(array_map("serialize", $ecwd_events)));
                        wp_reset_postdata();
                        wp_reset_query();

                        foreach ($ecwd_events as $ecwd_event) {
                            if ($ecwd_event->ID != $post_id) {
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
                        }
                        $d = new ECWD_Display(0, '', '', $today);
                        $start_date = date('Y-m-d');
                        $end_date = date('Y-m-d', strtotime("+1 year", strtotime($start_date)));
                        $events = $d->get_event_days($events, 1, $start_date, $end_date);                        
                        ?>

                        <?php
                        $events = $d->events_unique($events);                        
                        do_action('ecwd_show_related_events', $events,true);
                    }
                    ?>               </div>
                <!--	#Related  Events-->
            </article>
        </div> <!-- #post-x -->
        <?php if (comments_open() && $post->comment_status == 'open') { ?>
            <div class="ecwd-comments">

                <?php echo comments_template(); ?>
            </div>
        <?php } ?>
    <?php endwhile; ?>

</div>
<script id="ecwd_script_handler" type="text/javascript">if (typeof ecwd_js_init_call == "object") {
        ecwd_js_init_call = new ecwd_js_init();
    }</script>
<?php
if(isset($ecwd_options['enable_sidebar_in_event']) && $ecwd_options['enable_sidebar_in_event'] == '1'){
        get_sidebar();
}
get_footer();
?>
