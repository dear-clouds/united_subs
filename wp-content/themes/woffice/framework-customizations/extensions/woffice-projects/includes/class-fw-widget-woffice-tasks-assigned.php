<?php 

class Widget_Woffice_Tasks_Assigned extends WP_Widget {

	/**
	 * @internal
	 */
	function __construct() {
		$this->projects = fw()->extensions->get( 'woffice-projects' );
		if ( is_null( $this->projects ) ) {
			return;
		}
		
		$widget_ops = array( 'description' => 'Woffice widget to display the user tasks.' );
		parent::__construct( false, __( '(Woffice) User tasks', 'woffice' ), $widget_ops );
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
	
	
		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'before_title'  => str_replace( 'class="', 'class="widget_assigned_tasks ', $args['before_title']),
			'after_title'   => $args['after_title'],
		);

		echo fw_render_view($this->projects->locate_view_path( 'widget-assigned' ), $data );
		
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}

function fw_ext_woffice_projects_assigned_register_widget() {
	register_widget( 'Widget_Woffice_Tasks_Assigned' );
}
add_action( 'widgets_init', 'fw_ext_woffice_projects_assigned_register_widget' );

