<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Woffice_Funfacts extends WP_Widget {

	/**
	 * @internal
	 */
	function __construct() {
		$this->funfacts = fw()->extensions->get( 'woffice-funfacts' );
		if ( is_null( $this->funfacts ) ) {
			return;
		}
		
		$widget_ops = array( 'description' => 'Woffice widget to display the fun facts set in the Extensions Settings as a slider.' );
		parent::__construct( false, __( '(Woffice) Fun Facts', 'woffice' ), $widget_ops );
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'before_title'  => str_replace( 'class="', 'class="widget_funfacts ', $args['before_title']),
			'after_title'   => $args['after_title'],
			'title'         => str_replace( 'class="', 'class="widget_funfacts ',
				 $args['before_title'] ) . esc_html($instance['title']) . $args['after_title'],
			'funfacts'      => $this->funfacts->woffice_get_funfacts(),
		);

		echo fw_render_view($this->funfacts->locate_view_path( 'view' ), $data );
	}

	function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( (array) $new_instance, $old_instance );
		
		return $new_instance;
	}

	function form( $instance ) {
		$title = __( 'Fun Facts', 'woffice' );
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'woffice' ); ?> </label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $title ); ?>" class="widefat"
			       id="<?php esc_attr( $this->get_field_id( 'title' ) ); ?>"/>
		</p>
	<?php
	}
}

function fw_ext_woffice_funfacts_register_widget() {
	register_widget( 'Widget_Woffice_Funfacts' );
}
add_action( 'widgets_init', 'fw_ext_woffice_funfacts_register_widget' );

