<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in BuddyBoss consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
get_header();
?>

<!-- Frontpage Slider -->
<?php get_template_part( 'content', 'slides' ); ?>

<?php do_action('boss_custom_slider'); ?>

<?php if ( is_active_sidebar( 'home-right' ) ) : ?>
	<div class="page-right-sidebar">
	<?php else : ?>
		<div class="page-full-width">
		<?php endif; ?>

		<div id="primary" class="site-content">

			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php if ( is_home() ): ?>
						<?php get_template_part( 'content' ); ?>
					<?php else: ?>
						<?php get_template_part( 'content', 'page' ); ?>
					<?php endif; ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

                <div class="pagination-below">
					<?php buddyboss_pagination(); ?>
                </div>

			</div><!-- #content -->
		</div><!-- #primary -->

		<?php
		if ( is_active_sidebar( 'home-right' ) ) :
			get_sidebar( 'home-right' );
		endif;
		?>

	</div><!-- .page-left-sidebar -->

	<?php get_footer(); ?>