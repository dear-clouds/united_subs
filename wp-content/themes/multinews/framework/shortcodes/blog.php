<?php

function mom_blog_sc($atts, $content) {
	extract(shortcode_atts(array(
	'style' => '',
	'display' => '',
	'category' => '',
	'tag' => '',
	'specific' => '',
	'orderby' => '',
	'posts_per_page' => 9,
	'offset' => '',
	'nexcerpt' => '',
	'pagination' => 'yes',
	'class' => '',
	'cols' => 2,
	'post_type' => '',
	'ad_id' => '',
	'ad_count' => 3,
	'ad_repeat' => '',
	), $atts));
  $cols = 'grid-col-'.$cols;
	    static $id = 75;
        $id++;
    if ($category == 'Select a Category') { $category = '';}
  if ($tag == 'Select a Tag') { $tag = '';}
       global $wp_query;
        if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

    global $post;
    $exclude_posts = '';
    if ( $post ) {
    	$exclude_posts = array($post->ID);
	}

//$output = get_transient('mom_blog_sc_'.$id.$style.$display.$category.$tag.$specific.$orderby.$offset.$nexcerpt.$posts_per_page.$pagination.$paged);
	$output = false;
if ($orderby == 'rand') {
	$output = false;
}

if ($output == false) { 
	ob_start();
	?>
			<?php if ($style == 'grid') { ?>
			                            <div class="site-content page-wrap category-view-blog">

				                                <?php if(mom_option('cat_swi')) { ?>
	                                <div class="f-tabbed-head">
	                                    <ul class="f-tabbed-sort cat-sort">
	                                        <li class="grid active"><a href="#"><span class="brankic-icon-grid"></span><?php _e(' Grid', 'framework') ?></a></li>
	                                        <li class="list"><a href="#"><span class="brankic-icon-list2"></span><?php _e(' List', 'framework') ?></a></li>
	                                    </ul>
	                                </div>
	                                <?php } ?>
	                                
	                                <?php 
	                                $catswi = mom_option('cat_swi_def');
	                                $swiclass = 'cat-grid '.$cols;
	                                if($catswi == 'list') {
		                                $swiclass = 'cat-list';
	                                }
	                                $srclass = '';
	                                if(mom_option('cat_swi') != true) {
		                                $srclass = ' no-head';	
	                                }
	                                ?>
	                                <div class="cat-body<?php echo $srclass; ?>">
	                                    <ul class="nb1 <?php echo $swiclass; ?> clearfix">
		<?php } else { ?>
	    <div class="blog_posts">
	   	<?php } ?>
		<?php
	if ($display == 'category') {
			$args = array(
			'post_type' => $post_type,
			'post__not_in' => $exclude_posts, 
			'post_status' => 'publish', 
			'posts_per_page' => $posts_per_page,
			'paged' => $paged ,
			'cat' => $category,
			'offset' => $offset,
			'orderby' => $orderby,
			'cache_results' => false
			); 
		} elseif ($display == 'tag') {
			$args = array(
			'post_type' => $post_type,
			'post__not_in' => $exclude_posts, 
			'post_status' => 'publish', 
			'posts_per_page' => $posts_per_page,
			'paged' => $paged ,
			'tag' => $tag,
			'offset' => $offset,
			'orderby' => $orderby,
			'cache_results' => false
			);
		} elseif ($display == 'specific') {
			$args = array(
			'post_type' => $post_type,
			'post__not_in' => $exclude_posts, 
			'post_status' => 'publish', 
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'p' => $specific,
			'orderby' => $orderby,
			'cache_results' => false
			);  
		} else {
			$args = array(
				'post_type' => $post_type,
				'post__not_in' => $exclude_posts, 
				'post_status' => 'publish', 
				'posts_per_page' => $posts_per_page,
				'paged' => $paged ,
				'offset' => $offset,
				'orderby' => $orderby,
				'cache_results' => false
			); 
		}
		$post_count = 1;
		$query = new WP_Query( $args ); 
		update_post_thumbnail_cache( $query );

		?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
			<?php 
				$grid_class = '';
				if ($style == 'grid') {
						if ($post_count%2 == 0) {
								$grid_class = ' second';
						} else {
								$grid_class = ' first';
						}
				}

			mom_blog_post($style, $nexcerpt, $class.$grid_class); 

				if ($ad_id != '') {
						if ($ad_repeat == 'yes') { 
								if ($post_count%$ad_count == 0) {
									if ($style == 'grid') { echo '<li>'; }
									echo do_shortcode('[ad id="'.$ad_id.'"]');
									if ($style == 'grid') { echo '</li>'; }
								}
						} else {
								if ($post_count == $ad_count) {
									if ($style == 'grid') { echo '<li>'; }
									echo do_shortcode('[ad id="'.$ad_id.'"]');
									if ($style == 'grid') { echo '</li>'; }
								}
						}
				}
				$post_count ++;

			?>
		<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'framework'); ?></p>
		<?php endif; ?>
		<?php if($pagination != 'no') { ?>
		<?php if ($style != 'grid') { mom_pagination($query->max_num_pages);} ?>
		<?php } ?>
		<?php wp_reset_query(); ?>
	<?php if ($style == 'grid') { ?>
               </ul>
                    <?php if($pagination != 'no') { mom_pagination($query->max_num_pages); } ?>
                </div>
            </div>

	<?php } else { ?>
      </div> <!-- blog posts -->
     <?php } ?>
<?php
	$output = ob_get_contents();
	ob_end_clean();
    //set_transient('mom_blog_sc_'.$id.$style.$display.$category.$tag.$specific.$orderby.$offset.$nexcerpt.$posts_per_page.$pagination.$paged, $output, 60*60*24);
  }
    return $output;
}
add_shortcode('blog', 'mom_blog_sc');
?>