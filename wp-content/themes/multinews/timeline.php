<?php
/*
Template Name: Timeline Page
*/
?>

<?php get_header(); 
global $post;
$tlcat = get_post_meta($post->ID, 'mom_timeline_cat', true);
$tlorder = get_post_meta($post->ID, 'mom_timeline_orderby', true);
$tlcounter = get_post_meta($post->ID, 'mom_timeline_posts', true);
$tlex = get_post_meta($post->ID, 'mom_timeline_ex', true);
if ($tlcounter == '') {
	$tlcounter = 10;
}
?>
<div class="main-container author-page timeline"><!--container-->
	<div class="full-main-content" role="main">
		<div class="site-content page-wrap">
			<?php mom_posts_timeline($tlcounter, '', $tlex, $tlcat, $tlorder); ?>
		</div>
	</div>
</div>
</div><!-- wrap -->
<?php get_footer(); ?>
