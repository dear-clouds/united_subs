<?php get_header(); ?>


<!-- BEGIN CONTENT -->

<div id="content">

	
	<!-- BEGIN IMAGE -->
	
	<?php the_attachment_link( get_the_ID(), true ) ?>
	
	<!-- END IMAGE -->
	
	
	<!-- BEGIN POST CONTENT -->
	
	<div id="post-content">
	
		<?php the_content(); ?>
		
	</div>

	<!-- BEGIN END CONTENT -->

	
	<!-- BEGIN POST NAV -->
	
	<?php wp_link_pages('before=<div class="clear"></div><div class="wp-pagenavi post-navi">&pagelink=<span>%</span>&after=</div>'); ?>		

	<!-- END POST NAV -->

		
</div>

<!-- END CONTENT -->


<?php get_footer(); ?>