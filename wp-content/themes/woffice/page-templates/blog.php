<?php
/**
* Template Name: Blog
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
		woffice_title(get_the_title()); ?> 	

		<!-- START THE CONTENT CONTAINER -->
		<div id="content-container">

			<!-- START CONTENT -->
			<div id="content">
				
				<?php // We check for the layout 
				$blog_layout = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('blog_layout') : ''; 
				echo ($blog_layout == "masonry") ? '<div id="directory" class="masonry-layout">' : ''; ?>
				
					<?php 
					// THE LOOP :
                    $posts_per_page = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('blog_number') : '';
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$blog_query = new WP_Query('post_type=post&paged=' . $paged . '&posts_per_page='.$posts_per_page);
					if ( $blog_query->have_posts() ) :	?>
						<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
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
				<?php woffice_paging_nav($blog_query); ?>
				
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