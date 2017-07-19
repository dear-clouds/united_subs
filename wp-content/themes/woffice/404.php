<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>

	<div id="left-content">

		<?php  //GET THEME HEADER CONTENT
		$the_title = __( '404 Error. Not found...', 'woffice' );
		woffice_title($the_title); ?> 	

		<!-- START THE CONTENT CONTAINER -->
		<div id="content-container" >

			<!-- START CONTENT -->
			<div id="content">
				<article class="box content">
					<div class="intern-padding">
						<div class="special-404 center">
							<i class="fa fa-meh-o"></i>
						</div>
						<div class="heading">
							<h2>
								<?php // THE TITLE
								_e( 'Nothing Found', 'woffice' );?>
							</h2>
						</div>
					</div>
					<div class="intern-padding">
						<p class="blog-sum-up center">
							<?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'woffice' ); ?>
						</p>

						<div class="blog-button center">
			  				<a href="<?php echo get_home_url(); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> <?php _e('Back on the home page','woffice'); ?></a>
			  			</div>
					</div>
				</article>
			</div>
				
		</div><!-- END #content-container -->

		<?php woffice_scroll_top(); ?>
		
	</div><!-- END #left-content -->
	
<?php 
get_footer();