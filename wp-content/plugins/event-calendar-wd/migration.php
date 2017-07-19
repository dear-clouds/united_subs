<?php

/**
 * Migrating old plugin data to the new one
 * old tables:
 * ecwdcalendar_calendar, ecwdcalendar_event, ecwdcalendar_event_category, ecwdcalendar_theme, ecwdcalendar_widget_theme)
 */
 
function migrate_data() {
	global $wpdb;
	
	echo 'upgrading...<br />';
	$ecwdcalendar_calendar_tbl = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ecwdcalendar_calendar");
	$ecwdcalendar_event_tbl = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ecwdcalendar_event");
	$ecwdcalendar_event_category_tbl = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ecwdcalendar_event_category");
	$ecwdcalendar_calendar_theme_tbl = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ecwdcalendar_theme");
	$ecwdcalendar_calendar_widget_theme_tbl = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ecwdcalendar_widget_theme");

	
	
	
	
	//var_dump($ecwdcalendar_calendar_theme_tbl);
	
	//calendars migration
	for ($i = 0; $i < count($ecwdcalendar_calendar_tbl); ++$i) {
			if (NULL === get_page_by_title($ecwdcalendar_calendar_tbl[$i]->title, 'OBJECT', ECWD_PLUGIN_PREFIX.'_calendar')) {
					$new_post_id = wp_insert_post(array('post_type' => ECWD_PLUGIN_PREFIX.'_calendar', 'post_status' => 'publish', 'post_title' => $ecwdcalendar_calendar_tbl[$i]->title,));
					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_calendar_default_year', $ecwdcalendar_calendar_tbl[$i]->def_year, true);
					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_calendar_default_month', $ecwdcalendar_calendar_tbl[$i]->def_month, true);
					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_calendar_12_hour_time_format', $ecwdcalendar_calendar_tbl[$i]->time_format, true);
			}
	}
	
	//events migration
	$days = array('Mon' => ECWD_PLUGIN_PREFIX.'_event_day_monday', 'Tue' => ECWD_PLUGIN_PREFIX.'_event_day_tuesday', 'Wed' => ECWD_PLUGIN_PREFIX.'_event_day_wendesday', 'Thu' => ECWD_PLUGIN_PREFIX.'_event_day_thursday', 'Fri' => ECWD_PLUGIN_PREFIX.'_event_day_friday', 'Sat' => ECWD_PLUGIN_PREFIX.'_event_day_saturday', 'Sun' => ECWD_PLUGIN_PREFIX.'_event_day_sunday');

	for ($i = 0; $i < count($ecwdcalendar_event_tbl); ++$i) {
			if (NULL === get_page_by_title($ecwdcalendar_event_tbl[$i]->title, 'OBJECT', ECWD_PLUGIN_PREFIX.'_event')) {
					$new_post_id = wp_insert_post(array('post_type' => ECWD_PLUGIN_PREFIX.'_event', 'post_status' => 'publish', 'post_title' => $ecwdcalendar_event_tbl[$i]->title,));

					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_description', $ecwdcalendar_event_tbl[$i]->text_for_date, true);
					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_date_from', $ecwdcalendar_event_tbl[$i]->date, true);
					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_date_to', $ecwdcalendar_event_tbl[$i]->date_end, true);
					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_event', $ecwdcalendar_event_tbl[$i]->repeat_method, true);
					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_how', $ecwdcalendar_event_tbl[$i]->repeat, true);
					add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_repeat_until', $ecwdcalendar_event_tbl[$i]->date_end, true);
					
					if ($ecwdcalendar_event_tbl[$i]->year_month != '') {
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_year_month', $ecwdcalendar_event_tbl[$i]->year_month, true);
					}
					
					if ($ecwdcalendar_event_tbl[$i]->month_type == '1') {
						//	first on the radio button
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_enable_disable_m', ECWD_PLUGIN_PREFIX.'_event_repeat_enable_disable_1', true);
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_enable_disable_y', ECWD_PLUGIN_PREFIX.'_event_repeat_enable_disable_1', true);
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_on_the_m', $ecwdcalendar_event_tbl[$i]->month, true);
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_on_the_y', $ecwdcalendar_event_tbl[$i]->month, true);
					} else if ($ecwdcalendar_event_tbl[$i]->month_type == '2') {
						//	second on the radio button
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_enable_disable_m', ECWD_PLUGIN_PREFIX.'_event_repeat_enable_disable_2', true);
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_monthly_list_monthly', $ecwdcalendar_event_tbl[$i]->monthly_list, true);
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_monthly_week_monthly', strtolower($ecwdcalendar_event_tbl[$i]->month_week), true);

						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_event_repeat_enable_disable_y', ECWD_PLUGIN_PREFIX.'_event_repeat_enable_disable_2', true);
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_monthly_list_yearly', $ecwdcalendar_event_tbl[$i]->monthly_list, true);
						add_post_meta($new_post_id, ECWD_PLUGIN_PREFIX.'_monthly_week_yearly', strtolower($ecwdcalendar_event_tbl[$i]->month_week), true);
					}

					$week_days_old = explode(',', $ecwdcalendar_event_tbl[$i]->week);
					foreach ($days as $day => $field) {
							if (false !== array_search($day, $week_days_old)) {
									add_post_meta($new_post_id, $field, $field, true);
							}
					}
			}
	}
}
?>