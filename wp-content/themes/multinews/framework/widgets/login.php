<?php 

add_action('widgets_init','mom_widget_login');

function mom_widget_login() {
	register_widget('mom_widget_login');
	
	}

class mom_widget_login extends WP_Widget {
	function mom_widget_login() {
			
		$widget_ops = array('classname' => 'login_widget','description' => __('Login Widget','framework'));
		parent::__construct('login_widget',__('Momizat - Login','framework'),$widget_ops);
		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

			mom_login_form();
			
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Login','framework'), 
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

   <?php 
}
	} //end class