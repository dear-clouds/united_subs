<?php
/**
 * Template Name: Full Calendar Template
 *
 * Description: Use this page template to show calendar from WP FullCalendar.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 2.0.4
 */
get_header(); ?>

<div class="page-full-width">

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

</div><!-- .page-full-width -->
<?php get_footer(); ?>