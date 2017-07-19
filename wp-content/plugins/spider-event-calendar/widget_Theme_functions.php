<?php
if (!current_user_can('manage_options')) {
  die('Access Denied');
}
function add_theme_calendar_widget() {
  global $wpdb;
  html_add_theme_widget();
}

function show_theme_calendar_widget() {
  global $wpdb;
  $order = " ORDER BY title ASC";
  $sort["default_style"] = "manage-column column-autor sortable desc";
  $sort["sortid_by"] = "title";
  $sort["custom_style"] = "manage-column column-title sorted asc";
  $sort["1_or_2"] = "2";
  if (isset($_POST['page_number'])) {
    if (isset($_POST['order_by']) && $_POST['order_by'] != '') {
      $sort["sortid_by"] =esc_sql( $_POST['order_by']);
    }
    if (isset($_POST['asc_or_desc']) && ($_POST['asc_or_desc'] == 1)) {
      $sort["custom_style"] = "manage-column column-title sorted asc";
      $sort["1_or_2"] = "2";
      $order = "ORDER BY " . $sort["sortid_by"] . " ASC";
    }
    else {
      $sort["custom_style"] = "manage-column column-title sorted desc";
      $sort["1_or_2"] = "1";
      $order = "ORDER BY " . $sort["sortid_by"] . " DESC";
    }
    if ($_POST['page_number']) {
      $limit = ($_POST['page_number'] - 1) * 20;
    }
    else {
      $limit = 0;
    }
  }
  else {
    $limit = 0;
  }
  if (isset($_POST['search_events_by_title'])) {
    $search_tag = $_POST['search_events_by_title'];
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
  // Get the total number of records.
  $query = "SELECT COUNT(*) FROM " . $wpdb->prefix . "spidercalendar_widget_theme" . str_replace('%%','%',$where);
  $total = $wpdb->get_var($query);
  $pageNav['total'] = $total;
  $pageNav['limit'] = $limit / 20 + 1;
  $query = $wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_widget_theme" . $where . " " . $order . " " . " LIMIT %d,20", $limit);
  $rows = $wpdb->get_results($query);
  html_show_theme_calendar_widget($rows, $pageNav, $sort);
}

function apply_theme_calendar_widget($id) {
  global $wpdb;
  $title = ((isset($_POST["title"])) ? esc_sql(esc_html(stripslashes($_POST["title"]))) : '');
  $ev_title_color = ((isset($_POST["ev_title_color"])) ? esc_sql(esc_html(stripslashes($_POST["ev_title_color"]))) : '');
  $width = ((isset($_POST["width"])) ? esc_sql(esc_html(stripslashes($_POST["width"]))) : '');
  $week_start_day = ((isset($_POST["week_start_day"])) ? esc_sql(esc_html(stripslashes($_POST["week_start_day"]))) : '');
  $font_year = ((isset($_POST["font_year"])) ? esc_sql(esc_html(stripslashes($_POST["font_year"]))) : '');
  $font_month = ((isset($_POST["font_month"])) ? esc_sql(esc_html(stripslashes($_POST["font_month"]))) : '');
  $font_day = ((isset($_POST["font_day"])) ? esc_sql(esc_html(stripslashes($_POST["font_day"]))) : '');
  $font_weekday = ((isset($_POST["font_weekday"])) ? esc_sql(esc_html(stripslashes($_POST["font_weekday"]))) : '');
  $header_bgcolor = ((isset($_POST["header_bgcolor"])) ? esc_sql(esc_html(stripslashes($_POST["header_bgcolor"]))) : '');
  $footer_bgcolor = ((isset($_POST["footer_bgcolor"])) ? esc_sql(esc_html(stripslashes($_POST["footer_bgcolor"]))) : '');
  $text_color_month = ((isset($_POST["text_color_month"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_month"]))) : '');
  $text_color_week_days = ((isset($_POST["text_color_week_days"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_week_days"]))) : '');
  $text_color_other_months = ((isset($_POST["text_color_other_months"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_other_months"]))) : '');
  $text_color_this_month_unevented = ((isset($_POST["text_color_this_month_unevented"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_this_month_unevented"]))) : '');
  $text_color_this_month_evented = ((isset($_POST["text_color_this_month_evented"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_this_month_evented"]))) : '');
  $bg_color_this_month_evented = ((isset($_POST["bg_color_this_month_evented"])) ? esc_sql(esc_html(stripslashes($_POST["bg_color_this_month_evented"]))) : '');
  $bg_color_selected = ((isset($_POST["bg_color_selected"])) ? esc_sql(esc_html(stripslashes($_POST["bg_color_selected"]))) : '');
  $arrow_color = ((isset($_POST["arrow_color"])) ? esc_sql(esc_html(stripslashes($_POST["arrow_color"]))) : '');
  $text_color_selected = ((isset($_POST["text_color_selected"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_selected"]))) : '');
  $border_day = ((isset($_POST["border_day"])) ? esc_sql(esc_html(stripslashes($_POST["border_day"]))) : '');
  $text_color_sun_days = ((isset($_POST["text_color_sun_days"])) ? esc_sql(esc_html(stripslashes($_POST["text_color_sun_days"]))) : '');
  $weekdays_bg_color = ((isset($_POST["weekdays_bg_color"])) ? esc_sql(esc_html(stripslashes($_POST["weekdays_bg_color"]))) : '');
  $su_bg_color = ((isset($_POST["su_bg_color"])) ? esc_sql(esc_html(stripslashes($_POST["su_bg_color"]))) : '');
  $cell_border_color = ((isset($_POST["cell_border_color"])) ? esc_sql(esc_html(stripslashes($_POST["cell_border_color"]))) : '');
  $year_font_size = ((isset($_POST["year_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["year_font_size"]))) : '');
  $year_font_color = ((isset($_POST["year_font_color"])) ? esc_sql(esc_html(stripslashes($_POST["year_font_color"]))) : '');
  $year_tabs_bg_color = ((isset($_POST["year_tabs_bg_color"])) ? esc_sql(esc_html(stripslashes($_POST["year_tabs_bg_color"]))) : '');
  $show_cat = ((isset($_POST["show_cat"])) ? esc_sql(esc_html(stripslashes($_POST["show_cat"]))) : '');
  $date_format = ((isset($_POST["date_format"])) ? esc_sql(esc_html(stripslashes($_POST["date_format"]))) : '');
  $title_color = ((isset($_POST["title_color"])) ? esc_sql(esc_html(stripslashes($_POST["title_color"]))) : '');
  $title_font_size = ((isset($_POST["title_font_size"])) ? esc_sql(esc_html(stripslashes($_POST["title_font_size"]))) : '');
  $title_font = ((isset($_POST["title_font"])) ? esc_sql(esc_html(stripslashes($_POST["title_font"]))) : '');
  $title_style = ((isset($_POST["title_style"])) ? esc_sql(esc_html(stripslashes($_POST["title_style"]))) : '');
  $date_color = ((isset($_POST["date_color"])) ? esc_sql(esc_html(stripslashes($_POST["date_color"]))) : '');
  $date_size = ((isset($_POST["date_size"])) ? esc_sql(esc_html(stripslashes($_POST["date_size"]))) : '');
  $date_font = ((isset($_POST["date_font"])) ? esc_sql(esc_html(stripslashes($_POST["date_font"]))) : '');
  $date_style = ((isset($_POST["date_style"])) ? esc_sql(esc_html(stripslashes($_POST["date_style"]))) : '');
  $next_prev_event_bgcolor = ((isset($_POST["next_prev_event_bgcolor"])) ? esc_sql(esc_html(stripslashes($_POST["next_prev_event_bgcolor"]))) : '');
  $next_prev_event_arrowcolor = ((isset($_POST["next_prev_event_arrowcolor"])) ? esc_sql(esc_html(stripslashes($_POST["next_prev_event_arrowcolor"]))) : '');
  $show_event_bgcolor = ((isset($_POST["show_event_bgcolor"])) ? esc_sql(esc_html(stripslashes($_POST["show_event_bgcolor"]))) : '');
  $popup_width = ((isset($_POST["popup_width"])) ? esc_sql(esc_html(stripslashes($_POST["popup_width"]))) : '');
  $popup_height = ((isset($_POST["popup_height"])) ? esc_sql(esc_html(stripslashes($_POST["popup_height"]))) : '');
  $show_repeat = ((isset($_POST["show_repeat"])) ? esc_sql(esc_html(stripslashes($_POST["show_repeat"]))) : '');
  if ($id === -1) {
    $save_or_no = $wpdb->insert($wpdb->prefix . 'spidercalendar_widget_theme', array(
      'id' => NULL,
      'title' => $title,
	  'ev_title_color' => $ev_title_color,
      'width' => $width,
      'week_start_day' => $week_start_day,
      'font_year' => $font_year,
      'font_month' => $font_month,
      'font_day' => $font_day,
      'font_weekday' => $font_weekday,
      'header_bgcolor' => $header_bgcolor,
      'footer_bgcolor' => $footer_bgcolor,
      'text_color_month' => $text_color_month,
      'text_color_week_days' => $text_color_week_days,
      'text_color_other_months' => $text_color_other_months,
      'text_color_this_month_unevented' => $text_color_this_month_unevented,
      'text_color_this_month_evented' => $text_color_this_month_evented,
      'bg_color_this_month_evented' => $bg_color_this_month_evented,
      'bg_color_selected' => $bg_color_selected,
      'arrow_color' => $arrow_color,
      'text_color_selected' => $text_color_selected,
      'border_day' => $border_day,
      'text_color_sun_days' => $text_color_sun_days,
      'weekdays_bg_color' => $weekdays_bg_color,
      'su_bg_color' => $su_bg_color,
      'cell_border_color' => $cell_border_color,
      'year_font_size' => $year_font_size,
      'year_font_color' => $year_font_color,
      'year_tabs_bg_color' => $year_tabs_bg_color,
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
      'show_repeat' => $show_repeat,
	  'show_cat' => $show_cat,
    ), array(
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
	  '%d'
    ));
  }
  else {
    $save_or_no = $wpdb->update($wpdb->prefix . 'spidercalendar_widget_theme', array(
      'title' => $title,
	  'ev_title_color' => $ev_title_color,
      'width' => $width,
      'week_start_day' => $week_start_day,
      'font_year' => $font_year,
      'font_month' => $font_month,
      'font_day' => $font_day,
      'font_weekday' => $font_weekday,
      'header_bgcolor' => $header_bgcolor,
      'footer_bgcolor' => $footer_bgcolor,
      'text_color_month' => $text_color_month,
      'text_color_week_days' => $text_color_week_days,
      'text_color_other_months' => $text_color_other_months,
      'text_color_this_month_unevented' => $text_color_this_month_unevented,
      'text_color_this_month_evented' => $text_color_this_month_evented,
      'bg_color_this_month_evented' => $bg_color_this_month_evented,
      'bg_color_selected' => $bg_color_selected,
      'arrow_color' => $arrow_color,
      'text_color_selected' => $text_color_selected,
      'border_day' => $border_day,
      'text_color_sun_days' => $text_color_sun_days,
      'weekdays_bg_color' => $weekdays_bg_color,
      'su_bg_color' => $su_bg_color,
      'cell_border_color' => $cell_border_color,
      'year_font_size' => $year_font_size,
      'year_font_color' => $year_font_color,
      'year_tabs_bg_color' => $year_tabs_bg_color,
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
      'show_repeat' => $show_repeat,
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
		'%d'
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
    <div class="updated"><p><strong>Widget Theme Saved.</strong></p></div>
    <?php
    return TRUE;
  }
}

function edit_theme_calendar_widget($id) {
  global $wpdb;
  if ($id == 0) {
    $row = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_widget_theme WHERE id=1');
  }
  else {
    $row = $wpdb->get_row($wpdb->prepare ('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_widget_theme WHERE id=%d' , $id ));
  }
  html_edit_theme_calendar_widget($row, $id);
}

function remove_theme_calendar_widget($id) {
  if ($id > 0 && $id < 7) {
    ?>
    <div id="message" class="error"><p>You can't delete deafult theme.</p></div>
    <?php
    return FALSE;
  }
  global $wpdb;
  $sql_remove_tag = $wpdb->prepare ("DELETE FROM " . $wpdb->prefix . "spidercalendar_widget_theme WHERE id=%d", $id );
  if (!$wpdb->query($sql_remove_tag)) {
    ?>
    <div id="message" class="error"><p>Spider Calendar Theme Not Deleted.</p></div>
    <?php
  }
  else {
    ?>
    <div class="updated"><p><strong>Item Deleted.</strong></p></div>
    <?php
  }
}
?>