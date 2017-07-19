<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Woffice_UsersMap extends WP_Widget {

	/**
	 * @internal
	 */
	function __construct() {
		$this->map = fw()->extensions->get( 'woffice-map' );
		if ( is_null( $this->map ) ) {
			return;
		}
		
		$widget_ops = array( 'description' => 'Woffice widget to display the users map (Options are in the extension\'s settings).' );
		parent::__construct( false, __( '(Woffice) Users Map', 'woffice' ), $widget_ops );
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'before_title'  => str_replace( 'class="', 'class="widget_users_map ', $args['before_title']),
			'after_title'   => $args['after_title'],
			'title'         => str_replace( 'class="', 'class="widget_users_map ',
				 $args['before_title'] ) . esc_html( $instance['title'] ) . $args['after_title'],
		);

		echo fw_render_view($this->map->locate_view_path( 'widget' ), $data );
		
		function woffice_members_map_js_widget(){
			echo fw()->extensions->get( 'woffice-map' )->woffice_users_map_js("widget");
		}
		add_action('wp_footer', 'woffice_members_map_js_widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( (array) $new_instance, $old_instance );
		
		return $new_instance;
	}
	
	function form( $instance ) {
		$title = __( 'Users Map', 'woffice' );
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'woffice' ); ?> </label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $title ); ?>" class="widefat"
			       id="<?php esc_attr( $this->get_field_id( 'title' ) ); ?>"/>
		</p>
	<?php
	}
}

function fw_ext_woffice_map_register_widget() {
	register_widget( 'Widget_Woffice_UsersMap' );
}
add_action( 'widgets_init', 'fw_ext_woffice_map_register_widget' );

