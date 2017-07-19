<?php 

add_action('widgets_init','mom_widget_posts_list');

function mom_widget_posts_list() {
	register_widget('mom_widget_posts_list');
	
	}

class mom_widget_posts_list extends WP_Widget {
	function mom_widget_posts_list() {
			
		$widget_ops = array('classname' => 'posts_list','description' => __('Widget display Posts order by : Popular, Random, Recent','framework'));
		parent::__construct('momizat-posts_list',__('Momizat - Posts List','framework'),$widget_ops);

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = $instance['orderby'];
		$count = $instance['count'];
		$display = $instance['display'];
		$cats = isset($instance['cats']) ? $instance['cats'] : array();
		$tags = isset($instance['tags']) ? $instance['tags'] : array();

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
			global $unique_posts;
			global $do_unique_posts;
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
			<?php if($orderby == 'Popular') { ?>
				<?php if ($display == 'cats') {
				$catsi = implode(',', $cats);
				?>
	
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } elseif ($display == 'tags') { ?>
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tags, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } else { ?>
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } ?>
			<?php } elseif($orderby == 'Random') { ?>
				<?php if ($display == 'cats') {
				$catsi = implode(',', $cats);
				
				?>
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'rand', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } elseif ($display == 'tags') { ?>
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tags, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'rand', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } else { ?>
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'orderby' => 'comment_count', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } ?>
			<?php } elseif($orderby == 'Recent') { ?>
				<?php if ($display == 'cats') {
				$catsi = implode(',', $cats);
				?>
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $catsi, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } elseif ($display == 'tags') { ?>
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tags, 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } else { ?>
				<?php $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'posts_per_page' => $count, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) ); ?>
				<?php } ?>
			<?php } ?>
			<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
				  if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
			?>
			<li <?php post_class(); ?>>
				<h2>
                    <a class="entry-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
               </h2>
               <span class="post-format-icon"></span>
               <?php if($post_head != 0) { ?>
               <div class="entry-meta">
               		<?php if($post_head_date != 0) { ?>
                	<time class="entry-date updated" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php the_time($dateformat); ?></time>
					<?php } ?>
				</div>
				<?php } ?>
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

		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Most Popular','framework'), 
			'count' => 5
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		if (isset($instance['orderby'])) { $orderbyS = $instance['orderby'];} else {$orderbyS = ''; }
		if (isset($instance['display'])) { $displayS = $instance['display'];} else {$displayS = ''; }
		if (isset($instance['tags'])) { $tags = $instance['tags']; } else { $tags = ''; }
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
		<option <?php if ( 'tags' == $displayS ) echo 'selected="selected"'; ?> value="tags"><?php _e('Tag/s', 'framework'); ?></option>
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
	} //end class