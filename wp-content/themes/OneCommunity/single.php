<?php get_header(); ?>

		<?php do_action( 'bp_after_header' ) ?>
		<?php do_action( 'bp_before_container' ) ?>

<div id="content">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="blog-post">

<div class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Fixed link <?php the_title_attribute(); ?>"><?php the_title(); ?></a>

	<div class="clear"></div>

	<div class="blog-bottom">
		<div class="blog-bottom-category"><?php the_category(', ') ?></div><div class="blog-bottom-spacer"></div>
		<div class="blog-bottom-author"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a></div><div class="blog-bottom-spacer"></div>
		<div class="blog-bottom-date"><?php the_date() ?></div><div class="blog-bottom-spacer"></div>
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

<div class="text">
				<div class="entry">

<?php
$subtitle = get_post_meta ($post->ID, 'subtitle', $single = true);
if($subtitle !== '') {
echo '<div class="subtitle">';
echo $subtitle;
echo '</div>';
}
?>
					<?php the_content( __('Read more','OneCommunity') ); ?>

					<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'OneCommunity' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
				</div>

<div class="blog-bottom-tags <?php if ( has_tag() ) { echo "blog-bottom-tags-has"; } else { echo "blog-bottom-tags-empty"; } ?>"><?php the_tags('', ', ', '  '); ?></div>
<div class="clear"></div>
<br />

<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_pinterest_pinit"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-504612076f0dbf6b"></script>
<!-- AddThis Button END -->


    <?php $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
    $tag_ids = array();
    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
    $args=array(
    'tag__in' => $tag_ids,
    'post__not_in' => array($post->ID),
    'posts_per_page'=>5, // Number of related posts that will be shown.
    'ignore_sticky_posts'=>1
    );
    $my_query = new wp_query( $args );
    if( $my_query->have_posts() ) {

    echo '<div id="relatedposts"><div id="relatedposts-title">' .  __( 'Related Posts', 'OneCommunity' ) . ':</div>';

    while( $my_query->have_posts() ) {
    $my_query->the_post(); ?>

    <a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a><br /><br />
    <?php }
    echo '</div>';
    }
    }
    $post = $orig_post;
    wp_reset_query(); ?>


	</div><!--text-->

	</div><!--blog-post-->

	<div class="clear"> </div>



			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'OneCommunity' ); ?></p>

			<?php endif; ?>

<?php comments_template(); ?>

</div><!-- #content -->

<div id="sidebar">
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-single')) : ?><?php endif; ?>
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-ad-single')) : ?><?php endif; ?>
</div><!--sidebar ends-->

<?php get_footer(); ?>