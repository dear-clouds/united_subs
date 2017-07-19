<?php

/**
 * Class ECWD_Display
 */
class ECWD_Display {

    private $merged_events, $goole_events, $date, $month, $year, $day, $event_options;
    public $events;

    public function __construct($ids, $title_text = null, $sort_order = 'asc', $date = '', $page = 1, $search_params = array(), $displays = null, $filters = null, $page_items = 5, $event_search = 'yes', $display = '', $ecwd_views = array()) {
        $this->id = $ids;
        $this->title = $title_text;
        $this->sort = $sort_order;
        $this->merged_events = array();
        $this->search = $search_params;
        $this->displays = !is_array($displays) ? explode(',', $displays) : $displays;
        $this->filters = !is_array($filters) ? explode(',', $filters) : $filters;
        $this->page_items = $page_items;
        $this->event_search = $event_search;
        //$this->date = $date;
        $this->page = $page;
        if ($display) {
            $this->display = $display;
        } else {
            $this->display = 'full';
        }

        if (isset($_REQUEST['date'])) {
            $date = $_REQUEST['date'];
            $date = date('Y-n-j', strtotime($date));
        }
        if ($date == '' && !isset($_REQUEST['date'])) {
            $date = date('Y-n-j');
        }
        $start_date = date('Y-n-d', strtotime($date));
        $date = date('Y-n-t', strtotime($date)); // format the date for parsing
        $date_part = explode('-', $date); // separate year/month/day
        $year = $date_part[0];
        $month = $date_part[1];
        $day = $date_part[2];
        if (isset($_REQUEST['y']) && $_REQUEST['y'] != '') {
            $year = $_REQUEST['y'];
        } // if year is set in querystring it takes precedence
        if (isset($_REQUEST['m']) && $_REQUEST['m'] != '') {
            $month = $_REQUEST['m'];
        } // if month is set in querystring it takes precedence
        if (isset($_REQUEST['d']) && $_REQUEST['d'] != '') {
            $day = $_REQUEST['d'];
        } // if day is set in querystring it takes precedence

        if ($year == '') {
            $year = date('Y');
        }
        if ($month == '') {
            $month = date('n'); // set to january if year is known
        }
        if ($day == '') {
            $day = date('j'); // set to the 1st is year and month is known
        }
        $this->date = $date;
        $this->month = (int) $month;
        $this->year = (int) $year;
        $this->day = (int) $day;
        $this->start_date = $this->year . '-' . $this->month . '-1';
        $this->end_date = date('Y-m-t', strtotime($this->date));
        if (( isset($_REQUEST['t']) && $_REQUEST['t'] == 'week' ) || $this->display == 'week') {
            $this->start_date = $start_date;
            $this->end_date = date("Y-m-d", strtotime('+7 days', strtotime($start_date)));
            $this->date = date('Y-n-t', strtotime($this->end_date));
        } elseif (( isset($_REQUEST['t']) && $_REQUEST['t'] == '4day' ) || $this->display == '4day') {
            $this->start_date = $start_date;
            $this->end_date = date("Y-m-d", strtotime('+4 days', strtotime($start_date)));
            $this->date = date('Y-n-t', strtotime($this->end_date));
        }


        if ($this->id) {
            $this->get_events();
        }
    }

    public function get_events() {

        //get events by calendars
        if (!$this->date) {
            $this->date = $date = date('Y-m-t');
        }
        $date = $this->date;


        $query = ( isset($this->search['query']) ? $this->search['query'] : '' );

        foreach ($this->id as $id) {
            $ecwd_events_title = array();
            if (!is_array($this->search) || count($this->search) == 0) {
                $args = array(
                    'numberposts' => - 1,
                    'post_type' => ECWD_PLUGIN_PREFIX . '_event',
                    'meta_query' => array(
                        array(
                            'key' => ECWD_PLUGIN_PREFIX . '_event_calendars',
                            'value' => serialize(strval($id)),
                            'compare' => 'LIKE'
                        ),
                        array(
                            'key' => ECWD_PLUGIN_PREFIX . '_event_date_from',
                            'value' => $date,
                            'compare' => '<=',
                            'type' => 'DATE'
                        ),
                    ),
                    'meta_key' => ECWD_PLUGIN_PREFIX . '_event_date_from',
                    'orderby' => 'meta_value',
                    'order' => 'ASC'
                );
            } else {
                $ecwd_events_title_query = 'post_type=ecwd_event';
                $organizers_query = array();
                if ($query != '') {
                    $ecwd_events_title_query .= '&s=' . $query;

                    $metaquery = new WP_Query('s=' . $query . '&post_type=ecwd_organizer');
                    $organizers = $metaquery->get_posts();

                    $organizers_query['relation'] = 'OR';

                    foreach ($organizers as $organizer) {
                        $organizers_query[] = array(
                            'key' => ECWD_PLUGIN_PREFIX . '_event_organizers',
                            'value' => serialize(strval($organizer->ID)),
                            'compare' => 'LIKE'
                        );
                    }
                    $organizers_query[] = array(
                        'key' => ECWD_PLUGIN_PREFIX . '_event_location',
                        'value' => $query,
                        'compare' => 'LIKE'
                    );
                }

                $tax_query = array();
                $organizers_ids = array();
                $venue_query = array();
                ;
                if (isset($this->search['categories']) && $this->search['categories'] !== 0) {
                    $tax_query[] = array(
                        'taxonomy' => ECWD_PLUGIN_PREFIX . '_event_category',
                        'terms' => $this->search['categories'],
                    );
                }
                if (isset($this->search['tags']) && $this->search['tags'] > 0) {
                    $tax_query[] = array(
                        'taxonomy' => 'ecwd_event_tag',
                        'terms' => $this->search['tags'],
                    );
                }
                if (isset($this->search['venues']) && $this->search['venues'] > 0) {
                    $venue_query['relation'] = 'OR';
                    foreach ($this->search['venues'] as $venue) {
                        $venue_query[] = array(
                            'key' => ECWD_PLUGIN_PREFIX . '_event_venue',
                            'value' => $venue
                        );
                    }
                }
                if (isset($this->search['organizers']) && $this->search['organizers'] !== 0) {
                    $organizers_ids['relation'] = 'OR';
                    foreach ($this->search['organizers'] as $organizer) {
                        $organizers_ids[] = array(
                            'key' => ECWD_PLUGIN_PREFIX . '_event_organizers',
                            'value' => serialize(strval($organizer)),
                            'compare' => 'LIKE'
                        );
                    }
                }


                $meta_query = array(
                    'relation' => 'AND',
                    $organizers_query,
                    array(
                        'key' => ECWD_PLUGIN_PREFIX . '_event_calendars',
                        'value' => serialize(strval($id)),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => ECWD_PLUGIN_PREFIX . '_event_date_from',
                        'value' => $this->end_date,
                        'compare' => '<=',
                        'type' => 'DATE'
                    ),
                    $venue_query,
                    $organizers_ids
                );
                $args = array(
                    'numberposts' => - 1,
                    'post_type' => ECWD_PLUGIN_PREFIX . '_event',
                    'relation' => 'AND',
                    'meta_query' => $meta_query,
                    'tax_query' => $tax_query,
                    'meta_key' => ECWD_PLUGIN_PREFIX . '_event_date_from',
                    'orderby' => 'meta_value',
                    'order' => 'ASC'
                );

                if ($query && $query !== '') {
                    try {
                        $ecwd_events_title = new WP_Query($ecwd_events_title_query);
                        $ecwd_events_title = $ecwd_events_title->get_posts();
                    } catch (Exception $e) {
                        $ecwd_events_title = array();
                    }
                }
                wp_reset_query();
            }
            try {
                $ecwd_events = get_posts($args);
            } catch (Exception $e) {
                $ecwd_events = array();
            }

            $ecwd_events += $ecwd_events_title;
            wp_reset_query();
            $google_events = array();
            $events = array();
            $ical_events = array();
            $facebook_events = array();
            //fetch google calendar events

            global $ecwd_options;
            $event_desc_length = isset($ecwd_options['event_description_max_length']) ? $ecwd_options['event_description_max_length'] : "";

            foreach ($ecwd_events as $ecwd_event) {

                $term_metas = '';
                $categories = get_the_terms($ecwd_event->ID, ECWD_PLUGIN_PREFIX . '_event_category');
                if (is_array($categories)) {
                    $ci = 0;
                    foreach ($categories as $i => $category) {
                        $term_metas[$ci] = get_option("ecwd_event_category_$category->term_id");
                        $term_metas[$ci]['id'] = $category->term_id;
                        $term_metas[$ci]['name'] = $category->name;
                        $term_metas[$ci]['slug'] = $category->slug;
                        $ci ++;
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
                if ($event_desc_length !== '') {
                    $ecwd_event->post_content = $this->the_excerpt_max_charlength(intval($event_desc_length), $ecwd_event->post_content, $permalink);
                }
                if (isset($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_calendars'][0])) {
                    if (is_serialized($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_calendars'][0])) {
                        $event_calendar_ids = unserialize($ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_calendars'][0]);
                    } else {
                        $event_calendar_ids = $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_calendars'][0];
                    }
                    //var_dump($term_metas);
                    if (in_array($this->id[0], $event_calendar_ids)) {
                        $events[$ecwd_event->ID] = new ECWD_Event($ecwd_event->ID, $id, $ecwd_event->post_title, $ecwd_event->post_content, $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_location'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_lat_long'][0], $permalink, $ecwd_event, $term_metas, $ecwd_event_metas);
                    }
                }
            }
            $this->merged_events += $google_events + $facebook_events + $ical_events + $events;

            //$this->merged_events += $events;

            if(isset($_REQUEST['ecwd_calendar_search']) && $_REQUEST['ecwd_calendar_search'] == '1'){
                $this->get_search_events_for_long_days();
            }else {
                $this->get_events_for_long_days('', 1);
            }
        }
    }

    public function the_excerpt_max_charlength($charlength, $content,$permalink) {
        $excerpt = $content;
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = strip_tags($excerpt);
        $charlength++;

        if (mb_strlen($excerpt) > $charlength) {
            $read_more = '<a href="'.$permalink.'">[' . __('Read more', 'ecwd') . ']</a>';
            $subex = mb_substr($excerpt, 0, $charlength);
            $exwords = explode(' ', $subex);
            $excut = -(mb_strlen($exwords[count($exwords) - 1]));
            if ($excut < 0) {
                return mb_substr($subex, 0, $excut) . '...' .$read_more;
            } else {
                return $subex . '...'.$read_more;
            }
        } else {
            return str_replace('[&hellip;]', '', $excerpt);
        }
    }

    /**
     * Comparison function for use when sorting merged event data (with usort)
     */
    function compare($event1, $event2) {
//        //Sort ascending or descending
//        if ('asc' == $this->sort)
//            return $event1->start_time - $event2->start_time;
//
//        return $event2->start_time - $event1->start_time;
    }

    /**
     * Returns array of days with events, with sub-arrays of events for that day
     */
    public function get_event_days($events = '', $current_month = 1, $start_date = '', $end_date = '') {
        if (!$events) {
            $events = $this->merged_events;
        }
        if ($start_date) {
            $this->start_date = $start_date;
        }

        if ($end_date) {
            $this->end_date = $end_date;
        }
        foreach ($events as $id => $arr) {

            if (is_int($arr->start_time)) {
                $start_date = date('Y-m-d', $arr->start_time);
                $end_date = date('Y-m-d', $arr->end_time);
                $start_time = date('H:i', $arr->start_time);
                $end_time = date('H:i', $arr->end_time);
            } else {
                $start_date = date('Y-m-d', strtotime($arr->start_time));
                $end_date = date('Y-m-d', strtotime($arr->end_time));
                $start_time = date('H:i', strtotime($arr->start_time));
                $end_time = date('H:i', strtotime($arr->end_time));
            }
            $arr = (array) $arr;
            $from = $start_date;
            $to = $end_date;
            $starttime = $start_time;
            $endtime = $end_time;

            $post = array_key_exists('post', $arr) ? $arr['post'] : '';
            $color = array_key_exists('color', $arr) ? $arr['color'] : '';
            $permalink = array_key_exists('permalink', $arr) ? $arr['permalink'] : '';
            if ($permalink) {
                $permalink = ECWD_Event::getLink($post, $from);
            }

            $metas = array_key_exists('metas', $arr) ? $arr['metas'] : '';
            $terms = array_key_exists('terms', $arr) ? $arr['terms'] : '';
            $venue = array();
            if ($metas && isset($metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]) && $metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]) {
                $venue_post = get_post($metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]);
                if ($venue_post) {
                    $venue['name'] = $venue_post->post_title;
                    $venue['id'] = $venue_post->ID;
                    $venue['permalink'] = get_permalink($venue_post->ID);
                }
            }
            $organizers = array();
            $organizersIDs = array();
            if ($metas && isset($metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0])) {
                if (is_serialized($metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0])) {
                    $organizers_ids = unserialize($metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0]);
                } elseif (is_array($metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0])) {
                    $organizers_ids = $metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0];
                } else {
                    $organizers_ids = array();
                }
                if ($organizers_ids) {
                    foreach ($organizers_ids as $organizer_id) {
                        if ($organizer_id) {
                            $opost = get_post($organizer_id);
                            if ($opost) {
                                $organizers[] = array(
                                    'id' => $opost->ID,
                                    'name' => $opost->post_title,
                                    'permalink' => get_permalink($opost->ID)
                                );
                                $organizersIDs[] = $opost->ID;
                            }
                        }
                    }
                }
            }
            if ($terms) {
                if (isset($terms['0']['color'])) {
                    $color = $terms['0']['color'];
                } else {
                    $color = '';
                }
                $catIds = array();
                foreach ($terms as $term) {
                    if (isset($term['id'])) {
                        $catIds[] = $term['id'];
                    }
                }
            }

            $this->event_options['id'] = $id;
            $this->event_options['from'] = $from;
            $this->event_options['to'] = $to;
            $this->event_options['starttime'] = $start_time;
            $this->event_options['endtime'] = $end_time;
            $this->event_options['title'] = array_key_exists('title', $arr) ? $arr['title'] : '';
            $this->event_options['details'] = array_key_exists('description', $arr) ? $arr['description'] : '';
            $this->event_options['color'] = $color;
            $this->event_options['link'] = array_key_exists('link', $arr) ? $arr['link'] : '';
            $this->event_options['location'] = array_key_exists('location', $arr) ? $arr['location'] : '';
            $this->event_options['permalink'] = array_key_exists('permalink', $arr) ? $arr['permalink'] : '';
            $this->event_options['latlong'] = array_key_exists('latlong', $arr) ? $arr['latlong'] : '';
            $this->event_options['terms'] = $terms;
            $this->event_options['metas'] = $metas;
            $this->event_options['all_day_event'] = ( isset($metas['ecwd_all_day_event'][0]) && $metas['ecwd_all_day_event'][0] == 1 ) ? 1 : 0;
            $this->event_options['post'] = $post;
            $this->event_options['image'] = array_key_exists('image', $arr) ? $arr['image'] : '';
            $this->event_options['organizers'] = $organizers;
            $this->event_options['venue'] = $venue;


            if (isset($this->search['categories']) && $this->search['categories'] > 0) {
                if (!array_intersect($this->search['categories'], $catIds)) {
                    continue;
                };
            }
            //echo '<br />';

            if (isset($this->search['venues']) && $this->search['venues'] > 0) {
                if (!isset($metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]) || !count($venue)) {
                    continue;
                } else {
                    if (!in_array($venue['id'], $this->search['venues'])) {
                        continue;
                    }
                }
            }
            if (isset($this->search['organizers']) && $this->search['organizers'] > 0) {
                if (!array_intersect($this->search['organizers'], $organizersIDs)) {
                    continue;
                };
            }
            $weekdays = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
            if (isset($this->search['weekdays']) && $this->search['weekdays'] > 0) {
                $weekdays = $this->search['weekdays'];
            }


            if ($metas && isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0]) && $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] !== 'no_repeat' && $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] != '') {
                $event_week_last_day = '';
                if ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'weekly') {
                    $days = array();
                    if (isset($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0]) && $metas[ECWD_PLUGIN_PREFIX . '_event_day'][0] != '' && $metas[ECWD_PLUGIN_PREFIX . '_event_day'][0] != 1) {

                        if (is_serialized($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0])) {
                            $days = unserialize($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0]);
                        } elseif (is_array($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0])) {
                            $days = $metas[ECWD_PLUGIN_PREFIX . '_event_day'][0];
                        }
                    } else {
                        $days = array(strtolower(date('l', strtotime($from))));
                    }

                    $until = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0] : $to );
                    if (strtotime($until) > strtotime($this->end_date)) {
                        $until = $this->end_date;
                    }
                    $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );
                    if (count($days)) {
                        $event_week_last_day = $days[count($days) - 1];
                    }
                    $eventdays = $this->dateDiff($from, $until);
                    $eventdayslong = $this->dateDiff($from, $to);
                    if ($eventdays < 0) {
                        continue;
                    }
                    $from_date = $from;

                    for ($i = 0; $i <= $eventdays; $i ++) {
                        $eventdate = strtotime(date("Y-m-d", strtotime($from_date)) . " +" . $i . " day");
                        $week_day = strtolower(date('l', $eventdate));
                        $eventdate = date("Y-n-j", $eventdate);

                        if (is_array($days) && in_array($week_day, $days)) {
                            if ($how > 1 && $week_day == $event_week_last_day) {
                                $from_date = strtotime(( date("Y-m-d", ( strtotime($from_date))) . " +" . ( ( $how * 7 ) - 7 ) . " days"));
                                $from_date = date('Y-m-d', $from_date);
                                $next_week = date("Y-m-d", strtotime('next monday', strtotime($from_date)));
                            }
                            $from = $eventdate;

                            if (strtotime($until) >= strtotime(date('Y-m-d', strtotime($from)))) {


                                $to = date('Y-m-d', strtotime($from . ' + ' . $eventdayslong . ' days'));


                                if (!$current_month || (strtotime($to) <= strtotime($this->end_date) && strtotime($from) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($from))), $weekdays) )) {
                                    $this->set_event($eventdate, $from, $to);
                                }
                            }
                        }
                    }
                } elseif ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'daily') {
                    $until = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0] : $to );

                    if (strtotime($until) > strtotime($this->end_date)) {
                        $until = $this->end_date;
                    }
                    $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );
                    $eventdays = $this->dateDiff($from, $until);
                    $eventdayslong = $this->dateDiff($from, $to);
                    if ($eventdays < 0) {
                        continue;
                    }
                    $from_date = $from;
                    for ($i = 0; $i <= $eventdays; $i ++) {
                        $date = strtotime(date("Y-m-d", strtotime($from_date)) . " +" . $i . " day");
                        $date = date("Y-n-j", $date);
                        if (strtotime($until) >= strtotime(date('Y-m-d', strtotime($date)))) {

                            $from_date = strtotime(( date("Y-m-d", ( strtotime($from_date))) . " +" . ( ( $how - 1 ) ) . " days"));
                            $from_date = date('Y-m-d', $from_date);
                            $from = $date;
                            $to = date('Y-m-d', strtotime($from . ' + ' . $eventdayslong . ' days'));

                            if (!$current_month || (strtotime($to) <= strtotime($this->end_date) && strtotime($from) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($from))), $weekdays) )) {
                                $this->set_event($date, $from, $to);
                            }
                        }
                    }
                } else if ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'monthly') {
                    $until = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0] : $to );
                    $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );
                    $eventdays = $this->dateDiff($from, $until);
                    $eventdayslong = $this->dateDiff($from, $to);
                    $event_from = $from;
                    $from_date = $from;
                    $repeat_days = isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_month_on_days'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_month_on_days'][0] : 1;
                    $repeat_when = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_list_monthly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_list_monthly'][0] : false;
                    $repeat_day = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_week_monthly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_week_monthly'][0] : false;

                    $min_date = strtotime($event_from);
                    $max_date = strtotime("+1 MONTH", strtotime($until));
                    if ($max_date >= $min_date) {
                        $i = 0;
                        while (( $min_date = strtotime("+1 MONTH", $min_date) ) <= $max_date) {
                            //echo date('Y-m-d', $min_date).'----'.date('Y-m-d', $max_date).'<br />';
                            $date = strtotime(date("Y-m-d", strtotime($event_from)) . " +" . $i * $how . " MONTH");
                            if ($i > 0) {
                                if ($repeat_days == 2 && $repeat_day && $repeat_when && date('Y-m', strtotime($event_from)) !== date('Y-m', $date)) {
                                    $monthyear = date("F Y", $date);
                                    $repeat_date = date('Y-m-d', strtotime($repeat_when . ' ' . ucfirst($repeat_day) . ' of ' . $monthyear));
                                    if ($repeat_date == '1970-01-01' || $repeat_date == '1969-12-31') {
                                        $repeat_date = date('Y-m-d', strtotime($monthyear . ' ' . $repeat_when . ' ' . $repeat_day));
                                    }

                                    $date = strtotime($repeat_date);
                                }
                            }
                            $date = date("Y-n-j", $date);
                            $i ++;
                            if (strtotime($until) >= strtotime(date('Y-m-d', strtotime($date)))) {
                                $min_date = $from_date = strtotime(( date("Y-m-1", ( strtotime($date))) . " +" . ( ( $how ) ) . " month"));
                                $eventdays -= 30;
                                $from_date = strtotime(( date("Y-m-d", $from_date) . " - 1  day"));

                                $from_date = date('Y-m-d', $from_date);
                                $from = $date;
                                $to = strtotime(( date("Y-m-d", ( strtotime($from))) . " +" . ( $eventdayslong ) . " days"));
                                $to = date('Y-m-d', $to);
                                if (!$current_month || (strtotime($to) <= strtotime($this->end_date) && strtotime($from) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($from))), $weekdays) )) {
                                    $this->set_event($date, $from, $to);
                                }
                            }
                        }
                    }
                } else if ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'yearly') {
                    $until = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0] : $to );
                    $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );
                    $eventdays = $this->dateDiff($from, $until);
                    $eventdayslong = $this->dateDiff($from, $to);
                    $event_from = $from;
                    $from_date = $from;
                    $repeat_days = isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_year_on_days'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_year_on_days'][0] : 1;
                    $repeat_when = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_list_yearly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_list_yearly'][0] : false;
                    $repeat_day = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_week_yearly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_week_yearly'][0] : false;
                    if (isset($metas[ECWD_PLUGIN_PREFIX . '_event_year_month'][0]) && $repeat_days == 2) {
                        $month = $metas[ECWD_PLUGIN_PREFIX . '_event_year_month'][0];
                        $monthName = date('F', strtotime('2015-' . $month . '-1'));
                    } else {
                        $monthName = date('F', strtotime($from_date));
                    }
                    $min_date = strtotime($event_from);
                    $max_date = strtotime($until);
                    $i = 0;
                    while (( $min_date = strtotime("+1 YEAR", $min_date) ) <= $max_date) {
                        $date = strtotime(date("Y-m-d", strtotime($event_from)) . " +" . $i * $how . " YEAR");
                        if ($i > 0) {
                            if ($repeat_days == 1) {
                                $monthyear = $monthName . ' ' . date("d Y", $date);
                                $repeat_date = strtotime(date('Y-m-d', strtotime($monthyear)));
                                $date = $repeat_date;
                            }
                            if ($repeat_days == 2 && $repeat_day && $repeat_when) {
                                $monthyear = $monthName . ' ' . date("Y", $date);
                                //echo $repeat_when.' '.ucfirst( $repeat_day ).' of '.$monthyear.'<br />';
                                $repeat_date = date('Y-m-d', strtotime($repeat_when . ' ' . ucfirst($repeat_day) . ' of ' . $monthyear));
                                if ($repeat_date == '1970-01-01' || $repeat_date == '1969-12-31') {
                                    $repeat_date = date('Y-m-d', strtotime($monthyear . ' ' . $repeat_when . ' ' . $repeat_day));
                                }
                                //$repeat_date = date( 'Y-m-d', strtotime($repeat_when.' '.ucfirst( $repeat_day ).' of '.$monthyear) );
                                //don't know why, but "last sunday,last monday... returns last s,m of previous month"
                                if ($repeat_when == 'last') {
                                    $repeat_date = date('Y-m-d', strtotime($repeat_when . ' ' . ucfirst($repeat_day) . ' of ' . $monthyear, strtotime("+1 MONTH", $repeat_date)));
                                }
                                $date = strtotime($repeat_date);
                            }
                        }
                        $date = date("Y-n-j", $date);

                        $i ++;
                        if (strtotime($until) >= strtotime(date('Y-m-t', strtotime($this->date))) && strtotime($date) <= strtotime($until)) {
                            $from_date = strtotime(( date("Y-m-d", ( strtotime($from_date))) . " +" . ( ( $how ) ) . " year"));
                            $from_date = strtotime(( date("Y-m-d", $from_date) . " - 1  day"));
                            $from_date = date('Y-m-d', $from_date);
                            $from = $date;
                            $to = strtotime(( date("Y-m-d", ( strtotime($from_date))) . " +" . ( $eventdayslong ) . " days"));
                            $to = date('Y-m-d', $to);
                            if (!$current_month || (strtotime($to) <= strtotime($this->end_date) && strtotime($from) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($from))), $weekdays) )) {
                                $this->set_event($date, $from, $to);
                            }
                        }
                    }
                }
            } else {
                $eventdays = $this->dateDiff($from, $to); // get the difference in days between the two dates
                $date = strtotime(date("Y-m-d", strtotime($from)));
                $date = date("Y-n-j", $date);
                if (!$current_month || (strtotime($to) <= strtotime($this->end_date) && strtotime($from) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($from))), $weekdays) )) {
                    $this->set_event($date, $from, $to);
                }
            }
        }

        if ($this->events) {
            $this->events = $this->arraySort($this->events, 'from');
        }

        if ($events) {
            return $this->events;
        }
    }

    private function get_search_events_for_long_days(){
        $this->get_events_for_long_days('', 1);

        if(empty($this->merged_events) || (is_array($this->events) && !empty($this->events))){
            return ;
        }

        $max_end_date = 0;
        $max_end_date_event_id = 0;

        foreach ($this->merged_events as $id=>$event) {

            if(isset($event->metas['ecwd_event_repeat_repeat_until'][0])){
                $temp_date = $event->metas['ecwd_event_repeat_repeat_until'][0];
            }else{
                $temp_date = $event->end_time;
            }

            $temp_date = strtotime($temp_date);

            if($temp_date > $max_end_date){
                $max_end_date = $temp_date;
                $max_end_date_event_id = $id;
            }
        }

        $max_end_date = strtotime(date("Y/m/t H:i:s", $max_end_date));
        

        $init_start_date = $this->start_date;
        $init_end_date = $this->end_date;

        while(true){

            $start_date = date("Y-n-j" ,strtotime("+1 MONTH", strtotime($this->start_date)));
            $end_date = date("Y-m-t" , strtotime($start_date));

            if(strtotime($end_date) > $max_end_date){
                $this->start_date = $init_start_date;
                $this->end_date = $init_end_date;
                break;
            }


            $this->start_date = $start_date;
            $this->end_date = $end_date;

            $this->get_events_for_long_days('', 1);


            if(is_array($this->events) && !empty($this->events)){
                break;
            }
        }
    }

    /**
     * Returns array of days with events, with sub-arrays of events for that day
     */
    public function get_events_for_long_days($events = '', $current_month = 1, $start_date = '', $end_date = '') {
        global $ecwd_options;
        if (!$events) {
            $events = $this->merged_events;
        }

        if ($start_date && $end_date) {
            $this->start_date = $start_date;
            $this->end_date = $end_date;
        }
        foreach ($events as $id => $arr) {

            if (is_int($arr->start_time)) {
                $start_date = date('Y-m-d', $arr->start_time);
                $end_date = date('Y-m-d', $arr->end_time);
                $start_time = date('H:i', $arr->start_time);
                $end_time = date('H:i', $arr->end_time);
            } else {
                $start_date = date('Y-m-d', strtotime($arr->start_time));
                $end_date = date('Y-m-d', strtotime($arr->end_time));
                $start_time = date('H:i', strtotime($arr->start_time));
                $end_time = date('H:i', strtotime($arr->end_time));
            }
            $arr = (array) $arr;
            $from = $start_date;
            $to = $end_date;
            $starttime = $start_time;
            $endtime = $end_time;

            $post = array_key_exists('post', $arr) ? $arr['post'] : '';
            $color = array_key_exists('color', $arr) ? $arr['color'] : '';
            $permalink = array_key_exists('permalink', $arr) ? $arr['permalink'] : '';
            if ($permalink) {
                $permalink = ECWD_Event::getLink($post, $from);
            }

            $metas = array_key_exists('metas', $arr) ? $arr['metas'] : '';
            $terms = array_key_exists('terms', $arr) ? $arr['terms'] : '';
            $venue = array();
            if ($metas && isset($metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]) && $metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]) {
                $venue_post = get_post($metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]);
                if ($venue_post) {
                    $venue['name'] = $venue_post->post_title;
                    $venue['id'] = $venue_post->ID;
                    $venue['permalink'] = get_permalink($venue_post->ID);
                }
            }

            $organizers = array();
            $organizersIDs = array();
            if ($metas && isset($metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0])) {
                if (is_serialized($metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0])) {
                    $organizers_ids = unserialize($metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0]);
                } elseif (is_array($metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0])) {
                    $organizers_ids = $metas[ECWD_PLUGIN_PREFIX . '_event_organizers'][0];
                } else {
                    $organizers_ids = array();
                }
                if ($organizers_ids) {
                    foreach ($organizers_ids as $organizer_id) {
                        if ($organizer_id) {
                            $opost = get_post($organizer_id);
                            if ($opost) {
                                $organizers[] = array(
                                    'id' => $opost->ID,
                                    'name' => $opost->post_title,
                                    'permalink' => get_permalink($opost->ID)
                                );
                                $organizersIDs[] = $opost->ID;
                            }
                        }
                    }
                }
            }
            if ($terms) {
                if (isset($terms['0']['color'])) {
                    $color = $terms['0']['color'];
                } else {
                    $color = '';
                }
                $catIds = array();
                foreach ($terms as $term) {
                    if (isset($term['id'])) {
                        $catIds[] = $term['id'];
                    }
                }
            }


            $this->event_options['id'] = $id;
            $this->event_options['from'] = $from;
            $this->event_options['to'] = $to;
            $this->event_options['starttime'] = $start_time;
            $this->event_options['endtime'] = $end_time;
            $this->event_options['title'] = array_key_exists('title', $arr) ? $arr['title'] : '';
            $this->event_options['details'] = array_key_exists('description', $arr) ? $arr['description'] : '';
            $this->event_options['color'] = $color;
            $this->event_options['link'] = array_key_exists('link', $arr) ? $arr['link'] : '';
            $this->event_options['location'] = array_key_exists('location', $arr) ? $arr['location'] : '';
            $this->event_options['permalink'] = array_key_exists('permalink', $arr) ? $arr['permalink'] : '';
            $this->event_options['latlong'] = array_key_exists('latlong', $arr) ? $arr['latlong'] : '';
            $this->event_options['terms'] = $terms;
            $this->event_options['metas'] = $metas;
            $this->event_options['all_day_event'] = ( isset($metas['ecwd_all_day_event'][0]) && $metas['ecwd_all_day_event'][0] == 1 ) ? 1 : 0;
            $this->event_options['post'] = $post;
            $this->event_options['image'] = array_key_exists('image', $arr) ? $arr['image'] : '';
            $this->event_options['organizers'] = $organizers;
            $this->event_options['venue'] = $venue;



            if (isset($this->search['categories']) && $this->search['categories'] > 0) {
                if (!array_intersect($this->search['categories'], $catIds)) {
                    continue;
                };
            }
            //echo '<br />';

            if (isset($this->search['venues']) && $this->search['venues'] > 0) {
                if (!isset($metas[ECWD_PLUGIN_PREFIX . '_event_venue'][0]) || !count($venue)) {
                    continue;
                } else {
                    if (!in_array($venue['id'], $this->search['venues'])) {
                        continue;
                    }
                }
            }
            if (isset($this->search['organizers']) && $this->search['organizers'] > 0) {
                if (!array_intersect($this->search['organizers'], $organizersIDs)) {
                    continue;
                };
            }
            $weekdays = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
            if (isset($this->search['weekdays']) && $this->search['weekdays'] > 0) {
                $weekdays = $this->search['weekdays'];
            }

            if ($metas && isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0]) && $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] !== 'no_repeat' && $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] != '') {
                $event_week_last_day = '';

                if ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'weekly') {
                    $days = array();
                    if (isset($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0]) && $metas[ECWD_PLUGIN_PREFIX . '_event_day'][0] != '' && $metas[ECWD_PLUGIN_PREFIX . '_event_day'][0] != 1) {

                        if (is_serialized($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0])) {
                            $days = unserialize($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0]);
                        } elseif (is_array($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0])) {
                            $days = $metas[ECWD_PLUGIN_PREFIX . '_event_day'][0];
                        }
                    } else {
                        $days = array(strtolower(date('l', strtotime($from))));
                    }

                    $until = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0] : $to );
                    if (strtotime($until) > strtotime($this->end_date)) {
                        $until = $this->end_date;
                    }
                    $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );
                    if (count($days)) {
                        $event_week_last_day = $days[count($days) - 1];
                    }
                    $eventdays = $this->dateDiff($from, $until);
                    $eventdayslong = $this->dateDiff($from, $to);
                    $eventdayslong_def = $this->dateDiff($from, $to);
                    if ($eventdays < 0) {
                        continue;
                    }
                    $from_date = $from;

                    for ($i = 0; $i <= $eventdays; $i ++) {
                        $eventdate = strtotime(date("Y-m-d", strtotime($from_date)) . " +" . $i . " day");
                        $week_day = strtolower(date('l', $eventdate));
                        $eventdate = date("Y-n-j", $eventdate);

                        if (is_array($days) && in_array($week_day, $days)) {
                            if ($how > 1 && $week_day == $event_week_last_day) {
                                $from_date = strtotime(( date("Y-m-d", ( strtotime($from_date))) . " +" . ( ( $how * 7 ) - 7 ) . " days"));
                                $from_date = date('Y-m-d', $from_date);
                                $next_week = date("Y-m-d", strtotime('next monday', strtotime($from_date)));
                            }
                            $from = $eventdate;

                            $eventdayslong = $eventdayslong_def;
                            if (isset($ecwd_options["long_events"]) && $ecwd_options["long_events"] == '1') {
                                $m1 = date('m', strtotime($to));
                                $m2 = date('m', strtotime($end_date));
                                if (strtotime($to) <= strtotime($this->end_date) || (strtotime($to) >= strtotime($this->end_date) && $m1 == $m2)) {
                                    if (strtotime($from) < strtotime($this->start_date)) {
                                        $diff = $this->dateDiff($eventdate, $this->start_date);
                                        if ($diff > 0) {
                                            $eventdayslong -= $diff;
                                        }
                                        $eventdate = $this->start_date;
                                    }
                                }
                            }

                            if (strtotime($until) >= strtotime(date('Y-m-d', strtotime($eventdate)))) {
                                $to = date('Y-m-d', strtotime($eventdate . ' + ' . $eventdayslong . ' days'));
                                if (!$current_month || ( strtotime($eventdate) <= strtotime($this->end_date) && in_array(strtolower(date('l', strtotime($eventdate))), $weekdays) )) {
                                    $this->set_long_event($eventdate, $from, $to);
                                }
                            }
                        }
                    }
                } elseif ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'daily') {
                    $until = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0] : $to );

                    if (strtotime($until) > strtotime($this->end_date)) {
                        $until = $this->end_date;
                    }
                    $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );
                    $eventdays = $this->dateDiff($from, $until);
                    $eventdayslong = $this->dateDiff($from, $to);
                    $eventdayslong_def = $this->dateDiff($from, $to);
                    if ($eventdays < 0) {
                        continue;
                    }
                    $from_date = $from;
                    for ($i = 0; $i <= $eventdays; $i ++) {
                        $date = strtotime(date("Y-m-d", strtotime($from_date)) . " +" . $i . " day");
                        $date = date("Y-n-j", $date);
                        if (strtotime($until) >= strtotime(date('Y-m-d', strtotime($date)))) {

                            $from_date = strtotime(( date("Y-m-d", ( strtotime($from_date))) . " +" . ( ( $how - 1 ) ) . " days"));
                            $from_date = date('Y-m-d', $from_date);
                            $from = $date;
                            $to = date('Y-m-d', strtotime($from . ' + ' . $eventdayslong . ' days'));


                            $eventdayslong = $eventdayslong_def;
                            if (isset($ecwd_options["long_events"]) && $ecwd_options["long_events"] == '1') {
                                $m1 = date('m', strtotime($to));
                                $m2 = date('m', strtotime($end_date));
                                if (strtotime($to) <= strtotime($this->end_date) || (strtotime($to) >= strtotime($this->end_date) && $m1 == $m2)) {
                                    if (strtotime($from) < strtotime($this->start_date)) {
                                        $diff = $this->dateDiff($date, $this->start_date);
                                        if ($diff > 0) {
                                            $eventdayslong -= $diff;
                                        }
                                        $date = $this->start_date;
                                    }
                                }
                            }

                            if (!$current_month || ( strtotime($date) <= strtotime($this->end_date) && strtotime($date) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($date))), $weekdays) )) {
                                $this->set_long_event($date, $from, $to);
                            }
                        }
                    }
                } else if ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'monthly') {
                    $until = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0] : $to );
                    $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );
                    $eventdays = $this->dateDiff($from, $until);
                    $eventdayslong = $this->dateDiff($from, $to);
                    $eventdayslong_def = $this->dateDiff($from, $to);
                    $event_from = $from;
                    $from_date = $from;
                    $repeat_days = isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_month_on_days'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_month_on_days'][0] : 1;
                    $repeat_when = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_list_monthly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_list_monthly'][0] : false;
                    $repeat_day = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_week_monthly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_week_monthly'][0] : false;

                    $min_date = strtotime($event_from);
                    $max_date = strtotime("+1 MONTH", strtotime($until));
                    if ($max_date >= $min_date) {
                        $i = 0;
                        while (( $min_date = strtotime("+1 MONTH", $min_date) ) <= $max_date) {
                            //echo date('Y-m-d', $min_date).'----'.date('Y-m-d', $max_date).'<br />';
                            $date = strtotime(date("Y-m-d", strtotime($event_from)) . " +" . $i * $how . " MONTH");
                            if ($i > 0) {
                                if ($repeat_days == 2 && $repeat_day && $repeat_when && date('Y-m', strtotime($event_from)) !== date('Y-m', $date)) {
                                    $monthyear = date("F Y", $date);
                                    $repeat_date = date('Y-m-d', strtotime($repeat_when . ' ' . ucfirst($repeat_day) . ' of ' . $monthyear));
                                    if ($repeat_date == '1970-01-01' || $repeat_date == '1969-12-31') {
                                        $repeat_date = date('Y-m-d', strtotime($monthyear . ' ' . $repeat_when . ' ' . $repeat_day));
                                    }

                                    $date = strtotime($repeat_date);
                                }
                            }
                            $date = date("Y-n-j", $date);
                            $i ++;
                            if (strtotime($until) >= strtotime(date('Y-m-d', strtotime($date)))) {
                                $min_date = $from_date = strtotime(( date("Y-m-1", ( strtotime($date))) . " +" . ( ( $how ) ) . " month"));
                                $eventdays -= 30;
                                $from_date = strtotime(( date("Y-m-d", $from_date) . " - 1  day"));

                                $from_date = date('Y-m-d', $from_date);
                                $from = $date;
                                $to = strtotime(( date("Y-m-d", ( strtotime($from))) . " +" . ( $eventdayslong ) . " days"));
                                $to = date('Y-m-d', $to);

                                $eventdayslong = $eventdayslong_def;
                                if (isset($ecwd_options["long_events"]) && $ecwd_options["long_events"] == '1') {
                                    $m1 = date('m', strtotime($to));
                                    $m2 = date('m', strtotime($end_date));
                                    if (strtotime($to) <= strtotime($this->end_date) || (strtotime($to) >= strtotime($this->end_date) && $m1 == $m2)) {
                                        if (strtotime($from) < strtotime($this->start_date)) {
                                            $diff = $this->dateDiff($date, $this->start_date);
                                            if ($diff > 0) {
                                                $eventdayslong -= $diff;
                                            }
                                            $date = $this->start_date;
                                        }
                                    }
                                }

                                if (!$current_month || ( strtotime($date) <= strtotime($this->end_date) && strtotime($date) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($date))), $weekdays) )) {
                                    $this->set_long_event($date, $from, $to);
                                }
                            }
                        }
                    }
                } else if ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'yearly') {
                    $until = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0] : $to );
                    $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );
                    $eventdays = $this->dateDiff($from, $until);
                    $eventdayslong = $this->dateDiff($from, $to);
                    $eventdayslong_def = $this->dateDiff($from, $to);
                    $event_from = $from;
                    $from_date = $from;
                    $repeat_days = isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_year_on_days'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_year_on_days'][0] : 1;
                    $repeat_when = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_list_yearly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_list_yearly'][0] : false;
                    $repeat_day = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_week_yearly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_week_yearly'][0] : false;
                    if (isset($metas[ECWD_PLUGIN_PREFIX . '_event_year_month'][0]) && $repeat_days == 2) {
                        $month = $metas[ECWD_PLUGIN_PREFIX . '_event_year_month'][0];
                        $monthName = date('F', strtotime('2015-' . $month . '-1'));
                    } else {
                        $monthName = date('F', strtotime($from_date));
                    }
                    $min_date = strtotime($event_from);
                    $max_date = strtotime($until);
                    $i = 0;
                    while (( $min_date = strtotime("+1 YEAR", $min_date) ) <= $max_date) {
                        $date = strtotime(date("Y-m-d", strtotime($event_from)) . " +" . $i * $how . " YEAR");
                        if ($i > 0) {
                            if ($repeat_days == 1) {
                                $monthyear = $monthName . ' ' . date("d Y", $date);
                                $repeat_date = strtotime(date('Y-m-d', strtotime($monthyear)));
                                $date = $repeat_date;
                            }
                            if ($repeat_days == 2 && $repeat_day && $repeat_when) {
                                $monthyear = $monthName . ' ' . date("Y", $date);
                                //echo $repeat_when.' '.ucfirst( $repeat_day ).' of '.$monthyear.'<br />';
                                $repeat_date = date('Y-m-d', strtotime($repeat_when . ' ' . ucfirst($repeat_day) . ' of ' . $monthyear));
                                if ($repeat_date == '1970-01-01' || $repeat_date == '1969-12-31') {
                                    $repeat_date = date('Y-m-d', strtotime($monthyear . ' ' . $repeat_when . ' ' . $repeat_day));
                                }
                                //$repeat_date = date( 'Y-m-d', strtotime($repeat_when.' '.ucfirst( $repeat_day ).' of '.$monthyear) );
                                //don't know why, but "last sunday,last monday... returns last s,m of previous month"
                                if ($repeat_when == 'last') {
                                    $repeat_date = date('Y-m-d', strtotime($repeat_when . ' ' . ucfirst($repeat_day) . ' of ' . $monthyear, strtotime("+1 MONTH", $repeat_date)));
                                }
                                $date = strtotime($repeat_date);
                            }
                        }
                        $date = date("Y-n-j", $date);

                        $i ++;
                        if (strtotime($until) >= strtotime(date('Y-m-t', strtotime($this->date))) && strtotime($date) <= strtotime($until)) {
                            $from_date = strtotime(( date("Y-m-d", ( strtotime($from_date))) . " +" . ( ( $how ) ) . " year"));
                            $from_date = strtotime(( date("Y-m-d", $from_date) . " - 1  day"));
                            $from_date = date('Y-m-d', $from_date);
                            $from = $date;
                            $to = strtotime(( date("Y-m-d", ( strtotime($from_date))) . " +" . ( $eventdayslong ) . " days"));
                            $to = date('Y-m-d', $to);

                            $eventdayslong = $eventdayslong_def;
                            if (isset($ecwd_options["long_events"]) && $ecwd_options["long_events"] == '1') {
                                $m1 = date('m', strtotime($to));
                                $m2 = date('m', strtotime($end_date));
                                if (strtotime($to) <= strtotime($this->end_date) || (strtotime($to) >= strtotime($this->end_date) && $m1 == $m2)) {
                                    if (strtotime($from) < strtotime($this->start_date)) {
                                        $diff = $this->dateDiff($date, $this->start_date);
                                        if ($diff > 0) {
                                            $eventdayslong -= $diff;
                                        }
                                        $date = $this->start_date;
                                    }
                                }
                            }

                            if (!$current_month || ( strtotime($date) <= strtotime($this->end_date) && strtotime($date) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($date))), $weekdays) )) {
                                $this->set_long_event($date, $from, $to);
                            }
                        }
                    }
                }
            } else {
                $eventdayslong = $this->dateDiff($from, $to); // get the difference in days between the two dates
                $date = strtotime(date("Y-m-d", strtotime($from)));
                $date = date("Y-n-j", $date);


                if (isset($ecwd_options["long_events"]) && $ecwd_options["long_events"] == '1') {
                    $m1 = date('m', strtotime($to));
                    $m2 = date('m', strtotime($end_date));
                    if (strtotime($to) <= strtotime($this->end_date) || (strtotime($to) >= strtotime($this->end_date) && $m1 == $m2)) {
                        if (strtotime($from) < strtotime($this->start_date)) {
                            $diff = $this->dateDiff($date, $this->start_date);
                            if ($diff > 0) {
                                $eventdayslong -= $diff;
                            }
                            $date = $this->start_date;
                        }
                    }
                }

                if (!$current_month || ( strtotime($date) <= strtotime($this->end_date) && strtotime($date) >= strtotime($this->start_date) && in_array(strtolower(date('l', strtotime($date))), $weekdays) )) {
                    $this->set_long_event($date, $from, $to);
                }
            }
        }


        if ($events) {
            if (is_array($this->events)) {
                ksort($this->events);
            }
            return $this->events;
        }
    }

    private function set_long_event($date, $from, $to) {
        global $ecwd_options;
        $event_data = $this->event_options;
        $event_data['date'] = $date;
        $event_data['from'] = $from;
        $event_data['to'] = $to;
        if ($event_data['permalink']) {
            $event_data['permalink'] = ECWD_Event::getLink($event_data['post'], $from);
        }

        if (isset($ecwd_options["long_events"]) && $ecwd_options["long_events"] == '1' &&
                !($this->display == 'posterboard' || $this->display == 'map')) {
            $long_to = $to;

            if (strtotime($long_to) > strtotime($this->end_date)) {
                $long_to = $this->end_date;
            }

            $date_for_diff = $date;
            if (strtotime($date_for_diff) < strtotime($this->start_date)) {
                $date_for_diff = $this->start_date;
            }
            $long_days = $this->dateDiff($date_for_diff, $long_to);

            for ($j = 0; $j <= $long_days; $j ++) {

                $long_from = strtotime(date("Y-m-d", strtotime($date)) . " + " . $j . " day");
                if (!isset($this->events[$long_from])) {
                    $this->events[$long_from] = array();
                }
                $event_data['date'] = date("Y-n-j", $long_from);
                $this->events[$long_from][$event_data['id']] = $event_data;
            }
        } else {
            if (!isset($this->events[strtotime($date)])) {
                $this->events[strtotime($date)] = array();
            }
            $this->events[strtotime($date)][$event_data['id']] = $event_data;
        }
    }

    private function set_event($date, $from, $to) {
        global $ecwd_options;
        $event_data = $this->event_options;
        $event_data['date'] = $date;
        $event_data['from'] = $from;
        $event_data['to'] = $to;
        if ($event_data['permalink']) {
            $event_data['permalink'] = ECWD_Event::getLink($event_data['post'], $from);
        }
        $this->events[] = $event_data;
    }

    function literalDate($timestamp, $weekday) {
        $timestamp = is_numeric($timestamp) ? $timestamp : strtotime($timestamp);
        $month = date('M', $timestamp);
        $ord = 0;

        while (date('M', ( $timestamp = strtotime('-1 week', $timestamp))) == $month) {
            $ord ++;
        }

        $lit = array('first', 'second', 'third', 'fourth', 'fifth');

        return strtolower($lit[$ord] . ' ' . $weekday);
    }

    /**
     * Return the calendar
     */
    public function get_view($date = '', $type = '', $widget = 0, $ecwd_views, $preview) {
        if(!empty($this->start_date)){
            $date = $this->start_date;
        }
        require_once 'calendar-class.php';
        $categories = get_categories(array('taxonomy' => ECWD_PLUGIN_PREFIX . '_event_category'));
        $tags = get_terms('ecwd_event_tag', array('hide_empty' => false));

        //Get events data
        //Generate the calendar markup and return it
        $cal = new Calendar($type, $date, '', $widget, $this->page_items, $this->page, $this->displays, $this->filters, $this->event_search, array(), $preview);
        $search_params = $this->search;
        if (is_array($search_params) && ( ( isset($search_params['query']) && $search_params['query'] !== '' ) || ( isset($search_params['category']) && $search_params['category'] > 0 ) || ( isset($search_params['tag']) && $search_params['tag'] > 0 ) ) || ( isset($search_params['venue']) && $search_params['venue'] > 0 ) || ( isset($search_params['organizer']) && $search_params['organizer'] > 0 )) {
            $cal->search_params = $this->search;
        }
        if ($categories) {
            $cal->add_terms('categories', $categories);
        }
        if ($tags) {
            $cal->add_terms('tags', $tags);
        }

        $args = array(
            'post_type' => ECWD_PLUGIN_PREFIX . '_venue',
            'post_status' => 'publish',
            'posts_per_page' => - 1,
            'ignore_sticky_posts' => 1
        );
        $venues = get_posts($args);
        if ($venues) {
            $cal->add_terms('venues', $venues);
        }
        $args = array(
            'post_type' => ECWD_PLUGIN_PREFIX . '_organizer',
            'post_status' => 'publish',
            'posts_per_page' => - 1,
            'ignore_sticky_posts' => 1
        );
        $organizers = get_posts($args);
        if ($organizers) {
            $cal->add_terms('organizers', $organizers);
        }
        if ($this->events) {
            $cal->addEvents($this->events);
        }

        return $cal->showcal();
    }

    public function get_countdown($event_id, $date = '', $display = '', $widget = '') {
        $next_event = null;
        $count_down_events = array();
        if ($this->events) {
            foreach ($this->events as $id => $event) {
                $start = strtotime($event['from'] . 'T' . $event['starttime']);
                if ($start >= strtotime(gmdate('Y-m-dTH:i'))) {
                    $count_down_events[$id] = $event;
                    $next_event = $count_down_events[$id];
                    break;
                }
            }
        } else {

            $ecwd_event = get_post($event_id);
            $term_metas = '';
            if ($ecwd_event) {
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

                $events[$ecwd_event->ID] = new ECWD_Event($ecwd_event->ID, '', $ecwd_event->post_title, $ecwd_event->post_content, $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_location'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_from'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_date_to'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_event_url'][0], $ecwd_event_metas[ECWD_PLUGIN_PREFIX . '_lat_long'][0], $permalink, $ecwd_event, $term_metas, $ecwd_event_metas);

                $this->merged_events = $events;
                //$this->merged_events += $events;
                $this->get_event_days('', 0);

                if ($this->events) {
                    foreach ($this->events as $id => $event) {
                        $start = strtotime($event['from'] . 'T' . $event['starttime']);
                        if ($start >= strtotime(gmdate('Y-m-dTH:i'))) {
                            $count_down_events[$id] = $event;
                            $next_event = $count_down_events[$id];
                            break;
                        }
                    }
                }
            }
        }

        return $next_event;
    }

    public function get_repeat_rate($event_id, $metas = '', $datefomat = 'Y-m-d') {
        $repeat_text = '';
        if (!$metas) {
            $metas = get_post_meta($event_id, '', true);
        }
        $from = $metas[ECWD_PLUGIN_PREFIX . '_event_date_from'][0];
        $days = array();
        if (isset($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0]) && $metas[ECWD_PLUGIN_PREFIX . '_event_day'][0] != '') {
            if (is_serialized($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0])) {
                $days = unserialize($metas[ECWD_PLUGIN_PREFIX . '_event_day'][0]);
            }
        } else {
            $days = array(strtolower(date('l', strtotime($from))));
        }
        if ($metas && isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0]) && $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] !== 'no_repeat' && $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] != '') {
            $how = ( isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_how'][0] : 1 );

            if ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'daily') {
                if ($how > 1) {
                    $repeat_text .= 'Repeat every ' . $how . ' days';
                } else {
                    $repeat_text .= 'Repeat every day';
                }
            } elseif ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'weekly') {
                if ($how > 1) {
                    $repeat_text .= 'Repeat every ' . $how . ' weeks';
                } else {
                    $repeat_text .= 'Repeat every week';
                }


                if (count($days) > 0) {
                    $repeat_text .= ' on ';
                    foreach ($days as $i => $day) {
                        $repeat_text .= ucfirst($day) . 's';
                        if ($i !== ( count($days) - 1 )) {
                            $repeat_text .= ',';
                        }
                        $repeat_text .= ' ';
                    }
                }
            } elseif ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'monthly') {
                if ($how > 1) {
                    $repeat_text .= 'Repeat every ' . $how . ' months';
                } else {
                    $repeat_text .= 'Repeat every month';
                }
                $repeat_days = isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_month_on_days'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_month_on_days'][0] : 1;

                if ($repeat_days == 1) {
                    $repeat_text .= ' on the same day';
                } else {
                    $repeat_when = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_list_monthly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_list_monthly'][0] : false;
                    $repeat_day = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_week_monthly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_week_monthly'][0] : false;
                    if ($repeat_when && $repeat_day) {
                        $repeat_text .= ' on the ' . ucfirst($repeat_when) . ' ' . ucfirst($repeat_day);
                    }
                }
            } elseif ($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_event'][0] == 'yearly') {
                if ($how > 1) {
                    $repeat_text .= 'Repeat every ' . $how . ' years';
                } else {
                    $repeat_text .= 'Repeat every year';
                }

                $repeat_days = isset($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_year_on_days'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_event_repeat_year_on_days'][0] : 1;
                if (isset($metas[ECWD_PLUGIN_PREFIX . '_event_year_month'][0])) {
                    $month = $metas[ECWD_PLUGIN_PREFIX . '_event_year_month'][0];
                    $monthName = date('F', strtotime('2015-' . $month . '-1'));
                } else {
                    $monthName = date('F', strtotime($from));
                }
                $repeat_text .= ' in ' . $monthName;
                if ($repeat_days == 1) {
                    $repeat_text .= ' on the same day';
                } else {
                    $repeat_when = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_list_yearly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_list_yearly'][0] : false;
                    $repeat_day = isset($metas[ECWD_PLUGIN_PREFIX . '_monthly_week_yearly'][0]) ? $metas[ECWD_PLUGIN_PREFIX . '_monthly_week_yearly'][0] : false;
                    if ($repeat_when && $repeat_day) {
                        $repeat_text .= ' on the ' . ucfirst($repeat_when) . ' ' . ucfirst($repeat_day);
                    }
                }
            }
            $repeat_text .= ' until ' . date($datefomat, strtotime($metas[ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until'][0]));
        }

        return $repeat_text;
    }

    function events_unique($array) {
        if (is_array($array) && !empty($array)) {
            $events_ids = array();
            foreach ($array as $key => $event) {
                if (!in_array($event['id'], $events_ids)) {
                    $events_ids[] = $event['id'];
                } else {
                    unset($array[$key]);
                }
            }
        }
        return $array;
    }

    public function arraySort($a, $subkey) {
        foreach ($a as $k => $v) {
            $b[$k] = strtotime($v[$subkey] . 'T' . $v['starttime']);
        }
        asort($b);
        foreach ($b as $key => $val) {
            $c[] = $a[$key];
        }

        return $c;
    }

    public function dateDiff($beginDate, $endDate) {
        if ($endDate == '') {
            return 0;
        }
        $fromDate = date('Y-n-j', strtotime($beginDate));
        $toDate = date('Y-n-j', strtotime($endDate));
        $date_parts1 = explode('-', $fromDate);
        $date_parts2 = explode('-', $toDate);

        $start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
        $end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);

        return $end_date - $start_date;
    }

}
