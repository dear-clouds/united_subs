<?php 

add_action('widgets_init','mom_widget_reviews');

function mom_widget_reviews() {
	register_widget('mom_widget_reviews');
	
	}

class mom_widget_reviews extends WP_Widget {
	function mom_widget_reviews() {
			
		$widget_ops = array('classname' => 'review-widget','description' => __('Widget display Posts order by : Top , Random, Recent','framework'));
		parent::__construct('momizatReviews',__('Momizat - Reviews','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = $instance['orderby'];
		$count = $instance['count'];
		$display = $instance['display'];
		$cats = isset($instance['cats']) ? $instance['cats'] : array();
		$tags = isset($instance['tags']) ? $instance['tags']: array();

$output = get_transient($this->id);
if ($output == false) { 
    ob_start();
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
		<ul class="post-list">

		<?php
			if ($orderby == 'top') {
				if ($display == 'cats') {
					$catsi = implode(',', $cats);
					$query = new WP_Query( array ( 'orderby' => 'meta_value_num', 'meta_key' => '_mom_review-final-score','meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'cat' => $catsi, 'no_found_rows' => true, 'cache_results' => false ) );
				} elseif ($display == 'tags') {	
					$query = new WP_Query( array ( 'orderby' => 'meta_value_num', 'meta_key' => '_mom_review-final-score','meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'tag' => $tags, 'no_found_rows' => true, 'cache_results' => false ) );
				} else {
					$query = new WP_Query( array ( 'orderby' => 'meta_value_num', 'meta_key' => '_mom_review-final-score', 'meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'no_found_rows' => true, 'cache_results' => false ) );
				}
			} elseif ($orderby == 'random') {
				if ($display == 'cats') {
					$catsi = implode(',', $cats);
					$query = new WP_Query( array ( 'meta_key' => '_mom_review-final-score', "orderby" => "rand",'meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'cat' => $catsi, 'no_found_rows' => true, 'cache_results' => false ) );
				} elseif ($display == 'tags') {	
					$query = new WP_Query( array ( 'meta_key' => '_mom_review-final-score', "orderby" => "rand",'meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'tag' => $tags, 'no_found_rows' => true, 'cache_results' => false ) );
				} else {
					$query = new WP_Query( array ( 'meta_key' => '_mom_review-final-score', "orderby" => "rand", 'meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'no_found_rows' => true, 'cache_results' => false ) );
				}
			} else {
				if ($display == 'cats') {
					$catsi = implode(',', $cats);
					$query = new WP_Query( array ( 'meta_key' => '_mom_review-final-score', 'meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'cat' => $catsi, 'no_found_rows' => true, 'cache_results' => false ) );
				} elseif ($display == 'tags') {	
					$query = new WP_Query( array ( 'meta_key' => '_mom_review-final-score', 'meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'tag' => $tags, 'no_found_rows' => true, 'cache_results' => false ) );
				} else {
					$query = new WP_Query( array ( 'meta_key' => '_mom_review-final-score', 'meta_value' => 0, 'meta_compare' => '!=', "ignore_sticky_posts" => 1, 'showposts' => $count, 'no_found_rows' => true, 'cache_results' => false ));
				}
			}
			update_post_thumbnail_cache( $query );
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					$is_review = get_post_meta(get_the_ID(),'mom_review_post',true);
					$criterias = get_post_meta(get_the_ID(),'_mom_review-criterias',false);
				$all_scores = 0;
				$the_score = 0;
				$score = 0;
				if ($criterias != false) {
				foreach($criterias[0] as $criteria) {
					$all_scores += 100;
					$score += $criteria['cr_score'];
				}
				$the_score = $score/$all_scores*100;
				$score = round($the_score);
				}
				if ($is_review == true) {
		?>
			<li>
				<?php if( mom_post_image() != false ) { ?>
				<figure class="post-thumbnail"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark">
				<?php mom_post_image_full('postlist-thumb'); ?>
				</a></figure>
				<?php } ?>
				<h2 itemprop="name"><a itemprop="url" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="entry-review">
                    <?php
				$stars_score = number_format(($score/20), 1, '.', ',');
    				$summary = get_post_meta(get_the_ID(),'_mom_review_summary',true);
			?>
				<span class="rev-title"><?php _e('Review :', 'framework'); ?></span>
				<div class="star-rating mom_review_score"><span style="width:<?php echo $score; ?>%;"></span></div>
				<small>(<?php echo $stars_score; ?>)</small>
                </div>
			</li>
			<?php } ?>
			<?php endwhile; ?>
			<?php  else:  ?>
			<!-- Else in here -->
			<?php  endif; ?>
			<?php wp_reset_query(); ?>
			
		</ul>

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
		$instance['tags'] = $new_instance['tags'];
			$this->invalidate_widget_cache();

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Top Reviews','framework'), 
			'count' => 5
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$orderby = isset($instance['orderby']) ? $instance['orderby'] : '';
		$display = isset($instance['display']) ? $instance['display'] : '';
		$tags = isset($instance['tags']) ? $instance['tags'] : '';
		$cats = isset($instance['cats']) ? $instance['cats'] : array();
		$categories = get_categories('hide_empty=0');
	
		?>
	<script>
		jQuery(document).ready(function($) {
			$('#<?php echo $this->get_field_id( 'display' ); ?>').change( function () {
				if ($(this).val() === 'cats') {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeIn();
					$('#<?php echo $this->get_field_id('tags'); ?>').parent().fadeOut();
				} else if ($(this).val() === 'tags') {
					$('#<?php echo $this->get_field_id('tags'); ?>').parent().fadeIn();
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeOut();
				} else {
					$('#<?php echo $this->get_field_id('tags'); ?>').parent().fadeOut();
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeOut();
				}
			});
				if ($('#<?php echo $this->get_field_id( 'display' ); ?>').val() === 'cats') {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().show();
					$('#<?php echo $this->get_field_id('tags'); ?>').parent().hide();
				} else if ($('#<?php echo $this->get_field_id( 'display' ); ?>').val() === 'tags') {
					$('#<?php echo $this->get_field_id('tags'); ?>').parent().show();
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().hide();
				} else {
					$('#<?php echo $this->get_field_id('tags'); ?>').parent().hide();
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().hide();
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
		<option value="top" <?php selected($orderby, 'top'); ?>><?php _e('Top Reviews', 'framework'); ?></option>
		<option value="recent" <?php selected($orderby, 'recent'); ?>><?php _e('Recent Reviews', 'framework'); ?></option>
		<option value="random" <?php selected($orderby, 'random'); ?>><?php _e('Random Reviews', 'framework'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('display', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
		<option value="latest" <?php selected($display, 'latest'); ?>><?php _e('Latest Reviews', 'framework'); ?></option>
		<option value="cats" <?php selected($display, 'cats'); ?>><?php _e('Category/s', 'framework'); ?></option>
		<option value="tags" <?php selected($display, 'tags'); ?>><?php _e('Tag/s', 'framework'); ?></option>
		</select>
		</p>

		<p class="posts_widget_cats hidden">
		<label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e('Categories', 'framework') ?></label>
		<select id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>[]" class="widefat" multiple="multiple">
		<?php foreach ($categories as $cat) { ?>
			<option <?php echo in_array($cat->cat_ID, $cats)? 'selected="selected"':'';?> value="<?php echo $cat->cat_ID; ?>"><?php echo $cat->cat_name; ?></option>
		<?php } ?>
		</select>
		</p>

		<p class="hidden">
		<label for="<?php echo $this->get_field_id( 'tags' ); ?>"><?php _e('Tags:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" value="<?php echo $instance['tags']; ?>" class="widefat" />
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