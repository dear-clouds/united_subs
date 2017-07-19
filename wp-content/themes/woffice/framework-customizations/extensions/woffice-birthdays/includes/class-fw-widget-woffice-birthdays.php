<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Woffice_Birthdays extends WP_Widget {

	/**
	 * @internal
	 */
	function __construct() {
		$this->birthdays = fw()->extensions->get( 'woffice-birthdays' );
		if ( is_null( $this->birthdays ) ) {
			return;
		}
		
		$widget_ops = array( 'description' => 'Woffice widget to display the birthdays of the member in an elegant way.' );
		parent::__construct( false, __( '(Woffice) Birthdays', 'woffice' ), $widget_ops );
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'before_title'  => str_replace( 'class="', 'class="widget_birthdays ', $args['before_title']),
			'after_title'   => $args['after_title'],
		);

		echo fw_render_view($this->birthdays->locate_view_path( 'view' ), $data );
	}

	function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( (array) $new_instance, $old_instance );
		
		return $new_instance;
	}
}

function fw_ext_woffice_birthdays_register_widget() {
	register_widget( 'Widget_Woffice_Birthdays' );
}
add_action( 'widgets_init', 'fw_ext_woffice_birthdays_register_widget' );

