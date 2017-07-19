<?php

class MovDB_View
{
	var $data = array();
	
	function get_list_class ()
	{
		return 'movdb-listing';
	}
	
	function get_no_results_message ()
	{
		return __('No results available.', 'movdb');
	}
	
	function get_grouping_column ()
	{
		return null;
	}
	
	function get_group_title ($group_key)
	{
		return $group_key;
	}
	
	function get_item_id ($item)
	{
		return $item['movie'];
	}
	
	function get_item_title ($item)
	{
		return 'get_item_title not specified';
	}
	
	function display ()
	{
		echo '<ul class="' . $this->get_list_class() . '">';
		
		if (count($this->data) == 0) {
			echo '<li class="no-results">' . $this->get_no_results_message() . '</li>';
		}
		else {
			if ($this->get_grouping_column() === null) {
				$this->display_ungrouped($this->data);
			} else {
				$this->display_grouped($this->data);
			}
		}
		
		echo '</ul>';
	}
	
	function display_grouped ($items)
	{
		$grouped_items = array();
		
		foreach ($items as $item)
		{
			$group_key = $item[$this->get_grouping_column()];
			
			if (!isset($grouped_items[$group_key])) {
				$grouped_items[$group_key] = array();
			}
			
			$grouped_items[$group_key][] = $item;
		}
		
		foreach ($grouped_items as $group_key => $group)
		{
			echo '<li class="item-group">';
			echo '<h4>' . $this->get_group_title($group_key) . '</h4>';
			echo '<ul>';
			
			$this->display_ungrouped($group);
			
			echo '</ul>';
			echo '</li>';
		}
	}
	
	function display_ungrouped ($items)
	{
		foreach ($items as $item)
		{
			echo '<li class="item">';
			echo '<h5>';
			echo '<a href="' . admin_url('admin.php?page=movdb_movies_page&action=edit&movie=' . $this->get_item_id($item)) . '">' . $this->get_item_title($item) . '</a>';
			
			if (isset($item['year']) && !empty($item['year'])) {
				echo ' <span class="year">(' . $item['year'] . ')</span>';
			}
			
			echo '</h5>';
			echo $this->get_item_content($item);
			echo '</li>';
		}
	}
}

?>