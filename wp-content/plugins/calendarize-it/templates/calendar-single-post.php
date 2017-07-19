<?php
/**
 * This is used when rendering a singe item in the view detail view.
 */
?>
				<?php while ( have_posts() ) : the_post(); ?>

<div id="fc-post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="fc-entry-header">
		<h1 class="fc-entry-title"><?php the_title(); ?></h1>
	</div><!-- .entry-header -->

	<div class="fc-entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>
	<div class="fc-entry-meta">
		<?php edit_post_link( __( 'Edit', 'rhc' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
</div><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; // end of the loop. ?>
			