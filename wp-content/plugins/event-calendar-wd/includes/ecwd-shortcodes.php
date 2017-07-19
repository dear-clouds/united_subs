<?php

/**
 * Shortcodes
 */

/**
 *  [ecwd_calendar] shortcode
 */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
function ecwd_shortcode($attr) {

    extract(shortcode_atts(array(
        'id' => null,
        'page_items' => '5',
        'event_search' => 'yes',
        'display' => 'full',
        'displays' => null,
        'filters' => null,
        'calendar_start_date' => null
    ), $attr, ECWD_PLUGIN_PREFIX.'_calendar'));

    // If no ID is specified then return
    if (empty($id)) {
        return;
    }
    $args = array('displays'=>$displays, 'filters'=>$filters, 'page_items'=>$page_items, 'event_search'=>$event_search);

    if($calendar_start_date !== null){
      $calendar_start_date = strtotime($calendar_start_date);
      if($calendar_start_date === false || $calendar_start_date === -1){
        $calendar_start_date = null;
      }
    }
    
    if($calendar_start_date !== null){
      $args['date'] = date('Y-m-d',$calendar_start_date);      
    }
    
    $calendar_ids = explode(',', str_replace(' ', '', $id));
    $result = ecwd_print_calendar($calendar_ids, $display, $args);
    return $result;
}

add_shortcode(ECWD_PLUGIN_PREFIX, ECWD_PLUGIN_PREFIX.'_shortcode');
