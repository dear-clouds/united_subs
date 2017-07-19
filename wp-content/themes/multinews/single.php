<?php get_header(); ?>

<?php
    global $post;
    //page layout
    $layout = get_post_meta(get_the_ID(), 'mom_page_layout', true);
    if ($layout == '') { $layout = mom_option('post_page_layout'); }
    if ($layout == '') {
    	$layout = mom_option('main_layout');
    }
    //post settings
    $HFI = get_post_meta(get_the_ID(), 'mom_hide_feature', true);
    $DPS = get_post_meta(get_the_ID(), 'mom_blog_ps', true);
    $DPN = get_post_meta(get_the_ID(), 'mom_blog_np', true);
    $DAB = get_post_meta(get_the_ID(), 'mom_blog_ab', true);
    $DRP = get_post_meta(get_the_ID(), 'mom_blog_rp', true);
    $DPC = get_post_meta(get_the_ID(), 'mom_blog_pc', true);
    $PTS = get_post_meta(get_the_ID(), 'mom_blog_tags', true);
    $PCT = get_post_meta(get_the_ID(), 'mom_photo_credit', true);
    $PSC = get_post_meta(get_the_ID(), 'mom_post_source', true);
    $disable_ads = get_post_meta(get_the_ID(), 'mom_disable_post_ads', true);
    $site_width = mom_option('site_width');
    // story_higlight
    $SHE = get_post_meta($post->ID, 'mom_hide_highlights', true);
    $SH = get_post_meta($post->ID, 'mom_post_highlights', true);
    $mom_post_layout = get_post_meta($post->ID, 'mom_post_layout', true);
    if ($mom_post_layout == '') {
	$mom_post_layout = mom_option('post_layout');
    }
    $default_image_click = get_post_meta($post->ID, 'mom_default_image_click', true);
    if ($default_image_click == '') {
	$default_image_click = mom_option('post_layout_default_img');
    }
		$custom_main_sidebar = get_post_meta(get_queried_object_id(), 'mom_right_sidebar', TRUE);
		$custom_sec_sidebar = get_post_meta(get_queried_object_id(), 'mom_left_sidebar', TRUE);


		$cat_msidebar = '';
		$cat_ssidebar = '';
			$cat_icon = '';
    if (has_category('',$post->ID)) {
    $catid = get_the_category( $post->ID );
    $cat_data = get_option("category_".$catid[0]->term_id);
	$cat_icon = '';
	if($cat_data != '') {
		$cat_icon = isset($cat_data['icon']) ? $cat_data['icon'] : '' ;
		$cat_msidebar = isset($cat_data['sidebar']) ? $cat_data['sidebar'] : '' ;
		$cat_ssidebar = isset($cat_data['ssidebar']) ? $cat_data['ssidebar'] : '' ;
	} else {
		$cat_icon = '';
		$cat_msidebar = '';
		$cat_ssidebar = '';
	}
	if (mom_option('post_cat_sidebar') == false) {
		$cat_msidebar = '';
		$cat_ssidebar = '';
	}
	}
	$postbreadcrumb = mom_option('post_bread');
    $posticon = mom_option('post_icon');

                                    while ( have_posts() ) :
									the_post();
								if (mom_option('post_views_ajax') != 1) {
                                setPostViews(get_the_ID());
                                }

?>

<?php if (mom_post_image()) { ?>
<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
    <meta itemprop="url" content="<?php echo mom_post_image('medium'); ?>">
    <meta itemprop="width" content="<?php echo get_option( 'medium_size_w' ); ?>">
    <meta itemprop="height" content="<?php echo get_option( 'medium_size_h' ); ?>">
  </div>
<?php } ?>
  <meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>

  <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
    <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
      <meta itemprop="url" content="<?php echo mom_option('logo_img', 'url'); ?>">
      <meta itemprop="width" content="<?php echo mom_option('logo_img', 'width'); ?>">
      <meta itemprop="height" content="<?php echo mom_option('logo_img', 'height'); ?>">
    </div>
        <meta itemprop="name" content="<?php bloginfo('name'); ?>">
  </div>
  <meta itemprop="datePublished" content="<?php the_time('c'); ?>"/>
  <meta itemprop="dateModified" content="<?php the_modified_date('c'); ?>"/>

				<?php if($mom_post_layout == 'layout1') {
				$img = mom_post_image('full');
				$cover = get_post_meta(get_the_ID(), 'mom_post_cover_image', true);
				if ($cover) {
					$img = $cover;
				}
				?>
				<img src="<?php echo mom_post_image(); ?>" class="hide" alt="<?php the_title(); ?>">
				<div class="post-layout1" style="background: url('<?php echo $img; ?>') no-repeat center;"><?php if($PCT != '') { ?><div class="photo-credit"><i class="momizat-icon-camera"></i><?php _e('Photo Credit To ', 'framework'); ?><?php echo $PCT; ?></div><?php } ?><div class="pl2-shadow"></div></div>
				<?php } else if($mom_post_layout == 'layout2') {
				$img = mom_post_image('full');
				$cover = get_post_meta(get_the_ID(), 'mom_post_cover_image', true);
				if ($cover) {
					$img = $cover;
				}
				?>
				<img src="<?php echo mom_post_image(); ?>" class="hide" alt="<?php the_title(); ?>">
				<div class="post-layout2" style="background: url('<?php echo $img; ?>') no-repeat center;">
					<?php if($PCT != '') { ?><div class="photo-credit"><i class="momizat-icon-camera"></i><?php _e('Photo Credit To ', 'framework'); ?><?php echo $PCT; ?></div><?php } ?>
					<div class="pl2-shadow">
						<div class="pl2-tab-wrap">
							<div class="inner">
								<h1 itemprop="headline" class="entry-title"><?php the_title(); ?></h1>
								<?php if (class_exists('WPSubtitle')) { ?><h2 class="mom-sub-title"><?php the_subtitle(); ?></h2><?php } ?>
			                    <?php if(mom_option('post_head')) { get_template_part( 'framework/includes/post-head' ); } ?>

							</div>
						</div>
					</div>
				</div>

				<?php } else if($mom_post_layout == 'layout3') {
				$img = mom_post_image('full');
				$cover = get_post_meta(get_the_ID(), 'mom_post_cover_image', true);
				if ($cover) {
					$img = $cover;
				}

				?>
				<img src="<?php echo mom_post_image(); ?>" class="hide" alt="<?php the_title(); ?>">
				<div class="post-layout3" style="background: url('<?php echo $img; ?>') no-repeat center;">
					<?php if($PCT != '') { ?><div class="photo-credit"><i class="momizat-icon-camera"></i><?php _e('Photo Credit To ', 'framework'); ?><?php echo $PCT; ?></div><?php } ?>
					<div class="pl3-shadow">
							<div class="inner">
								<div class="pl2-bottom">
									<?php if(mom_option('breadcrumb') != 0) { ?>
				                    <?php if($postbreadcrumb) { ?>
				                    <div class="post-crumbs entry-crumbs">
							<?php if ($cat_icon != '') {
								if (0 === strpos($cat_icon, 'http')) {
									echo '<div class="crumb-icon"><i class="img_icon" style="background-image: url('.$cat_icon.')"></i></div>';
								} else {
									echo '<div class="crumb-icon"><i class="'.$cat_icon.'"></i></div>';
								}
							} ?>
				                        <?php mom_breadcrumb(); ?>
				                    </div>
				                    <?php } ?>
				                    <?php } ?>
									<h1 itemprop="headline" class="entry-title"><?php the_title(); ?></h1>
									<?php if (class_exists('WPSubtitle')) { ?><h2 class="mom-sub-title"><?php the_subtitle(); ?></h2><?php } ?>
				                    <?php if(mom_option('post_head')) { get_template_part( 'framework/includes/post-head' ); } ?>

								</div>
							</div>
					</div>
				</div>

				<?php } else if($mom_post_layout == 'layout4') {
				$img = mom_post_image('full');
				$cover = get_post_meta(get_the_ID(), 'mom_post_cover_image', true);
				if ($cover) {
					$img = $cover;
				}
				?>

					<div class="inner pl4">
					<section class="section">
						<img src="<?php echo mom_post_image(); ?>" class="hide" alt="<?php the_title(); ?>">
						<div class="post-layout4">
							<?php if($PCT != '') { ?><div class="photo-credit"><i class="momizat-icon-camera"></i><?php _e('Photo Credit To ', 'framework'); ?><?php echo $PCT; ?></div><?php } ?>
						    <img src="<?php echo $img; ?>" alt="<?php the_title(); ?>">
							<div class="pl3-shadow">
										<div class="pl2-bottom pl4-content">
											<?php if(mom_option('breadcrumb') != 0) { ?>
						                    <?php if($postbreadcrumb) { ?>
						                    <div class="post-crumbs entry-crumbs">
							<?php if ($cat_icon != '') {
								if (0 === strpos($cat_icon, 'http')) {
									echo '<div class="crumb-icon"><i class="img_icon" style="background-image: url('.$cat_icon.')"></i></div>';
								} else {
									echo '<div class="crumb-icon"><i class="'.$cat_icon.'"></i></div>';
								}
							} ?>
						                <?php mom_breadcrumb(); ?>
						                    </div>
						                    <?php } ?>
						                    <?php } ?>
											<h1 itemprop="headline" class="entry-title"><?php the_title(); ?></h1>
											<?php if (class_exists('WPSubtitle')) { ?><h2 class="mom-sub-title"><?php the_subtitle(); ?></h2><?php } ?>
						                    <?php if(mom_option('post_head')) { get_template_part( 'framework/includes/post-head' ); } ?>

										</div>
							</div>
						</div>
					</section>
					</div>

				<?php } ?>
                <div class="main-container"><!--container-->

                    <?php if($mom_post_layout != 'layout3' && $mom_post_layout != 'layout4') { ?>
                    <?php if(mom_option('breadcrumb') != 0) { ?>
                    <?php if($postbreadcrumb) { ?>
                    <div class="post-crumbs entry-crumbs">
							<?php if ($cat_icon != '') {
								if (0 === strpos($cat_icon, 'http')) {
									echo '<div class="crumb-icon"><i class="img_icon" style="background-image: url('.$cat_icon.')"></i></div>';
								} else {
									echo '<div class="crumb-icon"><i class="'.$cat_icon.'"></i></div>';
								}
							} ?>
                        <?php mom_breadcrumb(); ?>
                    </div>
                    <?php } ?>
                    <?php } } ?>

					<?php if ($layout != 'fullwidth') { ?>
                    <div class="main-left"><!--Main Left-->
                    	<div class="main-content" role="main"><!--Main Content-->
                    <?php } ?>
                            <div class="site-content page-wrap">
                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-id="<?php echo $post->ID; ?>">
                                    <?php if($mom_post_layout != 'layout2' && $mom_post_layout != 'layout3' && $mom_post_layout != 'layout4') { ?>
                                    <header>
                                        <h1 itemprop="headline" class="entry-title"><?php the_title(); ?></h1>
                                        <?php if (class_exists('WPSubtitle')) { ?><h2 class="mom-sub-title"><?php the_subtitle(); ?></h2><?php } ?>
                                        <?php if(mom_option('post_head')) { get_template_part( 'framework/includes/post-head' );} ?>
                                        <?php if(mom_option('post_head')) { get_template_part( 'framework/includes/post-topshare' ); } ?>


                                    </header>
                                    <?php } ?>

                                    <div class="entry-content clearfix">

                                        <?php get_template_part('framework/includes/post-formats'); ?>

                                        <?php if(mom_option('post_fimage')) {

					    				if($mom_post_layout == 'none') {
					    					if( $HFI == 1 && has_post_thumbnail() ) { $has_image = 'has_f_image';} else { $has_image = '';}
					    				} else {
					    					if( $HFI != 1 && has_post_thumbnail() ) { $has_image = 'has_f_image';} else { $has_image = '';}
					    				}
										if($mom_post_layout != 'default') {$has_image = '';}
										if( mom_option('post_feaimage') == 0 ) {$has_image = '';}
									    ?>
                                        <div class="entry-content-data <?php echo $has_image; ?>">
										<?php if($mom_post_layout == 'default') { ?>
                                        <?php if( $HFI != 1 && has_post_thumbnail() ) { ?>
                                        	<?php if ($HFI != 1) {
	                                        if(mom_option('post_feaimage') != 0) {
										    $img_class = '';
										    $pt_zoom_start = '';
										    $pt_zoom_end = '';
										    if ($default_image_click == 'zoom') {
											$img_class = 'pt-zoom';
											$pt_zoom_start = '<a href="'.mom_post_image('full').'" class="lightbox_link">';
											$pt_zoom_end = '</a>';
										    }
                                        	?>

                                        	<?php if ( has_post_thumbnail()) { ?>
                                            <figure class="post-thumbnail <?php echo $img_class; ?>" itemscope="" itemtype="http://schema.org/ImageObject">
											<?php echo $pt_zoom_start; ?>
                                                <?php the_post_thumbnail('big-thumb-hd'); ?>
											<?php echo $pt_zoom_end; ?>
                                                <?php if ($default_image_click != 'zoom') { ?><span class="img-toggle"><i class="<?php if ( is_rtl() ) { ?>momizat-icon-arrow-down-left2<?php } else { ?>momizat-icon-arrow-down-right2<?php }  ?>"></i></span><?php } ?>
                                            </figure>
                                            <?php if($PCT != '') { ?><div class="photo-credit img-pct"><i class="momizat-icon-camera"></i><?php _e('Photo Credit To ', 'framework'); ?><?php echo $PCT; ?></div><?php } ?>
                                            <?php }
	                                             } } }
											} //post layout
											if($mom_post_layout == 'none') {
												if( $HFI == 1 && has_post_thumbnail() ) {
	                                        	if ($HFI == 1) {
		                                        if(mom_option('post_feaimage') != 0) {
											    $img_class = '';
											    $pt_zoom_start = '';
											    $pt_zoom_end = '';
											    if ($default_image_click == 'zoom') {
												$img_class = 'pt-zoom';
												$pt_zoom_start = '<a href="'.mom_post_image('full').'" class="lightbox_link">';
												$pt_zoom_end = '</a>';
											    }
	                                        	?>

	                                        	<?php if ( has_post_thumbnail()) { ?>
	                                            <figure class="post-thumbnail <?php echo $img_class; ?>" itemscope="" itemtype="http://schema.org/ImageObject">
												<?php echo $pt_zoom_start; ?>
	                                                <?php the_post_thumbnail('big-thumb-hd'); ?>
												<?php echo $pt_zoom_end; ?>
	                                                <?php if ($default_image_click != 'zoom') { ?><span class="img-toggle"><i class="<?php if ( is_rtl() ) { ?>momizat-icon-arrow-down-left2<?php } else { ?>momizat-icon-arrow-down-right2<?php }  ?>"></i></span><?php } ?>
	                                            </figure>
	                                            <?php if($PCT != '') { ?><div class="photo-credit img-pct"><i class="momizat-icon-camera"></i><?php _e('Photo Credit To ', 'framework'); ?><?php echo $PCT; ?></div><?php } ?>
	                                            <?php }
		                                             } } }
											}
                                            ?>
                                            <?php if ($SHE != 0) {
	                                            if(mom_option('post_story') != 0) {
                                            ?>
                                            <?php if ($SH != '') { ?>
											<div class="story-highlights">
											    <h4><?php _e('Story Highlights', 'framework'); ?></h4>
											    <ul>
													<?php
													$SH = '<li>'.str_replace(array("\r","\n\n","\n"),array('',"\n","</li>\n<li>"),trim($SH,"\n\r")).'</li>';
													echo $SH;
													?>
											    </ul>
											</div>
										    <?php } } } ?>
                                        </div>
                                        <?php } ?>
					        <?php
						    if (mom_option('post_top_ad') != '' && $disable_ads == 0) {
							echo do_shortcode('[ad id="'.mom_option('post_top_ad').'"]');
							echo do_shortcode('[gap height="20"]');
						    }

						    $format = get_post_format();
						    $chat_top_content = '';
					        $chat_bottom_content = '';
					                if ($format == 'chat') {
					                        global $posts_st;
					                        $extra = get_post_meta(get_the_ID(), $posts_st->get_the_id(), TRUE);
					                        $chat_top_content = isset($extra['chat_post_top_content']) ? $extra['chat_post_top_content'] : '';
					                        $chat_bottom_content = isset($extra['chat_post_bottom_content']) ? $extra['chat_post_bottom_content'] : '';
					                }
						?>
                                        <?php
                                        echo $chat_top_content;
                                        the_content();

                                       echo $chat_bottom_content;
                                        ?>
                                        <?php wp_link_pages( array( 'before' => '<div class="my-paginated-posts">' . __( 'Pages:', 'framework' ), 'after' => '</div>' ) ); ?>
					        <?php
						    if (mom_option('post_bottom_content_ad') != '' && $disable_ads == 0) {

							echo do_shortcode('[gap height="20"]');
							echo do_shortcode('[ad id="'.mom_option('post_bottom_content_ad').'"]');
							echo do_shortcode('[gap height="20"]');
						    }
						?>
                                    <div class="clearfix"></div>
                                    </div>
                                </article>
                                <div class="clear"></div>

                                <?php if($PSC != '') { ?>
                                <div class="post_source">
	                                <p><span><?php _e( 'Post source : ', 'framework'); ?></span><?php echo $PSC; ?></p>
                                </div>

                                <div class="clear"></div>
                                <?php } ?>

                                <?php
                                if(mom_option('post_tags')) {
                                if($PTS != 1) { the_tags( '<div class="entry-tag-links"><span>' . __( 'Tags:', 'framework' ) . '</span>', '', '</div>' ); }
                                }
                                ?>


                                <?php
                                if(mom_option('share_position') == 'bottom' || mom_option('share_position') == 'both') {
                                if(mom_option('post_sharee')) {
                                if ($DPS != 1) { mom_posts_share(get_the_ID(),get_permalink()); }
                                } } else {
                                ?>
                                <div class="mom-share-post-free"></div>
                                <?php } ?>

                                <?php
                                if(mom_option('post_nav')) {
                                if ($DPN != 1) { ?>
                                <div class="post-nav-links">
                                    <div class="post-nav-prev">
                                        <?php previous_post_link( '%link','<span>'. __( 'Previous :', 'framework' ).'</span> %title' ); ?>
                                    </div>
                                    <div class="post-nav-next">
                                        <?php next_post_link( '%link', '<span>'. __( 'Next :', 'framework' ).'</span> %title' ); ?>
                                    </div>
                                </div>
                                <?php
                                	}
                                }
                                ?>

                                <?php
                                if(mom_option('post_author')) {
                                if ($DAB != 1) { get_template_part( 'framework/includes/post-author' ); }
                                }
                                ?>

                                <?php
                                if(mom_option('post_related')) {
                                if ($DRP != 1) { get_template_part( 'framework/includes/post-related' ); }
                                }
                                ?>

                                <?php
                                if(mom_option('post_comments')) {
                                if ($DPC != 1) { comments_template(); }
                                }
                                ?>
                                					        <?php
						    if (mom_option('post_bottom_ad') != '' && $disable_ads == 0) {
							echo do_shortcode('[ad id="'.mom_option('post_bottom_ad').'"]');
							echo do_shortcode('[gap height="20"]');
						    }
						?>

                            </div>

                    <?php if ($layout != 'fullwidth') { ?>
                        </div><!--Main Content-->
                    	<?php
                    	$swstyle = mom_option('swstyle');
				          if( $swstyle == 'style2' ){
				            $swclass = ' sws2';
				          } else {
				            $swclass = '';
				          }
                    	if (strpos($layout,'both') !== false) {
                    	if($cat_ssidebar != '' && $custom_sec_sidebar == ''){ ?>
	                    <aside class="secondary-sidebar<?php echo $swclass; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar"><!--secondary sidebar-->
	                    	<?php dynamic_sidebar($cat_ssidebar); ?>
	                    </aside>
						<?php
						} else {
                    		get_sidebar('left');
                    	}
                    	}
                    	?>
                    </div><!--Main left-->
                    <?php
                    if($cat_msidebar != '' && $custom_main_sidebar == ''){ ?>
                    <aside class="sidebar<?php echo $swclass; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar"><!--sidebar-->
	                    <?php dynamic_sidebar($cat_msidebar); ?>
                    </aside>
                    <?php
                    } else {
                    	get_sidebar();
                    }
                    ?>
                    <?php } ?>
                </div><!--container-->

            </div><!--wrap-->
                                            <?php
								endwhile;
								wp_reset_query();
								?>

<?php get_footer(); ?>
