<?php
function big_calendar_week() {
  require_once("frontend_functions.php");
  global $wpdb;
  $widget = ((isset($_GET['widget']) && (int) $_GET['widget']) ? (int) $_GET['widget'] : 0);
  $many_sp_calendar = ((isset($_GET['many_sp_calendar']) && is_numeric(esc_html($_GET['many_sp_calendar']))) ? esc_html($_GET['many_sp_calendar']) : 1);
  $calendar_id = (isset($_GET['calendar']) ? (int) $_GET['calendar'] : '');
  $theme_id = (isset($_GET['theme_id']) ? (int) $_GET['theme_id'] : 30);
  $date = ((isset($_GET['date']) && IsDate_inputed(esc_html($_GET['date']))) ? esc_html($_GET['date']) : '');
  $view_select = (isset($_GET['select']) ? esc_html($_GET['select']) : 'month,');
  $path_sp_cal = (isset($_GET['cur_page_url']) ? esc_html($_GET['cur_page_url']) : '');
  $months = (isset($_GET['months']) ? esc_html($_GET['months']) : '');
  $cat_id = (isset($_GET['cat_id']) ? esc_html($_GET['cat_id']) : '');
  $cat_ids = (isset($_GET['cat_ids']) ? esc_html($_GET['cat_ids']) : '');
  $site_url = get_admin_url().'admin-ajax.php';
  ///////////////////////////////////////////////////////////////////////////////////
  
if($cat_ids=='')
$cat_ids .= $cat_id.',';
else
$cat_ids .= ','.$cat_id.',';



$cat_ids = substr($cat_ids, 0,-1);

function getelementcountinarray($array , $element)
{
  $t=0; 

  for($i=0; $i<count($array); $i++)
  {
    if($element==$array[$i])
	$t++;
  
  }
  
  
  return $t; 

}

function getelementindexinarray($array , $element)
{
 
		$t='';
		
	for($i=0; $i<count($array); $i++)
		{
			if($element==$array[$i])
			$t.=$i.',';
	
	    }
	
	return $t;


}
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

///////////////////////////////////////////////////////////////////////////////////////////////////////
  
  $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme WHERE id=%d', $theme_id));
  $cal_width = $theme->width;
  $bg_top = '#' . str_replace('#','',$theme->bg_top);
  $bg_bottom = '#' . str_replace('#','',$theme->bg_bottom);
  $border_color = '#' . str_replace('#','',$theme->border_color);
  $text_color_year = '#' . str_replace('#','',$theme->text_color_year);
  $text_color_month = '#' . str_replace('#','',$theme->text_color_month);
  $color_week_days = '#' . str_replace('#','',$theme->text_color_week_days);
  $text_color_other_months = '#' . str_replace('#','',$theme->text_color_other_months);
  $text_color_this_month_unevented = '#' . str_replace('#','',$theme->text_color_this_month_unevented);
  $evented_color = '#' . str_replace('#','',$theme->text_color_this_month_evented);
  $evented_color_bg = (isset($theme->bg_color_this_month_evented) ?'#' . str_replace('#','',$theme->bg_color_this_month_evented) : '');
  $color_arrow_year = '#' . str_replace('#','',$theme->arrow_color_year);
  $color_arrow_month = '#' . str_replace('#','',$theme->arrow_color_month);
  $sun_days = '#' . str_replace('#','',$theme->text_color_sun_days);
  $event_title_color = '#' . str_replace('#','',$theme->event_title_color);
  $current_day_border_color = '#' . str_replace('#','',$theme->current_day_border_color);
  $cell_border_color = '#' . str_replace('#','',$theme->cell_border_color);
  $cell_height = $theme->cell_height;
  $popup_width = $theme->popup_width;
  $popup_height = $theme->popup_height;
  $number_of_shown_evetns = $theme->number_of_shown_evetns;
  $sundays_font_size = $theme->sundays_font_size;
  $other_days_font_size = $theme->other_days_font_size;
  $weekdays_font_size = $theme->weekdays_font_size;
  $border_width = $theme->border_width;
  $top_height = $theme->top_height;
  $bg_color_other_months = '#' . str_replace('#','',$theme->bg_color_other_months);
  $sundays_bg_color = '#' . str_replace('#','',$theme->sundays_bg_color);
  $weekdays_bg_color = '#' . str_replace('#','',$theme->weekdays_bg_color);
  $weekstart = $theme->week_start_day;
  $weekday_sunday_bg_color = '#' . str_replace('#','',$theme->weekday_sunday_bg_color);
  $border_radius = $theme->border_radius;
  $border_radius2 = $border_radius-$border_width;
  $week_days_cell_height = $theme->week_days_cell_height;
  $year_font_size = $theme->year_font_size;
  $month_font_size = $theme->month_font_size;
  $show_cat = $theme->show_cat;
  $arrow_size = $theme->arrow_size;
  $arrow_size_hover = $arrow_size;
  $next_month_text_color = '#' . str_replace('#','',$theme->next_month_text_color);
  $prev_month_text_color = '#' . str_replace('#','',$theme->prev_month_text_color);
  $next_month_arrow_color = '#' . str_replace('#','',$theme->next_month_arrow_color);
  $prev_month_arrow_color = '#' . str_replace('#','',$theme->prev_month_arrow_color);
  $next_month_font_size = $theme->next_month_font_size;
  $prev_month_font_size = $theme->prev_month_font_size;
  $month_type = $theme->month_type;
  $date_bg_color = '#' . str_replace('#','',$theme->date_bg_color);
  $event_bg_color1 = '#' . str_replace('#','',$theme->event_bg_color1);
  $event_bg_color2 = '#' . str_replace('#','',$theme->event_bg_color2);
  $event_num_bg_color1 = '#' . str_replace('#','',$theme->event_num_bg_color1);
  $event_num_bg_color2 = '#' . str_replace('#','',$theme->event_num_bg_color2);
  $event_num_color = '#' . str_replace('#','',$theme->event_num_color);
  $date_font_size = $theme->date_font_size;
  $event_num_font_size = $theme->event_num_font_size;
  $event_table_height = $theme->event_table_height;
  $date_height = $theme->date_height;
  $day_month_font_size = $theme->day_month_font_size;
  $week_font_size = $theme->week_font_size;
  $day_month_font_color = '#' . str_replace('#','',$theme->day_month_font_color);
  $week_font_color = '#' . str_replace('#','',$theme->week_font_color);
  $views_tabs_bg_color = '#' . str_replace('#','',$theme->views_tabs_bg_color);
  $views_tabs_text_color = '#' . str_replace('#','',$theme->views_tabs_text_color);
  $views_tabs_font_size = $theme->views_tabs_font_size;
  $header_format = (isset($theme->header_format) ? $theme->header_format : 'w/d/m/y');

  $date_bg_color = '#' . str_replace('#','',$theme->date_bg_color);
  $event_bg_color1 = '#' . str_replace('#','',$theme->event_bg_color1);
  $event_bg_color2 = '#' . str_replace('#','',$theme->event_bg_color2);
  $event_num_bg_color1 = '#' . str_replace('#','',$theme->event_num_bg_color1);
  $event_num_bg_color2 = '#' . str_replace('#','',$theme->event_num_bg_color2);
  $event_num_color = '#' . str_replace('#','',$theme->event_num_color);
  $date_font_size = $theme->date_font_size;
  $event_num_font_size = $theme->event_num_font_size;
  $show_numbers_for_events = $theme->day_start;
  $show_event_bgcolor = '#' . str_replace('#','',$theme->show_event_bgcolor);

  
  __('January', 'sp_calendar');
  __('February', 'sp_calendar');
  __('March', 'sp_calendar');
  __('April', 'sp_calendar');
  __('May', 'sp_calendar');
  __('June', 'sp_calendar');
  __('July', 'sp_calendar');
  __('August', 'sp_calendar');
  __('September', 'sp_calendar');
  __('October', 'sp_calendar');
  __('November', 'sp_calendar');
  __('December', 'sp_calendar');
  if ($cell_height == '') {
    $cell_height = 70;
  }
  if ($cal_width == '') {
    $cal_width = 700;
  }

  if ($date != '') {
    $date_REFERER = $date;
  }
  else {
    $date_REFERER = date("Y-m");
    $date = date("Y") . '-' . php_Month_num(date("F")) . '-' . date("d");
  }
  $year_REFERER = substr($date_REFERER, 0, 4);
  $month_REFERER = Month_name(substr($date_REFERER, 5, 2));
  $day_REFERER = substr($date_REFERER, 8, 2);

  $year = substr($date, 0, 4);
  $month = Month_name(substr($date, 5, 2));
  $day = substr($date, 8, 2);

  $cell_width = $cal_width / 7;

  $week_days = array();
  $d = new DateTime($date);
  $weekday = $d->format('w');
  // Monday=0, Sunday=6.
  $diff = ($weekday == 0 ? 6 : $weekday - 1);
  if ($weekstart == "su") {
    $diff = $diff + 1;
  }
  $d->modify("-$diff day");
  $d->modify("-1 day");
  $prev_date = $d->format('Y-m-d');
  $d->modify("+1 day");
  $week_days[] = $d->format('Y-m-d');
  for ($i = 1; $i < 7; $i++) {
    $d->modify('+1 day');
    $week_days[] = $d->format('Y-m-d');
  }
  if ($weekstart == "su") {
    $d->modify('+2 day');
  }
  else {
    $d->modify('+1 day');
  }
  $next_date = $d->format('Y-m-d');
  $prev_month = add_0((int) substr($prev_date, 5, 2) - 1);
  $this_month = add_0((int) substr($prev_date, 5, 2));
  $next_month = add_0((int) substr($prev_date, 5, 2) + 1);
  if ($next_month == '13') {
    $next_month = '01';
  }
  if ($prev_month == '00') {
    $prev_month = '12';
  }

  $activedatestr1 = "";
  $activedatestr2 = "";
  $view = 'bigcalendarweek';
  $views = explode(',', $view_select);
  $defaultview = 'week';
  array_pop($views);
  $display = '';
  if (count($views) == 0) {
    $display = "display:none";
  }
  if(count($views) == 1 && $views[0] == $defaultview) {
    $display = "display:none";
  }
  
  $date_format_array = explode('/', $header_format); 
  for ($i = 0; $i < 4; $i++) {
    if (isset($date_format_array[$i]) && ($date_format_array[$i] == 'w' || $date_format_array[$i] == 'y')) 
      unset($date_format_array[$i]);
    if (isset($date_format_array[$i]) && $date_format_array[$i] == 'm') 
      $date_format_array[$i] = 'F';
  }
  $header_date_format = implode(' ', $date_format_array);
  $start_month = date($header_date_format, strtotime($week_days[0])); 
  $end_month = date($header_date_format, strtotime($week_days[6])); 
  $exp_start_month = explode(' ', $start_month); 
  $exp_end_month = explode(' ', $end_month); 
  for($j = 0; $j < count($exp_start_month); $j++){
	  $activedatestr1 .= __($exp_start_month[$j], 'sp_calendar') . ' ';
  } 
  for($j = 0; $j < count($exp_end_month); $j++){
	  $activedatestr2 .= __($exp_end_month[$j], 'sp_calendar') . ' ';
  } 
  $activedatestr = $activedatestr1 . '- ' . $activedatestr2;
  ?>
<html>
  <head>
  <style type='text/css'>
  
	#afterbig<?php echo $many_sp_calendar; ?> table,
	#bigcalendar<?php echo $many_sp_calendar; ?> table{
		font-family: Segoe UI;
		border: 0;
	}
  
  .week_list:last-child{
	  border-top-left-radius: <?php echo $border_radius2; ?>px !important;
	  border-top-right-radius: <?php echo $border_radius2; ?>px !important;
	  border-radius:<?php echo $border_radius2; ?>px !important;
	  border-bottom-left-radius: <?php echo $border_radius2; ?>px !important;
  }
  #TB_iframeContent{
		background-color: <?php echo $show_event_bgcolor; ?>;
	}

  .general_table table table:last-child .week_list .week_ev{
		border-bottom-left-radius:<?php echo $border_radius2?>px;
		
  }
	#bigcalendar<?php echo $many_sp_calendar; ?> .arrow-left {
		width: 0px;
		height: 0px;
		border-top: 15px solid transparent;
		border-bottom: 15px solid transparent;
		border-right: 20px solid;
		margin: 0 auto;	
	}
	
	#bigcalendar<?php echo $many_sp_calendar; ?> .arrow-right {
		width: 0px;
		height: 0px;
		border-top: 15px solid transparent;
		border-bottom: 15px solid transparent;
		border-left: 20px solid;
		margin: 0 auto;
	}
	#bigcalendar<?php echo $many_sp_calendar; ?> #views_select .arrow-right{
		border-top: 5px solid transparent;
		border-bottom: 5px solid transparent;
		border-left: 8px solid;
		left: 5px;
		position: relative;
	}
	#bigcalendar<?php echo $many_sp_calendar; ?> #views_select .arrow-down{
		width: 0px;
		height: 0px;
		border-left: 5px solid transparent;
		border-right: 5px solid transparent;
		border-top: 8px solid;
	}
    #bigcalendar<?php echo $many_sp_calendar; ?> td,
    #bigcalendar<?php echo $many_sp_calendar; ?> tr,
    #spiderCalendarTitlesList td, #spiderCalendarTitlesList tr {
      border: none !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .general_table {
      border-radius: <?php echo $border_radius; ?>px !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .top_table {
      border-top-left-radius: <?php echo $border_radius2; ?>px !important;
      border-top-right-radius: <?php echo $border_radius2; ?>px !important;
    }
		
	.general_table table tr:last-child >td:last-child{
	border-bottom-right-radius: <?php echo $border_radius2; ?>px;
	border-top-right-radius: <?php echo $border_radius2 ?>px;
	}
	
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:link,
    #bigcalendar .cala_arrow a:visited {
      text-decoration: none !important;
	  box-shadow: none !important;
      background: none !important;
      font-size: <?php echo $arrow_size; ?>px !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow {
      vertical-align: middle !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:hover {
      font-size: <?php echo $arrow_size_hover; ?>px !important;
      text-decoration: none !important;
      background: none !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:link,
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:visited {
      text-decoration: none !important;
      background: none !important;
      font-size: 12px !important;
      color: red;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:hover {
      text-decoration: none !important;
      background: none !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day {
      border: 1px solid  <?php echo $cell_border_color; ?> !important;
      <?php echo 'vertical-align:top !important;'; ?>
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .weekdays {
      vertical-align: middle !important;
      border: 1px solid <?php echo $cell_border_color; ?> !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .week_days {
      font-size: <?php echo $weekdays_font_size; ?>px !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calyear_table {
      border-spacing: 0 !important;
      width: 100% !important;
    }
    .calyear_table table #bigcalendar<?php echo $many_sp_calendar; ?> .calmonth_table {
      border-spacing: 0 !important;
      width: 100% !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calbg, #bigcalendar .calbg td {
      text-align: center !important;
      width: 14% !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .caltext_color_other_months {
      color: <?php echo $text_color_other_months; ?> !important;
      border: 1px solid <?php echo $cell_border_color; ?> !important;
      <?php echo 'vertical-align:top !important;'; ?>
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .caltext_color_this_month_unevented {
      color: <?php echo $text_color_this_month_unevented; ?> !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calfont_year {
      font-size: 24px !important;
      font-weight: bold !important;
      color: <?php echo $text_color_year; ?> !important;
    }
    .general_table table, .general_table td, .general_table tr {
      border: inherit !important;
      vertical-align: initial !important;
      border-collapse: inherit !important;
      margin: inherit !important;
      padding: inherit !important;
    }
    .general_table {
      border-collapse: inherit !important;
      margin: inherit !important;
    }
    .general_table p {
      margin: inherit !important;
      padding: inherit !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calsun_days {
      color: <?php echo $sun_days; ?> !important;
      border: 1px solid <?php echo $cell_border_color; ?> !important;
      <?php echo 'vertical-align:top !important; text-align:left !important;'; ?>
      background-color: <?php echo $sundays_bg_color; ?> !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calbottom_border {

    }
    #TB_window {
      z-index: 10000;
    }

    #bigcalendar<?php echo $many_sp_calendar; ?> td {
      vertical-align: middle !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> table {
      border-collapse: initial;
      border:0px;
      max-width: none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> table tr:hover td {
      background: none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> table td {
      padding: 0px;
      vertical-align: none;
      border-top:none;
      line-height: none;
      text-align: none;
	  background: transparent;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> p, ol, ul, dl, address {
      margin-bottom:0;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> td,
    #bigcalendar<?php echo $many_sp_calendar; ?> tr,
    #spiderCalendarTitlesList td,
    #spiderCalendarTitlesList tr {
      border:none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .general_table {
      border-radius: <?php echo $border_radius; ?>px;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .top_table {
      border-top-left-radius: <?php echo $border_radius2; ?>px;
      border-top-right-radius: <?php echo $border_radius2; ?>px;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:link,
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:visited {
      text-decoration:none !important;
      background:none;
      font-size: <?php echo $arrow_size; ?>px;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:hover {
      text-decoration:none;
      background:none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:link,
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:visited {
      text-decoration:none;
      background:none;
      font-size:12px;
      color:red;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:hover {
      text-decoration:none;
      background:none;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .cala_day {
      border:1px solid <?php echo $cell_border_color; ?>;
      vertical-align:top;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .weekdays {
      border:1px solid <?php echo $cell_border_color; ?>;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .week_days {
      font-size:<?php echo $weekdays_font_size; ?>px;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calyear_table {
      border-spacing:0;
      width:100%;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calmonth_table {	
      border-spacing:0;
      width:100%;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calbg,
    #bigcalendar<?php echo $many_sp_calendar; ?> .calbg td {
      text-align:center;
      width:14%;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .caltext_color_other_months {
      color:<?php echo $text_color_other_months; ?>;
      border:1px solid <?php echo $cell_border_color; ?>;
      vertical-align:top;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .caltext_color_this_month_unevented {
      color:<?php echo $text_color_this_month_unevented; ?>;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calfont_year {
      font-size:24px;
      font-weight:bold;
      color:<?php echo $text_color_year; ?>;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .calsun_days {
      color:<?php echo $sun_days; ?>;
      border:1px solid <?php echo $cell_border_color; ?>;
      vertical-align:top;
      text-align:left;
      background-color:<?php echo $sundays_bg_color; ?> !important;
    }
    #bigcalendar<?php echo $many_sp_calendar; ?> .views {
      float: right;
      background-color: <?php echo $views_tabs_bg_color; ?> !important;
      min-height: 25px;
      min-width: 70px;
      margin-left: 2px;
      text-align: center;
      cursor:pointer;
      position: relative;
      top: 5px;
    }
	#afterbig<?php echo $many_sp_calendar; ?> .views span,
	#bigcalendar<?php echo $many_sp_calendar; ?> .views span{
		line-height: 30px;
	}
	
#bigcalendar<?php echo $many_sp_calendar; ?> .views_select ,
#bigcalendar<?php echo $many_sp_calendar; ?> #views_select
{

background-color: <?php echo $views_tabs_bg_color?>  !important;
width: 120px;
text-align: center;
cursor: pointer;
padding: 6px;
position: relative;
}


#drop_down_views
{
	list-style-type:none !important;
	position: absolute;
	top: 46px;
	left: 0px;
	display:none;
	z-index: 4545;
	margin-left: 0;
}

#drop_down_views >li:hover .views_select, #drop_down_views >li.active .views_select
{
	background: <?php echo $bg_top ?> !important;
}

#drop_down_views >li
{
	border-bottom:1px solid #fff !important;
}


#views_tabs_select 
{
	display:none;
}

  </style>
 </head>
 <body>
  <div  id="afterbig<?php echo $many_sp_calendar; ?>" style="<?php echo $display ?>">
  <div style="width:100%;">
    <table  cellpadding="0" cellspacing="0" style="width:100%;">
      <tr>
        <td>
          <div id="views_tabs" style="width: 100%;<?php echo $display; ?>">
            <div class="views" style="<?php if (!in_array('day', $views) AND $defaultview != 'day') echo 'display:none;'; if ($view == 'bigcalendarday') echo 'background-color:' . $bg_top . ' !important;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_day',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))) . '-' . date('d'),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
				'rand' => $many_sp_calendar,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="top: -3px; position: relative; color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('Day', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="<?php if (!in_array('week', $views) AND $defaultview != 'week') echo 'display:none;'; if ($view == 'bigcalendarweek') echo 'background-color:' . $bg_top . ' !important;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_week',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                'date' => $year . '-' . add_0((Month_num($month))) . '-' . date('d'),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
				'rand' => $many_sp_calendar,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('Week', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="<?php if (!in_array('list', $views) AND $defaultview != 'list') echo 'display:none;'; if ($view == 'bigcalendarlist') echo 'background-color:' . $bg_top . ' !important;top:0;' ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_list',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
				'rand' => $many_sp_calendar,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="top: -3px; position: relative; color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('List', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="<?php if (!in_array('month', $views) AND $defaultview != 'month') echo 'display:none;'; if ($view == 'bigcalendarmonth') echo 'background-color:' . $bg_top . ' !important;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_month',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
				'rand' => $many_sp_calendar,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="top: -3px; position: relative;color:<?php echo $views_tabs_text_color; ?>;font-size:<?php echo $views_tabs_font_size; ?>px"><?php echo __('Month', 'sp_calendar'); ?></span>
            </div>
          </div>
<div id="views_tabs_select" style="display:none" >
<div  id="views_select" style="background-color:<?php echo $bg_top?> !important;color:<?php echo $views_tabs_text_color ?> !important;font-size:<?php echo $views_tabs_font_size  ?>px">
<?php if($view=='bigcalendarday') echo 'Day'; ?>
<?php if($view=='bigcalendarmonth') echo 'Month'; ?>
<?php if($view=='bigcalendarweek') echo 'Week'; ?>
<?php if($view=='bigcalendarlist') echo 'List'; ?>
<div class="arrow-right show_arrow"></div>
<div class="arrow-down"></div>
</div>
<ul id="drop_down_views" style="float: left;top: inherit;left: -20px;margin-top: 0px;">
<li <?php if($view=='bigcalendarday'):?> class="active" <?php endif; ?>  style="<?php if(!in_array('day',$views) AND $defaultview!='day' ) echo 'display:none;' ; ?>">
<div class="views_select"   
				onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_day',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year.'-'.add_0((Month_num($month))).'-'.date('d'),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"  >
<span style="position:relative;top:25%;color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px">Day</span>
</div>
</li>

<li <?php if($view=='bigcalendarweek'):?> class="active" <?php endif; ?> style="<?php if(!in_array('week',$views) AND $defaultview!='week' ) echo 'display:none;' ; ?>" ><div class="views_select"  
			onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_week',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                'date' => $year . '-' . add_0((Month_num($month))) . '-' . date('d'),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')">
	<span style="position:relative;top:25%;color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px">Week</span>
</div>
</li>

<li <?php if($view=='bigcalendarlist'):?> class="active" <?php endif; ?> style="<?php if(!in_array('list',$views) AND $defaultview!='list' ) echo 'display:none;' ;?>"><div class="views_select"   
			onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_list',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" >
<span style="position:relative;top:25%;color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px">List</span>
</div>
</li>

<li <?php if($view=='bigcalendarmonth'):?> class="active" <?php endif; ?>  style="<?php if(!in_array('month',$views) AND $defaultview!='month' ) echo 'display:none;'; ?>"><div class="views_select"   
			onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_month',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" >
<span style="position:relative;top:25%;color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px">Month</span></div></li>

</ul>
</div>
        </td>
      </tr>
      <tr>
        <td>
          <table cellpadding="0" cellspacing="0" class="general_table"  style="border-spacing:0; width:100%;border:<?php echo $border_color; ?> solid <?php echo $border_width; ?>px; margin:0; padding:0;background-color:<?php echo $bg_bottom; ?> !important;">
            <tr>
              <td width="100%" style="padding:0; margin:0">
                <table cellpadding="0" cellspacing="0" border="0" style="border-spacing:0; font-size:12px; margin:0; padding:0; width:100%;">
                  <tr style="height:40px; width:100%;">
                    <td class="top_table" align="center" colspan="7" style="position: relative;padding:0; margin:0; background-color:<?php echo $bg_top; ?>;height:20px; background-repeat: no-repeat;background-size: 100% 100%;">
                      <table cellpadding="0" cellspacing="0" border="0" align="center" class="calyear_table" style="margin:0; padding:0; text-align:center; width:100%; height:<?php echo $top_height; ?>px;">
                        <tr>
                          <td style="width:100%;vertical-align:center">
                            <table style="width:100%;">
                              <tr>
                                <td width="15%">
                                  <div onclick="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php 
                                    echo add_query_arg(array(
                                      'action' => 'spiderbigcalendar_' . $defaultview,
                                      'theme_id' => $theme_id,
                                      'calendar' => $calendar_id,
                                      'select' => $view_select,
                                      'date' => ($year - 1) . '-' . add_0((Month_num($month))) . '-' . date('d'),
                                      'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                                      'many_sp_calendar' => $many_sp_calendar,
                                      'cur_page_url' => $path_sp_cal,
									  'cat_id' => '',
									  'cat_ids' => $cat_ids,
                                      'widget' => $widget,
                                      ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" style="text-align:center; cursor:pointer; width:100%; background-color: <?php echo hex_to_rgb($views_tabs_bg_color, 0.4) ?>;">
                                    <span style="font-size:18px; color:#FFF"><?php echo $year - 1; ?></span>
                                  </div>
                                </td>
                                <td class="cala_arrow" width="11%"  style="text-align:right;margin:0px;padding: 0px 30px 0px 0px !important;">
                                  <a style="text-shadow: 1px 1px 2px black;color:<?php echo $color_arrow_month; ?>;" href="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php
                                    echo add_query_arg(array(
                                      'action' => 'spiderbigcalendar_' . $defaultview,
                                      'theme_id' => $theme_id,
                                      'calendar' => $calendar_id,
                                      'select' => $view_select,
                                      'date' => $prev_date,
                                      'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                                      'many_sp_calendar' => $many_sp_calendar,
                                      'cur_page_url' => $path_sp_cal,
									  'cat_id' => '',
									  'cat_ids' => $cat_ids,
                                      'widget' => $widget,
                                      ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')">&#10096;
                                  </a>
                                </td>										  
                                <td style="text-align:center; margin:0;" width="40%">
                                  <input type="hidden" name="month" readonly="" value="<?php echo $month; ?>"/>
                                  <span style="line-height: 30px;font-family:arial; color:<?php echo $text_color_month; ?>; font-size:<?php echo $month_font_size; ?>px;text-shadow: 1px 1px black;"><?php echo $activedatestr; ?></span>
                          		</td>
                                <td style="margin:0; padding: 0px 0px 0px 30px !important; text-align:left" width="11%" class="cala_arrow">
                                  <a style="text-shadow: 1px 1px 2px black;color:<?php echo $color_arrow_month; ?>" href="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php
                                    echo add_query_arg(array(
                                      'action' => 'spiderbigcalendar_' . $defaultview,
                                      'theme_id' => $theme_id,
                                      'calendar' => $calendar_id,
                                      'select' => $view_select,
                                      'date' => $next_date,
                                      'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                                      'many_sp_calendar' => $many_sp_calendar,
                                      'cur_page_url' => $path_sp_cal,
									  'cat_id' => '',
									  'cat_ids' => $cat_ids,
                                      'widget' => $widget,
                                      ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')">&#10097;
                                  </a>
                                </td>
                                <td width="15%">
                                  <div onclick="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php
                                    echo add_query_arg(array(
                                      'action' => 'spiderbigcalendar_' . $defaultview,
                                      'theme_id' => $theme_id,
                                      'calendar' => $calendar_id,
                                      'select' => $view_select,
                                      'date' => ($year + 1) . '-' . add_0((Month_num($month))) . '-' . date('d'),
                                      'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                                      'many_sp_calendar' => $many_sp_calendar,
                                      'cur_page_url' => $path_sp_cal,
									  'cat_id' => '',
									  'cat_ids' => $cat_ids,
                                      'widget' => $widget,
                                      ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" style="text-align:center; cursor:pointer; width:100%;  background-color: <?php echo hex_to_rgb($views_tabs_bg_color, 0.4) ?>;">
                                    <span style="font-size:18px; color:#FFF"><?php echo $year + 1; ?></span>
                                  </div>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                   
                  </tr>
                </tr>
                <tr>
                  <td>
  <?php
  $month_first_weekday = date("N", mktime(0, 0, 0, Month_num($month), 1, $year));
  if ($weekstart == "su") {
    $month_first_weekday++;
    if ($month_first_weekday == 8) {
      $month_first_weekday = 1;
    }
  }
  $month_days = date("t", mktime(0, 0, 0, Month_num($month), 1, $year));
  $last_month_days = date("t", mktime(0, 0, 0, Month_num($month) - 1, 1, $year));
  $last_month_days_count = date("t", mktime(0, 0, 0, Month_num($month) - 1, 1, $year));
  $weekday_i = $month_first_weekday;
  $last_month_days = $last_month_days - $weekday_i + 2;
  $percent = 1;
  $sum = $month_days - 8 + $month_first_weekday;
  if ($sum % 7 <> 0) {
    $percent = $percent + 1;
  }
  $sum = $sum - ($sum % 7);
  $percent = $percent + ($sum / 7);
  $percent = 107 / $percent;

  $all_calendar_files = php_getdays_for_three_months($calendar_id, $date, $months, $theme_id, $widget);

  $categories=$wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "spidercalendar_event_category WHERE published=1"); 
  $calendar = (isset($_GET['calendar']) ? (int)$_GET['calendar'] : ''); 
  
  $all_array_days = $all_calendar_files[0]['all_array_days'];
  $all_array_days1 = $all_calendar_files[0]['all_array_days1'];
  $all_title = $all_calendar_files[0]['all_title'];
  $all_ev_ids = $all_calendar_files[0]['all_ev_ids'];

  $prev_month = substr($months, 0, 2);
  $this_month = substr($months, 3, 2);
  $next_month = substr($months, 6, 2);
  $array_days = array();
  for ($i = 0; $i <= 6; $i++) {
    $day=substr($week_days[$i],8,2);
		$month=substr($week_days[$i],5,2);
		$year=substr($week_days[$i],0,4);
		
		switch($month)
			{
			case $prev_month:
			$array_days=$all_array_days[0];
			$array_days1=$all_array_days1[0];
			$title=$all_title[0];
			$ev_ids=$all_ev_ids[0];
			break;
			
			case $this_month:
			$array_days=$all_array_days[1];
			$array_days1=$all_array_days1[1];
			$title=$all_title[1];
			$ev_ids=$all_ev_ids[1];
			break;
			
			case $next_month:
			$array_days=$all_array_days[2];
			$array_days1=$all_array_days1[2];
			$title=$all_title[2];
			$ev_ids=$all_ev_ids[2];
			break;
			
			}

	
	
    sort($array_days, SORT_NUMERIC);
    $week_day = date('D', mktime(0, 0, 0, $month, (int) $day, $year));
	$month_name = month_name($month);
    echo '<table style="width:100%;border-spacing:0;">
            <tr>
              <td style="height:' . $date_height . 'px;font-size:' . $date_font_size . 'px; padding-left:10px;background-color:' . $date_bg_color . ' !important; color:#6E7276">
                <span style="padding-left:10px; font-size:' . $date_font_size . 'px; color:' . $week_font_color . '">' . week_convert($week_day) . '</span>
                <span style="font-size:' . $day_month_font_size . 'px;color:' . $day_month_font_color . '">(' . __($month_name,'sp_calendar') . ' ' . (int) $day . ')</span>
              </td>
              <tr>
                <td>';
    if (in_array((int) $day, $array_days)) {
      foreach($title as $key => $value) {
        if ($key == (int) $day) {
          $ev_id = explode('<br>', $ev_ids[$key]);
          array_pop($ev_id);
          $ev_ids_inline = implode(',', $ev_id);
          $ev_title = explode('</p>', $value);
          array_pop($ev_title);
          for ($j = 0; $j < count($ev_title); $j++) {
		   $queryy =$wpdb->prepare ("SELECT " . $wpdb->prefix . "spidercalendar_event_category.color AS color FROM " . $wpdb->prefix . "spidercalendar_event  JOIN " . $wpdb->prefix . "spidercalendar_event_category
	       ON " . $wpdb->prefix . "spidercalendar_event.category=" . $wpdb->prefix . "spidercalendar_event_category.id WHERE " . $wpdb->prefix . "spidercalendar_event.calendar=%d AND 
	       " . $wpdb->prefix . "spidercalendar_event.published='1' AND " . $wpdb->prefix . "spidercalendar_event_category.published='1' AND " . $wpdb->prefix . "spidercalendar_event.id=%d",$calendar,$ev_id[$j]);
		   
		   $cat_color = $wpdb->get_row($queryy);
		  
            if (($j + 1) % 2 == 0) {
              $color = $event_num_bg_color2;
              $table_color = $event_bg_color2;
            }
            else {
              $color = $event_num_bg_color1;
              $table_color = $event_bg_color1;
            }
			if(!isset($cat_color->color)) { $cat_color = new stdClass; $cat_color->color=$bg_top;};
            echo '<table style="height:' . $event_table_height . 'px;border-spacing:0;width: 100%;background-color:' . $table_color . ' !important"  class="week_list">
                    <tr>
                      <td class="week_ev" style="font-size:' . $event_num_font_size . 'px;font-weight:bold;width:15px;text-align:center;background-color: #' . str_replace('#','',$cat_color->color) . ' !important;color:' . $event_num_color . ' !important">' . (($show_numbers_for_events) ? ($j + 1) : '') . '</td>
                      <td>
                        <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="text-decoration:none;font-size:15px;background:none;color:' . $event_title_color . ';"
                          href="' . add_query_arg(array(
                            'action' => 'spidercalendarbig',
                            'theme_id' => $theme_id,
                            'calendar_id' => $calendar_id,
                            'ev_ids' => $ev_ids_inline,
                            'eventID' => $ev_id[$j],
                            'date' => $year . '-' . $month . '-' . (int) $day,
                            'many_sp_calendar' => $many_sp_calendar,
                            'cur_page_url' => $path_sp_cal,
                            'widget' => $widget,
                            'TB_iframe' => 1,
                            'tbWidth' => $popup_width,
                            'tbHeight' => $popup_height,
                            ), $site_url) . '"><b>' . $ev_title[$j] . '</b>
                        </a>
                      </td>
                    </tr>
                  </table>';
          }
        }
      }
    }
    else {
      echo '<table style="height:' . $event_table_height . 'px;border-spacing:0;width: 100%;background-color:' . $event_bg_color1 . '" class="week_list">
              <tr>
                <td class="week_ev" style="font-size:22px; font-weight:bold; width:15px;text-align:center;background-color:' . $event_num_bg_color1 . ' !important;color:' . $event_num_color . ' !important"></td>
                <td><p style="color:' . $event_title_color . '; border:none">&nbsp;' . __('There are no events on this date', 'sp_calendar') . '</p></td>
              </tr>
            </table>';
    }
    echo '</td></tr></table>';
  }
  ?>
                  </td>
                </tr>
              </table>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  <style>  
  @media only screen and (max-width : 640px) { 
	#views_tabs ,#drop_down_views
	{
		display:none;
	}

	#views_tabs_select
	{
		display:block !important;
	}
	}

	@media only screen and (max-width : 968px) { 
		#cats >li
		{
			float:none;
		}
	}
   
    .spider_categories{
		display:inline-block;
		cursor:pointer;
	}
	
	.spider_categories p{
		color: #fff;
		padding: 2px 10px !important;
		margin: 2px 0 !important;
		font-size: 14px;
		font-weight: 600;
	}
  </style>
  <?php

		//reindex cat_ids_array
$re_cat_ids_array = array_values($cat_ids_array);

for($i=0; $i<count($re_cat_ids_array); $i++)
{
echo'
<style>
#cats #category'.$re_cat_ids_array[$i].'
{
	text-decoration:underline;
	cursor:pointer;

}

</style>';

}



	if($cat_ids=='')
		$cat_ids='';
if($show_cat){
echo '<ul id="cats" style="list-style-type:none; padding: 0;">';

foreach($categories as $category)
{
	
?>

<li  class="spider_categories"><p id="category<?php echo $category->id ?>" style="background-color:#<?php echo str_replace('#','',$category->color); ?> !important" onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_week',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                'date' => $year . '-' . $month . '-' . add_0($day),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => $category->id,
				'cat_ids' => $cat_ids,
                'widget' => $widget,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"> <?php echo  $category->title ?></p></li>


<?php
} 
if (!empty($categories)) {
?>
<li  class="spider_categories"><p id="category0" style="background-color:#<?php echo str_replace('#','',$bg_top); ?> !important" onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_week',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'months' => $prev_month . ',' . $this_month . ',' . $next_month,
                'date' => $year . '-' . $month . '-' . add_0($day),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => '',
                'widget' => $widget,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"><?php echo __('All categories', 'sp_calendar'); ?></p></li>
<?php echo '</ul>';
}
} ?>
  </body>
</html>
<?php
  die();
}

?>