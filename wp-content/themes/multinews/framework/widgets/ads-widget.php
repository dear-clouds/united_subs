<?php 

add_action('widgets_init','mom_ads_widget');

function mom_ads_widget() {
	register_widget('mom_ads_widget');
	
	}

class mom_ads_widget extends WP_Widget {
	function mom_ads_widget() {
			
		$widget_ops = array('classname' => 'momizat-ads clearfix','description' => __('Widget display any type of ads','framework'));
		parent::__construct('momizatAds',__('Momizat - Ads','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$ad = $instance['ad'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
		echo $before_title . $title . $after_title;
		echo do_shortcode('[ad id="'.$ad.'"]');
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['ad'] = $new_instance['ad'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Advertising','framework'), 
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
	
	$the_ad = isset($instance['ad']) ? $instance['ad'] : '';
	//get the ads
	$ads_obj = get_posts('post_type=ads&numberposts=-1');
		?>
	
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

	<p>
<label for="<?php echo $this->get_field_id( 'ad' ); ?>"><?php _e('type', 'framework') ?></label>
<select id="<?php echo $this->get_field_id( 'ad' ); ?>" name="<?php echo $this->get_field_name( 'ad' ); ?>" class="widefat">
	<?php
		foreach ($ads_obj as $ad) { 
	    echo '<option value="'.$ad->ID.'"'.selected($the_ad, $ad->ID).'>'.$ad->post_title.'</option>';
	    }

	?>
</select>
	</p>
        
   <?php 
}
	} //end class