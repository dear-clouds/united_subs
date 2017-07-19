<?php
/**
 * The template for displaying Search Results pages
 */
get_header(); 
?>

	<div id="left-content">
		<?php  //GET THEME HEADER CONTENT
		$title = sprintf( __( 'Search Results for: %s', 'woffice' ), get_search_query() );
		woffice_title($title); ?> 	

		<!-- START THE CONTENT CONTAINER -->
		<div id="content-container">

			<!-- START CONTENT -->
			<div id="content">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content' ); ?>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>

				<!-- THE NAVIGATION --> 
				<?php woffice_paging_nav(); ?>
			</div>
				
		</div><!-- END #content-container -->
		
		<?php woffice_scroll_top(); ?>

	</div><!-- END #left-content -->

<?php 
get_footer();