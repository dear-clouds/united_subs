<?php 

add_action('widgets_init','mom_video_widgets');

function mom_video_widgets() {
	register_widget('mom_video_widgets');
	
	}

class mom_video_widgets extends WP_Widget {
	function mom_video_widgets() {
			
		$widget_ops = array('classname' => 'momiazat-videos','description' => __('Widget display video support Youtube, vimeo, dailymotion','framework'));
/*		$control_ops = array( 'twitter name' => 'momizat', 'count' => 3, 'avatar_size' => '32' );
*/		
		parent::__construct('momizar-videos',__('Momizat - Videos','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$type = $instance['type'];
		$id = $instance['id'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
	<div class="video-widget">
	<?php if($type == 'Youtube') { ?>
		<iframe width="100%" height="227" src="http://www.youtube.com/embed/<?php echo $id; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
	<?php } elseif($type == 'Vimeo') { ?>
		<iframe src="http://player.vimeo.com/video/<?php echo $id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ba0d16" width="100%" height="227" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	<?php } elseif($type == 'Dialymotion') { ?>
		<iframe frameborder="0" width="100%	" height="227" src="http://www.dailymotion.com/embed/video/<?php echo $id ?>?logo=0"></iframe>
	<?php } ?>
	</div>
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = $new_instance['type'];
		$instance['id'] = $new_instance['id'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Video','framework'), 
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
	if (isset($instance['type'])) { $typeS = $instance['type'];} else {$typeS = ''; }
	if (isset($instance['id'])) { $ids = $instance['id'];} else {$ids = ''; }
	
		?>
	
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

	<p>
<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('type', 'framework') ?></label>
<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
<option <?php if ( 'Youtube' == $typeS ) echo 'selected="selected"'; ?>><?php _e('Youtube', 'framework'); ?></option>
<option <?php if ( 'Vimeo' == $typeS ) echo 'selected="selected"'; ?>><?php _e('Vimeo', 'framework'); ?></option>
<option <?php if ( 'Dialymotion' == $typeS ) echo 'selected="selected"'; ?>><?php _e('Dialymotion', 'framework'); ?></option>
</select>
	</p>

		<p>
	<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e('Video ID:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo $ids; ?>" class="widefat" />
		</p>

        
   <?php 
}
	} //end class