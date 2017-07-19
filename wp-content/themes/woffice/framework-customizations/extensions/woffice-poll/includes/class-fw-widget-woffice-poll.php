<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Widget_Woffice_Poll extends WP_Widget {
	/**
	 * @var FW_Extension_Woffice_Poll
	 */

	function __construct() {
		$this->poll = fw()->extensions->get( 'woffice-poll' );
		if ( is_null( $this->poll ) ) {
			return;
		}
		
		$widget_ops = array( 'description' => __( 'Get the poll from the Unyson Extensions', 'woffice' ) );
		parent::__construct( false, __( '(Woffice) Poll', 'woffice' ), $widget_ops );
	}

	function widget( $args, $instance ) {

		$data = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'before_title'  => str_replace( 'class="', 'class="widget_poll ', $args['before_title']),
			'after_title'   => $args['after_title'],
			'title'         => str_replace( 'class="', 'class="widget_poll ',
				 $args['before_title'] ) . esc_html( $instance['title'] ) . $args['after_title'],
			'name'      	=> $this->poll->woffice_get_poll_name(),
			'type'	   		=> $this->poll->woffice_get_poll_type(),
			'answers'   	=> $this->poll->woffice_get_poll_answers(),
			'type'          => (isset($instance['type'])) ? $instance['type'] : 'question'
		);

		echo fw_render_view($this->poll->locate_view_path( 'view' ), $data );
		
	}

	function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( (array) $new_instance, $old_instance );

		return $instance;
	}

	function form( $instance ) {
		$title = __( 'Poll', 'woffice' );
		$type = 'question';
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		if ( isset( $instance['type'] ) ) {
			$type = $instance['type'];
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'woffice' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $title ); ?>" class="widefat"
			       id="<?php esc_attr( $this->get_field_id( 'title' ) ); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tupe'); ?>"><?php _e( 'Type', 'woffice' ); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="text">
				<option value='answers'<?php echo ($type=='answers')?'selected':''; ?>><?php _e( 'Answers', 'woffice' ); ?></option>
				<option value='question'<?php echo ($type=='question')?'selected':''; ?>><?php _e( 'Question', 'woffice' ); ?></option> 
			</select>   
		</p>
	<?php
	}
}
function fw_ext_woffice_poll_register_widget() {
	register_widget( 'FW_Widget_Woffice_Poll' );
}
add_action( 'widgets_init', 'fw_ext_woffice_poll_register_widget' );
