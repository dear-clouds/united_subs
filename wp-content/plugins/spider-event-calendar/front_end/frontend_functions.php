<?php

function IsDate_inputed($str) {
  if (is_array($str)) {
    return;
  }
  $stamp = strtotime($str);
  if (!is_numeric($stamp)) {
    return FALSE;
  }
  $month = date('m', $stamp);
  $day = date('d', $stamp);
  $year = date('Y', $stamp);
  if (checkdate($month, $day, $year)) {
    return TRUE;
  }
  return FALSE;
}
function php_Month_num($month_name) {
  for ($month_num = 1; $month_num <= 12; $month_num++) {
    if (date("F", mktime(0, 0, 0, $month_num, 1, 0)) == $month_name) {
      if ($month_num < 10) {
        return '0' . $month_num;
      }
      else {
        return $month_num;
      }
    }
  }
}

function php_GetNextDate($beginDate, $repeat) {
  return date('n/j/Y',strtotime($beginDate.' +'.$repeat.' day'));
}

function php_daysDifference($beginDate, $endDate) {
  //explode the date by "-" and storing to array
  $date_parts1 = explode("-", $beginDate);
  $date_parts2 = explode("-", $endDate);
  //gregoriantojd() Converts a Gregorian date to Julian Day Count
  $start_date = mktime(0,0,0,$date_parts1[1], $date_parts1[2], $date_parts1[0]);
  $end_date = mktime(0,0,0,$date_parts2[1], $date_parts2[2], $date_parts2[0]);
  $diff= floor(($end_date - $start_date)/86400);
  return $diff;
}

function php_getdays($show_numbers_for_events, $calendar, $date, $theme_id, $widget) {
  global $wpdb;
  $row =  $wpdb->get_row($wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_calendar where published=1 and id=%d",$calendar)); 
  date_default_timezone_set ($row->def_zone);
  $year = substr($date, 0, 4);
  $month = substr($date, 5, 2);
  if ($widget) {
    $show_time = 0;
	$day_start = 0;
  }
  else {
    $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme WHERE id=%d', $theme_id));
    $show_time = $theme->show_time;
	$day_start = $theme->day_start;
  }

  $cat_id = (isset($_GET['cat_id']) ? esc_html($_GET['cat_id']) : '');
  $cat_ids = (isset($_GET['cat_ids']) ? esc_html($_GET['cat_ids']) : '');


if($cat_ids=='')
$cat_ids .= $cat_id.',';
else
$cat_ids .= ','.$cat_id.',';



$cat_ids = substr($cat_ids, 0,-1);

$cat_ids_array = explode(',',$cat_ids);


if($cat_id!='')
{

if(getelementcountinarray($cat_ids_array,$cat_id )%2==0)
{
$index_in_line = getelementindexinarray($cat_ids_array, $cat_id);
$index_array = explode(',' , $index_in_line);
array_pop ($index_array);
for($j=0; $j<count($index_array); $j++)
unset($cat_ids_array[$index_array[$j]]);
$cat_ids = implode(',',$cat_ids_array);
}
}
else
$cat_ids = substr($cat_ids, 0,-1);

	if($row->time_format==0)
	 {
		$order_by = "ORDER BY " . $wpdb->prefix . "spidercalendar_event.time ASC";
	 }
	 else{
		$order_by = " ORDER BY STR_TO_DATE( SUBSTRING( time, 1, 7 ) ,  '%h:%i%p' )";
	 }
	
  if($cat_ids!='' and preg_match("/^[0-9\,]+$/", $cat_ids)) {  
			$query = $wpdb->prepare ("SELECT " . $wpdb->prefix . "spidercalendar_event.*," . $wpdb->prefix . "spidercalendar_event_category.color  from " . $wpdb->prefix . "spidercalendar_event JOIN " . $wpdb->prefix . "spidercalendar_event_category ON " . $wpdb->prefix . "spidercalendar_event.category = " . $wpdb->prefix . "spidercalendar_event_category.id where " . $wpdb->prefix . "spidercalendar_event_category.published=1 and " . $wpdb->prefix . "spidercalendar_event.category IN (".$cat_ids.") and " . $wpdb->prefix . "spidercalendar_event.published=1 and ( ( (date<=%s or date like %s) and  (date_end>=%s ) or date_end='0000-00-00'  ) or ( date_end is Null and date like %s ) ) and calendar=%d", substr( $date,0,7).'-01',substr( $date,0,7)."%",substr( $date,0,7).'-01',substr( $date,0,7)."%",$calendar);
			}
   else{
			$query = $wpdb->prepare("SELECT * from " . $wpdb->prefix . "spidercalendar_event where published=1 and ( ( (date<=%s or date like %s) and  date_end>=%s) or ( date_end is Null and date like %s ) ) and calendar=%d   ", "" . substr($date, 0, 7) . "-01", "" . substr($date, 0, 7) . "%", "" . substr($date, 0, 7) . "-01", "" . substr($date, 0, 7) . "%", $calendar);
			}
  $rows = $wpdb->get_results($query." ".$order_by);
  
  
  $id_array = array();
  $s = count($rows);
  $id_array = array();
  $array_days = array();
  $array_days1 = array();
  $title = array();
  $ev_ids = array();
   for ($i = 1; $i <= $s; $i++) {
    $date_month = (int)substr($rows[$i - 1]->date, 5, 2);
    $date_end_month = (int)substr($rows[$i - 1]->date_end, 5, 2);
    $date_day = (int)substr($rows[$i - 1]->date, 8, 2);
    $date_end_day = (int)substr($rows[$i - 1]->date_end, 8, 2);
    $date_year_month = (int)(substr($rows[$i - 1]->date, 0, 4) . substr($rows[$i - 1]->date, 5, 2));
    $date_end_year_month = (int)(substr($rows[$i - 1]->date_end, 0, 4) . substr($rows[$i - 1]->date_end, 5, 2));
    $year_month = (int)($year . $month);
    $repeat = $rows[$i - 1]->repeat;
    if ($repeat == "") {
      $repeat = 1;
    }
    $start_date = $rows[$i - 1]->date;
    $weekly = $rows[$i - 1]->week;
    $weekly_array = explode(',', $weekly);
    $date_days = array();
    $weekdays_start = array();
    $weekdays = array();

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////                NO Repeat                /////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($rows[$i - 1]->repeat_method == 'no_repeat') {
      $date_days[] = $date_day;
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////               Repeat   Daily            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($rows[$i - 1]->repeat_method == 'daily') {
      $t = php_daysDifference($rows[$i - 1]->date, $rows[$i - 1]->date_end);
      for ($k = 1; $k <= $t / $repeat; $k++) {
        $next_date = php_GetNextDate($start_date, $repeat);
        $next_date_array = explode('/', $next_date);
        if ((int)$month == $date_month && (int)substr($date_year_month, 0, 4) == (int)$year)
          $date_days[0] = $date_day;
        if ((int)$month == $next_date_array[0] && (int)$year == $next_date_array[2])
          $date_days[] = $next_date_array[1];
        $start_date = date("Y-m-d", mktime(0, 0, 0, $next_date_array[0], $next_date_array[1], $next_date_array[2]));
      }
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////              Repeat   Weekly             ///////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($rows[$i - 1]->repeat_method == 'weekly') {
      for ($j = 0; $j <= 6; $j++) {
        if (in_array(date("D", mktime(0, 0, 0, $date_month, $date_day + $j, substr($rows[$i - 1]->date, 0, 4))), $weekly_array)) {
          $weekdays_start[] = $date_day + $j;
        }
      }
      for ($p = 0; $p < count($weekly_array) - 1; $p++) {
        $start_date = substr($rows[$i - 1]->date, 0, 8) . $weekdays_start[$p];
        $t = php_daysDifference($rows[$i - 1]->date, $rows[$i - 1]->date_end);
        $r = 0;

        for ($k = 1; $k < $t / $repeat; $k++) {
          $start_date_array[] = $start_date;
		  
		  if($date_month == (int)$month) $next_date = date('n/j/Y', strtotime($start_date));
		  else $next_date = php_GetNextDate($start_date, $repeat * 7);

          $next_date_array = explode('/', $next_date);
		
		 if ((int)$month == $date_month && (int)substr($date_year_month, 0, 4) == (int)$year)
                $date_days[0] = $weekdays_start[$p];

			
          if (($next_date_array[2] . '-' . add_0($next_date_array[0]) . '-' . add_0($next_date_array[1]) > $rows[$i - 1]->date_end) || ($next_date_array[0] > (int)$month && $next_date_array[2] == (int)$year) || ($next_date_array[2] > (int)$year))
            break;
		
		
          if ((int)$month == $date_month && (int)substr($date_year_month, 0, 4) == (int)$year)
            $date_days[0] = $weekdays_start[$p];
          if ((int)$month == $next_date_array[0] && (int)$year == $next_date_array[2])
		
              $weekdays[] = $next_date_array[1];
         

		 $start_date = date("Y-m-d", mktime(0, 0, 0, $next_date_array[0], $next_date_array[1], $next_date_array[2]));
         

        }
        $date_days = array_merge($weekdays, $date_days);
      }
      $repeat = $repeat * 7;
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////               Repeat   Monthly            ///////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($rows[$i - 1]->repeat_method == 'monthly') {
      $xxxxx = 13;
      $year_dif_count = (int)$year - (int)substr($rows[$i - 1]->date, 0, 4);
      $mount_dif_count = 12 - (int)substr($rows[$i - 1]->date, 5, 2) + (($year_dif_count - 1) * 12);
      if ($year_dif_count > 0)
        for ($my_serch_month = 1; $my_serch_month <= 12; $my_serch_month++) {
          if ((($mount_dif_count + $my_serch_month) % $rows[$i - 1]->repeat) == 0) {
            $xxxxx = $my_serch_month;
            break;
          }
        }
      if ($xxxxx != 13) {
        if ($xxxxx < 10) {
          $xxxxx = '0' . $xxxxx;
        }
      }
      $month_days = date('t', mktime(0, 0, 0, $month, $date_day, $year));
      if ($date_month < (int)$month or (int)substr($date_year_month, 0, 4) < $year)
        $date_day = 1;
      if ($year > (int)substr($date_year_month, 0, 4))
        $date_year_month = $year . $xxxxx;
      $p = (int)substr($date_year_month, 4, 2);
      if ((int)substr($date_year_month, 0, 4) != (int)substr($date_end_year_month, 0, 4))
        $end = (int)substr($date_end_year_month, 4, 2) + 12;
      else
        $end = (int)substr($date_end_year_month, 4, 2);
      for ($k = 1; $k <= $end; $k++) {
        if ((int)$month == $p and $rows[$i - 1]->month_type == 1) {
          $date_days[0] = $rows[$i - 1]->month;
        }
        if ($p == (int)$month and $rows[$i - 1]->month_type == 2) {
          if ($rows[$i - 1]->monthly_list != 'last') {
            for ($j = $rows[$i - 1]->monthly_list; $j < $rows[$i - 1]->monthly_list + 7; $j++) {
              if (date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i - 1]->month_week) {
                if ($j >= $date_day) {
                  $date_days[0] = $j;
                }
              }
            }
          }
          else {
            for ($j = 1; $j <= $month_days; $j++) {
              if (date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i - 1]->month_week) {
                if ($j >= $date_day) {
                  $date_days[0] = $j;
                }
              }
            }
          }
        }
        if ($year > (int)substr($date_year_month, 0, 4)) {
          $p = 1;
        }
        $p = $p + $repeat;
      }
      $repeat = 32;
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////               Repeat   Yearly             ///////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($rows[$i - 1]->repeat_method == 'yearly') {
      $month_days = date('t', mktime(0, 0, 0, $month, $date_day, $year));
      $end = substr($date_end_year_month, 0, 4) - substr($date_year_month, 0, 4) + 1;
      if (substr($date_year_month, 0, 4) < $year) {
        $date_day = 1;
      }
      for ($k = 0; $k <= $end; $k += $repeat) {
        if ((int)$month == $rows[$i - 1]->year_month and $rows[$i - 1]->month_type == 1 and $year == substr($date_year_month, 0, 4) + $k) {
          $date_days[0] = $rows[$i - 1]->month;
        }
      }
      for ($k = 0; $k <= $end; $k += $repeat) {
        if ((int)$month == $rows[$i - 1]->year_month and $rows[$i - 1]->month_type == 2 and $year == substr($date_year_month, 0, 4) + $k) {
          if ($rows[$i - 1]->monthly_list != 'last') {
            for ($j = $rows[$i - 1]->monthly_list; $j < $rows[$i - 1]->monthly_list + 7; $j++) {
              if (date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i - 1]->month_week) {
                $date_days[0] = $j;
              }
            }
          }
          else {
            for ($j = 1; $j <= $month_days; $j++) {
              if (date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i - 1]->month_week) {
                $date_days[0] = $j;
              }
            }
          }
        }
      }
      $repeat = 32;
    }
    $used = array();
    foreach ($date_days as $date_day) {
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////              Convert am/pm     ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/* */

      if ($date_month == $month) {
        if (in_array($date_day, $used)) {
          continue;
        }
        else {
          array_push($used, $date_day);
        }
        if (in_array($date_day, $array_days)) {
          $key = array_search($date_day, $array_days);
          $title_num[$date_day]++;
          if ($rows[$i - 1]->text_for_date != "")
            $array_days1[$key] = $date_day;
          $c = $title_num[$date_day];
          $list = '<p>' . (($show_numbers_for_events and $day_start) ? '' . (($show_numbers_for_events) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '') : '');
		  
		  
          if ($rows[$i - 1]->time and $show_time != 0) {
            $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
          }
          else {
            $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
          }
          $title[$date_day] = $title[$date_day] . $list;
          $ev_ids[$date_day] = $ev_ids[$date_day] . $rows[$i - 1]->id . '<br>';
        }
        else {
		
          $array_days[] = $date_day;
          $key = array_search($date_day, $array_days);
          if ($rows[$i - 1]->text_for_date != "")
            $array_days1[$key] = $date_day;
          $title_num[$date_day] = 1;
          $c = 1;
		  
          $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
          if ($rows[$i - 1]->time and $show_time != 0) {
            $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
          }
          else {
            $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
          }
          $title[$date_day] = $list;
          $ev_ids[$date_day] = $rows[$i - 1]->id . '<br>';
        }
      }
      if ($date_end_month > 0 and  $date_year_month == $date_end_year_month and $date_end_year_month == $year_month)
        for ($j = $date_day; $j <= $date_end_day; $j = $j + $repeat) {
          if (in_array($j, $used)) {
            continue;
          }
          else {
            array_push($used, $j);
          }
          if (in_array($j, $array_days)) {
            $key = array_search($j, $array_days);
            $title_num[$j]++;
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $j;
            }
            $c = $title_num[$j];
            $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
            }
            $title[$j] = $title[$j] . $list;
            $ev_ids[$j] = $ev_ids[$j] . $rows[$i - 1]->id . '<br>';
          }
          else {
            $array_days[] = $j;
            $key = array_search($j, $array_days);
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $j;
            }
            $title_num[$j] = 1;
            $c = 1;
            $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
            }
            $title[$j] = $list;
            $ev_ids[$j] = $rows[$i - 1]->id . '<br>';
          }
        }
      if ($date_end_month > 0 and  $date_year_month < $date_end_year_month and $date_year_month == $year_month)
        for ($j = $date_day; $j <= 31; $j = $j + $repeat) {
          if (in_array($j, $used)) {
            continue;
          }
          else {
            array_push($used, $j);
          }
          if (in_array($j, $array_days)) {
            $key = array_search($j, $array_days);
            $title_num[$j]++;
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $j;
            }
            $c = $title_num[$j];
            $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
            }
            $title[$j] = $title[$j] . $list;
            $ev_ids[$j] = $ev_ids[$j] . $rows[$i - 1]->id . '<br>';
          }
          else {
            $array_days[] = $j;
            $key = array_search($j, $array_days);
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $j;
            }
            $title_num[$j] = 1;
            $c = 1;
            $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
            }
            $title[$j] = $list;
            $ev_ids[$j] = $rows[$i - 1]->id . '<br>';
          }
        }
      if ($date_end_month > 0 and  $date_year_month < $date_end_year_month and   $date_end_year_month == $year_month)
        for ($j = $date_day; $j <= $date_end_day; $j = $j + $repeat) {
          if (in_array($j, $used)) {
            continue;
          }
          else {
            array_push($used, $j);
          }
          if (in_array($j, $array_days)) {
            $key = array_search($j, $array_days);
            $title_num[$j]++;
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $j;
            }
            $c = $title_num[$j];
            $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
            }
            $title[$j] = $title[$j] . $list;
            $ev_ids[$j] = $ev_ids[$j] . $rows[$i - 1]->id . '<br>';
          }
          else {
            $array_days[] = $j;
            $key = array_search($j, $array_days);
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $j;
            }
            $title_num[$j] = 1;
            $c = 1;
            $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
            }
            $title[$j] = $list;
            $ev_ids[$j] = $rows[$i - 1]->id . '<br>';
          }
        }
      if ($date_end_month > 0 and  $date_year_month < $date_end_year_month and   $date_end_year_month > $year_month and  $date_year_month < $year_month)
        for ($j = $date_day; $j <= 31; $j = $j + $repeat) {
          if (in_array($j, $used)) {
            continue;
          }
          else {
            array_push($used, $j);
          }
          if (in_array($j, $array_days)) {
            $key = array_search($j, $array_days);
            $title_num[$j]++;
            if ($rows[$i - 1]->text_for_date != "")
              $array_days1[$key] = $j;
            $c = $title_num[$j];
            $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
            }
            $title[$j] = $title[$j] . $list;
            $ev_ids[$j] = $ev_ids[$j] . $rows[$i - 1]->id . '<br>';
          }
          else {
            $array_days[] = $j;
            $key = array_search($j, $array_days);
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $j;
            }
            $title_num[$j] = 1;
            $c = 1;
            $list = '<p>' . (($show_numbers_for_events and $day_start) ? '<b>' . $c . '.</b>&nbsp;&nbsp;' : '');
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= '&nbsp;' . $rows[$i - 1]->title . '</p>';
            }
            $title[$j] = $list;
            $ev_ids[$j] = $rows[$i - 1]->id . '<br>';
          }
        }
    }
  }
  for ($i = 1; $i <= count($array_days) - 1; $i++) {
    if (isset($array_days[$i])) {
      if ($array_days[$i] > '00' && $array_days[$i] < '09' and substr($array_days[$i], 0, 1) == '0') {
        $array_days[$i] = substr($array_days[$i], 1, 1);
      }
    }
  }
  $all_calendar_files['array_days'] = $array_days;
  $all_calendar_files['title'] = $title;
  $all_calendar_files['array_days1'] = $array_days1;
  $all_calendar_files['calendar'] = $calendar;
  $all_calendar_files['ev_ids'] = $ev_ids;
  return array($all_calendar_files);
}

function php_getdays_for_three_months($calendar, $date, $months, $theme_id, $widget) {
  global $wpdb;  
  $row =  $wpdb->get_row($wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_calendar where published=1 and id=%d",$calendar));
  date_default_timezone_set ($row->def_zone);
  $year = substr($date, 0, 4);
  $month = substr($date, 5, 2);
  $months_array = explode(',', $months);
  if ($widget) {
    $show_time = 0;
  }
  else {
    $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme WHERE id=%d', $theme_id));
    $show_time = $theme->show_time;
  }

  $cat_id = (isset($_GET['cat_id']) ? esc_html($_GET['cat_id']) : '');
  $cat_ids = (isset($_GET['cat_ids']) ? esc_html($_GET['cat_ids']) : '');

  
if($cat_ids=='')
$cat_ids .= $cat_id.',';
else
$cat_ids .= ','.$cat_id.',';



$cat_ids = substr($cat_ids, 0,-1);

$cat_ids_array = explode(',',$cat_ids);


if($cat_id!='')
{

if(getelementcountinarray($cat_ids_array,$cat_id )%2==0)
{
$index_in_line = getelementindexinarray($cat_ids_array, $cat_id);
$index_array = explode(',' , $index_in_line);
array_pop ($index_array);
for($j=0; $j<count($index_array); $j++)
unset($cat_ids_array[$index_array[$j]]);
$cat_ids = implode(',',$cat_ids_array);
}
}
else
$cat_ids = substr($cat_ids, 0,-1);
 
	if($row->time_format==0)
	 {
		$order_by = "ORDER BY " . $wpdb->prefix . "spidercalendar_event.time ASC";
	 }
	 else{
		$order_by = " ORDER BY STR_TO_DATE( SUBSTRING( time, 1, 7 ) ,  '%h:%i%p' )";
	 } 
  
  if($cat_ids!='' and preg_match("/^[0-9\,]+$/", $cat_ids)){
  
			$query = $wpdb->prepare ("SELECT " . $wpdb->prefix . "spidercalendar_event.*,	" . $wpdb->prefix . "spidercalendar_event_category.color  from " . $wpdb->prefix . "spidercalendar_event JOIN " . $wpdb->prefix . "spidercalendar_event_category ON " . $wpdb->prefix . "spidercalendar_event.category = " . $wpdb->prefix . "spidercalendar_event_category.id 	where " . $wpdb->prefix . "spidercalendar_event_category.published=1 and " . $wpdb->prefix . "spidercalendar_event.category IN (".$cat_ids.") and " . $wpdb->prefix . "spidercalendar_event.published=1 and ( ( (date<=%s	or date like %s) and  (date_end>=%s ) or date_end='0000-00-00'  ) or ( date_end is Null and date like %s ) ) and calendar=%d ",substr( $date,0,7).'-01',substr( $date,0,7)."%",	substr( $date,0,7).'-01',substr( $date,0,7)."%",$calendar);	
			}
	else{
			 $query = $wpdb->prepare("SELECT * from " . $wpdb->prefix . "spidercalendar_event where published=1 and ((date_end>=%s) or (date_end=%s)) and calendar=%d", "" . substr($date, 0, 7) . "-01", "0000-00-00", $calendar);
  }
  $rows = $wpdb->get_results($query." ".$order_by);
  
			
  
  
  $all_id_array = array();
  $all_array_days = array();
  $all_array_days1 = array();
  $all_title = array();
  $all_ev_ids = array();
  $s = count($rows);
  foreach ($months_array as $month) {
    $id_array = array();
    $array_days = array();
    $array_days1 = array();
    $title = array();
    $ev_ids = array();
    for ($i = 1; $i <= $s; $i++) {
      if ($rows[$i - 1]->repeat_method != 'no_repeat' and $rows[$i - 1]->date_end == '0000-00-00')
        $d_end = ((int)substr($rows[$i - 1]->date, 0, 4) + 40) . substr($rows[$i - 1]->date, 4, 6);
      else
        $d_end = $rows[$i - 1]->date_end;
      $date_month = (int)substr($rows[$i - 1]->date, 5, 2);
      $date_end_month = (int)substr($d_end, 5, 2);
      $date_day = (int)substr($rows[$i - 1]->date, 8, 2);
      $date_end_day = (int)substr($d_end, 8, 2);
      $date_year_month = (int)(substr($rows[$i - 1]->date, 0, 4) . substr($rows[$i - 1]->date, 5, 2));
      $date_end_year_month = (int)(substr($d_end, 0, 4) . substr($d_end, 5, 2));
      $year_month = (int)($year . $month);
      $repeat = $rows[$i - 1]->repeat;
      if ($repeat == "") {
        $repeat = 1;
      }
      $start_date = $rows[$i - 1]->date;
      $weekly = $rows[$i - 1]->week;
      $weekly_array = explode(',', $weekly);
      $date_days = array();
      $weekdays_start = array();
      $weekdays = array();
	  
	  
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ////////////////////////                NO Repeat                /////////////////////////////////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      if ($rows[$i - 1]->repeat_method == 'no_repeat') {
        $date_days[] = $date_day;
      }
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ////////////////////////               Repeat   Daily             /////////////////////////////////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      if ($rows[$i - 1]->repeat_method == 'daily') {
        $t = php_daysDifference($rows[$i - 1]->date, $d_end);
        for ($k = 1; $k <= $t / $repeat; $k++) {
          $next_date = php_GetNextDate($start_date, $repeat);
          $next_date_array = explode('/', $next_date);
          if ((int)$month == $date_month && (int)substr($date_year_month, 0, 4) == (int)$year) {
            $date_days[0] = $date_day;
          }
          if ((int)$month == $next_date_array[0] && (int)$year == $next_date_array[2]) {
            $date_days[] = $next_date_array[1];
          }
          $start_date = date("Y-m-d", mktime(0, 0, 0, $next_date_array[0], $next_date_array[1], $next_date_array[2]));
        }
      }
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ////////////////////////               Repeat   Weekly             ///////////////////////////////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      if ($rows[$i - 1]->repeat_method == 'weekly') {
        for ($j = 0; $j <= 6; $j++) {
          if (in_array(date("D", mktime(0, 0, 0, $date_month, $date_day + $j, substr($rows[$i - 1]->date, 0, 4))), $weekly_array)) {
            $weekdays_start[] = $date_day + $j;
          }
        }
        for ($p = 0; $p < count($weekly_array) - 1; $p++) {
          $start_date = substr($rows[$i - 1]->date, 0, 8) . $weekdays_start[$p];
          $t = php_daysDifference($rows[$i - 1]->date, $d_end);
          $q = php_daysDifference($rows[$i - 1]->date, $start_date);
          $r = 0;
          if (($t / ($repeat * 7) - 1) > 1) {
            for ($k = 1; $k < $t / ($repeat * 7) - 1; $k++) {
              $start_date_array[] = $start_date;
			  
			  if($date_month == (int)$month) $next_date = date('n/j/Y', strtotime($start_date));
			  else $next_date = php_GetNextDate($start_date, $repeat * 7);
			  
              $next_date_array = explode('/', $next_date);
              if ((int)$month == $date_month && (int)substr($date_year_month, 0, 4) == (int)$year)
                $date_days[0] = $weekdays_start[$p];
              if ((int)$month == $next_date_array[0] && (int)$year == $next_date_array[2]) {
                if ((int)$year > (int)substr($date_year_month, 0, 4)) {
                  $weekdays[] = $next_date_array[1];
                }
                else {
                  $weekdays[] = $next_date_array[1];
                }
              }
              $start_date = date("Y-m-d", mktime(0, 0, 0, $next_date_array[0], $next_date_array[1], $next_date_array[2]));
              if ($next_date_array[2] > (int)substr($d_end, 0, 4)) {
                break;
              }
            }
            $date_days = array_merge($weekdays, $date_days);
          }
          else {
            if ($t >= $q) {
              $date_days[] = $weekdays_start[$p];
            }
          }
        }
        $repeat = $repeat * 7;
      }
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ////////////////////////               Repeat   Monthly            ///////////////////////////////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      if ($rows[$i - 1]->repeat_method == 'monthly') {
        $month_days = date('t', mktime(0, 0, 0, $month, $date_day, $year));
        if ($date_month < (int)$month or (int)substr($date_year_month, 0, 4) < $year) {
          $date_day = 1;
        }
        if ($year > (int)substr($date_year_month, 0, 4)) {
          $date_year_month = $year . '00';
        }
        $p = (int)substr($date_year_month, 4, 2);
        if ((int)substr($date_year_month, 0, 4) != (int)substr($date_end_year_month, 0, 4)) {
          $end = (int)substr($date_end_year_month, 4, 2) + 12;
        }
        else {
          $end = (int)substr($date_end_year_month, 4, 2);
        }
        for ($k = 1; $k <= $end; $k++) {
          if ((int)$month == $p and $rows[$i - 1]->month_type == 1) {
            $date_days[0] = $rows[$i - 1]->month;
          }
          if ($p == (int)$month and $rows[$i - 1]->month_type == 2) {
            if ($rows[$i - 1]->monthly_list != 'last') {
              for ($j = $rows[$i - 1]->monthly_list; $j < $rows[$i - 1]->monthly_list + 7; $j++) {
                if (date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i - 1]->month_week) {
                  if ($j >= $date_day) {
                    $date_days[0] = $j;
                  }
                }
              }
            }
            else {
              for ($j = 1; $j < $month_days; $j++) {
                if (date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i - 1]->month_week) {
                  if ($j >= $date_day) {
                    $date_days[0] = $j;
                  }
                }
              }
            }
          }
          if ($year > (int)substr($date_year_month, 0, 4)) {
            $p = 1;
          }
          $p = $p + $repeat;
        }
        $repeat = 32;
      }
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      ////////////////////////               Repeat   Yearly             ///////////////////////////////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      if ($rows[$i - 1]->repeat_method == 'yearly') {
        $month_days = date('t', mktime(0, 0, 0, $month, $date_day, $year));
        $end = substr($date_end_year_month, 0, 4) - substr($date_year_month, 0, 4) + 1;
        if (substr($date_year_month, 0, 4) < $year) {
          $date_day = 1;
        }
        for ($k = 0; $k <= $end; $k += $repeat) {
          if ((int)$month == $rows[$i - 1]->year_month and $rows[$i - 1]->month_type == 1 and $year == substr($date_year_month, 0, 4) + $k) {
            $date_days[0] = $rows[$i - 1]->month;
          }
        }
        for ($k = 0; $k <= $end; $k += $repeat) {
          if ((int)$month == $rows[$i - 1]->year_month and $rows[$i - 1]->month_type == 2 and $year == substr($date_year_month, 0, 4) + $k) {
            if ($rows[$i - 1]->monthly_list != 'last') {
              for ($j = $rows[$i - 1]->monthly_list; $j < $rows[$i - 1]->monthly_list + 7; $j++) {
                if (date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i - 1]->month_week) {
                  $date_days[0] = $j;
                }
              }
            }
            else {
              for ($j = 1; $j <= $month_days; $j++) {
                if (date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i - 1]->month_week) {
                  $date_days[0] = $j;
                }
              }
            }
          }
        }
        $repeat = 32;
      }
      $used = array();
      foreach ($date_days as $date_day) {
        if ($date_month == $month) {
          if (in_array($date_day, $used)) {
            continue;
          }
          else {
            array_push($used, $date_day);
          }
          if (in_array($date_day, $array_days)) {
            $key = array_search($date_day, $array_days);
            $title_num[$date_day]++;
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $date_day;
            }
            $c = $title_num[$date_day];
            $list = '<p>&nbsp; ';
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= $rows[$i - 1]->title . '</p>';
            }
            $title[$date_day] = $title[$date_day] . $list;
            $ev_ids[$date_day] = $ev_ids[$date_day] . $rows[$i - 1]->id . '<br>';
          }
          else {
            $array_days[] = $date_day;
            $key = array_search($date_day, $array_days);
            if ($rows[$i - 1]->text_for_date != "") {
              $array_days1[$key] = $date_day;
            }
            $title_num[$date_day] = 1;
            $c = 1;
            $list = '<p>&nbsp; ';
            if ($rows[$i - 1]->time and $show_time != 0) {
              $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
            }
            else {
              $list .= $rows[$i - 1]->title . '</p>';
            }
            $title[$date_day] = $list;
            $ev_ids[$date_day] = $rows[$i - 1]->id . '<br>';
          }
        }
        if ($date_end_month > 0 and  $date_year_month == $date_end_year_month and $date_end_year_month == $year_month)
          for ($j = $date_day; $j <= $date_end_day; $j = $j + $repeat) {
            if (in_array($j, $used)) {
              continue;
            }
            else {
              array_push($used, $j);
            }
            if (in_array($j, $array_days)) {
              $key = array_search($j, $array_days);
              $title_num[$j]++;
              if ($rows[$i - 1]->text_for_date != "") {
                $array_days1[$key] = $j;
              }
              $c = $title_num[$j];
              $list = '<p>&nbsp; ';
              if ($rows[$i - 1]->time and $show_time != 0) {
                $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
              }
              else {
                $list .= $rows[$i - 1]->title . '</p>';
              }
              $title[$j] = $title[$j] . $list;
              $ev_ids[$j] = $ev_ids[$j] . $rows[$i - 1]->id . '<br>';
            }
            else {
              $array_days[] = $j;
              $key = array_search($j, $array_days);
              if ($rows[$i - 1]->text_for_date != "") {
                $array_days1[$key] = $j;
              }
              $title_num[$j] = 1;
              $c = 1;
              $list = '<p>&nbsp; ';
              if ($rows[$i - 1]->time and $show_time != 0) {
                $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
              }
              else {
                $list .= $rows[$i - 1]->title . '</p>';
              }
              $title[$j] = $list;
              $ev_ids[$j] = $rows[$i - 1]->id . '<br>';
            }
          }
        if ($date_end_month > 0 and  $date_year_month < $date_end_year_month and $date_year_month == $year_month)
          for ($j = $date_day; $j <= 31; $j = $j + $repeat) {
            if (in_array($j, $used)) {
              continue;
            }
            else {
              array_push($used, $j);
            }
            if (in_array($j, $array_days)) {
              $key = array_search($j, $array_days);
              $title_num[$j]++;
              if ($rows[$i - 1]->text_for_date != "") {
                $array_days1[$key] = $j;
              }
              $c = $title_num[$j];
              $list = '<p>&nbsp; ';
              if ($rows[$i - 1]->time and $show_time != 0) {
                $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
              }
              else {
                $list .= $rows[$i - 1]->title . '</p>';
              }
              $title[$j] = $title[$j] . $list;
              $ev_ids[$j] = $ev_ids[$j] . $rows[$i - 1]->id . '<br>';
            }
            else {
              $array_days[] = $j;
              $key = array_search($j, $array_days);
              if ($rows[$i - 1]->text_for_date != "") {
                $array_days1[$key] = $j;
              }
              $title_num[$j] = 1;
              $c = 1;
              $list = '<p>&nbsp; ';
              if ($rows[$i - 1]->time and $show_time != 0) {
                $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
              }
              else {
                $list .= $rows[$i - 1]->title . '</p>';
              }
              $title[$j] = $list;
              $ev_ids[$j] = $rows[$i - 1]->id . '<br>';
            }
          }
        if ($date_end_month > 0 and  $date_year_month < $date_end_year_month and   $date_end_year_month == $year_month)
          for ($j = $date_day; $j <= $date_end_day; $j = $j + $repeat) {
            if (in_array($j, $used)) {
              continue;
            }
            else {
              array_push($used, $j);
            }
            if (in_array($j, $array_days)) {
              $key = array_search($j, $array_days);
              $title_num[$j]++;
              if ($rows[$i - 1]->text_for_date != "") {
                $array_days1[$key] = $j;
              }
              $c = $title_num[$j];
              $list = '<p>&nbsp; ';
              if ($rows[$i - 1]->time and $show_time != 0) {
                $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
              }
              else {
                $list .= $rows[$i - 1]->title . '</p>';
              }
              $title[$j] = $title[$j] . $list;
              $ev_ids[$j] = $ev_ids[$j] . $rows[$i - 1]->id . '<br>';
            }
            else {
              $array_days[] = $j;
              $key = array_search($j, $array_days);
              if ($rows[$i - 1]->text_for_date != "") {
                $array_days1[$key] = $j;
              }
              $title_num[$j] = 1;
              $c = 1;
              $list = '<p>&nbsp; ';
              if ($rows[$i - 1]->time and $show_time != 0) {
                $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
              }
              else {
                $list .= $rows[$i - 1]->title . '</p>';
              }
              $title[$j] = $list;
              $ev_ids[$j] = $rows[$i - 1]->id . '<br>';
            }
          }
        if ($date_end_month > 0 and  $date_year_month < $date_end_year_month and   $date_end_year_month > $year_month and  $date_year_month < $year_month)
          for ($j = $date_day; $j <= 31; $j = $j + $repeat) {
            if (in_array($j, $used)) {
              continue;
            }
            else {
              array_push($used, $j);
            }
            if (in_array($j, $array_days)) {
              $key = array_search($j, $array_days);
              $title_num[$j]++;
              if ($rows[$i - 1]->text_for_date != "") {
                $array_days1[$key] = $j;
              }
              $c = $title_num[$j];
              $list = '<p>&nbsp; ';
              if ($rows[$i - 1]->time and $show_time != 0) {
                $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
              }
              else {
                $list .= $rows[$i - 1]->title . '</p>';
              }
              $title[$j] = $title[$j] . $list;
              $ev_ids[$j] = $ev_ids[$j] . $rows[$i - 1]->id . '<br>';
            }
            else {
              $array_days[] = $j;
              $key = array_search($j, $array_days);
              if ($rows[$i - 1]->text_for_date != "") {
                $array_days1[$key] = $j;
              }
              $title_num[$j] = 1;
              $c = 1;
              $list = '<p>&nbsp; ';
              if ($rows[$i - 1]->time and $show_time != 0) {
                $list .= $rows[$i - 1]->title . '<br>(' . $rows[$i - 1]->time . ')</p>';
              }
              else {
                $list .= $rows[$i - 1]->title . '</p>';
              }
              $title[$j] = $list;
              $ev_ids[$j] = $rows[$i - 1]->id . '<br>';
            }
          }
      }
    }
    $all_id_array[] = $id_array;
    $all_array_days[] = $array_days;
    $all_array_days1[] = $array_days1;
    $all_title[] = $title;
    $all_ev_ids[] = $ev_ids;
  }
  $all_calendar_files['all_array_days'] = $all_array_days;
  $all_calendar_files['all_array_days1'] = $all_array_days1;
  $all_calendar_files['all_title'] = $all_title;
  $all_calendar_files['all_ev_ids'] = $all_ev_ids;
  $all_calendar_files['all_calendar'] = $all_id_array;  
  return array($all_calendar_files);
}


function Month_name($month_num) {
  $timestamp = mktime(0, 0, 0, $month_num, 1, 2005);
  return date("F", $timestamp);
}

function add_0($month_num) {
  if ($month_num < 10)
    return '0' . $month_num;
  return $month_num;
}

function Month_num($month_name) {
  for ($month_num = 1; $month_num <= 12; $month_num++) {
    if (date("F", mktime(0, 0, 0, $month_num, 1, 0)) == $month_name) {
      return $month_num;
    }
  }
}

function week_number($x) {
  if ($x == 1) {
    return __('First', 'sp_calendar');
  }
  elseif ($x == 8) {
    return __('Second', 'sp_calendar');
  }
  elseif ($x == 15) {
    return __('Third', 'sp_calendar');
  }
  elseif ($x == 22) {
    return __('Fourth', 'sp_calendar');
  }
  elseif ($x == 'last') {
    return __('Last', 'sp_calendar');
  }
}

function week_convert($x) {
  if ($x == 'Mon') {
    return __('Monday', 'sp_calendar');
  }
  elseif ($x == 'Tue') {
    return __('Tuesday', 'sp_calendar');
  }
  elseif ($x == 'Wed') {
    return __('Wednesday', 'sp_calendar');
  }
  elseif ($x == 'Thu') {
    return __('Thursday', 'sp_calendar');
  }
  elseif ($x == 'Fri') {
    return __('Friday', 'sp_calendar');
  }
  elseif ($x == 'Sat') {
    return __('Saturday', 'sp_calendar');
  }
  elseif ($x == 'Sun') {
    return __('Sunday', 'sp_calendar');
  }
}

function do_nothing() {
  return FALSE;
}

function php_showevent($calendar, $date, $eventID) {
  global $wpdb;
  $year = substr($date, 0, 4);
  $month = substr($date, 5, 2);
  $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_event WHERE id=%d', $eventID));
  $all_files_spider_cal['row'] = $row;
  return array($all_files_spider_cal);
}

function php_showevent_seemore($calendar, $date) {
  global $wpdb;
  $year = substr($date, 0, 4);
  $month = substr($date, 5, 2);
  $row =  $wpdb->get_row($wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_calendar where published=1 and id=%d",$calendar));

	if($row->time_format==0)
	 {
		$order_by = "ORDER BY " . $wpdb->prefix . "spidercalendar_event.time ASC";
	 }
	 else{
		$order_by = " ORDER BY STR_TO_DATE( SUBSTRING( time, 1, 7 ) ,  '%h:%i%p' )";
	 }
	 
  
  $query =  $wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_event WHERE calendar=%d ".$order_by,$calendar);
  $rows = $wpdb->get_results($query);
  $all_spider_files['rows'] = $rows;
  return array($all_spider_files);
}

function php_Month_num_seemore($month_name) {
  for ($month_num = 1; $month_num <= 12; $month_num++) {
    if (date("F", mktime(0, 0, 0, $month_num, 1, 0)) == $month_name) {
      return $month_num;
    }
  }
}

function hex_to_rgb($color, $opacity)
{
	$color=str_replace('#','',$color);
	$bg_color='rgba('.HEXDEC(SUBSTR($color, 0, 2)).','.HEXDEC(SUBSTR($color, 2, 2)).','.HEXDEC(SUBSTR($color, 4, 2)).','.$opacity.')';
	return $bg_color;
}

?>