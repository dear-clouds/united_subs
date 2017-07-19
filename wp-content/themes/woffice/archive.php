<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 */
get_header(); 
?>

	<div id="left-content">

		<?php  //GET THEME HEADER CONTENT
		if ( is_day() ) :
			$title = sprintf( __( 'Daily Archives: <span>%s</span>', 'woffice' ), get_the_date() );
		elseif ( is_month() ) :
			$title = sprintf( __( 'Monthly Archives: <span>%s</span>', 'woffice' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'woffice' ) ) );
		elseif ( is_year() ) :
			$title = sprintf( __( 'Yearly Archives: <span>%s</span>', 'woffice' ), get_the_date( _x( 'Y', 'yearly archives date format', 'woffice' ) ) );
		elseif ( is_tax() ) :
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$title =  $term->name . __(' Archives','woffice'); 		
		elseif (is_post_type_archive('wiki')) :
			$title = __( 'Wiki Articles', 'woffice' );
		elseif (is_post_type_archive('project')) :
			$title = __( 'Projects', 'woffice' );
		else :
			$title = __( 'Archives', 'woffice' );
		endif;
		woffice_title($title); ?> 	

		<!-- START THE CONTENT CONTAINER -->
		<div id="content-container">

			<!-- START CONTENT -->
			<div id="content">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php // We check for the role : 
						if (woffice_is_user_allowed()) { ?>
							<?php get_template_part( 'content' ); ?>
						<?php } ?>
						
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>

				<!-- THE NAVIGATION --> 
				<?php woffice_paging_nav(); ?>
			</div>
				
		</div><!-- END #content-container -->
		
		<?php woffice_scroll_top(); ?>

	</div><!-- END #left-content -->

<?php 
get_footer();
