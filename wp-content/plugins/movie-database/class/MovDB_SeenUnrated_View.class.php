<?php

class MovDB_SeenUnrated_View extends MovDB_View
{
	function get_list_class ()
	{
		return 'movdb-seen-unrated';
	}
	
	function get_no_results_message ()
	{
		return __('All seen movies have already been rated.', 'movdb');
	}
	
	function get_grouping_column ()
	{
		return null;
	}
	
	function get_item_title ($item)
	{
		return $item['title'];
	}
	
	function get_item_content ($item)
	{
		$content = array();
		
		if (empty($item['year'])) {
			$content[] = '<a href="' . admin_url('admin.php?page=movdb_movies_page&action=edit&movie=' . $item['movie']) . '">' . __('complete data', 'movdb') . '</a>';
		}
		
		if (!empty($item['guests'])) {
			$content[] = '<span class="guests">' . __('with', 'movdb') . ' ' . movdb_format_guests($item['guests']) . '</span>';
		}
		
		if ($item['rating_val'] > 0) {
			$content[] = '<a href="' . admin_url('admin.php?page=movdb_movies_page&action=edit&movie=' . $item['movie']) . '">' . __('rate movie', 'movdb') . '</a>';
		}
		
		if ($item['has_source'] == 1) {
			$content[] = '<a href="' . admin_url('admin.php?page=movdb_sources_page&action=edit&source=' . $item['source']) . '">' . __('rate source', 'movdb') . '</a>';
		}
		
		return '<p>' . implode('; ', $content) . '</p>';
	}
	
	function prepare_items ()
	{
		global $wpdb;
		
		$query = 'SELECT mov.id as movie, src.id as source, mov.title, mov.year, mov.rating, scr.guests, ' .
		         'if (not isnull(src.id), 1, 0) as has_source, ' .
		         'if (mov.rating = 0, 1, 0) as rating_val, ' .
		         'if (isnull(src.audio_quality), 1, 0) as audio_quality_val, ' .
		         'if (isnull(src.video_quality), 1, 0) as video_quality_val, ' .
		         'if (isnull(src.audience_capable), 1, 0) as audience_capable_val, ' .
		         'if (isnull(src.id), 0, 1) as has_source ' .
		         'FROM ' . $wpdb->prefix . 'movdb_screenings scr ' .
		         'JOIN ' . $wpdb->prefix . 'movdb_movies mov ON mov.id = scr.movie ' .
		         'LEFT OUTER JOIN ' . $wpdb->prefix . 'movdb_sources src ON src.id = scr.source ' .
		         'WHERE mov.rating = 0 or not isnull(src.id) ' .
		         'ORDER BY ((rating_val * 5) + audio_quality_val + video_quality_val + (audience_capable_val * 2)) DESC ' .
		         'LIMIT 10';
		//var_dump($query);
		
		$results = $wpdb->get_results($query, ARRAY_A);
		
		$items = array();
		
		foreach ($results as $result)
		{
			if ($result['rating_val'] + $result['audio_quality_val'] + $result['video_quality_val'] + $result['audience_capable_val'] == 0) {
				continue;
			}
			
			$items[] = $result;
		}
		
		$this->data = $items;
	}
}

?>