<?php global $theLayout;

if (have_posts()) : 
	while (have_posts()) : the_post();	
		
	$blogOptions = $theLayout['blog'];

	// style and layout info
	$postClass = array();

	// images enabled?
	if ($theLayout['blog']['post_featured_images']) {
		
		// class
		//$postClass[] = 'style-image-left';
			
		// get thumbnail image
		$thumb = get_post_thumbnail_id(); 
		
		// image sizes
		$imageW = $theLayout['blog']['image']['width'];
		$imageH = $theLayout['blog']['image']['height'];
		
		// get resized image
		// this will return the resized $thumb or placeholder if enabled and no $thumb
		$image = vt_resize( $thumb, '', $imageW, $imageH, true );
	
	}
	
	if (!isset($image['url'])) {
		// no imge
		$postClass[] = 'noImage';
	}


	?>
	<div class="content-post-single">
	
		<article id="post-<?php the_ID(); ?>" <?php post_class($postClass); ?>>
			<div class="the-post-container">
						
				<?php if (isset($image['url']) && $image['url']) : ?>
					<!-- Page "featured" image -->
					<div class="the-post-image">
						<figure>
							<img src="<?php echo $image['url']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
						</figure>
					</div>
				<?php endif; ?>

				<header class="entry-header">
					
					<?php if (!get_meta('hide_title')) : ?>
					<!-- Title / Page Headline -->
					<h1 class="entry-title" title="<?php echo the_title_attribute('echo=0'); ?>"><?php the_title(); ?></h1>
					<?php endif; ?>
					
					<?php if ($blogOptions['author_name'] || $blogOptions['post_date'] || $blogOptions['comments_link']) : ?>
					<div class="post-header-info">
						<?php 
						if ($blogOptions['author_name']) : 
							// author name ?>
							<address class="vcard author">
								<?php _e( 'Posted by ', THEME_NAME ) . the_author_posts_link(); ?> 
							</address>
							<?php 
							// seperator
							if ($blogOptions['post_date'] || $blogOptions['comments_link']) { echo ' <span class="meta-sep"> | </span> '; }
						endif;
						if ($blogOptions['post_date']) : 
							// date published ?>
							<abbr class="published" title="<?php the_time('c'); ?>"><span class="entry-date"><?php the_time(get_option('date_format')); ?></span></abbr>
							<?php 
							// seperator
							//if ($blogOptions['comments_link']) { echo ' <span class="meta-sep"> | </span> '; }
						endif;
						/*if ($blogOptions['comments_link']) : 
							// comments link ?>
							<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', THEME_NAME ), __( '1 Comment', THEME_NAME ), __( '% Comments', THEME_NAME ), '', '' ); ?></span>
							<?php 
						endif; */ ?>
					</div>
					<?php endif; ?>
					
				</header>

				<!-- Page Text and Main Content -->
				<div class="entry-content clearfix">
					<?php the_content(); ?>
				</div><!-- END entry-content -->
	
				<!-- Post Footer -->
				<footer class="post-footer-info">
					<?php 
					// category list 
					if ($blogOptions['category_list']) :
						if ( count( get_the_category() ) ) : ?>
						<div class="cat-links">
							<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', THEME_NAME ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
						</div>
						<?php 
						endif; 
					endif;
					// tag list
					if ($blogOptions['tag_list']) :
						$tags_list = get_the_tag_list( '', ', ' );
						if ( $tags_list ):  ?>
						<div class="tag-links">
							<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', THEME_NAME ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
						</div>
						<?php 
						endif; 
					endif; 
					?>
				</footer><!-- END .post-footer-info -->
				
				<?php 
				// Multi-page content <!--nextpage--> ?>
				<div class="nextPageLinks"> <?php wp_link_pages('before=<p><span class="nextPageTitle">'. __( 'Pages:', THEME_NAME ) .' </span>&after=</p>'); ?> </div>
					
				<?php
				// Comment form
				comments_template('', true); ?>
	
			</div>
		</article>
		
		<?php edit_post_link('Edit','<p class="postEdit">','</p>'); ?>
	
	</div>

	<?php 
	endwhile; 
endif; ?>
