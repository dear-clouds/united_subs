<?php global $post, $gp_settings, $dirname; ?>


<!-- BEGIN CONTENT -->

<div id="content">
	
	
	<?php if (have_posts()) : while (have_posts()) : the_post();
	
	
	// Image Dimensions
	
	if(get_post_meta(get_the_ID(), 'ghostpool_thumbnail_width', true)) {
		$thumbnail_width = get_post_meta(get_the_ID(), 'ghostpool_thumbnail_width', true);
	} else {
		$thumbnail_width = $gp_settings['thumbnail_width'];
	}
	if(get_post_meta(get_the_ID(), 'ghostpool_thumbnail_height', true)) {
		$thumbnail_height = get_post_meta(get_the_ID(), 'ghostpool_thumbnail_height', true);
	} else {
		$thumbnail_height = $gp_settings['thumbnail_height'];
	}
	
	?>
	
	
		<!-- BEGIN POST -->
	
		<div <?php post_class('post-loop '.$gp_settings['preload']); ?>>
		
			
			<!-- BEGIN FEATURED IMAGE -->
			
			<?php if(has_post_thumbnail()) { ?>				
				<div class="post-thumbnail<?php if($gp_settings['image_wrap'] == "Enable") { ?> wrap<?php } ?>">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())), $thumbnail_width, $thumbnail_height, $gp_settings['hard_crop'], false, true); ?>
						<?php if(get_option($dirname.'_retina') == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())), $thumbnail_width*2, $thumbnail_height*2, $gp_settings['hard_crop'], true, true); } else { $retina = ""; } ?>
						<img src="<?php echo $image[0]; ?>" data-rel="<?php echo $retina; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { the_title_attribute(); } ?>" class="wp-post-image" />	
					</a>				
				</div><?php if($gp_settings['image_wrap'] == "Disable") { ?><div class="clear"></div><?php } ?>
			<?php } ?>
		
			<!-- END FEATURED IMAGE -->
			
			
			<!-- BEGIN POST TEXT -->
			
			<div class="post-text">
			
			
				<!-- BEGIN TITLE -->

				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

				<!-- END TITLE -->		

				
				<!-- BEGIN POST META -->
				
				<?php if($gp_settings['meta_date'] == "0" OR $gp_settings['meta_author'] == "0" OR $gp_settings['meta_cats'] == "0" OR $gp_settings['meta_comments'] == "0") { ?>
					
					<div class="post-meta">
						
						<?php if($gp_settings['meta_author'] == "0") { ?><span class="author-icon"><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_meta('display_name', $post->post_author); ?></a></span><?php } ?>
						
						<?php if($gp_settings['meta_date'] == "0") { ?><span class="clock-icon"><?php the_time(get_option('date_format')); ?></span><?php } ?>
						
						<?php if($gp_settings['meta_cats'] == "0" && $post->post_type == "post") { ?><span class="folder-icon"><?php the_category(', '); ?></span><?php } ?>
						
						<?php if($gp_settings['meta_comments'] == "0" && 'open' == $post->comment_status) { ?><span class="speech-icon"><?php comments_popup_link(__('0', 'gp_lang'), __('1', 'gp_lang'), __('%', 'gp_lang'), 'comments-link', ''); ?></span><?php } ?>
					
					</div>
					
				<?php } ?>
				
				<!-- END POST META -->
				
				
				<!-- BEGIN POST CONTENT -->

				<?php if($gp_settings['content_display'] == "1") { ?>	
				
					<?php the_content(__('Read More &raquo;', 'gp_lang')); ?>
					
				<?php } else { ?>
				
					<?php if($gp_settings['excerpt_length'] != "0") { ?><p><?php echo gp_excerpt($gp_settings['excerpt_length']); ?><?php if($gp_settings['read_more'] == "0") { ?> <a href="<?php the_permalink(); ?>" class="read-more" title="<?php the_title_attribute(); ?>"><?php _e('Read More &raquo;', 'gp_lang'); ?></a><?php } ?></p><?php } ?>
					
				<?php } ?>
				
				<!-- END POST CONTENT -->
				
				
				<!-- BEGIN POST TAGS -->
				
				<?php if($gp_settings['meta_tags'] == "0") { ?><?php the_tags('<div class="post-meta post-tags"><span class="tag-icon">', ', ', '</span></div>'); ?><?php } ?>
				
				<!-- END POST TAGS -->
				
				
			</div>
			
			<!-- END POST TEXT -->
			

		</div>
		
		<!-- END POST -->
		
		
	<?php endwhile; ?>
		
		
		<?php gp_pagination(); ?>


	<?php else : ?>	
	

		<h4><?php _e('Try searching again using the search form below.', 'gp_lang'); ?></h4>
	
		<div class="sc-divider"></div>
		
		<h3><?php _e('Search The Site', 'gp_lang'); ?></h3>
		<?php get_search_form(); ?>	
		
	
	<?php endif; ?>	


</div>

<!-- END CONTENT -->

	
<?php get_sidebar(); ?>