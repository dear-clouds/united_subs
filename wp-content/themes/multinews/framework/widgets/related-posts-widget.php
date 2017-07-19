<?php 

add_action('widgets_init','mom_widget_related_posts');

function mom_widget_related_posts() {
	register_widget('mom_widget_related_posts');
	
	}

class mom_widget_related_posts extends WP_Widget {
	function mom_widget_related_posts() {
			
		$widget_ops = array('classname' => 'related_posts','description' => __('Widget display Posts order by : Popular, Random, Recent','framework'));
		parent::__construct('momizat-related-posts',__('Momizat - Related Posts','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = $instance['orderby'];
		$count = $instance['count'];
		$display = $instance['display'];
		$cats = isset($instance['cats']) ? $instance['cats'] : array();
		$relatedby = mom_option('related_type');
		
		if (is_single()) {
		if ($relatedby == 'tag') {
			$by = wp_get_post_tags(get_the_ID());
		} else {
			$by = get_the_category(get_the_ID());
		}
			if ($by) {
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		
		if ( $title )
			echo $before_title . $title . $after_title;
			
			$dateformat = mom_option('date_format');
			$post_meta_hp = mom_option('post_meta_hp');
	if($post_meta_hp == 1) {
		$post_head = mom_option('post_head');
		$post_head_author = mom_option('post_head_author');
		$post_head_date = mom_option('post_head_date');
		$post_head_cat = mom_option('post_head_cat');
		$post_head_commetns= mom_option('post_head_commetns');
		$post_head_views = mom_option('post_head_views');
		} else {
		$post_head = 1;
		$post_head_author = 1;
		$post_head_date = 1;
		$post_head_cat = 1;
		$post_head_commetns= 1;
		$post_head_views = 1;
		}
		
?>

		<ul class="post-list">
			
			<?php
			if ($by && $relatedby == 'tag') {
						$tag_ids = array();
						foreach($by as $individual_tag){ $tag_ids[] = $individual_tag->term_id;}
				
						$args=array(
						'post_type' => 'post', 
						'post_status' => 'publish', 
						'tag__in' => $tag_ids,
						'post__not_in' => array(get_the_ID()),
						'posts_per_page'=> $count,
						'ignore_sticky_posts'=>1,
						'no_found_rows' => true, 'cache_results' => false
						);
			}
			if ($by && $relatedby != 'tag') {
						    $cat_ids = array();
		    foreach($by as $individual_cat){ $cat_ids[] = $individual_cat->cat_ID;}
		
		    $args=array(
		    'post_type' => 'post', 
		    'post_status' => 'publish', 
			'category__in' => $cat_ids,
			'post__not_in' => array(get_the_ID()),
			'posts_per_page'=>$count,
			'ignore_sticky_posts'=>1,
			'no_found_rows' => true, 'cache_results' => false

		    );

			}

			$query = new WP_Query($args); 

			update_post_thumbnail_cache($query);

			?>
			<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

			<li>
				<?php if( mom_post_image() != false ) { ?>
				<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php mom_post_image_full('postlist-thumb'); ?>
				</a></figure>
				<?php } ?>
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php if($post_head != 0) { ?>
				<div class="entry-meta">
					<?php if($post_head_date != 0) { ?>
				    <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><i class="momizat-icon-calendar"></i><?php the_time($dateformat); ?></time>
				    <?php } ?>
				    <?php if($post_head_commetns != 0) { ?>
				    <div class="comments-link">
					<i class="momizat-icon-bubbles4"></i><a href="<?php the_permalink(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
				    </div>
				    <?php } ?>
				</div>
				<?php } ?>
				<a href="<?php the_permalink(); ?>" class="read-more-link"><?php _e('Read more...', 'framework'); ?></a>
			</li>

			<?php endwhile; ?>
			<?php  else:  ?>
			<!-- Else in here -->
			<?php  endif; ?>
			<?php wp_reset_postdata(); ?>
		</ul>
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
			}// if by 
		} // is single
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['display'] = $new_instance['display'];
		$instance['cats'] = $new_instance['cats'];


		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Related Posts ','framework'), 
			'count' => 3,
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number Of Posts:','framework'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>
   <?php 
}
	} //end class