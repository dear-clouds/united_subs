<?php
/**
 * The Template for displaying all single posts from EVENTON
 */

get_header(); ?>

	<?php // Start the Loop.
	while ( have_posts() ) : the_post(); ?>

		<div id="left-content">

			<?php  //GET THEME HEADER CONTENT

			woffice_title(get_the_title()); ?> 	

			<!-- START THE CONTENT CONTAINER -->
			<div id="content-container">

				<!-- START CONTENT -->
				<div id="content">
					
					<div class="box">
						<?php
						if (function_exists('eventon_se_page_content')) :
							eventon_se_page_content();
						else :
							_e("You need the Single Event addon from EventOn shop to have this feature since Woffice 1.7.2.","woffice");
						endif;
						?>
					</div>

				</div>
					
			</div><!-- END #content-container -->
		
			<?php woffice_scroll_top(); ?>

		</div><!-- END #left-content -->
		
	<?php // END THE LOOP 
	endwhile; ?>

<?php 
get_footer();