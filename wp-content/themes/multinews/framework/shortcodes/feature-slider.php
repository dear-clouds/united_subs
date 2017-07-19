<?php
function mom_feature_slider($atts, $content = null) {
			extract(shortcode_atts(array(
			'id' => '',
			'type' => 'def',
			'display' => 'latest',
			'cats' => '',
			'tag' => '',
			'specific' => '',
			'orderby' => '',
			'number_of_posts' => '',
			'animation' => '',
			'animationin' => '',
			'animationout' => '',
			'autoplay' => '',
			'timeout' => '4000',
			'cap' => 'yes',
			'exc' => '',
			'class' => '',
			'num_bullets' => '',
			'bullets_event' => ''
			), $atts));
			if ($id == '') {
				static $id = 75;
				$id++;
			}
			global $unique_posts;
			global $do_unique_posts;

			$lang = mom_get_lang();
			$specific = explode(',', $specific);
			if ($type == 'cat') {
												wp_enqueue_script('cycle');
								wp_enqueue_script('nicescroll');
			}
	if ($cats == 'Select a Category') { $cats = '';}
  if ($tag == 'Select a Tag') { $tag = '';}
$output = get_transient('mom_feature_sliders'.$id.$lang.$type.$display.$cats.$tag.$class.$orderby);
if ($orderby == 'rand') {
	$output = false;
}
if ($output == false) {
			ob_start();
  			if ($num_bullets == 'yes') { $class .= ' numbers_bullets';}

			if (is_rtl()) {
				$rtl = 'true';
			} else {
				$rtl = 'false';
			}
			if ($animation == 'fade') {
				$animationout = 'fadeOut';
				$animationin = '';
			} elseif ($animation == 'slide') {
				$animationout = '';
				$animationin = '';

			} elseif ($animation == 'flip') {
				$animationout = 'slideOutDown';
				$animationin = 'flipInX';
			}
			if ($autoplay == 'no') {
				$autoplay = 'false';
			} else {
				$autoplay = 'true';
			}

			$post_meta_hp = mom_option('post_meta_hp');
			if($post_meta_hp == 1) {
			$post_head = mom_option('post_head');
			$post_head_date = mom_option('post_head_date');
			} else {
			$post_head = 1;
			$post_head_date = 1;
			}
			?>
							<?php if($type == 'slider2') { ?> <!-- Full width Slider 2 -->

							<section class="section <?php echo $class; ?> feature_slider_<?php echo $id; ?>"><!--def slider-->
				                    	<div class="slider2 clearfix"> <!-- slider2 wrap -->
					                    	<?php
					                    	$i = 1;
						                    if($display == 'cat') {
						                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $cats, 'posts_per_page' => 5, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
						                    } elseif($display == 'tag') {
						                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tag, 'posts_per_page' => 5, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
						                    } elseif($display == 'specific') {
						                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'post__in' => $specific, 'posts_per_page' => 5, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
						                    } else {
						                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 5, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
						                    }
						                    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
						                    if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
						                    ?>
				                            <?php if( mom_post_image() != false ) { ?>

				                            <?php if ($i == 1 || $i == 2) { ?>
					                    	<div class="def-slider-item big-slider2">
					                            <a href="<?php the_permalink(); ?>">
					                            	<?php mom_post_image_full('catslider-thumb'); ?>
					                            </a>
					                            <?php if($cap != 'no') { ?>
					                            <div class="def-slider-cap">
					                                <div class="def-slider-title">
					                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					                                </div>
		                                                <?php if($exc != false) { ?>
					                                <p class="def-slider-desc">
					                                    <?php global $post;
					                                    $excerpt = $post->post_excerpt;
					                                    if($excerpt==''){
					                                    $excerpt = get_the_content('');
					                                    }
					                                    echo wp_html_excerpt(strip_shortcodes($excerpt), $exc);
					                                    ?> ...
					                                </p>
					                                <?php } ?>
					                            </div>
					                            <?php } ?>
					                        </div>
					                        <?php } else { ?>

					                        <div class="def-slider-item small-slider2">
					                            <a href="<?php the_permalink(); ?>"><?php mom_post_image_full('catslider-thumb'); ?></a>
					                            <?php if($cap != 'no') { ?>
					                            <div class="def-slider-cap">
					                                <div class="def-slider-title">
					                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					                                </div>
		                                                <?php if($exc != false) { ?>
					                                <p class="def-slider-desc">
					                                    <?php global $post;
					                                    $excerpt = $post->post_excerpt;
					                                    if($excerpt==''){
					                                    $excerpt = get_the_content('');
					                                    }
					                                    echo wp_html_excerpt(strip_shortcodes($excerpt), $exc);
					                                    ?> ...
					                                </p>
					                                <?php } ?>
					                            </div>
					                            <?php } ?>
					                        </div>
					                        <?php } ?>
					                        <?php } ?>
					                        <?php
					                        $i++;
				                            endwhile;
				                            else:
				                            endif;
				                            wp_reset_postdata();
				                            ?>

				                    	</div><!-- slider2 wrap -->
				                    </section>

				            <?php } elseif($type == 'cat') {	 ?>


								<section class="section clearfix <?php echo $class; ?> feature_slider_<?php echo $id; ?> feature-cat-slider-wrap mom_visibility_desktop">
								<div class="fc_nav">
									<a class="fc_prev" href="#"><span class="enotype-icon-arrow-left7"></span></a>
									<a class="fc_next" href="#"><span class="enotype-icon-uniE6D8"></span></a>
								</div>
								    <div class="cat-slider feature-cat-slider clearfix">
												<div class="cat-slider-wrap" data-cat_timeout="<?php echo $timeout; ?>">
										            <?php
										            $parent_posts = '';
										            if($display == 'cat') {
								                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $cats, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
								                    } elseif($display == 'tag') {
								                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tag, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
							                    	} elseif($display == 'specific') {
								                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'post__in' => $specific, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
								                    } else {
								                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
								                    }
							                    	update_post_thumbnail_cache( $query );
								                    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
								                    if ($unique_posts) {$do_unique_posts[] = get_the_ID();} $parent_posts[] = get_the_ID();	?>
								                    <?php if( mom_post_image() != false ) { ?>
										            <div class="cat-slider-item">
														<?php
															$layout = mom_option('main_layout');
															$site_width = mom_option('site_width');
															$thumb_size = 'catslider1-thumb';
															if (strpos($layout,'both') === false) {
															    $thumb_size = 'catslider-thumb';
														    	    if ($site_width == 'wide') {
																$thumb_size = 'catslider1-thumb';
															    }
															}
															if ($layout == 'fullwidth' && strpos(mom_option('main_layout'), 'both') !== false) {
															    $thumb_size = 'catslider1-thumb';
															}

														    ?>
									                	<div class="feature-cs-cap">
									                		<?php
									                			$category = get_the_category();
																if ($category) {
																	$cat_data = get_option("category_".$category[0]->term_id);
																	$cat_color = isset($cat_data['color']) ? $cat_data['color'] : '' ;

																  echo '<div class="cat-label" style="background:'.$cat_color.';"><a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s", 'framework' ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a></div>';
																}
									                		?>
									                		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									                		<?php if($exc != '') { ?>
									                		<p class="feature-cs-desc">
							                                    <?php global $post;
							                                    $excerpt = $post->post_excerpt;
							                                    if($excerpt==''){
							                                    $excerpt = get_the_content('');
							                                    }
							                                    echo wp_html_excerpt(strip_shortcodes($excerpt), $exc);
							                                    ?> ...
							                                </p>
							                                <?php } ?>
									                	</div>
										                <a href="<?php the_permalink(); ?>">
									                	<?php echo mom_post_image_full($thumb_size); ?>
										                </a>

										            </div>
										            <?php
										        	}
										            endwhile;
										            else:
										            ?>
										            <?php
										            endif;
										            ?>
										            <?php wp_reset_postdata(); ?>

										        </div>

									        <div class="cat-slider-nav">
									            <ul>
									                <?php

                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $number_of_posts, 'orderby' => 'post__in', 'no_found_rows' => true, 'cache_results' => false, 'post__in' => $parent_posts ) );
									                    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
									                    if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
									                ?>
									                <?php if( mom_post_image() != false ) { ?>
									                <li>
									                    <a href="<?php the_permalink(); ?>">
									                    <h2><?php short_title(47); ?></h2>
									                    <div class="entry-meta">
									                        <time class="entry-date" datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php the_time('Y/m/d'); ?></time>
									                        <div class="author-link">
									                            <?php _e('by ', 'framework') ?><a itemprop="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" rel="author"><?php echo get_the_author() ?></a>
									                        </div>
									                    </div>
									                    </a>
									                </li>
									                <?php } ?>
								                <?php
								                endwhile;
								                else:
								                ?>

								                <?php
								                endif;
								                wp_reset_postdata();
								                ?>
								            	</ul>
								        	</div>
								    </div>
								</section>
								<section class="section <?php echo $class; ?> feature_slider_<?php echo $id; ?> mom_visibility_device"><!--def slider-->
										<div class="def-slider">
												<div class="def-slider-wrap momizat-custom-slider" data-srtl="<?php echo $rtl; ?>" data-animate_out='<?php echo $animationout; ?>' data-animate_in="<?php echo $animationin; ?>" data-autoplay="<?php echo $autoplay; ?>" data-timeout="<?php echo $timeout; ?>" data-bullets_event="<?php echo $bullets_event; ?>">
														<?php
									$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $number_of_posts, 'orderby' => 'post__in', 'no_found_rows' => true, 'cache_results' => false, 'post__in' => $parent_posts ) );
									update_post_thumbnail_cache( $query );
									if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
									if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
									?>
														<?php if( mom_post_image() != false ) { ?>
														<div class="def-slider-item"  data-dot="<?php echo $count; ?>">
																<a href="<?php the_permalink(); ?>">
																	<?php
																		$thumbsize = 'slider-thumb';
																		if(mom_option('site_width') == 'wide'){
																			$classes = get_body_class();
								if (in_array('right-sidebar',$classes) || in_array('left-sidebar',$classes) ) {
																				$thumbsize = 'big-thumb-hd';
								}
																		}
																		mom_post_image_full($thumbsize);
																	?>
																</a>
																<?php if($cap != 'no') { ?>
																<div class="def-slider-cap">
																		<div class="def-slider-title">
																				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
																		</div>
																		<?php if($exc != false) { ?>
														<p class="def-slider-desc">
																<?php global $post;
																$excerpt = $post->post_excerpt;
																if($excerpt==''){
																$excerpt = get_the_content('');
																}
																echo wp_html_excerpt(strip_shortcodes($excerpt), $exc, '...');
																?>
														</p>
														<?php } ?>
																</div>
																<?php } ?>
														</div>
														<?php } ?>
														<?php
														endwhile;
														else:
														endif;
														wp_reset_postdata();
														?>
												</div>

										</div>
								</section><!--def slider-->


							<?php } else { ?> <!-- Default slider -->
		                            <section class="section <?php echo $class; ?> feature_slider_<?php echo $id; ?>"><!--def slider-->
		                                <div class="def-slider">
		                                    <div class="def-slider-wrap momizat-custom-slider" data-srtl="<?php echo $rtl; ?>" data-animate_out='<?php echo $animationout; ?>' data-animate_in="<?php echo $animationin; ?>" data-autoplay="<?php echo $autoplay; ?>" data-timeout="<?php echo $timeout; ?>" data-bullets_event="<?php echo $bullets_event; ?>">
		                                        <?php
		                                        $count = 1;
							                    if($display == 'cat') {
							                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'cat' => $cats, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
							                    } elseif($display == 'tag') {
							                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'tag' => $tag, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
							                    } elseif($display == 'specific') {
							                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'post__in' => $specific, 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
							                    } else {
							                    	$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $number_of_posts, 'orderby' => $orderby, 'no_found_rows' => true, 'cache_results' => false, 'post__not_in' => $do_unique_posts ) );
							                    }
							                    update_post_thumbnail_cache( $query );
							                    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
							                    if ($unique_posts) {$do_unique_posts[] = get_the_ID();}
							                    ?>
		                                        <?php if( mom_post_image() != false ) { ?>
		                                        <div class="def-slider-item"  data-dot="<?php echo $count; ?>">
		                                            <a href="<?php the_permalink(); ?>">
		                                            	<?php
		                                            		$thumbsize = 'slider-thumb';
		                                            		if(mom_option('site_width') == 'wide'){
		                                            			$classes = get_body_class();
																if (in_array('right-sidebar',$classes) || in_array('left-sidebar',$classes) ) {
		                                            				$thumbsize = 'big-thumb-hd';
																}
		                                            		}
		                                            		mom_post_image_full($thumbsize);
		                                            	?>
		                                            </a>
		                                            <?php if($cap != 'no') { ?>
		                                            <div class="def-slider-cap">
		                                                <div class="def-slider-title">
		                                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		                                                </div>
		                                                <?php if($exc != false) { ?>
						                                <p class="def-slider-desc">
						                                    <?php global $post;
						                                    $excerpt = $post->post_excerpt;
						                                    if($excerpt==''){
						                                    $excerpt = get_the_content('');
						                                    }
						                                    echo wp_html_excerpt(strip_shortcodes($excerpt), $exc, '...');
						                                    ?>
						                                </p>
						                                <?php } ?>
		                                            </div>
		                                            <?php } ?>
		                                        </div>
		                                        <?php } ?>
		                                        <?php
		                                        $count++;
		                                        endwhile;
		                                        else:
		                                        endif;
		                                        wp_reset_postdata();
		                                        ?>
		                                    </div>

		                                </div>
		                            </section><!--def slider-->

		               <?php } ?> <!-- End Slider type -->
			<?php
			$output = ob_get_contents();
			ob_end_clean();
    		set_transient('mom_feature_sliders'.$id.$lang.$type.$display.$cats.$tag.$class.$orderby, $output, 60*60*24);
	}

			return $output;
}

add_shortcode('feature_slider', 'mom_feature_slider');
