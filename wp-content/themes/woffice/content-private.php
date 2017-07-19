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
				<i class="fa fa-lock"></i>
			</div>
			<div class="heading">
				<h2>
					<?php // THE TITLE
					_e( 'Private content here', 'woffice' );?>
				</h2>
			</div>
			<p class="blog-sum-up center">
				<?php _e( 'Apologies, you do not have the right to access this page.', 'woffice' ); ?>
			
				<?php if(is_user_logged_in() == false){
					echo '<br>';
					_e('You must sign in to view the page content.','woffice'); 
				} ?>
			</p>
			
			<div class="blog-button center">
  				<a href="<?php echo get_home_url(); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> <?php _e('Back on the home page','woffice'); ?></a>
  				<?php if(is_user_logged_in() == false){ ?>
  					<a href="<?php echo wp_login_url(); ?>" class="btn btn-default"><i class="fa fa-sign-in"></i> <?php _e('Sign in','woffice'); ?></a>
				<?php } ?>
  			</div>
		</div>
	</article>