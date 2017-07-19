<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- Single blog post -->
	<?php if ( is_single() ) : ?>
		<!-- Title -->
		<header class="entry-header">

			<h1 class="entry-title"><?php the_title(); ?></h1>

		</header><!-- .entry-header -->

	<?php endif; // is_single() ?>

	<!-- Search, Blog index, archives -->
	<?php if ( is_search() || is_archive() || is_home() ) : // Only display Excerpts for Search, Blog index, and archives ?>

		<?php if ( has_post_thumbnail() ) : ?>
			<a class="entry-post-thumbnail" href="<?php the_permalink(); ?>">
				<?php
				$thumb	 = get_post_thumbnail_id();
				$image	 = buddyboss_resize( $thumb, '', 2.5, null, null, true );
				?>
				<img src="<?php echo $image[ 'url' ]; ?>" alt="<?php the_title(); ?>"/>

			</a>
		<?php else : ?>
			<div class="whitespace"></div>
		<?php endif; ?>

		<div class="post-wrap">

			<header>
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'boss' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1>
			</header><!-- .entry-header -->

			<div class="entry-meta mobile">
				<?php buddyboss_entry_meta( false ); ?>
			</div>

			<div class="entry-content entry-summary <?php if ( has_post_thumbnail() ) : ?>entry-summary-thumbnail<?php endif; ?>">

				<?php
						//entry-content
						if ( 'excerpt' === boss_get_option( 'boss_entry_content' ) ):
				            the_excerpt();
						else:
				            the_content();
				        endif;
				?>

				<footer class="entry-meta table">

					<div class="table-cell desktop">
						<?php buddyboss_entry_meta(); ?>
					</div>

					<div class="mobile">
						<?php buddyboss_entry_meta( true, false, false ); ?>
					</div>

					<span class="entry-actions table-cell mobile">
						<?php if ( comments_open() ) : ?>
							<?php comments_popup_link( '', '', '', 'reply', '' ); ?>
						<?php endif; // comments_open() ?>
					</span><!-- .entry-actions -->

				</footer><!-- .entry-meta -->

			</div><!-- .entry-content -->

		</div><!-- .post-wrap -->

		<!-- all other templates -->
	<?php else : ?>

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'boss' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'boss' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php edit_post_link( __( 'Edit', 'boss' ), '<span class="edit-link">', '</span>' ); ?>

	<?php endif; ?>


</article><!-- #post -->
