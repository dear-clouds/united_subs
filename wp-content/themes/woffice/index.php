<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 */
 

// CHECK IF USER CAN CREATE BLOG POST
$post_create = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('post_create') : ''; 
if (woffice_role_allowed($post_create)):  
	
	$hasError = woffice_frontend_proccess('post');
	
endif;
 
get_header(); 
?>

	<div id="left-content">

		<?php  //GET THEME HEADER CONTENT
		$title = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('index_title') : ''; 
		woffice_title($title); ?> 	

		<!-- START THE CONTENT CONTAINER -->
		<div id="content-container">

			<!-- START CONTENT -->
			<div id="content">
				
				<?php // We check for the layout 
				$blog_layout = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('blog_layout') : '';
				echo ($blog_layout == "masonry") ? '<div id="directory" class="masonry-layout">' : ''; ?>
				
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php // We check for the role : 
							if (woffice_is_user_allowed()) { ?>
								<?php if (($blog_layout == "masonry")) {
									get_template_part( 'content-masonry' );
								} 
								else {
									get_template_part( 'content' );
								} ?>
							<?php } ?>
						<?php endwhile; ?>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
					
				<?php echo ($blog_layout == "masonry") ? '</div>' : ''; ?>

				<!-- THE NAVIGATION --> 
				<?php woffice_paging_nav(); ?>
				
				<?php
				/*
				 * FRONT END CREATION
				 */ 
				// CHECK IF USER CAN CREATE BLOG POST
				$post_create = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('post_create') : ''; 
				if (woffice_role_allowed($post_create)): ?>
					
					<div class="box">
						<div class="intern-padding">
					
							<div class="center" id="blog-bottom">
							
								<?php echo'<a href="javascript:void(0)" class="btn btn-default" id="show-blog-create"><i class="fa fa-plus-square"></i> '. __("New Blog Article", "woffice") .'</a>'; ?>
								
							</div>
							
							<?php woffice_frontend_render('post',$hasError); ?>
														
						</div>
					</div>
				
				<?php endif; ?>
			</div>
				
		</div><!-- END #content-container -->

		<?php woffice_scroll_top(); ?>
		
	</div><!-- END #left-content -->

<?php 
get_footer(); 