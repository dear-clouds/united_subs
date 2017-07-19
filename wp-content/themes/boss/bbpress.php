<?php
/**
 * The template for displaying bbPress content.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */

get_header(); ?>

	<!-- if widgets are loaded in the Forums sidebar, display it -->	
	<?php if ( is_active_sidebar('forums') ) : ?>		
		<div class="page-right-sidebar">

	<!-- if not, hide the sidebar -->
	<?php else: ?>
		<div class="page-full-width">
	<?php endif; ?>


			<!-- bbPress template content -->
			<div id="primary" class="site-content">
			
				<div id="content" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                <header class="forum-header page-header">
                                    <h1 class="entry-title main-title"><?php the_title(); ?></h1>
                                </header><!-- .page-header -->

                                <div class="entry-content">
                                    <?php the_content(); ?>
                                    <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'boss' ), 'after' => '</div>' ) ); ?>
                                </div><!-- .entry-content -->

                                <footer class="entry-meta">
                                    <?php edit_post_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>
                                </footer><!-- .entry-meta -->

                            </article><!-- #post -->
						<?php comments_template( '', true ); ?>
					<?php endwhile; // end of the loop. ?>

				</div><!-- #content -->
			</div><!-- #primary -->

			<?php get_sidebar('bbpress'); ?>


		</div><!-- closing div -->

<?php get_footer(); ?>
