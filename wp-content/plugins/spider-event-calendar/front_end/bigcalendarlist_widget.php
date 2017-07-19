<?php
function big_calendar_list_widget() {
  require_once("frontend_functions.php");
  global $wpdb;
  $widget = ((isset($_GET['widget']) && (int) $_GET['widget']) ? (int) $_GET['widget'] : 0);
  $many_sp_calendar = ((isset($_GET['many_sp_calendar']) && is_numeric(esc_html($_GET['many_sp_calendar']))) ? esc_html($_GET['many_sp_calendar']) : 1);
  $calendar_id = (isset($_GET['calendar']) ? (int) $_GET['calendar'] : '');
  $theme_id = (isset($_GET['theme_id']) ? (int) $_GET['theme_id'] : 1);
  $date = ((isset($_GET['date']) && IsDate_inputed(esc_html($_GET['date']))) ? esc_html($_GET['date']) : '');
  $cat_id = (isset($_GET['cat_id']) ? esc_html($_GET['cat_id']) : '');
  $cat_ids = (isset($_GET['cat_ids']) ? esc_html($_GET['cat_ids']) : '');
  $view_select = (isset($_GET['select']) ? esc_html($_GET['select']) : 'month,');
  $path_sp_cal = (isset($_GET['cur_page_url']) ? esc_html($_GET['cur_page_url']) : '');
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
  
  
  $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_widget_theme WHERE id=%d', $theme_id));
  $weekstart = $theme->week_start_day;
  $bg = '#' . str_replace('#','',$theme->header_bgcolor);
  $bg_color_selected = '#' . str_replace('#','',$theme->bg_color_selected);
  $color_arrow = '#' . str_replace('#','',$theme->arrow_color);
  $evented_color = '#' . str_replace('#','',$theme->text_color_this_month_evented);
  $evented_color_bg = '#' . str_replace('#','',$theme->bg_color_this_month_evented);
  $sun_days = '#' . str_replace('#','',$theme->text_color_sun_days);
  $text_color_other_months = '#' . str_replace('#','',$theme->text_color_other_months);
  $text_color_this_month_unevented = '#' . str_replace('#','',$theme->text_color_this_month_unevented);
  $text_color_month = '#' . str_replace('#','',$theme->text_color_month);
  $color_week_days = '#' . str_replace('#','',$theme->text_color_week_days);
  $text_color_selected = '#' . str_replace('#','',$theme->text_color_selected);
  $border_day = '#' . str_replace('#','',$theme->border_day);
  $calendar_width = $theme->width;
  $calendar_bg = '#' . str_replace('#','',$theme->footer_bgcolor);
  $weekdays_bg_color = '#' . str_replace('#','',$theme->weekdays_bg_color);
  $weekday_su_bg_color = '#' . str_replace('#','',$theme->su_bg_color);
  $cell_border_color = '#' . str_replace('#','',$theme->cell_border_color);
  $year_font_size = $theme->year_font_size;
  $year_font_color = '#' . str_replace('#','',$theme->year_font_color);
  $year_tabs_bg_color = '#' . str_replace('#','',$theme->year_tabs_bg_color);
  $font_year = $theme->font_year;
  $font_month = $theme->font_month;
  $font_day = $theme->font_day;
  $font_weekday = $theme->font_weekday;
  $show_cat = $theme->show_cat;
  $ev_title_color = '#' . str_replace('#','',$theme->ev_title_color);
  $popup_width = $theme->popup_width;
  $popup_height = $theme->popup_height;
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

  $this_month = substr($year . '-' . add_0((Month_num($month))), 5, 2);
  $prev_month = add_0((int) $this_month - 1);
  $next_month = add_0((int) $this_month + 1);

  $cell_width = $calendar_width / 7;
  $cell_width = (int) $cell_width - 2;

  $view = 'bigcalendarlist_widget';
  $views = explode(',', $view_select);
  $defaultview = 'list';
  array_pop($views);
  $display = '';
  if (count($views) == 0) {
    $display = "display:none";
  }
  if(count($views) == 1 && $views[0] == $defaultview) {
    $display = "display:none";
  }
  ?>
<html>
  <head>
  <style type='text/css'>
    #calendar_<?php echo $many_sp_calendar; ?> table {
      border-collapse: initial;
      border:0px;
	  margin: 0;
    }
	#TB_iframeContent{
		background-color: <?php echo $show_event_bgcolor; ?>;
	}
    #calendar_<?php echo $many_sp_calendar; ?> table td {
      padding: 0px;
      vertical-align: none;
      border-top:none;
      line-height: none;
      text-align: none;
    }
	#calendar_<?php echo $many_sp_calendar; ?> .arrow-left {
		width: 0px;
		height: 0px;
		border-top: 7px solid transparent;
		border-bottom: 7px solid transparent;
		border-right: 13px solid;
		margin: 0 auto;	
	}
	
	#calendar_<?php echo $many_sp_calendar; ?> .arrow-right {
		width: 0px;
		height: 0px;
		border-top: 7px solid transparent;
		border-bottom: 7px solid transparent;
		border-left: 13px solid;
		margin: 0 auto;
	}
    #calendar_<?php echo $many_sp_calendar; ?> .cell_body td {
      border:1px solid <?php echo $cell_border_color; ?>;
      font-family: <?php echo $font_day; ?>;
    }
    #calendar_<?php echo $many_sp_calendar; ?> p, ol, ul, dl, address {
      margin-bottom: 0;
    }
    #calendar_<?php echo $many_sp_calendar; ?> td,
    #calendar_<?php echo $many_sp_calendar; ?> tr,
    #spiderCalendarTitlesList_<?php echo $many_sp_calendar; ?> td,
    #spiderCalendarTitlesList_<?php echo $many_sp_calendar; ?> tr {
       border:none;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .cala_arrow a:link,
    #calendar_<?php echo $many_sp_calendar; ?> .cala_arrow a:visited {
      color: <?php echo $color_arrow; ?>;
      text-decoration: none !important;
      background: none;
      font-size: 16px;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .cala_arrow a:hover {
      color: <?php echo $color_arrow; ?>;
      text-decoration:none;
      background:none;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .cala_day a:link,
    #calendar_<?php echo $many_sp_calendar; ?> .cala_day a:visited {
      text-decoration:underline;
      background:none;
      font-size:11px;
    }
    #calendar_<?php echo $many_sp_calendar; ?> a {
      font-weight: normal;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .cala_day a:hover {
      font-size:12px;
      text-decoration:none;
      background:none;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .calyear_table {
      border-spacing:0;
      width:100%;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .calmonth_table {	
      border-spacing: 0;
      vertical-align: middle;
      width: 100%;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .calbg {
      background-color:<?php echo $bg; ?> !important;
      text-align:center;
      vertical-align: middle;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .caltext_color_other_months {
      color:<?php echo $text_color_other_months; ?>;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .caltext_color_this_month_unevented {
      color:<?php echo $text_color_this_month_unevented; ?>;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .calfont_year {
      font-size:24px;
      font-weight:bold;
      color:<?php echo $year_font_color; ?>;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .calsun_days {
      color:<?php echo $sun_days; ?>;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .calborder_day {
      border: solid <?php echo $border_day; ?> 1px;
    }
    #TB_window {
      z-index: 10000;
    }
    #calendar_<?php echo $many_sp_calendar; ?> .views {
      float: right;
      background-color: <?php echo $calendar_bg; ?> !important;
      height: 25px;
      width: <?php echo ($calendar_width / 4) - 2; ?>px;
      margin-left: 2px;
      text-align: center;
      cursor:pointer;
      position: relative;
      top: 3px;
      font-family: <?php echo $font_month; ?>;
	  font-size: 14px;
    }
    #calendar_<?php echo $many_sp_calendar; ?> table tr {
      background: transparent !important;
    }
	
#calendar_<?php echo $many_sp_calendar; ?> .views_select ,
#calendar_<?php echo $many_sp_calendar; ?> #views_select
{
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
	left: -15px;
	display:none;
	z-index: 4545;
	
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
  <div id="calendar_<?php echo $many_sp_calendar; ?>" style="width:<?php echo $calendar_width; ?>px;">
    <table cellpadding="0" cellspacing="0" style="border-spacing:0; width:<?php echo $calendar_width; ?>px; margin:0; padding:0;background-color:<?php echo $calendar_bg; ?> !important">
      <tr style="background-color:#FFFFFF;">
        <td style="background-color:#FFFFFF;">
          <div id="views_tabs" style="width: 101%;margin-left: -2px;<?php echo $display; ?>">
            <div class="views" style="<?php if (!in_array('day', $views) AND $defaultview != 'day') echo 'display:none;'; if ($view == 'bigcalendarday_widget') echo 'background-color:' . $bg . ' !important;height:28px;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_day_widget',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))) . '-' . date('d'),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
				'TB_iframe' => 1,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="line-height: 2;color:<?php echo $text_color_month; ?>;"><?php echo __('Day', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="<?php if (!in_array('week', $views) AND $defaultview != 'week') echo 'display:none;'; if ($view == 'bigcalendarweek_widget') echo 'background-color:' . $bg . ' !important;height:28px;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_week_widget',
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
				'TB_iframe' => 1,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="line-height: 2;color:<?php echo $text_color_month; ?>;"><?php echo __('Week', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="margin-left: 3px;margin-right: 1px;<?php if (!in_array('list', $views) AND $defaultview != 'list') echo 'display:none;'; if ($view == 'bigcalendarlist_widget') echo 'background-color:' . $bg . ' !important;height:28px;top:0;' ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_list_widget',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
				'TB_iframe' => 1,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"><span style="line-height: 2;color:<?php echo $text_color_month; ?>;"><?php echo __('List', 'sp_calendar'); ?></span>
            </div>
            <div class="views" style="<?php if (!in_array('month', $views) AND $defaultview != 'month') echo 'display:none;'; if ($view == 'bigcalendarmonth_widget') echo 'background-color:' . $bg . ' !important;height:28px;top:0;'; ?>"
              onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_month_widget',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year . '-' . add_0((Month_num($month))),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => $cat_ids,
                'widget' => $widget,
				'TB_iframe' => 1,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" ><span style="line-height: 2;color:<?php echo $text_color_month; ?>;"><?php echo __('Month', 'sp_calendar'); ?></span>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" style="padding:0; margin:0;">
          <form action="" method="get" style="background:none; margin:0; padding:0;">
            <table cellpadding="0" cellspacing="0" border="0" style="border-spacing:0; font-size:12px; margin:0; padding:0;" width="<?php echo $calendar_width; ?>">
              <tr height="28px" style="width:<?php echo $calendar_width; ?>px;">
                <td class="calbg" colspan="7" style="background-image:url('<?php echo plugins_url('/images/Stver.png', __FILE__); ?>');margin:0; padding:0;background-repeat: no-repeat;background-size: 100% 100%;" >
                  <?php //MONTH TABLE ?>
                  <table cellpadding="0" cellspacing="0" border="0" align="center" class="calmonth_table"  style="width:100%; margin:0; padding:0">
                    <tr>
                      <td style="text-align:left; margin:0; padding:0; line-height:16px" class="cala_arrow" width="20%">
                        <a href="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar ?>','<?php  
                          if (Month_num($month) == 1) {
                            $needed_date = ($year - 1) . '-12';
                          }
                          else {
                            $needed_date = $year . '-' . add_0((Month_num($month) - 1));
                          }
                          echo add_query_arg(array(
                            'action' => 'spiderbigcalendar_' . $defaultview . '_widget',
                            'theme_id' => $theme_id,
                            'calendar' => $calendar_id,
                            'select' => $view_select,
                            'date' => $needed_date,
                            'many_sp_calendar' => $many_sp_calendar,
                            'cur_page_url' => $path_sp_cal,
							'cat_id' => '',
							'cat_ids' => $cat_ids,
                            'widget' => $widget,
							'TB_iframe' => 1,
                            ), $site_url);
                            ?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"><div class="arrow-left"></div>
                        </a>
                      </td>
                      <td width="60%" style="text-align:center; margin:0; padding:0; font-family:<?php echo $font_month; ?>">
                        <input type="hidden" name="month" readonly="" value="<?php echo $month; ?>"/>
                        <span style="font-size:<?php echo $year_font_size; ?>px;?>; color:<?php echo $text_color_month; ?>;"><?php echo __($month, 'sp_calendar'); ?></span>
                      </td>
                      <td style="text-align:right; margin:0; padding:0; line-height:16px"  class="cala_arrow" width="20%">
                        <a href="javascript:showbigcalendar('bigcalendar<?php echo $many_sp_calendar ?>','<?php
                          if (Month_num($month) == 12) {
                            $needed_date = ($year + 1) . '-01';
                          }
                          else {
                            $needed_date = $year . '-' . add_0((Month_num($month) + 1));
                          }
                          echo add_query_arg(array(
                            'action' => 'spiderbigcalendar_' . $defaultview . '_widget',
                            'theme_id' => $theme_id,
                            'calendar' => $calendar_id,
                            'select' => $view_select,
                            'date' => $needed_date,
                            'many_sp_calendar' => $many_sp_calendar,
                            'cur_page_url' => $path_sp_cal,
							'cat_id' => '',
							'cat_ids' => $cat_ids,
                            'widget' => $widget,
							'TB_iframe' => 1,
                            ), $site_url);
                            ?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"><div class="arrow-right"></div>
                        </a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              
              <tr>
                <td colspan="7">
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
  $all_calendar_files = php_getdays(0, $calendar_id, $date, $theme_id, $widget);
  $categories=$wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "spidercalendar_event_category WHERE published=1"); 
  $calendar = (isset($_GET['calendar']) ? (int)$_GET['calendar'] : ''); 
  $array_days = $all_calendar_files[0]['array_days'];
  $array_days1 = $all_calendar_files[0]['array_days1'];
  $title = $all_calendar_files[0]['title'];
  $ev_ids = $all_calendar_files[0]['ev_ids'];
  sort($array_days, SORT_NUMERIC);
  if (!$array_days) {
    echo '<table style="height:14px;border-spacing:0;border-spacing:0;width: 100%;background-color:#D6D4D5 !important;">
            <tr>
              <td style="padding-left:10px; font-size:12px;font-weight:bold;width:10px;text-align:center;background-color:' . $bg . ' !important;color:#949394;"></td>
              <td><p style="font-size:12px;color:' . $bg . '; border:none">&nbsp;' . __('There are no events for this month', 'sp_calendar') . '</p></td>
            </tr>
          </table>';
  }
  for ($i = 0; $i < count($array_days); $i++) {
    $week_day = date('D', mktime(0, 0, 0, Month_num($month), $array_days[$i], $year));
	if($array_days[$i]<=$month_days){
    echo '<table style="width:100%; border-spacing:0;">
            <tr>
              <td style="height:14px;font-size:12px; padding-left:10px;background-color:#D6D4D5 !important; color:#6E7276">
                <span style="padding-left:10px; font-size:12px;color:' . $color_week_days . '">' . week_convert($week_day) . '</span>
                <span style="font-size:12px;color:#949394;">(' . add_0($array_days[$i]) . ' ' . __($month,'sp_calendar') . ')</span>
              </td>
            </tr>
            <tr>
              <td>';
    foreach ($title as $key => $value) {
      if ($key == $array_days[$i]) {
        $ev_id = explode('<br>', $ev_ids[$key]);
        array_pop($ev_id);
        $ev_ids_inline = implode(',', $ev_id);
        $ev_title = explode('</p>', $value);
        array_pop($ev_title);
        for ($j = 0; $j < count($ev_title); $j++) {
		 $queryy = $wpdb->prepare ("SELECT " . $wpdb->prefix . "spidercalendar_event_category.color AS color FROM " . $wpdb->prefix . "spidercalendar_event  JOIN " . $wpdb->prefix . "spidercalendar_event_category
	       ON " . $wpdb->prefix . "spidercalendar_event.category=" . $wpdb->prefix . "spidercalendar_event_category.id WHERE " . $wpdb->prefix . "spidercalendar_event.calendar=%d AND 
	       " . $wpdb->prefix . "spidercalendar_event.published='1' AND " . $wpdb->prefix . "spidercalendar_event_category.published='1' AND " . $wpdb->prefix . "spidercalendar_event.id=%d",$calendar,$ev_id[$j]);
		   
		   $cat_color = $wpdb->get_row($queryy);
		
          if (($j + 1) % 2 == 0) {
            $color = $bg;
            $table_color = $calendar_bg;
          }
          else {
            $color = $bg;
            $table_color = $calendar_bg;
          }
		  if(!isset($cat_color->color)) { $cat_color = new stdClass; $cat_color->color=$bg;};
          echo '<table class="last_table" style="overflow:hidden;height:14px;border-spacing:0;width: 100%;background-color:' . $table_color . '">
                  <tr>
                    <td style="font-size:14px;font-weight:bold;width:15px;text-align:center;background-color:#' . str_replace('#','',$cat_color->color) . ' !important;color:' . $calendar_bg . '">' . ($j +1 ) . '</td>
                    <td>
                      <a class="thickbox-previewbigcalendar' . $many_sp_calendar . '" style="text-decoration:none;font-size:13px;background:none;color:' . $ev_title_color . ';"
                        href="' . add_query_arg(array(
                          'action' => 'spidercalendarbig',
                          'theme_id' => $theme_id,
                          'calendar_id' => $calendar_id,
                          'ev_ids' => $ev_ids_inline,
                          'eventID' => $ev_id[$j],
                          'date' => $year . '-' . add_0(Month_num($month)) . '-' . $array_days[$i],
                          'many_sp_calendar' => $many_sp_calendar,
                          'cur_page_url' => $path_sp_cal,
                          'widget' => $widget,
                          'TB_iframe' => 1,
                          'tbWidth' => $popup_width,
                          'tbHeight' => $popup_height,
                          ), $site_url) . '"><b>'.$ev_title[$j].'</b>
                      </a>
                    </td>
                  </tr>
                </table>';
        }
      }
    }
    echo '</td></tr></table>';
	}
  }
  ?>
                </td>
              </tr>
              <tr style="height:<?php echo $year_font_size + 2; ?>px; font-family: <?php echo $font_year; ?>;">
                <td colspan="2" onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar ?>','<?php 
                  echo add_query_arg(array(
                    'action' => 'spiderbigcalendar_' . $defaultview . '_widget',
                    'theme_id' => $theme_id,
                    'calendar' => $calendar_id,
                    'select' => $view_select,
                    'date' => ($year - 1) . '-' . add_0((Month_num($month))),
                    'many_sp_calendar' => $many_sp_calendar,
                    'cur_page_url' => $path_sp_cal,
                    'widget' => $widget,
					'cat_id' => '',
					'cat_ids' => $cat_ids,
					'TB_iframe' => 1,
                    ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" style="cursor:pointer;font-size:<?php echo $year_font_size; ?>px;color:<?php echo $year_font_color; ?>;text-align: center;background-color:<?php echo $year_tabs_bg_color; ?> !important">
                  <?php echo ($year - 1); ?>
                </td>
                <td colspan="3" style="font-size:<?php echo $year_font_size + 2; ?>px;color:<?php echo $year_font_color; ?>;text-align: center;border-right:1px solid <?php echo $cell_border_color; ?>;border-left:1px solid <?php echo $cell_border_color; ?>">
                  <?php echo $year; ?>
                </td>
                <td colspan="2" onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar ?>','<?php
                  echo add_query_arg(array(
                    'action' => 'spiderbigcalendar_' . $defaultview . '_widget',
                    'theme_id' => $theme_id,
                    'calendar' => $calendar_id,
                    'select' => $view_select,
                    'date' => ($year + 1) . '-' . add_0((Month_num($month))),
                    'many_sp_calendar' => $many_sp_calendar,
                    'cur_page_url' => $path_sp_cal,
                    'widget' => $widget,
					'cat_id' => '',
					'cat_ids' => $cat_ids,
					'TB_iframe' => 1,
                    ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')" style="cursor:pointer;font-size:<?php echo $year_font_size; ?>px;text-align: center;background-color:<?php echo $year_tabs_bg_color; ?> !important;color:<?php echo $year_font_color; ?>">
                  <?php echo ($year + 1); ?>
                </td>
              </tr>
            </table>
            <input type="text" value="1" name="day" style="display:none" />
          </form>
        </td>
      </tr>
    </table>
  </div>
 <style>
 #calendar_<?php echo $many_sp_calendar; ?> table{
	width: 100%;
   }
    .spider_categories_widget{
		display:inline-block;
		cursor:pointer;
	}
	
	.spider_categories_widget p{
		color: #fff;
		padding: 2px 10px !important;
		margin: 2px 0 !important;
		font-size: 13px;
	}
  </style>
  <?php

		//reindex cat_ids_array
$re_cat_ids_array = array_values($cat_ids_array);

for($i=0; $i<count($re_cat_ids_array); $i++)
{
echo'
<style>
#cats_widget_'.$many_sp_calendar.' #category'.$re_cat_ids_array[$i].'
{
	text-decoration:underline;
	cursor:pointer;

}

</style>';

}



	if($cat_ids=='')
		$cat_ids='';
if($show_cat){ 
echo '<ul id="cats_widget_'.$many_sp_calendar.'" style="list-style-type:none; margin-top: 10px;">';

foreach($categories as $category)
{
	
?>

<li class="spider_categories_widget"><p id="category<?php echo $category->id ?>" style="background-color:#<?php echo str_replace('#','',$category->color); ?> !important" onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_list_widget',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year.'-'.add_0((Month_num($month))) . '-' . add_0($day),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => $category->id,
				'cat_ids' => $cat_ids,
                'widget' => $widget,
				'TB_iframe' => 1,
                ), $site_url);?>','<?php echo $many_sp_calendar; ?>','<?php echo $widget; ?>')"> <?php echo  $category->title ?></p></li>


<?php
} 
if (!empty($categories)) {
?>
<li class="spider_categories_widget"><p class="categories2" id="category0" style="background-color:#<?php echo str_replace('#','',$bg); ?> !important" onclick="showbigcalendar('bigcalendar<?php echo $many_sp_calendar; ?>', '<?php echo add_query_arg(array(
                'action' => 'spiderbigcalendar_list_widget',
                'theme_id' => $theme_id,
                'calendar' => $calendar_id,
                'select' => $view_select,
                'date' => $year.'-'.add_0((Month_num($month))) . '-' . add_0($day),
                'many_sp_calendar' => $many_sp_calendar,
                'cur_page_url' => $path_sp_cal,
				'cat_id' => '',
				'cat_ids' => '',
                'widget' => $widget,
				'TB_iframe' => 1,
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