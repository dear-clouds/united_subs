<?php
/**
* Archive page for the directory
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
				
				<?php /* If the directory extension is one we display the items */
				if(function_exists('woffice_directory_extension_on')){
					
					if ( have_posts() ) : 
					
						echo '<div id="directory" class="masonry-layout">';
						
						while(have_posts()) : the_post();
						
							echo '<div class="box directory-item">';
								/* Featured Image */
								if ( has_post_thumbnail() ) : 
                                    woffice_render_featured_image_single_post($post->ID, '', true);
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
                        woffice_paging_nav();
					endif; 
					
				} else {
					
					get_template_part( 'content', 'none' );
					
				} ?>
				
			</div>
				
		</div><!-- END #content-container -->
	
		<?php woffice_scroll_top(); ?>

	</div><!-- END #left-content -->

<?php 
get_footer();
