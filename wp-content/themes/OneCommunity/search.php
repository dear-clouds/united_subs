<?php get_header(); ?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_blog_search' ); ?>

		<div class="page" id="blog-search" role="main">

			<?php if (have_posts()) : ?>


				<?php bp_dtheme_content_nav( 'nav-above' ); ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ); ?>

<div class="blog-post">

<div class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Fixed link <?php the_title_attribute(); ?>"><?php the_title(); ?></a></div><!--post-title-->

<?php
if ( has_post_thumbnail() ) { ?>
	<div class="thumbnail">
		<?php the_post_thumbnail('full'); ?>
	</div>
<?php } else {
	// no thumbnail
}
?>

<div class="text">

<?php
global $more;
$more = 0;
the_content( __('Read more','OneCommunity') );
?>

</div><!--text-->

</div><!--blog-post-->
<div class="clear"> </div>

					<?php do_action( 'bp_after_blog_post' ); ?>

				<?php endwhile; ?>

				<?php bp_dtheme_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'No posts found. Try a different search?', 'OneCommunity' ); ?></h2>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_blog_search' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->


<div id="sidebar">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-blog')) : ?><?php endif; ?>
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-ad-blog')) : ?><?php endif; ?>
</div><!--sidebar ends-->

<?php get_footer(); ?>
