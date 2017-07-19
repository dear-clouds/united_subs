<?php
/*
Template Name: Contact Form
*/
?>

<?php get_header(); ?>


	<div id="content">

	<div class="page-title"><?php the_title(); ?></div>

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry">

						<?php the_content( __('Read more','OneCommunity') ); ?>

					</div>

				</div>

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ); ?>

	</div><!-- #content -->

<div id="sidebar">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-contact')) : ?><?php endif; ?>
</div><!--sidebar ends-->

<div class="clear"></div>

<?php comments_template(); ?>

<?php get_footer(); ?>
