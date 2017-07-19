<?php

class MovDB_LastScreenings_View extends MovDB_View
{
	function get_list_class ()
	{
		return 'movdb-last-screenings';
	}
	
	function get_no_results_message ()
	{
		return __('No screenings found.', 'movdb');
	}
	
	function get_grouping_column ()
	{
		return 'date';
	}
	
	function get_group_title ($group_key)
	{
		return date_i18n(get_option('date_format'), strtotime($group_key));
	}
	
	function get_item_title ($item)
	{
		return $item['title'];
	}
	
	function get_item_content ($item)
	{
		$content = array();
		
		if (!empty($item['rating'])) {
			$content[] = movdb_format_rating($item['rating']);
		} else {
			$content[] = '<a href="' . admin_url('admin.php?page=movdb_movies_page&action=edit&movie=' . $item['movie']) . '">' . __('rate', 'movdb') . '</a>';
		}
		
		if (empty($item['year'])) {
			$content[] = '<a href="' . admin_url('admin.php?page=movdb_movies_page&action=edit&movie=' . $item['movie']) . '">' . __('complete data', 'movdb') . '</a>';
		}
		
		if (!empty($item['guests'])) {
			$content[] = '<span class="guests">' . __('with', 'movdb') . ' ' . movdb_format_guests($item['guests']) . '</span>';
		}
		
		return '<p>' . implode('; ', $content) . '</p>';
	}
	
	function prepare_items ()
	{
		global $wpdb;
		
		$query = 'SELECT scr.*, mov.title, mov.year, mov.rating ' .
		         'FROM ' . $wpdb->prefix . 'movdb_screenings scr ' .
		         'LEFT OUTER JOIN ' . $wpdb->prefix . 'movdb_movies mov ON scr.movie = mov.id ' .
		         'ORDER BY date desc, id desc LIMIT 5';
		//var_dump($query);
		
		$results = $wpdb->get_results($query, ARRAY_A);
		
		$this->data = $results;
	}
}

?>