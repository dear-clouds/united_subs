<?php
/**
 * The sidebar containing the widget area for WordPress blog posts and pages.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>
	
<!-- Homepage Right Sidebar -->
<div id="secondary" class="widget-area" role="complementary">
	<?php if ( is_active_sidebar('home-right') ) : ?>
		<?php dynamic_sidebar( 'home-right' ); ?>
	<?php endif; ?>
</div><!-- #secondary -->
