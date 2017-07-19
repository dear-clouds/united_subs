<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */

get_header(); ?>

<?php if ( is_active_sidebar('learndash-lesson') ) : ?>
	<div class="page-right-learndash">
<?php else : ?>
	<div class="page-full-width">
<?php endif; ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<!--
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
-->

                    <div class="entry-content">
                        <?php the_content(); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'boss-learndash' ), 'after' => '</div>' ) ); ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-meta">
                        <?php edit_post_link( __( 'Edit', 'boss-learndash' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer><!-- .entry-meta -->
                </article><!-- #post -->
				<?php comments_template( '', true ); ?>
            <?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php if ( is_active_sidebar('learndash-lesson') ) : 
    global $boss_learndash;
    $boss_learndash->boss_edu_load_template('sidebar-learndash-lesson'); 
endif; ?>
</div>
<?php get_footer(); ?>
