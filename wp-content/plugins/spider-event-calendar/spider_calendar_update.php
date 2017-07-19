<?php function spider_calendar_chech_update() {
  global $wpdb;
  // if (get_site_option('spider_calendar_cureent_version') != '1.3' || !get_site_option('spider_calendar_cureent_version', FALSE)) {
  // if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "formmaker_sessions'") != $wpdb->prefix . "formmaker_sessions") {
  // if ($wpdb->query("ALTER TABLE `" . $wpdb->prefix . "spidercalendar_theme` IF EXISTS "))
 
 $category = $wpdb->get_results("SHOW COLUMNS FROM ".$wpdb->prefix."spidercalendar_event");
	$catexist=0;
	for($i=0;$i<count($category);$i++){
	if($category[$i]->Field=="category"){
	$catexist=1;
	break;
	}

}

	if($catexist==0)
	{
	$wpdb->query("ALTER TABLE ".$wpdb->prefix."spidercalendar_event  ADD category int(11) AFTER title;");
	}


$calendar = $wpdb->get_results("SHOW COLUMNS FROM ".$wpdb->prefix."spidercalendar_calendar");
	$calexist=0;
	for($i=0;$i<count($calendar);$i++){
	if($calendar[$i]->Field=="start_month"){
	$calexist=1;
	break;
	}
	}
	
	
	$calendar1 = $wpdb->get_results("SHOW COLUMNS FROM ".$wpdb->prefix."spidercalendar_calendar");
	$calexist1=0;
	for($i=0;$i<count($calendar1);$i++){
	if($calendar1[$i]->Field=="def_month"){
	$calexist1=1;
	break;
	}
	}
	
	$def_zone = 0;
	for($i=0;$i<count($calendar1);$i++){
		if($calendar1[$i]->Field=="def_zone"){
		  $def_zone = 1;
		  break;
		}
	  }
	  if($def_zone == 0) {
		$wpdb->query("ALTER TABLE " . $wpdb->prefix . "spidercalendar_calendar ADD def_zone varchar(255) DEFAULT 'Asia/Muscat'");
	  } 
	
	
	
if ($calexist1 == 0) {
    if ($calexist == 0) {
      $sql = "ALTER TABLE " . $wpdb->prefix . "spidercalendar_calendar ADD start_month varchar(255);";
      $wpdb->query($sql);
    }
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "spidercalendar_calendar ADD `def_month` varchar(255) NOT NULL AFTER `start_month`");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "spidercalendar_calendar CHANGE `start_month` `def_year` VARCHAR(512) NOT NULL");
}
	$wpdb->query("DROP TABLE IF EXISTS `" . $wpdb->prefix . "spidercalendar_theme`");
	  $spider_theme_table = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "spidercalendar_theme` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `title` varchar(255) NOT NULL,
	  `width` varchar(255) NOT NULL,
	  `cell_height` varchar(255) NOT NULL,
	  `bg_top` varchar(255) NOT NULL,
	  `bg_bottom` varchar(255) NOT NULL,
	  `border_color` varchar(255) NOT NULL,
	  `text_color_year` varchar(255) NOT NULL,
	  `text_color_month` varchar(255) NOT NULL,
	  `text_color_week_days` varchar(255) NOT NULL,
	  `text_color_other_months` varchar(255) NOT NULL,
	  `text_color_this_month_unevented` varchar(255) NOT NULL,
	  `text_color_this_month_evented` varchar(255) NOT NULL,
	  `event_title_color` varchar(255) NOT NULL,
	  `current_day_border_color` varchar(255) NOT NULL,
	  `bg_color_this_month_evented` varchar(255) NOT NULL,
	  `next_prev_event_arrowcolor` varchar(255) NOT NULL,
	  `show_event_bgcolor` varchar(255) NOT NULL,
	  `cell_border_color` varchar(255) NOT NULL,
	  `arrow_color_year` varchar(255) NOT NULL,
	  `week_days_cell_height` varchar(255) NOT NULL,
	  `arrow_color_month` varchar(255) NOT NULL,
	  `text_color_sun_days` varchar(255) NOT NULL,
	  `title_color` varchar(255) NOT NULL,
	  `next_prev_event_bgcolor` varchar(255) NOT NULL,
	  `title_font_size` varchar(255) NOT NULL,
	  `title_font` varchar(255) NOT NULL,
	  `title_style` varchar(255) NOT NULL,
	  `date_color` varchar(255) NOT NULL,
	  `date_size` varchar(255) NOT NULL,
	  `date_font` varchar(255) NOT NULL,
	  `date_style` varchar(255) NOT NULL,
	  `popup_width` varchar(255) NOT NULL,
	  `popup_height` varchar(255) NOT NULL,
	  `number_of_shown_evetns` varchar(255) NOT NULL,
	  `sundays_font_size` varchar(255) NOT NULL,
	  `other_days_font_size` varchar(255) NOT NULL,
	  `weekdays_font_size` varchar(255) NOT NULL,
	  `border_width` varchar(255) NOT NULL,
	  `top_height` varchar(255) NOT NULL,
	  `bg_color_other_months` varchar(255) NOT NULL,
	  `sundays_bg_color` varchar(255) NOT NULL,
	  `weekdays_bg_color` varchar(255) NOT NULL,
	  `week_start_day` varchar(255) NOT NULL,
	  `weekday_sunday_bg_color` varchar(255) NOT NULL,
	  `border_radius` varchar(255) NOT NULL,
	  `year_font_size` varchar(255) NOT NULL,
	  `month_font_size` varchar(255) NOT NULL,
	  `arrow_size` varchar(255) NOT NULL,
	  `next_month_text_color` varchar(255) NOT NULL,
	  `prev_month_text_color` varchar(255) NOT NULL,
	  `next_month_arrow_color` varchar(255) NOT NULL,
	  `prev_month_arrow_color` varchar(255) NOT NULL,
	  `next_month_font_size` varchar(255) NOT NULL,
	  `prev_month_font_size` varchar(255) NOT NULL,
	  `month_type` varchar(255) NOT NULL,
	  `date_format` varchar(255) NOT NULL,
	  `show_time` int(11) NOT NULL,
	  `show_cat` int(11) NOT NULL,
	  `show_repeat` int(11) NOT NULL,
	  `date_bg_color` varchar(255) NOT NULL,
	  `event_bg_color1` varchar(255) NOT NULL,
	  `event_bg_color2` varchar(255) NOT NULL,
	  `event_num_bg_color1` varchar(255) NOT NULL,
	  `event_num_bg_color2` varchar(255) NOT NULL,
	  `event_num_color` varchar(255) NOT NULL,
	  `date_font_size` varchar(255) NOT NULL,
	  `event_num_font_size` varchar(255) NOT NULL,
	  `event_table_height` varchar(255) NOT NULL,
	  `date_height` varchar(255) NOT NULL,
	  `ev_title_bg_color` varchar(255) NOT NULL,
	  `week_font_size` varchar(255) NOT NULL,
	  `day_month_font_size` varchar(255) NOT NULL,
	  `week_font_color` varchar(255) NOT NULL,
	  `day_month_font_color` varchar(255) NOT NULL,
	  `views_tabs_bg_color` varchar(255) NOT NULL,
	  `views_tabs_text_color` varchar(255) NOT NULL,
	  `views_tabs_font_size` varchar(255) NOT NULL,
	  `day_start` int(11) NOT NULL,
	  `header_format` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	$wpdb->query($spider_theme_table);
	$spider_theme_rows = "INSERT INTO `" . $wpdb->prefix . "spidercalendar_theme` (`id`, `title`, `width`, `cell_height`, `bg_top`, `bg_bottom`, `border_color`, `text_color_year`, `text_color_month`, `text_color_week_days`, `text_color_other_months`, `text_color_this_month_unevented`, `text_color_this_month_evented`, `event_title_color`, `current_day_border_color`, `bg_color_this_month_evented`, `next_prev_event_arrowcolor`, `show_event_bgcolor`, `cell_border_color`, `arrow_color_year`, `week_days_cell_height`, `arrow_color_month`, `text_color_sun_days`, `title_color`, `next_prev_event_bgcolor`, `title_font_size`, `title_font`, `title_style`, `date_color`, `date_size`, `date_font`, `date_style`, `popup_width`, `popup_height`, `number_of_shown_evetns`, `sundays_font_size`, `other_days_font_size`, `weekdays_font_size`, `border_width`, `top_height`, `bg_color_other_months`, `sundays_bg_color`, `weekdays_bg_color`, `week_start_day`, `weekday_sunday_bg_color`, `border_radius`, `year_font_size`, `month_font_size`, `arrow_size`, `next_month_text_color`, `prev_month_text_color`, `next_month_arrow_color`, `prev_month_arrow_color`, `next_month_font_size`, `prev_month_font_size`, `month_type`, `date_format`, `show_time`, `show_cat`, `show_repeat`, `date_bg_color`, `event_bg_color1`, `event_bg_color2`, `event_num_bg_color1`, `event_num_bg_color2`, `event_num_color`, `date_font_size`, `event_num_font_size`, `event_table_height`, `date_height`, `ev_title_bg_color`, `week_font_size`, `day_month_font_size`, `week_font_color`, `day_month_font_color`, `views_tabs_bg_color`, `views_tabs_text_color`, `views_tabs_font_size`, `day_start`, `header_format`) VALUES
	(13, 'Shiny Blue', '700', '90', '005478', 'F8F8F8', '005478', 'F9F2F4', 'F9F2F4', 'CCD1D2', '004B6C', '004B6C', '004B6C', '005478', '005478', 'F8F8F8', '97A0A6', 'B4C5CC', 'CCD1D2 ', 'CCD1D2', '30', 'CCD1D2', '004B6C', 'FFFFFF', '00608A', '', '', 'normal', '262626', '', '', 'normal', '600', '500', '1', '17', '17', '17', '0', '90', 'F8F8F8', 'F8F8F8', '006285', 'su', '006285', '0', '25', '25', '25', 'CCD1D2', 'CCD1D2', 'CCD1D2', '1010A4', '16', '16', '2', 'w/d/m/y', 1, 1, 1, 'D6D4D5', 'F8F8F8', 'DEDCDD', '005478', '006E91', 'FFFFFF', '15', '13', '30', '25', 'F8F8F8', '15', '12', '005476', '737373', '01799C', 'FFFFFF', '13', 1, 'w/d/m/y');";
	$wpdb->query($spider_theme_rows);

	$wpdb->query("DROP TABLE IF EXISTS `" . $wpdb->prefix . "spidercalendar_widget_theme`");
	$spider_widget_theme_table = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "spidercalendar_widget_theme` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `title` varchar(255) NOT NULL,
	  `ev_title_color` varchar(255),
	  `width` varchar(255) NOT NULL,
	  `week_start_day` varchar(255) NOT NULL,
	  `show_cat` int(11) NOT NULL,
	  `font_year` varchar(255) NOT NULL,
	  `font_month` varchar(255) NOT NULL,
	  `font_day` varchar(255) NOT NULL,
	  `font_weekday` varchar(255) NOT NULL,
	  `header_bgcolor` varchar(255) NOT NULL,
	  `footer_bgcolor` varchar(255) NOT NULL,
	  `text_color_month` varchar(255) NOT NULL,
	  `text_color_week_days` varchar(255) NOT NULL,
	  `text_color_other_months` varchar(255) NOT NULL,
	  `text_color_this_month_unevented` varchar(255) NOT NULL,
	  `text_color_this_month_evented` varchar(255) NOT NULL,
	  `bg_color_this_month_evented` varchar(255) NOT NULL,
	  `bg_color_selected` varchar(255) NOT NULL,
	  `arrow_color` varchar(255) NOT NULL,
	  `text_color_selected` varchar(255) NOT NULL,
	  `border_day` varchar(255) NOT NULL,
	  `text_color_sun_days` varchar(255) NOT NULL,
	  `weekdays_bg_color` varchar(255) NOT NULL,
	  `su_bg_color` varchar(255) NOT NULL,
	  `cell_border_color` varchar(255) NOT NULL,
	  `year_font_size` varchar(255) NOT NULL,
	  `year_font_color` varchar(255) NOT NULL,
	  `year_tabs_bg_color` varchar(255) NOT NULL,
	  `date_format` varchar(255) NOT NULL,
	  `title_color` varchar(255) NOT NULL,
	  `title_font_size` varchar(255) NOT NULL,
	  `title_font` varchar(255) NOT NULL,
	  `title_style` varchar(255) NOT NULL,
	  `date_color` varchar(255) NOT NULL,
	  `date_size` varchar(255) NOT NULL,
	  `date_font` varchar(255) NOT NULL,
	  `date_style` varchar(255) NOT NULL,
	  `next_prev_event_bgcolor` varchar(255) NOT NULL,
	  `next_prev_event_arrowcolor` varchar(255) NOT NULL,
	  `show_event_bgcolor` varchar(255) NOT NULL,
	  `popup_width` varchar(255) NOT NULL,
	  `popup_height` varchar(255) NOT NULL,
	  `show_repeat` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	$wpdb->query($spider_widget_theme_table);
	$spider_widget_theme_rows = "INSERT INTO `" . $wpdb->prefix . "spidercalendar_widget_theme` (`id`,`title`,`ev_title_color`,`width`,`week_start_day`, `show_cat`, `font_year`,`font_month`,`font_day`,`font_weekday`,`header_bgcolor`,`footer_bgcolor`,`text_color_month`,`text_color_week_days`,`text_color_other_months`,`text_color_this_month_unevented`,`text_color_this_month_evented`,`bg_color_this_month_evented`,`bg_color_selected`,`arrow_color`,`text_color_selected`,`border_day`,`text_color_sun_days`,`weekdays_bg_color`,`su_bg_color`,`cell_border_color`,`year_font_size`,`year_font_color`,`year_tabs_bg_color`,`date_format`,`title_color`,`title_font_size`,`title_font`,`title_style`,`date_color`,`date_size`,`date_font`,`date_style`,`next_prev_event_bgcolor`,`next_prev_event_arrowcolor`,`show_event_bgcolor`,`popup_width`,`popup_height`,`show_repeat`) VALUES
	  (1,'Shiny Blue','005478','200','mo','1','','','','','005478','E1E1E1','FFFFFF','2F647D','939699','989898','FBFFFE','005478','005478','CED1D0','FFFFFF','005478','989898','D6D6D6','B5B5B5','D2D2D2','13','ACACAC','ECECEC','w/d/m/y','FFFFFF','','','normal','262626','','','normal','00608A','97A0A6','B4C5CC','600','500','1')";
	$wpdb->query($spider_widget_theme_rows);
} ?>