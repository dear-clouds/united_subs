<?php
if (!current_user_can('manage_options')) {
  die('Access Denied');
}
// function add_theme_calendar() {
  // global $wpdb;
  // html_add_theme();
// }

function show_theme_calendar() {
  global $wpdb;
  $order = " ORDER BY title ASC";
  $sort["default_style"] = "manage-column column-autor sortable desc";
  $sort["sortid_by"] = "title";
  $sort["custom_style"] = "manage-column column-title sorted asc";
  $sort["1_or_2"] = "2";
  if (isset($_POST['page_number'])) {
    if (isset($_POST['order_by']) && esc_html($_POST['order_by']) != '') {
      $sort["sortid_by"] = esc_sql(esc_html(stripslashes($_POST['order_by'])));
    }
    if (isset($_POST['asc_or_desc']) && (esc_html($_POST['asc_or_desc']) == 1)) {
      $sort["custom_style"] = "manage-column column-title sorted asc";
      $sort["1_or_2"] = "2";
      $order = "ORDER BY " . $sort["sortid_by"] . " ASC";
    }
    else {
      $sort["custom_style"] = "manage-column column-title sorted desc";
      $sort["1_or_2"] = "1";
      $order = "ORDER BY " . $sort["sortid_by"] . " DESC";
    }
    if (isset($_POST['page_number']) && (esc_html($_POST['page_number']))) {
      $limit = (esc_sql(esc_html(stripslashes($_POST['page_number']))) - 1) * 20;
    }
    else {
      $limit = 0;
    }
  }
  else {
    $limit = 0;
  }
  if (isset($_POST['search_events_by_title'])) {
    $search_tag = esc_sql(esc_html(stripslashes($_POST['search_events_by_title'])));
  }
  else {
    $search_tag = "";
  }
  if ($search_tag) {
    $where = ' WHERE title LIKE "%%' . like_escape($search_tag) . '%%"';
  }
  else {
    $where = '';
  }
  // get the total number of records
  $query = "SELECT COUNT(*) FROM " . $wpdb->prefix . "spidercalendar_theme" . str_replace('%%','%',$where);
  $total = $wpdb->get_var($query);
  $pageNav['total'] = $total;
  $pageNav['limit'] = $limit / 20 + 1;
  $query = $wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_theme" . $where . " " . $order . " " . " LIMIT %d,20",$limit);
  $rows = $wpdb->get_results( $query);
  html_show_theme_calendar($rows, $pageNav, $sort);
}

function apply_theme_calendar($id) {
  global $wpdb;
  $title = ((isset($_POST["title"])) ? esc_sql(esc_html(stripslashes($_POST["title"]))) : '');
  $width = ((isset($_POST["width"])) ? esc_sql(esc_html(stripslashes($_POST["width"]))) : '');
  $week_start_day = ((isset($_POST["week_start_day"])) ? esc_sql(esc_html(stripslashes($_POST["week_start_day"]))) : '');
  $border_color = ((isset($_POST["border_color"])) ? esc_sql(esc_html(stripslashes($_POST["border_color"]))) : '');
  $border_radius = ((isset($_POST["border_radius"])) ? esc_sql(esc_html(stripslashes($_POST["border_radius"]))) : '');
  $border_width = ((isset($_POST["border_width"])) ? esc_sql(esc_html(stripslashes($_POST["border_width"]))) : '');
  $show_cat = ((isset($_POST["show_cat"])) ? esc_sql(esc_html(stripslashes($_POST["show_cat"]))) : '');
  $top_height = ((isset($_POST["top_height"])) ? esc_sql(esc_html(stripslashes($_POST["top_height"]))) : '');
  $bg_top = ((isset($_POST["bg_top"])) ? esc_sql(esc_html(stripslashes($_POST["bg_top"]))) : '');
  $year_font_size = ((isset($_POST["year_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["year_font_size"]))) : '');
  $text_color_year = ((isset($_POST["text_color_year"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_year"]))) : '');
  $arrow_color_year = ((isset($_POST["arrow_color_year"])) ? esc_sql(esc_html(stripslashes($_POST["arrow_color_year"]))) : '');
  $month_type = ((isset($_POST["month_type"])) ? esc_sql(esc_html(stripslashes($_POST["month_type"]))) : '');
  $month_font_size = ((isset($_POST["month_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["month_font_size"]))) : '');
  $text_color_month = ((isset($_POST["text_color_month"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_month"]))) : '');
  $date_font = ((isset($_POST["date_font"])) ? esc_sql(esc_html(stripslashes($_POST["date_font"]))) : '');
  $date_style = ((isset($_POST["date_style"])) ? esc_sql(esc_html(stripslashes($_POST["date_style"]))) : '');
  $next_prev_event_bgcolor = ((isset($_POST["next_prev_event_bgcolor"])) ? esc_sql(esc_html(stripslashes($_POST["next_prev_event_bgcolor"]))) : '');
  $next_prev_event_arrowcolor = ((isset($_POST["next_prev_event_arrowcolor"])) ? esc_sql(esc_html(stripslashes($_POST["next_prev_event_arrowcolor"]))) : '');
  $show_event_bgcolor = ((isset($_POST["show_event_bgcolor"])) ? esc_sql(esc_html(stripslashes($_POST["show_event_bgcolor"]))) : '');
  $popup_width = ((isset($_POST["popup_width"])) ? esc_sql(esc_html(stripslashes($_POST["popup_width"]))) : '');
  $popup_height = ((isset($_POST["popup_height"])) ? esc_sql(esc_html(stripslashes($_POST["popup_height"]))) : '');
  $number_of_shown_evetns = ((isset($_POST["number_of_shown_evetns"])) ? esc_sql(esc_html(stripslashes($_POST["number_of_shown_evetns"]))) : '');
  $show_repeat = ((isset($_POST["show_repeat"])) ? esc_sql(esc_html(stripslashes($_POST["show_repeat"]))) : '');
  $day_start = ((isset($_POST["show_event"])) ? esc_sql(esc_html(stripslashes($_POST["show_event"]))) : '');
  $views_tabs_font_size = ((isset($_POST["views_tabs_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["views_tabs_font_size"]))) : '');
  $views_tabs_text_color = ((isset($_POST["views_tabs_text_color"])) ? esc_sql(esc_html(stripslashes($_POST["views_tabs_text_color"]))) : '');
  $views_tabs_bg_color = ((isset($_POST["views_tabs_bg_color"])) ? esc_sql(esc_html(stripslashes($_POST["views_tabs_bg_color"]))) : '');
  $day_month_font_color = ((isset($_POST["day_month_font_color"])) ? esc_sql(esc_html(stripslashes($_POST["day_month_font_color"]))) : '');
  $week_font_color = ((isset($_POST["week_font_color"])) ? esc_sql(esc_html(stripslashes($_POST["week_font_color"]))) : '');
  $day_month_font_size = ((isset($_POST["day_month_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["day_month_font_size"]))) : '');
  $week_font_size = ((isset($_POST["week_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["week_font_size"]))) : '');
  $ev_title_bg_color = ((isset($_POST["ev_title_bg_color"])) ? esc_sql(esc_html(stripslashes($_POST["ev_title_bg_color"]))) : '');
  $date_height = ((isset($_POST["date_height"])) ? esc_sql(esc_html(stripslashes($_POST["date_height"]))) : '');
  $event_table_height = ((isset($_POST["event_table_height"])) ? esc_sql(esc_html(stripslashes($_POST["event_table_height"]))) : '');
  $event_num_font_size = ((isset($_POST["event_num_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["event_num_font_size"]))) : '');
  $date_font_size = ((isset($_POST["date_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["date_font_size"]))) : '');
  $event_num_color = ((isset($_POST["event_num_color"])) ? esc_sql(esc_html(stripslashes($_POST["event_num_color"]))) : '');
  $event_num_bg_color2 = ((isset($_POST["event_num_bg_color2"])) ? esc_sql(esc_html(stripslashes($_POST["event_num_bg_color2"]))) : '');
  $event_num_bg_color1 = ((isset($_POST["event_num_bg_color1"])) ? esc_sql(esc_html(stripslashes($_POST["event_num_bg_color1"]))) : '');
  $event_bg_color2 = ((isset($_POST["event_bg_color2"])) ? esc_sql(esc_html(stripslashes($_POST["event_bg_color2"]))) : '');
  $event_bg_color1 = ((isset($_POST["event_bg_color1"])) ? esc_sql(esc_html(stripslashes($_POST["event_bg_color1"]))) : '');
  $date_bg_color = ((isset($_POST["date_bg_color"])) ? esc_sql(esc_html(stripslashes($_POST["date_bg_color"]))) : '');
  if ($id === -1) {
    $save_or_no = $wpdb->insert($wpdb->prefix . 'spidercalendar_theme', array(
      'id' => NULL,
      'title' => $title,
      'width' => $width,
      'week_start_day' => $week_start_day,
      'border_color' => $border_color,
      'border_radius' => $border_radius,
      'border_width' => $border_width,
	  'show_cat' => $show_cat,
      'top_height' => $top_height,
      'bg_top' => $bg_top,
      'year_font_size' => $year_font_size,
      'text_color_year' => $text_color_year,
      'arrow_color_year' => $arrow_color_year,
      'month_type' => $month_type,
      'month_font_size' => $month_font_size,
      'text_color_month' => $text_color_month,
      'arrow_color_month' => $arrow_color_month,
      'next_month_text_color' => $next_month_text_color,
      'next_month_font_size' => $next_month_font_size,
      'next_month_arrow_color' => $next_month_arrow_color,
      'prev_month_text_color' => $prev_month_text_color,
      'prev_month_font_size' => $prev_month_font_size,
      'prev_month_arrow_color' => $prev_month_arrow_color,
      'arrow_size' => $arrow_size,
      'text_color_week_days' => $text_color_week_days,
      'week_days_cell_height' => $week_days_cell_height,
      'weekdays_bg_color' => $weekdays_bg_color,
      'weekday_sunday_bg_color' => $weekday_sunday_bg_color,
      'weekdays_font_size' => $weekdays_font_size,
      'bg_bottom' => $bg_bottom,
      'cell_height' => $cell_height,
      'text_color_other_months' => $text_color_other_months,
      'bg_color_other_months' => $bg_color_other_months,
      'text_color_this_month_unevented' => $text_color_this_month_unevented,
      'text_color_this_month_evented' => $text_color_this_month_evented,
      'bg_color_this_month_evented' => $bg_color_this_month_evented,
      'event_title_color' => $event_title_color,
      'current_day_border_color' => $current_day_border_color,
      'cell_border_color' => $cell_border_color,
      'text_color_sun_days' => $text_color_sun_days,
      'sundays_bg_color' => $sundays_bg_color,
      'sundays_font_size' => $sundays_font_size,
      'other_days_font_size' => $other_days_font_size,
      'show_time' => $show_time,
      'date_format' => $date_format,
      'title_color' => $title_color,
      'title_font_size' => $title_font_size,
      'title_font' => $title_font,
      'title_style' => $title_style,
      'date_color' => $date_color,
      'date_size' => $date_size,
      'date_font' => $date_font,
      'date_style' => $date_style,
      'next_prev_event_bgcolor' => $next_prev_event_bgcolor,
      'next_prev_event_arrowcolor' => $next_prev_event_arrowcolor,
      'show_event_bgcolor' => $show_event_bgcolor,
      'popup_width' => $popup_width,
      'popup_height' => $popup_height,
      'number_of_shown_evetns' => $number_of_shown_evetns,
      'show_repeat' => $show_repeat,
      'day_start' => $show_event,
      'views_tabs_font_size' => $views_tabs_font_size,
      'views_tabs_text_color' => $views_tabs_text_color,
      'views_tabs_bg_color' => $views_tabs_bg_color,
      'day_month_font_color' => $day_month_font_color,
      'week_font_color' => $week_font_color,
      'day_month_font_size' => $day_month_font_size,
      'week_font_size' => $week_font_size,
      'ev_title_bg_color' => $ev_title_bg_color,
      'date_height' => $date_height,
      'event_table_height' => $event_table_height,
      'event_num_font_size' => $event_num_font_size,
      'date_font_size' => $date_font_size,
      'event_num_color' => $event_num_color,
      'event_num_bg_color2' => $event_num_bg_color2,
      'event_num_bg_color1' => $event_num_bg_color1,
      'event_bg_color2' => $event_bg_color2,
      'event_bg_color1' => $event_bg_color1,
      'date_bg_color' => $date_bg_color,
      'day_start' => $show_event,
    ), array(
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
	  '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
	  '%d'
    ));
  }
  else {
    $save_or_no = $wpdb->update($wpdb->prefix . 'spidercalendar_theme', array(
      'title' => $title,
      'width' => $width,
      'week_start_day' => $week_start_day,
      'border_color' => $border_color,
      'border_radius' => $border_radius,
      'border_width' => $border_width,
      'top_height' => $top_height,
      'bg_top' => $bg_top,
      'year_font_size' => $year_font_size,
      'text_color_year' => $text_color_year,
      'arrow_color_year' => $arrow_color_year,
      'month_type' => $month_type,
      'month_font_size' => $month_font_size,
      'text_color_month' => $text_color_month,
      'arrow_color_month' => $arrow_color_month,
      'next_month_text_color' => $next_month_text_color,
      'next_month_font_size' => $next_month_font_size,
      'next_month_arrow_color' => $next_month_arrow_color,
      'prev_month_text_color' => $prev_month_text_color,
      'prev_month_font_size' => $prev_month_font_size,
      'prev_month_arrow_color' => $prev_month_arrow_color,
      'arrow_size' => $arrow_size,
      'text_color_week_days' => $text_color_week_days,
      'week_days_cell_height' => $week_days_cell_height,
      'weekdays_bg_color' => $weekdays_bg_color,
      'weekday_sunday_bg_color' => $weekday_sunday_bg_color,
      'weekdays_font_size' => $weekdays_font_size,
      'bg_bottom' => $bg_bottom,
      'cell_height' => $cell_height,
      'text_color_other_months' => $text_color_other_months,
      'bg_color_other_months' => $bg_color_other_months,
      'text_color_this_month_unevented' => $text_color_this_month_unevented,
      'text_color_this_month_evented' => $text_color_this_month_evented,
      'bg_color_this_month_evented' => $bg_color_this_month_evented,
      'event_title_color' => $event_title_color,
      'current_day_border_color' => $current_day_border_color,
      'cell_border_color' => $cell_border_color,
      'text_color_sun_days' => $text_color_sun_days,
      'sundays_bg_color' => $sundays_bg_color,
      'sundays_font_size' => $sundays_font_size,
      'other_days_font_size' => $other_days_font_size,
      'show_time' => $show_time,
      'date_format' => $date_format,
      'title_color' => $title_color,
      'title_font_size' => $title_font_size,
      'title_font' => $title_font,
      'title_style' => $title_style,
      'date_color' => $date_color,
      'date_size' => $date_size,
      'date_font' => $date_font,
      'date_style' => $date_style,
      'next_prev_event_bgcolor' => $next_prev_event_bgcolor,
      'next_prev_event_arrowcolor' => $next_prev_event_arrowcolor,
      'show_event_bgcolor' => $show_event_bgcolor,
      'popup_width' => $popup_width,
      'popup_height' => $popup_height,
      'number_of_shown_evetns' => $number_of_shown_evetns,
      'show_repeat' => $show_repeat,
      'day_start' => $show_event,
      'views_tabs_font_size' => $views_tabs_font_size,
      'views_tabs_text_color' => $views_tabs_text_color,
      'views_tabs_bg_color' => $views_tabs_bg_color,
      'day_month_font_color' => $day_month_font_color,
      'week_font_color' => $week_font_color,
      'day_month_font_size' => $day_month_font_size,
      'week_font_size' => $week_font_size,
      'ev_title_bg_color' => $ev_title_bg_color,
      'date_height' => $date_height,
      'event_table_height' => $event_table_height,
      'event_num_font_size' => $event_num_font_size,
      'date_font_size' => $date_font_size,
      'event_num_color' => $event_num_color,
      'event_num_bg_color2' => $event_num_bg_color2,
      'event_num_bg_color1' => $event_num_bg_color1,
      'event_bg_color2' => $event_bg_color2,
      'event_bg_color1' => $event_bg_color1,
      'date_bg_color' => $date_bg_color,
      'day_start' => $show_event,
	  'show_cat' => $show_cat,
      ), array('id' => $id), array(
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
		'%d',
      ), array('%d'));
  }
  if ($save_or_no === FALSE) {
    ?>
    <div class="updated"><p><strong>Error. Please install plugin again.</strong></p></div>
    <?php
    return FALSE;
  }
  else {
    ?>
    <div class="updated"><p><strong>Theme Saved.</strong></p></div>
    <?php
    return TRUE;
  }
}

function edit_theme_calendar($id) {
  global $wpdb;
  if ($id == 0) {
    $row = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme WHERE id=1');
  }
  else {
    $row = $wpdb->get_row($wpdb->prepare ('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme WHERE id=%d' , $id ));
  }
  html_edit_theme_calendar($row, $id);
}

function remove_theme_calendar($id) {
  if ($id > 0 && $id < 18) {
    ?>
    <div id="message" class="error"><p>You can't delete deafult theme.</p></div>
    <?php
    return FALSE;
  }
  global $wpdb;
  $sql_remove_tag = $wpdb->prepare ( "DELETE FROM " . $wpdb->prefix . "spidercalendar_theme WHERE id=%d", $id );
  if (!$wpdb->query($sql_remove_tag)) {
    ?>
    <div id="message" class="error"><p>Spider Calendar Theme Not Deleted</p></div>
    <?php
  }
  else {
    ?>
    <div class="updated"><p><strong>Item Deleted.</strong></p></div>
    <?php
  }
}

?>