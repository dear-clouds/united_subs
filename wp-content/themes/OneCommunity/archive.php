<?php get_header(); ?>

	<div id="content">

		<?php do_action( 'bp_before_archive' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php bp_dtheme_content_nav( 'nav-above' ); ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ); ?>

<div class="blog-post">

<div class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Fixed link <?php the_title_attribute(); ?>"><?php the_title(); ?></a>

	<div class="clear"></div>

	<div class="blog-bottom">
		<div class="blog-bottom-category"><?php the_category(', ') ?></div><div class="blog-bottom-spacer"></div>
		<div class="blog-bottom-author"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a></div><div class="blog-bottom-spacer"></div>
		<div class="blog-bottom-date"><?php the_time('F j, Y') ?></div><div class="blog-bottom-spacer"></div>
		<a class="blog-bottom-comments" href="<?php the_permalink() ?>#comments"><?php comments_number('0', '1', '%'); ?></a><div class="blog-bottom-spacer"></div>
	</div>

	<div class="clear"></div>
</div><!--post-title-->

<?php
if ( has_post_thumbnail() ) { ?>
	<div class="thumbnail">
		<?php the_post_thumbnail('full');
		the_post_thumbnail_caption();
		?>
	</div>
<?php } else {
	// no thumbnail
}
?>
<div class="clear"> </div>

<div class="text">

<?php
$subtitle = get_post_meta ($post->ID, 'subtitle', $single = true);
if($subtitle !== '') {
echo '<div class="subtitle">';
echo $subtitle;
echo '</div>';
}
?>

<?php
global $more;
$more = 0;
the_content( __('Read more','OneCommunity') );
?>

</div><!--text-->

<div class="clear"></div>
</div><!--blog-post-->

		<?php endwhile; ?>

		<?php bp_dtheme_content_nav( 'nav-below' ); ?>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found', 'OneCommunity'); ?></h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

</div><!-- #content -->


<div id="sidebar">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-blog')) : ?><?php endif; ?>
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-ad-blog')) : ?><?php endif; ?>
</div><!--sidebar ends-->

<?php get_footer(); ?>
