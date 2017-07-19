<?php
/**
 * The template used for displaying content not found
 */
?>
<?php 
// CUSTOM CLASSES ADDED BY THE THEME
$post_classes = array('box','content');
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>

		<div class="intern-padding">
			<div class="special-404 center">
				<i class="fa fa-meh-o"></i>
			</div>
			<div class="heading">
				<h2>
					<?php // THE TITLE
					_e( 'Nothing Found', 'woffice' );?>
				</h2>
			</div>
		</div>
		<div class="intern-padding">
			<p class="blog-sum-up center">
				<?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'woffice' ); ?>
			</p>

			<div class="blog-button center">
  				<a href="<?php echo get_home_url(); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> <?php _e('Back on the home page','woffice'); ?></a>
  			</div>
		</div>
	</article>