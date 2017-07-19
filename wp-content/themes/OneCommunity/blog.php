<?php
/*
Template Name: Blog
*/
?>

<?php get_header(); ?>


<div id="content">


<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=4'.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

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
		the_post_thumbnail_caption(); ?>
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
<div class="clear"></div>

</div><!--text-->

<div class="clear"></div>
</div><!--blog-post-->


<?php endwhile; // end of loop
 ?>

<div style="display:inline">
<div class="older-entries"><?php next_posts_link( __( '&larr; Previous Entries', 'OneCommunity' ) ); ?></div>
<div class="newer-entries"><?php previous_posts_link( __( 'Next Entries &rarr;', 'OneCommunity' ) ); ?></div>
</div>

<?php $wp_query = null; $wp_query = $temp;?>

</div>


<div id="sidebar">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-blog')) : ?><?php endif; ?>
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-ad-blog')) : ?><?php endif; ?>
</div><!--sidebar ends-->

<?php get_footer(); ?>