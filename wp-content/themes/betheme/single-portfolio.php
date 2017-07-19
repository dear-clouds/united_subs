<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();

$class = '';
if( get_post_meta( get_the_ID(), 'mfn-post-template', true ) == 'builder' ) $class .= 'no-padding';
?>

<!-- #Content -->
<div id="Content" class="<?php echo $class; ?>">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

			<?php 
			
				if( get_post_meta( get_the_ID(), 'mfn-post-template', true ) == 'builder' ){
					
					// Template | Builder -----------------------------------------------

					// prev & next post navigation
					if( mfn_opts_get( 'prev-next-nav' ) ){
						
						mfn_post_navigation_sort();
						
						$in_same_term = ( mfn_opts_get( 'prev-next-nav' ) == 'same-category' ) ? true : false;
						$post_prev = get_adjacent_post( $in_same_term, '', true, 'portfolio-types' );
						$post_next = get_adjacent_post( $in_same_term, '', false, 'portfolio-types' );
						
						echo mfn_post_navigation( $post_prev, 'prev', 'icon-left-open-big' );
						echo mfn_post_navigation( $post_next, 'next', 'icon-right-open-big' );
					}
					
					
					while ( have_posts() ){
						the_post();							// Post Loop
						mfn_builder_print( get_the_ID() );	// Content Builder & WordPress Editor Content
					}
					
				} else {
					
					// Template | Default -----------------------------------------------
					
					while ( have_posts() ){
						the_post();
						get_template_part( 'includes/content', 'single-portfolio' );
					}
					
					if( mfn_opts_get('portfolio-comments') ){
						echo '<div class="section section-page-comments">';
							echo '<div class="section_wrapper clearfix">';
						
								echo '<div class="column one comments">';
									comments_template( '', true );
								echo '</div>';
								
							echo '</div>';
						echo '</div>';
					}
					
				}

			?>
			
		</div>
		
		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>
			
	</div>
</div>

<?php get_footer();

// Omit Closing PHP Tags