<?php
function mom_new_tabs($atts, $content) {
	global $unique_posts;
	global $do_unique_posts;
	extract(shortcode_atts(array(
		'style' => 'grid',
		'columns' => '2', // grid columns 2,3,4
		'switcher' => '',
		'class' => '',
		), $atts));
		wp_enqueue_script('tabs');
		$hpmeta = mom_option('post_meta_hp');
		$rndn = rand(1,100);
		$columns_class = 'f-tabbed-cols'. $columns;
		
		if($style == 'list') {
			$sclass = 'list active';
		} else {
			$sclass = 'list';
		}
		
		if($style == 'grid') {
			$ssclass = 'grid active';
		} else {
			$ssclass = 'grid';
		}
		
if (!preg_match_all("/(.?)\[(news_tab)\b(.*?)(?:(\/))?\]/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}

		$tabs = '';
               
                $tabs .= '<div class="f-tabbed-head"><ul class="f-tabbed-header">';
	    
		for($i = 0; $i < count($matches[0]); $i++) {
				$display = isset($matches[3][$i]['display']) ? $matches[3][$i]['display'] : '';
				$number_of_posts = isset($matches[3][$i]['count']) ? $matches[3][$i]['count'] : '';
				$cat = isset($matches[3][$i]['cat']) ? $matches[3][$i]['cat'] :'';
				$tag = isset($matches[3][$i]['tag']) ? $matches[3][$i]['tag'] : '';
				$orderby = isset($matches[3][$i]['orderby']) ? $matches[3][$i]['orderby'] : '';
				$title = isset($matches[3][$i]['title']) ? $matches[3][$i]['title'] :'';
				$exc = isset($matches[3][$i]['exc']) ? $matches[3][$i]['exc'] :'';
				$offset = isset($matches[3][$i]['offset']) ? $matches[3][$i]['offset'] :'';
			if ($title == '' && $display == '' ) {
				$title = __('Recent Posts', 'framework');
			} elseif ($title == '' && $display == 'cat') {
				if ($cat != '') {
					$cat_data = get_category($cat);
				}

				$title = $cat_data->name;
			} elseif ($title == '' && $display == 'tag') {
				$title = $tag;
			}
			$tabs .= '<li class="cat_'.$cat.'"><a href="#">'.$title. '</a></li>';
		}
		$tabs .= '</ul>';
                if ($switcher != 'no') {
                    $tabs .= '<ul class="f-tabbed-sort tabbed-sort"><li class="'.$ssclass.'"><a href="#"><span class="brankic-icon-grid"></span> '.__('Grid', 'framework').'</a></li><li class="'.$sclass.'"><a href="#"><span class="brankic-icon-list2"></span>'.__('List', 'framework').'</a></li></ul>';
                }
                $tabs .= '</div>';

	    
            ob_start();
            $dateformat = mom_option('date_format');
            
            ?>
              <script>
		jQuery(document).ready(function($) {
		    $(".nt-<?php echo $rndn; ?> ul.f-tabbed-header").momtabs(".nt-<?php echo $rndn; ?> div.f-tabbed-container > .f-tabbed-body", { effect: 'fade'});
		});
	      </script>
<div class="f-tabbed-container">
	<?php
                for($i = 0; $i < count($matches[0]); $i++) {
				$display = isset($matches[3][$i]['display']) ? $matches[3][$i]['display'] : '';
				$number_of_posts = isset($matches[3][$i]['count']) ? $matches[3][$i]['count'] : '';
				$cat = isset($matches[3][$i]['cat']) ? $matches[3][$i]['cat'] :'';
				$cats = isset($matches[3][$i]['cats']) ? $matches[3][$i]['cats'] : '';
				$cats = explode(',', $cats);
				$tag = isset($matches[3][$i]['tag']) ? $matches[3][$i]['tag'] : '';
				$orderby = isset($matches[3][$i]['orderby']) ? $matches[3][$i]['orderby'] : '';
				$exc = isset($matches[3][$i]['exc']) ? $matches[3][$i]['exc'] :'';
				$offset = isset($matches[3][$i]['offset']) ? $matches[3][$i]['offset'] :'';

			?>
                <div class="f-tabbed-body cat_<?php echo $cat; ?>"><ul class="f-tabbed-<?php echo $style; ?> <?php echo $columns_class; ?>">
           <?php global $wpdb;

	    if ($tag != '') {
	    $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE 'name' = '".$tag."'");
	    }
    
            if ($orderby == 'popular') {
                $orderby = 'comment_count';
            } elseif ($orderby == 'random'){
                $orderby = 'rand';
            } elseif ($orderby == 'views') { 
            	$orderby = 'views';
            } else {
                $orderby = '';
            }
            
            if ($number_of_posts == "") {
                $number_of_posts = '6';
            }
			
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
            
             <?php

             	if ($orderby == 'views') {
					$views_key = 'post_views_count';
					if (function_exists('the_views')) {
						$views_key = 'views';
					}             		
                                if($display == 'cat') {
                                	$query = new WP_Query( array( 'post_type' => 'post', 'offset' => $offset , 'post_status' => 'publish', 'cat' => $cat, 'posts_per_page' => $number_of_posts, 'meta_key' => $views_key, 'orderby' => 'meta_value_num','order' => 'DESC', 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                                } elseif($display == 'tag') {
                                    $query = new WP_Query( array( 'post_type' => 'post', 'offset' => $offset , 'post_status' => 'publish', 'tag' => $tag, 'posts_per_page' => $number_of_posts, 'meta_key' => $views_key, 'orderby' => 'meta_value_num','order' => 'DESC', 'category__not_in' => $cats, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                                } else {
                                    $query = new WP_Query( array( 'post_type' => 'post', 'offset' => $offset , 'post_status' => 'publish', 'posts_per_page' => $number_of_posts, 'meta_key' => $views_key, 'orderby' => 'meta_value_num','order' => 'DESC', 'category__not_in' => $cats, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                                }					
				} else {
                                if($display == 'cat') {
                                	$query = new WP_Query( array( 'post_type' => 'post', 'offset' => $offset , 'post_status' => 'publish', 'cat' => $cat, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                                } elseif($display == 'tag') {
                                    $query = new WP_Query( array( 'post_type' => 'post', 'offset' => $offset , 'post_status' => 'publish', 'tag' => $tag, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby,'category__not_in' => $cats, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                                } else {
                                    $query = new WP_Query( array( 'post_type' => 'post', 'offset' => $offset , 'post_status' => 'publish', 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'category__not_in' => $cats, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
                                }
                          }
                              	update_post_thumbnail_cache( $query );

                                if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                                if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
                                ?>
                                             <li <?php post_class(); ?>>
                                             	<?php if( mom_post_image() != false ) { ?>
                                                <figure class="post-thumbnail"><a href="<?php the_permalink(); ?>">
                                                	<?php mom_post_image_full('newstabs-thumb'); ?>
                                                </a></figure>
                                                <?php } ?>
                                                <div <?php if( mom_post_image() != false ) { ?>class="f-tabbed-list-content"<?php } ?>>
	                                                <div class="f-p-title">
	                                                    <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	                                                    <?php if( mom_post_image() != false ) { ?>
	                                                    <span class="post-format-icon"></span>
	                                                    <?php } ?>
	                                                </div>
	                                                <div class="entry-content">
	                                                    <p>
	                                                    <?php global $post;
	                                                    $excerpt = $post->post_excerpt;
	                                                    if($excerpt==''){
	                                                    $excerpt = get_the_content('');
	                                                    }
	                                                    if($exc != ''){
	                                                    	echo wp_html_excerpt(strip_shortcodes($excerpt), $exc);
	                                                    } else {
		                                                    echo wp_html_excerpt(strip_shortcodes($excerpt), 154);
	                                                    }
	                                                    ?> ...
	                                                    </p>
	                                                </div>
	                                                <?php if($post_head != 0) { ?>
	                                                <div class="entry-meta">
	                                                	<?php if($post_head_date != 0) { ?>
	                                                    <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="datePublished" content="<?php the_time('c'); ?>"><i class="momizat-icon-calendar"></i><?php the_time($dateformat); ?></time>
	                                                    <?php } ?>
	                                                    <?php if($post_head_cat != 0) { ?>
	                                                    <span class="comments-link">
	                                                        <i class="momizat-icon-bubbles4"></i><a href="<?php comments_link(); ?>"><?php comments_number(__( '(0) Comments', 'framework' ), __( '(1) Comment', 'framework' ),__( '(%) Comments', 'framework' )); ?></a>
	                                                    </span>
	                                                    <?php } ?>
	                                                </div>
	                                                <?php } ?>
                                                </div>
                                            </li>

                            <?php
                            endwhile;
                            else:
                            endif;
                            wp_reset_postdata();
                            ?>
		</ul>
		<?php if ($display != '') {
			$link = '';
			if ($display == 'cat') {
				$link = get_category_link($cat);
			}
			if ($display == 'tag') {
				$tag_id = get_term_by('name', $tag, 'post_tag');
				if ($tag_id) {
					$tag_id = $tag_id->term_id;
				}
				$link = get_tag_link($tag_id);
			}
		?>
		
		<footer class="show-more"><a href="<?php echo $link; ?>" class="tabs-show-more"><?php _e('Show More', 'framework'); ?></a></footer>
		<?php } ?>

</div>
		<?php } ?>
</div>
	<?php 
        $content = ob_get_contents();
	ob_end_clean();

                
		return '<section class="section '.$class.'"><div class="feature-tabbed nt-'.$rndn.'">' . $tabs.$content . '</div></section>';
	}			
}

add_shortcode("news_tabs", "mom_new_tabs");