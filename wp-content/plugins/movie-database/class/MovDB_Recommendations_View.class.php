<?php

class MovDB_Recommendations_View extends MovDB_View
{
	function get_list_class ()
	{
		return 'movdb-recommendations';
	}
	
	function get_no_results_message ()
	{
		return __('No suggestions available.', 'movdb');
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
		
		$content[] = '<span class="seen">' . $item['seen'] . ' ' . __('x seen', 'movdb') . '</span>';
		
		if (!empty($item['days_not_seen'])) {
			$content[] = '<span class="days-not-seen">' . sprintf(__('last seen %1$s days ago', 'movdb'), $item['days_not_seen']) . '</span>';
		}
		
		return '<p>' . implode('; ', $content) . '</p>';
	}
	
	function prepare_items ()
	{
		global $wpdb;
		
		$query = 'SELECT mov.id as movie, mov.title, mov.year, mov.rating, ' .
		         '(SELECT count(*) FROM ' . $wpdb->prefix . 'movdb_screenings WHERE movie = mov.id) + mov.approx_seen_formerly as seen, ' .
		         'datediff(now(), (SELECT max(date) FROM ' . $wpdb->prefix . 'movdb_screenings WHERE movie = mov.id)) as days_not_seen ' .
		         'FROM ' . $wpdb->prefix . 'movdb_movies mov ' .
		         'WHERE mov.rating > 6 ' .
		         'ORDER BY (rating / seen * days_not_seen) desc, -days_not_seen asc ' .
		         'LIMIT 5';
		//var_dump($query);
		
		$results = $wpdb->get_results($query, ARRAY_A);
		
		$this->data = $results;
	}
}

?>