<?php 

add_action('widgets_init','mom_widget_posts_images');

function mom_widget_posts_images() {
	register_widget('mom_widget_posts_images');
	
	}

class mom_widget_posts_images extends WP_Widget {
	function mom_widget_posts_images() {
			
		$widget_ops = array('classname' => 'posts_images','description' => __('Widget display Posts order by : Popular, Random, Recent','framework'));
		parent::__construct('momizat-Posts-Images',__('Momizat - Posts in images','framework'),$widget_ops);
		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = $instance['orderby'];
		$count = $instance['count'];
		$display = isset($instance['display']) ? $instance['display'] : array();
		$cats = isset($instance['cats']) ? $instance['cats'] : array();


$output = get_transient($this->id);
if ($orderby == 'Random') {
	$output = false;
}
if ($output == false) { 
    ob_start();

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		global $unique_posts;
global $do_unique_posts;
?>
<div class="news-pics-widget">
   	<ul class="npwidget clearfix">
		<?php if($orderby == 'Popular') { ?>
			<?php if ($display == 'cats') {
			$catsi = implode(',', $cats);
			?>
		
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
			<?php } else { ?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
			<?php } ?>
		<?php } elseif($orderby == 'Random') { ?>
			<?php if ($display == 'cats') {
			$catsi = implode(',', $cats);
			
			?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'rand', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
			<?php } else { ?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
			<?php } ?>
		<?php } elseif($orderby == 'Recent') { ?>
			<?php if ($display == 'cats') {
			$catsi = implode(',', $cats);
			?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
			<?php } else { ?>
			<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
			<?php } ?>
		<?php } ?>
		<?php update_post_thumbnail_cache( $query ); if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
			if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
		?>			
		<?php if( mom_post_image() != false ) { ?>
			<li class="simptip-position-top simptip-movable half-arrow simptip-multiline" data-tooltip="<?php the_title(); ?>">
				<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php mom_post_image_full('postpicwid-thumb'); ?>
                </a></figure>
			</li>
			<?php } ?>
			<?php endwhile; ?>
			<?php  else:  ?>
			<!-- Else in here -->
			<?php  endif; ?>
			<?php wp_reset_postdata(); ?>
	</ul>
</div>
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
   $output = ob_get_contents();
    ob_end_clean();
    set_transient($this->id, $output, 60*60*24);
}

    echo $output;    
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['display'] = $new_instance['display'];
		$instance['cats'] = $new_instance['cats'];
			$this->invalidate_widget_cache();

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Most Popular','framework'), 
			'count' => 9,
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		if (isset($instance['orderby'])) { $orderbyS = $instance['orderby'];} else {$orderbyS = ''; }
		if (isset($instance['display'])) { $displayS = $instance['display'];} else {$displayS = ''; }
		$cats = isset($instance['cats']) ? $instance['cats'] : array();
		$categories = get_categories('hide_empty=0');
		
		?>
	<script>
		jQuery(document).ready(function($) {
			$('#<?php echo $this->get_field_id( 'display' ); ?>').change( function () {
				if ($(this).val() !== 'latest') {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeIn();
				}
				
			});
				if ($('#<?php echo $this->get_field_id( 'display' ); ?>').val() !== 'latest') {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeIn();
				}
		});
	</script>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('orderby', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat">
		<option <?php if ( 'Popular' == $orderbyS ) echo 'selected="selected"'; ?>>Popular</option>
		<option <?php if ( 'Random' == $orderbyS ) echo 'selected="selected"'; ?>>Random</option>
		<option <?php if ( 'Recent' == $orderbyS ) echo 'selected="selected"'; ?>>Recent</option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('display', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
		<option <?php if ( 'latest' == $displayS ) echo 'selected="selected"'; ?> value="latest"><?php _e('Latest Posts', 'framework'); ?></option>
		<option <?php if ( 'cats' == $displayS ) echo 'selected="selected"'; ?> value="cats"><?php _e('Category/s', 'framework'); ?></option>
		</select>
		</p>

		<p class="hidden">
		<label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e('cats', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>[]" class="widefat" multiple="multiple">
		<?php foreach ($categories as $cat) { ?>
			<option <?php echo in_array($cat->cat_ID, $cats)? 'selected="selected"':'';?> value="<?php echo $cat->cat_ID; ?>"><?php echo $cat->cat_name; ?></option>
		<?php } ?>
		</select>
		</p>


		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number Of Posts:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>

   <?php 
}
	public function invalidate_widget_cache()
	{
		delete_transient( $this->id );
	} 
} //end class