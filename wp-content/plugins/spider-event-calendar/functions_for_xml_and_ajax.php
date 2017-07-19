<?php
function php_window() {
  global $wpdb;
  $themes = $wpdb->get_results("SELECT id,title FROM " . $wpdb->prefix . "spidercalendar_theme");
  $calendars = $wpdb->get_results("SELECT id,title FROM " . $wpdb->prefix . "spidercalendar_calendar WHERE published=1");
  ?>
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <title>Spider Calendar</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <script language="javascript" type="text/javascript"
              src="<?php echo get_option("siteurl"); ?>/wp-includes/js/jquery/jquery.js"></script>
      <script language="javascript" type="text/javascript"
              src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
      <script language="javascript" type="text/javascript"
              src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
      <script language="javascript" type="text/javascript"
              src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
      <base target="_self">
    </head>
    <body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="" dir="ltr" class="forceColors">
      <form name="spider_cat" action="#">
        <div class="tabs" role="tablist" tabindex="-1">
          <ul>
            <li id="Single_product_tab" class="current" role="tab" tabindex="0"><span><a
              href="javascript:mcTabs.displayTab('Single_product_tab','Single_product_panel');" onMouseDown="return false;"
              tabindex="-1">Spider Calendar</a></span></li>
          </ul>
        </div>
        <div class="panel_wrapper">
          <div id="Single_product_panel" class="panel current">
            <br>
            <table border="0" cellpadding="4" cellspacing="0">
              <tbody>
              <tr>
                <td nowrap="nowrap"><label for="spider_Calendar" style="font-size: 13px;">Select Calendar</label></td>
                <td><select name="spider_Calendar" id="spider_Calendar" style="width:150px;">
                  <option value="- Select a Calendar -" selected="selected">- Select a Calendar -</option>
                  <?php
                  foreach ($calendars as $calendar) {
                    ?>
                    <option value="<?php echo $calendar->id; ?>"><?php echo $calendar->title; ?></option>
                    <?php }?>
                </select>
                </td>
              </tr>
              <tr>
                <td nowrap="nowrap"><label for="spider_Calendar_theme" style="font-size: 13px;">Select Theme</label></td>
                <td>
                  <select name="spider_Calendar_theme" id="spider_Calendar_theme" style="width:150px;">
                    <option value="- Select a Theme -" selected="selected">- Select a Theme -</option>
                    <?php
                    foreach ($themes as $theme) {
                      ?>
                      <option value="<?php echo $theme->id; ?>"><?php echo $theme->title; ?></option>
                      <?php }?>
                  </select>
                </td>
              </tr>
              <tr>
                <td class="key"><label for="default_view" style="font-size: 13px;">Default View</label></td>
                <td>
                  <select id="default_view" style="width:150px;" onChange="spider_calendar_select_view(this.value)">
                    <option value="month" selected="selected">Month</option>
                    <option value="list">List</option>
                    <option value="week">Week</option>
                    <option value="day">Day</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td class="key"><label for="view_0" style="font-size: 13px;">Select Views</label></td>
                <td style="font-size: 13px;">
                  <input type="checkbox" id="view_0" value="month" checked="checked">Month
                  <input type="checkbox" id="view_1" value="list" checked="checked">List
                  <input type="checkbox" id="view_2" value="week" checked="checked">Week
                  <input type="checkbox" id="view_3" value="day" checked="checked">Day
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="mceActionPanel">
          <div style="float: left;">
            <input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();"/>
          </div>
          <div style="float: right;">
            <input type="submit" id="insert" name="insert" value="Insert" onClick="insert_spider_calendar();"/>
          </div>
        </div>
      </form>
      <script type="text/javascript">
        var short_code = get_params("Spider_Calendar");
        if (short_code) {
          document.getElementById("view_0").checked = false;
          document.getElementById("view_1").checked = false;
          document.getElementById("view_2").checked = false;
          document.getElementById("view_3").checked = false;
          document.getElementById("spider_Calendar").value = short_code['id'];
          document.getElementById("spider_Calendar_theme").value = short_code['theme'];
          document.getElementById("default_view").value = short_code['default'];
          var selected_views = short_code['select'].split(',');
          for (var selected_view_id in selected_views) {
            var selected_view = selected_views[selected_view_id];
            for (var i = 0; i < 4; i++) {
              if (document.getElementById("view_" + i).value == selected_view) {
                document.getElementById("view_" + i).checked = true;
              }
            }
          }
        }
        // Get shortcodes attributes.
        function get_params(module_name) {
          var selected_text = tinyMCE.activeEditor.selection.getContent();
          var module_start_index = selected_text.indexOf("[" + module_name);
          var module_end_index = selected_text.indexOf("]", module_start_index);
          var module_str = "";
          if ((module_start_index >= 0) && (module_end_index >= 0)) {
            module_str = selected_text.substring(module_start_index + 1, module_end_index);
          }
          else {
            return false;
          }
          var params_str = module_str.substring(module_str.indexOf(" ") + 1);
          var key_values = params_str.split(" ");
          var short_code_attr = new Array();
          for (var key in key_values) {
            var short_code_index = key_values[key].split('=')[0];
            var short_code_value = key_values[key].split('=')[1];
            short_code_value = short_code_value.substring(1, short_code_value.length - 1);
            short_code_attr[short_code_index] = short_code_value;
          }
          return short_code_attr;
        }
        
        function spider_calendar_select_view(selected_value) {
          for (i = 0; i <= 3; i++) {
            if (document.getElementById('view_' + i).value == selected_value) {
              document.getElementById('view_' + i).checked = true;
            }
          }
        }
        function insert_spider_calendar() {
          var calendar_id = document.getElementById('spider_Calendar').value;
          var theme_id = document.getElementById('spider_Calendar_theme').value;
          var default_view = document.getElementById('default_view').value;
          var select_view = '';
          for (i = 0; i <= 3; i++) {
            if (document.getElementById('view_' + i).checked) {
              select_view = select_view + document.getElementById('view_' + i).value + ',';
            }
          }
          if ((calendar_id != '- Select a Calendar -') && (theme_id != '- Select a Theme -')) {
            var tagtext;
            tagtext = '[Spider_Calendar id="' + calendar_id + '" theme="' + theme_id + '" default="' + default_view + '" select="' + select_view + '"]';
            window.tinyMCE.execCommand('mceInsertContent', false, tagtext);
            tinyMCEPopup.close();
          }
          tinyMCEPopup.close();
        }
      </script>
    </body>
  </html>
  <?php
  die();
}

function seemore() {
  require_once("front_end/frontend_functions.php");
  $calendar = (isset($_GET['calendar_id']) ? (int) $_GET['calendar_id'] : 0);
  $ev_ids = (isset($_GET['ev_ids']) ? esc_html($_GET['ev_ids']) : '');
  $eventID = (isset($_GET['eventID']) ? (int) $_GET['eventID'] : '');
  $widget = ((isset($_GET['widget']) && (int) $_GET['widget']) ? (int) $_GET['widget'] : 0);
  $theme_id = (isset($_GET['theme_id']) ? (int) $_GET['theme_id'] : 1);
  $date = ((isset($_GET['date']) && IsDate_inputed(esc_html($_GET['date']))) ? esc_html($_GET['date']) : '');
  $path_sp_cal = (isset($_GET['cur_page_url']) ? esc_html($_GET['cur_page_url']) : '');
  if ($date != '' && !IsDate_inputed($date)) {
    $date = date("Y-m-d");
  }
  else {
    $date = date("Y") . '-' . php_Month_num_seemore(date("F")) . '-' . date("d");
  }
  global $wpdb;
  if ($widget) {
    $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_widget_theme WHERE id=%d', $theme_id));
    $show_event = 0;
  }
  else {
    $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme WHERE id=%d', $theme_id));
    $show_event = $theme->day_start;
  }
  
  $row_cal =  $wpdb->get_row($wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_calendar where published=1 and id=%d",$calendar));
  
  $title_color = '#' . str_replace('#','',$theme->title_color);
  $title_size = $theme->title_font_size;
  $show_event_bgcolor = '#' . str_replace('#','',$theme->show_event_bgcolor);
  $popup_width = $theme->popup_width;
  $popup_height = $theme->popup_height;
  $show_repeat = $theme->show_repeat;
  $date_color = '#' . str_replace('#','',$theme->date_color);
  $date_size = $theme->date_size;
  $date_font = $theme->date_font;
  $date_format = $theme->date_format;
  $all_files = php_showevent_seemore($calendar, $date);
  $rows = $all_files[0]['rows'];
	
  $date_format_array = explode('/', $date_format);
  $datee = ((isset($_GET['date']) && IsDate_inputed(esc_html($_GET['date']))) ? esc_html($_GET['date']) : date("Y-m-d"));
  $activedate = explode('-', $datee);
  $activedatetimestamp = mktime(0, 0, 0, $activedate[1], $activedate[2], $activedate[0]);
  $activedatestr = '';

  for ($i = 0; $i < count($date_format_array); $i++) {
    if ($date_format_array[$i] == 'w') {
      $date_format_array[$i] = 'l';
    }
    if ($date_format_array[$i] == 'm') {
      $date_format_array[$i] = 'F';
    }
    if ($date_format_array[$i] == 'y') {
      $date_format_array[$i] = 'Y';
    }
  }
  
  for ($i = 0; $i < count($date_format_array); $i++) {
    $activedatestr .= __(date("" . $date_format_array[$i] . "", $activedatetimestamp), 'sp_calendar') . ' ';
  }

  $date = $datee;
  $day = substr($date, 8);
  $ev_id = explode(',', $ev_ids);
  ?>
  <html>
	<head>
	  <script>
		function next(day_events, ev_id, theme_id, calendar_id, date, day) {
		  var p = 0;
		  for (var key in day_events) {
			p = p + 1;
			if (day_events[key] == ev_id && day_events[parseInt(key) + 1]) {
			  window.location = '<?php echo admin_url('admin-ajax.php?action=spidercalendarbig'); ?>&theme_id=' + theme_id + '&calendar_id=' + calendar_id + '&eventID=' + day_events[parseInt(key) + 1] + '&date=' + date + '&day=' + day + '&widget=<?php echo $widget; ?>';
			}
		  }
		}
		function change() {
		  $('#dayevent').ready(function () {
			$('#dayevent').animate({
			  opacity:1,
			  marginLeft:"0in"
			}, 1000, function () {
			});
		  });
		}
		jQuery(document).ready(function() {
		  change();
		});
		// window.onload = change();
		function prev(array1, ev_id, theme_id, calendar_id, date, day) {
		  var day_events = array1;
		  for (var key in day_events) {
			if (day_events[key] == ev_id && day_events[parseInt(key) - 1]) {
			  window.location = '<?php echo admin_url('admin-ajax.php?action=spidercalendarbig'); ?>&theme_id=' + theme_id + '&calendar_id=' + calendar_id + '&eventID=' + day_events[parseInt(key) - 1] + '&date=' + date + '&day=' + day + '&widget=<?php echo $widget; ?>';
			}
		  }
		}
		document.onkeydown = function (evt) {
		  evt = evt || window.event;
		  if (evt.keyCode == 27) {
			window.parent.document.getElementById('sbox-window').close();
		  }
		};
	  </script>
	  <style>
	 body{
		margin:0px;
		padding:0px;
	  }
	  .date_rate{
		  background-image: url(<?php echo plugins_url( 'images/calendar1.png' , __FILE__ ); ?>);    
		  background-repeat: no-repeat; 
		  padding: 5px 0 5px 65px; 
		  line-height: 30px; 
		  background-position: 35px center;  
		  vertical-align:middle;
		  font-family: <?php echo $date_font; ?>;
		  float: left;
	  }
	  .events *{
		 font-family: <?php echo $date_font; ?>; 
	  }
	  .events a{
		  float: left;
		 width: 90%;
	  }
	  .events {
		border: 1px solid #eaeaea;
		overflow: hidden;
		margin: -1px 0 0px 0px;
		position: relative;
		}
	  </style>
  </head>
  <body class="pop_body">
  <div style="background-color:<?php echo $show_event_bgcolor; ?>; height:100%; padding:15px;">
    <?php
	if(!isset($date_font_style)) $date_font_style = "";
echo '<div style="font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_style . ';font-weight:bold;text-align:center;color:' . $date_color . '; margin-bottom: 15px;">'.$activedatestr.'</div>';


  			
      for ($i = 0; $i < count($ev_id); $i++) {


	  $row = $wpdb->get_row($wpdb->prepare ("SELECT " . $wpdb->prefix . "spidercalendar_event.* , " . $wpdb->prefix . "spidercalendar_event_category.color
FROM " . $wpdb->prefix . "spidercalendar_event
LEFT JOIN " . $wpdb->prefix . "spidercalendar_event_category ON " . $wpdb->prefix . "spidercalendar_event.category = " . $wpdb->prefix . "spidercalendar_event_category.id
WHERE " . $wpdb->prefix . "spidercalendar_event.published=1  AND " . $wpdb->prefix . "spidercalendar_event.id=%d",$ev_id[$i]));
	if($row->repeat=='1')

		$repeat='';

		else

		$repeat=$row->repeat;
		
 		$weekdays=explode(',',$row->week);


		
        if ($row->id == $ev_id[$i]) {
		  echo '<div class="events">';
          if ($show_event || $widget==1) {		 
			if(!isset($row->color)) $row->color = "";
			echo '	<div style="border-right: 2px solid #'.str_replace('#','',$row->color).';display: table-cell;font-size: 25px;background-color: #E8E8E8; position: absolute; height: 100%;">'.($i + 1).'&nbsp;</div>';
                 echo '<a style=" padding-left: 30px;text-decoration: none;font-size: 20px;color:' . $title_color . '; line-height:30px"
                    href="' . add_query_arg(array(
                      'action' => 'spidercalendarbig',
                      'theme_id' => $theme_id,
                      'calendar_id' => $calendar,
                      'ev_ids' => $ev_ids,
                      'eventID' => $ev_id[$i],
                      'date' => $date,
                      'day' => $day,
                      'cur_page_url' => $path_sp_cal,
                      'widget' => $widget,
                      'TB_iframe' => 1,
                      'tbWidth' => $popup_width,
                      'tbHeight' => $popup_height,
                      ), admin_url('admin-ajax.php')) . '">&nbsp;';
					  
          echo $row->title . '
                  </a>';
          }
		   else
		  {
		   echo '<div style="border-right: 2px solid #'.str_replace('#','',$row->color).';display: table-cell;font-size: 25px;background-color: #E8E8E8;">&nbsp; &nbsp;&nbsp;</div>';
                 echo '<a style="display: table-cell;text-decoration: none;font-size: 20px;color:' . $title_color . '; line-height:30px"
                    href="' . add_query_arg(array(
                      'action' => 'spidercalendarbig',
                      'theme_id' => $theme_id,
                      'calendar_id' => $calendar,
                      'ev_ids' => $ev_ids,
                      'eventID' => $ev_id[$i],
                      'date' => $date,
                      'day' => $day,
                      'cur_page_url' => $path_sp_cal,
                      'widget' => $widget,
                      'TB_iframe' => 1,
                      'tbWidth' => $popup_width,
                      'tbHeight' => $popup_height,
                      ), admin_url('admin-ajax.php')) . '">&nbsp;';
					  
          echo $row->title . '
                  </a>';
		 
		}
		
		  $healthy = array("/", "m", "y", "w");
		  $yummy   = array(" ","F", "Y", "l");
		  
		  $format_date = str_replace($healthy, $yummy, $date_format);	
		  
          if($row->date_end == "2035-12-12")
			$date_end = '';
		  else
			$date_end = ' - '.date($format_date, strtotime($row->date_end));
		
		  $start_day = date($format_date, strtotime($row->date));
		if($show_repeat){		
		   if ($row->repeat_method == 'daily') {
             echo '<div class="date_rate">Date: '.$start_day.''.$date_end.' ('. __('Repeat Every', 'sp_calendar').' ' .$repeat.' '.__('Day', 'sp_calendar').'), '.convert_time($row_cal->time_format, $row->time) .'</div>';
            }
			
			
				if($row->repeat_method=='weekly')

		{

		echo '<div class="date_rate">Date: '.$start_day.''.$date_end.' ('. __('Repeat Every', 'sp_calendar').' ' .$repeat.' '.__('Week(s) on', 'sp_calendar').' ';

		for ($j=0;$j<count($weekdays);$j++) 

		{

			if($weekdays[$j]!=''){

				if($j!=count($weekdays)-2)

					echo week_convert($weekdays[$j]).', ';

				else

					echo week_convert($weekdays[$j]);

			

			}

			

		}

		echo '), '.convert_time($row_cal->time_format, $row->time) .'</div>';

		}
		
		if($row->repeat_method=='monthly' and $row->month_type==1)

		echo '<div class="date_rate">Date: '.$start_day.''.$date_end.' ('. __('Repeat Every', 'sp_calendar').' ' .$repeat.' '.__('Month(s) on the', 'sp_calendar').' '.$row->month.'), ' .convert_time($row_cal->time_format, $row->time) .'</div>';	



		if($row->repeat_method=='monthly' and $row->month_type==2)

		echo '<div class="date_rate">Date: '.$start_day.''.$date_end.' ('. __('Repeat Every', 'sp_calendar').' '.$repeat.' '.__('Month(s) on the', 'sp_calendar').' '.week_number($row->monthly_list).' '.week_convert($row->month_week).'), ' .convert_time($row_cal->time_format, $row->time) . '</div>';



		if($row->repeat_method=='yearly' and $row->month_type==1)

		echo '<div class="date_rate">Date: '.$start_day.''.$date_end.' ('. __('Repeat Every', 'sp_calendar').' ' .$repeat.' '.__('Year(s) in', 'sp_calendar').' '.date('F',mktime(0,0,0,$row->year_month + 1,0,0)).' '.__('on the', 'sp_calendar').' '.$row->month.'), ' .convert_time($row_cal->time_format, $row->time) .'</div>';	



		if($row->repeat_method=='yearly' and $row->month_type==2)

		echo '<div class="date_rate">Date: '.$start_day.''.$date_end.' ('. __('Repeat Every', 'sp_calendar').' ' .$repeat.' '.__('Year(s) in', 'sp_calendar').' '.date('F',mktime(0,0,0,$row->year_month + 1,0,0)).' '.__('on the', 'sp_calendar').' '.week_number($row->monthly_list).' '.week_convert($row->month_week).'),  ' .convert_time($row_cal->time_format, $row->time) .'</div>';		



		if($row->repeat_method=='no_repeat')

		echo '<div class="date_rate">Date: '.$start_day.'  ' .convert_time($row_cal->time_format, $row->time) .'</div>';	  
		}
		echo '</div>'; 
        }
      }
    
    ?>
</div>
</body>
</html>
  <?php
  die();
}

function spiderbigcalendar() {
  require_once("front_end/frontend_functions.php");
  $calendar_id = (isset($_GET['calendar_id']) ? (int) $_GET['calendar_id'] : 0);
  $date = ((isset($_GET['date']) && IsDate_inputed(esc_html($_GET['date']))) ? esc_html($_GET['date']) : date("Y") . '-' . php_Month_num(date("F")) . '-' . date("d"));
  $ev_ids_inline = (isset($_GET['ev_ids']) ? esc_html($_GET['ev_ids']) : '');
  $eventID = (isset($_GET['eventID']) ? (int) $_GET['eventID'] : '');
  $widget = ((isset($_GET['widget']) && (int) $_GET['widget']) ? (int) $_GET['widget'] : 0);
  $theme_id = (isset($_GET['theme_id']) ? (int) $_GET['theme_id'] : 1);
  global $wpdb;
  if ($widget) {
    $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_widget_theme WHERE id=%d', $theme_id));
  }
  else {
    $theme = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'spidercalendar_theme WHERE id=%d', $theme_id));
  }
  
  $row_cal =  $wpdb->get_row($wpdb->prepare ("SELECT * FROM " . $wpdb->prefix . "spidercalendar_calendar where published=1 and id=%d",$calendar_id));
  
  $title_color = '#' . str_replace('#','',$theme->title_color);
  $title_size = ((isset($theme->title_font_size) && $theme->title_font_size!="") ? $theme->title_font_size : '21');
  $title_font = ((isset($theme->title_font) && $theme->title_font!="") ? $theme->title_font : '');
  $title_style = ((isset($theme->title_style) && $theme->title_style!="") ? $theme->title_style : 'bold');
  $date_color = '#' . str_replace('#','',$theme->date_color);
  $date_size = $theme->date_size;
  $date_font = $theme->date_font;
  $date_style = $theme->date_style;
  $next_prev_event_bgcolor = '#' . str_replace('#','',$theme->next_prev_event_bgcolor);
  $next_prev_event_arrowcolor = '#' . str_replace('#','',$theme->next_prev_event_arrowcolor);
  $show_event_bgcolor = '#' . str_replace('#','',$theme->show_event_bgcolor);
  $popup_width = $theme->popup_width;
  $popup_height = $theme->popup_height;
  $date_format = $theme->date_format;
  $show_repeat = $theme->show_repeat;
  $date_format_array = explode('/', $date_format);


  for ($i = 0; $i < count($date_format_array); $i++) {
    if ($date_format_array[$i] == 'w') {
      $date_format_array[$i] = 'l';
    }
    if ($date_format_array[$i] == 'm') {
      $date_format_array[$i] = 'F';
    }
    if ($date_format_array[$i] == 'y') {
      $date_format_array[$i] = 'Y';
    }
  }
  $all_files_cal = php_showevent($calendar_id, $date, $eventID);
  $row = $all_files_cal[0]['row'];
  $datte = ((isset($_GET['date']) && IsDate_inputed(esc_html($_GET['date']))) ? esc_html($_GET['date']) : date("Y-m-d"));
  $activedate = explode('-', $datte);
  $activedatetimestamp = mktime(0, 0, 0, $activedate[1], $activedate[2], $activedate[0]);
  $activedatestr = '';

  for ($i = 0; $i < count($date_format_array); $i++) {
    $activedatestr .= __(date("" . $date_format_array[$i] . "", $activedatetimestamp), 'sp_calendar') . ' ';
  }
  $date = $datte;
  $day = substr($date, 8);
  $ev_id = explode(',', $ev_ids_inline);
  
  
  ?>
  <html>
	  <head>
		  <script>
			function next(day_events, ev_id, theme_id, calendar_id, date, day, ev_ids) {
			  var p = 0;
			  for (var key in day_events) {
				p = p + 1;
				if (day_events[key] == ev_id && day_events[parseInt(key) + 1]) {
				  window.location = '<?php echo admin_url('admin-ajax.php?action=spidercalendarbig')?>&theme_id=' + theme_id + '&calendar_id=' + calendar_id + '&ev_ids=' + ev_ids + '&eventID=' + day_events[parseInt(key) + 1] + '&date=' + date + '&day=' + day + '&widget=<?php echo $widget; ?>';
				}
			  }
			}
			function change() {
			  jQuery('#dayevent').ready(function () {
				jQuery('#dayevent').animate({
				  opacity:1,
				  marginLeft:"0in"
				}, 1000, function () {
				});
			  });
			}
			jQuery(document).ready(function() {
			  change();
			});
			// window.onload = change();
			function prev(array1, ev_id, theme_id, calendar_id, date, day, ev_ids) {
			  var day_events = array1;
			  for (var key in day_events) {
				if (day_events[key] == ev_id && day_events[parseInt(key) - 1]) {
				  window.location = '<?php echo admin_url('admin-ajax.php?action=spidercalendarbig')?>&theme_id=' + theme_id + '&calendar_id=' + calendar_id + '&ev_ids=' + ev_ids + '&eventID=' + day_events[parseInt(key) - 1] + '&date=' + date + '&day=' + day + '&widget=<?php echo $widget; ?>';
				}
			  }
			}
			document.onkeydown = function (evt) {
			  evt = evt || window.event;
			  if (evt.keyCode == 27) {
				window.parent.document.getElementById('sbox-window').close();
			  }
			};
		  </script>	  
		  <?php 
		  $color = $wpdb->get_results("SELECT " . $wpdb->prefix . "spidercalendar_event.* , " . $wpdb->prefix . "spidercalendar_event_category.color
		FROM " . $wpdb->prefix . "spidercalendar_event
		JOIN " . $wpdb->prefix . "spidercalendar_event_category ON " . $wpdb->prefix . "spidercalendar_event.category = " . $wpdb->prefix . "spidercalendar_event_category.id
		WHERE " . $wpdb->prefix . "spidercalendar_event_category.published=1 AND " . $wpdb->prefix . "spidercalendar_event.id='".$row->id."'");

		  ?>
		  <style>
			#dayevent {
			  opacity: 1;
			}
			#previous,
			#next {
			  cursor: pointer;
			  height: <?php echo $popup_height - 51; ?>px;
			  width: 5%;
			}
			.arrow {
			  color: <?php echo $next_prev_event_arrowcolor; ?>;
			  font-size: 50px;
			  text-decoration: none;
			}
			body{
			margin:0px;
			padding:0px;
			}
		  </style>
	 </head>
 <body class="pop_body">
  <table style="height:100%;width:100%;background-color:<?php echo $show_event_bgcolor; ?>; border-spacing:0" align="center" id="pop_table">
    <tr>
      <td id="previous"
        onClick="prev([<?php echo $ev_ids_inline; ?>],<?php echo $eventID; ?>,<?php echo $theme_id ?>,<?php echo $calendar_id ?>,'<?php echo $date; ?>',<?php echo $day ?>,'<?php echo $ev_ids_inline ?>')"
        style="<?php if (count($ev_id) == 1 or $eventID == $ev_id[0])
          echo 'display:none'; ?>;text-align:center"
        onMouseOver="document.getElementById('previous').style.backgroundColor='<?php echo $next_prev_event_bgcolor ?>'"
        onMouseOut="document.getElementById('previous').style.backgroundColor=''">
        <span class="arrow">&lt;</span>
      </td>
      <td style="vertical-align:top; width:45%">
        <?php
        echo '<div id="dayevent" style="padding:0px 0px 0px 7px ;line-height:30px; padding-top:0px;">
		';
        if ($date_style == "bold" or $date_style == "bold/italic") {
          $date_font_weight = "font-weight:bold";
        }
        else {
          $date_font_weight = "font-weight:normal";
        }
        if ($date_style == "italic" or $date_style == "bold/italic") {
          $date_font_style = "font-style:italic";
        }
        else {
          $date_font_style = "";
        }
        echo '<div style="text-align:center;border-bottom:1px solid #F3F3F3;color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_weight . '; ' . $date_font_style . '  ">' . $activedatestr . '</div>';
        if ($title_style == "bold" or $title_style == "bold/italic") {
          $font_weight = "font-weight:bold";
        }
        else {
          $font_weight = "font-weight:normal";
        }
        if ($title_style == "italic" or $title_style == "bold/italic") {
          $font_style = "font-style:italic";
        }
        else {
          $font_style = "";
        }
        $weekdays = explode(',', $row->week);
        $date_format1 = substr($theme->date_format, 2);
        if ($row->repeat == '1') {
          $repeat = '';
        }
        else {
          $repeat = $row->repeat;
        }
        if ($row->date_end == '2035-12-12') {
          $row->date_end = '';
        }
        
          if ($row->date_end and $row->date_end != '0000-00-00') {
            echo '<div style="color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_weight . '; ' . $date_font_style . '  ">' . __('Date', 'sp_calendar') . ':' . str_replace("d", substr($row->date, 8, 2), str_replace("m", substr($row->date, 5, 2), str_replace("y", substr($row->date, 0, 4), $date_format1))) . '&nbsp;-&nbsp;' . str_replace("d", substr($row->date_end, 8, 2), str_replace("m", substr($row->date_end, 5, 2), str_replace("y", substr($row->date_end, 0, 4), $date_format1))) . '&nbsp;' . convert_time($row_cal->time_format, $row->time) . '</div>';
          }
          else {
            echo '<div style="color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $font_weight . '; ' . $font_style . '  ">' . convert_time($row_cal->time_format, $row->time) . '</div>';
          }
          if ($show_repeat == 1) {
            if ($row->repeat_method == 'daily') {

              echo '<div style="color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_weight . '; ' . $date_font_style . '  ">' . __('Repeat Every', 'sp_calendar') . ' ' . $repeat . ' ' . __('Day', 'sp_calendar') . '</div>';
            }
            if ($row->repeat_method == 'weekly') {
              echo '<div style="color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_weight . '; ' . $date_font_style . '  ">' . __('Repeat Every', 'sp_calendar') . ' ' . $repeat . ' ' . __('Week(s) on', 'sp_calendar') . ' : ';
              for ($i = 0; $i < count($weekdays); $i++) {
                if ($weekdays[$i] != '') {
                  if ($i != count($weekdays) - 2) {
                    echo week_convert($weekdays[$i]) . ', ';
                  }
                  else {
                    echo week_convert($weekdays[$i]);
                  }
                }
              }
              echo '</div>';
            }
            if ($row->repeat_method == 'monthly' and $row->month_type == 1) {
              echo '<div style="color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_weight . '; ' . $date_font_style . '  ">' . __('Repeat Every', 'sp_calendar') . ' ' . $repeat . ' ' . __('Month(s) on the', 'sp_calendar') . ' ' . $row->month . '</div>';
            }
            if ($row->repeat_method == 'monthly' and $row->month_type == 2) {
              echo '<div style="color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_weight . '; ' . $date_font_style . '  ">' . __('Repeat Every', 'sp_calendar') . ' ' . $repeat . ' ' . __('Month(s) on the', 'sp_calendar') . ' ' . week_number($row->monthly_list) . ' ' . week_convert($row->month_week) . '</div>';
            }
            if ($row->repeat_method == 'yearly' and $row->month_type == 1) {
              echo '<div style="color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_weight . '; ' . $date_font_style . '  ">' . __('Repeat Every', 'sp_calendar') . ' ' . $repeat . ' ' . __('Year(s) in', 'sp_calendar') . ' ' . date('F', mktime(0, 0, 0, $row->year_month + 1, 0, 0)) . ' ' . __('on the', 'sp_calendar') . ' ' . $row->month . '</div>';
            }
            if ($row->repeat_method == 'yearly' and $row->month_type == 2) {
              echo '<div style="color:' . $date_color . ';font-size:' . $date_size . 'px; font-family:' . $date_font . '; ' . $date_font_weight . '; ' . $date_font_style . '  ">' . __('Repeat Every', 'sp_calendar') . ' ' . $repeat . ' ' . __('Year(s) in', 'sp_calendar') . ' ' . date('F', mktime(0, 0, 0, $row->year_month + 1, 0, 0)) . ' ' . __('on the', 'sp_calendar') . ' ' . week_number($row->monthly_list) . ' ' . week_convert($row->month_week) . '</div>';
            }
          }
		  if(isset($row->title)) $row_title=$row->title;
		  else $row_title ="";
		  if(isset($color[0]->color))
		  $row_color = $color[0]->color;
		  else
		  $row_color = "";
		  
          echo '<div style="color:' . $title_color . ';font-size:' . $title_size . 'px; font-family:' . $title_font . '; ' . $font_weight . '; ' . $font_style . '  ">' . $row_title . '</div>';
		  if ($row->text_for_date != '') {

		  $pop_content = wpautop($row->text_for_date);
		  $pop_content = do_shortcode($pop_content);
		  
          echo '<div style="line-height:20px">' . $pop_content . '</div>';
		  }
		   else {
	
          echo '<p style="text-align:center">' . __('There Is No Text For This Event', 'sp_calendar') . '</p>';
        }
        
       
        echo '</div>';

        ?>
        <div style="height:50px;width:98%;text-align:right;<?php if(count($ev_id) == 1) echo 'display:none;' ?>">
          <a class="back_cal" style="color:<?php echo $title_color; ?>;font-size:15px; font-family:<?php echo $title_font; ?>;<?php echo $font_weight; ?>;<?php echo $font_style; ?>;"
            href="<?php echo add_query_arg(array(
                        'action' => 'spiderseemore',
                        'theme_id' => $theme_id,
                        'calendar_id' => $calendar_id,
                        'ev_ids' => $ev_ids_inline,
                        'date' => $date,
                        'widget' => $widget,
                        'TB_iframe' => 1,
                        'tbWidth' => $popup_width,
                        'tbHeight' => $popup_height,
                        ), admin_url('admin-ajax.php')); ?>"><?php echo __('Back to event list', 'sp_calendar'); ?>
          </a>
        </div><br>
		<br>
      </td>
      <td id="next"
          onclick="next([<?php echo $ev_ids_inline ?>],<?php echo $eventID ?>,<?php echo $theme_id ?>,<?php echo $calendar_id ?>,'<?php echo $date ?>',<?php echo $day ?>,'<?php echo $ev_ids_inline ?>')"
          style="<?php if (count($ev_id) == 1 or $eventID == end($ev_id))
            echo 'display:none' ?>;text-align:center"
          onMouseOver="document.getElementById('next').style.backgroundColor='<?php echo $next_prev_event_bgcolor ?>'"
          onMouseOut="document.getElementById('next').style.backgroundColor=''">
        <span class="arrow">&gt;</span>
      </td>
    </tr>
  </table>
  <?php
  ////////////////
  $url_for_page = (isset($_GET['cur_page_url']) ? esc_html($_GET['cur_page_url']) : '');
  $url_for_page_de = urldecode($url_for_page);
  if (!strpos($url_for_page_de, '?')) {
    $cuery_string = '?' . $_SERVER['QUERY_STRING'];
  }
  else {
    $cuery_string = '&' . $_SERVER['QUERY_STRING'];
  }
  $url_for_page_de .= $cuery_string;
  $url_for_page_de = str_replace('theme_id=', 'frst_theme_id=\'', $url_for_page_de);
  $url_for_page_de = str_replace('calendar_id=', 'frst_calendar_id=\'', $url_for_page_de);
  $url_for_page_de = str_replace('ev_ids=', 'frst_ev_ids=\'', $url_for_page_de);
  $url_for_page_de = str_replace('eventID=', 'frst_eventID=\'', $url_for_page_de);
  $url_for_page_de = str_replace('date=', 'frst_date=\'', $url_for_page_de);
  $url_for_page_de = str_replace('day=', 'frst_day=\'', $url_for_page_de);
  if (substr($url_for_page_de, -1) == '&') {
    $url_for_page_de = substr_replace($url_for_page_de, "", -1);
  }
  $zzzzzzzzz = 0;
  if ($zzzzzzzzz == 1) {
    ?>
  <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode($url_for_page_de); ?>" scrolling="no"
          frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;"
          allowTransparency="true"></iframe>
  <?php
  }
   ?>
  </body>
</html>
<?php
  die();
  }

?>