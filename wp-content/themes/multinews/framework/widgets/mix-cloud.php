<?php 

add_action('widgets_init','mom_widget_mixcloud');

function mom_widget_mixcloud() {
	register_widget('mom_widget_mixcloud');
	
	}

class mom_widget_mixcloud extends WP_Widget {
	function mom_widget_mixcloud() {
			
		$widget_ops = array('classname' => 'mix_cloud','description' => __('Mix cloud Widget','framework'));
		parent::__construct('mix_cloud',__('Momizat - Mix Cloud','framework'),$widget_ops);
		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$url = $instance['url'];
		$height = $instance['height'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
<iframe width="100%" height="<?php echo $height; ?>" src="//www.mixcloud.com/widget/iframe/?feed=<?php echo $url; ?>" frameborder="0"></iframe>
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = $new_instance['url'] ;
		$instance['height'] = $new_instance['height'] ;

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('MixCloud','framework'), 
			'height' => 200,
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('URL:','framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>"  class="widefat" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height:','framework'); ?></label>
		<input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>"  class="widefat" />
		</p>


   <?php 
}
	} //end class