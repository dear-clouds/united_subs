<?php


if (!defined('WP_LOAD_PATH')) {
  // Classic root path if wp-content and plugins is below wp-config.php.
  $classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/';
  if (file_exists($classic_root . 'wp-load.php')) {
    define('WP_LOAD_PATH', $classic_root);
  }
  elseif (file_exists($path . 'wp-load.php')) {
    define('WP_LOAD_PATH', $path);
  }
  else {
    exit("Could not find wp-load.php");
  }
}
// Load WordPress.
require_once(WP_LOAD_PATH . 'wp-load.php');
if (!current_user_can('manage_options')) {
  die('Access Denied');
}
require_once("front_end/frontend_functions.php");
// $month = date('m');
// $year = date('Y');
$date_REFERER = date("Y-m");
$date = date("Y") . '-' . php_Month_num(date("F")) . '-' . date("d");
$year_REFERER = substr($date_REFERER, 0, 4);
// var_dump(date("F", mktime(0, 0, 0, 7, 1, 0)));
$month_REFERER = Month_name(substr($date_REFERER, 5, 2));
$day_REFERER = substr($date_REFERER, 8, 2);

$year = substr($date, 0, 4);
// var_dump($date);
$month = Month_name(substr($date, 5, 2));
$day = substr($date, 8, 2);

?>
<script>
  var cal_width = window.parent.document.getElementById('width').value;
  var calendar_bg = '#' + window.parent.document.getElementById('footer_bgcolor').value;
  var year_font_size = window.parent.document.getElementById('year_font_size').value;
  var text_color_month = '#' + window.parent.document.getElementById('text_color_month').value;
  var weekdays_bg_color = '#' + window.parent.document.getElementById('weekdays_bg_color').value;
  var weekday_su_bg_color = '#' + window.parent.document.getElementById('su_bg_color').value;
  var color_week_days = '#' + window.parent.document.getElementById('text_color_week_days').value;
  var text_color_selected = '#' + window.parent.document.getElementById('text_color_selected').value;
  var evented_color = '#' + window.parent.document.getElementById('text_color_this_month_evented').value;
  var evented_color_bg = '#' + window.parent.document.getElementById('bg_color_this_month_evented').value;
  var border_day = '#' + window.parent.document.getElementById('border_day').value;
  var text_color_this_month_unevented = '#' + window.parent.document.getElementById('text_color_this_month_unevented').value;
  var bg_color_selected = '#' + window.parent.document.getElementById('bg_color_selected').value;
  var year_font_color = '#' + window.parent.document.getElementById('year_font_color').value;
  var year_tabs_bg_color = '#' + window.parent.document.getElementById('year_tabs_bg_color').value;
  var cell_border_color = '#' + window.parent.document.getElementById('cell_border_color').value;
  var color_arrow = '#' + window.parent.document.getElementById('arrow_color').value;
  var bg = '#' + window.parent.document.getElementById('header_bgcolor').value;
  var text_color_other_months = '#' + window.parent.document.getElementById('text_color_other_months').value;
  var sun_days = '#' + window.parent.document.getElementById('text_color_sun_days').value;
  var cell_width = (cal_width / 7 )- 2;
  var font_year = window.parent.document.getElementById('font_year').value;
  var font_month = window.parent.document.getElementById('font_month').value;
  var font_day = window.parent.document.getElementById('font_day').value;
  var font_weekday = window.parent.document.getElementById('font_weekday').value;
  
  var head = document.getElementsByTagName('head')[0],
    style = document.createElement('style'),
    rules = document.createTextNode(
      '#calendar, .cell_body_su, #form_table, #form_table_td, #calendar_table, .cell_body { width: ' + cal_width + 'px; }' +
      '#calendar_table { background-color: ' + calendar_bg + '; }' +
      '#year { font-size: ' + year_font_size + 'px; color: ' + text_color_month + '; }' +
      '.cell_body { background-color: ' + weekdays_bg_color + '; }' +
      '.cell_body_su { background-color: ' + weekday_su_bg_color + '; color: ' + color_week_days + '; font-family: ' + font_weekday + '; }' +
      '.calbottom_border, .cell_body_mo, .calborder_day, .calborder_day { width: ' + cell_width + 'px;}' +
      '.cell_body_mo { color: ' + color_week_days + '; font-family: ' + font_weekday + '; }' +
      '.text_color_selected { color: ' + text_color_selected + '; }' +
      '.evented_color { color: ' + evented_color + '; }' +
      '.cala_day { background-color: ' + evented_color_bg + '; border: 2px solid ' + border_day + '; }' +
      '.calsun_days { border: 2px solid ' + border_day + '; }' +
      '.text_color_this_month_unevented { color:  ' + text_color_this_month_unevented + '; border: 2px solid ' + border_day + '; }' +
      '.bg_color_selected { background-color: ' + bg_color_selected + '; }' +
      '.year { font-size: ' + year_font_size + 'px; color: ' + year_font_color + '; background-color: ' + year_tabs_bg_color + '; }' +
      '.year_middle { font-size: ' + (parseInt(year_font_size) + 2) + 'px; color: ' + year_font_color + '; border-right: 1px solid ' + cell_border_color + '; border-left: 1px solid ' + cell_border_color + '; }' +
      '#calendar .cell_body td { border: 1px solid ' + cell_border_color + '; }' +
      '#calendar .cala_arrow a:link, #calendar .cala_arrow a:visited, #calendar .cala_arrow a:hover { color: ' + color_arrow + ';}' +
      '#calendar .calbg { background-color: ' + bg + '; }' +
      '#calendar .caltext_color_other_months { color: ' + text_color_other_months + '; }' +
      '#calendar .caltext_color_this_month_unevented { color: ' + text_color_this_month_unevented + '; }' +
      '#calendar .calfont_year { color: ' + year_font_color + '; }' +
      '#calendar .calsun_days { color: ' + sun_days + '; }' +
      '#calendar .calborder_day { border: 1px solid ' + border_day + '; }' +
      '#calendar .views { background-color: ' + calendar_bg + '; width: ' + ((cal_width / 4) - 2) + 'px; font-family: ' + font_month + ';}' +
      '#year_tr { font-family: ' + font_year + '; }' +
      '#month_tr { font-family: ' + font_month + '; }' +
      '#days_tr, #days_tr1 { font-family: ' + font_day + '; }' 
    );
  style.type = 'text/css';
  if (style.styleSheet) {
    style.styleSheet.cssText = rules.nodeValue;
  }
  else {
    style.appendChild(rules);
  }
  head.appendChild(style);
</script>

<style type='text/css'>
  #calendar table {
    border-collapse: initial;
    border:0px;
  }
  #calendar table td {
    padding: 0px;
    vertical-align: none;
    border-top:none;
    line-height: none;
    text-align: none;
  }
  #calendar p, ol, ul, dl, address {
    margin-bottom: 0;
  }
  #calendar td,
  #calendar tr,
  #spiderCalendarTitlesList td,
  #spiderCalendarTitlesList tr {
     border:none;
  }
  #calendar .cala_arrow a:link,
  #calendar .cala_arrow a:visited {
    text-decoration: none;
    background: none;
    font-size: 16px;
  }
  #calendar .cala_arrow a:hover {
    text-decoration:none;
    background:none;
  }
  #calendar .cala_day a:link,
  #calendar .cala_day a:visited {
    text-decoration:underline;
    background:none;
    font-size:11px;
  }
  #calendar a {
    font-weight: normal;
  }
  #calendar .cala_day a:hover {
    font-size:12px;
    text-decoration:none;
    background:none;
  }
  #calendar .calyear_table {
    border-spacing:0;
    width:100%;
  }
  #calendar .calmonth_table {	
    border-spacing: 0;
    vertical-align: middle;
    width: 100%;
  }
  #calendar .calbg {
    text-align:center;
    vertical-align: middle;
  }
  #calendar .calfont_year {
    font-size:24px;
    font-weight:bold;
  }
  #calendar .views {
    float: right;
    height: 25px;
    margin-left: 2px;
    text-align: center;
    cursor: pointer;
    position: relative;
    top: 3px;
  }
</style>
<div id="calendar">
  <table id="calendar_table" cellpadding="0" cellspacing="0" style="border-spacing:0; height:190px; margin:0; padding:0;">
    <tr>
      <td width="100%" style="padding:0; margin:0;">
        <form action="" method="get" style="background:none; margin:0; padding:0;">
          <table id="form_table" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0; font-size:12px; margin:0; padding:0;" height="190">
            <tr height="28px">
              <td id="form_table_td" class="calbg" colspan="7" style="background-image:url('<?php echo plugins_url('front_end/images/Stver.png', __FILE__); ?>');margin:0; padding:0;background-repeat: no-repeat;background-size: 100% 100%;" >
                <table cellpadding="0" cellspacing="0" border="0" align="center" class="calmonth_table"  style="width:100%; margin:0; padding:0">
                  <tr>
                    <td style="text-align:left; margin:0; padding:0; line-height:16px" class="cala_arrow" width="20%">
                      <a href="">&#9668;</a>
                    </td>
                    <td id="month_tr" width="60%" style="text-align:center; margin:0; padding:0;">
                      <input type="hidden" name="month" readonly="" value="<?php echo $month; ?>"/>
                      <span id="year"><?php echo $month; ?></span>
                    </td>
                    <td style="text-align:right; margin:0; padding:0; line-height:16px"  class="cala_arrow" width="20%">
                      <a href="">&#9658;</a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr class="cell_body" align="center"  height="10%">
              <td class="cell_body_su" style="margin:0; padding:0">
                <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b> Su </b></div>
              </td>
              <td class="cell_body_mo" style="margin:0; padding:0">
                <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b> Mo </b></div>
              </td>
              <td class="cell_body_mo" style="margin:0; padding:0">
                <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b> Tu </b></div>
              </td>
              <td class="cell_body_mo" style="margin:0; padding:0">
                <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b> We </b></div>
              </td>
              <td class="cell_body_mo" style="margin:0; padding:0">
                <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b> Th </b></div>
              </td>
              <td class="cell_body_mo" style="margin:0; padding:0">
                <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b> Fr </b></div>
              </td>
              <td class="cell_body_mo" style="margin:0; padding:0">
                <div class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b> Sa </b></div>
              </td>
            </tr>
<?php
$month_first_weekday = date("N", mktime(0, 0, 0, Month_num($month), 1, $year));
$month_first_weekday++;
if ($month_first_weekday == 8) {
  $month_first_weekday = 1;
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
$weekstart = 'su';
$percent = 107 / $percent;
$array_days = array(11);
$array_days1 = $array_days;
$title = array(
    11 => '<br>
1.   Event1<br>
2.   Event2<br>
3.   Event3<br>
4.   Event4'
  );
  $ev_ids = array(
    11 => '97<br>
98<br>
99<br>
100'
  );
echo '      <tr id="days_tr" class="cell_body" height="' . $percent . 'px" style="line-height:' . $percent . 'px">';
for ($i = 1; $i < $weekday_i; $i++) {
  echo '          <td class="caltext_color_other_months" style="text-align:center;">' . $last_month_days . '</td>';
  $last_month_days = $last_month_days + 1;
}
for ($i = 1; $i <= $month_days; $i++) {
  if (isset($title[$i])) {
    $ev_title = explode('</p>', $title[$i]);
    array_pop($ev_title);
    $k = count($ev_title);
    $ev_id = explode('<br>', $ev_ids[$i]);
    array_pop($ev_id);
    $ev_ids_inline = implode(',', $ev_id);
  }
  if (($weekday_i % 7 == 0 and $weekstart == "mo") or ($weekday_i % 7 == 1 and $weekstart == "su")) {
    if ($i == $day_REFERER and $month == $month_REFERER and $year == $year_REFERER) {
      echo  ' <td class="cala_day bg_color_selected" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <div class="calborder_day" style="text-align:center; margin:0; padding:0;">
                  <a class="text_color_selected" style="background:none; text-decoration:underline;" href=""><b>' . $i . '</b></a>
                </div>
              </td>';
    }
    elseif ($i == date('j') and $month == date('F') and $year == date('Y')) {
      if (in_array($i, $array_days)) {
        if (in_array ($i, $array_days1)) {
          echo '
              <td class="cala_day current_day" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <a class="evented_color" style="background:none; text-align:center; text-decoration:underline;" href=""><b>' . $i . '</b>
                </a>
              </td>';
        }
        else {
          echo '
              <td class="cala_day current_day" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <a class="evented_color" style="background:none; text-align:center; text-decoration:underline;" href=""><b>' . $i . '</b>
                </a>
              </td>';
        }
      }
      else {
        echo '
              <td class="calsun_days current_day" style="text-align:center;padding:0; margin:0;line-height:inherit;"><b>' . $i . '</b></td>';
      }
    }
    else {
      if (in_array ($i, $array_days)) {
        if (in_array ($i, $array_days1)) {
          echo '
              <td class="cala_day" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <a class="evented_color" style="background:none; text-align:center; text-decoration:underline;" href=""><b>' . $i . '</b></a>
              </td>';
        }
        else {
          echo '
              <td class="cala_day" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <a class="evented_color" style="background:none; text-align:center; text-decoration:underline;" href=""><b>' . $i . '</b></a>
              </td>';
        }
      }
      else {
        echo  '
              <td class="calsun_days" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <b>' . $i . '</b>
              </td>';
      }
    }
  }
  elseif ($i == $day_REFERER and $month == $month_REFERER and $year == $year_REFERER) {
    echo '    <td class="cala_day bg_color_selected" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <div class="calborder_day" style="text-align:center; margin:0; padding:0;">
                  <a class="text_color_selected" style="background:none; text-decoration:underline;" href=""><b>' . $i . '</b>
                </a>
              </td>';
  }
  else {
    if ($i == date('j') and $month == date('F') and $year == date('Y')) {
      if (in_array ($i, $array_days)) {
        if (in_array ($i, $array_days1)) {
          echo '
              <td class="cala_day current_day" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <a class="evented_color" style="background:none; text-align:center; text-decoration:underline;" href=""><b>' . $i . '</b></a>
              </td>';
        }
        else {
          echo '
              <td class="cala_day current_day" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <a class="evented_color" style="background:none; text-align:center; text-decoration:underline;" href=""><b>' . $i . '</b></a>
              </td>';
        }
      }
      else {
        echo '<td class="text_color_this_month_unevented current_day" style="text-align:center;padding:0; margin:0; line-height:inherit;">
                <b>' . $i . '</b>
              </td>';
      }
    }
    elseif (in_array($i, $array_days)) {
      if (in_array ($i, $array_days1)) {
        echo '<td class="cala_day" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <a class="evented_color" style="background:none; text-align:center;text-decoration:underline;" href=""><b>' . $i . '</b>
                </a>
              </td>';
      }
      else {
        echo '<td class="cala_day" style="text-align:center;padding:0; margin:0;line-height:inherit;">
                <a class="evented_color" style="background:none; text-align:center; text-decoration:underline;" href=""><b>' . $i . '</b></a>
              </td>';
      }
    }
    else {
      echo '  <td class="text_color_this_month_unevented" style="text-align:center; padding:0; margin:0; line-height:inherit;">
                <b>' . $i . '</b>
              </td>';
    }
  }
  if ($weekday_i % 7 == 0 && $i <> $month_days) {
    echo   '</tr>
            <tr id="days_tr1" class="cell_body" height="' . $percent . 'px" style="line-height:' . $percent . 'px">';
    $weekday_i = 0;
  }
  $weekday_i++;
}
$weekday_i;
$next_i = 1;
if ($weekday_i != 1) {
  for ($i = $weekday_i; $i <= 7; $i++) {
    echo '    <td class="caltext_color_other_months" style="text-align:center;">' . $next_i . '</td>';
    $next_i++;
  }
}
echo '      </tr>';
?>
            <tr id="year_tr">
              <td class="year" colspan="2" style="cursor:pointer;text-align: center;">
                <?php echo ($year - 1); ?>
              </td>
              <td class="year_middle" colspan="3" style="text-align: center;">
                <?php echo $year; ?>
              </td>
              <td class="year" colspan="2" style="cursor:pointer;text-align: center;">
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
