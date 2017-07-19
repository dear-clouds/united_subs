<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Visualizer extends WP_Widget {

	/**
	 * @internal
	 */
	function __construct() {
		$widget_ops = array( 'description' => 'Woffice widget to display a graph from the Visualizer library.' );
		parent::__construct( false, __( '(Woffice) Graph', 'woffice' ), $widget_ops );
	}
	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title     = esc_attr( $instance['title'] );
		$before_widget = str_replace( 'class="', 'class="widget_visualizer ', $before_widget );
		$title         = str_replace( 'class="', 'class="widget_visualizer ',
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
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'woffice' ); ?> </label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat"
			       id="<?php esc_attr( $this->get_field_id( 'title' ) ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('graph') ); ?>"><?php _e('Graph:','woffice') ?></label>
			<?php
			
			// GET VISUALIZER POSTS
			$widget_visualizer_query = new WP_Query('post_type=visualizer&showposts=-1');
			
			if ( $widget_visualizer_query->have_posts() ) : ?>
					<select class="widefat" name="<?php echo esc_attr( $this->get_field_name('graph') ); ?>" id="<?php echo esc_attr( $this->get_field_id('graph') ); ?>">
					<?php while($widget_visualizer_query->have_posts()) : $widget_visualizer_query->the_post(); ?>
						<option value="<?php the_id(); ?>"<?php selected(get_the_id(), $instance['graph']); ?>><?php the_ID(); ?></option>
					<?php endwhile;
			else : ?>
				<select class="widefat" disabled>
				<option disabled="disabled"><?php _e("No Graph Found","woffice"); ?></option> 
			<?php endif;
			wp_reset_postdata();
			?> </select>
		</p>
		 <?php
	}
}
