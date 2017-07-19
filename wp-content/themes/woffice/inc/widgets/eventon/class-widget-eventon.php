<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Eventon extends WP_Widget {

	/**
	 * @internal
	 */
	function __construct() {
		$widget_ops = array( 'description' => 'Woffice widget to display the latest events from EventON.' );
		parent::__construct( false, __( '(Woffice) Events', 'woffice' ), $widget_ops );
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title     = esc_attr( $instance['title'] );
		$show     = esc_attr( $instance['show'] );
		$before_widget = str_replace( 'class="', 'class="widget_events ', $before_widget );
		$title         = str_replace( 'class="', 'class="widget_events ',
				$before_title ) . $title . $after_title;

		$filepath = dirname( __FILE__ ) . '/views/widget.php';

		if ( file_exists( $filepath ) ) {
			include( $filepath );
		}
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '',  'show' => '4') );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'woffice' ); ?> </label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat"
			       id="<?php esc_attr( $this->get_field_id( 'title' ) ); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _e( 'Number', 'woffice' ); ?> </label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'show' ) ); ?>"
			       value="<?php echo esc_attr( $instance['show'] ); ?>" class="widefat"
			       id="<?php esc_attr( $this->get_field_id( 'show' ) ); ?>"/>
		</p>
	<?php
	}
}
