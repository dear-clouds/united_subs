<?php 

add_action('widgets_init','weather_widget');

function weather_widget() {
	register_widget('weather_widget');
	
	}

class weather_widget extends WP_Widget {
	function weather_widget() {
			
		$widget_ops = array('classname' => 'weather-box','description' => __('Weather Widget','framework'));

		parent::__construct('weather-box',__('Momizat - Weather widget','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$city = $instance['city'];
		$units = $instance['units'];
		$date_format = $instance['dateformat'];
		$lang = isset( $instance['lang'] ) ? esc_attr( $instance['lang'] ) : '';
		$display = isset( $instance['display'] ) ? esc_attr( $instance['display'] ) : '';
		$days = isset( $instance['days'] ) ? esc_attr( $instance['days'] ) : '';

$output = get_transient($this->id);
if (isset($_COOKIE['lon']) && $_COOKIE['lon'] != '') {$output = false;}
if ($output == false) { 
    ob_start();

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
              <?php momizat_weather($city, $units, $date_format, $lang, $display, $days); ?>      

<?php 
		/* After widget (defined by themes). */
		echo $after_widget;

	$output = ob_get_contents();
    ob_end_clean();
    set_transient($this->id, $output, 60*60*24);
}

    echo $output;  

}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['city'] = $new_instance['city'];
		$instance['units'] = $new_instance['units'];
		$instance['dateformat'] = $new_instance['dateformat'];
		$instance['lang'] = $new_instance['lang'];
		$instance['display'] = $new_instance['display'];
		$instance['days'] = $new_instance['days'];
		delete_transient('mom_weather_data_'.$instance['city']);
		$this->invalidate_widget_cache();

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __('Weather','framework'),
			'city' => 'Sydney',
			'units' => 'metric',
			'dateformat' => 'm/d/Y',
			'lang' => 'en',
			'display' => '',
			'days' => 6,
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

    	<p>
		<label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e('City Name:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" value="<?php echo $instance['city']; ?>"  class="widefat" />
	</p>
        
    	<p>
		<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('Custom display title:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" value="<?php echo $instance['display']; ?>"  class="widefat" />
	</p>

        <p>
		<label for="<?php echo $this->get_field_id( 'units' ); ?>"><?php _e('Units', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'units' ); ?>" name="<?php echo $this->get_field_name( 'units' ); ?>" class="widefat">
		<option value="metric" <?php if ( 'metric' == $instance['units'] ) echo 'selected="selected"'; ?>>Metric</option>
		<option value="imperial" <?php if ( 'imperial' == $instance['units'] ) echo 'selected="selected"'; ?>>Imperial</option>
		</select>
		</p>

    	<p>
		<label for="<?php echo $this->get_field_id( 'dateformat' ); ?>"><?php _e('Date Format:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'dateformat' ); ?>" name="<?php echo $this->get_field_name( 'dateformat' ); ?>" value="<?php echo $instance['dateformat']; ?>"  class="widefat" />
	</p>

        <p>
		<label for="<?php echo $this->get_field_id( 'lang' ); ?>"><?php _e('Language', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'lang' ); ?>" name="<?php echo $this->get_field_name( 'lang' ); ?>" class="widefat">
			<option value="en" <?php selected($instance['lang'], 'en'); ?>>English</option>
			<option value="ar" <?php selected($instance['lang'], 'ar'); ?>>Arabic</option>
			<option value="fr" <?php selected($instance['lang'], 'fr'); ?>>French</option>
			<option value="ru" <?php selected($instance['lang'], 'ru'); ?>>Russian</option>
			<option value="it" <?php selected($instance['lang'], 'it'); ?>>Italian</option>
			<option value="sp" <?php selected($instance['lang'], 'sp'); ?>>Spanish</option>
			<option value="ua" <?php selected($instance['lang'], 'ua'); ?>>Ukrainian</option>
			<option value="de" <?php selected($instance['lang'], 'de'); ?>>German</option>
			<option value="pt" <?php selected($instance['lang'], 'pt'); ?>>Portuguese</option>
			<option value="ro" <?php selected($instance['lang'], 'ro'); ?>>Romanian</option>
			<option value="pl" <?php selected($instance['lang'], 'pl'); ?>>Polish</option>
			<option value="fi" <?php selected($instance['lang'], 'fi'); ?>>Finnish</option>
			<option value="nl" <?php selected($instance['lang'], 'nl'); ?>>Dutch</option>
			<option value="bg" <?php selected($instance['lang'], 'bg'); ?>>Bulgarian</option>
			<option value="se" <?php selected($instance['lang'], 'se'); ?>>Swedish</option>
			<option value="zh_tw" <?php selected($instance['lang'], 'zh_tw'); ?>>Chinese Traditional</option>
			<option value="zh_cn" <?php selected($instance['lang'], 'zh_cn'); ?>>Chinese Simplified</option>
			<option value="tr" <?php selected($instance['lang'], 'tr'); ?>>Turkish</option>
			<option value="cz" <?php selected($instance['lang'], 'cz'); ?>>Czech</option>
			<option value="gl" <?php selected($instance['lang'], 'gl'); ?>>Galician</option>
			<option value="vi" <?php selected($instance['lang'], 'vi'); ?>>Vietnamese</option>
			<option value="mk" <?php selected($instance['lang'], 'mk'); ?>>Macedonian</option>
			<option value="sk" <?php selected($instance['lang'], 'sk'); ?>>Slovak</option>
			<option value="hr" <?php selected($instance['lang'], 'hr'); ?>>Croatian</option>
			<option value="ca" <?php selected($instance['lang'], 'ca'); ?>>Catalan</option>
			<option value="hu" <?php selected($instance['lang'], 'hu'); ?>>Hungarian</option>
		</select>
	</p>
        <p>
		<label for="<?php echo $this->get_field_id( 'days' ); ?>"><?php _e('Number of days (max is 14)', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'days' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>" value="<?php echo $instance['days']; ?>"  class="widefat" />
	</p>
	
   <?php 
}
	public function invalidate_widget_cache()
	{
		delete_transient( $this->id );
	}
	} //end class