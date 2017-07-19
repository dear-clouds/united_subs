<?php
/**
* Archive page for the project
*/
get_header(); 
?>

	<div id="left-content">

		<?php  //GET THEME HEADER CONTENT
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$title =  $term->name . __(' Archives','woffice'); 
		woffice_title($title); ?> 

		<!-- START THE CONTENT CONTAINER -->
		<div id="content-container">

			<!-- START CONTENT -->
			<div id="content">
				
				<?php 
				// CUSTOM CLASSES ADDED BY THE THEME
				$post_classes = array('box','content');
				?>
				<article <?php post_class($post_classes); ?>>
				
					<?php /* If the directory extension is one we display the items */
					if(function_exists('woffice_projects_extension_on')){
						
						// Thee project filter
						woffice_projects_filter();
						
						if ( have_posts() ) : 
						
							echo'<ul id="projects-list">';
							
							while(have_posts()) : the_post();
							
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
									
							wp_reset_postdata();
							
							echo '</ul>';
                            woffice_paging_nav();
						endif; 
						
					} else {
						
						get_template_part( 'content', 'none' );
						
					} ?>
					
				</article>
				
			</div>
				
		</div><!-- END #content-container -->
	
		<?php woffice_scroll_top(); ?>

	</div><!-- END #left-content -->

<?php 
get_footer();
