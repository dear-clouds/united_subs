<?php 

add_action('widgets_init','mom_widget_posts');

function mom_widget_posts() {
	register_widget('mom_widget_posts');
	
	}

class mom_widget_posts extends WP_Widget {
	function mom_widget_posts() {
			
		$widget_ops = array('classname' => 'posts','description' => __('Widget display Posts order by : Popular, Random, Recent','theme'));
		parent::__construct('momizat-posts',__('Momizat - Posts','theme'),$widget_ops);

		add_action( 'save_post', array( $this, 'invalidate_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'invalidate_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'invalidate_widget_cache' ) );

		}
		
	function widget( $args, $instance ) {
		extract( $args );
		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$orderby = $instance['orderby'];
		$count = $instance['count'];
		$display = $instance['display'];
		$cats = isset($instance['cats']) ? $instance['cats'] : array();
		$layout = isset($instance['layout']) ? $instance['layout'] : '';
		$sidebar_size = isset($instance['sidebar_size']) ? $instance['sidebar_size'] : '';
		$tag = isset($instance['tag']) ? $instance['tag'] : '';
		


$output = get_transient('mom-posts-widget-'.$this->id);
if ($orderby == 'random') {
	$output = false;
}
if ($output == false) { 
    ob_start();
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?>
		<ul class="post-list <?php echo $layout; ?>">

		<?php
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

			if ($orderby == 'popular') {
				if ($display == 'cats') {
					$catsi = implode(',', $cats);
					$args = array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, "orderby" => "comment_count", 'cat' => $catsi);
				} elseif ($display == 'tag') {
					$args = array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, "orderby" => "comment_count", 'tag' => $tag);
				} else {
					$args = array (  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, "orderby" => "comment_count"); 
				}
			} elseif ($orderby == 'random') {
				if ($display == 'cats') {
					$catsi = implode(',', $cats);
					$args = array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, "orderby" => "rand", 'cat' => $catsi);
				} elseif ($display == 'tag') {
					$args = array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, "orderby" => "rand", 'tag' => $tag);
				} else {
					$args =  array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, "orderby" => "rand"); 
				}
			} elseif ($orderby == 'views') {
					$views_key = 'post_views_count';
					if (function_exists('the_views')) {
						$views_key = 'views';
					}
				if ($display == 'cats') {
					$catsi = implode(',', $cats);
					$args = array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, 'cat' => $catsi, 'meta_key' => $views_key, 'orderby' => 'meta_value_num','order' => 'DESC');
				} elseif ($display == 'tag') {
					$args = array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, 'tag' => $tag, 'meta_key' => $views_key, 'orderby' => 'meta_value_num','order' => 'DESC');
				} else {
					$args =  array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, 'meta_key' => $views_key, 'orderby' => 'meta_value_num','order' => 'DESC'); 
				}
			} else {
				if ($display == 'cats') {
					$catsi = implode(',', $cats);
					$args =  array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, 'cat' => $catsi);
				} elseif ($display == 'tag') {
					$args =  array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts, 'tag' => $tag);
				} else {
					$args = array(  "ignore_sticky_posts" => 1, 'posts_per_page' => $count, 'cache_results' => false, 'no_found_rows' => true, 'post__not_in' => $do_unique_posts); 
				}
			}
			$query = new WP_Query( $args );
			update_post_thumbnail_cache( $query );
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
			if ($sidebar_size == 'small') {
				$img_size = 'postlist-thumb';
				if ($layout == 'full') {
					$img_size = 'postlist-thumb';
				}
			} elseif ($sidebar_size == 'big') {
				$img_size = 'postpicwid-thumb';
				if ($layout == 'full') {
					$img_size = 'sliderwidget-thumb';
				}
			} else {
				$img_size = 'postlist-thumb';
				if ($layout == 'full') {
					$img_size = 'sliderwidget-thumb';
				}
			}
		?>
			<li>
				<?php if( mom_post_image() != false ) { ?>
				<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php mom_post_image_full($img_size); ?>
				</a></figure>
				<?php } ?>
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php if($post_head != 0) { ?>
				<div class="entry-meta">
					<?php if($post_head_date != 0) { ?>
				    <time class="entry-date" datetime="<?php the_time('c'); ?>" content="<?php the_time('c'); ?>"><i class="momizat-icon-calendar"></i><?php the_time($dateformat); ?></time>
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
			<?php wp_reset_query(); ?>
                                    </ul>
<?php 
		/* After widget (defined by themes). */
		echo $after_widget;
    $output = ob_get_contents();
    ob_end_clean();
    set_transient('mom-posts-widget-'.$this->id, $output, 60*60*24);
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
		$instance['layout'] = $new_instance['layout'];
		$instance['sidebar_size'] = $new_instance['sidebar_size'];
		$instance['tag'] = $new_instance['tag'];
		delete_transient('mom-posts-widget-'.$this->id);


		return $instance;
	}
	
function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Recent Posts','theme'), 
			'count' => 5
 			);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$orderby = isset($instance['orderby']) ? $instance['orderby'] : '';
		$display = isset($instance['display']) ? $instance['display'] : '';
		$cats = isset($instance['cats']) ? $instance['cats'] : array();
		$layout = isset($instance['layout']) ? $instance['layout'] : '';
		$sidebar_size = isset($instance['sidebar_size']) ? $instance['sidebar_size'] : '';
		$tag = isset($instance['tag']) ? $instance['tag'] : '';
		$categories = get_categories('hide_empty=0');
	
		?>
	<script>
		jQuery(document).ready(function($) {
			$('#<?php echo $this->get_field_id( 'display' ); ?>').change( function () {
				if ($(this).val() === 'cats') {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeIn();
				} else if ($(this).val() === 'tag') {
					$('#<?php echo $this->get_field_id('tag'); ?>').parent().fadeIn();
				} else {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeOut();
				}
				
			});
				if ($('#<?php echo $this->get_field_id( 'display' ); ?>').val() === 'cats') {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeIn();
				} else if ($('#<?php echo $this->get_field_id( 'display' ); ?>').val() === 'tag') {
					$('#<?php echo $this->get_field_id('tag'); ?>').parent().fadeIn();
				} else {
					$('#<?php echo $this->get_field_id('cats'); ?>').parent().fadeOut();
				}
		});
	</script>
	
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','theme'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e('layout', 'theme') ?></label>
		<select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" class="widefat">
		<option value="default" <?php selected($layout, 'default'); ?>><?php _e('Default', 'framework'); ?></option>
		<option value="full" <?php selected($layout, 'full'); ?>><?php _e('Full width image', 'framework'); ?></option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'sidebar_size' ); ?>"><?php _e('Sidebar size - to set image size for website performance', 'theme') ?></label>
		<select id="<?php echo $this->get_field_id( 'sidebar_size' ); ?>" name="<?php echo $this->get_field_name( 'sidebar_size' ); ?>" class="widefat">
		<option value="big" <?php selected($sidebar_size, 'big'); ?>><?php _e('Big sidebar', 'framework'); ?></option>
		<option value="small" <?php selected($sidebar_size, 'small'); ?>><?php _e('Small sidebar', 'framework'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('orderby', 'theme') ?></label>
		<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat">
		<option value="recent" <?php selected($orderby, 'recent'); ?>><?php _e('Recent', 'theme'); ?></option>
		<option value="popular" <?php selected($orderby, 'popular'); ?>><?php _e('Popular', 'theme'); ?></option>
		<option value="random" <?php selected($orderby, 'random'); ?>><?php _e('Random', 'theme'); ?></option>
		<option value="views" <?php selected($orderby, 'views'); ?>><?php _e('Most viewed', 'theme'); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('display', 'theme') ?></label>
		<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
		<option value="latest" <?php selected($display, 'latest'); ?>><?php _e('Latest Posts', 'framework'); ?></option>
		<option value="cats" <?php selected($display, 'cats'); ?>><?php _e('Category/s', 'framework'); ?></option>
		<option value="tag" <?php selected($display, 'tag'); ?>><?php _e('Tag', 'framework'); ?></option>
		</select>
		</p>

		<p class="posts_widget_cats hidden">
		<label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e('Categories', 'theme') ?></label>
		<select id="<?php echo $this->get_field_id( 'cats' ); ?>" name="<?php echo $this->get_field_name( 'cats' ); ?>[]" class="widefat" multiple="multiple">
		<?php foreach ($categories as $cat) { ?>
			<option <?php echo in_array($cat->cat_ID, $cats)? 'selected="selected"':'';?> value="<?php echo $cat->cat_ID; ?>"><?php echo $cat->cat_name; ?></option>
		<?php } ?>
		</select>
		</p>
		<p class="posts_widget_tags hidden">
		<label for="<?php echo $this->get_field_id( 'tag' ); ?>"><?php _e('Tag', 'theme') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'tag' ); ?>" name="<?php echo $this->get_field_name( 'tag' ); ?>" value="<?php echo $instance['tag']; ?>" class="widefat">
		<small><?php _e('Insert tag slug.'. 'theme'); ?></small>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number Of Posts:','theme'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" class="widefat" />
		</p>

   <?php 
}
	public function invalidate_widget_cache()
	{
		delete_transient('mom-posts-widget-'. $this->id );
	}

 } //end class