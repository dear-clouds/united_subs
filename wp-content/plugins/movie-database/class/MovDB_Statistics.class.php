<?php

class MovDB_Statistics
{
	var $movies_data = array();
	var $screenings_data = array();
	var $sources_data = array();
	
	function prepare_items ()
	{
		$this->prepare_movies();
		$this->prepare_screenings();
		$this->prepare_sources();
	}
	
	function prepare_movies ()
	{
		global $wpdb;
		
		$query = 'SELECT * FROM ' . $wpdb->prefix . 'movdb_movies';
		
		$results = $wpdb->get_results($query, ARRAY_A);
		
		$movies_total = count($results);
		
		$oldest_movie = date('Y');
		
		$counter_parts = 0;
		$counter_parts_1 = 0;
		$counter_parts_2 = 0;
		$counter_parts_3 = 0;
		
		foreach ($results as $result)
		{
			if (!empty($result['year']) && $result['year'] < $oldest_movie) {
				$oldest_movie = $result['year'];
			}
			
			if ($result['part'] >= 1) $counter_parts++;
			if ($result['part'] == 1) $counter_parts_1++;
			if ($result['part'] == 2) $counter_parts_2++;
			if ($result['part'] == 3) $counter_parts_3++;
		}
		
		$this->movies_data = array(
			__('Movies total', 'movdb') => $movies_total,
			__('Eldest movie', 'movdb') => sprintf(__('from %1$s', 'movdb'), $oldest_movie),
			__('Series', 'movdb') => sprintf(__('%1$s total (%2$s first, %3$s second and %4$s third parts)', 'movdb'), $counter_parts, $counter_parts_1, $counter_parts_2, $counter_parts_3)
		);
	}
	
	function prepare_screenings ()
	{
		global $wpdb;
		
		$query = 'SELECT * FROM ' . $wpdb->prefix . 'movdb_screenings ORDER BY date asc, id asc';
		
		$results = $wpdb->get_results($query, ARRAY_A);
		
		$screenings_total = count($results);
		$first_date = strtotime($results[0]['date']);
		$last_date = strtotime($results[$screenings_total - 1]['date']);
		$timespan = floor(($last_date - $first_date) / 60 / 60 / 24) + 1;
		$screenings_per_day = round($screenings_total / $timespan, 2);
		
		$counter_screenings_without_guests = 0;
		$counter_screenings_with_guests = 0;
		$total_guests = array();
		
		foreach ($results as $result)
		{
			$guests = movdb_guest_array($result['guests']);
			
			if (count($guests) == 0) {
				$counter_screenings_without_guests++;
			}
			else
			{
				foreach ($guests as $guest)
				{
					if (!isset($total_guests[$guest])) {
						$total_guests[$guest] = 0;
					}
					
					$total_guests[$guest]++;
				}
				
				$counter_screenings_with_guests++;
			}
		}
		
		arsort($total_guests);
		$total_guests_result = array();
		
		foreach ($total_guests as $name => $count) {
			$total_guests_result[] = $name . ' (' . $count . ')';
		}
		
		$this->screenings_data = array(
			__('Screenings total', 'movdb') => $screenings_total,
			__('Screenings per day', 'movdb') => $screenings_per_day,
			__('Time per day', 'movdb') => sprintf(__('%1$s minutes (at %2$s minutes per movie)', 'movdb'), ceil(130 * $screenings_per_day), 130),
			__('Screenings alone', 'movdb') => $counter_screenings_without_guests,
			__('with guests', 'movdb') => $counter_screenings_with_guests,
			__('Guests total', 'movdb') => '<abbr title="' . htmlspecialchars(implode(', ', $total_guests_result)) . '">' . array_sum(array_values($total_guests)) . '</abbr>',
			__('various guests', 'movdb') => '<abbr title="' . htmlspecialchars(implode(', ', $total_guests_result)) . '">' . count($total_guests_result) . '</abbr>',
			__('most frequent quest', 'movdb') => count($total_guests_result) > 0 ? $total_guests_result[0] : '–'
		);
	}
	
	function prepare_sources ()
	{
		global $wpdb;
		
		$query = 'SELECT * FROM ' . $wpdb->prefix . 'movdb_sources';
		
		$results = $wpdb->get_results($query, ARRAY_A);
		
		$sources_total = count($results);
		
		$counter_type_bluray = 0;
		$counter_type_dvd = 0;
		$counter_type_file = 0;
		
		$counter_video_3d = 0;
		$counter_audience_capable = 0;
		
		foreach ($results as $result)
		{
			if ($result['type'] == 'blu-ray') $counter_type_bluray++;
			if ($result['type'] == 'dvd') $counter_type_dvd++;
			if ($result['type'] == 'file') $counter_type_file++;
			
			if ($result['video_3d'] == 'true') $counter_video_3d++;
			if ($result['audience_capable'] == 'true') $counter_audience_capable++;
		}
		
		$this->sources_data = array(
			__('Sources', 'movdb') => sprintf(__('%1$s total (%2$s Blu-rays, %3$s DVDs and %4$s as file)', 'movdb'), $sources_total, $counter_type_bluray, $counter_type_dvd, $counter_type_file),
			__('3D sources', 'movdb') => $counter_video_3d,
			__('appropriate for audience', 'movdb') => $counter_audience_capable,
		);
	}
	
	function display ()
	{
		?>
		<h3 class="movdb-sub-headline"><?php _e('Movies', 'movdb'); ?></h3>
		<ul>
		<?php
		
		foreach ($this->movies_data as $key => $value)
		{
			echo '<li>';
			echo '<span class="label">' . $key . '</span>';
			echo '<span class="value">' . $value . '</span>';
			echo '</li>';
		}
		
		?>
		</ul>
		<h3 class="movdb-sub-headline"><?php _e('Screenings', 'movdb'); ?></h3>
		<ul>
		<?php
		
		foreach ($this->screenings_data as $key => $value)
		{
			echo '<li>';
			echo '<span class="label">' . $key . '</span>';
			echo '<span class="value">' . $value . '</span>';
			echo '</li>';
		}
		
		?>
		</ul>
		<h3 class="movdb-sub-headline"><?php _e('Sources', 'movdb'); ?></h3>
		<ul>
		<?php
		
		foreach ($this->sources_data as $key => $value)
		{
			echo '<li>';
			echo '<span class="label">' . $key . '</span>';
			echo '<span class="value">' . $value . '</span>';
			echo '</li>';
		}
		
		?>
		</ul>
		<?php
	}
}

?>