<?php
/**
* Template Name: Projects
*/
	
if (function_exists( 'woffice_projects_extension_on' )){

	$projects_create = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_create') : ''; 				
	if (woffice_role_allowed($projects_create)):  
	
		$hasError = woffice_frontend_proccess('project');
		
	endif;
	
}

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
					<?php if (woffice_is_user_allowed()) { ?>
						<?php 
						// CUSTOM CLASSES ADDED BY THE THEME
						$post_classes = array('box','content');
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
							<div id="projects-page-content">
								<div class="intern-padding">
									<?php 
									// THE PAGE CONTENT
									the_content();
									//DISABLED IN THIS THEME
									wp_link_pages(array('echo'  => 0));
									//EDIT LINK
									edit_post_link( __( 'Edit', 'woffice' ), '<span class="edit-link">', '</span>' );
									?>	
								</div>
								
								<!-- LOOP ALL THE PROJECTS-->
								<?php // GET POSTS
								if (function_exists( 'woffice_projects_extension_on' )){
									
									// Thee project filter
									woffice_projects_filter();

                                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
									$project_query = new WP_Query('post_type=project&paged=' . $paged);
									if ( $project_query->have_posts() ) :
										echo'<ul id="projects-list">';
										// LOOP
										while($project_query->have_posts()) : $project_query->the_post(); 
										
											if (woffice_is_user_allowed_projects()) : 
											
												echo '<li class="intern-padding">'; 
												
													// THE TITLE + INFOS
													echo '<a href="'. get_the_permalink() .'" rel="bookmark" class="project-head">';
														// TITLE
														echo'<h2><i class="fa fa-cubes"></i> '. get_the_title() .'</h2>';
														// COMMENTS
														if (get_comment_count(get_the_ID()) > 0):
															echo '<span class="project-comments"><i class="fa fa-comments-o"></i> '.get_comments_number( '0', '1', '%' ).'</span>';
														endif;
														// CATEGORY
														if( has_term('', 'project-category')): 
															echo '<span class="project-category"><i class="fa fa-tag"></i>';
															echo wp_strip_all_tags(get_the_term_list( $post->ID, 'project-category', '', ', ' ));
															echo '</span>';
														endif;
														// MEMBERS
														$project_members = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_the_ID(), 'project_members') : '';
														echo '<span class="project-members"><i class="fa fa-users"></i> '.count($project_members).'</span>';
													echo'</a>';
													// THE PROGRESS BAR
													echo woffice_project_progressbar();
													// EXCERPT
													echo '<p class="project-excerpt">'. get_the_excerpt() .'</p>';
													// LINK READ MORE
													echo '<div class="text-right">';
														echo '<a href="'.get_the_permalink().'" class="btn btn-default">';
															echo __("See Project","woffice").' <i class="fa fa-arrow-right"></i>';
														echo'</a>';
													echo '</div>';
												echo '</li>';
											endif;
										endwhile;
										echo '</ul>';
                                        woffice_paging_nav($project_query);
									else : 
										get_template_part( 'content', 'none' );
									endif; 
									wp_reset_postdata();
										
										
									// CHECK IF USER CAN CREATE PROJECT POST
									$projects_create = ( function_exists( 'fw_get_db_settings_option' ) ) ? fw_get_db_settings_option('projects_create') : ''; 
									if (woffice_role_allowed($projects_create)): ?>
											
										<div class="center intern-padding" id="projects-bottom">
											<a href="javascript:void(0)" class="btn btn-default" id="show-project-create"><i class="fa fa-plus-square"></i> <?php _e("Create a project", "woffice"); ?></a>
										</div>
										
										<?php woffice_frontend_render('project',$hasError); ?>
										
									<?php endif; 
								 }?>
							</div>
							
						</article>
					<?php
					} else { 
						get_template_part( 'content', 'private' );
					}
					?>
				</div>
					
			</div><!-- END #content-container -->
		
			<?php woffice_scroll_top(); ?>

		</div><!-- END #left-content -->

	<?php // END THE LOOP 
	endwhile; ?>

<?php 
get_footer();



