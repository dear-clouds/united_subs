<?php get_header(); ?>

	<div id="content" class="bbpress-page">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="page-title"><?php the_title(); ?></div>

				<?php the_content(); ?>

		<?php endwhile; endif; ?>

	</div><!-- #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>