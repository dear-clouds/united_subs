<?php
if (count($events) > 0) {
    global $post;
    if ($upcoming_events) {
        $evs_text = __('Related upcoming events', 'ecwd');
    } else {
        $evs_text = __('Upcoming events', 'ecwd');
    }
    ?>
    <div class="ecwd-organizer-events">
        <h3><?php _e($evs_text, 'ecwd') ?></h3>

        <div class="upcoming_events_slider">
            <div class="upcoming_events_slider-arrow-left"><a href="#left"></a></div>
            <div class="upcoming_events_slider-arrow-right"><a href="#right"></a></div>
            <ul>
                <?php
                $events_count = 0;
                foreach ($events as $key => $ecwd_event) {
                    if ($related_events_count >= 0 && $events_count > $related_events_count) {
                        break;
                    }
                    if ($upcoming_events == false || ($upcoming_events == true && strtotime($ecwd_event['from']) >= strtotime($today))) {
                        $events_count++;
                        ?>
                        <li itemscope itemtype="http://schema.org/Event" class="upcoming_events_item">
                            <div class="upcoming_event_container">
                                <?php
                                $image_class = '';
                                $image = getAndReplaceFirstImage($ecwd_event['post']->post_content);
                                if (!has_post_thumbnail($ecwd_event['id']) && $image['image'] == "") {
                                    $image_class = "ecwd-no-image";
                                }
                                echo '<div class="upcoming_events_item-img ' . $image_class . '">';
                                if (get_the_post_thumbnail($ecwd_event['id'])) {
                                    echo get_the_post_thumbnail($ecwd_event['id'], 'thumb');
                                } elseif ($image['image'] != null) {
                                    echo '<img src="' . $image['image'] . '" />';
                                    $ecwd_event['post']->post_content = $image['content'];
                                }
                                echo '</div>';
                                ?>
                                <div class="event-title" itemprop="name">
                                    <a href="<?php echo $ecwd_event['permalink'] ?>"><?php echo $ecwd_event['title'] ?></a>
                                </div>
                                <div class="event-date" itemprop="startDate"
                                     content="<?php echo date('Y-m-d', strtotime($ecwd_event['from'])) . 'T' . date('H:i', strtotime($ecwd_event['starttime'])) ?>">
                                         <?php
                                         if (isset($ecwd_event['all_day_event']) && $ecwd_event['all_day_event'] == 1) {
                                             echo date($date_format, strtotime($ecwd_event['from']));
                                             if ($ecwd_event['to'] && date($date_format, strtotime($ecwd_event['from'])) !== date($date_format, strtotime($ecwd_event['to']))) {
                                                 echo ' - ' . date($date_format, strtotime($ecwd_event['to']));
                                             }
                                             echo ' ' . __('All day', 'ecwd');
                                         } else {

                                             echo date($date_format, strtotime($ecwd_event['from'])) . ' ' . date($time_format, strtotime($ecwd_event['starttime']));

                                             if ($ecwd_event['to']) {
                                                 echo ' - ' . date($date_format, strtotime($ecwd_event['to'])) . ' ' . date($time_format, strtotime($ecwd_event['endtime']));
                                             }
                                         }
                                         ?>
                                </div>
                                <div class="upcoming_events_item-content"><?php echo( $ecwd_event['post']->post_content ? wpautop(strip_shortcodes($ecwd_event['post']->post_content)) : 'No additional details for this event.' ); ?> </div>
                            </div>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
<?php } ?>