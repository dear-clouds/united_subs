<?php

if (function_exists('current_user_can')) {
  if (!current_user_can('manage_options')) {
    die('Access Denied');
  }
}

function add_spider_calendar() {
  html_add_spider_calendar();
}

function copy_spider_event($calendar_id, $id) {
    global $wpdb;
	$query = 'INSERT INTO `'.$wpdb->prefix . 'spidercalendar_event`(`calendar`, `date`, `date_end`, `title`, `category`, `time`, `text_for_date`, `userID`, `repeat_method`, `repeat`, `week`, `month`, `month_type`, `monthly_list`, `month_week`, `year_month`, `published`) SELECT `calendar`, `date`, `date_end`, `title`, `category`, `time`, `text_for_date`, `userID`, `repeat_method`, `repeat`, `week`, `month`, `month_type`, `monthly_list`, `month_week`, `year_month`, `published` FROM `'.$wpdb->prefix . 'spidercalendar_event` WHERE `id` = "'.$id.'"';
	if (!$wpdb->query($query)) {
    ?>
    <div id="message" class="error"><p>Event copy was not created.</p></div>
    <?php
  }
  else {
    ?>
    <div class="updated"><p><strong>Event successfully copied.</strong></p></div>
    <?php
  }
}

function spider_upcoming(){
if(isset($_GET['upcalendar_id']))
 $calendar_id=(int)$_GET['upcalendar_id'];
else $calendar_id="0";
 
	  global $wpdb;
  $order = " ORDER BY title ASC";
  $sort["default_style"] = "manage-column column-autor sortable desc";
  $sort["sortid_by"] = "title";
  $sort["custom_style"] = "manage-column column-title sorted asc";
  $sort["1_or_2"] = "2";
  if (isset($_POST['page_number'])) {
    if (esc_html($_POST['asc_or_desc']) && (esc_html($_POST['asc_or_desc']) == 1)) {
      if (isset($_POST['order_by'])) {
        $sort["sortid_by"] = esc_sql(esc_html($_POST['order_by']));
      }
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
      $limit = (esc_sql(esc_html(stripslashes($_POST['page_number'])))- 1) * 20;
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
    $where = ' AND ' . $wpdb->prefix . 'spidercalendar_event.title LIKE "%%' . like_escape($search_tag) . '%%"';
  }
  else {
    $where = '';
  }
  if (isset($_POST['startdate']) && esc_html($_POST['startdate'])) {
    $where .= ' AND ' . $wpdb->prefix . 'spidercalendar_event.date > \'' .  esc_sql(esc_html($_POST['startdate'])) . '\' ';
  }
  if (isset($_POST['enddate']) && esc_html($_POST['enddate'])) {
    $where .= ' AND ' . $wpdb->prefix . 'spidercalendar_event.date < \'' .  esc_sql(esc_html($_POST['enddate'])) . '\' ';
  }
  // Get the total number of records.

  $query = $wpdb->prepare ("SELECT COUNT(*) FROM " . $wpdb->prefix . "spidercalendar_event WHERE calendar=%d " . $where . " ",$calendar_id );
  
  $total = $wpdb->get_var($query);
  $pageNav['total'] = $total;
  $pageNav['limit'] = $limit / 20 + 1;
  
  $query =  $wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_event WHERE calendar=%d  " . $where . " " . $order . " " . " LIMIT %d,20",$calendar_id,$limit);

  $rows=$wpdb->get_results($query);

  
  html_upcoming_widget($rows, $pageNav, $sort);

}


function show_spider_calendar() {
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
    $where = ' ';
  }
  // Get the total number of records.
  $query = "SELECT COUNT(*) FROM " . $wpdb->prefix . "spidercalendar_calendar" . str_replace('%%','%',$where);
  $total = $wpdb->get_var($query);
  $pageNav['total'] = $total;
  $pageNav['limit'] = $limit / 20 + 1;
  $query = $wpdb->prepare ( "SELECT * FROM " . $wpdb->prefix . "spidercalendar_calendar" . $where . " " . $order . " " . " LIMIT  %d,20",$limit);
  $rows = $wpdb->get_results($query);
  // display function
  html_show_spider_calendar($rows, $pageNav, $sort);
}

function show_event_cat(){
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
  if (isset($_POST['search_cat_by_title'])) {
    $search_tag = esc_sql(esc_html(stripslashes($_POST['search_cat_by_title'])));
  }
  else {
    $search_tag = "";
  }
  if ($search_tag) {
    $where = ' WHERE title LIKE "%%' . like_escape($search_tag) . '%%"';
  }
  else {
    $where = ' ';
  }
  // Get the total number of records.
  $query = "SELECT COUNT(*) FROM " . $wpdb->prefix . "spidercalendar_event_category" . str_replace('%%','%',$where);
  $total = $wpdb->get_var($query);
  $pageNav['total'] = $total;
  $pageNav['limit'] = $limit / 20 + 1;
  $query =$wpdb->prepare ( "SELECT * FROM " . $wpdb->prefix . "spidercalendar_event_category" . $where . " " . $order . " " . " LIMIT %d,20",$limit);
  
  $rows = $wpdb->get_results($query);
  // display function
  show_event_category($rows, $pageNav, $sort);

}


// Edit calendar.
function edit_spider_calendar($id) {
  global $wpdb;
  $row = $wpdb->get_row($wpdb->prepare ('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_calendar WHERE id=%d',$id));
  html_edit_spider_calendar($row);
}

// Delete calendar.
function remove_spider_calendar($id) {
  global $wpdb;
  $sql_remov_vid = $wpdb->prepare ("DELETE FROM " . $wpdb->prefix . "spidercalendar_calendar WHERE id=%d", $id);
  $sql_remov_eve = $wpdb->prepare ("DELETE FROM " . $wpdb->prefix . "spidercalendar_event WHERE calendar=%d", $id);
  if (!$wpdb->query($sql_remov_vid)) {
    ?>
    <div id="message" class="error"><p>Calendar Not Deleted.</p></div>
    <?php
  }
  else {
    ?>
    <div class="updated"><p><strong>Calendar Deleted.</strong></p></div>
    <?php
    $count_eve = $wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'spidercalendar_event WHERE `calendar`="%d"', $id));
    if ($count_eve) {
      if (!$wpdb->query($sql_remov_eve)) {
        ?>
        <div id="message" class="error"><p>Events Not Deleted.</p></div>
        <?php
      }
    }
  }
}


//Save Category Event

function save_spider_category_event() {
  /*
  if (!$id) {
    echo '<h1 style="color:#00C">Error. ID does not exist.</h1>';
    exit;
  }
  */
  if(isset($_POST['title'])){
	  $title = (isset($_POST["title"]) ? esc_sql(esc_html(stripslashes($_POST["title"]))) : '');
	  $published = (isset($_POST["published"]) ? (int) $_POST["published"] : 1);
	  $color = (isset($_POST["color"]) ? esc_sql(esc_html(stripslashes($_POST["color"]))) : '');
	  $description = preg_replace('#<script(.*?)>(.*?)</script>#is', '', stripslashes($_POST["description"]));
	  global $wpdb;
	 
		$save_or_no = $wpdb->insert($wpdb->prefix . 'spidercalendar_event_category', array(
		  'id' => NULL,
		  'title' => $title,
		  'published' => $published,
		  'color' => $color,
		  'description' => $description,
		), array(
		  '%d',
		  '%s',
		  '%d',
		  '%s',
		  '%s'
		));
	}
}


// Publish/Unpublish category.
function spider_category_published($id) {
  global $wpdb;
  $publish = $wpdb->get_var($wpdb->prepare('SELECT published FROM ' . $wpdb->prefix . 'spidercalendar_event_category WHERE `id`="%d"', $id));
  if ($publish) {
    $publish = 0;
    $publish_unpublish = 'Category unpublished.';
  }
  else {
    $publish = 1;
    $publish_unpublish = 'Category published.';
  }
  $save_or_no = $wpdb->update($wpdb->prefix . 'spidercalendar_event_category', array(
      'published' => $publish,
    ), array('id' => $id), array(
      '%d',
    ));

  if ($save_or_no !== FALSE) {
    ?>
    <div class="updated"><p><strong><?php echo $publish_unpublish; ?></strong></p></div>
    <?php
  }
}


//Apply category event

function apply_spider_category_event($id) {

	  $title = (isset($_POST["title"]) ? esc_sql(esc_html(stripslashes($_POST["title"]))) : '');
	  $published = (isset($_POST["published"]) ? (int) $_POST["published"] : 1);
	  $color = (isset($_POST["color"]) ? esc_sql(esc_html(stripslashes($_POST["color"]))) : '');
	  $description = preg_replace('#<script(.*?)>(.*?)</script>#is', '', stripslashes($_POST["description"]));
	  global $wpdb;


    $save_or_no = $wpdb->update($wpdb->prefix . 'spidercalendar_event_category', array(
      'title' => $title,
      'published' => $published,
	  'color' => $color,
	  'description' => $description,
    ), array('id' => $_POST['id']), array(
      '%s',
      '%d',
      '%s',
      '%s'
    ));
 
}

// Save calendar.
function apply_spider_calendar($id) {
  if (!$id) {
    echo '<h1 style="color:#00C">Error. ID does not exist.</h1>';
    exit;
  }
if(isset($_POST['title'])){
  $title = (isset($_POST["title"]) ? esc_sql(esc_html(stripslashes($_POST["title"]))) : '');
  $user_type = (isset($_POST["user_type"]) ? esc_sql(esc_html(stripslashes($_POST["user_type"]))) : '');
  $time_format = (isset($_POST["time_format"]) ? (int) $_POST["time_format"] : 0);
  $def_year = (isset($_POST["def_year"]) ? esc_sql(esc_html(stripslashes($_POST["def_year"]))) : '');
  $def_month = (isset($_POST["def_month"]) ? esc_sql(esc_html(stripslashes($_POST["def_month"]))) : '');
  $def_zone = (isset($_POST["def_zone"]) ? esc_sql(esc_html(stripslashes($_POST["def_zone"]))) : '');
  $allow_publish = (isset($_POST["allow_publish"]) ? esc_sql(esc_html(stripslashes($_POST["allow_publish"]))) : '');
  $published = (isset($_POST["published"]) ? (int) $_POST["published"] : 1);
  global $wpdb;
  if ($id === -1) {
  
    $save_or_no = $wpdb->insert($wpdb->prefix . 'spidercalendar_calendar', array(
      'id' => NULL,
      'title' => $title,
      'gid' => $user_type,
      'def_year' => $def_year,
      'def_month' => $def_month,
	  'def_zone' => $def_zone,
      'time_format' => $time_format,
      'allow_publish' => $allow_publish,
      'published' => $published,
    ), array(
      '%d',
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
  
    $save_or_no = $wpdb->update($wpdb->prefix . 'spidercalendar_calendar', array(
      'title' => $title,
      'gid' => $user_type,
      'time_format' => $time_format,
      'def_year' => $def_year,
      'def_month' => $def_month,
	  'def_zone' => $def_zone,
      'allow_publish' => $allow_publish,
      'published' => $published,
    ), array('id' => $id), array(
      '%s',
      '%s',
      '%d',
      '%s',
	  '%s',
      '%s',
      '%s',
      '%d'
    ));
  }
  if ($save_or_no === FALSE) {
    ?>
    <div class="updated"><p><strong>Error. Please install plugin again.</strong></p></div>
    <?php
    return FALSE;
  }
  else {
    ?>
    <div class="updated"><p><strong>Calendar Saved.</strong></p></div>
    <?php
    return TRUE;
  }
  }
}

// Publish/Unpublish calendar.
function spider_calendar_published($id) {
  global $wpdb;
  $publish = $wpdb->get_var($wpdb->prepare('SELECT published FROM ' . $wpdb->prefix . 'spidercalendar_calendar WHERE `id`="%d"', $id));
  if ($publish) {
    $publish = 0;
    $publish_unpublish = 'Calendar unpublished.';
  }
  else {
    $publish = 1;
    $publish_unpublish = 'Calendar published.';
  }
  $save_or_no = $wpdb->update($wpdb->prefix . 'spidercalendar_calendar', array(
      'published' => $publish,
    ), array('id' => $id), array(
      '%d',
    ));
  if ($save_or_no !== FALSE) {
    ?>
    <div class="updated"><p><strong><?php echo $publish_unpublish; ?></strong></p></div>
    <?php
  }
}

// Event in table
function show_spider_event($calendar_id) {
global $wpdb;
  $order = " ORDER BY title ASC";
  $sort["default_style"] = "manage-column column-autor sortable desc";
  $sort["sortid_by"] = "title";
  $sort["custom_style"] = "manage-column column-title sorted asc";
  $sort["1_or_2"] = "2";
  if (isset($_POST['page_number'])) {
    if (isset($_POST['order_by']) && esc_html($_POST['order_by']) != '') {
      $sort["sortid_by"] =esc_sql(esc_html(stripslashes($_POST['order_by'])));
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
    $where = ' AND ' . $wpdb->prefix . 'spidercalendar_event.title LIKE "%%' . like_escape($search_tag) . '%%"';
  }
  else {
    $where = '';
  }
  if (isset($_POST['startdate']) && esc_html($_POST['startdate'])) {
    $where .= ' AND ' . $wpdb->prefix . 'spidercalendar_event.date > \'' . esc_sql(esc_html(stripslashes($_POST['startdate']))) . '\' ';
  }
  if (isset($_POST['enddate']) && $_POST['enddate']) {
    $where .= ' AND ' . $wpdb->prefix . 'spidercalendar_event.date < \'' .esc_sql(esc_html(stripslashes($_POST['enddate']))). '\' ';
  }
  // Get the total number of records.
  $query = $wpdb->prepare ("SELECT COUNT(*) FROM " . $wpdb->prefix . "spidercalendar_event WHERE calendar=%d " . $where . " ", $calendar_id);
  $total = $wpdb->get_var($query);
  $pageNav['total'] = $total;
  $pageNav['limit'] = $limit / 20 + 1;
  
  $query = $wpdb->prepare ("SELECT " . $wpdb->prefix . "spidercalendar_event.*, " . $wpdb->prefix . "spidercalendar_event_category.title as cattitle FROM " . $wpdb->prefix . "spidercalendar_event LEFT JOIN " . $wpdb->prefix . "spidercalendar_event_category ON " . $wpdb->prefix . "spidercalendar_event.category=" . $wpdb->prefix . "spidercalendar_event_category.id
	WHERE calendar=%d " . $where . " " . $order . " " . " LIMIT %d,20",$calendar_id,$limit);
 
  $rows = $wpdb->get_results($query);
  $cal_name = $wpdb->get_var($wpdb->prepare('SELECT title' . ' FROM ' . $wpdb->prefix . 'spidercalendar_calendar WHERE `id`="%d"', $calendar_id));
  html_show_spider_event($rows, $pageNav, $sort, $calendar_id, $cal_name);
}


// Add an event.
function add_spider_event($calendar_id) {
  global $wpdb;
  $cal_name = $wpdb->get_var($wpdb->prepare('SELECT title' . ' FROM ' . $wpdb->prefix . 'spidercalendar_calendar WHERE `id`="%d"', $calendar_id));
  html_add_spider_event($calendar_id, $cal_name);
}

// Edit event.
function edit_spider_event($calendar_id, $id) {
  global $wpdb;
  $row = $wpdb->get_row($wpdb->prepare ('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_event WHERE id=%d', $id ));
  $calendar = $row->calendar;
  $query = $wpdb->prepare ('SELECT title FROM ' . $wpdb->prefix . 'spidercalendar_calendar WHERE id=%d' , $calendar);
  $calendar_name = $wpdb->get_var($query);
  $cal_name = $wpdb->get_var($wpdb->prepare('SELECT title' . ' FROM ' . $wpdb->prefix . 'spidercalendar_calendar WHERE `id`="%d"', $calendar_id));
  html_edit_spider_event($row, $calendar_id, $id, $cal_name);
}

// Save event.
function apply_spider_event($calendar_id, $id) {
  global $wpdb;
  if(isset($_POST['title'])){
  $title = ((isset($_POST['title'])) ? esc_sql(esc_html(stripslashes($_POST['title']))) : '');
  $category = ((isset($_POST['category'])) ? esc_sql(esc_html(stripslashes($_POST['category']))) : ''); 
  $text_for_date = preg_replace('#<script(.*?)>(.*?)</script>#is', '', stripslashes($_POST["text_for_date"]));
  $published = ((isset($_POST['published'])) ? (int) $_POST['published'] : 1);
  $repeat = ((isset($_POST['repeat'])) ? esc_sql(esc_html(stripslashes($_POST['repeat']))) : '');
  $week = ((isset($_POST['week'])) ? esc_sql(esc_html(stripslashes($_POST['week']))) : '');
  $month = ((isset($_POST['month'])) ? esc_sql(esc_html(stripslashes($_POST['month']))) : '');
  $monthly_list = ((isset($_POST['monthly_list'])) ? esc_sql(esc_html(stripslashes($_POST['monthly_list']))) : '');
  $month_type = ((isset($_POST['month_type'])) ? esc_sql(esc_html(stripslashes($_POST['month_type']))) : '');
  $month_week = ((isset($_POST['month_week'])) ? esc_sql(esc_html(stripslashes($_POST['month_week']))) : '');
  $year_month = ((isset($_POST['year_month'])) ? esc_sql(esc_html(stripslashes($_POST['year_month']))) : '');
  $repeat_method = ((isset($_POST['repeat_method'])) ? esc_sql(esc_html(stripslashes($_POST['repeat_method']))) : 'no_repeat');
  $date = ((isset($_POST['date'])) ? esc_sql(esc_html(stripslashes($_POST['date']))) : '');
  $date_end = ((isset($_POST['date_end'])) ? esc_sql(esc_html(stripslashes($_POST['date_end']))) : '');
  if ($date_end == '' && $repeat_method != 'no_repeat') {
    $date_end = '2035-12-12';
  }
  $select_from = ((isset($_POST['select_from'])) ? esc_sql(esc_html(stripslashes($_POST['select_from']))) : '');
  $select_to = ((isset($_POST['select_to'])) ? esc_sql(esc_html(stripslashes($_POST['select_to']))) : '');
  $selhour_from = ((isset($_POST['selhour_from'])) ? esc_sql(esc_html(stripslashes($_POST['selhour_from']))) : '');
  $selhour_to = ((isset($_POST['selhour_to'])) ? esc_sql(esc_html(stripslashes($_POST['selhour_to']))) : '');
  $selminute_from = ((isset($_POST['selminute_from'])) ? esc_sql(esc_html(stripslashes($_POST['selminute_from']))) : '');
  $selminute_to = ((isset($_POST['selminute_to'])) ? esc_sql(esc_html(stripslashes($_POST['selminute_to']))) : '');
  if ($selhour_from) {
    if ($selhour_to) {
      $time = $selhour_from . ':' . $selminute_from . '' . $select_from . '-' . $selhour_to . ':' . $selminute_to . '' . $select_to;
    }
    else {
      $time = $selhour_from . ':' . $selminute_from . ' ' . $select_from;
    }
  }
  else {
    $time = '';
  }
  if ($id === -1) {
    $save = $wpdb->insert($wpdb->prefix . 'spidercalendar_event', array(
      'id' => NULL,
	  'category' => $category,
      'title' => $title,
      'time' => $time,
      'calendar' => $calendar_id,
      'date' => $date,
      'text_for_date' => $text_for_date,
      'published' => $published,
      'repeat' => $repeat,
      'week' => $week,
      'date_end' => $date_end,
      'month' => $month,
      'monthly_list' => $monthly_list,
      'month_week' => $month_week,
      'month_type' => $month_type,
      'year_month' => $year_month,
      'repeat_method' => $repeat_method,
      'userID' => ''
    ), array(
      '%d',
	  '%s',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
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
      '%s'
    ));
  }
  else {
    $save = $wpdb->update($wpdb->prefix . 'spidercalendar_event', array(
      'title' => $title,
	  'category' => $category,
      'time' => $time,
      'calendar' => $calendar_id,
      'date' => $date,
      'text_for_date' => $text_for_date,
      'published' => $published,
      'repeat' => $repeat,
      'week' => $week,
      'date_end' => $date_end,
      'month' => $month,
      'monthly_list' => $monthly_list,
      'month_type' => $month_type,
      'month_week' => $month_week,
      'year_month' => $year_month,
      'repeat_method' => $repeat_method
    ), array('id' => $id), array(
      '%s',
	  '%d',
      '%s',
      '%d',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s'
    ));
  }
  if ($save !== FALSE) {
    ?>
    <div class="updated"><p><strong>Item Saved.</strong></p></div>
    <?php
    return TRUE;
  }
  else {
    ?>
    <div class="updated"><p><strong>Error. Please install plugin again.</strong></p></div>
    <?php
    return FALSE;
  }
  }
}

// Publish/Unpublish event.
function published_spider_event($calendar_id, $id) {
  global $wpdb;
  $publish = $wpdb->get_var($wpdb->prepare('SELECT published FROM ' . $wpdb->prefix . 'spidercalendar_event WHERE `id`="%d"', $id));
  if ($publish) {
    $publish = 0;
    $publish_unpublish = 'Event unpublished.';
  }
  else {
    $publish = 1;
    $publish_unpublish = 'Event published.';
  }
  $save_or_no = $wpdb->update($wpdb->prefix . 'spidercalendar_event', array(
      'published' => $publish,
    ), array('id' => $id), array(
      '%d',
    ));
  if ($save_or_no !== FALSE) {
    ?>
    <div class="updated"><p><strong><?php echo $publish_unpublish; ?></strong></p></div>
    <?php
  }
  
}

// Delete event.
function remove_spider_event($calendar_id, $id) {
  global $wpdb;
  $sql_remove_vid = $wpdb->prepare ("DELETE FROM " . $wpdb->prefix . "spidercalendar_event WHERE id=%d" , $id );
  if (!$wpdb->query($sql_remove_vid)) {
    ?>
    <div id="message" class="error"><p>Event Not Deleted.</p></div>
    <?php
  }
  else {
    ?>
    <div class="updated"><p><strong>Event Deleted.</strong></p></div>
    <?php
  }
}


// Delete event.
function remove_category_event($id) {
  global $wpdb;
  $sql_remove_vid = $wpdb->prepare ("DELETE FROM " . $wpdb->prefix . "spidercalendar_event_category WHERE id=%d", $id );
  if (!$wpdb->query($sql_remove_vid)) {
    ?>
    <div id="message" class="error"><p>Event Category Not Deleted.</p></div>
    <?php
  }
  else {
    ?>
    <div class="updated"><p><strong>Event Category Deleted.</strong></p></div>
    <?php
  }
}
?>