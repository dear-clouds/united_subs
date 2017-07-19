<?php
function big_calendar_month() {
  require_once("frontend_functions.php");
  global $wpdb;
  $widget = ((isset($_GET['widget']) && (int) $_GET['widget']) ? (int) $_GET['widget'] : 0);
  $many_sp_calendar = ((isset($_GET['many_sp_calendar']) && is_numeric(esc_html($_GET['many_sp_calendar']))) ? esc_html($_GET['many_sp_calendar']) : 1);
  $calendar_id = (isset($_GET['calendar']) ? (int) $_GET['calendar'] : '');
  $theme_id = (isset($_GET['theme_id']) ? (int) $_GET['theme_id'] : 30);
  $cat_id = (isset($_GET['cat_id']) ? esc_html($_GET['cat_id']) : '');
  $cat_ids = (isset($_GET['cat_ids']) ? esc_html($_GET['cat_ids']) : '');
  $date = ((isset($_GET['date']) && IsDate_inputed(esc_html($_GET['date']))) ? esc_html($_GET['date']) : '');
  $view_select = (isset($_GET['select']) ? esc_html($_GET['select']) : 'month,');
  $path_sp_cal = (isset($_GET['cur_page_url']) ? esc_html($_GET['cur_page_url']) : '');
  $query = "SELECT * FROM " . $wpdb->prefix . "spidercalendar_calendar where id=".$calendar_id."";
  $calendar = $wpdb->query($query);
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
  $themes = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme');
  $theme_name = $theme->title;
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
  $arrow_size = $theme->arrow_size;
  $arrow_size_hover = $arrow_size + 5;
  $next_month_text_color = '#' . str_replace('#','',$theme->next_month_text_color);
  $prev_month_text_color = '#' . str_replace('#','',$theme->prev_month_text_color);
  $next_month_arrow_color = '#' . str_replace('#','',$theme->next_month_arrow_color);
  $prev_month_arrow_color = '#' . str_replace('#','',$theme->prev_month_arrow_color);
  $next_month_font_size = $theme->next_month_font_size;
  $prev_month_font_size = $theme->prev_month_font_size;
  $month_type = $theme->month_type;
  $header_format = (isset($theme->header_format) ? $theme->header_format : 'w/d/m/y');
  $ev_title_bg_color = '#' . str_replace('#','',$theme->ev_title_bg_color);

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
  $show_numbers_for_events = $theme->number_of_shown_evetns;
  $show_cat = $theme->show_cat;
  $text_color_year = '#' . str_replace('#','',$theme->text_color_year);
  $ev_color = '#' . str_replace('#','',$theme->event_title_color);
  $show_event_bgcolor = '#' . str_replace('#','',$theme->show_event_bgcolor);

  
  $themes_titles = array('1' => 'Wasabi', '2' => 'Bluejay and Orange', '3' => 'White and Blue', '4' => 'Dark', '5' => 'Red and Olive', '6' => 'Blue and Bisque', '7' => 'White and OliveDrab', '8' => 'DarkCyan and Violet', '9' => 'SteelBlue', '10' => 'PaleGreen', '11' => 'Gold and Brown', '13' => 'Shiny Blue', '12' => 'Shiny Red', '14' => 'Shiny Green', '17' => 'Shiny Orange', '18' => 'Shiny Pink', '19' => 'Shiny Purple'); 
  
  if (isset($themes_titles[$theme_id]) && $themes_titles[$theme_id] == $theme_name && count($themes)>13) {
	$date_bgcolor = "transparent";
	$years_bgcolor = "background-color: #000000; filter: alpha(opacity=30); opacity: 0.3;";
  }
  else {
	  $date_bgcolor = $cell_border_color; 
	  $years_bgcolor = "background-color: ".hex_to_rgb($views_tabs_bg_color, 0.4).";";
  }
  
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
  $cell_width = (int) $cell_width - 2;
  
  $this_month = substr($year . '-' . add_0((Month_num($month))), 5, 2);
  $prev_month = add_0((int) $this_month - 1);
  $next_month = add_0((int) $this_month + 1);
  $activedatestr = "";
  
  $date_format_array = explode('/', $header_format); 
  for ($i = 0; $i < 4; $i++) {
    if (isset($date_format_array[$i]) && ($date_format_array[$i] == 'd' || $date_format_array[$i] == 'w')) { 
		unset($date_format_array[$i]);
	}
	if (isset($date_format_array[$i]) && $date_format_array[$i] == 'm')  $date_format_array[$i] = 'F';
    if (isset($date_format_array[$i]) && $date_format_array[$i] == 'y')  $date_format_array[$i] = 'Y';
  }
  $header_date_format = implode(' ', $date_format_array);
  $name_year = date($header_date_format, strtotime($date)); 
  $exp_name_year = explode(' ', $name_year); 
  for($j = 0; $j < count($exp_name_year); $j++){
	  $activedatestr .= __($exp_name_year[$j], 'sp_calendar') . ' ';
  } 

  $view = 'bigcalendarmonth';
  $views = explode(',', $view_select);
  $defaultview = 'month';
  array_pop($views);
 
  $display='';

if(count($views)==0)
{
$display="display:none";
echo '<style>
@media only screen and (max-width : 640px) { 
 
#views_tabs_select
{
	display:none !important;
}
}

</style>';
}
if(count($views)==1 and $views[0]==$defaultview)
{
$display="display:none";
echo '<style>
@media only screen and (max-width : 640px) { 
 
#views_tabs_select
{
	display:none !important;
}
}

</style>';
}
?>
<html>
  <head>
	  <style type='text/css'> 
		#afterbig<?php echo $many_sp_calendar; ?> table,
		#bigcalendar<?php echo $many_sp_calendar; ?> table{
			font-family: Segoe UI;
			border: 0;
		}
		
		#afterbig<?php echo $many_sp_calendar; ?> table,
		#bigcalendar<?php echo $many_sp_calendar; ?> table{
						
		}
		
		#TB_iframeContent{
			background-color: <?php echo $show_event_bgcolor; ?>;
		}
	  
		#TB_window {
		  z-index: 10000;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .calyear_table td,
		#bigcalendar<?php echo $many_sp_calendar; ?> .calyear_table td {
		  vertical-align: middle !important;
		}
		
		#afterbig<?php echo $many_sp_calendar; ?> table td,
		#bigcalendar<?php echo $many_sp_calendar; ?> table td {
		  padding: 0px;
		  vertical-align: none;
		  border-bottom:none;
		  line-height: none;
		  text-align: none;
		  background: transparent;
		}
		
		#afterbig<?php echo $many_sp_calendar; ?> p, ol, ul, dl, address,
		#bigcalendar<?php echo $many_sp_calendar; ?> p, ol, ul, dl, address {
		  margin-bottom:0;
		}
		#afterbig<?php echo $many_sp_calendar; ?> td,
		#afterbig<?php echo $many_sp_calendar; ?> tr,
		#bigcalendar<?php echo $many_sp_calendar; ?> td,
		#bigcalendar<?php echo $many_sp_calendar; ?> tr,
		#spiderCalendarTitlesList td,
		#spiderCalendarTitlesList tr {
		  border:none;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .arrow-left,
		#bigcalendar<?php echo $many_sp_calendar; ?> .arrow-left {
			width: 0px;
			height: 0px;
			border-bottom: 15px solid transparent;
			border-bottom: 15px solid transparent;
			border-right: 20px solid;
			margin: 0 auto;	
		}
		
		#afterbig<?php echo $many_sp_calendar; ?> .arrow-right,
		#bigcalendar<?php echo $many_sp_calendar; ?> .arrow-right {
			width: 0px;
			height: 0px;
			border-bottom: 15px solid transparent;
			border-bottom: 15px solid transparent;
			border-left: 20px solid;
			margin: 0 auto;
		}
		
		 #bigcalendar<?php echo $many_sp_calendar ?> .cala_arrow a:hover {
		  text-decoration: none !important;
		  background: none !important;
		}
		
		#afterbig<?php echo $many_sp_calendar; ?> #views_select .arrow-right,
		#bigcalendar<?php echo $many_sp_calendar; ?> #views_select .arrow-right{
			border-bottom: 5px solid transparent;
			border-bottom: 5px solid transparent;
			border-left: 8px solid;
			left: 5px;
			position: relative;
		}
		#afterbig<?php echo $many_sp_calendar; ?> #views_select .arrow-down,
		#bigcalendar<?php echo $many_sp_calendar; ?> #views_select .arrow-down{
			width: 0px;
			height: 0px;
			border-left: 5px solid transparent;
			border-right: 5px solid transparent;
			border-bottom: 8px solid;
		}
		
		#afterbig<?php echo $many_sp_calendar; ?> .general_table
		#bigcalendar<?php echo $many_sp_calendar; ?> .general_table {
		  border-radius: <?php echo $border_radius; ?>px;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .top_table,
		#bigcalendar<?php echo $many_sp_calendar; ?> .top_table {
		  border-bottom-left-radius: <?php echo $border_radius2; ?>px;
		  border-bottom-right-radius: <?php echo $border_radius2; ?>px;
		}
		
		#afterbig<?php echo $many_sp_calendar; ?> .general_table table tr:last-child >td:first-child,
		#bigcalendar<?php echo $many_sp_calendar; ?> .general_table table tr:last-child >td:first-child{
			border-bottom-left-radius: <?php echo $border_radius2; ?>px;
		}
		
		 #afterbig<?php echo $many_sp_calendar; ?> .general_table table tr:last-child >td:last-child,
		 #bigcalendar<?php echo $many_sp_calendar; ?> .general_table table tr:last-child >td:last-child{
			border-bottom-right-radius: <?php echo $border_radius2; ?>px;
		}
		
		#afterbig<?php echo $many_sp_calendar; ?> .cala_arrow a:link,
		#afterbig<?php echo $many_sp_calendar; ?> .cala_arrow a:visited,
		#bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:link,
		#bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:visited {
		  text-decoration:none !important;
		  box-shadow: none !important;
		  background:none;
		  font-size: <?php echo $arrow_size; ?>px;
		  border: 0 !important;
		  box-shadow: none;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .cala_arrow a:hover,
		#bigcalendar<?php echo $many_sp_calendar; ?> .cala_arrow a:hover {
		  text-decoration:none;
		  background:none;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .cala_day a:link,
		#afterbig<?php echo $many_sp_calendar; ?> .cala_day a:visited,
		#bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:link,
		#bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:visited {
		  text-decoration:none;
		  background:none;
		  font-size:12px;
		  box-shadow: none;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .cala_day a:hover,
		#bigcalendar<?php echo $many_sp_calendar; ?> .cala_day a:hover {
		  text-decoration:none;
		  background:none;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .cala_day,
		#bigcalendar<?php echo $many_sp_calendar; ?> .cala_day {
		  border-bottom:1px solid <?php echo $cell_border_color; ?> !important;
		  border-left:1px solid <?php echo $cell_border_color; ?> !important;
		  vertical-align:top;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .weekdays,
		#bigcalendar<?php echo $many_sp_calendar; ?> .weekdays {
		  border-bottom: 1px solid <?php echo $cell_border_color; ?> !important;
		  border-left: 1px solid <?php echo $cell_border_color; ?> !important;
		  vertical-align: middle;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .week_days,
		#bigcalendar<?php echo $many_sp_calendar; ?> .week_days {
		  font-size:<?php echo $weekdays_font_size; ?>px;
		   font-weight: 600;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .calyear_table,
		#bigcalendar<?php echo $many_sp_calendar; ?> .calyear_table {
		  border-spacing:0;
		  width:100%;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .calmonth_table,
		#bigcalendar<?php echo $many_sp_calendar; ?> .calmonth_table {	
		  border-spacing:0;
		  width:100%;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .calbg,
		#afterbig<?php echo $many_sp_calendar; ?> .calbg td,
		#bigcalendar<?php echo $many_sp_calendar; ?> .calbg,
		#bigcalendar<?php echo $many_sp_calendar; ?> .calbg td {
		  text-align:center;
		  width:14%;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .caltext_color_other_months,
		#bigcalendar<?php echo $many_sp_calendar; ?> .caltext_color_other_months {
		  color:<?php echo $text_color_other_months; ?>;
		  border-bottom:1px solid <?php echo $cell_border_color; ?> !important;
		  border-left:1px solid <?php echo $cell_border_color; ?> !important;
		  vertical-align:top;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .caltext_color_this_month_unevented,
		#bigcalendar<?php echo $many_sp_calendar; ?> .caltext_color_this_month_unevented {
		  color:<?php echo $text_color_this_month_unevented; ?>;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .calfont_year,
		#bigcalendar<?php echo $many_sp_calendar; ?> .calfont_year {
		  font-size:24px;
		  font-weight:bold;
		  color:<?php echo $text_color_year; ?>;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .calsun_days,
		#bigcalendar<?php echo $many_sp_calendar; ?> .calsun_days {
		  color:<?php echo $sun_days; ?>;
		  border-bottom:1px solid <?php echo $cell_border_color; ?> !important;
		  border-left:1px solid <?php echo $cell_border_color; ?> !important;
		  vertical-align:top;
		  text-align:left;
		  background-color: <?php echo $sundays_bg_color; ?> !important;
		  font-weight: 600;
		}
		#afterbig<?php echo $many_sp_calendar; ?> .views,
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
		
		#afterbig<?php echo $many_sp_calendar; ?> .views_select ,
		#afterbig<?php echo $many_sp_calendar; ?> #views_select,
		#bigcalendar<?php echo $many_sp_calendar; ?> .views_select ,
		#bigcalendar<?php echo $many_sp_calendar; ?> #views_select
		{
			background-color: <?php echo $views_tabs_bg_color ?> !important;
			width: 120px;
			text-align: center;
			cursor: pointer;
			padding: 6px;
			position: relative;
		}

		#afterbig<?php echo $many_sp_calendar; ?> #views_select,
		#bigcalendar<?php echo $many_sp_calendar; ?> #views_select
		{
			min-height: 30px;
		}

		#drop_down_views
		{
			list-style-type:none !important;
			display:none;
			z-index: 4545;
			position: absolute;
			left: 0 !important;
			margin-left: 0;
		}

		#drop_down_views >li:hover .views_select, #drop_down_views >li.active .views_select
		{
			background:<?php echo $bg_top ?> !important;
		}

		#drop_down_views >li
		{
			border-bottom:1px solid #fff !important;
		}


		#views_tabs_select 
		{
			display:none;
		}
		#cal_event p{
			color:<?php echo $ev_color;?>;
			line-height: 15px;
		}
		
		.general_table table tr > td:last-child{
			border-right: 1px solid <?php echo $cell_border_color; ?> !important;
		} 
	  </style>
	</head>
	<body>
  <div  id="afterbig<?php echo $many_sp_calendar; ?>" style="<?php echo $display ?>">
  <div style="width:100%;">
    <table cellpadding="0" cellspacing="0" style="width:100%;">
      <tr>
        <td>		
          <div id="views_tabs" style="<?php echo $display ?>;width: 100%;">
            <div class="views" style="<?php if (!in_array('day', $views) AND $defaultview != 'day') echo 'display:none;'; if ($view == 'bigcalendarday') echo 'background-color:' . $bg_top . ' !important;top:0;' ?>"
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
            <div class="views" style="<?php if (!in_array('week', $views) AND $defaultview != 'week') echo 'display:none;'; if ($view == 'bigcalendarweek') echo 'background-color:' . $bg_top . ' !important;top:0;' ?>"
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
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="top: -3px; position: relative; color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('Week', 'sp_calendar'); ?></span>
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
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"><span style="top: -3px; position: relative; color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('List', 'sp_calendar'); ?></span>
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
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="color:<?php echo $views_tabs_text_color ?>;font-size:<?php echo $views_tabs_font_size  ?>px"><?php echo __('Month', 'sp_calendar'); ?></span>
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
              <td width="100%" style="padding:0; margin:0;">
                <table cellpadding="0" cellspacing="0" border="0" style="border-spacing:0; font-size:12px; margin:0; padding:0; width:100%;">
                  <tr style="height:40px; width:100%;">
                    <td class="top_table" align="center" colspan="7" style="position: relative;padding:0; margin:0; background-color:<?php echo $bg_top; ?>;height:20px; background-repeat: no-repeat;background-size: 100% 100%; border: 0 !important;">
                      <table cellpadding="0" cellspacing="0" border="0" align="center" class="calyear_table" style="margin:0; padding:0; text-align:center; width:100%; height:<?php echo $top_height; ?>px;">
                        <tr>
                          <td width="10%">
                            <div onclick="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php 
                              echo add_query_arg(array(
                                'action' => 'spiderbigcalendar_' . $defaultview,
                                'theme_id' => $theme_id,
                                'calendar' => $calendar_id,
                                'select' => $view_select,
                                'date' => ($year - 1) . '-' . add_0(Month_num($month)),
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
								'cat_id' => '',
								'cat_ids' => $cat_ids,
                                'widget' => $widget,
                                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" style="text-align:center; cursor:pointer; width:100%; <?php echo $years_bgcolor; ?>;">
                              <span style="font-size:18px;color:#FFF"><?php echo $year - 1; ?></span>
                            </div>
                          </td>
                          <td class="cala_arrow" width="11%" style="text-align:right;margin:0px; padding: 0px 30px 0px 0px;">
                            <a style="text-shadow: 1px 1px 2px black;color:<?php echo $color_arrow_month ?>;" href="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php
                              if (Month_num($month) == 1) {
                                $needed_date = ($year - 1) . '-12';
                              }
                              else {
                                $needed_date = $year . '-' . add_0((Month_num($month) - 1));
                              }
                              echo add_query_arg(array(
                                'action' => 'spiderbigcalendar_' . $defaultview,
                                'theme_id' => $theme_id,
                                'calendar' => $calendar_id,
                                'select' => $view_select,
                                'date' => $needed_date,
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
								'cat_id' => '',
								'cat_ids' => $cat_ids,
                                'widget' => $widget,
                                ), $site_url);
                              ?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')">&#10096;
                            </a>
                          </td>
                          <td style="text-align:center; margin:0;" width="10%">
                            <input type="hidden" name="month" readonly="" value="<?php echo $month; ?>"/>
                            <span style="line-height: 30px;font-family: Segoe UI; color:<?php echo $text_color_month; ?>; font-size:<?php echo $month_font_size; ?>px;text-shadow: 1px 1px  black;"><?php echo $activedatestr; ?></span>
                          </td>
                          <td style="margin:0; padding: 0px 0px 0px 30px;text-align:left" width="11%" class="cala_arrow">
                            <a style="text-shadow: 1px 1px 2px black; color:<?php echo $color_arrow_month; ?>" href="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php
                              if (Month_num($month) == 12) {
                                $needed_date = ($year + 1) . '-01';
                              }
                              else {
                                $needed_date = $year . '-' . add_0((Month_num($month) + 1));
                              }
                              echo add_query_arg(array(
                                'action' => 'spiderbigcalendar_' . $defaultview,
                                'theme_id' => $theme_id,
                                'calendar' => $calendar_id,
                                'select' => $view_select,
                                'date' => $needed_date,
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
								'cat_id' => '',
								'cat_ids' => $cat_ids,
                                'widget' => $widget,
                                ), $site_url);
                              ?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')">&#10097;
                            </a>
                          </td>
                          <td width="10%" style="border: 0 !important;">
                            <div onclick="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>','<?php 
                              echo add_query_arg(array(
                                'action' => 'spiderbigcalendar_' . $defaultview,
                                'theme_id' => $theme_id,
                                'calendar' => $calendar_id,
                                'select' => $view_select,
                                'date' => ($year + 1) . '-' . add_0(Month_num($month)),
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
								'cat_id' => '',
								'cat_ids' => $cat_ids,
                                'widget' => $widget,
                                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" style="text-align:center; cursor:pointer; width:100%; <?php echo $years_bgcolor; ?>;">
                              <span style="font-size:18px;color:#FFF"><?php echo $year + 1; ?></span>
                            </div>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr align="center" height="<?php echo $week_days_cell_height; ?>" style="background-color:<?php echo $weekdays_bg_color; ?> !important;">
                    <?php if ($weekstart == "su") { ?>
                      <td class="weekdays" style="width:14.2857143%; color:<?php echo $color_week_days;?>; margin:0; padding:0;background-color:<?php echo $weekday_sunday_bg_color; ?> !important">
                        <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"><?php echo __('Su', 'sp_calendar'); ?> </b></div>
                      </td>
                    <?php } ?>
                    <td class="weekdays" style="width:14.2857143%; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"><?php echo __('Mo', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:14.2857143%; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"><?php echo __('Tu', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:14.2857143%; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"><?php echo __('We', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:14.2857143%; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center;margin:0; padding:0;"><b class="week_days"><?php echo __('Th', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:14.2857143%; color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center;margin:0; padding:0;"><b class="week_days"><?php echo __('Fr', 'sp_calendar'); ?> </b></div>
                    </td>
                    <td class="weekdays" style="width:14.2857143%;	color:<?php echo $color_week_days; ?>; margin:0; padding:0">
                      <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"><?php echo __('Sa', 'sp_calendar'); ?> </b></div>
                    </td>
                    <?php if ($weekstart == "mo") { ?>			 
                    <td class="weekdays" style="width:14.2857143%; color:<?php echo $color_week_days;?>; margin:0; padding:0;background-color:<?php echo $weekday_sunday_bg_color; ?> !important">
                      <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"><?php echo __('Su', 'sp_calendar'); ?> </b></div>
                    </td>
                    <?php } ?>
                  </tr>
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
  $all_calendar_files = php_getdays($show_numbers_for_events, $calendar_id, $date, $theme_id, $widget);
  $array_days = $all_calendar_files[0]['array_days'];
  $array_days1 = $all_calendar_files[0]['array_days1'];
  $title = $all_calendar_files[0]['title'];
  $ev_ids = $all_calendar_files[0]['ev_ids'];
  $categories=$wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "spidercalendar_event_category WHERE published=1"); 
  $calendar = (isset($_GET['calendar']) ? (int)$_GET['calendar'] : '');
  
  echo '          <tr id="days"  height="' . $cell_height . '" style="line-height:15px;">';
  for ($i = 1; $i < $weekday_i; $i++) {
    echo '          <td class="caltext_color_other_months" style="background-color:' . $bg_color_other_months . ' !important">
                      <p style="padding-right: 7px; font-size:' . $other_days_font_size . 'px; font-weight: 600;line-height:1.4;font-family: Segoe UI;padding-left: 5px;background: '.$date_bgcolor.' !important; width: 100%; padding-right: 6px;">' . $last_month_days . '</p>
                    </td>';
    $last_month_days = $last_month_days + 1;
  }
  ///////////////////////////////////////////////////////////////////////
  
  function category_color($event_id)
{

	global $wpdb;
	$calendar = (isset($_GET['calendar']) ? (int)$_GET['calendar'] : '');

	$query = $wpdb->prepare ("SELECT " . $wpdb->prefix . "spidercalendar_event_category.color AS color FROM " . $wpdb->prefix . "spidercalendar_event  JOIN " . $wpdb->prefix . "spidercalendar_event_category ON " . $wpdb->prefix . "spidercalendar_event.category=" . $wpdb->prefix . "spidercalendar_event_category.id WHERE " . $wpdb->prefix . "spidercalendar_event.calendar=%d AND  " . $wpdb->prefix . "spidercalendar_event.published='1' AND " . $wpdb->prefix . "spidercalendar_event_category.published='1' AND " . $wpdb->prefix . "spidercalendar_event.id=%d",$calendar,$event_id);

	
		$colors=$wpdb->get_results($query);

		if(!empty($colors))
		$color=$colors[0]->color;
		else $color = "";
		
		$theme_id = (isset($_GET['theme_id']) ? (int) $_GET['theme_id'] : '');
		   
	return '#'.$color;		
}


function style($title, $color,$ev_height){
	$new_title = html_entity_decode(strip_tags($title));
	$number = $new_title[0];
	$first_letter =$new_title[1];
	$ev_title =  $title;
	$color=str_replace('#','',$color);
	$event='<div id="cal_event"  style="padding-left: 5px; background-color: '.hex_to_rgb($color,'0.5').' !important;"><p class="ev_name">'.$ev_title.'</p></div>';
	
	return $event;
}

function evented_days($r, $number_of_shown_evetns, $ev_id, $i,$evented_color_bg,$events_count){
	if($r < $number_of_shown_evetns && $r < $events_count){ $ev_colid = $r; }
	else $ev_colid = $r - 1;

	if(str_replace('#','',category_color($ev_id[0]))=="") $cat_col_without_color = $evented_color_bg;
	else $cat_col_without_color = '#' . str_replace('#','',category_color($ev_id[0]));
	if($r>1){
		if(category_color($ev_id[$r-1])=='#')
			$cat_color_for_last='#' . str_replace('#','',$evented_color_bg);
		else
			$cat_color_for_last='#' . str_replace('#','',category_color($ev_id[$ev_colid]));
	}
	else $cat_color_for_last = $cat_col_without_color;

}
  
  /////////////////////////////////////////////////////////////////////////////
  
  for ($i = 1; $i <= $month_days; $i++) {
      if (isset($title[$i])) {
      $ev_title = explode('</p>', $title[$i]);
      array_pop($ev_title);
      $k = count($ev_title);	  
      $ev_id = explode('<br>', $ev_ids[$i]);
	  array_pop($ev_id);
      $ev_ids_inline = implode(',', $ev_id);
	      }
	else
	$k=0;
	
    $dayevent = '';
    if (($weekday_i % 7 == 0 and $weekstart == "mo") or ($weekday_i % 7 == 1 and $weekstart == "su")) {
      if ($i == $day_REFERER and $month == $month_REFERER and $year == $year_REFERER ) {
        echo '      <td class="cala_day" style="padding:0; margin:0;line-height:15px;" id="event_td_'.$i.'">
                      <div class="calborder_day" style=" margin:0; padding:0;">
                        <p style="font-size:' . $other_days_font_size . 'px; font-weight: 600; color:' . $evented_color . ';line-height:1.4;font-family: Segoe UI; background: '.$date_bgcolor.';">' . $i . '</p>';
        $r = 0;
        echo '          <div style="background-color:' . $ev_title_bg_color . ' !important;">';
        for ($j = 0; $j < $k; $j++) {
		if(category_color($ev_id[$j])=='#')
				$cat_color=$evented_color_bg;
		else
			$cat_color=category_color($ev_id[$j]);		
		if ($k > $number_of_shown_evetns)
			$events_count = $number_of_shown_evetns + 1;
		else $events_count = $k; 			
		$event_height = ($cell_height - floor($other_days_font_size * 1.4))/$events_count;
          if ($r < $number_of_shown_evetns) {
            echo '        <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none;color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
							  'cat_id' => $cat_ids
                              ), $site_url) . '"><b>' . style($ev_title[$j],$cat_color,$event_height) . '</b>
                          </a>';
          }
          else {
            echo '       
                          <div style=" min-height: '.$event_height.'px;"><a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="padding-left: 5px; font-size:11px; background:none; color:' . $ev_color . '; text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a></div>';
            break;
          }
          $r++;
        }
		 evented_days($r, $number_of_shown_evetns, $ev_id, $i,$evented_color_bg, $events_count);
        echo '          </div>
                      </div>
                    </td>';
				
      }
      else
	  if ($i ==date( 'j' ) and $month == date('F') and $year == date('Y')) {
	  
		if(!isset($border_day)) $border_day = "";
                if ($i == date('j') and $month == date('F') and $year == date('Y')) { $border_day = $current_day_border_color;}
        if (in_array($i,$array_days)) {
          echo '      <td class="cala_day" style="background-color:' . $ev_title_bg_color . ' !important;overflow: hidden; padding:0; margin:0;line-height:15px; border: 2px solid ' . $current_day_border_color . ' !important" id="event_td_'.$i.'">
                        <p style="background-color:' . $evented_color_bg . ' !important;color:' . $evented_color . ' !important;font-size:' . $other_days_font_size . 'px; font-weight: 600;line-height:1.4;font-family: Segoe UI;padding-left: 5px;background: '.$date_bgcolor.' !important; width: 100%; padding-right: 6px;">' . $i . '</p>';
          $r = 0;
          echo '        <div style="background-color:' . $ev_title_bg_color . ' !important">';
          for ($j = 0; $j < $k; $j++) {
		  
		  if(category_color($ev_id[$j])=='#')
				$cat_color=$evented_color_bg;
			else
				$cat_color=category_color($ev_id[$j]);
			
		if ($k > $number_of_shown_evetns)
			$events_count = $number_of_shown_evetns + 1;
		else $events_count = $k; 			
		$event_height = ($cell_height - floor($other_days_font_size * 1.4))/$events_count;
            if ($r < $number_of_shown_evetns) {
              echo '      <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none;color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . style($ev_title[$j],$cat_color,$event_height) . '</b>
                          </a>';
            }
            else {
              echo '      
                          <div style=" min-height: '.$event_height.'px;"><a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="padding-left: 5px; font-size:11px;background:none;color:' . $ev_color . ';text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a></div>';
              break;
            }
            $r++;
          }
		  evented_days($r, $number_of_shown_evetns, $ev_id, $i,$evented_color_bg, $events_count);
          echo '        </div>
                      </td>';
        }
        else {

          echo '      <td class="calsun_days" style="overflow: hidden; padding:0; font-size:' . $sundays_font_size . 'px; margin:0;line-height:1.4;font-family: Segoe UI;padding-left: 5px; border: 2px solid ' . $current_day_border_color . ' !important">
                        <b>' . $i . '</b>
                      </td>';
        }
      }
      else
	  
	  if (in_array($i, $array_days)) {
        echo '        <td class="cala_day" style="background-color:' . $ev_title_bg_color . ' !important;padding:0; margin:0;line-height:15px;" id="event_td_'.$i.'">
                        <p style="background-color:' . $evented_color_bg . ' !important;color:' . $evented_color . ';font-size:' . $other_days_font_size . 'px; font-weight: 600;line-height:1.4;font-family: Segoe UI;padding-left: 5px;background: '.$date_bgcolor.' !important; padding-right: 6px;">' . $i . '</p>
                        <div>';
        $r = 0;
        for ($j = 0; $j < $k; $j++) {
		if(category_color($ev_id[$j])=='#')
				$cat_color=$evented_color_bg;
			else
				$cat_color=category_color($ev_id[$j]);
		if ($k > $number_of_shown_evetns)
			$events_count = $number_of_shown_evetns + 1;
		else $events_count = $k; 			
		$event_height = ($cell_height - floor($other_days_font_size * 1.4))/$events_count;

          if ($r < $number_of_shown_evetns) {
            echo '       <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none; color:' . $event_title_color . ' !important;"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . style($ev_title[$j],$cat_color,$event_height) . '</b>
                          </a>';
          }
          else {
            echo '        
                        <div style=" min-height: '.$event_height.'px;"><a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="padding-left: 5px; font-size:11px; background:none; color:' . $ev_color . ' !important;text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a></div>';
            break;
          }
          $r++;
        }
		 evented_days($r, $number_of_shown_evetns, $ev_id, $i,$evented_color_bg,$events_count);
        echo '          </div>
                      </td>';
			}
      else {
        echo '        <td class="calsun_days" style="padding:0; margin:0;line-height:1.4;font-family: Segoe UI; font-size:' . $sundays_font_size . 'px">
                        <p style="background: '.$date_bgcolor.'; padding-left: 5px; padding-right: 6px; ">' . $i . '</p>
                      </td>';
      }
    }
    else
	
	if ($i == $day_REFERER and $month == $month_REFERER and $year == $year_REFERER) {
	
			echo '          <td bgcolor="' . $ev_title_bg_color . '" class="cala_day" style="overflow: hidden; border: 2px solid ' . $current_day_border_color . ' !important;padding:0; margin:0;line-height:15px;" id="event_td_'.$i.'">
                        <div class="calborder_day" style="margin:0; padding:0;">
                          <p style="background-color:' . $evented_color_bg . ' !important;color:' . $evented_color . ' !important;font-size:' . $other_days_font_size . 'px; font-weight: 600;line-height:1.4;font-family: Segoe UI;padding-left: 5px;background: '.$date_bgcolor.' !important; width: 100%; padding-left: 5px; padding-right: 6px;">' . $i . '</p>
                          <div style="background-color:' . $ev_title_bg_color . ' !important">';
      $r = 0;
			for ($j = 0; $j < $k; $j++) {
			if(category_color($ev_id[$j])=='#')
				$cat_color=$evented_color_bg;
			else
				$cat_color=category_color($ev_id[$j]);
			
		if ($k > $number_of_shown_evetns)
			$events_count = $number_of_shown_evetns + 1;
		else $events_count = $k; 			
		$event_height = ($cell_height - floor($other_days_font_size * 1.4))/$events_count;	
        if ($r < $number_of_shown_evetns) {
          echo '            <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none; color:' . $event_title_color . ' !important;"
                              href="' . add_query_arg(array(
                                'action' => 'spidercalendarbig',
                                'theme_id' => $theme_id,
                                'calendar_id' => $calendar_id,
                                'ev_ids' => $ev_ids_inline,
                                'eventID' => $ev_id[$j],
                                'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
                                'widget' => $widget,
                                'TB_iframe' => 1,
                                'tbWidth' => $popup_width,
                                'tbHeight' => $popup_height,
                                ), $site_url) . '"><b>' . style($ev_title[$j],$cat_color,$event_height) . '</b>
                            </a>';
          }
          else {
              echo '       
                            <div style=" min-height: '.$event_height.'px;"><a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="padding-left: 5px; font-size:11px; background:none; color:' . $ev_color . ';text-align:center;"
                              href="' . add_query_arg(array(
                                'action' => 'spiderseemore',
                                'theme_id' => $theme_id,
                                'calendar_id' => $calendar_id,
                                'ev_ids' => $ev_ids_inline,
                                'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                                'many_sp_calendar' => $many_sp_calendar,
                                'cur_page_url' => $path_sp_cal,
                                'widget' => $widget,
                                'TB_iframe' => 1,
                                'tbWidth' => $popup_width,
                                'tbHeight' => $popup_height,
                                ), $site_url) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                            </a></div>';
            break;
          }
          $r++;
        }
		 evented_days($r, $number_of_shown_evetns, $ev_id, $i,$evented_color_bg, $events_count);
        echo '            </div>
                        </div>
                      </td>';
      }
      else {
 
       if ($i ==date( 'j' ) and $month == date('F') and $year == date('Y')) {
		
		
          if (in_array ($i,$array_days)) {
            echo  '   <td class="cala_day" style="background-color:' . $ev_title_bg_color . ' !important;overflow: hidden; padding:0; margin:0;line-height:15px; border: 2px solid ' . $current_day_border_color . ' !important;" id="event_td_'.$i.'">
                        <p style="background-color:' . $evented_color_bg . ' !important;color:' . $evented_color . ';font-size:' . $other_days_font_size . 'px; font-weight: 600;line-height:1.4;font-family: Segoe UI;padding-left: 5px;background: '.$date_bgcolor.' !important; width: 100%; padding-right: 6px;">' . $i . '</p>
                        <div style="background-color:' . $ev_title_bg_color . ' !important">';
            $r = 0;
            for ($j = 0; $j < $k; $j++) {
			if(category_color($ev_id[$j])=='#')
				$cat_color=$evented_color_bg;
			else
				$cat_color=category_color($ev_id[$j]);

			if ($k > $number_of_shown_evetns)
				$events_count = $number_of_shown_evetns + 1;
			else $events_count = $k; 			
			$event_height = ($cell_height - floor($other_days_font_size * 1.4))/$events_count;
              if ($r < $number_of_shown_evetns) {
                echo '    <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="background:none; color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . style($ev_title[$j],$cat_color,$event_height) . '</b>
                          </a>';
              }
              else {
                echo '    
                          <div style=" min-height: '.$event_height.'px;"><a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="padding-left: 5px; font-size:11px; background:none;color:' . $ev_color . ';text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a></div>';
                break;
              }
              $r++;
            }	
			evented_days($r, $number_of_shown_evetns, $ev_id, $i,$evented_color_bg, $events_count);			
            echo '      </div>
                      </td>';
          }
          else {
            echo '    <td style="overflow: hidden; color:' . $text_color_this_month_unevented . ';padding:0; margin:0; line-height:15px; border: 2px solid ' . $current_day_border_color . ' !important; vertical-align:top;">
                        <p style="font-size:'.$other_days_font_size.'px; font-weight: 600;line-height:1.4;font-family: Segoe UI;padding-left: 5px; background: '.$date_bgcolor.';">' . $i . '</p>
                      </td>';
          }
        }
        else
		
if (in_array($i, $array_days)) {
          echo '      <td class="cala_day" style="background-color:' . $ev_title_bg_color . ' !important;padding:0; margin:0;line-height:15px;" id="event_td_'.$i.'">
                        <p style="color:' . $evented_color . ' !important;font-size:' . $other_days_font_size . 'px; font-weight: 600;line-height:1.4; padding-left: 5px; font-family: Segoe UI;padding-left: 5px; background: '.$date_bgcolor.' !important;">' . $i . '</p>';
          $r = 0;
          echo ' <div class="events_div">';
		  
      		for ($j = 0; $j < $k; $j++) {
			
			if(category_color($ev_id[$j])=='#')
				$cat_color=$evented_color_bg;
			else
				$cat_color=category_color($ev_id[$j]);
			
			if ($k > $number_of_shown_evetns)
				$events_count = $number_of_shown_evetns + 1;
			else $events_count = $k; 			
			$event_height = ($cell_height - floor($other_days_font_size * 1.4))/$events_count;
			
            if ($r < $number_of_shown_evetns) {
              echo '      <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '"  style="background:none; color:' . $event_title_color . ';"
                            href="' . add_query_arg(array(
                              'action' => 'spidercalendarbig',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'eventID' => $ev_id[$j],
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . style($ev_title[$j],$cat_color,$event_height) . '</b>
                          </a>';
            }
            else {
              echo '<div style="min-height: '.$event_height.'px;"><a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="padding-left: 5px; font-size:11px; background:none; color:' . $ev_color . ';text-align:center;"
                            href="' . add_query_arg(array(
                              'action' => 'spiderseemore',
                              'theme_id' => $theme_id,
                              'calendar_id' => $calendar_id,
                              'ev_ids' => $ev_ids_inline,
                              'date' => $year . '-' . add_0(Month_num($month)) . '-' . $i,
                              'many_sp_calendar' => $many_sp_calendar,
                              'cur_page_url' => $path_sp_cal,
                              'widget' => $widget,
                              'TB_iframe' => 1,
                              'tbWidth' => $popup_width,
                              'tbHeight' => $popup_height,
                              ), $site_url) . '"><b>' . __('See more', 'sp_calendar') . '</b>
                          </a></div>';
              break;
            }
            $r++;
          }
		   evented_days($r, $number_of_shown_evetns, $ev_id, $i,$evented_color_bg, $events_count);
          echo '        </div>
                      </td>';
			}
			else {
        echo '        <td style=" color:' . $text_color_this_month_unevented . ';padding:0; margin:0; line-height:15px;border-bottom: 1px solid ' . $cell_border_color . ' !important; border-left: 1px solid ' . $cell_border_color . ' !important;vertical-align:top;">
                        <p style="font-size:' . $other_days_font_size . 'px; font-weight: 600;line-height:1.4;font-family: Segoe UI; padding-left: 5px; background: '.$date_bgcolor.';">' . $i . '</p>
                      </td>';
      }
    }
    if ($weekday_i % 7 == 0 && $i <> $month_days) {
    	echo '        </tr>
                    <tr height="' . $cell_height . '" style="line-height:15px">';
      $weekday_i = 0;
    }
    $weekday_i += 1;
  }
  $weekday_i;
  $next_i = 1;
  if ($weekday_i != 1) {
    for ($i = $weekday_i; $i <= 7; $i++) {
      if ($i != 7) {
        echo '        <td class="caltext_color_other_months" style="font-size:' . $other_days_font_size . 'px;line-height:1.4;font-family: Segoe UI;font-weight: 600;background-color:' . $bg_color_other_months . ' !important;"><p style="background: '.$date_bgcolor.';"><span style="padding: 0px 19px 0px 5px;">' . $next_i . '</span></p></td>';
      }
      else {
        echo '        <td class="caltext_color_other_months" style="font-size:' . $other_days_font_size . 'px;line-height:1.4; font-weight: 600;font-family: Segoe UI; background-color:' . $bg_color_other_months . ' !important;"><p style="background: '.$date_bgcolor.';"><span style="padding: 0px 19px 0px 5px;">' . $next_i . '</span></p></td>';
      }
      $next_i += 1;
    }
  }
  echo '            </tr>
                  </table>';
  ?>            <input type="text" value="1" name="day" style="display:none" />
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
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

<li class="spider_categories"><p id="category<?php echo $category->id ?>" style="background-color:#<?php echo str_replace('#','',$category->color); ?> !important" onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_month',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => $category->id,
				'cat_ids' => $cat_ids,
                'widget' => $widget,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"> <?php echo  $category->title ?></p></li>


<?php } 
if (!empty($categories)) {
?>
<li class="spider_categories"><p id="category0" style="background-color:#<?php echo str_replace('#','',$bg_top); ?> !important" onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_month',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => '',
                'widget' => $widget,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"><?php echo __('All categories', 'sp_calendar'); ?></p></li>
<?php
}
 echo '</ul>';
}
 ?>
  </body>
</html>
<?php
  die();
} ?>