<?php get_header(); global $gp_settings, $dirname; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<!-- END CONTENT -->

	<div id="content">

		
		<!-- BEGIN FEATURED IMAGE -->
		
		<?php if(has_post_thumbnail() && $gp_settings['show_image'] == "Show") { ?>
		
			<div class="post-thumbnail<?php if($gp_settings['image_wrap'] == "Enable") { ?> wrap<?php } ?>">
				<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $gp_settings['image_width'], $gp_settings['image_height'], $gp_settings['hard_crop'], false, true); ?>
				<?php if(get_option($dirname.'_retina') == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $gp_settings['image_width']*2, $gp_settings['image_height']*2, $gp_settings['hard_crop'], true, true); } else { $retina = ""; } ?>
				<img src="<?php echo $image[0]; ?>" data-rel="<?php echo $retina; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { the_title_attribute(); } ?>" class="wp-post-image" />
			</div><?php if($gp_settings['image_wrap'] == "Disable") { ?><div class="clear"></div><?php } ?>
		<?php } ?>
		
		<!-- END FEATURED IMAGE -->
		
		
		<!--BEGIN POST CONTENT -->
		
		<div id="post-content">
			
			<?php the_content(__('Read More &raquo;', 'gp_lang')); ?>
			
		</div>
		
		<!-- END POST CONTENT -->
		
		
		<!-- BEGIN POST NAV -->
		
		<?php wp_link_pages('before=<div class="clear"></div><div class="wp-pagenavi post-navi">&pagelink=<span>%</span>&after=</div><div class="clear"></div>'); ?>		

		<!-- END POST NAV -->


		<!-- BEGIN POST TAGS -->

		<?php if( isset( $gp_settings['meta_tags'] ) && $gp_settings['meta_tags'] == "0") { ?><?php the_tags('<div class="post-meta post-tags"><span class="tag-icon">', ', ', '</span></div>'); ?><?php } ?>
		
		<!-- END POST TAGS -->
		
		
		<!-- BEGIN AUTHOR INFO PANEL -->
		
		<?php if( isset( $gp_settings['author_info'] ) && $gp_settings['author_info'] == "0") { ?><?php echo do_shortcode('[author]'); ?><?php } ?>
		
		<!-- END AUTHOR INFO PANEL -->
		
		
		<!-- BEGIN RELATED ITEMS -->
		
		<?php if( isset( $gp_settings['related_items'] ) && $gp_settings['related_items'] == "0") { ?>				
			<?php echo do_shortcode('[related_posts id="" cats="" images="true" image_width="'.$theme_post_related_image_width.'" image_height="'.$theme_post_related_image_height.'" image_wrap="false" cols="3" per_page="3" link="both" orderby="rand" order="desc" offset="" content_display="excerpt" excerpt_length="0" title="true" title_size="" meta="false" read_more="false" pagination="false" preload="false"]'); ?>			
		<?php } ?>	
		
		<!-- END RELATED ITEMS -->
						
		
		<!-- END CONTENT -->
		
		
		<!-- BEGIN COMMENTS -->
		
		<?php comments_template(); ?>
		
		<!-- END COMMENTS -->
		
	
	</div>
	
	<!-- END CONTENT -->
	
	
	<?php get_sidebar(); ?>
	

<?php endwhile; endif; ?>


<?php get_footer(); ?>