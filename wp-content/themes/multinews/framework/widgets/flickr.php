<?php 

add_action('widgets_init','mom_flickr');

function mom_flickr() {
	register_widget('mom_flickr');
	
	}

class mom_flickr extends WP_Widget {
	function mom_flickr() {
			
		$widget_ops = array('classname' => 'flickr','description' => __('Widget display Flickr Photo','framework'));
		parent::__construct('flickr-photo',__('Momizat - Flickr','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
$title = apply_filters('widget_title', $instance['title'] );
	$flickrID = $instance['flickrID'];
	$count = $instance['count'];
	$box = $instance['box'];


		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
	wp_enqueue_script('jflicker');
?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('.flicker-widget-wrap').jflickrfeed({
				limit: <?php echo $count; ?>,
				qstrings: {
					id: '<?php echo $flickrID; ?>'
				},
				itemTemplate: '<div class="flicker-widget-item">'+
								'<a rel="prettyPhoto[gallery1]" href="{{image}}" title="{{title}}">' +
									'<img src="{{image_s}}" alt="{{title}}" />' +
								'</a>' +
							  '</li>'
			<?php if($box == 'on') { ?>}, function(data) {
				$(".flicker-widget-item a").magnificPopup();
			<?php } ?>
			});
		});
	</script>
	<div class="flicker-widget-wrap clearfix"></div>

<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['count'] = $new_instance['count'];
		$instance['box'] = $new_instance['box'];

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Flickr','framework'), 
		'flickrID' => '44695441@N03',
		'count' => '8',
		'box' => 'on',
 			);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'framework') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" />
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of Photos:', 'framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
	</p>
	
	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['box'], 'on' ); ?> id="<?php echo $this->get_field_id( 'box' ); ?>" name="<?php echo $this->get_field_name( 'box' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'box' ); ?>"><?php _e('Open in light box', 'framework'); ?></label>
	</p>
	
        
   <?php 
}
	} //end class