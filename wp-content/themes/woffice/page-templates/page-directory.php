<?php
/**
* Template Name: Directory
*/

if (function_exists( 'woffice_directory_extension_on' )){

	$directory_create = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('directory_create') : ''; 				
	if (woffice_role_allowed($directory_create)):  
	
		$hasError = woffice_frontend_proccess('directory');
		
	endif;
	
}

get_header(); 
?>

	<?php // Start the Loop.
	while ( have_posts() ) : the_post(); ?>

		<div id="left-content">

			<?php  //GET THEME HEADER CONTENT

			$title = get_the_title();
			woffice_title($title); ?> 	

			<!-- START THE CONTENT CONTAINER -->
			<div id="content-container">

				<!-- START CONTENT -->
				<div id="content">
					
					<?php /* If the directory extension is one we display the items */
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$directory_query = new WP_Query('post_type=directory&paged=' . $paged);
					if ( $directory_query->have_posts() && function_exists('woffice_directory_extension_on')) :
					
						echo '<div id="directory" class="masonry-layout">';
						
						while($directory_query->have_posts()) : $directory_query->the_post();
						
							echo '<div class="box directory-item">';
								/* Featured Image */
								if ( has_post_thumbnail() ) :
                                    woffice_render_featured_image_single_post($post->ID, '', $post->ID);
								endif; 
								/* Content */
								echo '<div class="intern-padding">';
									/* Title */
									echo'<div class="intern-box box-title">
										<h3><a href="'. get_the_permalink() .'">'.get_the_title().'</a></h3>
									</div>';
									/* Excerpt */
									echo '<p>';
										echo woffice_directory_get_excerpt();
									echo '</p>';
									
									/* Categories */
									if( has_term('', 'directory-category')): 
										echo '<span class="directory-category"><i class="fa fa-tag"></i>';
										echo get_the_term_list( $post->ID, 'directory-category', '', ', ' );
										echo '</span>';
									endif;
									
									/* Comments */
									if (get_comment_count(get_the_ID()) > 0){
										echo'<span class="directory-comments"><i class="fa fa-comments-o"></i> ';
											echo'<a href="'. get_the_permalink().'#respond">'. get_comments_number( '0', '1', '%' ) .'</a>';
											echo'</span>';	
									}
								echo '</div>';
								
								/* Meta fields */
								woffice_directory_single_fields('page');
								
							echo '</div>';
					
						endwhile;
								
						wp_reset_postdata();
						
						echo '</div>';
                        woffice_paging_nav($directory_query);
					
					else :
						
						get_template_part( 'content', 'none' );
						
					endif;  ?>
					
					<?php // CHECK IF USER CAN CREATE DIRECTORY ITEM
					$directory_create = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('directory_create') : ''; 
					if (woffice_role_allowed($directory_create)):  ?>
					
						<div class="box">
						
							<div class="center intern-padding" id="directory-bottom">
								<a href="javascript:void(0)" class="btn btn-default" id="show-directory-create"><i class="fa fa-plus-square"></i> <?php _e("Create an item", "woffice"); ?></a>
							</div>
							
							<?php woffice_frontend_render('directory',$hasError); ?>
							
						</div>
						
					<?php endif; ?>
					
				</div>
					
			</div><!-- END #content-container -->
		
			<?php woffice_scroll_top(); ?>

		</div><!-- END #left-content -->

	<?php // END THE LOOP 
	endwhile; ?>

<?php 
get_footer();