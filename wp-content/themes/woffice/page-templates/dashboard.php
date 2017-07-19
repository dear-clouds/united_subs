<?php
/**
 * Template Name: Dashboard
 */

get_header(); 
?>

	<?php // Start the Loop.
	while ( have_posts() ) : the_post(); ?>

		<div id="left-content">

			<?php  //GET THEME HEADER CONTENT
			woffice_title(get_the_title()); ?> 	

			<!-- START THE CONTENT CONTAINER -->
			<div id="content-container">

				<!-- START CONTENT -->
				<div id="content">
					<?php if ( is_active_sidebar( 'dashboard' ) && woffice_is_user_allowed() ) : ?>
						<!--
						<div id="dashboard-loader-container" class="box">
							<div class="intern-padding">
								<div id="dashboard-loader" class="woffice-loader">
									<i class="fa fa-spinner"></i>
								</div>
							</div>
						</div>-->
						
						<div id="dashboard">
							<?php // LOAD THE WIDGETS
							dynamic_sidebar( 'dashboard' ); ?>
						</div>
						
					<?php else: ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>
					
			</div><!-- END #content-container -->
		
			<?php woffice_scroll_top(); ?>

		</div><!-- END #left-content -->

	<?php // END THE LOOP 
	endwhile; ?>

<?php 
get_footer();


