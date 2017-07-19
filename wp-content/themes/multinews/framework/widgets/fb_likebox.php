<?php 

add_action('widgets_init','fb_likebox_widget');

function fb_likebox_widget() {
	register_widget('fb_likebox_widget');
	
	}

class fb_likebox_widget extends WP_Widget {
	function fb_likebox_widget() {
			
		$widget_ops = array('classname' => 'Like-box','description' => __('Facebook Like Box','framework'));

		parent::__construct('Like-box',__('Momizat - Facebook Likebox','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$width = $instance['width'];
		$height = $instance['height'];
		$faces = $instance['faces'];
		$stream = $instance['stream'];
		$header = $instance['header'];
		$page = $instance['page'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
<div class="facebook-widget">
<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $page ; ?>&amp;width=<?php echo $width ; ?>&amp;height=<?php echo $height; ?>&amp;colorscheme=light&amp;show_faces=<?php if($faces != 'on') {echo 'false';}else{echo 'true';} ?>&amp;show_border=false&amp;stream=<?php if($stream != 'on') {echo 'false';}else{echo 'true';} ?>&amp;header=<?php if($header != 'on') {echo 'false';}else{echo 'true';} ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;" allowTransparency="true"></iframe>
</div>
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['width'] = $new_instance['width'];
		$instance['height'] = $new_instance['height'];
		$instance['faces'] = $new_instance['faces'];
		$instance['stream'] = $new_instance['stream'];
		$instance['header'] = $new_instance['header'];
		$instance['page'] = $new_instance['page'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __('Facebook','framework'),
			'page' => 'http://www.facebook.com/momizat',
			'width' => 335,
			'height' => 258,
			'faces' => 'on',
			'stream' => '',
			'header' => '',
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

    	<p>
		<label for="<?php echo $this->get_field_id( 'page' ); ?>"><?php _e('Facebook Page URL:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>" value="<?php echo $instance['page']; ?>"  class="widefat" />
		</p>
        

    	<p>
		<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Width:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>"  class="widefat" />
		</p>

    	<p>
		<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>"  class="widefat" />
		</p>


		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['faces'], 'on' ); ?> id="<?php echo $this->get_field_id( 'faces' ); ?>" name="<?php echo $this->get_field_name( 'faces' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'faces' ); ?>"><?php _e('Show faces', 'framework'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['stream'], 'on' ); ?> id="<?php echo $this->get_field_id( 'stream' ); ?>" name="<?php echo $this->get_field_name( 'stream' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'stream' ); ?>"><?php _e('Show stream', 'framework'); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['header'], 'on' ); ?> id="<?php echo $this->get_field_id( 'header' ); ?>" name="<?php echo $this->get_field_name( 'header' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'header' ); ?>"><?php _e('Show header', 'framework'); ?></label>
		</p>

	
   <?php 
}
	} //end class