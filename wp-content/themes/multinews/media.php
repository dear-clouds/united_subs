<?php
/*
Template name: Media
*/

get_header();
global $post;
	$layout = get_post_meta($post->ID, 'mom_page_layout', TRUE);
	if ($layout == '') { $layout = mom_option('main_layout');}
	$custom_psidebar = get_post_meta($post->ID, 'mom_left_sidebar', TRUE);
	$pagebreadcrumb = get_post_meta($post->ID, 'mom_hide_breadcrumb', true);
	$icon = get_post_meta($post->ID, 'mom_page_icon', true);
	$mdisplay = get_post_meta($post->ID, 'mom_media_display', TRUE);
	$mcat = get_post_meta($post->ID, 'mom_media_cat', TRUE);
	$mcat = get_post_meta($post->ID, 'mom_media_cat', TRUE);
	$mposts = get_post_meta($post->ID, 'mom_media_posts', TRUE);
	if ($mposts == '') {
		$mposts = 10;
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
                <div class="main-container"><!--container-->
                    
                    <?php if(mom_option('breadcrumb') != 0) { ?>
                    <?php if ($pagebreadcrumb != true) { ?> 
                    <div class="post-crumbs entry-crumbs">
                    	<?php if($icon != '') { 
				if (0 === strpos($icon, 'http')) {
					echo '<div class="crumb-icon"><i class="img_icon" style="background-image: url('.$icon.')"></i></div>';
				} else {
					echo '<div class="crumb-icon"><i class="'.$icon.'"></i></div>';
				}
				 } else { ?>
                        <div class="crumb-icon"><i class="momizat-icon-film"></i></div>
                        <?php } ?>
                         <?php mom_breadcrumb(); ?>
                         <span><?php the_title(); ?></span>
                        
                        <!-- <div class="cat-feed"><a href=""><i class="enotype-icon-rss"></i></a></div> -->
                    </div>
					<?php } ?>
					<?php } else { ?>
						<span class="mom-page-title"><h1><?php the_title(); ?></h1></span>
					<?php } ?>
					
					
                        <div class="media-main-content main-content" role="main"><!--Main Content-->
                            
                            <div class="site-content page-wrap">
                                 
                                 <div class="f-tabbed-head">
                                    <ul class="f-tabbed-sort cat-sort media-tabs" data-count="<?php echo $mposts; ?>">
                                    	<li class="all active" data-type="all"><a href="#"><?php _e(' All', 'framework'); ?></a></li>
                                        <li class="media-video" data-type="video"><a href="#"><span class="momizat-icon-play3"></span><?php _e(' Video', 'framework'); ?></a></li>
                                        <li class="media-gallery" data-type="gallery"><a href="#"><span class="momizat-icon-images"></span><?php _e(' Gallery', 'framework'); ?></a></li>
					<li class="media-audio" data-type="audio"><a href="#"><span class="momizat-icon-volume-medium"></span><?php _e(' Audio', 'framework'); ?></a></li>
                                    </ul>
                                    <form class="media-sort-form" method="get">
	                                    <div class="media-sort-wrap">
		                                    <select id="media-sort">
			                                    <option value="recent"><?php _e('Recent', 'framework'); ?></option>
			                                    <option value="popular"><?php _e('Popular', 'framework'); ?></option>
		                                    </select>
	                                    <div class="sort-arrow"></div>
                                    	</div>
                                    </form>
                                     <span class="media-sort-title"><?php _e('Sort by:', 'framework'); ?></span>
								</div>
                                 <div class="media-page-content">
                                 <ul class="media-items-list clearfix">
	                                 <?php 
        if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

	                         if($mdisplay == 'cat'){
		                         $args = array(
							    'post_type' => 'post', 
							    'posts_per_page' => $mposts,
							    'cat' => $mcat,
							    'tax_query' => array(
							    array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array('post-format-audio', 'post-format-video', 'post-format-gallery'),
								'operator' => 'IN'
							    ))
								);
	                         } else {
							 $args = array(
							    'post_type' => 'post', 
							    'posts_per_page' => $mposts,
							    'paged' => $paged,
							    'tax_query' => array(
							    array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array('post-format-audio', 'post-format-video', 'post-format-gallery'),
								'operator' => 'IN'
							    ))
							);
							}

					    $query = new WP_Query( $args );
					    update_post_thumbnail_cache( $query );

					    $i = 0;
                     if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					    global $posts_st;
					    $extra = get_post_meta(get_the_ID(), $posts_st->get_the_id(), TRUE);
                                        if (isset($extra['video_type'])) { $video_type = $extra['video_type']; }
                                        if (isset($extra['video_id'])) { $video_id = $extra['video_id']; }
                                        if (isset($extra['html5_mp4_url'])) { $html5_mp4 = $extra['html5_mp4_url']; }
                                        if (isset($extra['html5_duration'])) { $html5_duration = $extra['html5_duration']; } else { $html5_duration = '00:00'; }
                                        if (isset($extra['slides'])) { $slides = $extra['slides']; } else { $slides = ''; }
					$post_format = get_post_format();
					
					$num_of_slides = $post_format == 'gallery' ? count($slides) :'';
					if ($i < 2) { 
	                                 ?>
					 <li <?php post_class('media-item featured'); ?>>
					 	<div class="media-item--inner">
					 			<?php if( mom_post_image() != false ) { ?>
				    		    <figure class="post-thumbnail">
							   <a href="<?php the_permalink(); ?>">
							   		<?php mom_post_image_full('media1-thumb'); ?>
							   </a>
							   <div class="media-data">
								   <div class="media-format"></div>
								   <?php if ($post_format == ('video')) { ?>
									<?php if ($video_type == 'youtube') { ?>
									   <?php if (mom_youtube_duration($video_id) != false) { ?>
									   <div class="video-time">
									       <?php echo mom_youtube_duration($video_id); ?>
									   </div>
									   <?php } ?>
									   <?php } elseif ($video_type == 'vimeo') { ?>
									   <div class="video-time">
									       <?php echo mom_vimeo_duration($video_id); ?>
									   </div>
									   <?php } else { ?>
									       <div class="video-time">
										   <?php echo $html5_duration; ?>
									       </div>
									   <?php } ?>
							       <?php } elseif ($post_format == ('gallery')) { ?>
							       		<div class="video-time"><?php echo $num_of_slides; ?></div>
							       <?php } else { ?>
						       			<div class="video-time">
										   <?php echo $html5_duration; ?>
								       </div>
							       <?php } ?>
							   </div>
						    </figure>
						    <?php } ?>
						    <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						    <?php if($post_head != 0) { ?>
						    <div class="entry-meta">
							    <?php if($post_head_date != 0) { ?>
							    <time datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php mom_date_format(); ?></time>
							    <?php } ?>
							    <?php if($post_head_cat != 0) { ?>
							    <div class="cat-link">
								    <?php $category = get_the_category(); echo '<a class="category" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>
							    </div>
							    <?php } ?>
						    </div>
						    <?php } ?>
						    </div>
					 </li>
					 <?php
					} else {
						$s = '';
					if ($i == 2) { $s = 'ms-first-item';} ?>
					    <li <?php post_class('media-item m-items '.$s); ?>>
					 	<div class="media-item--inner">
					    				<?php if( mom_post_image() != false ) { ?>
		                                 <figure class="post-thumbnail">
		                                 	<a href="<?php the_permalink(); ?>">
			                                 	<?php mom_post_image_full('media-thumb'); ?>
		                                 	</a>
		                                 	<div class="media-data">
			                                 	<div class="media-format"></div>
			                                 	<?php if ($post_format == ('video')) { ?>
									<?php if ($video_type == 'youtube') { ?>
									   <?php if (mom_youtube_duration($video_id) != false) { ?>
									   <div class="video-time">
									       <?php echo mom_youtube_duration($video_id); ?>
									   </div>
									   <?php } ?>
									   <?php } elseif ($video_type == 'vimeo') { ?>
									   <div class="video-time">
									       <?php echo mom_vimeo_duration($video_id); ?>
									   </div>
									   <?php } else { ?>
									       <div class="video-time">
										   <?php echo $html5_duration; ?>
									       </div>
									   <?php } ?>
							       <?php } elseif ($post_format == ('gallery')) { ?>
							       		<div class="video-time"><?php echo $num_of_slides; ?></div>
							       <?php } else { ?>
						       			<div class="video-time">
										   <?php echo $html5_duration; ?>
								       </div>
							       <?php } ?>
		                                 	</div>
		                                 </figure>
		                                 <?php } ?>
		                                 <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		                                 <?php if($post_head != 0) { ?>
		                                 <div class="entry-meta">
		                                 	<?php if($post_head_date != 0) { ?>
			                                 <time datetime="<?php the_time('c'); ?>" itemprop="dateCreated"><?php mom_date_format(); ?></time>
			                                 <?php } ?>
											 <?php if($post_head_cat != 0) { ?>
			                                 <div class="cat-link">
				                                 <?php $category = get_the_category(); echo '<a class="category" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>
			                                 </div>
			                                 <?php } ?>
		                                 </div>
		                                 <?php } ?>
		                             </div>
					    </li>
					<?php
					}
					 $i++;
		                            endwhile;
		                            else:
		                            endif;
		                            ?>                                 
	                       
	                            </ul>
	                            <?php 
								wp_reset_postdata();
	                            ?>
				 </div> <!--media page content -->
				 <footer class="show-more media-show-more">
				         <a href="#" class="show-more-posts"  data-offset="<?php echo $mposts; ?>" data-count="<?php echo $mposts; ?>"><?php _e('Show More', 'framework'); 
				         ?></a>
				     </footer>

                            </div>
                            
								<div class="clear"></div>
                        		<?php the_content(); ?>
                        </div><!--Main Content-->

                    <?php
                    $swstyle = mom_option('swstyle');
			          if( $swstyle == 'style2' ){
			            $swclass = ' sws2';
			          } else {
			            $swclass = '';
			          }
					if (strpos($layout,'both') === false) {
					    $site_width = mom_option('site_width');
				    	    if ($site_width != 'wide') {
					    ?>
						
						<aside class="secondary-sidebar<?php echo $swclass; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar"><!--secondary sidebar-->
							<?php
							if (!empty($custom_psidebar)) {
							    dynamic_sidebar($custom_psidebar);		    
							} else { 
								dynamic_sidebar( 'Secondary sidebar' ); 
							}
							?>
						</aside>
					<?php
					    } else {
							get_sidebar();
					    }
					} else {
							get_sidebar();
					} 
					?>
                </div><!--container-->
    
            </div><!--wrap-->
            <?php get_footer(); ?>