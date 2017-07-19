<?php
/**
 * The sidebar containing the secondary widget area for the left column, used in the three column layout.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?>
	
<!-- left WordPress sidebar -->
<div id="secondary" class="widget-area left-widget-area" role="complementary">
	<?php if ( is_active_sidebar('sidebar-left') ) : ?>
		<?php dynamic_sidebar( 'sidebar-left' ); ?>
	<?php else: ?>
		<aside class="widget widget-error">
			<p>Please <?php if ( !is_user_logged_in() ) : ?><a href="<?php echo wp_login_url(); ?>">log in</a> and<?php endif; ?> add widgets to the "Left Sidebar" widget area.</p>
			<?php if ( is_user_logged_in() ) : ?><p><a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php">Add Widgets &raquo;</a></p><?php endif; ?>
		</aside>
	<?php endif; ?>
</div><!-- #secondary -->
		
