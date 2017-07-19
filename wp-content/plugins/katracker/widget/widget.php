<?php

// Recent Torrents Widget Class ////////////////////////////////////////////////////////////////////////////////////

/**
 * Katracker Widget Class
 *
 * Adds widget of recent torrents to wordpress
 */
class Katracker_Widget extends WP_Widget {

	/**
	* Register widget with WordPress.
	*/
	function __construct() {
		parent::__construct(
			'katracker_widget', // Base ID
			__( 'Katracker', 'katracker' ), // Name
			array( 'description' => __( 'Katracker Torrents Widget', 'katracker' ), ) // Args
		);
	}

	/**
	* Front-end display of widget.
	*
	* @see WP_Widget::widget()
	*
	* @param array $args	Widget arguments.
	* @param array $instance Saved values from database.
	*/
	public function widget( $args, $instance ) {
		echo preg_replace( '/widget\s/', ' widget widget_recent_entries ', $args['before_widget'] );
		$template_part = locate_template( KATRACKER_PRE . '-widget.php' );
		if ( empty( $template_part ) ) {
			$template_part = plugin_dir_path( __FILE__ ) . KATRACKER_PRE . '-widget.php';
		}

		// Load Style
		wp_enqueue_style( 'katracker-widget-style' );
		require_once $template_part;

		echo $args['after_widget'];
	}

	/**
	* Back-end widget form.
	*
	* @see WP_Widget::form()
	*
	* @param array $instance Previously saved values from database.
	*/
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$torrents_id = !empty( $instance['torrents_id'] ) ? $instance['torrents_id'] : '';
		$numtorrents = !empty( $instance['numtorrents'] ) ? $instance['numtorrents'] : 5;
		$show_date =   isset( $instance['show_date'] )    ? $instance['show_date']   : 0;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>

		<p><label for="<?php echo $this->get_field_id( 'numtorrents' ); ?>"><?php _e( 'Number of Torrents' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'numtorrents' ); ?>" name="<?php echo $this->get_field_name( 'numtorrents' ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $numtorrents ); ?>" size="3"></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
		<?php 
	}

	/**
	* Sanitize widget form values as they are saved.
	*
	* @see WP_Widget::update()
	*
	* @param array $new_instance Values just sent to be saved.
	* @param array $old_instance Previously saved values from database.
	*
	* @return array Updated safe values to be saved.
	*/
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ?
		                           strip_tags( $new_instance['title'] ) : '';
		$instance['numtorrents'] = isset( $new_instance['numtorrents'] ) ?
		                           $new_instance['numtorrents'] : 5;
		$instance['show_date']   = isset( $new_instance['show_date'] ) ?
		                           $new_instance['show_date'] : 0;

		return $instance;
	}

} // class Katracker_Widget

// Register style
add_action( 'wp_enqueue_scripts', function () {
	// Check if the user have created a stylesheet in the theme dir, if not register the default style
	$template_part = locate_template( array( KATRACKER_PRE . '-widget.css' ) );
	if ( empty( $template_part ) ) {
		$template_part = plugins_url( KATRACKER_PRE . '-widget.css', __FILE__ );
	} else {
		$template_part = get_template_directory_uri() . '/' . KATRACKER_PRE . '-widget.css';
	}
	wp_register_style( 'katracker-widget-style', $template_part );
} );


add_action( 'widgets_init', function(){
	register_widget( KATRACKER_PREFIX . 'Widget' );
} );

?>
