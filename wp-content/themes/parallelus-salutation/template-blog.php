<?php global $post, $wp_query, $blog_query, $shortcode_values, $theLayout; ?>


<section class="content-post-list">
	<ol class="posts-list hfeed">
	
	<?php 
	if (!$blog_query) $blog_query = $wp_query;
	$blogOptions = ($shortcode_values) ? $shortcode_values : $theLayout['blog'];
	
	while( $blog_query->have_posts() ) : $blog_query->the_post();
	
		// style and layout info
		$postClass = array();
		
		// images enabled?
		if ($blogOptions['blog_featured_images']) {
			
			// class
			$postClass[] = ''; //'style-image-left';
			
			// get thumbnail image
			$thumb = get_post_thumbnail_id(); 
			
			// image sizes
			$imageW = $blogOptions['image']['width'];
			$imageH = $blogOptions['image']['height'];
			
			// crop image (default = true)
			$imageCrop = ( $imageW === 0 || $imageH === 0 ) ? false : true; // Setting to FALSE is useful when setting one value so other adjusts automatically

			// get resized image
			// this will return the resized $thumb or placeholder if enabled and no $thumb
			$image = vt_resize( $thumb, '', $imageW, $imageH, $imageCrop );
			
				// If media field is populated use lightbox for image/video on click
				$popup_link = '';
				if (get_meta('media_url')) {
					$popup_link = '<a href="'. get_meta('media_url') .'" class="popup" title="'. get_meta('media_title') .'">';
				} 
		}
		
		if (!$image['url']) {
			// no imge
			$postClass[] = 'noImage';
		}
		
		?>

		<li class="post-item clearfix">
			<article id="post-<?php the_ID(); ?>" <?php post_class($postClass); ?>>
				<div class="item-container">
				
					<?php if ($image['url']) : ?>
					<div class="the-post-image">
						<?php 
						if ($popup_link) : 
							echo $popup_link; 
						else : ?>
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permalink to %s', THEME_NAME ), the_title_attribute( 'echo=0' ) ); ?>">
						<?php endif; ?>
							<figure>
								<img src="<?php echo $image['url']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
							</figure>
						</a>
					</div>
					<?php endif; ?>
					
					<div class="the-post-content">
						<header class="entry-header">
							
							<?php
							// Author avatar 
							if ($blogOptions['author_avatar']) :
								?>
								<div class="author-avatar">
									<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(  get_the_author_meta('ID'), 35, '', get_the_author_meta('display_name')); ?></a>
								</div>
								<?php
							endif; ?>
							
							<!-- Title / Page Headline -->
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permalink to %s', THEME_NAME ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
							
							<?php if ($blogOptions['author_name'] || $blogOptions['post_date'] || $blogOptions['comments_link'] || $blogOptions['category_list']) : ?>
							<div class="post-header-info clearfix" <?php if ( !$blogOptions['author_avatar'] ) : echo 'style="margin-left: 0;"'; endif; ?>>
								<?php								
								// Author name 
								if ($blogOptions['author_name']) : 
									?>
									<address class="vcard author">
										<?php _e( 'by ', THEME_NAME ) . the_author_posts_link(); ?> 
									</address>
								<?php 
								endif;
								// Comments link
								if ($blogOptions['comments_link']) : 
									// comments link ?>
									<span class="comments-link"><?php comments_popup_link( __( 'Comment', THEME_NAME ), __( '1', THEME_NAME ), __( '%', THEME_NAME ), '', '' ); ?></span>
									<?php 
								endif;
								// Category list 
								if ($blogOptions['category_list']) :
									if ( count( get_the_category() ) ) :
										?>
										<div class="cat-links">
											<?php 
											// seperator
											if ($blogOptions['post_date']) { echo ' <span class="meta-sep">|</span> '; }
											//printf( __( '<span class="%1$s">Posted in</span> %2$s', THEME_NAME ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) );
											echo get_the_category_list( ', ' ); 
											?>
										</div>
										<?php 
									endif; 
								endif;
								// Date Published
								if ($blogOptions['post_date']) : 
									?>
									<abbr class="published" title="<?php the_time('c'); ?>"><span class="entry-date"><?php the_time(get_option('date_format')); ?></span></abbr>
									<?php 
									//if ($blogOptions['comments_link']) { echo ' <span class="meta-sep">|</span> '; }  // seperator
								endif;
								?>
							</div>
							<?php endif; ?>
							
						</header>
						
						<!-- Content -->
						<div class="entry-content">
							<?php
								// Post content/excerpt
								if ($blogOptions['use_excerpt']) {
									if ($blogOptions['excerpt_length'] != '-1')  {
										echo customExcerpt(get_the_excerpt(), $blogOptions['excerpt_length']); 
									}
								} else {
									// set $more to 0 or WP will ignore the <!--more--> tags if not on the home page
									global $more;
									$more = 0;
									the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', THEME_NAME ) );
								}
								// Read more link
								if ($blogOptions['read_more'] && $blogOptions['read_more'] != "-1") {
									$readMore = prep_content($blogOptions['read_more'], 0, 1);
									echo '<div class="read-more"><a href="'. get_permalink() .'" title="'. $readMore .'" class="read-more-link">'. $readMore .'</a></div>';
								}
							?>
						</div><!-- END .entry-content -->
			
						<!-- Post Footer -->
						<footer class="post-footer-info">
							<?php 
							// tag list
							if ($blogOptions['tag_list']) :
								$tags_list = get_the_tag_list( '', ', ' );
								if ( $tags_list ):  ?>
								<div class="tag-links">
									<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', THEME_NAME ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
								</div>
								<?php 
								endif; 
							endif; ?>
						</footer><!-- END .post-footer-info -->
					</div>
		
				</div>
			</article>
		</li>
		
		<?php endwhile; ?>
	
	</ol>
</section>


<?php

// show paging  (< 1 3 4 >)
if ($blogOptions['paging']) get_pagination($blog_query);

?>

