<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Kleo_Recent_Posts_widget extends WP_Widget {

	/**
	 * Widget setup
	 */
	function __construct() {
	
		$widget_ops = array( 
			'description' => __( 'Recent posts with thumbnails widget.', 'kleo_framework' ) 
		);
		parent::__construct( 'kleo_recent_posts', __('(Kleo) Recent posts','kleo_framework'), $widget_ops );
	}

	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$limit = $instance['limit'];
		$length = (int)( $instance['length'] );
		$thumb = isset($instance['thumb']) ? $instance['thumb'] : '';
		$excerpt = isset($instance['excerpt']) ? $instance['excerpt'] : '' ;
		$cat = $instance['cat'];
		$post_type = $instance['post_type'];

		global $post;

		$args = array(
            'numberposts' => $limit,
            'cat' => $cat,
            'post_type' => $post_type,
			'suppress_filters' => false
		);

		$kleo_recent_posts = get_posts( $args );

		if ( ! empty( $kleo_recent_posts ) ) {

			echo $before_widget;

			if ( ! empty( $title ) ) {
				echo $before_title . $title . $after_title;
			}

			?>

			<div>

				<ul class='news-widget-wrap'>

					<?php foreach ( $kleo_recent_posts as $post ) : setup_postdata( $post ); ?>
						<li class="news-content">
							<a class="news-link" href="<?php the_permalink(); ?>">
								<?php if ( $thumb == 1 ) : /* Display author image */ ?>

									<span class="news-thumb"><?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?></span>
									<span class="news-headline"><?php the_title(); ?>
										<small class="news-time"><?php echo get_the_date(); ?></small></span>

									<?php if ( $excerpt == 1 ) { ?>
										<span class="news-excerpt"><?php echo kleo_excerpt( $length, false ); ?></span>
									<?php } ?>

								<?php elseif ( $thumb == 2 ) : /* Display post thumbnail */ ?>
									<?php
									$img_url = kleo_get_post_thumbnail_url();
									if ( $img_url != '' ) {
										$image = aq_resize( $img_url, 44, 44, true, true, true );
										if ( ! $image ) {
											$image = $img_url;
										}
										$html_img = '<img src="' . $image . '" alt="" title="">';
									} else {
										$html_img = '';
									}

									?>
									<span class="news-thumb"><?php echo $html_img; ?></span>
									<span class="news-headline"><?php the_title(); ?>
										<small class="news-time"><?php echo get_the_date(); ?></small></span>

									<?php if ( $excerpt == 1 ) { ?>
										<span class="news-excerpt"><?php echo kleo_excerpt( $length, false ); ?></span>
									<?php } ?>

								<?php else : ?>

									<span><?php the_title(); ?>
										<small class="news-time"><?php echo get_the_date(); ?></small></span>

									<?php if ( $excerpt == 1 ) { ?>
										<span class="news-excerpt"><?php echo kleo_excerpt( $length, false ); ?></span>
									<?php } ?>

								<?php endif; ?>

							</a>

						</li>
					<?php endforeach;
					wp_reset_postdata(); ?>

				</ul>

			</div>

			<?php

			echo $after_widget;

		}
	}

	/**
	 * Update widget
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = esc_attr( $new_instance['title'] );
		$instance['limit'] = $new_instance['limit'];
		$instance['length'] = (int)( $new_instance['length'] );
		$instance['thumb'] = $new_instance['thumb'];
		$instance['excerpt'] = $new_instance['excerpt'];
		$instance['cat'] = $new_instance['cat'];
		$instance['post_type'] = $new_instance['post_type'];

		return $instance;

	}

	/**
	 * Widget setting
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
        $defaults = array(
            'title' => '',
            'limit' => 5,
            'length' => 100,
            'thumb' => true,
            'excerpt' => '',
            'cat' => '',
            'post_type' => '',
            'date' => true,
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = esc_attr( $instance['title'] );
		$limit = $instance['limit'];
		$length = (int)($instance['length']);
		$thumb = $instance['thumb'];
		$excerpt = $instance['excerpt'];
		$cat = $instance['cat'];
		$post_type = $instance['post_type'];

	?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'kleo_framework' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', 'kleo_framework' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'limit' ); ?>" id="<?php echo $this->get_field_id( 'limit' ); ?>">
				<?php for ( $i=1; $i<=20; $i++ ) { ?>
					<option <?php selected( $limit, $i ) ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"><?php _e( 'Display excerpt?', 'kleo_framework' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>">
                <option value="">No</option>
                <option <?php selected( '1', $excerpt ); ?> value="1">Yes</option>
            </select>&nbsp;
        </p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>"><?php _e( 'Excerpt length(characters):', 'kleo_framework' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>" type="text" value="<?php echo $length; ?>" />
		</p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>"><?php _e( 'Display Thumbnail?', 'kleo_framework' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>">
                <option value="">No</option>
                <option <?php selected( '1', $thumb ); ?> value="1">Author Image</option>
                <option <?php selected( '2', $thumb ); ?> value="2">Featured Image</option>
            </select>&nbsp;
        </p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php _e( 'Show from category: ' , 'kleo_framework' ); ?></label>
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name( 'cat' ), 'show_option_all' => __( 'All categories' , 'kleo_framework' ), 'hide_empty' => 1, 'hierarchical' => 1, 'selected' => $cat ) ); ?>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php _e( 'Choose the Post Type: ' , 'kleo_framework' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php foreach ( get_post_types( '', 'objects' ) as $post_type ) { ?>
					<option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( $instance['post_type'], $post_type->name ); ?>><?php echo esc_html( $post_type->labels->singular_name ); ?></option>
				<?php } ?>
			</select>
		</p>

	<?php
	}

}

/**
 * Register widget.
 *
 * @since 1.0
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "Kleo_Recent_Posts_widget" );' ) );