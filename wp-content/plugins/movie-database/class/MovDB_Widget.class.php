<?php

class MovDB_Widget extends WP_Widget
{
	var $wtypes;
	
	function __construct ()
	{
		parent::__construct(false, __('Movie Database', 'movdb'));
		
		$this->wtypes = array (
			'latest_screenings' => __('Latest screenings', 'movdb'),
			'latest_sources' => __('Newest sources', 'movdb')
		);
	}
	
	function widget ($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		
		if (empty($instance['wtype']) || !($wtype = $instance['wtype'])) {
			$availableKeys = array_keys($this->wtypes);
			$wtype = $availableKeys[0];
		}
		
		if (!in_array($wtype, array_keys($this->wtypes))) {
			$availableKeys = array_keys($this->wtypes);
			$wtype = $availableKeys[0];
		}
		
		$title = apply_filters('widget_title', empty($instance['title']) ? $this->wtypes[$wtype] : $instance['title'], $instance, $this->id_base);
		
		echo $before_widget;
		
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		
		if (method_exists($this, 'content_' . $wtype)) {
			call_user_func_array(array($this, 'content_' . $wtype), array($instance));
		}
		
		echo $after_widget;
	}
	
	function update ($new_instance, $old_instance)
	{
		return $new_instance;
	}
	
	function form ($instance)
	{
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$wtype = isset($instance['wtype']) ? esc_attr($instance['wtype']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 1;
		$showfiletype = (isset($instance['showfiletype']) && $instance['showfiletype'] == '1');
		
		if ($number < 1) $number = 1;
		if ($number > 5) $number = 5;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('wtype'); ?>"><?php _e('List:', 'movdb'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('wtype'); ?>" name="<?php echo $this->get_field_name('wtype'); ?>">
				<?php
				
				foreach ($this->wtypes as $key => $value) {
					echo '<option value="' . $key . '"' . ($wtype == $key ? ' selected="selected"' : '') . '>' . $value . '</option>';
				}
				
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Movie count:', 'movdb'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" min="1" max="5" value="<?php echo $number; ?>" size="3" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('showfiletype'); ?>" class="movdb-file-type-checkbox" name="<?php echo $this->get_field_name('showfiletype'); ?>" type="checkbox" value="1" <?php if ($showfiletype) echo 'checked="checked"' ?> />
			<label for="<?php echo $this->get_field_id('showfiletype'); ?>"><?php _e('Show sources of type <em>file</em>', 'movdb'); ?></label>
			<span id="movdb_file_warning">
				<?php _e('<strong>Attention!</strong> The possession of movies in the form of files is illegal in many cases.<br />Activate this checkbox only if you own legal files, as they are available with many Blu-ray discs.', 'movdb'); ?>
			</span>
		</p>
		<?php
	}
	
	function content_latest_screenings ($instance)
	{
		global $wpdb;
		
		if (empty($instance['number']) || !($number = absint($instance['number']))) {
			$number = 1;
		}
		
		$showfiletype = (isset($instance['showfiletype']) && $instance['showfiletype'] == '1');
		
		$query = 'SELECT `scr`.`id`, `scr`.`date`, `mov`.`title`, `mov`.`year`, `mov`.`rating`, `scr`.`guests` ' .
		         'FROM `' . $wpdb->prefix . 'movdb_screenings` `scr` ' .
		         'LEFT OUTER JOIN `' . $wpdb->prefix . 'movdb_movies` `mov` ON `scr`.`movie` = `mov`.`id` ' .
		         'LEFT OUTER JOIN `' . $wpdb->prefix . 'movdb_sources` `src` ON `scr`.`source` = `src`.`id` ' .
		         'WHERE `scr`.`frontend_visible` = "true" ';
		
		if (!$showfiletype) {
			$query .= 'AND (ISNULL(`src`.`type`) OR `src`.`type` != "file") ';
		}
		
		$query .= 'ORDER BY `date` desc, `id` desc ' .
		          'LIMIT ' . $number;
		//var_dump($query);
		
		$results = $wpdb->get_results($query, ARRAY_A);
		
		$previousDate = '';
		
		foreach ($results as $result)
		{
			$date = strtotime($result['date']);
			
			?>
			<div class="movdb-widget-movie">
				<?php if ($date != $previousDate): ?>
				<p class="date"><time datetime="<?php echo date('Y-m-d', $date); ?>"><?php echo date_i18n(get_option('date_format'), $date); ?></time></p>
				<?php endif; ?>
				<h4>
					<?php echo $result['title']; ?>
					<span class="year">(<?php echo $result['year']; ?>)</span>
				</h4>
				<?php if (count(movdb_guest_array($result['guests'])) > 0): ?>
					<p class="guests"><?php _e('with', 'movdb'); ?> <?php echo movdb_format_guests($result['guests']); ?></p>
				<?php endif; ?>
				<p class="rating"><?php echo movdb_format_rating($result['rating']); ?></p>
			</div>
			<?php
			
			$previousDate = $date;
		}
	}
	
	function content_latest_sources ($instance)
	{
		global $wpdb;
		
		if (empty($instance['number']) || !($number = absint($instance['number']))) {
			$number = 1;
		}
		
		$showfiletype = (isset($instance['showfiletype']) && $instance['showfiletype'] == '1');
		
		$query = 'SELECT `src`.`id`, `src`.`type`, `src`.`video_3d`, `mov`.`title`, `mov`.`year`, `mov`.`rating` ' .
		         'FROM `' . $wpdb->prefix . 'movdb_sources` `src` ' .
		         'LEFT OUTER JOIN `' . $wpdb->prefix . 'movdb_movies` `mov` ON `src`.`movie` = `mov`.`id` ' .
		         'WHERE `src`.`frontend_visible` = "true" ';
		
		if (!$showfiletype) {
			$query .= 'AND `src`.`type` != "file" ';
		}
		
		$query .= 'ORDER BY `id` desc ' .
		          'LIMIT ' . $number;
		//var_dump($query);
		
		$results = $wpdb->get_results($query, ARRAY_A);
		
		foreach ($results as $result)
		{
			?>
			<div class="movdb-widget-movie">
				<p class="type">
					<?php
					echo movdb_format_source_type($result['type']);
					
					if ($result['video_3d'] == 'true') {
						echo ' ';
						_e('3D', 'movdb');
					}
					?>
				</p>
				<h4>
					<?php echo $result['title']; ?>
					<span class="year">(<?php echo $result['year']; ?>)</span>
				</h4>
				<p><?php echo movdb_format_rating($result['rating']); ?></p>
			</div>
			<?php
		}
	}
}

?>